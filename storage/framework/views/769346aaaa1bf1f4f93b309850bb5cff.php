<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2rem;
    }
    .analytics-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .analytics-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }
    .analytics-card:hover {
        border-color: rgba(201,168,76,0.4);
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }
    .analytics-icon {
        font-size: 2.2rem;
        margin-bottom: 0.8rem;
        display: block;
        animation: float 3s ease-in-out infinite;
    }
    .analytics-value {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        display: block;
        margin-bottom: 0.3rem;
    }
    .analytics-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    .analytics-section {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.8rem;
        margin-bottom: 1.5rem;
        transition: border-color 0.3s;
    }
    .analytics-section:hover { border-color: rgba(201,168,76,0.2); }
    .section-head {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        color: var(--text);
        margin-bottom: 1.5rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .bar-chart { display: flex; flex-direction: column; gap: 1rem; }
    .bar-item { display: flex; align-items: center; gap: 1rem; }
    .bar-label {
        width: 120px;
        font-size: 0.82rem;
        color: var(--text-muted);
        flex-shrink: 0;
        text-align: right;
    }
    .bar-track {
        flex: 1;
        background: var(--dark3);
        border-radius: 20px;
        height: 28px;
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-dark), var(--primary));
        border-radius: 20px;
        display: flex;
        align-items: center;
        padding-left: 0.8rem;
        color: var(--dark);
        font-size: 0.78rem;
        font-weight: 700;
        min-width: 40px;
        transition: width 1s ease;
    }
    .bar-value {
        font-size: 0.82rem;
        color: var(--primary);
        font-weight: 700;
        width: 80px;
        text-align: right;
        flex-shrink: 0;
    }
    .client-table { width: 100%; border-collapse: collapse; }
    .client-table th {
        padding: 0.7rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border);
        font-weight: 700;
    }
    .client-table td {
        padding: 0.8rem 1rem;
        font-size: 0.85rem;
        color: var(--text);
        border-bottom: 1px solid rgba(48,54,61,0.5);
    }
    .client-table tr:hover td { background: rgba(201,168,76,0.03); }
</style>

<a href="http://localhost/justifind/public/lawyer-dashboard" class="back-link">← Back to Dashboard</a>

<h2 class="page-title">📊 Analytics Dashboard</h2>

<div class="analytics-grid">
    <div class="analytics-card">
        <span class="analytics-icon">📋</span>
        <span class="analytics-value" data-count="<?php echo e($totalConsultations); ?>"><?php echo e($totalConsultations); ?></span>
        <span class="analytics-label">Total Consultations</span>
    </div>
    <div class="analytics-card">
        <span class="analytics-icon">✅</span>
        <span class="analytics-value" data-count="<?php echo e($completedConsultations); ?>"><?php echo e($completedConsultations); ?></span>
        <span class="analytics-label">Completed</span>
    </div>
    <div class="analytics-card">
        <span class="analytics-icon">❌</span>
        <span class="analytics-value" data-count="<?php echo e($cancelledConsultations); ?>"><?php echo e($cancelledConsultations); ?></span>
        <span class="analytics-label">Cancelled</span>
    </div>
    <div class="analytics-card">
        <span class="analytics-icon">💰</span>
        <span class="analytics-value">৳<?php echo e(number_format($totalEarnings)); ?></span>
        <span class="analytics-label">Total Earnings</span>
    </div>
    <div class="analytics-card">
        <span class="analytics-icon">⭐</span>
        <span class="analytics-value" data-count="<?php echo e($totalReviews); ?>"><?php echo e($totalReviews); ?></span>
        <span class="analytics-label">Total Reviews</span>
    </div>
</div>

<div class="analytics-section">
    <div class="section-head">📈 Monthly Earnings</div>
    <?php if(count($monthlyEarnings) > 0): ?>
    <?php $maxEarning = max(array_column((array)$monthlyEarnings, 'total')); ?>
    <div class="bar-chart">
        <?php $__currentLoopData = $monthlyEarnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $percent = $maxEarning > 0 ? ($month->total / $maxEarning) * 100 : 0; ?>
        <div class="bar-item">
            <div class="bar-label"><?php echo e($month->month); ?></div>
            <div class="bar-track">
                <div class="bar-fill" style="width:<?php echo e($percent); ?>%">
                    <?php if($percent > 15): ?> ৳<?php echo e(number_format($month->total)); ?> <?php endif; ?>
                </div>
            </div>
            <div class="bar-value">৳<?php echo e(number_format($month->total)); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <p style="color:var(--text-muted); text-align:center; padding:2rem;">No earnings data yet.</p>
    <?php endif; ?>
</div>

<div class="analytics-section">
    <div class="section-head">📁 Consultation Types</div>
    <?php if(count($typeBreakdown) > 0): ?>
    <?php $maxCount = max(array_column((array)$typeBreakdown, 'count')); ?>
    <div class="bar-chart">
        <?php $__currentLoopData = $typeBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $percent = $maxCount > 0 ? ($type->count / $maxCount) * 100 : 0; ?>
        <div class="bar-item">
            <div class="bar-label"><?php echo e(substr($type->Type, 0, 18)); ?></div>
            <div class="bar-track">
                <div class="bar-fill" style="width:<?php echo e($percent); ?>%">
                    <?php if($percent > 15): ?> <?php echo e($type->count); ?> <?php endif; ?>
                </div>
            </div>
            <div class="bar-value"><?php echo e($type->count); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <p style="color:var(--text-muted); text-align:center; padding:2rem;">No data yet.</p>
    <?php endif; ?>
</div>

<div class="analytics-section">
    <div class="section-head">💳 Payment Methods</div>
    <?php if(count($paymentMethods) > 0): ?>
    <div class="bar-chart">
        <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $percent = $totalConsultations > 0 ? ($pm->count / $totalConsultations) * 100 : 0; ?>
        <div class="bar-item">
            <div class="bar-label"><?php echo e($pm->Method); ?></div>
            <div class="bar-track">
                <div class="bar-fill" style="width:<?php echo e($percent); ?>%">
                    <?php if($percent > 15): ?> <?php echo e($pm->count); ?>x <?php endif; ?>
                </div>
            </div>
            <div class="bar-value">৳<?php echo e(number_format($pm->total)); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <p style="color:var(--text-muted); text-align:center; padding:2rem;">No payment data yet.</p>
    <?php endif; ?>
</div>

<div class="analytics-section">
    <div class="section-head">👥 Recent Clients</div>
    <?php if(count($recentClients) > 0): ?>
    <table class="client-table">
        <thead>
            <tr><th>Client</th><th>Email</th><th>Last Consultation</th></tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $recentClients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>👤 <?php echo e($client->Client_Name); ?></td>
                <td style="color:var(--text-muted);"><?php echo e($client->Client_Email); ?></td>
                <td style="color:var(--primary);"><?php echo e($client->Last_Consultation); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <p style="color:var(--text-muted); text-align:center; padding:2rem;">No clients yet.</p>
    <?php endif; ?>
</div>

<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\justifind\resources\views/lawyer/analytics.blade.php ENDPATH**/ ?>