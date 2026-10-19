<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JustiFind — Premium Legal Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #c9a84c;
            --primary-dark: #a8892e;
            --primary-light: #f0d98a;
            --dark: #0d1117;
            --dark2: #161b22;
            --dark3: #21262d;
            --text: #e6edf3;
            --text-muted: #8b949e;
            --accent: #238636;
            --danger: #da3633;
            --border: #30363d;
            --card-bg: #161b22;
            --body-bg: #0d1117;
            --white: #ffffff;
            --success-bg: #1a4731;
            --success-text: #3fb950;
            --error-bg: #3d1c1c;
            --error-text: #f85149;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--body-bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--dark); }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 3px; }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse-gold {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201,168,76,0.4); }
            50% { box-shadow: 0 0 0 12px rgba(201,168,76,0); }
        }
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes rotate3d {
            0% { transform: perspective(500px) rotateY(0deg); }
            50% { transform: perspective(500px) rotateY(180deg); }
            100% { transform: perspective(500px) rotateY(360deg); }
        }
        @keyframes glow {
            0%, 100% { filter: drop-shadow(0 0 5px rgba(201,168,76,0.3)); }
            50% { filter: drop-shadow(0 0 20px rgba(201,168,76,0.8)); }
        }
        @keyframes borderPulse {
            0%, 100% { border-color: var(--border); box-shadow: none; }
            50% { border-color: rgba(201,168,76,0.5); box-shadow: 0 0 20px rgba(201,168,76,0.15); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.85); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        /* ===== HEADER ===== */
        .site-header {
            background: rgba(13, 17, 23, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0 2rem;
            animation: fadeInDown 0.5s ease forwards;
            transition: all 0.3s ease;
        }

        .header-inner {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
            gap: 1rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .logo:hover { filter: brightness(1.2); }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            animation: pulse-gold 3s ease-in-out infinite;
            transition: transform 0.3s ease;
        }

        .logo:hover .logo-icon {
            animation: rotate3d 0.8s ease;
        }

        .main-nav {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .nav-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            padding: 0.45rem 0.75rem;
            border-radius: 8px;
            transition: all 0.2s;
            white-space: nowrap;
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0; left: 50%;
            width: 0; height: 2px;
            background: var(--primary);
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: var(--text);
            background: var(--dark3);
            border-color: var(--border);
        }

        .nav-link:hover::before { width: 80%; }

        .nav-role-badge {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--dark);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            animation: scaleIn 0.3s ease;
        }

        .nav-user {
            color: var(--text-muted);
            font-size: 0.8rem;
            max-width: 130px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .logout-btn {
            color: var(--danger) !important;
            border-color: rgba(218,54,51,0.3) !important;
            background: rgba(218,54,51,0.1) !important;
        }

        .logout-btn:hover {
            background: var(--danger) !important;
            color: white !important;
            border-color: var(--danger) !important;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            max-width: 1300px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 0.9rem 1.2rem;
            margin: 0.5rem 0 1rem 0;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            animation: slideIn 0.3s ease;
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
            border: 1px solid rgba(63,185,80,0.3);
        }

        .alert-error {
            background: var(--error-bg);
            color: var(--error-text);
            border: 1px solid rgba(248,81,73,0.3);
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.65rem 1.3rem;
            border: none;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s ease;
            font-family: inherit;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--dark);
            box-shadow: 0 4px 15px rgba(201,168,76,0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(201,168,76,0.4);
            filter: brightness(1.1);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(201,168,76,0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--primary);
        }

        .btn-outline:hover {
            background: rgba(201,168,76,0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(201,168,76,0.15);
        }

        .btn-ghost {
            background: var(--dark3);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover {
            background: var(--border);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: rgba(218,54,51,0.15);
            color: var(--error-text);
            border: 1px solid rgba(218,54,51,0.3);
            padding: 0.45rem 0.9rem;
            font-size: 0.82rem;
        }

        .btn-danger:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-1px);
        }

        .btn-sm { padding: 0.4rem 0.9rem; font-size: 0.8rem; }
        .btn-full { width: 100%; justify-content: center; }
        .btn-lg { padding: 0.9rem 2rem; font-size: 1rem; }

        /* ===== FORM ELEMENTS ===== */
        .form-group { margin-bottom: 1.1rem; }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            background: var(--dark3);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: inherit;
            color: var(--text);
            transition: all 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
            background: rgba(33,38,45,0.8);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder { color: var(--text-muted); }
        .form-group select option { background: var(--dark2); color: var(--text); }

        /* ===== BADGES ===== */
        .practice-badge {
            display: inline-block;
            padding: 0.25rem 0.8rem;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            background: rgba(201,168,76,0.12);
            color: var(--primary);
            border: 1px solid rgba(201,168,76,0.25);
            letter-spacing: 0.3px;
            transition: all 0.2s;
        }

        .practice-badge:hover {
            background: rgba(201,168,76,0.2);
        }

        .status-badge {
            padding: 0.25rem 0.7rem;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .status-completed {
            background: rgba(63,185,80,0.12);
            color: #3fb950;
            border: 1px solid rgba(63,185,80,0.25);
        }

        .status-scheduled {
            background: rgba(56,139,253,0.12);
            color: #58a6ff;
            border: 1px solid rgba(56,139,253,0.25);
        }

        .status-cancelled {
            background: rgba(248,81,73,0.12);
            color: #f85149;
            border: 1px solid rgba(248,81,73,0.25);
        }

        .pay-badge {
            padding: 0.25rem 0.7rem;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .pay-paid, .pay-completed {
            background: rgba(63,185,80,0.12);
            color: #3fb950;
            border: 1px solid rgba(63,185,80,0.25);
        }

        .pay-pending {
            background: rgba(201,168,76,0.12);
            color: var(--primary);
            border: 1px solid rgba(201,168,76,0.25);
        }

        .pay-refunded {
            background: rgba(248,81,73,0.12);
            color: #f85149;
            border: 1px solid rgba(248,81,73,0.25);
        }

        /* ===== CARDS ===== */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            animation: borderPulse 4s ease-in-out infinite;
        }

        .card:hover {
            border-color: rgba(201,168,76,0.4);
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }

        .card-header {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 1.2rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            animation: fadeInUp 0.5s ease;
        }

        .empty-state-icon {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            opacity: 0.4;
            animation: float 3s ease-in-out infinite;
        }

        .empty-state p {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        /* ===== PAGE TITLE ===== */
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 0.7rem;
            animation: fadeInUp 0.4s ease;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeInUp 0.2s ease;
        }

        .modal-box {
            background: var(--dark2);
            border: 1px solid rgba(201,168,76,0.2);
            border-radius: 24px;
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 30px 100px rgba(0,0,0,0.6),
                        0 0 60px rgba(201,168,76,0.05);
            animation: scaleIn 0.3s ease;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: var(--text);
        }

        .modal-close {
            background: var(--dark3);
            border: 1px solid var(--border);
            color: var(--text-muted);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
            transform: rotate(90deg);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 0.8rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .modal-lawyer-info {
            background: var(--dark3);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .rate-badge {
            background: rgba(63,185,80,0.12);
            color: #3fb950;
            border: 1px solid rgba(63,185,80,0.25);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* ===== GLASS EFFECT ===== */
        .glass {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
        }

        /* ===== SHIMMER TEXT ===== */
        .shimmer-text {
            background: linear-gradient(90deg,
                var(--primary) 0%,
                #fff8e1 30%,
                var(--primary) 60%,
                #fff8e1 80%,
                var(--primary) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        /* ===== GRADIENT TEXT ===== */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary), #fff8e1, var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ===== FLOAT ANIMATION ===== */
        .float { animation: float 3s ease-in-out infinite; }
        .float-2 { animation: float 4s ease-in-out 0.5s infinite; }
        .float-3 { animation: float 5s ease-in-out 1s infinite; }

        /* ===== GLOW ===== */
        .glow { animation: glow 2s ease-in-out infinite; }

        /* ===== GRADIENT BORDER ===== */
        .gradient-border {
            position: relative;
            border-radius: 20px;
        }
        .gradient-border::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 21px;
            background: linear-gradient(135deg,
                var(--primary), transparent 40%,
                var(--primary-dark), transparent 80%,
                var(--primary));
            background-size: 300% 300%;
            animation: gradientShift 4s ease infinite;
            z-index: -1;
        }

        /* ===== BACK LINK ===== */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.88rem;
            margin-bottom: 1.5rem;
            transition: all 0.2s;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
        }

        .back-link:hover {
            color: var(--primary);
            background: rgba(201,168,76,0.08);
        }

        /* ===== DIVIDER ===== */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
            margin: 1.5rem 0;
        }

        /* ===== LOGGED IN BANNER ===== */
        .logged-in-banner {
            background: rgba(201,168,76,0.06);
            border: 1px solid rgba(201,168,76,0.15);
            border-radius: 10px;
            padding: 0.6rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: fadeInUp 0.3s ease;
        }

        /* ===== FOOTER ===== */
        .site-footer {
            background: var(--dark2);
            border-top: 1px solid var(--border);
            color: var(--text-muted);
            text-align: center;
            padding: 2.5rem 2rem;
            margin-top: 4rem;
        }

        .site-footer .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 0.8rem;
            animation: glow 3s ease-in-out infinite;
        }

        .site-footer p { font-size: 0.85rem; margin-bottom: 0.5rem; }

        .site-footer a {
            color: var(--text-muted);
            text-decoration: none;
            margin: 0 0.5rem;
            transition: color 0.2s;
        }

        .site-footer a:hover { color: var(--primary); }

        /* ===== TOOLTIP ===== */
        .tooltip { position: relative; }
        .tooltip::before {
            content: attr(data-tip);
            position: absolute;
            bottom: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%);
            background: var(--dark3);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.78rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
            z-index: 100;
        }
        .tooltip:hover::before { opacity: 1; }

        /* ===== TYPED CURSOR ===== */
        .typed-cursor {
            display: inline-block;
            width: 3px;
            height: 1em;
            background: var(--primary);
            animation: blink 0.7s step-end infinite;
            vertical-align: text-bottom;
            margin-left: 2px;
        }

        /* ===== 3D PERSPECTIVE ===== */
        .perspective-container {
            perspective: 1000px;
            perspective-origin: center center;
        }

        /* ===== NEON GLOW ===== */
        .neon-text {
            color: var(--primary);
            text-shadow:
                0 0 7px rgba(201,168,76,0.5),
                0 0 10px rgba(201,168,76,0.3),
                0 0 21px rgba(201,168,76,0.2);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .header-inner { height: auto; padding: 0.8rem 0; flex-wrap: wrap; }
            .main-content { padding: 0 1rem; margin: 1rem auto; }
            .page-title { font-size: 1.5rem; }
            .modal-box { padding: 1.5rem; }
        }

        @media (max-width: 480px) {
            .main-nav { gap: 0.2rem; }
            .nav-link { padding: 0.3rem 0.5rem; font-size: 0.75rem; }
        }
    </style>
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <a href="http://localhost/justifind/public" class="logo">
            <div class="logo-icon">⚖️</div>
            JustiFind
        </a>
        <nav class="main-nav">
            <?php if(session('role')): ?>
                <span class="nav-role-badge"><?php echo e(session('role')); ?></span>
                <?php if(session('role') == 'Client'): ?>
                    <a href="http://localhost/justifind/public" class="nav-link">🔍 Search</a>
                    <a href="http://localhost/justifind/public/appointments" class="nav-link">📋 Appointments</a>
                    <a href="http://localhost/justifind/public/messages" class="nav-link">💬 Messages</a>
                    <a href="http://localhost/justifind/public/recommendations" class="nav-link">⭐ For You</a>
                    <a href="http://localhost/justifind/public/notifications" class="nav-link">🔔 Alerts</a>
                    <a href="http://localhost/justifind/public/support-tickets" class="nav-link">🎫 Support</a>
                <?php elseif(session('role') == 'Lawyer'): ?>
                    <a href="http://localhost/justifind/public/lawyer-dashboard" class="nav-link">📊 Dashboard</a>
                    <a href="http://localhost/justifind/public/messages" class="nav-link">💬 Messages</a>
                    <a href="http://localhost/justifind/public/lawyer-availability" class="nav-link">📅 Availability</a>
                    <a href="http://localhost/justifind/public/lawyer-analytics" class="nav-link">📈 Analytics</a>
                    <a href="http://localhost/justifind/public/lawyer-profile-edit" class="nav-link">✏️ Profile</a>
                    <a href="http://localhost/justifind/public/notifications" class="nav-link">🔔 Alerts</a>
                <?php elseif(session('role') == 'Admin'): ?>
                    <a href="http://localhost/justifind/public/admin" class="nav-link">🛡️ Dashboard</a>
                    <a href="http://localhost/justifind/public/support-tickets" class="nav-link">🎫 Tickets</a>
                    <a href="http://localhost/justifind/public/notifications" class="nav-link">🔔 Alerts</a>
                <?php endif; ?>
                <span class="nav-user">👤 <?php echo e(session('lawyer_name') ?? session('client_name') ?? session('admin_name') ?? session('email')); ?></span>
                <a href="http://localhost/justifind/public/logout" class="nav-link logout-btn">Logout</a>
            <?php else: ?>
                <a href="http://localhost/justifind/public" class="nav-link">Find a Lawyer</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<div class="main-content">

<?php if(session('role')): ?>
<div class="logged-in-banner">
    ✦ Signed in as <strong><?php echo e(session('role')); ?></strong>
    — <?php echo e(session('lawyer_name') ?? session('client_name') ?? session('admin_name') ?? session('email')); ?>

</div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-error">⚠️ <?php echo e(session('error')); ?></div>
<?php endif; ?>
<?php if(session('booking_success')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('booking_success')); ?></div>
<?php endif; ?>
<?php if(session('booking_error')): ?>
    <div class="alert alert-error">⚠️ <?php echo e(session('booking_error')); ?></div>
<?php endif; ?>
<?php if(session('review_message')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('review_message')); ?></div>
<?php endif; ?>
<?php if(session('review_error')): ?>
    <div class="alert alert-error">⚠️ <?php echo e(session('review_error')); ?></div>
<?php endif; ?>
<?php if(session('upload_message')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('upload_message')); ?></div>
<?php endif; ?>
<?php if(session('upload_error')): ?>
    <div class="alert alert-error">⚠️ <?php echo e(session('upload_error')); ?></div>
<?php endif; ?>
<?php if(session('delete_message')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('delete_message')); ?></div>
<?php endif; ?>
<?php if(session('delete_error')): ?>
    <div class="alert alert-error">⚠️ <?php echo e(session('delete_error')); ?></div>
<?php endif; ?>
<?php if(session('payment_success')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('payment_success')); ?></div>
<?php endif; ?>
<?php if(session('status_success')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('status_success')); ?></div>
<?php endif; ?>
<?php if(session('verify_message')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('verify_message')); ?></div>
<?php endif; ?>
<?php if(session('profile_success')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('profile_success')); ?></div>
<?php endif; ?>
<?php if(session('cancel_success')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('cancel_success')); ?></div>
<?php endif; ?>
<?php if(session('reschedule_success')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('reschedule_success')); ?></div>
<?php endif; ?>
<?php if(session('availability_success')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('availability_success')); ?></div>
<?php endif; ?>
<?php if(session('ticket_success')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('ticket_success')); ?></div>
<?php endif; ?>
<?php if(session('ticket_error')): ?>
    <div class="alert alert-error">⚠️ <?php echo e(session('ticket_error')); ?></div>
<?php endif; ?>
<?php if(session('ticket_message')): ?>
    <div class="alert alert-success">✅ <?php echo e(session('ticket_message')); ?></div>
<?php endif; ?><?php /**PATH C:\laragon\www\justifind\resources\views/layouts/header.blade.php ENDPATH**/ ?>