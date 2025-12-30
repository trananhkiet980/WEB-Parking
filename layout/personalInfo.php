<?php
// Include your DAO files here
include_once '../dao/user-accounts.php';

// Assuming you have a user session or some way to identify the current user
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    return;
}

// Get the user's account information
$user = user_account_select_by_id($userId);

if (!$user) {
    echo "User not found.";
    return;
}
?>

<!-- Thêm liên kết đến file CSS thông báo -->
<link rel="stylesheet" href="../layout/css/notification-styles.css">

<div class="col-lg-9">
    <h4 class="panel-section-title">
        <i class="fas fa-id-card"></i> Thông tin cơ bản
    </h4>

    <div class="text-center mb-4">
        <div class="avatar-container">
            <img src="<?php echo htmlspecialchars($user['avatar'] ?? '/api/placeholder/200/200'); ?>" alt="User Avatar" class="avatar-image">
            <div class="avatar-edit-btn">
                <i class="fas fa-camera"></i>
            </div>
        </div>
        <h5 style="color: #fff; margin-top: 15px; font-weight: 600;"><?php echo htmlspecialchars($user['full_name'] ?? ''); ?></h5>
    </div>

    <div class="panel-form-group">
        <label for="fullName">Họ và tên</label>
        <input type="text" id="fullName" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" readonly>
        <input type="text" id="fullNameEdit" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" style="display: none;">
    </div>

    <div class="panel-form-group">
        <label for="email">Email</label>
        <input type="email" id="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly>
        <input type="email" id="emailEdit" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" style="display: none;">
    </div>

    <div class="panel-form-group">
        <label for="phone">Số điện thoại</label>
        <input type="tel" id="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" readonly>
        <input type="tel" id="phoneEdit" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" style="display: none;">
    </div>

    <div class="panel-form-group">
        <label for="address">Địa chỉ</label>
        <input type="text" id="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" readonly>
        <input type="text" id="addressEdit" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" style="display: none;">
    </div>

    <button class="panel-action-btn w-100" id="editButton">
        <i class="fas fa-edit me-2"></i>Chỉnh sửa thông tin
    </button>
    <button class="panel-action-btn w-100" id="saveButton" style="display: none;">
        <i class="fas fa-save me-2"></i>Lưu thông tin
    </button>
</div>

<script src='js/personalInfo.js'></script>