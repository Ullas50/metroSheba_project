<?php
session_start();//check lodded in user
require_once '../model/Payment.php';

// authrntication check
if (!isset($_SESSION['user_id'])) 
{
    header("Location: login.php");
    exit;
}
//petch purchase history
$payment = new Payment();
//get purchase all histroy 
$history = $payment->getPurchaseHistory($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Purchase History</title>
    <link rel="stylesheet" href="../public/css/history.css">
     <link rel="stylesheet" href="../public/css/home.css">
</head>
<body>
<!--for common header-->
<?php include 'partials/header1.php'; ?>
<!--container for parchase history-->
<div class="history-container">

    <h2>Purchase History</h2>

    <?php if (empty($history)): ?>
        <p class="empty">No purchase history found.</p>
    <?php else: ?>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Route</th>
                    <th>Journey Date</th>
                    <th>Tickets</th>
                    <th>Amount (৳)</th>
                    <th>Payment</th>
                    <th>Purchased On</th>
                </tr>
            </thead>
            <tbody>
                <!--array for foreach-->
                <?php foreach ($history as $row): ?>
                    <tr>
                        <td>#<?= $row['booking_id'] ?></td>
                        <td><?= $row['from_station'] ?> → <?= $row['to_station'] ?></td>
                        <td><?= $row['journey_date'] ?></td>
                        <td><?= $row['ticket_quantity'] ?></td>
                        <td><?= $row['paid_amount'] ?></td>
                        <td><?= strtoupper($row['payment_method']) ?></td>
                        <td><?= date('Y-m-d', strtotime($row['confirmed_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>
<br>
<br>
<br>
<br>
<br>
<!--common footer-->
<?php include 'partials/footer.php'; ?>
</body>
</html>
