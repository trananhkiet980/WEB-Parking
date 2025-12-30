document.addEventListener('DOMContentLoaded', function() {
    // ----- Form thông báo nâng cao -----
    // Kiểm tra xem các hàm form thông báo đã tồn tại chưa
    if (typeof renderNotificationForm !== 'function') {
        // Tạo form thông báo
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
                cancelButton: options.cancelButton || null,
                autoClose: options.autoClose || 3000, // Không tự đóng
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
                autoClose: options.autoClose || 3000, // Tự đóng sau 3 giây
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
    }

    // Xử lý nút chỉnh sửa
    document.getElementById('editButton').addEventListener('click', function() {
        document.getElementById('fullName').style.display = 'none';
        document.getElementById('email').style.display = 'none';
        document.getElementById('phone').style.display = 'none';
        document.getElementById('address').style.display = 'none';

        document.getElementById('fullNameEdit').style.display = 'block';
        document.getElementById('emailEdit').style.display = 'block';
        document.getElementById('phoneEdit').style.display = 'block';
        document.getElementById('addressEdit').style.display = 'block';

        document.getElementById('editButton').style.display = 'none';
        document.getElementById('saveButton').style.display = 'block';
    });

    // Xử lý nút lưu
    document.getElementById('saveButton').addEventListener('click', function() {
        // Hiển thị thông báo đang xử lý
        let loadingNotification = null;
        if (typeof showInfoNotification === 'function') {
            loadingNotification = showInfoNotification('Đang xử lý...', {
                title: 'Cập nhật thông tin',
                autoClose: null,
                confirmButton: null
            });
        }

        const fullName = document.getElementById('fullNameEdit').value;
        const email = document.getElementById('emailEdit').value;
        const phone = document.getElementById('phoneEdit').value;
        const address = document.getElementById('addressEdit').value;

        // Kiểm tra dữ liệu đầu vào
        let isValid = true;
        let validationMessage = '';

        if (!fullName.trim()) {
            isValid = false;
            validationMessage += '- Họ và tên không được để trống\n';
        }

        if (!email.trim()) {
            isValid = false;
            validationMessage += '- Email không được để trống\n';
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            isValid = false;
            validationMessage += '- Email không hợp lệ\n';
        }

        if (!phone.trim()) {
            isValid = false;
            validationMessage += '- Số điện thoại không được để trống\n';
        } else if (!/^[0-9]{10,11}$/.test(phone.replace(/\s/g, ''))) {
            isValid = false;
            validationMessage += '- Số điện thoại không hợp lệ (cần 10-11 chữ số)\n';
        }

        if (!isValid) {
            // Đóng thông báo đang xử lý nếu có
            if (loadingNotification && typeof closeNotificationForm === 'function') {
                closeNotificationForm(loadingNotification);
            }

            // Hiển thị thông báo lỗi
            if (typeof showErrorNotification === 'function') {
                showErrorNotification('Vui lòng kiểm tra lại thông tin', {
                    details: validationMessage.replace(/\n/g, '<br>')
                });
                setTimeout(() => {
                    window.location.reload(); // Reload trang sau 3000 milliseconds (3 seconds)
                }, 3000);
            } else {
                alert('Vui lòng kiểm tra lại thông tin:\n' + validationMessage);
            }
            return;
        }

        // Tạo đối tượng FormData để gửi dữ liệu dưới dạng form
        const formData = new FormData();
        formData.append('fullName', fullName);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('address', address);

        // Gửi dữ liệu đến endpoint PHP bằng AJAX (POST method)
        fetch('../dao/update-user-info.php', {
            method: 'POST',
            body: formData // Sử dụng FormData làm body
        })
        .then(response => response.text()) // Nhận phản hồi là text
        .then(data => {
            console.log('Phản hồi từ server:', data);

            // Đóng thông báo đang xử lý nếu có
            if (loadingNotification && typeof closeNotificationForm === 'function') {
                closeNotificationForm(loadingNotification);
            }

            if (data === 'Update successful.') {
                // Hiển thị thông báo thành công
                if (typeof showSuccessNotification === 'function') {
                    showSuccessNotification('Cập nhật thông tin thành công!', {
                        details: `
                            <p>Thông tin tài khoản của bạn đã được cập nhật.</p>
                            <p>Các thay đổi sẽ được áp dụng ngay lập tức.</p>
                        `,
                        onConfirm: () => {
                            window.location.reload();
                        },
                    });
                    setTimeout(() => {
                        window.location.reload(); // Reload trang sau 3000 milliseconds (3 seconds)
                    }, 3000);
                } else {
                    alert('Cập nhật thông tin thành công!');
                    window.location.reload();
                }
            } else {
                // Hiển thị thông báo lỗi
                if (typeof showErrorNotification === 'function') {
                    showErrorNotification('Cập nhật thông tin thất bại', {
                        details: data || 'Không xác định được nguyên nhân lỗi.'
                    });
                } else {
                    alert('Cập nhật thông tin thất bại: ' + data);
                    window.location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);

            // Đóng thông báo đang xử lý nếu có
            if (loadingNotification && typeof closeNotificationForm === 'function') {
                closeNotificationForm(loadingNotification);
            }

            // Hiển thị thông báo lỗi
            if (typeof showErrorNotification === 'function') {
                showErrorNotification('Đã xảy ra lỗi khi cập nhật thông tin', {
                    details: 'Không thể kết nối đến máy chủ. Vui lòng thử lại sau.'
                });
            } else {
                alert('Đã xảy ra lỗi khi cập nhật thông tin.');
                window.location.reload();
            }
        });
    });

    // Xử lý nút thay đổi ảnh đại diện
    document.querySelector('.avatar-edit-btn').addEventListener('click', function() {
        if (typeof showInfoNotification === 'function') {
            showInfoNotification('Tính năng đang phát triển', {
                details: 'Chức năng thay đổi ảnh đại diện sẽ sớm được triển khai. Vui lòng quay lại sau.',
                confirmButton: 'Đã hiểu'
            });
        } else {
            alert('Tính năng đang phát triển. Vui lòng quay lại sau.');
        }
    });
});