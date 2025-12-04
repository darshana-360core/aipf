<?php

namespace App\Http\Controllers\admin;

use App\Imports\profitSharingExcel;
use App\Models\rankingExcel;
use App\Models\profitSharingModel;
use App\Models\excelHistoryModel;
use App\Models\usersModel;
use App\Models\myTeamModel;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\DB;

use function App\Helpers\is_mobile;

use App\Http\Controllers\frontend\investmentController;

class profitSharingExcelController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = profitSharingModel::orderBy('id','desc')->take(1)->get()->toArray();

        $excel = excelHistoryModel::where(['excel_type' => 'PS'])->orderBy('id','desc')->get()->toArray();

        foreach($excel as $key => $value)
        {
            $gd = profitSharingModel::selectRaw("count(id) as users, sum(company_sharing) as amount_paid_to_signal, sum(client_sharing) as signal_amount")->where(['date' => $value['date']])->get()->toArray();

            $excel[$key]['total_users'] = $gd['0']['users'];
            $excel[$key]['total_amount_paid_to_signal'] = $gd['0']['amount_paid_to_signal'];
            $excel[$key]['total_signal_amount'] = $gd['0']['signal_amount'];
        }

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;
        $res['excel'] = $excel;

        return is_mobile($type, 'profit_sharing_excel_import', $res , 'view');
    }

    
    
    public function store(Request $request)
    {
        $updateData = $request->except('_method','_token','submit');
        $type = $request->input('type');
        $date = $request->input('date');

        $this->backupDatabase();

        $path = $request->file('file')->getRealPath();

        $file_name = "";
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalname = $file->getClientOriginalName();
            $name = "psexcelfile".'_'.date('Y-m-d-His');
            $ext = \File::extension($originalname);
            $file_name = $name . '.' . $ext;
            $path = $file->storeAs('public/', $file_name);
        }

        if($ext != 'xlsx')
        {
            $res['status_code'] = 0;
            $res['message'] = "Only excel file is allowed.";

            return is_mobile($type, "profitSharingExcel.index", $res);
        }

        $newRow = array();
        $newRow['excel_type'] = "PS";
        $newRow['file_name'] = $file_name;
        $newRow['date'] = $date;

        excelHistoryModel::insert($newRow);
        
        $data = Excel::toArray(new profitSharingExcel, request()->file('file'));

        if(count($data) > 0)
        {
            foreach($data['0'] as $key => $value)
            {
                if($key > 0)
                {                   
                    if($value['0'] != '')
                    {
                        $newRow = array();
                        $newRow['mt5'] = $value['0'];
                        $newRow['refferal_code'] = $value['1'];
                        $newRow['package'] = $value['2'];
                        $newRow['name'] = $value['3'];
                        $newRow['profit'] = $value['4'];
                        $newRow['company_sharing'] = $value['5'];
                        $newRow['client_sharing'] = $value['6'];
                        $newRow['isSynced'] = 0;
                        $newRow['date'] = $date;

                        // $isFound = usersModel::where(['mt5' => $value['2'], 'mt5_verify' => 1])->get()->toArray();
                        // if(count($isFound) > 0)
                        // {
                        //     $newRow['found'] = 1;
                        // }else
                        // {
                        //     $newRow['found'] = 0;
                        // }

                        profitSharingModel::insert($newRow);
                    }          
                }
            }
        }

        $res['status_code'] = 1;
        $res['message'] = "Excel Imported Successfully.";

        return is_mobile($type, "profitSharingExcel.index", $res);
    }

    public function backupDatabase()
    {
        $databaseName = 'vitnixxai'; //env('DB_DATABASE');
        $databaseUser = 'root';//env('DB_USERNAME');
        $databasePassword = 'Crypto@@123';//env('DB_PASSWORD');
        $backupPath = storage_path('app/backups/'.time().'.sql.gz');


        $command = "mysqldump --user={$databaseUser} --password={$databasePassword} {$databaseName} | gzip --best > {$backupPath}";

        $output = shell_exec($command);
    }
}