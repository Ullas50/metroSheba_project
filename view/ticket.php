<!DOCTYPE html>
<html>
<head>
    <title>Ticket</title>
</head>
<body>

<h2>MetroSheba Ticket</h2>

<p><b>Name:</b> <?= htmlspecialchars($_SESSION['ticket_view']['user']['full_name']) ?></p>
<p><b>Route:</b>
<?= $_SESSION['ticket_view']['booking']['from_station'] ?>
 →
<?= $_SESSION['ticket_view']['booking']['to_station'] ?>
</p>

<p><b>Purchased:</b> <?= $_SESSION['ticket_view']['purchaseTime'] ?></p>
<p><b>Valid Until:</b> <?= $_SESSION['ticket_view']['validUntil'] ?></p>

<p>
<?= $_SESSION['ticket_view']['isExpired']
    ? '<span style="color:red">Ticket Expired</span>'
    : '<span style="color:green">Ticket Valid</span>' ?>
</p>

<img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=<?= urlencode($_SESSION['ticket_view']['qrData']) ?>">

<br><br>
<button onclick="window.print()">Print</button>
<a href="logout.php">Logout</a>

</body>
</html>
