<?php
session_start();
require_once '../core/db.php';

// authorization check
if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'seller' ||
    !isset($_SESSION['seller_payment'])
) {
    exit('Unauthorized');//stop immediately if seller is not authorized
    
}
// seller and payment data from session
$sellerId = (int) $_SESSION['user_id'];
$data     = $_SESSION['seller_payment'];
//amount entered by seller and expected amount from session
$received = (int) ($_POST['received_amount'] ?? 0);
$amount   = (int) $data['amount'];

// ensure exact cash amount
if ($received !== $amount) {
    //cash payment must match the total exactly
    $_SESSION['cash_error'] = 'Received amount must be exactly ৳' . $amount;
    header("Location: ../view/seller_cash_payment.php");
    exit;
}


$conn = getConnection();// connection database

//insert seller sale record
$stmt = $conn->prepare(
    "INSERT INTO seller_sales
     (seller_id, from_station_id, to_station_id, ticket_quantity,
      journey_date, total_price, paid_amount)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param( // query details
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
$saleId = $conn->insert_id; //get the newly created sale ID

$_SESSION['seller_ticket_id'] = $saleId;
unset($_SESSION['seller_payment']);

header("Location: ../view/seller_ticket.php");
exit;
