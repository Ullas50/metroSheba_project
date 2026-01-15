<?php
session_start();

/* HARD GUARD */
if (!isset($_SESSION['booking'])) {
    http_response_code(400);
    echo "Booking session missing";
    exit;
}

$method = $_POST['method'] ?? '';

if ($method === '') {
    http_response_code(400);
    echo "Invalid payment method";
    exit;
}

/* Amount MUST come from booking session, not JS */
$amount = $_SESSION['booking']['total_price'];

/* SINGLE SOURCE OF TRUTH */
$_SESSION['payment'] = [
    'method' => $method,
    'amount' => $amount
];

echo "OK";
