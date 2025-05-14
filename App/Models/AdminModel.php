<?php 
require_once __DIR__ . "/../../Core/db.php";

class AdminModel{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
}

?>