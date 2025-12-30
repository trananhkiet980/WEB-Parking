<?php
require_once 'pdo.php';

function updateParkingStatuses() {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    
    $currentTime = date('Y-m-d H:i:s');
    error_log("Bắt đầu chạy updateParkingStatuses vào: " . $currentTime . "\n", 3, 'update_log.txt');

    $sqlComplete = "UPDATE bookings SET status = 'completed' WHERE status = 'active' AND end_time <= ?";
    error_log("Câu lệnh SQL (completed): " . $sqlComplete . " với thời gian: " . $currentTime . "\n", 3, 'update_log.txt');
    $rowsAffectedComplete = pdo_execute($sqlComplete, $currentTime);
    error_log("Số hàng 'completed' bị ảnh hưởng: " . $rowsAffectedComplete . "\n", 3, 'update_log.txt');

    error_log("Kết thúc chạy updateParkingStatuses\n", 3, 'update_log.txt');
}

updateParkingStatuses();
?>