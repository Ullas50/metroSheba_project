<?php
session_start();
require_once '../model/Admin.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    exit("Invalid request");
}

$admin = new Admin();
$data = $admin->getPassengerDetails((int)$_GET['id']);

if (!$data) {
    exit("Passenger not found");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Passenger Details</title>
    <link rel="stylesheet" href="../public/css/admin.css">
</head>
<body>

<div class="detail-container">

    <div class="profile-card">
        <img src="../public/uploads/<?= htmlspecialchars($data['photo']) ?>" alt="Passenger Photo">
        <h2><?= htmlspecialchars($data['full_name']) ?></h2>
        <p><?= htmlspecialchars($data['email']) ?></p>
    </div>

    <div class="info-grid">
        <div><strong>Mobile:</strong> <?= $data['mobile'] ?></div>
        <div><strong>NID:</strong> <?= $data['nid'] ?></div>
        <div><strong>DOB:</strong> <?= $data['dob'] ?></div>
        <div><strong>Gender:</strong> <?= ucfirst($data['gender']) ?></div>

        <hr>

        <div><strong>Route:</strong> <?= $data['from_station'] ?> → <?= $data['to_station'] ?></div>
        <div><strong>Journey Date:</strong> <?= $data['journey_date'] ?></div>
        <div><strong>Tickets:</strong> <?= $data['ticket_quantity'] ?></div>
        <div><strong>Total Price:</strong> ৳<?= number_format($data['total_price']) ?></div>
    </div>

    <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>

</div>

</body>
</html>
