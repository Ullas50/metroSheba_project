<?php
session_start();
require_once '../model/Admin.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$admin = new Admin();
$passengers = $admin->getPassengers();
$sellers    = $admin->getSellerTickets();
$routes     = $admin->getRouteSales();
$grandTotal = $admin->getGrandTotal();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/admin.css">
    <link rel="stylesheet" href="../public/css/home.css">
</head>

<body>
    <?php include 'partials/header3.php'; ?>
<br><br>
    <div class="dashboard-container">

        <!-- ================= TOP RIGHT STATS ================= -->
        <div class="top-stats">
            <div class="stat-card green">
                <div class="stat-left">
                    <span class="stat-icon">💵</span>
                    <div>
                        <small>Total Tickets Sold</small>
                        <h3><?= array_sum(array_column($routes, 'tickets_sold')) ?></h3>
                    </div>
                </div>
                <div class="stat-right">
                    <?= array_sum(array_column($routes, 'tickets_sold')) ?>
                </div>
            </div>

            <div class="stat-card blue">
                <div class="stat-left">
                    <span class="stat-icon">💰</span>
                    <div>
                        <small>Total Revenue</small>
                        <h3>৳<?= number_format($grandTotal) ?></h3>
                    </div>
                </div>
                <div class="stat-right">
                    ৳<?= number_format($grandTotal) ?>
                </div>
            </div>

        </div>

        <!-- ================= PASSENGERS ================= -->
        <h2>Passenger Information</h2>

        <input
            type="text"
            id="searchInput"
            placeholder="Search passenger..."
            class="search-input" />
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Route</th>
                    <th>Journey Date</th>
                    <th>Ticket Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="passengerTable">
                <?php foreach ($passengers as $p): ?>
                    <tr id="p<?= $p['booking_id'] ?>">
                        <td><?= $p['booking_id'] ?></td>
                        <td><?= htmlspecialchars($p['full_name']) ?></td>
                        <td><?= $p['from_station'] ?> → <?= $p['to_station'] ?></td>
                        <td><?= $p['journey_date'] ?></td>
                        <td><?= $p['ticket_quantity'] ?></td>
                        <td>৳<?= number_format($p['total_price']) ?></td>
                        <td class="actions">
                            <button class="view-btn"
                                onclick="window.location.href='admin_passenger_view.php?id=<?= $p['booking_id'] ?>'">
                                View
                            </button>

                            <button class="delete-btn"
                                onclick="deleteBooking(<?= $p['booking_id'] ?>)">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- ================= SELLERS ================= -->
        <h2>Seller Sales</h2>

        <input
            type="text"
            id="sellerSearch"
            placeholder="Search seller..."
            class="search-input" />

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Seller Name</th>          
                    <th>Route</th>
                    <th>Tickets sold</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="sellerTable">
                <?php foreach ($sellers as $s): ?>
                    <tr id="s<?= $s['sale_id'] ?>">
                        <td><?= $s['sale_id'] ?></td>
                        <td><?= htmlspecialchars($s['seller_name']) ?></td>
                        <td><?= $s['from_station'] ?> → <?= $s['to_station'] ?></td>
                        <td><?= $s['ticket_quantity'] ?></td>
                        <td>৳<?= number_format($s['total_price']) ?></td>
                        <td class="actions">
                            <button class="view-btn"
                                onclick="window.location.href='admin_seller_view.php?id=<?= $s['sale_id'] ?>'">
                                View
                            </button>

                            <button class="delete-btn"
                                onclick="deleteSellerSale(<?= $s['sale_id'] ?>)">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- ================= TOTAL REVENUE ================= -->
        <h2>Total Revenue</h2>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Destination</th>
                    <th>Total Tickets sold</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>

            <tbody id="revenueTable">
                <?php foreach ($routes as $r): ?>
                    <tr>
                        <td><?= $r['from_station'] ?> → <?= $r['to_station'] ?></td>
                        <td><?= $r['tickets_sold'] ?></td>
                        <td>৳<?= number_format($r['revenue']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

           <tfoot>
    <tr>
        <td><strong>Total</strong></td>
        <td>
            <strong>
                <?= array_sum(array_column($routes, 'tickets_sold')) ?>
            </strong>
        </td>
        <td>
            <strong>
                ৳<?= number_format($grandTotal) ?>
            </strong>
        </td>
    </tr>
</tfoot>

        </table>

    </div>

    <button onclick="window.print()" class="print-btn">
        🖨 Print Report
    </button>

    <?php include 'partials/footer.php'; ?>

    <script src="../public/js/admin.js"></script>
</body>

</html>