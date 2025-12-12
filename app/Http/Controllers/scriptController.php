<?php

namespace App\Http\Controllers;

use App\Models\earningLogsModel;
use App\Models\packageTransaction;
use App\Models\levelEarningLogsModel;
use App\Models\levelRoiModel;
use App\Models\myTeamModel;
use App\Models\rankingModel;
use App\Models\rewardBonusModel;
use App\Models\userPlansModel;
use App\Models\usersModel;
use App\Models\withdrawModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

use function App\Helpers\findRankBonusIncome;
use function App\Helpers\findUplineRank;
use function App\Helpers\getRefferer;
use function App\Helpers\getIncome;
use function App\Helpers\getUserMaxReturn;
use function App\Helpers\getRoiMaxReturn;
use function App\Helpers\getTeamRoi;
use function App\Helpers\isUserActive;
use function App\Helpers\coinPrice;
use function App\Helpers\updateActiveTeam;
use function App\Helpers\updateReverseBusiness;
use function App\Helpers\unstakedAmount;
use function App\Helpers\getUserStakeAmount;
use function App\Helpers\reverseBusiness;

use function App\Helpers\unstakedAmountContractStackeid;
use function App\Helpers\claimRoiAmountContractStackeid;
use function App\Helpers\coinPriceLive;

use Carbon\Carbon;

class scriptController extends Controller
{

    public function businessSync(Request $request)
    {
        $coinPrice = coinPrice();
        $investment = userPlansModel::where(['isCount' => 0])->orderBy('id', 'asc')->get()->toArray();

        $ids_updated = array();

        foreach ($investment as $key => $value) {
            updateReverseBusiness($value['user_id'], $value['amount']);

            $checkIfFirstPackage = userPlansModel::where('user_id', $value['user_id'])->get()->toArray();

            if (count($checkIfFirstPackage) == 1) {
                updateActiveTeam($value['user_id']);
            }
            userPlansModel::where(['id' => $value['id']])->update(['isCount' => 1]);

            $stake = getUserStakeAmount($value['user_id']);

            usersModel::where(['id' => $value['user_id']])->update(['stake' => $stake]);
        }

        $investmentReverse = withdrawModel::where(['isReverse' => 0])->orderBy('id', 'asc')->get()->toArray();

        foreach ($investmentReverse as $key => $value) {
            reverseBusiness($value['user_id'], $value['amount']);

            withdrawModel::where(['id' => $value['id']])->update(['isReverse' => 1]);

            $stake = getUserStakeAmount($value['user_id']);

            usersModel::where(['id' => $value['user_id']])->update(['stake' => $stake]);
        }
    }

    public function setStake(Request $request)
    {
        // avoid huge in-memory query logs during long loops
        DB::connection()->disableQueryLog();

        usersModel::where('status', 1)
            ->orderBy('id')
            ->chunkById(1000, function ($users) {
                $updates = [];

                foreach ($users as $u) {
                    // keeps your existing calculation
                    $stake = getUserStakeAmount($u->id);
                    $updates[] = ['id' => $u->id, 'stake' => $stake];
                }

                if (!empty($updates)) {
                    // single bulk write per chunk (MySQL/PG supported)
                    usersModel::upsert($updates, ['id'], ['stake']);
                }
            });

        return response()->json(['status' => 'ok']);
    }

    public function checkLevel(Request $request)
    {
        $coinPrice = coinPrice();

        $users = usersModel::where('daily_roi', '>', 0)->where('status', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        foreach ($users as $key => $value) {
            $activeUser = userPlansModel::where(['user_id' => $value['id']])->get()->toArray();
            if(count($activeUser) > 0)
            {
                $activeDirectCount = DB::select("select SUM(amount + compound_amount) AS cs, user_id from `users` inner join `user_plans` on `user_plans`.`user_id` = `users`.`id` where (`users`.`sponser_id` = ".$value['id'].") GROUP BY user_id HAVING cs >= (".(100 / $coinPrice).")");

                $userInvestment = 0;
                $unstakedAmount = 0;
                foreach ($activeUser as $keyValue => $userValue) {
                    $userInvestment += ($userValue['amount'] + $userValue['compound_amount']);
                    // $unstakedAmount += unstakedAmountContractStackeid($value['id'], $userValue['contract_stakeid']);
                }

                // $userInvestment = $userInvestment - $unstakedAmount;

                $unstake1 = unstakedAmount($value['id'], 1);
                $unstake2 = unstakedAmount($value['id'], 2);
                $unstake3 = unstakedAmount($value['id'], 3);

                $userInvestment = ($userInvestment - $unstake1 - $unstake2 - $unstake3);

                $userInvestment = $coinPrice * $userInvestment;

                $activeDirectCount = array_map(function ($value) {
                    return (array) $value;
                }, $activeDirectCount);

                $countDirect = count($activeDirectCount);

                $levelsOpen = levelRoiModel::select('id', 'direct', 'business')
                    ->where('direct', '<=', $countDirect)
                    ->whereRaw('CAST(business AS DECIMAL(15,2)) <= CAST(? AS DECIMAL(15,2))', [$userInvestment])
                    ->orderBy('id', 'desc')
                    ->get()
                    ->toArray();
                    
                if (count($levelsOpen) > 0) {
                    usersModel::where(['id' => $value['id']])->update(['level' => $levelsOpen['0']['id']]);
                }else
                {
                    usersModel::where(['id' => $value['id']])->update(['level' => 0]);
                }
            }else
            {
                usersModel::where(['id' => $value['id']])->update(['level' => 0]);
            }

        }
    }

    public function activeTeamCalculate(Request $request)
    {
        usersModel::where(['status' => 1])->update(['active_team' => 0]);

        $userPlans = userPlansModel::select('user_id')->groupBy('user_id')->get()->toArray();

        foreach ($userPlans as $key => $value) {
            updateActiveTeam($value['user_id']);
        }
    }

    public function reverseInvestment(Request $request)
    {
        // $investment = userPlansModel::where(['status' => 2])->orderBy('id', 'asc')->get()->toArray();

        // foreach ($investment as $key => $value) {
        //     reverseBusiness($value['user_id'], $value['amount']);

        //     userPlansModel::where(['id' => $value['id']])->update(['status' => 3]);
        // }
    }

    public function checkUserRank(Request $request)
    {
        $type = $request->input('type');

        $user = usersModel::where('daily_roi', '>', 0)->where('status', 1)->get()->toArray();

        foreach ($user as $key => $value) {
            $business_amount = 0;
            $investment_amount = 0;

            usersModel::where('id', $value['id'])->update([
                'rank' => null,
                'rank_id' => 0
            ]);

            $getSelfInvestment = userPlansModel::where(['user_id' => $value['id']])->get()->toArray();

            foreach ($getSelfInvestment as $gsik => $gsiv) {
                $investment_amount += $gsiv['amount'] + $gsiv['compound_amount'];
            }

            $unstake1 = unstakedAmount($value['id'], 1);
            $unstake2 = unstakedAmount($value['id'], 2);
            $unstake3 = unstakedAmount($value['id'], 3);

            $investment_amount = $investment_amount - ($unstake1 - $unstake2 - $unstake3);

            $rewardDate = $value['created_on'];

            $getLastRewardDate = earningLogsModel::where('user_id', $value['id'])->where('tag', 'REWARD-BONUS')->orderBy('id', 'desc')->get()->toArray();

            if(count($getLastRewardDate))
            {
                $rewardDate = $getLastRewardDate['0']['created_on'];
            }

            $userJoiningDate = \Carbon\Carbon::parse($rewardDate);

            $coinPrice = coinPrice();

            $investment_amount = ($coinPrice * $investment_amount);

            $otherLegs = usersModel::selectRaw("(my_business + strong_business) + IFNULL(SUM(user_plans.amount), 0) as legbusiness, users.id")
                                            ->leftjoin('user_plans', 'user_plans.user_id', '=', 'users.id')
                                            ->where(['sponser_id' => $value['id']])
                                            ->groupBy("users.id")
                                            ->get()->toArray();

            foreach ($otherLegs as $olk => $olv) {
                $business_amount += $olv['legbusiness'];
            }

            $business_amount = ($coinPrice * $business_amount);

            $checkLevel = rankingModel::whereRaw("eligible <= (".($business_amount).") and account_balance <= $investment_amount")
                                        ->orderByRaw('CAST(eligible as unsigned) desc')
                                        ->get()->toArray();
            
            if (count($checkLevel) > 0) {
                foreach ($checkLevel as $clk => $clv) {

                    $getRewardRanking = rewardBonusModel::where(['id' => $clv['id']])->get()->toArray();

                    $isEligible = 0;
                    $countBusiness = 0;
                    $remaingBusines = 0;
                    $eligible = $clv['eligible'];
                    $eligiblePerLeg = $eligible / 2;
                    $rewardAmount = $getRewardRanking['0']['income'];
                    $durationDays = $getRewardRanking['0']['days'];


                    $deadline = $userJoiningDate->copy()->addDays($durationDays);
                    $now = \Carbon\Carbon::now();
                    $finalReward = $now->lte($deadline) ? $rewardAmount : $rewardAmount / 2;

                    $otherLegs = usersModel::selectRaw("IFNULL((my_business + strong_business),0) as my_business, users.id")
                                                    ->leftjoin('user_plans', 'user_plans.user_id', '=', 'users.id')
                                                    ->where(['sponser_id' => $value['id']])
                                                    ->groupBy('users.id')
                                                    ->get()
                                                    ->toArray();

                    // dd($otherLegs);

                    foreach ($otherLegs as $kl => $vl) {
                        $userPlansAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")->where(['user_id' => $vl['id']])->whereRaw("roi > 0")->get()->toArray();

                        $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")->where('withdraw_type', '=', 'UNSTAKE')->where('user_id', '=', $vl['id'])->get()->toArray();

                        $vl['my_business'] = (($vl['my_business'] + $userPlansAmount['0']['amount']) - $claimedRewards['0']['amount']) * $coinPrice;

                        if($vl['my_business'] < 0)
                        {
                            $vl['my_business'] = 0;
                        }

                        // echo  $vl['id'] . " -> Business " . $vl['my_business'] . "/" . $eligiblePerLeg . " - Remaining Business" . $remaingBusines .PHP_EOL;

                        if ($vl['my_business'] >= $eligiblePerLeg) {
                            $countBusiness += $eligiblePerLeg;
                            $remaingBusines += ($vl['my_business'] - $eligiblePerLeg);
                            $isEligible = 1;
                        } else {
                            $countBusiness += $vl['my_business'];
                        }

                        // if($value['strong_business'] > 0)
                        // {
                        //         $countBusiness += $vl['my_business'];
                        // }else
                        // {
                            
                        // }
                    }

                    if ($countBusiness >= $eligible && $isEligible == 1) {

                        usersModel::where('id', $value['id'])->update([
                            'rank' => $clv['name'],
                            'rank_id' => $clv['id']
                        ]);

                        $userRank = [
                            'user_id' => $value['id'],
                            'rank'    => $clv['id'],
                            'amount'  => $clv['income'],
                            'week'    => $clv['week'],
                            'date'    => date('Y-m-d'),
                        ];

                        // Check if already exists
                        $exists = DB::table('user_ranks')
                            ->where('user_id', $userRank['user_id'])
                            ->where('rank', $userRank['rank'])
                            ->exists();

                        if (!$exists) {
                            usersModel::where('id', $value['id'])->update([
                                'rank' => $clv['name'],
                                'rank_id' => $clv['id'],
                                'rank_date' => date('Y-m-d')
                            ]);

                            DB::table('user_ranks')->insert($userRank);
                        }

                        $existing = earningLogsModel::where('user_id', $value['id'])
                            ->where('refrence_id', $clv['id'])
                            ->where('tag', 'REWARD-BONUS')
                            ->first();

                        if (!$existing) {
                            $roi = array();
                            $roi['user_id'] = $value['id'];
                            $roi['amount'] = ($finalReward / $coinPrice);
                            $roi['tag'] = "REWARD-BONUS";
                            $roi['isCount'] = 1;
                            $roi['refrence'] = $coinPrice;
                            $roi['refrence_id'] = $clv['id'];
                            $roi['created_on'] = date('Y-m-d H:i:s');

                            earningLogsModel::insert($roi);

                            DB::statement("UPDATE users set reward_bonus = (IFNULL(reward_bonus,0) + (".$roi['amount'].")) where id = '" . $value['id'] . "'");
                        }

                        break;
                    }
                }
            }
        }
    }

    public function checkRankForOneUser($user_id)
    {
        $user = usersModel::where(['status' => 1, 'id' => $user_id])->get()->toArray();

        foreach ($user as $key => $value) {
            $business_amount = 0;
            $investment_amount = 0;

            usersModel::where('id', $value['id'])->update([
                'rank' => null,
                'rank_id' => 0
            ]);

            $getSelfInvestment = userPlansModel::where(['user_id' => $value['id']])->get()->toArray();

            foreach ($getSelfInvestment as $gsik => $gsiv) {
                $investment_amount += $gsiv['amount'] + $gsiv['compound_amount'];
            }

            $unstake1 = unstakedAmount($value['id'], 1);
            $unstake2 = unstakedAmount($value['id'], 2);
            $unstake3 = unstakedAmount($value['id'], 3);

            $investment_amount = $investment_amount - ($unstake1 - $unstake2 - $unstake3);

            $rewardDate = $value['created_on'];

            $getLastRewardDate = earningLogsModel::where('user_id', $value['id'])->where('tag', 'REWARD-BONUS')->orderBy('id', 'desc')->get()->toArray();

            if(count($getLastRewardDate))
            {
                $rewardDate = $getLastRewardDate['0']['created_on'];
            }

            $userJoiningDate = \Carbon\Carbon::parse($rewardDate);

            $coinPrice = coinPrice();

            $investment_amount = ($coinPrice * $investment_amount);

            $otherLegs = usersModel::selectRaw("(my_business + strong_business) + IFNULL(SUM(user_plans.amount), 0) as legbusiness, users.id")->leftjoin('user_plans', 'user_plans.user_id', '=', 'users.id')->where(['sponser_id' => $value['id']])->groupBy("users.id")->get()->toArray();

            // dd($otherLegs);

            foreach ($otherLegs as $olk => $olv) {
                $business_amount += $olv['legbusiness'];
            }

            $business_amount = ($coinPrice * $business_amount);

            $checkLevel = rankingModel::whereRaw("eligible <= (".($business_amount).") and account_balance <= $investment_amount")->orderByRaw('CAST(eligible as unsigned) desc')->get()->toArray();
            // dd($checkLevel);
            if (count($checkLevel) > 0) {
                foreach ($checkLevel as $clk => $clv) {

                    $getRewardRanking = rewardBonusModel::where(['id' => $clv['id']])->get()->toArray();

                    $isEligible = 0;
                    $countBusiness = 0;
                    $remaingBusines = 0;
                    $eligible = $clv['eligible'];
                    $eligiblePerLeg = $eligible / 2;
                    $rewardAmount = $getRewardRanking['0']['income'];
                    $durationDays = $getRewardRanking['0']['days'];


                    $deadline = $userJoiningDate->copy()->addDays($durationDays);
                    $now = \Carbon\Carbon::now();
                    $finalReward = $now->lte($deadline) ? $rewardAmount : $rewardAmount / 2;

                    $otherLegs = usersModel::selectRaw("IFNULL((my_business + strong_business),0) as my_business, users.id")->leftjoin('user_plans', 'user_plans.user_id', '=', 'users.id')->where(['sponser_id' => $value['id']])->groupBy('users.id')->get()->toArray();

                    foreach ($otherLegs as $kl => $vl) {
                        $userPlansAmount = userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")->where(['user_id' => $vl['id']])->whereRaw("roi > 0")->get()->toArray();

                        $claimedRewards = withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")->where('withdraw_type', '=', 'UNSTAKE')->where('user_id', '=', $vl['id'])->get()->toArray();

                        $vl['my_business'] = (($vl['my_business'] + $userPlansAmount['0']['amount']) - $claimedRewards['0']['amount']) * $coinPrice;

                        if($vl['my_business'] < 0)
                        {
                            $vl['my_business'] = 0;
                        }

                        if ($vl['my_business'] >= $eligiblePerLeg) {
                            $countBusiness += $eligiblePerLeg;
                            $remaingBusines += ($vl['my_business'] - $eligiblePerLeg);
                            $isEligible = 1;
                        } else {
                            $countBusiness += $vl['my_business'];
                        }
                    }

                    if ($countBusiness >= $eligible && $isEligible == 1) {

                        usersModel::where('id', $value['id'])->update([
                            'rank' => $clv['name'],
                            'rank_id' => $clv['id']
                        ]);

                        $userRank = [
                            'user_id' => $value['id'],
                            'rank'    => $clv['id'],
                            'amount'  => $clv['income'],
                            'week'    => $clv['week'],
                            'date'    => date('Y-m-d'),
                        ];

                        // Check if already exists
                        $exists = DB::table('user_ranks')
                            ->where('user_id', $userRank['user_id'])
                            ->where('rank', $userRank['rank'])
                            ->exists();

                        if (!$exists) {
                            usersModel::where('id', $value['id'])->update([
                                'rank' => $clv['name'],
                                'rank_id' => $clv['id'],
                                'rank_date' => date('Y-m-d')
                            ]);

                            DB::table('user_ranks')->insert($userRank);
                        }
                        break;
                    }
                }
            }
        }
    }

    public function starBonus()
    {
        // $rankPercentage = [];
        // foreach ($this->matrix as $level => $m) {
        //     $rankPercentage[$level] = $m['profit_ratio'];
        // }

        $rankPercentage = [
            0 => 0,
            1 => 10,
            2 => 20,
            3 => 30,
            4 => 40,
            5 => 50,
            6 => 60,
            7 => 70,
            8 => 80,
            9 => 90,
            10 => 100,
            11 => 110,
            12 => 120,
            13 => 130,
            14 => 140,
            15 => 150,
        ];

        // $users = usersModel::where('rank_id', '>', 0)->get();

        // foreach ($users as $user) {
        //     $userRank = $user->rank_id;
        //     $userPercent = $rankPercentage[$userRank];
        //     $teamRoi = ($user->my_business * 0.0035); //getTeamRoi($user->id);
        //     $distributeAmount = 0;

        //     $directs = usersModel::where('sponser_id', $user->id)->get();

        //     foreach ($directs as $direct) {
        //         $legRoi = ($direct->my_business * 0.0035); //getTeamRoi($direct->id);
        //         $remainingLegRoi = $legRoi;

        //         $deductedTeamIds = [];
        //         $directIncluded = false;

        //         // First, check the direct himself
        //         if ($direct->rank_id >= $userRank) {
        //             // Direct is higher/equal ranked → subtract full ROI
        //             $directRoi = ($direct->my_business * 0.0035); //getTeamRoi($direct->id);
        //             $teamRoi -= $directRoi;
        //             $remainingLegRoi -= $directRoi;
        //             $directIncluded = true;
        //         } elseif ($direct->rank_id > 0) {
        //             // Direct is lower ranked → give differential bonus
        //             $directRoi = ($direct->my_business * 0.0035); //getTeamRoi($direct->id);
        //             $effectiveRoi = min($directRoi, $remainingLegRoi);
        //             $diff = $userPercent - $rankPercentage[$direct->rank_id];

        //             if ($diff > 0) {
        //                 $distributeAmount += ($effectiveRoi * $diff / 100);
        //             }

        //             $remainingLegRoi -= $effectiveRoi;
        //             $deductedTeamIds[] = $direct->id;
        //         }

        //         // Now go through downline ranked members
        //         $rankedMembers = usersModel::join('my_team', 'my_team.team_id', '=', 'users.id')
        //             ->where('my_team.user_id', $direct->id)
        //             ->where('users.rank_id', '>', 0)
        //             ->orderBy('users.rank_id', 'desc')
        //             ->get();

        //         foreach ($rankedMembers as $rankedUser) {
        //             if (in_array($rankedUser->sponser_id, $deductedTeamIds)) {
        //                 continue;
        //             }

        //             $rankedUserRoi = ($rankedUser->my_business * 0.0035); //getTeamRoi($rankedUser->id);
        //             $effectiveRoi = min($rankedUserRoi, $remainingLegRoi);

        //             if ($rankedUser->rank_id >= $userRank) {
        //                 $teamRoi -= $effectiveRoi;
        //                 $remainingLegRoi -= $effectiveRoi;
        //             } else {
        //                 $diff = $userPercent - $rankPercentage[$rankedUser->rank_id];
        //                 if ($diff > 0) {
        //                     $distributeAmount += ($effectiveRoi * $diff / 100);
        //                 }
        //                 $remainingLegRoi -= $effectiveRoi;
        //             }

        //             $deductedTeamIds[] = $rankedUser->id;
        //         }

        //         // Remaining ROI in leg → full % bonus
        //         if ($remainingLegRoi > 0) {
        //             $distributeAmount += ($remainingLegRoi * $userPercent / 100);
        //         }

        //         $teamRoi -= $legRoi;
        //     }

        //     // Final remaining ROI (other than directs) → full % bonus
        //     if ($teamRoi > 0) {
        //         $distributeAmount += ($teamRoi * $userPercent / 100);
        //     }

        //     $roi = [
        //         'user_id' => $user->id,
        //         'amount' => round($distributeAmount, 6),
        //         'tag' => "STAR-BONUS",
        //         'refrence' => $user->rank_id,
        //         'refrence_id' => $teamRoi,
        //         'created_on' => now(),
        //     ];

        //     earningLogsModel::insert($roi);

        //     DB::statement("UPDATE users SET rank_bonus = IFNULL(rank_bonus, 0) + {$roi['amount']} WHERE id = {$user->id}");
        // }
        // ->where('id', '66')

         $users = usersModel::where('level', '>', 0)->get();

        foreach ($users as $user) {

            $userRank    = $user->level;
            $userPercent = $rankPercentage[$userRank] ?? 0;

            $teamRoi = getTeamRoi($user->id);
            $distributeAmount = 0;

            $directs = usersModel::where('sponser_id', $user->id)->get();

            foreach ($directs as $direct) {

                $legRoi = getTeamRoi($direct->id);
                $remainingLegRoi = $legRoi;

                $deductedTeamIds = [];

                /** ---------------------------------------------------
                 * DIRECT LOGIC
                 * --------------------------------------------------- */
                if ($direct->level >= $userRank) {

                    $directRoi = getTeamRoi($direct->id);

                    // ❌ teamRoi yahan CUT nahi karna
                    // teamRoi -= directRoi;

                    $remainingLegRoi -= $directRoi;
                    $deductedTeamIds[] = $direct->id;

                } elseif ($direct->level > 0) {

                    $directRoi = getTeamRoi($direct->id);
                    $effectiveRoi = min($directRoi, $remainingLegRoi);

                    $diff = $userPercent - ($rankPercentage[$direct->level] ?? 0);

                    if ($diff > 0) {
                        $give = ($effectiveRoi * $diff / 100);
                        $distributeAmount += $give;
                    }

                    $remainingLegRoi -= $effectiveRoi;
                    $deductedTeamIds[] = $direct->id;
                }

                /** ---------------------------------------------------
                 * DOWNLINE RANKED MEMBERS LOGIC
                 * --------------------------------------------------- */
                $rankedMembers = usersModel::join('my_team', 'my_team.team_id', '=', 'users.id')
                    ->where('my_team.user_id', $direct->id)
                    ->where('users.level', '>', 0)
                    ->orderBy('users.level', 'desc')
                    ->get();

                foreach ($rankedMembers as $rankedUser) {

                    if (in_array($rankedUser->id, $deductedTeamIds)) {
                        continue;
                    }

                    $rankedUserRoi = getTeamRoi($rankedUser->id);
                    $effectiveRoi = min($rankedUserRoi, $remainingLegRoi);

                    if ($rankedUser->level >= $userRank) {

                        // ❌ YEH GALAT CUT NAHI KARNA
                        // teamRoi -= $effectiveRoi;

                        $remainingLegRoi -= $effectiveRoi;

                    } else {

                        $diff = $userPercent - ($rankPercentage[$rankedUser->level] ?? 0);

                        if ($diff > 0) {
                            $give = ($effectiveRoi * $diff / 100);
                            $distributeAmount += $give;
                        }

                        $remainingLegRoi -= $effectiveRoi;
                    }

                    $deductedTeamIds[] = $rankedUser->id;
                }

                /** ---------------------------------------------------
                 * REMAINING LEG ROI → GIVE FULL TO USER
                 * --------------------------------------------------- */
                if ($remainingLegRoi > 0) {
                    $give = ($remainingLegRoi * $userPercent / 100);
                    $distributeAmount += $give;
                }

                /** ---------------------------------------------------
                 * NOW CUT ONLY **ONCE** → ENTIRE LEG ROI
                 * --------------------------------------------------- */
                $teamRoi -= $legRoi;
                if ($teamRoi < 0) $teamRoi = 0;
            }

            /** ---------------------------------------------------
             * RESIDUAL TEAM ROI (GLOBAL LEFTOVER)
             * --------------------------------------------------- */
            if ($teamRoi > 0) {
                $give = ($teamRoi * $userPercent / 100);
                $distributeAmount += $give;
            }

            /** ---------------------------------------------------
             * FINAL OUTPUT FOR USER
             * --------------------------------------------------- */

            // first user ke liye detail dekhne ke liye

            echo $distributeAmount . " - " . $user->id;
            echo "<br>\n";

            $roi = [
                'user_id' => $user->id,
                'amount' => round($distributeAmount, 6),
                'tag' => "DIFF-TEAM-BONUS",
                'refrence' => $user->rank_id,
                'refrence_id' => $teamRoi,
                'created_on' => now(),
            ];


            earningLogsModel::insert($roi);

            DB::statement("UPDATE users 
                           SET rank_bonus = IFNULL(rank_bonus, 0) + {$roi['amount']} 
                           WHERE id = {$user->id}");

        }

    }

    public function uplineBonus(Request $request)
    {
        $coinPrice = coinPrice();

        $uplineBonusUsers = array();

        $users = usersModel::whereRaw(" active_direct >= 8 and direct_business >= ".(8000 / $coinPrice))->get()->toArray();
        
        foreach ($users as $key => $value) {
            $getActiveDirects = usersModel::selectRaw("IFNULL(SUM(user_plans.amount) ,0) as db, users.id")->join('user_plans', 'user_plans.user_id', '=', 'users.id')->where(['sponser_id' => $value['id']])->groupBy("users.id")->get()->toArray();

            $criteriaMatch = 0;

            foreach ($getActiveDirects as $gadk => $gadv) {
                // $unstake1 = unstakedAmount($gadv['id'], 1);
                // $unstake2 = unstakedAmount($gadv['id'], 2);
                // $unstake3 = unstakedAmount($gadv['id'], 3);
                // $stakeAmount = ($gadv['db'] - $unstake1 - $unstake2 - $unstake3);
                $stakeAmount = getUserStakeAmount($gadv['id']);
                if (($stakeAmount * $coinPrice) >= 1000) {
                    $criteriaMatch++;
                }
            }

            if ($criteriaMatch >= 8) {
                $checkInvestment = userPlansModel::selectRaw("SUM(amount) as investment")->where(['user_id' => $value['id']])->get()->toArray();
                // $unstake1 = unstakedAmount($value['id'], 1);
                // $unstake2 = unstakedAmount($value['id'], 2);
                // $unstake3 = unstakedAmount($value['id'], 3);
                // $stakeAmount = ($checkInvestment['0']['investment'] - $unstake1 - $unstake2 - $unstake3);
                $stakeAmount = getUserStakeAmount($value['id']);
                if(($stakeAmount * $coinPrice) >= 3000)
                {
                    $uplineBonusUsers[$value['sponser_id']][] = $value['id'];
                }
            }
        }

        foreach($uplineBonusUsers as $sponser => $users) {

            $getEarnings = earningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as earnings")
                ->where('user_id', $sponser)
                ->where('isCount', 0)
                ->where('tag', '!=', 'UPLINE-BONUS')
                ->first();

            $getLevelEarnings = levelEarningLogsModel::selectRaw("IFNULL(SUM(amount), 0) as earnings")
                ->where('user_id', $sponser)
                ->where('isCount', 0)
                ->where('tag', '!=', 'UPLINE-BONUS')
                ->first();

            $totalEarnings = $getEarnings->earnings + $getLevelEarnings->earnings;

            if ($totalEarnings > 0) {
                $bonusPool = $totalEarnings * 0.05;
                $userCount = count($users);
                $bonusPerUser = $userCount > 0 ? ($bonusPool / $userCount) : 0;

                foreach ($users as $userId) {
                    if($bonusPerUser > 0)
                    {
                        $roi = [
                            'user_id' => $userId,
                            'amount' => $bonusPerUser,
                            'tag' => 'UPLINE-BONUS',
                            'refrence' => $totalEarnings,
                            'refrence_id' => $sponser,
                            'isCount' => 1,
                            'created_on' => now()
                        ];

                        earningLogsModel::insert($roi);

                        DB::statement("UPDATE users SET direct_income = IFNULL(direct_income, 0) + {$bonusPerUser} WHERE id = '{$userId}'");
                    }
                }
            }
        }

    }

    public function dailyPoolRelease(Request $request)
    {
        $coinPrice = coinPrice();

        $qualifiedUsers = DB::table('user_plans')
                                ->whereRaw('(amount * coin_price) >= 100')
                                ->whereRaw('user_id in (52738,52741,52747,52750,52753,52758,52776,52785,52805,52726,52735)')
                                ->pluck('user_id')
                                ->unique()
                                ->toArray();

        $getPoolAmount = withdrawModel::selectRaw("IFNULL(SUM(daily_pool_amount), 0) as daily_pool")
                                        ->whereRaw("DATE_FORMAT(created_on, '%Y-%m-%d') = ?", [date('Y-m-d', strtotime('-1 day'))])
                                        ->get()
                                        ->toArray();

        $poolAmount = $getPoolAmount['0']['daily_pool']; // Example daily pool amount

        if ($poolAmount > 0) {
            if (count($qualifiedUsers) > 11) {
                $winners = collect($qualifiedUsers)->random(11);
                $amountPerWinner = $poolAmount / 11;
            } else {
                $winners = $qualifiedUsers;
                $amountPerWinner = $poolAmount / count($qualifiedUsers);
            }

            foreach ($winners as $winnerId) {
                $roi = array();
                $roi['user_id'] = $winnerId;
                $roi['amount'] = $amountPerWinner;
                $roi['tag'] = "DAILY-POOL";
                $roi['refrence'] = $coinPrice;
                $roi['refrence_id'] = "-";
                $roi['isCount'] = "1";
                // $roi['isSynced'] = "1";
                $roi['created_on'] = '2025-09-06 23:01:01';

                // echo "--------------------------------".PHP_EOL;
                // echo $roi['amount']."-".$winnerId.PHP_EOL;
                // echo "--------------------------------".PHP_EOL;

                earningLogsModel::insert($roi);

                DB::statement("UPDATE users set royalty = (IFNULL(royalty,0) + (" . $roi['amount'] . ")) where id = '" . $winnerId . "'");
            }
        }
    }

    public function monthlyPoolRelease(Request $request)
    {
        $coinPrice = coinPrice();
        $month = date('Y-m', strtotime('-1 month'));

        $poolAmount = withdrawModel::whereRaw("DATE_FORMAT(created_on, '%Y-%m') = ?", [$month])
            ->sum('monthly_pool_amount');

        if ($poolAmount > 0) {

            // Inner query: Top 50 investments for the month
            $innerQuery = userPlansModel::select([
                    'user_id', 'amount',
                    DB::raw("(amount * coin_price) as investment"),
                    DB::raw("(SELECT wallet_address FROM users WHERE users.id = user_plans.user_id) as wallet_address"),
                ])
                ->whereBetween('created_on', ['2025-09-01 16:30:01', '2025-10-01 16:29:59'])
                ->orderByRaw("CAST((amount * coin_price) AS UNSIGNED) DESC")
                ->limit(50);

            // Outer query: Group by wallet_address, order by investment, limit 31
            $data = DB::table(DB::raw("({$innerQuery->toSql()}) as monthly_pool"))
                ->mergeBindings($innerQuery->getQuery())
                ->select('*')
                ->groupBy('wallet_address')
                ->orderByDesc('investment')
                ->limit(31)
                ->get();

            // If no valid users found, return
            if ($data->isEmpty()) {
                return response()->json(['message' => 'No eligible users found.'], 200);
            }

            $seventyPercent = $poolAmount * 0.7;
            $thirtyPercent = $poolAmount * 0.3;
            $thirtyUserShare = $seventyPercent / 30;

            // Distribute 70% to the top user
            $topUser = $data->first();

            earningLogsModel::insert([
                'user_id' => $topUser->user_id,
                'amount' => $thirtyPercent,
                'tag' => 'MONTHLY-POOL',
                'refrence' => $topUser->amount,
                'refrence_id' => '-',
                'isCount' => 1,
                'isSynced' => 1,
                'created_on' => now(),
            ]);

            DB::statement("UPDATE users SET royalty = IFNULL(royalty, 0) + ? WHERE id = ?", [
                $thirtyPercent, $topUser->user_id
            ]);

            // Distribute 30% equally among next 30 users
            $otherUsers = $data->slice(1); // Exclude the top user

            $totalInvestments = 0;

            foreach ($otherUsers as $user) {
                $totalInvestments += $user->amount;
            }

            $distributePerRtx = ($seventyPercent / $totalInvestments);

            foreach ($otherUsers as $user) {
                $calculateAmount = ($distributePerRtx * $user->amount);
                earningLogsModel::insert([
                    'user_id' => $user->user_id,
                    'amount' => $calculateAmount,
                    'tag' => 'MONTHLY-POOL',
                    'refrence' => $user->amount,
                    'refrence_id' => '-',
                    'isCount' => 1,
                    'isSynced' => 1,
                    'created_on' => now(),
                ]);

                DB::statement("UPDATE users SET royalty = IFNULL(royalty, 0) + ? WHERE id = ?", [
                    $calculateAmount, $user->user_id
                ]);
            }

            return response()->json(['message' => 'Monthly pool released successfully.'], 200);
        }

        return response()->json(['message' => 'No pool amount to distribute.'], 200);
    }

    // Single stacking plan roi
    public function roiRelease(Request $request)
    {

        // \Log::info("In roiRelease...");
        Log::channel('roi_release')->info("In roiRelease...");

        // $coinPrice = coinPrice();

        /*
         * R1 :: This is to release ROI manually for DATE TIME AND SKIP RECENT STAKED PLANS
         */
        // Log::channel('roi_release')->info("In roiRelease... for 2025-11-19 20:01:01");
        // Log::channel('roi_release')->info("In roiRelease... for 2025-11-20 08:01:01");
        // $cutoff = Carbon::parse('2025-11-20 08:01:01')->subHours(12);

        $packages = userPlansModel::where('status', 1)
                                        ->where('roi','>',0)
                                        ->where('created_on', '<', Carbon::now()->subHours(12))
                                        // ->where('created_on', '<', $cutoff) // :: R1
                                        ->select(
                                            'user_id',
                                            'package_id',
                                            'amount as amount',
                                            'compound_amount as compound_amount',
                                            'id as id',
                                            'status as status',
                                            'roi as roi',
                                            'contract_stakeid',
                                            'lock_period'
                                        )
                                        ->orderByDesc('id')
                                        ->get()
                                        ->toArray();

        if (count($packages) <= 0) {
            return response()->json([
                'ok' => false,
                'msg' => 'Not in a release window'
            ]);
        }

        earningLogsModel::where(['isCount' => 0])->update(['isCount' => 1]);

        levelEarningLogsModel::where(['isCount' => 0])->update(['isCount' => 1]);

        DB::statement("UPDATE users set daily_roi = 0");

        $levelRoi = levelRoiModel::where(['status' => 1])->get()->toArray();

        $roiLevel = array();
        
        foreach ($levelRoi as $key => $value) {
            $roiLevel[$value['level']] = $value['percentage'];
        }

        $validLeaders = array();

        foreach ($packages as $key => $value) {

            $ogRoi = $value['roi'];
            $packageId = $value['package_id'];
            $lock_period = $value['lock_period'];
            $contract_stakeid = $value['contract_stakeid'];
            
            $unstakeAmount = unstakedAmountContractStackeid($value['user_id'], $packageId, $contract_stakeid);
            $claimRoiAmount = claimRoiAmountContractStackeid($value['user_id'], $packageId, $contract_stakeid);
            
            // echo "unstakeAmount:=".$unstakeAmount.PHP_EOL;
            // echo "claimRoiAmount:=".$claimRoiAmount.PHP_EOL;

            $value['compound_amount'] = 
                ($value['compound_amount'] - $claimRoiAmount < 0)
                    ? 0
                    : ($value['compound_amount'] - $claimRoiAmount);
            
            // echo "value[compound_amount]:=".$value['compound_amount'].PHP_EOL;

            $amount = ($value['amount'] + $value['compound_amount']);

            // echo "Amount+compound_amount:=".$amount.PHP_EOL;

            $amount = ($amount - $unstakeAmount);

            // echo "Amount-unstakeAmount:=".$amount.PHP_EOL;

            $user_id = $value['user_id'];
            $investment_id = $value['id'];

            // $roiUser = usersModel::select('refferal_code')->where(['id' => $user_id])->get()->toArray();
            $roiUser = usersModel::select('refferal_code')->where(['id' => $user_id])->first(); //,'sponser_id','sponser_code'
            $refCode = $roiUser ? $roiUser->refferal_code : null;
            
            $today = date('Y-m-d');

            if($amount < 1){
                continue;
            }

            // echo $amount ."*". $ogRoi.PHP_EOL;
            $roi_amount = round(($amount * $ogRoi) / 100, 6);

            if ($roi_amount <= 0) {
                continue;
            }

            $roi = array();

            $entryDate = date('Y-m-d H:i:s'); // :: R1
            $roi['user_id'] = $user_id;
            $roi['amount'] = $roi_amount;
            $roi['tag'] = "ROI";
            $roi['refrence'] = $amount;
            $roi['refrence_id'] = $packageId;
            $roi['created_on'] = $entryDate;
            $roi['contract_stakeid'] = $contract_stakeid;
            $roi['lock_period'] = $lock_period;


            earningLogsModel::insert($roi);

            DB::statement("UPDATE users set roi_income = (IFNULL(roi_income,0) + ($roi_amount)), daily_roi = (IFNULL(daily_roi,0) + ($roi_amount)) where id = '" . $user_id . "'");

            userPlansModel::where(['id' => $investment_id])->update(['return' => DB::raw('`return` + ' . $roi_amount), 'compound_amount' => DB::raw('`compound_amount` + ' . $roi_amount)]);

            Log::channel('roi_release')->info("ROI Release... Userid=".$user_id." ROI Amount=".$roi_amount);

            //roi calculation end

            //START LEADERSHIP REFERRAL INCOME (ROI-ON-ROI)
            $level1 = getRefferer($user_id);
            if (isset($level1['sponser_id']) && $level1['sponser_id'] > 0) {
                $userLevel1 = isUserActive($level1['sponser_id']);                
                if (isset($level1['sponser_id']) && $level1['sponser_id'] > 0) { 
                    Log::channel('roi_release')->info("ROI Release... In Leadership Referral Income");
                    // echo "level1[sponser_id] = ".$level1['sponser_id'].PHP_EOL;
                    $validLeaders[$level1['sponser_id']][] = [
                        'direct'     => $user_id,
                        'amount'     => $value['amount'],
                        'roi_amount' => $roi_amount,
                        'percent'    => 10,
                        'refCode'    => $refCode,
                        'entryDate'  => $entryDate,
                        'investment_id' => $investment_id
                    ];
                }
            }
            //END LEADERSHIP REFERRAL INCOME (ROI-ON-ROI)
        }

        Log::channel('roi_release')->info("ROI Release... distributeLeadershipReferralIncome ValidLeaders=".json_encode($validLeaders));

        if(count($validLeaders)>0)
        {
            $this->distributeLeadershipReferralIncome($validLeaders);
        }
    }

    private function distributeLeadershipReferralIncome(array $validNodes): void
    {
        // $apiUrl = "https://aipf-api.vercel.app/aipf-price";
        // $coinresponse = file_get_contents($apiUrl);
        // $coindata = json_decode($coinresponse, true);
        // $coin_price = $coindata['price'] ?? 0;

        $coin_price = coinPriceLive();

        Log::channel('roi_release')->info("ROI Release... distributeLeadershipReferralIncome Latest Coin Price=".$coin_price);
        
        foreach ($validNodes as $sponsorId => $directs) {

            // Convert single direct to array of directs if needed
            if (!is_array(reset($directs))) {
                $directs = [$directs];
            }
            
            // Check if ANY direct has amount >= 100
            // $hasValidAmount = collect($directs)->contains(function ($direct) {
            //     return $direct['amount']*$coinPrice >= 100;
            // });
            // $hasValidAmount = collect($directs)->contains(function ($direct) use ($coin_price) {
            //     return $direct['amount'] * $coin_price >= 100;
            // });
            
            $directTotals = collect($directs)
                ->groupBy('direct')
                ->map(function ($items) {
                    return $items->sum(function ($item) {
                        return $item['amount'];
                    });
                });

            $hasValidAmount = $directTotals->contains(function ($totalAmount) use ($coin_price) {
                return $totalAmount * $coin_price >= 100;
            });

            if (!$hasValidAmount) {
                // Skip this sponsor
                continue;
            }

            Log::channel('roi_release')->info("ROI Release... distributeLeadershipReferralIncome Valid Directs=".json_encode($directs));

            // Process all directs for this sponsor
            foreach ($directs as $direct) {
                // dump("Processing sponsor {$sponsorId}", $direct);

                $receiverId = (int)$sponsorId;
                if (!isUserActive($receiverId)) continue;

                Log::channel('roi_release')->info("ROI Release... distributeLeadershipReferralIncome Userid=".$receiverId);

                $pct = $direct['percent'] ?? 0;
                if ($pct <= 0) continue;

                $amt = round(($direct['roi_amount'] * $pct) / 100, 6);
                if ($amt <= 0) continue;

                Log::channel('roi_release')->info("ROI Release... distributeLeadershipReferralIncome Userid=".$receiverId." Amount=".$amt);

                $log = [
                    'user_id'     => $receiverId,
                    'amount'      => $amt,
                    'tag'         => "LEADERSHIP-REF-INCOME",
                    'refrence'    => $direct['refCode'] . " - " .$direct['roi_amount'],
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
        }

    }
    
    public function StakePoolReward()
    {
        
        $POOL_ELIGIBILITY = 5000;
        $POOL_PERCENT = 5;   // 10% of total ROI
        $CUTOFF_HOURS = 24;
           
        // consider plans within 24 hours
        $cutoff = now()->subHours($CUTOFF_HOURS);
        // $coin_price = coinPriceLive();
        
       $users = userPlansModel::query()
                                ->join('users', 'users.id', '=', 'user_plans.user_id')     // JOIN
                                ->whereIn('user_plans.package_id', [2,3])
                                ->where('user_plans.lock_period', 4)
                                ->where('user_plans.roi', '>', 0)
                                ->whereIn('user_plans.id', function($query) {
                                    $query->selectRaw('MIN(id)')
                                        ->from('user_plans')
                                        ->groupBy('user_id');  // FIRST plan per user
                                })
                                // ->whereRaw("user_plans.amount * ? >= ?", [$coin_price, $POOL_ELIGIBILITY])
                                ->whereRaw('(user_plans.amount * user_plans.coin_price) >= ?', [4999])
                                ->select([
                                    'users.id as user_id',
                                    'users.wallet_address',
                                    'user_plans.amount',
                                    'user_plans.package_id',
                                    'user_plans.id as plan_id'
                                ])
                                ->distinct()
                                ->limit(100)
                                ->get()
                                ->toArray();
           
        

        $totalStakeLat24hrs = userPlansModel::whereIn('package_id', [2,3])
                                ->where('created_on', '>=', $cutoff)
                                ->where('transaction_hash', 'NOT LIKE', '%BYADMIN%') //5000
                                ->sum('amount');

        
            
        $fivePerOFTotalStakeLast24hrs = $totalStakeLat24hrs * $POOL_PERCENT / 100;
    
        $profitPrUser =  $fivePerOFTotalStakeLast24hrs / 100;

        $poolRewards = [];
        foreach ($users as $user) {
            $poolRewards[] = [
                    'user_id'     => $user['user_id'],
                    'user_address'     => $user['wallet_address'],
                    'amount'      => $profitPrUser,
                    
                ];
        }
        return response()->json(['message' => 'pool amount to distribute.',"data" => $poolRewards], 200);
    }
    
    public function StakePoolRewardSave(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'transaction_hash' => 'required|string',
            'wallet_address' => 'required|string',
        ]);

        try {
            // Insert into database
            $id = DB::table('developer_pools')->insertGetId([
                'amount' => $validated['amount'],
                'transaction_hash' => $validated['transaction_hash'],
                'wallet_address' => $validated['wallet_address'],
                'created_on' => now(),
            ]);

            return response()->json([
                'status_code' => 1,
                'message' => 'Success',
                'pool_amount' => $validated['amount'],
                'insert_id' => $id
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status_code' => 0,
                'message' => 'Insert failed: ' . $e->getMessage()
            ]);
        }
    }
}
