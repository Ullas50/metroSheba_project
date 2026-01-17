<?php
session_start();
require_once '../model/Admin.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit;
}

$admin = new Admin();

/* DELETE PASSENGER */
if (isset($_POST['booking_id'])) {
    echo $admin->deleteBooking((int)$_POST['booking_id']) ? "OK" : "FAIL";
    exit;
}

/* DELETE SELLER */
if (isset($_POST['seller_sale_id'])) {
    echo $admin->deleteSellerSale((int)$_POST['seller_sale_id']) ? "OK" : "FAIL";
    exit;
}

/* REFRESH SALES */
if (isset($_GET['refresh'])) {
    echo json_encode([
        'routes' => $admin->getRouteSales(),
        'total'  => $admin->getGrandTotal()
    ]);
    exit;
}

http_response_code(400);
