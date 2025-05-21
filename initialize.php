<?php

require_once 'config.php';  // Adjust path if needed

// Sanitize and validate inputs
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$currency = (isset($_POST['currency']) && $_POST['currency'] === 'USD') ? 'USD' : 'KES';

if (!$name || !$email || !$amount) {
    die('Invalid input data');
}

// Convert amount to kobo/cents (multiply by 100)
$amount_in_cents = intval($amount * 100);

$data = [
    'email' => $email,
    'amount' => $amount_in_cents,
    'callback_url' => 'https://fedhabrothers.co.ke/payment_callback.php', // Update with your real callback URL
    'currency' => $currency,
    'metadata' => [
        'name' => $name,
        'currency' => $currency
    ]
];

$ch = curl_init('https://api.paystack.co/transaction/initialize');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . PAYSTACK_SECRET,
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);

if ($http_code == 200 && isset($result['status']) && $result['status'] === true) {
    header('Location: ' . $result['data']['authorization_url']);
    exit;
} else {
    echo "Payment initialization failed: " . htmlspecialchars($result['message'] ?? 'Unknown error');
}
