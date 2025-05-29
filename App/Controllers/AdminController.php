<?php
require_once __DIR__ . "/../Models/AdminModel.php";
require_once __DIR__ . '/../Models/OrderModel.php';

class AdminController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $dataArea = $orderModel->getRevenuePerWeek();
        $labels = array_map(function ($item) {
            return "Tuần " . $item['order_week'] . " (" . $item['order_year'] . ")";
        }, $dataArea);
        $revenues = array_column($dataArea, 'total_revenue');
        $dataBar = $orderModel->getOrderCountPerMonth();
        $months = array_column($dataBar, 'order_month');
        $monthsFormatted = array_map(function ($monthStr) {
            $dateObj = DateTime::createFromFormat('Y-m', $monthStr);
            return 'Tháng ' . (int)$dateObj->format('m') . '/' . $dateObj->format('Y');
        }, $months);
        $counts = array_column($dataBar, 'order_count');
        include "App/Views/Admin/Index.php";
    }
    public function orderManagement()
    {
        $orderModel = new OrderModel();
        $orders = $orderModel->getAllOrdersWithUser();
        $config = require __DIR__ . '/../../config.php';
        $baseURL = $config['baseURL'];
        include __DIR__ . '/../Views/Admin/Ordermanagement.php';
    }
    public function report()
    {
        $orderModel = new OrderModel();
        $ordersPerDay = $orderModel->getOrderCountPerDay(7); // Truyền vào index view
        include __DIR__ . '/../Views/Admin/Report.php';
    }
}
