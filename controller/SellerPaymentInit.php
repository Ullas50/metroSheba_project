<?php
session_start();
require_once '../core/db.php';
require_once '../model/Booking.php';

/* ================= AUTH ================= */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    http_response_code(403);
    exit('Unauthorized');
}

/* ================= INPUT ================= */
$from = (int)($_POST['from'] ?? 0);
$to   = (int)($_POST['to'] ?? 0);
$qty  = (int)($_POST['quantity'] ?? 0);
$date = $_POST['journey_date'] ?? '';

/* ================= VALIDATION ================= */
if (!$from) exit('From station required');
if (!$to) exit('To station required');
if ($from === $to) exit('Stations cannot be the same');
if (!$date) exit('Journey date required');

if ($qty < 1) exit('Quantity must be at least 1');
if ($qty > 10) exit('Maximum 10 tickets allowed');

/* ================= PRICE CALC ================= */
$booking = new Booking();

$fromOrder = $booking->getStationOrder($from);
$toOrder   = $booking->getStationOrder($to);

if ($fromOrder === null || $toOrder === null) {
    exit('Invalid station');
}

$distance = abs($toOrder - $fromOrder);
$amount   = $distance * 10 * $qty;

/* ================= STATION NAMES ================= */
$conn = getConnection();

$stmt = $conn->prepare("SELECT station_name FROM stations WHERE id=?");
$stmt->bind_param("i", $from);
$stmt->execute();
$fromName = $stmt->get_result()->fetch_assoc()['station_name'] ?? '';

$stmt->bind_param("i", $to);
$stmt->execute();
$toName = $stmt->get_result()->fetch_assoc()['station_name'] ?? '';

/* ================= SESSION (SINGLE SOURCE OF TRUTH) ================= */
$_SESSION['seller_payment'] = [
    'seller_id'  => $_SESSION['user_id'],
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
