<?php
require_once __DIR__ . "/../Models/ProductModel.php";

class ProductController
{
    public function index(){
        $product = new productModel();
        $productList = $product -> getAllProducts();
        include "App/Views/Product/Index.php";
    }
}
