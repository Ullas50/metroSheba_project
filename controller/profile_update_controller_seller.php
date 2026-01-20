<?php
session_start();
require_once '../model/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php");
    exit;
}

$user = fetchUserById($_SESSION['user_id']); // seller data using the logged-in user ID

if (!$user) {
    $_SESSION['profile_error'] = "User not found"; //if user record is not found, stop and show error
    header("Location: ../view/update_seller_profile.php");
    exit;
}

$altMobile = trim($_POST['alt_mobile'] ?? '');

// validate alternative mobile number
if ($altMobile !== '') {

    // 11-digit check
    if (strlen($altMobile) !== 11) {
        $_SESSION['errors']['alt_mobile'] = "Alternative number must be exactly 11 digits";
        header("Location: ../view/update_admin_profile.php");
        exit;
    }

    // Same as primary check
    if ($altMobile === $user['mobile']) {
        $_SESSION['errors']['alt_mobile'] = "Alternative number cannot be same as primary number";
        header("Location: ../view/update_admin_profile.php");
        exit;
    }
}

// handle photo upload
$photoName = $user['photo'];

if (!empty($_FILES['photo']['name'])) {
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $photoName = uniqid('profile_') . '.' . $ext;
    move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        "../public/uploads/" . $photoName
    );
}

// update seller profile in database
$conn = getConnection();
$stmt = $conn->prepare(
    "UPDATE users SET photo=?, alt_mobile=? WHERE id=?"
);
$stmt->bind_param("ssi", $photoName, $altMobile, $_SESSION['user_id']);
$stmt->execute();

header("Location: ../view/profile_seller.php");
exit;
