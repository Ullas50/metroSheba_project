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

<!-- MAIN SPLIT CONTAINER -->
<div class="register-page">

    <!-- LEFT SIDE IMAGE -->
    <div class="register-image">
        <img src="../public/images/register.jpg" alt="MetroSheba">
        <div class="image-overlay">
            <h1>MetroSheba</h1>
            <p>Fast & Easy Metro Ticket Booking</p>
        </div>
    </div>

    <!-- RIGHT SIDE (YOUR EXISTING FORM, UNTOUCHED) -->
    <section class="register-container">

        <!-- HEADER -->
        <div class="register-header">
            <h2>Registration</h2>
            <p>Quickly register to book your metro train tickets</p>
        </div>

        <!-- FORM (UNCHANGED) -->
        <form id="registrationForm"
              method="POST"
              action="../controller/registerController.php"
              enctype="multipart/form-data">

            <!-- EVERYTHING BELOW IS YOUR ORIGINAL CODE -->
            <!-- NO FIELD MODIFIED -->

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
            <div>
                <label>Email</label>
                <input type="text" id="email" name="email">
                <small id="emailError" class="error"></small>
            </div>

            <!-- PHONE -->
            <div>
                <label>Mobile Number</label>
                <input type="text" id="phone" name="phone">
                <small id="phoneError" class="error"></small>
            </div>

            <!-- DATE OF BIRTH -->
            <div>
                <label>Date of Birth</label>
                <div class="date-input-wrapper">
                    <input type="date" id="dob" name="dob">
                </div>
                <small id="dobError" class="error"></small>
            </div>

            <!-- GENDER -->
            <div>
                <label>Gender</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="male"> Male</label>
                    <label><input type="radio" name="gender" value="female"> Female</label>
                    <label><input type="radio" name="gender" value="other"> Other</label>
                </div>
                <small id="genderError" class="error"></small>
            </div>

            <!-- NID -->
            <div>
                <label>NID Number</label>
                <input type="text" id="nidNumber" name="nidNumber">
                <small id="nidNumberError" class="error"></small>
            </div>

            <!-- PASSWORD -->
            <div>
                <label>Password</label>
                <input type="password" id="password" name="password">
                <small id="passwordError" class="error"></small>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div>
                <label>Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
                <small id="confirmPasswordError" class="error"></small>
            </div>

            <!-- PHOTO -->
            <div>
                <label>Profile Photo</label>
                <input type="file" id="profile-photo" name="profile-photo">
                <small id="profilePhotoError" class="error"></small>
            </div>

            <!-- TERMS -->
            <div class="terms">
                <input type="checkbox" id="terms">
                I agree to the <a href="#">Terms & Conditions</a>
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
</body>
</html>
