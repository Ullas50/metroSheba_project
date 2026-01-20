<?php
session_start();
require_once '../model/User.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: ../view/login.php");
    exit;
}
// mwthod guard
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/update_seller_password.php");
    exit;
}

$user = fetchUserById($_SESSION['user_id']);
if (!$user) {
    $_SESSION['errors']['general'] = "User not found";
    header("Location: ../view/update_seller_password.php");
    exit;
}

$current = trim($_POST['current_password'] ?? '');
$new     = trim($_POST['new_password'] ?? '');
$confirm = trim($_POST['confirm_password'] ?? '');

$errors = [];
// VALIDATION
//current password check
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

//error handle
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: ../view/update_seller_password.php");
    exit;
}

//update password
updatePassword($_SESSION['user_id'], $new);

// User must log in again after password change
session_unset();
session_destroy();

header("Location: ../view/login.php");
exit;
