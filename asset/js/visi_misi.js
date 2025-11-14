// AOS (Animate On Scroll) Implementation
document.addEventListener('DOMContentLoaded', function() {
    initAOS();
    initScrollIndicator();
    initParallax();
    initCounters();
});

// Initialize AOS Animation
function initAOS() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.aosDelay || 0;
                setTimeout(() => {
                    entry.target.classList.add('aos-animate');
                }, delay);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('[data-aos]').forEach(el => {
        observer.observe(el);
    });
}

// Scroll Indicator
function initScrollIndicator() {
    const scrollIndicator = document.querySelector('.scroll-indicator');
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', () => {
            const visiSection = document.querySelector('.visi-section');
            if (visiSection) {
                visiSection.scrollIntoView({ behavior: 'smooth' });
            }
        });

        // Hide scroll indicator on scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                scrollIndicator.style.opacity = '0';
            } else {
                scrollIndicator.style.opacity = '1';
            }
        });
    }
}

// Parallax Effect for Hero Section
function initParallax() {
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxSpeed = 0.5;
            heroSection.style.transform = `translateY(${scrolled * parallaxSpeed}px)`;
        });
    }
}

// Animated Counter (for future statistics)
function initCounters() {
    const counters = document.querySelectorAll('.counter');
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.dataset.target);
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        updateCounter();
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => observer.observe(counter));
}

// Card Hover Effects
document.querySelectorAll('.misi-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
    });
});

// Smooth Scroll for all internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
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

// Add active state to cards on mobile touch
if ('ontouchstart' in window) {
    document.querySelectorAll('.misi-card, .value-item').forEach(item => {
        item.addEventListener('touchstart', function() {
            this.style.transform = 'translateY(-10px)';
        });
        
        item.addEventListener('touchend', function() {
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
        });
    });
}

// Lazy Loading Background Images
function initLazyBackgrounds() {
    const lazyBackgrounds = document.querySelectorAll('.lazy-bg');
    
    const bgObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('loaded');
                bgObserver.unobserve(entry.target);
            }
        });
    });

    lazyBackgrounds.forEach(bg => bgObserver.observe(bg));
}

// Add floating animation to icons
function addFloatingAnimation() {
    const icons = document.querySelectorAll('.misi-icon, .visi-icon');
    
    icons.forEach((icon, index) => {
        icon.style.animation = `float 3s ease-in-out ${index * 0.2}s infinite`;
    });
}

// Create floating keyframes dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
`;
document.head.appendChild(style);

// Initialize floating animation after DOM load
window.addEventListener('load', addFloatingAnimation);

// Performance optimization: Debounce scroll events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Optimized scroll handler
const handleScroll = debounce(() => {
    const scrolled = window.pageYOffset;
    
    // Add scroll-based effects here
    if (scrolled > 100) {
        document.body.classList.add('scrolled');
    } else {
        document.body.classList.remove('scrolled');
    }
}, 10);

window.addEventListener('scroll', handleScroll);

// Add intersection observer for performance
const createObserver = (elements, callback, options = {}) => {
    const observer = new IntersectionObserver(callback, {
        threshold: options.threshold || 0.1,
        rootMargin: options.rootMargin || '0px'
    });

    elements.forEach(el => observer.observe(el));
    return observer;
};

// Reveal sections on scroll
const revealSections = document.querySelectorAll('section');
createObserver(revealSections, (entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('section-visible');
        }
    });
}, { threshold: 0.2 });

// Print page functionality
function printPage() {
    window.print();
}

// Share functionality
async function sharePage() {
    if (navigator.share) {
        try {
            await navigator.share({
                title: 'Visi & Misi',
                text: 'Lihat Visi & Misi perusahaan kami',
                url: window.location.href
            });
        } catch (err) {
            console.log('Error sharing:', err);
        }
    } else {
        // Fallback: Copy to clipboard
        navigator.clipboard.writeText(window.location.href);
        alert('Link berhasil disalin!');
    }
}

// Expose functions globally if needed
window.visiMisiApp = {
    printPage,
    sharePage
};

console.log('✅ Visi & Misi page loaded successfully');