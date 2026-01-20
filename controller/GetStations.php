<?php
require_once '../core/db.php';

$conn = getConnection();//database connection

$result = mysqli_query( // all stations, ordered by their sequence
    $conn,
    "SELECT id, station_name, station_order FROM stations ORDER BY station_order"
);

$stations = [];

while ($row = mysqli_fetch_assoc($result)) {
    $stations[] = $row;  //add each station to the array
}

header("Content-Type: application/json");//return the station data as JSON
echo json_encode($stations);