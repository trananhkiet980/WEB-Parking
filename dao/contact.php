PHP

<?php
// contact.php

// Bao gồm file pdo.php để sử dụng các hàm PDO
include 'pdo.php';

// Kiểm tra xem form đã được submit hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $user_id = $_POST["user_id"] ?? '';
    $ho_ten = $_POST["ho_ten"] ?? '';
    $email = $_POST["email"] ?? '';
    $so_dien_thoai = $_POST["so_dien_thoai"] ?? '';
    $ban_la = $_POST["user_type"] ?? '';
    $noi_dung = $_POST["noi_dung"] ?? '';

    // Giả sử bạn đã có user_id của người dùng đang đăng nhập
    // Bạn cần thay thế giá trị này bằng cách lấy user_id thực tế từ session hoặc hệ thống xác thực của bạn
    $user_id = 123; // Ví dụ user_id

    // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào bảng 'contact'
    $sql = "INSERT INTO contact (user_id, ho_ten, email, so_dien_thoai, ban_la, noi_dung, thoi_gian_gui)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

    try {
        // Thực thi câu lệnh SQL sử dụng hàm pdo_execute từ pdo.php
        pdo_execute($sql, $user_id, $ho_ten, $email, $so_dien_thoai, $ban_la, $noi_dung);

        // Nếu chèn dữ liệu thành công, bạn có thể hiển thị thông báo thành công hoặc chuyển hướng người dùng
        echo "<script>alert('Tin nhắn của bạn đã được gửi thành công!'); window.location.href = 'thank_you.php';</script>";
        exit(); // Dừng việc thực thi script sau khi chuyển hướng
    } catch (PDOException $e) {
        // Nếu có lỗi trong quá trình chèn dữ liệu
        echo "<script>alert('Đã có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.');</script>";
        echo "Lỗi: " . $e->getMessage();
    }
}
?>