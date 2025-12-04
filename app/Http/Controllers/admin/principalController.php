<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\usersModel;
use App\Models\withdrawModel;
use App\Models\userPlansModel;
use Illuminate\Http\Request;

use function App\Helpers\is_mobile;

class principalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = withdrawModel::selectRaw("withdraw.*, users.name, users.refferal_code")->join('users', 'users.id', '=', 'withdraw.user_id')->where(['withdraw.withdraw_type' => "PRINCIPAL", 'withdraw.status' => 0, 'withdraw.isSynced' => 5, 'withdraw.isRequestSynced' => 5])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;

        return is_mobile($type, "principal", $res, 'view');
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
        $updateData = $request->except('_method','_token','submit');
        
        $type = $request->input('type');

        withdrawModel::insert($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Insert successfully";

        return is_mobile($type, "principal.index", $res);
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

        $editData = withdrawModel::where(['id' => $id])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['editData'] = $editData[0];

        return is_mobile($type, 'principal', $res, 'view');
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
        $updateData = $request->except('_method','_token','submit');
        
        $type = $request->input('type');

        // withdrawModel::where(['id' => $id])->update($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Something Went Wrong Please Try Again Later.";

        return is_mobile($type, "principal.index", $res);
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

        $res['status_code'] = 1;
        $res['message'] = "Something Went Wrong Please Try Again Later.";

        return is_mobile($type, 'principal.index', $res);
    }
}