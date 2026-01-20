<?php
require_once '../model/User.php';
header("Content-Type: application/json");
//get user input from the form
$email   = trim($_POST['email'] ?? '');
$new     = trim($_POST['new_password'] ?? '');
$confirm = trim($_POST['confirm_password'] ?? '');

$errors = []; // array to hold validation errors

// email checking
if ($email === '') {
    $errors['email'] = "Email is required";
} else {
    $user = fetchUser($email);
    if (!$user) {
        $errors['email'] = "Email not found";
    }
}

// new password set
if ($new === '') {
    $errors['new_password'] = "New password is required";
} elseif (strlen($new) < 6) {
    $errors['new_password'] = "Minimum 6 characters required";// minimum length rule
}

// confirm password
if ($confirm === '') {
    $errors['confirm_password'] = "Please re-enter password";
} elseif ($new !== $confirm) {
    $errors['confirm_password'] = "Passwords do not match";
}
// error retun
if (!empty($errors)) {
    echo json_encode([
        "status" => "error",
        "errors" => $errors
    ]);
    exit;
}

//password update in database
updatePassword($user['id'], $new);
// return successfully
echo json_encode([
    "status" => "success"
]);
exit;
