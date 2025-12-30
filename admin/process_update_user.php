<?php
session_start();

// Kiểm tra quyền admin
// ...

// Include DAO
include_once '../dao/user-accounts.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $address = $_POST['address'] ?? null;
    $profile_pic = $_POST['profile_pic'] ?? null;

    try {
        user_account_update(
            $user_id,
            $username,
            $email,
            $full_name,
            $phone,
            $address,
            $profile_pic
        );
        $_SESSION['message'] = "Cập nhật thông tin người dùng thành công!";
        $_SESSION['message_type'] = "success";
    } catch (PDOException $e) {
        $_SESSION['message'] = "Có lỗi xảy ra khi cập nhật thông tin người dùng.";
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