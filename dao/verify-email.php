<?php
// Include file chứa các hàm PDO
require_once '../dao/pdo.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    try {
        // Tìm người dùng dựa trên token xác thực
        $sql = "SELECT user_id, email_verified_at FROM user_accounts WHERE email_verification_token = ?";
        $user = pdo_query_one($sql, $token);

        if ($user) {
            // Kiểm tra xem tài khoản đã được xác thực chưa
            if ($user['email_verified_at'] !== null) {
                $message = "Email của bạn đã được xác thực trước đó.";
                $success = true;
            } else {
                // Cập nhật trường email_verified_at trong cơ sở dữ liệu
                $current_time = date('Y-m-d H:i:s');
                $sql_update = "UPDATE user_accounts SET email_verified_at = ? WHERE user_id = ?";
                pdo_execute($sql_update, $current_time, $user['user_id']);

                // (Tùy chọn) Xóa token xác thực sau khi đã sử dụng
                $sql_update_token = "UPDATE user_accounts SET email_verification_token = NULL WHERE user_id = ?";
                pdo_execute($sql_update_token, $user['user_id']);

                $message = "Email của bạn đã được xác thực thành công! Bây giờ bạn có thể đăng nhập.";
                $success = true;
            }
        } else {
            $message = "Liên kết xác thực không hợp lệ hoặc đã hết hạn.";
            $success = false;
        }

    } catch (PDOException $e) {
        $message = "Lỗi khi xác thực email: " . $e->getMessage();
        $success = false;
    }
} else {
    $message = "Thiếu token xác thực.";
    $success = false;
}
?>