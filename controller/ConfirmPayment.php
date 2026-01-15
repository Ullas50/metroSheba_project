<?php
session_start();
require_once '../model/Payment.php';

/* HARD GUARDS */
if (!isset($_SESSION['user_id'], $_SESSION['payment'], $_SESSION['pending_booking_id'])) {
    header("Location: ../view/passenger_dashboard.php");
    exit;
}

$mobile = trim($_POST['mobile'] ?? '');

/* FORMAT VALIDATION */
if (!preg_match('/^01[3-9][0-9]{8}$/', $mobile)) {
    $_SESSION['payment_error'] = "Invalid mobile number format";
    header("Location: ../view/payment_form.php");
    exit;
}

$userId = $_SESSION['user_id'];
$payment = new Payment();

/* PASSENGER CHECK */
$passenger = $payment->getPassenger($userId);

if (!$passenger || empty($passenger['mobile'])) {
    $_SESSION['payment_error'] = "Mobile number not found for your account";
    header("Location: ../view/payment_form.php");
    exit;
}

if ($mobile !== $passenger['mobile']) {
    $_SESSION['payment_error'] = "Mobile number does not match your account";
    header("Location: ../view/payment_form.php");
    exit;
}

/* SESSION DATA */
$bookingId = $_SESSION['pending_booking_id'];
$method    = $_SESSION['payment']['method'];
$amount    = $_SESSION['payment']['amount'];

/* INSERT PAYMENT */
$paid = $payment->createPayment(
    $bookingId,
    $method,
    $amount
);

if (!$paid) {
    $_SESSION['payment_error'] = "Payment record failed";
    header("Location: ../view/payment_form.php");
    exit;
}

/* CONFIRM BOOKING */
$payment->confirmBooking($bookingId);

/* CLEANUP */
unset($_SESSION['payment']);
unset($_SESSION['pending_booking_id']);
unset($_SESSION['payment_error']);

/* DONE */
header("Location: ../view/passenger_dashboard.php");
exit;
