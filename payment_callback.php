<?php
if (!isset($_GET['reference'])) {
    die("No transaction reference provided.");
}

$reference = $_GET['reference'];

$ch = curl_init("https://api.paystack.co/transaction/verify/" . $reference);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer sk_live_08114d3e1b5c10c328e5a9d49be1216b2642e3e7", // Replace with your actual key
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

$status = $result['status'] && $result['data']['status'] == 'success';
$name = $result['data']['metadata']['name'] ?? 'Unknown';
$email = $result['data']['customer']['email'] ?? 'Unknown';
$amount = number_format($result['data']['amount'] / 100, 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Status</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="status-container">
    <?php if ($status): ?>
      <div class="status-box success">
        <h2>✅ Payment Successful</h2>
        <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Amount Paid:</strong> <?= $amount ?> KES/USD</p>
      </div>
    <?php else: ?>
      <div class="status-box failed">
        <h2>❌ Payment Failed</h2>
        <p>We could not verify your transaction.</p>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
