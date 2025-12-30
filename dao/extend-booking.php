<?php
// extend-booking.php

include_once 'bookings.php';
include_once 'booking-extension.php';
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['booking_id']) || !isset($_POST['added_hours']) || !isset($_POST['fee']) || !isset($_POST['payment_method'])) {
        echo 'Missing required data.';
        return;
    }

    $booking_id = $_POST['booking_id'];
    $parking_id = $_POST['parking_id'];
    $added_hours = $_POST['added_hours'];
    $fee = $_POST['fee'];
    $payment_method = $_POST['payment_method'];

    try {
        // Add extension record
        booking_extension_insert($booking_id, $added_hours, $fee, $payment_method);

        // Update duration_hours in bookings table
        $booking = booking_select_by_id($booking_id);
        if (!$booking) {
            echo 'Booking not found.';
            return;
        }
        $new_duration_hours = $booking['duration_hours'] + $added_hours;
        booking_update_duration($booking_id, $user_id, $parking_id, $new_duration_hours);

        echo 'Gia hạn đặt chỗ thành công!';
    } catch (PDOException $e) {
        echo 'Error extending booking: ' . $e->getMessage();
    }
} else {
    echo 'Method not allowed.';
}
?>