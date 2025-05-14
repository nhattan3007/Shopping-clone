<?php 
require_once __DIR__ . "/../../Core/db.php";

class UserModel{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
}

?>