<?php

namespace App\Http\Controllers;

use App\Models\levelRoiModel;
use App\Models\packageTransaction;
use App\Models\rankingModel;
use App\Models\userPlansModel;
use App\Models\usersModel;
use App\Models\earningLogsModel;
use App\Models\user_stablebond_details;
use App\Models\rewardBonusModel;
use App\Models\withdrawModel;
use App\Models\loginLogsModel;
use App\Models\myTeamModel;
use App\Models\suspiciousStake;
use App\Models\suspiciousBalance;
use App\Models\levelEarningLogsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function App\Helpers\is_mobile;
use function App\Helpers\getBalance;
use function App\Helpers\getIncome;
use function App\Helpers\getTeamRoi;
use function App\Helpers\coinPrice;
use function App\Helpers\getTreasuryBalance;
use function App\Helpers\verifyRSVP;
use function App\Helpers\fetchJson;
use function App\Helpers\getUserStakeAmount;
use function App\Helpers\getUserStakedAmount;
use function App\Helpers\activeDirect;
use function App\Helpers\isUserActive;
use function App\Helpers\coinPriceLive; 

use Illuminate\Support\Facades\Log;

// use App\Services\Days360PoolService;

class loginController extends Controller
{
    /*private $rankMatrix = [
                            ["id" => 1, "name" => "D1", "eligible" => 100, "direct_referral" => 2, "income" => 1200, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 2, "name" => "D2", "eligible" => 150, "direct_referral" => 3, "income" => 4000, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 3, "name" => "D3", "eligible" => 200, "direct_referral" => 4, "income" => 8000, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 4, "name" => "D4", "eligible" => 250, "direct_referral" => 5, "income" => 14000, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 5, "name" => "D5", "eligible" => 300, "direct_referral" => 6, "income" => 28000, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 6, "name" => "D6", "eligible" => 350, "direct_referral" => 7, "income" => 60000, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 7, "name" => "D7", "eligible" => 400, "direct_referral" => 8, "income" => 120000, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 8, "name" => "D8", "eligible" => 450, "direct_referral" => 9, "income" => 240000, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 9, "name" => "D9", "eligible" => 500, "direct_referral" => 10, "income" => 500000, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 10, "name" => "D10", "eligible" => 550, "direct_referral" => 11, "income" => 1000000, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 11, "name" => "D11", "eligible" => 600, "direct_referral" => 12, "income" => 2000000, "days" => 7, "created_on" => "2025-10-15 21:53:35"],
                        ];*/

    private $rankMatrix = [
                            ["id" => 1, "name" => "D1", "eligible" => 500, "direct_referral" => 5, "income" => 1200, "days" => 7, "strong_business"=>30000, "week_business"=>30000, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 2, "name" => "D2", "eligible" => 1100, "direct_referral" => 6, "income" => 4000, "days" => 7, "strong_business"=>100000, "week_business"=>100000, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 3, "name" => "D3", "eligible" => 1800, "direct_referral" => 7, "income" => 8000, "days" => 7, "strong_business"=>200000, "week_business"=>200000, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 4, "name" => "D4", "eligible" => 2600, "direct_referral" => 8, "income" => 14000, "days" => 7, "strong_business"=>350000, "week_business"=>350000, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 5, "name" => "D5", "eligible" => 3500, "direct_referral" => 9, "income" => 28000, "days" => 7, "strong_business"=>700000, "week_business"=>700000, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 6, "name" => "D6", "eligible" => 4500, "direct_referral" => 10, "income" => 60000, "days" => 7, "strong_business"=>1500000, "week_business"=>1500000, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 7, "name" => "D7", "eligible" => 5600, "direct_referral" => 11, "income" => 120000, "days" => 7, "strong_business"=>3000000, "week_business"=>3000000, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 8, "name" => "D8", "eligible" => 6800, "direct_referral" => 12, "income" => 240000, "days" => 7, "strong_business"=>6000000, "week_business"=>6000000, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 9, "name" => "D9", "eligible" => 8100, "direct_referral" => 13, "income" => 500000, "days" => 7, "strong_business"=>12500000, "week_business"=>12500000, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 10, "name" => "D10", "eligible" => 9500, "direct_referral" => 14, "income" => 1000000, "days" => 7, "strong_business"=>25000000, "week_business"=>25000000, "created_on" => "2025-10-15 21:53:35"],
                            ["id" => 11, "name" => "D11", "eligible" => 11000, "direct_referral" => 15, "income" => 2000000, "days" => 7, "strong_business"=>50000000, "week_business"=>50000000, "created_on" => "2025-10-15 21:53:35"],
                        ];

    /*private $teamBonusMatrix =  [
                                    ["id" => 1, "name" => "L1", "account_balance" => 100, "eligible" => 50, "type" => "volume", "count" => 0, "direct_referral" => 2, "income" => 5, "brokerage_income" => 10, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 2, "name" => "L2", "account_balance" => 200, "eligible" => 100, "type" => "volume", "count" => 0, "direct_referral" => 3, "income" => 10, "brokerage_income" => 20, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 3, "name" => "L3", "account_balance" => 300, "eligible" => 150, "type" => "volume", "count" => 0, "direct_referral" => 4, "income" => 15, "brokerage_income" => 30, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 4, "name" => "L4", "account_balance" => 400, "eligible" => 200, "type" => "volume", "count" => 0, "direct_referral" => 5, "income" => 20, "brokerage_income" => 40, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 5, "name" => "L5", "account_balance" => 500, "eligible" => 250, "type" => "volume", "count" => 0, "direct_referral" => 6, "income" => 25, "brokerage_income" => 50, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 6, "name" => "L6", "account_balance" => 600, "eligible" => 300, "type" => "volume", "count" => 0, "direct_referral" => 7, "income" => 30, "brokerage_income" => 60, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 7, "name" => "L7", "account_balance" => 700, "eligible" => 350, "type" => "volume", "count" => 0, "direct_referral" => 8, "income" => 35, "brokerage_income" => 70, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 8, "name" => "L8", "account_balance" => 800, "eligible" => 400, "type" => "volume", "count" => 0, "direct_referral" => 9, "income" => 40, "brokerage_income" => 80, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 9, "name" => "L9", "account_balance" => 900, "eligible" => 450, "type" => "volume", "count" => 0, "direct_referral" => 10, "income" => 45, "brokerage_income" => 90, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 10, "name" => "L10", "account_balance" => 1000, "eligible" => 9, "type" => "hold_level", "count" => 2, "direct_referral" => 11, "income" => 50, "brokerage_income" => 100, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 11, "name" => "L11", "account_balance" => 1100, "eligible" => 10, "type" => "hold_level", "count" => 2, "direct_referral" => 12, "income" => 55, "brokerage_income" => 110, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 12, "name" => "L12", "account_balance" => 1200, "eligible" => 11, "type" => "hold_level", "count" => 2, "direct_referral" => 13, "income" => 60, "brokerage_income" => 120, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 13, "name" => "L13", "account_balance" => 1300, "eligible" => 12, "type" => "hold_level", "count" => 2, "direct_referral" => 14, "income" => 65, "brokerage_income" => 130, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 14, "name" => "L14", "account_balance" => 1400, "eligible" => 13, "type" => "hold_level", "count" => 2, "direct_referral" => 15, "income" => 70, "brokerage_income" => 140, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 15, "name" => "L15", "account_balance" => 1500, "eligible" => 14, "type" => "hold_level", "count" => 2, "direct_referral" => 15, "income" => 75, "brokerage_income" => 150, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"]
                                ];
    */

    /*private $teamBonusMatrix =  [
                                    ["id" => 1, "name"=>"Spark", "account_balance" => 100, "eligible" => 5000, "type" => "volume", "count" => 0, "direct_referral" => 2, "income" => 5, "brokerage_income" => 10, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 2, "name"=>"Wave", "account_balance" => 500, "eligible" => 20000, "type" => "volume", "count" => 0, "direct_referral" => 3, "income" => 10, "brokerage_income" => 20, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 3, "name"=>"Surge", "account_balance" => 1000, "eligible" => 50000, "type" => "volume", "count" => 0, "direct_referral" => 4, "income" => 15, "brokerage_income" => 30, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 4, "name"=>"Drive", "account_balance" => 2000, "eligible" => 150000, "type" => "volume", "count" => 0, "direct_referral" => 5, "income" => 20, "brokerage_income" => 40, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 5, "name"=>"Vector", "account_balance" => 3000, "eligible" => 400000, "type" => "volume", "count" => 0, "direct_referral" => 6, "income" => 25, "brokerage_income" => 50, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 6, "name"=>"Pulse",  "account_balance" => 5000, "eligible" => 1000000, "type" => "volume", "count" => 0, "direct_referral" => 7, "income" => 30, "brokerage_income" => 60, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 7, "name"=>"Relay",  "account_balance" => 10000, "eligible" => 2500000, "type" => "volume", "count" => 0, "direct_referral" => 8, "income" => 35, "brokerage_income" => 70, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 8, "name"=>"Nexus",  "account_balance" => 12000, "eligible" => 6000000, "type" => "volume", "count" => 0, "direct_referral" => 9, "income" => 40, "brokerage_income" => 80, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 9, "name"=>"Titan",  "account_balance" => 15000, "eligible" => 15000000, "type" => "volume", "count" => 0, "direct_referral" => 10, "income" => 45, "brokerage_income" => 90, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 10, "name"=>"Prime", "account_balance" => 0, "eligible" => 15000000, "type" => "hold_level", "count" => 2, "direct_referral" => 11, "income" => 50, "brokerage_income" => 100, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 11, "name"=>"Supra", "account_balance" => 0, "eligible" => 15000000, "type" => "hold_level", "count" => 2, "direct_referral" => 12, "income" => 55, "brokerage_income" => 110, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 12, "name"=>"Zenith", "account_balance" => 0, "eligible" => 15000000, "type" => "hold_level", "count" => 2, "direct_referral" => 13, "income" => 60, "brokerage_income" => 120, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 13, "name"=>"Paragon", "account_balance" => 0, "eligible" => 15000000, "type" => "hold_level", "count" => 2, "direct_referral" => 14, "income" => 65, "brokerage_income" => 130, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 14, "name"=>"Quantum", "account_balance" => 0, "eligible" => 15000000, "type" => "hold_level", "count" => 2, "direct_referral" => 15, "income" => 70, "brokerage_income" => 140, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"],
                                    ["id" => 15, "name"=>"Singularity", "account_balance" => 0, "eligible" => 15000000, "type" => "hold_level", "count" => 2, "direct_referral" => 15, "income" => 75, "brokerage_income" => 150, "profit_sharing" => 0, "week" => 0, "created_on" => "2025-10-16 09:44:09"]
                                ];
    */


    private $teamBonusMatrix = null;

    public function __construct()
    {
        if ($this->teamBonusMatrix === null) {
            $this->teamBonusMatrix = $this->loadTeamBonusMatrixFromDB();
        }
    }

    private function loadTeamBonusMatrixFromDB()
    {
        $rows = DB::table('ranking')->orderBy('id')->get();
        $matrix = [];

        foreach ($rows as $row) {
            $holdlvlReq = json_decode($row->hold_level_requirement, true);

            $matrix[$row->id] = [
                'level'             => $row->id,
                'name'              => $row->name,
                'account_balance'   => $row->account_balance,
                'eligible'          => (int)$row->eligible,
                'type'              => $row->team_requirement_type,
                'count'             => $holdlvlReq['count'] ?? 0,
                'hold_level'        => $holdlvlReq['level'] ?? 0,
                'value'             => $holdlvlReq['value'] ?? 0,
                'direct_referral'   => (int)$row->direct_referral,
                'income'            => (float)$row->profit_sharing,
                'brokerage_income'  => (float)$row->profit_sharing_max,
                'profit_sharing'    => (float)$row->profit_sharing, 
                'week'              => 0,
            ];
        }

        return $matrix;
    }


    public function testTest()
    {
        echo "<h1>Welcome to AIPF</h1>";
        // $test = getUserStakeAmount(6);
        // echo $test;
        // $counts = oneActiveDirect(2);
        // echo "COunts=".$counts;
    }
    
    public function userValidate(Request $request)
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

        $users = usersModel::where(['wallet_address' => $wallet_address])->get()->toArray();

        if (count($users) == 0) {
            $res['status_code'] = 1;
            $res['message'] = "Wallet Address is eligeble for user.";
        } else {
            $res['status_code'] = 0;
            $res['message'] = "User already exist make login.";
        }

        return is_mobile($type, "", $res, "view");
    }

    public function login(Request $request)
    {
        $request->setLaravelSession(app('session')->driver());
        $type = $request->input('type');
        $wallet_address = $request->input('wallet_address');

        $data = usersModel::where(['wallet_address' => $wallet_address])->get()->toArray();
        // dd($data);
        $loginLogs = array();
        if (count($data) == 1) {
            $loginLogs['user_id'] = $data['0']['id'];
        } else {
            $loginLogs['user_id'] = "FAILED";
        }
        $loginLogs['login_type'] = "USER";
        $loginLogs['email'] = $wallet_address;
        $loginLogs['password'] = $wallet_address;
        $loginLogs['ip_address'] = $request->ip();
        $loginLogs['ip_address_2'] = $request->header('x-forwarded-for');
        $loginLogs['device'] = $request->header('User-Agent');
        $loginLogs['created_on'] = date('Y-m-d H:i:s');

        loginLogsModel::insert($loginLogs);

        if (!$request->session()->has('admin_user_id') && $type!='API') {
            $walletAddressScript = $request->input('walletAddressScript');
            $hashedMessageScript = $request->input('hashedMessageScript');
            $rsvScript = $request->input('rsvScript');
            $rsScript = $request->input('rsScript');
            $rScript = $request->input('rScript');

            $verifySignData = json_encode(array(
                "wallet" => $wallet_address,
                "message" => $hashedMessageScript,
                "v" => $rsvScript,
                "r" => $rScript,
                "s" => $rsScript,
            ));

            $v = verifyRSVP($verifySignData);

            // if (isset($v['result'])) {
            //     if ($v['result'] != true) {
            //         // dd($v['result']);
            //         $res['status_code'] = 0;
            //         $res['message'] = "Invalid Signature. Please try again later..";

            //         return is_mobile($type, "", $res);
            //     }
            // } else {
            //     $res['status_code'] = 0;
            //     $res['message'] = "Invalid Signature. Please try again later.";

            //     return is_mobile($type, "", $res);
            // }
        }

        if (count($data) == 1) {
            if ($data['0']['status'] == 1) {

                $request->session()->put('user_id', $data['0']['id']);
                $request->session()->put('email', $data['0']['email']);
                $request->session()->put('name', $data['0']['name']);
                $request->session()->put('refferal_code', $data['0']['refferal_code']);
                $request->session()->put('wallet_address', $data['0']['wallet_address']);
                $request->session()->put('rank', $data['0']['rank']);

                $res['status_code'] = 1;
                $res['message'] = "Login Successfully.";
                $res['user_id'] = $data['0']['id'];
                
                $apiBase = "http://91.243.178.30:3152/balance/" . $data['0']['wallet_address'];

                $json = fetchJson($apiBase);
                if (is_array($json)) {
                    // Safely read amounts as strings
                    $sa = (string)($json['stake']['amount']       ?? '0');
                    $la = (string)($json['lpBond']['amount']      ?? '0');
                    $ba = (string)($json['stableBond']['amount']  ?? '0');
                    $ab = (string)($json['earnings']['availableBalance']  ?? '0');

                    $ts = ($sa + $la + $ba);

                    $stakeAmount = (string) getUserStakeAmount($data['0']['id']);

                    if ((int)$stakeAmount != (int)$ts) {
                        $suspiciousData = array();
                        $suspiciousData['user_id'] = $data['0']['id'];
                        $suspiciousData['wallet_address'] = $data['0']['wallet_address'];
                        $suspiciousData['stake_amount'] = $stakeAmount;
                        $suspiciousData['contract_stake_amount'] = $ts;
                        $suspiciousData['difference'] = ($stakeAmount - $ts);

                        // Check if the record already exists by user_id
                        $existingRecord = suspiciousStake::where('user_id', $data['0']['id'])->first();

                        if ($existingRecord) {
                            // If record exists, update it
                            suspiciousStake::where('user_id', $data['0']['id'])->update($suspiciousData);
                        } else {
                            // Otherwise, insert a new record
                            suspiciousStake::insert($suspiciousData);
                        }
                    }

                    $withdraw = withdrawModel::where(['user_id' => $data['0']['id'],'withdraw_type'=>'USDT'])->orderBy('id', 'desc')->get()->toArray();

                    $withdraw_amount = 0;

                    $totalIncome = $data['0']['direct_income'] + $data['0']['level_income'] + $data['0']['rank_bonus'] + $data['0']['royalty'] + $data['0']['reward_bonus'] + $data['0']['club_bonus'];

                    foreach ($withdraw as $key => $value) {
                        if ($value['status'] == 1) {
                            $withdraw_amount += $value['amount'];
                        }
                    }

                    $availableBalance = $totalIncome - $withdraw_amount;

                    if ((int)$availableBalance != (int)$ab) {
                        $suspiciousData = array();
                        $suspiciousData['user_id'] = $data['0']['id'];
                        $suspiciousData['wallet_address'] = $data['0']['wallet_address'];
                        $suspiciousData['balance'] = $availableBalance;
                        $suspiciousData['contract_balance'] = $ab;
                        $suspiciousData['difference'] = ($availableBalance - $ab);

                        // Check if the record already exists by user_id
                        $existingRecord = suspiciousBalance::where('user_id', $data['0']['id'])->first();

                        if ($existingRecord) {
                            // If record exists, update it
                            suspiciousBalance::where('user_id', $data['0']['id'])->update($suspiciousData);
                        } else {
                            // Otherwise, insert a new record
                            suspiciousBalance::insert($suspiciousData);
                        }
                    }
                }
                
                return is_mobile($type, "", $res);
            } else {
                $res['status_code'] = 0;
                $res['message'] = "Your account is suspended by admin.";

                return is_mobile($type, "", $res);
            }
        } else {
            $res['status_code'] = 0;
            $res['message'] = "User Id and Password Does Not Match.";

            return is_mobile($type, "", $res);
        }
    }

    public function logout(Request $request)
    {
        $type = $request->input('type');

        $request->session()->flush();

        $res['status_code'] = 1;
        $res['message'] = "Disconnected Successfully.";

        return is_mobile($type, "", $res);
    }

    /*public function dashboard(Request $request)
    {
        $type    = $request->input('type');

        // $user_id = $request->session()->get('user_id');
        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }

        // Basic user check (don’t cache “not found”)
        $user = usersModel::where(['id' => $user_id])->get()->toArray();
        if (count($user) == 0) {
            $res['status_code'] = 0;
            $res['message'] = "User not found.";
            return is_mobile($type, "", $res);
        }

        // Cache key + TTL (adjust as needed)
        $cacheKey = "dashboard:{$user_id}";
        $ttl = now()->addMinutes(5);

        // Manual refresh: /dashboard?refresh=1
        if ($request->boolean('refresh')) {
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
        }

        try {
            $res = \Illuminate\Support\Facades\Cache::remember($cacheKey, $ttl, function () use ($user_id, $user) {
                $coinPrice = coinPrice();

                // Sponser
                if ($user_id == 1) {
                    $sponser = usersModel::where(['id' => 1])->get()->toArray();
                } else {
                    $sponser = usersModel::where(['id' => $user[0]['sponser_id']])->get()->toArray();
                }

                // Ranks / Levels
                $ranks  = rankingModel::get()->toArray();
                $levels = levelRoiModel::get()->toArray();

                // Directs chart (last 7 days)
                $directs = usersModel::selectRaw("count(id) as directs, DATE_FORMAT(created_on, '%Y-%m-%d') as dates")
                    ->where(['sponser_id' => $user_id])
                    ->where('created_on', '>=', \Carbon\Carbon::now()->subDays(7))
                    ->groupBy(DB::raw('DATE_FORMAT(created_on, "%Y-%m-%d")'))
                    ->get()
                    ->keyBy('dates')
                    ->toArray();

                $chartDirect = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = \Carbon\Carbon::today()->subDays($i)->format('Y-m-d');
                    $chartDirect[$date] = isset($directs[$date]) ? $directs[$date]['directs'] : 0;
                }
                $directChart = array_values($chartDirect);

                // Packages
                $packages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'desc')->get()->toArray();
                $selfInvestment = 0;
                $compoundAmount = 0;
                foreach ($packages as $p) {
                    $selfInvestment += $p['amount'];
                    $compoundAmount += $p['compound_amount'];
                }

                // Withdrawals
                $withdraw = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")
                    ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'USDT'])
                    ->get()->toArray();

                $unstakeAmount = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")
                    ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])
                    ->get()->toArray();

                $withdrawMeta = withdrawModel::selectRaw("amount, created_on")
                    ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])
                    ->orderBy('id', 'asc')
                    ->get()->toArray();

                // Active stake calc (original logic preserved)
                $activeStake = 0;
                $lastCreatedOn = 0;
                $totalCompoundAmount = 0;

                foreach ($withdrawMeta as $wm) {
                    $tempPackages = userPlansModel::where(['user_id' => $user_id])
                        ->where('created_on', '<=', $wm['created_on'])
                        ->where('created_on', '>=', $lastCreatedOn)
                        ->orderBy('id', 'asc')
                        ->get()->toArray();

                    foreach ($tempPackages as $tp) {
                        $activeStake += $tp['amount'];
                    }

                    $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                        ->where(['user_id' => $user_id])
                        ->where('created_on', '<=', $wm['created_on'])
                        ->where('created_on', '>', $lastCreatedOn)
                        ->where('tag', '=', 'ROI')
                        ->get()->toArray();

                    $totalCompoundAmount += ($tempEarnings[0]['amount']);
                    if ($wm['amount'] <= $totalCompoundAmount) {
                        $totalCompoundAmount -= $wm['amount'];
                    } else {
                        $activeStake -= ($wm['amount'] - $totalCompoundAmount);
                        $totalCompoundAmount = 0;
                    }

                    $lastCreatedOn = $wm['created_on'];
                }

                if (count($withdrawMeta) == 0) {
                    $tempPackages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'asc')->get()->toArray();
                    foreach ($tempPackages as $tp) {
                        $activeStake += $tp['amount'];
                    }
                } else {
                    $tempPackagesAfter = userPlansModel::where(['user_id' => $user_id])
                        ->where('created_on', '>', $lastCreatedOn)
                        ->orderBy('id', 'asc')
                        ->get()->toArray();
                    foreach ($tempPackagesAfter as $tp) {
                        $activeStake += $tp['amount'];
                    }
                }

                // Direct business (actual)
                $getDirects = usersModel::where(['sponser_id' => $user_id])->get()->toArray();
                $directActualBusiness = 0;
                foreach ($getDirects as $d) {
                    $directActualBusiness += getUserStakeAmount($d['id']);
                }

                // Prepare user object for response
                $userLocal = $user[0];
                $userLocal['direct_business'] = $directActualBusiness;
                $userLocal['rank'] = ($userLocal['rank_id'] == 0) ? "No Rank" : ($userLocal['rank'] ?? $userLocal['rank_id']);

                // Team ROI / rank users (kept as stub logic 0)
                $rankUsers = 0;
                $getTeamRoiLastDay = 0;

                // Two legs calculation
                $get2Legs = DB::select("SELECT (my_business + strong_business) as my_business_achieve, users.id, users.strong_business, users.refferal_code FROM users left join user_plans on users.id = user_plans.user_id where sponser_id = " . $user_id . " group by users.id order by cast(my_business_achieve as unsigned) DESC");
                $get2Legs = array_map(function ($v) { return (array) $v; }, $get2Legs);

                foreach ($get2Legs as $k2 => $v2) {
                    $userPlansAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")
                        ->where(['user_id' => $v2['id']])
                        ->whereRaw("roi > 0 and isSynced != 2")
                        ->get()->toArray();

                    $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                        ->where('user_id', '=', $v2['id'])
                        ->where('withdraw_type', '=', "UNSTAKE")
                        ->get()->toArray();

                    $get2Legs[$k2]['my_business_achieve'] =
                        (($v2['my_business_achieve'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']) < 0
                        ? 0
                        : (($v2['my_business_achieve'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']);
                }

                usort($get2Legs, function ($a, $b) {
                    return ($b["my_business_achieve"] <=> $a["my_business_achieve"]);
                });

                $firstLeg = 0;
                $otherLeg = 0;
                foreach ($get2Legs as $k2 => $v2) {
                    if ($k2 == 0) {
                        $firstLeg += $v2['my_business_achieve'];
                    } else {
                        $otherLeg += $v2['my_business_achieve'];
                    }
                }

                // Pools
                $dailyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as dailyPool")
                    ->where([['tag', '=', 'DAILY-POOL'], ['user_id', '=', $user_id]])
                    ->value('dailyPool');

                $monthlyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as dailyPool")
                    ->where([['tag', '=', 'MONTHLY-POOL'], ['user_id', '=', $user_id]])
                    ->value('dailyPool');

                // Reward date window
                $rewardDate = $userLocal['created_on'];
                $durationDays = 60;
                $getLastRewardDate = earningLogsModel::where('user_id', $user_id)
                    ->where('tag', 'REWARD-BONUS')
                    ->orderBy('id', 'desc')->get()->toArray();

                if (count($getLastRewardDate)) {
                    $rewardDate = $getLastRewardDate[0]['created_on'];
                    $getRewardDays = rewardBonusModel::where(['id' => ($getLastRewardDate[0]['refrence_id'] + 1)])->get()->toArray();
                    $durationDays = count($getRewardDays) > 0 ? $getRewardDays[0]['days'] : 0;
                }

                if ($durationDays > 0) {
                    $deadline = \Carbon\Carbon::parse($rewardDate)->addDays($durationDays);
                }

                // Delhi-event flag
                $exist = user_stablebond_details::where('user_id', $user_id)->whereNotNull('rank')->first();

                // Top investor (date window kept as in your code)
                $top = usersModel::from('users as u')
                    ->join('user_plans as up', 'up.user_id', '=', 'u.id')
                    ->whereBetween('up.created_on', ['2025-09-01 16:30:01', '2025-10-01 16:29:59'])
                    ->whereRaw("(amount * coin_price) >= 10000")
                    ->orderByRaw('CAST(up.amount AS UNSIGNED) DESC')
                    ->limit(31)
                    ->get(['u.wallet_address', 'up.amount', 'up.coin_price']);

                // Build response
                $res = [];
                $res['status_code']           = 1;
                $res['message']               = "Dashboard Page.";
                $res['user']                  = $userLocal;
                $res['sponser']               = $sponser[0] ?? [];
                $res['ranks']                 = $ranks;
                $res['levels']                = $levels;
                $res['chartDirect']           = $directChart;
                $res['my_packages']           = $packages;
                $res['total_withdraw']        = $withdraw[0]['total_withdraw'] ?? 0;
                $res['total_unstake_amount']  = $unstakeAmount[0]['total_withdraw'] ?? 0;
                $res['self_investment']       = $selfInvestment;
                $res['compound_amount']       = $compoundAmount;
                $res['activeStake']           = $activeStake;
                $res['available_balance']     = getBalance($user_id);
                $res['total_income']          = getIncome($user_id);
                $res['coinPrice']              = $coinPrice;
                $res['treasuryBalance']       = getTreasuryBalance();
                $res['teamRoi']               = $getTeamRoiLastDay;
                $res['rankUser']              = $rankUsers;
                $res['nonRankUser']           = ($userLocal['my_team'] - $rankUsers);
                $res['firstLeg']              = $firstLeg;
                $res['otherLeg']              = $otherLeg;
                $res['dailyPoolWinners']      = $dailyPoolWinners;
                $res['monthlyPoolWinners']    = $monthlyPoolWinners;
                if (!empty($deadline)) {
                    $res['rewardDate'] = $deadline;
                }
                $res['delhi-event']           = $exist ? 1 : 0;
                $res['top_investor']          = $top;

                // New key added to check if user has stacked True/False
                $isStaked  = userPlansModel::where('user_id', $user_id)
                                                ->where('amount', '>', 0)
                                                ->where('isSynced', '!=', 2)
                                                ->exists();
                $res['isStaked']              = $isStaked;

                return $res;
            });
        } catch (\Exception $e) {
            \Log::warning('Cache failed for dashboard, executing without cache: ' . $e->getMessage());
            
            $coinPrice = coinPrice();

            // Sponser
            if ($user_id == 1) {
                $sponser = usersModel::where(['id' => 1])->get()->toArray();
            } else {
                $sponser = usersModel::where(['id' => $user[0]['sponser_id']])->get()->toArray();
            }

            // Ranks / Levels
            $ranks  = rankingModel::get()->toArray();
            $levels = levelRoiModel::get()->toArray();

            // Directs chart (last 7 days)
            $directs = usersModel::selectRaw("count(id) as directs, DATE_FORMAT(created_on, '%Y-%m-%d') as dates")
                ->where(['sponser_id' => $user_id])
                ->where('created_on', '>=', \Carbon\Carbon::now()->subDays(7))
                ->groupBy(DB::raw('DATE_FORMAT(created_on, "%Y-%m-%d")'))
                ->get()
                ->keyBy('dates')
                ->toArray();

            $chartDirect = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = \Carbon\Carbon::today()->subDays($i)->format('Y-m-d');
                $chartDirect[$date] = isset($directs[$date]) ? $directs[$date]['directs'] : 0;
            }
            $directChart = array_values($chartDirect);

            // Packages
            $packages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'desc')->get()->toArray();
            $selfInvestment = 0;
            $compoundAmount = 0;
            foreach ($packages as $p) {
                $selfInvestment += $p['amount'];
                $compoundAmount += $p['compound_amount'];
            }

            // Withdrawals
            $withdraw = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")
                ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'USDT'])
                ->get()->toArray();

            $unstakeAmount = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")
                ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])
                ->get()->toArray();

            $withdrawMeta = withdrawModel::selectRaw("amount, created_on")
                ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])
                ->orderBy('id', 'asc')
                ->get()->toArray();

            // Active stake calc (original logic preserved)
            $activeStake = 0;
            $lastCreatedOn = 0;
            $totalCompoundAmount = 0;

            foreach ($withdrawMeta as $wm) {
                $tempPackages = userPlansModel::where(['user_id' => $user_id])
                    ->where('created_on', '<=', $wm['created_on'])
                    ->where('created_on', '>=', $lastCreatedOn)
                    ->orderBy('id', 'asc')
                    ->get()->toArray();

                foreach ($tempPackages as $tp) {
                    $activeStake += $tp['amount'];
                }

                $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                    ->where(['user_id' => $user_id])
                    ->where('created_on', '<=', $wm['created_on'])
                    ->where('created_on', '>', $lastCreatedOn)
                    ->where('tag', '=', 'ROI')
                    ->get()->toArray();

                $totalCompoundAmount += ($tempEarnings[0]['amount']);
                if ($wm['amount'] <= $totalCompoundAmount) {
                    $totalCompoundAmount -= $wm['amount'];
                } else {
                    $activeStake -= ($wm['amount'] - $totalCompoundAmount);
                    $totalCompoundAmount = 0;
                }

                $lastCreatedOn = $wm['created_on'];
            }

            if (count($withdrawMeta) == 0) {
                $tempPackages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'asc')->get()->toArray();
                foreach ($tempPackages as $tp) {
                    $activeStake += $tp['amount'];
                }
            } else {
                $tempPackagesAfter = userPlansModel::where(['user_id' => $user_id])
                    ->where('created_on', '>', $lastCreatedOn)
                    ->orderBy('id', 'asc')
                    ->get()->toArray();
                foreach ($tempPackagesAfter as $tp) {
                    $activeStake += $tp['amount'];
                }
            }

            // Direct business (actual)
            $getDirects = usersModel::where(['sponser_id' => $user_id])->get()->toArray();
            $directActualBusiness = 0;
            foreach ($getDirects as $d) {
                $directActualBusiness += getUserStakeAmount($d['id']);
            }

            // Prepare user object for response
            $userLocal = $user[0];
            $userLocal['direct_business'] = $directActualBusiness;
            $userLocal['rank'] = ($userLocal['rank_id'] == 0) ? "No Rank" : ($userLocal['rank'] ?? $userLocal['rank_id']);

            // Team ROI / rank users (kept as stub logic 0)
            $rankUsers = 0;
            $getTeamRoiLastDay = 0;

            // Two legs calculation
            $get2Legs = DB::select("SELECT (my_business + strong_business) as my_business_achieve, users.id, users.strong_business, users.refferal_code FROM users left join user_plans on users.id = user_plans.user_id where sponser_id = " . $user_id . " group by users.id order by cast(my_business_achieve as unsigned) DESC");
            $get2Legs = array_map(function ($v) { return (array) $v; }, $get2Legs);

            foreach ($get2Legs as $k2 => $v2) {
                $userPlansAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")
                    ->where(['user_id' => $v2['id']])
                    ->whereRaw("roi > 0 and isSynced != 2")
                    ->get()->toArray();

                $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                    ->where('user_id', '=', $v2['id'])
                    ->where('withdraw_type', '=', "UNSTAKE")
                    ->get()->toArray();

                $get2Legs[$k2]['my_business_achieve'] =
                    (($v2['my_business_achieve'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']) < 0
                    ? 0
                    : (($v2['my_business_achieve'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']);
            }

            usort($get2Legs, function ($a, $b) {
                return ($b["my_business_achieve"] <=> $a["my_business_achieve"]);
            });

            $firstLeg = 0;
            $otherLeg = 0;
            foreach ($get2Legs as $k2 => $v2) {
                if ($k2 == 0) {
                    $firstLeg += $v2['my_business_achieve'];
                } else {
                    $otherLeg += $v2['my_business_achieve'];
                }
            }

            // Pools
            $dailyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as dailyPool")
                ->where([['tag', '=', 'DAILY-POOL'], ['user_id', '=', $user_id]])
                ->value('dailyPool');

            $monthlyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as dailyPool")
                ->where([['tag', '=', 'MONTHLY-POOL'], ['user_id', '=', $user_id]])
                ->value('dailyPool');

            // Reward date window
            $rewardDate = $userLocal['created_on'];
            $durationDays = 60;
            $getLastRewardDate = earningLogsModel::where('user_id', $user_id)
                ->where('tag', 'REWARD-BONUS')
                ->orderBy('id', 'desc')->get()->toArray();

            if (count($getLastRewardDate)) {
                $rewardDate = $getLastRewardDate[0]['created_on'];
                $getRewardDays = rewardBonusModel::where(['id' => ($getLastRewardDate[0]['refrence_id'] + 1)])->get()->toArray();
                $durationDays = count($getRewardDays) > 0 ? $getRewardDays[0]['days'] : 0;
            }

            if ($durationDays > 0) {
                $deadline = \Carbon\Carbon::parse($rewardDate)->addDays($durationDays);
            }

            // Delhi-event flag
            $exist = user_stablebond_details::where('user_id', $user_id)->whereNotNull('rank')->first();

            // Top investor (date window kept as in your code)
            $top = usersModel::from('users as u')
                ->join('user_plans as up', 'up.user_id', '=', 'u.id')
                ->whereBetween('up.created_on', ['2025-09-01 16:30:01', '2025-10-01 16:29:59'])
                ->whereRaw("(amount * coin_price) >= 10000")
                ->orderByRaw('CAST(up.amount AS UNSIGNED) DESC')
                ->limit(31)
                ->get(['u.wallet_address', 'up.amount', 'up.coin_price']);

            // Build response
            $res = [];
            $res['status_code']           = 1;
            $res['message']               = "Dashboard Page.";
            $res['user']                  = $userLocal;
            $res['sponser']               = $sponser[0] ?? [];
            $res['ranks']                 = $ranks;
            $res['levels']                = $levels;
            $res['chartDirect']           = $directChart;
            $res['my_packages']           = $packages;
            $res['total_withdraw']        = $withdraw[0]['total_withdraw'] ?? 0;
            $res['total_unstake_amount']  = $unstakeAmount[0]['total_withdraw'] ?? 0;
            $res['self_investment']       = $selfInvestment;
            $res['compound_amount']       = $compoundAmount;
            $res['activeStake']           = $activeStake;
            $res['available_balance']     = getBalance($user_id);
            $res['total_income']          = getIncome($user_id);
            $res['coinPrice']              = $coinPrice;
            $res['treasuryBalance']       = getTreasuryBalance();
            $res['teamRoi']               = $getTeamRoiLastDay;
            $res['rankUser']              = $rankUsers;
            $res['nonRankUser']           = ($userLocal['my_team'] - $rankUsers);
            $res['firstLeg']              = $firstLeg;
            $res['otherLeg']              = $otherLeg;
            $res['dailyPoolWinners']      = $dailyPoolWinners;
            $res['monthlyPoolWinners']    = $monthlyPoolWinners;
            if (!empty($deadline)) {
                $res['rewardDate'] = $deadline;
            }
            $res['delhi-event']           = $exist ? 1 : 0;
            $res['top_investor']          = $top;
        }

        return is_mobile($type, "", $res, "view");
    }*/

    public function dashboard(Request $request)
    {
        $type    = $request->input('type');

        // $user_id = $request->session()->get('user_id');
        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }

        // Basic user check (don’t cache “not found”)
        $user = usersModel::where(['id' => $user_id])->get()->toArray();
        if (count($user) == 0) {
            $res['status_code'] = 0;
            $res['message'] = "User not found.";
            return is_mobile($type, "fregister", $res);
        }

        // Cache key + TTL (adjust as needed)
        $cacheKey = "dashboard:{$user_id}";
        $ttl = now()->addMinutes(5);

        // Manual refresh: /dashboard?refresh=1
        \Illuminate\Support\Facades\Cache::forget($cacheKey);
        if ($request->boolean('refresh')) {
        }

        try {
            $res = \Illuminate\Support\Facades\Cache::remember($cacheKey, $ttl, function () use ($user_id, $user) {
                $coinPrice = coinPrice();

                // Sponser
                if ($user_id == 1) {
                    $sponser = usersModel::where(['id' => 1])->get()->toArray();
                } else {
                    $sponser = usersModel::where(['id' => $user[0]['sponser_id']])->get()->toArray();
                }

                // Team Bonus (Differential Bonus System) : team_bonus - rank_bonus
                // Rank & Reward : creator_bonus - reward_bonus
                // Ranks / Levels
                $ranks  = $this->teamBonusMatrix; // rankingModel::get()->toArray();
                $creatorRanks  = $this->rankMatrix; //rewardBonusModel::get()->toArray();
                $levels = levelRoiModel::get()->toArray();

                // Directs chart (last 7 days)
                $directs = usersModel::selectRaw("count(id) as directs, DATE_FORMAT(created_on, '%Y-%m-%d') as dates")
                    ->where(['sponser_id' => $user_id])
                    ->where('created_on', '>=', \Carbon\Carbon::now()->subDays(7))
                    ->groupBy(DB::raw('DATE_FORMAT(created_on, "%Y-%m-%d")'))
                    ->get()
                    ->keyBy('dates')
                    ->toArray();

                $chartDirect = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = \Carbon\Carbon::today()->subDays($i)->format('Y-m-d');
                    $chartDirect[$date] = isset($directs[$date]) ? $directs[$date]['directs'] : 0;
                }
                $directChart = array_values($chartDirect);

                // Packages
                $packages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'desc')->get()->toArray();
                $selfInvestment = 0;
                $compoundAmount = 0;
                foreach ($packages as $p) {
                    $selfInvestment += $p['amount'];
                    $compoundAmount += $p['compound_amount'];
                }

                // Withdrawals
                $withdraw = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")
                    ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'USDT'])
                    ->get()->toArray();

                $unstakeAmount = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")
                    ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])
                    ->get()->toArray();

                $withdrawMeta = withdrawModel::selectRaw("amount, created_on")
                    ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])
                    ->orderBy('id', 'asc')
                    ->get()->toArray();

                // Active stake calc (original logic preserved)
                $activeStake = 0;
                $lastCreatedOn = 0;
                $totalCompoundAmount = 0;

                foreach ($withdrawMeta as $wm) {
                    $tempPackages = userPlansModel::where(['user_id' => $user_id])
                        ->where('created_on', '<=', $wm['created_on'])
                        ->where('created_on', '>=', $lastCreatedOn)
                        ->orderBy('id', 'asc')
                        ->get()->toArray();

                    foreach ($tempPackages as $tp) {
                        $activeStake += $tp['amount'];
                    }

                    $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                        ->where(['user_id' => $user_id])
                        ->where('created_on', '<=', $wm['created_on'])
                        ->where('created_on', '>', $lastCreatedOn)
                        ->where('tag', '=', 'ROI')
                        ->get()->toArray();

                    $totalCompoundAmount += ($tempEarnings[0]['amount']);
                    if ($wm['amount'] <= $totalCompoundAmount) {
                        $totalCompoundAmount -= $wm['amount'];
                    } else {
                        $activeStake -= ($wm['amount'] - $totalCompoundAmount);
                        $totalCompoundAmount = 0;
                    }

                    $lastCreatedOn = $wm['created_on'];
                }

                if (count($withdrawMeta) == 0) {
                    $tempPackages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'asc')->get()->toArray();
                    foreach ($tempPackages as $tp) {
                        $activeStake += $tp['amount'];
                    }
                } else {
                    $tempPackagesAfter = userPlansModel::where(['user_id' => $user_id])
                        ->where('created_on', '>', $lastCreatedOn)
                        ->orderBy('id', 'asc')
                        ->get()->toArray();
                    foreach ($tempPackagesAfter as $tp) {
                        $activeStake += $tp['amount'];
                    }
                }

                // Direct business (actual)
                $getDirects = usersModel::where(['sponser_id' => $user_id])->get()->toArray();
                $directActualBusiness = 0;
                foreach ($getDirects as $d) {
                    $directActualBusiness += getUserStakeAmount($d['id']);
                }

                // Prepare user object for response
                $userLocal = $user[0];
                $userLocal['active_direct'] = activeDirect($user_id, 100);
                $userLocal['direct_business'] = $directActualBusiness;
                $userLocal['rank'] = ($userLocal['rank_id'] == 0) ? "No Rank" : ($userLocal['rank'] ?? $userLocal['rank_id']);

                // Team ROI / rank users (kept as stub logic 0)
                $rankUsers = 0;
                $getTeamRoiLastDay = 0;

                // Two legs calculation
                $get2Legs = DB::select("SELECT (my_business + strong_business) as my_business_achieve, users.id, users.strong_business, users.refferal_code FROM users left join user_plans on users.id = user_plans.user_id where sponser_id = " . $user_id . " group by users.id order by cast(my_business_achieve as unsigned) DESC");
                $get2Legs = array_map(function ($v) { return (array) $v; }, $get2Legs);

                foreach ($get2Legs as $k2 => $v2) {
                    $userPlansAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")
                        ->where(['user_id' => $v2['id']])
                        ->whereRaw("roi > 0 and isSynced != 2")
                        ->get()->toArray();

                    $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                        ->where('user_id', '=', $v2['id'])
                        ->where('withdraw_type', '=', "UNSTAKE")
                        ->get()->toArray();

                    $get2Legs[$k2]['my_business_achieve'] =
                        (($v2['my_business_achieve'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']) < 0
                        ? 0
                        : (($v2['my_business_achieve'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']);
                }

                usort($get2Legs, function ($a, $b) {
                    return ($b["my_business_achieve"] <=> $a["my_business_achieve"]);
                });

                $firstLeg = 0;
                $otherLeg = 0;
                foreach ($get2Legs as $k2 => $v2) {
                    if ($k2 == 0) {
                        $firstLeg += $v2['my_business_achieve'];
                    } else {
                        $otherLeg += $v2['my_business_achieve'];
                    }
                }

                // Pools
                $dailyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as dailyPool")
                    ->where([['tag', '=', 'DAILY-POOL'], ['user_id', '=', $user_id]])
                    ->value('dailyPool');

                $monthlyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as dailyPool")
                    ->where([['tag', '=', 'MONTHLY-POOL'], ['user_id', '=', $user_id]])
                    ->value('dailyPool');

                // Reward date window
                $rewardDate = $userLocal['created_on'];
                $durationDays = 60;
                $getLastRewardDate = earningLogsModel::where('user_id', $user_id)
                    ->where('tag', 'REWARD-BONUS')
                    ->orderBy('id', 'desc')->get()->toArray();

                if (count($getLastRewardDate)) {
                    $rewardDate = $getLastRewardDate[0]['created_on'];
                    $getRewardDays = rewardBonusModel::where(['id' => ($getLastRewardDate[0]['refrence_id'] + 1)])->get()->toArray();
                    $durationDays = count($getRewardDays) > 0 ? $getRewardDays[0]['days'] : 0;
                }

                if ($durationDays > 0) {
                    $deadline = \Carbon\Carbon::parse($rewardDate)->addDays($durationDays);
                }

                // Delhi-event flag
                $exist = user_stablebond_details::where('user_id', $user_id)->whereNotNull('rank')->first();


                $directsActive100 = usersModel::select('users.id')
                    ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                    ->where('users.sponser_id', $user_id)
                    ->groupBy('users.id')
                    ->get();

                $count = 0;
                foreach ($directsActive100 as $direct) {
                    $stake = getUserStakedAmount($direct->id);
                    if ($stake * $coinPrice >= 100) $count++;
                }

                $userLocal['active_direct'] = $count;


                $teamActive100 = myTeamModel::select('my_team.team_id')
                        ->join('user_plans', 'user_plans.user_id', '=', 'my_team.team_id')
                        ->where('my_team.user_id', $user_id)
                        ->groupBy('my_team.team_id')
                        ->get();

                $teamCount = 0;
                foreach ($teamActive100 as $team) {
                    $teamStake = getUserStakedAmount($team->team_id);
                    if ($teamStake * $coinPrice >= 100) $teamCount++;
                }

                $userLocal['active_team'] = $teamCount;

                // Build response
                $res = [];
                $res['status_code']           = 1;
                $res['message']               = "Dashboard Page.";
                $res['user']                  = $userLocal;
                $res['sponser']               = $sponser[0] ?? [];
                $res['ranks']                 = $ranks;
                $res['creator_ranks']         = $creatorRanks;
                $res['levels']                = $levels;
                $res['chartDirect']           = $directChart;
                $res['my_packages']           = $packages;
                $res['total_withdraw']        = $withdraw[0]['total_withdraw'] ?? 0;
                $res['total_unstake_amount']  = $unstakeAmount[0]['total_withdraw'] ?? 0;
                $res['self_investment']       = $selfInvestment;
                $res['compound_amount']       = $compoundAmount;
                $res['activeStake']           = $activeStake;
                $res['available_balance']     = getBalance($user_id);
                $res['total_income']          = getIncome($user_id);
                $res['coinPrice']              = $coinPrice;
                $res['treasuryBalance']       = getTreasuryBalance();
                $res['teamRoi']               = $getTeamRoiLastDay;
                $res['rankUser']              = $rankUsers;
                $res['nonRankUser']           = ($userLocal['my_team'] - $rankUsers);
                $res['firstLeg']              = $firstLeg;
                $res['otherLeg']              = $otherLeg;
                $res['dailyPoolWinners']      = $dailyPoolWinners;
                $res['monthlyPoolWinners']    = $monthlyPoolWinners;
                if (!empty($deadline)) {
                    $res['rewardDate'] = $deadline;
                }
                $res['delhi-event']           = $exist ? 1 : 0;


                // New key added to check if user has stacked True/False
                $isStaked  = userPlansModel::where('user_id', $user_id)
                                                ->where('amount', '>', 0)
                                                ->where('isSynced', '!=', 2)
                                                ->exists();
                $res['isStaked']              = $isStaked;

                $fetchDiscountJson = file_get_contents("http://91.243.178.152:5255/api/24h");

                $fetchDiscount = json_decode($fetchDiscountJson, true);

                $res['discount'] = abs($fetchDiscount['data']['priceChange24hPercent']);

                Log::info("Data: " . json_encode($res));

                return $res;
            });
        } catch (\Exception $e) {
            \Log::warning('Cache failed for dashboard, executing without cache: ' . $e->getMessage());
            
            $coinPrice = coinPrice();

            // Sponser
            if ($user_id == 1) {
                $sponser = usersModel::where(['id' => 1])->get()->toArray();
            } else {
                $sponser = usersModel::where(['id' => $user[0]['sponser_id']])->get()->toArray();
            }

            // Ranks / Levels
            $ranks  = rankingModel::get()->toArray();
            $creatorRanks  = rewardBonusModel::get()->toArray();
            $levels = levelRoiModel::get()->toArray();

            // Directs chart (last 7 days)
            $directs = usersModel::selectRaw("count(id) as directs, DATE_FORMAT(created_on, '%Y-%m-%d') as dates")
                ->where(['sponser_id' => $user_id])
                ->where('created_on', '>=', \Carbon\Carbon::now()->subDays(7))
                ->groupBy(DB::raw('DATE_FORMAT(created_on, "%Y-%m-%d")'))
                ->get()
                ->keyBy('dates')
                ->toArray();

            $chartDirect = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = \Carbon\Carbon::today()->subDays($i)->format('Y-m-d');
                $chartDirect[$date] = isset($directs[$date]) ? $directs[$date]['directs'] : 0;
            }
            $directChart = array_values($chartDirect);

            // Packages
            $packages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'desc')->get()->toArray();
            $selfInvestment = 0;
            $compoundAmount = 0;
            foreach ($packages as $p) {
                $selfInvestment += $p['amount'];
                $compoundAmount += $p['compound_amount'];
            }

            // Withdrawals
            $withdraw = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")
                ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'USDT'])
                ->get()->toArray();

            $unstakeAmount = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")
                ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])
                ->get()->toArray();

            $withdrawMeta = withdrawModel::selectRaw("amount, created_on")
                ->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])
                ->orderBy('id', 'asc')
                ->get()->toArray();

            // Active stake calc (original logic preserved)
            $activeStake = 0;
            $lastCreatedOn = 0;
            $totalCompoundAmount = 0;

            foreach ($withdrawMeta as $wm) {
                $tempPackages = userPlansModel::where(['user_id' => $user_id])
                    ->where('created_on', '<=', $wm['created_on'])
                    ->where('created_on', '>=', $lastCreatedOn)
                    ->orderBy('id', 'asc')
                    ->get()->toArray();

                foreach ($tempPackages as $tp) {
                    $activeStake += $tp['amount'];
                }

                $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                    ->where(['user_id' => $user_id])
                    ->where('created_on', '<=', $wm['created_on'])
                    ->where('created_on', '>', $lastCreatedOn)
                    ->where('tag', '=', 'ROI')
                    ->get()->toArray();

                $totalCompoundAmount += ($tempEarnings[0]['amount']);
                if ($wm['amount'] <= $totalCompoundAmount) {
                    $totalCompoundAmount -= $wm['amount'];
                } else {
                    $activeStake -= ($wm['amount'] - $totalCompoundAmount);
                    $totalCompoundAmount = 0;
                }

                $lastCreatedOn = $wm['created_on'];
            }

            if (count($withdrawMeta) == 0) {
                $tempPackages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'asc')->get()->toArray();
                foreach ($tempPackages as $tp) {
                    $activeStake += $tp['amount'];
                }
            } else {
                $tempPackagesAfter = userPlansModel::where(['user_id' => $user_id])
                    ->where('created_on', '>', $lastCreatedOn)
                    ->orderBy('id', 'asc')
                    ->get()->toArray();
                foreach ($tempPackagesAfter as $tp) {
                    $activeStake += $tp['amount'];
                }
            }

            // Direct business (actual)
            $getDirects = usersModel::where(['sponser_id' => $user_id])->get()->toArray();
            $directActualBusiness = 0;
            foreach ($getDirects as $d) {
                $directActualBusiness += getUserStakeAmount($d['id']);
            }

            // Prepare user object for response
            $userLocal = $user[0];
            $userLocal['direct_business'] = $directActualBusiness;
            $userLocal['rank'] = ($userLocal['rank_id'] == 0) ? "No Rank" : ($userLocal['rank'] ?? $userLocal['rank_id']);

            // Team ROI / rank users (kept as stub logic 0)
            $rankUsers = 0;
            $getTeamRoiLastDay = 0;

            // Two legs calculation
            $get2Legs = DB::select("SELECT (my_business + strong_business) as my_business_achieve, users.id, users.strong_business, users.refferal_code FROM users left join user_plans on users.id = user_plans.user_id where sponser_id = " . $user_id . " group by users.id order by cast(my_business_achieve as unsigned) DESC");
            $get2Legs = array_map(function ($v) { return (array) $v; }, $get2Legs);

            foreach ($get2Legs as $k2 => $v2) {
                $userPlansAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")
                    ->where(['user_id' => $v2['id']])
                    ->whereRaw("roi > 0 and isSynced != 2")
                    ->get()->toArray();

                $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                    ->where('user_id', '=', $v2['id'])
                    ->where('withdraw_type', '=', "UNSTAKE")
                    ->get()->toArray();

                $get2Legs[$k2]['my_business_achieve'] =
                    (($v2['my_business_achieve'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']) < 0
                    ? 0
                    : (($v2['my_business_achieve'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']);
            }

            usort($get2Legs, function ($a, $b) {
                return ($b["my_business_achieve"] <=> $a["my_business_achieve"]);
            });

            $firstLeg = 0;
            $otherLeg = 0;
            foreach ($get2Legs as $k2 => $v2) {
                if ($k2 == 0) {
                    $firstLeg += $v2['my_business_achieve'];
                } else {
                    $otherLeg += $v2['my_business_achieve'];
                }
            }

            // Pools
            $dailyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as dailyPool")
                ->where([['tag', '=', 'DAILY-POOL'], ['user_id', '=', $user_id]])
                ->value('dailyPool');

            $monthlyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as dailyPool")
                ->where([['tag', '=', 'MONTHLY-POOL'], ['user_id', '=', $user_id]])
                ->value('dailyPool');

            // Reward date window
            $rewardDate = $userLocal['created_on'];
            $durationDays = 60;
            $getLastRewardDate = earningLogsModel::where('user_id', $user_id)
                ->where('tag', 'REWARD-BONUS')
                ->orderBy('id', 'desc')->get()->toArray();

            if (count($getLastRewardDate)) {
                $rewardDate = $getLastRewardDate[0]['created_on'];
                $getRewardDays = rewardBonusModel::where(['id' => ($getLastRewardDate[0]['refrence_id'] + 1)])->get()->toArray();
                $durationDays = count($getRewardDays) > 0 ? $getRewardDays[0]['days'] : 0;
            }

            if ($durationDays > 0) {
                $deadline = \Carbon\Carbon::parse($rewardDate)->addDays($durationDays);
            }

            // Delhi-event flag
            $exist = user_stablebond_details::where('user_id', $user_id)->whereNotNull('rank')->first();

            $directsActive100 = usersModel::select('users.id')
                    ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                    ->where('users.sponser_id', $user_id)
                    ->groupBy('users.id')
                    ->get();

            $count = 0;
            foreach ($directsActive100 as $direct) {
                $stake = getUserStakedAmount($direct->id);
                if ($stake * $coinPrice >= 100) $count++;
            }

            $userLocal['active_direct'] = $count;


            $teamActive100 = myTeamModel::select('my_team.team_id')
                    ->join('user_plans', 'user_plans.user_id', '=', 'my_team.team_id')
                    ->where('my_team.user_id', $user_id)
                    ->groupBy('my_team.team_id')
                    ->get();

            $teamCount = 0;
            foreach ($teamActive100 as $team) {
                $teamStake = getUserStakedAmount($team->team_id);
                if ($teamStake * $coinPrice >= 100) $teamCount++;
            }

            $userLocal['active_team'] = $teamCount;

            // Build response
            $res = []; 
            $res['status_code']           = 1;
            $res['message']               = "Dashboard Page.";
            $res['user']                  = $userLocal;
            $res['sponser']               = $sponser[0] ?? [];
            $res['ranks']                 = $ranks;
            $res['creator_ranks']         = $creatorRanks;
            $res['levels']                = $levels;
            $res['chartDirect']           = $directChart;
            $res['my_packages']           = $packages;
            $res['total_withdraw']        = $withdraw[0]['total_withdraw'] ?? 0;
            $res['total_unstake_amount']  = $unstakeAmount[0]['total_withdraw'] ?? 0;
            $res['self_investment']       = $selfInvestment;
            $res['compound_amount']       = $compoundAmount;
            $res['activeStake']           = $activeStake;
            $res['available_balance']     = getBalance($user_id);
            $res['total_income']          = getIncome($user_id);
            $res['coinPrice']             = $coinPrice;
            $res['treasuryBalance']       = getTreasuryBalance();
            $res['teamRoi']               = $getTeamRoiLastDay;
            $res['rankUser']              = $rankUsers;
            $res['nonRankUser']           = ($userLocal['my_team'] - $rankUsers);
            $res['firstLeg']              = $firstLeg;
            $res['otherLeg']              = $otherLeg;
            $res['dailyPoolWinners']      = $dailyPoolWinners;
            $res['monthlyPoolWinners']    = $monthlyPoolWinners;
            if (!empty($deadline)) {
                $res['rewardDate'] = $deadline;
            }
            $res['delhi-event']           = $exist ? 1 : 0;
            $fetchDiscountJson = file_get_contents("http://91.243.178.152:5255/api/24h");

            $fetchDiscount = json_decode($fetchDiscountJson, true);

            $res['discount'] = abs($fetchDiscount['data']['priceChange24hPercent']);
        }

        return is_mobile($type, "pages.index", $res, "view");
    }

    public function activeTrades(Request $request)
    {
        $type = "API";


        $res['status_code'] = 1;
        $res['message'] = "Active Trades.";

        return is_mobile($type, "", $res, "view");
    }

    public function toastDetails(Request $request)
    {
        $type = "API";

        $toaster = DB::table('toaster')
            ->where(['status' => 0])
            ->orderBy('id', 'desc')   // First order by 'id' descending
            ->orderBy('priority', 'desc')   // Second order by 'priority' descending
            ->first();

        if (count($toaster) > 0) {
            DB::table('toaster')->where(['id' => $toaster->id])->update(['status' => 1]);
            $res['toaster'] = $toaster;
        }

        $res['status_code'] = 1;
        $res['message'] = "Active Toasts.";

        return is_mobile($type, "", $res, "view");
    }

    public function referralCodeDetails(Request $request)
    {
        $type = "API";
        $refferal_code = $request->input('refferal_code');

        if (!empty($refferal_code)) {
            $data = usersModel::select('wallet_address')->where(['refferal_code' => $refferal_code])->get()->toArray();

            if (count($data) > 0) {
                $res['status_code'] = 1;
                $res['message'] = "Successfully.";
                $res['data'] = $data['0']['wallet_address'];
            } else {
                $res['status_code'] = 0;
                $res['message'] = "Invalid user.";
            }
        } else {
            $res['status_code'] = 0;
            $res['message'] = "Parameter missing.";
        }

        return is_mobile($type, "", $res, "view");
    }

    function user_details_store(Request $request){
        $type = $request->input('type');
        $user_id = $request->session()->get('user_id');
        $country = $request->input('country');
        $tag = $request->input('tag');
        $region = $request->input('region');
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $email = $request->input('email');
        $wapp = $request->input('wapp');
        $pass_num = $request->input('pass_num');
        $pass_issue_date = $request->input('pass_issue_date');
        $pass_expiry_date = $request->input('pass_expiry_date');
 
        $validator = Validator::make($request->all(), [
            'country'           => 'required|string',
            'tag'               => 'required|string',
            'region'            => 'required|string',
            'fname'             => 'required|string',
            'lname'             => 'required|string',
            'email'             => 'required|email',
            'wapp'              => 'required|string',
            'pass_num'          => 'required|string',
            'pass_front'          => 'required|file|max:2048',
            'pass_back'          => 'required|file|max:2048',
            'pass_issue_date'   => 'required|date',
            'pass_expiry_date'  => 'required|date',
        ]);

        if ($validator->fails()) {
            $res['status_code'] = 0;
            // $res['message'] = "Details Required";
            $res['message'] = $validator->errors()->first();

            return is_mobile($type, "", $res);
        }
        $validator1 = Validator::make($request->all(), [
            'pass_front'          => 'file|max:2048',
            'pass_back'          => 'file|max:2048',
        ]);

        if ($validator1->fails()) {
            $res['status_code'] = 0;
            $res['message'] = implode(', ', $validator->errors()->all());

            return is_mobile($type, "", $res);
        }
        $exist= user_stablebond_details::where('user_id',$user_id)->where('tag',$tag)->first();
        if ($exist) {
            $res['status_code'] = 0;
            $res['message'] = "Already Submitted";

            return is_mobile($type, "", $res);
        }

        $user_plans = array();

        $allowedfileExtension = ['jpeg', 'jpg', 'png'];

        $pass_front_file = $request->file('pass_front');

        if (isset($pass_front_file)) {
            $filename = $pass_front_file->getClientOriginalName();
            $extension = $pass_front_file->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);
            if (!$check) {
                $res['status_code'] = 0;
                $res['message'] = "Only jpeg and png files are supported ";

                return is_mobile($type, "", $res);
            }

            $pass_front_file_name = "";
            if ($request->hasFile('pass_front')) {
                $pass_front_file = $request->file('pass_front');
                $originalname = $pass_front_file->getClientOriginalName();
                $og_name = "pass_front" . '_' . date('YmdHis');
                $ext = \File::extension($originalname);
                $pass_front_file_name = $og_name . '.' . $ext;
                $path = $pass_front_file->storeAs('public/', $pass_front_file_name);
                $user_plans['passport_pic_front'] = $pass_front_file_name;
            }
        }
        $pass_back_file = $request->file('pass_back');

        if (isset($pass_back_file)) {
            $filename = $pass_back_file->getClientOriginalName();
            $extension = $pass_back_file->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);

            if (!$check) {
                $res['status_code'] = 0;
                $res['message'] = "Only jpeg and png files are supported ";

                return is_mobile($type, "", $res);
            }

            $pass_back_file_name = "";
            if ($request->hasFile('pass_back')) {
                $pass_back_file = $request->file('pass_back');
                $originalname = $pass_back_file->getClientOriginalName();
                $og_name = "pass_back" . '_' . date('YmdHis');
                $ext = \File::extension($originalname);
                $pass_back_file_name = $og_name . '.' . $ext;
                $path = $pass_back_file->storeAs('public/', $pass_back_file_name);
                $user_plans['passport_pic_back'] = $pass_back_file_name;
            }
        }

        $user_plans['user_id'] = $user_id;
        $user_plans['country'] = $country;
        $user_plans['tag'] = $tag;
        $user_plans['region'] = $region;
        $user_plans['firstname'] = $fname;
        $user_plans['lastname'] = $lname;
        $user_plans['email'] = $email;
        $user_plans['whatapp_num'] = $wapp;
        $user_plans['passport_num'] = $pass_num;
        $user_plans['passport_issue_date'] = $pass_issue_date;
        $user_plans['passport_expiry_date'] = $pass_expiry_date;
        $user_plans['event'] = 'Thailand Event 17 August';
        user_stablebond_details::insert($user_plans);

        $res['status_code'] = 1;
        $res['message'] = "Details Added Successfully";

        return is_mobile($type, "", $res);
    }
    
    function user_rank_details_store(Request $request){
        $type = $request->input('type');
        $user_id = $request->session()->get('user_id');
        $name = $request->input('name');
        $mobile = $request->input('mobile');
        $rank = $request->input('rank');
        $email = $request->input('email');

        $validator = Validator::make($request->all(), [
            'name'           => 'required|string',
            'mobile'               => 'required|string',
            'rank'             => 'required|string',
            'email'             => 'required|email',
            'address_proof'          => 'required|file|max:2048',
            'photo'          => 'required|file|max:2048',
        ]);

        if ($validator->fails()) {
            $res['status_code'] = 0;
            // $res['message'] = "Details Required";
            $res['message'] = $validator->errors()->first();

            return is_mobile($type, "", $res);
        }
        $validator1 = Validator::make($request->all(), [
            'address_proof'          => 'file|max:2048',
            'photo'          => 'file|max:2048',
        ]);

        if ($validator1->fails()) {
            $res['status_code'] = 0;
            $res['message'] = implode(', ', $validator->errors()->all());

            return is_mobile($type, "", $res);
        }
        $exist= user_stablebond_details::where('user_id',$user_id)->whereNotNull('rank')->first();
        if ($exist) {
            $res['status_code'] = 0;
            $res['message'] = "Already Submitted";

            return is_mobile($type, "", $res);
        }

        $user_plans = array();

        $allowedfileExtension = ['jpeg', 'jpg', 'png'];

        $pass_front_file = $request->file('address_proof');

        if (isset($pass_front_file)) {
            $filename = $pass_front_file->getClientOriginalName();
            $extension = $pass_front_file->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);
            if (!$check) {
                $res['status_code'] = 0;
                $res['message'] = "Only jpeg and png files are supported ";

                return is_mobile($type, "", $res);
            }

            $pass_front_file_name = "";
            if ($request->hasFile('address_proof')) {
                $pass_front_file = $request->file('address_proof');
                $originalname = $pass_front_file->getClientOriginalName();
                $og_name = "address_proof" . '_' . date('YmdHis');
                $ext = \File::extension($originalname);
                $pass_front_file_name = $og_name . '.' . $ext;
                $path = $pass_front_file->storeAs('public/', $pass_front_file_name);
                $user_plans['address_proof'] = $pass_front_file_name;
            }
        }
        $pass_back_file = $request->file('photo');

        if (isset($pass_back_file)) {
            $filename = $pass_back_file->getClientOriginalName();
            $extension = $pass_back_file->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);

            if (!$check) {
                $res['status_code'] = 0;
                $res['message'] = "Only jpeg and png files are supported ";

                return is_mobile($type, "", $res);
            }

            $pass_back_file_name = "";
            if ($request->hasFile('photo')) {
                $pass_back_file = $request->file('photo');
                $originalname = $pass_back_file->getClientOriginalName();
                $og_name = "photo" . '_' . date('YmdHis');
                $ext = \File::extension($originalname);
                $pass_back_file_name = $og_name . '.' . $ext;
                $path = $pass_back_file->storeAs('public/', $pass_back_file_name);
                $user_plans['user_photo'] = $pass_back_file_name;
            }
        }

        $user_plans['user_id'] = $user_id;
        $user_plans['firstname'] = $name;
        $user_plans['whatapp_num'] = $mobile;
        $user_plans['email'] = $email;
        $user_plans['rank'] = $rank;
        $user_plans['event'] = 'Delhi Event 17 August';
        user_stablebond_details::insert($user_plans);

        $res['status_code'] = 1;
        $res['message'] = "Details Added Successfully";

        return is_mobile($type, "", $res);
    }

    public function getTeamBusiness(Request $request)
    {
        $userId = $request->input("user_id");

        $coinPrice = coinPrice();
        
        $otherLegs = usersModel::selectRaw("IFNULL((my_business),0) as my_business, users.id")
                                        ->leftJoin('user_plans', 'user_plans.user_id', '=', 'users.id')
                                        ->where('users.sponser_id', $userId)
                                        ->groupBy('users.id')
                                        ->get()
                                        ->toArray();

        $strongBusiness = 0;
        $weakBusiness = 0;
        // echo "<pre>"; print_r($otherLegs);
        if (!empty($otherLegs)) {
            // sort descending by leg business
            usort($otherLegs, fn($a, $b) => $b['my_business'] <=> $a['my_business']);
            // echo "<pre>"; print_r($otherLegs);
            foreach ($otherLegs as $index => $leg) {
                $userPlansAmount = userPlansModel::where('user_id', $leg['id'])
                                                    ->whereRaw("roi > 0")
                                                    ->sum('amount');
                // echo "User id:".$leg['id'].", Sum=".$userPlansAmount."<br>".PHP_EOL;
                $claimedRewards = withdrawModel::where('user_id', $leg['id'])
                                                    ->where('withdraw_type', 'UNSTAKE')
                                                    ->sum('amount');
                // echo "claimedRewards:".$claimedRewards."<br>".PHP_EOL;
                $legBusiness = ($leg['my_business'] + $userPlansAmount - $claimedRewards) * $coinPrice;
                // echo "coinPrice=".$coinPrice."<br>".PHP_EOL;
                // echo "legBusiness:".$legBusiness."<br>".PHP_EOL;
                
                if ($legBusiness < 0) $legBusiness = 0;

                if ($index === 0) 
                {
                    $strongBusiness = $legBusiness;
                } 
                else 
                {
                    $weakBusiness += $legBusiness;
                }
            }
        }

        return ['strong' => $strongBusiness, 'weak' => $weakBusiness];
    }

}
