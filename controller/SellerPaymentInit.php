<?php
session_start();
require_once '../core/db.php';
require_once '../model/Booking.php';

/* AUTH */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    exit('Unauthorized');
}

$from = (int)($_POST['from'] ?? 0);
$to   = (int)($_POST['to'] ?? 0);
$qty  = (int)($_POST['quantity'] ?? 0);
$date = $_POST['journey_date'] ?? '';

if (!$from || !$to) exit('Station required');
if ($from === $to) exit('Same station');
if ($qty < 1 || $qty > 10) exit('Invalid quantity');
if (!$date) exit('Journey date required');

$conn = getConnection();
$booking = new Booking();

/* PRICE CALCULATION */
$fromOrder = $booking->getStationOrder($from);
$toOrder   = $booking->getStationOrder($to);
$distance  = abs($fromOrder - $toOrder);
$amount    = $distance * 10 * $qty;

/* RESOLVE STATION NAMES */
$stmt = $conn->prepare("SELECT station_name FROM stations WHERE id=?");
$stmt->bind_param("i", $from);
$stmt->execute();
$fromName = $stmt->get_result()->fetch_assoc()['station_name'];

$stmt = $conn->prepare("SELECT station_name FROM stations WHERE id=?");
$stmt->bind_param("i", $to);
$stmt->execute();
$toName = $stmt->get_result()->fetch_assoc()['station_name'];

/* STORE SESSION */
$_SESSION['seller_payment'] = [
    'from_id'    => $from,
    'to_id'      => $to,
    'from_name'  => $fromName,
    'to_name'    => $toName,
    'quantity'   => $qty,
    'date'       => $date,
    'distance'   => $distance,
    'amount'     => $amount
];

echo "OK";
