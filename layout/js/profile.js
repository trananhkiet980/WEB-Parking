// document.addEventListener('DOMContentLoaded', function () {
//     // Initialize Featured Parking Lots Swiper
//     const featuredSwiper = new Swiper('.featuredSwiper', {
//         slidesPerView: 1,
//         spaceBetween: 30,
//         autoplay: {
//             delay: 3000,
//             disableOnInteraction: false,
//         },
//         pagination: {
//             el: '.swiper-pagination',
//             clickable: true,
//         },
//         breakpoints: {
//             640: {
//                 slidesPerView: 2,
//                 spaceBetween: 20,
//             },
//             992: {
//                 slidesPerView: 3,
//                 spaceBetween: 30,
//             }
//         },
//         grabCursor: true,
//         loop: true,
//         effect: 'slide',
//     });

//     // Usage Statistics Chart
//     const usageChart = document.getElementById('usageChart');
//     new Chart(usageChart, {
//         type: 'line',
//         data: {
//             labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
//             datasets: [{
//                 label: 'Số lượt đặt chỗ',
//                 data: [5, 7, 4, 9, 10, 8, 12, 10, 9, 6, 11, 12],
//                 backgroundColor: 'rgba(255, 127, 0, 0.1)',
//                 borderColor: '#ff7f00',
//                 borderWidth: 2,
//                 pointBackgroundColor: '#ff7f00',
//                 pointBorderColor: '#fff',
//                 pointRadius: 5,
//                 pointHoverRadius: 7,
//                 tension: 0.3,
//                 fill: true
//             }]
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             plugins: {
//                 legend: {
//                     display: true,
//                     position: 'top',
//                     labels: {
//                         color: '#fff',
//                         font: {
//                             size: 14
//                         }
//                     }
//                 },
//                 tooltip: {
//                     mode: 'index',
//                     intersect: false,
//                     backgroundColor: '#1a1a1a',
//                     borderColor: '#333',
//                     borderWidth: 1,
//                     titleColor: '#ff7f00',
//                     bodyColor: '#fff',
//                     usePointStyle: true,
//                     callbacks: {
//                         labelPointStyle: function (context) {
//                             return {
//                                 pointStyle: 'rectRounded',
//                                 rotation: 0
//                             };
//                         }
//                     }
//                 }
//             },
//             scales: {
//                 y: {
//                     beginAtZero: true,
//                     grid: {
//                         color: 'rgba(255, 255, 255, 0.1)',
//                         borderDash: [5, 5]
//                     },
//                     ticks: {
//                         color: '#ccc',
//                         font: {
//                             size: 12
//                         }
//                     }
//                 },
//                 x: {
//                     grid: {
//                         color: 'rgba(255, 255, 255, 0.1)',
//                         borderDash: [5, 5]
//                     },
//                     ticks: {
//                         color: '#ccc',
//                         font: {
//                             size: 12
//                         }
//                     }
//                 }
//             }
//         }
//     });

//     // Sidebar menu active state
//     const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
//     sidebarLinks.forEach(link => {
//         link.addEventListener('click', function (e) {
//             // Remove active class from all links
//             sidebarLinks.forEach(item => item.classList.remove('active'));
//             // Add active class to clicked link
//             this.classList.add('active');
//         });
//     });

//     // Quick action cards hover effect
//     const quickActionCards = document.querySelectorAll('.quick-action-card');
//     quickActionCards.forEach(card => {
//         card.addEventListener('mouseenter', function () {
//             this.style.transform = 'translateY(-10px)';
//             this.style.borderColor = '#ff7f00';
//             this.style.boxShadow = '0 10px 20px rgba(255, 127, 0, 0.1)';
//         });

//         card.addEventListener('mouseleave', function () {
//             this.style.transform = 'translateY(0)';
//             this.style.borderColor = '#333';
//             this.style.boxShadow = 'none';
//         });
//     });

    
//     // Change Avatar Button Click
//     document.getElementById('changeAvatarBtn').addEventListener('click', function (e) {
//         e.preventDefault();
//         alert('Tính năng thay đổi ảnh đại diện sẽ được cập nhật sớm!');
//     });

//     // Initialize tooltips (if needed)
//     const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
//     tooltipTriggerList.map(function (tooltipTriggerEl) {
//         return new bootstrap.Tooltip(tooltipTriggerEl);
//     });

//     // Real-time countdown for booking
//     function updateCountdown() {
//         // Example: Calculate remaining time from fixed end time (15:30)
//         const now = new Date();
//         const hours = 15 - now.getHours();
//         const minutes = 30 - now.getMinutes();

//         let totalMinutes = hours * 60 + minutes;
//         if (totalMinutes < 0) totalMinutes = 0;

//         const displayHours = Math.floor(totalMinutes / 60);
//         const displayMinutes = totalMinutes % 60;

//         // Update the countdown display
//         const countdownElem = document.querySelector('.booking-card .booking-badge + span');
//         if (countdownElem) {
//             countdownElem.innerHTML = `<i class="fas fa-clock me-1" style="color: #ff7f00;"></i>Còn lại: ${displayHours} giờ ${displayMinutes} phút`;
//         }
//     }

//     // Update countdown every minute
//     updateCountdown();
//     setInterval(updateCountdown, 60000);
// });

// // Edit Vehicle Function
// function editVehicle(plateNumber) {
//     // Set up the edit form with the vehicle data
//     document.getElementById('editVehiclePlate').value = plateNumber;

//     // In a real app, you would fetch the vehicle details from an API
//     // For this demo, we'll use hardcoded data
//     let vehicleModel, vehicleColor, vehicleType;

//     if (plateNumber === '51H-123.45') {
//         vehicleModel = 'Toyota Camry';
//         vehicleColor = 'Đen';
//         vehicleType = 'car';
//     } else if (plateNumber === '59P2-56789') {
//         vehicleModel = 'Honda SH';
//         vehicleColor = 'Trắng';
//         vehicleType = 'motorcycle';
//     } else if (plateNumber === '51G-87654') {
//         vehicleModel = 'Mercedes GLC';
//         vehicleColor = 'Xám';
//         vehicleType = 'car';
//     }

//     document.getElementById('editVehicleModel').value = vehicleModel;
//     document.getElementById('editVehicleColor').value = vehicleColor;
//     document.getElementById('editVehicleType').value = vehicleType;

//     // Show the modal
//     document.getElementById('editVehicleModal').style.display = 'block';
// }

// // Delete Vehicle Function
// function deleteVehicle(plateNumber) {
//     // Set the plate number in the confirmation modal
//     document.getElementById('deleteVehiclePlate').textContent = plateNumber;

//     // Store the plate number for the confirmation function
//     window.vehicleToDelete = plateNumber;

//     // Show the modal
//     document.getElementById('deleteVehicleModal').style.display = 'block';
// }

// // Confirm Delete Vehicle Function
// function confirmDeleteVehicle() {
//     // In a real app, you would make an API call to delete the vehicle

//     // Show loading effect
//     const confirmBtn = document.querySelector('#deleteVehicleModal .btn-save');
//     const originalText = confirmBtn.innerHTML;
//     confirmBtn.innerHTML = 'Đang xử lý <div class="loading-dots"><div class="loading-dot"></div><div class="loading-dot"></div><div class="loading-dot"></div></div>';
//     confirmBtn.disabled = true;

//     // Simulate API call delay
//     setTimeout(() => {
//         alert(`Đã xóa xe ${window.vehicleToDelete} thành công!`);
//         confirmBtn.innerHTML = originalText;
//         confirmBtn.disabled = false;
//         closeModals();
//     }, 1500);
// }

// // Close all modals
// function closeModals() {
//     const modals = document.querySelectorAll('.modal-custom');
//     modals.forEach(modal => {
//         modal.style.display = 'none';
//     });
// }

// // Close modals when clicking outside
// window.addEventListener('click', function (event) {
//     const modals = document.querySelectorAll('.modal-custom');
//     modals.forEach(modal => {
//         if (event.target === modal) {
//             modal.style.display = 'none';
//         }
//     });
// });

// // Easter egg - secret konami code
// let konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
// let konamiCodePosition = 0;

// document.addEventListener('keydown', function (e) {
//     // Check if the pressed key matches the next key in the Konami Code
//     if (e.key === konamiCode[konamiCodePosition]) {
//         konamiCodePosition++;

//         // If the entire code is entered correctly
//         if (konamiCodePosition === konamiCode.length) {
//             // Activate special features
//             activateSpecialFeatures();
//             konamiCodePosition = 0; // Reset for next time
//         }
//     } else {
//         konamiCodePosition = 0; // Reset if a wrong key is pressed
//     }
// });

// function activateSpecialFeatures() {
//     // Add free points
//     const pointsElement = document.querySelector('.stat-card:nth-child(4) .stat-value');
//     if (pointsElement) {
//         const currentPoints = parseInt(pointsElement.textContent);
//         pointsElement.textContent = currentPoints + 100;

//         // Update progress bar
//         setTimeout(() => {
//             const progressBar = document.getElementById('membershipProgressBar');
//             progressBar.style.width = '77%';
//             document.querySelector('.progress-label').textContent = '77%';
//             document.querySelector('.progress-info .current').textContent = '620 điểm';
//         }, 500);

//         alert('🎮 Cheat code activated! Bạn đã nhận được 100 điểm thưởng miễn phí! 🎮');
//     }
// }

// document.addEventListener('DOMContentLoaded', function() {
// // Set animation delay for each parking item
// const parkingItems = document.querySelectorAll('.parking-item');
// parkingItems.forEach((item, index) => {
//     item.style.setProperty('--item-index', index);
    
//     // Add floating effect on hover with parallax
//     item.addEventListener('mousemove', function(e) {
//         const rect = this.getBoundingClientRect();
//         const x = e.clientX - rect.left; // x position within the element
//         const y = e.clientY - rect.top;  // y position within the element
        
//         // Calculate rotation based on mouse position
//         const centerX = rect.width / 2;
//         const centerY = rect.height / 2;
//         const rotateX = (y - centerY) / 15;
//         const rotateY = (centerX - x) / 15;
        
//         // Apply the 3D rotation
//         this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(20px) scale(1.03)`;
        
//         // Move the icon slightly opposite to cursor for a parallax effect
//         const icon = this.querySelector('.parking-icon');
//         if (icon) {
//             icon.style.transform = `translate(${(centerX - x) / 10}px, ${(centerY - y) / 10}px) scale(1.25) rotateY(15deg) translateZ(40px)`;
//         }
        
//         // Move details with less parallax
//         const details = this.querySelector('.parking-details');
//         if (details) {
//             details.style.transform = `translate(${(centerX - x) / 30}px, ${(centerY - y) / 30}px) translateX(10px) translateZ(15px)`;
//         }
        
//         // Add parallax to action buttons with subtle movement
//         const action = this.querySelector('.parking-action');
//         if (action) {
//             action.style.transform = `translate(${(x - centerX) / 40}px, ${(y - centerY) / 40}px) translateZ(25px)`;
//         }
        
//         // Create dynamic ripple effect at cursor position
//         if (Math.random() > 0.98) { // Occasionally add ripple
//             const ripple = document.createElement('div');
//             ripple.classList.add('cursor-ripple');
//             ripple.style.left = `${x}px`;
//             ripple.style.top = `${y}px`;
//             this.appendChild(ripple);
            
//             // Remove the ripple after animation
//             setTimeout(() => {
//                 ripple.remove();
//             }, 1000);
//         }
//     });
    
//     // Reset on mouse leave with smooth transition
//     item.addEventListener('mouseleave', function() {
//         this.style.transform = '';
//         const icon = this.querySelector('.parking-icon');
//         if (icon) icon.style.transform = '';
        
//         const details = this.querySelector('.parking-details');
//         if (details) details.style.transform = '';
        
//         const action = this.querySelector('.parking-action');
//         if (action) action.style.transform = '';
        
//         // Add a smooth transition back
//         this.style.transition = 'transform 0.5s ease';
//         setTimeout(() => {
//             this.style.transition = '';
//         }, 500);
//     });
    
//     // Add click effect
//     item.addEventListener('click', function() {
//         this.classList.add('highlight');
        
//         // Create pulse effect from center
//         const pulse = document.createElement('div');
//         pulse.classList.add('click-pulse');
//         this.appendChild(pulse);
        
//         setTimeout(() => {
//             this.classList.remove('highlight');
//             pulse.remove();
//         }, 700);
//     });
    
//     // Add magnetic effect to buttons
//     const buttons = item.querySelectorAll('.btn');
//     buttons.forEach(button => {
//         button.addEventListener('mousemove', function(e) {
//             const rect = this.getBoundingClientRect();
//             const btnX = e.clientX - rect.left;
//             const btnY = e.clientY - rect.top;
//             const centerX = rect.width / 2;
//             const centerY = rect.height / 2;
            
//             // Calculate distance from center
//             const distanceX = btnX - centerX;
//             const distanceY = btnY - centerY;
            
//             // Apply magnetic pull (stronger when closer to center)
//             this.style.transform = `translate(${distanceX / 3}px, ${distanceY / 3}px) scale(1.05)`;
//         });
        
//         button.addEventListener('mouseleave', function() {
//             this.style.transform = '';
//             this.style.transition = 'transform 0.3s ease';
//             setTimeout(() => {
//                 this.style.transition = '';
//             }, 300);
//         });
//     });
// });

// // Animated counting for time remaining
// const activeItems = document.querySelectorAll('.parking-item[data-status="active"]');
// activeItems.forEach(item => {
//     const timeText = item.querySelector('.parking-time');
//     if (timeText && timeText.textContent.includes('giờ')) {
//         const timeString = timeText.textContent;
//         const hoursPart = timeString.match(/(\d+)\s+giờ/);
//         if (hoursPart && hoursPart[1]) {
//             const hours = parseInt(hoursPart[1]);
//             const minutes = parseInt(timeString.match(/(\d+)\s+phút/)[1] || 0);
            
//             // Update the counter every minute (here simulated for demo)
//             let remainingHours = hours;
//             let remainingMinutes = minutes;
            
//             // For demo - update every 10 seconds instead of every minute
//             const interval = setInterval(() => {
//                 remainingMinutes--;
                
//                 if (remainingMinutes < 0) {
//                     remainingMinutes = 59;
//                     remainingHours--;
//                 }
                
//                 if (remainingHours >= 0) {
//                     timeText.innerHTML = `Đang hoạt động • Còn <span class="time-highlight">${remainingHours} giờ ${remainingMinutes} phút</span>`;
                    
//                     // Add highlight animation
//                     const highlight = timeText.querySelector('.time-highlight');
//                     highlight.style.animation = 'timeHighlight 2s';
//                     setTimeout(() => {
//                         highlight.style.animation = '';
//                     }, 2000);
                    
//                     // Add urgency effect when time gets low
//                     if (remainingHours === 0 && remainingMinutes < 30) {
//                         timeText.classList.add('urgent-time');
//                     }
//                 } else {
//                     clearInterval(interval);
//                     timeText.innerHTML = 'Đã hết thời gian';
//                     item.setAttribute('data-status', 'completed');
                    
//                     // Add completion animation
//                     item.classList.add('complete-animation');
//                     setTimeout(() => {
//                         item.classList.remove('complete-animation');
//                     }, 1500);
//                 }
                
//             }, 10000); // For demo purposes - in real use, this would be 60000 (1 minute)
//         }
//     }
// });

// // Enhanced animation for viewing all link with hover state tracking
// const viewAllLink = document.querySelector('.view-all-link');
// if (viewAllLink) {
//     let isHovered = false;
    
//     viewAllLink.addEventListener('mouseenter', function() {
//         isHovered = true;
//         const icon = this.querySelector('i');
//         if (icon) {
//             icon.style.transition = 'transform 0.3s ease';
//             icon.style.transform = 'translateX(8px)';
//         }
        
//         // Add subtle pulse to the entire link
//         this.classList.add('pulse-link');
//     });
    
//     viewAllLink.addEventListener('mouseleave', function() {
//         isHovered = false;
//         const icon = this.querySelector('i');
//         if (icon) {
//             icon.style.transform = 'translateX(0)';
//         }
        
//         this.classList.remove('pulse-link');
//     });
    
//     // Occasionally add a subtle "attention" animation if not hovered
//     setInterval(() => {
//         if (!isHovered && Math.random() > 0.7) {
//             viewAllLink.classList.add('attention');
//             setTimeout(() => {
//                 viewAllLink.classList.remove('attention');
//             }, 1000);
//         }
//     }, 5000);
// }

// // Add random shimmer effect to cards occasionally
// setInterval(() => {
//     const randomItem = parkingItems[Math.floor(Math.random() * parkingItems.length)];
//     if (randomItem) {
//         randomItem.classList.add('random-shimmer');
//         setTimeout(() => {
//             randomItem.classList.remove('random-shimmer');
//         }, 2000);
//     }
// }, 8000);

// // Add particles to container for ambient background effect
// const container = document.querySelector('.mb-5');
// if (container) {
//     for (let i = 0; i < 15; i++) {
//         const particle = document.createElement('div');
//         particle.classList.add('ambient-particle');
        
//         // Random positions and sizes
//         const size = Math.random() * 4 + 1;
//         particle.style.width = `${size}px`;
//         particle.style.height = `${size}px`;
//         particle.style.left = `${Math.random() * 100}%`;
//         particle.style.top = `${Math.random() * 100}%`;
        
//         // Random animation delay and duration
//         particle.style.animationDelay = `${Math.random() * 10}s`;
//         particle.style.animationDuration = `${Math.random() * 20 + 10}s`;
        
//         container.appendChild(particle);
//     }
// }

// // Add CSS for new dynamic effects
// const style = document.createElement('style');
// style.textContent = `
//     .cursor-ripple {
//         position: absolute;
//         width: 5px;
//         height: 5px;
//         background: rgba(255, 255, 255, 0.4);
//         border-radius: 50%;
//         pointer-events: none;
//         z-index: 10;
//         transform: translate(-50%, -50%);
//         animation: ripple 1s linear forwards;
//     }
    
//     @keyframes ripple {
//         0% { transform: translate(-50%, -50%) scale(1); opacity: 0.7; }
//         100% { transform: translate(-50%, -50%) scale(30); opacity: 0; }
//     }
    
//     .click-pulse {
//         position: absolute;
//         inset: 0;
//         border-radius: 16px;
//         background: radial-gradient(circle at center, rgba(255, 127, 0, 0.3), transparent 70%);
//         z-index: 5;
//         pointer-events: none;
//         animation: clickPulse 0.7s cubic-bezier(0.19, 1, 0.22, 1) forwards;
//     }
    
//     @keyframes clickPulse {
//         0% { opacity: 0; transform: scale(0.5); }
//         50% { opacity: 0.7; }
//         100% { opacity: 0; transform: scale(1.2); }
//     }
    
//     .urgent-time {
//         animation: urgentPulse 1s infinite alternate;
//     }
    
//     @keyframes urgentPulse {
//         0% { color: #888; }
//         100% { color: #e74c3c; }
//     }
    
//     .complete-animation {
//         animation: completeFlash 1.5s forwards;
//     }
    
//     @keyframes completeFlash {
//         0% { background: rgba(25, 25, 35, 0.4); }
//         50% { background: rgba(46, 204, 113, 0.3); }
//         100% { background: rgba(25, 25, 35, 0.4); }
//     }
    
//     .pulse-link {
//         animation: subtlePulse 1s infinite alternate;
//     }
    
//     @keyframes subtlePulse {
//         0% { transform: scale(1); }
//         100% { transform: scale(1.03); }
//     }
    
//     .attention {
//         animation: attention 1s cubic-bezier(0.19, 1, 0.22, 1);
//     }
    
//     @keyframes attention {
//         0% { transform: translateX(0); }
//         25% { transform: translateX(-5px); }
//         50% { transform: translateX(5px); }
//         75% { transform: translateX(-3px); }
//         100% { transform: translateX(0); }
//     }
    
//     .ambient-particle {
//         position: absolute;
//         background: linear-gradient(135deg, rgba(255, 127, 0, 0.3), rgba(52, 152, 219, 0.3));
//         border-radius: 50%;
//         pointer-events: none;
//         z-index: 0;
//         opacity: 0.3;
//         filter: blur(1px);
//         animation: float linear infinite;
//     }
    
//     @keyframes float {
//         0% { transform: translate(0, 0) rotate(0deg); }
//         33% { transform: translate(30px, -20px) rotate(120deg); }
//         66% { transform: translate(-20px, 15px) rotate(240deg); }
//         100% { transform: translate(0, 0) rotate(360deg); }
//     }
// `;
// document.head.appendChild(style);
// });
