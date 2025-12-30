<?php
session_start();


// Include DAO
include_once '../dao/bookings.php';
include_once '../dao/user-accounts.php'; // Để lấy danh sách người dùng
include_once '../dao/parking-lots.php'; // Để lấy danh sách bãi xe

// Lấy ID đặt chỗ từ URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_bookings.php");
    exit();
}

$booking_id = $_GET['id'];

// Lấy thông tin đặt chỗ dựa trên ID
$booking = booking_select_by_id($booking_id);

if (!$booking) {
    header("Location: admin_bookings.php");
    exit();
}

// Lấy danh sách tất cả người dùng và bãi xe để hiển thị trong dropdown
$users = user_account_select_all();
$parkingLots = parking_lot_select_all();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Đặt Chỗ - SKT Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_bookings.css">
    <style>
        /* Thêm CSS tùy chỉnh nếu cần */
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Sửa Thông Tin Đặt Chỗ</h2>
        <form action="process_update_booking.php" method="post">
            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['booking_id']); ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="user_id" class="form-label" style="color: black;">Người Đặt:</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo htmlspecialchars($user['user_id']); ?>" <?php if ($user['user_id'] == $booking['user_id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($user['full_name']); ?> (ID: <?php echo htmlspecialchars($user['user_id']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="parking_id" class="form-label" style="color: black;">Bãi Xe:</label>
                        <select class="form-select" id="parking_id" name="parking_id" required>
                            <?php foreach ($parkingLots as $parkingLot): ?>
                                <option value="<?php echo htmlspecialchars($parkingLot['parking_id']); ?>" <?php if ($parkingLot['parking_id'] == $booking['parking_id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($parkingLot['name']); ?> (ID: <?php echo htmlspecialchars($parkingLot['parking_id']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label" style="color: black;">Thời Gian Bắt Đầu:</label>
                        <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="<?php echo str_replace(' ', 'T', htmlspecialchars($booking['start_time'])); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration_hours" class="form-label" style="color: black;">Thời Lượng (giờ):</label>
                        <input type="number" class="form-control" id="duration_hours" name="duration_hours" value="<?php echo htmlspecialchars($booking['duration_hours']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="pricePerHour" class="form-label" style="color: black;">Giá Theo Giờ:</label>
                        <input type="number" class="form-control" id="pricePerHour" name="pricePerHour" value="<?php echo htmlspecialchars($booking['pricePerHour']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label" style="color: black;">Trạng Thái:</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?php if ($booking['status'] === 'active') echo 'selected'; ?>>Đang hoạt động</option>
                            <option value="complete" <?php if ($booking['status'] === 'complete') echo 'selected'; ?>>Hoàn thành</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="total_fee" class="form-label" style="color: black;">Tổng Phí:</label>
                        <input type="number" class="form-control" id="total_fee" name="total_fee" value="<?php echo htmlspecialchars($booking['total_fee']); ?>" readonly>
                        <small class="form-text text-muted">Tổng phí được tính toán tự động.</small>
                    </div>
                    <div class="mb-3">
                        <label for="created_at" class="form-label" style="color: black;">Ngày Tạo:</label>
                        <input type="text" class="form-control" id="created_at" name="created_at" value="<?php echo htmlspecialchars($booking['created_at']); ?>" readonly>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
            <a href="admin_bookings.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>