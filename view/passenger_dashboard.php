<?php
session_start();

/* 🚫 Disable browser cache */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

/* 🔐 Auth check */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Book Ticket</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../public/css/passenger.css">
    <link rel="stylesheet" href="../public/css/home.css">
</head>
<body>

<?php include 'partials/header1.php'; ?>

<main class="container main-section">

    <!-- LEFT CARD -->
    <div class="form-card">
        <h2><span class="blue-text">Metro Ticket</span></h2>
        <p>Confirm your metro ticket</p>

        <form id="bookingForm" novalidate>

            <div class="field">
                <label>From</label>
                <select id="from" name="from"></select>
                <small class="error" id="fromError"></small>
            </div>

            <div class="field">
                <label>To</label>
                <select id="to" name="to"></select>
                <small class="error" id="toError"></small>
            </div>

            <div class="field date-field">
                <input type="date" id="journey_date" name="journey_date">
                <label for="journey_date">Journey Date</label>
                <small class="error" id="dateError"></small>
            </div>

            <div class="field">
                <label>Quantity</label>
                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    value="0"
                    min="0"
                    step="1"
                    inputmode="numeric">
                <small class="error" id="qtyError"></small>
            </div>

            <div class="field">
                <strong>Total: <span id="totalPrice">৳0</span></strong>
            </div>

            <button type="submit" class="search-btn">
                Proceed to Payment
            </button>

        </form>
    </div>

    <!-- RIGHT IMAGE -->
    <div class="image-box">
        <img src="../public/images/passenger.jpg" alt="Metro Train">
    </div>

</main>

<?php include 'partials/footer.php'; ?>

<script src="../public/js/passenger.js"></script>

<script>
document.addEventListener("click", e => {
    const user = document.querySelector(".nav-user");
    if (!user) return;

    if (user.contains(e.target)) {
        user.classList.toggle("open");
    } else {
        user.classList.remove("open");
    }
});
</script>

<script>
/* Force back-button users to login */
window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        window.location.href = "login.php";
    }
});
</script>

</body>
</html>