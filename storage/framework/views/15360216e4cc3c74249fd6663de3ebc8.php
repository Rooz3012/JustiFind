<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
    .dashboard-hero {
        background: linear-gradient(135deg, var(--dark2), var(--dark3));
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }
    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: -50%; right: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .dashboard-hero-left h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        color: var(--text);
        margin-bottom: 0.5rem;
    }
    .dashboard-hero-badges {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        margin-top: 0.8rem;
    }
    .earnings-badge {
        background: rgba(63,185,80,0.12);
        color: #3fb950;
        border: 1px solid rgba(63,185,80,0.25);
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .verified-badge {
        background: rgba(56,139,253,0.12);
        color: #58a6ff;
        border: 1px solid rgba(56,139,253,0.25);
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .unverified-badge {
        background: rgba(201,168,76,0.12);
        color: var(--primary);
        border: 1px solid rgba(201,168,76,0.25);
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .action-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.3rem 1rem;
        text-align: center;
        text-decoration: none;
        color: var(--text);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .action-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    .action-card:hover {
        border-color: rgba(201,168,76,0.4);
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        color: var(--primary);
    }
    .action-card:hover::after { transform: scaleX(1); }
    .action-icon {
        font-size: 2rem;
        margin-bottom: 0.6rem;
        display: block;
        transition: transform 0.3s ease;
    }
    .action-card:hover .action-icon { transform: scale(1.2) rotate(5deg); }
    .action-label { font-size: 0.82rem; font-weight: 600; }
    .badge-count {
        display: inline-block;
        background: var(--danger);
        color: white;
        border-radius: 20px;
        padding: 0.1rem 0.5rem;
        font-size: 0.68rem;
        font-weight: 700;
        margin-left: 4px;
        vertical-align: middle;
    }
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    .dashboard-panel {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.5rem;
        transition: border-color 0.3s;
    }
    .dashboard-panel:hover { border-color: rgba(201,168,76,0.2); }
    .panel-header {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1.2rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .consultation-item {
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.8rem;
        transition: all 0.2s;
    }
    .consultation-item:hover {
        border-color: rgba(201,168,76,0.3);
        transform: translateX(3px);
    }
    .con-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.6rem;
        flex-wrap: wrap;
        gap: 0.3rem;
    }
    .con-client { font-weight: 600; color: var(--text); font-size: 0.9rem; }
    .con-details {
        display: flex;
        gap: 0.8rem;
        font-size: 0.8rem;
        color: var(--text-muted);
        flex-wrap: wrap;
        margin-bottom: 0.5rem;
    }
    .con-type { font-size: 0.78rem; color: var(--primary); }
    .status-form {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.6rem;
        flex-wrap: wrap;
    }
    .status-select {
        padding: 0.35rem 0.6rem;
        background: var(--dark2);
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 0.78rem;
        font-family: inherit;
        color: var(--text);
    }
    .empty-text {
        text-align: center;
        color: var(--text-muted);
        font-size: 0.9rem;
        padding: 2rem 1rem;
    }
    @media(max-width:768px) { .dashboard-grid { grid-template-columns: 1fr; } }
</style>

<div class="dashboard-hero">
    <div class="dashboard-hero-left">
        <?php if($profile): ?>
        <h2>Welcome back, <?php echo e(explode(' ', $profile->Name)[0]); ?> 👋</h2>
        <p style="color:var(--text-muted); font-size:0.9rem;"><?php echo e($profile->Practice_Area); ?> · <?php echo e($profile->Experience); ?> years experience</p>
        <?php else: ?>
        <h2>Lawyer Dashboard</h2>
        <?php endif; ?>
        <div class="dashboard-hero-badges">
            <span class="earnings-badge">💰 ৳<?php echo e(number_format($earnings)); ?> earned</span>
            <?php if($verification && $verification->is_verified): ?>
                <span class="verified-badge">✅ Verified Lawyer</span>
            <?php else: ?>
                <span class="unverified-badge">⏳ Pending Verification</span>
            <?php endif; ?>
            <?php if($unreadMessages > 0): ?>
                <span class="unverified-badge">💬 <?php echo e($unreadMessages); ?> new messages</span>
            <?php endif; ?>
        </div>
    </div>
    <div style="font-size:4rem; opacity:0.3; animation:float 3s ease-in-out infinite;">⚖️</div>
</div>

<div class="quick-actions">
    <a href="http://localhost/justifind/public/lawyer-profile-edit" class="action-card">
        <span class="action-icon">✏️</span>
        <span class="action-label">Edit Profile</span>
    </a>
    <a href="http://localhost/justifind/public/lawyer-availability" class="action-card">
        <span class="action-icon">📅</span>
        <span class="action-label">Availability</span>
    </a>
    <a href="http://localhost/justifind/public/lawyer-analytics" class="action-card">
        <span class="action-icon">📊</span>
        <span class="action-label">Analytics</span>
    </a>
    <a href="http://localhost/justifind/public/messages" class="action-card">
        <span class="action-icon">💬</span>
        <span class="action-label">
            Messages
            <?php if($unreadMessages > 0): ?>
                <span class="badge-count"><?php echo e($unreadMessages); ?></span>
            <?php endif; ?>
        </span>
    </a>
    <a href="http://localhost/justifind/public/notifications" class="action-card">
        <span class="action-icon">🔔</span>
        <span class="action-label">
            Alerts
            <?php if($unreadNotifications > 0): ?>
                <span class="badge-count"><?php echo e($unreadNotifications); ?></span>
            <?php endif; ?>
        </span>
    </a>
</div>

<div class="dashboard-grid">
    <div class="dashboard-panel">
        <div class="panel-header">📅 Upcoming Consultations</div>
        <?php $__empty_1 = true; $__currentLoopData = $upcoming; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $con): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $cno = $con->C_NO; ?>
        <div class="consultation-item">
            <div class="con-header">
                <span class="con-client">👤 <?php echo e($con->Client_Name); ?></span>
                <span class="status-badge status-scheduled">Scheduled</span>
            </div>
            <div class="con-details">
                <span>📅 <?php echo e($con->Date); ?></span>
                <span>🕐 <?php echo e($con->Time); ?></span>
                <span><?php echo e($con->Online ? '🌐 Online' : '🏢 In-Person'); ?></span>
            </div>
            <div class="con-type">📁 <?php echo e($con->Type); ?></div>
            <form action="http://localhost/justifind/public/update-consultation-status" method="POST" class="status-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="consultation_id" value="<?php echo e($cno); ?>">
                <select name="status" class="status-select">
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Update</button>
            </form>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-text">
            <div style="font-size:2rem; margin-bottom:0.5rem; opacity:0.4;">📅</div>
            No upcoming consultations
        </div>
        <?php endif; ?>
    </div>

    <div class="dashboard-panel">
        <div class="panel-header">✅ Recent Completed Cases</div>
        <?php $__empty_1 = true; $__currentLoopData = $past; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $con): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="consultation-item">
            <div class="con-header">
                <span class="con-client">👤 <?php echo e($con->Client_Name); ?></span>
                <span class="status-badge status-completed">Completed</span>
            </div>
            <div class="con-details">
                <span>📅 <?php echo e($con->Date); ?></span>
                <span>💰 ৳<?php echo e(number_format($con->Amount ?? 0)); ?></span>
                <span><?php echo e($con->Payment_Method ?? 'N/A'); ?></span>
            </div>
            <div class="con-type">📁 <?php echo e($con->Type); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-text">
            <div style="font-size:2rem; margin-bottom:0.5rem; opacity:0.4;">✅</div>
            No completed cases yet
        </div>
        <?php endif; ?>
    </div>
</div>

<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\justifind\resources\views/lawyer/dashboard.blade.php ENDPATH**/ ?>