<?php

namespace App\Http\Controllers\admin;

use App\Models\settingModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use function App\Helpers\is_mobile;

class settingController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = settingModel::where(['id' => 1])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Setting data loaded successfully.";
        $res['data'] = $data['0'];

        return is_mobile($type, "setting", $res, "view");
    }

    public function store(Request $request)
    {
        $type = $request->input('type');
        $withdraw_setting = $request->input('withdraw_setting');

        $updateData = $request->except('_method','_token','submit','withdraw_setting');


        if($withdraw_setting == 1)
        {
            $updateData['withdraw_setting'] = 1;
        }else
        {
            $updateData['withdraw_setting'] = 0;
        }
        
        $file_name = "";
		if ($request->hasFile('logo')) {
			$file = $request->file('logo');
			$originalname = $file->getClientOriginalName();
			$name = "logo".'_'.date('YmdHis');
			$ext = \File::extension($originalname);
			$file_name = $name . '.' . $ext;
			$path = $file->storeAs('public/', $file_name);
            $updateData['logo'] = $file_name;
		}

        $file_name = "";
		if ($request->hasFile('favicon')) {
			$file = $request->file('favicon');
			$originalname = $file->getClientOriginalName();
			$name = "favicon".'_'.date('YmdHis');
			$ext = \File::extension($originalname);
			$file_name = $name . '.' . $ext;
			$path = $file->storeAs('public/', $file_name);
            $updateData['favicon'] = $file_name;
		}

        settingModel::where(['id' => 1])->update($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Setting data loaded successfully.";

        return is_mobile($type, "setting.index", $res);
    }
}
