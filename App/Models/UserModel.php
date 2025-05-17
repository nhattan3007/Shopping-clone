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
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //tạo người dùng mới với hashpassword **hash password là mã hóa hóa password 1 chiều để chặng đánh cấp dữ liệu
    public function createUser($username, $password, $fullname)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Insert the new user into the database
        // Sử dụng prepared statement để tránh SQL injection
        $sql = "INSERT INTO users (UserName, Password, FullName) VALUES (?, ?, ?)"; // vì là đây là câu lệnh SQL nên phải ghi đúng tên trong bảng
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username, $hashedPassword, $fullname]);
        return $this->db->lastInsertId();
    }
}
