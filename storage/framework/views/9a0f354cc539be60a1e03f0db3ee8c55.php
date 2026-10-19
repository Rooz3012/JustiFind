<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
    .register-container { max-width: 580px; margin: 2rem auto; }
    .register-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        position: relative;
        overflow: hidden;
    }
    .register-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }
    .register-header { text-align: center; margin-bottom: 2rem; }
    .register-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem; color: var(--text); margin-bottom: 0.4rem;
    }
    .register-header p { color: var(--text-muted); font-size: 0.9rem; }
    .role-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
    .role-option {
        border: 2px solid var(--border);
        border-radius: 14px; padding: 1.2rem;
        text-align: center; cursor: pointer;
        transition: all 0.2s; background: var(--dark3);
    }
    .role-option:hover { border-color: rgba(201,168,76,0.4); background: rgba(201,168,76,0.05); }
    .role-option.active { border-color: var(--primary); background: rgba(201,168,76,0.08); }
    .role-option input { display: none; }
    .role-icon { font-size: 2rem; margin-bottom: 0.5rem; display: block; }
    .role-name { font-weight: 700; color: var(--text); font-size: 0.9rem; }
    .role-desc { font-size: 0.75rem; color: var(--text-muted); margin-top: 0.2rem; }
    .client-fields, .lawyer-fields {
        background: var(--dark3); border: 1px solid var(--border);
        border-radius: 12px; padding: 1.2rem; margin-bottom: 1rem;
    }
    .lawyer-fields { display: none; }
    .lawyer-fields.show { display: block; }
    .client-fields.hide { display: none; }
    .fields-title {
        font-size: 0.78rem; font-weight: 700; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;
    }
    .email-hint {
        font-size: 0.75rem; color: var(--text-muted); margin-top: 0.4rem;
        padding: 0.4rem 0.8rem; background: var(--dark3);
        border-radius: 6px; border: 1px solid var(--border);
    }
    .email-hint span { color: var(--primary); font-weight: 600; }
    .login-link {
        text-align: center; margin-top: 1.5rem;
        font-size: 0.88rem; color: var(--text-muted);
    }
    .login-link a { color: var(--primary); text-decoration: none; font-weight: 600; }
    .password-strength {
        height: 4px; border-radius: 2px;
        margin-top: 0.4rem; transition: all 0.3s; background: var(--border);
    }
    .reg-divider {
        display: flex; align-items: center; gap: 1rem;
        margin: 1.5rem 0; color: var(--text-muted); font-size: 0.8rem;
    }
    .reg-divider::before, .reg-divider::after {
        content: ''; flex: 1; height: 1px; background: var(--border);
    }
</style>

<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <div style="font-size:3rem; margin-bottom:0.5rem; animation:float 3s ease-in-out infinite;">⚖️</div>
            <h2>Join JustiFind</h2>
            <p>Create your account to get started</p>
        </div>

        <?php if(session('reg_error')): ?>
            <div class="alert alert-error">⚠️ <?php echo e(session('reg_error')); ?></div>
        <?php endif; ?>

        <form action="http://localhost/justifind/public/register" method="POST">
            <?php echo csrf_field(); ?>

            <div style="margin-bottom:1.2rem;">
                <label style="display:block; font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.8rem;">I am a</label>
                <div class="role-selector">
                    <label class="role-option active" onclick="selectRole('Client', this)">
                        <input type="radio" name="role" value="Client" checked>
                        <span class="role-icon">👤</span>
                        <div class="role-name">Client</div>
                        <div class="role-desc">Looking for legal help</div>
                    </label>
                    <label class="role-option" onclick="selectRole('Lawyer', this)">
                        <input type="radio" name="role" value="Lawyer">
                        <span class="role-icon">👨‍⚖️</span>
                        <div class="role-name">Lawyer</div>
                        <div class="role-desc">Offering legal services</div>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Your full name" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" id="emailInput"
                    placeholder="your.name@Client.com" required>
                <div class="email-hint" id="emailHint">
                    Client email must end with <span>@Client.com</span>
                </div>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" placeholder="+880 1XXXXXXXXX">
            </div>

            
            <div class="client-fields" id="clientFields">
                <div class="fields-title">👤 Personal Information</div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" placeholder="e.g. Dhaka, Bangladesh">
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" name="age" placeholder="e.g. 30" min="18" max="100">
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            
            <div class="lawyer-fields" id="lawyerFields">
                <div class="fields-title">⚖️ Lawyer Information</div>
                <div class="form-group">
                    <label>Years of Experience</label>
                    <input type="number" name="experience" placeholder="e.g. 5" min="0" max="50">
                </div>
                <div class="form-group">
                    <label>Hourly Rate (৳)</label>
                    <input type="number" name="hourly_rate" placeholder="e.g. 2000" min="500">
                </div>
                <div class="form-group">
                    <label>Professional Bio</label>
                    <textarea name="profile" rows="3"
                        placeholder="Describe your expertise..."
                        style="width:100%; padding:0.75rem 1rem; background:var(--dark2); border:1px solid var(--border); border-radius:10px; font-family:inherit; font-size:0.9rem; color:var(--text); resize:vertical;"></textarea>
                </div>
            </div>

            <div class="reg-divider">Security</div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="passwordInput"
                    placeholder="Minimum 6 characters" required
                    oninput="checkStrength(this.value)">
                <div class="password-strength" id="strengthBar"></div>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirm"
                    placeholder="Repeat your password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-full btn-lg" style="margin-top:0.5rem;">
                Create Account →
            </button>
        </form>

        <div class="login-link">
            Already have an account?
            <a href="http://localhost/justifind/public">Sign In</a>
        </div>
    </div>
</div>

<script>
function selectRole(role, element) {
    document.querySelectorAll('.role-option').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
    element.querySelector('input').checked = true;
    const lawyerFields = document.getElementById('lawyerFields');
    const clientFields = document.getElementById('clientFields');
    const emailHint    = document.getElementById('emailHint');
    const emailInput   = document.getElementById('emailInput');
    if (role === 'Lawyer') {
        lawyerFields.classList.add('show');
        clientFields.classList.add('hide');
        emailHint.innerHTML = 'Lawyer email must end with <span style="color:var(--primary);font-weight:600;">@Law.co</span>';
        emailInput.placeholder = 'yourname@Law.co';
    } else {
        lawyerFields.classList.remove('show');
        clientFields.classList.remove('hide');
        emailHint.innerHTML = 'Client email must end with <span style="color:var(--primary);font-weight:600;">@Client.com</span>';
        emailInput.placeholder = 'yourname@Client.com';
    }
}
function checkStrength(password) {
    const bar = document.getElementById('strengthBar');
    let strength = 0;
    if (password.length >= 6)  strength++;
    if (password.length >= 10) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    const colors = ['#f85149','#f0ad4e','#c9a84c','#3fb950','#3fb950'];
    const widths = ['20%','40%','60%','80%','100%'];
    bar.style.background = colors[strength-1] || 'var(--border)';
    bar.style.width = widths[strength-1] || '0%';
    bar.style.height = '4px';
}
</script>

<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\justifind\resources\views/auth/register.blade.php ENDPATH**/ ?>