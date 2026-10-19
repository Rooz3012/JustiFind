@include('layouts.header')

<style>
    .appointments-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .appointment-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.8rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .appointment-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        opacity: 0;
        transition: opacity 0.3s;
    }
    .appointment-card:hover {
        border-color: rgba(201,168,76,0.3);
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        transform: translateY(-2px);
    }
    .appointment-card:hover::before { opacity: 1; }
    .appt-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.2rem;
        flex-wrap: wrap;
        gap: 0.8rem;
    }
    .appt-lawyer-info h4 {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        color: var(--text);
        margin-bottom: 0.4rem;
    }
    .appt-status-group { display: flex; gap: 0.5rem; flex-wrap: wrap; }
    .appt-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 0.8rem;
        margin-bottom: 1.2rem;
        padding: 1rem;
        background: var(--dark3);
        border-radius: 12px;
        border: 1px solid var(--border);
    }
    .appt-detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }
    .appt-detail-label {
        font-size: 0.72rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    .appt-detail-value {
        font-size: 0.9rem;
        color: var(--text);
        font-weight: 600;
    }
    .appt-meta {
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border);
    }
    .appt-actions {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }
    .payment-section {
        background: rgba(201,168,76,0.06);
        border: 1px solid rgba(201,168,76,0.2);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1rem;
    }
    .payment-section h5 {
        color: var(--primary);
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .payment-form {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        align-items: center;
    }
    .payment-select {
        padding: 0.6rem 0.9rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.85rem;
        font-family: inherit;
        color: var(--text);
    }
    .collapsible {
        border: 1px solid var(--border);
        border-radius: 12px;
        margin-bottom: 0.8rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .collapsible:hover { border-color: rgba(201,168,76,0.3); }
    .collapsible summary {
        padding: 0.9rem 1.2rem;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        list-style: none;
        transition: all 0.2s;
        background: var(--dark3);
    }
    .collapsible summary:hover { color: var(--primary); background: rgba(201,168,76,0.05); }
    .collapsible summary::-webkit-details-marker { display: none; }
    .collapsible summary::before {
        content: '▶';
        font-size: 0.6rem;
        transition: transform 0.3s;
    }
    .collapsible[open] summary::before { transform: rotate(90deg); }
    .collapsible-body {
        padding: 1.2rem;
        border-top: 1px solid var(--border);
        background: var(--card-bg);
    }
    .form-row {
        display: flex;
        gap: 0.8rem;
        margin-bottom: 0.8rem;
        flex-wrap: wrap;
    }
    .form-row input {
        flex: 1;
        padding: 0.7rem 0.9rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.85rem;
        font-family: inherit;
        color: var(--text);
        min-width: 140px;
    }
    .form-row input:focus {
        outline: none;
        border-color: var(--primary);
    }
    .review-textarea {
        width: 100%;
        padding: 0.8rem 1rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        color: var(--text);
        margin-bottom: 0.8rem;
        resize: vertical;
        transition: border-color 0.2s;
    }
    .review-textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(201,168,76,0.1);
    }
    .desc-input {
        width: 100%;
        padding: 0.7rem 0.9rem;
        background: var(--dark3);
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.85rem;
        font-family: inherit;
        color: var(--text);
        margin-bottom: 0.8rem;
    }
    .desc-input:focus {
        outline: none;
        border-color: var(--primary);
    }
</style>

<div class="appointments-header">
    <h2 class="page-title" style="margin-bottom:0;">📋 My Appointments</h2>
    <a href="http://localhost/justifind/public/recommendations" class="btn btn-outline btn-sm">⭐ Get Recommendations</a>
</div>

@if(count($appointments) > 0)
    @foreach($appointments as $appt)
    @php $cno = $appt->C_NO; $lid = $appt->Lawyer_ID; @endphp
    <div class="appointment-card">
        <div class="appt-header">
            <div class="appt-lawyer-info">
                <h4>{{ $appt->Lawyer_Name }}</h4>
                <span class="practice-badge">{{ $appt->Practice_Area }}</span>
            </div>
            <div class="appt-status-group">
                <span class="status-badge status-{{ strtolower($appt->CStatus) }}">{{ $appt->CStatus }}</span>
                <span class="pay-badge pay-{{ strtolower($appt->Pay_Sts) }}">💰 {{ $appt->Pay_Sts }}</span>
            </div>
        </div>

        <div class="appt-details-grid">
            <div class="appt-detail-item">
                <span class="appt-detail-label">📅 Date</span>
                <span class="appt-detail-value">{{ $appt->Date }}</span>
            </div>
            <div class="appt-detail-item">
                <span class="appt-detail-label">🕐 Time</span>
                <span class="appt-detail-value">{{ $appt->Time }}</span>
            </div>
            <div class="appt-detail-item">
                <span class="appt-detail-label">📡 Mode</span>
                <span class="appt-detail-value">{{ $appt->Online ? '🌐 Online' : '🏢 In-Person' }}</span>
            </div>
            <div class="appt-detail-item">
                <span class="appt-detail-label">📁 Type</span>
                <span class="appt-detail-value">{{ $appt->Type }}</span>
            </div>
            <div class="appt-detail-item">
                <span class="appt-detail-label">💰 Fee</span>
                <span class="appt-detail-value">৳{{ number_format($appt->Amount ?? $appt->Hourly_Rate) }}</span>
            </div>
        </div>

        <div class="appt-meta">
            Consultation #{{ $cno }}
            @if($appt->Payment_Method) · Paid via {{ $appt->Payment_Method }} @endif
        </div>

        <div class="appt-actions">
            <a href="http://localhost/justifind/public/messages" class="btn btn-ghost btn-sm">💬 Message Lawyer</a>
            <a href="http://localhost/justifind/public/lawyer-profile?lawyer_id={{ $lid }}" class="btn btn-ghost btn-sm">👨‍⚖️ View Profile</a>
        </div>

        {{-- Payment --}}
        @if($appt->Pay_Sts == 'Pending' && $appt->CStatus != 'Cancelled')
        <div class="payment-section">
            <h5>💳 Complete Payment</h5>
            <form action="http://localhost/justifind/public/payment/process" method="POST" class="payment-form">
                @csrf
                <input type="hidden" name="consultation_id" value="{{ $cno }}">
                <input type="hidden" name="amount" value="{{ $appt->Amount ?? $appt->Hourly_Rate }}">
                <select name="payment_method" class="payment-select">
                    <option value="bKash">📱 bKash</option>
                    <option value="Nagad">📱 Nagad</option>
                    <option value="Rocket">📱 Rocket</option>
                    <option value="Bank Transfer">🏦 Bank Transfer</option>
                    <option value="Cash">💵 Cash</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">
                    Pay ৳{{ number_format($appt->Amount ?? $appt->Hourly_Rate) }}
                </button>
            </form>
        </div>
        @endif

        {{-- Reschedule --}}
        @if($appt->CStatus == 'Scheduled')
        <details class="collapsible">
            <summary>📅 Reschedule Appointment</summary>
            <div class="collapsible-body">
                <form action="http://localhost/justifind/public/reschedule-booking" method="POST">
                    @csrf
                    <input type="hidden" name="consultation_id" value="{{ $cno }}">
                    <div class="form-row">
                        <input type="date" name="new_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        <input type="time" name="new_time" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Confirm Reschedule</button>
                </form>
            </div>
        </details>

        <form action="http://localhost/justifind/public/cancel-booking" method="POST" style="margin-bottom:0.8rem;">
            @csrf
            <input type="hidden" name="consultation_id" value="{{ $cno }}">
            <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Cancel this appointment?')">
                ❌ Cancel Appointment
            </button>
        </form>
        @endif

        {{-- Upload Document --}}
        <details class="collapsible">
            <summary>📎 Upload Document</summary>
            <div class="collapsible-body">
                <form action="http://localhost/justifind/public/upload-document" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="consultation_id" value="{{ $cno }}">
                    <div class="form-row">
                        <input type="text" name="document_name" placeholder="Document name" required>
                        <input type="file" name="document_file" accept=".pdf,.doc,.docx,.jpg,.png" required
                            style="padding:0.5rem;">
                    </div>
                    <input type="text" name="document_description" placeholder="Description (optional)" class="desc-input">
                    <button type="submit" class="btn btn-primary btn-sm">Upload Document</button>
                </form>
            </div>
        </details>

        {{-- Review --}}
        @if($appt->CStatus == 'Completed')
        <details class="collapsible">
            <summary>⭐ Leave a Review</summary>
            <div class="collapsible-body">
                <form action="http://localhost/justifind/public/submit-review" method="POST">
                    @csrf
                    <input type="hidden" name="consultation_id" value="{{ $cno }}">
                    <input type="hidden" name="lawyer_id" value="{{ $lid }}">
                    <textarea name="review_text" rows="3" class="review-textarea"
                        placeholder="Share your experience with this lawyer (min 10 characters)..." required></textarea>
                    <button type="submit" class="btn btn-primary btn-sm">Submit Review ⭐</button>
                </form>
            </div>
        </details>
        @endif
    </div>
    @endforeach
@else
    <div class="empty-state">
        <div class="empty-state-icon">📋</div>
        <p>No appointments yet. Find a lawyer and book your first consultation!</p>
        <a href="http://localhost/justifind/public" class="btn btn-primary">Find a Lawyer →</a>
    </div>
@endif

@include('layouts.footer')