<?php
// Include your DAO files here
include_once '../dao/bookings.php';
include_once '../dao/booking-extension.php';
include_once '../dao/parking-lots.php';
include_once '../dao/update-parking-status.php';


// Assuming you have a user session or some way to identify the current user
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo "User not logged in.";
    return;
}

// Get the user's bookings
$bookings = getBookingsByUserId($userId); // Use the DAO function directly
?>

<!-- Thêm liên kết đến file CSS thông báo -->
<link rel="stylesheet" href="css/notification-styles.css">
<link rel="stylesheet" href="css/currentBooking.css">


<div class="col-lg-9">
    <div class="mb-5 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 style="font-size: 1.3rem; color: #fff;">Đặt chỗ hiện tại</h3>
        </div>

        <?php if (!empty($bookings)): ?>
            <?php foreach ($bookings as $booking): ?>
                <?php
                    // Chỉ hiển thị nếu status là 'active'
                    if ($booking['status'] == 'active') {
                        $parkingLot = parking_lot_select_by_id($booking['parking_id']); // Use parking_lots.php function
                        if (!$parkingLot) {
                            continue;
                        }
                        date_default_timezone_set('Asia/Ho_Chi_Minh');

                        $remainingTime = strtotime($booking['start_time'] . ' + 7 hours') + ($booking['duration_hours'] * 3600) - time();
                        $remainingHours = floor($remainingTime / 3600);
                        $remainingMinutes = floor(($remainingTime % 3600) / 60);
                ?>
                    <div class="booking-card">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="booking-title">
                                    <i class="fas fa-building"></i> <?php echo htmlspecialchars($parkingLot['name']); ?>
                                </h4>
                                <p class="booking-info">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($parkingLot['address']); ?>
                                </p>
                                <div>
                                    <span class="booking-badge active">Đang hoạt động</span>
                                    <span style="color: #ccc; font-size: 0.85rem;">
                                        <i class="fas fa-clock me-1" style="color: #ff7f00;"></i> Còn lại: <?php echo $remainingHours; ?> giờ <?php echo $remainingMinutes; ?> phút
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="border-left: 1px solid #333; padding-left: 20px; height: 100%;">
                                    <p class="booking-info">
                                        <i class="fas fa-calendar-alt"></i> Bắt đầu: <?php echo date('Y-m-d H:i', strtotime($booking['start_time'] . ' + 7 hours')); ?>                                    </p>
                                    <p class="booking-info">
                                        <i class="fas fa-clock"></i> Thời lượng: <?php echo $booking['duration_hours']; ?> giờ
                                    </p>
                                    <p class="booking-info">
                                        <i class="fas fa-money-bill-wave"></i> Phí: <?php echo number_format($booking['total_fee'], 0, ',', '.'); ?>đ
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-2 text-end">
                                <div class="booking-actions">
                                <a href="#" class="btn btn-orange btn-sm mb-2 w-100 extendBookingBtn"
                                    data-booking-id="<?php echo $booking['booking_id']; ?>"
                                    data-parking-id="<?php echo $booking['parking_id']; ?>">
                                        <i class="fas fa-hourglass-half me-1"></i> Gia hạn
                                </a>
                                    <a href="#" class="btn btn-outline-danger btn-sm w-100 cancelBookingBtn" data-booking-id="<?php echo $booking['booking_id']; ?>">
                                        <i class="fas fa-times-circle me-1"></i> Hủy đặt chỗ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    } // end if status active
                ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có đặt chỗ nào.</p>
        <?php endif; ?>
    </div>
</div>

<div class="modal-custom" id="extendBookingModal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Gia hạn thời gian đỗ xe</h3>
            <button class="close-modal" onclick="closeModals()">×</button>
        </div>
        <form id="extendBookingForm">
            <div class="modal-form-group">
                <label class="modal-label"><?php echo htmlspecialchars($parkingLot['name'] ?? ''); ?></label>
            </div>
            <div class="modal-form-group">
                <label for="extendHours" class="modal-label">Số giờ gia hạn</label>
                <select id="extendHours" class="modal-input">
                    <option value="1">1 giờ</option>
                    <option value="2">2 giờ</option>
                    <option value="3">3 giờ</option>
                    <option value="4">4 giờ</option>
                    <option value="5">5 giờ</option>
                </select>
            </div>
            <div class="modal-form-group">
                <label for="paymentMethod" class="modal-label">Phương thức thanh toán</label>
                <select id="paymentMethod" class="modal-input">
                    <option value="balance">Ví SKT Parking (Số dư: 200.000đ)</option>
                    <option value="momo">Ví MoMo</option>
                    <option value="bank">Thẻ ngân hàng</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModals()">Hủy bỏ</button>
                <button type="submit" class="btn-save">Xác nhận thanh toán</button>
            </div>
        </form>
    </div>
</div>

<!-- Thêm CSS cho notification nếu chưa có trong file notification-styles.css -->
<style>
    
</style>

<script src='js/currentBooking.js'></script>