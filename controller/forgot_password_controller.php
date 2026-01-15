<?php
require_once '../model/User.php';
header("Content-Type: application/json");

$email   = trim($_POST['email'] ?? '');
$new     = trim($_POST['new_password'] ?? '');
$confirm = trim($_POST['confirm_password'] ?? '');

$errors = [];

/* EMAIL */
if ($email === '') {
    $errors['email'] = "Email is required";
} else {
    $user = fetchUser($email);
    if (!$user) {
        $errors['email'] = "Email not found";
    }
}

/* NEW PASSWORD */
if ($new === '') {
    $errors['new_password'] = "New password is required";
} elseif (strlen($new) < 6) {
    $errors['new_password'] = "Minimum 6 characters required";
}

/* CONFIRM PASSWORD */
if ($confirm === '') {
    $errors['confirm_password'] = "Please re-enter password";
} elseif ($new !== $confirm) {
    $errors['confirm_password'] = "Passwords do not match";
}

/* RETURN ERRORS */
if (!empty($errors)) {
    echo json_encode([
        "status" => "error",
        "errors" => $errors
    ]);
    exit;
}

/* UPDATE PASSWORD */
updatePassword($user['id'], $new);

echo json_encode([
    "status" => "success"
]);
exit;
