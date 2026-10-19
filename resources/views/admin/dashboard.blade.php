@include('layouts.header')

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
        <span class="stat-value">{{ $stats['total_clients'] }}</span>
        <span class="stat-label">Total Clients</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">👨‍⚖️</span>
        <span class="stat-value">{{ $stats['total_lawyers'] }}</span>
        <span class="stat-label">Total Lawyers</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">📋</span>
        <span class="stat-value">{{ $stats['total_bookings'] }}</span>
        <span class="stat-label">Total Bookings</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">💰</span>
        <span class="stat-value">৳{{ number_format($stats['total_revenue']) }}</span>
        <span class="stat-label">Total Revenue</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">🎫</span>
        <span class="stat-value">{{ $stats['pending_tickets'] }}</span>
        <span class="stat-label">Open Tickets</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">⏳</span>
        <span class="stat-value">{{ $stats['unverified_lawyers'] }}</span>
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
    <h3>👥 All Clients ({{ count($clients) }})</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Age</th><th>Gender</th></tr></thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#{{ $client->CID }}</span></td>
                <td>{{ $client->Name }}</td>
                <td style="color:var(--text-muted);">{{ $client->Email ?? 'N/A' }}</td>
                <td>{{ $client->Phone ?? 'N/A' }}</td>
                <td>{{ $client->Address ?? 'N/A' }}</td>
                <td>{{ $client->Age ?? 'N/A' }}</td>
                <td>{{ $client->Gender ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="tab-lawyers" class="tab-panel" style="display:none;">
    <h3>👨‍⚖️ All Lawyers ({{ count($lawyers) }})</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Experience</th><th>Success Rate</th><th>Rate/hr</th></tr></thead>
        <tbody>
            @foreach($lawyers as $lawyer)
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#{{ $lawyer->LID }}</span></td>
                <td>{{ $lawyer->Name }}</td>
                <td style="color:var(--text-muted);">{{ $lawyer->Email }}</td>
                <td>{{ $lawyer->Phone ?? 'N/A' }}</td>
                <td>{{ $lawyer->Experience }} yrs</td>
                <td>
                    <div style="display:flex; align-items:center; gap:0.5rem;">
                        <div style="flex:1; height:4px; background:var(--dark3); border-radius:2px; overflow:hidden;">
                            <div style="height:100%; width:{{ $lawyer->Success_Rate }}%; background:linear-gradient(90deg,var(--primary),var(--primary-dark)); border-radius:2px;"></div>
                        </div>
                        <span style="font-size:0.8rem; color:var(--primary);">{{ $lawyer->Success_Rate }}%</span>
                    </div>
                </td>
                <td><span style="color:#3fb950; font-weight:700;">৳{{ number_format($lawyer->Hourly_Rate) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="tab-verify" class="tab-panel" style="display:none;">
    <h3>✅ Lawyer Verification</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Name</th><th>Experience</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
            @foreach($unverifiedLawyers as $lawyer)
            @php $lid = $lawyer->LID; @endphp
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#{{ $lid }}</span></td>
                <td>{{ $lawyer->Name }}</td>
                <td>{{ $lawyer->Experience }} yrs</td>
                <td>
                    @if($lawyer->is_verified)
                        <span class="status-badge status-completed">✅ Verified</span>
                    @else
                        <span class="pay-badge pay-pending">⏳ Pending</span>
                    @endif
                </td>
                <td>
                    <form action="http://localhost/justifind/public/admin/verify-lawyer" method="POST" class="verify-form">
                        @csrf
                        <input type="hidden" name="lawyer_id" value="{{ $lid }}">
                        <select name="is_verified" class="mini-select">
                            <option value="1" {{ $lawyer->is_verified ? 'selected' : '' }}>✅ Verify</option>
                            <option value="0" {{ !$lawyer->is_verified ? 'selected' : '' }}>❌ Reject</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="tab-bookings" class="tab-panel" style="display:none;">
    <h3>📋 All Bookings ({{ count($bookings) }})</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Client</th><th>Lawyer</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
            @foreach($bookings as $booking)
            @php $bno = $booking->C_NO; @endphp
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#{{ $bno }}</span></td>
                <td>{{ $booking->Client_Name }}</td>
                <td>{{ $booking->Lawyer_Name }}</td>
                <td style="color:var(--text-muted);">{{ $booking->Date }}</td>
                <td><span class="status-badge status-{{ strtolower($booking->CStatus) }}">{{ $booking->CStatus }}</span></td>
                <td>
                    <form action="http://localhost/justifind/public/admin/delete-booking" method="POST" class="delete-form"
                        onsubmit="return confirm('Delete booking #{{ $bno }}?')">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $bno }}">
                        <input type="text" name="delete_reason" placeholder="Reason" class="delete-input">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="tab-transactions" class="tab-panel" style="display:none;">
    <h3>💰 Recent Transactions</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Client</th><th>Lawyer</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            @foreach($transactions as $tx)
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#{{ $tx->Pay_ID }}</span></td>
                <td>{{ $tx->Client_Name }}</td>
                <td>{{ $tx->Lawyer_Name }}</td>
                <td><span style="color:#3fb950; font-weight:700;">৳{{ number_format($tx->Amount) }}</span></td>
                <td>{{ $tx->Method }}</td>
                <td><span class="pay-badge pay-{{ strtolower($tx->PStatus) }}">{{ $tx->PStatus }}</span></td>
                <td style="color:var(--text-muted);">{{ $tx->Date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="tab-tickets" class="tab-panel" style="display:none;">
    <h3>🎫 Support Tickets</h3>
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Client</th><th>Subject</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
        <tbody>
            @foreach($tickets as $ticket)
            @php $tid = $ticket->id; @endphp
            <tr>
                <td><span style="color:var(--primary); font-weight:700;">#{{ $tid }}</span></td>
                <td>{{ $ticket->Client_Name }}</td>
                <td>{{ $ticket->subject }}</td>
                <td>
                    <span class="status-badge status-{{ strtolower(str_replace(' ','-',$ticket->status)) }}">
                        {{ $ticket->status }}
                    </span>
                </td>
                <td style="color:var(--text-muted);">{{ date('M d', strtotime($ticket->created_at)) }}</td>
                <td>
                    <form action="http://localhost/justifind/public/admin/update-ticket" method="POST"
                        style="display:flex; gap:0.4rem; flex-wrap:wrap; align-items:center;">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $tid }}">
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
            @endforeach
        </tbody>
    </table>
</div>

@include('layouts.footer')