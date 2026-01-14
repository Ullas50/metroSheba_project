<?php
require_once __DIR__ . '/../core/db.php';

class Booking {
    private $conn;

    public function __construct() {
        $this->conn = getConnection(); // ✅ CORRECT
    }

    public function getStationOrder($id) {
        $stmt = $this->conn->prepare(
            "SELECT station_order FROM stations WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['station_order'];
    }

    public function createBooking($userId, $from, $to, $qty, $total, $date) {
        $stmt = $this->conn->prepare(
            "INSERT INTO bookings
            (user_id, from_station_id, to_station_id, ticket_quantity, total_price, journey_date, booking_status)
            VALUES (?, ?, ?, ?, ?, ?, 'pending')"
        );

        $stmt->bind_param(
            "iiiiis",
            $userId,
            $from,
            $to,
            $qty,
            $total,
            $date
        );

        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function confirmBooking($bookingId) {
        $stmt = $this->conn->prepare(
            "UPDATE bookings
             SET booking_status = 'confirmed',
                 journey_time = CURRENT_TIME
             WHERE id = ?"
        );
        $stmt->bind_param("i", $bookingId);
        return $stmt->execute();
    }
}
