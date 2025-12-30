<?php
?>
<!-- Content Area -->
<div class="col-lg-9">
    <div class="content-area">
        <div class="content-header">
            <h2 class="content-title">Tổng quan tài khoản</h2>
            <div class="content-actions">
                <button class="btn btn-orange" id="newBookingBtn">
                    <i class="fas fa-plus me-2"></i>Đặt chỗ mới
                </button>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="alert alert-dismissible animated-card"
            style="background-color: rgba(255, 127, 0, 0.1); border: 1px solid rgba(255, 127, 0, 0.3); color: #fff; border-radius: 10px; position: relative; padding: 15px 20px; margin-bottom: 30px;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                style="position: absolute; top: 15px; right: 15px; color: #fff; opacity: 0.7;"></button>
            <h5 style="color: #ff7f00; margin-bottom: 10px; font-weight: bold;">
                <i class="fas fa-hand-sparkles me-2"></i>Chào mừng trở lại, Nguyễn Văn A!
            </h5>
            <p style="margin-bottom: 5px;">
                <i class="fas fa-bell-on me-2" style="color: #ff7f00;"></i>Bạn có <strong>3 thông báo
                    mới</strong> và <strong>1 chỗ đỗ xe đang hoạt động</strong>.
            </p>
            <p style="margin-bottom: 5px;">
                <i class="fas fa-star me-2" style="color: #ff7f00;"></i>Điểm thưởng hiện tại của bạn:
                <strong>520 điểm</strong> (Thiếu 280 điểm để đạt cấp độ tiếp theo)
            </p>
            <p style="margin-bottom: 0;">
                <i class="fas fa-calendar-check me-2" style="color: #ff7f00;"></i>Lần đặt chỗ gần nhất:
                <strong>15/03/2025</strong> tại <strong>Landmark 81</strong>
            </p>
        </div>

        <!-- Account Stats -->
        <div class="account-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="stat-value">12</div>
                <div class="stat-label">Lịch sử đặt chỗ</div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i> +3
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value">1</div>
                <div class="stat-label">Đặt chỗ hiện tại</div>
                <div class="stat-trend down">
                    <i class="fas fa-arrow-down"></i> -1
                </div>
            </div>  
        </div>

        <!-- Featured Parking Lots -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 style="font-size: 1.3rem; color: #fff;">Bãi đỗ xe gợi ý</h3>
                <a href="#" style="color: #ff7f00; text-decoration: none; font-size: 0.9rem;">Xem tất cả
                    <i class="fas fa-chevron-right ms-1"></i></a>
            </div>

            <!-- Swiper -->
            <div class="swiper featuredSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="/api/placeholder/400/250" alt="Parking Lot" class="slide-image">
                        <div class="slide-content">
                            <div class="slide-title">Landmark 81</div>
                            <div class="slide-info"><i class="fas fa-map-marker-alt"></i> Bình Thạnh,
                                TP.HCM</div>
                            <div class="slide-info"><i class="fas fa-car"></i> 200 chỗ trống</div>
                            <div class="slide-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="slide-rating-value">4.5/5</span>
                            </div>
                            <button class="btn btn-sm btn-orange slide-button">Đặt ngay</button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="/api/placeholder/400/250" alt="Parking Lot" class="slide-image">
                        <div class="slide-content">
                            <div class="slide-title">Aeon Mall Tân Phú</div>
                            <div class="slide-info"><i class="fas fa-map-marker-alt"></i> Tân Phú,
                                TP.HCM</div>
                            <div class="slide-info"><i class="fas fa-car"></i> 150 chỗ trống</div>
                            <div class="slide-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="slide-rating-value">4.0/5</span>
                            </div>
                            <button class="btn btn-sm btn-orange slide-button">Đặt ngay</button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="/api/placeholder/400/250" alt="Parking Lot" class="slide-image">
                        <div class="slide-content">
                            <div class="slide-title">Vincom Center</div>
                            <div class="slide-info"><i class="fas fa-map-marker-alt"></i> Quận 1, TP.HCM
                            </div>
                            <div class="slide-info"><i class="fas fa-car"></i> 80 chỗ trống</div>
                            <div class="slide-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="slide-rating-value">4.8/5</span>
                            </div>
                            <button class="btn btn-sm btn-orange slide-button">Đặt ngay</button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="/api/placeholder/400/250" alt="Parking Lot" class="slide-image">
                        <div class="slide-content">
                            <div class="slide-title">Vivo City</div>
                            <div class="slide-info"><i class="fas fa-map-marker-alt"></i> Quận 7, TP.HCM
                            </div>
                            <div class="slide-info"><i class="fas fa-car"></i> 120 chỗ trống</div>
                            <div class="slide-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="slide-rating-value">4.2/5</span>
                            </div>
                            <button class="btn btn-sm btn-orange slide-button">Đặt ngay</button>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>   
        <!-- Quick Actions -->
        <div>
            <h3 style="font-size: 1.3rem; color: #fff; margin-bottom: 20px;">Thao tác nhanh</h3>

            <div class="row g-3">
                <div class="col-md-4">
                    <a href="#" class="quick-action-card text-center p-4 d-block">
                        <div class="quick-action-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h5 class="quick-action-title">Đặt chỗ mới</h5>
                        <p class="quick-action-desc">Tìm và đặt chỗ đỗ xe ngay</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="quick-action-card text-center p-4 d-block">
                        <div class="quick-action-icon">
                            <i class="fas fa-car-alt"></i>
                        </div>
                        <h5 class="quick-action-title">Thêm xe mới</h5>
                        <p class="quick-action-desc">Đăng ký phương tiện của bạn</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="quick-action-card text-center p-4 d-block">
                        <div class="quick-action-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h5 class="quick-action-title">Tìm bãi đỗ xe</h5>
                        <p class="quick-action-desc">Xem bản đồ các bãi đỗ xe</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>