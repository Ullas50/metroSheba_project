<?php
session_start();

$cashError = $_SESSION['cash_error'] ?? null;
unset($_SESSION['cash_error']);

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'seller' ||
    !isset($_SESSION['seller_payment'])
) {
    header("Location: seller_dashboard.php");
    exit;
}

$data = $_SESSION['seller_payment'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Cash Payment</title>
    <link rel="stylesheet" href="../public/css/Payment_seller.css">
</head>
<body>

<div class="payment-container">
    <div class="payment-card">

        <div class="brand">MetroSheba</div>
        <div class="method">Cash Payment</div>

        <div class="amount">
            Please collect <strong>৳<?= $data['amount'] ?></strong> in cash
        </div>

        <div class="route">
            <?= htmlspecialchars($data['from_name']) ?> → <?= htmlspecialchars($data['to_name']) ?>
        </div>

        <form method="POST" action="../controller/SellerConfirmPayment.php" novalidate>

            <div class="input-group">
                <label>Received Amount</label>
                <input
                    type="text"
                    name="received_amount"
                    inputmode="numeric"
                    step="1"
                    min="<?= $data['amount'] ?>"
                    required
                    placeholder="Enter received amount"
                    class="<?= $cashError ? 'input-error' : '' ?>"
                >

                <?php if ($cashError): ?>
                    <small class="error"><?= htmlspecialchars($cashError) ?></small>
                <?php endif; ?>
            </div>

            <div class="actions">
                <a href="seller_dashboard.php" class="cancel-btn">Back</a>
                <button type="submit" class="confirm-btn">Done</button>
            </div>

        </form>

    </div>
</div>

</body>
</html>
