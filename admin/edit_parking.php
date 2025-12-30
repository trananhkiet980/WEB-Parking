<?php
// Bắt đầu session (nếu chưa có)
session_start();

// // Kiểm tra xem người dùng đã đăng nhập và có quyền admin hay chưa
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu không phải admin
//     exit();
// }

// Include DAO
include_once '../dao/parking-lots.php';

// Lấy ID bãi xe từ URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ?page=admin_parking"); // Chuyển hướng nếu không có ID hoặc ID không hợp lệ
    exit();
}

$parking_id = $_GET['id'];

// Lấy thông tin bãi xe dựa trên ID
$parkingLot = parking_lot_select_by_id($parking_id);

// Nếu không tìm thấy bãi xe
if (!$parkingLot) {
    header("Location: ?page=admin_parking");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Bãi Xe - SKT Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="css/admin_parking.css"> -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #545b62;
            border-color: #4e555b;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">Sửa Thông Tin Bãi Xe</h2>
        <form action="process_update_parking.php" method="post">
            <input type="hidden" name="parking_id" value="<?php echo htmlspecialchars($parkingLot['parking_id']); ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên Bãi Xe:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($parkingLot['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa Chỉ:</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($parkingLot['address']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Sức Chứa:</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo htmlspecialchars($parkingLot['capacity']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="pricePerHour" class="form-label">Giá Theo Giờ:</label>
                        <input type="number" class="form-control" id="pricePerHour" name="pricePerHour" value="<?php echo htmlspecialchars($parkingLot['pricePerHour']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="operating_hours" class="form-label">Giờ Hoạt Động:</label>
                        <input type="text" class="form-control" id="operating_hours" name="operating_hours" value="<?php echo htmlspecialchars($parkingLot['operating_hours']); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="image_url" class="form-label">URL Hình Ảnh:</label>
                        <input type="text" class="form-control" id="image_url" name="image_url" value="<?php echo htmlspecialchars($parkingLot['image_url']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="district" class="form-label">Quận/Huyện:</label>
                        <input type="text" class="form-control" id="district" name="district" value="<?php echo htmlspecialchars($parkingLot['district']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="latitude" class="form-label">Vĩ Độ:</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo htmlspecialchars($parkingLot['latitude']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="longtitude" class="form-label">Kinh Độ:</label>
                        <input type="text" class="form-control" id="longtitude" name="longtitude" value="<?php echo htmlspecialchars($parkingLot['longitude']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng Thái:</label>
                        <select class="form-select" id="status" name="status">
                            <option value="available" <?php if ($parkingLot['status'] === 'available') echo 'selected'; ?>>Đang hoạt động</option>
                            <option value="full" <?php if ($parkingLot['status'] === 'full') echo 'selected'; ?>>Đã đầy</option>
                            <option value="maintaince" <?php if ($parkingLot['status'] === 'maintaince') echo 'selected'; ?>>Bảo trì</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
            <a href="../admin/?page=admin_parking" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>