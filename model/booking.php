<?php
require_once __DIR__ . '/../core/db.php'; // database connection

class Booking { // Booking model class

    private $conn; // Store database connection
    // Create database connection on object creation
    public function __construct() {
        $this->conn = getConnection();
    }
    
    // Get station order number by station ID
    public function getStationOrder($id) {
        $stmt = mysqli_prepare(        

            $this->conn,
            "SELECT station_order FROM stations WHERE id=?"
        );  
        // Bind station ID as integer
        mysqli_stmt_bind_param($stmt, "i", $id);
        // Execute query
        mysqli_stmt_execute($stmt);
        // Get result set
        $res = mysqli_stmt_get_result($stmt);
         // Fetch single row
        $row = mysqli_fetch_assoc($res);

        return $row['station_order']; // Return station order value
    }
       // Create a new booking record
    public function createBooking($userId, $from, $to, $qty, $total, $date) {
    $stmt = mysqli_prepare(
            $this->conn,
            "INSERT INTO bookings 
            (user_id, from_station_id, to_station_id, ticket_quantity, total_price, journey_date, booking_status)
            VALUES (?, ?, ?, ?, ?, ?, 'pending')"
        );
        // Bind booking values to query
        mysqli_stmt_bind_param(
            $stmt,
            "iiiiis", 
            $userId, // user id
            $from, // from station id
            $to, // to station ID
            $qty, // ticket quantity
            $total,  // total price
            $date // journey date
        );
        // Execcute query
        mysqli_stmt_execute($stmt);
        // Return newly created booking ID
        return mysqli_insert_id($this->conn);
    }
    // Save selected payment method for pending booking
    public function savePaymentMethod($bookingId, $method) {
    $stmt = $this->conn->prepare(  
        "UPDATE bookings 
         SET payment_method = ? 
         WHERE id = ? AND booking_status = 'pending'" 
    );
     // Bind payment account, amount, and booking ID
    $stmt->bind_param("si", $method, $bookingId);
    return $stmt->execute();

    
}
 // Get pending booking details by booking ID
public function getPendingBooking($bookingId) {
    $stmt = $this->conn->prepare(
        "SELECT id, total_price, payment_method 
         FROM bookings 
         WHERE id=? AND booking_status='pending'"
    );
    // Bind booking ID
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();    // Execute query
    return $stmt->get_result()->fetch_assoc();   // Return booking data
}
     // Save payment details and mark booking as paid
public function savePayment($bookingId, $account, $amount) {
$stmt = $this->conn->prepare(
        "UPDATE bookings 
         SET payment_account=?, paid_amount=?, booking_status='paid' 
         WHERE id=?"
    );
     // Bind payment account, amount, and booking ID
    $stmt->bind_param("sii", $account, $amount, $bookingId);
    return $stmt->execute();  // Execute update
}

}