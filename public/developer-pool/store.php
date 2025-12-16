<?php
$host = '127.0.0.1';
$user = 'root';
$password = 'Qf2rYtVd0YuloxWP';
$dbname = 'aipf';

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die(json_encode([
        'status_code' => 0,
        'message' => 'Database connection failed'
    ]));
}

// Get POST parameters
$amount = $_POST['amount'] ?? null;
$transaction_hash = $_POST['transaction_hash'] ?? null;
$wallet_address = $_POST['wallet_address'] ?? null;

// Validate inputs
if (empty($amount) || empty($transaction_hash) || empty($wallet_address)) {
    $res = [
        'status_code' => 0,
        'message' => 'Missing parameters: amount or transaction_hash'
    ];
    echo json_encode($res, true);
    die;
}

// Escape and sanitize inputs
$amount = floatval($amount); // Ensures it's a number
$transaction_hash = mysqli_real_escape_string($conn, $transaction_hash);
$wallet_address = mysqli_real_escape_string($conn, $wallet_address);

// Prepare the insert query
$insertQuery = "INSERT INTO og_developer_pools (amount, transaction_hash, wallet_address, created_on) VALUES ($amount, '$transaction_hash', '$wallet_address', NOW())";

// Execute query
$success = mysqli_query($conn, $insertQuery);

if ($success) {
    $res = [
        'status_code' => 1,
        'message' => "Success",
        'pool_amount' => $amount
    ];
} else {
    $res = [
        'status_code' => 0,
        'message' => "Insert failed: " . mysqli_error($conn)
    ];
}

echo json_encode($res, true);
?>
