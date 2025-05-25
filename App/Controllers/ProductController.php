<?php
require_once __DIR__ . "/../Models/ProductModel.php";

class ProductController
{
    public function index(){
        $product = new productModel();
        $productList = $product -> getAllProducts();
        include "App/Views/Product/Index.php";
    }
    public function detail(){
        if (session_status()===PHP_SESSION_NONE)
        {
            session_start();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' 
            && isset($_POST['ProductId'])) {
            $productId = $_POST['ProductId'];
            $productModel = new ProductModel();
            $product = $productModel->getProductById($productId);

            $config = require 'config.php';
            $baseURL = $config['baseURL'];
        }
    include "App/Views/Product/Detail.php";
    }
}
