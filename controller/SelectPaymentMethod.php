<?php
session_start();

/* HARD GUARD */
if (!isset($_SESSION['booking'])) {
    http_response_code(400);
    echo "Booking session missing";
    exit;
}

$method = $_POST['method'] ?? ''; //read payment method sent from the form
//payment method is required
if ($method === '') {
    http_response_code(400);
    echo "Invalid payment method";
    exit;
}

// amount must come from booking session, not JS
$amount = $_SESSION['booking']['total_price'];


$_SESSION['payment'] = [
    'method' => $method,
    'amount' => $amount
];

echo "OK";