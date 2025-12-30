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
    $name = $_POST['name'];
    $address = $_POST['address'];
    $capacity = $_POST['capacity'];
    $pricePerHour = $_POST['pricePerHour'];
    $operating_hours = $_POST['operating_hours'];
    $image_url = $_POST['image_url'];
    $district = $_POST['district'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longtitude'];
    $status = $_POST['status'];

    // Giá trị mặc định cho occupied_slots khi thêm mới
    $occupied_slots = 0;

    // Thực hiện thêm bãi đỗ xe mới
    try {
        parking_lot_insert(
            $name,
            $address,
            $capacity,
            $pricePerHour,
            $operating_hours,
            $status,
            $image_url,
            $district,
            $latitude,
            $longitude,
            $occupied_slots // Thêm occupied_slots vào đây
        );
        $_SESSION['message'] = "Thêm bãi xe thành công!";
        $_SESSION['message_type'] = "success";
    } catch (PDOException $e) {
        $_SESSION['message'] = "Có lỗi xảy ra khi thêm bãi xe.";
        $_SESSION['message_type'] = "danger";
        // Ghi lỗi chi tiết vào log server để debug (khuyến nghị)
        error_log('Lỗi thêm bãi xe: ' . $e->getMessage());
        // Hiển thị thông báo lỗi chi tiết (chỉ trong môi trường phát triển)
        // echo 'Lỗi thêm bãi xe: ' . $e->getMessage();
    }

    header("Location: ../admin/?page=admin_parking"); // Chuyển hướng về trang quản lý bãi xe
    exit();
} else {
    // Nếu không phải phương thức POST
    $_SESSION['message'] = "Phương thức không hợp lệ!";
    $_SESSION['message_type'] = "warning";
    // echo 'Method not allowed.'; // Không nên echo trực tiếp khi chuyển hướng
    header("Location: ../admin/?page=admin_parking");
    exit();
}
?>