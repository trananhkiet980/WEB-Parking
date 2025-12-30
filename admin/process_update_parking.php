<?php
// Bắt đầu session (nếu chưa có)
session_start();

// // Kiểm tra xem người dùng đã đăng nhập và có quyền admin hay chưa
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu không phải admin
//     exit();
// }

// Include DAO
include_once '../dao/parking-lots.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parking_id = $_POST['parking_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $capacity = $_POST['capacity'];
    $pricePerHour = $_POST['pricePerHour'];
    $operating_hours = $_POST['operating_hours'];
    $image_url = $_POST['image_url'];
    $district = $_POST['district'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $status = $_POST['status'];

    // Thực hiện cập nhật thông tin bãi xe
    try {
        parking_lot_update(
            $parking_id,
            $name,
            $address,
            $capacity,
            $pricePerHour,
            $operating_hours,
            $status,
            $image_url,
            $district,
            $latitude,
            $longitude
        );
        $_SESSION['message'] = "Cập nhật thông tin bãi xe thành công!";
        $_SESSION['message_type'] = "success";
    }
    catch (PDOException $e) {
        $_SESSION['message'] = "Có lỗi xảy ra khi cập nhật thông tin bãi xe.";
        $_SESSION['message_type'] = "danger";
        echo 'Error extending booking: ' . $e->getMessage();
    }

    header("Location: ../admin/?page=admin_parking"); // Chuyển hướng về trang quản lý bãi xe
    exit();
} else {
    // Nếu không phải phương thức POST
    $_SESSION['message'] = "Không phải POST!";
    echo 'Method not allowed.';
    header("Location: ../admin/?page=admin_parking");
    exit();
}
?>