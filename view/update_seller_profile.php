<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
require_once '../model/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user = fetchUserById($_SESSION['user_id']);
if (!$user) {
    echo "User not found";
    exit;
}

$error = $_SESSION['profile_error'] ?? '';
unset($_SESSION['profile_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Update Profile</title>
    <link rel="stylesheet" href="../public/css/home.css">
    <link rel="stylesheet" href="../public/css/update_profile.css">
</head>
<body>

<?php include 'partials/header2.php'; ?>

<div class="update-container">
<form id="profileForm"
      class="update-card"
      method="POST"
      action="../controller/profile_update_controller_seller.php"
      enctype="multipart/form-data">

    <h2>Update Profile</h2>

    <?php if ($error): ?>
        <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="image-section">
        <img
            src="../public/uploads/<?= htmlspecialchars($user['photo'] ?: 'default.png') ?>"
            id="photoPreview"
            class="preview-img"
        >
        <label class="upload-btn">
            Change Photo
            <input type="file" name="photo" id="photoInput" accept="image/*" hidden>
        </label>
    </div>

    <div class="form-group">
        <label>Full Name</label>
        <input type="text" value="<?= htmlspecialchars($user['full_name']) ?>" readonly>
    </div>

    <div class="form-group">
        <label>Primary Mobile</label>
        <input type="text" value="<?= htmlspecialchars($user['mobile']) ?>" readonly>
    </div>

    <div class="form-group">
        <label>Alternative Mobile</label>
        <input type="text"
               name="alt_mobile"
               value="<?= htmlspecialchars($user['alt_mobile'] ?? '') ?>"
               placeholder="Optional">
        <small class="hint">Must be different from primary number</small> <br>
        <small class="error-text">
            <?= htmlspecialchars($errors['alt_mobile'] ?? '') ?>
        </small>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Gender</label>
            <input type="text" value="<?= htmlspecialchars($user['gender']) ?>" readonly>
        </div>
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="text" value="<?= htmlspecialchars($user['dob']) ?>" readonly>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-confirm">Confirm</button>
        <a href="profile_seller.php" class="btn-cancel">Cancel</a>
    </div>
</form>
</div>

<script src="../public/js/profile_update.js"></script>
<script src="../public/js/profile_preview.js"></script>

<?php include 'partials/footer.php'; ?>
</body>
</html>
