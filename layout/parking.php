<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bãi xe - SKT Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./css/parking.css">
    <link rel="stylesheet" href="./css/notification-styles.css">
</head>

<body>
    <!-- Navbar -->
    <?php include('navbar.php')?>

    <!-- Hero Banner -->
    <div class="hero-banner" style="background-image: url('/api/placeholder/1920/1080');">
        <div class="hero-overlay">
            <div class="hero-title">
                <h1>Các Bãi Đỗ Xe</h1>
                <p class="hero-subtitle">Tìm kiếm và đặt chỗ đỗ xe một cách nhanh chóng, tiết kiệm thời gian và chi phí.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Bãi xe</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <!-- Search and Filter Section -->
        <section class="search-filter-section">
            <form method="GET" action="parking.php" id="filter-form">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <h3 class="filter-heading">Tìm Kiếm Bãi Đỗ Xe</h3>
                    </div>

                    <div class="col-lg-12 mb-3">
                        <input type="text" name="search" class="search-input" placeholder="Nhập tên bãi đỗ xe hoặc địa điểm..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="filter-group">
                            <label class="filter-label">Quận/Huyện</label>
                            <select name="district" class="filter-select">
                                <option value="">Tất cả</option>
                                <option value="quan7" <?php echo (isset($_GET['district']) && $_GET['district'] == 'quan7') ? 'selected' : ''; ?>>Quận 7</option>
                                <option value="quan1" <?php echo (isset($_GET['district']) && $_GET['district'] == 'quan1') ? 'selected' : ''; ?>>Quận 1</option>
                                <option value="quan3" <?php echo (isset($_GET['district']) && $_GET['district'] == 'quan3') ? 'selected' : ''; ?>>Quận 3</option>
                                <option value="quan4" <?php echo (isset($_GET['district']) && $_GET['district'] == 'quan4') ? 'selected' : ''; ?>>Quận 4</option>
                                <option value="quan5" <?php echo (isset($_GET['district']) && $_GET['district'] == 'quan5') ? 'selected' : ''; ?>>Quận 5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="filter-group">
                            <label class="filter-label">Trạng thái</label>
                            <select name="status" class="filter-select">
                                <option value="">Tất cả</option>
                                <option value="available" <?php echo (isset($_GET['status']) && $_GET['status'] == 'available') ? 'selected' : ''; ?>>Còn chỗ trống</option>
                                <option value="full" <?php echo (isset($_GET['status']) && $_GET['status'] == 'full') ? 'selected' : ''; ?>>Đã đầy</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="filter-group">
                            <label class="filter-label">Sắp xếp theo</label>
                            <select name="sort" class="filter-select">
                                <option value="pricePerHour_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'pricePerHour_asc') ? 'selected' : ''; ?>>Giá: Thấp đến cao</option>
                                <option value="pricePerHour_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'pricePerHour_desc') ? 'selected' : ''; ?>>Giá: Cao đến thấp</option>
                                <option value="distance" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'distance') ? 'selected' : ''; ?>>Khoảng cách</option>
                                <option value="popularity" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'popularity') ? 'selected' : ''; ?>>Mức độ phổ biến</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="filter-group">
                            <label class="filter-label">Vị trí của bạn</label>
                            <button type="button" id="get-location-btn" class="btn btn-outline-primary w-100">
                                <i class="fas fa-map-marker-alt me-2"></i> Lấy vị trí tự động
                            </button>
                            <!-- Tạo độ ngẫu nhiên ban đầu-->
                            <input type="hidden" name="user_latitude" id="user_latitude" value="">
                            <input type="hidden" name="user_longitude" id="user_longitude" value="">                        
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-2 mt-2">
                        <button type="submit" class="filter-button">
                            <i class="fas fa-filter me-2"></i> Lọc
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <!-- Parking Lots Section -->
        <h2 class="section-title">Các Bãi Đỗ Xe</h2>
        <div class="parking-grid">
            
        </div>

        <!-- Map Preview -->
        <div class="map-preview">
            <div class="map-title">
                <i class="fas fa-map-marked-alt"></i> Bản đồ các bãi đỗ xe
            </div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d31355.768529420876!2d106.69956896542596!3d10.738077929992935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20lot%20district%207%20ho%20chi%20minh!5e0!3m2!1sen!2s!4v1709732584343!5m2!1sen!2s"
                class="map-container" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <!-- Get in Touch Section -->
        <?php include("getintouch.php")?>
    </div>

    <!-- Footer -->
    <?php include("footer.php")?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/parking.js"></script>
    <script>
        // Lấy tọa độ người dùng (tạm thời dùng giá trị mặc định)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('user_latitude').value = position.coords.latitude;
                document.getElementById('user_longitude').value = position.coords.longitude;
            }, function(error) {
                console.error("Lỗi lấy vị trí: " + error.message);
            });
        }
    </script>
</body>

</html>