<?php

namespace App\Http\Controllers;

use App\Models\earningLogsModel;
use App\Models\packageModel;
use App\Models\packageTransaction;
use App\Models\pay9Model;
use App\Models\settingModel;
use App\Models\userPlansModel;
use App\Models\usersModel;
use App\Models\user_stablebond_details;
use App\Models\withdrawModel;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use function App\Helpers\is_mobile;
use function App\Helpers\unstakedAmount;
use function App\Helpers\coinPrice;
use function App\Helpers\getUserStakeAmount;
use function App\Helpers\getUserStakedAmountTVL;

use function App\Helpers\unstakedAmountContractStackeid;
use function App\Helpers\claimRoiAmountContractStackeid;

use App\Models\roiReleaseVestingModel;

class packagesController extends Controller
{


    public $lpMatrix = [
                            1 => ['min_amount'=>100, 'roi_daily_pct'=>0.70, 'duration_days'=>45, 'benifit'=>[95,100]],
                            2 => ['min_amount'=>100, 'roi_daily_pct'=>0.80, 'duration_days'=>90, 'benifit'=>[90,100]],
                            3 => ['min_amount'=>100, 'roi_daily_pct'=>0.90, 'duration_days'=>180, 'benifit'=>[85,100]],
                            4 => ['min_amount'=>100, 'roi_daily_pct'=>1.00, 'duration_days'=>360, 'benifit'=>[80,100]],
                        ];

    public $stableMatrix = [
                                1 => ['roi_daily_pct'=>0.70, 'duration_days'=>45],
                                2 => ['roi_daily_pct'=>0.80, 'duration_days'=>90],
                                3 => ['roi_daily_pct'=>0.90, 'duration_days'=>180],
                                4 => ['roi_daily_pct'=>1.00, 'duration_days'=>360],
                            ];

    public function index(Request $request)
    {
        $type = $request->input('type');
        $user_id = $request->session()->get('user_id');
        $withdraw = withdrawModel::where(['user_id' => $user_id,'withdraw_type'=>'UNSTAKE','package_id'=>1])->orderBy('id', 'desc')->get()->toArray();

        $user = usersModel::where(['id' => $user_id])->get()->toArray();
        $packages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'desc')->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Activate package by TOPUP 9 Pay.";
        $res['topup_balance'] = $user['0']['topup_balance'];
        $res['packages'] = $packages;
        $res['withdraw'] = $withdraw;
        $res['user'] = $user['0'];
        $res['form_code'] = $user_id . date('YmdHis');

        return is_mobile($type, "", $res, "view");
    }

    // public function stake(Request $request)
    // {
    //     Log::info("This is an info message");
    //     $type = $request->input('type');
    //     // $user_id = $request->session()->get('user_id');
    //     if($type == "API")
    //     {
    //         $user_id = $request->input("user_id");
    //     }else
    //     {
    //         $user_id = $request->session()->get("user_id");
    //     }

    //     $package_id = $request->input("package_id");
    //     $package_ids = explode(",",$package_id);

    //     $user = usersModel::where(['id' => $user_id])->get()->toArray();

    //     if(empty($user))
    //     {
    //         $res['status'] = 'success';
    //         $res['message'] = 'No user founds';
    //         return is_mobile($type, "", $res, "view");
    //     }

    //     $withdraw = withdrawModel::where(['user_id' => $user_id,'withdraw_type'=>'UNSTAKE'])->whereIn('package_id', $package_ids)->orderBy('id', 'desc')->get()->toArray();

    //     $earningsGeneratedAccordingToWithdraw = array();

    //     $lastWithdrawDate = 0;

    //     foreach($withdraw as $key => $value)
    //     {
    //         $lastWithdrawDate = isset($withdraw[$key+1]['created_on']) ? $withdraw[$key+1]['created_on'] : 0;
    //         $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")->where(['user_id' => $user_id])->where('created_on', '<=', $value['created_on'])->where('created_on', '>', $lastWithdrawDate)->where('tag', '=', 'ROI')->get()->toArray();
            
    //         array_push($earningsGeneratedAccordingToWithdraw, $tempEarnings['0']['amount']);

    //     }

    //     if ($user_id == 1) {
    //         $sponser = usersModel::where(['id' => 1])->get()->toArray();
    //     } else {
    //         $sponser = usersModel::where(['id' => $user['0']['sponser_id']])->get()->toArray();
    //     }

    //     $packages = userPlansModel::where(['user_id' => $user_id])->whereIn('package_id', $package_ids)->orderBy('id', 'desc')->get()->toArray();

    //     $totalStakedAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")->get()->toArray();

    //     // dd($totalStakedAmount); 
    //     // 4118687.0821692

    //     $staked_amount = 0;
    //     $compound_amount = 0;
    //     // R1
    //     $unstaked = 0;
    //     $claimedROI = 0;
    //     foreach ($packages as $k => $v) {
    //         $staked_amount += $v['amount'];
    //         $compound_amount += ($v['amount'] + $v['compound_amount']);

    //         // New code start to get data in API response :: shikhar
    //         $unstakeWithdraws = withdrawModel::where(['user_id' => $user_id,'withdraw_type'=>'UNSTAKE','contract_stakeid'=>$v['contract_stakeid'], 'status' => 1])->orderBy('id', 'desc')->get()->toArray(); //'package_id'=>$v['package_id'],
    //         $unstakeSum = array_sum(array_column($unstakeWithdraws, 'amount'));

    //         $roiWithdraws = withdrawModel::where(['user_id' => $user_id,'withdraw_type'=>'CLAIMROI','contract_stakeid'=>$v['contract_stakeid'], 'status' => 1])->orderBy('id', 'desc')->get()->toArray(); //'package_id'=>$v['package_id'],
    //         $roiSum = array_sum(array_column($roiWithdraws, 'amount'));

    //         $packages[$k]['unstaked_amount'] = $unstakeSum;
    //         $packages[$k]['claimed_amount'] = $roiSum;
    //         $packages[$k]['last_claim_date'] = $roiWithdraws[0]['created_on'] ?? null; 

    //         // $packages[$k]['remain_roi_amount'] = $staked_amount - $roiSum;

    //         // New code end to get data in API response :: shikhar

    //         // R1 New code begin :: shikhar
    //         $unstaked += unstakedAmountContractStackeid($v['user_id'], 1, $v['contract_stakeid']);//$v['package_id']
    //         $claimedROI += claimRoiAmountContractStackeid($v['user_id'], 1, $v['contract_stakeid']);//$v['package_id']
    //         // R1 New code end :: shikhar
    //     }

    //     // dd($staked_amount, $compound_amount); 
    //     // 1010 
    //     // 1338.4950351279 

    //     $generatedRoi = earningLogsModel::selectRaw("IFNULL(SUM(amount),0) as amount")
    //         ->where('tag', '=', 'ROI')
    //         ->where('refrence_id', '=', '1')
    //         ->where('user_id', '=', $user_id)
    //         ->get()
    //         ->toArray();

    //     // dd($generatedRoi); 
    //     // 328.495035127899487220

    //     $totalUnstakeAmount = 0;

    //     foreach($withdraw as $key => $value)
    //     {
    //         if($value['status'] == 1)
    //         {
    //             $totalUnstakeAmount += $value['amount'];
    //         }
    //     }

    //     // dd($totalUnstakeAmount);
    //     // 20.0

    //     if($totalUnstakeAmount > $staked_amount)
    //     {
    //         $staked_amount = 0;
    //     }else
    //     {
    //         $staked_amount = ($staked_amount - $totalUnstakeAmount);
    //     }

    //     // dd($staked_amount);
    //     // 990.0

    //     $unstakeAmount = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])->whereIn('package_id', $package_ids)->get()->toArray();
    //     $withdrawMeta = withdrawModel::selectRaw("amount, created_on, package_id")->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])->whereIn('package_id', $package_ids)->orderBy('id', 'asc')->get()->toArray();

    //     $tempUSA = 0;
        
    //     $activeStake = 0;

    //     $lastCreatedOn = 0;

    //     $extraAmountLeft = 0;
    //     $totalCompoundAmount = 0;
    //     // R1
    //     $unstaked = 0;
    //     $claimedROI = 0;
    //     foreach($withdrawMeta as $key => $value)
    //     {
    //         $tempPackages = userPlansModel::where(['user_id' => $user_id])->where('created_on', '<=', $value['created_on'])->where('created_on', '>=', $lastCreatedOn)->where('package_id', $value['package_id'])->orderBy('id', 'asc')->get()->toArray();

    //         $totalPackageAmount = 0;

    //         foreach($tempPackages as $key => $valuePackage) {
    //             $totalPackageAmount += ($valuePackage['amount']);
    //             $activeStake += ($valuePackage['amount']);
    //         }

    //         $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")->where(['user_id' => $user_id])->where('created_on', '<=', $value['created_on'])->where('created_on', '>', $lastCreatedOn)->where('tag', '=', 'ROI')->where('refrence_id', 1)->get()->toArray();
    //         $totalCompoundAmount += ($tempEarnings['0']['amount']);

    //         if ($value['amount'] <= ($totalCompoundAmount)) {
    //             $totalCompoundAmount -= ($value['amount']);
    //         } else if ($value['amount'] > ($totalCompoundAmount)) {
    //             $activeStake -= ($value['amount'] - ($totalCompoundAmount));
    //             $totalCompoundAmount = 0;
    //         }

    //         $lastCreatedOn = $value['created_on'];
    //     }

    //     if (count($withdrawMeta) == 0) {
    //         $tempPackages = userPlansModel::where(['user_id' => $user_id])->whereIn('package_id', $package_ids)->orderBy('id', 'asc')->get()->toArray();
    //         foreach($tempPackages as $key => $valuePackage) {
    //             $activeStake += ($valuePackage['amount']);
    //         }
    //     } else {
    //         $tempPackagesAfter = userPlansModel::where(['user_id' => $user_id])->whereIn('package_id', $package_ids)->where('created_on', '>', $lastCreatedOn)->orderBy('id', 'asc')->get()->toArray();
    //         foreach($tempPackagesAfter as $key => $valuePackage) {
    //             $activeStake += ($valuePackage['amount']);
    //         }
    //     }

    //     /*if(count($packages) > 0)
    //     {
    //         if($activeStake < 1)
    //         {
    //             $res['status_code'] = 0;
    //             $res['message'] = "You're not eligible for Regular Staking, Please Stake in Bonds.";

    //             return is_mobile($type, "lpbonds", $res);
    //         }
    //     }*/

    //     $res['status_code'] = 1;
    //     $res['message'] = "Activate package by TOPUP 9 Pay.";
    //     $res['topup_balance'] = $user['0']['topup_balance'];
    //     $res['packages'] = $packages;
    //     $res['withdraw'] = $withdraw;
    //     $res['earnings'] = $earningsGeneratedAccordingToWithdraw;
    //     $res['user'] = $user['0'];
    //     $res['sponser'] = $sponser['0'];
    //     $res['form_code'] = $user_id . date('YmdHis');
    //     $res['total_staked_amount'] = $totalStakedAmount['0']['amount'];
    //     $res['staked_amount'] = $activeStake;
    //     $res['compound_amount'] = $compound_amount;
    //     $res['total_unstake_amount'] = $totalUnstakeAmount;
    //     $res['generated_roi'] = $generatedRoi['0']['amount'];
    //     $res['coinPrice'] = coinPrice();

    //     if (count($packages) > 0) {
    //         $lastStake = $packages['0'];
    //         $res['last_stake'] = $lastStake;
    //         $createdOn = new DateTime($lastStake['created_on']); // e.g., '2024-06-01'
    //         $today = new DateTime(); // current date and time

    //         $interval = $createdOn->diff($today);

    //         // Get total days difference
    //         $res['last_stake_days'] = $interval->days;
    //     }

    //     $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
    //     ->where('user_id', '=', $user_id)
    //     ->whereIn('package_id', $package_ids)
    //     ->first(); // Use first() to fetch only one result

    //     // dd($claimedRewards);
    //     // "amount" => 20.0

    //     $res['claim_roi'] = $claimedRewards->amount;
        
    //     // R1 New code begin :: shikhar
    //     $res['claimed_rewards'] = $unstaked + $claimedROI; 
    //     // R1 New code end :: shikhar
    //     // $res['claimed_rewards'] = unstakedAmount($user_id, "1"); //$claimedRewards['0']['amount'];

        
    //     // dd($res['claimed_rewards']);
    //     // 20.0

    //     $checkPendingTransaction = packageTransaction::where(['user_id' => $user_id, 'isSynced' => 0, 'package_id' => $package_id])->whereRaw("transaction_hash != 'By Other'")->get()->toArray();
    //     // dd( $checkPendingTransaction);
    //     // []

    //     if (count($checkPendingTransaction) > 0) {
    //         $res['confirmTransactionWindow'] = 1;
    //         $res['pending_amount'] = $checkPendingTransaction['0']['amount'];
    //         $res['pending_transaction_hash'] = $checkPendingTransaction['0']['transaction_hash'];
    //         $res['pending_package_id'] = $checkPendingTransaction['0']['package_id'];
    //         $res['pending_package_amount'] = $checkPendingTransaction['0']['amount'];
    //     }
        

    //     // echo "OUTPUT: <pre>"; print_r($res); echo "</pre>";
    //     return is_mobile($type, "", $res, "view");
    // }

    public function stake(Request $request)
    {
        $type = $request->input('type');
        // $user_id = $request->session()->get('user_id');
        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }

        $package_id = $request->input("package_id");
        $package_ids = explode(",",$package_id);

        $user = usersModel::where(['id' => $user_id])->get()->toArray();

        if(empty($user))
        {
            $res['status'] = 'success';
            $res['message'] = 'No user founds';
            return is_mobile($type, "", $res, "view");
        }

        $withdraw = withdrawModel::where(['user_id' => $user_id,'withdraw_type'=>'UNSTAKE'])->whereIn('package_id', $package_ids)->orderBy('id', 'desc')->get()->toArray();

        $earningsGeneratedAccordingToWithdraw = array();

        $lastWithdrawDate = 0;

        foreach($withdraw as $key => $value)
        {
            $lastWithdrawDate = isset($withdraw[$key+1]['created_on']) ? $withdraw[$key+1]['created_on'] : 0;
            $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")->where(['user_id' => $user_id])->where('created_on', '<=', $value['created_on'])->where('created_on', '>', $lastWithdrawDate)->where('tag', '=', 'ROI')->get()->toArray();
            
            array_push($earningsGeneratedAccordingToWithdraw, $tempEarnings['0']['amount']);

        }

        if ($user_id == 1) {
            $sponser = usersModel::where(['id' => 1])->get()->toArray();
        } else {
            $sponser = usersModel::where(['id' => $user['0']['sponser_id']])->get()->toArray();
        }

        $packages = userPlansModel::where(['user_id' => $user_id])->whereIn('package_id', $package_ids)->orderBy('id', 'desc')->get()->toArray();

        $totalStakedAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")->get()->toArray();

        // dd($totalStakedAmount); 
        // 4118687.0821692

        $staked_amount = 0;
        $compound_amount = 0;

        foreach ($packages as $k => $v) {
            $staked_amount += $v['amount'];
            $compound_amount += ($v['amount'] + $v['compound_amount']);

            // New code start to get data in API response :: shikhar
            $unstakeWithdraws = withdrawModel::where(['user_id' => $user_id,'withdraw_type'=>'UNSTAKE','contract_stakeid'=>$v['contract_stakeid'], 'status' => 1, 'package_id' => $v['package_id']])->orderBy('id', 'desc')->get()->toArray(); //'package_id'=>$v['package_id'],
            $unstakeSum = array_sum(array_column($unstakeWithdraws, 'amount'));

            $roiWithdraws = withdrawModel::where(['user_id' => $user_id,'withdraw_type'=>'CLAIMROI','contract_stakeid'=>$v['contract_stakeid'], 'status' => 1, 'package_id' => $v['package_id']])->orderBy('id', 'desc')->get()->toArray(); //'package_id'=>$v['package_id'],
            $roiSum = array_sum(array_column($roiWithdraws, 'amount'));

            $packages[$k]['unstaked_amount'] = $unstakeSum;
            $packages[$k]['claimed_amount'] = $roiSum;
            $packages[$k]['last_claim_date'] = $roiWithdraws[0]['created_on'] ?? null; 

            // $packages[$k]['remain_roi_amount'] = $staked_amount - $roiSum;

            // New code end to get data in API response :: shikhar
        }

        // dd($staked_amount, $compound_amount); 
        // 1010 
        // 1338.4950351279 

        $generatedRoi = earningLogsModel::selectRaw("IFNULL(SUM(amount),0) as amount")
            ->where('tag', '=', 'ROI')
            ->where('refrence_id', '=', '1')
            ->where('user_id', '=', $user_id)
            ->get()
            ->toArray();

        // dd($generatedRoi); 
        // 328.495035127899487220

        $totalUnstakeAmount = 0;

        foreach($withdraw as $key => $value)
        {
            if($value['status'] == 1)
            {
                $totalUnstakeAmount += $value['amount'];
            }
        }

        // dd($totalUnstakeAmount);
        // 20.0

        if($totalUnstakeAmount > $staked_amount)
        {
            $staked_amount = 0;
        }else
        {
            $staked_amount = ($staked_amount - $totalUnstakeAmount);
        }

        // dd($staked_amount);
        // 990.0

        $unstakeAmount = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])->whereIn('package_id', $package_ids)->get()->toArray();
        $withdrawMeta = withdrawModel::selectRaw("amount, created_on, package_id")->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE'])->whereIn('package_id', $package_ids)->orderBy('id', 'asc')->get()->toArray();

        $tempUSA = 0;
        
        $activeStake = 0;

        $lastCreatedOn = 0;

        $extraAmountLeft = 0;
        $totalCompoundAmount = 0;
        
        foreach($withdrawMeta as $key => $value)
        {
            $tempPackages = userPlansModel::where(['user_id' => $user_id])->where('created_on', '<=', $value['created_on'])->where('created_on', '>=', $lastCreatedOn)->where('package_id', $value['package_id'])->orderBy('id', 'asc')->get()->toArray();

            $totalPackageAmount = 0;

            foreach($tempPackages as $key => $valuePackage) {
                $totalPackageAmount += ($valuePackage['amount']);
                $activeStake += ($valuePackage['amount']);
            }

            $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")->where(['user_id' => $user_id])->where('created_on', '<=', $value['created_on'])->where('created_on', '>', $lastCreatedOn)->where('tag', '=', 'ROI')->where('refrence_id', 1)->get()->toArray();
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
            $tempPackages = userPlansModel::where(['user_id' => $user_id])->whereIn('package_id', $package_ids)->orderBy('id', 'asc')->get()->toArray();
            foreach($tempPackages as $key => $valuePackage) {
                $activeStake += ($valuePackage['amount']);
            }
        } else {
            $tempPackagesAfter = userPlansModel::where(['user_id' => $user_id])->whereIn('package_id', $package_ids)->where('created_on', '>', $lastCreatedOn)->orderBy('id', 'asc')->get()->toArray();
            foreach($tempPackagesAfter as $key => $valuePackage) {
                $activeStake += ($valuePackage['amount']);
            }
        }

        /*if(count($packages) > 0)
        {
            if($activeStake < 1)
            {
                $res['status_code'] = 0;
                $res['message'] = "You're not eligible for Regular Staking, Please Stake in Bonds.";

                return is_mobile($type, "lpbonds", $res);
            }
        }*/

        $res['status_code'] = 1;
        $res['message'] = "Activate package by TOPUP 9 Pay.";
        $res['topup_balance'] = $user['0']['topup_balance'];
        $res['packages'] = $packages;
        $res['withdraw'] = $withdraw;
        $res['earnings'] = $earningsGeneratedAccordingToWithdraw;
        $res['user'] = $user['0'];
        $res['sponser'] = $sponser['0'];
        $res['form_code'] = $user_id . date('YmdHis');
        $res['total_staked_amount'] = $totalStakedAmount['0']['amount'];
        $res['staked_amount'] = $activeStake;
        $res['compound_amount'] = $compound_amount;
        $res['total_unstake_amount'] = $totalUnstakeAmount;
        $res['generated_roi'] = $generatedRoi['0']['amount'];
        $res['coinPrice'] = coinPrice();

        if (count($packages) > 0) {
            $lastStake = $packages['0'];
            $res['last_stake'] = $lastStake;
            $createdOn = new DateTime($lastStake['created_on']); // e.g., '2024-06-01'
            $today = new DateTime(); // current date and time

            $interval = $createdOn->diff($today);

            // Get total days difference
            $res['last_stake_days'] = $interval->days;
        }

        $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
        ->where('user_id', '=', $user_id)
        ->whereIn('package_id', $package_ids)
        ->first(); // Use first() to fetch only one result

        // dd($claimedRewards);
        // "amount" => 20.0

        $res['claim_roi'] = $claimedRewards->amount;
        $res['claimed_rewards'] = unstakedAmount($user_id, "1"); //$claimedRewards['0']['amount'];
        
        // dd($res['claimed_rewards']);
        // 20.0

        $checkPendingTransaction = packageTransaction::where(['user_id' => $user_id, 'isSynced' => 0, 'package_id' => $package_id])->whereRaw("transaction_hash != 'By Other'")->get()->toArray();
        // dd( $checkPendingTransaction);
        // []

        if (count($checkPendingTransaction) > 0) {
            $res['confirmTransactionWindow'] = 1;
            $res['pending_amount'] = $checkPendingTransaction['0']['amount'];
            $res['pending_transaction_hash'] = $checkPendingTransaction['0']['transaction_hash'];
            $res['pending_package_id'] = $checkPendingTransaction['0']['package_id'];
            $res['pending_package_amount'] = $checkPendingTransaction['0']['amount'];
        }

        // echo "OUTPUT: <pre>"; print_r($res); echo "</pre>";
        return is_mobile($type, "", $res, "view");
    }

    public function lpbonds(Request $request)
    {
        $request->setLaravelSession(app('session')->driver());
        $type = $request->input('type');
        // $user_id = $request->session()->get('user_id');
        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }

        $user = usersModel::where(['id' => $user_id])->get()->toArray();

        if ($user_id == 1) {
            $sponser = usersModel::where(['id' => 1])->get()->toArray();
        } else {
            $sponser = usersModel::where(['id' => $user['0']['sponser_id']])->get()->toArray();
        }

        $packages = userPlansModel::where(['user_id' => $user_id, 'package_id' => 2])->orderBy('id', 'desc')->get()->toArray();

        $withdraw = withdrawModel::where(['user_id' => $user_id,'withdraw_type'=>'UNSTAKE','package_id'=>2])->orderBy('id', 'desc')->get()->toArray();
        
        $earningsGeneratedAccordingToWithdraw = array();

        $lastWithdrawDate = 0;

        foreach($withdraw as $key => $value)
        {
            $lastWithdrawDate = isset($withdraw[$key+1]['created_on']) ? $withdraw[$key+1]['created_on'] : 0;
            $tempEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as amount")->where(['user_id' => $user_id])->where('created_on', '<=', $value['created_on'])->where('created_on', '>', $lastWithdrawDate)->where('tag', '=', 'ROI')->get()->toArray();
            array_push($earningsGeneratedAccordingToWithdraw, $tempEarnings['0']['amount']);
        }

        $totalStakedAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")->get()->toArray();

        $staked_amount = 0;
        $compound_amount = 0;
        // R2
        $unstaked=0;
        $claimedROI=0;
        foreach ($packages as $k => $v) {
            $staked_amount += $v['amount'];
            $compound_amount += ($v['amount'] + $v['compound_amount']);

            // R2 New code begin :: shikhar
            $unstaked += unstakedAmountContractStackeid($v['user_id'], 2, $v['contract_stakeid']); //$v['package_id']
            $claimedROI += claimRoiAmountContractStackeid($v['user_id'], 2, $v['contract_stakeid']);//$v['package_id']
            // R2 New code end :: shikhar
        }

        $generatedRoi = earningLogsModel::selectRaw("IFNULL(SUM(amount),0) as amount")
            ->where('tag', '=', 'ROI')
            ->where('refrence_id', '=', '2')
            ->where('user_id', '=', $user_id)
            ->get()
            ->toArray();

        $totalUnstakeAmount = 0;

        foreach($withdraw as $key => $value)
        {
            if($value['status'] == 1)
            {
                $totalUnstakeAmount += $value['amount'];
            }
        }

        if($totalUnstakeAmount > $staked_amount)
        {
            $staked_amount = 0;
        }else
        {
            $staked_amount = ($staked_amount - $totalUnstakeAmount);
        }

        $unstakeAmount = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE','package_id' => 2])->get()->toArray();

        $tempPackages = userPlansModel::where(['user_id' => $user_id, 'package_id' => 2])->orderBy('id', 'asc')->get()->toArray();

        $tempUSA = $unstakeAmount['0']['total_withdraw'];

        $activeStake = 0;
        
        foreach($tempPackages as $key => $value)
        {
            $tempUSA -= ($value['amount'] - $value['compound_amount']);

            if($tempUSA < 1)
            {
                $activeStake += $value['amount'];
            }
        }

        $res['status_code'] = 1;
        $res['message'] = "Activate package by TOPUP 9 Pay.";
        $res['topup_balance'] = $user['0']['topup_balance'];
        $res['packages'] = $packages;
        $res['withdraw'] = $withdraw;
        $res['earnings'] = $earningsGeneratedAccordingToWithdraw;
        $res['user'] = $user['0'];
        $res['sponser'] = $sponser['0'];
        $res['form_code'] = $user_id . date('YmdHis');
        $res['total_staked_amount'] = $totalStakedAmount['0']['amount'];
        $res['staked_amount'] = $activeStake;
        $res['compound_amount'] = $compound_amount;
        $res['total_unstake_amount'] = $totalUnstakeAmount;
        $res['generated_roi'] = $generatedRoi['0']['amount'];
        $res['coinPrice'] = coinPrice();

        if (count($packages) > 0) {
            $lastStake = $packages['0'];
            $res['last_stake'] = $lastStake;
            $createdOn = new DateTime($lastStake['created_on']); // e.g., '2024-06-01'
            $today = new DateTime(); // current date and time

            $interval = $createdOn->diff($today);

            // Get total days difference
            $res['last_stake_days'] = $interval->days;
        }

        $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
        ->where('user_id', '=', $user_id)
        ->where('package_id', 2)
        ->first(); // Use first() to fetch only one result

        $res['claim_roi'] = $claimedRewards->amount;

        // R2 New code begin :: shikhar
        $res['claimed_rewards'] = $unstaked + $claimedROI;
        // R2 New code end :: shikhar

        // $res['claimed_rewards'] = unstakedAmount($user_id, "2");

        $checkPendingTransaction = packageTransaction::where(['user_id' => $user_id, 'isSynced' => 0, 'package_id' => 2])->whereRaw("transaction_hash != 'By Other'")->get()->toArray();

        if (count($checkPendingTransaction) > 0) {
            $res['confirmTransactionWindow'] = 1;
            $res['pending_amount'] = $checkPendingTransaction['0']['amount'];
            $res['pending_transaction_hash'] = $checkPendingTransaction['0']['transaction_hash'];
            $res['pending_package_id'] = $checkPendingTransaction['0']['package_id'];
            $res['pending_package_amount'] = $checkPendingTransaction['0']['amount'];
        }
  
        return is_mobile($type, "", $res, "view");
    }

    public function stablebonds(Request $request)
    {
        $type = $request->input('type');
        // $user_id = $request->session()->get('user_id');
        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }

        $user = usersModel::where(['id' => $user_id])->get()->toArray();

        if ($user_id == 1) {
            $sponser = usersModel::where(['id' => 1])->get()->toArray();
        } else {
            $sponser = usersModel::where(['id' => $user['0']['sponser_id']])->get()->toArray();
        }

        $packages = userPlansModel::where(['user_id' => $user_id, 'package_id' => 3])->orderBy('id', 'desc')->get()->toArray();

        $withdraw = withdrawModel::where(['user_id' => $user_id,'withdraw_type'=>'UNSTAKE','package_id'=>3])->orderBy('id', 'desc')->get()->toArray();

        $totalStakedAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")->get()->toArray();

        $staked_amount = 0;
        $compound_amount = 0;
        // R3
        $unstaked = 0;
        $claimedROI = 0;
        foreach ($packages as $k => $v) {
            $staked_amount += $v['amount'];
            $compound_amount += ($v['amount'] + $v['compound_amount']);

            // R3 New code begin :: shikhar
            $unstaked += unstakedAmountContractStackeid($v['user_id'], 3, $v['contract_stakeid']); //$v['package_id']
            $claimedROI += claimRoiAmountContractStackeid($v['user_id'], 3, $v['contract_stakeid']);//$v['package_id']
            // R3 New code end :: shikhar
        }

        $generatedRoi = earningLogsModel::selectRaw("IFNULL(SUM(amount),0) as amount")
            ->where('tag', '=', 'ROI')
            ->where('refrence_id', '=', '3')
            ->where('user_id', '=', $user_id)
            ->get()
            ->toArray();            

        $totalUnstakeAmount = 0;

        foreach($withdraw as $key => $value)
        {
            if($value['status'] == 1)
            {
                $totalUnstakeAmount += $value['amount'];
            }
        }

        if($totalUnstakeAmount > $staked_amount)
        {
            $staked_amount = 0;
        }else
        {
            $staked_amount = ($staked_amount - $totalUnstakeAmount);
        }

        $unstakeAmount = withdrawModel::selectRaw("IFNULL(SUM(amount),0) as total_withdraw")->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => 'UNSTAKE','package_id' => 3])->get()->toArray();

        $tempPackages = userPlansModel::where(['user_id' => $user_id, 'package_id' => 3])->orderBy('id', 'asc')->get()->toArray();

        $tempUSA = $unstakeAmount['0']['total_withdraw'];

        $activeStake = 0;

        foreach($tempPackages as $key => $value)
        {
            $tempUSA -= ($value['amount'] - $value['compound_amount']);

            if($tempUSA < 1)
            {
                $activeStake += $value['amount'];
            }
        }

        $res['status_code'] = 1;
        $res['message'] = "Activate package by TOPUP 9 Pay.";
        $res['topup_balance'] = $user['0']['topup_balance'];
        $res['packages'] = $packages;
        $res['withdraw'] = $withdraw;
        $res['user'] = $user['0'];
        $res['sponser'] = $sponser['0'];
        $res['form_code'] = $user_id . date('YmdHis');
        $res['total_staked_amount'] = $totalStakedAmount['0']['amount'];
        $res['staked_amount'] = $staked_amount;
        $res['compound_amount'] = $compound_amount;
        $res['total_unstake_amount'] = $totalUnstakeAmount;
        $res['generated_roi'] = $generatedRoi['0']['amount'];
        $res['coinPrice'] = coinPrice();

        if (count($packages) > 0) {
            $lastStake = $packages['0'];
            $res['last_stake'] = $lastStake;
            $createdOn = new DateTime($lastStake['created_on']); // e.g., '2024-06-01'
            $today = new DateTime(); // current date and time

            $interval = $createdOn->diff($today);

            // Get total days difference
            $res['last_stake_days'] = $interval->days;
        }

        $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
        ->where('user_id', '=', $user_id)
        ->where('package_id', 3)
        ->first(); // Use first() to fetch only one result

        $res['claim_roi'] = $claimedRewards->amount;
        // R3 New code begin :: shikhar
        $res['claimed_rewards'] = $unstaked+$claimedROI;
        // R3 New code end :: shikhar
        
        // $res['claimed_rewards'] = unstakedAmount($user_id, "3");

        $checkPendingTransaction = packageTransaction::where(['user_id' => $user_id, 'isSynced' => 0, 'package_id' => 3])->whereRaw("transaction_hash != 'By Other'")->get()->toArray();

        if (count($checkPendingTransaction) > 0) {
            $res['confirmTransactionWindow'] = 1;
            $res['pending_amount'] = $checkPendingTransaction['0']['amount'];
            $res['pending_transaction_hash'] = $checkPendingTransaction['0']['transaction_hash'];
            $res['pending_package_id'] = $checkPendingTransaction['0']['package_id'];
            $res['pending_package_amount'] = $checkPendingTransaction['0']['amount'];
        }

        $thailandBonanza = userPlansModel::where('package_id', 3)
                    ->where('user_id', $user_id)
                    ->where('lock_period', '>', 1)
                    ->where('created_on', '>=', '2025-09-01 16:30:01')
                    ->get();

        $bonanzaArray = array();

        $bonanzaDetails['360']['total'] = 30000;
        $bonanzaDetails['180']['total'] = 15000;
        $bonanzaDetails['90']['total'] = 5000;
        $bonanzaDetails['45']['total'] = 3000;

        $bonanzaDetails['360']['name'] = "Pro Executive Access";
        $bonanzaDetails['180']['name'] = "Executive Access";
        $bonanzaDetails['90']['name'] = "Classic Staker";
        $bonanzaDetails['45']['name'] = "Mega Event Traveller";

        foreach($thailandBonanza as $key => $value)
        {
            $bonanzaArray[$value['lock_period']]['amount'] = ($bonanzaArray[$value['lock_period']]['amount'] ?? 0) + ($value['amount'] * $value['coin_price']);
            $bonanzaArray[$value['lock_period']]['total'] = $bonanzaDetails[$value['lock_period']]['total'];
            $bonanzaArray[$value['lock_period']]['name'] = $bonanzaDetails[$value['lock_period']]['name'];
        }
        $user_stablebond_details= user_stablebond_details::where('user_id',$user_id)->get();

        $res['bonanza'] = $bonanzaArray;
        $res['user_stablebond_details'] = $user_stablebond_details;

        return is_mobile($type, "", $res, "view");
    }

    public function topup9pay(Request $request)
    {
        $type = $request->input("type");
        $user_id = $request->session()->get("user_id");

        $user = usersModel::where(["id" => $user_id])->get()->toArray();

        if (empty($user['0']['pg_evm_json'])) {
            $evm_tss = "https://api.9pay.co/get-eth-wallet/ninepaytest-" . $user_id . "-" . $user['0']['refferal_code'] . "/eth";

            $getTss = file_get_contents($evm_tss);

            $finalTss = json_decode($getTss, true);

            usersModel::where(['id' => $user_id])->update(['pg_evm_json' => $finalTss]);
        }

        if (empty($user['0']['pg_trc_json'])) {
            $trc_tss = "https://api.9pay.co/get-tron-wallet/ninepaytest-" . $user_id . "-" . $user['0']['refferal_code'];

            $getTss = file_get_contents($trc_tss);

            $finalTss = json_decode($getTss, true);

            usersModel::where(['id' => $user_id])->update(['pg_trc_json' => $finalTss]);
        }

        $user = usersModel::where(['id' => $user_id])->get()->toArray();

        $evmAddress = json_decode($user['0']['pg_evm_json'], true);
        $trcAddress = json_decode($user['0']['pg_trc_json'], true);

        $evmqrCode = QrCode::size(240)->generate($evmAddress['address']);
        $trcqrCode = QrCode::size(240)->generate($trcAddress['address']);

        $res['status_code'] = 1;
        $res['message'] = "Package fetched successfully";
        $res['evm_address'] = $evmAddress['address'];
        $res['trc_address'] = $trcAddress['address'];
        $res['evmqrCode'] = $evmqrCode;
        $res['trcqrCode'] = $trcqrCode;

        $checkPendingTransaction = packageTransaction::where(['user_id' => $user_id, 'isSynced' => 0])->get()->toArray();

        if (count($checkPendingTransaction) > 0) {
            $res['confirmTransactionWindow'] = 1;
            $res['pending_amount'] = $checkPendingTransaction['0']['amount'];
            $res['pending_transaction_hash'] = $checkPendingTransaction['0']['transaction_hash'];
            $res['pending_package_id'] = $checkPendingTransaction['0']['package_id'];
            $res['pending_package_amount'] = $checkPendingTransaction['0']['amount'];
        } else {
            $check9pay = pay9Model::where(['user_id' => $user_id, 'status' => 0])->get()->toArray();

            if (count($check9pay) > 0) {
                $res['amount'] = $check9pay['0']['amount'];
                $res['fees_amount'] = $check9pay['0']['fees_amount'];
                $res['received_amount'] = $check9pay['0']['received_amount'];
                $res['chain'] = $check9pay['0']['chain'];

                return is_mobile($type, "", $res, "view");
            }
        }

        return is_mobile($type, "", $res, "view");
    }

    public function ajaxActivatePackage(Request $request)
    {
        $type = "API";
        $user_id = $request->session()->get('user_id');

        $checkPendingTransaction = packageTransaction::where(['user_id' => $user_id, 'isSynced' => 9])->get()->toArray();

        if (count($checkPendingTransaction) > 0) {

            $checkInvestment = userPlansModel::where(['transaction_hash' => $checkPendingTransaction['0']['transaction_hash'], 'user_id' => $user_id])->get()->toArray();

            if (count($checkInvestment) == 0) {

                $res['status_code'] = 1;
                $res['message'] = $checkPendingTransaction['0']['amount'] . " package detected its getting activated please wait.";

                return is_mobile($type, "", $res);
            }
        } else {
            $res['status_code'] = 0;
            $res['message'] = "No Package Found.";

            return is_mobile($type, "", $res);
        }
    }

    public function ajaxStorePackage(Request $request)
    {
        $type = "API";
        $user_id = $request->session()->get('user_id');
        $amount = $request->input('amount');
        $fees_amount = $request->input('fees_amount');
        $chain = $request->input('chain');

        $checkPendingTransaction = pay9Model::where(['user_id' => $user_id, 'status' => 0])->get()->toArray();

        if (count($checkPendingTransaction) == 0) {
            $pay9 = array();
            $pay9['user_id'] = $user_id;
            $pay9['amount'] = $amount;
            $pay9['fees_amount'] = $fees_amount;
            $pay9['received_amount'] = 0;
            $pay9['chain'] = $chain;
            $pay9['status'] = 0;
            $pay9['created_on'] = date('Y-m-d H:i:s');

            pay9Model::insert($pay9);

            $res['status_code'] = 1;
            $res['message'] = "Logged successfully";
        } else {
            $res['status_code'] = 0;
            $res['message'] = "Already transaction initiated.";

            return is_mobile($type, "", $res);
        }
    }

    public function cancelPayTransaction(Request $request)
    {
        $type = $request->input('type');
        $user_id = $request->session()->get('user_id');

        $getPay = pay9Model::where(['user_id' => $user_id])->get()->toArray();

        if (count($getPay) > 0) {
            pay9Model::where(['user_id' => $user_id])->update(['status' => 2]);
        }

        $res['status_code'] = 1;
        $res['message'] = "Transaction canceled";

        return is_mobile($type, "", $res);
    }

    public function apiHandlePackageTransaction9Pay(Request $request)
    {
        $type = "API";
        $newRequest = $request->input('auth');
        if (empty($newRequest)) {
            $res['status_code'] = 0;
            $res['message'] = "Parameter Missing.";

            return is_mobile($type, "", $res);
        }
        $newRequest = str_replace("806a7c4ac4e0133b5a90af9008738851", "", $newRequest);
        $newRequest = str_replace("203eb5fde9dbf86421903bb84fde4e03", "", $newRequest);
        $decodedString = base64_decode($newRequest);
        $explodeString = explode("+", $decodedString);

        $transaction_hash = trim($explodeString['0']);
        $amount = trim($explodeString['1']);
        $usdt_amount = trim($explodeString['2']);
        $user_id = trim($explodeString['3']);
        $network_type = trim($explodeString['4']);


        $getUser = usersModel::where(['id' => $user_id])->get()->toArray();

        $res = array();

        if (count($getUser) > 0) {
            $user_id = $getUser['0']['id'];

            $check9pay = pay9Model::where(['user_id' => $user_id, 'status' => 0])->get()->toArray();

            if (count($check9pay) > 0) {
                DB::statement("UPDATE pay9_payments set received_amount = (IFNULL(received_amount,0) + ($amount)) where id = '" . $check9pay['0']['id'] . "'");
            }

            if ($user_id > 0) {
                DB::statement("UPDATE users set topup_balance = (IFNULL(topup_balance,0) + ($amount)) where id = '" . $user_id . "'");
            }

            $checkTransaction = packageTransaction::where(['transaction_hash' => $transaction_hash])->get()->toArray();

            if (count($checkTransaction) == 0) {

                $user_plans = array();
                $user_plans['user_id'] = $user_id;
                $user_plans['transaction_hash'] = $transaction_hash;
                $user_plans['amount'] = $usdt_amount;
                $user_plans['package_id'] = 1;
                $user_plans['isSynced'] = 9;
                $user_plans['isApi'] = 1;
                $user_plans['remarks'] = $network_type;

                packageTransaction::insert($user_plans);

                $res['status_code'] = 1;
                $res['message'] = "Transaction logged successfully.";
            } else {
                $res['status_code'] = 0;
                $res['message'] = "transaction already exist.";

                return is_mobile($type, "", $res);
            }
        } else {
            $res['status_code'] = 0;
            $res['message'] = "Invalid wallet address.";

            return is_mobile($type, "", $res);
        }

        return is_mobile($type, "", $res);
    }

    public function packageDeposit(Request $request)
    {
        $type = $request->input('type');
        $user_id = $request->session()->get('user_id');

        $user = usersModel::where(['id' => $user_id])->get()->toArray();
        $packages = userPlansModel::where(['user_id' => $user_id])->orderBy('id', 'desc')->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Activate package deposit.";
        $res['packages'] = $packages;
        $res['user'] = $user['0'];
        $res['form_code'] = $user_id . date('YmdHis');

        $checkPendingTransaction = packageTransaction::where(['user_id' => $user_id, 'isSynced' => 0])->whereRaw("transaction_hash != 'By Other'")->get()->toArray();

        if (count($checkPendingTransaction) > 0) {
            $res['confirmTransactionWindow'] = 1;
            $res['pending_amount'] = $checkPendingTransaction['0']['amount'];
            $res['pending_transaction_hash'] = $checkPendingTransaction['0']['transaction_hash'];
            $res['pending_package_id'] = $checkPendingTransaction['0']['package_id'];
            $res['pending_package_amount'] = $checkPendingTransaction['0']['amount'];
        }

        return is_mobile($type, "", $res, "view");
    }

    public function processpackage(Request $request)
    {
        \Log::info("In processpackage...");

        $type = $request->input('type');
        $package = $request->input('package');
        $lock_period = $request->input('lock_period');
        // $discount = $request->input('discount');

        // dd($lock_period);

        $amount = $request->input('amount');
        $transaction_hash = $request->input('transaction_hash');
        $contract_stakeid = $request->input('contract_stakeid');
        $unique_transaction_hash = $request->input('unique_th');
        $redirect='stake';
        $redirect = ($package == 1) ? 'stake' : (($package == 2) ? 'lpbonds' : (($package == 3) ? 'stablebonds' : ''));

        if ($type == "API") {
            $user_id = $request->input('user_id');
        } else {
            $user_id = $request->session()->get('user_id');
        }
        
        if($package == 2)
        {
            $lp_amount = ($amount / coinPrice());
            // Check minimum 1 DORA equivalent amount
            if ($lp_amount < 1) {
                $res['status_code'] = 0;
                $res['message'] = "Minimum transaction amount is $".coinPrice()."[1 DORA]";
                return is_mobile($type, "", $res);
            }
        }
        else
        {
            if ($amount < 1) {
                $res['status_code'] = 0;
                $res['message'] = "Minimum transaction amount is $1.";

                return is_mobile($type, "", $res);
            }
        }

        

        $users = usersModel::select('topup_balance', 'sponser_id', 'wallet_address')->where('id', $user_id)->get()->toArray();

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'http://91.243.178.152:3152/check-transaction',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => 'transaction=' . $transaction_hash . '&amount=' . $amount . '&wallet=' . $users['0']['wallet_address'],
        //     CURLOPT_HTTPHEADER => array(
        //         'Content-Type: application/x-www-form-urlencoded'
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);

        // $decodeResponse = json_decode($response, true);

        if (!empty($transaction_hash) && $transaction_hash != 'By Topup') {
            $checkTransactionExist = userPlansModel::where(['transaction_hash' => $transaction_hash, 'user_id' => $user_id])->get()->toArray();

            if (count($checkTransactionExist) > 0) {
                packageTransaction::where(['transaction_hash' => $transaction_hash, 'user_id' => $user_id])->update(['isSynced' => 1]);

                $res['status_code'] = 0;
                $res['message'] = "Your package is already activated.";

                return is_mobile($type, "", $res);
            }

            $checkTransactionExist = userPlansModel::where(['transaction_hash' => $transaction_hash])->get()->toArray();

            if (count($checkTransactionExist) > 0) {
                packageTransaction::where(['transaction_hash' => $transaction_hash])->update(['isSynced' => 1]);

                $res['status_code'] = 0;
                $res['message'] = "Your package is already activated.";

                return is_mobile($type, "", $res);
            }
        }

        $packageData = packageModel::where(['status' => 1, 'id' => $package])->get()->toArray();

        $packageData = $packageData['0'];

        $packageData['amount'] = $amount;

        $user_plans = array();
        $user_plans['user_id'] = $user_id;
        $user_plans['package_id'] = $package;
        $user_plans['lock_period'] = $lock_period;
        // $user_plans['discount'] = $discount;

        // if($package == 2)
        // {
        //     $user_plans['amount'] = ($amount / coinPrice());
        // }else
        // {
        //     $user_plans['amount'] = $amount;
        // }
        // if($package == 3)
        // {
        //     if($lock_period == 1) 
        //     {
        //         $user_plans['compound_amount'] = ($amount * 0.025);
        //     }

        //     if($lock_period == 2)
        //     {
        //         $user_plans['compound_amount'] = ($amount * 0.05);
        //     }

        //     if($lock_period == 3)
        //     {
        //         $user_plans['compound_amount'] = ($amount * 0.075);
        //     }

        //     if($lock_period == 4)
        //     {
        //         $user_plans['compound_amount'] = ($amount * 0.1);
        //     }
        // }

        // \Log::info("In lockperiod...".$lock_period);

        $user_plans['amount'] = $amount;
        $daily_roi_pct = 0; // Default
        // dd($package);
        if($package == 1)
        {
            $daily_roi_pct = (float)0.60/2; // 2 Times a day
        }
        else if($package == 2) 
        {
            $plan_pct=0;
            $user_plans['amount'] = ($amount); // / coinPrice()

            foreach ($this->lpMatrix as $key => $data) {
                // if ($data['duration_days'] === $lock_period) {
                if ($key === $lock_period) {
                    $plan_pct = $data['roi_daily_pct'] / 2;
                    break;
                }
            }
            $daily_roi_pct = $plan_pct;
        }
        else if($package == 3) 
        {
            $plan_pct=0;
            foreach ($this->stableMatrix as $key => $data) {
                // \Log::info("In key...".$key);
                // if ($data['duration_days'] === $lock_period) {
                if ($key === $lock_period) {
                    $plan_pct = $data['roi_daily_pct'] / 2;
                    break;
                }
            }
            $daily_roi_pct = $plan_pct; 
        }

        $user_plans['roi'] = $daily_roi_pct; //$packageData['roi'];
        $user_plans['days'] = $packageData['days'];
        $user_plans['transaction_hash'] = $transaction_hash;
        $user_plans['unique_th'] = $unique_transaction_hash;
        $user_plans['contract_stakeid'] = $contract_stakeid;
        $user_plans['status'] = 1;
        $user_plans['coin_price'] = coinPrice();
        $user_plans['created_on'] = date('Y-m-d H:i:s');

        $existing = userPlansModel::where('unique_th', $unique_transaction_hash)->first();
       
        if (!$existing) {
            userPlansModel::insert($user_plans);

            usersModel::where('id', $user_id)->update(['total_stake_amount' => DB::raw('total_stake_amount + ' . $amount)]);
            
            packageTransaction::where(['transaction_hash' => $transaction_hash, 'user_id' => $user_id])->update(['isSynced' => 1]);

            if ($users['0']['sponser_id'] > 0) {

                $checkIfFirstPackage = userPlansModel::where('user_id', $user_id)->get()->toArray();
                if (count($checkIfFirstPackage) == 1) {
                    usersModel::where('id', $users['0']['sponser_id'])->update(['active_direct' => DB::raw('active_direct + 1')]);
                }

                usersModel::where('id', $users['0']['sponser_id'])->update(['direct_business' => DB::raw('direct_business + ' . $amount)]);
                
            }

        }

        $res['status_code'] = 1;
        $res['message'] = "Staked successfully";

        return is_mobile($type, "", $res);
    }

    public function handlePackageTransaction(Request $request)
    {
        \Log::info("In handlePackageTransaction...");
        \Log::info($request->input('type'));
        \Log::info($request->input('amount'));
        \Log::info($request->input('transaction_hash'));
        \Log::info($request->input('package'));
        \Log::info($request->input('lock_period'));
        \Log::info($request->input('contract_stakeid'));
        $type = $request->input('type');
        $transaction_hash = $request->input('transaction_hash');
        $remarks = $transaction_hash;
        $amount = $request->input('amount');
        $package = $request->input('package');
        $lock_period = $request->input('lock_period');
        $contract_stakeid = $request->input('contract_stakeid');
        // $discount = $request->input('discount');
        $redirect='stake';
        $redirect = ($package == 1) ? 'stake' : (($package == 2) ? 'lpbonds' : (($package == 3) ? 'stablebonds' : 'stake'));
        // dd($redirect);
        if ($type == "API") {
            $wallet_address = $request->input("wallet_address");
            $wallet = "USDT";
            $user = usersModel::where(['wallet_address' => $wallet_address])->get()->toArray();

            if(empty($package))
            {
                $package = 1;
            }

            if (count($user) == 0) {
                $res['status_code'] = 0;
                $res['message'] = "Invalid user id.";

                return is_mobile($type, "", $res);
            }
            $user_id = $user['0']['id'];
        } else {
            $user_id = $request->session()->get('user_id');
            $wallet = $request->input('wallet');
        }

        if ($amount <= 0) {
            $res['status_code'] = 0;
            $res['message'] = "Invalid amount.";

            return is_mobile($type, "", $res);
        }

        $user = usersModel::where(['id' => $user_id])->get()->toArray();

        $user_plans = array();
        $user_plans['user_id'] = $user_id;
        $user_plans['transaction_hash'] = $transaction_hash;
        $user_plans['amount'] = $amount;
        $user_plans['package_id'] = $package;
        $user_plans['lock_period'] = $lock_period;
        $user_plans['isSynced'] = 0;
        $user_plans['remarks'] = $remarks;
        if($type == "API")
        {
            $user_plans['isApi'] = 1;            
        }

        $existing = packageTransaction::where('transaction_hash', $transaction_hash)->first();
        // dd($existing);
        if (!$existing) {
            packageTransaction::insert($user_plans);
        }

        $checkPendingTransaction = packageTransaction::where(['user_id' => $user_id, 'isSynced' => 0])->get()->toArray();

        if(count($checkPendingTransaction) == 0)
        {
            $res['status_code'] = 0;
            $res['message'] = "Transaction is already verified.";

            return is_mobile($type, "", $res);
        }

        if($type == "API")
        {
            $data = [
                'transaction_hash' => $checkPendingTransaction['0']['transaction_hash'],
                'contract_stakeid' => $contract_stakeid,
                'unique_th'        => $checkPendingTransaction['0']['transaction_hash'],
                'amount'           => $checkPendingTransaction['0']['amount'],
                'package'          => $checkPendingTransaction['0']['package_id'],
                'lock_period'      => $checkPendingTransaction['0']['lock_period'],
                'user_id'          => $user_id,
                // 'discount'      => $discount,
                'type'             => "API", // if needed
            ];
            // dd($data);

            // Create a new request instance
            $fakeRequest = new Request($data);

            // Call the controller method
            \Log::info("call...processpackage");
            return $this->processpackage($fakeRequest);

            $res['status_code'] = 1;
            $res['message'] = "Please check transaction status to proceed.";

            return is_mobile($type, "", $res);
        }else
        {
            return redirect()->route('process.package', ['transaction_hash' => $checkPendingTransaction['0']['transaction_hash'], 'unique_th' => $checkPendingTransaction['0']['transaction_hash'], 'amount' => $checkPendingTransaction['0']['amount'], 'package' => $checkPendingTransaction['0']['package_id'], 'lock_period' => $checkPendingTransaction['0']['lock_period']]);
        }

    }

    public function checkPackageTransaction(Request $request)
    {
        $type = $request->input('type');
        $user_id = $request->session()->get('user_id');
        $isSynced = 0;

        $checkPendingTransaction = packageTransaction::where(['user_id' => $user_id, 'isSynced' => 0])->get()->toArray();
        $redirect='stake';
        $redirect = ($checkPendingTransaction['0']['package_id'] == 1) ? 'stake' : (($checkPendingTransaction['0']['package_id'] == 2) ? 'lpbonds' : (($checkPendingTransaction['0']['package_id'] == 3) ? 'stablebonds' : 'stake'));

        if (count($checkPendingTransaction) > 0) {
            // if($checkPendingTransaction['0']['transaction_hash'] == "0x93d4f949a3949d080f99ff5040723cddf6031b3f24971b862f2f4a3aa5649702")
            // {
            //     // packageTransaction::where(['transaction_hash' => $checkPendingTransaction['0']['transaction_hash']])->update(['json' => $response]);
            //     return redirect()->route('process.package',['transaction_hash'=> $checkPendingTransaction['0']['transaction_hash'],'unique_th'=> $checkPendingTransaction['0']['transaction_hash'], 'amount' => $checkPendingTransaction['0']['amount'], 'package' => $checkPendingTransaction['0']['package_id']]);
            // }

            $tempUser = usersModel::where(['id' => $user_id])->get()->toArray();

            if (count($tempUser) == 0) {
                $res['status_code'] = 0;
                $res['message'] = "Something went wrong please try again later.";

                return is_mobile($type, "", $res);
            }

            $checkAmount = $checkPendingTransaction['0']['amount'];
            $transaction_hash_check = $checkPendingTransaction['0']['transaction_hash'];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://91.243.178.30:3152/check-transaction',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'transaction=' . $transaction_hash_check . '&amount=' . $checkAmount . '&wallet=' . $tempUser['0']['wallet_address'],
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $decodeResponse = json_decode($response, true);

            if (isset($decodeResponse['status'])) {
                if ($decodeResponse['status'] == 1) {
                    if (isset($decodeResponse['result'])) {
                        if ($decodeResponse['result'] == true) {
                            $isSynced = 1;
                            $checkInvestment = userPlansModel::where(['transaction_hash' => $checkPendingTransaction['0']['transaction_hash'], 'user_id' => $user_id])->get()->toArray();

                            if (count($checkInvestment) == 0) {
                                packageTransaction::where(['transaction_hash' => $checkPendingTransaction['0']['transaction_hash']])->update(['json' => $response]);
                                return redirect()->route('process.package', ['transaction_hash' => $checkPendingTransaction['0']['transaction_hash'], 'unique_th' => $checkPendingTransaction['0']['transaction_hash'], 'amount' => $checkPendingTransaction['0']['amount'], 'package' => $checkPendingTransaction['0']['package_id'], 'lock_period' => $checkPendingTransaction['0']['lock_period']]);
                            }
                        } else {
                            $isSynced = 2;
                        }
                    } else {
                        $isSynced = 2;
                    }
                } else if ($decodeResponse['status'] == 0) {
                    $isSynced = 2;
                } else {
                    $isSynced = 2;
                }

                packageTransaction::where(['transaction_hash' => $checkPendingTransaction['0']['transaction_hash']])->update(['json' => $response, 'isSynced' => $isSynced]);

                $res['status_code'] = 0;
                if ($isSynced == 0) {
                    $res['message'] = "You transaction is still pending please check again later.";
                } else {
                    $res['message'] = "Your transaction is failed please check and try again later.";
                }

                return is_mobile($type, "", $res);
            } else {
                $res['status_code'] = 0;
                $res['message'] = "Something went wrong please try again later.";

                return is_mobile($type, "", $res);
            }
        } else {
            $res['status_code'] = 0;
            $res['message'] = "Staked successfully.";

            return is_mobile($type, "", $res);
        }
    }

    function getTVLTrend($days = 5)
    {
        $users = usersModel::select('id')->where('status', 1)->get();
        $trend = [];

        for ($i = 0; $i < $days; $i++) {
            $date = now()->subDays($i)->startOfDay();
            $totalTVL = 0;

            foreach ($users as $user) {
                $totalTVL += getUserStakedAmountTVL($user->id, $date);
            }

            $trend[$date->format('M d')] = round($totalTVL, 2);
        }

        return array_reverse($trend, true); // chronological order
    }

    // api/revenue-resource-details
    // public function revenueResourceDetails(Request $request)
    // {
    //     $request->setLaravelSession(app('session')->driver());
    //     $type = $request->input('type');

    //     if($type == "API")
    //     {
    //         $user_id = $request->input("user_id");
    //     }else
    //     {
    //         $user_id = $request->session()->get("user_id");
    //     }

    //     $page = $request->input('page', 1); // default page = 1
    //     $perPage = $request->input('perpage', 10); // default page = 10

    //     $roiWithdraws = DB::table('contract_roi_logs as crl')
    //                             ->join('user_plans as up', function ($join) {
    //                                 $join->on('crl.stake_id', '=', 'up.contract_stakeid')
    //                                      ->on('crl.user_id', '=', 'up.user_id');
    //                             })
    //                             ->leftJoin('withdraw as w', function ($join) {
    //                                 $join->on('crl.stake_id', '=', 'w.contract_stakeid')
    //                                      ->on('crl.user_id', '=', 'w.user_id');
    //                             })
    //                             ->join('users as u', 'u.id', '=', 'crl.user_id')
    //                             ->select(
    //                                 'crl.id',
    //                                 'crl.user_id',
    //                                 'crl.stake_id as contract_stakeid',
    //                                 'crl.plan_id',
    //                                 'crl.package_id',
    //                                 'crl.amount',
    //                                 'crl.event_type',
    //                                 'crl.transaction_hash',
    //                                 'crl.created_on',
    //                                 'up.amount as stake_amount',
    //                                 'up.created_on as stake_date',
    //                                 'u.wallet_address',
    //                                 'w.withdraw_type',
    //                                 'w.contract_label'
    //                             )
    //                             ->where('crl.user_id', $user_id)
    //                             ->orderByDesc('crl.created_on')
    //                             ->paginate($perPage, ['*'], 'page', $page);

    //     $responseData = [];
    //     // dd($user_stakes);
    //     // Push formatted record
    //     if(!empty($roiWithdraws))
    //     {
    //         $walletAddress = null;
    //         foreach ($roiWithdraws as $key => $withdraw) {
                
    //             if ($walletAddress === null) {
    //                 $walletAddress = $withdraw->wallet_address;
    //             }
    //             $responseData[] = [
    //                                 "id" => $withdraw->id,
    //                                 "amount" => $withdraw->amount,
    //                                 "type" => $withdraw->withdraw_type,
    //                                 "label" => $withdraw->contract_label,
    //                                 "date" => $withdraw->created_on,
    //                                 "event_type" => $withdraw->event_type
    //                             ];
    //         }
    //     }
    //     // dd($responseData);

    //     // Final response
    //     if(empty($responseData))
    //     {
    //         $responseData['status'] = 'success';
    //         $responseData['message'] = 'No data found';
    //     }

    //     $res = array(
    //                "status" => 1,
    //                "data" => $responseData,
    //                "wallet_address" => $walletAddress,
    //                "total" => $roiWithdraws->total(),
    //                "lastPage" => $roiWithdraws->lastPage()
    //             );
    //     return is_mobile($type, "", $res, "");
    // }

    // api/earning-receive-history
    public function earningLogsHistory(Request $request)
    {
        $request->setLaravelSession(app('session')->driver());
        $type = $request->input('type');

        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }

        $user_stakes = userPlansModel::where([
                                                'user_id' => $user_id,
                                                'package_id' => 1
                                            ])
                                            ->orderBy('id', 'desc')
                                            ->get()
                                            ->toArray();

        $responseData = [];
        
        foreach ($user_stakes as $us_value) {

            $generatedRoi = earningLogsModel::selectRaw("IFNULL(SUM(amount),0) as amount")
                ->where('tag', '=', 'CLAIMROI')
                ->where('refrence_id', '=', '1')
                ->where('user_id', '=', $user_id)
                ->where('contract_stakeid', '=', $us_value['contract_earningid'])
                ->get()
                ->toArray();

        }

        // Final response
        if(empty($responseData))
        {
            $responseData['status'] = 'success';
            $responseData['message'] = 'No data found';
        }

        return is_mobile($type, "errors.403", $responseData, "");
    }

    // api/stake-details
    public function stakingReleaseHistoryStakeid(Request $request)
    {
        $request->setLaravelSession(app('session')->driver());
        $type = $request->input('type');

        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }

        $contract_stakeid = $request->input("stake_id");

        $user_stakes = userPlansModel::where([
                                                'user_id' => $user_id,
                                                'contract_stakeid' => $contract_stakeid
                                            ])
                                            ->orderBy('id', 'desc')
                                            ->get()
                                            ->toArray();

        $responseData = [];
        foreach ($user_stakes as $us_value) {

            // ROI Withdraws for this stake
            $roiWithdraws = DB::select("
                SELECT id, contract_stakeid, package_id, amount, status, created_on
                FROM withdraw
                WHERE package_id = ?
                  AND user_id = ?
                  AND contract_stakeid = ?
                  AND withdraw_type = 'CLAIMROI'
                  AND status = 1
                ORDER BY created_on ASC
            ", [
                $us_value['package_id'],
                $user_id,
                $us_value['contract_stakeid']
            ]);
            // dd($roiWithdraws);
            
            $roiSum = array_sum(array_column($roiWithdraws, 'amount'));

            // UNSTAKE Withdraws for this stake
            $unstakeWithdraws = DB::select("
                SELECT id, contract_stakeid, package_id, amount, status, created_on
                FROM withdraw
                WHERE package_id = ?
                  AND user_id = ?
                  AND withdraw_type = 'UNSTAKE'
                  AND status = 1
                  AND contract_stakeid = ?
                ORDER BY created_on ASC
            ", [
                $us_value['package_id'],
                $user_id,
                $us_value['contract_stakeid']
            ]);

            $unstakeSum = array_sum(array_column($unstakeWithdraws, 'amount'));

            // Choose display date: latest of ROI or UNSTAKE, or fallback to stake date
            $lastRoiDate = !empty($roiWithdraws)
                ? end($roiWithdraws)->created_on
                : null;
            $lastUnstakeDate = !empty($unstakeWithdraws)
                ? end($unstakeWithdraws)->created_on
                : null;

            $displayDate = $lastUnstakeDate ?? $lastRoiDate ?? $us_value['created_on'];

            // Push formatted record
            if($unstakeSum>0 || $roiSum>0)
            {
                $responseData[] = [
                    'date'            => $displayDate,
                    'current_asset'   => (float) $unstakeSum, // or you can use $us_value['amount'] - $unstakeSum if you want remaining asset
                    'current_reward'  => (float) $roiSum,
                ];
            }
        }

        // Final response
        if(empty($responseData))
        {
            $responseData['status'] = 'success';
            $responseData['message'] = 'No data found';
        }

        return is_mobile($type, "errors.403", $responseData, "");
    }

    // /stakeing-rebase-history
    public function stakingRebaseHistory(Request $request)
    {
        $type = "API";
        $stake_id = $request->input('stake_id');
        $user_id = $request->input('user_id');
        $package_id = $request->input('package_id');

        $data = earningLogsModel::selectRaw('refrence as current_asset, amount as current_reward, created_on as date')->where(['user_id' => $user_id, 'contract_stakeid' => $stake_id, 'refrence_id' => $package_id, 'tag' => "ROI"])->orderBy('id', 'desc')->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;

        return is_mobile($type, "errors.403", $res);
    }

    
    public function turbineVestingHistory(Request $request)
    {
        $request->setLaravelSession(app('session')->driver());
        $stype = $request->input('type');
        $type = "API";
        $wallet_address = $request->input('wallet_address');

        // 1) Get user + wallet
        $user = usersModel::select('id', 'wallet_address')
            ->where('wallet_address', $wallet_address)
            ->first();

        if (!$user || empty($user->wallet_address)) {
            $res = [
                'status_code' => 0,
                'message'     => 'User not found or wallet address missing.',
                'data'        => [],
            ];
            return is_mobile($type, "errors.403", $res);
        }

        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }
        else
        {
            $user_id = $request->session()->get("user_id");
        }
        $amount = $request->input('amount');
        $transaction_hash = $request->input('transaction_hash');
        $release_type = $request->input('release_type');
        $start_datetime = is_numeric($request->input('start_datetime'))
        ? date('Y-m-d H:i:s', (int) $request->input('start_datetime'))
        : $request->input('start_datetime');

        $end_datetime = is_numeric($request->input('end_datetime'))
            ? date('Y-m-d H:i:s', (int) $request->input('end_datetime'))
            : $request->input('end_datetime');
        
        // Prepare insert data
        $data = [
            'wallet_address'   => $wallet_address,
            'amount'           => $amount,
            'type'             => $release_type,
            'transaction_hash' => $transaction_hash,
            'start_datetime'   => $start_datetime,
            'end_datetime'     => $end_datetime,
            'created_on'       => date('Y-m-d H:i:s')
        ];

        // ✅ Check if duplicate already exists (same wallet + transaction hash)
        $exists = roiReleaseVestingModel::where('wallet_address', $wallet_address)
            ->where('transaction_hash', $transaction_hash)
            ->exists();

        $res['status_code'] = 1;
        if (!$exists) {
            roiReleaseVestingModel::insert($data);
            $res['message'] = "Success";
        } else {
            roiReleaseVestingModel::where('wallet_address', $wallet_address)->where('transaction_hash', $transaction_hash)->update($data);
            $res['message'] = "Duplicate entry skipped for wallet: {$wallet_address}, txn: {$transaction_hash}";
        }
        
        $res['data'] = $data;

        return is_mobile($type, "errors.403", $res);        
    }


    public function releaseHistory(Request $request)
    {
        $type    = "API";
        $user_id = (int) $request->input('user_id');

        // 1) Get user + wallet
        $user = usersModel::select('id', 'wallet_address')
            ->where('id', $user_id)
            ->first();

        if (!$user || empty($user->wallet_address)) {
            $res = [
                'status_code' => 0,
                'message'     => 'User not found or wallet address missing.',
                'data'        => [],
            ];
            return is_mobile($type, "errors.403", $res);
        }

        $wallet = $user->wallet_address;

        // 2) Fetch release history for this wallet (using DB:: methods)
        //    Also compute total_days between start_datetime and end_datetime.
        $data = DB::table('roi_release_history')
            ->select(
                'id',
                'wallet_address',
                'amount',
                'transaction_hash',
                'start_datetime',
                'end_datetime',
                'created_on',
                DB::raw('DATEDIFF(end_datetime, start_datetime) AS total_days')
            )
            ->where('wallet_address', $wallet)
            ->orderByDesc('id')
            ->get()
            ->toArray();

        // 3) Build response
        $res = [
            'status_code' => 1,
            'message'     => 'Success',
            'data'        => $data,
            'wallet'      => $wallet,
            'count'       => count($data),
        ];

        // Keep your existing view target (you can swap to a real list view if needed)
        return is_mobile($type, "errors.403", $res);
    }

    public function revenueSourceDetails(Request $request)
    {
        $type    = "API";
        $user_id = (int) $request->input('user_id');

        // 1️⃣ Get user wallet address
        $user = usersModel::select('id', 'wallet_address')
            ->where('id', $user_id)
            ->first();

        if (!$user || empty($user->wallet_address)) {
            $res = [
                'status_code' => 0,
                'message'     => 'User not found or wallet address missing.',
                'data'        => [],
            ];
            return is_mobile($type, "errors.403", $res);
        }

        $wallet = $user->wallet_address;

        // 2️⃣ Get withdraw data (event_type = claimreward)
        $withdrawData = DB::table('withdraw')
            ->select(
                'id',
                'amount',
                'created_on',
                DB::raw("'claimreward' AS event_type"),
                DB::raw("CASE 
                    WHEN withdraw_type = 'CLAIMROI' THEN 'static' 
                    WHEN withdraw_type = 'UNSTAKE' THEN 'static' 
                    ELSE 'dynamic' 
                 END AS label")
            )
            ->where('user_id', $user_id)
            ->get()
            ->toArray();

        // 3️⃣ Get ROI release data (event_type = withdrawreward)
        $roiData = DB::table('roi_release_history')
            ->select(
                'id',
                'amount',
                'created_on',
                DB::raw("type AS label"),
                DB::raw("'withdrawreward' AS event_type")
            )
            ->where('wallet_address', $wallet)
            ->get()
            ->toArray();

        // 4️⃣ Merge both arrays
        $data = array_merge($withdrawData, $roiData);

        // 5️⃣ Sort merged data by created_on (newest first)
        usort($data, function ($a, $b) {
            return strtotime($b->created_on) <=> strtotime($a->created_on);
        });

        // 6️⃣ Build response
        $res = [
            'status_code' => 1,
            'message'     => 'Success',
            'data'        => $data,
            'wallet'      => $wallet,
            'total'       => count($data),
        ];

        return is_mobile($type, "errors.403", $res);
    }

    public function userBalance(Request $request)
    {
        $type    = "API";

        // 1️⃣ Get user wallet address
        $user = usersModel::select('id', 'wallet_address', 'roi_income', 'direct_income', 'level_income', 'royalty', 'rank_bonus', 'reward_bonus', 'club_bonus')->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['users'] = $user;

        return is_mobile($type, "errors.403", $res);
    }

    public function processTurbineRelease(Request $request)
    {
        $type = "API";

        // ✅ 1) Validate API input
        $validated = $request->validate([
            'wallet_address'    => 'required|string|max:255',
            'amount'            => 'required|numeric|min:0',
            'transaction_hash'  => 'required|string|max:255',
        ]);

        // ✅ 2) Fetch the user_id using wallet_address
        $user = usersModel::select('id')
            ->where('wallet_address', $validated['wallet_address'])
            ->first();

        if (!$user) {
            $res = [
                'status_code' => 0,
                'message'     => 'Wallet address not found.',
            ];
            return is_mobile($type, "errors.403", $res);
        }

        // ✅ 3) Prepare data for insertion
        $data = [
            'user_id'          => $user->id,
            'amount'           => $validated['amount'],
            'transaction_hash' => $validated['transaction_hash'],
            'status'           => 1,
            'created_on'       => now(),
        ];

        // ✅ 4) Check for duplicate (same user + transaction)
        $exists = DB::table('turbine')
            ->where('user_id', $user->id)
            ->where('transaction_hash', $validated['transaction_hash'])
            ->exists();

        if ($exists) {
            $res = [
                'status_code' => 0,
                'message'     => 'Duplicate entry. This transaction already exists.',
            ];
            return is_mobile($type, "errors.403", $res);
        }

        // ✅ 5) Insert new turbine release record
        DB::table('turbine')->insert($data);

        // ✅ 6) Response
        $res = [
            'status_code' => 1,
            'message'     => 'Turbine release entry inserted successfully.',
            'data'        => $data,
        ];

        return is_mobile($type, "pages.income_overview", $res, "view");
    }

    public function turbineReleaseHistory(Request $request)
    {
        $type = "API";

        // ✅ 1) Validate input
        $validated = $request->validate([
            'user_id' => 'required|integer|min:1',
        ]);

        $user_id = $validated['user_id'];

        // ✅ 2) Fetch history from turbine table
        $data = DB::table('turbine')
        ->select(
            'id',
            'user_id',
            'amount',
            'transaction_hash',
            'status',
            'created_on',
            DB::raw("'released' AS withdraw_type") // 👈 added static field
        )
        ->where('user_id', $user_id)
        ->orderByDesc('id')
        ->get()
        ->toArray();

        // ✅ 3) Prepare response
        if (count($data) > 0) {
            $res = [
                'status_code' => 1,
                'message'     => 'Turbine release history fetched successfully.',
                'withdraw'        => $data,
            ];
        } else {
            $res = [
                'status_code' => 0,
                'message'     => 'No records found for this user.',
                'withdraw'        => [],
            ];
        }

        // ✅ 4) Return unified response
        return is_mobile($type, "pages.income_overview", $res, "view");
    }
}
