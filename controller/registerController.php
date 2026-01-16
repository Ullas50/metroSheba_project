<?php
session_start();
require_once "../model/User.php";

/* ================= AJAX EMAIL CHECK ================= */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['ajax']) &&
    $_POST['ajax'] === 'check_email'
) {
    $email = trim($_POST['email'] ?? '');

    if ($email && emailExists($email)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email already registered'
        ]);
    } else {
        echo json_encode(['status' => 'ok']);
    }
    exit;
}

/* ================= NORMAL FORM SUBMIT ================= */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/register.php");
    exit;
}

$errors = [];

/* BASIC VALIDATION */
if (empty($_POST['firstName']) || empty($_POST['lastName'])) {
    $errors['name'] = "Name is required";
}
if (empty($_POST['email'])) {
    $errors['email'] = "Email is required";
}
if (empty($_POST['password']) || strlen($_POST['password']) < 6) {
    $errors['password'] = "Password must be at least 6 characters";
}
if (empty($_POST['nidNumber'])) {
    $errors['nid'] = "NID is required";
}
if (empty($_POST['dob'])) {
    $errors['dob'] = "Date of birth is required";
}
if (empty($_POST['gender'])) {
    $errors['gender'] = "Gender is required";
}
if (empty($_POST['phone'])) {
    $errors['phone'] = "Mobile number is required";
}
if (!isset($_FILES['profile-photo']) || $_FILES['profile-photo']['error'] !== 0) {
    $errors['photo'] = "Profile photo is required";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;
    header("Location: ../view/register.php");
    exit;
}

/* EMAIL EXISTS (FINAL SERVER CHECK) */
if (emailExists($_POST['email'])) {
    $_SESSION['errors']['email'] = "Email already registered";
    $_SESSION['old'] = $_POST;
    header("Location: ../view/register.php");
    exit;
}

/* UPLOAD PHOTO */
$ext = pathinfo($_FILES['profile-photo']['name'], PATHINFO_EXTENSION);
$photoName = time() . "_" . uniqid() . "." . $ext;
$uploadDir = "../public/uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!move_uploaded_file($_FILES['profile-photo']['tmp_name'], $uploadDir . $photoName)) {
    $_SESSION['errors']['photo'] = "Failed to upload photo";
    header("Location: ../view/register.php");
    exit;
}

/* INSERT USER */
$user = [
    'full_name' => trim($_POST['firstName']) . " " . trim($_POST['lastName']),
    'email'     => trim($_POST['email']),
    'password'  => $_POST['password'],
    'nid'       => trim($_POST['nidNumber']),
    'dob'       => $_POST['dob'],
    'gender'    => $_POST['gender'],
    'mobile'    => trim($_POST['phone']),
    'photo'     => $photoName
];

if (!insertUser($user)) {
    $_SESSION['errors']['general'] = "Registration failed";
    header("Location: ../view/register.php");
    exit;
}

unset($_SESSION['errors'], $_SESSION['old']);
header("Location: ../view/login.php");
exit;
