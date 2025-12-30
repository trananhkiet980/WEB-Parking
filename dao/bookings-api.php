<?php
// bookings-api.php

require_once 'bookings.php';

session_start();
$user_Id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parking_id = isset($_POST['parking_id']) ? $_POST['parking_id'] : null;
    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : null;
    $duration_hours = isset($_POST['duration_hours']) ? $_POST['duration_hours'] : null;
    $pricePerHour = isset($_POST['pricePerHour']) ? $_POST['pricePerHour'] : null;
    $total_fee = isset($_POST['total_fee']) ? $_POST['total_fee'] : null;

    if ($user_Id === null) {
        echo "Lỗi: Chưa đăng nhập.";
        exit();
    }

    if ($parking_id === null) {
        echo "Lỗi: Thiếu thông tin parking_id.";
        exit();
    }

    try {
        // Kiểm tra xem đã có booking nào tồn tại cho user_id và parking_id hay chưa
        $existingBooking = booking_check_exists($user_Id, $parking_id, 'active'); // Thêm trạng thái 'active' để chỉ kiểm tra các booking hiện tại

        if ($existingBooking) {
            echo "Bạn đã đặt bãi xe này rồi. Vui lòng kiểm tra bãi xe của tôi.";
            exit();
        }

        // Nếu không có booking nào tồn tại, tiến hành thêm booking mới
        booking_insert($user_Id, $parking_id, $start_time, $duration_hours, $pricePerHour, 'active', $total_fee);
        echo "Đặt chỗ thành công";
        exit();
    } catch (PDOException $e) {
        echo "Lỗi lưu thông tin đặt chỗ: " . $e->getMessage();
    }
} else {
    echo "Phương thức không được hỗ trợ.";
}


?>