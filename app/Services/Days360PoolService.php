<?php

namespace App\Services;

use App\Models\usersModel;
use App\Models\earningLogsModel;
use App\Models\userPlansModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function App\Helpers\getUserStakeAmount;
use function App\Helpers\coinPriceLive;

class Days360PoolService
{
    public function days360PoolReward()
    {
        // === CONFIGURATION ===
        $POOL_ELIGIBILITY = 5000;
        $POOL_TYPE = 'singlestake'; //partstake
        $POOL_PERCENT = 5;   // 10% of total ROI
        $CUTOFF_HOURS = 24;
        // consider plans within 24 hours
        $cutoff = now()->subHours($CUTOFF_HOURS);
        $coinPrice = coinPriceLive();

        // === 1. FIND ELIGIBLE USERS INVESTED >= 5000 IN LP LOCK FOR 360 Days===
        $elligible_users_query = usersModel::query()
                                                ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                                                ->where('users.status', 1)
                                                ->where('user_plans.status', 1)
                                                ->where('user_plans.package_id', 2) //LP Bond
                                                ->where('user_plans.lock_period', 4) //360Days
                                                ->whereRaw("user_plans.amount * ? >= ?", [$coinPrice, $POOL_ELIGIBILITY])
                                                ->where('user_plans.created_on', '>=', $cutoff) //Witin the cutoff period
                                                ->limit(100); 
                                
        dd($elligible_users_query->toSql(), $elligible_users_query->getBindings());

        $elligibles_users = $elligible_users_query->get(['users.id', 'user_plans.amount', 'user_plans.package_id', 'user_plans.lock_period', 'user_plans.created_on']);

        // dd($sponser_data);

        if($elligibles_users->count() > 0)
        {

            // === 1. FIND INVERSTOR USERS INVESTED >= 5000 IN LP LOCK FOR 360 Days===
            $investors_query = usersModel::query()
                                            ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                                            ->where('users.status', 1)
                                            ->where('user_plans.status', 1)
                                            ->whereIn('user_plans.package_id', [2,3]) //LP Bond and Stable
                                            ->where('user_plans.created_on', '>=', $cutoff); //Witin the cutoff period

            // dd($investors_query->toSql(), $investors_query->getBindings());

            $investors_total = $investors_query->sum('amount');

            echo "Investors Total = ".$investors_total."<br>";

            if($investors_total>0){

                $pool360days_amount = $investors_total * ($POOL_PERCENT / 100) ;

                $elligibleusers = $elligibles_users->count();

                $pool360share = $pool360days_amount / $elligibleusers;

                echo "Pool360days elligibleusers count=".$elligibleusers."<br>";
                echo "Pool360days amount=".$pool360days_amount."<br>";
                echo "Pool360days share=".$pool360share."<br>";

                foreach ($elligibles_users as $user) {
                    echo "User ID: " . $user->id . "<br>";
                    echo "Amount: " . $user->amount . "<br>";
                    echo "Package: " . $user->package_id . "<br>";
                    echo "Lock Period: " . $user->lock_period . "<br>";
                    echo "Created On: " . $user->created_on . "<br><br>";
                }

            }
        }

        //     DB::transaction(function () use ($sponsor, $directs_pool) {
        //         // Insert earning log
        //         earningLogsModel::insert([
        //                                     'user_id'     => $sponsor->id,
        //                                     'amount'      => round($directs_pool, 6),
        //                                     'tag'         => 'DIRECT-POOL-BONUS',
        //                                     'refrence'    => 0,
        //                                     'refrence_id' => 0,
        //                                     'created_on'  => now(),
        //                                 ]);

        //         // Update user pool amount
        //         usersModel::where('id', $sponsor->id)
        //                         ->update(['direct_poolamount' => DB::raw("direct_poolamount + {$directs_pool}")]);
        //     });
        // }

        // // === 5. MARK PLANS AS SYNCED ===
        // userPlansModel::where('isDirectPoolSynced', 0)->update(['isDirectPoolSynced' => 1]);

        // return response()->json(['ok' => true, 'msg' => 'Direct pool reward distributed successfully.']);
    }
}

