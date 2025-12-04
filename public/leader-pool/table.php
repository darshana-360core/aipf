<?php
$host = '127.0.0.1';
$user = 'root';
$password = 'Truepoints@@987$$';
$dbname = 'stakefundx';

$conn = mysqli_connect($host, $user, $password, $dbname);

$userAddress = array();

$getAllUsers = mysqli_query($conn, "SELECT id,wallet_address FROM users");
while($fetAllUsers = mysqli_fetch_assoc($getAllUsers))
{
    $userAddress[$fetAllUsers['id']] = $fetAllUsers['wallet_address'];
}

$getInvestment = mysqli_query($conn, "SELECT el.*
FROM earning_logs el
JOIN (
    SELECT user_id, MAX(id) AS max_id
    FROM earning_logs
    WHERE DATE_FORMAT(created_on, '%Y-%m-%d') = '2025-07-16'  AND tag = 'ROI'
    GROUP BY user_id
) latest ON el.user_id = latest.user_id AND el.id = latest.max_id
ORDER BY el.id DESC;
");

$thresholdOn16 = array();

while($fetInvestment = mysqli_fetch_assoc($getInvestment))
{
  $thresholdOn16[$fetInvestment['user_id']] = $fetInvestment['refrence'];
}

$newCompound = array();

$getNewCompound = mysqli_query($conn, "SELECT * FROM user_plans ");

while($fetNewCompound = mysqli_fetch_assoc($getNewCompound))
{
  $newCompound[$fetNewCompound['user_id']] += $fetNewCompound['compound_amount'];
}

$newInvestments = array();

$getNewInvestment = mysqli_query($conn, "SELECT * FROM user_plans where DATE_FORMAT(created_on, '%Y-%m-%d') >= '2025-07-17'");

while($fetNewInvestment = mysqli_fetch_assoc($getNewInvestment))
{
  $newInvestments[$fetNewInvestment['user_id']] += $fetNewInvestment['amount'];
}

$newUnstake = array();

$getNewUnstake = mysqli_query($conn, "SELECT * FROM withdraw where DATE_FORMAT(created_on, '%Y-%m-%d') >= '2025-07-17' and withdraw_type = 'UNSTAKE' and status = 1");

while($fetNewUnstake = mysqli_fetch_assoc($getNewUnstake))
{
  $newUnstake[$fetNewUnstake['user_id']] += $fetNewUnstake['amount'];
}


foreach ($userAddress as $key => $value)
{
  $prev = $thresholdOn16[$key] ?? 0;
  $new = $newInvestments[$key] ?? 0;
  $ns = $newUnstake[$key] ?? 0;
  $us = $newCompound[$key] ?? 0;
  $reward = ($new > $prev) ? round(($new - $prev) * 0.005, 6) : 0;
  $totalReward += $reward;                    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Developer Pools</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400..800&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>

<body class="bg-black text-white">
  <section class="grid grid-cols-1 gap-5 mt-5 bg-black text-white">
    <div class="container px-2 sm:px-4 mx-auto">
      <div class="w-full p-4 md:p-5 bg-[#171531] rounded-xl">
        <!-- Header Section -->
        <div class="text-center mb-12">
          <div class="inline-flex items-center gap-3 mb-6">
            <div class="w-2 h-12 bg-gradient-to-b from-blue-400 to-purple-600 rounded-full"></div>
            <h1 class="text-4xl md:text-5xl font-bold text-white">Developer Pool Rewards</h1>
            <div class="w-2 h-12 bg-gradient-to-b from-purple-600 to-pink-600 rounded-full"></div>
          </div>
          <p class="text-xl text-gray-300 max-w-3xl mx-auto">
            Participate in our revolutionary reward distribution system powered by transaction fees
          </p>
          <div class="mt-4 inline-flex items-center gap-2 bg-gray-800/50 rounded-full px-4 py-2 text-sm text-gray-400">
            <div class="w-2 h-2 rounded-full bg-green-500"></div>
            Live contract data
          </div>
        </div>

        <!-- Overview Stats Boxes -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 overflow-hidden">
          <!-- Box 1 -->
          <div class="group relative flex flex-row items-center justify-between gap-2 md:gap-4 rounded-3xl px-6 pt-8 pb-12 text-left text-black border overflow-hidden" style="background-color: #0BF4C8; border-color: #0BF4C8;">
            <div class="flex flex-col relative z-10">
              <p class="text-base lg:text-lg leading-none mb-6 font-semibold">Pool Allocation</p>
              <h4 class="text-lg lg:text-xl text-black font-semibold leading-none">0.5%</h4>
            </div>
            <div class="absolute bottom-3 right-3 z-[9] pointer-events-none opacity-45">
              <img src="https://orbitx.world/assets/images/icons/marketvalue.webp" class="object-contain w-24 h-24" />
            </div>
            <div class="w-full h-full absolute top-0 left-0 p-2 z-0 pointer-events-none opacity-35">
              <img src="https://orbitx.world/assets/images/boxbgline.svg" class="w-auto h-auto object-contain mx-auto" />
            </div>
          </div>

          <!-- Box 2 -->
          <div class="group relative flex flex-row items-center justify-between gap-2 md:gap-4 rounded-3xl px-6 pt-8 pb-12 text-left text-black border overflow-hidden" style="background-color: #FAD85D; border-color: #FAD85D;">
            <div class="flex flex-col relative z-10">
              <p class="text-base lg:text-lg leading-none mb-6 font-semibold">Pool Amount</p>
              <h4 class="text-lg lg:text-xl text-black font-semibold leading-none">
                <?php echo round($totalReward, 2); ?> RTX
              </h4>
            </div>
            <div class="absolute bottom-3 right-3 z-[9] pointer-events-none opacity-45">
              <img src="https://orbitx.world/assets/images/icons/totalsupply.webp" class="object-contain w-24 h-24" />
            </div>
            <div class="w-full h-full absolute top-0 left-0 p-2 z-0 pointer-events-none opacity-35">
              <img src="https://orbitx.world/assets/images/boxbgline.svg" class="w-auto h-auto object-contain mx-auto" />
            </div>
          </div>

          <!-- Box 3 -->
          <div class="group relative flex flex-row items-center justify-between gap-2 md:gap-4 rounded-3xl px-6 pt-8 pb-12 text-left text-black border overflow-hidden" style="background-color: #F2A0FF; border-color: #F2A0FF;">
            <div class="flex flex-col relative z-10">
              <p class="text-base lg:text-lg leading-none mb-6 font-semibold">Pool Members</p>
              <h4 class="text-lg lg:text-xl text-black font-semibold leading-none">1</h4>
            </div>
            <div class="absolute bottom-3 right-3 z-[9] pointer-events-none opacity-45">
              <img src="https://orbitx.world/assets/images/icons/rtxprice.webp" class="object-contain w-24 h-24" />
            </div>
            <div class="w-full h-full absolute top-0 left-0 p-2 z-0 pointer-events-none opacity-35">
              <img src="https://orbitx.world/assets/images/boxbgline.svg" class="w-auto h-auto object-contain mx-auto" />
            </div>
          </div>
        </div>

        <!-- TABLE: User Rewards -->
        <div class="overflow-x-auto">
          <table class="min-w-full bg-gray-900 rounded-lg overflow-hidden">
            <thead class="bg-gray-700 text-gray-300 text-sm uppercase tracking-wider">
              <tr>
                <th class="px-6 py-3 text-left">Sr NO.</th>
                <th class="px-6 py-3 text-left">User ID</th>
                <th class="px-6 py-3 text-left">Previous Staked</th>
                <th class="px-6 py-3 text-left">New Staked</th>
                <th class="px-6 py-3 text-left">New Unstaked</th>
                <th class="px-6 py-3 text-left">Reward (0.5%)</th>
              </tr>
            </thead>
            <tbody class="text-gray-100 divide-y divide-gray-700 text-sm">
              <?php 
                $srNo = 1;
              ?>
              <?php foreach ($newInvestments as $key => $value): ?>
              <tr>
                <td class="px-6 py-4"><?php echo $srNo++; ?></td>
                <td class="px-6 py-4"><?php echo substr($userAddress[$key], 0, 6) . '...' . substr($userAddress[$key], -6); ?></td>
                <td class="px-6 py-4"><?php echo $thresholdOn16[$key] ?? 0; ?></td>
                <td class="px-6 py-4"><?php echo $newInvestments[$key] ?? 0; ?></td>
                <td class="px-6 py-4"><?php
                  $unstake = $newUnstake[$key] ?? 0;
                  $compound = $newCompound[$key] ?? 0;
                  $stake = $newStake[$key] ?? 0;
                  echo ($unstake > $compound) ? ($unstake - $compound) : $stake;
                ?></td>
                <td class="px-6 py-4">
                   <?php
                      $prev = $thresholdOn16[$key] ?? 0;
                      $new = $newInvestments[$key] ?? 0;
                      $reward = ($new > $prev) ? round(($new - $prev) * 0.005, 6) : 0;
                      echo $reward;
                    ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        </div>

      </div>
    </div>
  </section>
</body>

</html>