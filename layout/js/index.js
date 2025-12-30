document.addEventListener('DOMContentLoaded', function () {
    // Navbar mobile toggle
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    navLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992) {
                navbarCollapse.classList.remove('show');
                navbarToggler.setAttribute('aria-expanded', 'false');
            }
        });
    });

    // Animate stats numbers
    const stats = document.querySelectorAll('.stat-number');

    const animateStats = () => {
        stats.forEach(stat => {
            const target = parseInt(stat.getAttribute('data-count'));
            const isPercentage = stat.textContent.includes('%');
            const suffix = isPercentage ? '%' : '+';

            let count = 0;
            const updateCount = () => {
                const increment = target / 100;

                if (count < target) {
                    count += increment;
                    stat.textContent = isPercentage ?
                        Math.ceil(count) + suffix :
                        Math.ceil(count).toLocaleString() + suffix;
                    setTimeout(updateCount, 10);
                } else {
                    stat.textContent = isPercentage ?
                        target + suffix :
                        target.toLocaleString() + suffix;
                }
            };

            updateCount();
        });
    };

    // Check if element is in viewport
    const isInViewport = el => {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    };

    // Trigger animation when stats section is in viewport
    const statsSection = document.querySelector('.stats-section');
    let animated = false;

    window.addEventListener('scroll', () => {
        if (!animated && isInViewport(statsSection)) {
            animateStats();
            animated = true;
        }
    });

    // If stats section is already in viewport on page load
    if (isInViewport(statsSection)) {
        animateStats();
        animated = true;
    }

    // Get in Touch animations
    const inputs = document.querySelectorAll('.form-group');
    inputs.forEach((input, index) => {
        setTimeout(() => {
            input.classList.add('active');
        }, 100 * index);
    });

    // Animation for send button
    const sendButton = document.querySelector('.send-button');
    if (sendButton) {
        sendButton.addEventListener('mouseover', function () {
            this.style.transition = 'all 0.3s ease';
            this.style.transform = 'translateY(-2px)';
        });

        sendButton.addEventListener('mouseout', function () {
            this.style.transform = 'translateY(0)';
        });

        // Feedback when clicking send button
        sendButton.addEventListener('click', function (e) {
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