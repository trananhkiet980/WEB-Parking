<?php
// Include your DAO files here
include_once '../dao/parking-lots.php';

// Fetch all parking lots
$parkingLots = parking_lot_select_all();
?>

<!-- <link rel="stylesheet" href="css/admin_parking.css"> -->
<div class="container mt-5">
    <h2 class="mb-4">Quản lý Bãi Xe</h2>

    <?php
    // Hiển thị thông báo nếu có
    if (isset($_SESSION['message']) && isset($_SESSION['message_type'])): ?>
        <div class="alert alert-<?php echo htmlspecialchars($_SESSION['message_type']); ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
        // Xóa các biến session sau khi hiển thị để thông báo không xuất hiện lại
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    endif;
    ?>

    <button class="btn btn-primary mb-3" onclick="document.getElementById('addParkingForm').style.display='block'; document.getElementById('parkingList').style.display='none';">
        <i class="fas fa-plus-circle me-2"></i> Thêm Bãi Xe Mới
    </button>

    <div id="addParkingForm" style="display:none;">
    <h3>Thêm Bãi Xe Mới</h3>
    <form action="process_add_parking.php" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label" style="color: black;">Tên Bãi Xe:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label" style="color: black;">Địa Chỉ:</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="mb-3">
                    <label for="capacity" class="form-label" style="color: black;">Sức Chứa:</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" required>
                </div>
                <div class="mb-3">
                    <label for="pricePerHour" class="form-label" style="color: black;">Giá Theo Giờ:</label>
                    <input type="number" class="form-control" id="pricePerHour" name="pricePerHour" required>
                </div>
                <div class="mb-3">
                    <label for="operating_hours" class="form-label" style="color: black;">Giờ Hoạt Động:</label>
                    <input type="text" class="form-control" id="operating_hours" name="operating_hours">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="image_url" class="form-label" style="color: black;">URL Hình Ảnh:</label>
                    <input type="text" class="form-control" id="image_url" name="image_url">
                </div>
                <div class="mb-3">
                    <label for="district" class="form-label" style="color: black;">Quận/Huyện:</label>
                    <input type="text" class="form-control" id="district" name="district">
                </div>
                <div class="mb-3">
                    <label for="latitude" class="form-label" style="color: black;">Vĩ Độ:</label>
                    <input type="text" class="form-control" id="latitude" name="latitude">
                </div>
                <div class="mb-3">
                    <label for="longtitude" class="form-label" style="color: black;">Kinh Độ:</label>
                    <input type="text" class="form-control" id="longtitude" name="longtitude">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label" style="color: black;">Trạng Thái:</label>
                    <select class="form-select" id="status" name="status">
                        <option value="available">Đang hoạt động</option>
                        <option value="full">Đã đầy</option>
                        <option value="closed">Đóng cửa</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Thêm Bãi Xe</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('addParkingForm').style.display='none'; document.getElementById('parkingList').style.display='block';">Hủy</button>
        </form>
    </div>

    <div id="parkingList">
        <h3>Danh Sách Bãi Xe</h3>
        <?php if (!empty($parkingLots)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Bãi Xe</th>
                        <th>Địa Chỉ</th>
                        <th>Sức Chứa</th>
                        <th>Giá Theo Giờ</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($parkingLots as $parkingLot): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($parkingLot['parking_id']); ?></td>
                            <td><?php echo htmlspecialchars($parkingLot['name']); ?></td>
                            <td><?php echo htmlspecialchars($parkingLot['address']); ?></td>
                            <td><?php echo htmlspecialchars($parkingLot['capacity']); ?></td>
                            <td><?php echo number_format($parkingLot['pricePerHour'], 0, ',', '.'); ?>.000 nghìnVNĐ/giờ</td>
                            <td>
                                <span class="badge <?php
                                    switch ($parkingLot['status']) {
                                        case 'available':
                                            echo 'bg-success';
                                            break;
                                        case 'full':
                                            echo 'bg-danger';
                                            break;
                                        case 'closed':
                                            echo 'bg-secondary';
                                            break;
                                        default:
                                            echo 'bg-info';
                                            break;
                                    }
                                ?>">
                                    <?php echo htmlspecialchars($parkingLot['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit_parking.php?id=<?php echo $parkingLot['parking_id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Sửa</a>
                                <button class="btn btn-sm btn-info updateStatusBtn" data-parking-id="<?php echo $parkingLot['parking_id']; ?>" data-current-status="<?php echo $parkingLot['status']; ?>">
                                    <i class="fas fa-sync-alt"></i> Cập nhật TT
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không có bãi xe nào.</p>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Cập nhật trạng thái bãi xe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateParkingStatusForm" action="process_update_parking_status.php" method="post">
                    <input type="hidden" id="parkingIdInput" name="parking_id">
                    <div class="mb-3">
                        <label for="newStatus" class="form-label">Trạng Thái Mới:</label>
                        <select class="form-select" id="newStatus" name="new_status">
                            <option value="available">Đang hoạt động</option>
                            <option value="full">Đã đầy</option>
                            <option value="closed">Đóng cửa</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateStatusButtons = document.querySelectorAll('.updateStatusBtn');
        const updateStatusModal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
        const parkingIdInput = document.getElementById('parkingIdInput');
        const newStatusSelect = document.getElementById('newStatus');

        updateStatusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const parkingId = this.dataset.parkingId;
                const currentStatus = this.dataset.currentStatus;
                parkingIdInput.value = parkingId;
                // Optionally, you can set the current status in the select for context
                newStatusSelect.value = currentStatus;
                updateStatusModal.show();
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2, h3 {
        color: #333;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #1e7e34;
        border-color: #1e7e34;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: #fff;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
        color: #fff;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #545b62;
        border-color: #4e555b;
    }

    .badge {
        font-size: 0.875rem;
    }

    #addParkingForm label {
        font-weight: bold;
    }
</style>