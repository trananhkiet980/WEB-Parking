<?php
session_start();


// Include DAO
include_once '../dao/user-accounts.php';
include_once '../dao/bookings.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id_to_delete']) && is_numeric($_POST['user_id_to_delete'])) {
        $user_id_to_delete = $_POST['user_id_to_delete'];

        try {
            booking_delete_by_user_id($user_id_to_delete); 
            user_account_delete($user_id_to_delete);
            $_SESSION['message'] = "Xóa người dùng thành công!";
            $_SESSION['message_type'] = "success";
        } catch (PDOException $e) {
            $_SESSION['message'] = "Có lỗi xảy ra khi xóa người dùng.";
            $_SESSION['message_type'] = "danger";
            $_SESSION['error_detail'] = "Lỗi database: " . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = "ID người dùng không hợp lệ.";
        $_SESSION['message_type'] = "warning";
    }

    header("Location: ../admin/?page=admin_user");
    exit();
} else {
    $_SESSION['message'] = "Phương thức không hợp lệ!";
    $_SESSION['message_type'] = "warning";
    header("Location: ../admin/?page=admin_user");
    exit();
}
?>