<?php
require_once __DIR__ . '/../core/db.php';

class SellerSale {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function create($seller, $from, $to, $qty, $date, $total, $paid) {
        $stmt = $this->conn->prepare(
            "INSERT INTO seller_sales
            (seller_id, from_station_id, to_station_id, ticket_quantity, journey_date, total_price, paid_amount)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param("iiiisii",
            $seller, $from, $to, $qty, $date, $total, $paid
        );

        return $stmt->execute();
    }
}
