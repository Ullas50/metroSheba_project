<?php
session_start();

/* Guard */
if (
    !isset(
        $_SESSION['payment_data']['user'],
        $_SESSION['payment_data']['booking'],
        $_SESSION['payment_data']['fare']
    )
) {
    header("Location: passenger_dashboard.php");
    exit;
}

$data = $_SESSION['payment_data'];

$user    = $data['user'];
$booking = $data['booking'];
$fare    = $data['fare'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>MetroSheba | Payment</title>
    <link rel="stylesheet" href="../public/css/home.css">
    <link rel="stylesheet" href="../public/css/payment.css">
</head>
<body>

<?php include 'partials/header1.php'; ?>

<div class="container payment-layout">

    <!-- LEFT -->
    <div class="left">
        <div class="card">
            <h3>Passenger Details</h3>
            <p><strong>Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
            <p><strong>Mobile:</strong> <?= htmlspecialchars($user['mobile']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>

        <div class="card">
            <h3>Select Payment Method</h3>

            <div class="payment-methods">
                <button data-method="bkash">bKash</button>
                <button data-method="nagad">Nagad</button>
                <button data-method="rocket">Rocket</button>
                <button data-method="upay">Upay</button>
            </div>

            <button id="proceedBtn" class="pay-btn" disabled>
                Proceed to Payment
            </button>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <div class="card">
            <h3>Journey Details</h3>
            <p><?= $booking['from_station'] ?> → <?= $booking['to_station'] ?></p>
            <p>Date: <?= $booking['journey_date'] ?></p>
            <p>Tickets: <?= $booking['ticket_quantity'] ?></p>
        </div>

        <div class="card">
            <h3>Fare Details</h3>
            <div class="row"><span>Ticket Price</span><span><?= $fare['ticket'] ?></span></div>
            <div class="row"><span>VAT</span><span><?= $fare['vat'] ?></span></div>
            <div class="row"><span>Service Charge</span><span><?= $fare['service'] ?></span></div>
            <hr>
            <div class="row total">
                <span>Total</span>
                <span>৳<?= $fare['total'] ?></span>
            </div>
            <p class="note">Service charge is non-refundable.</p>
        </div>
    </div>

</div>

<?php include 'partials/footer.php'; ?>

<script src="../public/js/payment.js"></script>
</body>
</html>