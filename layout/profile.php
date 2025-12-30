<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Lấy tham số 'page' từ URL, mặc định là 'overview' nếu không có
$page = isset($_GET['page']) ? $_GET['page'] : 'overview';

// Ánh xạ giữa giá trị 'page' và file PHP tương ứng
$pageFiles = [
    'overview' => 'overview.php',
    'personal' => 'personalInfo.php',
    'currentBooking' => 'currentBooking.php',
    'historyBooking' => 'historyBooking.php',
    'payments' => 'payments.php',
    'notifications' => 'notifications.php',
    'settings' => 'settings.php',
    'logout' => 'logout.php' 
];

// Xác định file để include, mặc định là overview.php nếu không hợp lệ
$includeFile = isset($pageFiles[$page]) ? $pageFiles[$page] : 'overview.php';

// Xử lý đăng xuất
if ($page === 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
</body>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Khoản - SKT Parking</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome cho các biểu tượng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    
    <?php include 'navbar.php' ?>

    <!-- Account Header Section -->
    <section class="account-header">
        <div class="container">
            <h1 class="account-title">Quản Lý Tài Khoản</h1>
            <p class="account-subtitle">Quản lý thông tin cá nhân, xe và lịch sử đặt chỗ của bạn</p>
        </div>
    </section>

    <!-- Account Dashboard -->
    <section class="dashboard-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="sidebar">
                        <div class="user-profile">
                            <div class="user-online-status" title="Trực tuyến"></div>
                            <div class="user-avatar">
                                <img src="/api/placeholder/100/100" alt="User Avatar">
                                <div class="avatar-edit" title="Thay đổi ảnh đại diện" id="changeAvatarBtn">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <h4 class="user-name">Nguyễn Văn A</h4>
                            <p class="user-email">nguyenvana@gmail.com</p>
                            <span class="user-status">Thành viên VIP</span>
                        </div>

                        <h4 class="sidebar-title">Trang tổng quan</h4>
                        <ul class="sidebar-menu">
                            <!-- <li>
                                <a href="profile.php?page=overview" class="<?php echo ($page === 'overview') ? 'active' : ''; ?>">
                                    <i class="fas fa-home"></i>
                                    <span>Tổng quan</span>
                                </a>
                            </li> -->
                            <li>
                                <a href="profile.php?page=personal" class="<?php echo ($page === 'personal') ? 'active' : ''; ?>">
                                    <i class="fas fa-user"></i>
                                    <span>Thông tin cá nhân</span>
                                </a>
                            </li>
                            <li>
                                <a href="profile.php?page=currentBooking" class="<?php echo ($page === 'currentBooking') ? 'active' : ''; ?>">
                                    <i class="fas fa-car"></i>
                                    <span>Bãi xe của tôi</span>
                                </a>
                            </bladet>
                            <li>
                                <a href="profile.php?page=historyBooking" class="<?php echo ($page === 'historyBooking') ? 'active' : ''; ?>">
                                    <i class="fas fa-ticket-alt"></i>
                                    <span>Lịch sử đặt chỗ</span>
                                </a>
                            </li>
                            <li>
                                <a href="profile.php?page=notifications" class="<?php echo ($page === 'notifications') ? 'active' : ''; ?> notification-badge">
                                    <i class="fas fa-bell"></i>
                                    <span>Thông báo</span>
                                    <span class="badge bg-danger">3</span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="profile.php?page=settings" class="<?php echo ($page === 'settings') ? 'active' : ''; ?>">
                                    <i class="fas fa-cog"></i>
                                    <span>Cài đặt</span>
                                </a>
                            </li> -->
                            <li>
                                <a href="profile.php?page=logout" class="<?php echo ($page === 'logout') ? 'active' : ''; ?> text-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Đăng xuất</span>
                                </a>
                            </li>
                        </ul>
                    </div>       
                </div>
                <?php include $includeFile; ?>
            </div>
        </div>
    </section>
    

    <!-- Footer -->
    <?php include 'footer.php' ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <!-- Custom Script -->
    <script src="js/profile.js"></script>


</html>