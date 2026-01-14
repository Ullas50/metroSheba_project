<?php
require_once __DIR__ . '/../core/db.php';

class Booking {

    private $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function getStationOrder($id) {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT station_order FROM stations WHERE id=?"
        );
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($res);

        return $row['station_order'];
    }

    public function createBooking($userId, $from, $to, $qty, $total, $date) {
        $stmt = mysqli_prepare(
            $this->conn,
            "INSERT INTO bookings 
            (user_id, from_station_id, to_station_id, ticket_quantity, total_price, journey_date, booking_status)
            VALUES (?, ?, ?, ?, ?, ?, 'pending')"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iiiiis",
            $userId,
            $from,
            $to,
            $qty,
            $total,
            $date
        );

        mysqli_stmt_execute($stmt);
        return mysqli_insert_id($this->conn);
    }
}
