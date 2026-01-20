<?php
session_start();
require_once '../model/Payment.php';

// all required session info is set
if (!isset($_SESSION['user_id'], $_SESSION['payment'], $_SESSION['pending_booking_id'])) {
    header("Location: ../view/passenger_dashboard.php");
    exit;
}
//get the mobile number submitted from the form
$mobile = trim($_POST['mobile'] ?? '');

//formal validation
if (!preg_match('/^01[3-9][0-9]{8}$/', $mobile)) {
    $_SESSION['payment_error'] = "Invalid mobile number format";
    header("Location: ../view/payment_form.php");
    exit;
}

$userId = $_SESSION['user_id'];
$payment = new Payment(); // create Payment object

//passenger info from database 
$passenger = $payment->getPassenger($userId);

//make sure passenger exists and has a mobile number
if (!$passenger || empty($passenger['mobile'])) {
    $_SESSION['payment_error'] = "Mobile number not found for your account";
    header("Location: ../view/payment_form.php");
    exit;
}
//confirm that the submitted mobile matches
if ($mobile !== $passenger['mobile']) {
    $_SESSION['payment_error'] = "Mobile number does not match your account";
    header("Location: ../view/payment_form.php");
    exit;
}

//passenger info from database
$bookingId = $_SESSION['pending_booking_id'];
$method    = $_SESSION['payment']['method'];
$amount    = $_SESSION['payment']['amount'];

//Insert payment record
if (!$payment->createPayment($bookingId, $method, $amount)) {
    $_SESSION['payment_error'] = "Payment record failed";
    header("Location: ../view/payment_form.php");
    exit;
}

//confirm booking
$payment->confirmBooking($bookingId);

//save the booking id to show on the ticket page
$_SESSION['last_booking_id'] = $bookingId;

//delete temporary session data 
unset($_SESSION['payment'], $_SESSION['pending_booking_id'], $_SESSION['payment_error']);
 

header("Location: ../view/ticket.php");
exit;