<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
require_once '../model/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user = fetchUserById($_SESSION['user_id']);
if (!$user) {
    echo "User not found";
    exit;
}

$error = $_SESSION['profile_error'] ?? '';
unset($_SESSION['profile_error']);
require '../view/update_admin_profile.php';
?>