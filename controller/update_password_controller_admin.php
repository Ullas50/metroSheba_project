<?php
session_start();
require_once '../model/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/update_admin_password.php");
    exit;
}

$user = fetchUserById($_SESSION['user_id']);
if (!$user) {
    $_SESSION['errors']['general'] = "User not found";
    header("Location: ../view/update_admin_password.php");
    exit;
}

$current = trim($_POST['current_password'] ?? '');
$new     = trim($_POST['new_password'] ?? '');
$confirm = trim($_POST['confirm_password'] ?? '');

$errors = [];

/* FIELD VALIDATION */
if ($current === '') {
    $errors['current_password'] = "Current password is required";
} elseif (!password_verify($current, $user['password'])) {
    $errors['current_password'] = "Current password is incorrect";
}

if ($new === '') {
    $errors['new_password'] = "New password is required";
} elseif (strlen($new) < 6) {
    $errors['new_password'] = "Minimum 6 characters required";
} elseif (password_verify($new, $user['password'])) {
    $errors['new_password'] = "New password must be different";
}

if ($confirm === '') {
    $errors['confirm_password'] = "Please re-enter the password";
} elseif ($new !== $confirm) {
    $errors['confirm_password'] = "Passwords do not match";
}

/* IF ERRORS → BACK */
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: ../view/update_admin_password.php");
    exit;
}

/* UPDATE PASSWORD */
updatePassword($_SESSION['user_id'], $new);

/* LOGOUT */
session_unset();
session_destroy();

header("Location: ../view/login.php");
exit;
