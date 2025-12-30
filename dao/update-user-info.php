<?php
// Include your DAO files here
include_once 'user-accounts.php';

// Assuming you have a user session or some way to identify the current user
session_start();
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo "User not logged in.";
    return;
}

// Nhận dữ liệu từ POST request
$fullName = isset($_POST['fullName']) ? $_POST['fullName'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$phone = isset($_POST['phone']) ? $_POST['phone'] : null;
$address = isset($_POST['address']) ? $_POST['address'] : null;

$missingFields = [];
if ($fullName === null) {
    $missingFields[] = 'fullName';
}
if ($email === null) {
    $missingFields[] = 'email';
}
if ($phone === null) {
    $missingFields[] = 'phone';
}
if ($address === null) {
    $missingFields[] = 'address';
}

if (!empty($missingFields)) {
    echo "Missing required fields: " . implode(', ', $missingFields) . ".";
    return;
}

// Kiểm tra định dạng email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    return;
}

// Kiểm tra định dạng số điện thoại (ví dụ đơn giản, có thể cần phức tạp hơn)
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    echo "Invalid phone number format. Please use 10 digits.";
    return;
}

try {
    user_account_update($userId, $fullName, $email, $phone, $address);
    echo "Update successful.";
    exit();
} catch (PDOException $e) {
    echo "Lỗi lưu thông tin: " . $e->getMessage();
}
?>