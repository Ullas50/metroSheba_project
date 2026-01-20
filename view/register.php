<?php
session_start();//old input & error msg
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--css-->
    <link rel="stylesheet" href="../public/css/register.css">
    <link rel="stylesheet" href="../public/css/home.css">
</head>

<body>

    <?php include 'partials/header.php'; ?>

    <div class="register-page">
<!--left image-->
        <div class="register-image">
            <img src="../public/images/register.jpg" alt="MetroSheba">
            <div class="image-overlay">
                <h1>MetroSheba</h1>
                <p>Fast & Easy Metro Ticket Booking</p>
            </div>
        </div>
<!--right from-->
        <section class="register-container">

            <div class="register-header">
                <h2>Registration</h2>
                <p>Quickly register to book your metro train tickets</p>
            </div>

            <form id="registrationForm"
                method="POST"
                action="../controller/registerController.php"
                enctype="multipart/form-data">

                <!--name-->
                <div class="row">
                    <div>
                        <label>First Name</label>
                        <input type="text" id="firstName" name="firstName"
                            value="<?= htmlspecialchars($_SESSION['old']['firstName'] ?? '') ?>">
                        <small id="firstNameError" class="error">
                            <?= htmlspecialchars($_SESSION['errors']['firstName'] ?? '') ?>
                        </small>
                    </div>

                    <div>
                        <label>Last Name</label>
                        <input type="text" id="lastName" name="lastName"
                            value="<?= htmlspecialchars($_SESSION['old']['lastName'] ?? '') ?>">
                        <small id="lastNameError" class="error">
                            <?= htmlspecialchars($_SESSION['errors']['lastName'] ?? '') ?>
                        </small>
                    </div>
                </div>



                <!--mail-->
                <label>Email</label>
                <input type="text" id="email" name="email"
                    value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">
                <small id="emailError" class="error">
                    <?= htmlspecialchars($_SESSION['errors']['email'] ?? '') ?>
                </small>

                <!--mobile num-->
                <label>Mobile Number</label>
                <input type="text" id="phone" name="phone">
                <small id="phoneError" class="error">
                    <?= htmlspecialchars($_SESSION['errors']['phone'] ?? '') ?>
                </small>

                <!--date of birth-->
                <label>Date of Birth</label>
                <input type="date" id="dob" name="dob">
                <small id="dobError" class="error">
                    <?= htmlspecialchars($_SESSION['errors']['dob'] ?? '') ?>
                </small>

                <!--gender-->
                <label>Gender</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="male"> Male</label>
                    <label><input type="radio" name="gender" value="female"> Female</label>
                    <label><input type="radio" name="gender" value="other"> Other</label>
                </div>
                <small id="genderError" class="error">
                    <?= htmlspecialchars($_SESSION['errors']['gender'] ?? '') ?>
                </small>

                <!--nid-->
                <label>NID Number</label>
                <input type="text" id="nidNumber" name="nidNumber">
                <small id="nidNumberError" class="error">
                    <?= htmlspecialchars($_SESSION['errors']['nid'] ?? '') ?>
                </small>

                <!--pass-->
                <label>Password</label>
                <input type="password" id="password" name="password">
                <small id="passwordError" class="error">
                    <?= htmlspecialchars($_SESSION['errors']['password'] ?? '') ?>
                </small>

                <!--confirm pass -->
                <label>Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
                <small id="confirmPasswordError" class="error">
                    <?= htmlspecialchars($_SESSION['errors']['confirmPassword'] ?? '') ?>
                </small>

                <!--profile pic-->
                <label>Profile Photo</label>
                <input type="file" id="profilePhoto" name="profile-photo">
                <small id="profilePhotoError" class="error">
                    <?= htmlspecialchars($_SESSION['errors']['photo'] ?? '') ?>
                </small>

                <!--terms-->
                <div class="terms">
                    <label class="terms-label">
                        <input type="checkbox" id="terms" name="terms">
                        <span>
                            I agree to the
                            <a href="terms.php" target="_blank">Terms &amp; Conditions</a>
                        </span>
                    </label>
                    <small id="termsError" class="error">
                        <?= htmlspecialchars($_SESSION['errors']['terms'] ?? '') ?>
                    </small>
                </div>

<!--submit btn-->
                <button type="submit">Register</button>
                <p class="login-link">
                    Already registered? <a href="login.php">Login</a>
                </p>
            </form>
        </section>
    </div>
<!--js validation-->
    <script src="../public/js/register.js"></script>
    <?php include 'partials/footer.php'; ?>
<!--clear old input & erroe session data-->
    <?php unset($_SESSION['errors'], $_SESSION['old']); ?>

</body>
</html>