<?php
require_once __DIR__ . '/../core/db.php';

class Payment {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function createPayment($bookingId, $method, $amount) {
        $txn = uniqid("TXN_");

        $stmt = $this->conn->prepare(
            "INSERT INTO payments
             (booking_id, payment_method, transaction_id, paid_amount)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("issi", $bookingId, $method, $txn, $amount);
        return $stmt->execute();
    }

    public function getPassenger($userId) {
        $stmt = $this->conn->prepare(
            "SELECT full_name, email, mobile FROM users WHERE id=?"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getBookingDetails($bookingId, $userId) {
        $stmt = $this->conn->prepare("
            SELECT b.*, 
                   s1.station_name AS from_station,
                   s2.station_name AS to_station
            FROM bookings b
            JOIN stations s1 ON b.from_station_id = s1.id
            JOIN stations s2 ON b.to_station_id = s2.id
            WHERE b.id=? AND b.user_id=?
        ");
        $stmt->bind_param("ii", $bookingId, $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
