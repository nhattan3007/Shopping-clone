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
            // dùng trim() để tránh lỗi do người dùng nhập thừa dấu cách.
            // Nhiều lỗi sai mật khẩu hoặc username là do người dùng copy/paste có khoảng trắng không nhìn thấy.

            // phần Post này sẽ lấy giá trị từ form đăng ký nên phải đúng tên các trường trong form.
            $fullname = trim($_POST['fullname']); // FullName thành fullname
            $username = trim($_POST['username']); // UserName thành username
            $password = trim($_POST['password']); // Password thành password
            $confirmpassword = trim($_POST['confirm_password'] ?? ''); // ConfirmPassword thành confirm_password

            // Thêm debug để kiểm tra giá trị nhớ tắt nếu ko cần thiết
            // error_log("Password: " . $password);
            // error_log("Confirm Password: " . $conformPassword);
            // error_log("Length Password: " . strlen($password));
            // error_log("Length Confirm: " . strlen($conformPassword));

            // dùng strcmp() cho so sánh chính xác giá trị chuỗi (string).
            if (strcmp($password, $confirmpassword) !== 0) {
                $_SESSION['register_error'] = "Wrong password";
                header("Location: " . $baseURL . 'User/register');
                exit;
            }

            $userModel = new UserModel();
            $userId = $userModel->createUser($username, $password, $fullname);

            $_SESSION['userid'] = $userId;
            $_SESSION['username'] = $username;

            header("Location: " . $baseURL . 'home/index');
            exit;
        }
        // Nếu không phải là POST request, hiển thị form đăng ký
        include 'App/Views/User/Register.php';
    }

    // Phương thức đăng nhập người dùng
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $config = require './config.php';
        $baseURL = $config['baseURL'];

        // nhan POST request từ form đăng nhập
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? ''); // dùng ?? để tránh lỗi nếu không có trường này
            $password = trim($_POST['password'] ?? '');

            // Kiểm tra người dùng trong cơ sở dữ liệu
            $userModel = new UserModel();
            $users = $userModel->getUserByUserName($username);

            // so sánh password với password đã mã hóa trong database
            // nếu đúng lưu thông tin vào $_SESSION và chyên hướng về home/index
            // nếu sai thì lưu thông báo lỗi vào $_SESSION và chuyển hướng về user/login
            if ($users && password_verify($password, $users['Password'])) {
                // đăng nhập success
                // đăng nhập thành công, lưu thông tin vào session
                $_SESSION['userid'] = $users['UserId']; // lưu id người dùng vào session
                $_SESSION['username'] = $users['UserName']; // lưu tên người dùng vào session
                $_SESSION['fullname'] = $users['FullName']; // lưu tên đầy đủ người dùng vào session

                // chuyển hướng về trang chủ
                header("Location: " . $baseURL . 'Home/index');
                exit;
            } else {
                // đăng nhập thất bại
                $_SESSION['login_error'] = "Invalid username or password";
                header("Location: " . $baseURL . 'User/login');
                exit;
            }
        }
        // nếu là get request thì hiện thị ra form đăng nhập
        include 'App/Views/User/Login.php';
    }

    // Phương thức xử lý đăng xuất
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset(); // xóa tất cả các biến trong $_SESSION
        session_unset(); // Hủy file session trên server

        // unset($_SESSION['user_id']);
        // unset($_SESSION['username']);

        // quay lại trang trang chủ
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
