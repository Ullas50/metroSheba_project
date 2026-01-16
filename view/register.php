<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../public/css/register.css">
    <link rel="stylesheet" href="../public/css/home.css">
</head>

<body>

    <?php include 'partials/header.php'; ?>

    <div class="register-page">

        <div class="register-image">
            <img src="../public/images/register.jpg" alt="MetroSheba">
            <div class="image-overlay">
                <h1>MetroSheba</h1>
                <p>Fast & Easy Metro Ticket Booking</p>
            </div>
        </div>

        <section class="register-container">

            <div class="register-header">
                <h2>Registration</h2>
                <p>Quickly register to book your metro train tickets</p>
            </div>

            <!-- ERROR BOX -->
            <?php
            if (!empty($_SESSION['errors'])) {
                echo '<div class="error-box">';
                foreach ($_SESSION['errors'] as $err) {
                    echo '<p>' . htmlspecialchars($err) . '</p>';
                }
                echo '</div>';
                unset($_SESSION['errors']);
            }
            ?>

            <form id="registrationForm"
                method="POST"
                action="../controller/registerController.php"
                enctype="multipart/form-data">

                <!-- NAME -->
                <div class="row">
                    <div>
                        <label>First Name</label>
                        <input type="text" id="firstName" name="firstName">
                        <small id="firstNameError" class="error"></small>
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" id="lastName" name="lastName">
                        <small id="lastNameError" class="error"></small>
                    </div>
                </div>

                <!-- EMAIL -->
                <label>Email</label>
<input
    type="text"
    id="email"
    name="email"
    value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">

<small id="emailError" class="error">
    <?= htmlspecialchars($_SESSION['errors']['email'] ?? '') ?>
</small>




                <!-- PHONE -->
                <label>Mobile Number</label>
                <input type="text" id="phone" name="phone">
                <small id="phoneError" class="error"></small>

                <!-- DOB -->
                <label>Date of Birth</label>
                <input type="date" id="dob" name="dob">
                <small id="dobError" class="error"></small>

                <!-- GENDER -->
                <label>Gender</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="male"> Male</label>
                    <label><input type="radio" name="gender" value="female"> Female</label>
                    <label><input type="radio" name="gender" value="other"> Other</label>
                </div>
                <small id="genderError" class="error"></small>

                <!-- NID -->
                <label>NID Number</label>
                <input type="text" id="nidNumber" name="nidNumber">
                <small id="nidNumberError" class="error"></small>

                <!-- PASSWORD -->
                <label>Password</label>
                <input type="password" id="password" name="password">
                <small id="passwordError" class="error"></small>

                <!-- CONFIRM -->
                <label>Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
                <small id="confirmPasswordError" class="error"></small>

                <!-- PHOTO -->
                <label>Profile Photo</label>
                <input type="file" id="profile-photo" name="profile-photo">
                <small id="profilePhotoError" class="error"></small>

                <!-- TERMS -->
                <div class="terms">
                    <label class="terms-label">
                        <input type="checkbox" id="terms" name="terms">
                        <span>
                            I agree to the
                            <a href="terms.php" target="_blank">Terms &amp; Conditions</a>
                        </span>
                    </label>
                    <small id="termsError" class="error"></small>
                </div>


                <button type="submit">Register</button>

                <p class="login-link">
                    Already registered? <a href="login.php">Login</a>
                </p>

            </form>
        </section>
    </div>

    <script src="../public/js/register.js"></script>
    <?php include 'partials/footer.php'; ?>
    <?php
    unset($_SESSION['errors'], $_SESSION['old']);
    ?>

</body>

</html>