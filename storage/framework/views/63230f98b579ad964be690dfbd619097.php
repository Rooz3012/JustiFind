</div>

<footer class="site-footer">
    <div class="footer-logo">⚖️ JustiFind</div>
    <p>Your trusted platform for premium on-demand legal services across Bangladesh</p>
    <p style="margin-top:0.8rem;">
        <a href="http://localhost/justifind/public">Home</a> |
        <?php if(!session('role')): ?>
            <a href="http://localhost/justifind/public">Login</a>
        <?php else: ?>
            <a href="http://localhost/justifind/public/logout">Logout</a>
        <?php endif; ?>
        | <a href="http://localhost/justifind/public/support-tickets">Support</a>
    </p>
    <p style="margin-top:1rem; font-size:0.78rem; opacity:0.5;">© 2026 JustiFind. All rights reserved.</p>
</footer>

<script>
function openBooking(lawyerId, lawyerName, hourlyRate) {
    document.getElementById('bookingModal').style.display = 'flex';
    document.getElementById('modal_lawyer_id').value = lawyerId;
    document.getElementById('modal_lawyer_name').textContent = '👨‍⚖️ ' + lawyerName;
    document.getElementById('modal_lawyer_rate').textContent = '৳' + hourlyRate.toLocaleString() + '/hr';
}
function closeBooking() {
    document.getElementById('bookingModal').style.display = 'none';
}
function showTab(tabName, event) {
    document.querySelectorAll('.tab-panel').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + tabName).style.display = 'block';
    event.target.classList.add('active');
}
document.addEventListener('click', function(e) {
    const modal = document.getElementById('bookingModal');
    if (modal && e.target === modal) closeBooking();
});

// ===== PARTICLE SYSTEM =====
function createParticles() {
    const container = document.createElement('div');
    container.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:0;overflow:hidden;';
    document.body.appendChild(container);
    for (let i = 0; i < 25; i++) {
        const particle = document.createElement('div');
        const size = (Math.random() * 4 + 2) + 'px';
        particle.style.cssText = `
            position:absolute;
            width:${size};height:${size};
            background:#c9a84c;
            border-radius:50%;
            left:${Math.random() * 100}%;
            top:${Math.random() * 100}%;
            opacity:${Math.random() * 0.15 + 0.05};
            animation:particleFloat ${Math.random() * 15 + 8}s linear ${Math.random() * 5}s infinite;
        `;
        container.appendChild(particle);
    }
}
createParticles();

// Add particle animation
const particleStyle = document.createElement('style');
particleStyle.textContent = `
    @keyframes particleFloat {
        0% { transform: translateY(0) rotate(0deg); opacity: 0.1; }
        50% { opacity: 0.2; }
        100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
    }
    @keyframes rippleAnim {
        to { transform: scale(4); opacity: 0; }
    }
`;
document.head.appendChild(particleStyle);

// ===== SCROLL REVEAL =====
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }, index * 80);
        }
    });
}, { threshold: 0.05 });

document.querySelectorAll('.lawyer-card, .card, .dashboard-panel, .appointment-card, .stat-card, .analytics-card, .rec-card, .notification-card, .ticket-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    revealObserver.observe(el);
});

// ===== 3D TILT EFFECT =====
document.querySelectorAll('.lawyer-card, .rec-card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = (y - centerY) / 25;
        const rotateY = (centerX - x) / 25;
        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02) translateY(-4px)`;
        card.style.transition = 'transform 0.1s ease';
        card.style.boxShadow = `${-rotateY * 2}px ${rotateX * 2}px 30px rgba(201,168,76,0.15)`;
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1) translateY(0)';
        card.style.transition = 'transform 0.4s ease, box-shadow 0.4s ease';
        card.style.boxShadow = '';
    });
});

// ===== RIPPLE EFFECT =====
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        ripple.style.cssText = `
            position:absolute;width:${size}px;height:${size}px;
            top:${e.clientY-rect.top-size/2}px;
            left:${e.clientX-rect.left-size/2}px;
            background:rgba(255,255,255,0.25);border-radius:50%;
            transform:scale(0);animation:rippleAnim 0.6s ease-out;pointer-events:none;
        `;
        this.style.position = 'relative';
        this.style.overflow = 'hidden';
        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });
});

// ===== SMOOTH PAGE TRANSITIONS =====
document.body.style.opacity = '0';
document.body.style.transform = 'translateY(15px)';
document.body.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
setTimeout(() => {
    document.body.style.opacity = '1';
    document.body.style.transform = 'translateY(0)';
}, 50);

document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="mailto"])').forEach(link => {
    link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href && href.startsWith('/') && !this.closest('form')) {
            e.preventDefault();
            document.body.style.opacity = '0';
            document.body.style.transform = 'translateY(-15px)';
            setTimeout(() => { window.location.href = href; }, 350);
        }
    });
});

// ===== NAVBAR SCROLL EFFECT =====
const header = document.querySelector('.site-header');
if (header) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.style.background = 'rgba(13,17,23,0.99)';
            header.style.boxShadow = '0 4px 30px rgba(0,0,0,0.6)';
            header.style.borderBottomColor = 'rgba(201,168,76,0.2)';
        } else {
            header.style.background = 'rgba(13,17,23,0.95)';
            header.style.boxShadow = 'none';
            header.style.borderBottomColor = '';
        }
    });
}

// ===== MAGNETIC BUTTON =====
document.querySelectorAll('.btn-primary').forEach(btn => {
    btn.addEventListener('mousemove', (e) => {
        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        btn.style.transform = `translate(${x * 0.12}px, ${y * 0.12}px)`;
    });
    btn.addEventListener('mouseleave', () => {
        btn.style.transform = '';
        btn.style.transition = 'transform 0.3s ease';
    });
    btn.addEventListener('mouseenter', () => {
        btn.style.transition = 'transform 0.1s ease';
    });
});

// ===== ANIMATED COUNTERS =====
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const el = entry.target;
            const target = parseFloat(el.getAttribute('data-count'));
            const isDecimal = el.getAttribute('data-count').includes('.');
            if (!isNaN(target)) {
                let start = 0;
                const duration = 1500;
                const increment = target / (duration / 16);
                const timer = setInterval(() => {
                    start += increment;
                    if (start >= target) {
                        el.textContent = isDecimal ? target.toFixed(1) : Math.floor(target).toLocaleString();
                        clearInterval(timer);
                    } else {
                        el.textContent = isDecimal ? start.toFixed(1) : Math.floor(start).toLocaleString();
                    }
                }, 16);
            }
            counterObserver.unobserve(el);
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('[data-count]').forEach(el => {
    counterObserver.observe(el);
});

// ===== GLOW EFFECT ON HOVER FOR STAT CARDS =====
document.querySelectorAll('.stat-card, .analytics-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.boxShadow = '0 0 30px rgba(201,168,76,0.2), 0 8px 30px rgba(0,0,0,0.3)';
        card.style.borderColor = 'rgba(201,168,76,0.4)';
        card.style.transition = 'all 0.3s ease';
    });
    card.addEventListener('mouseleave', () => {
        card.style.boxShadow = '';
        card.style.borderColor = '';
    });
});

// ===== CURSOR GLOW EFFECT =====
const cursorGlow = document.createElement('div');
cursorGlow.style.cssText = `
    position:fixed;width:300px;height:300px;
    background:radial-gradient(circle, rgba(201,168,76,0.04) 0%, transparent 70%);
    border-radius:50%;pointer-events:none;z-index:1;
    transform:translate(-50%,-50%);transition:left 0.1s ease, top 0.1s ease;
`;
document.body.appendChild(cursorGlow);
document.addEventListener('mousemove', (e) => {
    cursorGlow.style.left = e.clientX + 'px';
    cursorGlow.style.top = e.clientY + 'px';
});

console.log('%c⚖️ JustiFind', 'color:#c9a84c;font-size:20px;font-weight:bold;');
console.log('%cPremium Legal Platform', 'color:#8b949e;font-size:12px;');
</script>
</body>
</html><?php /**PATH C:\laragon\www\justifind\resources\views/layouts/footer.blade.php ENDPATH**/ ?>