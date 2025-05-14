<?php
require_once __DIR__ . "/../Models/OrderModel.php";

class OrderController{
    public function index()
    {
        include "App/view/admin/index.php";
    }
}