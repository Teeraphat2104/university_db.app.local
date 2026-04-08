<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ระบบกิจกรรมนักศึกษา')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --surface: #ffffff;
            --surface-soft: #f8f8f5;
            --bg: #f3f4ef;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --accent: #1d6b57;
            --accent-soft: #eaf5f0;
            --danger: #b42318;
            --danger-soft: #fef3f2;
            --shadow: 0 18px 44px rgba(15, 23, 42, 0.06);
            --radius: 20px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: linear-gradient(180deg, #f8f8f4 0%, #f1f2eb 100%);
            color: var(--text);
            font-family: "IBM Plex Sans Thai", sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        .container {
            width: min(1120px, calc(100% - 2rem));
            margin: 0 auto;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            border-bottom: 1px solid rgba(229, 231, 235, 0.9);
            background: rgba(243, 244, 239, 0.9);
            backdrop-filter: blur(12px);
        }

        .site-nav {
            min-height: 74px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: #111827;
            color: #ffffff;
            font-weight: 700;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .nav-link {
            padding: 0.72rem 1rem;
            border-radius: 999px;
            color: var(--muted);
        }

        .nav-link.active,
        .nav-link:hover {
            background: var(--surface);
            color: var(--text);
        }

        .button,
        button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.85rem 1.15rem;
            border: 1px solid transparent;
            border-radius: 999px;
            background: var(--accent);
            color: #ffffff;
            cursor: pointer;
        }

        .button.secondary,
        button.secondary {
            background: var(--surface);
            color: var(--text);
            border-color: var(--line);
        }

        main {
            padding: 2rem 0 4rem;
        }

        .flash,
        .validation-errors {
            margin-bottom: 1rem;
            padding: 1rem 1.15rem;
            border-radius: 16px;
            border: 1px solid var(--line);
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .flash.success {
            color: var(--accent);
            border-color: rgba(29, 107, 87, 0.16);
            background: var(--accent-soft);
        }

        .flash.error,
        .validation-errors {
            color: var(--danger);
            border-color: rgba(180, 35, 24, 0.14);
            background: var(--danger-soft);
        }

        .validation-errors ul,
        .flash ul {
            margin: 0.75rem 0 0;
            padding-left: 1.25rem;
        }

        .hero,
        .panel,
        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .hero {
            padding: 2.25rem;
        }

        .hero-grid,
        .detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
            gap: 1.25rem;
            align-items: start;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            background: var(--accent-soft);
            color: var(--accent);
            font-size: 0.88rem;
            font-weight: 600;
        }

        h1,
        h2,
        h3 {
            margin: 0;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        h1 { font-size: clamp(2rem, 4vw, 3.2rem); }
        h2 { font-size: clamp(1.35rem, 2.5vw, 2rem); }
        h3 { font-size: 1.15rem; }

        p,
        .muted {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .hero-copy p {
            max-width: 58ch;
            margin-top: 1rem;
        }

        .actions,
        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .actions {
            margin-top: 1.5rem;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .stat {
            padding: 1.2rem;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: var(--surface-soft);
        }

        .stat-label {
            color: var(--muted);
            font-size: 0.95rem;
        }

        .stat-value {
            margin-top: 0.4rem;
            font-size: 1.85rem;
            font-weight: 600;
        }

        .section {
            margin-top: 1.5rem;
        }

        .panel {
            padding: 1.5rem;
        }

        .section-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .section-head p {
            margin-top: 0.35rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .field.span-2 {
            grid-column: span 2;
        }

        .field.span-4 {
            grid-column: 1 / -1;
        }

        label {
            font-weight: 600;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            background: #ffffff;
            color: var(--text);
            border: 1px solid var(--line);
            border-radius: 14px;
            outline: none;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .card {
            padding: 1.35rem;
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            background: var(--accent-soft);
            color: var(--accent);
            font-size: 0.84rem;
            font-weight: 600;
        }

        .badge.neutral {
            background: #f3f4f6;
            color: #4b5563;
        }

        .meta-list,
        .stack,
        .info-list {
            display: grid;
            gap: 0.7rem;
        }

        .meta-list {
            color: var(--muted);
            font-size: 0.95rem;
        }

        .info-item {
            padding-bottom: 0.8rem;
            border-bottom: 1px solid var(--line);
        }

        .info-item:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .empty-state {
            padding: 2rem;
            text-align: center;
        }

        .pager {
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .pager-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            padding: 0.75rem 1rem;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: var(--surface);
        }

        .pager-link.disabled {
            opacity: 0.45;
            pointer-events: none;
        }

        .is-invalid {
            border-color: rgba(180, 35, 24, 0.4);
            background: #fff9f8;
        }

        .field-error {
            color: var(--danger);
            font-size: 0.9rem;
        }

        .site-footer {
            padding: 0 0 2.5rem;
            color: var(--muted);
        }

        @media (max-width: 960px) {
            .hero-grid,
            .detail-grid,
            .card-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .field.span-2,
            .field.span-4 {
                grid-column: auto;
            }
        }

        @media (max-width: 720px) {
            .site-nav,
            .section-head,
            .pager {
                flex-direction: column;
                align-items: stretch;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .nav-links,
            .actions {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="site-nav">
                <a href="{{ route('home') }}" class="brand">
                    <span class="brand-mark">UA</span>
                    <span>ระบบกิจกรรมนักศึกษา</span>
                </a>

                <nav class="nav-links">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">หน้าแรก</a>
                    <a href="{{ route('activities.index') }}" class="nav-link {{ request()->routeIs('activities.*') ? 'active' : '' }}">กิจกรรม</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="button secondary">จัดการระบบ</a>
                    @else
                        <a href="{{ route('admin.login') }}" class="button secondary">เข้าสู่ระบบผู้ดูแล</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            @if (session('success'))
                <div class="flash success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="flash error">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="validation-errors">
                    <strong>กรุณาตรวจสอบข้อมูลอีกครั้ง</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            ระบบกิจกรรมนักศึกษา แยก public site และ admin management อย่างชัดเจน
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        window.AppUi = {
            clearFormErrors(formSelector) {
                const $form = $(formSelector);
                $form.find('.field-error').remove();
                $form.find('.is-invalid').removeClass('is-invalid');
            },
            applyFieldErrors(formSelector, errors) {
                const $form = $(formSelector);
                const messages = [];

                $.each(errors || {}, function (fieldName, fieldMessages) {
                    const $field = $form.find('[name="' + fieldName + '"]');

                    if ($field.length) {
                        $field.addClass('is-invalid');
                        $('<div class="field-error"></div>')
                            .text(fieldMessages[0])
                            .insertAfter($field.last());
                    }

                    $.each(fieldMessages, function (_index, message) {
                        messages.push(message);
                    });
                });

                return messages;
            },
            showFeedback(selector, type, message, items = []) {
                const $feedback = $(selector);
                const feedbackClass = type === 'success' ? 'flash success' : 'flash error';
                let html = '<strong>' + message + '</strong>';

                if (items.length) {
                    html += '<ul>' + items.map((item) => '<li>' + item + '</li>').join('') + '</ul>';
                }

                $feedback
                    .removeAttr('hidden')
                    .attr('class', feedbackClass)
                    .html(html);
            }
        };
    </script>
    @stack('scripts')
</body>
</html>
