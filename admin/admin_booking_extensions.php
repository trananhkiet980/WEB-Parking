<?php

// Include DAO
include_once '../dao/booking-extension.php';
include_once '../dao/bookings.php'; // Để lấy thông tin booking
include_once '../dao/user-accounts.php'; // Để lấy email người dùng
include_once '../dao/parking-lots.php'; // Để lấy tên bãi xe

// Lấy tất cả các gia hạn đặt chỗ và thông tin liên quan
$bookingExtensions = booking_extension_select_all_with_details();
?>
<div class="container mt-5">
    <h2 class="mb-4">Quản lý Gia Hạn Đặt Chỗ</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo htmlspecialchars($_SESSION['message_type']); ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php if (isset($_SESSION['error_detail']) && $_SESSION['message_type'] === 'danger'): ?>
                <p class="mt-2"><strong>Chi tiết lỗi:</strong> <?php echo htmlspecialchars($_SESSION['error_detail']); ?></p>
            <?php endif; ?>
        </div>
        <?php
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        unset($_SESSION['error_detail']);
        ?>
    <?php endif; ?>

    <h3>Danh Sách Gia Hạn Đặt Chỗ</h3>
    <?php if (!empty($bookingExtensions)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Gia Hạn</th>
                    <th>ID Đặt Chỗ</th>
                    <th>Email Người Đặt</th>
                    <th>Tên Bãi Xe</th>
                    <th>Thêm Giờ</th>
                    <th>Phí Gia Hạn</th>
                    <th>Phương Thức Thanh Toán</th>
                    <th>Thời Gian Gia Hạn</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookingExtensions as $extension): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($extension['extension_id']); ?></td>
                        <td><?php echo htmlspecialchars($extension['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($extension['user_email']); ?></td>
                        <td><?php echo htmlspecialchars($extension['parking_name']); ?></td>
                        <td><?php echo htmlspecialchars($extension['added_hours']); ?></td>
                        <td><?php echo number_format($extension['fee'], 0, ',', '.'); ?>đ</td>
                        <td><?php echo htmlspecialchars($extension['payment_method']); ?></td>
                        <td><?php echo htmlspecialchars($extension['extended_at']); ?></td>
                        <td>
                            <button class="btn btn-sm btn-danger deleteExtensionBtn" data-extension-id="<?php echo $extension['extension_id']; ?>">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có gia hạn đặt chỗ nào.</p>
    <?php endif; ?>

    <form id="deleteExtensionForm" action="process_delete_booking_extension.php" method="post" style="display: none;">
        <input type="hidden" name="extension_id_to_delete" id="extension_id_to_delete">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteExtensionButtons = document.querySelectorAll('.deleteExtensionBtn');
        const deleteExtensionForm = document.getElementById('deleteExtensionForm');
        const extensionIdToDeleteInput = document.getElementById('extension_id_to_delete');

        deleteExtensionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const extensionId = this.dataset.extensionId;
                if (confirm(`Bạn có chắc chắn muốn xóa gia hạn có ID ${extensionId} không?`)) {
                    extensionIdToDeleteInput.value = extensionId;
                    deleteExtensionForm.submit();
                }
            });
        });
    });
</script>
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