<?php
session_start();
require_once "../model/User.php";

/* ======================================================
   AJAX: EMAIL CHECK (USED BY EMAIL BLUR)
====================================================== */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['ajax']) &&
    $_POST['ajax'] === 'check_email'
) {
    $email = trim($_POST['email'] ?? '');

    if ($email !== '' && emailExists($email)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Email already registered'
        ]);
    } else {
        echo json_encode(['status' => 'ok']);
    }
    exit;
}

/* ======================================================
   AJAX: GENERIC FIELD VALIDATION (ALL FIELDS)
====================================================== */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['ajax']) &&
    $_POST['ajax'] === 'validate_field'
) {
    $field = $_POST['field'] ?? '';
    $value = trim($_POST['value'] ?? '');

    $error = '';

    switch ($field) {

        case 'firstName':
            if ($value === '') {
                $error = 'First name is required';
            }
            break;

        case 'lastName':
            if ($value === '') {
                $error = 'Last name is required';
            }
            break;

        case 'email':
            if ($value === '') {
                $error = 'Email is required';
            } elseif (emailExists($value)) {
                $error = 'Email already registered';
            }
            break;

        case 'password':
            if ($value === '') {
                $error = 'Password is required';
            } elseif (strlen($value) < 6) {
                $error = 'Password must be at least 6 characters';
            }
            break;

        case 'phone':
            if ($value === '') {
                $error = 'Mobile number is required';
            } elseif (strlen($value) !== 11) {
                $error = 'Mobile number must be exactly 11 digits';
            }
            break;

        case 'nidNumber':
            if ($value === '') {
                $error = 'NID is required';
            } elseif (strlen($value) !== 10) {
                $error = 'NID must be exactly 10 digits';
            }
            break;

        case 'dob':
            if ($value === '') {
                $error = 'Date of birth is required';
            }
            break;

        case 'terms':
            if ($value !== '1') {
                $error = 'You must accept the Terms & Conditions';
            }
            break;
    }

    if ($error !== '') {
        echo json_encode([
            'status'  => 'error',
            'message' => $error
        ]);
    } else {
        echo json_encode(['status' => 'ok']);
    }
    exit;
}

/* ======================================================
   NORMAL FORM SUBMIT (FINAL AUTHORITY)
====================================================== */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/register.php");
    exit;
}

$errors = [];

/* FIRST NAME */
if (empty($_POST['firstName'])) {
    $errors['firstName'] = "First name is required";
}

/* LAST NAME */
if (empty($_POST['lastName'])) {
    $errors['lastName'] = "Last name is required";
}

/* EMAIL */
if (empty($_POST['email'])) {
    $errors['email'] = "Email is required";
}

/* PASSWORD */
if (empty($_POST['password'])) {
    $errors['password'] = "Password is required";
} elseif (strlen($_POST['password']) < 6) {
    $errors['password'] = "Password must be at least 6 characters";
}

/* PHONE */
if (empty($_POST['phone'])) {
    $errors['phone'] = "Mobile number is required";
} elseif (strlen(trim($_POST['phone'])) !== 11) {
    $errors['phone'] = "Mobile number must be exactly 11 digits";
}

/* NID */
if (empty($_POST['nidNumber'])) {
    $errors['nid'] = "NID is required";
} elseif (strlen(trim($_POST['nidNumber'])) !== 10) {
    $errors['nid'] = "NID must be exactly 10 digits";
}

/* DOB */
if (empty($_POST['dob'])) {
    $errors['dob'] = "Date of birth is required";
}

/* GENDER */
if (empty($_POST['gender'])) {
    $errors['gender'] = "Gender is required";
}

/* TERMS */
if (!isset($_POST['terms'])) {
    $errors['terms'] = "You must accept the Terms & Conditions";
}

/* PHOTO */
if (!isset($_FILES['profile-photo']) || $_FILES['profile-photo']['error'] !== 0) {
    $errors['photo'] = "Profile photo is required";
}

/* REDIRECT IF ERRORS */
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;
    header("Location: ../view/register.php");
    exit;
}

/* FINAL EMAIL CHECK */
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
