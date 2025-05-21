<?php
$name   = $_POST['name'];
$email  = $_POST['email'];
$amount = $_POST['amount'] * 100;
$currency = isset($_POST['currency']) && $_POST['currency'] === 'USD' ? 'USD' : 'KES';

$data = [
    'email' => $email,
    'amount' => $amount,
    'callback_url' => 'https://fedhabrothers.co.ke/payment_callback.php', // Replace with your live callback URL
    'currency' => $currency,
    'metadata' => [
        'name' => $name,
        'currency' => $currency
    ]
];

$ch = curl_init('https://api.paystack.co/transaction/initialize');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer sk_live_08114d3e1b5c10c328e5a9d49be1216b2642e3e7",
    //"Authorization: Bearer sk_test_ccebaaf7152a34bea6f60bca7266fced5e832b3c", // Replace with your actual Paystack secret key
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);

if ($http_code == 200 && $result['status']) {
    header('Location: ' . $result['data']['authorization_url']);
} else {
    echo "Payment initialization failed: " . $result['message'];
}
