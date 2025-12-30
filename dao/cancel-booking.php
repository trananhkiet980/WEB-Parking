<?php
require_once 'pdo.php';
require_once 'bookings.php'; // Đảm bảo file bookings.php được include

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['booking_id'])) {
        $bookingId = $_POST['booking_id'];

        try {
            // Kiểm tra xem booking có tồn tại không (tùy chọn)
            if (!booking_exists($bookingId)) {
                echo "Không tìm thấy đặt chỗ với ID: " . $bookingId;
                exit();
            }

            // Thực hiện xóa booking bằng hàm đã định nghĩa trong bookings.php
            booking_update_status($bookingId, "cancelled");
            echo "Hủy đặt chỗ thành công!";

        } catch (PDOException $e) {
            echo "Lỗi hủy đặt chỗ: " . $e->getMessage();
        }

    } else {
        echo "Thiếu booking_id trong yêu cầu POST.";
    }
} else {
    echo "Phương thức yêu cầu không hợp lệ.";
}
?>