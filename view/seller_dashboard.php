<?php
session_start();
//only logged-in sellers can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') 
{
    header("Location: login.php");
    exit;
}
//disable caching back btn issues
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

    <!--sell form-->
    <div class="card sell-card">
        <h3>Sell Ticket</h3>
        <p class="subtitle">Enter journey details</p>

        <form id="sellerForm" novalidate>

            <div class="field">
                <label>From</label>
                <select id="from" name="from"></select>
                <!-- ADDED -->
                <small class="error" id="fromError"></small>
            </div>

            <div class="field">
                <label>To</label>
                <select id="to" name="to"></select>
                <!-- ADDED -->
                <small class="error" id="toError"></small>
            </div>

            <div class="field">
                <label>Journey Date</label>
                <input type="date" id="journey_date" name="journey_date">
                <!-- ADDED -->
                <small class="error" id="dateError"></small>
            </div>

            <div class="field">
                <label>Quantity</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" max="10">
                <!-- ADDED -->
                <small class="error" id="qtyError"></small>
            </div>

        </form>
    </div>

    <!--summary-->
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

        <!--pay btn-->
        <button id="payBtn" type="button" class="pay-btn">
            Proceed to Payment
        </button>
    </div>

</div>

<script src="../public/js/seller.js"></script>
<?php include 'partials/footer.php'; ?>
</body>
</html>
