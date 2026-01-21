<?php
session_start();
require_once '../core/db.php';

function isAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/* AUTH CHECK */
if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'seller' ||
    !isset($_SESSION['seller_payment'])
) {
    if (isAjax()) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Unauthorized'
        ]);
        exit;
    }
    exit('Unauthorized');
}

/* DATA */
$sellerId = (int) $_SESSION['user_id'];
$data     = $_SESSION['seller_payment'];

$received = (int) ($_POST['received_amount'] ?? 0);
$amount   = (int) $data['amount'];

/* VALIDATION */
if ($received !== $amount) {

    if (isAjax()) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Received amount must be exactly ৳' . $amount
        ]);
        exit;
    }

    $_SESSION['cash_error'] = 'Received amount must be exactly ৳' . $amount;
    header("Location: ../view/seller_cash_payment.php");
    exit;
}

/* DB INSERT */
$conn = getConnection();

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

$_SESSION['seller_ticket_id'] = $conn->insert_id;
unset($_SESSION['seller_payment']);

/* SUCCESS RESPONSE */
if (isAjax()) {
    echo json_encode([
        'status'   => 'success',
        'redirect' => '../view/seller_ticket.php'
    ]);
    exit;
}

header("Location: ../view/seller_ticket.php");
exit;
