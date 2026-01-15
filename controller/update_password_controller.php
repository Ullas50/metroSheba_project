<?php
session_start();
require_once '../model/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/update_password.php");
    exit;
}

/* FETCH USER */
$user = fetchUserById($_SESSION['user_id']);
if (!$user) {
    $_SESSION['password_error'] = "User not found";
    header("Location: ../view/update_password.php");
    exit;
}

/* INPUT */
$current = $_POST['current_password'] ?? '';
$new     = $_POST['new_password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

/* VALIDATION */
if ($current === '' || $new === '' || $confirm === '') {
    $_SESSION['password_error'] = "All fields are required";
    header("Location: ../view/update_password.php");
    exit;
}

if (!password_verify($current, $user['password'])) {
    $_SESSION['password_error'] = "Current password is incorrect";
    header("Location: ../view/update_password.php");
    exit;
}

if (strlen($new) < 6) {
    $_SESSION['password_error'] = "New password must be at least 6 characters";
    header("Location: ../view/update_password.php");
    exit;
}

if ($new !== $confirm) {
    $_SESSION['password_error'] = "New passwords do not match";
    header("Location: ../view/update_password.php");
    exit;
}

/* UPDATE PASSWORD */
if (!updatePassword($_SESSION['user_id'], $new)) {
    $_SESSION['password_error'] = "Password update failed";
    header("Location: ../view/update_password.php");
    exit;
}

/* FORCE LOGOUT */
session_unset();
session_destroy();

header("Location: ../view/login.php");
exit;
