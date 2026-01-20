<?php
session_start(); //start the session
require_once '../model/Admin.php'; // include the admin class to use its functions

 // make sure the user is logged in 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403); //send a 403 forbidden
    exit;
}

$admin = new Admin(); // create a admin odject 


if (isset($_POST['booking_id'])) {
    echo $admin->deleteBooking((int)$_POST['booking_id']) ? "OK" : "FAIL"; // try to delete the booking
    exit;
}


if (isset($_POST['seller_sale_id'])) {
    echo $admin->deleteSellerSale((int)$_POST['seller_sale_id']) ? "OK" : "FAIL"; // try to delete the seller sale record
    exit;
}


if (isset($_GET['refresh'])) { 

// get the latest sales data and total 

    echo json_encode([
        'routes' => $admin->getRouteSales(),
        'total'  => $admin->getGrandTotal()
    ]);
    exit;
}

http_response_code(400); //no valid action found respond with 400
