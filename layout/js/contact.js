document.addEventListener('DOMContentLoaded', function() {
    // Navbar mobile toggle
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                navbarCollapse.classList.remove('show');
                navbarToggler.setAttribute('aria-expanded', 'false');
            }
        });
    });
    
    // Animate elements when they come into view
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.contact-item, .contact-form-section, .map-section, .accordion-item');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementPosition < windowHeight - 50) {
                element.classList.add('fade-in');
            }
        });
    };
    
    // Call once on load
    animateOnScroll();
    
    // Call on scroll
    window.addEventListener('scroll', animateOnScroll);
    
    // Thêm class 'active' cho các input để kích hoạt animation
    const inputs = document.querySelectorAll('.form-group');
    inputs.forEach((input, index) => {
        setTimeout(() => {
            input.classList.add('active');
        }, 100 * index);
    });
    
    // Animation cho nút gửi
    const sendButtons = document.querySelectorAll('.send-button, .submit-btn');
    sendButtons.forEach(button => {
        button.addEventListener('mouseover', function() {
            this.style.transition = 'all 0.3s ease';
            this.style.transform = 'translateY(-3px)';
        });
        
        button.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0)';
        });
        
        // Phản hồi khi click vào nút gửi
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            this.innerHTML = '<i class="fas fa-check"></i> SENT';
            
            if (this.classList.contains('send-button')) {
                this.style.background = 'linear-gradient(to right, #4CAF50, #45a049)';
            } else {
                this.style.background = '#4CAF50';
            }
            
            const form = this.closest('form');
            
            // Reset form sau 2 giây
            setTimeout(() => {
                form.reset();
                
                if (this.classList.contains('send-button')) {
                    this.innerHTML = 'SEND';
                    this.style.background = 'linear-gradient(to right, #ff7f00, #ff5500)';
                } else {
                    this.innerHTML = 'Gửi Tin Nhắn';
                    this.style.background = 'linear-gradient(to right, #ff7f00, #ff5500)';
                }
            }, 2000);
        });
    });
    
    // Thêm hiệu ứng hover cho các mục FAQ
    const accordionButtons = document.querySelectorAll('.accordion-button');
    accordionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.color = '#ff7f00';
        });
        
        button.addEventListener('mouseleave', function() {
            if (!this.classList.contains('collapsed')) {
                this.style.color = '#ff7f00';
            } else {
                this.style.color = 'white';
            }
        });
    });
});