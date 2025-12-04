<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\bonusModel;
use App\Models\earningLogsModel;
use App\Models\matchingIncomeModel;
use App\Models\packageModel;
use App\Models\plansModel;
use App\Models\settingModel;
use App\Models\userPlansModel;
use App\Models\withdrawModel;
use App\Models\usersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;

use App\Models\adminModel;
use App\Models\pinModel;

use function App\Helpers\checkActivationPin;
use function App\Helpers\is_mobile;
use function App\Helpers\getBalance;
use function App\Helpers\getBalanceALL;
use function App\Helpers\getBalancePS;

class withdrawController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $email = $request->input('email');
        $password = $request->input('password');

        $data = withdrawModel::selectRaw("users.*, withdraw.id as withdraw_id, withdraw.amount, withdraw.withdraw_type, withdraw.transaction_hash, withdraw.blc_price, withdraw.net_amount, withdraw.processed_date, withdraw.created_on ")->join('users','users.id','=','withdraw.user_id')->where(['withdraw.status' => 1])->orderBy('withdraw.id','desc')->get()->toArray();

        foreach($data as $key => $value)
        {
            $data[$key]['balance'] = getBalance($value['id']);
        }
        
        $res['status_code'] = 1;
        $res['message'] = "Withdraw fetch successfully.";
        $res['data'] = $data;

        return is_mobile($type, "withdraw", $res, "view");
           
    }

    public function withdrawProcess(Request $request)
    {
        $type = $request->input('type');

        $blcData = file_get_contents("https://coinsbit.io/api/v1/public/ticker?market=BLC_USDT");
        $blcDataFinal = json_decode($blcData, true);

        $data = withdrawModel::selectRaw("users.*, withdraw.id as withdraw_id, withdraw.amount, withdraw.withdraw_type, withdraw.transaction_hash, withdraw.blc_price, withdraw.net_amount, withdraw.created_on ")->join('users','users.id','=','withdraw.user_id')->where(['withdraw.status' => 0])->orderBy('withdraw.id','desc')->get()->toArray();

        foreach($data as $key => $value)
        {
            $data[$key]['balance'] = getBalance($value['id']);
        }
        
        $res['status_code'] = 1;
        $res['message'] = "Withdraw fetch successfully.";
        $res['data'] = $data;
        $res['blcprice'] = $blcDataFinal['result']['last'];

        return is_mobile($type, "withdraw-process", $res, "view"); 
    }

    public function withdrawSave(Request $request)
    {
        $type = $request->input('type');
        $transaction_hash = $request->input('transaction_hash');        
        $withdraw_ids = $request->input('withdrawof');

        $blcData = file_get_contents("https://coinsbit.io/api/v1/public/ticker?market=BLC_USDT");
        $blcDataFinal = json_decode($blcData, true);

        $fetchTxn = file_get_contents("https://api.polygonscan.com/api?module=transaction&action=gettxreceiptstatus&txhash=".$transaction_hash."&apikey=5BWWNYVKS6AKTQ616DIVQF86YP2UJBZ686");

        $dataTxn = json_decode($fetchTxn, true);

        if(isset($dataTxn['status']))
        {
            if($dataTxn['status'] == 1)
            {
                $status = 1;
            }
        }

        if($status == 1)
        {
            foreach($withdraw_ids as $key => $value)
            {
                withdrawModel::where(['id' => $value])->update(['status' => $status, 'transaction_hash' => $transaction_hash, 'blc_price' => $blcDataFinal['result']['last'], 'processed_date' => date('Y-m-d H:i:s')]);
            }
        }
        
        $res['status_code'] = 1;
        $res['message'] = "Withdraw process successfully.";

        return is_mobile($type, "withdraw.index", $res); 
    }

    public function searchUserForWithdraw(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');

        if(!empty($search))
        {
            $data = usersModel::where(['refferal_code' => $search])->get()->toArray();

            if(count($data) == 0)
            {
                $res['status_code'] = 0;
                $res['message'] = "User not found.";

                return is_mobile($type, "searchUserForWithdraw", $res);
            }

            $user = $data['0'];

            $checkForWithdraw = withdrawModel::where(['status' => 0, 'user_id' => $user['id']])->get()->toArray();

            if(count($checkForWithdraw) > 0)
            {
                $res['status_code'] = 0;
                $res['message'] = $user['refferal_code']." is one withdraw is in pending you can't deduct now.";

                return is_mobile($type, "searchUserForWithdraw", $res);
            }

            // $allIncome = $user['referral_bonus'] + $user['rank_bonus'] + $user['brokerage'] + $user['royalty_pool'] + $user['profit_sharing_level'];
            // $profitSharingIncome = $user['profit_sharing'];

            $allIncome = getBalanceALL($user['id']);
            $profitSharingIncome = getBalancePS($user['id']);

            $res['status_code'] = 1;
            $res['message'] = "User found";
            $res['allIncome'] = $allIncome;
            $res['profitSharingIncome'] = $profitSharingIncome;
            $res['user'] = $data;
            $res['search'] = $search;

            return is_mobile($type, "search-user-withdraw", $res, "view");
        }

        $res['status_code'] = 1;
        $res['message'] = "User found";

        return is_mobile($type, "search-user-withdraw", $res, "view");
    }

    public function searchUserForAddBalance(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');

        if(!empty($search))
        {
            $data = usersModel::where(['refferal_code' => $search])->get()->toArray();

            if(count($data) == 0)
            {
                $res['status_code'] = 0;
                $res['message'] = "User not found.";

                return is_mobile($type, "searchUserForAddBalance", $res);
            }

            $user = $data['0'];

            $checkForWithdraw = withdrawModel::where(['status' => 0, 'user_id' => $user['id']])->get()->toArray();

            if(count($checkForWithdraw) > 0)
            {
                $res['status_code'] = 0;
                $res['message'] = $user['refferal_code']." is one withdraw is in pending you can't deduct now.";

                return is_mobile($type, "searchUserForAddBalance", $res);
            }

            // $allIncome = $user['referral_bonus'] + $user['rank_bonus'] + $user['brokerage'] + $user['royalty_pool'] + $user['profit_sharing_level'];
            // $profitSharingIncome = $user['profit_sharing'];

            $allIncome = getBalanceALL($user['id']);
            $profitSharingIncome = getBalancePS($user['id']);

            $res['status_code'] = 1;
            $res['message'] = "User found";
            $res['allIncome'] = $allIncome;
            $res['profitSharingIncome'] = $profitSharingIncome;
            $res['user'] = $data;
            $res['search'] = $search;

            return is_mobile($type, "search-user-add-balance", $res, "view");
        }

        $res['status_code'] = 1;
        $res['message'] = "User found";

        return is_mobile($type, "search-user-add-balance", $res, "view");
    }

    public function addUserBalance(Request $request)
    {
        $type = $request->input('type');
        $amount = $request->input('amount');
        $remarks = $request->input('remarks');
        $user_id = $request->input('user_id');

        $data = usersModel::where(['id' => $user_id])->get()->toArray();

        if(count($data) > 0)
        {
            $randomString = checkActivationPin();

            $activationPin = array();
            $activationPin['user_id'] = 1;
            $activationPin['pin'] = $randomString;
            $activationPin['amount'] = $amount;
            $activationPin['for_user_id'] = $user_id;
            $activationPin['status'] = 0;
            $activationPin['used_by'] = 0;
            $activationPin['isAdmin'] = 1;
            $activationPin['remarks'] = $remarks;
            $activationPin['created_on'] = date('Y-m-d H:i:s');

            pinModel::insert($activationPin);
            
            $res['status_code'] = 1;
            $res['message'] = "$".$amount." Added For User ".$data['0']['refferal_code'];
        }else
        {
            $res['status_code'] = 0;
            $res['message'] = "user not found";
        }


        return is_mobile($type, "searchUserForAddBalance", $res);
    }

    public function deductUserWithdraw(Request $request)
    {
        $type = $request->input('type');
        $wallet = $request->input('wallet');
        $amount = $request->input('amount');
        $remarks = $request->input('remarks');
        $user_id = $request->input('user_id');

        $data = usersModel::where(['id' => $user_id])->get()->toArray();

        if(count($data) > 0)
        {
            $allIncome = getBalanceALL($user_id);
            $profitSharingIncome = getBalancePS($user_id);

            if($wallet == "PS")
            {

                if($amount > $profitSharingIncome)
                {
                    $res['status_code'] = 0;
                    $res['message'] = "You can't deduct more then available balance.";

                    return is_mobile($type, "searchUserForWithdraw", $res);
                }

                $withdraw = array();
                $withdraw['user_id'] = $user_id;
                $withdraw['withdraw_type'] = "DEDUCT";
                $withdraw['wallet'] = "PROFIT-SHARING";
                $withdraw['amount'] = $amount;
                $withdraw['admin_charge'] = 0;
                $withdraw['utility_charge'] = 0;
                $withdraw['net_amount'] = $amount;
                $withdraw['remarks'] = $remarks;
                $withdraw['transaction_hash'] = "DEDUCT";
                $withdraw['status'] = 1;
                $withdraw['coin_price'] = 1;
                // $withdraw['json_response'] = $server_output;
                $withdraw['isSynced'] = '1';
                $withdraw['isRequestSynced'] = '1';
                $withdraw['signatureJson'] = '-';

                withdrawModel::insert($withdraw);

            }else
            {
                if($amount > $allIncome)
                {
                    $res['status_code'] = 0;
                    $res['message'] = "You can't deduct more then available balance.";

                    return is_mobile($type, "searchUserForWithdraw", $res);
                }

                $withdraw = array();
                $withdraw['user_id'] = $user_id;
                $withdraw['withdraw_type'] = "DEDUCT";
                $withdraw['wallet'] = "ALL";
                $withdraw['amount'] = $amount;
                $withdraw['admin_charge'] = 0;
                $withdraw['utility_charge'] = 0;
                $withdraw['net_amount'] = $amount;
                $withdraw['remarks'] = $remarks;
                $withdraw['transaction_hash'] = "DEDUCT";
                $withdraw['status'] = 1;
                $withdraw['coin_price'] = 1;
                // $withdraw['json_response'] = $server_output;
                $withdraw['isSynced'] = '1';
                $withdraw['isRequestSynced'] = '1';
                $withdraw['signatureJson'] = '-';

                withdrawModel::insert($withdraw);
            }
        }

        $res['status_code'] = 1;
        $res['message'] = "$".$amount." Deducted From User ".$data['0']['refferal_code'];

        return is_mobile($type, "searchUserForWithdraw", $res);
    }
}
