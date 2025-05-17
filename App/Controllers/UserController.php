<?php
require_once __DIR__ . "/../Models/UserModel.php";
require_once __DIR__ . "/../../Core/PHPMailer/Mailer.php";

class UserController
{
    public function register()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = '';

        $config = require './config.php';
        $baseURL = $config['baseURL'];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['FullName'];
            $username = $_POST['UserName'];
            $password = $_POST['Password'];
            $conformPassword = $_POST['ConfirmPassword'] ?? '';
            if ($password !== $conformPassword) {
                $_SESSION['register_error'] = "Wrong password";
                header("Location: " . $baseURL . 'User/register');
                exit;
            } else {
                $userModel = new UserModel();
            }
            $userId = $userModel->createUser($username, $password, $fullname);

            $_SESSION['userid'] = $userId;
            $_SESSION['username'] = $username;

            header("Location: " . $baseURL . 'home/index');
            exit;
        }
        // Nếu không phải là POST request, hiển thị form đăng ký
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

            $pdo = new PDO("mysql:host=localhost;dbname=shopqst", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $config = require 'config.php';

                $baseURL = $config['baseURL'];
                header("Location: " . $baseURL . 'home/index'); // về trang chủ
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
            }
        }
        include 'App/Views/User/Login.php';
    }
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        $config = require 'config.php';

        $baseURL = $config['baseURL'];
        header("Location: " . $baseURL . 'home/index'); // về trang chủ
        exit;
    }
    public function contact()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userName = htmlspecialchars($_POST['name']);
            $userEmail = htmlspecialchars($_POST['email']);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);

            $adminEmail = "nguyenminhson13231@gmail.com"; // Email admin
            $emailSubject = "Liên hệ từ $userName";

            // Nội dung email đẹp
            $emailBody = "<h3>Thông tin liên hệ</h3>
                          <p><strong>Tên:</strong> $userName</p>
                          <p><strong>Email:</strong> $userEmail</p>
                          <p><strong>Tiêu đề:</strong> $subject</p>
                          <p><strong>Nội dung:</strong><br>$message</p>";

            if (Mailer::sendMail($adminEmail, $emailSubject, $emailBody)) {
                $_SESSION['contact_success'] = "Cảm ơn bạn đã liên hệ!";
            } else {
                $_SESSION['contact_error'] = "Gửi email thất bại. Vui lòng thử lại!";
            }

            $config = require './config.php';
            $baseURL = $config['baseURL'];

            header("Location: " . $baseURL . "user/contact");
            exit();
        }

        include 'App/Views/User/Contact.php';
    }
}
