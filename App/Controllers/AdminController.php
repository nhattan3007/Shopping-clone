<?php
require_once __DIR__ . "/../Models/AdminModel.php";

class AdminController{
    public function index()
    {
        include "App/Views/Admin/Index.php";
    }
    public function orderManagement()
    {
        require_once __DIR__ . '/../../Model/orderModel.php';
        $orderModel = new OrderModel();
        $orders = $orderModel->getAllOrdersWithUser();
        $config = require __DIR__ . '/../../config.php';
        $baseURL = $config['baseURL'];
        include __DIR__ . '/../view/admin/ordermanage.php';
    }
    public function report()
    {
        require_once __DIR__ . '/../../Model/orderModel.php';
        $orderModel = new OrderModel();
        $ordersPerDay = $orderModel->getOrderCountPerDay(7); // Truyền vào index view

        include __DIR__ . '/../view/admin/report.php';
      
    }
}