<?php
require_once __DIR__ . "/../Models/OrderModel.php";
require_once __DIR__ . "/../Models/ProductModel.php";

class OrderController
{
    // echo "<pre>";
    // print_r($_SESSION['cart']);
    // echo "</pre>";
    // exit(); // Tạm thời để xem structure

    public function checkout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $config = require 'config.php';
        $baseURL = $config['baseURL'];

        // 1. Neu nguoi dung chua login ==>yeu cau login 
        if (!isset($_SESSION['userid'])) {
            header('Location:' . $baseURL . 'user/login');
            exit();
        }

        // debug
        // echo "<pre>";
        // print_r($_SESSION['cart']);
        // echo "</pre>";
        // exit();

        // 2. Tạo Order
        $orderModel = new OrderModel();
        $now = (new DateTime())->format('Y-m-d H:i:s');

        $productModel = new ProductModel();
        $total = 0;

        $orderId  = $orderModel->insertOrder($now, $_SESSION['userid'], 0);

        // 3. Tạo Order Detail
        foreach ($_SESSION['cart'] as $item) {
            $product = $productModel->getProductById($item['ProductId']);
            $orderModel->insertOrderItem(
                $orderId,
                $item['ProductId'],
                $item['quantity'],
                $product['Price']
            );
            $total += $item['quantity'] * $product['Price'];
        }
        $orderModel->updateOrderTotal($orderId, $total);

        // 4. Xoa gio hang
        unset($_SESSION['cart']);

        //5. Redirect về trang báo checkout thành công
        include __DIR__ . '/../Views/Checkout/checkout_success.php';
    }

    // Phương thức hiển thị lịch sử đơn hàng của người dùng
    public function history()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $config = require './config.php';
        $baseURL = $config['baseURL'];

        if (!isset($_SESSION['userid'])) { // đổi user_id thành userid
            header("Location: " . $baseURL . "user/login");
            exit;
        }

        $orderModel = new OrderModel();
        $orders = $orderModel->getOrdersByUserId($_SESSION['userid']);


        include 'App/Views/Checkout/history.php';
    }


    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['orderid'];
            $status = $_POST['status'];
            if (isset($status) && !empty($status)) {
                $orderModel = new OrderModel();
                $orderModel->updateStatus($orderId, $status);
            }
            $config = require './config.php';
            header('Location: ' . $config['baseURL'] . 'admin/orderManagement');
            exit();
        }
    }
}
