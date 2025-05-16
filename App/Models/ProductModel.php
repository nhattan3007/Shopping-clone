<?php 
require_once __DIR__ . "/../../Core/db.php";

class ProductModel{
    private $db;
    
    public function __construct()
    {
        $this->db = Database::connect();
    }
    //lấy và show sản phẩm ra các trong mong muốn
    public function getAllProducts() {
        $stmt = $this->db->prepare('SELECT * FROM products ORDER BY ProductId ASC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả kết quả về
    }
    // thêm sản phẩm vào database
        public function add($name, $price, $image)
    {
        $stmt = $this->db->prepare("INSERT INTO Products (ProductName, Price, Image) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, $image]);
    }
    //lấy sản phẩm từ ID để thống kê
    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE ProductId = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE ProductId = ?");

        $stmt->execute([$id]);
    }
}

?>