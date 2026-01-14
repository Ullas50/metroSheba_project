<?php
require_once "../core/db.php";

/* =========================
   FETCH USER BY EMAIL (LOGIN)
========================= */
function fetchUser($email) {
    $conn = getConnection();
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        return mysqli_fetch_assoc($result);
    }
    return false;
}

/* =========================
   INSERT USER (REGISTER)
========================= */
function insertUser($user) {
    $conn = getConnection();

    $full_name = mysqli_real_escape_string($conn, $user['full_name']);
    $email     = mysqli_real_escape_string($conn, $user['email']);
    $password  = password_hash($user['password'], PASSWORD_DEFAULT);
    $nid       = mysqli_real_escape_string($conn, $user['nid']);
    $dob       = mysqli_real_escape_string($conn, $user['dob']);
    $gender    = mysqli_real_escape_string($conn, $user['gender']);
    $mobile    = mysqli_real_escape_string($conn, $user['mobile']);
    $photo     = mysqli_real_escape_string($conn, $user['photo']);

    // EMAIL DUPLICATE CHECK
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if ($check && mysqli_num_rows($check) > 0) {
        return "EMAIL_EXISTS";
    }

    $sql = "INSERT INTO users
        (role, full_name, email, password, nid, dob, gender, mobile, photo, created_at)
        VALUES
        ('customer','$full_name','$email','$password','$nid','$dob','$gender','$mobile','$photo',NOW())";

    if (!mysqli_query($conn, $sql)) {
        return mysqli_error($conn); // SHOW REAL DB ERROR
    }

    return true;
}

/* =========================
   FETCH ALL USERS
========================= */
function fetchAllUsers() {
    $conn = getConnection();
    $sql = "SELECT * FROM users ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    $users = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users;
}

/* =========================
   FETCH USER BY ID
========================= */
function fetchUserById($id) {
    $conn = getConnection();
    $id = intval($id);

    $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        return mysqli_fetch_assoc($result);
    }
    return false;
}

/* =========================
   UPDATE USER
========================= */
function updateUser($user) {
    $conn = getConnection();

    $id        = intval($user['id']);
    $full_name = mysqli_real_escape_string($conn, $user['full_name']);
    $mobile    = mysqli_real_escape_string($conn, $user['mobile']);
    $gender    = mysqli_real_escape_string($conn, $user['gender']);
    $dob       = mysqli_real_escape_string($conn, $user['dob']);

    $sql = "UPDATE users SET
        full_name='$full_name',
        mobile='$mobile',
        gender='$gender',
        dob='$dob'
        WHERE id=$id";

    return mysqli_query($conn, $sql);
}

/* =========================
   UPDATE PASSWORD
========================= */
function updatePassword($id, $newPassword) {
    $conn = getConnection();
    $id = intval($id);
    $password = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password='$password' WHERE id=$id";
    return mysqli_query($conn, $sql);
}

/* =========================
   DELETE USER
========================= */
function deleteUser($id) {
    $conn = getConnection();
    $id = intval($id);

    $sql = "DELETE FROM users WHERE id=$id";
    return mysqli_query($conn, $sql);
}
