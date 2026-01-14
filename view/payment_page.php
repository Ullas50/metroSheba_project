<?php
session_start();
require_once '../core/db.php';

if (!isset($_SESSION['user_id'], $_SESSION['pending_booking_id'])) {
    header("Location: passenger_dashboard.php");
    exit;
}

$conn = getConnection();

$userId    = $_SESSION['user_id'];
$bookingId = $_SESSION['pending_booking_id'];

/* Passenger info */
$userStmt = $conn->prepare(
    "SELECT full_name, email, mobile FROM users WHERE id=?"
);
$userStmt->bind_param("i", $userId);
$userStmt->execute();
$user = $userStmt->get_result()->fetch_assoc();

/* Booking + journey info */
$bookingStmt = $conn->prepare("
    SELECT 
        b.ticket_quantity,
        b.total_price,
        b.journey_date,
        s1.station_name AS from_station,
        s2.station_name AS to_station
    FROM bookings b
    JOIN stations s1 ON b.from_station_id = s1.id
    JOIN stations s2 ON b.to_station_id = s2.id
    WHERE b.id=? AND b.user_id=?
");
$bookingStmt->bind_param("ii", $bookingId, $userId);
$bookingStmt->execute();
$booking = $bookingStmt->get_result()->fetch_assoc();

$ticketPrice   = $booking['total_price'];
$vat           = round($ticketPrice * 0.15);
$serviceCharge = 20;
$grandTotal    = $ticketPrice + $vat + $serviceCharge;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
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

            <button id="payBtn" disabled class="pay-btn">
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

            <div class="row"><span>Ticket Price</span><span><?= $ticketPrice ?></span></div>
            <div class="row"><span>VAT</span><span><?= $vat ?></span></div>
            <div class="row"><span>Service Charge</span><span><?= $serviceCharge ?></span></div>

            <hr>

            <div class="row total">
                <span>Total</span>
                <span>৳<?= $grandTotal ?></span>
            </div>

        
        </div>

    </div>

</div>

<?php include 'partials/footer.php'; ?>
<script src="../public/js/payment.js"></script>
</body>
</html>
