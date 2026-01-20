<?php
session_start();//for login and error msg
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
<!--common header-->
<?php include 'partials/header.php'; ?>

<div class="login-page">

    <!--log-in page left image-->
<div class="login-image">
    <div class="image-overlay">
        <h1>MetroSheba</h1>
        <p>Fast & Secure Metro Ticket Booking</p>
    </div>
</div>

    <!--right sile login form-->
    <div class="login-form-container">

        <h2>Login to your account</h2>

        <!--error msg (log-in failed)-->
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="form-error">
                <?= $_SESSION['login_error']; ?>
            </div>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>
<!--login form-->
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

    <!--show error-->
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="form-error">
            <?= $_SESSION['login_error']; ?>
        </div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>
<!--remember me chechbok-->
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
    <a href="forgot_password.php">Forgot Password?</a><br>
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

    if (passwordInput.type === "password") 
        {
        passwordInput.type = "text";
        this.textContent = "🙈";
    } 
    else 
    {
        passwordInput.type = "password";
        this.textContent = "👁️";
    }
});
</script>




</html>
