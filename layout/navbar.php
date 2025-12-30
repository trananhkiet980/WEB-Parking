<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy trang hiện tại từ URL
$current_page = basename($_SERVER['PHP_SELF']);

function displayAuthButton() {
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header("Location: index.php"); 
        exit();
    }

    $output = '<div class="dropdown ms-3">';
    if (isset($_SESSION['user_id'])) {
        $username = htmlspecialchars($_SESSION['username'] ?? 'Nguyễn Văn A'); // Lấy username từ session, mặc định là Nguyễn Văn A nếu không có
        $output .= '<a href="#" class="btn-login dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">';
        $output .= '<i class="fas fa-user-circle me-2"></i>' . $username;
        $output .= '</a>';
        $output .= '<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="userDropdown">';
        $output .= '<li><a class="dropdown-item active" href="profile.php?page=personal"><i class="fas fa-user me-2"></i>Thông tin cá nhân</a></li>';
        $output .= '<li><a class="dropdown-item" href="profile.php?page=currentBooking"><i class="fas fa-ticket-alt me-2"></i>Bãi xe đã đặt</a></li>';
        $output .= '<li><a class="dropdown-item" href="profile.php?page=historyBooking"><i class="fas fa-ticket-alt me-2"></i>Lịch sử đặt chỗ</a></li>';
        $output .= '<li><a class="dropdown-item" href="profile.php?page=notifications"><i class="fas fa-bell me-2"></i>Thông báo <span class="badge bg-danger rounded-pill ms-2">3</span></a></li>';
        $output .= '<li><hr class="dropdown-divider"></li>';
        $output .= '<li><a class="dropdown-item" href="?logout=true"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>';
        $output .= '</ul>';
    } else {
        $output .= '<a href="login.html" class="btn btn-primary btn-login ms-3">Đăng nhập</a>';
    }
    $output .= '</div>';

    return $output;
}
?>
<link rel="stylesheet" href="./css/navbar.css">
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="img/logo.png" alt="SKT Parking Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="about.php">Giới thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'parking.php') ? 'active' : ''; ?>" href="parking.php">Bãi xe</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="contact.php">Liên hệ</a>
                </li>
            </ul>
            <?php echo displayAuthButton(); ?>
        </div>
    </div>
</nav>