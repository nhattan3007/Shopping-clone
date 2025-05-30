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
    public function insertOrder($orderDate, $userId, $totalAmount)
    {
        try {
            $sql = "INSERT INTO orders (OrderDate, UserId, TotalAmount,Status) VALUES (?, ?, ?,'Đặt Hàng')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderDate, $userId, $totalAmount]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi tạo đơn hàng: " . $e->getMessage());
        }
    }

    // cập nhập tổng đơn hàng
    public function updateOrderTotal($orderId, $totalAmount)
    {
        $sql = "UPDATE orders SET TotalAmount = ? WHERE OrderId = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$totalAmount, $orderId]);
    }

    //nhập dữ liệu đơn hàng
    public function insertOrderItem($orderId, $productId, $quantity, $price)
    {
        try {
            $sql = "INSERT INTO orderitems (OrderId, ProductId, Quantity, Price) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$orderId, $productId, $quantity, $price]);
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi thêm chi tiết vào đơn hàng: " . $e->getMessage());
        }
    }

    // Lấy danh sách đơn hàng theo user ID
    public function getOrdersByUserId($userId)
    {
        try {
            $sql = "SELECT * FROM orders WHERE UserId = ? ORDER BY OrderDate DESC, OrderId DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi lấy danh sách đơn hàng: " . $e->getMessage());
        }
    }

    // Lấy thông tin đơn hàng theo ID
    public function getOrderById($orderId)
    {
        try {
            $sql = "SELECT * FROM orders WHERE OrderId = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi lấy thông tin đơn hàng: " . $e->getMessage());
        }
    }

    // Lấy chi tiết đơn hàng
    public function getOrderItems($orderId)
    {
        try {
            $sql = "SELECT oi.*, p.ProductName 
                    FROM orderitems oi 
                    JOIN products p ON oi.ProductId = p.id 
                    WHERE oi.OrderId = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi lấy chi tiết đơn hàng: " . $e->getMessage());
        }
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


    // Cập nhật trạng thái đơn hàng
    public function updateStatus($orderId, $status)
    {
        try {
            $sql = "UPDATE orders SET Status = ? WHERE OrderId = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $orderId]);
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi cập nhật trạng thái: " . $e->getMessage());
        }
    }

    // Lấy tất cả đơn hàng (dành cho admin)
    public function getAllOrders()
    {
        try {
            $sql = "SELECT o.*, u.UserName 
                    FROM orders o 
                    JOIN users u ON o.UserId = u.UserId 
                    ORDER BY o.OrderDate DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi lấy tất cả đơn hàng: " . $e->getMessage());
        }
    }

    // Xóa đơn hàng
    public function deleteOrder($orderId)
    {
        try {
            $this->db->beginTransaction();

            // Xóa chi tiết đơn hàng trước
            $sql = "DELETE FROM OrderItems WHERE OrderId = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderId]);

            // Xóa đơn hàng
            $sql = "DELETE FROM orders WHERE OrderId = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$orderId]);

            $this->db->commit();
            return $result;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new Exception("Lỗi khi xóa đơn hàng: " . $e->getMessage());
        }
    }

    // Thống kê doanh thu theo tháng
    public function getMonthlyRevenue($year)
    {
        try {
            $sql = "SELECT MONTH(OrderDate) as month, SUM(TotalAmount) as revenue 
                    FROM orders
                    WHERE YEAR(OrderDate) = ? AND status != 'Hủy Đơn'
                    GROUP BY MONTH(OrderDate)
                    ORDER BY month";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$year]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi lấy thống kê doanh thu: " . $e->getMessage());
        }
    }

    // Đếm số đơn hàng theo trạng thái
    public function countOrdersByStatus()
    {
        try {
            $sql = "SELECT Status, COUNT(*) as count FROM orders GROUP BY Status";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi đếm đơn hàng theo trạng thái: " . $e->getMessage());
        }
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
    public function getOrderCountPerMonth($months = 7)
    {   
        $stmt = $this->db->prepare("
            SELECT DATE_FORMAT(OrderDate, '%Y-%m') as order_month, COUNT(*) as order_count
            FROM orders
            WHERE OrderDate >= DATE_SUB(CURDATE(), INTERVAL :months MONTH)
            GROUP BY order_month
            ORDER BY order_month ASC
        ");
        $stmt->bindValue(':months', $months, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getRevenuePerWeek($weeks = 8)
    {
        $stmt = $this->db->prepare("
            SELECT 
                YEAR(OrderDate) as order_year,
                WEEK(OrderDate, 1) as order_week, -- 1: tuần bắt đầu từ Thứ 2
                SUM(TotalAmount) as total_revenue
            FROM orders
            WHERE OrderDate >= DATE_SUB(CURDATE(), INTERVAL :weeks WEEK)
            GROUP BY order_year, order_week
            ORDER BY order_year ASC, order_week ASC
        ");
        $stmt->bindValue(':weeks', $weeks, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
