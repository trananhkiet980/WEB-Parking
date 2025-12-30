<?php
require_once 'pdo.php';

// Thêm một bãi đỗ xe mới
function parking_lot_insert($name, $address, $capacity, $pricePerHour, $operating_hours, $status, $image_url, $district, $latitude, $longitude, $occupied_slots) {
    $sql = "INSERT INTO parking_lots(name, address, capacity, pricePerHour, operating_hours, status, image_url, district, latitude, longitude, occupied_slots) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    pdo_execute($sql, $name, $address, $capacity, $pricePerHour, $operating_hours, $status, $image_url, $district, $latitude, $longitude, $occupied_slots);
}

// Cập nhật thông tin bãi đỗ xe
function parking_lot_update($parking_id, $name, $address, $capacity, $pricePerHour, $operating_hours, $status, $image_url, $district, $latitude, $longitude) {
    $sql = "UPDATE parking_lots SET name=?, address=?, capacity=?, pricePerHour=?, operating_hours=?, status=?, image_url=?, district=?, latitude=?, longitude=? WHERE parking_id=?";
    pdo_execute($sql, $name, $address, $capacity, $pricePerHour, $operating_hours, $status, $image_url, $district, $latitude, $longitude, $parking_id);
}

// Xóa một hoặc nhiều bãi đỗ xe
function parking_lot_delete($parking_id) {
    $sql = "DELETE FROM parking_lots WHERE id=?";
    if (is_array($parking_id)) {
        foreach ($parking_id as $ma) {
            pdo_execute($sql, $ma);
        }
    } else {
        pdo_execute($sql, $parking_id);
    }
}

// Truy vấn tất cả các bãi đỗ xe
function parking_lot_select_all() {
    $sql = "SELECT * FROM parking_lots ORDER BY parking_id DESC";
    return pdo_query($sql);
}

// Truy vấn một bãi đỗ xe theo ID
function parking_lot_select_by_id($parking_id) {
    $sql = "SELECT * FROM parking_lots WHERE parking_id=?";
    return pdo_query_one($sql, $parking_id);
}

// Kiểm tra xem bãi đỗ xe có tồn tại không
function parking_lot_exist($parking_id) {
    $sql = "SELECT count(*) FROM parking_lots WHERE parking_id=?";
    return pdo_query_value($sql, $parking_id) > 0;
}

// Truy vấn các bãi đỗ xe theo quận (district)
function parking_lot_select_by_district($district) {
    $sql = "SELECT * FROM parking_lots WHERE district=? ORDER BY parking_id DESC";
    return pdo_query($sql, $district);
}

// Hàm cập nhật trạng thái bãi xe 
function parking_lot_update_status($parking_id, $status) {
    $sql = "UPDATE parking_lots SET status = ? WHERE parking_id = ?";
    pdo_execute($sql, $status, $parking_id);
}

// Hàm tính khoảng cách Haversine
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371; // Bán kính Trái Đất (km)
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $R * $c;
}

// Truy vấn bãi đỗ xe với bộ lọc và sắp xếp
function parking_lot_fetch_filtered($params = []) {
    $user_latitude = floatval($params['user_latitude'] ?? 10.7380779);
    $user_longitude = floatval($params['user_longitude'] ?? 106.6995689);
    $search = trim($params['search'] ?? '');
    $district = trim($params['district'] ?? '');
    $status = trim($params['status'] ?? '');
    $sort = trim($params['sort'] ?? 'pricePerHour_asc');
    $page = intval($params['page'] ?? 1);
    $limit = 6;

    $offset = ($page - 1) * $limit;

    // Công thức Haversine
    $haversine = "6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))";
    $sql = "SELECT *, $haversine AS distance FROM parking_lots WHERE 1=1";
    $sql_args = [$user_latitude, $user_longitude, $user_latitude];

    if ($search) {
        $sql .= " AND (name LIKE ? OR address LIKE ?)";
        $sql_args[] = "%$search%";
        $sql_args[] = "%$search%";
    }
    if ($district) {
        $sql .= " AND district = ?";
        $sql_args[] = $district;
    }
    if ($status) {
        $sql .= " AND status = ?";
        $sql_args[] = $status;
    }

    // Sắp xếp
    switch ($sort) {
        case 'pricePerHour_asc': $sql .= " ORDER BY CAST(REPLACE(pricePerHour, '.', '') AS UNSIGNED) ASC"; break;
        case 'pricePerHour_desc': $sql .= " ORDER BY CAST(REPLACE(pricePerHour, '.', '') AS UNSIGNED) DESC"; break;
        case 'distance': $sql .= " ORDER BY distance ASC"; break;
        case 'popularity': $sql .= " ORDER BY (occupied_slots / capacity) DESC"; break;
        default: $sql .= " ORDER BY CAST(REPLACE(pricePerHour, '.', '') AS UNSIGNED) ASC";
    }

    // Thêm LIMIT và OFFSET mà không đưa vào mảng `$sql_args`
    $sql .= " LIMIT $limit OFFSET $offset";

    try {
        // Debug SQL trước khi chạy
        error_log("SQL: " . $sql);
        error_log("Params: " . json_encode($sql_args));

        // Lấy dữ liệu phân trang
        $parking_lots = pdo_query($sql, ...$sql_args);
        foreach ($parking_lots as &$lot) {
            $lot['distance'] = round($lot['distance'], 2);
        }

        // Đếm tổng số bản ghi
        $count_sql = "SELECT COUNT(*) as total FROM parking_lots WHERE 1=1";
        $count_args = [];

        if ($search) {
            $count_sql .= " AND (name LIKE ? OR address LIKE ?)";
            $count_args[] = "%$search%";
            $count_args[] = "%$search%";
        }
        if ($district) {
            $count_sql .= " AND district = ?";
            $count_args[] = $district;
        }
        if ($status) {
            $count_sql .= " AND status = ?";
            $count_args[] = $status;
        }

        // Debug SQL đếm tổng
        error_log("Count SQL: " . $count_sql);
        error_log("Count Params: " . json_encode($count_args));

        $total_records = pdo_query_value($count_sql, ...$count_args);
        $total_pages = ceil($total_records / $limit);

        return [
            'parking_lots' => $parking_lots,
            'total' => $total_records,
            'page' => $page,
            'limit' => $limit,
            'total_pages' => $total_pages
        ];
    } catch (PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        return [
            'error' => 'Lỗi truy vấn cơ sở dữ liệu: ' . $e->getMessage(),
            'parking_lots' => [],
            'total' => 0,
            'page' => $page,
            'limit' => $limit,
            'total_pages' => 0
        ];
    }
}
?>