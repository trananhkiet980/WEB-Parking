<?php
session_start();

// Kiểm tra quyền admin
// ...

// Include DAO
include_once '../dao/user-accounts.php';

// Lấy ID người dùng từ URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_users.php");
    exit();
}

$user_id = $_GET['id'];

// Lấy thông tin người dùng dựa trên ID
$user = user_account_select_by_id($user_id);

if (!$user) {
    header("Location: admin_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Người Dùng - SKT Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_users.css">
    <style>
        /* Thêm CSS tùy chỉnh nếu cần */
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Sửa Thông Tin Người Dùng</h2>
        <form action="process_update_user.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="username" class="form-label" style="color: black;">Tên Đăng Nhập:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: black;">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="full_name" class="form-label" style="color: black;">Họ và Tên:</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label" style="color: black;">Số Điện Thoại:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="address" class="form-label" style="color: black;">Địa Chỉ:</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="profile_pic" class="form-label" style="color: black;">Ảnh Đại Diện:</label>
                        <input type="text" class="form-control" id="profile_pic" name="profile_pic" value="<?php echo htmlspecialchars($user['profile_pic']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email_verified_at" class="form-label" style="color: black;">Ngày Xác Minh Email:</label>
                        <input type="text" class="form-control" id="email_verified_at" name="email_verified_at" value="<?php echo htmlspecialchars($user['email_verified_at']); ?>" readonly>
                        <small class="form-text text-muted">Không thể chỉnh sửa trực tiếp.</small>
                    </div>
                    
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
            <a href="../admin/?page=admin_user" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>