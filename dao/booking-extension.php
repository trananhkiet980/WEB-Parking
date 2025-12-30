<?php
require_once 'pdo.php';

// Insert a new booking extension
function booking_extension_insert($booking_id, $added_hours, $fee, $payment_method) {
    $extended_at = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
    $sql = "INSERT INTO bookingextensions (booking_id, added_hours, fee, payment_method, extended_at) VALUES (?, ?, ?, ?, ?)";
    pdo_execute($sql, $booking_id, $added_hours, $fee, $payment_method, $extended_at);
}

// Update a booking extension
function booking_extension_update($extension_id, $booking_id, $added_hours, $fee, $payment_method) {
    $sql = "UPDATE bookingextensions SET booking_id=?, added_hours=?, fee=?, payment_method=? WHERE extension_id=?";
    pdo_execute($sql, $extension_id, $booking_id, $added_hours, $fee, $payment_method);
}

// Delete a booking extension
function booking_extension_delete($extension_id) {
    $sql = "DELETE FROM bookingextensions WHERE extension_id=?";
    pdo_execute($sql, $extension_id);
}

// Select all booking extensions
function booking_extension_select_all() {
    $sql = "SELECT * FROM bookingextensions ORDER BY extended_at DESC";
    return pdo_query($sql);
}

// Select a booking extension by ID
function booking_extension_select_by_id($extension_id) {
    $sql = "SELECT * FROM bookingextensions WHERE extension_id=?";
    return pdo_query_one($sql, $extension_id);
}

// Check if a booking extension exists
function booking_extension_exists($extension_id) {
    $sql = "SELECT count(*) FROM bookingextensions WHERE extension_id=?";
    return pdo_query_value($sql, $extension_id) > 0;
}

//select booking extensions by booking id.
function getExtensionsByBookingId($booking_id){
    $sql = "SELECT * FROM bookingextensions WHERE booking_id = ?";
    return pdo_query($sql, $booking_id);
}

function booking_extension_select_all_with_details() {
    $sql = "SELECT
                be.extension_id,
                be.booking_id,
                be.added_hours,
                be.fee,
                be.payment_method,
                be.extended_at,
                b.user_id,
                ua.email AS user_email,
                pl.name AS parking_name
            FROM bookingextensions be
            JOIN bookings b ON be.booking_id = b.booking_id
            JOIN user_accounts ua ON b.user_id = ua.user_id
            JOIN parking_lots pl ON b.parking_id = pl.parking_id
            ORDER BY be.extended_at DESC";
    return pdo_query($sql);
}
?>