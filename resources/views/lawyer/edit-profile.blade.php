@include('layouts.header')

<style>
    .edit-container {
        max-width: 700px;
        margin: 0 auto;
    }
    .edit-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 2.5rem;
        transition: border-color 0.3s;
    }
    .edit-card:hover { border-color: rgba(201,168,76,0.2); }
    .edit-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border);
    }
    .edit-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--text);
        margin-bottom: 0.3rem;
    }
    .edit-header p { color: var(--text-muted); font-size: 0.88rem; }
    .char-count {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-align: right;
        margin-top: 0.3rem;
    }
</style>

<a href="http://localhost/justifind/public/lawyer-dashboard" class="back-link">← Back to Dashboard</a>

<div class="edit-container">
    <div class="edit-card gradient-border">
        <div class="edit-header">
            <h3>✏️ Edit Your Profile</h3>
            <p>Update your professional information visible to clients</p>
        </div>
        <form action="http://localhost/justifind/public/lawyer-profile-update" method="POST">
            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ $profile->Name }}" required>
            </div>
            <div class="form-group">
                <label>Professional Bio</label>
                <textarea name="profile" rows="5" required
                    id="bioTextarea" maxlength="500"
                    style="resize:vertical;">{{ $profile->Profile }}</textarea>
                <div class="char-count">
                    <span id="charCount">{{ strlen($profile->Profile) }}</span>/500 characters
                </div>
            </div>
            <div class="form-group">
                <label>Hourly Rate (৳)</label>
                <input type="number" name="hourly_rate"
                    value="{{ $profile->Hourly_Rate }}" required step="100" min="500">
            </div>
            <div class="form-group">
                <label>Years of Experience</label>
                <input type="number" name="experience"
                    value="{{ $profile->Experience }}" required min="0" max="50">
            </div>
            <button type="submit" class="btn btn-primary btn-full btn-lg">
                Save Changes →
            </button>
        </form>
    </div>
</div>

<script>
const textarea = document.getElementById('bioTextarea');
const charCount = document.getElementById('charCount');
if (textarea && charCount) {
    textarea.addEventListener('input', () => {
        charCount.textContent = textarea.value.length;
        charCount.style.color = textarea.value.length > 450 ? '#f85149' : '';
    });
}
</script>

@include('layouts.footer')