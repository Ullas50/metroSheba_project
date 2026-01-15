<?php
session_start();
require_once '../model/Booking.php';

$from = (int)($_POST['from'] ?? 0);
$to   = (int)($_POST['to'] ?? 0);
$qty  = (int)($_POST['quantity'] ?? 0);
$date = $_POST['journey_date'] ?? null;

if (!$from) exit("From station required");
if (!$to) exit("To station required");
if ($from === $to) exit("Stations cannot be same");
if (!$date) exit("Journey date required");

// ===== QUANTITY VALIDATION (ADDED) =====
if ($qty < 1) {
    exit("Quantity must be at least 1");
}

if ($qty > 10) {
    exit("Maximum 10 tickets allowed");
}

$userId = $_SESSION['user_id'] ?? 1;

$booking = new Booking();
$fromOrder = $booking->getStationOrder($from);
$toOrder   = $booking->getStationOrder($to);

$total = abs($toOrder - $fromOrder) * 10 * $qty;

$bookingId = $booking->createBooking(
    $userId, $from, $to, $qty, $total, $date
);

$_SESSION['pending_booking_id'] = $bookingId;

echo "OK";