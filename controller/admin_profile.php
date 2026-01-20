<?php
session_start();
require_once '../model/User.php';

/* AUTH GUARD */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* FETCH LOGGED-IN USER */
$user = fetchUserById($_SESSION['user_id']);

if (!$user) {
    echo "User not found";
    exit;
}

require '../view/admin_profile.php';
?>