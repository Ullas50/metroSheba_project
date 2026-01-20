<?php
require_once __DIR__ . '/../core/db.php';


// Payment model class
class Payment
{  // Store database connection
    private $conn;
// Create database connection on object creation
    public function __construct()
    {
        $this->conn = getConnection();
    }
// Get passenger details by user ID
    public function getPassenger($userId)
    {
        $stmt = $this->conn->prepare(
            "SELECT full_name, email, mobile FROM users WHERE id=?"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
        // Get full booking passenger details
    public function getBookingDetails($bookingId, $userId)
    {   // Prepare booking details query
        $stmt = $this->conn->prepare("
            SELECT 
                b.ticket_quantity,
                b.total_price,
                b.journey_date,
                b.journey_time,
                s1.station_name AS from_station,
                s2.station_name AS to_station
            FROM bookings b
            JOIN stations s1 ON b.from_station_id = s1.id
            JOIN stations s2 ON b.to_station_id = s2.id
            WHERE b.id = ?
              AND b.user_id = ?
        ");
        // Bind booking ID and user ID
        $stmt->bind_param("ii", $bookingId, $userId);
        $stmt->execute(); // Execute query
        return $stmt->get_result()->fetch_assoc(); // Return booking details
    }
// Get ticket details by booking ID and user ID
    public function getTicketByBooking($bookingId, $userId)
    {   // Prepare ticket details query
        $stmt = $this->conn->prepare("
            SELECT // Select relevant ticket and passenger fields
                b.id AS booking_id,
                b.ticket_quantity,
                b.journey_date,
                b.journey_time,
                b.confirmed_at,
                s1.station_name AS from_station,
                s2.station_name AS to_station,
                u.full_name,
                u.email,
                u.mobile
            FROM bookings b
            JOIN stations s1 ON b.from_station_id = s1.id
            JOIN stations s2 ON b.to_station_id = s2.id
            JOIN users u ON b.user_id = u.id
            WHERE b.id = ?
              AND b.user_id = ?
              AND b.booking_status = 'confirmed'
        ");
// Bind booking ID and user ID
        $stmt->bind_param("ii", $bookingId, $userId);
        $stmt->execute();// Execute query
        return $stmt->get_result()->fetch_assoc();// Return ticket details
    }
    // Create payment record
    public function createPayment(int $bookingId, string $method, int $amount)
    {// Generate unique transaction ID
        $transactionId = uniqid('TXN_', true);

        $stmt = $this->conn->prepare( // Prepare insert query
            "INSERT INTO payments
             (booking_id, payment_method, transaction_id, paid_amount, payment_status)
             VALUES (?, ?, ?, ?, 'success')"
        );
        // Bind booking ID, method, transaction ID, and amount
        $stmt->bind_param("issi", $bookingId, $method, $transactionId, $amount);
        return $stmt->execute();
    }

    public function confirmBooking(int $bookingId)
    { // Prepare update query
        $stmt = $this->conn->prepare(
            "UPDATE bookings
             SET booking_status = 'confirmed', // Set confirmed status and timestamp
                 confirmed_at = NOW()
             WHERE id = ?"
        );

        $stmt->bind_param("i", $bookingId); // Bind booking ID  
        return $stmt->execute();
    }
        // Get purchase history for a user
 public function getPurchaseHistory($userId)
{ // Prepare purchase history query
    $stmt = $this->conn->prepare("
        SELECT 
            b.id AS booking_id,
            b.journey_date,
            b.ticket_quantity,
            b.confirmed_at,
            s1.station_name AS from_station,
            s2.station_name AS to_station,
            p.paid_amount,
            p.payment_method
        FROM bookings b
        INNER JOIN payments p 
            ON p.booking_id = b.id
           AND p.payment_status = 'success'
        JOIN stations s1 ON b.from_station_id = s1.id
        JOIN stations s2 ON b.to_station_id = s2.id
        WHERE b.user_id = ?
          AND b.booking_status = 'confirmed'
        ORDER BY b.confirmed_at DESC
    ");

    $stmt->bind_param("i", $userId); // Bind user ID
    $stmt->execute(); // Execute query
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);        // Return purchase history
}


}