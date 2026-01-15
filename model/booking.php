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

    public function savePaymentMethod($bookingId, $method) {
    $stmt = $this->conn->prepare(
        "UPDATE bookings 
         SET payment_method = ? 
         WHERE id = ? AND booking_status = 'pending'"
    );

    $stmt->bind_param("si", $method, $bookingId);
    return $stmt->execute();

    
}

public function getPendingBooking($bookingId) {
    $stmt = $this->conn->prepare(
        "SELECT id, total_price, payment_method 
         FROM bookings 
         WHERE id=? AND booking_status='pending'"
    );
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

public function savePayment($bookingId, $account, $amount) {
    $stmt = $this->conn->prepare(
        "UPDATE bookings 
         SET payment_account=?, paid_amount=?, booking_status='paid'
         WHERE id=?"
    );
    $stmt->bind_param("sii", $account, $amount, $bookingId);
    return $stmt->execute();
}

}



