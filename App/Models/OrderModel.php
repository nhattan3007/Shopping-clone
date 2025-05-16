<?php
require_once __DIR__ . "/../../Core/db.php";

class OrderModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
    //nhập đơn đặt hàng từ home đến khách hàng
    public function insertOrder($order_date, $user_id, $total_amount)
    {
        $sql = "INSERT INTO orders (OrderDate, UserId, total_amount,status) VALUES (?, ?, ?,'Đặt Hàng')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$order_date, $user_id, $total_amount]);
        return $this->db->lastInsertId();
    }
    // cập nhập tổng đơn hàng
    public function updateOrderTotal($orderId, $totalAmount)
    {
        $sql = "UPDATE orders SET total_amount = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$totalAmount, $orderId]);
    }
    //nhập dữ liệu đơn hàng
    public function insertOrderItem($orderId, $productId, $quantity, $price)
    {
        $sql = "INSERT INTO orderitems (OrderId, ProductId, quantity, price)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$orderId, $productId, $quantity, $price]);
    }
    //sấp xếp đơn hàng theo ngày
    public function getOrdersByUserId($userId)
    {
        $sql = "SELECT * FROM orders WHERE UserId = ? ORDER BY OrderDate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //lấy đơn hàng từ khách hàng
    public function getAllOrdersWithUser()
    {
        $sql = "SELECT orders.*, users.fullname 
                FROM orders 
                LEFT JOIN users ON orders.user_id = users.id 
                ORDER BY orders.order_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //cập nhật trạng thái của đơn hàng
    public function updateStatus($orderId, $newStatus)
    {
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$newStatus, $orderId]);
    }
    //lấy đơn hàng trong 7 ngày gần nhất
    public function getOrderCountPerDay($days = 7)
    {
        $stmt = $this->db->prepare("
            SELECT DATE(order_date) as order_day, COUNT(*) as order_count
            FROM orders
            WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL :days DAY)
            GROUP BY order_day
            ORDER BY order_day ASC
        ");
        $stmt->bindValue(':days', $days, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
