<?php

class CartController
{
    // Phương thức thêm sản phẩm vào giỏ hàng
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['product_id'])
        ) {
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

            header('Location:' . $baseURL . '/home/index');
            exit;
        }
    }

    // Phưởng thức hiện thị giỏ hàng 
    public function index()
    {
        require_once 'App/Models/ProductModel.php';
        $productModel = new ProductModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $cartItems = [];
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product) {
                // Fetch product details from the database using the Product ID from the session
                $products =  $productModel->getProductById($product['ProductId']);

                // Add the quantity from the session cart to the product details fetched from the database
                $products['quantity'] = $product['quantity'];

                // Add the combined product details to the cart items array
                $cartItems[] =  $products;
            }
        }
        include './App/Views/Cart/Index.php';
    }
}
