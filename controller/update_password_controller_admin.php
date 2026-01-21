<?php
session_start();
require_once '../model/User.php';

/* AJAX DETECTION */
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

/* AUTH GUARD */
if (!isset($_SESSION['user_id'])) {
    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'errors' => ['general' => 'Unauthorized access']
        ]);
        exit;
    }
    header("Location: ../view/login.php");
    exit;
}

/* METHOD GUARD */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'errors' => ['general' => 'Invalid request method']
        ]);
        exit;
    }
    header("Location: ../view/update_admin_password.php");
    exit;
}

/* FETCH USER */
$user = fetchUserById($_SESSION['user_id']);
if (!$user) {
    $_SESSION['errors']['general'] = "User not found";

    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'errors' => ['general' => 'User not found']
        ]);
        exit;
    }

    header("Location: ../view/update_admin_password.php");
    exit;
}

/* INPUT */
$current = trim($_POST['current_password'] ?? '');
$new     = trim($_POST['new_password'] ?? '');
$confirm = trim($_POST['confirm_password'] ?? '');

$errors = [];

/* VALIDATION — UNCHANGED */
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

/* ERROR HANDLING */
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;

    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);
        exit;
    }

    header("Location: ../view/update_admin_password.php");
    exit;
}

/* UPDATE PASSWORD */
updatePassword($_SESSION['user_id'], $new);

/* FORCE LOGOUT */
session_unset();
session_destroy();

/* SUCCESS RESPONSE */
if ($isAjax) {
    echo json_encode([
        'success' => true,
        'redirect' => '../view/login.php'
    ]);
    exit;
}

header("Location: ../view/login.php");
exit;
