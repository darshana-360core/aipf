<?php

namespace App\Http\Controllers\admin;

use App\Jobs\RunArtisanCommand;
use App\Models\packageModel;
use App\Models\usersModel;
use App\Models\userPlansModel;
use App\Models\packageTransaction;
use App\Models\levelRoiModel;
use App\Models\poolModel;
use App\Models\settingModel;
use App\Models\earningLogsModel;
use App\Models\rp3TransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use function App\Helpers\is_mobile;
use function App\Helpers\getBalance;
use function App\Helpers\getTotalIncome;
use function App\Helpers\getUserMaxReturn;
use function App\Helpers\todayCapping;
use function App\Helpers\getRefferer;
use function App\Helpers\getReffererUser;
use function App\Helpers\findUplineRank;

use App\Http\Controllers\frontend\loginController;

class CustomRequest extends Request
{
    public function input($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->all();
        }

        return $this->get($key, $default);
    }
}

class packageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = packageModel::get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;

        return is_mobile($type, "package", $res, 'view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $updateData = $request->except('_method', '_token', 'submit');

        $type = $request->input('type');

        packageModel::insert($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Insert successfully";

        return is_mobile($type, "package.index", $res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $type = $request->input('type');

        $editData = packageModel::where(['id' => $id])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['editData'] = $editData[0];

        return is_mobile($type, 'package', $res, 'view');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updateData = $request->except('_method', '_token', 'submit');

        $type = $request->input('type');

        packageModel::where(['id' => $id])->update($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Updated successfully";

        return is_mobile($type, "package.index", $res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $type = $request->input('type');

        $deleteData = packageModel::where(['id' => $id])->delete();

        $res['status_code'] = 1;
        $res['message'] = "Deleted Successfully";

        return is_mobile($type, 'package.index', $res);
    }

    public function searchMember(Request $request)
    {
        $type = $request->input('type');
        $member_code = $request->input('member_code');

        if ($member_code != null) {
            $user = usersModel::whereRaw("(refferal_code = '" . $member_code . "' or wallet_address like '" . $member_code . "' or name like '%" . $member_code . "%' or email like '%" . $member_code . "%')")->take(1)->get()->toArray();

            if (count($user) == 0) {
                $res['status_code'] = 0;
                $res['message'] = "Member code does not exist";

                return is_mobile($type, 'searchMember', $res);
            }

            $user['0']['balance'] = getBalance($user['0']['id']);

            $packages = userPlansModel::selectRaw('GROUP_CONCAT(amount) as package_amount')->where(['user_id' => $user['0']['id']])->get()->toArray();

            $user['0']['packages'] = $packages['0']['package_amount'];
            $res['user'] = $user;
            $res['member_code'] = $member_code;

            $packages = packageModel::get()->toArray();

            $checkPackage = userPlansModel::where(['user_id' => $user['0']['id'], 'status' => 1])->get()->toArray();

            if (count($checkPackage) == 0) {
                $checkPackage = userPlansModel::where(['user_id' => $user['0']['id'], 'status' => 2])->orderBy('id', 'desc')->get()->toArray();
            }

            if (count($checkPackage) > 0) {
                $res['current_package'] = $checkPackage['0']['amount'];

                foreach ($packages as $pkey => $pvalue) {
                    if ($checkPackage['0']['amount'] > $pvalue['amount']) {
                        unset($packages[$pkey]);
                    }
                }
            }

            $res['packages'] = $packages;
        }

        $res['status_code'] = 1;
        $res['message'] = "Search member here";

        return is_mobile($type, 'memeber_package', $res, "view");
    }


    public function processpackage(Request $request)
    {
        $type = $request->input('type');
        $amount = $request->input('amount');
        $user_id = $request->input('user_id');

        $users = usersModel::where(['id' => $user_id])->get()->toArray();

        $userPlanStatus = 1;

        if ($amount >= 10 && $amount <= 499) {
            $package = 1;
        } else if ($amount >= 500 && $amount <= 999) {
            $package = 2;
        } else if ($amount >= 1000 && $amount <= 2999) {
            $package = 3;
        } else if ($amount >= 3000 && $amount <= 5999) {
            $package = 4;
        } else if ($amount >= 6000 && $amount <= 9999) {
            $package = 5;
        } else if ($amount >= 10000) {
            $package = 6;
        }

        $packageData = packageModel::where(['status' => 1, 'id' => $package])->get()->toArray();

        $userPlans = userPlansModel::where(['status' => 1, 'user_id' => $user_id])->get()->toArray();

        // if (count($userPlans) > 0) {
        //     foreach ($userPlans as $key => $value) {
        //         userPlansModel::where(['id' => $value['id']])->update(['status' => 0]);
        //     }
        // }

        $packageData = $packageData['0'];

        $user_plans = array();
        $user_plans['user_id'] = $user_id;
        $user_plans['package_id'] = $package;
        $user_plans['amount'] = $amount;
        $user_plans['roi'] = $packageData['roi'];
        $user_plans['days'] = $packageData['days'];
        $user_plans['transaction_hash'] = "By Admin";
        $user_plans['unique_th'] = date('YmdHis');
        $user_plans['isSynced'] = 1;
        $user_plans['status'] = 1;
        $user_plans['created_on'] = date('Y-m-d H:i:s');

        userPlansModel::insert($user_plans);

        if ($users['0']['sponser_id'] > 0) {

            $checkIfFirstPackage = userPlansModel::where('id', $user_id)->get()->toArray();

            if (count($checkIfFirstPackage) == 1) {
                usersModel::where('id', $users['0']['sponser_id'])->update(['active_direct' => DB::raw('active_direct + 1')]);
            }

            usersModel::where('id', $users['0']['sponser_id'])->update(['direct_business' => DB::raw('direct_business + ' . $amount)]);
        }

        $res['status_code'] = 1;
        $res['message'] = "Package activated successfully";

        return is_mobile($type, "searchMember", $res);
    }

    public function depositOther(Request $request)
    {
        $type = $request->input('type');

        $depositPending = packageTransaction::selectRaw('package_transaction.*, users.refferal_code, users.created_on as joining')->join('users', 'users.id', '=', 'package_transaction.user_id')->where(['isSynced' => 0])->whereRaw("transaction_hash = 'By Other'")->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Package activated successfully";
        $res['data'] = $depositPending;

        return is_mobile($type, "verify_deposit", $res, "view");
    }

    public function depositOtherProcess(Request $request)
    {
        $type = $request->input('type');
        $ptid = $request->input('ptid');
        $decision = $request->input('decision');

        $getPtid = packageTransaction::where(['id' => $ptid, 'isSynced' => 0])->get()->toArray();

        if (count($getPtid) == 0) {
            $res['status_code'] = 1;
            $res['message'] = "Package is already processed.";
        }

        if ($decision == 0) {
            packageTransaction::where(['id' => $ptid])->update(['isSynced' => 2]);
        } else {
            packageTransaction::where(['id' => $ptid])->update(['isSynced' => 1]);

            $package = packageTransaction::where(['id' => $ptid])->get()->toArray();

            $value = $package['0'];

            $appHome = new loginController;

            $request->request->set('transaction_hash', $value['transaction_hash']);
            $request->request->set('amount', $value['amount'] / $value['usdt_conversion']);
            $request->request->set('package', $value['package_id']);
            $request->request->set('user_id', $value['user_id']);
            $request->request->set('type', "API");

            $customRequest = new CustomRequest();
            $customRequest->initialize(
                $request->query->all(),
                $request->request->all(),
                $request->attributes->all(),
                $request->cookies->all(),
                $request->files->all(),
                $request->server->all(),
                $request->getContent()
            );

            $appHome->processpackage($customRequest);
        }

        $res['status_code'] = 1;
        $res['message'] = "Package activated successfully";

        return is_mobile($type, "depositOther", $res);
    }

    public function depositOtherReport(Request $request)
    {
        $type = $request->input('type');

        $data = userPlansModel::selectRaw('user_plans.*, users.refferal_code, users.level, users.sponser_code, users.rank, users.created_on as joining')->join('users', 'users.id', '=', 'user_plans.user_id')->where(['transaction_hash' => "By Other"])->orderBy("id", "desc")->get()->toArray();


        $res['status_code'] = 1;
        $res['message'] = "Package activated successfully";
        $res['data'] = $data;

        return is_mobile($type, "deposit_other_report", $res, "view");
    }

    
    function process_rp3_transaction(Request $request){
        $type = $request->input('type');
        $admin_user_id = $request->session()->get('admin_user_id');
        $user_id = $request->input('user_id');
        $amount = $request->input('amount');
        $user = usersModel::where('id',$user_id)->first();
        $member_code=  $user->refferal_code;
        
        $rp3transaction=new rp3TransactionModel;
        $rp3transaction->user_id=$user_id;
        $rp3transaction->amount=$amount;
        $rp3transaction->created_by=$admin_user_id;
        $rp3transaction->save();

        $rp3sum=(int)$user->RP3+$amount;
        $user = usersModel::where('id',$user_id)->update([
            'RP3'=>$rp3sum
        ]);


        $res['status_code'] = 1;
        $res['message'] = "Transaction Added Successfully";
        $res['member_code'] = $member_code;
        return is_mobile($type, 'searchMember', $res);
    }
}
