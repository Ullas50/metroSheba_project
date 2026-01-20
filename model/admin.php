<?php
// Include database connection file
require_once __DIR__ . '/../core/db.php';



// Admin model class
class Admin {
    private $conn;   // Store database connection
 // Create database connection when object is created
    public function __construct() {
        $this->conn = getConnection();
    }

       // Get all confirmed passenger bookings
    public function getPassengers() {
    $sql = "
        SELECT 
            b.id AS booking_id,
            u.full_name,
            u.email,
            s1.station_name AS from_station,
            s2.station_name AS to_station,
            b.journey_date,
            b.ticket_quantity,
            b.total_price
        FROM bookings b
        JOIN users u ON u.id = b.user_id
        JOIN stations s1 ON s1.id = b.from_station_id
        JOIN stations s2 ON s2.id = b.to_station_id
        WHERE b.booking_status = 'confirmed'
          AND u.role = 'customer'
        ORDER BY b.id DESC
    ";

        // Return all rows as array
    return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
}


      // Get all paid seller ticket sales
    public function getSellerTickets() {
        $sql = "
            SELECT
                s.id AS sale_id,
                u.full_name AS seller_name,
                u.email,
                st1.station_name AS from_station,
                st2.station_name AS to_station,
                s.ticket_quantity,
                s.total_price
            FROM seller_sales s
            JOIN users u ON u.id = s.seller_id
            JOIN stations st1 ON st1.id = s.from_station_id
            JOIN stations st2 ON st2.id = s.to_station_id
            WHERE s.payment_status = 'paid'
            ORDER BY s.id DESC
        ";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);    // Return sales data
    }

     // Delete a passenger booking
    public function deleteBooking($id) {
        $this->conn->begin_transaction();    // Start database transaction
        try {
            // Delete related payment record
            $stmt = $this->conn->prepare("DELETE FROM payments WHERE booking_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt = $this->conn->prepare("DELETE FROM bookings WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Undo changes if error occurs
            $this->conn->rollback();
            return false;
        }
    }

    // Delete a seller ticket sale
    public function deleteSellerSale($id) {
        $stmt = $this->conn->prepare("DELETE FROM seller_sales WHERE id = ?");    // Prepare delete query
        $stmt->bind_param("i", $id);
        return $stmt->execute();    // Execute delete
    }

    // Get sales grouped by route
    public function getRouteSales() {
        $sql = "
            SELECT
                s1.station_name AS from_station,
                s2.station_name AS to_station,
                SUM(tickets) AS tickets_sold,
                SUM(revenue) AS revenue
            FROM (
                SELECT from_station_id, to_station_id,
                       ticket_quantity AS tickets,
                       total_price AS revenue
                FROM bookings
                WHERE booking_status = 'confirmed'

                UNION ALL

                SELECT from_station_id, to_station_id,
                       ticket_quantity,
                       total_price
                FROM seller_sales
                WHERE payment_status = 'paid'
            ) x
            JOIN stations s1 ON s1.id = x.from_station_id
            JOIN stations s2 ON s2.id = x.to_station_id
            GROUP BY x.from_station_id, x.to_station_id
            ORDER BY revenue DESC
        ";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);  // Return route sales data
    }

    // Get total revenue from all sales
    public function getGrandTotal() {
        $sql = "
            SELECT SUM(total_price) AS total
            FROM (
                SELECT total_price FROM bookings WHERE booking_status='confirmed'
                UNION ALL
                SELECT total_price FROM seller_sales WHERE payment_status='paid'
            ) all_sales
        ";
        return (int)$this->conn->query($sql)->fetch_assoc()['total']; // Return total revenue
    }

 // Get full passenger booking details
    public function getPassengerDetails($bookingId) { 
    $stmt = $this->conn->prepare(" 
        SELECT
            u.full_name,
            u.email,
            u.mobile,
            u.nid,
            u.dob,
            u.gender,
            u.photo,

            b.id AS booking_id,
            b.journey_date,
            b.ticket_quantity,
            b.total_price,

            s1.station_name AS from_station,
            s2.station_name AS to_station

        FROM bookings b
        JOIN users u ON u.id = b.user_id
        JOIN stations s1 ON s1.id = b.from_station_id
        JOIN stations s2 ON s2.id = b.to_station_id

        WHERE b.id = ?
        LIMIT 1
    ");

    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc(); // Return passenger data
}
 // Get full seller sale details
public function getSellerSaleDetails($saleId) {
    $stmt = $this->conn->prepare(" 
        SELECT
            u.full_name,
            u.email,
            u.mobile,
            u.nid,
            u.gender,
            u.photo,

            s.id AS sale_id,
            s.ticket_quantity,
            s.total_price,
            s.sold_at,

            st1.station_name AS from_station,
            st2.station_name AS to_station

        FROM seller_sales s
        JOIN users u ON u.id = s.seller_id
        JOIN stations st1 ON st1.id = s.from_station_id
        JOIN stations st2 ON st2.id = s.to_station_id

        WHERE s.id = ?
        LIMIT 1
    ");

    $stmt->bind_param("i", $saleId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc(); // Return seller sale data
}


}
