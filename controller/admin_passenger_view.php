<?php
session_start();
require_once '../model/Admin.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    exit("Invalid request");
}

$admin = new Admin();
$data = $admin->getPassengerDetails((int)$_GET['id']);

if (!$data) {
    exit("Passenger not found");
}
require '../view/admin_passenger_view.php';
?>