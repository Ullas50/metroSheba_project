<?php
require_once __DIR__ . '/../core/db.php'; // database connection
    // SellerSale model class
class SellerSale {
    private $conn; // Store database connection

    public function __construct() { // Create database connection on object creation
        $this->conn = getConnection();
    }
// Create a new seller sale record
    public function create($seller, $from, $to, $qty, $date, $total, $paid) {
        $stmt = $this->conn->prepare( // Prepare insert query
            "INSERT INTO seller_sales // Insert relevant sale fields
            (seller_id, from_station_id, to_station_id, ticket_quantity, journey_date, total_price, paid_amount)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
// Bind sale values to query
        $stmt->bind_param("iiiisii",
            $seller, $from, $to, $qty, $date, $total, $paid // sale values
        );

        return $stmt->execute(); // Execute query
    }
}
