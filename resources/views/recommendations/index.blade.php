@include('layouts.header')

<style>
    .rec-hero {
        background: linear-gradient(135deg, var(--dark2) 0%, var(--dark3) 100%);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        text-align: center;
    }
    .rec-hero::before {
        content: '';
        position: absolute;
        top: -50%; left: 50%;
        transform: translateX(-50%);
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .rec-hero-badge {
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
        margin-bottom: 1rem;
    }
    .rec-hero h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--text);
        margin-bottom: 0.5rem;
    }
    .rec-hero p { color: var(--text-muted); font-size: 0.95rem; }
    .rec-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    .rec-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 1.8rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .rec-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }
    .rec-card:hover {
        border-color: rgba(201,168,76,0.4);
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    }
    .rec-card-top {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .rec-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--dark);
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(201,168,76,0.3);
    }
    .rec-info { flex: 1; }
    .rec-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 0.4rem;
    }
    .match-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: rgba(201,168,76,0.12);
        color: var(--primary);
        border: 1px solid rgba(201,168,76,0.25);
        padding: 0.2rem 0.7rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .rec-bio {
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin: 0.8rem 0;
    }
    .rec-stats {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
        padding: 0.8rem;
        background: var(--dark3);
        border-radius: 10px;
        border: 1px solid var(--border);
    }
    .rec-stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }
    .rec-stat-value {
        font-weight: 700;
        color: var(--primary);
        font-size: 0.9rem;
    }
    .rec-stat-label {
        font-size: 0.68rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .rec-actions {
        display: flex;
        gap: 0.6rem;
    }
</style>

<div class="rec-hero">
    <div class="rec-hero-badge">✦ AI-Powered Recommendations</div>
    <h2>⭐ Recommended for You</h2>
    <p>Personalized lawyer suggestions based on your consultation history and preferences</p>
</div>

@if(count($recommended) > 0)
<div class="rec-grid">
    @foreach($recommended as $lawyer)
    @php
        $lid = $lawyer->LID;
        $lname = addslashes($lawyer->Name);
        $lrate = $lawyer->Hourly_Rate;
    @endphp
    <div class="rec-card">
        <div class="rec-card-top">
            <div class="rec-avatar">{{ strtoupper(substr($lawyer->Name, 0, 1)) }}</div>
            <div class="rec-info">
                <div class="rec-name">{{ $lawyer->Name }}</div>
                <span class="match-badge">⭐ Best Match</span>
                <br>
                <span class="practice-badge">{{ $lawyer->Practice_Area }}</span>
            </div>
        </div>
        <p class="rec-bio">{{ substr($lawyer->Profile, 0, 110) }}...</p>
        <div class="rec-stats">
            <div class="rec-stat">
                <span class="rec-stat-value">{{ $lawyer->Experience }}yr</span>
                <span class="rec-stat-label">Experience</span>
            </div>
            <div class="rec-stat">
                <span class="rec-stat-value">{{ $lawyer->Success_Rate }}%</span>
                <span class="rec-stat-label">Success</span>
            </div>
            <div class="rec-stat">
                <span class="rec-stat-value">{{ $lawyer->review_count }}</span>
                <span class="rec-stat-label">Reviews</span>
            </div>
            <div class="rec-stat">
                <span class="rec-stat-value">৳{{ number_format($lawyer->Hourly_Rate) }}</span>
                <span class="rec-stat-label">Per Hour</span>
            </div>
        </div>
        <div class="rec-actions">
            <a href="http://localhost/justifind/public/lawyer-profile?lawyer_id={{ $lid }}"
                class="btn btn-ghost btn-sm" style="flex:1; justify-content:center;">
                View Profile
            </a>
            <button class="btn btn-primary btn-sm" style="flex:1; justify-content:center;"
                onclick="openBooking({{ $lid }}, '{{ $lname }}', {{ $lrate }})">
                Book Now
            </button>
        </div>
    </div>
    @endforeach
</div>

{{-- BOOKING MODAL --}}
<div id="bookingModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <h3>📅 Book a Consultation</h3>
            <button onclick="closeBooking()" class="modal-close">✕</button>
        </div>
        <form action="http://localhost/justifind/public/book" method="POST">
            @csrf
            <input type="hidden" name="lawyer_id" id="modal_lawyer_id">
            <div class="modal-lawyer-info">
                <strong id="modal_lawyer_name" style="color:var(--text);"></strong>
                <span id="modal_lawyer_rate" class="rate-badge"></span>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="consultation_date" required
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>
            <div class="form-group">
                <label>Time</label>
                <input type="time" name="consultation_time" required>
            </div>
            <div class="form-group">
                <label>Case Type</label>
                <input type="text" name="consultation_type"
                    placeholder="e.g. Divorce Case" required>
            </div>
            <div class="form-group">
                <label>Mode</label>
                <select name="consultation_mode" required>
                    <option value="online">🌐 Online</option>
                    <option value="offline">🏢 In-Person</option>
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
                <button type="button" onclick="closeBooking()" class="btn btn-ghost">Cancel</button>
                <button type="submit" class="btn btn-primary">Confirm Booking →</button>
            </div>
        </form>
    </div>
</div>

@else
<div class="empty-state">
    <div class="empty-state-icon">⭐</div>
    <p>No recommendations yet. Book a consultation first!</p>
    <a href="http://localhost/justifind/public" class="btn btn-primary" style="margin-top:1rem;">
        Find a Lawyer →
    </a>
</div>
@endif

@include('layouts.footer')