<?php
include_once 'parking-lots.php';

if (isset($_GET['parking_id'])) {
    $parkingId = $_GET['parking_id'];
    $parkingLot = parking_lot_select_by_id($parkingId);
    if ($parkingLot) {
        echo htmlspecialchars($parkingLot['name']);
    } else {
        echo ''; // Hoặc thông báo lỗi khác
    }
} else {
    echo ''; // Hoặc thông báo lỗi khác
}
?>