<?php
session_start();
require_once '../model/Payment.php';

if (!isset($_SESSION['user_id'], $_SESSION['last_booking_id'])) 
{
    header("Location: passenger_dashboard.php");
    exit;
}

$payment = new Payment();
$ticket = $payment->getTicketByBooking
( $_SESSION['last_booking_id'],$_SESSION['user_id']);

if (!$ticket) 
{
    echo "Ticket not found";
    exit;
}

/* FORMAT DATA */
$journeyDate = date('Y-m-d', strtotime($ticket['journey_date']));
$validUntil  = date('Y-m-d H:i',strtotime($ticket['confirmed_at'] . ' +24 hours'));

/* QR PAYLOAD */
$qrData = json_encode([
    'booking_id' => $ticket['booking_id'],
    'from'       => $ticket['from_station'],
    'to'         => $ticket['to_station'],
    'date'       => $journeyDate,
    'tickets'    => $ticket['ticket_quantity'],
    'valid'      => $validUntil
]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | E-Ticket</title>
    <link rel="stylesheet" href="../public/css/ticket.css">
</head>
<body>

<div class="ticket-wrapper" id="ticketArea">

    <!-- HEADER -->
    <div class="ticket-header">
        <h1>MetroSheba</h1>
        <span class="badge">E-Ticket</span>
    </div>

    <!-- BODY -->
    <div class="ticket-body">

        <!-- LEFT -->
        <div class="ticket-left">

            <div class="ticket-section">
                <h3>Passenger Information</h3>
                <p><strong>Name:</strong> <?= htmlspecialchars($ticket['full_name']) ?></p>
                <p><strong>Mobile:</strong> <?= htmlspecialchars($ticket['mobile']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($ticket['email']) ?></p>
            </div>

            <div class="ticket-section route">
                <div>
                    <span class="label">From</span>
                    <span class="value"><?= $ticket['from_station'] ?></span>
                </div>
                <div class="arrow">→</div>
                <div>
                    <span class="label">To</span>
                    <span class="value"><?= $ticket['to_station'] ?></span>
                </div>
            </div>

            <div class="ticket-section details">
                <p><strong>Journey Date:</strong> <?= $journeyDate ?></p>
                <p><strong>Tickets:</strong> <?= $ticket['ticket_quantity'] ?></p>
                <p><strong>Booking ID:</strong> #<?= $ticket['booking_id'] ?></p>
            </div>

            <div class="ticket-validity">
                Ticket is valid for <strong>24 hours</strong> from confirmation<br>
                <span>Valid until: <?= $validUntil ?></span>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="ticket-right">

            <div class="qr-section">
                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=<?= urlencode($qrData) ?>"
                    alt="QR Code"
                >
                <p class="qr-note">Scan at metro gate</p>
            </div>

            <div class="ticket-actions no-print">
                <button onclick="window.print()">Print Ticket</button>
                <a href="../controller/logout.php" class="logout">Logout</a>
            </div>

        </div>

    </div>

</div>

</body>
</html>
