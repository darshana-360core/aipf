<?php

namespace App\Http\Controllers\admin;

use App\Exports\CustomQueryExport;
use App\Http\Controllers\Controller;
use App\Models\bonusModel;
use App\Models\earningLogsModel;
use App\Models\matchingIncomeModel;
use App\Models\packageModel;
use App\Models\plansModel;
use App\Models\settingModel;
use App\Models\userPlansModel;
use App\Models\withdrawModel;
use App\Models\packageTransaction;
use App\Models\usersModel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;

use App\Models\adminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use function App\Helpers\is_mobile;

class loginController extends Controller
{
        public function index(Request $request)
        {
                $type = $request->input('type');
                $email = $request->input('email');
                $password = $request->input('password');

                $data = adminModel::where(['email' => $email, 'password' => md5($password)])->get()->toArray();

                if (count($data) == 1) {
                        $res['status_code'] = 1;
                        $res['message'] = "Login successfully";

                        $request->session()->put('admin_user_id', $data['0']['id']);
                        $request->session()->put('email', $data['0']['email']);
                        $request->session()->put('name', $data['0']['name']);

                        $length = 6;
                        $characters = '0123456789';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < $length; $i++) {
                                $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }

                        adminModel::where(['id' => $data['0']['id']])->update(['otp' => $randomString]);

                        //     $to_email = "vitnixxai4@gmail.com";
                        //     $to_name = "Admin";
                        //     $message = $randomString." is your OTP for admin login. Do not share it with anyone.";
                        //     $data = array('code' => $message, 'name' => $to_name, 'portal' => 'VitnixX AI');
                        //     $isSent = Mail::send('emails.otp', $data, function($message) use ($to_name, $to_email) {
                        //     $message->to($to_email, $to_name)
                        //     ->subject('ADMIN OTP to login');
                        //     $message->from('support@ai.vitnixx.com','VitnixX AI');
                        //     });

                        // return is_mobile($type, "aloginviewotp", $res);
                        return is_mobile($type, "dashboard", $res);
                } else {
                        $res['status_code'] = 0;
                        $res['message'] = "Email and Password Does Not Match.";

                        return is_mobile($type, "index", $res);
                }
        }

        public function logout(Request $request)
        {
                //logout user
                $request->session()->flush();
                // redirect to homepage
                return redirect()->route('index');
        }

        public function dashboard(Request $request)
        {
                $type = $request->input('type');
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
                $user_id = $request->session()->get('admin_user_id');

                $total_users = usersModel::count();
                // $total_activated_count= userPlansModel::where('status',1)->count();
                $total_activated_user = userPlansModel::where('status', 1)->where('transaction_hash','NOT LIKE', '%Admin%')->groupBy('user_id')->get();
                $total_activated_count = count($total_activated_user);
                $total_activated_amount = userPlansModel::where('status', 1)->where('transaction_hash','NOT LIKE', '%Admin%')->sum('amount');
                // $total_activated_by_admin_count= userPlansModel::where('status',1)->where('transaction_hash','By Admin')->count();
                $total_activated_by_admin_user = userPlansModel::where('status', 1)->where('transaction_hash','LIKE', '%Admin%')->groupBy('user_id')->get();
                $total_activated_by_admin_count = count($total_activated_by_admin_user);
                $total_activatedamount_by_admin = userPlansModel::where('status', 1)->where('transaction_hash','LIKE', '%Admin%')->sum('amount');
                $total_withdraws = withdrawModel::where('status', 1)->sum('amount');
                // $total_usdt = packageTransaction::where('wallet', 'USDT')->sum('amount');

                $res['status_code'] = 1;
                $res['total_users'] = $total_users;
                $res['total_activated_count'] = $total_activated_count;
                $res['total_activated_amount'] = $total_activated_amount;
                $res['total_activated_by_admin_count'] = $total_activated_by_admin_count;
                $res['total_activatedamount_by_admin'] = $total_activatedamount_by_admin;
                $res['total_withdraws'] = $total_withdraws;
                // $res['total_usdt'] = $total_usdt;
                $res['message'] = "Dashboard information loaded successfully";

                return is_mobile($type, "index", $res, "view");
        }

        public function incomeOverviewFilter(Request $request)
        {
                ini_set('memory_limit', '512M');
                $type = $request->input('type');
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
                $refferal_code = $request->input('refferal_code');

                $whereStartDate = '';
                $whereEndDate = '';
                $whereRefferalCode = '';

                if ($start_date != '') {
                        $whereStartDate = " AND date_format(e.created_on, '%Y-%m-%d') >= '" . date('Y-m-d', strtotime($start_date)) . "'";
                }

                if ($end_date != '') {
                        $whereEndDate = " AND date_format(e.created_on, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime($end_date)) . "'";
                }

                if ($refferal_code != '') {
                        $whereRefferalCode = " AND u.refferal_code = '" . $refferal_code . "'";
                }

                $data = DB::select("SELECT u.name, u.refferal_code, u.sponser_code, u.email, e.amount, e.tag, e.created_on, u.id FROM earning_logs e inner join users u on e.user_id = u.id where 1 = 1 " . $whereRefferalCode . $whereStartDate . $whereEndDate);

                $data = array_map(function ($value) {
                        return (array) $value;
                }, $data);

                $levelData = DB::select("SELECT u.name, u.refferal_code, u.sponser_code, u.email, e.amount, e.tag, e.created_on, u.id FROM level_earning_logs e inner join users u on e.user_id = u.id where 1 = 1 " . $whereRefferalCode . $whereStartDate . $whereEndDate);

                $levelData = array_map(function ($value) {
                        return (array) $value;
                }, $levelData);

                $finalData = array();

                foreach ($data as $key => $value) {
                        $finalData[$value['id']]['roi_income'] = 0;
                        $finalData[$value['id']]['reward_bonus'] = 0;
                        $finalData[$value['id']]['star_bonus'] = 0;
                        $finalData[$value['id']]['daily_pool'] = 0;
                        $finalData[$value['id']]['monthly_pool'] = 0;
                        $finalData[$value['id']]['upline_bonus'] = 0;
                        $finalData[$value['id']]['club_bonus'] = 0;
                        $finalData[$value['id']]['level_income'] = 0;
                }

                foreach ($data as $key => $value) {
                        $finalData[$value['id']]['name'] = $value['name'];
                        $finalData[$value['id']]['refferal_code'] = $value['refferal_code'];
                        $finalData[$value['id']]['sponser_code'] = $value['sponser_code'];
                        $finalData[$value['id']]['email'] = $value['email'];
                        $finalData[$value['id']]['amount'] = $value['amount'];
                        $finalData[$value['id']]['tag'] = $value['tag'];
                        $finalData[$value['id']]['created_on'] = $value['created_on'];

                        if ($value['tag'] == 'ROI') {
                                if (isset($finalData[$value['id']]['roi_income'])) {
                                        $finalData[$value['id']]['roi_income'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['roi_income'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "LEVEL1-ROI" || $value['tag'] == "LEVEL2-ROI" || $value['tag'] == "LEVEL3-ROI" || $value['tag'] == "LEVEL4-ROI" || $value['tag'] == "LEVEL5-ROI" || $value['tag'] == "LEVEL6-ROI" || $value['tag'] == "LEVEL7-ROI" || $value['tag'] == "LEVEL8-ROI" || $value['tag'] == "LEVEL9-ROI" || $value['tag'] == "LEVEL10-ROI" || $value['tag'] == "LEVEL11-ROI" || $value['tag'] == "LEVEL12-ROI" || $value['tag'] == "LEVEL13-ROI" || $value['tag'] == "LEVEL14-ROI" || $value['tag'] == "LEVEL15-ROI") {
                                if (isset($finalData[$value['id']]['level_income'])) {
                                        $finalData[$value['id']]['level_income'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['level_income'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "REWARD-BONUS") {
                                if (isset($finalData[$value['id']]['reward_bonus'])) {
                                        $finalData[$value['id']]['reward_bonus'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['reward_bonus'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "STAR-BONUS") {
                                if (isset($finalData[$value['id']]['star_bonus'])) {
                                        $finalData[$value['id']]['star_bonus'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['star_bonus'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "DAILY-POOL") {
                                if (isset($finalData[$value['id']]['daily_pool'])) {
                                        $finalData[$value['id']]['daily_pool'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['daily_pool'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "MONTHLY-POOL") {
                                if (isset($finalData[$value['id']]['monthly_pool'])) {
                                        $finalData[$value['id']]['monthly_pool'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['monthly_pool'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "UPLINE-BONUS") {
                                if (isset($finalData[$value['id']]['upline_bonus'])) {
                                        $finalData[$value['id']]['upline_bonus'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['upline_bonus'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "CLUB-BONUS") {
                                if (isset($finalData[$value['id']]['club_bonus'])) {
                                        $finalData[$value['id']]['club_bonus'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['club_bonus'] = $value['amount'];
                                }
                        }
                }

                foreach ($levelData as $key => $value) {
                    $userId = $value['id'];

                    if (!isset($finalData[$userId]['roi_income'])) {
                        $finalData[$userId]['roi_income'] = 0;
                    }
                    if (!isset($finalData[$userId]['reward_bonus'])) {
                        $finalData[$userId]['reward_bonus'] = 0;
                    }
                    if (!isset($finalData[$userId]['star_bonus'])) {
                        $finalData[$userId]['star_bonus'] = 0;
                    }
                    if (!isset($finalData[$userId]['daily_pool'])) {
                        $finalData[$userId]['daily_pool'] = 0;
                    }
                    if (!isset($finalData[$userId]['monthly_pool'])) {
                        $finalData[$userId]['monthly_pool'] = 0;
                    }
                    if (!isset($finalData[$userId]['upline_bonus'])) {
                        $finalData[$userId]['upline_bonus'] = 0;
                    }
                    if (!isset($finalData[$userId]['club_bonus'])) {
                        $finalData[$userId]['club_bonus'] = 0;
                    }
                    if (!isset($finalData[$userId]['level_income'])) {
                        $finalData[$userId]['level_income'] = 0;
                    }
                }


                foreach ($levelData as $key => $value) {
                        $finalData[$value['id']]['name'] = $value['name'];
                        $finalData[$value['id']]['refferal_code'] = $value['refferal_code'];
                        $finalData[$value['id']]['sponser_code'] = $value['sponser_code'];
                        $finalData[$value['id']]['email'] = $value['email'];
                        $finalData[$value['id']]['amount'] = $value['amount'];
                        $finalData[$value['id']]['tag'] = $value['tag'];
                        $finalData[$value['id']]['created_on'] = $value['created_on'];

                        
                        if (isset($finalData[$value['id']]['level_income'])) {
                                $finalData[$value['id']]['level_income'] += $value['amount'];
                        } else {
                                $finalData[$value['id']]['level_income'] = $value['amount'];
                        }
                        
                }

                $res['status_code'] = 1;
                $res['message'] = "successfully.";
                $res['start_date'] = $start_date;
                $res['end_date'] = $end_date;
                $res['refferal_code'] = $refferal_code;
                $res['data'] = $finalData;

                return is_mobile($type, "income_generated_report", $res, "view");
        }

        public function incomeOverviewFilterExcel(Request $request)
        {
                $type = $request->input('type');
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
                $refferal_code = $request->input('refferal_code');

                $whereStartDate = '';
                $whereEndDate = '';
                $whereRefferalCode = '';

                if ($start_date != '') {
                        $whereStartDate = " AND date_format(e.created_on, '%Y-%m-%d') >= '" . date('Y-m-d', strtotime($start_date)) . "'";
                }

                if ($end_date != '') {
                        $whereEndDate = " AND date_format(e.created_on, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime($end_date)) . "'";
                }

                if ($refferal_code != '') {
                        $whereRefferalCode = " AND u.refferal_code = '" . $refferal_code . "'";
                }

                $data = DB::select("SELECT u.name, u.refferal_code, u.sponser_code, u.email, e.amount, e.tag, e.created_on, u.id FROM earning_logs e inner join users u on e.user_id = u.id where 1 = 1 " . $whereRefferalCode . $whereStartDate . $whereEndDate);

                $data = array_map(function ($value) {
                        return (array) $value;
                }, $data);

                $finalData = array();

                foreach ($data as $key => $value) {
                        $finalData[$value['id']]['name'] = $value['name'];
                        $finalData[$value['id']]['refferal_code'] = $value['refferal_code'];
                        $finalData[$value['id']]['sponser_code'] = $value['sponser_code'];
                        $finalData[$value['id']]['email'] = $value['email'];
                        $finalData[$value['id']]['created_on'] = $value['created_on'];
                        $finalData[$value['id']]['referral_bonus'] = "0";
                        $finalData[$value['id']]['profit_sharing'] = "0";
                        $finalData[$value['id']]['profit_sharing_level'] = "0";
                        $finalData[$value['id']]['rank_bonus'] = "0";
                        $finalData[$value['id']]['ib_income'] = "0";
                        $finalData[$value['id']]['booster_income'] = "0";
                        $finalData[$value['id']]['award_income'] = "0";
                }

                foreach ($data as $key => $value) {
                        $finalData[$value['id']]['name'] = $value['name'];
                        $finalData[$value['id']]['refferal_code'] = $value['refferal_code'];
                        $finalData[$value['id']]['sponser_code'] = $value['sponser_code'];
                        $finalData[$value['id']]['email'] = $value['email'];
                        $finalData[$value['id']]['created_on'] = $value['created_on'];

                        if ($value['tag'] == 'REFERRAL') {
                                if (isset($finalData[$value['id']]['referral_bonus'])) {
                                        $finalData[$value['id']]['referral_bonus'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['referral_bonus'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "LEVEL1-ROI" || $value['tag'] == "LEVEL2-ROI" || $value['tag'] == "LEVEL3-ROI" || $value['tag'] == "LEVEL4-ROI" || $value['tag'] == "LEVEL5-ROI" || $value['tag'] == "LEVEL6-ROI" || $value['tag'] == "LEVEL7-ROI" || $value['tag'] == "LEVEL8-ROI" || $value['tag'] == "LEVEL9-ROI" || $value['tag'] == "LEVEL10-ROI" || $value['tag'] == "LEVEL11-ROI" || $value['tag'] == "LEVEL12-ROI" || $value['tag'] == "LEVEL13-ROI" || $value['tag'] == "LEVEL14-ROI" || $value['tag'] == "LEVEL15-ROI" || $value['tag'] == "LEVEL16-ROI" || $value['tag'] == "LEVEL17-ROI" || $value['tag'] == "LEVEL18-ROI" || $value['tag'] == "LEVEL19-ROI" || $value['tag'] == "LEVEL20-ROI") {
                                if (isset($finalData[$value['id']]['profit_sharing_level'])) {
                                        $finalData[$value['id']]['profit_sharing_level'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['profit_sharing_level'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "profit_sharing") {
                                if (isset($finalData[$value['id']]['profit_sharing'])) {
                                        $finalData[$value['id']]['profit_sharing'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['profit_sharing'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "reward_income") {
                                if (isset($finalData[$value['id']]['rank_bonus'])) {
                                        $finalData[$value['id']]['rank_bonus'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['rank_bonus'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "brokerage") {
                                if (isset($finalData[$value['id']]['brokerage'])) {
                                        $finalData[$value['id']]['brokerage'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['brokerage'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "pool") {
                                if (isset($finalData[$value['id']]['royalty_pool'])) {
                                        $finalData[$value['id']]['royalty_pool'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['royalty_pool'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "ib_income") {
                                if (isset($finalData[$value['id']]['ib_income'])) {
                                        $finalData[$value['id']]['ib_income'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['ib_income'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "booster_income") {
                                if (isset($finalData[$value['id']]['booster_income'])) {
                                        $finalData[$value['id']]['booster_income'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['booster_income'] = $value['amount'];
                                }
                        }

                        if ($value['tag'] == "award-income") {
                                if (isset($finalData[$value['id']]['award_income'])) {
                                        $finalData[$value['id']]['award_income'] += $value['amount'];
                                } else {
                                        $finalData[$value['id']]['award_income'] = $value['amount'];
                                }
                        }
                }

                $headings = [
                        'Member Name',
                        'Member Code',
                        'Sponser Code',
                        'Email',
                        'Registration Date',
                        'Sponsor Income',
                        'Profit Sharing',
                        'Level Income',
                        'Reward Income',
                        'Ib Income',
                        'Booster Income',
                        'Award Income',
                ];

                return Excel::download(new CustomQueryExport($finalData, $headings), 'payoutReport.xlsx');

                // $res['status_code'] = 1;
                // $res['message'] = "successfully.";
                // $res['start_date'] = $start_date;
                // $res['end_date'] = $end_date;
                // $res['refferal_code'] = $refferal_code;
                // $res['data'] = $finalData;

                // return is_mobile($type, "income_generated_report", $res, "view");
        }

        public function view_change_password(Request $request)
        {
                $type = $request->input('type');

                $res['status_code'] = 1;
                $res['message'] = "Success";

                return is_mobile($type, "change_password", $res, "view");
        }

        public function store_change_password(Request $request)
        {
                $type = $request->input('type');
                $user_id = $request->session()->get('admin_user_id');

                $old_password = $request->input('old_password');
                $new_password = $request->input('new_password');
                $renew_password = $request->input('renew_password');

                if ($new_password != $renew_password) {
                        $res['status_code'] = 0;
                        $res['message'] = "new password and confirm password does not match";

                        return is_mobile($type, "view_change_password", $res);
                }

                $old_password = md5($old_password);

                $checkOldPassword = adminModel::where(['id' => $user_id, 'password' => $old_password])->get()->toArray();

                if (count($checkOldPassword) == 0) {
                        $res['status_code'] = 0;
                        $res['message'] = "Old password does not match";

                        return is_mobile($type, "view_change_password", $res);
                }

                $updatePassword = adminModel::where(['id' => $user_id])->update(['password' => md5($new_password)]);

                $res['status_code'] = 1;
                $res['message'] = "Password change Successfully";

                return is_mobile($type, "view_change_password", $res);
        }

        public function loginviewotp(Request $request)
        {
                $type = $request->input('type');
                $user_id = $request->session()->get('temp_admin_user_id');

                if (empty($user_id)) {
                        $res['status_code'] = 1;
                        $res['message'] = "Please login to continue.";

                        return is_mobile($type, "aloginview", $res);
                }

                $res['status_code'] = 1;
                $res['message'] = "Please enter otp to continue.";

                return is_mobile($type, "login-otp", $res, "view");
        }

        public function otpProcess(Request $request)
        {
                $type = $request->input('type');
                $otp = $request->input('otp');
                $user_id = $request->session()->get('temp_admin_user_id');

                if (empty($user_id)) {
                        $res['status_code'] = 1;
                        $res['message'] = "Please login to continue.";

                        return is_mobile($type, "aloginview", $res);
                }

                $verify = adminModel::where(['id' => $user_id, 'otp' => $otp])->get()->toArray();

                if (count($verify) > 0) {
                        $request->session()->flush();

                        $request->session()->put('admin_user_id', $verify['0']['id']);
                        $request->session()->put('name', $verify['0']['name']);
                        $request->session()->put('email', $verify['0']['email']);

                        $res['status_code'] = 1;
                        $res['message'] = "Login Successfully.";

                        return is_mobile($type, "dashboard", $res);
                } else {
                        $res['status_code'] = 0;
                        $res['message'] = "Invalid OTP.";

                        return is_mobile($type, "aloginviewotp", $res);
                }
        }

        function activated_admin_users(Request $request)
        {
                $type = $request->input('type');
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
                $refferal_code = $request->input('refferal_code');
                $user_id = $request->session()->get('admin_user_id');
                $isExport = $request->input('export') === 'yes';

                $whereStartDate = '';
                $whereEndDate = '';
                $whereRC = '';

                if ($start_date != '') {
                        $whereStartDate = " AND date_format(user_plans.created_on, '%Y-%m-%d') >= '" . date('Y-m-d', strtotime($start_date)) . "'";
                }

                if ($end_date != '') {
                        $whereEndDate = " AND date_format(user_plans.created_on, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime($end_date)) . "'";
                }

                if ($refferal_code != '') {
                        $whereRC = "  AND users.refferal_code = '" . $refferal_code . "' ";
                }
                $query = "SELECT users.*, 
                user_plans.amount, 
                user_plans.created_on AS dateofearning, 
                user_plans.transaction_hash, 
                user_plans.isSynced, 
                user_plans.created_on
                FROM user_plans
                JOIN users ON users.id = user_plans.user_id
                WHERE user_plans.status=1 AND user_plans.transaction_hash ='By Admin' AND 1 = 1  " . $whereStartDate . $whereEndDate . $whereRC;


                if ($isExport) {
                        $data = DB::select($query);

                        $data = array_map(function ($value) {
                                return (array) $value;
                        }, $data);
                        $list = [
                                ['Member Name', 'Member Code', 'Sponsor Code', 'Amount', 'Date', 'Joining Date']
                        ];
                        // Export file path
                        $filePath = '/var/www/html/exports/admin_active_reports.csv';
                        // Open file for writing
                        $fp = fopen($filePath, 'w');
                        foreach ($list as $fields) {
                                fputcsv($fp, $fields);
                        }
                        foreach ($data as $value) {

                                $dataRows = [
                                        $value['name'],
                                        $value['refferal_code'],
                                        $value['sponser_code'],
                                        $value['amount'],
                                        isset($value['dateofearning']) ? date('d-m-Y', strtotime($value['dateofearning'])) : '',
                                        isset($value['created_on']) ? date('d-m-Y', strtotime($value['created_on'])) : '',
                                ];
                                fputcsv($fp, $dataRows);
                        }

                        fclose($fp);
                        return response()->download($filePath)->deleteFileAfterSend(true);
                }



                $admin_activated = userPlansModel::selectRaw("users.*,user_plans.amount,user_plans.created_on as dateofearning, user_plans.transaction_hash, user_plans.isSynced, user_plans.created_on")->join('users', 'users.id', '=', 'user_plans.user_id')->where('user_plans.status', 1)->where('user_plans.transaction_hash', 'By Admin')->whereRaw("1 = 1  " . $whereStartDate . $whereEndDate . $whereRC)->paginate(20)->toArray();

                $res['message'] = "Data loaded successfully";
                $res['status_code'] = 1;
                $res['admin_activated'] = $admin_activated;
                $res['start_date'] = $start_date;
                $res['refferal_code'] = $refferal_code;
                $res['end_date'] = $end_date;

                return is_mobile($type, "admin_activated", $res, "view");
        }
}
