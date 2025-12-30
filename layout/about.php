<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu - SKT Parking</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome cho các biểu tượng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="./css/about.css">
    
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php' ?>

    <!-- Hero Banner -->
    <div class="hero-banner" style="background-image: url('img/login.jpg');">
        <div class="hero-overlay">
            <div class="hero-title">
                <h1>Giới Thiệu SKT Parking</h1>
                <p class="hero-subtitle">Giải pháp quản lý bãi đỗ xe thông minh và toàn diện, nâng tầm trải nghiệm người dùng</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Giới thiệu</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <!-- Phần Giới thiệu -->
        <div class="intro-section">
            <p class="intro-text">
                SKT Parking là hệ thống quản lý bãi đỗ xe và giải pháp công nghệ tiên tiến nhất hiện nay. Với bề dày kinh nghiệm và đội ngũ chuyên gia dày dặn, chúng tôi cung cấp các giải pháp toàn diện từ khâu tư vấn, triển khai đến vận hành và bảo trì hệ thống.
            </p>
            
            <div class="row mt-5">
                <div class="col-lg-6 mb-4">
                    <img src="img/login.jpg" alt="Parking Image" class="intro-image">
                </div>
                <div class="col-lg-6">
                    <div class="intro-content">
                        <p>
                            SKT Parking ra đời với sứ mệnh mang lại giải pháp thông minh cho việc quản lý bãi đỗ xe. Chúng tôi hiểu rằng việc quản lý bãi đỗ xe là một thách thức lớn đối với các doanh nghiệp, đặc biệt là tại các thành phố lớn.
                        </p>
                        <p>
                            Với công nghệ tiên tiến và kinh nghiệm triển khai thực tế, chúng tôi tự hào mang đến giải pháp tối ưu nhất cho khách hàng, giúp tối ưu hóa không gian, tiết kiệm chi phí và nâng cao trải nghiệm người dùng.
                        </p>
                        <p>
                            Hệ thống của chúng tôi kết hợp phần cứng hiện đại với phần mềm thông minh, tạo nên một giải pháp toàn diện cho việc quản lý bãi đỗ xe từ quy mô nhỏ đến lớn, từ các tòa nhà văn phòng đến trung tâm thương mại và khu dân cư.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="features">
                <div class="feature">
                    <div class="feature-circle">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h4 class="feature-title">Tốc độ và hiệu quả cao</h4>
                    <p class="feature-description">Hệ thống quản lý bãi đỗ xe thông minh giúp tối ưu hóa thời gian và nâng cao hiệu suất vận hành</p>
                </div>
                
                <div class="feature">
                    <div class="feature-circle">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h4 class="feature-title">Phương án tối ưu</h4>
                    <p class="feature-description">Cung cấp giải pháp với chi phí hợp lý nhất, phù hợp với nhu cầu và ngân sách của từng dự án</p>
                </div>
                
                <div class="feature">
                    <div class="feature-circle">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4 class="feature-title">Hoàn thiện mọi yêu cầu</h4>
                    <p class="feature-description">Cam kết hoàn thiện tất cả các yêu cầu từ khách hàng với tiêu chuẩn cao nhất của ngành</p>
                </div>
            </div>
        </div>
        
        <!-- Phần Vấn đề của khách hàng -->
        <h2 class="section-title">Vấn đề của khách hàng</h2>
        
        <div class="collapsible-section">
            <div class="section-header" data-target="section1">
                <div class="section-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h3 class="section-title-text">Khó khăn trong việc quản lý bãi đỗ xe</h3>
                <div class="toggle-btn">
                    <i class="fas fa-plus"></i>
                </div>
            </div>
            <div class="section-content" id="section1">
                <ul>
                    <li>Khó kiểm soát lưu lượng xe ra vào, đặc biệt vào giờ cao điểm</li>
                    <li>Không tối ưu được không gian đỗ xe, gây lãng phí diện tích</li>
                    <li>Thời gian tìm kiếm chỗ đỗ xe kéo dài, tạo ùn tắc và khó chịu cho người dùng</li>
                    <li>Các vấn đề bảo mật và an toàn chưa được đảm bảo, tiềm ẩn rủi ro mất cắp</li>
                    <li>Khó khăn trong việc quản lý hệ thống vé xe thủ công, dễ xảy ra sai sót</li>
                </ul>
            </div>
        </div>
        
        <div class="collapsible-section">
            <div class="section-header" data-target="section2">
                <div class="section-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3 class="section-title-text">Chi phí quản lý cao, hiệu quả thấp</h3>
                <div class="toggle-btn">
                    <i class="fas fa-plus"></i>
                </div>
            </div>
            <div class="section-content" id="section2">
                <ul>
                    <li>Chi phí vận hành nhân sự cao do phải bố trí nhiều nhân viên tại các điểm vào/ra</li>
                    <li>Thất thoát doanh thu do quản lý thủ công hoặc nhân viên không trung thực</li>
                    <li>Không có hệ thống báo cáo thống kê chính xác, gây khó khăn trong việc phân tích dữ liệu</li>
                    <li>Chi phí bảo trì và vận hành cao do sử dụng các thiết bị lạc hậu</li>
                    <li>Khó khăn trong việc tối ưu hóa doanh thu theo giờ cao điểm và thấp điểm</li>
                </ul>
            </div>
        </div>
        
        <div class="collapsible-section">
            <div class="section-header" data-target="section3">
                <div class="section-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="section-title-text">Trải nghiệm người dùng không tốt</h3>
                <div class="toggle-btn">
                    <i class="fas fa-plus"></i>
                </div>
            </div>
            <div class="section-content" id="section3">
                <ul>
                    <li>Người dùng mất thời gian chờ đợi tại điểm vào/ra trong giờ cao điểm</li>
                    <li>Không có thông tin về việc còn chỗ trống hay không, gây mất thời gian tìm kiếm</li>
                    <li>Thanh toán thủ công gây phiền phức và mất thời gian, tạo ùn tắc tại lối ra</li>
                    <li>Khó khăn trong việc tìm kiếm thông tin và hỗ trợ khi gặp sự cố</li>
                    <li>Thiếu các tiện ích hỗ trợ như đặt chỗ trước, thanh toán trực tuyến</li>
                </ul>
            </div>
        </div>
        
        <!-- Phần Giải pháp -->
        <h2 class="section-title">Giải pháp của SKT Parking</h2>
        
        <div class="collapsible-section">
            <div class="section-header" data-target="solution1">
                <div class="section-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h3 class="section-title-text">Công nghệ quản lý bãi đỗ xe thông minh</h3>
                <div class="toggle-btn">
                    <i class="fas fa-plus"></i>
                </div>
            </div>
            <div class="section-content" id="solution1">
                <p>SKT Parking cung cấp hệ thống quản lý hiện đại với camera nhận diện biển số xe và phần mềm quản lý chuyên nghiệp. Giải pháp của chúng tôi giúp tự động hóa toàn bộ quy trình ra vào, theo dõi thời gian đỗ và thanh toán, giảm thiểu sự can thiệp của con người và nâng cao hiệu quả vận hành.</p>
                <p>Hệ thống được thiết kế để hoạt động 24/7, đảm bảo tính ổn định và an toàn, đồng thời tích hợp các công nghệ bảo mật tiên tiến để bảo vệ dữ liệu và thông tin của khách hàng.</p>
            </div>
        </div>
        
        <div class="collapsible-section">
            <div class="section-header" data-target="solution2">
                <div class="section-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="section-title-text">Ứng dụng tìm kiếm chỗ đỗ xe</h3>
                <div class="toggle-btn">
                    <i class="fas fa-plus"></i>
                </div>
            </div>
            <div class="section-content" id="solution2">
                <p>SKT Parking phát triển ứng dụng di động thông minh cho phép người dùng dễ dàng tìm kiếm, đặt chỗ và thanh toán trước qua các phương thức thanh toán điện tử hiện đại.</p>
                <p>Ứng dụng cung cấp thông tin thời gian thực về tình trạng bãi đỗ xe, giúp người dùng tiết kiệm thời gian tìm kiếm và nâng cao trải nghiệm sử dụng. Ngoài ra, ứng dụng còn tích hợp các tính năng như tìm đường đến bãi đỗ xe, nhắc nhở thời gian hết hạn, và lịch sử đỗ xe để người dùng dễ dàng theo dõi.</p>
            </div>
        </div>
        
        <div class="collapsible-section">
            <div class="section-header" data-target="solution3">
                <div class="section-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="section-title-text">Hệ thống báo cáo thống kê chuyên sâu</h3>
                <div class="toggle-btn">
                    <i class="fas fa-plus"></i>
                </div>
            </div>
            <div class="section-content" id="solution3">
                <p>SKT Parking cung cấp hệ thống báo cáo chi tiết về tình hình sử dụng bãi đỗ xe, doanh thu theo từng khung giờ/ngày/tháng, giúp chủ bãi đỗ xe có cái nhìn tổng quan và chi tiết về hoạt động kinh doanh.</p>
                <p>Các báo cáo được hiển thị dưới dạng biểu đồ trực quan, dễ hiểu, hỗ trợ việc ra quyết định dựa trên dữ liệu. Chủ doanh nghiệp có thể truy cập báo cáo từ xa thông qua nền tảng web hoặc ứng dụng di động, giúp quản lý linh hoạt và hiệu quả.</p>
                <p>Hệ thống còn cung cấp các công cụ phân tích dữ liệu nâng cao, dự báo xu hướng và đề xuất các chiến lược tối ưu hóa doanh thu dựa trên mô hình AI.</p>
            </div>
        </div>

        <!-- Get in Touch Section -->
        <?php include 'getintouch.php' ?>
    </div>    
    <!-- Footer -->
    <?php include 'footer.php' ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Script -->
    <script src="./js/about.js"></script>
</body>
</html>