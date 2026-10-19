@include('layouts.header')

<style>
    .success-container {
        max-width: 600px;
        margin: 3rem auto;
        text-align: center;
    }
    .success-card {
        background: var(--card-bg);
        border: 1px solid rgba(63,185,80,0.3);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3),
                    0 0 40px rgba(63,185,80,0.05);
    }
    .success-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        display: block;
        animation: scaleIn 0.5s ease, float 3s ease-in-out 0.5s infinite;
    }
    .success-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: #3fb950;
        margin-bottom: 0.8rem;
    }
    .success-message {
        color: var(--text-muted);
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 2rem;
    }
    .success-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border), transparent);
        margin: 1.5rem 0;
    }
    .success-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    .checkmark-circle {
        width: 100px;
        height: 100px;
        background: rgba(63,185,80,0.1);
        border: 2px solid rgba(63,185,80,0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 3rem;
        animation: scaleIn 0.5s ease, pulse-gold 2s ease-in-out infinite;
    }
</style>

<div class="success-container">
    <div class="success-card">
        <div class="checkmark-circle">✅</div>
        <div class="success-title">Payment Successful!</div>
        <p class="success-message">
            Your payment has been processed successfully.<br>
            Your lawyer will be notified and will confirm your consultation shortly.
        </p>
        <div class="success-divider"></div>
        <div class="success-actions">
            <a href="http://localhost/justifind/public/appointments" class="btn btn-primary btn-lg">
                View My Appointments →
            </a>
            <a href="http://localhost/justifind/public" class="btn btn-ghost">
                Back to Home
            </a>
        </div>
    </div>
</div>

@include('layouts.footer')