@include('layouts.header')

<style>
    .support-hero {
        background: linear-gradient(135deg, var(--dark2), var(--dark3));
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .support-hero-icon {
        font-size: 2.5rem;
        animation: float 3s ease-in-out infinite;
    }
    .support-hero h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--text);
    }
    .support-hero p { color: var(--text-muted); font-size: 0.88rem; }
    .new-ticket-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.8rem;
        margin-bottom: 2rem;
        transition: border-color 0.3s;
    }
    .new-ticket-card:hover { border-color: rgba(201,168,76,0.2); }
    .new-ticket-title {
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
    .ticket-list { display: flex; flex-direction: column; gap: 1rem; }
    .ticket-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .ticket-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        transition: background 0.3s;
    }
    .ticket-card.open::before { background: #f85149; }
    .ticket-card.in-progress::before { background: var(--primary); }
    .ticket-card.closed::before { background: #3fb950; }
    .ticket-card:hover {
        border-color: rgba(201,168,76,0.3);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.8rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .ticket-subject {
        font-weight: 700;
        color: var(--text);
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .ticket-client {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-top: 0.2rem;
    }
    .ticket-status {
        padding: 0.25rem 0.8rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
    }
    .status-open { background: rgba(248,81,73,0.12); color: #f85149; border: 1px solid rgba(248,81,73,0.25); }
    .status-in-progress { background: rgba(201,168,76,0.12); color: var(--primary); border: 1px solid rgba(201,168,76,0.25); }
    .status-closed { background: rgba(63,185,80,0.12); color: #3fb950; border: 1px solid rgba(63,185,80,0.25); }
    .ticket-desc {
        font-size: 0.88rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 0.8rem;
    }
    .ticket-meta {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        gap: 1rem;
    }
    .admin-reply-section {
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 0.8rem;
    }
    .admin-reply-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.8rem;
    }
    .reply-form {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        align-items: center;
    }
    .reply-input {
        flex: 1;
        padding: 0.65rem 1rem;
        background: var(--dark2);
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.85rem;
        font-family: inherit;
        color: var(--text);
        min-width: 150px;
        transition: border-color 0.2s;
    }
    .reply-input:focus { outline: none; border-color: var(--primary); }
    .reply-select {
        padding: 0.65rem 0.9rem;
        background: var(--dark2);
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.82rem;
        font-family: inherit;
        color: var(--text);
    }
</style>

<div class="support-hero">
    <div class="support-hero-icon">🎫</div>
    <div>
        <h2>Support Tickets</h2>
        <p>Get help from our support team anytime</p>
    </div>
</div>

@if($role == 'Client')
<div class="new-ticket-card">
    <div class="new-ticket-title">➕ Create New Ticket</div>
    <form action="http://localhost/justifind/public/support-tickets" method="POST">
        @csrf
        <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject"
                placeholder="Briefly describe your issue" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" required
                style="width:100%; padding:0.75rem 1rem; background:var(--dark3); border:1px solid var(--border); border-radius:10px; font-family:inherit; font-size:0.9rem; color:var(--text); resize:vertical; transition:border-color 0.2s;"
                placeholder="Provide more details about your issue..."
                onfocus="this.style.borderColor='var(--primary)'"
                onblur="this.style.borderColor='var(--border)'"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Ticket 🎫</button>
    </form>
</div>
@endif

@if(count($tickets) > 0)
<div class="ticket-list">
    @foreach($tickets as $ticket)
    @php
        $statusClass = strtolower(str_replace(' ', '-', $ticket->status));
    @endphp
    <div class="ticket-card {{ $statusClass }}">
        <div class="ticket-header">
            <div>
                <div class="ticket-subject">🎫 {{ $ticket->subject }}</div>
                @if(isset($ticket->Client_Name))
                    <div class="ticket-client">👤 {{ $ticket->Client_Name }}</div>
                @endif
            </div>
            <span class="ticket-status status-{{ $statusClass }}">
                {{ $ticket->status }}
            </span>
        </div>
        <div class="ticket-desc">{{ $ticket->description }}</div>
        <div class="ticket-meta">
            <span>📅 {{ date('M d, Y', strtotime($ticket->created_at)) }}</span>
            <span>💬 {{ $ticket->reply_count }} replies</span>
        </div>

        @if($role == 'Admin')
        <div class="admin-reply-section">
            <div class="admin-reply-title">🛡️ Admin Response</div>
            <form action="http://localhost/justifind/public/admin/update-ticket" method="POST">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <div class="reply-form">
                    <input type="text" name="reply"
                        placeholder="Write a reply..." class="reply-input">
                    <select name="status" class="reply-select">
                        <option value="Open" {{ $ticket->status=='Open'?'selected':'' }}>Open</option>
                        <option value="In Progress" {{ $ticket->status=='In Progress'?'selected':'' }}>In Progress</option>
                        <option value="Closed" {{ $ticket->status=='Closed'?'selected':'' }}>Closed</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
        @endif
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="empty-state-icon">🎫</div>
    <p>No support tickets yet.</p>
    @if($role == 'Client')
        <p style="font-size:0.85rem; margin-top:0.5rem;">
            Create a ticket above if you need help!
        </p>
    @endif
</div>
@endif

@include('layouts.footer')