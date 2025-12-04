<?php

namespace App\Http\Controllers\admin;

use App\Imports\ImportMarketExcel;
use App\Models\marketExcelModel;
use App\Models\excelHistoryModel;
use App\Models\usersModel;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\DB;

use function App\Helpers\is_mobile;

class importExcelController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = marketExcelModel::orderBy('id','desc')->take(1)->get()->toArray();

        $excel = excelHistoryModel::where(['excel_type' => 'BROKERAGE'])->orderBy('id','desc')->get()->toArray();

        foreach($excel as $key => $value)
        {
            $gd = marketExcelModel::selectRaw("count(id) as users, sum(deposits) as deposits, sum(withdraw) as withdraw, sum(volume) as volume, sum(profit) as profit, sum(balance) as balance")->where(['date' => $value['date']])->get()->toArray();

            $excel[$key]['total_users'] = $gd['0']['users'];
            $excel[$key]['total_deposits'] = $gd['0']['deposits'];
            $excel[$key]['total_withdraw'] = $gd['0']['withdraw'];
            $excel[$key]['total_volume'] = $gd['0']['volume'];
            $excel[$key]['total_profit'] = $gd['0']['profit'];
            $excel[$key]['total_balance'] = $gd['0']['balance'];
        }

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;
        $res['excel'] = $excel;

        return is_mobile($type, 'excel_import', $res , 'view');
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
			$name = "excelfile".'_'.date('Y-m-d-His');
			$ext = \File::extension($originalname);
			$file_name = $name . '.' . $ext;
			$path = $file->storeAs('public/', $file_name);
		}

        if($ext != 'xlsx')
        {
            $res['status_code'] = 0;
            $res['message'] = "Only excel file is allowed.";

            return is_mobile($type, "importExcel.index", $res);
        }

        $checkExcel = excelHistoryModel::where(['excel_type' => 'BROKERAGE', 'date' => $date])->get()->toArray();

        if(count($checkExcel) > 0)
        {
            $res['status_code'] = 0;
            $res['message'] = "Already uploaded.";

            return is_mobile($type, "importExcel.index", $res);
        }

        $newRow = array();
        $newRow['excel_type'] = "BROKERAGE";
        $newRow['file_name'] = $file_name;
        $newRow['date'] = $date;

        excelHistoryModel::insert($newRow);
        
        $data = Excel::toArray(new ImportMarketExcel, request()->file('file'));

        if(count($data) > 0)
        {
         foreach($data['0'] as $key => $value)
         {
            if($key > 0)
            {                   
                if($value['0'] != '')
                {
                    $newRow = array();
                    $newRow['mt_acc'] = $value['0'];
                    $newRow['name'] = $value['1'];
                    $newRow['deposits'] = $value['2'];
                    $newRow['withdraw'] = $value['3'];
                    $newRow['volume'] = $value['4']/100;
                    $newRow['swaps'] = $value['5'];
                    $newRow['commission'] = $value['6'];
                    $newRow['profit'] = $value['7']/100;
                    $newRow['balance'] = $value['8']/100;
                    $newRow['isSynced'] = 0;
                    $newRow['date'] = $date;

                    $isFound = usersModel::where(['mt5' => $value['0'], 'mt5_verify' => 1])->get()->toArray();
                    if(count($isFound) > 0)
                    {
                        $newRow['found'] = 1;
                    }else
                    {
                        $newRow['found'] = 0;
                    }

                    $dayName = date("l");

                    // if($dayName != "Tuesday")
                    // {
                    //     $newRow['volume'] = 0;
                    // }

                    marketExcelModel::insert($newRow);

                    usersModel::where(['mt5' => $value['0'], 'mt5_verify' => 1])->update(['balance' => $value['8']/100]);
                }          
            }
         }
        }        

        $res['status_code'] = 1;
        $res['message'] = "Excel Imported Successfully.";

        return is_mobile($type, "importExcel.index", $res);
    }

    public function destroy(Request $request, $id)
    {

        $type = $request->input('type');

        $getDate = excelHistoryModel::where(['id' => $id])->get()->toArray();

        $date = $getDate['0']['date'];

        $deleteData = excelHistoryModel::where(['id' => $id])->delete();

        $deleteData = marketExcelModel::where(['date' => $date])->delete();

        $res['status_code'] = 1;
        $res['message'] = "Deleted Successfully";

        return is_mobile($type, 'importExcel.index', $res);
    }

    public function backupDatabase()
    {
        $databaseName = 'finlyai'; //env('DB_DATABASE');
        $databaseUser = 'root';//env('DB_USERNAME');
        $databasePassword = 'Crypto@@123';//env('DB_PASSWORD');
        $backupPath = storage_path('app/backups/'.time().'.sql.gz');


        $command = "mysqldump --user={$databaseUser} --password={$databasePassword} {$databaseName} | gzip --best > {$backupPath}";

        $output = shell_exec($command);
    }
}
