<?php
class UserModel {
    public $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function getAllData() {
        $sql = "SELECT * FROM users";
        $query = $this->db->pdo->query($sql);
        $result = $query->fetchAll();
        return $result;
    }
    public function isEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function addUserToDB($deshPath) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $role = $_POST['role'];
        $image = $deshPath;
        $now = date('Y-m-d H:i:s');

        if ($this->isEmailExists($email)) {
            throw new Exception("Email đã tồn tại trong hệ thống. Vui lòng chọn email khác.");
        }
        $sql = "INSERT INTO users (name, email, password, address, phone, image, created_at, updated_at, role) 
                VALUES (:name, :email, :password, :address, :phone, :image, :created_at, :updated_at, :role)";
        
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':created_at', $now);
        $stmt->bindParam(':updated_at', $now);

        return $stmt->execute();
    }
}