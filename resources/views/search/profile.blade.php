@include('layouts.header')

<style>
    .profile-hero {
        background: linear-gradient(135deg, var(--dark2) 0%, var(--dark3) 100%);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .profile-hero::before {
        content: '';
        position: absolute;
        top: -30%; right: -10%;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .profile-hero-inner {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        flex-wrap: wrap;
    }
    .profile-avatar-xl {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--dark);
        flex-shrink: 0;
        box-shadow: 0 8px 30px rgba(201,168,76,0.3);
        animation: pulse-gold 3s ease-in-out infinite;
    }
    .profile-hero-info { flex: 1; min-width: 200px; }
    .profile-hero-name {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 0.6rem;
    }
    .profile-stats-grid {
        display: flex;
        gap: 1rem;
        margin-top: 1.2rem;
        flex-wrap: wrap;
    }
    .profile-stat-box {
        text-align: center;
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 0.8rem 1.3rem;
        transition: all 0.2s;
    }
    .profile-stat-box:hover {
        border-color: rgba(201,168,76,0.3);
        background: rgba(201,168,76,0.05);
    }
    .profile-stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary);
        display: block;
    }
    .profile-stat-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.2rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .profile-body {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }
    .profile-section {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.8rem;
        margin-bottom: 1.5rem;
        transition: border-color 0.3s;
    }
    .profile-section:hover { border-color: rgba(201,168,76,0.2); }
    .profile-section-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .profile-bio {
        color: var(--text);
        line-height: 1.8;
        font-size: 0.92rem;
    }
    .spec-grid {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }
    .spec-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.7rem 0.9rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 0.88rem;
        transition: border-color 0.2s;
    }
    .spec-item:hover { border-color: rgba(201,168,76,0.3); }
    .spec-label { color: var(--text-muted); font-size: 0.82rem; }
    .spec-value { color: var(--primary); font-weight: 700; }
    .review-card {
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.2rem;
        margin-bottom: 1rem;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }
    .review-card::before {
        content: '"';
        position: absolute;
        top: -10px; right: 15px;
        font-size: 5rem;
        color: rgba(201,168,76,0.1);
        font-family: 'Playfair Display', serif;
        line-height: 1;
    }
    .review-card:hover {
        border-color: rgba(201,168,76,0.3);
        transform: translateX(3px);
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.6rem;
        font-size: 0.82rem;
    }
    .reviewer-name { color: var(--primary); font-weight: 600; }
    .review-date { color: var(--text-muted); }
    .review-text {
        color: var(--text);
        font-size: 0.9rem;
        line-height: 1.7;
    }
    @media(max-width:768px) { .profile-body { grid-template-columns: 1fr; } }
</style>

<a href="http://localhost/justifind/public" class="back-link">← Back to Search</a>

@if($notFound)
<div class="empty-state">
    <div class="empty-state-icon">🔍</div>
    <p>Lawyer not found or no longer available.</p>
    <a href="http://localhost/justifind/public" class="btn btn-primary" style="margin-top:1rem;">
        Back to Search →
    </a>
</div>

@elseif($lawyer)
<div class="profile-hero">
    <div class="profile-hero-inner">
        <div class="profile-avatar-xl">
            {{ strtoupper(substr($lawyer->Name, 0, 1)) }}
        </div>
        <div class="profile-hero-info">
            <div class="profile-hero-name">{{ $lawyer->Name }}</div>
            @if($isVerified)
            <span style="background:rgba(201,168,76,0.15); border:1px solid var(--primary); color:var(--primary); padding:0.3rem 0.8rem; border-radius:20px; font-size:0.78rem; font-weight:700;">✅ Verified Lawyer</span>
            @endif
            <span class="practice-badge" style="font-size:0.85rem; padding:0.3rem 1rem;">
                {{ $lawyer->Practice_Area }}
            </span>
            <div class="profile-stats-grid">
                <div class="profile-stat-box">
                    <span class="profile-stat-value">{{ $lawyer->Experience }}</span>
                    <span class="profile-stat-label">Yrs Experience</span>
                </div>
                <div class="profile-stat-box">
                    <span class="profile-stat-value">{{ $lawyer->Success_Rate }}%</span>
                    <span class="profile-stat-label">Success Rate</span>
                </div>
                <div class="profile-stat-box">
                    <span class="profile-stat-value">৳{{ number_format($lawyer->Hourly_Rate) }}</span>
                    <span class="profile-stat-label">Per Hour</span>
                </div>
            </div>
        </div>
        @if(session('role') == 'Client')
        @php $lid=$lawyer->LID; $lname=addslashes($lawyer->Name); $lrate=$lawyer->Hourly_Rate; @endphp
        <button class="btn btn-primary btn-lg"
            onclick="openBooking({{ $lid }}, '{{ $lname }}', {{ $lrate }})">
            📅 Book Consultation
        </button>
        @endif
    </div>
</div>

<div class="profile-body">
    <div>
        <div class="profile-section">
            <div class="profile-section-title">📖 About</div>
            <p class="profile-bio">{{ $lawyer->Profile }}</p>
        </div>

        <div class="profile-section">
            <div class="profile-section-title">⭐ Client Reviews</div>
            @forelse($reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <span class="reviewer-name">👤 {{ $review->Client_Name }}</span>
                    <span class="review-date">{{ $review->Rev_Date }}</span>
                </div>
                <p class="review-text">{{ $review->Rev_Text }}</p>
            </div>
            @empty
            <div style="text-align:center; padding:2rem; color:var(--text-muted);">
                <div style="font-size:2rem; margin-bottom:0.5rem; opacity:0.4;">⭐</div>
                No reviews yet for this lawyer.
            </div>
            @endforelse
        </div>
    </div>

    <div>
        @if($lawyer->specialty)
        <div class="profile-section">
            <div class="profile-section-title">🎯 Specialization</div>
            <div class="spec-grid">
                @if($lawyer->Practice_Area == 'Family Law')
                <div class="spec-item">
                    <span class="spec-label">Family Cases</span>
                    <span class="spec-value">{{ $lawyer->specialty->Family_Cases }}</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Mediation</span>
                    <span class="spec-value">{{ $lawyer->specialty->Mediation ? '✅ Yes' : '❌ No' }}</span>
                </div>
                @elseif($lawyer->Practice_Area == 'Criminal Law')
                <div class="spec-item">
                    <span class="spec-label">Criminal Cases</span>
                    <span class="spec-value">{{ $lawyer->specialty->Criminal_Cases }}</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">License Level</span>
                    <span class="spec-value">{{ $lawyer->specialty->License_LvL }}</span>
                </div>
                @elseif($lawyer->Practice_Area == 'Corporate Law')
                <div class="spec-item">
                    <span class="spec-label">Corp. Clients</span>
                    <span class="spec-value">{{ $lawyer->specialty->Corp_clients }}</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Contract Making</span>
                    <span class="spec-value">{{ $lawyer->specialty->Contract_Making ? '✅ Yes' : '❌ No' }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="profile-section">
            <div class="profile-section-title">📋 Quick Info</div>
            <div class="spec-grid">
                <div class="spec-item">
                    <span class="spec-label">Experience</span>
                    <span class="spec-value">{{ $lawyer->Experience }} years</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Hourly Rate</span>
                    <span class="spec-value">৳{{ number_format($lawyer->Hourly_Rate) }}</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Success Rate</span>
                    <span class="spec-value">{{ $lawyer->Success_Rate }}%</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Practice Area</span>
                    <span class="spec-value">{{ $lawyer->Practice_Area }}</span>
                </div>
            </div>
        </div>

        @if(session('role') == 'Client')
        <div class="profile-section" style="text-align:center;">
            <div class="profile-section-title">📅 Book This Lawyer</div>
            <p style="color:var(--text-muted); font-size:0.85rem; margin-bottom:1rem;">
                Schedule a consultation at your convenience
            </p>
            <button class="btn btn-primary btn-full"
                onclick="openBooking({{ $lawyer->LID }}, '{{ addslashes($lawyer->Name) }}', {{ $lawyer->Hourly_Rate }})">
                Book Consultation →
            </button>
        </div>
        @endif
    </div>
</div>

{{-- BOOKING MODAL --}}
@if(session('role') == 'Client')
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
@endif
@endif

@include('layouts.footer')