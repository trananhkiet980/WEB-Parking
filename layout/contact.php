<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ - SKT Parking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="./css/contact.css">
</head>

<body>
    <?php include 'navbar.php' ?>

    <div class="container">
        <div class="hero-banner" style="background-image: url('/api/placeholder/1920/1080');">
            <div class="hero-overlay">
                <div class="hero-title">
                    <h1>Liên Hệ Với Chúng Tôi</h1>
                    <p class="hero-subtitle">Chúng tôi luôn sẵn sàng trả lời mọi thắc mắc và đồng hành cùng bạn xây dựng
                        giải pháp quản lý bãi đỗ xe hoàn hảo.</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item">Liên hệ</li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="contact-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-5 mb-4">
                        <h3 class="section-title">Thông Tin Liên Hệ</h3>

                        <div class="contact-info">
                            <div class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-text">
                                    <strong>Thành phố Hồ Chí Minh</strong>
                                    <small>12 Nguyễn Hữu Thọ, Tân Hưng, Quận 7, Hồ Chí Minh</small>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-text">
                                    <strong>Thành phố Hà Nội</strong>
                                    <small>268 Đội Cấn, Liễu Giai, Đống Đa, Hà Nội</small>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="contact-text">
                                    <strong>Hotline</strong>
                                    <small>+84 924 031 093</small>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-text">
                                    <strong>Email</strong>
                                    <small>nguyentansang@gmail.com</small>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="contact-text">
                                    <strong>Giờ làm việc</strong>
                                    <small>Thứ Hai - Thứ Sáu: 8:00 - 17:30<br>Thứ Bảy: 8:00 - 12:00</small>
                                </div>
                            </div>
                        </div>

                        <div class="social-links">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-7">
                        <div class="contact-form-section">
                            <h4 class="form-heading">Gửi Tin Nhắn Cho Chúng Tôi</h4>

                            <form class="contact-form" id="contactForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Họ và tên</label>
                                            <input type="text" class="form-control" name="ho_ten"
                                                placeholder="Nhập họ và tên của bạn" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Nhập địa chỉ email" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" name="so_dien_thoai"
                                        placeholder="Nhập số điện thoại">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Bạn là</label>
                                    <div class="radio-group">
                                        <label class="radio-container">Khách hàng
                                            <input type="radio" name="user_type" value="Khách hàng" checked>
                                            <span class="radio-checkmark"></span>
                                        </label>
                                        <label class="radio-container">Đối tác
                                            <input type="radio" name="user_type" value="Đối tác">
                                            <span class="radio-checkmark"></span>
                                        </label>
                                        <label class="radio-container">Nhà đầu tư
                                            <input type="radio" name="user_type" value="Nhà đầu tư">
                                            <span class="radio-checkmark"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Nội dung</label>
                                    <textarea class="form-control" rows="6" name="noi_dung"
                                        placeholder="Nhập nội dung tin nhắn" required></textarea>
                                </div>

                                <button type="submit" class="submit-btn" id="submitBtn">Gửi Tin Nhắn</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="map-section">
            <div class="container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.9551578053897!2d106.69978287469857!3d10.732139089415999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f9ff1e6adb3%3A0x89b46cb963766e86!2zMTIgTmd1eeG7hW4gSOG7r3UgVGjhu40sIFTDom4gSOawsG5nLCBRdeG6rW4gNywgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1709730242899!5m2!1svi!2s" class="map-container" allowfullscreen=""
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>

        <section class="faq-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <h2 class="section-title mx-auto" style="display: inline-block;">Câu Hỏi Thường Gặp</h2>
                        <p class="text-muted">Những câu hỏi thường được khách hàng quan tâm</p>
                    </div>

                    <div class="col-lg-10 mx-auto">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item bg-dark mb-3 border-0 rounded overflow-hidden">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed bg-dark text-white" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        <i class="fas fa-question-circle text-warning me-2"></i>
                                        Làm thế nào để triển khai hệ thống SKT Parking tại doanh nghiệp?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body bg-dark text-light">
                                        Quy trình triển khai SKT Parking tại doanh nghiệp của bạn bao gồm 4 bước chính: (1)
                                        Khảo sát và đánh giá nhu cầu, (2) Tư vấn giải pháp phù hợp, (3) Lắp đặt và cài đặt
                                        hệ thống, (4) Đào tạo nhân viên và bàn giao. Đội ngũ chuyên gia của chúng tôi sẽ đồng
                                        hành cùng bạn trong suốt quá trình này để đảm bảo hệ thống hoạt động hiệu quả và đáp
                                        ứng đúng nhu cầu của doanh nghiệp.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item bg-dark mb-3 border-0 rounded overflow-hidden">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed bg-dark text-white" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <i class="fas fa-question-circle text-warning me-2"></i>
                                        Chi phí triển khai giải pháp SKT Parking là bao nhiêu?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body bg-dark text-light">
                                        Chi phí triển khai phụ thuộc vào nhiều yếu tố như quy mô bãi đỗ xe, số lượng làn
                                        vào/ra, các tính năng bổ sung và mức độ tích hợp với các hệ thống khác. Chúng tôi
                                        cung cấp nhiều gói giải pháp với mức giá linh hoạt, phù hợp với ngân sách và nhu cầu
                                        của từng doanh nghiệp. Vui lòng liên hệ với chúng tôi để được tư vấn chi tiết và
                                        nhận báo giá phù hợp nhất.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item bg-dark mb-3 border-0 rounded overflow-hidden">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed bg-dark text-white" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        <i class="fas fa-question-circle text-warning me-2"></i>
                                        SKT Parking có thể tích hợp với hệ thống quản lý tòa nhà không?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body bg-dark text-light">
                                        Có, SKT Parking được thiết kế để dễ dàng tích hợp với hầu hết các hệ thống quản lý
                                        tòa nhà (BMS) phổ biến hiện nay. Chúng tôi sử dụng các API mở và chuẩn kết nối hiện
                                        đại để đảm bảo khả năng tương thích cao với các hệ thống khác như kiểm soát vào ra,
                                        quản lý an ninh, hệ thống thanh toán và phần mềm quản lý doanh nghiệp.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item bg-dark border-0 rounded overflow-hidden">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed bg-dark text-white" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        <i class="fas fa-question-circle text-warning me-2"></i>
                                        Làm thế nào để tải ứng dụng di động SKT Parking?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body bg-dark text-light">
                                        Ứng dụng di động SKT Parking hiện có sẵn trên cả App Store (cho người dùng iOS) và
                                        Google Play (cho người dùng Android). Bạn chỉ cần tìm kiếm "SKT Parking" trên cửa
                                        hàng ứng dụng và nhấn nút tải xuống. Sau khi cài đặt, bạn có thể đăng ký tài khoản
                                        mới hoặc đăng nhập với tài khoản hiện có để bắt đầu sử dụng các tính năng như tìm
                                        kiếm bãi đỗ xe, đặt chỗ trước và thanh toán trực tuyến.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include 'getintouch.php' ?>
    </div>


    <?php include 'footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Ngăn form gửi theo cách mặc định

            const form = this;

            const submitBtn = document.getElementById('submitBtn');
            const formData = new FormData(form);


            // Disable the submit button and change its text
            submitBtn.disabled = true;
            submitBtn.textContent = 'Đang gửi...';

            fetch('../dao/contact.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text(); // or response.json() if server sends JSON
                })
                .then(data => {
                    console.log('Success:', data);
                    submitBtn.textContent = 'Đã gửi';

                    // Wait 5 seconds and reload
                    setTimeout(() => {
                        window.location.reload();
                    }, 5000);

                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Gửi Tin Nhắn';
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                });
        });
    </script>
</body>

</html>