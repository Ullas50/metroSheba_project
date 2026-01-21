<?php
session_start();
require_once '../model/Payment.php';

/* =========================
   Detect AJAX
========================= */
function isAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/* =========================
   Error response helper
========================= */
function paymentError($msg) {

    if (isAjax()) {
        echo json_encode([
            'status'  => 'error',
            'message' => $msg
        ]);
        exit;
    }

    $_SESSION['payment_error'] = $msg;
    header("Location: ../view/payment_form.php");
    exit;
}

/* =========================
   Guard checks
========================= */
if (!isset($_SESSION['user_id'], $_SESSION['payment'], $_SESSION['pending_booking_id'])) {
    if (isAjax()) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Session expired. Please start again.'
        ]);
        exit;
    }

    header("Location: ../view/passenger_dashboard.php");
    exit;
}

/* =========================
   Validate mobile
========================= */
$mobile = trim($_POST['mobile'] ?? '');

if (!preg_match('/^01[3-9][0-9]{8}$/', $mobile)) {
    paymentError("Invalid mobile number format");
}

$userId  = $_SESSION['user_id'];
$payment = new Payment();

/* =========================
   Passenger validation
========================= */
$passenger = $payment->getPassenger($userId);

if (!$passenger || empty($passenger['mobile'])) {
    paymentError("Mobile number not found for your account");
}

if ($mobile !== $passenger['mobile']) {
    paymentError("Mobile number does not match your account");
}

/* =========================
   Payment process
========================= */
$bookingId = $_SESSION['pending_booking_id'];
$method    = $_SESSION['payment']['method'];
$amount    = $_SESSION['payment']['amount'];

if (!$payment->createPayment($bookingId, $method, $amount)) {
    paymentError("Payment record failed");
}

$payment->confirmBooking($bookingId);

/* =========================
   Cleanup
========================= */
$_SESSION['last_booking_id'] = $bookingId;
unset($_SESSION['payment'], $_SESSION['pending_booking_id'], $_SESSION['payment_error']);

/* =========================
   Success response
========================= */
if (isAjax()) {
    echo json_encode([
        'status'   => 'success',
        'redirect' => '../view/ticket.php'
    ]);
    exit;
}

header("Location: ../view/ticket.php");
exit;
