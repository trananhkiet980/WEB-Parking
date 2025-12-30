<?php
require_once 'parking-lots.php'; // Include file parking-lots.php

header('Content-Type: application/json'); // Thêm header json

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'filter':
        $params = [
            'user_latitude' => $_GET['user_latitude'] ?? '',
            'user_longitude' => $_GET['user_longitude'] ?? '',
            'search' => $_GET['search'] ?? '',
            'district' => $_GET['district'] ?? '',
            'status' => $_GET['status'] ?? '',
            'sort' => $_GET['sort'] ?? 'pricePerHour_asc',
            'page' => $_GET['page'] ?? 1,
            'limit' => $_GET['limit'] ?? 6
        ];
        echo json_encode(parking_lot_fetch_filtered($params));
        break;

    case 'all':
        echo json_encode(['parking_lots' => parking_lot_select_all()]);
        break;

    case 'get_by_id':
        $id = $_GET['id'] ?? '';
        echo json_encode(['parking_lot' => parking_lot_select_by_id($id)]);
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            parking_lot_delete($id);
            echo json_encode(['success' => true]);
        }
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}
?>