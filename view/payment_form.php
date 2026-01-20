<?php
session_start();

if (!isset($_SESSION['payment'], $_SESSION['user_id'])) {
    header("Location: passenger_dashboard.php");
    exit;
}

$method = strtoupper($_SESSION['payment']['method']);
$amount = (int) $_SESSION['payment']['amount'];

/* Read error once */
$error = $_SESSION['payment_error'] ?? '';
unset($_SESSION['payment_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Payment</title>
    <link rel="stylesheet" href="../public/css/payment_form.css">
</head>
<body>

<div class="payment-container">
    <div class="payment-card">

        <h1 class="brand">MetroSheba</h1>
        <h2 class="method"><?= $method ?> Payment</h2>
        <p class="amount">Please pay ৳<?= $amount ?></p>

        <form method="POST" action="../controller/ConfirmPayment.php" novalidate>

            <div class="input-group">
                <label>Mobile Number</label>
                <input
                    type="number"
                    name="mobile"
                    placeholder="01XXXXXXXXX"
                    class="<?= $error ? 'input-error' : '' ?>"
                >

                <?php if ($error): ?>
                    <small class="error"><?= htmlspecialchars($error) ?></small>
                <?php endif; ?>
            </div>

            <div class="actions">
                <button type="submit" class="confirm-btn">Confirm</button>
                <a href="passenger_dashboard.php" class="cancel-btn">Cancel</a>
            </div>

        </form>

    </div>
</div>

</body>
</html>
