<?php

namespace App\Http\Controllers\admin;

use App\Models\bankDetailsModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use function App\Helpers\is_mobile;

class bankDetailsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = bankDetailsModel::where(['id' => 1])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Bank Details data loaded successfully.";
        $res['data'] = $data['0'];

        return is_mobile($type, "bank_details", $res, "view");
    }

    public function store(Request $request)
    {
        $type = $request->input('type');
        $user_id = $request->session()->get('admin_user_id');

        $updateData = $request->except('_method','_token','submit');

        $updateData['user_id'] = $user_id;

        bankDetailsModel::where(['id' => 1])->update($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Bank Details data loaded successfully.";

        return is_mobile($type, "bank-details.index", $res);
    }
}
