<?php
include_once 'parking-lots.php';

if (isset($_GET['parking_id'])) {
    $parkingId = $_GET['parking_id'];
    $parkingLot = parking_lot_select_by_id($parkingId);
    if ($parkingLot) {
        echo $parkingLot['pricePerHour'];
    } else {
        echo '0'; // Hoặc xử lý lỗi khác nếu cần
    }
} else {
    echo '0'; // Hoặc xử lý lỗi khác nếu cần
}
?>