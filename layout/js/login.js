// Throttle function giữ nguyên
function throttle(func, limit) {
    let lastFunc;
    let lastRan;
    return function () {
        const context = this;
        const args = arguments;
        if (!lastRan) {
            func.apply(context, args);
            lastRan = Date.now();
        } else {
            clearTimeout(lastFunc);
            lastFunc = setTimeout(function () {
                if ((Date.now() - lastRan) >= limit) {
                    func.apply(context, args);
                    lastRan = Date.now();
                }
            }, limit - (Date.now() - lastRan));
        }
    };
}

document.getElementById('showSignupForm').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('loginContainer').style.display = 'none';
    document.getElementById('signupContainer').style.display = 'block';
});

document.getElementById('showLoginForm').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('signupContainer').style.display = 'none';
    document.getElementById('loginContainer').style.display = 'block';
});

// Initialize AOS và các hiệu ứng
document.addEventListener('DOMContentLoaded', function () {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true
        });
    }
    if (typeof createStars === 'function') createStars();
    initializeFormValidation();
    initializeTilt();
    initMouseParallax();
});

// Các hàm khác giữ nguyên
function initMouseParallax() {
    const orbs = document.querySelectorAll('.animated-orb');
    const stars = document.querySelector('.stars');
    document.addEventListener('mousemove', throttle(function (e) {
        const x = e.clientX / window.innerWidth;
        const y = e.clientY / window.innerHeight;
        orbs.forEach(orb => {
            const speed = parseFloat(orb.getAttribute('data-speed') || Math.random() * 0.05 + 0.025);
            const offsetX = (0.5 - x) * 100 * speed;
            const offsetY = (0.5 - y) * 100 * speed;
            orb.style.transform = `translate(${offsetX}px, ${offsetY}px)`;
        });
        if (stars) {
            stars.style.transform = `translate(${(0.5 - x) * 20}px, ${(0.5 - y) * 20}px)`;
        }
    }, 16));
}

function togglePasswordVisibility(inputId) {
    const passwordInput = document.getElementById(inputId);
    if (!passwordInput) {
        console.error(`Không tìm thấy input với ID: ${inputId}`);
        return;
    }

    const passwordToggle = passwordInput.closest('.input-with-icon').querySelector('.password-toggle');
    if (!passwordToggle) {
        console.error(`Không tìm thấy .password-toggle cho input: ${inputId}`);
        return;
    }

    const icon = passwordToggle.querySelector('i');
    if (!icon) {
        console.error(`Không tìm thấy biểu tượng i trong .password-toggle cho input: ${inputId}`);
        return;
    }

    console.log(`Trước khi toggle - Input type: ${passwordInput.type}, Icon classes: ${icon.className}`);

    passwordToggle.style.display = 'block';
    passwordToggle.style.visibility = 'visible';

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }

    console.log(`Sau khi toggle - Input type: ${passwordInput.type}, Icon classes: ${icon.className}`);
}

function createStars() {
    const starsContainer = document.getElementById('stars');
    if (!starsContainer) return;
    const starCount = 100;
    for (let i = 0; i < starCount; i++) {
        const star = document.createElement('div');
        star.classList.add('star');
        star.style.top = `${Math.random() * 100}%`;
        star.style.left = `${Math.random() * 100}%`;
        const size = Math.random() * 3 + 1;
        star.style.width = `${size}px`;
        star.style.height = `${size}px`;
        star.style.animationDelay = `${Math.random() * 3}s`;
        starsContainer.appendChild(star);
    }
}

function initializeTilt() {
    const tiltElements = document.querySelectorAll('.tilt-element');
    if (!tiltElements.length) return;
    tiltElements.forEach(element => {
        element.addEventListener('mousemove', throttle(function (e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xPercent = x / rect.width;
            const yPercent = y / rect.height;
            const xRotation = (yPercent - 0.5) * 10;
            const yRotation = (0.5 - xPercent) * 10;
            this.style.transform = `perspective(1000px) rotateX(${xRotation}deg) rotateY(${yRotation}deg) translateZ(0)`;
        }, 16));
        element.addEventListener('mouseleave', function () {
            this.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) translateZ(0)`;
        });
    });
}

// Khởi tạo xác thực form với AJAX
function initializeFormValidation() {
    const forms = document.querySelectorAll('#loginForm, #mobileLoginForm, #signupForm');
    if (!forms.length) {
        console.error('Không tìm thấy form nào!');
        return;
    }

    forms.forEach(form => {
        const inputs = form.querySelectorAll('.login-form-input');
        let errorDiv;
        let emailInput, passwordInput, confirmPasswordInput;

        // Xác định errorDiv và các input dựa trên form
        if (form.id === 'signupForm') {
            errorDiv = form.querySelector('#signup-error');
            emailInput = form.querySelector('#signup-email');
            passwordInput = form.querySelector('#signup-password');
            confirmPasswordInput = form.querySelector('#confirm-password');
        } else {
            errorDiv = form.querySelector('#login-error');
            emailInput = form.querySelector('#login-email') || form.querySelector('#email-mobile');
            passwordInput = form.querySelector('#login-password') || form.querySelector('#password-mobile');
        }

        inputs.forEach(input => {
            input.addEventListener('blur', function () {
                validateInput(this, form.id);
            });
            input.addEventListener('input', function () {
                validateInput(this, form.id);
                if (errorDiv) errorDiv.style.display = 'none'; // Ẩn lỗi khi nhập lại
            });
            input.addEventListener('focus', function () {
                this.classList.remove('is-invalid', 'is-valid');
            });
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            let isValid = true;
            inputs.forEach(input => {
                if (!validateInput(input, form.id)) isValid = false;
            });

            if (!isValid) {
                console.log('Dữ liệu không hợp lệ, không gửi form.');
                return;
            }

            // Gửi dữ liệu qua AJAX
            const formData = new FormData(form);
            
            if (form.id==='signupForm') {
                formData.append('emailInput', emailInput.value);
                formData.append('passwordInput', passwordInput.value);
                formData.append('confirmPasswordInput', confirmPasswordInput.value);
            }
            let url = (form.id === 'signupForm') ? '../dao/signup.php' : '../dao/login.php';
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(data => {
                console.log('Phản hồi từ server:', data);
                if (data.trim() === 'Đăng nhập thành công' || data.trim() === 'Đăng ký thành công') {
                    window.location.href = 'index.php'; // Chuyển hướng nếu thành công
                } else {
                    if (errorDiv) {
                        // errorDiv.textContent = (form.id === 'signupForm') 
                        //     ? 'Đăng ký thất bại. Vui lòng kiểm tra lại thông tin.'
                        //     : 'Tài khoản hoặc mật khẩu không đúng';
                        errorDiv.style.display = 'block';
                        console.log('Hiển thị lỗi trên giao diện');
                        setTimeout(() => {
                            errorDiv.style.display = 'none';
                            // Xóa nội dung và hiệu ứng của các ô input
                            if (emailInput) {
                                emailInput.value = '';
                                emailInput.classList.remove('is-valid', 'is-invalid');
                            }
                            if (passwordInput) {
                                passwordInput.value = '';
                                passwordInput.classList.remove('is-valid', 'is-invalid');
                            }
                            if (confirmPasswordInput) {
                                confirmPasswordInput.value = '';
                                confirmPasswordInput.classList.remove('is-valid', 'is-invalid');
                            }
                            console.log('Đã xóa nội dung và hiệu ứng sau 2 giây');
                        }, 2000);
                    } else {
                        console.error('Không thể hiển thị lỗi: errorDiv không tồn tại');
                    }
                }
            })
            .catch(error => {
                console.error('Lỗi fetch:', error);
                if (errorDiv) {
                    errorDiv.textContent = 'Đã xảy ra lỗi khi gửi yêu cầu';
                    errorDiv.style.display = 'block';
                    setTimeout(() => {
                        errorDiv.style.display = 'none';
                        // Xóa nội dung và hiệu ứng của các ô input
                        if (emailInput) {
                            emailInput.value = '';
                            emailInput.classList.remove('is-valid', 'is-invalid');
                        }
                        if (passwordInput) {
                            passwordInput.value = '';
                            passwordInput.classList.remove('is-valid', 'is-invalid');
                        }
                        if (confirmPasswordInput) {
                            confirmPasswordInput.value = '';
                            confirmPasswordInput.classList.remove('is-valid', 'is-invalid');
                        }
                        console.log('Đã xóa nội dung và hiệu ứng sau 3 giây');
                    }, 3000);
                }
            });
        });
    });
}

// Hàm xác thực input
function validateInput(input) {
    if (!input) return false;

    if (input.dataset.interacted !== 'true' && input.value.trim() === '') {
        return true;
    }

    input.classList.remove('is-invalid', 'is-valid');
    input.dataset.interacted = 'true';

    let isValid = true;
    if (input.type === 'email') {
        isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value);
    } else if (input.type === 'password') {
        isValid = input.value.length >= 8;
    }

    if (input.value.trim() !== '') {
        input.classList.add(isValid ? 'is-valid' : 'is-invalid');
    }

    return isValid;
}