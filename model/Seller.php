<?php
require_once __DIR__ . '/../core/db.php'; // database connection

class Seller {
    // Store database connection
    private $conn;

    public function __construct() {
        // Create database connection on object creation
        $this->conn = getConnection();
    }
    // Get ticket details by sale ID
    public function getTicketBySale($saleId) {
        $stmt = $this->conn->prepare( // Prepare ticket details query
            "SELECT // Select relevant ticket and seller fields
                ss.id,
                ss.journey_date,
                ss.ticket_quantity,
                ss.total_price,
                u.full_name AS seller_name,
                u.mobile AS seller_mobile,
                u.email AS seller_email,
                fs.station_name AS from_station,
                ts.station_name AS to_station,
                ss.created_at
             FROM seller_sales ss
             JOIN users u ON u.id = ss.seller_id
             JOIN stations fs ON fs.id = ss.from_station_id
             JOIN stations ts ON ts.id = ss.to_station_id
             WHERE ss.id = ?"
        );
        // Bind sale ID
        $stmt->bind_param("i", $saleId);
        $stmt->execute(); // Execute query
        return $stmt->get_result()->fetch_assoc(); //   Return ticket details
    }
}
