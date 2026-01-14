<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Login</title>
    <link rel="stylesheet" href="../public/css/login.css">
     <link rel="stylesheet" href="../public/css/home.css">
</head>
<body>

<?php include 'partials/header.php'; ?>

<div class="login-page">

    <!-- LEFT IMAGE -->
<div class="login-image">
    <div class="image-overlay">
        <h1>MetroSheba</h1>
        <p>Fast & Secure Metro Ticket Booking</p>
    </div>
</div>

    <!-- RIGHT FORM -->
    <div class="login-form-container">

        <h2>Login to your account</h2>

        <!-- ✅ ERROR MESSAGE (REGISTRATION STYLE) -->
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="form-error">
                <?= $_SESSION['login_error']; ?>
            </div>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>

        <form method="POST" action="../controller/loginController.php">

    <label>Email</label>
    <input type="text" name="email"
           value="<?= isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : '' ?>"
           placeholder="Enter your email">

    <label>Password</label>

<div class="password-wrapper">
    <input type="password" id="password" name="password" placeholder="Enter your password">
    <span class="toggle-password" id="togglePassword">👁️</span>
</div>


    <!-- ✅ ERROR BELOW INPUTS -->
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="form-error">
            <?= $_SESSION['login_error']; ?>
        </div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>


    <div class="remember-row">
    <label class="remember-label">
        <input type="checkbox" name="remember-me"
            <?= isset($_COOKIE['remember_email']) ? 'checked' : '' ?>>
        <span>Remember Me</span>
    </label>
</div>


    <button type="submit">Login</button>
</form>
        <form class="links-form">

            <p class="links">
                <a href="#">Forgot Password?</a><br>
                Not registered yet? <a href="register.php">Create Account</a>
            </p>
        </form>
    </div>
</div>
<script src="../public/js/loginValidation.js"></script>
<?php include 'partials/footer.php'; ?>
</body>

<script>
document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("password");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        this.textContent = "🙈";
    } else {
        passwordInput.type = "password";
        this.textContent = "👁️";
    }
});
</script>

</html>
