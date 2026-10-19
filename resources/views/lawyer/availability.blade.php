@include('layouts.header')

<style>
    .availability-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    .avail-panel {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.8rem;
        transition: border-color 0.3s;
    }
    .avail-panel:hover { border-color: rgba(201,168,76,0.2); }
    .panel-title {
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
    .avail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.9rem 1rem;
        border-radius: 12px;
        margin-bottom: 0.6rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        transition: all 0.2s;
    }
    .avail-item:hover {
        border-color: rgba(201,168,76,0.3);
        transform: translateX(3px);
    }
    .avail-day {
        font-weight: 700;
        color: var(--primary);
        font-size: 0.9rem;
    }
    .avail-time {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-top: 0.2rem;
    }
    .day-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .day-btn {
        padding: 0.6rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text-muted);
        font-family: inherit;
        font-size: 0.82rem;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }
    .day-btn:hover, .day-btn.selected {
        background: rgba(201,168,76,0.1);
        border-color: var(--primary);
        color: var(--primary);
    }
    @media(max-width:768px) { .availability-grid { grid-template-columns: 1fr; } }
</style>

<a href="http://localhost/justifind/public/lawyer-dashboard" class="back-link">← Back to Dashboard</a>

<h2 class="page-title">📅 Manage Availability</h2>

<div class="availability-grid">
    <div class="avail-panel">
        <div class="panel-title">➕ Add Availability</div>
        <form action="http://localhost/justifind/public/lawyer-availability" method="POST">
            @csrf
            <div class="form-group">
                <label>Day of Week</label>
                <select name="day_of_week" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>
            <div class="form-group">
                <label>Start Time</label>
                <input type="time" name="start_time" required>
            </div>
            <div class="form-group">
                <label>End Time</label>
                <input type="time" name="end_time" required>
            </div>
            <button type="submit" class="btn btn-primary btn-full">Save Availability</button>
        </form>
    </div>

    <div class="avail-panel">
        <div class="panel-title">📋 Current Schedule</div>
        @forelse($availability as $slot)
        <div class="avail-item">
            <div>
                <div class="avail-day">{{ $slot->day_of_week }}</div>
                <div class="avail-time">🕐 {{ $slot->start_time }} — {{ $slot->end_time }}</div>
            </div>
            <form action="http://localhost/justifind/public/lawyer-availability/delete" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $slot->id }}">
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Remove this slot?')">Remove</button>
            </form>
        </div>
        @empty
        <div class="empty-state" style="padding:2rem;">
            <div class="empty-state-icon" style="font-size:2rem;">📅</div>
            <p style="font-size:0.9rem;">No availability set yet.</p>
        </div>
        @endforelse
    </div>
</div>

@include('layouts.footer')