<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<header class="header">
    <div class="container nav-bar">
        <div class="logo">
            🚉 MetroSheba
        </div>

        <nav>
            <a href="seller_dashboard.php" class="nav-link">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="nav-user">
                    <span class="nav-link nav-user-toggle">
                        <?= htmlspecialchars($_SESSION['full_name']) ?> ▾
                    </span>

                    <div class="nav-dropdown">
                        <a href="profile_seller.php">Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
            <?php endif; ?>

        </nav>
    </div>
</header>