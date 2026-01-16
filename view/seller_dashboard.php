<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Seller Panel</title>

    <link rel="stylesheet" href="../public/css/seller.css">
    <link rel="stylesheet" href="../public/css/home.css">


</head>
<body>

<?php include 'partials/header2.php'; ?>

<div class="container">

    <!-- SELL FORM -->
    <div class="card sell-card">
        <h3>Sell Ticket</h3>
        <p class="subtitle">Enter journey details</p>

        <form id="sellerForm" novalidate>
            <div class="field">
                <label>From</label>
                <select id="from" name="from"></select>
            </div>

            <div class="field">
                <label>To</label>
                <select id="to" name="to"></select>
            </div>

            <div class="field">
                <label>Journey Date</label>
                <input type="date" id="journey_date" name="journey_date">
            </div>

            <div class="field">
                <label>Quantity</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" max="10">
            </div>
        </form>

        <div class="error" id="serverErr"></div>
    </div>

    <!-- SUMMARY -->
    <div class="summary premium-summary">
        <h3>Ticket Summary</h3>

        <div class="summary-row">
            <span>From</span>
            <strong id="sFrom">—</strong>
        </div>

        <div class="summary-row">
            <span>To</span>
            <strong id="sTo">—</strong>
        </div>

        <div class="summary-row">
            <span>Quantity</span>
            <strong id="sQty">0</strong>
        </div>

        <div class="summary-row">
            <span>Distance</span>
            <strong id="sDist">0 stations</strong>
        </div>

        <div class="divider"></div>

        <div class="summary-total">
            ৳<span id="sTotal">0</span>
        </div>
        <div class="summary-note">Total Fare</div>

        <!-- 🔥 PAYMENT BUTTON HERE -->
       <button id="payBtn" type="button" class="pay-btn">
    Proceed to Payment
</button>

    </div>

</div>

<script src="../public/js/seller.js"></script>
<?php include 'partials/footer.php'; ?>
</body>
</html>
