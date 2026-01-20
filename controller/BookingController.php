<?php
session_start();
require_once '../model/Booking.php'; //include the Booking class for booking operations
  //set default to 0 or null if not provided
$from = (int)($_POST['from'] ?? 0);
$to   = (int)($_POST['to'] ?? 0);
$qty  = (int)($_POST['quantity'] ?? 0);
$date = $_POST['journey_date'] ?? null;
//basic validation

if (!$from) exit("From station required");
if (!$to) exit("To station required");
if ($from === $to) exit("Stations cannot be same");
if (!$date) exit("Journey date required");

// quantity valitation  
if ($qty < 1) {
    exit("Quantity must be at least 1");
}

if ($qty > 10) {
    exit("Maximum 10 tickets allowed"); //no more than 10 tickets per booking

}

$userId = $_SESSION['user_id'] ?? 1;

$booking = new Booking(); //create a Booking object

//get the order of the stations to calculate distance
$fromOrder = $booking->getStationOrder($from);
$toOrder   = $booking->getStationOrder($to);
//calculate total price
$total = abs($toOrder - $fromOrder) * 10 * $qty;
// save the booking and get its ID

$bookingId = $booking->createBooking(
    $userId, $from, $to, $qty, $total, $date
);

$_SESSION['pending_booking_id'] = $bookingId;
$_SESSION['booking'] = [
    'total_price' => $total //save booking info in session
];

//send success response to frontend

echo "OK";