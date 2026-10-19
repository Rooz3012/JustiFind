@include('layouts.header')

<style>
    .notif-hero {
        background: linear-gradient(135deg, var(--dark2), var(--dark3));
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .notif-hero-left { display: flex; align-items: center; gap: 1rem; }
    .notif-hero-icon {
        font-size: 2.5rem;
        animation: float 3s ease-in-out infinite;
    }
    .notif-hero h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--text);
    }
    .notif-hero p { color: var(--text-muted); font-size: 0.88rem; }
    .notif-list { display: flex; flex-direction: column; gap: 0.8rem; }
    .notification-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .notification-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--border);
        transition: background 0.3s;
    }
    .notification-card.unread {
        background: rgba(201,168,76,0.03);
        border-color: rgba(201,168,76,0.2);
    }
    .notification-card.unread::before {
        background: linear-gradient(180deg, var(--primary), var(--primary-dark));
    }
    .notification-card:hover {
        border-color: rgba(201,168,76,0.3);
        transform: translateX(3px);
    }
    .notif-icon-circle {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--dark3);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .notif-content { flex: 1; }
    .notif-title {
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--text);
        margin-bottom: 0.3rem;
    }
    .notif-message {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.5;
    }
    .notif-date {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.5rem;
        opacity: 0.7;
    }
    .new-badge {
        background: var(--primary);
        color: var(--dark);
        padding: 0.15rem 0.5rem;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 800;
        flex-shrink: 0;
    }
</style>

<div class="notif-hero">
    <div class="notif-hero-left">
        <div class="notif-hero-icon">🔔</div>
        <div>
            <h2>Notifications</h2>
            <p>Stay updated with your latest activity</p>
        </div>
    </div>
    <form action="http://localhost/justifind/public/notifications/mark-read" method="POST">
        @csrf
        <button type="submit" class="btn btn-ghost btn-sm">✓ Mark All Read</button>
    </form>
</div>

@if(count($notifications) > 0)
<div class="notif-list">
    @foreach($notifications as $notif)
    <div class="notification-card {{ !$notif->is_read ? 'unread' : '' }}">
        <div class="notif-icon-circle">
            @if(str_contains($notif->title, 'Payment')) 💰
            @elseif(str_contains($notif->title, 'Message')) 💬
            @elseif(str_contains($notif->title, 'Booking') || str_contains($notif->title, 'Consultation')) 📅
            @elseif(str_contains($notif->title, 'Verified') || str_contains($notif->title, 'Verification')) ✅
            @elseif(str_contains($notif->title, 'Cancelled')) ❌
            @elseif(str_contains($notif->title, 'Rescheduled')) 🔄
            @else 🔔
            @endif
        </div>
        <div class="notif-content">
            <div class="notif-title">{{ $notif->title }}</div>
            <div class="notif-message">{{ $notif->message }}</div>
            <div class="notif-date">
                🕐 {{ date('M d, Y · h:i A', strtotime($notif->created_at)) }}
            </div>
        </div>
        @if(!$notif->is_read)
            <span class="new-badge">NEW</span>
        @endif
    </div>
    @endforeach
</div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">🔔</div>
        <p>No notifications yet. We'll notify you of important updates!</p>
    </div>
@endif

@include('layouts.footer')