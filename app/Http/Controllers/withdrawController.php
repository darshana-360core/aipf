<?php

namespace App\Http\Controllers;

use App\Models\earningLogsModel;
use App\Models\levelEarningLogsModel;
use App\Models\settingModel;
use App\Models\myTeamModel;
use App\Models\userPlansModel;
use App\Models\usersModel;
use App\Models\transferModel;
use App\Models\withdrawModel;
use Illuminate\Http\Request;

use function App\Helpers\getBalance;
use function App\Helpers\coinPrice;
use function App\Helpers\is_mobile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class withdrawController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input("type");
        // $user_id = $request->session()->get("user_id");
        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }

        $user = usersModel::where("id", $user_id)->get()->toArray();

        $withdraw = withdrawModel::where(['user_id' => $user_id,'withdraw_type'=>'USDT'])->orderBy('id', 'desc')->get()->toArray();

        $lastRequest = withdrawModel::where(['user_id' => $user_id, 'status' => 0])->orderBy('id', 'desc')->get()->toArray();

        $setting = settingModel::get()->toArray();

        $queue = 0;

        if (count($lastRequest) > 0) {
            if ($lastRequest['0']['isSynced'] == '-1') {
                $getCountQueue = withdrawModel::whereRaw("id < " . $lastRequest['0']['id'] . " and isSynced = '-1'")->get()->toArray();

                $queue = count($getCountQueue) + 1;
            }
        }

        $pending_withdraw_amount = 0;
        $withdraw_amount = 0;

        foreach ($withdraw as $key => $value) {
            if ($value['status'] == 0) {
                $pending_withdraw_amount += $value['amount'];
            }
            if ($value['status'] == 1) {
                $withdraw_amount += $value['amount'];
            }
        }

        $totalIncome = $user['0']['direct_income'] + $user['0']['level_income'] + $user['0']['rank_bonus'] + $user['0']['royalty'] + $user['0']['reward_bonus'] + $user['0']['club_bonus'];

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['user'] = $user['0'];
        $res['setting'] = $setting['0'] ?? 0;
        $res['totalIncome'] = $totalIncome;
        $res['queue'] = $queue;
        $res['withdraw'] = $withdraw;
        $res['withdraw_amount'] = $withdraw_amount;// > $totalIncome ? $totalIncome : $withdraw_amount;
        $res['availableBalance'] = $totalIncome - $withdraw_amount;
        $res['pendingWithdraw'] = $pending_withdraw_amount;

        $dailyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as dailyPool")->where('tag', 'DAILY-POOL')->where('user_id', '=', $user_id)->get()->toArray();
        $stake_bonus = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as stake_bonus")->where('tag', 'ROI')->where('user_id', '=', $user_id)->get()->toArray();

        $monthlyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as monthlyPool")->where('tag', 'MONTHLY-POOL')->where('user_id', '=', $user_id)->get()->toArray();

        $res['dailyPoolWinners'] = $dailyPoolWinners['0']['dailyPool'];
        $res['monthlyPoolWinners'] = $monthlyPoolWinners['0']['monthlyPool'];
        $res['stake_bonus'] = $stake_bonus['0']['stake_bonus'];
        $res['coinPrice'] = coinPrice();

        return is_mobile($type, "", $res, "view");
    }

    public function withdrawprocess(Request $request)
    {
        $type = $request->input('type');
        $withdraw_type = $request->input('withdraw_type');
        $package_id = $request->input('package_id');
        $amount = $request->input('amount');
        $transaction_hash = $request->input('transaction_hash');
        $user_id = $request->session()->get('user_id');

        // Check if the transaction hash is 66 characters long (including 0x) and hex
        if (!preg_match('/^0x([A-Fa-f0-9]{64})$/', $transaction_hash)) {
            $res['status_code'] = 0;
            $res['message'] = "Invalid transaction hash format.";
            return redirect()->back()->with(['data' => $res]);
        }

        $users = usersModel::where(['id' => $user_id])->get()->toArray();

        $setting = settingModel::get()->toArray();

        if ($setting['0']['withdraw_setting'] == 0) {
            $res['status_code'] = 0;
            $res['message'] = "Claim Bonus can not be processed right now. Please try again later.";

            return redirect()->back()->with(['data' => $res]);
        }

        if ($amount <= 1) {
            $res['status_code'] = 0;
            $res['message'] = "Minimum Amount is 1.";

            return redirect()->back()->with(['data' => $res]);
        }

        // $verifyWalletAddress = DB::select("SELECT * FROM `users` where RIGHT(wallet_address, 6) = refferal_code and id = " . $user_id . " ORDER BY id desc");

        // if (count($verifyWalletAddress) == 0) {
        //     $res['status_code'] = 0;
        //     $res['message'] = "Your wallet address is not verified.";

        //     return redirect()->back()->with(['data' => $res]);
        // }

        $checkCanWithdraw = usersModel::where(['id' => $user_id])->get()->toArray();

        if ($checkCanWithdraw['0']['canWithdraw'] == 0) {
            $res['status_code'] = 0;
            $res['message'] = "Claim Bonus can not be processed right now please try again later.";

            return redirect()->back()->with(['data' => $res]);
        }

        if ($amount <= 0) {
            $res['status_code'] = 0;
            $res['message'] = "Amount must be greater than zero.";

            return redirect()->back()->with(['data' => $res]);
        }

        if ($amount < 1) {
            $res['status_code'] = 0;
            $res['message'] = "Minimum Amount to process claim bonus is $1.";

            return redirect()->back()->with(['data' => $res]);
        }

        // $balance = getBalance($user_id);

        // if ($amount > ($balance)) {
        //     $res['status_code'] = 0;
        //     $res['message'] = "Insufficent balance to process that request.";

        //     return redirect()->back()->with(['data' => $res]);
        // }

        $admin_charge = ($setting['0']["admin_fees"] * $amount) / 100;
        $daily_pool_amount = (2 * $amount) / 100;
        $monthly_pool_amount = (1 * $amount) / 100;

        $net_amount = $amount - $admin_charge;

        // $withdrawAmount = withdrawModel::selectRaw("SUM(amount) as amount")->where(['user_id' => $user_id, 'status' => 1, 'withdraw_type' => "USDT"])->get()->toArray();

        // if (($withdrawAmount['0']['amount'] + $amount) > ($users['0']['level_income'] + $users['0']['royalty'] + $users['0']['rank_bonus'] + $users['0']['direct_income']  + $users['0']['reward_bonus'])) {
        //     $res['status_code'] = 0;
        //     $res['message'] = "Amount entered more then your total balance please try again later.";

        //     return redirect()->back()->with(['data' => $res]);
        // }

        // $checkWithdraw = withdrawModel::where(['user_id' => $user_id, 'status' => 0])->get()->toArray();

        // if (count($checkWithdraw) > 0) {
        //     $res['status_code'] = 0;
        //     $res['message'] = "One of your claim bonus request is in process please wait.";

        //     return redirect()->back()->with(['data' => $res]);
        // }

        // $lastWithdraw = withdrawModel::where('user_id', $user_id)->where('withdraw_type', 'USDT')
        //     ->orderBy('created_on', 'desc')
        //     ->first();

        // if ($lastWithdraw) {
        //     if (Carbon::parse($lastWithdraw->created_on)->diffInHours(Carbon::now()) < 24) {
        //         $res['status_code'] = 0;
        //         $res['message'] = "Only one withdraw is allowed in 24 hours.";

        //         return redirect()->back()->with(['data' => $res]);
        //     }
        // }

        $checkPackage = userPlansModel::where(['user_id' => $user_id])->get()->toArray();

        if (count($checkPackage) == 0) {
            $res['status_code'] = 0;
            $res['message'] = "Your are not eligible to claim bonus.";

            return redirect()->back()->with(['data' => $res]);
        }

        // $withdrawCount = withdrawModel::where(['user_id' => $user_id, 'status' => 1])->get()->toArray();
        // $withdraw_balance_earn = 0;
        // foreach ($withdrawCount as $key => $value) {
        //     $withdraw_balance_earn += $value['amount'];
        // }

        // $countEarningLogs = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as earnAmount")->where(['user_id' => $user_id])->where('tag', '!=', 'ROI')->get()->toArray();
        // $countLevelEarningLogs = levelEarningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as earnAmount")->where(['user_id' => $user_id])->get()->toArray();

        // if ($amount > (($countEarningLogs['0']['earnAmount'] + $countLevelEarningLogs['0']['earnAmount']) - $withdraw_balance_earn)) {
        //     $res['status_code'] = 0;
        //     $res['message'] = "Insufficent balance to process that request.";

        //     return redirect()->back()->with(['data' => $res]);
        // }

        $txnExists = withdrawModel::where(['claim_hash' => $transaction_hash])->get()->toArray();
        if(count($txnExists) > 0)
        {
            $res['status_code'] = 1;
            $res['message'] = "Bonus claimed successfully.";

            return redirect()->back()->with(['data' => $res]);
        }

        // $transaction_hash = '-';
        $signaturejsonRPC = '-';

        $withdraw = array();
        $withdraw['user_id'] = $user_id;
        $withdraw['withdraw_type'] = $withdraw_type;
        $withdraw['amount'] = $amount;
        $withdraw['coin_price'] = coinPrice();
        $withdraw['admin_charge'] = $admin_charge;
        $withdraw['daily_pool_amount'] = $daily_pool_amount;
        $withdraw['monthly_pool_amount'] = $monthly_pool_amount;
        $withdraw['fees'] = ($setting['0']["admin_fees"]);
        $withdraw['net_amount'] = $net_amount;
        $withdraw['transaction_hash'] = "-";
        $withdraw['claim_hash'] = $transaction_hash;
        $withdraw['status'] = 1;
        $withdraw['json_response'] = '-';
        $withdraw['isSynced'] = '1';
        $withdraw['isRequestSynced'] = '1';
        $withdraw['signatureJson'] = $signaturejsonRPC;
        $withdraw['created_on'] = date('Y-m-d H:i:s');

        if($withdraw_type != "UNSTAKE")
        {
            $withdraw['isReverse'] = 1;
        }

        if(!empty($package_id))
        {
            $withdraw['package_id'] = $package_id;
        }

        withdrawModel::insert($withdraw);

        $res['status_code'] = 1;
        $res['message'] = "Bonus claimed successfully.";

        return redirect()->back()->with(['data' => $res]);
    }

    public function poolRewards(Request $request)
    {
        $type = $request->input("type");
        if($type == "API")
        {
            $user_id = $request->input("user_id");
        }else
        {
            $user_id = $request->session()->get("user_id");
        }

        $start_date = $request->input("start_date");
        $end_date = $request->input("end_date");

        $start_date = $start_date ? Carbon::parse($start_date)->startOfDay() : null;
        $end_date = $end_date ? Carbon::parse($end_date)->endOfDay() : null;

        // $user_id = $request->session()->get("user_id");

        $getPoolAmount = withdrawModel::selectRaw("IFNULL(SUM(daily_pool_amount), 0) as daily_pool")
            ->whereRaw("DATE_FORMAT(created_on, '%Y-%m-%d') = ?", [date('Y-m-d')])
            ->get()
            ->toArray();

        $month = date('Y-m');

        $getMonthlyPoolAmount = withdrawModel::selectRaw("IFNULL(SUM(monthly_pool_amount), 0) as monthly_pool")
            ->whereRaw("DATE_FORMAT(created_on, '%Y-%m') = ?", [$month])
            ->get()
            ->toArray();

        $dailyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as dailyPool")->where('tag', 'DAILY-POOL')->where('user_id', '=', $user_id)->get()->toArray();

        $monthlyPoolWinners = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as monthlyPool")->where('tag', 'MONTHLY-POOL')->where('user_id', '=', $user_id)->get()->toArray();

        $dailyPoolQuery = earningLogsModel::selectRaw("
            users.wallet_address,
            IFNULL(SUM(earning_logs.amount), 0) as dailyPool,
            earning_logs.created_on
        ")
        ->join('users', 'users.id', '=', 'earning_logs.user_id')
        ->where('earning_logs.tag', 'DAILY-POOL');

        // Apply filter only if both dates are present
        if ($start_date && $end_date) {
            $dailyPoolQuery->whereBetween('earning_logs.created_on', [$start_date, $end_date]);
        } else {
            // Default to last 7 days
            $dailyPoolQuery->where('earning_logs.created_on', '>=', Carbon::now()->subDays(7));
        }

        $dailyPoolData = $dailyPoolQuery
            ->groupBy('users.id', 'users.wallet_address')
            ->orderBy('earning_logs.id', 'desc')
            ->get()
            ->toArray();

        $monthlyPoolQuery = earningLogsModel::selectRaw("
            users.wallet_address,
            IFNULL(SUM(earning_logs.amount), 0) as monthlyPool,
            earning_logs.refrence,
            earning_logs.created_on
        ")
        ->join('users', 'users.id', '=', 'earning_logs.user_id')
        ->where('earning_logs.tag', 'MONTHLY-POOL');

        if ($start_date && $end_date) {
            $monthlyPoolQuery->whereBetween('earning_logs.created_on', [$start_date, $end_date]);
        } else {
            // Default to current month
            $monthlyPoolQuery->whereBetween('earning_logs.created_on', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfDay()
            ]);
        }

        $monthlyPoolData = $monthlyPoolQuery
            ->groupBy('users.id', 'users.wallet_address')
            ->orderBy('earning_logs.id', 'desc')
            ->get()
            ->toArray();


        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['daily_pool'] = $getPoolAmount['0']['daily_pool'];
        $res['monthly_pool'] = $getMonthlyPoolAmount['0']['monthly_pool'];
        $res['claim_daily_pool_amount'] = $dailyPoolWinners['0']['dailyPool'];
        $res['claim_monthly_pool_amount'] = $monthlyPoolWinners['0']['monthlyPool'];
        $res['daily_data'] = $dailyPoolData;
        $res['monthly_data'] = $monthlyPoolData;

        return is_mobile($type, "", $res, "view");
    }

    public function clubBonus(Request $request)
    {
        $type = $request->input("type");
        $user_id = $request->session()->get("user_id");

        $clubBonusData = earningLogsModel::selectRaw("
            users.wallet_address,
            earning_logs.amount as clubBonus,
            earning_logs.created_on,
            earning_logs.refrence
        ")
        ->join('users', 'users.id', '=', 'earning_logs.user_id')
        ->where('earning_logs.tag', 'CLUB-BONUS')
        ->orderBy('earning_logs.id', 'desc')
        ->get()
        ->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['club_data'] = $clubBonusData;

        return is_mobile($type, "", $res, "view");
    }

    public function handleWithdrawTransaction(Request $request)
    {
        $type = "API";
        $transaction_hash = $request->input('transaction_hash');
        $contract_stakeid = $request->input('contract_stakeid');
        $amount = $request->input('amount');
        $withdraw_type = $request->input('withdraw_type');
        $package_id = $request->input('package_id');
        $lock_period = $request->input('lock_period');
        $wallet_address = $request->input("wallet_address");

        // Check if the transaction hash is 66 characters long (including 0x) and hex
        if (!preg_match('/^0x([A-Fa-f0-9]{64})$/', $transaction_hash)) {
            $res['status_code'] = 0;
            $res['message'] = "Invalid transaction hash format.";
            return is_mobile($type, "", $res);
        }

        if ($amount < 0) {
            $res['status_code'] = 0;
            $res['message'] = "Please Enter Valid Amount.";

            return is_mobile($type, "", $res);
        }

        if ($withdraw_type !== 'USDT' && $withdraw_type !== 'UNSTAKE' && $withdraw_type !== 'ROI') {
            // If the withdraw type is neither 'USDT' nor 'UNSTAKE' nor ROI, show an error
            $res['status_code'] = 0;
            $res['message'] = "Please Enter Valid Withdrawal Type.";

            return is_mobile($type, "", $res);
        }

        $txnExists = withdrawModel::where(['claim_hash' => $transaction_hash])->get()->toArray();
        if(count($txnExists) > 0)
        {
            withdrawModel::where(['claim_hash' => $transaction_hash])->update(['lock_period' => $lock_period]);
            $res['status_code'] = 0;
            $res['message'] = "Transaction already exists.";
            return is_mobile($type, "", $res);
        }
        
        $user = usersModel::where(['wallet_address' => $wallet_address])->get()->toArray();

        if (count($user) == 0) {
            $res['status_code'] = 0;
            $res['message'] = "Invalid user id.";

            return is_mobile($type, "", $res);
        }

        $user_id = $user['0']['id'];

        $checkPackage = userPlansModel::where(['user_id' => $user_id])->get()->toArray();

        if (count($checkPackage) == 0) {
            $res['status_code'] = 0;
            $res['message'] = "Your are not eligible to claim bonus.";

            return redirect()->back()->with(['data' => $res]);
        }

        $setting = settingModel::get()->toArray();

        $admin_charge = ($setting['0']["admin_fees"] * $amount) / 100;
        $daily_pool_amount = (2 * $amount) / 100;
        $monthly_pool_amount = (1 * $amount) / 100;

        $net_amount = $amount - $admin_charge;

        if($withdraw_type == "ROI")
        {
            $withdraw_type = 'CLAIMROI';
        }

        $signaturejsonRPC = '-';

        $withdraw = array();
        $withdraw['user_id'] = $user_id;
        $withdraw['withdraw_type'] = $withdraw_type;
        $withdraw['amount'] = $amount;
        $withdraw['coin_price'] = coinPrice();
        $withdraw['admin_charge'] = $admin_charge;
        $withdraw['daily_pool_amount'] = $daily_pool_amount;
        $withdraw['monthly_pool_amount'] = $monthly_pool_amount;
        $withdraw['fees'] = ($setting['0']["admin_fees"]);
        $withdraw['net_amount'] = $net_amount;
        $withdraw['transaction_hash'] = "-";
        $withdraw['claim_hash'] = $transaction_hash;
        $withdraw['contract_stakeid'] = $contract_stakeid;
        $withdraw['status'] = 1;
        $withdraw['json_response'] = '-';
        $withdraw['isSynced'] = '1';
        $withdraw['isRequestSynced'] = '1';
        $withdraw['signatureJson'] = $signaturejsonRPC;
        $withdraw['created_on'] = date('Y-m-d H:i:s');

        if($withdraw_type != "UNSTAKE")
        {
            $withdraw['isReverse'] = 1;
        }

        if(!empty($package_id))
        {
            $withdraw['package_id'] = $package_id;
        }

        withdrawModel::insert($withdraw);

        usersModel::where('id', $user_id)->update(['total_stake_amount' => DB::raw('total_stake_amount - ' . $amount)]);

        $res['status_code'] = 1;
        $res['message'] = "Withdraw logged successfully.";

        return is_mobile($type, "", $res);
    }
}
