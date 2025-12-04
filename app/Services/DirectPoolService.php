<?php

namespace App\Services;

use App\Models\usersModel;
use App\Models\earningLogsModel;
use App\Models\userPlansModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function App\Helpers\getUserStakeAmount;
use function App\Helpers\coinPriceLive; 

class DirectPoolService
{
    public function directPoolReward()
    {
        // Log::channel('direct_pool')->info("In Direct Pool Service");

        Log::channel('direct_pool')->info("In Direct Pool Service");

        $POOL_PERCENT = 10;   // 10% of total ROI
        $CUTOFF_HOURS = 12;  // consider plans older than 12 hours
        $cutoff = now()->subHours($CUTOFF_HOURS);

        // === FETCH SPONSORS ===
        $sponsors = usersModel::query()
                            ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                            ->where('users.status', 1)
                            ->where('users.level', '>=', 1)
                            ->groupBy('users.id', 'users.daily_roi')
                            ->get(['users.id', 'users.wallet_address', 'users.daily_roi']);

        Log::channel('direct_pool')->info("Sponsors Found: " . $sponsors->count());

        if ($sponsors->isEmpty()) {
            Log::channel('direct_pool')->info("No eligible sponsors. ");
            return response()->json(['ok' => true, 'msg' => 'No eligible sponsors.']);
        }


        // === 2. GLOBAL POOL === 0.0141098516759447

        // $start='2025-11-21 20:00:00';
        // $end='2025-11-22 08:00:00';

        $totalDailyRoi = earningLogsModel::query()
                            ->where('earning_logs.isSynced', 1)
                            ->where('earning_logs.created_on', '>=', $cutoff)
                            // ->whereBetween('earning_logs.created_on', [$start, $end])
                            ->where('earning_logs.tag', 'ROI')
                            ->get(['amount']);

        $totalDailyRoi = (float) $totalDailyRoi->sum('amount');

        Log::channel('direct_pool')->info("Total daily ROI :".$totalDailyRoi);

        if ($totalDailyRoi <= 0) {
            Log::channel('direct_pool')->info("Total daily ROI is zero.");
            return response()->json(['ok' => true, 'msg' => 'Total daily ROI is zero.']);
        }

        $globalPool = $totalDailyRoi * ($POOL_PERCENT / 100.0);

        Log::channel('direct_pool')->info("Global pool :".$globalPool);

        if ($globalPool <= 0) {
            Log::channel('direct_pool')->info("Global pool is zero.");
            return response()->json(['ok' => true, 'msg' => 'Global pool is zero.']);
        }


        // === 3. TOTAL SYSTEM INVESTMENT ===

        $totalSystemInvestment = usersModel::query()
                                        ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                                        ->where('users.status', 1)
                                        ->where('user_plans.status', 1)
                                        ->where('user_plans.created_on', '>=', $cutoff)
                                        // ->whereBetween('user_plans.created_on', [$start, $end])
                                        ->sum('user_plans.amount');

        Log::channel('direct_pool')->info("Total System Investment:".$totalSystemInvestment);

        if ($totalSystemInvestment <= 0) {
            Log::channel('direct_pool')->info("Total System Investment is zero.");
            return response()->json(['ok' => true, 'msg' => 'Total System Investment is zero.']);
        }


        // === 4. LOOP OVER SPONSORS ===
        foreach ($sponsors as $sponsor) {

            $directData = DB::table('users as u')
                                    ->join('user_plans as p', 'p.user_id', '=', 'u.id')
                                    ->where('u.sponser_id', $sponsor->id)
                                    ->where('u.status', 1)
                                    ->where('p.status', 1)
                                    ->where('p.isDirectPoolSynced', 0)
                                    ->where('p.created_on', '>=', $cutoff)
                                    // ->whereBetween('p.created_on', [$start, $end])
                                    ->get();
                                
            Log::channel('direct_pool')->info("Direct Data:".json_encode($directData));

            if ($directData->isEmpty()) {
                continue;
            }

            $totalDirectInvestment = $directData->sum('amount');
            Log::channel('direct_pool')->info("Sponsor direct investment:".$totalDirectInvestment);

            if ($totalDirectInvestment <= 0) {
                Log::channel('direct_pool')->info("Sponsor direct investment is zero. Skipping.");
                continue;
            }

            // POOL SHARE BASED ON DIRECT INVESTMENT
            $directs_pool = ($totalDirectInvestment / $totalSystemInvestment) * $globalPool;
            Log::channel('direct_pool')->info("Directs Pool:".$directs_pool);


            if ($directs_pool <= 0) {
                continue;
            }

            // STAKED AMOUNT
            $stakedAmount = getUserStakeAmount($sponsor->id);
            $stakedAmountUSDT = $stakedAmount * coinPriceLive();

            Log::channel('direct_pool')->info("Staked Amount:".$stakedAmount);
            Log::channel('direct_pool')->info("Staked Amount USDT:".$stakedAmountUSDT);


            // COEFFICIENT CHECK
            if ($stakedAmountUSDT >= 100 && $stakedAmountUSDT <= 999) {
                $coeff = 0.80;
            } else if ($stakedAmountUSDT >= 1000 && $stakedAmountUSDT <= 2999) {
                $coeff = 0.85;
            } else if ($stakedAmountUSDT >= 3000 && $stakedAmountUSDT <= 4999) {
                $coeff = 0.90;
            } else if ($stakedAmountUSDT >= 5000 && $stakedAmountUSDT <= 9999) {
                $coeff = 0.95;
            } else if ($stakedAmountUSDT >= 10000) {
                $coeff = 1.0;
            } else {
                $coeff = 0;
            }

            if ($coeff <= 0) {
                Log::channel('direct_pool')->info("stakedAmountUSDT is not eligible for coeff.");
                continue;
            }

            Log::channel('direct_pool')->info("Co-efficient:".$coeff);

            $directs_pool = $coeff * $directs_pool;

            Log::channel('direct_pool')->info("Directs pool after co-efficient:".$directs_pool);

            DB::transaction(function () use ($sponsor, $directs_pool) {
                // Insert earning log
                earningLogsModel::insert([
                                            'user_id'     => $sponsor->id,
                                            'amount'      => round($directs_pool, 6),
                                            'tag'         => 'DIRECT-POOL-BONUS',
                                            'refrence'    => 0,
                                            'refrence_id' => 0,
                                            'created_on'  => now(),
                                        ]);

                //Log::channel('direct_pool')->info("Sponsor ID:".$sponsor->id." Amount:".round($directs_pool, 6)." Date:".now());

                // Update user pool amount
                usersModel::where('id', $sponsor->id)
                                ->update(['direct_poolamount' => DB::raw("direct_poolamount + {$directs_pool}")]);

            });
        }

        userPlansModel::where('isDirectPoolSynced', 0)->update(['isDirectPoolSynced' => 1]);

        // return response()->json(['ok' => true, 'msg' => 'Direct pool reward distributed successfully.']);

    }
}

