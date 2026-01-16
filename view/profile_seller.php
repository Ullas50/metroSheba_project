<?php
session_start();
require_once '../model/User.php';

/* AUTH GUARD */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* FETCH LOGGED-IN USER */
$user = fetchUserById($_SESSION['user_id']);

if (!$user) {
    echo "User not found";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | My Profile</title>
    <link rel="stylesheet" href="../public/css/profile.css">
    <link rel="stylesheet" href="../public/css/home.css">
</head>
<body>

<?php include 'partials/header2.php'; ?>

<div class="profile-container">

    <div class="profile-card">

        <!-- PROFILE PHOTO -->
        <div class="profile-photo">
            <?php if (!empty($user['photo'])): ?>
                <img src="../public/uploads/<?= htmlspecialchars($user['photo']) ?>" alt="Profile Photo">
            <?php else: ?>
                <img src="../public/uploads/default.png" alt="Profile Photo">
            <?php endif; ?>
        </div>

        <!-- NAME -->
        <h2><?= htmlspecialchars($user['full_name']) ?></h2>

        <!-- USER INFO -->
        <div class="profile-info">
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Mobile:</strong> <?= htmlspecialchars($user['mobile']) ?></p>
            <?php if (!empty($user['alt_mobile'])): ?>
    <p>
        <strong>Alternative Mobile:</strong>
        <?= htmlspecialchars($user['alt_mobile']) ?>
    </p>
<?php endif; ?>

            <p><strong>NID:</strong> <?= htmlspecialchars($user['nid']) ?></p>
            <p><strong>Date of Birth:</strong> <?= htmlspecialchars($user['dob']) ?></p>
            <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?></p>
        </div>

        <!-- ACTION -->
        <div class="profile-actions">
    <a href="update_seller_profile.php" class="btn-profile">
        Update Profile
    </a>

    <a href="update_seller_password.php" class="btn-password">
        Update Password
    </a>
</div>



    </div>

</div>
<?php include 'partials/footer.php'; ?>
</body>
</html>
