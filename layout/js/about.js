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
    
    // Animate features on scroll
    const features = document.querySelectorAll('.feature');
    const collapsibleSections = document.querySelectorAll('.collapsible-section');
    
    const animateElements = () => {
        features.forEach((feature, index) => {
            const elementTop = feature.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementTop < windowHeight - 50) {
                setTimeout(() => {
                    feature.classList.add('animated');
                }, index * 150); // Staggered animation
            }
        });
        
        collapsibleSections.forEach((section, index) => {
            const elementTop = section.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementTop < windowHeight - 50) {
                setTimeout(() => {
                    section.classList.add('animated');
                }, index * 100); // Staggered animation
            }
        });
    };
    
    // Initial check on page load
    animateElements();
    
    // Check on scroll
    window.addEventListener('scroll', animateElements);
    
    // Collapsible sections
    const sectionHeaders = document.querySelectorAll('.section-header');
    
    sectionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            // Toggle the active class on the header
            this.classList.toggle('active');
            
            // Get the target section ID
            const targetId = this.getAttribute('data-target');
            const targetContent = document.getElementById(targetId);
            
            // Toggle the active class on the content
            targetContent.classList.toggle('active');
            
            // Close other sections when opening one
            if (this.classList.contains('active')) {
                sectionHeaders.forEach(otherHeader => {
                    if (otherHeader !== this) {
                        otherHeader.classList.remove('active');
                        const otherId = otherHeader.getAttribute('data-target');
                        document.getElementById(otherId).classList.remove('active');
                    }
                });
            }
        });
    });
    
    // Animate form inputs
    const inputs = document.querySelectorAll('.form-group');
    inputs.forEach((input, index) => {
        setTimeout(() => {
            input.classList.add('active');
        }, 100 * index);
    });
    
    // Animation for send button
    const sendButton = document.querySelector('.send-button');
    if (sendButton) {
        sendButton.addEventListener('mouseover', function() {
            this.style.transition = 'all 0.3s ease';
            this.style.transform = 'translateY(-5px)';
        });
        
        sendButton.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0)';
        });
        
        // Feedback when clicking send button
        sendButton.addEventListener('click', function(e) {
            e.preventDefault();
            this.innerHTML = '<i class="fas fa-check"></i> SENT';
            this.style.background = 'linear-gradient(to right, #4CAF50, #45a049)';
            
            // Reset form after 2 seconds
            setTimeout(() => {
                document.querySelector('.contact-form').reset();
                this.innerHTML = 'SEND';
                this.style.background = 'linear-gradient(to right, #ff7f00, #ff5500)';
            }, 2000);
        });
    }
});