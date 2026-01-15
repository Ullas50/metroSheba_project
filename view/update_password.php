<?php
session_start();
require_once '../model/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = $_SESSION['password_error'] ?? '';
unset($_SESSION['password_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Update Password</title>
    <link rel="stylesheet" href="../public/css/update_password.css">
</head>
<body>

<?php include 'partials/header.php'; ?>

<div class="password-container">

    <form class="password-card"
          method="POST"
          action="../controller/update_password_controller.php">

        <h2>Update Password</h2>

        <?php if ($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- OLD PASSWORD -->
        <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="current_password" required>
        </div>

        <!-- NEW PASSWORD -->
        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="new_password" required>
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="form-group">
            <label>Re-enter New Password</label>
            <input type="password" name="confirm_password" required>
        </div>

        <!-- ACTIONS -->
        <div class="form-actions">
            <button type="submit" class="btn-confirm">Confirm</button>
            <a href="update_profile.php" class="btn-cancel">Back</a>
        </div>

    </form>

</div>

</body>
</html>
