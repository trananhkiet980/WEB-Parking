<?php
session_start();

// Include file DAO
require_once '../dao/user-accounts.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        // Truy vấn người dùng theo email
        $user = user_account_select_by_email($email);

        if ($user) {
            // Kiểm tra trạng thái email_verified_at
            if ($user['email_verified_at'] !== null) {
                // Email đã được xác thực, kiểm tra mật khẩu
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['profile_pic'] = $user['profile_pic'] ?: 'default-avatar.png';
                    echo "Đăng nhập thành công";
                    exit();
                } else {
                    echo "Tài khoản hoặc mật khẩu không đúng"; // Thông báo chung
                }
            } else {
                echo "Tài khoản email chưa được xác thực. Vui lòng kiểm tra hộp thư đến của bạn để xác nhận.";
            }
        } else {
            echo "Tài khoản hoặc mật khẩu không đúng"; // Thông báo chung
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>