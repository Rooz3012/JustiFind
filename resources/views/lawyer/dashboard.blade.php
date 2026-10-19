@include('layouts.header')

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
        @if($profile)
        <h2>Welcome back, {{ explode(' ', $profile->Name)[0] }} 👋</h2>
        <p style="color:var(--text-muted); font-size:0.9rem;">{{ $profile->Practice_Area }} · {{ $profile->Experience }} years experience</p>
        @else
        <h2>Lawyer Dashboard</h2>
        @endif
        <div class="dashboard-hero-badges">
            <span class="earnings-badge">💰 ৳{{ number_format($earnings) }} earned</span>
            @if($verification && $verification->is_verified)
                <span class="verified-badge">✅ Verified Lawyer</span>
            @else
                <span class="unverified-badge">⏳ Pending Verification</span>
            @endif
            @if($unreadMessages > 0)
                <span class="unverified-badge">💬 {{ $unreadMessages }} new messages</span>
            @endif
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
            @if($unreadMessages > 0)
                <span class="badge-count">{{ $unreadMessages }}</span>
            @endif
        </span>
    </a>
    <a href="http://localhost/justifind/public/notifications" class="action-card">
        <span class="action-icon">🔔</span>
        <span class="action-label">
            Alerts
            @if($unreadNotifications > 0)
                <span class="badge-count">{{ $unreadNotifications }}</span>
            @endif
        </span>
    </a>
</div>

<div class="dashboard-grid">
    <div class="dashboard-panel">
        <div class="panel-header">📅 Upcoming Consultations</div>
        @forelse($upcoming as $con)
        @php $cno = $con->C_NO; @endphp
        <div class="consultation-item">
            <div class="con-header">
                <span class="con-client">👤 {{ $con->Client_Name }}</span>
                <span class="status-badge status-scheduled">Scheduled</span>
            </div>
            <div class="con-details">
                <span>📅 {{ $con->Date }}</span>
                <span>🕐 {{ $con->Time }}</span>
                <span>{{ $con->Online ? '🌐 Online' : '🏢 In-Person' }}</span>
            </div>
            <div class="con-type">📁 {{ $con->Type }}</div>
            <form action="http://localhost/justifind/public/update-consultation-status" method="POST" class="status-form">
                @csrf
                <input type="hidden" name="consultation_id" value="{{ $cno }}">
                <select name="status" class="status-select">
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Update</button>
            </form>
        </div>
        @empty
        <div class="empty-text">
            <div style="font-size:2rem; margin-bottom:0.5rem; opacity:0.4;">📅</div>
            No upcoming consultations
        </div>
        @endforelse
    </div>

    <div class="dashboard-panel">
        <div class="panel-header">✅ Recent Completed Cases</div>
        @forelse($past as $con)
        <div class="consultation-item">
            <div class="con-header">
                <span class="con-client">👤 {{ $con->Client_Name }}</span>
                <span class="status-badge status-completed">Completed</span>
            </div>
            <div class="con-details">
                <span>📅 {{ $con->Date }}</span>
                <span>💰 ৳{{ number_format($con->Amount ?? 0) }}</span>
                <span>{{ $con->Payment_Method ?? 'N/A' }}</span>
            </div>
            <div class="con-type">📁 {{ $con->Type }}</div>
        </div>
        @empty
        <div class="empty-text">
            <div style="font-size:2rem; margin-bottom:0.5rem; opacity:0.4;">✅</div>
            No completed cases yet
        </div>
        @endforelse
    </div>
</div>

@include('layouts.footer')