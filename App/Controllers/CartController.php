<?php

class CartController{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' 
            && isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] += 1;
            } else {
                $_SESSION['cart'][$productId] = [
                    'product_id' => $productId,
                    'quantity' => 1
                ];
            }
            $config = require 'config.php';
            
            $baseURL = $config['baseURL'];
           

            header('Location:'. $baseURL.'/Product/index');
            exit;
        }
    }
    public function index()
    {
        require_once 'App/Models/ProductModel.php';
        $productModel = new ProductModel();
        if (session_status() === PHP_SESSION_NONE) {
           session_start();
        }

        $cartItems =[];
        if (isset($_SESSION['cart']))
        {
            foreach($_SESSION['cart'] as $product)
            {
                $products =  $productModel->getProductById($product['Product_id']);
                $products['quantity'] = $product['quantity'];
                $cartItems[] =  $products;
            }
        }
        include './App/Views/Cart/Index.php';
    }
}