<?php
session_start();
require_once '../model/Payment.php';

if (!isset($_SESSION['user_id'], $_SESSION['pending_booking_id'])) {
    header("Location: ../view/passenger_dashboard.php");
    exit;
}

$payment = new Payment();

$userId    = $_SESSION['user_id'];
$bookingId = $_SESSION['pending_booking_id'];

$user    = $payment->getPassenger($userId);
$booking = $payment->getBookingDetails($bookingId, $userId);

if (!$booking) {
    header("Location: ../view/passenger_dashboard.php");
    exit;
}

$ticket = (int)$booking['total_price'];
$vat    = round($ticket * 0.15);
$service= 20;
$total  = $ticket + $vat + $service;

/* STORE FOR VIEW */
$_SESSION['payment_data'] = [
    'user' => $user,
    'booking' => $booking,
    'fare' => [
        'ticket'  => $ticket,
        'vat'     => $vat,
        'service' => $service,
        'total'   => $total
    ]
];

/* REDIRECT TO VIEW */
header("Location: ../view/payment_page.php");
exit;
