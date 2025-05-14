<?php
require_once __DIR__ . "/../Models/UserModel.php";

class UserController{
    public function index()
    {
        include "App/view/admin/index.php";
    }
}