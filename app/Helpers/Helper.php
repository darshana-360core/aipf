<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Redirect;
use App\Models\myTeamModel;
use App\Models\userPlansModel;
use App\Models\usersModel;
use App\Models\earningLogsModel;
use App\Models\withdrawModel;
use App\Models\settingModel;

use Carbon\Carbon;

use kornrunner\Keccak;
use Elliptic\EC;
use Web3p\Util\Util;

if (!function_exists('is_mobile')) {
    function is_mobile($type, $url = null, $data = null, $redirect_type = "redirect")
    {
        if ($type == "API") {
            return json_encode($data);
        } else {
            if ($redirect_type == 'redirect') {
                //                return redirect($url)->with(['data' => $data]);
                return redirect()->route($url)->with(['data' => $data]);
                //                return redirect()->route( 'clients.show' )->with( [ 'id' => $id ] );
            } else if ($redirect_type == 'view') {
                return view($url, ['data' => $data]);
            }
        }
    }
}

if (!function_exists('checkReferralCode')) {
    function checkReferralCode($refferal_code)
    {
        $checkRefCode = usersModel::where(['refferal_code' => $refferal_code])->get()->toArray();

        if (count($checkRefCode) == 0) {
            return 1;
        } else {
            return 0;
        }
    }
}

if (!function_exists('updateReverseSize')) {
    function updateReverseSize($user_id, $og_user_id)
    {
        $data = usersModel::where(['id' => $user_id])->get()->toArray();
        $ogdata = usersModel::where(['id' => $og_user_id])->get()->toArray();

        if (count($data) > 0) {
            if ($data['0']['sponser_id'] > 0) {
                $myTeam = array();
                $myTeam['user_id'] = $data['0']['sponser_id'];
                $myTeam['team_id'] = $og_user_id;
                $myTeam['sponser_id'] = $ogdata['0']['sponser_id'];

                myTeamModel::insert($myTeam);

                DB::statement("UPDATE users set my_team = (my_team + 1) where id = '" . $data['0']['sponser_id'] . "'");

                updateReverseSize($data['0']['sponser_id'], $og_user_id);
            }
        }
    }
}

if (!function_exists('reverseBusiness')) {
    function reverseBusiness($user_id, $amount)
    {
        $data = usersModel::where(['id' => $user_id])->get()->toArray();

        if(count($data) > 0)
        {
            if($data['0']['sponser_id'] > 0)
            {
                // DB::statement("UPDATE users set my_business = (my_business - ".$amount.") where id = '".$data['0']['sponser_id']."'");
                DB::statement("UPDATE users set my_business = GREATEST(my_business - ".$amount.", 0), unstake_business = GREATEST(unstake_business - ".$amount.", 0) where id = '".$data['0']['sponser_id']."'");

                reverseBusiness($data['0']['sponser_id'], $amount);
            }
        }
    }
}

if (!function_exists('getBalance')) {
    function getBalance($user_id)
    {
        $investments = usersModel::selectRaw("(direct_income + roi_income + level_income + royalty + rank_bonus + club_bonus) as balance")->where(['id' => $user_id])->get()->toArray();

        $available_withdraw_balance = 0;
        $withdraw_balance = 0;

        foreach ($investments as $key => $value) {
            $available_withdraw_balance += $value['balance'];
        }

        $withdraw = withdrawModel::where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'USDT'])->get()->toArray();

        foreach ($withdraw as $key => $value) {
            $withdraw_balance += $value['amount'];
        }

        return ($available_withdraw_balance - $withdraw_balance);
    }
}

if (!function_exists('getLevelTeam')) {
    function getLevelTeam($user_id)
    {
        $users = usersModel::where(['sponser_id' => $user_id])->get()->toArray();

        foreach ($users as $key => $value) {
            $currentPackage = 0;
            $matchingDistributed = 0;
            $allPackages = '';
            $currentPackageDate = '-';
            $package = userPlansModel::where(['user_id' => $value['id']])->whereRaw('roi > 0 and isSynced != 2')->get()->toArray();
            $otherPackageLeft = 0;
            $otherPackageRight = 0;
            $totalInvestment = 0;

            $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
            ->where('user_id', '=', $value['id'])
            ->where('withdraw_type', '=', 'UNSTAKE')
            ->get()
            ->toArray();

            foreach ($package as $k => $v) {
                $totalInvestment +=  $v['amount']; //($v['amount'] + $v['compound_amount']);

                if ($v['status'] == 1) {
                    $currentPackage = $v['amount'];
                    $matchingDistributed = $v['isSynced'];
                    $currentPackageDate = $v['created_on'];
                } else {
                    $allPackages .= $v['amount'] . ",";

                    $otherPackageLeft += $v['amount'];
                }
            }

            $users[$key]['matchingDistributed'] = $matchingDistributed;
            $users[$key]['currentPackage'] = $currentPackage;
            $users[$key]['otherPackageLeft'] = $otherPackageLeft;
            $users[$key]['otherPackageRight'] = $otherPackageRight;
            $users[$key]['currentPackageDate'] = $currentPackageDate;
            $users[$key]['totalInvestment'] = ($totalInvestment - $claimedRewards['0']['amount']);
            $users[$key]['allPackages'] = rtrim($allPackages, ",");

            $users[$key]['team_investment'] = $value['my_business']; //$finalTeamActiveAmount;
            $users[$key]['direct_investment'] = $value['direct_business']; //$finalDirectActiveAmount;
            $users[$key]['team_active'] = $value['active_team']; //count($my_team_active);
            $users[$key]['direct_active'] = $value['active_direct'];
        }

        return $users;
    }
}

if (!function_exists('updateReverseBusiness')) {
    function updateReverseBusiness($user_id, $amount)
    {
        $data = usersModel::where(['id' => $user_id])->get()->toArray();

        if (count($data) > 0) {
            if ($data['0']['sponser_id'] > 0) {
                DB::statement("UPDATE users set my_business = (my_business + " . $amount . "), my_daily_business = GREATEST(my_daily_business + ".$amount.", 0) where id = '" . $data['0']['sponser_id'] . "'");
                updateReverseBusiness($data['0']['sponser_id'], $amount);
            }
        }
    }
}

if (!function_exists('updateActiveTeam')) {
    function updateActiveTeam($user_id)
    {
        $data = myTeamModel::where(['team_id' => $user_id])->get()->toArray();

        foreach ($data as $key => $value) {
            usersModel::where('id', $value['user_id'])->update(['active_team' => DB::raw('active_team + 1')]);
        }
    }
}


if (!function_exists('getRefferer')) {
    function getRefferer($user_id)
    {
        // Step 1: Get the sponsor ID for the user
        $user = usersModel::select('sponser_id')->where('id', $user_id)->first();

        // Step 2: If no user found or sponser_id is null or 0, return 0
        if (!$user || !$user->sponser_id) {
            return 0;
        }

        // Step 3: Get the sponsor's level
        $sponser = usersModel::select('level')->where('id', $user->sponser_id)->first();

        // Step 4: Return sponsor ID and level
        return [
            'sponser_id' => $user->sponser_id,
            'level' => $sponser ? $sponser->level : 0
        ];

        // $checkRefferal = usersModel::selectRaw("IFNULL(sponser_id, 0) as sponser_id")->where(['id' => $user_id])->get()->toArray();

        // if (isset($checkRefferal['0']['sponser_id'])) {
        //     if ($checkRefferal['0']['sponser_id'] == 0) {
        //         return 0;
        //     } else {
        //         $getLevel = usersModel::select('level')->where(['id' => $checkRefferal['0']['sponser_id']])->get()->toArray();

        //         $returnArray = array();
        //         $returnArray['sponser_id'] = $checkRefferal['0']['sponser_id'];
        //         $returnArray['level'] = $getLevel['0']['level'];

        //         return $returnArray;
        //     }
        // } else {
        //     return 0;
        // }
    }
}

if (!function_exists('isUserActive')) {
    function isUserActive($user_id)
    {
        $userActive = userPlansModel::where(['user_id' => $user_id])->get()->toArray();

        if (count($userActive) > 0) {
            return 1;
        } else {
            return 0;
        }

        // return userPlansModel::where('user_id', $user_id)->exists() ? 1 : 0;
    }
}

if (!function_exists('findUplineRank')) {
    function findUplineRank($user_id, $findRank)
    {
        $getUser = usersModel::whereRaw("id = '" . $user_id . "' and rank_id > " . $findRank)->get()->toArray();

        $isEligible = 1;
        if (count($getUser) > 0) {
            $checkEligible = DB::table('user_ranks')->select('*', DB::raw('TIMESTAMPDIFF(HOUR, created_on, NOW()) AS hours_difference'))->where(['user_id' => $user_id, 'rank' => $getUser['0']['rank_id']])->get()->toArray();

            if ($checkEligible['0']->hours_difference > 23) {
                $isEligible = 1;
            } else {
                $isEligible = 0;
            }
        }


        if (count($getUser) > 0 && $isEligible == 1) {
            $data = array();
            $data['user_id'] = $user_id;
            $data['rank'] = $getUser['0']['rank'];
            $data['rank_id'] = $getUser['0']['rank_id'];

            return $data;
        } else {
            $getSponser = usersModel::where(['id' => $user_id])->get()->toArray();

            if (count($getSponser) > 0) {
                return findUplineRank($getSponser['0']['sponser_id'], $findRank);
            } else {
                $data = array();
                $data['user_id'] = $user_id;
                $data['rank'] = 0;
                $data['rank_id'] = 0;

                return $data;
            }
        }
    }
}

if (!function_exists('findRankBonusIncome')) {
    function findRankBonusIncome($lastRank, $newRank)
    {
        $data = DB::select("SELECT SUM(income) as income FROM `ranking` where id > " . $lastRank . " and id <= " . $newRank);

        return $data['0']->income;
    }
}


if (!function_exists('verifyRSVP')) {
    function verifyRSVP($signature)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://91.243.178.126:3152/verify-wallet-using-vrs',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $signature,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        // dd($response);
        curl_close($curl);

        return $responseData = json_decode($response, true);
    }
}

if (!function_exists('getUserMaxReturn')) {
    function getUserMaxReturn($user_id)
    {
        $investments = userPlansModel::where(['user_id' => $user_id])->get()->toArray();

        $return = 0;

        foreach ($investments as $key => $value) {
            $return += ($value['amount'] * 5);
        }

        return $return;
    }
}

if (!function_exists('getRoiMaxReturn')) {
    function getRoiMaxReturn($user_id)
    {
        $investments = userPlansModel::where(['user_id' => $user_id])->get()->toArray();

        $return = 0;

        foreach ($investments as $key => $value) {
            $return += ($value['amount'] * 2);
        }

        return $return;
    }
}

if (!function_exists('getIncome')) {
    function getIncome($user_id)
    {
        $users = usersModel::selectRaw("(direct_income + roi_income + level_income + royalty + rank_bonus + club_bonus) as balance")->where(['id' => $user_id])->get()->toArray();

        return $users['0']['balance'];
    }
}

if (!function_exists('getTeamRoi')) {
    function getTeamRoi($user_id)
    {
        return $totalDailyRoi = DB::table('my_team as m')->join('users as u', 'm.team_id', '=', 'u.id')->where('m.user_id', $user_id)->sum('u.daily_roi');
    }
}

if (!function_exists('coinPrice')) {
    function coinPrice()
    {
        $claimedRewards = settingModel::get()->toArray();
        return (isset($claimedRewards['0']['coin_price'])?$claimedRewards['0']['coin_price']:0);    
    }
}

if (!function_exists('coinPriceLive')) {
    function coinPriceLive()
    {
        $apiUrl = "https://aipf-api.vercel.app/aipf-price";
        $coinresponse = file_get_contents($apiUrl);
        $coindata = json_decode($coinresponse, true);
        $coin_price = $coindata['price'] ?? 0;
        return $coin_price;
    }
}

if (!function_exists('getTreasuryBalance')) {
    function getTreasuryBalance()
    {
        $claimedRewards = settingModel::get()->toArray();
        $treasuryBalance = $claimedRewards[0]['treasury_balance'] ?? 0;
        return $treasuryBalance;
    }
}

if (!function_exists('unstakedAmount')) {
    function unstakedAmount($user_id, $package_id)
    {
        $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
            ->where('user_id', '=', $user_id)
            ->where('package_id', '=', $package_id)
            ->where('withdraw_type', '=', "UNSTAKE")
            ->get()
            ->toArray();

        return $claimedRewards['0']['amount'];
    }
}

if (!function_exists('fetchJson')) {
    function fetchJson($url)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        ]);

        $response = curl_exec($ch);
        if ($response === false) {
            curl_close($ch);
            return null;
        }
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code < 200 || $code >= 300) {
            return null;
        }

        $json = json_decode($response, true);
        return (json_last_error() === JSON_ERROR_NONE) ? $json : null;
    }
}

if (!function_exists('getUserStakeAmount')) {
    function getUserStakeAmount($user_id)
    {
        $withdrawMeta = withdrawModel::selectRaw("amount, created_on")->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])->orderBy('id', 'asc')->get()->toArray();
        
        $activeStake = 0;

        $lastCreatedOn = 0;

        $extraAmountLeft = 0;
        $totalCompoundAmount = 0;
        
        foreach($withdrawMeta as $key => $value)
        {
            $tempPackages = userPlansModel::where(['user_id' => $user_id])->where('created_on', '<=', $value['created_on'])->where('created_on', '>=', $lastCreatedOn)->orderBy('id', 'asc')->get()->toArray();
            
            $totalPackageAmount = 0;

            foreach($tempPackages as $key => $valuePackage) {
                $totalPackageAmount += ($valuePackage['amount']);
                $activeStake += ($valuePackage['amount']);
            }

            $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")->where(['user_id' => $user_id])->where('created_on', '<=', $value['created_on'])->where('created_on', '>', $lastCreatedOn)->where('tag', '=', 'ROI')->get()->toArray();
            $totalCompoundAmount += ($tempEarnings['0']['amount']);

            if ($value['amount'] <= ($totalCompoundAmount)) {
                $totalCompoundAmount -= ($value['amount']);
            } else if ($value['amount'] > ($totalCompoundAmount)) {
                $activeStake -= ($value['amount'] - ($totalCompoundAmount));
                $totalCompoundAmount = 0;
            }
            
            $lastCreatedOn = $value['created_on'];
        }

        if (count($withdrawMeta) == 0) {
            $tempPackages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'asc')->get()->toArray();
            foreach($tempPackages as $key => $valuePackage) {
                $activeStake += ($valuePackage['amount']);
            }
        } else {
            $tempPackagesAfter = userPlansModel::where(['user_id' => $user_id])->where('created_on', '>', $lastCreatedOn)->orderBy('id', 'asc')->get()->toArray();
            foreach($tempPackagesAfter as $key => $valuePackage) {
                $activeStake += ($valuePackage['amount']);
            }
        }

        return $activeStake;
    }
}

// Shikhar created to use inside teamController::() for Pool bonus calculations
if (!function_exists('getUserStakedDuration')) {
    function getUserStakedDuration($user_id)
    {
        $lastCreatedOn = 0;

        // Fetch all unstake events
        $withdrawMeta = withdrawModel::selectRaw("amount, created_on")
            ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE', 'package_id' => 1])
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        // Case 1: No unstake → just take the earliest stake date
        if (count($withdrawMeta) == 0) {
            $firstStake = userPlansModel::where(['user_id' => $user_id, 'package_id' => 1])
                ->orderBy('created_on', 'asc')
                ->first();

            if (!$firstStake) {
                return 0; // no stake found
            }

            return Carbon::parse($firstStake->created_on)->diffInDays(Carbon::now());
        }

        // Case 2: User unstaked at least once
        foreach ($withdrawMeta as $value) {
            $lastCreatedOn = $value['created_on'];
        }

        // After last unstake → check the new stakes
        $stakeAfterUnstake = userPlansModel::where(['user_id' => $user_id, 'package_id' => 1])
            ->where('created_on', '>', $lastCreatedOn)
            ->orderBy('created_on', 'asc')
            ->first();

        if ($stakeAfterUnstake) {
            return Carbon::parse($stakeAfterUnstake->created_on)->diffInDays(Carbon::now());
        }

        return 0;
    }
}

// Shikhar created to use inside teamController::getUserStaked() for upline bonus calculations
if (!function_exists('getUserStakedAmount')) {
    function getUserStakedAmount($user_id)
    {
        $activeStake = 0;
        $totalCompoundAmount = 0;
        $lastCreatedOn = 0;

        $withdrawMeta = withdrawModel::selectRaw("amount, created_on") //, 'package_id' => 1
            ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        if (count($withdrawMeta) == 0) { //, 'package_id' => 1
            $tempPackages = userPlansModel::where(['user_id' => $user_id])
                ->orderBy('id', 'asc')
                ->get()
                ->toArray();
            foreach ($tempPackages as $valuePackage) {
                $activeStake += $valuePackage['amount'];
            }
        } else {
            foreach ($withdrawMeta as $value) { //, 'package_id' => 1
                $tempPackages = userPlansModel::where(['user_id' => $user_id])
                    ->where('created_on', '<=', $value['created_on'])
                    ->where('created_on', '>=', $lastCreatedOn)
                    ->orderBy('id', 'asc')
                    ->get()
                    ->toArray();

                $totalPackageAmount = 0;
                foreach ($tempPackages as $valuePackage) {
                    $totalPackageAmount += $valuePackage['amount'];
                    $activeStake += $valuePackage['amount'];
                }

                $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                    ->where(['user_id' => $user_id])
                    ->where('created_on', '<=', $value['created_on'])
                    ->where('created_on', '>', $lastCreatedOn)
                    ->where('tag', '=', 'ROI')
                    // ->where('refrence_id', 1)
                    ->get()
                    ->toArray();
                $totalCompoundAmount += $tempEarnings['0']['amount'];

                if ($value['amount'] <= $totalCompoundAmount) {
                    $totalCompoundAmount -= $value['amount'];
                } else if ($value['amount'] > $totalCompoundAmount) {
                    $activeStake -= ($value['amount'] - $totalCompoundAmount);
                    $totalCompoundAmount = 0;
                }

                $lastCreatedOn = $value['created_on'];
            }

            $tempPackagesAfter = userPlansModel::where(['user_id' => $user_id]) //, 'package_id' => 1
                ->where('created_on', '>', $lastCreatedOn)
                ->orderBy('id', 'asc')
                ->get()
                ->toArray();
            foreach ($tempPackagesAfter as $valuePackage) {
                $activeStake += $valuePackage['amount'];
            }
        }

        return $activeStake;
    }
}

if (!function_exists('getUserStakedAmountInDays')) {
    function getUserStakedAmountInDays($user_id, $days = 0)
    {
        $activeStake = 0;
        $totalCompoundAmount = 0;
        $lastCreatedOn = 0;

        // Find the first stake date
        $firstStake = userPlansModel::where(['user_id' => $user_id, 'package_id' => 1])
            ->orderBy('created_on', 'asc')
            ->first();

        if (!$firstStake) {
            return 0; // no stake found
        }

        // Cutoff date based on "first stake + days"
        $cutoffDate = null;
        if ($days > 0) {
            $cutoffDate = Carbon::parse($firstStake->created_on)->addDays($days);
        }

        // Fetch unstake events (apply cutoff if given)
        $withdrawMeta = withdrawModel::selectRaw("amount, created_on")
            ->where([
                'user_id'       => $user_id,
                'status'        => 1,
                'withdraw_type' => 'UNSTAKE',
                'package_id'    => 1
            ])
            ->orderBy('id', 'asc');

        if ($cutoffDate) {
            $withdrawMeta->where('created_on', '<=', $cutoffDate);
        }

        $withdrawMeta = $withdrawMeta->get()->toArray();

        if (count($withdrawMeta) == 0) {
            // All stakes up to cutoff
            $tempPackages = userPlansModel::where(['user_id' => $user_id, 'package_id' => 1])
                ->orderBy('id', 'asc');

            if ($cutoffDate) {
                $tempPackages->where('created_on', '<=', $cutoffDate);
            }

            foreach ($tempPackages->get() as $valuePackage) {
                $activeStake += $valuePackage->amount;
            }
        } else {
            foreach ($withdrawMeta as $value) {
                $tempPackages = userPlansModel::where(['user_id' => $user_id, 'package_id' => 1])
                    ->where('created_on', '<=', $value['created_on'])
                    ->where('created_on', '>=', $lastCreatedOn);

                if ($cutoffDate) {
                    $tempPackages->where('created_on', '<=', $cutoffDate);
                }

                $tempPackages = $tempPackages->orderBy('id', 'asc')->get();

                $totalPackageAmount = 0;
                foreach ($tempPackages as $valuePackage) {
                    $totalPackageAmount += $valuePackage->amount;
                    $activeStake += $valuePackage->amount;
                }

                $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                    ->where(['user_id' => $user_id])
                    ->where('created_on', '<=', $value['created_on'])
                    ->where('created_on', '>', $lastCreatedOn)
                    ->where('tag', '=', 'ROI')
                    ->where('refrence_id', 1);

                if ($cutoffDate) {
                    $tempEarnings->where('created_on', '<=', $cutoffDate);
                }

                $tempEarnings = $tempEarnings->first();
                $totalCompoundAmount += $tempEarnings->amount ?? 0;

                if ($value['amount'] <= $totalCompoundAmount) {
                    $totalCompoundAmount -= $value['amount'];
                } else {
                    $activeStake -= ($value['amount'] - $totalCompoundAmount);
                    $totalCompoundAmount = 0;
                }

                $lastCreatedOn = $value['created_on'];
            }

            $tempPackagesAfter = userPlansModel::where(['user_id' => $user_id, 'package_id' => 1])
                ->where('created_on', '>', $lastCreatedOn);

            if ($cutoffDate) {
                $tempPackagesAfter->where('created_on', '<=', $cutoffDate);
            }

            foreach ($tempPackagesAfter->get() as $valuePackage) {
                $activeStake += $valuePackage->amount;
            }
        }

        return $activeStake;
    }
}

function getUserStakedAmountTVL($user_id, $asOfDate = null)
{
    $activeStake = 0;
    $totalCompoundAmount = 0;
    $lastCreatedOn = 0;

    if (!$asOfDate) {
        $asOfDate = now();
    }

    $withdrawMeta = withdrawModel::selectRaw("amount, created_on")
        ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE']) //, 'package_id' => 1
        ->where('created_on', '<=', $asOfDate)
        ->orderBy('id', 'asc')
        ->get()
        ->toArray();

    if (count($withdrawMeta) == 0) {
        $tempPackages = userPlansModel::where(['user_id' => $user_id]) //, 'package_id' => 1
            ->where('created_on', '<=', $asOfDate)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        foreach ($tempPackages as $valuePackage) {
            $activeStake += $valuePackage['amount'];
        }
    } else {
        foreach ($withdrawMeta as $value) {
            $tempPackages = userPlansModel::where(['user_id' => $user_id]) //, 'package_id' => 1
                ->where('created_on', '<=', $value['created_on'])
                ->where('created_on', '>=', $lastCreatedOn)
                ->orderBy('id', 'asc')
                ->get()
                ->toArray();

            foreach ($tempPackages as $valuePackage) {
                $activeStake += $valuePackage['amount'];
            }

            $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                ->where(['user_id' => $user_id])
                ->where('created_on', '<=', $value['created_on'])
                ->where('created_on', '>', $lastCreatedOn)
                ->where('tag', '=', 'ROI')
                ->where('refrence_id', 1)
                ->get()
                ->toArray();

            $totalCompoundAmount += $tempEarnings[0]['amount'];

            if ($value['amount'] <= $totalCompoundAmount) {
                $totalCompoundAmount -= $value['amount'];
            } else if ($value['amount'] > $totalCompoundAmount) {
                $activeStake -= ($value['amount'] - $totalCompoundAmount);
                $totalCompoundAmount = 0;
            }

            $lastCreatedOn = $value['created_on'];
        }

        $tempPackagesAfter = userPlansModel::where(['user_id' => $user_id]) //, 'package_id' => 1
            ->where('created_on', '>', $lastCreatedOn)
            ->where('created_on', '<=', $asOfDate)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        foreach ($tempPackagesAfter as $valuePackage) {
            $activeStake += $valuePackage['amount'];
        }
    }

    return $activeStake;
}

function web3Verify(string $message, string $signature): ?string
{
    if (!preg_match('/^0x[a-fA-F0-9]{130}$/', $signature)) return null;

    $prefix  = "\x19Ethereum Signed Message:\n" . strlen($message);
    $hashHex = Keccak::hash($prefix . $message, 256);
    $hashBin = hex2bin($hashHex);

    $sig = substr($signature, 2);
    $r = '0x' . substr($sig, 0, 64);
    $s = '0x' . substr($sig, 64, 64);
    $v = hexdec(substr($sig, 128, 2));
    if ($v < 27) $v += 27;
    $recId = $v - 27;

    $ec = new EC('secp256k1');
    $pubKey = $ec->recoverPubKey($hashBin, ['r' => $r, 's' => $s], $recId);
    $pubHex = $pubKey->encode('hex', false);
    $pubBody = hex2bin(substr($pubHex, 2));
    $addrHex = Keccak::hash($pubBody, 256);
    $address = '0x' . substr($addrHex, 24);

    return (new Util())->toChecksumAddress($address);
}


/*
 *  Count if a sponser has active direct users with amount >= $amount 
 *  amount >= 100
 */
if (!function_exists('activeDirect')) {
    function activeDirect($sponserid, $amount)
    {
        $activeDirects  =   usersModel::select(
                                                'users.id',
                                                DB::raw('SUM(user_plans.amount * user_plans.coin_price) as total_amount')
                                            )
                                            ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                                            ->where('users.sponser_id', $sponserid)
                                            ->groupBy('users.id')
                                            ->having('total_amount', '>=', $amount)
                                            ->get();
        // print_r($directs->toArray());                                    
        return $activeDirects->count();
    }
}

if (!function_exists('unstakedAmountContractStackeid')) {
    function unstakedAmountContractStackeid($user_id, $package_id, $contract_stakeid)
    {
        $unstakedAmount = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                                                ->where('user_id', '=', $user_id)
                                                ->where('package_id', '=', $package_id)
                                                ->where('contract_stakeid', '=', $contract_stakeid)
                                                ->where('withdraw_type', '=', "UNSTAKE")
                                                ->get()
                                                ->toArray();
        return $unstakedAmount['0']['amount'];
    }
}

if (!function_exists('claimRoiAmountContractStackeid')) {
    function claimRoiAmountContractStackeid($user_id, $package_id, $contract_stakeid)
    {
        $claimedRoi = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                                            ->where('user_id', '=', $user_id)
                                            ->where('package_id', '=', $package_id)
                                            ->where('contract_stakeid', '=', $contract_stakeid)
                                            ->where('withdraw_type', '=', "CLAIMROI")
                                            ->get()
                                            ->toArray();
        return $claimedRoi['0']['amount'];
    }
}
