@include('layouts.header')

<style>
    .messages-hero {
        background: linear-gradient(135deg, var(--dark2), var(--dark3));
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .messages-hero-icon {
        font-size: 3rem;
        animation: float 3s ease-in-out infinite;
    }
    .messages-hero h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--text);
    }
    .messages-hero p { color: var(--text-muted); font-size: 0.88rem; }
    .conversation-list { display: flex; flex-direction: column; gap: 0.8rem; }
    .conversation-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.3rem 1.5rem;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }
    .conversation-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, var(--primary), var(--primary-dark));
        opacity: 0;
        transition: opacity 0.3s;
    }
    .conversation-card:hover {
        border-color: rgba(201,168,76,0.3);
        transform: translateX(4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    .conversation-card:hover::before { opacity: 1; }
    .conversation-card.unread {
        border-color: rgba(201,168,76,0.2);
        background: rgba(201,168,76,0.03);
    }
    .conversation-card.unread::before { opacity: 1; }
    .conv-avatar {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--dark);
        flex-shrink: 0;
    }
    .conv-info { flex: 1; }
    .conv-name {
        font-weight: 700;
        color: var(--text);
        font-size: 0.95rem;
        margin-bottom: 0.3rem;
    }
    .conv-meta {
        font-size: 0.8rem;
        color: var(--text-muted);
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }
    .conv-right { text-align: right; }
    .unread-badge {
        background: var(--primary);
        color: var(--dark);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 800;
        display: inline-block;
    }
    .conv-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.3rem;
    }
</style>

<div class="messages-hero">
    <div class="messages-hero-icon">💬</div>
    <div>
        <h2>Messages</h2>
        <p>Your conversations with lawyers and clients</p>
    </div>
</div>

@if(count($consultations) > 0)
    <div class="conversation-list">
        @foreach($consultations as $conv)
        <a href="http://localhost/justifind/public/messages/{{ $conv->C_NO }}"
            class="conversation-card {{ $conv->unread > 0 ? 'unread' : '' }}">
            <div class="conv-avatar">
                {{ strtoupper(substr($conv->Other_Name, 0, 1)) }}
            </div>
            <div class="conv-info">
                <div class="conv-name">{{ $conv->Other_Name }}</div>
                <div class="conv-meta">
                    <span>📁 {{ $conv->Type }}</span>
                    <span>🔖 Consultation #{{ $conv->C_NO }}</span>
                    <span>📅 {{ $conv->Date }}</span>
                </div>
            </div>
            <div class="conv-right">
                @if($conv->unread > 0)
                    <span class="unread-badge">{{ $conv->unread }} new</span>
                @endif
                <div class="conv-hint">Click to open →</div>
            </div>
        </a>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">💬</div>
        <p>No conversations yet. Book a consultation to start messaging!</p>
        <a href="http://localhost/justifind/public" class="btn btn-primary">Find a Lawyer →</a>
    </div>
@endif

@include('layouts.footer')