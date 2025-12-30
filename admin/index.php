<?php
// Bắt đầu session (nếu chưa có)
session_start();

// Lấy giá trị của tham số 'page' từ URL, mặc định là 'overview' nếu không có
$page = $_GET['page'] ?? 'admin_parking';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị - SKT Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile.css">
    </head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include 'sidebar_admin.php'; ?>
            </div>
            <div class="col-md-10">
                <?php
                switch ($page) {
                    case 'overview':
                        // include 'overview.php'; // Trang tổng quan (nếu có)
                        echo "<h2>Tổng quan trang quản trị</h2>";
                        break;
                    case 'admin_parking':
                        include 'admin_parking.php'; // Include file quản lý bãi xe
                        break;
                    case 'admin_user':
                        include 'admin_user.php'; // Trang quản lý tài khoản (nếu có)
                        break;
                    case 'admin_booking':
                        include 'admin_booking.php'; // Trang lịch sử đặt chỗ (nếu có)
                        break;
                    case 'admin_bookingextensions':
                        include 'admin_booking_extensions.php'; // Trang quản lý tài khoản (nếu có)
                        break;
                    // Các case khác cho các mục menu khác
                    default:
                        echo "<h2>Chào mừng đến trang quản trị!</h2>";
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/profile.js"></script>
    </body>
</html>