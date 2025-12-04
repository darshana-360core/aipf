<?php

namespace App\Http\Controllers;

use App\Models\userPlansModel;
use App\Models\usersModel;
use App\Models\loginLogsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function App\Helpers\checkReferralCode;
use function App\Helpers\verifyRSVP;
use function App\Helpers\is_mobile;
use function App\Helpers\updateReverseSize;

class registerController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $sponser_code = $request->input('sponser_code');
        $user_id = $request->session()->get('user_id');


        // if (empty($sponser_code)) {
        //     $res['status_code'] = 0;
        //     $res['message'] = "Please use referral link for register.";

        //     return is_mobile($type, "flogin", $res);
        // }

        if (!empty($user_id)) {
            $res['status_code'] = 1;
            $res['message'] = "Already loggedin.";

            return is_mobile($type, "", $res);
        }

        $res['status_code'] = 1;
        $res['message'] = "Fetched Successfully.";

        if (!empty($sponser_code)) {
            $res['sponser_code'] = $sponser_code;
        }

        return is_mobile($type, "", $res, "view");
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->setLaravelSession(app('session')->driver());
        $type = $request->input('type');
        $updateData = $request->except('_method', '_token', 'submit', 'image', 'cover', 'value_cover', 'confirm_password', 'type','rScript','rsScript','rsvScript','hashedMessageScript','walletAddressScript');

        $wallet_address = $request->input('wallet_address');

        if (empty($updateData['wallet_address'])) {
            $res['status_code'] = 0;
            $res['message'] = "Invalid wallet address Address.";
            return is_mobile($type, "", $res);
        }

        if ($updateData['wallet_address'] == 'undefined') {
            $res['status_code'] = 0;
            $res['message'] = "Invalid wallet address Address.";
            return is_mobile($type, "", $res);
        }

        $data = usersModel::where(['wallet_address' => $wallet_address])->get()->toArray();

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

        $walletAddressScript = $request->input('walletAddressScript');
        $hashedMessageScript = $request->input('hashedMessageScript');
        $rsvScript = $request->input('rsvScript');
        $rsScript = $request->input('rsScript');
        $rScript = $request->input('rScript');

        $verifySignData = json_encode(array(
            "wallet" => $updateData['wallet_address'],
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
        
        $checkEmailMobile = usersModel::whereRaw("wallet_address = '" . $updateData['wallet_address'] . "'")->get()->toArray();

        if (count($checkEmailMobile) == 0) {
            $refferal_code = substr($updateData['wallet_address'], -6);

            $length = 10;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            if (!empty($updateData['refferal'])) {
                $getRefUserId = usersModel::where(['wallet_address' => $updateData['refferal']])->get()->toArray();

                if (count($getRefUserId) == 0) {
                    $res['status_code'] = 0;
                    $res['message'] = "Invalid reffer code used please check again.";
                    return is_mobile($type, "", $res);
                } else {
                    $checkReferalActivation = userPlansModel::where(['user_id' => $getRefUserId['0']['id']])->get()->toArray();

                    // if (count($checkReferalActivation) == 0) {
                    //     $res['status_code'] = 0;
                    //     $res['message'] = "Referrer is not active please check again.";
                    //     return is_mobile($type, "flogin", $res);
                    // }

                    $updateData['sponser_id'] = $getRefUserId['0']['id'];
                    $updateData['sponser_code'] = $getRefUserId['0']['refferal_code'];
                }
            }

            if (empty($updateData['refferal'])) {
                $res['status_code'] = 0;
                $res['message'] = "Please use referral link to connect wallet.";

                return is_mobile($type, "", $res);
            }

            $updateData['password'] = md5($updateData['wallet_address']);
            $updateData['refferal_code'] = $refferal_code;
            $updateData['status'] = 1;
            $updateData['code'] = $randomString;
            $updateData['verified'] = 1;
            $updateData['created_on'] = date('Y-m-d H:i:s');

            unset($updateData['refferal']);

            usersModel::insert($updateData);

            $user_id = DB::getPdo()->lastInsertId();

            DB::statement("UPDATE users set my_direct = (my_direct + 1) where id = '" . $updateData['sponser_id'] . "'");

            updateReverseSize($user_id, $user_id, 1);

            usersModel::where(['id' => $user_id])->update(['isCount' => 1]);

            $data = usersModel::where(['id' => $user_id])->get()->toArray();

            $request->session()->put('user_id', $data['0']['id']);
            $request->session()->put('email', $data['0']['email']);
            $request->session()->put('name', $data['0']['name']);
            $request->session()->put('refferal_code', $data['0']['refferal_code']);
            $request->session()->put('wallet_address', $data['0']['wallet_address']);
            $request->session()->put('rank', $data['0']['rank']);

            $res['status_code'] = 1;
            $res['message'] = "Wallet Connected Successfully.";
            $res['user_id'] = $data['0']['id'];
            return is_mobile($type, "", $res);

            // $res['status_code'] = 1;
            // $res['message'] = "Registration Successfully.";
            // $res['email_verification'] = 1;
            // $res['refferal_code'] = $refferal_code;
            // $res['user_id'] = $user_id;

            // return is_mobile($type, "flogin", $res);
        } else {
            if ($data['0']['status'] == 1) {
                $request->session()->put('user_id', $data['0']['id']);
                $request->session()->put('email', $data['0']['email']);
                $request->session()->put('name', $data['0']['name']);
                $request->session()->put('refferal_code', $data['0']['refferal_code']);
                $request->session()->put('wallet_address', $data['0']['wallet_address']);
                $request->session()->put('rank', $data['0']['rank']);

                $res['status_code'] = 1;
                $res['message'] = "Wallet Connected Successfully.";
                $res['user_id'] = $data['0']['id'];
                return is_mobile($type, "", $res);
            } else {
                $res['status_code'] = 0;
                $res['message'] = "Your account is suspended.";

                return is_mobile($type, "", $res);
            }
        }
    }

    public function verifyEmail(Request $request, $code)
    {
        $type = $request->input('type');

        $checkCode = usersModel::where(['code' => $code])->get()->toArray();

        if (count($checkCode) > 0) {
            usersModel::where(['id' => $checkCode['0']['id']])->update(['code' => '', 'verified' => '1']);

            $res['status_code'] = 1;
            $res['message'] = "Your Email Is Successfully Verified.";
        } else {
            $res['status_code'] = 0;
            $res['message'] = "Something went wrong please try again later.";
        }

        return is_mobile($type, "", $res);
    }
}
