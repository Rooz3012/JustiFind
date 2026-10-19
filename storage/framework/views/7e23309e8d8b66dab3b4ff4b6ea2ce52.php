<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
    .hero {
        text-align: center;
        padding: 4rem 2rem 3rem;
        position: relative;
        overflow: hidden;
    }
    .hero::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(ellipse at center, rgba(201,168,76,0.08) 0%, transparent 60%);
        pointer-events: none;
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(201,168,76,0.1);
        border: 1px solid rgba(201,168,76,0.3);
        color: var(--primary);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    .hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--text);
        line-height: 1.2;
        margin-bottom: 1rem;
    }
    .hero h1 span { color: var(--primary); }
    .hero p {
        font-size: 1.1rem;
        color: var(--text-muted);
        max-width: 600px;
        margin: 0 auto 2.5rem;
        line-height: 1.7;
    }
    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    .hero-stat { text-align: center; }
    .hero-stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
    }
    .hero-stat-label {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-top: 0.2rem;
    }
    .login-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 2.5rem;
        max-width: 480px;
        margin: 0 auto 3rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    .login-card-header { text-align: center; margin-bottom: 2rem; }
    .login-card-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        color: var(--text);
        margin-bottom: 0.4rem;
    }
    .login-card-header p { color: var(--text-muted); font-size: 0.88rem; }
    .login-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1.5rem 0;
        color: var(--text-muted);
        font-size: 0.8rem;
    }
    .login-divider::before, .login-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }
    .login-sample {
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1.2rem;
    }
    .login-sample-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.6rem;
    }
    .login-sample-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.3rem 0;
        border-bottom: 1px solid var(--border);
        font-size: 0.82rem;
    }
    .login-sample-item:last-child { border-bottom: none; }
    .login-sample-role { color: var(--text-muted); font-weight: 600; }
    .login-sample-email { color: var(--primary); font-family: monospace; font-size: 0.8rem; }
    .register-link {
        text-align: center;
        margin-top: 1.2rem;
        font-size: 0.88rem;
        color: var(--text-muted);
    }
    .register-link a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .register-link a:hover { opacity: 0.8; text-decoration: underline; }
    .forgot-link-row {
        text-align: center;
        margin-top: 1rem;
    }
    .forgot-link-row a {
        font-size: 0.85rem;
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.2s;
    }
    .forgot-link-row a:hover { color: var(--primary); }
    .search-section { max-width: 900px; margin: 0 auto 3rem; }
    .search-bar-wrapper {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    .search-bar-row { display: flex; gap: 0.8rem; margin-bottom: 1rem; }
    .search-input {
        flex: 1;
        padding: 0.9rem 1.2rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 12px;
        font-size: 0.95rem;
        font-family: inherit;
        color: var(--text);
        transition: all 0.2s;
    }
    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
    }
    .search-input::placeholder { color: var(--text-muted); }
    .filter-row { display: flex; gap: 0.8rem; flex-wrap: wrap; }
    .filter-row select, .filter-row input {
        padding: 0.6rem 0.9rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 0.85rem;
        font-family: inherit;
        color: var(--text);
        flex: 1;
        min-width: 140px;
    }
    .filter-row select option { background: var(--dark2); }
    .quick-links { display: flex; gap: 0.8rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text);
    }
    .section-count {
        font-size: 0.85rem;
        color: var(--text-muted);
        background: var(--dark3);
        border: 1px solid var(--border);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
    }
    .lawyer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.5rem;
    }
    .lawyer-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.8rem;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    .lawyer-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        opacity: 0;
        transition: opacity 0.3s;
    }
    .lawyer-card:hover {
        border-color: rgba(201,168,76,0.4);
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    .lawyer-card:hover::before { opacity: 1; }
    .lawyer-card-top { display: flex; gap: 1rem; margin-bottom: 1.2rem; }
    .lawyer-avatar {
        width: 60px; height: 60px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        color: var(--dark); font-size: 1.5rem; font-weight: 800; flex-shrink: 0;
    }
    .lawyer-info { flex: 1; }
    .lawyer-name { font-size: 1.05rem; font-weight: 700; color: var(--text); margin-bottom: 0.4rem; }
    .lawyer-bio { font-size: 0.82rem; color: var(--text-muted); line-height: 1.6; margin: 0.6rem 0; }
    .lawyer-stats { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 0.8rem; }
    .lawyer-stat { display: flex; align-items: center; gap: 0.3rem; font-size: 0.8rem; color: var(--text-muted); }
    .lawyer-stat-value { font-weight: 700; color: var(--text); }
    .lawyer-divider { height: 1px; background: var(--border); margin: 1rem 0; }
    .lawyer-actions { display: flex; gap: 0.6rem; }
</style>

<?php if(!session('role')): ?>
<div class="hero">
    <div class="hero-badge">✦ Bangladesh's Premier Legal Platform</div>
    <h1>Find Your <span>Legal Expert</span><br>With Confidence</h1>
    <p>Connect with verified, experienced lawyers across Bangladesh. Get expert legal advice anytime, anywhere.</p>
    <div class="hero-stats">
        <div class="hero-stat">
            <div class="hero-stat-value">15+</div>
            <div class="hero-stat-label">Verified Lawyers</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-value">15+</div>
            <div class="hero-stat-label">Happy Clients</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-value">95%</div>
            <div class="hero-stat-label">Success Rate</div>
        </div>
    </div>
</div>

<div class="login-card">
    <div class="login-card-header">
        <h3>Welcome Back</h3>
        <p>Sign in to access your legal services</p>
    </div>
    <form action="http://localhost/justifind/public/login" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="login_email"
                placeholder="your.email@Client.com" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="login_pass"
                placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-full btn-lg">
            Sign In →
        </button>
    </form>

    <div class="forgot-link-row">
        <a href="http://localhost/justifind/public/forgot-password">
            🔐 Forgot your password?
        </a>
    </div>

    <div class="register-link">
        Don't have an account?
        <a href="http://localhost/justifind/public/register">Create Account →</a>
    </div>

    <div class="login-divider">Email Format Guide</div>
    <div class="login-sample">
        <div class="login-sample-title">Use your role-based email domain</div>
        <div class="login-sample-item">
            <span class="login-sample-role">👤 Client</span>
            <span class="login-sample-email">yourname@Client.com</span>
        </div>
        <div class="login-sample-item">
            <span class="login-sample-role">👨‍⚖️ Lawyer</span>
            <span class="login-sample-email">yourname@Law.co</span>
        </div>
        <div class="login-sample-item">
            <span class="login-sample-role">🛡️ Admin</span>
            <span class="login-sample-email">yourname@Admin.com</span>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(session('role') == 'Client'): ?>
<div class="quick-links">
    <a href="http://localhost/justifind/public/recommendations" class="btn btn-outline btn-sm">⭐ Recommended for You</a>
    <a href="http://localhost/justifind/public/messages" class="btn btn-ghost btn-sm">💬 Messages</a>
    <a href="http://localhost/justifind/public/support-tickets" class="btn btn-ghost btn-sm">🎫 Support</a>
    <a href="http://localhost/justifind/public/notifications" class="btn btn-ghost btn-sm">🔔 Notifications</a>
</div>
<?php endif; ?>

<?php if(session('role') == 'Lawyer'): ?>
<div class="quick-links">
    <a href="http://localhost/justifind/public/lawyer-dashboard" class="btn btn-outline btn-sm">📊 My Dashboard</a>
    <a href="http://localhost/justifind/public/lawyer-analytics" class="btn btn-ghost btn-sm">📈 Analytics</a>
    <a href="http://localhost/justifind/public/lawyer-availability" class="btn btn-ghost btn-sm">📅 Availability</a>
    <a href="http://localhost/justifind/public/messages" class="btn btn-ghost btn-sm">💬 Messages</a>
</div>
<?php endif; ?>

<div class="search-section">
    <form action="http://localhost/justifind/public" method="GET">
        <div class="search-bar-wrapper">
            <div class="search-bar-row">
                <input type="text" name="q"
                    value="<?php echo e($filters['search']); ?>"
                    placeholder="🔍 Search lawyers by name, specialization..."
                    class="search-input">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
            <div class="filter-row">
                <select name="practice_area">
                    <option value="">All Practice Areas</option>
                    <option value="family" <?php echo e($filters['practice_area'] == 'family' ? 'selected' : ''); ?>>⚖️ Family Law</option>
                    <option value="criminal" <?php echo e($filters['practice_area'] == 'criminal' ? 'selected' : ''); ?>>🔒 Criminal Law</option>
                    <option value="corporate" <?php echo e($filters['practice_area'] == 'corporate' ? 'selected' : ''); ?>>🏢 Corporate Law</option>
                </select>
                <input type="number" name="min_experience"
                    placeholder="Min Experience (yrs)"
                    value="<?php echo e($filters['min_experience']); ?>">
                <input type="number" name="max_fee"
                    placeholder="Max Fee (৳/hr)"
                    value="<?php echo e($filters['max_fee']); ?>">
                <input type="number" name="min_success"
                    placeholder="Min Success (%)" step="0.1"
                    value="<?php echo e($filters['min_success']); ?>">
            </div>
        </div>
    </form>
</div>

<div class="section-header">
    <div class="section-title">Available Lawyers</div>
    <span class="section-count"><?php echo e(count($lawyers)); ?> lawyers found</span>
</div>

<div class="lawyer-grid">
    <?php $__empty_1 = true; $__currentLoopData = $lawyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lawyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $lid = $lawyer->LID;
        $lname = addslashes($lawyer->Name);
        $lrate = $lawyer->Hourly_Rate;
    ?>
    <div class="lawyer-card">
        <div class="lawyer-card-top">
            <div class="lawyer-avatar">
                <?php echo e(strtoupper(substr($lawyer->Name, 0, 1))); ?>

            </div>
            <div class="lawyer-info">
                <div class="lawyer-name"><?php echo e($lawyer->Name); ?></div>
                <span class="practice-badge"><?php echo e($lawyer->Practice_Area); ?></span>
            </div>
        </div>
        <p class="lawyer-bio"><?php echo e(substr($lawyer->Profile, 0, 110)); ?>...</p>
        <div class="lawyer-stats">
            <div class="lawyer-stat">
                📅 <span class="lawyer-stat-value"><?php echo e($lawyer->Experience); ?> yrs</span>
            </div>
            <div class="lawyer-stat">
                ✅ <span class="lawyer-stat-value"><?php echo e($lawyer->Success_Rate); ?>%</span>
            </div>
            <div class="lawyer-stat">
                💰 <span class="lawyer-stat-value">৳<?php echo e(number_format($lawyer->Hourly_Rate)); ?>/hr</span>
            </div>
        </div>
        <div class="lawyer-divider"></div>
        <div class="lawyer-actions">
            <a href="http://localhost/justifind/public/lawyer-profile?lawyer_id=<?php echo e($lid); ?>"
                class="btn btn-ghost btn-sm" style="flex:1; justify-content:center;">
                View Profile
            </a>
            <?php if(session('role') == 'Client'): ?>
            <button class="btn btn-primary btn-sm"
                style="flex:1; justify-content:center;"
                onclick="openBooking(<?php echo e($lid); ?>, '<?php echo e($lname); ?>', <?php echo e($lrate); ?>)">
                Book Now
            </button>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="empty-state" style="grid-column:1/-1;">
        <div class="empty-state-icon">🔍</div>
        <p>No lawyers found matching your search criteria.</p>
        <a href="http://localhost/justifind/public" class="btn btn-outline">Clear Filters</a>
    </div>
    <?php endif; ?>
</div>

<?php if(session('role') == 'Client'): ?>
<div id="bookingModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <h3>📅 Book a Consultation</h3>
            <button onclick="closeBooking()" class="modal-close">✕</button>
        </div>
        <form action="http://localhost/justifind/public/book" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="lawyer_id" id="modal_lawyer_id">
            <div class="modal-lawyer-info">
                <strong id="modal_lawyer_name" style="color:var(--text);"></strong>
                <span id="modal_lawyer_rate" class="rate-badge"></span>
            </div>
            <div class="form-group">
                <label>Consultation Date</label>
                <input type="date" name="consultation_date" required
                    min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>">
            </div>
            <div class="form-group">
                <label>Preferred Time</label>
                <input type="time" name="consultation_time" required>
            </div>
            <div class="form-group">
                <label>Case Type</label>
                <input type="text" name="consultation_type"
                    placeholder="e.g. Divorce Case, Criminal Defense" required>
            </div>
            <div class="form-group">
                <label>Consultation Mode</label>
                <select name="consultation_mode" required>
                    <option value="online">🌐 Online Video Call</option>
                    <option value="offline">🏢 In-Person Meeting</option>
                </select>
            </div>
            <div class="form-group">
                <label>Payment Method</label>
                <select name="payment_method" required>
                    <option value="bKash">📱 bKash</option>
                    <option value="Nagad">📱 Nagad</option>
                    <option value="Rocket">📱 Rocket</option>
                    <option value="Bank Transfer">🏦 Bank Transfer</option>
                    <option value="Cash">💵 Cash</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeBooking()"
                    class="btn btn-ghost">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    Confirm Booking →
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\justifind\resources\views/search/index.blade.php ENDPATH**/ ?>