<?php
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include DAO
include_once '../dao/bookings.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['booking_id_to_delete']) && is_numeric($_POST['booking_id_to_delete'])) {
        $booking_id_to_delete = $_POST['booking_id_to_delete'];

        try {
            booking_delete($booking_id_to_delete);
            $_SESSION['message'] = "Xóa đặt chỗ thành công!";
            $_SESSION['message_type'] = "success";
        } catch (PDOException $e) {
            $_SESSION['message'] = "Có lỗi xảy ra khi xóa đặt chỗ.";
            $_SESSION['message_type'] = "danger";
            $_SESSION['error_detail'] = "Lỗi database: " . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = "ID đặt chỗ không hợp lệ.";
        $_SESSION['message_type'] = "warning";
    }

    header("Location: admin_bookings.php");
    exit();
} else {
    $_SESSION['message'] = "Phương thức không hợp lệ!";
    $_SESSION['message_type'] = "warning";
    header("Location: admin_bookings.php");
    exit();
}
?>