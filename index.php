<?php
//Đặt Controller tại đây->
require_once __DIR__ . "/App/Controllers/AdminController.php";
require_once __DIR__ . "/App/Controllers/CartController.php";
require_once __DIR__ . "/App/Controllers/CheckoutController.php";
require_once __DIR__ . "/App/Controllers/HomeController.php";
require_once __DIR__ . "/App/Controllers/UserController.php";
require_once __DIR__ . "/App/Controllers/ProductController.php";
require_once __DIR__ . "/App/Controllers/OrderController.php";


$url = $_GET['url'] ?? 'product/product'; // Mặc định trang sản phẩm

$urlArr = explode('/', $url);

// Kiểm tra controller và method có tồn tại không
$controllerName = $urlArr[0] . 'Controller';
$method = $urlArr[1] ?? 'product';
$param = $urlArr[2] ?? null; // lấy id nếu có

if (class_exists($controllerName) && method_exists($controllerName, $method)) {
    $controller = new $controllerName();

    if ($param) {
        call_user_func([$controller, $method], $param); // gọi method với tham số
    } else {
        call_user_func([$controller, $method]);
    }
} else {
    echo "404 - Không tìm thấy controller hoặc method.";
}
?>