<?php
// Bắt đầu session (nếu chưa có)
session_start();

// Include DAO
include_once '../dao/parking-lots.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form modal
    $parking_id = $_POST['parking_id'];
    $new_status = $_POST['new_status'];

    // Thực hiện cập nhật trạng thái bãi xe
    try{
        parking_lot_update_status($parking_id, $new_status);
        $_SESSION['message'] = "Cập nhật trạng thái bãi xe thành công!";
        $_SESSION['message_type'] = "success";
    } 
    catch (PDOException $e) {
        $_SESSION['message'] = "Có lỗi xảy ra khi cập nhật trạng thái bãi xe thành công.";
        $_SESSION['message_type'] = "danger";
        echo 'Error extending booking: ' . $e->getMessage();
    }
    // Chuyển hướng trở lại trang quản lý bãi xe
    header("Location: ../admin/?page=admin_parking");
    exit();
} else {
    // Nếu không phải phương thức POST
    header("Location: ../admin/?page=admin_parking");
    exit();
}
?>