<?php
session_start();



// Include DAO
include_once '../dao/booking-extension.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['extension_id_to_delete']) && is_numeric($_POST['extension_id_to_delete'])) {
        $extension_id_to_delete = $_POST['extension_id_to_delete'];

        try {
            booking_extension_delete($extension_id_to_delete);
            $_SESSION['message'] = "Xóa gia hạn đặt chỗ thành công!";
            $_SESSION['message_type'] = "success";
        } catch (PDOException $e) {
            $_SESSION['message'] = "Có lỗi xảy ra khi xóa gia hạn đặt chỗ.";
            $_SESSION['message_type'] = "danger";
            $_SESSION['error_detail'] = "Lỗi database: " . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = "ID gia hạn không hợp lệ.";
        $_SESSION['message_type'] = "warning";
    }

    header("Location: ../admin/?page=admin_bookingextensions");
    exit();
} else {
    $_SESSION['message'] = "Phương thức không hợp lệ!";
    $_SESSION['message_type'] = "warning";
    header("Location: ../admin/?page=admin_bookingextensions");
    exit();
}
?>