<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
    .admin-hero {
        background: linear-gradient(135deg, var(--dark2), var(--dark3));
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .admin-hero::before {
        content: '';
        position: absolute;
        top: -30%; right: -5%;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
    }
    .admin-hero h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        color: var(--text);
        margin-bottom: 0.3rem;
    }
    .admin-hero p { color: var(--text-muted); font-size: 0.9rem; }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.3rem;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }
    .stat-card:hover {
        border-color: rgba(201,168,76,0.3);
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .stat-icon { font-size: 1.8rem; margin-bottom: 0.5rem; display: block; }
    .stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        display: block;
    }
    .stat-label { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.2rem; }
    .admin-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        background: var(--dark2);
        padding: 0.5rem;
        border-radius: 14px;
        border: 1px solid var(--border);
    }
    .tab-btn {
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 10px;
        background: transparent;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.82rem;
        font-family: inherit;
        color: var(--text-muted);
        transition: all 0.2s;
    }
    .tab-btn:hover { color: var(--text); background: var(--dark3); }
    .tab-btn.active {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--dark);
    }
    .tab-panel {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        overflow-x: auto;
        animation: fadeInUp 0.3s ease;
    }
    .tab-panel h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        margin-bottom: 1.2rem;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .admin-table { width: 100%; border-collapse: collapse; min-width: 600px; }
    .admin-table thead { background: var(--dark3); }
    .admin-table th {
        padding: 0.8rem 1rem;
        text-align: left;
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border);
    }
    .admin-table td {
        padding: 0.85rem 1rem;
        font-size: 0.85rem;
        color: var(--text);
        border-bottom: 1px solid rgba(48,54,61,0.5);
        transition: background 0.2s;
    }
    .admin-table tr:hover td { background: rgba(201,168,76,0.03); }
    .delete-form { display: flex; gap: 0.4rem; align-items: center; flex-wrap: wrap; }
    .delete-input {
        padding: 0.35rem 0.6rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 0.78rem;
        font-family: inherit;
        color: var(--text);
        width: 90px;
    }
    .verify-form { display: flex; gap: 0.4rem; align-items: center; flex-wrap: wrap; }
    .mini-select {
        padding: 0.35rem 0.6rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 0.78rem;
        font-family: inherit;
        color: var(--text);
    }
</style>

<div class="admin-hero">
    <h2>🛡️ Admin Dashboard</h2>
    <p>Platform management and oversight for JustiFind</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-icon">👥</span>
        <span class="stat-value"><?php echo e($stats['total_clients']); ?></span>
        <span class="stat-label">Total Clients</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">👨‍⚖️</span>
        <span class="stat-value"><?php echo e($stats['total_lawyers']); ?></span>
        <span class="stat-label">Total Lawyers</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">📋</span>
        <span class="stat-value"><?php echo e($stats['total_bookings']); ?></span>
        <span class="stat-label">Total Bookings</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">💰</span>
        <span class="stat-value">৳<?php echo e(number_format($stats['total_revenue'])); ?></span>
        <span class="stat-label">Total Revenue</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">🎫</span>
        <span class="stat-value"><?php echo e($stats['pending_tickets']); ?></span>
        <span class="stat-label">Open Tickets</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">⏳</span>
        <span class="stat-value"><?php echo e($stats['unverified_lawyers']); ?></span>
        <span class="stat-label">Unverified</span>
    </div>
</div>

<div class="admin-tabs">
    <button class="tab-btn active" onclick="showTab('clients', event)">👥 Clients</button>
    <button class="tab-btn" onclick="showTab('lawyers', event)">👨‍⚖️ Lawyers</button>
    <button class="tab-btn" onclick="showTab('verify', event)">✅ Verify</button>
    <button class="tab-btn" onclick="showTab('bookings', event)">📋 Bookings</button>
    <button class="tab-btn" onclick="showTab('transactions', event)">💰 Payments</button>
    <button class="tab-btn" onclick="showTab('tickets', event)">🎫 Tickets</button>
</div>

<div id="tab-clients" class="tab-panel">
    <h3>👥 All Clients (<?php echo e(count($clients)); ?>)</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Age</th><th>Gender</th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#<?php echo e($client->CID); ?></span></td>
                <td><?php echo e($client->Name); ?></td>
                <td style="color:var(--text-muted);"><?php echo e($client->Email ?? 'N/A'); ?></td>
                <td><?php echo e($client->Phone ?? 'N/A'); ?></td>
                <td><?php echo e($client->Address ?? 'N/A'); ?></td>
                <td><?php echo e($client->Age ?? 'N/A'); ?></td>
                <td><?php echo e($client->Gender ?? 'N/A'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div id="tab-lawyers" class="tab-panel" style="display:none;">
    <h3>👨‍⚖️ All Lawyers (<?php echo e(count($lawyers)); ?>)</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Experience</th><th>Success Rate</th><th>Rate/hr</th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $lawyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lawyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#<?php echo e($lawyer->LID); ?></span></td>
                <td><?php echo e($lawyer->Name); ?></td>
                <td style="color:var(--text-muted);"><?php echo e($lawyer->Email); ?></td>
                <td><?php echo e($lawyer->Phone ?? 'N/A'); ?></td>
                <td><?php echo e($lawyer->Experience); ?> yrs</td>
                <td>
                    <div style="display:flex; align-items:center; gap:0.5rem;">
                        <div style="flex:1; height:4px; background:var(--dark3); border-radius:2px; overflow:hidden;">
                            <div style="height:100%; width:<?php echo e($lawyer->Success_Rate); ?>%; background:linear-gradient(90deg,var(--primary),var(--primary-dark)); border-radius:2px;"></div>
                        </div>
                        <span style="font-size:0.8rem; color:var(--primary);"><?php echo e($lawyer->Success_Rate); ?>%</span>
                    </div>
                </td>
                <td><span style="color:#3fb950; font-weight:700;">৳<?php echo e(number_format($lawyer->Hourly_Rate)); ?></span></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div id="tab-verify" class="tab-panel" style="display:none;">
    <h3>✅ Lawyer Verification</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Name</th><th>Experience</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $unverifiedLawyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lawyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $lid = $lawyer->LID; ?>
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#<?php echo e($lid); ?></span></td>
                <td><?php echo e($lawyer->Name); ?></td>
                <td><?php echo e($lawyer->Experience); ?> yrs</td>
                <td>
                    <?php if($lawyer->is_verified): ?>
                        <span class="status-badge status-completed">✅ Verified</span>
                    <?php else: ?>
                        <span class="pay-badge pay-pending">⏳ Pending</span>
                    <?php endif; ?>
                </td>
                <td>
                    <form action="http://localhost/justifind/public/admin/verify-lawyer" method="POST" class="verify-form">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="lawyer_id" value="<?php echo e($lid); ?>">
                        <select name="is_verified" class="mini-select">
                            <option value="1" <?php echo e($lawyer->is_verified ? 'selected' : ''); ?>>✅ Verify</option>
                            <option value="0" <?php echo e(!$lawyer->is_verified ? 'selected' : ''); ?>>❌ Reject</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div id="tab-bookings" class="tab-panel" style="display:none;">
    <h3>📋 All Bookings (<?php echo e(count($bookings)); ?>)</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Client</th><th>Lawyer</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $bno = $booking->C_NO; ?>
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#<?php echo e($bno); ?></span></td>
                <td><?php echo e($booking->Client_Name); ?></td>
                <td><?php echo e($booking->Lawyer_Name); ?></td>
                <td style="color:var(--text-muted);"><?php echo e($booking->Date); ?></td>
                <td><span class="status-badge status-<?php echo e(strtolower($booking->CStatus)); ?>"><?php echo e($booking->CStatus); ?></span></td>
                <td>
                    <form action="http://localhost/justifind/public/admin/delete-booking" method="POST" class="delete-form"
                        onsubmit="return confirm('Delete booking #<?php echo e($bno); ?>?')">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="booking_id" value="<?php echo e($bno); ?>">
                        <input type="text" name="delete_reason" placeholder="Reason" class="delete-input">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div id="tab-transactions" class="tab-panel" style="display:none;">
    <h3>💰 Recent Transactions</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Client</th><th>Lawyer</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#<?php echo e($tx->Pay_ID); ?></span></td>
                <td><?php echo e($tx->Client_Name); ?></td>
                <td><?php echo e($tx->Lawyer_Name); ?></td>
                <td><span style="color:#3fb950; font-weight:700;">৳<?php echo e(number_format($tx->Amount)); ?></span></td>
                <td><?php echo e($tx->Method); ?></td>
                <td><span class="pay-badge pay-<?php echo e(strtolower($tx->PStatus)); ?>"><?php echo e($tx->PStatus); ?></span></td>
                <td style="color:var(--text-muted);"><?php echo e($tx->Date); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div id="tab-tickets" class="tab-panel" style="display:none;">
    <h3>🎫 Support Tickets</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Client</th><th>Subject</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $tid = $ticket->id; ?>
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#<?php echo e($tid); ?></span></td>
                <td><?php echo e($ticket->Client_Name); ?></td>
                <td><?php echo e($ticket->subject); ?></td>
                <td>
                    <span class="status-badge status-<?php echo e(strtolower(str_replace(' ','-',$ticket->status))); ?>">
                        <?php echo e($ticket->status); ?>

                    </span>
                </td>
                <td style="color:var(--text-muted);"><?php echo e(date('M d', strtotime($ticket->created_at))); ?></td>
                <td>
                    <form action="http://localhost/justifind/public/admin/update-ticket" method="POST"
                        style="display:flex; gap:0.4rem; flex-wrap:wrap; align-items:center;">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="ticket_id" value="<?php echo e($tid); ?>">
                        <input type="text" name="reply" placeholder="Reply..." class="delete-input">
                        <select name="status" class="mini-select">
                            <option value="Open">Open</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Closed">Closed</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\justifind\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>