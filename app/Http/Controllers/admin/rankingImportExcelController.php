<?php

namespace App\Http\Controllers\admin;

use App\Imports\ImportMarketExcel;
use App\Models\rankingExcel;
use App\Models\usersModel;
use App\Models\myTeamModel;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\DB;

use function App\Helpers\is_mobile;

use App\Http\Controllers\frontend\investmentController;

class rankingImportExcelController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = rankingExcel::orderBy('id','desc')->take(1)->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;

        return is_mobile($type, 'ranking_excel_import', $res , 'view');
    }

    
    
    public function store(Request $request)
    {
        $updateData = $request->except('_method','_token','submit');
        $type = $request->input('type');

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

            return is_mobile($type, "RankingImportExcel.index", $res);
        }
        
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
                        $newRow['isSynced'] = 1;
                        $newRow['date'] = $date;

                        rankingExcel::insert($newRow);

                        usersModel::where(['mt5' => $value['0'], 'mt5_verify' => 1])->update(['balance' => $value['8']/100]);
                    }          
                }
            }
        }

        $users = usersModel::where(['status' => 1])->get()->toArray();

        foreach($users as $ku => $kv)
        {
            $getMyBusiness = myTeamModel::selectRaw("IFNULL(SUM(users.balance),0) as my_business")->join('users', 'users.id', '=', 'my_team.team_id')->where(['my_team.user_id' => $kv['id']])->get()->toArray();

            if(count($getMyBusiness) > 0)
            {
                DB::statement("UPDATE users set my_business = '".$getMyBusiness['0']['my_business']."' where id = ".$kv['id']);          
            }
        }

        $appHome = new investmentController;

        $appHome->checkUserLevel($request);

        $res['status_code'] = 1;
        $res['message'] = "Excel Imported Successfully.";

        return is_mobile($type, "RankingImportExcel.index", $res);
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