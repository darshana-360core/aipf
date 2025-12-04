<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\rankBonusModel;
use App\Models\rankingModel;
use Illuminate\Http\Request;

use function App\Helpers\is_mobile;

class rankBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = rankBonusModel::get()->toArray();

        $ranks = rankingModel::get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;
        $res['ranks'] = $ranks;

        return is_mobile($type, "rank-bonus", $res, 'view');
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

        rankBonusModel::insert($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Insert successfully";

        return is_mobile($type, "rank-bonus.index", $res);
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

        $editData = rankBonusModel::where(['id' => $id])->get()->toArray();

        $ranks = rankingModel::get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['editData'] = $editData[0];
        $res['ranks'] = $ranks;

        return is_mobile($type, 'rank-bonus', $res, 'view');
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

        rankBonusModel::where(['id' => $id])->update($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Updated successfully";

        return is_mobile($type, "rank-bonus.index", $res);
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

        $deleteData = rankBonusModel::where(['id' => $id])->delete();

        $res['status_code'] = 1;
        $res['message'] = "Deleted Successfully";

        return is_mobile($type, 'level-roi.index', $res);
    }
}