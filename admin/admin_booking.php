<?php
// Include DAO
include_once '../dao/bookings.php';

// Lấy tất cả các đặt chỗ và thông tin liên quan
$bookings = booking_select_all_with_details();
?>

<div class="container mt-5">
    <h2 class="mb-4">Quản lý Đặt Chỗ</h2>

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

    <h3>Danh Sách Đặt Chỗ</h3>
    <?php if (!empty($bookings)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Đặt Chỗ</th>
                    <th>Người Đặt</th>
                    <th>Bãi Xe</th>
                    <th>Thời Gian Bắt Đầu</th>
                    <th>Thời Lượng (giờ)</th>
                    <th>Giá Theo Giờ</th>
                    <th>Trạng Thái</th>
                    <th>Tổng Phí</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td style="max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo htmlspecialchars($booking['booking_id']); ?></td>
                        <td style="max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo htmlspecialchars($booking['user_full_name']); ?> (ID: <?php echo htmlspecialchars($booking['user_id']); ?>)</td>
                        <td style="max-width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo htmlspecialchars($booking['parking_name']); ?> (ID: <?php echo htmlspecialchars($booking['parking_id']); ?>)</td>
                        <td><?php echo htmlspecialchars($booking['start_time']); ?></td>
                        <td style="max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo htmlspecialchars($booking['duration_hours']); ?></td>
                        <td style="max-width: 50px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo number_format($booking['pricePerHour'], 0, ',', '.'); ?>đ</td>
                        <td style="max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            <?php
                            $statusClass = '';
                            switch ($booking['status']) {
                                case 'active':
                                    $statusClass = 'bg-success';
                                    break;
                                case 'complete':
                                    $statusClass = 'bg-secondary'; // Hoặc bạn có thể chọn 'bg-info', 'bg-primary', v.v.
                                    break;
                                case 'cancelled':
                                    $statusClass = 'bg-danger';
                                    break;
                                default:
                                    $statusClass = 'bg-light text-dark'; // Màu mặc định nếu có trạng thái khác
                                    break;
                            }
                            ?>
                            <span class="badge <?php echo $statusClass; ?>">
                                <?php echo htmlspecialchars($booking['status']); ?>
                            </span>
                        </td>
                        <td style="max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo number_format($booking['total_fee'], 0, ',', '.'); ?>đ</td>
                        <td ><?php echo htmlspecialchars($booking['created_at']); ?></td>
                        <td style="max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            <form method="post" action="process_update_booking_status.php">
                                <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                                <select class="form-select form-select-sm" name="status" onchange="this.form.submit()">
                                    <option value="">Cập nhật TT</option>
                                    <option value="active" <?php if ($booking['status'] === 'active') echo 'selected'; ?>>Đang hoạt động</option>
                                    <option value="complete" <?php if ($booking['status'] === 'complete') echo 'selected'; ?>>Hoàn thành</option>
                                    <option value="cancelled" <?php if ($booking['status'] === 'cancelled') echo 'selected'; ?>>Đã hủy</option>
                                </select>
                                <noscript><button type="submit" class="btn btn-sm btn-primary mt-1">Cập nhật</button></noscript>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có đặt chỗ nào.</p>
    <?php endif; ?>

    <form id="deleteBookingForm" action="process_delete_booking.php" method="post" style="display: none;">
        <input type="hidden" name="booking_id_to_delete" id="booking_id_to_delete">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBookingButtons = document.querySelectorAll('.deleteBookingBtn');
        const deleteBookingForm = document.getElementById('deleteBookingForm');
        const bookingIdToDeleteInput = document.getElementById('booking_id_to_delete');

        deleteBookingButtons.forEach(button => {
            button.addEventListener('click', function() {
                const bookingId = this.dataset.bookingId;
                if (confirm(`Bạn có chắc chắn muốn xóa đặt chỗ có ID ${bookingId} không?`)) {
                    bookingIdToDeleteInput.value = bookingId;
                    deleteBookingForm.submit();
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