<?php
require_once __DIR__ . "/../Models/UserModel.php";

class UserController{
    public function register()
    {
       
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }

        $error = '';
        
        $config = require './config.php';
        $baseURL = $config['baseURL'];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $userModel = new UserModel();
            $userId = $userModel->createUser($fullname, $username, $password);
            
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;

            header("Location: " . $baseURL. 'home/index');
             exit;

        }
       include 'App/Views/User/Register.php';
    }
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $pdo = new PDO("mysql:host=localhost;dbname=productdb", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $config = require 'config.php';
            
                $baseURL = $config['baseURL'];
                header("Location: " . $baseURL.'home/index'); // về trang chủ
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
            }
        }
        include 'App/Views/User/Login.php';
    }
    public function logout(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        $config = require 'config.php';
        
        $baseURL = $config['baseURL'];
        header("Location: " . $baseURL.'home/index'); // về trang chủ
        exit;
    }
    // public function contract()
    // {
    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $userName = htmlspecialchars($_POST['name']);
    //         $userEmail = htmlspecialchars($_POST['email']);
    //         $subject = htmlspecialchars($_POST['subject']);
    //         $message = htmlspecialchars($_POST['message']);

    //         $adminEmail = "nguyenminhson13231@gmail.com"; // Email admin
    //         $emailSubject = "Liên hệ từ $userName";

    //         // Nội dung email đẹp
    //         $emailBody = "<h3>Thông tin liên hệ</h3>
    //                       <p><strong>Tên:</strong> $userName</p>
    //                       <p><strong>Email:</strong> $userEmail</p>
    //                       <p><strong>Tiêu đề:</strong> $subject</p>
    //                       <p><strong>Nội dung:</strong><br>$message</p>";

    //         if (Mailer::sendMail($adminEmail, $emailSubject, $emailBody)) {
    //             $_SESSION['contact_success'] = "Cảm ơn bạn đã liên hệ!";
    //         } else {
    //             $_SESSION['contact_error'] = "Gửi email thất bại. Vui lòng thử lại!";
    //         }
    //         $config = require './config.php';
    //         $baseURL = $config['baseURL'];

    //         header("Location: " . $baseURL."user/contract");
    //         exit();
    //     }
        
    //     include 'App/view/user/contract.php';
    // }
}