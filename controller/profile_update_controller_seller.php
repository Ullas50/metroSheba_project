<?php
session_start();
require_once '../model/User.php';

/* AJAX DETECTION */
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if (!isset($_SESSION['user_id'])) {
    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'errors' => ['general' => 'Unauthorized']
        ]);
        exit;
    }
    header("Location: ../view/login.php");
    exit;
}

/* LOAD USER */
$user = fetchUserById($_SESSION['user_id']);
if (!$user) {
    $_SESSION['profile_error'] = "User not found";

    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'errors' => ['general' => 'User not found']
        ]);
        exit;
    }

    header("Location: ../view/update_seller_profile.php");
    exit;
}

/* INPUT */
$altMobile = trim($_POST['alt_mobile'] ?? '');
$errors = [];

/* VALIDATION (SAME) */
if ($altMobile !== '') {

    // must be exactly 11 digits
    if (strlen($altMobile) !== 11) {
        $errors['alt_mobile'] = "Alternative number must be exactly 11 digits";

    // must match Bangladesh mobile format
    } elseif (!preg_match('/^01[3-9][0-9]{8}$/', $altMobile)) {
        $errors['alt_mobile'] = "Invalid mobile number format";

    // must not match primary number
    } elseif ($altMobile === $user['mobile']) {
        $errors['alt_mobile'] = "Alternative number cannot be same as primary number";
    }
}

/* HANDLE ERRORS */
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;

    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);
        exit;
    }

    header("Location: ../view/update_seller_profile.php");
    exit;
}

/* PHOTO UPLOAD */
$photoName = $user['photo'];

if (!empty($_FILES['photo']['name'])) {
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $photoName = uniqid('profile_') . '.' . $ext;

    move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        "../public/uploads/" . $photoName
    );
}

/* UPDATE DB */
$conn = getConnection();
$stmt = $conn->prepare(
    "UPDATE users SET photo=?, alt_mobile=? WHERE id=?"
);
$stmt->bind_param("ssi", $photoName, $altMobile, $_SESSION['user_id']);
$stmt->execute();

/* SUCCESS */
if ($isAjax) {
    echo json_encode([
        'success' => true,
        'redirect' => '../view/profile_seller.php'
    ]);
    exit;
}

header("Location: ../view/profile_seller.php");
exit;
