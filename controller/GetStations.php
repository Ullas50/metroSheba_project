<?php
require_once '../core/db.php';

$conn = getConnection();

$result = mysqli_query(
    $conn,
    "SELECT id, station_name, station_order FROM stations ORDER BY station_order"
);

$stations = [];

while ($row = mysqli_fetch_assoc($result)) {
    $stations[] = $row;
}

header("Content-Type: application/json");
echo json_encode($stations);