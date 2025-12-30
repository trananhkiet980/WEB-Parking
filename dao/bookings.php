<?php
require_once 'pdo.php'; // Assuming you have your pdo.php file

// Insert a new booking
function booking_insert($user_id, $parking_id, $start_time, $duration_hours, $pricePerHour, $status = 'active', $total_fee) {
    // Thiết lập múi giờ Việt Nam (nếu chưa được thiết lập ở nơi khác)
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    // Lấy thời gian tạo theo giờ Việt Nam
    $created_at = date('Y-m-d H:i:s');

    // Tính thời gian kết thúc dựa trên thời gian tạo (đã là giờ Việt Nam)
    $end_time = date('Y-m-d H:i:s', strtotime("+" . $duration_hours . " hours", strtotime($created_at)));

    $sql = "INSERT INTO bookings (user_id, parking_id, start_time, duration_hours, pricePerHour, status, total_fee, created_at, end_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $user_id, $parking_id, $start_time, $duration_hours, $pricePerHour, $status, $total_fee, $created_at, $end_time);
}


// Update a booking
function booking_update($booking_id, $user_id, $parking_id, $start_time, $duration_hours, $status, $total_fee) {
    // Lấy thông tin booking cũ để có created_at
    $sql_select = "SELECT created_at FROM bookings WHERE booking_id = ?";
    $result = pdo_query_one($sql_select, $booking_id);
    $created_at = $result['created_at'];

    // Tính thời gian kết thúc bằng cách cộng duration_hours vào created_at
    $end_time = date('Y-m-d H:i:s', strtotime("+" . $duration_hours . " hours", strtotime($created_at)));
    $sql = "UPDATE bookings SET user_id=?, parking_id=?, start_time=?, duration_hours=?, status=?, total_fee=?, end_time=? WHERE booking_id=?";
    pdo_execute($sql, $user_id, $parking_id, $start_time, $duration_hours, $status, $total_fee, $end_time, $booking_id);
}

// Delete a booking
function booking_delete($booking_id) {
    $sql = "DELETE FROM bookings WHERE booking_id=?";
    pdo_execute($sql, $booking_id);
}

function booking_delete_by_user_id($user_id) {
    $sql = "DELETE FROM bookings WHERE user_id = ?";
    pdo_execute($sql, $user_id);
}

// Select all bookings
function booking_select_all() {
    $sql = "SELECT * FROM bookings ORDER BY created_at DESC";
    return pdo_query($sql);
}

// Select a booking by ID
function booking_select_by_id($booking_id) {
    $sql = "SELECT * FROM bookings WHERE booking_id=?";
    return pdo_query_one($sql, $booking_id);
}

// Check if a booking exists
function booking_exists($booking_id) {
    $sql = "SELECT count(*) FROM bookings WHERE booking_id=?";
    return pdo_query_value($sql, $booking_id) > 0;
}

function booking_update_status($booking_id, $status) {
    $sql = "UPDATE bookings SET status = ? WHERE booking_id = ?";
    return pdo_execute($sql, $status, $booking_id);
}
// Select bookings by user ID
function getBookingsByUserId($user_id) {
    $sql = "SELECT * FROM bookings WHERE user_id = ?";
    return pdo_query($sql, $user_id);
}

//Select bookings by parking ID
function getBookingsByParkingId($parking_id){
    $sql = "SELECT * FROM bookings WHERE parking_id = ?";
    return pdo_query($sql, $parking_id);
}

function booking_update_duration($booking_id, $user_id, $parking_id, $duration_hours) {
    // Lấy thông tin booking cũ để có created_at hiện tại
    $sql_select = "SELECT created_at FROM bookings WHERE booking_id = ?";
    $result = pdo_query_one($sql_select, $booking_id);
    if ($result) {
        $created_at = $result['created_at'];
        // Tính thời gian kết thúc mới dựa trên created_at và duration_hours mới
        $end_time = date('Y-m-d H:i:s', strtotime("+" . $duration_hours . " hours", strtotime($created_at)));
        $sql = "UPDATE bookings SET duration_hours = ?, end_time = ? WHERE user_id = ? AND parking_id = ?";
        pdo_execute($sql, $duration_hours, $end_time, $user_id, $parking_id);
    } else {
        return false; // Hoặc throw một exception
    }
}

// Hàm kiểm tra xem booking đã tồn tại hay chưa (cần được định nghĩa trong bookings.php)
function booking_check_exists($user_id, $parking_id, $status) {
    $sql = "SELECT COUNT(*) FROM bookings WHERE user_id = ? AND parking_id = ? AND status = ?";
    return pdo_query_value($sql, $user_id, $parking_id, $status) > 0;
}

function booking_select_all_with_details() {
    $sql = "SELECT
                b.booking_id,
                b.user_id,
                ua.full_name AS user_full_name,
                b.parking_id,
                pl.name AS parking_name,
                b.start_time,
                b.duration_hours,
                b.pricePerHour,
                b.status,
                b.total_fee,
                b.created_at
            FROM bookings b
            JOIN user_accounts ua ON b.user_id = ua.user_id
            JOIN parking_lots pl ON b.parking_id = pl.parking_id
            ORDER BY b.created_at DESC";
    return pdo_query($sql);
}
?>