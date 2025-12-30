<?php
session_start();

// Include DAO
include_once '../dao/bookings.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $user_id = $_POST['user_id'];
    $parking_id = $_POST['parking_id'];
    $start_time = $_POST['start_time'];
    $duration_hours = $_POST['duration_hours'];
    $pricePerHour = $_POST['pricePerHour'];
    $status = $_POST['status'];
    $total_fee = $duration_hours * $pricePerHour; // Tính toán lại tổng phí

    try {
        booking_update(
            $booking_id,
            $user_id,
            $parking_id,
            $start_time,
            $duration_hours,
            $pricePerHour,
            $status,
            $total_fee
        );
        $_SESSION['message'] = "Cập nhật thông tin đặt chỗ thành công!";
        $_SESSION['message_type'] = "success";
    } catch (PDOException $e) {
        $_SESSION['message'] = "Có lỗi xảy ra khi cập nhật thông tin đặt chỗ.";
        $_SESSION['message_type'] = "danger";
        $_SESSION['error_detail'] = "Lỗi database: " . $e->getMessage();
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