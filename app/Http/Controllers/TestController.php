<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\levelRoiModel;
use App\Models\packageTransaction;
use App\Models\rankingModel;
use App\Models\userPlansModel;
use App\Models\usersModel;
use App\Models\earningLogsModel;
use App\Models\user_stablebond_details;
use App\Models\rewardBonusModel;
use App\Models\withdrawModel;
use App\Models\loginLogsModel;
use App\Models\myTeamModel;
use App\Models\suspiciousStake;
use App\Models\suspiciousBalance;
use App\Models\levelEarningLogsModel;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function App\Helpers\is_mobile;
use function App\Helpers\getBalance;
use function App\Helpers\getIncome;
use function App\Helpers\getTeamRoi;
use function App\Helpers\coinPrice;
use function App\Helpers\getTreasuryBalance;
use function App\Helpers\verifyRSVP;
use function App\Helpers\fetchJson;
use function App\Helpers\getUserStakeAmount;
use function App\Helpers\activeDirect;
use function App\Helpers\isUserActive;

use function App\Helpers\coinPriceLive; 

use Illuminate\Support\Facades\Log;


// use App\Services\Days360PoolService;

class TestController extends Controller
{
    public function testTest()
    {
        // echo "<h1>Welcome to AIPF</h1>";
        // // $test = getUserStakeAmount(6);
        // // echo $test;
        // // $counts = oneActiveDirect(2);
        // // echo "COunts=".$counts;

        // // $userId = 15;

        // echo "Coin Price Live=".coinPriceLive();

        // $js = '{
        //             "16": [
        //                 {
        //                     "direct": 27,
        //                     "amount": "96.930639116165",
        //                     "roi_amount": 0.484653,
        //                     "percent": 10,
        //                     "refCode": "406879",
        //                     "entryDate": "2025-11-21 08:00:01",
        //                     "investment_id": 30
        //                 }
        //             ]
        //         }';

        // $validNodes = json_decode($js, true);

        // echo "<pre>";
        // print_r($validNodes);
        // echo "</pre>";

        // foreach ($validNodes as $sponsorId => $directs) {

        //     echo "here1\n";

        //     // Ensure $directs is always a list of directs
        //     if (!isset($directs[0]) || !is_array($directs[0])) {
        //         $directs = [$directs];
        //     }

        //     echo "here2\n";
        //     print_r($directs);

           

        //     echo "Coin Price: " . $coin_price;


        //         // Check if ANY direct has amount * coinPrice >= 100
        //         $hasValidAmount = collect($directs)->contains(function ($direct) use ($coin_price) {
        //         return $direct['amount'] * $coin_price >= 100;
        //     });

        //     echo "here3 -> ";
        //     var_dump($hasValidAmount);

        //     if (!$hasValidAmount) {
        //         continue; // skip this sponsor
        //     }

        //     // If needed, continue processing here

        //     foreach ($directs as $direct) {
        //                 // dump("Processing sponsor {$sponsorId}", $direct);

        //                 $receiverId = (int)$sponsorId;
        //                 if (!isUserActive($receiverId)) continue;


        //                 $pct = $direct['percent'] ?? 0;
        //                 if ($pct <= 0) continue;

        //                 $amt = round(($direct['roi_amount'] * $pct) / 100, 6);
        //                 if ($amt <= 0) continue;


        //                 $log = [
        //                     'user_id'     => $receiverId,
        //                     'amount'      => $amt,
        //                     'tag'         => "LEADERSHIP-REF-INCOME",
        //                     'refrence'    => $direct['refCode'],
        //                     'refrence_id' => $direct['investment_id'],
        //                     'created_on'  => $direct['entryDate'], 
        //                 ];
        //              echo "<pre>"; print_r($log);   
                     
        //             }
        // }

        /*$validNodes = [
                        [
                            "direct"=> 19,
                            "amount"=> "2.262445533821",
                            "roi_amount"=> 0.011312,
                            "percent"=> 10,
                            "refCode"=> "2dDDF9",
                            "entryDate"=> "2025-11-21 08:00:01",
                            "investment_id"=> 52
                        ],
                        [
                            "direct"=> 19,
                            "amount"=> "20.919914402920586",
                            "roi_amount"=> 0.1046,
                            "percent"=> 10,
                            "refCode"=> "2dDDF9",
                            "entryDate"=> "2025-11-21 08:00:01",
                            "investment_id"=> 51
                        ],
                        [
                            "direct"=> 19,
                            "amount"=> "4973.669394226962460732",
                            "roi_amount"=> 24.868347,
                            "percent"=> 10,
                            "refCode"=> "2dDDF9",
                            "entryDate"=> "2025-11-21 08:00:01",
                            "investment_id"=> 28
                        ]
                    ];
            */

        /*foreach ($validNodes as $sponsorId => $directs) {

            // Convert single direct to array of directs if needed
            if (!is_array(reset($directs))) {
                $directs = [$directs];
            }

            // Check if ANY direct has amount >= 100
            $hasValidAmount = collect($directs)->contains(function ($direct) {
                return $direct['amount'] >= 100;
            });

            if (!$hasValidAmount) {
                // Skip this sponsor
                continue;
            }

            // Process all directs for this sponsor
            foreach ($directs as $direct) {
                // dump("Processing sponsor {$sponsorId}", $direct);

                $receiverId = (int)$sponsorId;
                if (!isUserActive($receiverId)) continue;

                echo "ROI Release... distributeLeadershipReferralIncome Userid=".$receiverId."\n";

                $pct = $direct['percent'] ?? 0;
                if ($pct <= 0) continue;

                $amt = round(($direct['roi_amount'] * $pct) / 100, 6);
                if ($amt <= 0) continue;

                echo "ROI Release... distributeLeadershipReferralIncome Userid=".$receiverId." Amount=".$amt."\n";

                $log = [
                    'user_id'     => $receiverId,
                    'amount'      => $amt,
                    'tag'         => "LEADERSHIP-REF-INCOME",
                    'refrence'    => $direct['refCode'],
                    'refrence_id' => $direct['investment_id'],
                    'created_on'  => $direct['entryDate'], 
                ];
                
                levelEarningLogsModel::insert($log);

                DB::statement("
                    UPDATE users
                    SET level_income = IFNULL(level_income,0) + (?)
                    WHERE id = ?
                ", [$amt, $receiverId]);

            }
        }*/
        // $legBusiness = usersModel::select('users.id','users.refferal_code','users.my_business')
        //                                 ->leftJoin('user_plans', 'user_plans.user_id', '=', 'users.id')
        //                                 ->where('users.sponser_id', $userId)
        //                                 ->groupBy('users.id', 'users.strong_business', 'users.refferal_code', 'users.my_business')
        //                                 ->orderByRaw('my_business DESC')
        //                                 ->get()
        //                                 ->toArray();
                                        
        /*foreach ($legBusiness as $k2 => $v2) {
            $userPlansAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")
                                                    ->where(['user_id' => $v2['id']])
                                                    ->whereRaw("roi > 0 and isSynced != 2")
                                                    ->get()->toArray();

            $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                                                    ->where('user_id', '=', $v2['id'])
                                                    ->where('withdraw_type', '=', "UNSTAKE")
                                                    ->get()->toArray();

            $legBusiness[$k2]['my_business'] =
                (($v2['my_business'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']) < 0
                ? 0
                : (($v2['my_business'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']);
        }*/

        // usort($legBusiness, function ($a, $b) {
        //     return ($b["my_business"] <=> $a["my_business"]);
        // });

        // $strongBusiness = 0;
        // $weakBusiness = 0;
        // foreach ($legBusiness as $k2 => $v2) {
        //     if ($k2 == 0) {
        //         $strongBusiness += $v2['my_business'];
        //     } else {
        //         $weakBusiness += $v2['my_business'];
        //     }
        // }

        
        // echo 'strong='.$strongBusiness.', weak='.$weakBusiness."<br><br>";


        // $directs = usersModel::select(
        //                                 'users.id',
        //                                 DB::raw('SUM(user_plans.amount) as total_amount')
        //                             )
        //                             ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
        //                             ->where('users.sponser_id', 15)
        //                             ->groupBy('users.id')
        //                             ->having('total_amount', '>=', 100)
        //                             ->get();
        // // print_r($directs->toArray());                                    
        // echo "COUNT:". $directs->count();

        $testt = '1';

        if($testt=='1')
        {
            $apiUrl = "https://aipf-api.vercel.app/aipf-price";

            $coinresponse = file_get_contents($apiUrl);
            $coindata = json_decode($coinresponse, true);

            // Extract coin price
            $coin_price = $coindata['price'] ?? 0;

            echo "===================== Start coin price =============================</br>";
            echo $coin_price."</br>";
            echo "===================== end coin price =============================</br>";
            // === CONFIGURATION ===
            $POOL_ELIGIBILITY = 5000;
            $POOL_TYPE = 'singlestake'; //partstake
            $POOL_PERCENT = 5;   // 10% of total ROI
            $CUTOFF_HOURS = 24;
            // consider plans within 24 hours
            $cutoff = now()->subHours($CUTOFF_HOURS);
            $coinPrice = coinPrice();


            $users = userPlansModel::where('package_id', 2)      // LP Bond
                    ->where('lock_period', 4)                        // 360 Days
                    ->whereRaw("amount * ? >= ?", [$coin_price, $POOL_ELIGIBILITY])
                    ->select("user_id")                              // only user_id
                    ->distinct()                                     // UNIQUE user_id
                    ->limit(100)
                    ->get()
                    ->toArray();
            
            // echo "<pre>"; print_r($elligible_users_query); echo "</pre>"; dd('STOP');

            // dd($elligible_users_query->toSql(), $elligible_users_query->getBindings());

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
            
            $fivePerOFTotalStakeLat24hrs = $totalStakeLat24hrs * 5 / 100;
        
            echo "===================== Start fivePerOFTotalStakeLat24hrs =============================</br>";
            echo $fivePerOFTotalStakeLat24hrs."</br>";
            echo "===================== end fivePerOFTotalStakeLat24hrs =============================</br>";
            
            // dd($fivePerOFTotalStakeLat24hrs);

            $profitPrUser =  $fivePerOFTotalStakeLat24hrs / count($users);

            echo "===================== Start profitPrUser =============================</br>";
            echo $profitPrUser."</br>";
            echo "===================== end profitPrUser =============================</br>";

            
            foreach ($users as $user) {
                
                // dd($profitPrUser, $user['user_id']);
                $log = [
                        'user_id'     => $user['user_id'],
                        'amount'      => $profitPrUser,
                        'tag'         => "FIVE-PERCENTAGE-POOL-REWARD",
                        'refrence'    => 0,
                        'refrence_id' => 0,
                        'created_on'  => date('Y-m-d H:i:s'), 
                        "isSynced"    =>1
                    ];

                 DB::statement("UPDATE users set five_percentage_pool = (IFNULL(five_percentage_pool,0) + ($profitPrUser)) where id = '" . $user['user_id'] . "'");
                    
            }





            // -----------------------------------------------------------
            // Step 3: Show eligible users list
            // -----------------------------------------------------------
            // echo "<h3>Eligible Users (Top 100)</h3><pre>";
            // print_r($eligible_users);
            // echo "</pre><br>";


            if (count($eligible_users) > 0) {

                // -----------------------------------------------------------
                // Step 4: Fetch all investors in cutoff
                // -----------------------------------------------------------
                echo "<h3>Step 3: Fetching All Investors Within Cutoff...</h3>";

                $investors_query = userPlansModel::query()
                                                ->join('users', 'users.id', '=', 'user_plans.user_id')
                                                ->where('users.status', 1)
                                                ->where('user_plans.status', 1)
                                                ->whereIn('user_plans.package_id', [2, 3])  // LP Bond & Stable
                                                // ->where('user_plans.created_on', '>=', $cutoff)
                                                ->select('user_plans.amount',
                                                        'user_plans.user_id',
                                                        'user_plans.package_id',
                                                        'user_plans.compound_amount',
                                                        'user_plans.lock_period',
                                                        'user_plans.created_on',
                                                        'user_plans.coin_price',
                                                        DB::raw("ROUND(user_plans.amount * {$coin_price}, 6) AS USDT"));

                $investors_users = $investors_query->get();

                echo "✔ Total investor records found: " . count($investors_users) . "<br><br>";

                echo "<b>Investor User Records:</b><pre>";
                // print_r($investors_users->toArray());

                foreach ($investors_users as $index => $item) {
                    echo "<pre>";
                    echo "---- Investor Record #" . ($index + 1) . " ----\n";
                    echo "User ID          : " . $item->user_id . "\n";
                    echo "Amount           : " . $item->amount . "(USDT:".$item->USDT.")" . "\n";
                    echo "Compound Amount  : " . $item->compound_amount . "\n";
                    echo "Package Id       : " . $item->package_id . "\n";
                    echo "Lock Period      : " . $item->lock_period . "\n";
                    echo "Stake ID         : " . $item->contract_stakeid . "\n";
                    echo "Coin Price       : " . $item->coin_price . "\n";
                    echo "Created On       : " . $item->created_on . "\n";
                    echo "-------------------------------\n";
                    echo "</pre>";
                }


                echo "</pre><br>";

                // -----------------------------------------------------------
                // Step 5: Calculate total investment
                // -----------------------------------------------------------
                $investors_total = $investors_query->sum('amount');

                echo "<h3>Step 4: Investment Summary</h3>";
                echo "Total Investment (within cutoff): <b>" . $investors_total . "</b><br><br>";


                if ($investors_total > 0) {

                    // -----------------------------------------------------------
                    // Step 6: Pool calculation
                    // -----------------------------------------------------------
                    $pool360days_amount = $investors_total * ($POOL_PERCENT / 100);
                    $elligible_count = count($eligible_users);
                    $pool360share = $pool360days_amount / $elligible_count;

                    echo "<h3>Step 5: 360 Days Pool Calculation</h3>";
                    echo "Eligible Users Count: <b>" . $elligible_count . "</b><br>";
                    echo "Pool Amount (" . $POOL_PERCENT . "% of ".$investors_total."): <b>" . $pool360days_amount . "</b><br>";
                    echo "Per User Share: <b>" . $pool360share . "</b><br><br>";


                    // -----------------------------------------------------------
                    // Step 7: Display eligible user breakdown
                    // -----------------------------------------------------------
                    echo "<h3>Step 6: Eligible Users Breakdown</h3>";

                    foreach ($eligible_users as $user) {
                        echo "<b>User ID:</b> {$user['id']}<br>";
                        echo "<b>Amount:</b> {$user['amount']} + {$pool360share} = ".$user['amount']+$pool360share."<br>";
                        echo "<b>Package:</b> {$user['package_id']}<br>";
                        echo "<b>Lock Period:</b> {$user['lock_period']}<br>";
                        echo "<b>Created On:</b> {$user['created_on']}<br><br>";
                    }
                }
            }
        }

        // DIRECT POOL CALCULATION
        if($testt=='2')
        {
            $POOL_PERCENT = 10;   // 10% of total ROI
            $CUTOFF_HOURS = 12;  // consider plans older than 12 hours
            $cutoff = now()->subHours($CUTOFF_HOURS);

            // === FETCH SPONSORS ===
            echo "\n[DP] Fetching eligible sponsors...<br>";
            echo "\n[DP] CUTOFF ".$cutoff."<br>";
            $sponsors = usersModel::query()
                                ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                                ->where('users.status', 1)
                                ->where('users.level', '>=', 1)
                                ->groupBy('users.id', 'users.daily_roi')
                                ->get(['users.id', 'users.wallet_address', 'users.daily_roi']);

            echo "\n[DP] Sponsors Found: " . $sponsors->count()."<br>";

            if ($sponsors->isEmpty()) {
                echo "\n[DP] No eligible sponsors.<br>";
                return response()->json(['ok' => true, 'msg' => 'No eligible sponsors.']);
            }


            // === 2. GLOBAL POOL === 0.0141098516759447

            $totalDailyRoi = earningLogsModel::query()
                                ->where('earning_logs.isSynced', 1)
                                ->where('earning_logs.created_on', '>=', $cutoff)
                                ->where('earning_logs.tag', 'ROI')
                                ->get(['amount']);

            $totalDailyRoi = (float) $totalDailyRoi->sum('amount');

            echo "\n[DP] Total Daily ROI = $totalDailyRoi<br>";

            if ($totalDailyRoi <= 0) {
                echo "\n[DP] Total daily ROI is zero.<br>";
                return response()->json(['ok' => true, 'msg' => 'Total daily ROI is zero.']);
            }

            $globalPool = $totalDailyRoi * ($POOL_PERCENT / 100.0);
            echo "\n[DP] Global Pool ($POOL_PERCENT%) = $globalPool";

            if ($globalPool <= 0) {
                echo "\n[DP] Global pool is zero.<br>";
                return response()->json(['ok' => true, 'msg' => 'Global pool is zero.']);
            }


            // === 3. TOTAL SYSTEM INVESTMENT ===
            echo "\n[DP] Calculating Total System Investment...<br>";

            $totalSystemInvestment = usersModel::query()
                ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                ->where('users.status', 1)
                ->where('user_plans.status', 1)
                ->where('user_plans.created_on', '>=', $cutoff)
                ->sum('user_plans.amount');

            echo "\n[DP] Total System Investment = $totalSystemInvestment<br>";

            if ($totalSystemInvestment <= 0) {
                echo "\n[DP] Total System Investment is zero.<br>";
                return response()->json(['ok' => true, 'msg' => 'Total System Investment is zero.']);
            }


            // === 4. LOOP OVER SPONSORS ===
            echo "\n[DP] Processing Each Sponsor...<br>";

            foreach ($sponsors as $sponsor) {

                echo "\n\n[DP] --- Sponsor ID: {$sponsor->id} ---<br>";

                $directData = DB::table('users as u')
                    ->join('user_plans as p', 'p.user_id', '=', 'u.id')
                    ->where('u.sponser_id', $sponsor->id)
                    ->where('u.status', 1)
                    ->where('p.status', 1)
                    ->where('p.isDirectPoolSynced', 0)
                    ->where('p.created_on', '>=', $cutoff)
                    ->get();

                echo "\n[DP] Directs Found: " . $directData->count()."<br>";

                if ($directData->isEmpty()) {
                    echo "\n[DP] No directs for Sponsor {$sponsor->id}. Skipping.<br>";
                    continue;
                }

                $totalDirectInvestment = $directData->sum('amount');
                echo "\n[DP] Total Direct Investment = $totalDirectInvestment<br>";

                if ($totalDirectInvestment <= 0) {
                    echo "\n[DP] Sponsor direct investment is zero. Skipping.<br>";
                    continue;
                }

                // POOL SHARE BASED ON DIRECT INVESTMENT
                $directs_pool = ($totalDirectInvestment / $totalSystemInvestment) * $globalPool;

                echo "\n[DP] Direct Pool Share = $directs_pool<br>";

                if ($directs_pool <= 0) {
                    echo "\n[DP] Sponsor direct pool is zero. Skipping.<br>";
                    continue;
                }

                // STAKED AMOUNT
                $stakedAmount = getUserStakeAmount($sponsor->id);
                $stakedAmountUSDT = $stakedAmount * coinPriceLive();

                echo "\n[DP] SponsorID=".$sponsor->id.", Wallet Address=".$sponsor->wallet_address.", Staked Amount = ".$stakedAmount." USDT=".$stakedAmountUSDT."<br>";

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

                echo "\n[DP] Coefficient = $coeff<br>";

                $directs_pool = $coeff * $directs_pool;

                echo "\n[DP] Final Directs Pool After Coefficient = $directs_pool<br><br>";
            }

        }        
    }
    
    
}
