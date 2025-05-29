<?php
require_once __DIR__ . "/../../Core/db.php";

class productModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
    //lấy và show sản phẩm ra các trang mong muốn
    public function getAllProducts()
    {
        $stmt = $this->db->prepare('SELECT * FROM products ORDER BY ProductId ASC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả kết quả về
    }
    // thêm sản phẩm vào database
    public function add($name, $price, $image)
    {
        $stmt = $this->db->prepare("INSERT INTO nameindata (Name, Price, Image) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, $image]);
    }
    //lấy sản phẩm từ ID
    public function getProductById($productid)
    {
        // sữ dụng try catch để bắt lỗi nếu có
        try {
            $sql = "SELECT * FROM products WHERE ProductId = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$productid]);
            return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về sản phẩm dưới dạng mảng kết hợp
        } catch (PDOException $e) {
            echo "Error fetching product by ID: " . $e->getMessage();
            return false;
        }
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM product WHERE ID = ?");

        $stmt->execute([$id]);
    }
}
