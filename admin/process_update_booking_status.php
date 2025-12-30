<?php
session_start();

// Include DAO
include_once '../dao/bookings.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['booking_id']) && is_numeric($_POST['booking_id']) && isset($_POST['status'])) {
        $booking_id = $_POST['booking_id'];
        $new_status = $_POST['status'];

        try {
            booking_update_status($booking_id, $new_status);
            $_SESSION['message'] = "Cập nhật trạng thái đặt chỗ thành công!";
            $_SESSION['message_type'] = "success";
        } catch (PDOException $e) {
            $_SESSION['message'] = "Có lỗi xảy ra khi cập nhật trạng thái đặt chỗ.";
            $_SESSION['message_type'] = "danger";
            $_SESSION['error_detail'] = "Lỗi database: " . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = "Dữ liệu không hợp lệ.";
        $_SESSION['message_type'] = "warning";
    }

    header("Location: ../admin/?page=admin_booking");
    exit();
} else {
    $_SESSION['message'] = "Phương thức không hợp lệ!";
    $_SESSION['message_type'] = "warning";
    header("Location: ../admin/?page=admin_booking");
    exit();
}
?>