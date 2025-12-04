<?php
public function checkCitizenAllianceReward(Request $request)
{
    $citizenAllianceMatrix = [
    1=>['level' => 'S1', 'personal_holding' => 100, 'team_requirement' => ['type' => 'volume', 'value' => 5000], 'valid_referrals' => 2, 'profit_ratio' => [5, 10]],
    2=>['level' => 'S2', 'personal_holding' => 500, 'team_requirement' => ['type' => 'volume', 'value' => 20000], 'valid_referrals' => 3, 'profit_ratio' => [10, 20]],
    3=>['level' => 'S3', 'personal_holding' => 1000, 'team_requirement' => ['type' => 'volume', 'value' => 50000], 'valid_referrals' => 5, 'profit_ratio' => [15, 30]],
    4=>['level' => 'S4', 'personal_holding' => 2000, 'team_requirement' => ['type' => 'volume', 'value' => 150000], 'valid_referrals' => 10, 'profit_ratio' => [20, 40]],
    5=>['level' => 'S5', 'personal_holding' => 3000, 'team_requirement' => ['type' => 'volume', 'value' => 400000], 'valid_referrals' => 15, 'profit_ratio' => [25, 50]],
    6=>['level' => 'S6', 'personal_holding' => 5000, 'team_requirement' => ['type' => 'volume', 'value' => 1000000], 'valid_referrals' => 15, 'profit_ratio' => [30, 60]],
    7=>['level' => 'S7', 'personal_holding' => 10000, 'team_requirement' => ['type' => 'volume', 'value' => 2500000], 'valid_referrals' => 15, 'profit_ratio' => [35, 70]],
    8=>['level' => 'S8', 'personal_holding' => 12000, 'team_requirement' => ['type' => 'volume', 'value' => 6000000], 'valid_referrals' => 15, 'profit_ratio' => [40, 80]],
    9=>['level' => 'S9', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'volume', 'value' => 15000000], 'valid_referrals' => 15, 'profit_ratio' => [45, 90]],
    10=>['level' => 'S10', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '9','count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [50, 100]],
    11=>['level' => 'S11', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '10', 'count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [55, 110]],
    12=>['level' => 'S12', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '11', 'count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [60, 120]],
    13=>['level' => 'S13', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '12', 'count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [65, 130]],
    14=>['level' => 'S14', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '13', 'count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [70, 140]],
    15=>['level' => 'S15', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '14', 'count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [75, 150]]
                            ];

    $criteriaMatch = true;

    $levelSelected = $citizenAllianceMatrix[1];

    // 1. Collect the ranked users
    $users = usersModel::where('status', 1)->get();

    foreach ($users as $user) {
        
        $userId = $user->id;
        $userLevel = $user->level;
        
        //2. Collect the self stake amount
        $personalHolding = getUserStakedAmount($userId);
        if($personalHolding < $levelSelected['personal_holding'])
        {
            $criteriaMatch = false;
        }

        //3. Collect valid referrals or direct counts
        $directs = usersModel::select('users.id')
                        ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                        ->where('users.sponser_id', $user->id)
                        ->groupBy('users.id')
                        ->get();
        $coinPrice = rtxPrice();
        $directCount = 0;
        foreach ($directs as $direct) 
        {
            $stakeAmount = getUserStakedAmount($direct->id);
            if ($stakeAmount * $coinPrice >= 100)
            {
                $directCount++;
            }
        }

        if($directCount < $levelSelected['valid_referrals'])
        {
            $criteriaMatch = false;
        }

        //4. Collect Total Ordinary Staking
        $totalOrdinaryStaking = $user->my_business; 
        if($levelSelected['team_requirement']['type'] == 'volume')
        {
            if($totalOrdinaryStaking < $levelSelected['team_requirement']['value'])
            {
                $criteriaMatch = false;
            }
        }
        else if($levelSelected['team_requirement']['type'] == 'hold_level')
        {
            $teamData = myTeamModel::join('user_plans', 'user_plans.user_id', '=', 'my_team.team_id')
                                        ->join('users', 'users.id', '=', 'my_team.user_id') 
                                        ->where('my_team.user_id', $userId)
                                        ->where('user_plans.status', 1)
                                        ->where('users.level', $levelSelected['team_requirement']['level']) // Filter users with Citizen Alliance Reward i.e. car = 9
                                        ->groupBy('my_team.team_id') 
                                        ->get()
                                        ->count();
            if ($teamData < $levelSelected['team_requirement']['count']) 
            {
                $criteriaMatch = false;
            } 
        }

        //5. Update level in users
        if ($criteriaMatch == true)
        {
            echo "Matched, hence update level to :". $levelSelected['level']."<br>";
            // usersModel::where(['id' => $userId])->update(['level' => $levelSelected['level']]);
        }
        else{
            echo "Not matched, hence update level to :". $levelSelected['level']."<br>";
            // usersModel::where(['id' => $userId])->update(['level' => 0]);
        }
    }
}
public function citizenAllianceRewardBonus(Request $request)
{
    $citizenAllianceMatrix = [
    1=>['level' => 'S1', 'personal_holding' => 100, 'team_requirement' => ['type' => 'volume', 'value' => 5000], 'valid_referrals' => 2, 'profit_ratio' => [5, 10]],
    2=>['level' => 'S2', 'personal_holding' => 500, 'team_requirement' => ['type' => 'volume', 'value' => 20000], 'valid_referrals' => 3, 'profit_ratio' => [10, 20]],
    3=>['level' => 'S3', 'personal_holding' => 1000, 'team_requirement' => ['type' => 'volume', 'value' => 50000], 'valid_referrals' => 5, 'profit_ratio' => [15, 30]],
    4=>['level' => 'S4', 'personal_holding' => 2000, 'team_requirement' => ['type' => 'volume', 'value' => 150000], 'valid_referrals' => 10, 'profit_ratio' => [20, 40]],
    5=>['level' => 'S5', 'personal_holding' => 3000, 'team_requirement' => ['type' => 'volume', 'value' => 400000], 'valid_referrals' => 15, 'profit_ratio' => [25, 50]],
    6=>['level' => 'S6', 'personal_holding' => 5000, 'team_requirement' => ['type' => 'volume', 'value' => 1000000], 'valid_referrals' => 15, 'profit_ratio' => [30, 60]],
    7=>['level' => 'S7', 'personal_holding' => 10000, 'team_requirement' => ['type' => 'volume', 'value' => 2500000], 'valid_referrals' => 15, 'profit_ratio' => [35, 70]],
    8=>['level' => 'S8', 'personal_holding' => 12000, 'team_requirement' => ['type' => 'volume', 'value' => 6000000], 'valid_referrals' => 15, 'profit_ratio' => [40, 80]],
    9=>['level' => 'S9', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'volume', 'value' => 15000000], 'valid_referrals' => 15, 'profit_ratio' => [45, 90]],
    10=>['level' => 'S10', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '9','count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [50, 100]],
    11=>['level' => 'S11', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '10', 'count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [55, 110]],
    12=>['level' => 'S12', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '11', 'count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [60, 120]],
    13=>['level' => 'S13', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '12', 'count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [65, 130]],
    14=>['level' => 'S14', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '13', 'count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [70, 140]],
    15=>['level' => 'S15', 'personal_holding' => 15000, 'team_requirement' => ['type' => 'hold_level', 'level' => '14', 'count' => 2], 'valid_referrals' => 15, 'profit_ratio' => [75, 150]]
                            ];
        $rankPercentage = array();
        foreach($citizenAllianceMatrix as $key => $matrix)
        {
            $rankPercentage[$key] = $matrix['profit_ratio'];
        }    

        $users = usersModel::where('level', '>', 0)->get();

        foreach ($users as $user) {
            $userLevel = $user->level;
            $userPercent = $rankPercentage[$userLevel][0];
            $teamRoi = ($user->my_business * 0.0035); //getTeamRoi($user->id);
            $distributeAmount = 0;

            $directs = usersModel::where('sponser_id', $user->id)->get();

            foreach ($directs as $direct) {
                $legRoi = ($direct->my_business * 0.0035); //getTeamRoi($direct->id);
                $remainingLegRoi = $legRoi;

                $deductedTeamIds = [];
                $directIncluded = false;

                // First, check the direct himself
                if ($direct->level >= $userLevel) {
                    // Direct is higher/equal ranked → subtract full ROI
                    $directRoi = ($direct->my_business * 0.0035); //getTeamRoi($direct->id);
                    $teamRoi -= $directRoi;
                    $remainingLegRoi -= $directRoi;
                    $directIncluded = true;
                } elseif ($direct->rank_id > 0) {
                    // Direct is lower ranked → give differential bonus
                    $directRoi = ($direct->my_business * 0.0035); //getTeamRoi($direct->id);
                    $effectiveRoi = min($directRoi, $remainingLegRoi);
                    $diff = $userPercent - $rankPercentage[$direct->level];

                    if ($diff > 0) {
                        $distributeAmount += ($effectiveRoi * $diff / 100);
                    }

                    $remainingLegRoi -= $effectiveRoi;
                    $deductedTeamIds[] = $direct->id;
                }

                // Now go through downline ranked members
                $rankedMembers = usersModel::join('my_team', 'my_team.team_id', '=', 'users.id')
                    ->where('my_team.user_id', $direct->id)
                    ->where('users.level', '>', 0)
                    ->orderBy('users.level', 'desc')
                    ->get();

                foreach ($rankedMembers as $rankedUser) {
                    if (in_array($rankedUser->sponser_id, $deductedTeamIds)) {
                        continue;
                    }

                    $rankedUserRoi = ($rankedUser->my_business * 0.0035); //getTeamRoi($rankedUser->id);
                    $effectiveRoi = min($rankedUserRoi, $remainingLegRoi);

                    if ($rankedUser->level >= $userLevel) {
                        $teamRoi -= $effectiveRoi;
                        $remainingLegRoi -= $effectiveRoi;
                    } else {
                        $diff = $userPercent - $rankPercentage[$rankedUser->level][0];
                        if ($diff > 0) {
                            $distributeAmount += ($effectiveRoi * $diff / 100);
                        }
                        $remainingLegRoi -= $effectiveRoi;
                    }

                    $deductedTeamIds[] = $rankedUser->id;
                }

                // Remaining ROI in leg → full % bonus
                if ($remainingLegRoi > 0) {
                    $distributeAmount += ($remainingLegRoi * $userPercent / 100);
                }

                $teamRoi -= $legRoi;
            }

            // Final remaining ROI (other than directs) → full % bonus
            if ($teamRoi > 0) {
                $distributeAmount += ($teamRoi * $userPercent / 100);
            }

            $roi = [
                'user_id' => $user->id,
                'amount' => round($distributeAmount, 6),
                'tag' => "CZNREWARD-BONUS",
                'refrence' => $user->level,
                'refrence_id' => $teamRoi,
                'created_on' => now(),
            ];

            // earningLogsModel::insert($roi);

            // DB::statement("UPDATE users SET rank_bonus = IFNULL(rank_bonus, 0) + {$roi['amount']} WHERE id = {$user->id}");

            echo "<pre>"; print_r($roi); echo "</pre>";
        }

    }
}