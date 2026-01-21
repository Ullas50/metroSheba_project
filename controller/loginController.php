<?php
session_start();
require_once "../model/user.php";

/*detect AJAX */
function isAjaxRequest() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/* ERROR HANDLER */
function redirectWithError($msg) {

    // AJAX response
    if (isAjaxRequest()) {
        echo json_encode([
            'status' => 'error',
            'message' => $msg
        ]);
        exit;
    }

    // NORMAL form response (unchanged)
    $_SESSION['login_error'] = $msg;
    header("Location: ../view/login.php");
    exit;
}

/*MAIN LOGIC */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['email'])) {
        redirectWithError("Email is required");
    }

    if (empty($_POST['password'])) {
        redirectWithError("Password is required");
    }

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user
    $user = fetchUser($email);

    if (!$user) {
        redirectWithError("User not found");
    }

    if (!password_verify($password, $user['password'])) {
        redirectWithError("Incorrect password");
    }

    /* LOGIN SUCCESS */
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email']     = $user['email'];
    $_SESSION['role']      = $user['role'];

    // Remember me
    if (isset($_POST['remember-me'])) {
        setcookie(
            'remember_email',
            $email,
            time() + (86400 * 7),
            '/',
            '',
            false,
            true
        );
    } else {
        setcookie('remember_email', '', time() - 3600, '/');
    }

    /* AJAX SUCCESS RESPONSE */
    if (isAjaxRequest()) {

        // decide redirect URL
        $redirect = '../view/passenger_dashboard.php';

        if ($user['role'] === 'admin') {
            $redirect = '../view/admin_dashboard.php';
        } elseif ($user['role'] === 'seller') {
            $redirect = '../view/seller_dashboard.php';
        }

        echo json_encode([
            'status'   => 'success',
            'redirect' => $redirect
        ]);
        exit;
    }

    /* NORMAL REDIRECT */
    if ($user['role'] === 'admin') {
        header("Location: ../view/admin_dashboard.php");
    } elseif ($user['role'] === 'seller') {
        header("Location: ../view/seller_dashboard.php");
    } else {
        header("Location: ../view/passenger_dashboard.php");
    }
    exit;
}
