<?php

namespace App\Http\Controllers;

use App\Models\myTeamModel;
use App\Models\userPlansModel;
use App\Models\usersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use function App\Helpers\getLevelTeam;
use function App\Helpers\is_mobile;
use function App\Helpers\coinPrice;
use function App\Helpers\getUserStakeAmount;
use function App\Helpers\unstakedAmount;

use App\Services\UplineBonusService;

use App\Models\earningLogsModel;

use App\Services\RankRewardService;

use App\Services\PoolBonusService;

use App\Services\ClubBonusService;

use App\Services\CitizenAllianceService;

class teamController extends Controller
{
    public function my_team(Request $request)
    {
        $type = $request->input('type');
        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }

        $wallet_address = $request->input('wallet_address');
        // $user_id = $request->session()->get('user_id');
        $perPage = 50; // You can make this dynamic from request

        if(!empty($wallet_address))
        {
            $teamMembers = myTeamModel::where('my_team.user_id', $user_id)
                ->join('users', 'my_team.team_id', '=', 'users.id')
                ->select('users.*', 'my_team.id as team_relation_id')
                ->where(function ($query) use ($wallet_address) {
                    $query->where('users.wallet_address', $wallet_address)
                          ->orWhere('users.refferal_code', $wallet_address);
                })
                ->orderByDesc('my_team.id')
                ->paginate($perPage);

            $res['wallet_address'] = $wallet_address;

        }
        else
        {
            $teamMembers = myTeamModel::where('my_team.user_id', $user_id)
                ->join('users', 'my_team.team_id', '=', 'users.id')
                ->select('users.*', 'my_team.id as team_relation_id')
                ->where('daily_roi', '>', '0')
                ->orderByDesc('my_team.id')
                ->paginate($perPage);
        }

        foreach ($teamMembers as $member) {
            $userId = $member->id;

            $packages = userPlansModel::where('user_id', $userId)
                ->whereRaw('roi > 0 and isSynced != 2')
                ->get();

            $packageDetails = [];
            $unstakedAmount = 0;

            $currentPackage = 0;
            $matchingDistributed = 0;
            $totalPackage = 0;
            $allPackages = [];
            $currentPackageDate = '-';
            $otherPackageLeft = 0;

            foreach ($packages as $package) {
                if ($package->status == 1) {
                    $currentPackage = $package->amount;
                    $matchingDistributed = $package->isSynced;
                    $currentPackageDate = $package->created_on;
                } else {
                    $otherPackageLeft += $package->amount;
                }
                $totalPackage += ($package->amount);
                $allPackages[] = $package->amount;

                $unstakedAmount += unstakedAmount($userId, $package->contract_stakeid);
            }

            $member->matchingDistributed = $matchingDistributed;
            $member->currentPackage = $currentPackage;
            $member->otherPackageLeft = $otherPackageLeft;
            $member->otherPackageRight = 0; // No logic provided
            $member->currentPackageDate = $currentPackageDate;
            $member->totalPackage = ($totalPackage - $unstakedAmount) < 0 ? 0 : ($totalPackage - $unstakedAmount);
            $member->allPackages = implode(',', $allPackages);
        }

        $user = usersModel::find($user_id);
        $res['coinPrice'] = coinPrice();
        $res['status_code'] = 1;
        $res['message'] = "My Team";
        $res['data'] = $teamMembers;
        $res['user'] = $user;

        return is_mobile($type, "", $res, "view");
    }

    public function my_directs(Request $request)
    {
        $type     = $request->input('type');
        // $user_id  = $request->session()->get('user_id');
        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }
        $coinPrice = coinPrice();

        // Cache key + TTL
        $cacheKey   = "my_directs:{$user_id}";
        $cacheTtl   = now()->addMinutes(60);

        // Optional: allow manual bust with ?refresh=1
        if ($request->boolean('refresh')) {
            Cache::forget($cacheKey);
        }

        // Cache::forget($cacheKey);

        // Build (or fetch) cached payload for this user_id
        $res = Cache::remember($cacheKey, $cacheTtl, function () use ($user_id, $coinPrice) {

            $data = usersModel::where('sponser_id', $user_id)
                ->orderBy('id', 'desc')
                ->get()
                ->toArray();

            foreach ($data as $key => $value) {
                $totalPackage        = 0;
                $currentPackage      = 0;
                $allPackages         = '';
                $currentPackageDate  = '-';

                // keep your existing helpers/logic
                $unstake1 = unstakedAmount($value['id'], 1);
                $unstake2 = unstakedAmount($value['id'], 2);
                $unstake3 = unstakedAmount($value['id'], 3);

                $package = userPlansModel::where('user_id', $value['id'])
                    ->whereRaw('roi > 0 and isSynced != 2')
                    ->get()
                    ->toArray();

                foreach ($package as $k => $v) {
                    if ($v['status'] == 1) {
                        $currentPackage     = $v['amount'];
                        $currentPackageDate = $v['created_on'];
                    } else {
                        $allPackages .= $v['amount'] . ",";
                    }
                    $totalPackage += $v['amount'];
                }

                $data[$key]['totalPackage']       = getUserStakeAmount($value['id']);
                $data[$key]['currentPackage']     = $currentPackage;
                $data[$key]['currentPackageDate'] = $currentPackageDate;
                $data[$key]['allPackages']        = rtrim($allPackages, ',');
            }

            // $user = usersModel::where('id', $user_id)->first()->toArray();
            $user = usersModel::where('id', $user_id)->first();

            if ($user) 
            {
                $user = $user->toArray();
            

                // (your existing “upline bonus” scan kept intact; not added to response in original)
                $uplineBonusUsers = [];
                $users = usersModel::where('id', $user_id)
                    ->whereRaw("active_direct >= 8 and direct_business >= " . (8000 / $coinPrice))
                    ->get()->toArray();

                foreach ($users as $key => $value) {
                    $getActiveDirects = usersModel::selectRaw("IFNULL(SUM(user_plans.amount),0) as db, users.id, users.refferal_code")
                        ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                        ->where('sponser_id', $value['id'])
                        ->groupBy('users.id')
                        ->get()
                        ->toArray();

                    $criteriaMatch = 0;

                    foreach ($getActiveDirects as $gadk => $gadv) {
                        $stakeAmount = getUserStakeAmount($gadv['id']);
                        if (($stakeAmount * $coinPrice) >= 1000) {
                            $criteriaMatch++;
                        }
                    }

                    if ($criteriaMatch >= 8) {
                        $checkInvestment = userPlansModel::selectRaw("SUM(amount) as investment")
                            ->where('user_id', $value['id'])
                            ->get()->toArray();

                        $stakeAmount = getUserStakeAmount($value['id']);
                        if (($stakeAmount * $coinPrice) >= 3000) {
                            $uplineBonusUsers[$value['sponser_id']][] = $value['id'];
                        }
                    }
                }

                // Final payload (same shape as your original)
                return [
                    'coinPrice'    => $coinPrice,
                    'status_code' => 1,
                    'message'     => 'My Team',
                    'data'        => $data,
                    'user'        => $user,
                    // 'uplineBonusUsers' => $uplineBonusUsers, // uncomment if you want it in response
                ];
            }
            else
            {
                return [
                    'coinPrice'    => 0,
                    'status_code' => 1,
                    'message'     => 'No Data Found',
                    'data'        => [],
                    'user'        => [],
                    // 'uplineBonusUsers' => $uplineBonusUsers, // uncomment if you want it in response
                ];
            }
        });

        // Render using cached payload
        return is_mobile($type, "", $res, "view");
    }

    public function genealogy_level_team(Request $request)
    {
        $type = $request->input('type');

        if ($type == "API") {
            $refferal_code = $request->input('refferal_code');
            $getUserId = usersModel::where(['refferal_code' => $refferal_code])->get()->toArray();
            $user_id = $getUserId?$getUserId['0']['id']:0;
        } else {
            $user_id = $request->session()->get('user_id');
        }

        $data = getLevelTeam($user_id);

        foreach ($data as $key => $value) {
            $dataL2 = getLevelTeam($value['id']);

            if (count($dataL2) > 0) {
                $data[$key][$value['refferal_code']] = $dataL2;
            }
        }
        $res['coinPrice'] = coinPrice();

        $res['status_code'] = 1;
        $res['message'] = "Fetched Successfully.";
        $res['data'] = $data;

        return is_mobile($type, "", $res, "view");
    }

    // Shikhar create to check rank rewards
    public function checkRankRewardBonus($userId, RankRewardService $rankrewardservice)
    {

        $user = usersModel::find($userId);

        $rankMatrix = [
            1  => ['rank' => 'D1',  'team_business' => 60000,      'strong' => 30000,      'weak' => 30000,       'directs' => 5,  'onetime' => 1200,     'daily' => 15,     'terms' => 30],
            2  => ['rank' => 'D2',  'team_business' => 200000,     'strong' => 100000,     'weak' => 100000,      'directs' => 6,  'onetime' => 4000,     'daily' => 50,     'terms' => 60],
            3  => ['rank' => 'D3',  'team_business' => 400000,     'strong' => 200000,     'weak' => 200000,      'directs' => 7,  'onetime' => 8000,     'daily' => 100,    'terms' => 60],
            4  => ['rank' => 'D4',  'team_business' => 700000,     'strong' => 350000,     'weak' => 350000,      'directs' => 8,  'onetime' => 14000,    'daily' => 175,    'terms' => 90],
            5  => ['rank' => 'D5',  'team_business' => 1400000,    'strong' => 700000,     'weak' => 700000,      'directs' => 9,  'onetime' => 28000,    'daily' => 350,    'terms' => 90],
            6  => ['rank' => 'D6',  'team_business' => 3000000,    'strong' => 1500000,    'weak' => 1500000,     'directs' => 10, 'onetime' => 60000,    'daily' => 750,    'terms' => 120],
            7  => ['rank' => 'D7',  'team_business' => 6000000,    'strong' => 3000000,    'weak' => 3000000,     'directs' => 11, 'onetime' => 120000,   'daily' => 1500,   'terms' => 120],
            8  => ['rank' => 'D8',  'team_business' => 12000000,   'strong' => 6000000,    'weak' => 6000000,     'directs' => 12, 'onetime' => 240000,   'daily' => 3000,   'terms' => 150],
            9  => ['rank' => 'D9',  'team_business' => 25000000,   'strong' => 12500000,   'weak' => 12500000,    'directs' => 13, 'onetime' => 500000,   'daily' => 6250,   'terms' => 150],
            10 => ['rank' => 'D10', 'team_business' => 50000000,   'strong' => 25000000,   'weak' => 25000000,    'directs' => 14, 'onetime' => 1000000,  'daily' => 12500,  'terms' => 180],
            11 => ['rank' => 'D11', 'team_business' => 100000000,  'strong' => 50000000,   'weak' => 50000000,    'directs' => 15, 'onetime' => 2000000,  'daily' => 25000,  'terms' => 180],
        ];
        
        $firststakedate = $rankrewardservice->getFirstStakeDate($userId, 30); // userId = 1074, term = 30 days
        // dd("firststakedate:",$firststakedate); //2025-06-28

        $stake = getUserStakeAmount($userId);
        // dd($stake); // 4172.2717812462

        $activeDirects = $rankrewardservice->getActiveDirects($userId, 1);
        // dd($activeDirects);

        $teamBusiness = $rankrewardservice->getTeamBusiness($userId, 30);
        // dd($teamBusiness);

        $assignRank = $rankrewardservice->assignRank($user, $rankMatrix[1]);
        dd($assignRank);

    }


    // Shikhar create to check club bonus
    public function checkClubBonus(Request $request, ClubBonusService $clubBonusService)
    {
        $month = $request->input('month', now()->format('2025-6'));
        
        $results = $clubBonusService->calculateClubBonus($month);

        return response()->json([
            'month'   => $month,
            'coinPrice'=> 0,
            'results' => $results,
        ]);
    }

    public function checkCityzenAllianceBonus(Request $request, CitizenAllianceService $citizenAllianceService)
    {   
        $check_results = $citizenAllianceService->checkCitizenAllianceReward();

        dd($check_results);
        
        // $bonus_results = $citizenAllianceService->citizenAllianceRewardBonus();

        // dd($bonus_results);

        // return response()->json([
        //     'month'   => $month,
        //     'coinPrice'=> 0,
        //     'results' => $results,
        // ]);
    }
}
