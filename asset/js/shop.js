// Shop URLs Configuration
const shopLinks = {
    tiktok: 'https://www.tiktok.com/@yourshop', // Ganti dengan link TikTok Shop Anda
    tokopedia: 'https://www.tokopedia.com/yourshop', // Ganti dengan link Tokopedia Anda
    shopee: 'https://shopee.co.id/yourshop', // Ganti dengan link Shopee Anda
    lazada: 'https://www.lazada.co.id/shop/yourshop' // Ganti dengan link Lazada Anda
};

// Redirect to Shop Function
function redirectToShop(platform) {
    const url = shopLinks[platform];
    
    if (url) {
        // Add animation before redirect
        const card = document.querySelector(`[data-platform="${platform}"]`);
        card.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            // Open in new tab
            window.open(url, '_blank');
            
            // Reset animation
            card.style.transform = '';
        }, 200);
    } else {
        alert('Link toko belum tersedia untuk platform ini.');
    }
}

// Add hover sound effect (optional)
function playHoverSound() {
    // Uncomment if you want to add sound effect
    // const audio = new Audio('path/to/hover-sound.mp3');
    // audio.volume = 0.3;
    // audio.play();
}

// Intersection Observer for scroll animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Initialize animations on page load
document.addEventListener('DOMContentLoaded', () => {
    // Animate shop cards
    const shopCards = document.querySelectorAll('.shop-card');
    shopCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        card.style.transitionDelay = `${index * 0.1}s`;
        
        observer.observe(card);
    });

    // Animate benefit cards
    const benefitCards = document.querySelectorAll('.benefit-card');
    benefitCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        card.style.transitionDelay = `${index * 0.1}s`;
        
        observer.observe(card);
    });

    // Add click tracking (optional - for analytics)
    shopCards.forEach(card => {
        card.addEventListener('click', (e) => {
            if (!e.target.closest('.shop-btn')) {
                const platform = card.getAttribute('data-platform');
                redirectToShop(platform);
            }
        });
    });

    // Add particle effect on hover (optional enhancement)
    shopCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            createParticles(card);
        });
    });
});

// Create particle effect function
function createParticles(element) {
    const colors = ['#F9D70B', '#2B8D4C'];
    
    for (let i = 0; i < 5; i++) {
        const particle = document.createElement('div');
        particle.style.position = 'absolute';
        particle.style.width = '5px';
        particle.style.height = '5px';
        particle.style.borderRadius = '50%';
        particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        particle.style.pointerEvents = 'none';
        particle.style.zIndex = '1000';
        
        const rect = element.getBoundingClientRect();
        particle.style.left = `${rect.left + Math.random() * rect.width}px`;
        particle.style.top = `${rect.top + Math.random() * rect.height}px`;
        
        document.body.appendChild(particle);
        
        // Animate particle
        particle.animate([
            { 
                transform: 'translate(0, 0) scale(1)', 
                opacity: 1 
            },
            { 
                transform: `translate(${Math.random() * 100 - 50}px, ${-Math.random() * 100}px) scale(0)`, 
                opacity: 0 
            }
        ], {
            duration: 1000,
            easing: 'ease-out'
        }).onfinish = () => particle.remove();
    }
}

// Smooth scroll for anchor links (if any)
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

// Add loading animation
window.addEventListener('load', () => {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});

// Keyboard navigation support
document.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
        const focusedElement = document.activeElement;
        if (focusedElement.classList.contains('shop-card')) {
            const platform = focusedElement.getAttribute('data-platform');
            redirectToShop(platform);
        }
    }
});

// Add tabindex to cards for accessibility
document.querySelectorAll('.shop-card').forEach(card => {
    card.setAttribute('tabindex', '0');
    card.setAttribute('role', 'button');
    card.setAttribute('aria-label', `Belanja di ${card.querySelector('.platform-name').textContent}`);
});

// Console log for debugging
console.log('Shop page loaded successfully!');
console.log('Available platforms:', Object.keys(shopLinks));