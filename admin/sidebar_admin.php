<div class="sidebar">
    <h4 class="sidebar-title">Trang tổng quan</h4>
    <ul class="sidebar-menu">
        <!-- <li>
            <a href="admin.php?page=overview" class="<?php echo ($page === 'overview') ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                <span>Tổng quan</span>
            </a>
        </li> -->
        <li>
            <a href="?page=admin_parking" class="<?php echo ($page === 'admin_parking') ? 'active' : ''; ?>">
                <i class="fas fa-car"></i>
                <span>Quản lý bãi xe</span>
            </a>
        </li>
        <li>
            <a href="?page=admin_user" class="<?php echo ($page === 'admin_user') ? 'active' : ''; ?>">
                <i class="fas fas fa-user"></i>
                <span>Quản lý tài khoản</span>
            </a>
        </li>
        <li>
            <a href="?page=admin_booking" class="<?php echo ($page === 'admin_booking') ? 'active' : ''; ?>">
                <i class="fas fas fa-calendar-alt"></i>
                <span>Lịch sử đặt chỗ</span>
            </a>
        </li>
        <li>
            <a href="?page=admin_bookingextensions" class="<?php echo ($page === 'admin_bookingextensions') ? 'active' : ''; ?>">
                <i class="fas fa-ticket-alt"></i>
                <span>Lịch sử gia hạn đặt chỗ</span>
            </a>
        </li>
        <li>
            <a href="../layout/index.php" class="text-danger">
                <i class="fas fa-sign-out-alt"></i>
                <span>Đăng xuất</span>
            </a>
        </li>
    </ul>
</div>

<style>
    .sidebar {
        background-color: #ffffff; /* Nền trắng cho sidebar */
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar-title {
        color: #333;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li {
        margin-bottom: 10px;
    }

    .sidebar-menu li a {
        display: block;
        padding: 10px 15px;
        text-decoration: none;
        color: #555;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .sidebar-menu li a:hover {
        background-color: #f0f0f0;
        color: #007bff;
    }

    .sidebar-menu li a i {
        margin-right: 10px;
    }

    .sidebar-menu li a.active {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }

    .sidebar-menu li a.active:hover {
        background-color: #0056b3;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .text-danger:hover {
        color: #bd2130 !important;
    }
</style>