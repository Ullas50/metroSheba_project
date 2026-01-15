<?php
session_start();
require_once '../model/Payment.php';

/* HARD GUARDS */
if (!isset($_SESSION['user_id'], $_SESSION['payment'])) {
    header("Location: ../view/passenger_dashboard.php");
    exit;
}

$mobile = trim($_POST['mobile'] ?? '');

/* Format validation */
if (!preg_match('/^01[3-9][0-9]{8}$/', $mobile)) {
    $_SESSION['payment_error'] = "Invalid mobile number format";
    header("Location: ../view/payment_form.php");
    exit;
}

$userId = $_SESSION['user_id'];

$payment = new Payment();
$passenger = $payment->getPassenger($userId);

if (!$passenger || empty($passenger['mobile'])) {
    $_SESSION['payment_error'] = "Mobile number not found for your account";
    header("Location: ../view/payment_form.php");
    exit;
}

/* Match with DB */
if ($mobile !== $passenger['mobile']) {
    $_SESSION['payment_error'] = "Mobile number does not match your account";
    header("Location: ../view/payment_form.php");
    exit;
}

/* SUCCESS (TEMP) */
unset($_SESSION['payment_error']);
echo "Payment verified successfully";
