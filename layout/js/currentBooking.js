// Đảm bảo closeModals là global
function closeModals() {
    const modal = document.getElementById('extendBookingModal');
    if (modal) {
        modal.style.display = 'none';
    }
}
window.closeModals = closeModals;

document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM content loaded - Initializing booking scripts"); // Debug log
    
    // ----- Form thông báo nâng cao -----
    function renderNotificationForm(notification) {
        console.log("Rendering notification:", notification.title); // Debug log
        
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
            autoClose: options.autoClose || 5000, // Tự đóng sau 5 giây
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

    // Event listener for "Gia hạn" buttons
    const extendButtons = document.querySelectorAll('.extendBookingBtn');
    console.log("Số nút gia hạn được tìm thấy:", extendButtons.length); // Debug
    
    extendButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            console.log("Đã click vào nút gia hạn"); // Debug
            const bookingId = this.dataset.bookingId;
            const parkingId = this.dataset.parkingId;
            console.log("booking_id:", bookingId, "parking_id:", parkingId); // Debug
            openExtendModal(bookingId, parkingId);
        });
    });

    function openExtendModal(bookingId, parkingId) {
        console.log("Mở modal gia hạn cho booking:", bookingId); // Debug
        
        // Kiểm tra xem form có tồn tại không
        const form = document.getElementById('extendBookingForm');
        if (!form) {
            console.error("Không tìm thấy form gia hạn!"); // Debug
            return;
        }
        
        // Kiểm tra xem nút submit có tồn tại không
        const submitBtn = form.querySelector('.btn-save');
        if (!submitBtn) {
            console.error("Không tìm thấy nút xác nhận!"); // Debug
            return;
        }
        
        // Lưu bookingId và parkingId vào nút submit của form
        submitBtn.dataset.currentBookingId = bookingId;
        submitBtn.dataset.currentParkingId = parkingId;

        // Hiển thị modal
        const modal = document.getElementById('extendBookingModal');
        if (modal) {
            modal.style.display = 'block';
        } else {
            console.error("Không tìm thấy modal gia hạn!"); // Debug
        }
    }

    // ----- Xử lý form gia hạn đặt chỗ -----
    const extendForm = document.getElementById('extendBookingForm');
    if (extendForm) {
        extendForm.addEventListener('submit', function (e) {
            e.preventDefault();
            console.log("Form gia hạn đã được submit"); // Debug

            const submitBtn = this.querySelector('.btn-save');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Đang xử lý <div class="loading-dots"><div class="loading-dot"></div><div class="loading-dot"></div><div class="loading-dot"></div></div>';
            submitBtn.disabled = true;

            const bookingId = submitBtn.dataset.currentBookingId; // Lấy bookingId từ thuộc tính data
            const parkingId = submitBtn.dataset.currentParkingId; // Lấy parkingId từ thuộc tính data của nút submit
            const addedHours = document.getElementById('extendHours').value;
            const paymentMethod = document.getElementById('paymentMethod').value;

            console.log("Dữ liệu gia hạn:", {bookingId, parkingId, addedHours, paymentMethod}); // Debug

            fetch('../dao/get_parking_lot_price.php?parking_id=' + parkingId) // Sử dụng parkingId lấy từ nút submit
                .then(response => response.text())
                .then(price => {
                    const fee = addedHours * parseFloat(price);
                    console.log("Giá bãi đỗ:", price, "Phí gia hạn:", fee); // Debug

                    const formData = new FormData();
                    formData.append('booking_id', bookingId);
                    formData.append('added_hours', parseInt(addedHours));
                    formData.append('fee', fee);
                    formData.append('payment_method', paymentMethod);
                    formData.append('parking_id', parkingId); // Gửi parking_id lên server

                    fetch('../dao/extend-booking.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log('Phản hồi từ server:', data);   
                        
                        if (data === 'Gia hạn đặt chỗ thành công!') {
                            showSuccessNotification('Gia hạn đặt chỗ thành công!', {
                                title: 'Thành công',
                                details: `
                                    <p><strong>Thêm:</strong> ${addedHours} giờ</p>
                                    <p><strong>Phí:</strong> ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(fee * 1000)}</p>
                                    <p><strong>Phương thức thanh toán:</strong> ${paymentMethod === 'balance' ? 'Ví SKT Parking' : (paymentMethod === 'momo' ? 'Ví MoMo' : 'Thẻ ngân hàng')}</p>
                                    <p style="font-size: 0.8em; color: gray; font-style: italic; margin-top: 5px;">Tự động làm mới trong 5s</p>
                                `,
                                onConfirm: () => {
                                    closeModals();
                                    location.reload(); // Tải lại trang để hiển thị thông tin cập nhật
                                }
                            });
                            setTimeout(() => {
                                window.location.reload(); // Reload trang sau 5000 milliseconds (5 seconds)
                            }, 5000);
                        } else {
                            showErrorNotification('Gia hạn đặt chỗ thất bại', {
                                details: data || 'Không xác định được nguyên nhân lỗi.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        showErrorNotification('Có lỗi xảy ra', {
                            details: 'Không thể kết nối đến máy chủ. Vui lòng thử lại sau.'
                        });
                    })
                    .finally(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
                })
                .catch(error => {
                    console.error('Error fetching price:', error);
                    showErrorNotification('Không thể lấy thông tin giá', {
                        details: 'Không thể kết nối đến máy chủ. Vui lòng thử lại sau.'
                    });
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });
    } else {
        console.error("Không tìm thấy form gia hạn!"); // Debug
    }

    // ----- Xử lý nút hủy đặt chỗ -----
    // CÁCH 1: Gắn trực tiếp listener cho từng nút hủy
    const cancelButtons = document.querySelectorAll('.cancelBookingBtn');
    console.log('Số nút hủy đặt chỗ được tìm thấy:', cancelButtons.length); // Debug
    
    cancelButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Đã nhấp vào nút hủy đặt chỗ'); // Debug
            
            const bookingId = this.dataset.bookingId;
            console.log('ID đặt chỗ cần hủy:', bookingId); // Debug
            
            showConfirmDialog('Bạn có chắc chắn muốn hủy đặt chỗ này?', 
                function() {
                    console.log('Người dùng đã xác nhận hủy'); // Debug
                    const btnCancel = button;
                    const originalText = btnCancel.innerHTML;
                    btnCancel.innerHTML = 'Đang hủy <div class="loading-dots"><div class="loading-dot"></div><div class="loading-dot"></div><div class="loading-dot"></div></div>';
                    btnCancel.disabled = true;

                    const formData = new FormData();
                    formData.append('booking_id', bookingId);

                    fetch('../dao/cancel-booking.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log('Phản hồi từ server:', data);
                        if (data === 'Hủy đặt chỗ thành công!') {
                            showSuccessNotification('Hủy đặt chỗ thành công!', {
                                title: 'Đã hủy đặt chỗ',
                                details: 'Đặt chỗ của bạn đã được hủy thành công.',
                                onConfirm: () => {
                                    location.reload(); // Tải lại trang để hiển thị thông tin cập nhật
                                }
                            });
                            
                            // Tự động làm mới sau 3 giây
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        } else {
                            showErrorNotification('Hủy đặt chỗ thất bại', {
                                details: data || 'Không xác định được nguyên nhân lỗi.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showErrorNotification('Có lỗi xảy ra', {
                            details: 'Không thể kết nối đến máy chủ. Vui lòng thử lại sau.'
                        });
                    })
                    .finally(() => {
                        btnCancel.innerHTML = originalText;
                        btnCancel.disabled = false;
                    });
                },
                {
                    title: 'Xác nhận hủy đặt chỗ',
                    details: 'Lưu ý: Sau khi hủy đặt chỗ, bạn có thể phải chịu phí hủy nếu đặt chỗ đã bắt đầu.',
                    confirmButton: 'Xác nhận hủy',
                    cancelButton: 'Giữ đặt chỗ'
                }
            );
        });
    });

    // CÁCH 2: Sử dụng event delegation cho những nút được thêm vào sau
    // Hữu ích nếu bạn cập nhật DOM động hoặc có nhiều nút
    document.addEventListener('click', function(event) {
        // Kiểm tra xem sự kiện click có từ nút hủy đặt chỗ không
        const targetButton = event.target.closest('.cancelBookingBtn');
        if (!targetButton) return; // Nếu không phải thì thoát khỏi hàm
        
        // Nếu đã xử lý bởi event listener trực tiếp, không xử lý nữa
        if (targetButton.dataset.hasDirectListener === 'true') return;
        
        console.log('Bắt được sự kiện click từ delegated event'); // Debug
        event.preventDefault();
        
        const bookingId = targetButton.dataset.bookingId;
        console.log('ID đặt chỗ cần hủy (delegated):', bookingId); // Debug
        
        showConfirmDialog('Bạn có chắc chắn muốn hủy đặt chỗ này?', 
            function() {
                console.log('Người dùng đã xác nhận hủy (delegated)'); // Debug
                const btnCancel = targetButton;
                const originalText = btnCancel.innerHTML;
                btnCancel.innerHTML = 'Đang hủy <div class="loading-dots"><div class="loading-dot"></div><div class="loading-dot"></div><div class="loading-dot"></div></div>';
                btnCancel.disabled = true;

                const formData = new FormData();
                formData.append('booking_id', bookingId);

                fetch('../dao/cancel-booking.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Phản hồi từ server:', data);
                    if (data === 'Hủy đặt chỗ thành công!') {
                        showSuccessNotification('Hủy đặt chỗ thành công!', {
                            title: 'Đã hủy đặt chỗ',
                            details: 'Đặt chỗ của bạn đã được hủy thành công.',
                            onConfirm: () => {
                                location.reload(); // Tải lại trang để hiển thị thông tin cập nhật
                            }
                        });
                        
                        // Tự động làm mới sau 3 giây
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    } else {
                        showErrorNotification('Hủy đặt chỗ thất bại', {
                            details: data || 'Không xác định được nguyên nhân lỗi.'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorNotification('Có lỗi xảy ra', {
                        details: 'Không thể kết nối đến máy chủ. Vui lòng thử lại sau.'
                    });
                })
                .finally(() => {
                    btnCancel.innerHTML = originalText;
                    btnCancel.disabled = false;
                });
            },
            {
                title: 'Xác nhận hủy đặt chỗ',
                details: 'Lưu ý: Sau khi hủy đặt chỗ, bạn có thể phải chịu phí hủy nếu đặt chỗ đã bắt đầu.',
                confirmButton: 'Xác nhận hủy',
                cancelButton: 'Giữ đặt chỗ'
            }
        );
    });

    // Đánh dấu các nút đã có direct listener
    cancelButtons.forEach(button => {
        button.dataset.hasDirectListener = 'true';
    });
});