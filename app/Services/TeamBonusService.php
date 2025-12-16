<?php
namespace App\Services;

use App\Models\usersModel;
use App\Models\myTeamModel;
use App\Models\earningLogsModel;
use App\Models\userPlansModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use function App\Helpers\getUserStakeAmount;
use function App\Helpers\coinPriceLive;
use function App\Helpers\getTeamRoi;
use function App\Helpers\updateReverseBusiness;
use function App\Helpers\updateActiveTeam;
use function App\Helpers\activeDirect;
use function App\Helpers\getUserStakedAmount;
use App\Models\withdrawModel;

// class CitizenAllianceService
class TeamBonusService
{
    private $matrix = null;

    public function getMatrix()
    {
        if ($this->matrix === null) {
            $this->matrix = $this->loadTeamBonusMatrixFromDB();
        }
        return $this->matrix;
    }

    private function loadTeamBonusMatrixFromDB()
    {
        $rows = DB::table('ranking')->orderBy('id')->get();
        $matrix = [];

        foreach ($rows as $row) {
            $holdlvlReq = json_decode($row->hold_level_requirement, true);

            $matrix[$row->id] = [
                'level' => $row->id,
                'name'  => $row->name,
                'personal_holding' => (int)$row->account_balance,
                'team_requirement' => [
                    'type'  => $row->team_requirement_type,
                    'value' => $holdlvlReq['value'] ?? 0,
                    'level' => $holdlvlReq['level'] ?? 0,
                    'count' => $holdlvlReq['count'] ?? 0,
                ],
                'valid_referrals' => (int)$row->direct_referral,
                'profit_ratio' => [
                    (int)$row->profit_sharing,
                    (int)$row->profit_sharing_max,
                ]
            ];
        }

        return $matrix;
    }

    /**
     * Check and update user levels (Citizen Alliance Reward Levels)
     */
    // public function checkCitizenAllianceReward()
    public function checkLevel()
    {

        // \Log::info("In checkLevel..."); dd();
        Log::channel('level_check')->info("==================== start =======================");

        $coinPrice = coinPriceLive();

        $isSplitTeamBusiness = false;

        $investment = userPlansModel::where(['isCount' => 0])->orderBy('id', 'asc')->get()->toArray();

        // UPDATE MY_BUSINESS
        foreach ($investment as $key => $value) 
        {
            updateReverseBusiness($value['user_id'], $value['amount']);
            $checkIfFirstPackage = userPlansModel::where('user_id', $value['user_id'])->get()->toArray();
            if (count($checkIfFirstPackage) == 1) 
            {
                updateActiveTeam($value['user_id']);
            }
            userPlansModel::where(['id' => $value['id']])->update(['isCount' => 1]);
        }

        $users = usersModel::where('status', 1)->get();

        foreach ($users as $user) 
        {
            $userId = $user->id;

            Log::channel('level_check')->info("===========================================");
            Log::channel('level_check')->info("wallet address...".$user->wallet_address);

            $personalHolding = getUserStakeAmount($userId);

            $personalHolding *= $coinPrice;

            Log::channel('level_check')->info("self stake...".$personalHolding);
            $selfBusiness = $this->getTeamBusiness($userId);
            Log::channel('level_check')->info("Coin Price...".$coinPrice);
            Log::channel('level_check')->info("self business...".(($selfBusiness['strong'] + $selfBusiness['weak'])));
            Log::channel('level_check')->info("self business in USDT...".(($selfBusiness['strong'] + $selfBusiness['weak']) * $coinPrice));

            // $validReferrals = activeDirect($userId, 100); //$this->getValidReferrals($userId, $coinPrice);

            $directsActive100 = usersModel::select('users.id')
                    ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                    ->where('users.sponser_id', $userId)
                    ->groupBy('users.id')
                    ->get();

            $validReferrals = 0;
            foreach ($directsActive100 as $direct) {
                $stake = getUserStakedAmount($direct->id);
                if ($stake * $coinPrice >= 100) $validReferrals++;
            }

            Log::channel('level_check')->info("active direct...".$validReferrals);
           
            
           
            // $totalTeamBusiness = $user->my_business ?? 0;

            // $totalTeamBusiness = $totalTeamBusiness * $coinPrice;

            $achievedLevel = 0;
            
            $legs = usersModel::where('sponser_id', $userId)->where('level', 0)->get();
            
            // === LEVEL 15 ===
            if ($this->hasMultipleLegs($legs, 14, 2) && $validReferrals >= 15) 
            {
                $legamount = 15000000;
                $legbusiness = $this->getTeamBusiness($userId);
                if($isSplitTeamBusiness)
                {
                    $legamount = $legamount/2;
                    if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                    {
                        $achievedLevel = 15;
                    }
                }
                else 
                {
                    if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                    {
                        $achievedLevel = 15;
                    }
                }
            }

            // === LEVEL 14 ===
            if (!$achievedLevel && $this->hasMultipleLegs($legs, 13, 2) && $validReferrals >= 15) 
            {
                $legamount = 15000000;
                $legbusiness = $this->getTeamBusiness($userId);
                if($isSplitTeamBusiness)
                {
                    $legamount = $legamount/2;
                    if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                    {
                        $achievedLevel = 14;
                    }
                }
                else 
                {
                    if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                    {
                        $achievedLevel = 14;
                    }
                }
            }

            // === LEVEL 13 ===
            if (!$achievedLevel && $this->hasMultipleLegs($legs, 12, 2) && $validReferrals >= 14) 
            {
                $legamount = 15000000;
                $legbusiness = $this->getTeamBusiness($userId);
                if($isSplitTeamBusiness)
                {
                    $legamount = $legamount/2;
                    if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                    {
                        $achievedLevel = 13;
                    }
                }
                else 
                {
                    if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                    {
                        $achievedLevel = 13;
                    }
                }
            }

            // === LEVEL 12 ===
            if (!$achievedLevel && $this->hasMultipleLegs($legs, 11, 2) && $validReferrals >= 13) 
            {
                $legamount = 15000000;
                $legbusiness = $this->getTeamBusiness($userId);

                if($isSplitTeamBusiness)
                {
                    $legamount = $legamount/2;
                
                    if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                    {
                        $achievedLevel = 12;
                    }
                }
                else 
                {
                    if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                    {
                        $achievedLevel = 12;
                    }
                }
            }

            // === LEVEL 11 ===
            if (!$achievedLevel && $this->hasMultipleLegs($legs, 10, 2) && $validReferrals >= 12) 
            {
                $legamount = 15000000;
                $legbusiness = $this->getTeamBusiness($userId);

                if($isSplitTeamBusiness)
                {
                    $legamount = $legamount/2;
                
                    if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                    {
                        $achievedLevel = 11;
                    }
                }
                else 
                {
                    if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                    {
                        $achievedLevel = 11;
                    }
                }
            }
            
            // === LEVEL 10 ===
            if ($this->hasMultipleLegs($legs, 9, 2) && $validReferrals >= 11) {
                $legamount = 15000000;
                $legbusiness = $this->getTeamBusiness($userId);

                if($isSplitTeamBusiness)
                {
                    $legamount = $legamount/2;
                    if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                    {
                        $achievedLevel = 10;
                    }
                }
                else 
                {
                    if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                    {
                        $achievedLevel = 10;
                    }
                }
            }

            if ($achievedLevel === 0) 
            {
                // echo PHP_EOL." 2# ".$userId ."=> personalHolding=". $personalHolding .", validReferrals=". $validReferrals ."<br>"; // totalTeamBusiness=". $totalTeamBusiness .", 

                // === LEVEL 9 ===
                if ($personalHolding >= 15000 && $validReferrals >= 10) 
                {
                    $legamount = 15000000;
                    $legbusiness = $this->getTeamBusiness($userId);

                    if($isSplitTeamBusiness)
                    {
                        $legamount = $legamount/2;
                        
                        if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                        {
                            $achievedLevel = 9;
                        }
                    }
                    else 
                    {
                        if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                        {
                            $achievedLevel = 9;
                        }
                    }
                }

                // === LEVEL 8 ===
                if (!$achievedLevel && $personalHolding >= 12000 && $validReferrals >= 9) 
                {
                    $legamount = 6000000;
                    $legbusiness = $this->getTeamBusiness($userId);
                    if($isSplitTeamBusiness)
                    {
                        $legamount = $legamount/2;
                        if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                        {
                            $achievedLevel = 8;
                        }
                    }
                    else 
                    {
                        if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                        {
                            $achievedLevel = 8;
                        }
                    }
                }

                // === LEVEL 7 ===
                if (!$achievedLevel && $personalHolding >= 10000 && $validReferrals >= 8) 
                {
                    $legamount = 2500000;
                    $legbusiness = $this->getTeamBusiness($userId);
                    if($isSplitTeamBusiness)
                    {
                        $legamount = $legamount/2;
                        if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                        {
                            $achievedLevel = 7;
                        }
                    }
                    else 
                    {
                        if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                        {
                            $achievedLevel = 7;
                        }
                    }
                }

                // === LEVEL 6 ===
                if (!$achievedLevel && $personalHolding >= 5000 && $validReferrals >= 7) 
                {
                    $legamount = 1000000;
                    $legbusiness = $this->getTeamBusiness($userId);
                    if($isSplitTeamBusiness)
                    {
                        $legamount = $legamount/2;
                        if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                        {
                            $achievedLevel = 6;
                        }
                    }
                    else 
                    {
                        if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                        {
                            $achievedLevel = 6;
                        }
                    }
                }

                // === LEVEL 5 ===
                if (!$achievedLevel && $personalHolding >= 3000 && $validReferrals >= 6) 
                {
                    $legamount = 400000;
                    $legbusiness = $this->getTeamBusiness($userId);
                    if($isSplitTeamBusiness)
                    {
                        $legamount = $legamount/2;
                        if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                        {
                            $achievedLevel = 5;
                        }
                    }
                    else 
                    {
                        if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                        {
                            $achievedLevel = 5;
                        }
                    }
                }

                // === LEVEL 4 ===
                if (!$achievedLevel && $personalHolding >= 2000 && $validReferrals >= 5) 
                {
                    $legamount = 150000;
                    $legbusiness = $this->getTeamBusiness($userId);

                    if($isSplitTeamBusiness)
                    {
                        $legamount = $legamount/2;
                    
                        if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                        {
                            $achievedLevel = 4;
                        }
                    }
                    else 
                    {
                        if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                        {
                            $achievedLevel = 4;
                        }
                    }
                }

                // === LEVEL 3 ===
                if (!$achievedLevel && $personalHolding >= 1000 && $validReferrals >= 4) 
                {
                    $legamount = 50000;
                    $legbusiness = $this->getTeamBusiness($userId);

                    if($isSplitTeamBusiness)
                    {
                        $legamount = $legamount/2;
                        if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                        {
                            $achievedLevel = 3;
                        }
                    }
                    else 
                    {
                        if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                        {
                            $achievedLevel = 3;
                        }
                    }
                }

                // === LEVEL 2 ===
                if (!$achievedLevel && $personalHolding >= 500 && $validReferrals >= 3) 
                {
                    $legamount = 20000;
                    $legbusiness = $this->getTeamBusiness($userId);
                   
                    if($isSplitTeamBusiness)
                    {
                        $legamount = $legamount/2;
                        if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                        {
                            $achievedLevel = 2;
                        }
                    }
                    else 
                    {
                        if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                        {
                            $achievedLevel = 2;
                        }
                    }
                }

                // === LEVEL 1 ===
                if (!$achievedLevel && $personalHolding >= 100 && $validReferrals >= 2) 
                {
                    $legamount = 5000;
                    $legbusiness = $this->getTeamBusiness($userId);

                    if($isSplitTeamBusiness)
                    {
                        $legamount = $legamount/2;
                        if(($legbusiness['strong'] >= $legamount) && ($legbusiness['weak'] >= $legamount))
                        {
                            $achievedLevel = 1;
                        }
                    }
                    else 
                    {
                        if((($legbusiness['strong'] + $legbusiness['weak']) * $coinPrice) >= $legamount)
                        {
                            $achievedLevel = 1;
                        }
                    }
                }

            }

            Log::channel('level_check')->info("User Level ...".$achievedLevel);

            if ($achievedLevel) 
            {
                usersModel::where('id', $userId)->update(['level' => $achievedLevel]);
            } 
            else 
            {
                usersModel::where('id', $userId)->update(['level' => 0]);
            }
            Log::channel('level_check')->info("===========================================");
        }
        Log::channel('level_check')->info("==================== end =======================");
    }


    public function hasMultipleLegs($legs, $requiredLevel, $countDifferentLegs)
    {
        $legCount = 0;
        $legFoundArray = array();

        // Loop through each leg to check if it meets the required rank
        foreach ($legs as $leg) {
            if ($leg->level >= $requiredLevel) {
                $legCount++;
                array_push($legFoundArray, $leg->id); // Store the leg's id that qualifies
            }
        }

        // If there aren't enough legs with the required rank, check within teams under each leg
        if ($legCount < $countDifferentLegs) {
            // Loop through the remaining legs to find the teams
            foreach ($legs as $leg) {
                // If leg is already counted, skip it
                if (in_array($leg->id, $legFoundArray)) {
                    continue;
                }

                // Find the users in the leg's team (downline) using their sponsor_id
                $legTeam = myTeamModel::join('users', 'users.id', '=', 'my_team.team_id')
                                            ->where(['my_team.user_id' => $leg->id])
                                            ->get();

                foreach ($legTeam as $legMember) {
                    // Check if the team member qualifies based on the rank
                    if ($legMember->level >= $requiredLevel) {
                        $legCount++;
                        array_push($legFoundArray, $leg->id); // Add the leg id if the team member qualifies
                        break; // Stop as soon as we find a qualifying team member
                    }
                }
            }
        }

        // Return whether the number of qualifying legs meets the required count
        return $legCount >= $countDifferentLegs;
    }

    public function getTeamBusiness($userId)
    {
        $legBusiness = usersModel::select('users.id','users.refferal_code','users.my_business')
                                        ->leftJoin('user_plans', 'user_plans.user_id', '=', 'users.id')
                                        ->where('users.sponser_id', $userId)
                                        ->groupBy('users.id', 'users.strong_business', 'users.refferal_code', 'users.my_business')
                                        ->orderByRaw('my_business DESC')
                                        ->get()
                                        ->toArray();
                                        
        foreach ($legBusiness as $key => $val) {
            $userPlansAmount    =   userPlansModel::selectRaw("IFNULL(SUM(amount),0) as amount")
                                                        ->where(['user_id' => $val['id']])
                                                        ->whereRaw("roi > 0 and isSynced != 2")
                                                        ->get()->toArray();

            $claimedRewards     =   withdrawModel::selectRaw("IFNULL(SUM(amount), 0) as amount")
                                                        ->where('user_id', '=', $val['id'])
                                                        ->where('withdraw_type', '=', "UNSTAKE")
                                                        ->get()->toArray();

            $legBusiness[$key]['my_business'] =
                (($val['my_business'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']) < 0
                ? 0
                : (($val['my_business'] + $userPlansAmount[0]['amount']) - $claimedRewards[0]['amount']);
        }

        usort($legBusiness, function ($a, $b) {
            return ($b["my_business"] <=> $a["my_business"]);
        });

        $strongBusiness = 0;
        $weakBusiness = 0;
        foreach ($legBusiness as $key => $val) {
            if ($key == 0) {
                $strongBusiness += $val['my_business'];
            } else {
                $weakBusiness += $val['my_business'];
            }
        }

        return ['strong' => $strongBusiness, 'weak' => $weakBusiness];
    }

    /**
     * Count valid direct referrals (>= $100)
     */
    // public function getValidReferrals($userId, $price)
    // {
    //     $directs = usersModel::select(
    //                                     'users.id',
    //                                     DB::raw('SUM(user_plans.amount) as total_amount')
    //                                 )
    //                                 ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
    //                                 ->where('users.sponser_id', $userId)
    //                                 ->groupBy('users.id')
    //                                 ->having('total_amount', '>=', 100)
    //                                 ->get();
    //     // print_r($directs->toArray());                                    
    //     return $directs->count();
    // }

    public function distributeBonus()
    {
        // STAR BONUS
        
        Log::channel('level_check')->info("In distributeBonus...");

        $TEST_MODE = false;

        $matrix = $this->getMatrix(); // Only loaded once

        $levelPct = [];


        $levelPct = ["0"=>0];

        foreach ($matrix as $lvl => $cfg) {
            $levelPct[(int)$lvl] = (float)($cfg['profit_ratio'][1] ?? 0.0);
        }

        $users = usersModel::where('level', '>', 0)->get();

        foreach ($users as $user) {

            if ($TEST_MODE) 
                echo "<hr><h2>USER: {$user->id} | Rank: {$user->level} | Percent: {$levelPct[$user->level]}%</h2>";
            
            Log::channel('level_check')->info("USER: {$user->id} | Rank: {$user->level} | Percent: {$levelPct[$user->level]}%");

            $userRank = $user->level;
            $userPercent = $levelPct[$userRank];

            $teamRoi = getTeamRoi($user->id);

            if ($TEST_MODE) echo "Total Team ROI: {$teamRoi}\n";

            Log::channel('level_check')->info("Total Team ROI: {$teamRoi}");

            $distributeAmount = 0;

            $directs = usersModel::where('sponser_id', $user->id)->get();

            if ($TEST_MODE) 
                echo "<h3>Directs of User {$user->id}:</h3>";
                foreach ($directs as $d) {
                    echo "→ Direct ID: {$d->id} | Rank: {$d->level} | ROI: " . getTeamRoi($d->id) . "\n";
                    Log::channel('level_check')->info("Direct ID: {$d->id} | Rank: {$d->level} | ROI: " . getTeamRoi($d->id));
                }

            foreach ($directs as $direct) {

                if ($TEST_MODE) echo "\n<b>--- Processing Direct: {$direct->id}</b>\n";

                Log::channel('level_check')->info("--- Processing Direct: {$direct->id}");

                $legRoi = getTeamRoi($direct->id);

                $remainingLegRoi = $legRoi;

                if ($TEST_MODE) 
                    echo "Leg ROI: {$legRoi}\n";

                Log::channel('level_check')->info("Leg ROI: {$legRoi}");

                $deductedTeamIds = [];
                $directIncluded = false;

                // Check direct himself
                if ($direct->level >= $userRank) {
                    if ($TEST_MODE) 
                        echo "Direct Rank >= User Rank (Direct Full Deduction)\n";

                    Log::channel('level_check')->info("Direct Rank >= User Rank (Direct Full Deduction)");

                    $directRoi = getTeamRoi($direct->id);

                    if ($TEST_MODE) 
                        echo "Direct Full Deduct ROI: {$directRoi}\n";

                    Log::channel('level_check')->info("Direct Full Deduct Direct ROI: {$directRoi} From Team ROI: {$teamRoi}");
                    Log::channel('level_check')->info("Direct Full Deduct Direct ROI: {$directRoi} From Remaining Leg ROI: {$remainingLegRoi}");

                    $teamRoi -= $directRoi;
                    $remainingLegRoi -= $directRoi;
                    $directIncluded = true;

                } 
                elseif ($direct->level > 0) 
                {

                    if ($TEST_MODE) 
                        echo "Direct Lower Rank (Differential Bonus)\n";

                    Log::channel('level_check')->info("Direct Lower Rank (Differential Bonus)");

                    $directRoi = getTeamRoi($direct->id);
                    $effectiveRoi = min($directRoi, $remainingLegRoi);
                    $diff = $userPercent - $levelPct[$direct->level];

                    if ($TEST_MODE) 
                        echo "Direct ROI: {$directRoi}\n";
                        echo "Effective ROI: {$effectiveRoi}\n";
                        echo "Diff Percent: {$diff}%\n";

                    Log::channel('level_check')->info("Direct ROI: {$directRoi}, Effective ROI: {$effectiveRoi}, Diff Percent: {$diff}%");

                    if ($diff > 0) {
                        Log::channel('level_check')->info("1 Give : {$diff} of Effective ROI {$effectiveRoi}");
                        $give = ($effectiveRoi * $diff / 100);
                        if ($TEST_MODE) echo "<b>Direct Differential Bonus Add: {$give}</b>\n";
                        $distributeAmount += $give;
                        Log::channel('level_check')->info("Direct Differential Bonus Add:{$give}");
                        Log::channel('level_check')->info("Distribute Amount: {$distributeAmount}");
                    }

                    $remainingLegRoi -= $effectiveRoi;
                    $deductedTeamIds[] = $direct->id;
                }

                if ($TEST_MODE) echo "Remaining Leg ROI after Direct: {$remainingLegRoi}\n";

                Log::channel('level_check')->info("Remaining Leg ROI after Direct: {$remainingLegRoi}");

                // Downline ranked members
                $rankedMembers = usersModel::join('my_team', 'my_team.team_id', '=', 'users.id')
                    ->where('my_team.user_id', $direct->id)
                    ->where('users.level', '>', 0)
                    ->orderBy('users.level', 'desc')
                    ->get();

                foreach ($rankedMembers as $rankedUser) {

                    if ($TEST_MODE) echo "→ Checking Ranked Downline: {$rankedUser->id} | Rank {$rankedUser->level}\n";

                    Log::channel('level_check')->info("Checking Ranked Downline: {$rankedUser->id} | Rank {$rankedUser->level}");

                    if (in_array($rankedUser->sponser_id, $deductedTeamIds)) {
                        if ($TEST_MODE) echo "SKIPPING (Already Deducted)\n";
                        Log::channel('level_check')->info("SKIPPING (Already Deducted)");
                        continue;
                    }

                    $rankedUserRoi = getTeamRoi($rankedUser->id);

                    if ($TEST_MODE) 
                        echo "Ranked User ROI: {$rankedUserRoi}\n";

                    Log::channel('level_check')->info("Ranked User ROI: {$rankedUserRoi}");

                    $effectiveRoi = min($rankedUserRoi, $remainingLegRoi);

                    if ($rankedUser->level >= $userRank) {
                        if ($TEST_MODE) 
                            echo "Downline Rank >= User Rank (Full Deduction) {$effectiveRoi}\n";

                        Log::channel('level_check')->info("Downline Rank >= User Rank (Full Deduction) {$effectiveRoi}");

                        $teamRoi -= $effectiveRoi;
                        $remainingLegRoi -= $effectiveRoi;

                    } else {

                        $diff = $userPercent - $levelPct[$rankedUser->level];

                        if ($TEST_MODE) 
                            echo "Downline Lower Rank | Diff %: {$diff}\n";

                        Log::channel('level_check')->info("Downline Lower Rank | Diff %: {$diff}");


                        if ($diff > 0) {
                            Log::channel('level_check')->info("2 Give : {$diff} of Effective ROI {$effectiveRoi}");
                        
                            $give = ($effectiveRoi * $diff / 100);
                            if ($TEST_MODE) 
                                echo "<b>Downline Differential Add: {$give}</b>\n";

                            Log::channel('level_check')->info("Downline Differential Add: {$give}");
                            Log::channel('level_check')->info("Distribute Amount: {$distributeAmount}");
                            $distributeAmount += $give;
                        }

                        $remainingLegRoi -= $effectiveRoi;
                    }

                    if ($TEST_MODE) 
                        echo "Remaining Leg ROI Now: {$remainingLegRoi}\n";

                    Log::channel('level_check')->info("Remaining Leg ROI Now: {$remainingLegRoi}");

                    $deductedTeamIds[] = $rankedUser->id;
                }

                if ($remainingLegRoi > 0) {
                    Log::channel('level_check')->info("3 Give : {$userPercent} of Remain Leg ROI {$remainingLegRoi}");
                    $give = ($remainingLegRoi * $userPercent / 100);
                    if ($TEST_MODE) 
                        echo "<b>Remaining Leg Full % Bonus Add: {$give}</b>\n";
                    Log::channel('level_check')->info("Remaining Leg Full percent Bonus Add: {$give}");
                    Log::channel('level_check')->info("Distribute Amount: {$distributeAmount}");
                    $distributeAmount += $give;
                }

                if ($TEST_MODE) 
                    echo "<b>Leg Processing Completed | Final Remaining: {$remainingLegRoi}</b>\n";

                Log::channel('level_check')->info("Leg Processing Completed | Final Remaining: {$remainingLegRoi}");

                $teamRoi -= $legRoi;

                if ($TEST_MODE) 
                    echo "Team ROI after subtracting this leg: {$teamRoi}\n";

                Log::channel('level_check')->info("Team ROI after subtracting this leg: {$teamRoi}");
            }

            if ($teamRoi > 0) {
                Log::channel('level_check')->info("4 Give : {$userPercent} of Team Leg ROI {$teamRoi}"); 

                $give = ($teamRoi * $userPercent / 100);

                if ($TEST_MODE) 
                    echo "<b>Final Team Remaining Bonus Add: {$give}</b>\n";
                Log::channel('level_check')->info("Final Team Remaining Bonus Add: {$give}");
                Log::channel('level_check')->info("Distribute Amount: {$distributeAmount}");
                $distributeAmount += $give;
            }

            if ($TEST_MODE) 
                echo "<h3>FINAL BONUS FOR USER {$user->id}: {$distributeAmount}</h3>";

            Log::channel('level_check')->info("FINAL BONUS FOR USER {$user->id}: {$distributeAmount}");

            if($distributeAmount>0)
            {
                $roi = [
                    'user_id' => $user->id,
                    'amount' => round($distributeAmount, 6),
                    'tag' => "DIFF-TEAM-BONUS", // STAR-BONUS",
                    'refrence' => $user->rank_id,
                    'refrence_id' => $teamRoi,
                    'created_on' => now(),
                    //'created_on' => '2025-11-29 20:05:00',
                    //"isSynced" => 1
                ];

                if ($TEST_MODE) 
                    echo "<pre>Insert Log: " . print_r($roi, true) . "</pre>";
            
                Log::channel('level_check')->info("Insert Log: " . json_encode($roi));

                if (!$TEST_MODE) 
                    earningLogsModel::insert($roi);
                    DB::statement("UPDATE users 
                                SET rank_bonus = IFNULL(rank_bonus, 0) + {$roi['amount']} 
                                WHERE id = {$user->id}");

                if ($TEST_MODE) echo "<b>Rank Bonus Updated for User {$user->id}</b>\n\n";
            }           
        }
    }


}
