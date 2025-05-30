<?php
require_once __DIR__ . "/../Models/ProductModel.php";
class HomeController
{

    public function index()
    {
        $productModel = new productModel();
        $productList = $productModel->getAllProducts();
        include "./App/Views/Home/Index.php";
    }
}
