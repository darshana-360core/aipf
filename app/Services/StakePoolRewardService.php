<?php

namespace App\Services;

use App\Models\usersModel;
use App\Models\earningLogsModel;
use App\Models\userPlansModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function App\Helpers\getUserStakeAmount;
use function App\Helpers\coinPriceLive;

class StakePoolRewardService
{
    public function StakePoolReward()
    {
        
        // === CONFIGURATION ===
        $POOL_ELIGIBILITY = 5000;
        $POOL_PERCENT = 5;   // 10% of total ROI
        $CUTOFF_HOURS = 24;
           
        // consider plans within 24 hours
        $cutoff = now()->subHours($CUTOFF_HOURS);
        $coin_price = coinPriceLive();
        
        echo "===================== Start Date =============================</br>";
        echo $cutoff."</br>";
        echo "===================== end date =============================</br>";

        echo "===================== Start coin price =============================</br>";
        echo $coin_price."</br>";
        echo "===================== end coin price =============================</br>";

        // $users = userPlansModel::whereIn('package_id', [2,3])      // LP Bond
        //         ->where('lock_period', 4)
        //         ->where("roi" ,">",0)                        // 360 Days
        //         ->whereRaw("amount * ? >= ?", [$coin_price, $POOL_ELIGIBILITY])
        //         ->select("user_id")                              // only user_id
        //         ->distinct()                                     // UNIQUE user_id
        //         ->limit(100)
        //         ->get()
        //         ->toArray();
        
        $users = userPlansModel::whereIn('package_id', [2,3])
                                ->where('lock_period', 4)
                                ->where('roi', '>', 0)
                                ->whereIn('id', function($query) {
                                    $query->selectRaw('MIN(id)')
                                        ->from('user_plans')
                                        ->groupBy('user_id');  // FIRST plan per user
                                })
                                ->whereRaw("amount * ? >= ?", [$coin_price, $POOL_ELIGIBILITY])
                                ->distinct()
                                ->limit(100)
                                ->get()
                                ->toArray();   
           
        echo "===================== Start total eligible User =============================</br>";
        echo count($users)."</br>";
        echo "===================== end total eligible User =============================</br>";

        $totalStakeLat24hrs = userPlansModel::whereIn('package_id', [2,3])
                                ->where('created_on', '>=', $cutoff)
                                ->where('transaction_hash', 'NOT LIKE', '%BYADMIN5000%')
                                ->sum('amount');

        echo "===================== Start totalStakeLat24hrs =============================</br>";
        echo $totalStakeLat24hrs."</br>";
        echo "===================== end totalStakeLat24hrs =============================</br>";
            
        $fivePerOFTotalStakeLast24hrs = $totalStakeLat24hrs * $POOL_PERCENT / 100;
    
        echo "===================== Start fivePerOFTotalStakeLast24hrs =============================</br>";
        echo $fivePerOFTotalStakeLast24hrs."</br>";
        echo "===================== end fivePerOFTotalStakeLast24hrs =============================</br>";
        
        // dd($fivePerOFTotalStakeLast24hrs);

        $profitPrUser =  $fivePerOFTotalStakeLast24hrs / 100;

        echo "===================== Start profitPrUser =============================</br>";
        echo $profitPrUser."</br>";
        echo "===================== end profitPrUser =============================</br>";

        
        foreach ($users as $user) {
            $log = [
                    'user_id'     => $user['user_id'],
                    'amount'      => $profitPrUser,
                    'tag'         => "STAKE-POOL-REWARD",
                    'refrence'    => 0,
                    'refrence_id' => 0,
                    'created_on'  => date('Y-m-d H:i:s'), 
                    "isSynced"    =>1
                ];
            //earningLogsModel::insert($log);
            
            //DB::statement("UPDATE users set stake_pool_reward = (IFNULL(stake_pool_reward,0) + ($profitPrUser)) where id = '" . $user['user_id'] . "'");
                
        }
    }
}

