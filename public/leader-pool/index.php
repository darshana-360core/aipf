<?php
$host = '127.0.0.1';
$user = 'root';
$password = 'Qf2rYtVd0YuloxWP';
$dbname = 'aipf';

$conn = mysqli_connect($host, $user, $password, $dbname);

$getLeader = mysqli_query($conn, "SELECT id, wallet_address, my_daily_business,my_business, unstake_business, (my_daily_business * 0.10) as reward_amount, (my_daily_business * 0.10) / 7 as today_amount FROM users WHERE wallet_address = '0xdF4C6761F6f00e5982a4295d3D11FE6Fa64aE210'");

$leaders = array();

$j=0;

while($fetLeader = mysqli_fetch_assoc($getLeader))
{
  $leaders[$j] = $fetLeader;
  $leaders[$j]['reward_date'] = date('Y-m-d');
  $j++;
}

if($_POST['type'] == "API")
{
  $remaingingRewards = array();
  $getRemaingReward = mysqli_query($conn, "SELECT *, count(id) as sent FROM `leader_pools` GROUP by reward_date HAVING sent < 7");
  $r=0;
  while($fetRemaingReward = mysqli_fetch_assoc($getRemaingReward))
  {
    $remaingingRewards[$r] = $fetRemaingReward;
    $r++;
  }

  $res['status_code'] = 1;
  $res['message'] = "Success";
  $res['leaders'] = $leaders;
  $res['remaingingRewards'] = $remaingingRewards;
  echo json_encode($res, true);
  die;
}

$getLeaders = mysqli_query($conn, "SELECT * FROM `leader_pools`");
$leaderLogs = array();

$rewardAmount = 0;
$i=0;
while($fetLeaders = mysqli_fetch_assoc($getLeaders))
{
  $rewardAmount += $fetLeaders['amount'];
  $leaderLogs[$i] = $fetLeaders;
  $i++;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Leader Pools</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400..800&display=swap" rel="stylesheet" />

  <!-- Tailwind CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />

  <style>
    body {
      font-family: "Syne", sans-serif;
      background-color: #000;
      color: #d1fae5;
    }

    .card-bg {
      background: linear-gradient(135deg, #022b1a 0%, #014f2b 100%);
      border: 1px solid #10b981;
    }

    .box-line {
      opacity: 0.2;
    }
  </style>
</head>

<body>

<section class="grid grid-cols-1 gap-5 mt-6">

  <div class="container px-2 sm:px-4 mx-auto">
    <div class="w-full p-5 bg-[#001a12] rounded-xl border border-green-600/40 shadow-lg">

      <!-- HEADER -->
      <div class="text-center mb-12">
        <div class="inline-flex items-center gap-3 mb-6">
          <div class="w-2 h-12 bg-gradient-to-b from-green-400 to-emerald-600 rounded-full"></div>
          <h1 class="text-4xl md:text-5xl font-extrabold text-green-400 drop-shadow-lg">Leader Pool Rewards</h1>
          <div class="w-2 h-12 bg-gradient-to-b from-emerald-600 to-green-700 rounded-full"></div>
        </div>

        <p class="text-lg text-green-200 max-w-2xl mx-auto">
          Participate in the decentralized reward distribution system.
        </p>
      </div>

      <!-- 3 Stats Boxes -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">

        <!-- Box 1 -->
        <div class="relative card-bg rounded-3xl px-6 pt-8 pb-12 flex justify-between overflow-hidden">
          <div class="z-10">
            <p class="text-lg font-semibold text-green-300 mb-5">Total Business</p>
            <h4 class="text-2xl font-bold text-green-400"><?php echo number_format($leaders['0']['my_business'], 2); ?> AIP</h4>
          </div>

          <!-- SVG Icon -->
          <div class="absolute bottom-3 right-3 opacity-40 z-0">
            <svg width="80" height="80" fill="none" stroke="#34d399" stroke-width="2">
              <circle cx="40" cy="40" r="30"></circle>
              <path d="M40 15 L40 40 L60 40"></path>
            </svg>
          </div>
        </div>

        <!-- Box 2 -->
        <div class="relative card-bg rounded-3xl px-6 pt-8 pb-12 flex justify-between overflow-hidden">
          <div class="z-10">
            <p class="text-lg font-semibold text-green-300 mb-5">Total Unstake</p>
            <h4 class="text-2xl font-bold text-green-400"><?php echo number_format($leaders['0']['unstake_business'], 2); ?> AIP</h4>
          </div>

          <!-- SVG Icon -->
          <div class="absolute bottom-3 right-3 opacity-40 z-0">
            <svg width="80" height="80" fill="none" stroke="#34d399" stroke-width="2">
              <rect x="15" y="20" width="50" height="40" rx="6"></rect>
              <circle cx="40" cy="40" r="10"></circle>
            </svg>
          </div>
        </div>

        <!-- Box 3 -->
        <div class="relative card-bg rounded-3xl px-6 pt-8 pb-12 flex justify-between overflow-hidden">
          <div class="z-10">
            <p class="text-lg font-semibold text-green-300 mb-5">Pool Allocation(10%)</p>
            <h4 class="text-2xl font-bold text-green-400"><?php echo number_format($leaders['0']['my_business'] * 0.10, 2) ?></h4>
          </div>

          <!-- SVG Icon -->
          <div class="absolute bottom-3 right-3 opacity-40 z-0">
            <svg width="80" height="80" stroke="#34d399" stroke-width="2" fill="none">
              <circle cx="40" cy="28" r="10"></circle>
              <path d="M15 65 C15 50, 65 50, 65 65 Z"></path>
            </svg>
          </div>
        </div>

        <!-- Box 4 -->
        <div class="relative card-bg rounded-3xl px-6 pt-8 pb-12 flex justify-between overflow-hidden">
          <div class="z-10">
            <p class="text-lg font-semibold text-green-300 mb-5">Total Reward</p>
            <h4 class="text-2xl font-bold text-green-400"><?php echo number_format($rewardAmount, 2); ?></h4>
          </div>

          <!-- SVG Icon -->
          <div class="absolute bottom-3 right-3 opacity-40 z-0">
            <svg width="80" height="80" stroke="#34d399" stroke-width="2" fill="none">
              <circle cx="40" cy="28" r="10"></circle>
              <path d="M15 65 C15 50, 65 50, 65 65 Z"></path>
            </svg>
          </div>
        </div>

      </div>

      <!-- TABLE -->
      <div class="overflow-x-auto">
        <table class="min-w-full bg-green-900/20 border border-green-700/40 rounded-lg overflow-hidden shadow">
          <thead class="bg-green-800/40 text-green-300 uppercase text-sm tracking-wider">
            <tr>
              <th class="px-6 py-3 text-left">Sr No.</th>
              <th class="px-6 py-3 text-left">Amount</th>
              <th class="px-6 py-3 text-left">Transaction Hash</th>
              <th class="px-6 py-3 text-left">Reward Refrence</th>
              <th class="px-6 py-3 text-left">Date</th>
            </tr>
          </thead>
          <tbody class="text-green-100 divide-y divide-green-800 text-sm">
            <?php 
              foreach($leaderLogs as $key => $value)
              {
                ?>
                <tr>
                  <td class="px-6 py-3 text-left"><?php echo ($key+1); ?></td>
                  <td class="px-6 py-3 text-left"><?php echo number_format($value['amount'], 2); ?></td>
                  <td class="px-6 py-3 text-left">
                    <a target="_blank" href="https://polygonscan.com/tx/<?php echo $value['transaction_hash']; ?>"><?php echo $value['transaction_hash']; ?></a>
                  </td>
                  <td class="px-6 py-3 text-left"><?php echo number_format($value['reward_amount'], 2) . " / " . $value['reward_date']; ?></td>
                  <td class="px-6 py-3 text-left"><?php echo date('d-m-Y', strtotime($value['created_on'])); ?></td>
                </tr>
                <?php
              }
            ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>

</section>

</body>
</html>