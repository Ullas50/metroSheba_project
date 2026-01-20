<?php
session_start();
require_once '../model/Admin.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$admin = new Admin();
$passengers = $admin->getPassengers();
$sellers    = $admin->getSellerTickets();
$routes     = $admin->getRouteSales();
$grandTotal = $admin->getGrandTotal();

require '../view/admin_dashboard.php';
?>