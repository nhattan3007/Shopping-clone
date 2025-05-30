<?php

class CartController
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Phương thức thêm sản phẩm vào giỏ hàng
    public function add()
    {
        // kiểm tra sản phẩm có trong giỏ hàng chưa, nếu có thì tặng quantity
        // thêm sản phẩm vào giỏ hàng
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ProductId'])) {
            $productId = (int)$_POST['ProductId'];
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;


            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['ProductId'] == $productId) {
                    $item['quantity'] += $quantity; // Tăng số lượng
                    $found = true;
                    break;
                }
            }

            // Nếu sản phẩm chưa có trong giỏ, thêm mới
            if (!$found) {
                $_SESSION['cart'][] = [
                    'ProductId' => $productId,
                    'quantity' => $quantity
                ];
            }

            // Kiểm tra có phải là Ajax request không
            if (
                !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            ) {

                // Tính lại tổng quantity
                $totalQuantity = CartController::getTotalQuantity();

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                    'totalQuantity' => $totalQuantity
                ]);
                exit;
            }

            // Nếu không phải Ajax thì redirect như cũ
            $config = require 'config.php';
            $baseURL = $config['baseURL'];
            $referer = $_SERVER['HTTP_REFERER'] ?? $baseURL . 'home/index';
            header('Location: ' . $referer);
            exit;
        }

        // if (
        //     $_SERVER['REQUEST_METHOD'] === 'POST'
        //     && isset($_POST['product_id'])
        // ) {
        //     $productId = $_POST['product_id'];

        //     if (!isset($_SESSION['cart'])) {
        //         $_SESSION['cart'] = [];
        //     }

        //     if (isset($_SESSION['cart'][$productId])) {
        //         $_SESSION['cart'][$productId]['quantity'] += 1;
        //     } else {
        //         $_SESSION['cart'][$productId] = [
        //             'product_id' => $productId,
        //             'quantity' => 1
        //         ];
        //     }

        //     $config = require 'config.php';
        //     $baseURL = $config['baseURL'];

        //     header('Location:' . $baseURL . '/home/index');
        //     exit;
        // }
    }

    // Phưởng thức hiện thị giỏ hàng 
    public function index()
    {
        $productModel = new productModel();
        $cartItems = [];
        $totalPrice = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                // Lấy thông tin sản phẩm từ database
                $product = $productModel->getProductById($cartItem['ProductId']);

                if ($product) {
                    $cartItems[] = [
                        'ProductId' => $cartItem['ProductId'],
                        'ProductName' => $product['ProductName'],
                        'Price' => $product['Price'],
                        'quantity' => $cartItem['quantity']
                    ];
                }

                // if ($product) {
                //     // Thêm quantity vào thông tin sản phẩm
                //     $product['quantity'] = $cartItem['quantity'];
                //     $product['subtotal'] = $product['Price'] * $cartItem['quantity'];
                //     $totalPrice += $product['subtotal'];

                //     $cartItems[] = $product;
                // }
            }
        }

        // Truyền dữ liệu cho view
        $config = require 'config.php';
        $baseURL = $config['baseURL'];

        include 'App/Views/Cart/index.php';
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ProductId'], $_POST['quantity'])) {
            $productId = (int)$_POST['ProductId'];
            $quantity = (int)$_POST['quantity'];

            if ($quantity <= 0) {
                // Nếu quantity <= 0, xóa sản phẩm khỏi giỏ
                $this->remove($productId);
                return;
            }

            // Cập nhật số lượng
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['ProductId'] == $productId) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }

            $config = require 'config.php';
            $baseURL = $config['baseURL'];
            header('Location: ' . $baseURL . 'cart/index');
            exit;
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($productId = null)
    {
        if ($productId === null && isset($_POST['ProductId'])) {
            $productId = (int)$_POST['ProductId'];
        }

        if ($productId) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($productId) {
                return $item['ProductId'] != $productId;
            });

            // Reset array keys
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }

        $config = require 'config.php';
        $baseURL = $config['baseURL'];
        header('Location: ' . $baseURL . 'cart/index');
        exit;
    }

    // Xóa toàn bộ giỏ hàng
    public function clear()
    {
        $_SESSION['cart'] = [];

        $config = require 'config.php';
        $baseURL = $config['baseURL'];
        header('Location: ' . $baseURL . 'cart/index');
        exit;
    }

    // Lấy tổng số lượng sản phẩm trong giỏ (để hiển thị trên nav)
    public static function getTotalQuantity()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            return 0;
        }

        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['quantity'];
        }

        return $total;
    }

    // Lấy số lượng items trong giỏ (số loại sản phẩm khác nhau)
    public static function getTotalItems()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    }

    // public function index()
    // {
    //     require_once 'App/Models/ProductModel.php';
    //     $productModel = new ProductModel();
    //     if (session_status() === PHP_SESSION_NONE) {
    //         session_start();
    //     }

    //     $cartItems = [];
    //     if (isset($_SESSION['cart'])) {
    //         foreach ($_SESSION['cart'] as $product) {
    //             // Fetch product details from the database using the Product ID from the session
    //             $products =  $productModel->getProductById($product['ProductId']);

    //             // Add the quantity from the session cart to the product details fetched from the database
    //             $products['quantity'] = $product['quantity'];

    //             // Add the combined product details to the cart items array
    //             $cartItems[] =  $products;
    //         }
    //     }
    //     include './App/Views/Cart/Index.php';
    // }
}
