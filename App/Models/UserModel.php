<?php 
require_once __DIR__ . "/../../Core/db.php";

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
    //lấy các người dùng để xem xét đang nhập
    public function getAllUsers()
    {
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY UserId ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //tạo người dùng mới với hashpassword **hash password là mã hóa hóa password 1 chiều để chặng đánh cấp dữ liệu
    public function createUser($fullname, $username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (FullName, UserName, Password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fullname, $username, $hashedPassword]);
        return $this->db->lastInsertId();
    }
    
}

?>