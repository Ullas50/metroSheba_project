<?php
session_start();
require_once '../model/Payment.php';

//make sure required session data exists
if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['pending_booking_id'])
) {
    header("Location: ../view/passenger_dashboard.php");//if user ID or booking ID is missing, redirect to dashboard

    exit;
}

$payment = new Payment();
// if user ID or booking ID is missing

$userId    = (int) $_SESSION['user_id'];
$bookingId = (int) $_SESSION['pending_booking_id']; 


$user    = $payment->getPassenger($userId); //get passenger info
$booking = $payment->getBookingDetails($bookingId, $userId); //get booking details


//strong validation
if (!$user || !$booking || !isset($booking['total_price'])) {
    //shows data if something is missing 
    echo "<pre>";
    var_dump($user, $booking);
    exit;
}

// price calculation
$ticket  = (int) $booking['total_price'];
$vat     = (int) round($ticket * 0.15);
$service = 20;
$total   = $ticket + $vat + $service;

// store data in session for payment page
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


header("Location: ../view/payment_page.php");
exit;