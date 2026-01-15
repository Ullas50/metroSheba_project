<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../public/css/forgot_password.css">
</head>
<body>

<div class="password-container">

<form id="forgotForm" class="password-card" novalidate>

    <h2>Reset Password</h2>

    <!-- EMAIL -->
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email">
        <small class="error-text" data-error="email"></small>
    </div>

    <!-- NEW PASSWORD -->
    <div class="form-group">
        <label>New Password</label>
        <input type="password" name="new_password">
        <small class="error-text" data-error="new_password"></small>
    </div>

    <!-- CONFIRM PASSWORD -->
    <div class="form-group">
        <label>Re-enter New Password</label>
        <input type="password" name="confirm_password">
        <small class="error-text" data-error="confirm_password"></small>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-confirm">Confirm</button>
        <a href="login.php" class="btn-cancel">Back</a>
    </div>

</form>

</div>

<script src="../public/js/forgot_password.js"></script>
</body>
</html>
