<?php
require_once "../model/User.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/register.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| BASIC SERVER-SIDE VALIDATION
|--------------------------------------------------------------------------
*/
$errors = [];

if (empty($_POST['firstName']) || empty($_POST['lastName'])) {
    $errors[] = "Name is required";
}

if (empty($_POST['email'])) {
    $errors[] = "Email is required";
}

if (empty($_POST['password']) || strlen($_POST['password']) < 6) {
    $errors[] = "Password must be at least 6 characters";
}

if (empty($_POST['nidNumber'])) {
    $errors[] = "NID is required";
}

if (empty($_POST['dob'])) {
    $errors[] = "Date of birth is required";
}

if (empty($_POST['gender'])) {
    $errors[] = "Gender is required";
}

if (empty($_POST['phone'])) {
    $errors[] = "Mobile number is required";
}

if (!isset($_FILES['profile-photo']) || $_FILES['profile-photo']['error'] !== 0) {
    $errors[] = "Profile photo is required";
}

if (!empty($errors)) {
    echo implode("<br>", $errors);
    exit;
}

/*
|--------------------------------------------------------------------------
| PHOTO UPLOAD
|--------------------------------------------------------------------------
*/
$photoExt = pathinfo($_FILES['profile-photo']['name'], PATHINFO_EXTENSION);
$photoName = time() . "_" . uniqid() . "." . $photoExt;
$uploadDir = "../public/uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$uploadPath = $uploadDir . $photoName;

if (!move_uploaded_file($_FILES['profile-photo']['tmp_name'], $uploadPath)) {
    die("Failed to upload profile photo");
}

/*
|--------------------------------------------------------------------------
| PREPARE USER DATA
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| INSERT USER
|--------------------------------------------------------------------------
*/
$result = insertUser($user);

if ($result === true) {
    header("Location: ../view/login.php");
    exit;
}

if ($result === "EMAIL_EXISTS") {
    echo "Email already registered";
    exit;
}

echo "Registration failed";