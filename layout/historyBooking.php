<?php
// Include your DAO files here
include_once '../dao/bookings.php';
include_once '../dao/parking-lots.php';

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
$bookings = getBookingsByUserId($userId);
?>

<div class="col-lg-9">
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 style="font-size: 1.3rem; color: #fff;">Các bãi xe đã đặt (Hết hạn)</h3>
            <!-- <a href="#" style="color: #ff7f00; text-decoration: none; font-size: 0.9rem;" class="view-all-link">
                Xem tất cả
                <i class="fas fa-chevron-right ms-1"></i>
            </a> -->
        </div>

        <ul class="parking-list">
            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $booking): ?>
                    <?php if ($booking['status'] == 'completed'): ?>
                        <?php
                            $parkingLot = parking_lot_select_by_id($booking['parking_id']);
                            if (!$parkingLot) {
                                continue;
                            }
                        ?>
                        <li class="parking-item" data-status="completed">
                            <div class="parking-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="parking-details">
                                <h4 class="parking-title"><?php echo htmlspecialchars($parkingLot['name']); ?></h4>
                                <p class="parking-time">Hoàn thành • <?php echo date('d/m/Y', strtotime($booking['end_time'])); ?></p>
                            </div>
                            <div class="parking-action">
                                <a href="parking.php" class="btn btn-sm btn-outline-success">Đặt lại</a>
                                <!-- <a href="#" class="btn btn-sm btn-outline-secondary">Chi tiết</a> -->
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có đặt chỗ nào đã hoàn thành trước đó.</p>
            <?php endif; ?>
        </ul>
    </div>
</div>