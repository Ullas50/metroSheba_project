<?php
session_start();
require_once "../model/user.php";
//save the error in session
function redirectWithError($msg) {
    $_SESSION['login_error'] = $msg;
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 //make sure email is provided
    if (empty($_POST['email'])) {
        redirectWithError("Email is required");
    }
// make sure password is provided
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
//verify that the entered password matches the hashed password
    if (!password_verify($password, $user['password'])) {
        redirectWithError("Incorrect password");
    }

    // login sucess
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email']     = $user['email'];
    $_SESSION['role']      = $user['role'];

    // Remember me cookie 
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

    // redirect by role
    if ($user['role'] === 'admin') {
        header("Location: ../controller/AdminDashboardController.php");
    } elseif ($user['role'] === 'seller') {
        header("Location: ../view/seller_dashboard.php");
    } else {
        header("Location: ../view/passenger_dashboard.php");
    }
    exit;
}
