<?php
session_start();

if (!isset($_SESSION['pending_booking_id'])) {
    die("No pending booking");
}

echo "Pending Booking ID: " . $_SESSION['pending_booking_id'];
