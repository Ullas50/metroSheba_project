<?php
session_start();
require_once '../core/db.php';

/* AUTH */
if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'seller' ||
    !isset($_SESSION['seller_payment'])
) {
    exit('Unauthorized');
}

$sellerId = (int) $_SESSION['user_id'];
$data     = $_SESSION['seller_payment'];
$received = (int) ($_POST['received_amount'] ?? 0);
$amount   = (int) $data['amount'];

/* EXACT MATCH REQUIRED */
if ($received !== $amount) {
    $_SESSION['cash_error'] = 'Received amount must be exactly ৳' . $amount;
    header("Location: ../view/seller_cash_payment.php");
    exit;
}


$conn = getConnection();

/* INSERT SALE */
$stmt = $conn->prepare(
    "INSERT INTO seller_sales
     (seller_id, from_station_id, to_station_id, ticket_quantity,
      journey_date, total_price, paid_amount)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "iiiisii",
    $sellerId,
    $data['from_id'],
    $data['to_id'],
    $data['quantity'],
    $data['date'],
    $amount,
    $received
);

$stmt->execute();
$saleId = $conn->insert_id;

/* PREPARE TICKET */
$_SESSION['seller_ticket_id'] = $saleId;
unset($_SESSION['seller_payment']);

header("Location: ../view/seller_ticket.php");
exit;
