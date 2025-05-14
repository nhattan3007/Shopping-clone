<?php
require_once __DIR__ . "/../Models/ProductModel.php";

class ProductController{
    public function index()
    {
        include "App/view/admin/index.php";
    }
}