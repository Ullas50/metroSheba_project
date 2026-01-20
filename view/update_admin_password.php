<?php
session_start();
//recv err msg 
$errors = $_SESSION['errors'] ?? [];
//clear err from session after retrieving
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
<!--pass update form-->
<div class="password-container">
<form class="password-card"
      method="POST"
      action="../controller/update_password_controller_admin.php">

    <h2>Update Password</h2>
    <!--current pass-->
    <div class="form-group <?= isset($errors['current_password']) ? 'error' : '' ?>">
        <label>Current Password</label>
        <input type="password" name="current_password">
        <?php if (isset($errors['current_password'])): ?>
            <small class="error-text"><?= $errors['current_password'] ?></small>
        <?php endif; ?>
    </div>
    <!--new pass-->
    <div class="form-group <?= isset($errors['new_password']) ? 'error' : '' ?>">
        <label>New Password</label>
        <input type="password" name="new_password">
        <?php if (isset($errors['new_password'])): ?>
            <small class="error-text"><?= $errors['new_password'] ?></small>
        <?php endif; ?>
    </div>
    <!--confirm pass-->
    <div class="form-group <?= isset($errors['confirm_password']) ? 'error' : '' ?>">
        <label>Re-enter New Password</label>
        <input type="password" name="confirm_password">
        <?php if (isset($errors['confirm_password'])): ?>
            <small class="error-text"><?= $errors['confirm_password'] ?></small>
        <?php endif; ?>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-confirm">Confirm</button>
        <a href="admin_profile.php" class="btn-cancel">Back</a>
    </div>
</form>
</div>
</body>
</html>
