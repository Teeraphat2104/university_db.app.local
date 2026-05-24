<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เข้าสู่ระบบ - ผู้ดูแลระบบ</title>
    <meta name="description" content="ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @php $favicon = setting('favicon'); @endphp
    @if ($favicon)
        <link rel="icon" type="image/png" href="{{ Storage::disk('public')->url($favicon) }}">
    @else
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @endif
    <style>
        :root { --primary-color: {{ setting('primary_color', '#6366F1') }}; }

        .split-layout {
            display: flex;
            min-height: 100vh;
        }

        .brand-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(ellipse at 15% 50%, rgba(99,102,241,.25) 0%, transparent 60%),
                              radial-gradient(ellipse at 80% 50%, rgba(139,92,246,.15) 0%, transparent 55%);
            pointer-events: none;
        }

        .brand-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            opacity: .02;
            pointer-events: none;
        }

        .brand-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }
        .brand-orb-1 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(99,102,241,.12) 0%, transparent 70%);
            top: -10%; left: -5%;
        }
        .brand-orb-2 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(139,92,246,.10) 0%, transparent 70%);
            bottom: 0; right: -3%;
            animation-delay: -7s;
        }
        .brand-orb-3 {
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(99,102,241,.08) 0%, transparent 70%);
            top: 40%; left: 55%;
            animation-delay: -14s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            33% { transform: translateY(-25px) scale(1.05); }
            66% { transform: translateY(15px) scale(.95); }
        }

        .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 2rem;
            max-width: 420px;
        }

        .brand-icon {
            width: 72px; height: 72px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #6366F1, #8B5CF6);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 32px rgba(99,102,241,.4);
            animation: fadeUp .6s ease-out .1s backwards;
        }
        .brand-icon i { color: #fff; font-size: 1.75rem; }

        .brand-name {
            font-size: 1.75rem;
            font-weight: 900;
            color: #fff;
            font-family: 'Manrope', 'Noto Sans Thai', sans-serif;
            line-height: 1.2;
            margin: 0 0 .5rem;
            animation: fadeUp .6s ease-out .2s backwards;
        }
        .brand-tagline {
            font-size: .95rem;
            color: #94A3B8;
            line-height: 1.6;
            margin: 0 0 2.5rem;
            animation: fadeUp .6s ease-out .3s backwards;
        }

        .brand-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            animation: fadeUp .6s ease-out .4s backwards;
        }
        .brand-stat {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 16px;
            padding: 1.25rem 1rem;
            text-align: center;
            transition: all .3s ease;
        }
        .brand-stat:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,.15);
        }
        .brand-stat-icon { font-size: 1.1rem; color: #818CF8; margin-bottom: .5rem; }
        .brand-stat-num {
            font-size: 1.5rem; font-weight: 800; color: #fff;
            font-family: 'Manrope', 'Noto Sans Thai', sans-serif;
            line-height: 1; margin-bottom: .25rem;
        }
        .brand-stat-label { font-size: .7rem; color: #64748B; font-weight: 500; }

        .brand-footer {
            position: absolute;
            bottom: 2rem;
            left: 0; right: 0;
            text-align: center;
            font-size: .75rem;
            color: #475569;
            z-index: 1;
        }

        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 2rem;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
        }

        .form-header {
            margin-bottom: 2rem;
            animation: fadeUp .6s ease-out .1s backwards;
        }
        .form-header-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #6366F1, #8B5CF6);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 16px rgba(99,102,241,.3);
        }
        .form-header-icon i { color: #fff; font-size: 1.2rem; }
        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0F172A;
            font-family: 'Manrope', 'Noto Sans Thai', sans-serif;
            margin: 0 0 .375rem;
        }
        .form-header p {
            color: #64748B;
            font-size: .875rem;
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.25rem;
            animation: fadeUp .6s ease-out .15s backwards;
        }
        .form-group:nth-child(2) { animation-delay: .2s; }
        .form-group:nth-child(3) { animation-delay: .25s; }

        .form-label {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            color: #64748B;
            margin-bottom: .375rem;
        }

        .input-wrap {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: .875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            pointer-events: none;
            font-size: .9rem;
        }
        .input-field {
            width: 100%;
            padding: .75rem 1rem .75rem 2.75rem;
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            font-size: .9rem;
            font-family: inherit;
            color: #1E293B;
            background: #F8FAFC;
            transition: all .2s;
            outline: none;
        }
        .input-field:focus {
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(99,102,241,.1);
        }
        .input-field::placeholder { color: #94A3B8; }
        .input-field.has-value { background: #fff; border-color: #CBD5E1; }

        .input-toggle {
            position: absolute;
            right: .75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            padding: .25rem;
            font-size: .9rem;
            transition: color .15s;
        }
        .input-toggle:hover { color: #64748B; }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            animation: fadeUp .6s ease-out .3s backwards;
        }
        .remember-check {
            display: flex;
            align-items: center;
            gap: .5rem;
            cursor: pointer;
            font-size: .82rem;
            color: #64748B;
            user-select: none;
        }
        .remember-check input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--primary-color);
            cursor: pointer;
        }

        .submit-btn {
            width: 100%;
            padding: .85rem;
            background: linear-gradient(135deg, #6366F1, #8B5CF6);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: .95rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all .25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            box-shadow: 0 4px 16px rgba(99,102,241,.35);
            animation: fadeUp .6s ease-out .35s backwards;
        }
        .submit-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99,102,241,.45);
        }
        .submit-btn:active:not(:disabled) {
            transform: translateY(0);
        }
        .submit-btn:disabled {
            opacity: .7;
            cursor: not-allowed;
        }
        .submit-btn .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }
        .submit-btn.is-loading .spinner { display: block; }
        .submit-btn.is-loading .btn-text { display: none; }
        .submit-btn.is-success {
            background: #10B981;
            box-shadow: 0 4px 16px rgba(16,185,129,.35);
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .error-banner {
            display: none;
            padding: .875rem 1rem;
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 12px;
            color: #B91C1C;
            font-size: .85rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            align-items: flex-start;
            gap: .625rem;
            animation: slideDown .25s ease;
        }
        .error-banner.is-visible { display: flex; }
        .error-banner i { margin-top: 2px; flex-shrink: 0; }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-footer {
            text-align: center;
            margin-top: 1.75rem;
            animation: fadeUp .6s ease-out .4s backwards;
        }
        .form-footer a {
            color: #64748B;
            font-size: .85rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .375rem;
            transition: color .15s;
        }
        .form-footer a:hover { color: var(--primary-color); }

        .test-hint {
            margin-top: 1.25rem;
            padding: .75rem 1rem;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            text-align: center;
            animation: fadeUp .6s ease-out .45s backwards;
        }
        .test-hint p {
            font-size: .75rem;
            color: #94A3B8;
            margin: 0 0 .5rem;
        }
        .test-hint code {
            font-size: .78rem;
            color: #475569;
            background: #fff;
            padding: .15em .5em;
            border-radius: 6px;
            border: 1px solid #E2E8F0;
        }
        .test-hint .arrow {
            color: #CBD5E1;
            margin: 0 .375rem;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .split-layout { flex-direction: column; }
            .brand-panel {
                min-height: auto;
                padding: 2.5rem 1.5rem 1.5rem;
            }
            .brand-content { padding: 0; max-width: none; }
            .brand-icon { width: 56px; height: 56px; margin-bottom: 1rem; }
            .brand-icon i { font-size: 1.35rem; }
            .brand-name { font-size: 1.25rem; }
            .brand-tagline { font-size: .85rem; margin-bottom: 1.5rem; }
            .brand-stats { display: none; }
            .brand-footer { display: none; }
            .form-panel { padding: 1.5rem; }
            .form-container { max-width: none; }
        }
    </style>
</head>
<body>
    <div class="split-layout">
        <div class="brand-panel">
            <div class="brand-orb brand-orb-1"></div>
            <div class="brand-orb brand-orb-2"></div>
            <div class="brand-orb brand-orb-3"></div>

            <div class="brand-content">
                <div class="brand-icon">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h1 class="brand-name">{{ setting('site_name', 'University Activities') }}</h1>
                <p class="brand-tagline">ระบบจัดการกิจกรรมและเอกสารของมหาวิทยาลัย</p>

                <div class="brand-stats">
                    <div class="brand-stat">
                        <div class="brand-stat-icon"><i class="fa-regular fa-calendar"></i></div>
                        <div class="brand-stat-num" id="stat-activities">-</div>
                        <div class="brand-stat-label">กิจกรรม</div>
                    </div>
                    <div class="brand-stat">
                        <div class="brand-stat-icon"><i class="fa-solid fa-users"></i></div>
                        <div class="brand-stat-num" id="stat-participants">-</div>
                        <div class="brand-stat-label">ผู้เข้าร่วม</div>
                    </div>
                    <div class="brand-stat">
                        <div class="brand-stat-icon"><i class="fa-regular fa-folder"></i></div>
                        <div class="brand-stat-num" id="stat-categories">-</div>
                        <div class="brand-stat-label">หมวดหมู่</div>
                    </div>
                </div>
            </div>

            <div class="brand-footer">
                &copy; {{ date('Y') }} University Activities System
            </div>
        </div>

        <div class="form-panel">
            <div class="form-container">
                <div class="form-header">
                    <div class="form-header-icon">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <h2>ยินดีต้อนรับ</h2>
                    <p>เข้าสู่ระบบเพื่อจัดการกิจกรรม</p>
                </div>

                <div id="login-error" class="error-banner">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span id="error-message"></span>
                </div>

                <form id="admin-login-form" autocomplete="off">
                    <div class="form-group">
                        <label class="form-label" for="admin-email">อีเมล</label>
                        <div class="input-wrap">
                            <i class="fa-regular fa-envelope input-icon"></i>
                            <input type="email" id="admin-email" name="email" required
                                   placeholder="admin@example.com" autocomplete="email"
                                   class="input-field">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="admin-password">รหัสผ่าน</label>
                        <div class="input-wrap">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" id="admin-password" name="password" required
                                   placeholder="••••••••" autocomplete="current-password"
                                   class="input-field">
                            <button type="button" class="input-toggle" id="toggle-password" tabindex="-1"
                                    title="แสดง/ซ่อนรหัสผ่าน">
                                <i class="fa-regular fa-eye" id="toggle-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="remember-check">
                            <input type="checkbox" id="remember-email">
                            จดจำอีเมล
                        </label>
                    </div>

                    <button type="submit" class="submit-btn" id="login-btn">
                        <span class="btn-text">เข้าสู่ระบบ</span>
                        <div class="spinner"></div>
                    </button>
                </form>

                <div class="test-hint">
                    <p>ข้อมูลสำหรับทดสอบ</p>
                    <code>admin@example.com</code>
                    <span class="arrow"><i class="fa-solid fa-arrow-right"></i></span>
                    <code>password</code>
                </div>

                <div class="form-footer">
                    <a href="/">
                        <i class="fa-solid fa-arrow-left"></i> กลับหน้าหลัก
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script>
        $(function () {
            var $form = $('#admin-login-form');
            var $email = $('#admin-email');
            var $password = $('#admin-password');
            var $btn = $('#login-btn');
            var $errorDiv = $('#login-error');
            var $errorMsg = $('#error-message');
            var $toggleBtn = $('#toggle-password');
            var $toggleIcon = $('#toggle-icon');
            var $remember = $('#remember-email');

            if (localStorage.getItem('login_email')) {
                $email.val(localStorage.getItem('login_email'));
                $remember.prop('checked', true);
            }

            $email.on('input', function () {
                $(this).toggleClass('has-value', !!this.value);
            }).trigger('input');
            $password.on('input', function () {
                $(this).toggleClass('has-value', !!this.value);
            }).trigger('input');

            $toggleBtn.on('click', function () {
                var isPassword = $password.attr('type') === 'password';
                $password.attr('type', isPassword ? 'text' : 'password');
                $toggleIcon.toggleClass('fa-eye', !isPassword).toggleClass('fa-eye-slash', isPassword);
            });

            $form.on('submit', function (e) {
                e.preventDefault();

                $btn.prop('disabled', true).addClass('is-loading').removeClass('is-success');
                $errorDiv.removeClass('is-visible');

                if ($remember.is(':checked')) {
                    localStorage.setItem('login_email', $email.val());
                } else {
                    localStorage.removeItem('login_email');
                }

                $.ajax({
                    url: '/api/admin/login',
                    method: 'POST',
                    data: {
                        email: $email.val(),
                        password: $password.val()
                    },
                    success: function (json) {
                        if (json.data && json.data.token) {
                            localStorage.setItem('admin_token', json.data.token);
                            $btn.removeClass('is-loading').addClass('is-success');
                            $btn.find('.btn-text').text('กำลังนำคุณเข้าสู่ระบบ...');
                            setTimeout(function () {
                                window.location.href = '/admin';
                            }, 400);
                        } else {
                            showError('เข้าสู่ระบบไม่สำเร็จ');
                        }
                    },
                    error: function (xhr) {
                        var msg = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
                        try {
                            var json = JSON.parse(xhr.responseText);
                            if (json.message) msg = json.message;
                        } catch (e) {}
                        showError(msg);
                    }
                });
            });

            function showError(msg) {
                $errorMsg.text(msg);
                $errorDiv.addClass('is-visible');
                $btn.prop('disabled', false).removeClass('is-loading');
            }

            $.get('/api/public/home', function (res) {
                if (res.data && res.data.stats) {
                    if (res.data.stats.total_activities) $('#stat-activities').text(res.data.stats.total_activities);
                    if (res.data.stats.total_participants) $('#stat-participants').text(res.data.stats.total_participants);
                    if (res.data.stats.total_categories) $('#stat-categories').text(res.data.stats.total_categories);
                }
            });
        });
    </script>
</body>
</html>
