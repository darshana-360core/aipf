<?php
$host = '127.0.0.1';
$user = 'dbadmin';
$password = 'Rfw57ebsNkti$57RfwNktiebs';
$dbname = 'aipf';

$conn = mysqli_connect($host, $user, $password, $dbname);

$userAddress = array();
$thresholdOn16 = array();

$getAllUsers = mysqli_query($conn, "SELECT id,wallet_address FROM users");
while ($fetAllUsers = mysqli_fetch_assoc($getAllUsers)) {
  $userAddress[$fetAllUsers['id']] = $fetAllUsers['wallet_address'];
  $thresholdOn16[$fetAllUsers['id']] = 0;
}

$newCompound = array();

$getNewCompound = mysqli_query($conn, "SELECT * FROM user_plans ");

while ($fetNewCompound = mysqli_fetch_assoc($getNewCompound)) {
  if (!isset($newCompound[$fetNewCompound['user_id']])) {
    $newCompound[$fetNewCompound['user_id']] = 0;
  }
  $newCompound[$fetNewCompound['user_id']] += $fetNewCompound['compound_amount'];
}

$newInvestments = array();

$getNewInvestment = mysqli_query($conn, "SELECT * FROM user_plans");

while ($fetNewInvestment = mysqli_fetch_assoc($getNewInvestment)) {
  if (!isset($newInvestments[$fetNewInvestment['user_id']])) {
    $newInvestments[$fetNewInvestment['user_id']] = 0;
  }
  $newInvestments[$fetNewInvestment['user_id']] += $fetNewInvestment['amount'];
}

$newUnstake = array();

$getNewUnstake = mysqli_query($conn, "SELECT * FROM withdraw where withdraw_type = 'UNSTAKE' and status = 1");

while ($fetNewUnstake = mysqli_fetch_assoc($getNewUnstake)) {
  if (!isset($newUnstake[$fetNewUnstake['user_id']])) {
    $newUnstake[$fetNewUnstake['user_id']] = 0;
  }
  $newUnstake[$fetNewUnstake['user_id']] += $fetNewUnstake['amount'];
}

$totalReward = 0;
foreach ($userAddress as $key => $value) {
  $prev = $thresholdOn16[$key] ?? 0;
  $new = $newInvestments[$key] ?? 0;
  $reward = ($new > $prev) ? round(($new - $prev) * 0.04, 6) : 0;
  $totalReward += $reward;
}

$getDevEntry = mysqli_query($conn, "SELECT SUM(amount) as amount FROM other_pools");
$fetDevEntry = mysqli_fetch_assoc($getDevEntry);

$totalReward = ($totalReward - $fetDevEntry['amount']);

// $totalReward = $totalReward / 3;

$res['status_code'] = 1;
$res['message'] = "Success";
$res['pool_amount'] = ($totalReward);

if (isset($_POST['type']) && $_POST['type'] == "API") {
  echo json_encode($res, true);
  die;
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Founder Pools</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="icon" href="https://defi.orbitx.world/assets/images/favico.ico">
  <style>
    :root {
      --card: rgba(255, 255, 255, 0.04);
      --card-border: rgba(255, 255, 255, 0.29);
      --glow: 0 10px 40px rgba(91, 75, 255, 0.35);
      --grid: radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.07) 1px, transparent 0);
    }
    body { font-family: "Poppins", system-ui, sans-serif; }
    .bg-hero {
      background:
        radial-gradient(60rem 60rem at 110% -10%, rgba(168, 85, 247, 0.20), transparent 40%),
        radial-gradient(50rem 50rem at -10% 110%, rgba(59, 130, 246, 0.18), transparent 40%),
        #050509;
    }
    .grid-overlay {
      background-image: var(--grid);
      background-size: 24px 24px;
      mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), transparent);
      opacity: .35;
      pointer-events: none;
    }
    .card {
      background: linear-gradient(180deg, rgba(255, 255, 255, .05), rgba(255, 255, 255, .02));
      border: 1px solid var(--card-border);
      backdrop-filter: blur(8px);
      transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .card:hover { transform: translateY(-4px); box-shadow: var(--glow); border-color: rgba(255, 255, 255, 0.18); }
    .pill {
      border: 1px solid rgba(255, 255, 255, 0.15);
      background: rgba(255, 255, 255, 0.06);
      backdrop-filter: blur(6px);
    }
    .shine { position: relative; overflow: hidden; }
    .shine::after {
      content: "";
      position: absolute; inset: -200% -50% auto -50%; height: 200%;
      transform: rotate(25deg);
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .12), transparent);
      animation: shine 6s linear infinite;
    }
    @keyframes shine { 0% { left: -120% } 100% { left: 120% } }
    .tag { font-size: .7rem; letter-spacing: .1em; text-transform: uppercase; }
    .icon-wrap { width: 64px; height: 64px; opacity: .8; }
  </style>
</head>

<body class="bg-hero text-white min-h-full relative">
  <div class="grid-overlay absolute inset-0"></div>

  <section class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <header class="text-center mb-10">
      <div class="inline-flex items-center gap-3 mb-5">
        <span class="w-2 h-10 rounded-full bg-gradient-to-b from-gray-400 to-white-600"></span>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">Developer Pool Rewards</h1>
        <span class="w-2 h-10 rounded-full bg-gradient-to-b from-gray-400 to-white-600"></span>
      </div>
      <p class="max-w-2xl mx-auto text-gray-300">
        Participate in our reward distribution system powered by transaction fees.
      </p>
      <div class="mt-5 inline-flex items-center gap-2 pill rounded-full px-4 py-2 text-sm text-gray-300">
        <span class="w-2 h-2 rounded-full bg-green-500"></span>
        Live contract data
      </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
      <!-- Pool Allocation -->
      <div class="card rounded-2xl p-6 shine">
        <div class="flex items-start justify-between">
          <div>
            <div class="tag text-gray-300 mb-2">Pool Allocation</div>
            <div class="text-3xl font-extrabold">4%</div>
          </div>
          <!-- SVG: Donut/Pie icon -->
          <svg class="icon-wrap" viewBox="0 0 48 48" fill="none" aria-hidden="true">
            <defs>
              <linearGradient id="g1" x1="0" y1="0" x2="48" y2="48" gradientUnits="userSpaceOnUse">
                <stop stop-color="#34d399"/>
                <stop offset="1" stop-color="#22d3ee"/>
              </linearGradient>
            </defs>
            <circle cx="24" cy="24" r="18" stroke="url(#g1)" stroke-width="6" opacity=".35"/>
            <path d="M24 6a18 18 0 1 1-12.73 30.73L24 24V6z" fill="url(#g1)"/>
            <circle cx="24" cy="24" r="8" fill="#050509"/>
          </svg>
        </div>
        <div class="mt-4 h-2 w-full bg-white bg-opacity-10 rounded-full overflow-hidden">
          <div class="h-full bg-gradient-to-r from-emerald-400 to-cyan-300" style="width: 3%;"></div>
        </div>
      </div>

      <!-- Pool Amount -->
      <div class="card rounded-2xl p-6 shine">
        <div class="flex items-start justify-between">
          <div>
            <div class="tag text-gray-300 mb-2">Pool Amount</div>
            <div class="text-3xl font-extrabold">
              <?php echo round(($totalReward), 2); ?> AIP
            </div>
          </div>
          <!-- SVG: Coins stack -->
          <svg class="icon-wrap" viewBox="0 0 64 64" fill="none" aria-hidden="true">
            <defs>
              <linearGradient id="g2" x1="0" y1="0" x2="64" y2="64" gradientUnits="userSpaceOnUse">
                <stop stop-color="#fde047"/>
                <stop offset="1" stop-color="#f59e0b"/>
              </linearGradient>
            </defs>
            <ellipse cx="32" cy="16" rx="16" ry="6" fill="url(#g2)" opacity=".9"/>
            <path d="M16 16v8c0 3.3 7.2 6 16 6s16-2.7 16-6v-8" fill="url(#g2)" opacity=".65"/>
            <ellipse cx="32" cy="24" rx="16" ry="6" fill="url(#g2)" opacity=".9"/>
            <path d="M16 24v8c0 3.3 7.2 6 16 6s16-2.7 16-6v-8" fill="url(#g2)" opacity=".65"/>
            <ellipse cx="32" cy="32" rx="16" ry="6" fill="url(#g2)" opacity=".9"/>
            <path d="M16 32v8c0 3.3 7.2 6 16 6s16-2.7 16-6v-8" fill="url(#g2)" opacity=".65"/>
            <ellipse cx="32" cy="40" rx="16" ry="6" fill="url(#g2)" opacity=".9"/>
          </svg>
        </div>
        <p class="mt-3 text-sm text-gray-300">
          Auto-updated from live calculations.
        </p>
      </div>

      <!-- Pool Members -->
      <div class="card rounded-2xl p-6 shine">
        <div class="flex items-start justify-between">
          <div>
            <div class="tag text-gray-300 mb-2">Pool Members</div>
            <div class="text-3xl font-extrabold">1</div>
          </div>
        <!-- SVG: Users group -->
          <svg class="icon-wrap" viewBox="0 0 48 48" fill="none" aria-hidden="true">
            <defs>
              <linearGradient id="g3" x1="0" y1="0" x2="48" y2="48" gradientUnits="userSpaceOnUse">
                <stop stop-color="#c084fc"/>
                <stop offset="1" stop-color="#f472b6"/>
              </linearGradient>
            </defs>
            <circle cx="16" cy="18" r="6" stroke="url(#g3)" stroke-width="2" fill="none"/>
            <circle cx="32" cy="18" r="6" stroke="url(#g3)" stroke-width="2" fill="none" opacity=".8"/>
            <path d="M6 36c0-5.5 4.5-10 10-10s10 4.5 10 10" stroke="url(#g3)" stroke-width="2" fill="none"/>
            <path d="M22 36c0-5.5 4.5-10 10-10s10 4.5 10 10" stroke="url(#g3)" stroke-width="2" fill="none" opacity=".8"/>
          </svg>
        </div>
        <p class="mt-3 text-sm text-gray-300">
          Verified contributors participating in distribution.
        </p>
      </div>
    </div>
  </section>
</body>
</html>
