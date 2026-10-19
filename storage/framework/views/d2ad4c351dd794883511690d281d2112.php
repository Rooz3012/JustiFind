<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
    .forgot-container { max-width: 500px; margin: 3rem auto; }
    .forgot-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        position: relative;
        overflow: hidden;
    }
    .forgot-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }
    .forgot-header { text-align: center; margin-bottom: 2rem; }
    .forgot-icon {
        font-size: 3rem;
        margin-bottom: 0.8rem;
        display: block;
        animation: float 3s ease-in-out infinite;
    }
    .forgot-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        color: var(--text);
        margin-bottom: 0.4rem;
    }
    .forgot-header p { color: var(--text-muted); font-size: 0.9rem; }
    .info-note {
        background: rgba(201,168,76,0.08);
        border: 1px solid rgba(201,168,76,0.25);
        border-radius: 10px;
        padding: 0.9rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        color: var(--primary);
        line-height: 1.6;
    }
    .back-to-login {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.88rem;
        color: var(--text-muted);
    }
    .back-to-login a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
    }
    .back-to-login a:hover { text-decoration: underline; }
</style>

<div class="forgot-container">
    <div class="forgot-card">
        <div class="forgot-header">
            <div class="forgot-icon">🔐</div>
            <h2>Reset Password</h2>
            <p>Recover access to your JustiFind account</p>
        </div>

        <?php if(session('reset_error')): ?>
            <div class="alert alert-error">⚠️ <?php echo e(session('reset_error')); ?></div>
        <?php endif; ?>

        <div class="info-note">
            🛡️ For security, please verify your identity by providing your registered email and phone number.
        </div>

        <form action="http://localhost/justifind/public/forgot-password" method="POST">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="your.email@Client.com" required>
            </div>

            <div class="form-group">
                <label>Phone Number (for verification)</label>
                <input type="text" name="phone" placeholder="+880 1XXXXXXXXX" required>
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password"
                    placeholder="Minimum 6 characters" required>
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password"
                    placeholder="Repeat new password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-full btn-lg">
                Reset Password →
            </button>
        </form>

        <div class="back-to-login">
            Remember your password?
            <a href="http://localhost/justifind/public">Sign In</a>
        </div>
    </div>
</div>

<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\justifind\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>