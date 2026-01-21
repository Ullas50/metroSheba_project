<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Password</title>
    <link rel="stylesheet" href="../public/css/update_password.css">
    <link rel="stylesheet" href="../public/css/home.css">
</head>
<body>

<div class="password-container">
<form id="passwordForm"
      class="password-card"
      method="POST"
      action="../controller/update_password_controller_admin.php">

    <h2>Update Password</h2>

    <!-- current password -->
    <div class="form-group <?= isset($errors['current_password']) ? 'error' : '' ?>">
        <label>Current Password</label>
        <input type="password" name="current_password">
        <small class="error-text">
            <?= $errors['current_password'] ?? '' ?>
        </small>
    </div>

    <!-- new password -->
    <div class="form-group <?= isset($errors['new_password']) ? 'error' : '' ?>">
        <label>New Password</label>
        <input type="password" name="new_password">
        <small class="error-text">
            <?= $errors['new_password'] ?? '' ?>
        </small>
    </div>

    <!-- confirm password -->
    <div class="form-group <?= isset($errors['confirm_password']) ? 'error' : '' ?>">
        <label>Re-enter New Password</label>
        <input type="password" name="confirm_password">
        <small class="error-text">
            <?= $errors['confirm_password'] ?? '' ?>
        </small>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-confirm" name="submit">Confirm</button>
        <a href="admin_profile.php" class="btn-cancel">Back</a>
    </div>

</form>
</div>

<script src="../public/js/update_password.js"></script>
</body>
</html>
