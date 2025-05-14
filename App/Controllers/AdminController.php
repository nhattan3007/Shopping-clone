<?php
require_once __DIR__ . "/../Models/AdminModel.php";

class AdminController{
    public function index()
    {
        include "App/view/admin/index.php";
    }
}