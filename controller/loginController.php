<?php
session_start();
require_once "../model/user.php"; // make sure filename is correct

function redirectWithError($msg) {
    $_SESSION['login_error'] = $msg;
    header("Location: ../view/login.php");
    exit;
}

if (isset($_POST['remember-me'])) {
    setcookie(
        'remember_email',
        $email,
        time() + (86400 * 7), // 7 days
        '/',
        '',
        false,
        true // httponly
    );
} else {
    setcookie('remember_email', '', time() - 3600, '/');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['email'])) {
        redirectWithError("Email is required");
    }

    if (empty($_POST['password'])) {
        redirectWithError("Password is required");
    }

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    // ✅ PASS STRING, NOT ARRAY
    $user = fetchUser($email);

    if (!$user) {
    $_SESSION['login_error'] = "User not found";
    header("Location: ../view/login.php");
    exit;
}

if (!password_verify($password, $user['password'])) {
    $_SESSION['login_error'] = "Incorrect password";
    header("Location: ../view/login.php");
    exit;
}

    // SUCCESS
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['email']    = $user['email'];
    $_SESSION['role']     = $user['role'];

    if ($user['role'] === 'admin') {
        header("Location: ../view/adminDashboard.php");
    } elseif ($user['role'] === 'ticket_seller') {
        header("Location: ../view/sellerDashboard.php");
    } else {
        header("Location: ../view/userDashboard.php");
    }
    exit;
}
