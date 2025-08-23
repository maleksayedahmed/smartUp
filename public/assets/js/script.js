// Mobile Menu Toggle
const menuToggle = document.getElementById('menuToggle');
const navLinks = document.getElementById('navLinks');

if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

// Language Toggle
// Language toggle moved to route-based switching

// Refresh Page Function
function refreshPage() {
    window.location.reload();
}

// Testimonials Slider (guarded for pages that don't include it)
let currentTestimonial = 0;
const testimonials = document.querySelectorAll('.testimonial-card');
const dots = document.querySelectorAll('.testimonials-dot');

function showTestimonial(index) {
    if (!testimonials.length) return;
    // Remove active class from all testimonials and dots
    testimonials.forEach(testimonial => testimonial.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    // Add active class to current testimonial and dot
    const current = testimonials[index];
    const currentDot = dots[index];
    if (current) current.classList.add('active');
    if (currentDot) currentDot.classList.add('active');
    
    // Move the track
    const track = document.querySelector('.testimonials-track');
    if (track) {
        track.style.transform = `translateX(-${index * 100}%)`;
    }
    
    currentTestimonial = index;
}

function nextTestimonial() {
    if (!testimonials.length) return;
    const nextIndex = (currentTestimonial + 1) % testimonials.length;
    showTestimonial(nextIndex);
}

function previousTestimonial() {
    if (!testimonials.length) return;
    const prevIndex = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
    showTestimonial(prevIndex);
}

function goToTestimonial(index) {
    if (!testimonials.length) return;
    showTestimonial(index);
}

// Auto-play testimonials (optional)
if (testimonials.length > 0) {
    setInterval(nextTestimonial, 5000);
}

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        showCopySuccess();
    }, function(err) {
        // Fallback for older browsers
        const textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            showCopySuccess();
        } catch (err) {
            console.error('Could not copy text: ', err);
        }
        document.body.removeChild(textArea);
    });
}

// Show copy success message
function showCopySuccess() {
    // Create and show a temporary success message
    const message = document.createElement('div');
    message.textContent = 'تم النسخ بنجاح!';
    message.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #4CAF50;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        animation: slideInRight 0.3s ease;
    `;
    
    document.body.appendChild(message);
    
    // Remove message after 3 seconds
    setTimeout(() => {
        message.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(message);
        }, 300);
    }, 3000);
}

// Add CSS animations for the success message
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Navbar and Language Color Effect Based on Background
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    const consultationContainer = document.querySelector('.consultation-button-container');
    const isContactPage = document.body.classList.contains('contact-page');
    
    // Get all major sections
    const sections = document.querySelectorAll('section, .hero');
    let currentSection = null;
    
    // Find which section is currently in view at the header level
    sections.forEach(section => {
        const rect = section.getBoundingClientRect();
        const headerHeight = 80; // Account for header height
        
        if (rect.top <= headerHeight && rect.bottom >= headerHeight) {
            currentSection = section;
        }
    });
    
    // Determine if current section has dark or light background
    let isDarkBackground = true; // Default for hero
    
    if (currentSection && !isContactPage) {
        const sectionClasses = currentSection.className;
        
        // Sections with light/white backgrounds
        if (sectionClasses.includes('journey-section') || 
            sectionClasses.includes('services-section') || 
            sectionClasses.includes('gallery-section') || 
            sectionClasses.includes('pricing-section') ||
            sectionClasses.includes('contact-section')) {
            isDarkBackground = false;
        }
        
        // Sections with dark backgrounds
        if (sectionClasses.includes('testimonials-section') ||
            sectionClasses.includes('hero')) {
            isDarkBackground = true;
        }
    }
    
    // Apply navbar scroll effect
    if (!isContactPage) {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    } else {
        navbar.classList.add('scrolled');
    }
    
    // Set language colors based on background
    if (isContactPage || isDarkBackground) {
        consultationContainer.classList.remove('light-bg');
        consultationContainer.classList.add('dark-bg');
    } else {
        consultationContainer.classList.remove('dark-bg');
        consultationContainer.classList.add('light-bg');
    }
});

// Animated Counter for Stats
function animateCounters() {
    const counters = document.querySelectorAll('.stat-number');

    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const increment = target / 100;
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = target === 50000 ? '50K+' :
                    target === 99.9 ? '99.9%' :
                        target + '+';
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 20);
    });
}

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animationPlayState = 'running';
            if (entry.target.classList.contains('stats')) {
                animateCounters();
            }
        }
    });
}, observerOptions);

// Initialize smooth floating animation on load
document.addEventListener('DOMContentLoaded', () => {
    // Start smooth floating circles
    initSmoothFloatingCircles();

    const animatedElements = document.querySelectorAll('.badge, .hero h1, .hero p, .cta-buttons, .stats, .scroll-indicator');
    animatedElements.forEach(el => {
        el.style.animationPlayState = 'paused';
        observer.observe(el);
    });
});

// Button Functions moved to layout file

function watchDemo() {
    // You can replace this with actual video modal
    const modal = createVideoModal();
    document.body.appendChild(modal);

    // Or redirect to demo page
    // window.location.href = '/demo';
}

function createVideoModal() {
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
    `;

    const content = document.createElement('div');
    content.style.cssText = `
        background: white;
        padding: 2rem;
        border-radius: 10px;
        max-width: 500px;
        text-align: center;
        color: black;
    `;

    content.innerHTML = `
        <h3>Demo Video</h3>
        <p>Demo video would be embedded here</p>
        <button onclick="this.parentElement.parentElement.remove()" 
                style="margin-top: 1rem; padding: 0.5rem 1rem; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Close
        </button>
    `;

    modal.appendChild(content);

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.remove();
        }
    });

    return modal;
}

function scrollToNext() {
    window.scrollTo({
        top: window.innerHeight,
        behavior: 'smooth'
    });
}

function scrollToSection(section) {
    // You can implement actual section scrolling here
    console.log(`Scrolling to ${section} section`);

    // Example implementation:
    // const targetSection = document.getElementById(section);
    // if (targetSection) {
    //     targetSection.scrollIntoView({ behavior: 'smooth' });
    // }

    // For now, just close mobile menu if open
    navLinks.classList.remove('active');
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Smooth floating circles animation with JavaScript
function initSmoothFloatingCircles() {
    const heroAfter = document.querySelector('.hero');
    let time = 0;

    function updateCirclePositions() {
        // Use sine and cosine waves for super smooth movement
        const speed = 0.0004; // Very slow for smooth floating

        // Circle 1 - moves in a figure-8 pattern
        const circle1X = 50 + Math.sin(time * speed) * 25 + Math.cos(time * speed * 0.7) * 15;
        const circle1Y = 50 + Math.cos(time * speed) * 20 + Math.sin(time * speed * 1.3) * 10;

        // Circle 2 - moves in opposite pattern
        const circle2X = 50 - Math.sin(time * speed * 0.8) * 30 - Math.cos(time * speed * 1.1) * 12;
        const circle2Y = 50 - Math.cos(time * speed * 0.9) * 25 - Math.sin(time * speed * 0.6) * 18;

        // Apply smooth positions
        if (heroAfter) {
            heroAfter.style.setProperty('--circle1-x', `${circle1X}%`);
            heroAfter.style.setProperty('--circle1-y', `${circle1Y}%`);
            heroAfter.style.setProperty('--circle2-x', `${circle2X}%`);
            heroAfter.style.setProperty('--circle2-y', `${circle2Y}%`);
        }

        time += 16; // ~60fps
        requestAnimationFrame(updateCirclePositions);
    }

    updateCirclePositions();
}

// Enhanced cursor effects for orbs with subtle movement
document.addEventListener('mousemove', (e) => {
    const orbs = document.querySelectorAll('.orb');
    const mouseX = e.clientX / window.innerWidth;
    const mouseY = e.clientY / window.innerHeight;

    orbs.forEach((orb, index) => {
        const speed = (index + 1) * 0.008; // Even more subtle movement
        const x = (mouseX - 0.5) * speed * 15;
        const y = (mouseY - 0.5) * speed * 15;

        orb.style.transform = `translate(${x}px, ${y}px) scale(1)`;
    });
});

// Remove old background intensity function
// Animation loop now handled by smooth floating circles

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    // ESC to close mobile menu
    if (e.key === 'Escape') {
        navLinks.classList.remove('active');
    }

    // Space or Enter to trigger scroll
    if (e.key === ' ' || e.key === 'Enter') {
        if (e.target.classList.contains('scroll-indicator')) {
            e.preventDefault();
            scrollToNext();
        }
    }
});

// Performance optimization: Throttle scroll events
let ticking = false;

function updateOnScroll() {
    // Scroll-based animations handled here
    ticking = false;
}

window.addEventListener('scroll', () => {
    if (!ticking) {
        requestAnimationFrame(updateOnScroll);
        ticking = true;
    }
});

// Add loading animation
window.addEventListener('load', () => {
    document.body.classList.add('loaded');

    // Optional page transition effect
    const style = document.createElement('style');
    style.textContent = `
        body {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        body.loaded {
            opacity: 1;
        }
    `;
    document.head.appendChild(style);
});

// Smooth Future word gradient animation
function initFutureWordAnimation() {
    const futureWord = document.querySelector('.highlight');
    if (!futureWord) return;

    let time = 0;

    function updateFutureGradient() {
        const speed = 0.002; // Adjust speed here
        const progress = (Math.sin(time * speed) + 1) / 2; // 0 to 1

        // Interpolate between the three gradient states
        let colors;
        if (progress < 0.5) {
            // From state 1 to state 2
            const t = progress * 2;
            colors = {
                color1: interpolateColor('#FFFFFF', '#8D3176', t),
                color2: interpolateColor('#B99DCA', '#C4B9DF', t),
                color3: interpolateColor('#8D3176', '#FFFFFF', t),
                color4: interpolateColor('#8D3176', '#FFFFFF', t)
            };
        } else {
            // From state 2 to state 3
            const t = (progress - 0.5) * 2;
            colors = {
                color1: interpolateColor('#8D3176', '#8D3176', t),
                color2: interpolateColor('#C4B9DF', '#8D3176', t),
                color3: interpolateColor('#FFFFFF', '#C4B9DF', t),
                color4: interpolateColor('#FFFFFF', '#FFFFFF', t)
            };
        }

        const gradient = `linear-gradient(45deg, ${colors.color1} 0%, ${colors.color2} 26%, ${colors.color3} 65%, ${colors.color4} 100%)`;
        futureWord.style.background = gradient;
        futureWord.style.backgroundSize = '300% 300%';

        time += 16;
        requestAnimationFrame(updateFutureGradient);
    }

    // Color interpolation function
    function interpolateColor(color1, color2, t) {
        const hex1 = color1.replace('#', '');
        const hex2 = color2.replace('#', '');

        const r1 = parseInt(hex1.substr(0, 2), 16);
        const g1 = parseInt(hex1.substr(2, 2), 16);
        const b1 = parseInt(hex1.substr(4, 2), 16);

        const r2 = parseInt(hex2.substr(0, 2), 16);
        const g2 = parseInt(hex2.substr(2, 2), 16);
        const b2 = parseInt(hex2.substr(4, 2), 16);

        const r = Math.round(r1 + (r2 - r1) * t);
        const g = Math.round(g1 + (g2 - g1) * t);
        const b = Math.round(b1 + (b2 - b1) * t);

        return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
    }

    updateFutureGradient();
}

// Initialize Future word animation
document.addEventListener('DOMContentLoaded', () => {
    // Start smooth floating circles
    initSmoothFloatingCircles();

    // Start Future word animation
    initFutureWordAnimation();

    const animatedElements = document.querySelectorAll('.badge, .hero h1, .hero p, .cta-buttons, .stats, .scroll-indicator');
    animatedElements.forEach(el => {
        el.style.animationPlayState = 'paused';
        observer.observe(el);
    });
});

// cards
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {
        const stars = card.querySelectorAll('.star');

        // Mouse enter event - حركة محدودة داخل الكارد
        card.addEventListener('mouseenter', function () {
            stars.forEach((star, index) => {
                setTimeout(() => {
                    if (star.classList.contains('star-1')) {
                        // حركة محدودة للأعلى (معكوسة لليمين)
                        star.style.transform = 'translate(3px, -5px) rotate(90deg) scale(1.2)';
                        star.style.color = 'rgba(255, 255, 255, 0.8)';
                    } else if (star.classList.contains('star-2')) {
                        // حركة محدودة لليسار (معكوسة)
                        star.style.transform = 'translate(-8px, -3px) rotate(-45deg) scale(1.1)';
                        star.style.color = 'rgba(255, 255, 255, 0.7)';
                    } else if (star.classList.contains('star-3')) {
                        // حركة محدودة لليمين السفلي
                        star.style.transform = 'translate(5px, 6px) rotate(45deg) scale(1.3)';
                        star.style.color = 'rgba(255, 255, 255, 0.9)';
                    }
                }, index * 80);
            });
        });

        // Mouse leave event - النجوم ترجع لمكانها
        card.addEventListener('mouseleave', function () {
            stars.forEach((star, index) => {
                setTimeout(() => {
                    star.style.transform = 'translate(0, 0) rotate(0deg) scale(1)';
                    star.style.color = 'rgba(255, 255, 255, 0.4)';
                }, index * 40);
            });
        });

        // Card click effect
        card.addEventListener('click', function () {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });

    // تحديث مواضع النجوم حسب حجم الشاشة
    function updateStarsPosition() {
        const screenWidth = window.innerWidth;
        const stars = document.querySelectorAll('.star');

        stars.forEach(star => {
            if (screenWidth <= 480) {
                // حركة أقل في الشاشات الصغيرة
                star.addEventListener('mouseenter', function () {
                    if (this.classList.contains('star-1')) {
                        this.style.transform = 'translate(2px, -3px) rotate(45deg) scale(1.1)';
                    } else if (this.classList.contains('star-2')) {
                        this.style.transform = 'translate(-5px, -2px) rotate(-30deg) scale(1.05)';
                    } else if (this.classList.contains('star-3')) {
                        this.style.transform = 'translate(3px, 4px) rotate(30deg) scale(1.15)';
                    }
                });
            }
        });
    }

    // تشغيل عند تحميل الصفحة وتغيير حجم الشاشة
    updateStarsPosition();
    window.addEventListener('resize', updateStarsPosition);
});

// gallery

let currentImageIndex = 0;
let allImages = [];

// Collect all gallery items on page load
document.addEventListener('DOMContentLoaded', function () {
    allImages = Array.from(document.querySelectorAll('.gallery-item[data-src]'));
});

function openModal(clickedElement) {
    // Find the index of clicked element
    currentImageIndex = allImages.indexOf(clickedElement);

    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');

    // Load data from the clicked element
    modalImage.src = clickedElement.dataset.src;
    modalTitle.textContent = clickedElement.dataset.title;
    modalDescription.textContent = clickedElement.dataset.description;

    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
    // document.body.style.overflow = 'auto';  
}

function changeImage(direction) {
    currentImageIndex += direction;

    if (currentImageIndex >= allImages.length) {
        currentImageIndex = 0;
    } else if (currentImageIndex < 0) {
        currentImageIndex = allImages.length - 1;
    }

    const currentElement = allImages[currentImageIndex];
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');

    // Load data from current element
    modalImage.src = currentElement.dataset.src;
    modalTitle.textContent = currentElement.dataset.title;
    modalDescription.textContent = currentElement.dataset.description;
}

// Close modal when clicking outside
window.onclick = function (event) {
    const modal = document.getElementById('imageModal');
    if (event.target === modal) {
        closeModal();
    }
}

// Keyboard navigation
document.addEventListener('keydown', function (event) {
    const modal = document.getElementById('imageModal');
    if (modal.style.display === 'block') {
        if (event.key === 'Escape') {
            closeModal();
        } else if (event.key === 'ArrowLeft') {
            changeImage(1);
        } else if (event.key === 'ArrowRight') {
            changeImage(-1);
        }
    }
});

// packages

document.addEventListener('DOMContentLoaded', function () {
    const pricingCards = document.querySelectorAll('.pricing-card, .custom-package');

    pricingCards.forEach(card => {
        card.addEventListener('click', function () {
            // Add click effect
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                if (this.classList.contains('featured')) {
                    this.style.transform = 'scale(1.05)';
                } else {
                    this.style.transform = '';
                }
            }, 150);
        });
    });
});


// Testimonials functionality (guarded for pages that include this UI)
document.addEventListener('DOMContentLoaded', function () {
    // If the page uses the simple track-based testimonials (packages page), skip this block
    const hasTrackBasedSlider = document.querySelector('.testimonials-track');
    if (hasTrackBasedSlider) return;

    const hasClientName = document.querySelector('.client-name') || document.querySelector('.testimonial-client-name');
    const testimonialCard = document.querySelector('.testimonial-card');
    if (!hasClientName || !testimonialCard) return;

    // Support both class naming schemes
    const dots = document.querySelectorAll('.dot, .testimonials-dot');
    const leftBtn = document.querySelector('.nav-btn-left') || document.querySelector('.testimonial-nav-btn-prev');
    const rightBtn = document.querySelector('.nav-btn-right') || document.querySelector('.testimonial-nav-btn-next');

    let currentSlide = 0;
    let autoSlideInterval;

    // Sample testimonials data
    const testimonialsData = [
        {
            name: "سامح الزهير",
            title: "مدير تسويق - جريدة الصباح",
            text: "الشراكة تتميز بدقة عالية، وطرح ممتاز وإبراز التفاصيل بشكل احترافي....",
            backgroundImage: "./Images/testimonial-bg-1.jpg"
        },
        {
            name: "أحمد محمد",
            title: "مدير العمليات - شركة النجاح",
            text: "خدمة متميزة وجودة عالية في التنفيذ، ننصح بالتعامل معه بقوة....",
            backgroundImage: "./Images/testimonial-bg-2.jpg"
        },
        {
            name: "فاطمة السعيد",
            title: "مديرة المشاريع - مؤسسة الإبداع",
            text: "تعامل راقي ومهني، والنتائج فاقت كل التوقعات بشكل مذهل....",
            backgroundImage: "./Images/testimonial-bg-3.jpg"
        }
    ];

    // Cache references to name/title/text elements (support both naming schemes)
    const nameEl = document.querySelector('.client-name') || document.querySelector('.testimonial-client-name');
    const titleEl = document.querySelector('.client-title') || document.querySelector('.testimonial-client-title');
    const textEl = document.querySelector('.testimonial-text');

    if (!nameEl || !titleEl || !textEl) return;

    // Update testimonial content and background
    function updateTestimonial(index) {
        const t = testimonialsData[index];

        // Add fade out effect
        testimonialCard.style.opacity = '0';
        testimonialCard.style.transform = 'translateY(20px)';

        setTimeout(() => {
            // Update content
            nameEl.textContent = t.name;
            titleEl.textContent = t.title;
            textEl.textContent = t.text;

            // Update background image (optional if CSS handles background)
            if (t.backgroundImage) {
                testimonialCard.style.backgroundImage = `url('${t.backgroundImage}')`;
            }

            // Fade in effect
            testimonialCard.style.opacity = '1';
            testimonialCard.style.transform = 'translateY(0)';
        }, 300);

        // Update dots indicator
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }

    // Navigation functions
    function goToNextSlide() {
        currentSlide = (currentSlide + 1) % testimonialsData.length;
        updateTestimonial(currentSlide);
    }

    function goToPrevSlide() {
        currentSlide = (currentSlide - 1 + testimonialsData.length) % testimonialsData.length;
        updateTestimonial(currentSlide);
    }

    function goToSlide(index) {
        currentSlide = index;
        updateTestimonial(currentSlide);
    }

    // Auto-slide functionality
    function startAutoSlide() {
        autoSlideInterval = setInterval(goToNextSlide, 5000);
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    // Event listeners
    if (leftBtn) {
        leftBtn.addEventListener('click', () => {
            stopAutoSlide();
            goToPrevSlide();
            startAutoSlide();
        });
    }

    if (rightBtn) {
        rightBtn.addEventListener('click', () => {
            stopAutoSlide();
            goToNextSlide();
            startAutoSlide();
        });
    }

    if (dots && dots.length) {
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                stopAutoSlide();
                goToSlide(index);
                startAutoSlide();
            });
        });
    }

    // Pause auto-slide on hover
    if (testimonialCard) {
        testimonialCard.addEventListener('mouseenter', stopAutoSlide);
        testimonialCard.addEventListener('mouseleave', startAutoSlide);
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            stopAutoSlide();
            goToNextSlide(); // In RTL, left arrow goes to next
            startAutoSlide();
        } else if (e.key === 'ArrowRight') {
            stopAutoSlide();
            goToPrevSlide(); // In RTL, right arrow goes to previous
            startAutoSlide();
        }
    });

    // Touch/swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    testimonialCard.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    testimonialCard.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            stopAutoSlide();
            if (diff > 0) {
                // Swiped left - go to next
                goToNextSlide();
            } else {
                // Swiped right - go to previous
                goToPrevSlide();
            }
            startAutoSlide();
        }
    }

    // --- Mobile header logo swap and partners slider controls ---
    document.addEventListener('DOMContentLoaded', function () {
        const logoImage = document.querySelector('.logo-image');
        const compactLogo = document.querySelector('.logo-image-compact');
        const partnersTrack = document.getElementById('partnersTrack');

        // Helper to toggle logos based on width
        function updateLogoByWidth() {
            const w = window.innerWidth;
            if (!logoImage || !compactLogo) return;

            if (w <= 768) {
                logoImage.style.display = 'none';
                compactLogo.style.display = 'block';
                compactLogo.setAttribute('aria-hidden', 'false');
            } else {
                logoImage.style.display = '';
                compactLogo.style.display = 'none';
                compactLogo.setAttribute('aria-hidden', 'true');
            }
        }

        // Initialize logo visibility
        updateLogoByWidth();
        window.addEventListener('resize', updateLogoByWidth);

    // We only handle logo swapping here. Partner auto-scroll should remain handled by CSS animation.
    });

    // Initialize
    updateTestimonial(0);
    startAutoSlide();

    // Intersection Observer for animation trigger
    const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, { threshold: 0.1 });

    io.observe(testimonialCard);
});