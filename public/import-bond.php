<?php 

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$host = '127.0.0.1';
	$user = 'dbadmin';
	$password = 'Rfw57ebsNkti$57RfwNktiebs';
	$dbname = 'aipf';

	$con = mysqli_connect($host, $user, $password, $dbname);

	$wallets = [
	    // ['wallet' => '0xe331c8c8bff7db61adc8a4f8b869cefc0e406879', 'amount' => 5000],
	    // ['wallet' => '0x15191f5822242701115cbcdeb1c2f1efd30e174e', 'amount' => 5000],
	    // ['wallet' => '0x21f3f880c961a0c595d98eb7562a12e99dcf009e', 'amount' => 5000],
	    // ['wallet' => '0xc3fb512f54224fdaa3fd9cf756277225b928c8f4', 'amount' => 5000],
	    // ['wallet' => '0xc11f849ad0e1e445b4628ca85fc4a583aba585ca', 'amount' => 5000],
	    // ['wallet' => '0x2ca89a1694e4dfcd77f8f711a3ef53e5f32dddf9', 'amount' => 5000],
	    // ['wallet' => '0xeba8588714d2af38799C7e32f0A05A71A043aE92', 'amount' => 5000],
	    // ['wallet' => '0xd309aa448714ab24b3274d95975f49e570964a3b', 'amount' => 5000],
	    // ['wallet' => '0x7155EA97d80E0943D47a5092ba6D278379Fc8Ee7', 'amount' => 5000],
	    // ['wallet' => '0xa754A8F185D5c6891eC406d1B55Eb8EC69117B7f', 'amount' => 5000],
	    // ['wallet' => '0x2dc31c86177df79c1066532a13ec2959b7e6a164', 'amount' => 5000],
	    ['wallet' => '0xa754a8f185d5c6891ec406d1b55eb8ec69117b7f', 'amount' => 5000],
	    ['wallet' => '0x51f16158b2f938bfe06769e523851a11f7406ad0', 'amount' => 5000],
	    ['wallet' => '0xda749c58c3cce19377453f5b19c43147cd1921b1', 'amount' => 5000],
	];

	foreach($wallets as $key => $value)
	{
	    $amount = $value['amount'];
	    $wallet = $value['wallet'];

	    // Check user exists
	    $checkUser = mysqli_query($con, "SELECT id FROM `users` WHERE `wallet_address` = '{$wallet}' LIMIT 1");
	    $userData = mysqli_fetch_assoc($checkUser);

	    if (!$userData) {
	        // User not registered
	        echo $wallet . " - Not Registered\n";
	        continue; // Skip insertion
	    }

	    // User exists
	    $userId = $userData['id'];

	    $tx  = "BYADMIN" . $amount . "AIP" . $key . date('ymdhis');
	    $uth = $tx;

	    $query = "
	        INSERT INTO `user_plans`
	        (`user_id`, `package_id`, `lock_period`, `amount`, `compound_amount`, `roi`, `days`, `return`, `max_return`, `isSynced`, `isCount`, `transaction_hash`, `unique_th`, `coin_price`, `status`)
	        VALUES
	        ($userId, 2, 4, ($amount / 1.112), 0, '0.5', 360, 0, 0, 0, 1, '$tx', '$uth', '1.112', 1)
	    ";

	    $insert = mysqli_query($con, $query);

	    if ($insert) {
	        echo $wallet . " - Inserted Successfully\n";
	    } else {
	        echo $wallet . " - Insert Error: " . mysqli_error($con) . "\n";
	    }

	    sleep(1);
	}
?>