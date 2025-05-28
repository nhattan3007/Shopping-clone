<?php
require_once __DIR__ . "/../Models/ProductModel.php";

class ProductController
{
    public function index()
    {
        $product = new productModel();
        $productList = $product->getAllProducts();
        include "App/Views/Product/Index.php";
    }

    public function detail()
    {
        // check if productid parameter exists
        if (!isset($_GET['productid']) || empty($_GET['productid'])) {
            echo "ProductId is not found.";
            return;
        }

        $productModel = new productModel();
        $product = $productModel->getProductById($_GET['productid']);

        // Check if product exists
        if (!$product) {
            echo "Product not found!";
            return;
        }


        include "App/Views/Product/detail.php";
    }
}
