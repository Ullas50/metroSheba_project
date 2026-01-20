<?php
session_start();
require_once '../model/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php");
    exit;
}
// if user record is missing, stop and show error
$user = fetchUserById($_SESSION['user_id']);
if (!$user) {
   
    $_SESSION['profile_error'] = "User not found";
    header("Location: ../view/update_admin_profile.php");
    exit;
}

$altMobile = trim($_POST['alt_mobile'] ?? '');// get alternative mobile number from form

if ($altMobile !== '') {

   
    if (strlen($altMobile) !== 11) {
        $_SESSION['errors']['alt_mobile'] = "Alternative number must be exactly 11 digits";
        header("Location: ../view/update_admin_profile.php");
        exit;
    }

    // same as primary check
    if ($altMobile === $user['mobile']) {
        $_SESSION['errors']['alt_mobile'] = "Alternative number cannot be same as primary number";
        header("Location: ../view/update_admin_profile.php");
        exit;
    }
}


// handle profile photo upload
$photoName = $user['photo'];

if (!empty($_FILES['photo']['name'])) {
   
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $photoName = uniqid('profile_') . '.' . $ext;
    
    move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        "../public/uploads/" . $photoName
    );
}

// update user profile in database
$conn = getConnection();
$stmt = $conn->prepare(
    "UPDATE users SET photo=?, alt_mobile=? WHERE id=?"
);
//bind updated values and user id
$stmt->bind_param("ssi", $photoName, $altMobile, $_SESSION['user_id']);
$stmt->execute();

header("Location: ../controller/admin_profile.php");
exit;


