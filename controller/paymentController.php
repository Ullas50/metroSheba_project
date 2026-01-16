<?php
session_start();
require_once '../model/Payment.php';

/* HARD GUARD */
if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['pending_booking_id'])
) {
    header("Location: ../view/passenger_dashboard.php");
    exit;
}

$payment = new Payment();

$userId    = (int) $_SESSION['user_id'];
$bookingId = (int) $_SESSION['pending_booking_id'];

/* FETCH DATA */
$user    = $payment->getPassenger($userId);
$booking = $payment->getBookingDetails($bookingId, $userId);

/* STRONG VALIDATION */
if (!$user || !$booking || !isset($booking['total_price'])) {
    // temporary debug – REMOVE after fixing
    echo "<pre>";
    var_dump($user, $booking);
    exit;
}

/* PRICE CALCULATION */
$ticket  = (int) $booking['total_price'];
$vat     = (int) round($ticket * 0.15);
$service = 20;
$total   = $ticket + $vat + $service;

/* STORE FOR VIEW */
$_SESSION['payment_data'] = [
    'user'    => $user,
    'booking' => $booking,
    'fare'    => [
        'ticket'  => $ticket,
        'vat'     => $vat,
        'service' => $service,
        'total'   => $total
    ]
];

/* REDIRECT */
header("Location: ../view/payment_page.php");
exit;