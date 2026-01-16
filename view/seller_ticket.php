<?php
session_start();
require_once '../model/Seller.php';

if (!isset($_SESSION['seller_ticket_id'])) {
    exit('Ticket not found');
}

$seller = new Seller();
$ticket = $seller->getTicketBySale($_SESSION['seller_ticket_id']);

if (!$ticket) exit('Invalid ticket');

$validUntil = date(
    'Y-m-d H:i',
    strtotime($ticket['created_at'] . ' +24 hours')
);

$qrData = json_encode([
    'sale_id' => $ticket['id'],
    'from'    => $ticket['from_station'],
    'to'      => $ticket['to_station'],
    'date'    => $ticket['journey_date'],
    'qty'     => $ticket['ticket_quantity']
]);
?>
<!DOCTYPE html>
<html>
<head>
    <title>MetroSheba | Seller Ticket</title>
    <link rel="stylesheet" href="../public/css/ticket_seller.css">
</head>
<body>

<div class="ticket-wrapper">

    <div class="ticket-header">
        <h1>MetroSheba</h1>
        <span class="badge">E-Ticket</span>
    </div>

    <div class="ticket-body">
        

        <div class="ticket-left">
            <h3>Sold By</h3>
            <p><strong>Name:</strong> <?= htmlspecialchars($ticket['seller_name']) ?></p>
            <p><strong>Mobile:</strong> <?= htmlspecialchars($ticket['seller_mobile']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($ticket['seller_email']) ?></p>

            <hr>

            <p><strong>From:</strong> <?= $ticket['from_station'] ?></p>
            <p><strong>To:</strong> <?= $ticket['to_station'] ?></p>
            <p><strong>Journey Date:</strong> <?= $ticket['journey_date'] ?></p>
            <p><strong>Tickets:</strong> <?= $ticket['ticket_quantity'] ?></p>

            <div class="ticket-validity">
                Valid until <?= $validUntil ?>
            </div>
        </div>

        <div class="ticket-right">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=<?= urlencode($qrData) ?>">
            <button onclick="window.print()">Print Ticket</button>
        </div>

    </div>
</div>

</body>
</html>
