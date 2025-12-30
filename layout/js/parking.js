document.addEventListener('DOMContentLoaded', function () {
    function closeBookingsForm() {
        // Sửa lỗi: document.getElementByClass -> document.getElementsByClassName
        const bookingForms = document.getElementsByClassName('booking-form');
        if (bookingForms.length > 0) {
            bookingForms[0].style.display = 'none';
        }
    }
    let currentPage = 1;
    const itemsPerPage = 10;
    let isLoading = false;
    let parkingLots = [];

    document.querySelectorAll('.parking-card').forEach(card => {
        card.classList.add('animated');
    });

    function initializeParkingCards() {
        console.log(parkingLots)
        const parkingCards = document.querySelectorAll('.parking-card');
        parkingCards.forEach(card => {
            card.addEventListener('click', function (e) {
                if (!e.target.closest('.close-details') && !e.target.closest('.book-btn')) {
                    this.classList.toggle('active');
                }
            });

            const bookBtn = card.querySelector('.book-btn');

            if (bookBtn) {
                bookBtn.addEventListener('click', function (e) {
                    console.log('book button clicked');
                    e.stopPropagation();
                    const lotId = card.dataset.id;
                    const lot = parkingLots.find(l => l.parking_id === parseInt(lotId, 10));
                    console.log(lotId); // Kiểm tra dữ liệu
                    console.log(lot); // Kiểm tra dữ liệu
                    if (lot) {
                        renderBookingForm(lot);
                    }
                });
            }
        });

        document.querySelectorAll('.close-details').forEach(close => {
            close.addEventListener('click', function (e) {
                e.stopPropagation();
                this.closest('.parking-card').classList.remove('active');
            });
        });
    }

    function renderParkingCards(parkingLots) {
        let html = '';
        if (parkingLots.length > 0) {
            parkingLots.forEach(lot => {
                const statusClass = lot.status === 'available' ? 'status-available' : 'status-full';
                const statusText = lot.status === 'available' ? 'Còn chỗ trống' : 'Đã đầy';
                html += `
                    <div class="parking-card" data-id="${lot.parking_id}">
                        <img src="${lot.image_url || 'img/logo.png'}" alt="${lot.name}" class="parking-image">
                        <div class="parking-info">
                            <span class="parking-name">${lot.name} 
                                <span class="distance">(${lot.distance || 0} km)</span> 
                                <br> 
                                <span class="occupancy">${lot.occupied_slots}/${lot.capacity}</span>
                                <span style="font-size: 0.8em; color: #555;">${lot.pricePerHour}.000VNĐ/1 giờ</span>                            
                            </span>
                            <div class="toggle-details">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div class="parking-details">
                            <div class="close-details">
                                <i class="fas fa-times"></i>
                            </div>
                            <h3 class="details-title">Bãi đỗ xe ${lot.name}</h3>
                            <div class="details-info">
                                <p><i class="fas fa-map-marker-alt"></i> ${lot.address}</p>
                                <p><i class="fas fa-car"></i> Số chỗ: ${lot.occupied_slots}/${lot.capacity}</p>
                                <div>
                                    <i class="fas fa-money-bill-wave" style="color: #ff7f00"></i> Giá: ${lot.pricePerHour}.000VNĐ/1giờ                                    
                                    <i class="fas fa-clock" style="color: #ff7f00"></i> Hoạt động: ${lot.operating_hours}
                                </div>
                                <div class="status-badge ${statusClass}">${statusText}</div>
                                <button class="book-btn ${lot.status === 'full' ? 'disabled-btn' : ''}" ${lot.status === 'full' ? 'disabled' : ''}>Đặt chỗ ngay</button>
                            </div>
                        </div>
                    </div>
                `;
            });
        } else {
            html = '<p>Không có bãi đỗ xe nào phù hợp với bộ lọc.</p>';
        }
        return html;
    }

    function filterParkingLots(page = 1) {
        if (isLoading) return;
        isLoading = true;
        const filterForm = document.querySelector('#filter-form');
        const search = filterForm.querySelector('input[name="search"]').value;
        const district = filterForm.querySelector('select[name="district"]').value;
        const status = filterForm.querySelector('select[name="status"]').value;
        const sort = filterForm.querySelector('select[name="sort"]').value;
        const userLatitude = document.getElementById('user_latitude').value || '10.7380779';
        const userLongitude = document.getElementById('user_longitude').value || '106.6995689';

        const parkingGrid = document.querySelector('.parking-grid');
        if (parkingGrid) {
            parkingGrid.classList.add('loading-state');
        }

        const url = `../dao/parking-lots-api.php?action=filter&search=${encodeURIComponent(search)}&district=${encodeURIComponent(district)}&status=${encodeURIComponent(status)}&sort=${encodeURIComponent(sort)}&user_latitude=${encodeURIComponent(userLatitude)}&user_longitude=${encodeURIComponent(userLongitude)}&page=${page}&limit=${itemsPerPage}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    parkingGrid.innerHTML = '<p>Có lỗi xảy ra. Vui lòng thử lại sau.</p>';
                    return;
                }
                if (parkingGrid) {
                    parkingGrid.innerHTML = renderParkingCards(data.parking_lots);
                    initializeParkingCards();
                    document.querySelectorAll('.parking-card').forEach(card => {
                        card.classList.add('animated');
                    });
                    renderPagination(data.page, data.total_pages);
                }
                currentPage = data.page;
                parkingLots = data.parking_lots;
            })
            .catch(error => {
                console.error('Lỗi:', error);
                parkingGrid.innerHTML = '<p>Có lỗi xảy ra. Vui lòng thử lại sau.</p>';
            })
            .finally(() => {
                isLoading = false;
                if (parkingGrid) {
                    parkingGrid.classList.remove('loading-state');
                }
            });
    }

    function renderPagination(currentPage, totalPages) {
        const parkingGrid = document.querySelector('.parking-grid');
        const paginationContainer = document.createElement('div');
        paginationContainer.className = 'pagination';

        const prevButton = document.createElement('button');
        prevButton.textContent = 'Trang trước';
        prevButton.disabled = currentPage === 1;
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                filterParkingLots(currentPage - 1);
            }
        });
        paginationContainer.appendChild(prevButton);

        const pageInfo = document.createElement('span');
        pageInfo.textContent = `Trang ${currentPage} / ${totalPages}`;
        paginationContainer.appendChild(pageInfo);

        const nextButton = document.createElement('button');
        nextButton.textContent = 'Trang sau';
        nextButton.disabled = currentPage === totalPages;
        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                filterParkingLots(currentPage + 1);
            }
        });
        paginationContainer.appendChild(nextButton);

        const existingPagination = document.querySelector('.pagination');
        if (existingPagination) {
            existingPagination.remove();
        }
        parkingGrid.after(paginationContainer);
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                document.getElementById('user_latitude').value = latitude;
                document.getElementById('user_longitude').value = longitude;
                filterParkingLots(currentPage);
            },
            function (error) {
                console.error('Lỗi lấy vị trí ban đầu:', error.message);
                document.getElementById('user_latitude').value = '10.7380779';
                document.getElementById('user_longitude').value = '106.6995689';
                filterParkingLots(currentPage);
            }
        );
    } else {
        console.error('Trình duyệt không hỗ trợ định vị.');
        document.getElementById('user_latitude').value = '10.7380779';
        document.getElementById('user_longitude').value = '106.6995689';
        filterParkingLots(currentPage);
    }

    const getLocationBtn = document.getElementById('get-location-btn');
    if (getLocationBtn) {
        getLocationBtn.addEventListener('click', function () {
            if (navigator.geolocation) {
                getLocationBtn.disabled = true;
                getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Đang lấy vị trí...';

                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        document.getElementById('user_latitude').value = latitude;
                        document.getElementById('user_longitude').value = longitude;

                        getLocationBtn.disabled = false;
                        getLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt me-2"></i> Lấy vị trí tự động';
                        filterParkingLots(currentPage);
                    },
                    function (error) {
                        console.error('Lỗi lấy vị trí:', error.message);
                        alert('Không thể lấy vị trí. Vui lòng kiểm tra quyền truy cập hoặc thử lại.');
                        getLocationBtn.disabled = false;
                        getLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt me-2"></i> Lấy vị trí tự động';
                    }
                );
            } else {
                alert('Trình duyệt của bạn không hỗ trợ định vị.');
            }
        });
    }

    const filterForm = document.querySelector('#filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            currentPage = 1;
            filterParkingLots(currentPage);
        });
    }

    // Khai báo hàm hiển thị thông báo
    // Các hàm thông báo này sử dụng bởi booking form
    // Cần khai báo trước khi định nghĩa renderBookingForm
    function renderNotificationForm(notification) {
        // Tạo container cho form thông báo
        const notificationForm = document.createElement('div');
        notificationForm.className = 'notification-form';
        notificationForm.setAttribute('data-type', notification.type || 'info');
        
        // Định nghĩa các icon cho các loại thông báo
        const notificationIcons = {
            success: '<i class="fas fa-check-circle"></i>',
            warning: '<i class="fas fa-exclamation-triangle"></i>',
            info: '<i class="fas fa-info-circle"></i>',
            error: '<i class="fas fa-times-circle"></i>'
        };
        
        // Lấy icon phù hợp với loại thông báo
        const icon = notificationIcons[notification.type] || notificationIcons.info;
        
        // Tạo nội dung HTML cho form
        notificationForm.innerHTML = `
            <div class="notification-form-content">
                <div class="notification-header">
                    <div class="notification-title">
                        ${icon} <h3>${notification.title}</h3>
                    </div>
                    <div class="close-notification-form">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="notification-body">
                    <p>${notification.message}</p>
                    ${notification.details ? `<div class="notification-details">${notification.details}</div>` : ''}
                </div>
                <div class="notification-actions">
                    ${notification.confirmButton ? 
                        `<button class="confirm-btn">${notification.confirmButton}</button>` : ''}
                    ${notification.cancelButton ? 
                        `<button class="cancel-btn">${notification.cancelButton}</button>` : ''}
                </div>
            </div>
        `;
        
        // Thêm form vào body
        document.body.appendChild(notificationForm);
        
        // Tạo hiệu ứng xuất hiện
        setTimeout(() => {
            notificationForm.classList.add('visible');
        }, 10);
        
        // Kéo form (ví dụ cơ bản)
        let isDragging = false;
        let offsetX, offsetY;
        const formHeader = notificationForm.querySelector('.notification-header');
        
        formHeader.addEventListener('mousedown', function(e) {
            // Chỉ kéo khi bấm vào header, không phải nút đóng
            if (e.target.closest('.close-notification-form')) return;
            
            isDragging = true;
            offsetX = e.clientX - notificationForm.getBoundingClientRect().left;
            offsetY = e.clientY - notificationForm.getBoundingClientRect().top;
            formHeader.style.cursor = 'grabbing';
        });
        
        document.addEventListener('mouseup', function() {
            isDragging = false;
            if (formHeader) formHeader.style.cursor = 'grab';
        });
        
        document.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            notificationForm.style.left = e.clientX - offsetX + 'px';
            notificationForm.style.top = e.clientY - offsetY + 'px';
        });
        
        // Xử lý đóng form
        const closeBtn = notificationForm.querySelector('.close-notification-form');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                closeNotificationForm(notificationForm);
            });
        }
        
        // Xử lý nút xác nhận
        const confirmBtn = notificationForm.querySelector('.confirm-btn');
        if (confirmBtn && notification.onConfirm) {
            confirmBtn.addEventListener('click', function() {
                notification.onConfirm();
                closeNotificationForm(notificationForm);
            });
        }
        
        // Xử lý nút hủy
        const cancelBtn = notificationForm.querySelector('.cancel-btn');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                if (notification.onCancel) notification.onCancel();
                closeNotificationForm(notificationForm);
            });
        }
        
        // Đóng form tự động nếu có thời gian tự đóng
        if (notification.autoClose) {
            setTimeout(() => {
                if (document.body.contains(notificationForm)) {
                    closeNotificationForm(notificationForm);
                }
            }, notification.autoClose);
        }
        
        return notificationForm;
    }

    // Hàm đóng form thông báo với hiệu ứng
    function closeNotificationForm(form) {
        form.classList.remove('visible');
        form.classList.add('closing');
        
        // Đợi hiệu ứng kết thúc rồi xóa form
        setTimeout(() => {
            if (document.body.contains(form)) {
                document.body.removeChild(form);
            }
        }, 300); // Thời gian phải khớp với transition trong CSS
    }

    // Hiển thị thông báo thành công
    function showSuccessNotification(message, options = {}) {
        return renderNotificationForm({
            type: 'success',
            title: options.title || 'Thành công',
            message: message,
            details: options.details || null,
            confirmButton: options.confirmButton || 'OK',
            autoClose: options.autoClose || 3000, // Tự đóng sau 3 giây
            onConfirm: options.onConfirm || null
        });
    }

    // Hiển thị thông báo cảnh báo
    function showWarningNotification(message, options = {}) {
        return renderNotificationForm({
            type: 'warning',
            title: options.title || 'Cảnh báo',
            message: message,
            details: options.details || null,
            confirmButton: options.confirmButton || 'OK',
            cancelButton: options.cancelButton || null,
            autoClose: options.autoClose || null, // Không tự đóng
            onConfirm: options.onConfirm || null,
            onCancel: options.onCancel || null
        });
    }

    // Hiển thị thông báo lỗi
    function showErrorNotification(message, options = {}) {
        return renderNotificationForm({
            type: 'error',
            title: options.title || 'Lỗi',
            message: message,
            details: options.details || null,
            confirmButton: options.confirmButton || 'OK',
            autoClose: options.autoClose || null, // Không tự đóng
            onConfirm: options.onConfirm || null
        });
    }

    // Hiển thị thông báo thông tin
    function showInfoNotification(message, options = {}) {
        return renderNotificationForm({
            type: 'info',
            title: options.title || 'Thông báo',
            message: message,
            details: options.details || null,
            confirmButton: options.confirmButton || 'OK',
            cancelButton: options.cancelButton || null,
            autoClose: options.autoClose || 8000, // Tự đóng sau 8 giây
            onConfirm: options.onConfirm || null,
            onCancel: options.onCancel || null
        });
    }

    // Hiển thị hộp thoại xác nhận
    function showConfirmDialog(message, onConfirm, options = {}) {
        return renderNotificationForm({
            type: 'info',
            title: options.title || 'Xác nhận',
            message: message,
            details: options.details || null,
            confirmButton: options.confirmButton || 'Xác nhận',
            cancelButton: options.cancelButton || 'Hủy',
            autoClose: null, // Không tự đóng
            onConfirm: onConfirm,
            onCancel: options.onCancel || null
        });
    }

    function renderBookingForm(lot) {
        // Xóa form booking cũ nếu đã tồn tại
        const existingForm = document.querySelector('.booking-form');
        if (existingForm) {
            existingForm.remove();
        }
        
        // Xóa overlay cũ nếu đã tồn tại
        const existingOverlay = document.querySelector('.booking-form-overlay');
        if (existingOverlay) {
            existingOverlay.remove();
        }
        
        const bookingForm = document.createElement('div');
        bookingForm.className = 'booking-form';
        bookingForm.innerHTML = `
            <div class="booking-form-content">
                <div class="close-booking-form">
                    <i class="fas fa-times"></i>
                </div>
                <h3>Đặt chỗ xe tại ${lot.name}</h3>
                <p>Địa chỉ: ${lot.address}</p>
                <p>Số chỗ: ${lot.occupied_slots}/${lot.capacity}</p>
                <p>Giờ hoạt động: ${lot.operating_hours}</p>
                <label for="booking-hours">Số giờ thuê:</label>
                <input type="number" id="booking-hours" value="1" min="1">
                <p>Giá: <span id="booking-price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(lot.pricePerHour * 1000)}/giờ</span></p>
                <button id="payment-btn">Thanh toán</button>
            </div>
        `;
        document.body.appendChild(bookingForm);
    
        // Định vị form ở giữa màn hình
        bookingForm.style.position = 'fixed';
        bookingForm.style.left = '50%';
        bookingForm.style.top = '50%';
        bookingForm.style.transform = 'translate(-50%, -50%)';
        bookingForm.style.zIndex = '1000'; // Đảm bảo form ở trên các phần tử khác
        bookingForm.style.cursor = 'grab'; // Đặt con trỏ mặc định là 'grab'
    
        // Thêm lớp phủ (overlay) để ngăn tương tác với background
        const overlay = document.createElement('div');
        overlay.className = 'booking-form-overlay';
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)'; // Màu đen với độ trong suốt
        overlay.style.zIndex = '999'; // Dưới form nhưng trên các phần tử khác
        document.body.appendChild(overlay);
    
        // Hàm rung lắc form - Sửa lỗi animation
        function shakeForm() {
            // Xóa class để reset animation nếu đã có
            bookingForm.classList.remove('shake');
            
            // Sử dụng setTimeout để đảm bảo reflow và animation reset
            setTimeout(() => {
                bookingForm.classList.add('shake');
            }, 10);
            
            // Xóa class sau khi animation kết thúc
            setTimeout(() => {
                bookingForm.classList.remove('shake');
            }, 510); // 510ms (500ms animation + 10ms delay)
        }
    
        // Ngăn chặn sự kiện click lan ra ngoài form (để không rung khi click bên trong)
        bookingForm.querySelector('.booking-form-content').addEventListener('mousedown', function(event) {
            event.stopPropagation();
        });
    
        // Xử lý sự kiện click bên ngoài form (trên overlay)
        overlay.addEventListener('mousedown', shakeForm);
    
        // Đóng form
        bookingForm.querySelector('.close-booking-form').addEventListener('click', function () {
            bookingForm.remove();
            overlay.remove(); // Xóa cả lớp phủ
        });
    
        // Ngăn chặn hành vi kéo mặc định
        bookingForm.addEventListener('dragstart', function(e) {
            e.preventDefault();
        });
    
        // Tính toán giá tiền
        const bookingHoursInput = bookingForm.querySelector('#booking-hours');
        const bookingPriceSpan = bookingForm.querySelector('#booking-price');
    
        bookingHoursInput.addEventListener('input', function () {
            const hours = parseInt(this.value, 10) || 1;
            const pricePerHour = lot.pricePerHour || 0;
            const totalPrice = pricePerHour * hours;
            bookingPriceSpan.textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(totalPrice * 1000) + '/giờ';
        });
    
        // Thanh toán và lưu thông tin - Sử dụng thông báo nâng cao
        const paymentBtn = bookingForm.querySelector('#payment-btn');
        if (paymentBtn) {
            paymentBtn.addEventListener('click', function() {
                const hours = parseInt(bookingForm.querySelector('#booking-hours').value, 10) || 1;
                const pricePerHour = lot.pricePerHour || 0;
                const totalFee = pricePerHour * hours;
                const parkingId = lot.parking_id;
                const startTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
                
                // Hiển thị thông báo đang xử lý
                const loadingNotification = showInfoNotification('Đang xử lý thanh toán...', {
                    autoClose: null,
                    confirmButton: null
                });
                
                // Gửi yêu cầu AJAX đến backend
                fetch('../dao/bookings-api.php', {
                    method: 'POST',
                    body: (() => {
                        const formData = new FormData();
                        formData.append('parking_id', parkingId);
                        formData.append('start_time', startTime);
                        formData.append('duration_hours', hours);
                        formData.append('pricePerHour', pricePerHour);
                        formData.append('total_fee', totalFee);
                        return formData;
                    })()
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(data => {
                    console.log('Phản hồi từ server:', data);
                    
                    // Đóng thông báo đang xử lý
                    closeNotificationForm(loadingNotification);
                    
                    if (data === 'Đặt chỗ thành công') {
                        // Hiển thị thông báo thành công
                        showSuccessNotification('<strong>Thanh toán thành công!', {
                            title: 'Đặt chỗ thành công',
                            details: `
                                <div style="background-color: #000; color: #f0f0f0; padding: 10px; border-radius: 5px;">
                                    <p><strong><span style="color: #ddd;">Bãi đỗ:</span></strong> ${lot.name}</p>
                                    <p><strong><span style="color: #ddd;">Thời gian:</span></strong> ${hours} giờ</p>
                                    <p><strong><span style="color: #ddd;">Phí:</span></strong> ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(totalFee * 1000)}</p>
                                    <p><strong><span style="color: #ddd;">Thời gian bắt đầu:</span></strong> <span style="color: #8fbc8f;">${new Date().toLocaleString('vi-VN')}</span></p>
                                </div>
                            `,
                            onConfirm: () => {
                                location.reload();
                            }
                        });
                        
                        // Đóng form đặt chỗ
                        bookingForm.remove();
                        overlay.remove();
                        
                        setTimeout(() => {
                            window.location.reload(); // Reload trang sau 3 seconds
                        }, 3000);
                    } else {
                        // Hiển thị thông báo lỗi
                        showErrorNotification('Thanh toán thất bại. Vui lòng thử lại sau.', {
                            details: data || 'Không nhận được phản hồi chi tiết từ máy chủ.'
                        });
                    }
                })
                .catch(error => {
                    console.error('Lỗi thanh toán:', error);
                    
                    // Đóng thông báo đang xử lý
                    closeNotificationForm(loadingNotification);
                    
                    // Hiển thị thông báo lỗi
                    showErrorNotification('Có lỗi xảy ra. Vui lòng thử lại sau.', {
                        details: error.message
                    });
                });
            });
        }
    
        return bookingForm;
    }
    
    // Thêm CSS để tạo hiệu ứng và kiểu dáng
    const style = document.createElement('style');
    style.innerHTML = `
        .booking-form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 400px; /* Điều chỉnh độ rộng tùy ý */
            font-family: sans-serif;
            box-sizing: border-box;
            cursor: grab; /* Đặt con trỏ mặc định là 'grab' */
            position: fixed; /* Đảm bảo cố định ở giữa */
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
    
        .booking-form-content {
            position: relative;
        }
    
        .close-booking-form {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 1.2em;
            color: #555;
        }
    
        .close-booking-form:hover {
            color: #333;
        }
    
        .booking-form h3 {
            margin-top: 0;
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }
    
        .booking-form p {
            margin-bottom: 8px;
            color: #666;
        }
    
        .booking-form label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
    
        .booking-form input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    
        #payment-btn {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
            position: static; /* Đảm bảo không bị dịch chuyển */
            transform: none;
            translate: none;
        }
    
        #payment-btn:hover {
            background-color: #0056b3;
        }
    
        #payment-btn:active {
            background-color: #004080; /* Màu đậm hơn khi active */
            transform: scale(0.98); /* Hiệu ứng nhỏ lại khi nhấn */
            transition: transform 0.1s ease-in-out; /* Thêm transition cho mượt mà */
        }
    
        /* Hiệu ứng rung lắc - Sửa lỗi animation */
        @keyframes shake {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            10% { transform: translate(-50%, -50%) rotate(-1deg); }
            20% { transform: translate(-50%, -50%) rotate(1deg); }
            30% { transform: translate(-50%, -50%) rotate(0deg); }
            40% { transform: translate(-50%, -50%) rotate(1deg); }
            50% { transform: translate(-50%, -50%) rotate(-1deg); }
            60% { transform: translate(-50%, -50%) rotate(0deg); }
            70% { transform: translate(-50%, -50%) rotate(-1deg); }
            80% { transform: translate(-50%, -50%) rotate(1deg); }
            90% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(0deg); }
        }
        
        .shake {
            animation: shake 0.5s;
        }
    
        .booking-form-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        /* CSS cho notification form */
        .notification-form {
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            min-width: 300px;
            max-width: 500px;
            width: auto;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .notification-form.visible {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
        
        .notification-form.closing {
            opacity: 0;
            transform: translateX(-50%) translateY(-20px);
        }
        
        .notification-form-content {
            padding: 20px;
        }
        
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
            cursor: grab;
        }
        
        .notification-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .notification-title h3 {
            margin: 0;
            font-size: 18px;
        }
        
        .notification-title i {
            font-size: 20px;
        }
        
        .close-notification-form {
            cursor: pointer;
            font-size: 16px;
            color: #666;
        }
        
        .notification-body {
            margin-bottom: 15px;
        }
        
        .notification-body p {
            margin: 0 0 10px 0;
        }
        
        .notification-details {
            background-color: #f5f5f5;
            border-radius: 4px;
            padding: 10px;
            margin-top: 10px;
            font-size: 0.9em;
        }
        
        .notification-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .notification-actions button {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 500;
        }
        
        .confirm-btn {
            background-color: #4CAF50;
            color: white;
        }
        
        .cancel-btn {
            background-color: #f44336;
            color: white;
        }
        
        /* Các định dạng theo loại thông báo */
        .notification-form[data-type="success"] .notification-title i {
            color: #4CAF50;
        }
        
        .notification-form[data-type="warning"] .notification-title i {
            color: #FF9800;
        }
        
        .notification-form[data-type="error"] .notification-title i {
            color: #f44336;
        }
        
        .notification-form[data-type="info"] .notification-title i {
            color: #2196F3;
        }
    `;
    document.head.appendChild(style);

    initializeParkingCards();
    
    // Thay thế hàm alert() mặc định để sử dụng thông báo tùy chỉnh
    // (Chỉ nên áp dụng khi đã khai báo đầy đủ các hàm thông báo)
    const originalAlert = window.alert;
    window.alert = function(message) {
        showInfoNotification(message);
    };
});