<?php
function getConnection() {

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "metrosheba";   // ⚠️ MUST MATCH YOUR DATABASE NAME EXACTLY

    $conn = mysqli_connect($host, $user, $pass, $db);

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    mysqli_set_charset($conn, "utf8mb4");

    return $conn;
}
