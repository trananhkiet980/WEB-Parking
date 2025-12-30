<?php
session_start();

// Kiểm tra quyền admin
// ...

// Include DAO
include_once '../dao/user-accounts.php';

function generateVerificationToken($length = 32) {
    return bin2hex(random_bytes($length));
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Cần được mã hóa trước khi lưu!
    $full_name = $_POST['full_name'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $address = $_POST['address'] ?? null;
    $profile_pic = $_POST['profile_pic'] ?? null;

    // Mã hóa mật khẩu (sử dụng password_hash)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $email_verification_token = generateVerificationToken();
    
    try {
        user_account_insert(
            $username,
            $email,
            $hashed_password,
            $profile_pic,
            $email_verification_token
        );
        $_SESSION['message'] = "Thêm người dùng thành công!";
        $_SESSION['message_type'] = "success";
    } catch (PDOException $e) {
        $_SESSION['message'] = "Có lỗi xảy ra khi thêm người dùng.";
        $_SESSION['message_type'] = "danger";
        $_SESSION['error_detail'] = "Lỗi database: " . $e->getMessage();
    }

    header("Location: ../admin/?page=admin_user");
    exit();
} else {
    $_SESSION['message'] = "Phương thức không hợp lệ!";
    $_SESSION['message_type'] = "warning";
    header("Location: ../admin/?page=admin_user");
    exit();
}
?>