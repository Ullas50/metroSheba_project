<?php
session_start();

//browser caching disable
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['user_id'])) 
{
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Book Ticket</title>
    <!--css-->
    <link rel="stylesheet" href="../public/css/passenger.css">
    <link rel="stylesheet" href="../public/css/home.css">
</head>
<body>

<?php include 'partials/header1.php'; ?>

<main class="container main-section">

    <!--left card booking form -->
    <div class="form-card">
        <h2><span class="blue-text">Metro Ticket</span></h2>
        <p>Confirm your metro ticket</p>
<!--ticket booking form -->
        <form id="bookingForm" novalidate>
            <!--from station-->
            <div class="field">
                <label>From</label>
                <select id="from" name="from"></select>
                <small class="error" id="fromError"></small>
            </div>
            <!--to station -->
            <div class="field">
                <label>To</label>
                <select id="to" name="to"></select>
                <small class="error" id="toError"></small>
            </div>
<!--journey date-->
            <div class="field date-field">
                <input type="date" id="journey_date" name="journey_date">
                <label for="journey_date">Journey Date</label>
                <small class="error" id="dateError"></small>
            </div>
<!--ticket quantity-->
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
<!--total price-->
            <div class="field">
                <strong>Total: <span id="totalPrice">৳0</span></strong>
            </div>

            <button type="submit" class="search-btn">
                Proceed to Payment
            </button>

        </form>
    </div>

    <!--right image-->
    <div class="image-box">
        <img src="../public/images/passenger.jpg" alt="Metro Train">
    </div>

</main>
<!--common footer-->
<?php include 'partials/footer.php'; ?>
<script src="../public/js/passenger.js"></script>
<!--toggle for user menu-->
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

window.addEventListener("pageshow", function (event) 
{
    if (event.persisted) 
    {
        window.location.href = "login.php";
    }
});
</script>

</body>
</html>