<?php

class HomeController{
    public function index()
    {
        $product = new productModel();
        $productList = $product -> getAllProducts();
        include "App/Views/Home/Index.php";
    }
}