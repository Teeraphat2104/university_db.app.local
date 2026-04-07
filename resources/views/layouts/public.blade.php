<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Activities')</title>
    <style>
        :root {
            --ink: #1b2a3d;
            --muted: #5d6b7a;
            --paper: #fffdf9;
            --sand: #f6efe3;
            --mint: #d9f3ee;
            --teal: #14746f;
            --coral: #dd6b4d;
            --gold: #f0b24d;
            --line: rgba(27, 42, 61, 0.12);
            --shadow: 0 18px 48px rgba(27, 42, 61, 0.12);
            --radius: 24px;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: var(--ink);
            font-family: "Space Grotesk", "Trebuchet MS", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(240, 178, 77, 0.24), transparent 28%),
                radial-gradient(circle at top right, rgba(20, 116, 111, 0.16), transparent 24%),
                linear-gradient(180deg, #f7efe0 0%, #fffdf9 28%, #f9f7f1 100%);
        }
        a { color: inherit; text-decoration: none; }
        .container { width: min(1120px, calc(100% - 2rem)); margin: 0 auto; }
        .site-header { padding: 1.25rem 0 1rem; }
        .nav-shell {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.25rem;
            background: rgba(255, 253, 249, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 999px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(18px);
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }
        .brand-mark {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: white;
            background: linear-gradient(135deg, var(--teal), #1f5d91);
        }
        .nav-links { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
        .nav-link, .button, button {
            border: none;
            cursor: pointer;
            font: inherit;
            border-radius: 999px;
            transition: transform 0.18s ease;
        }
        .nav-link { padding: 0.72rem 1rem; color: var(--muted); }
        .button, button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.82rem 1.2rem;
            background: linear-gradient(135deg, var(--teal), #1d8e86);
            color: white;
            box-shadow: 0 12px 28px rgba(20, 116, 111, 0.22);
        }
        .button.secondary, button.secondary {
            background: white;
            color: var(--ink);
            border: 1px solid var(--line);
            box-shadow: none;
        }
        .button.accent, button.accent {
            background: linear-gradient(135deg, var(--coral), #e88d58);
            box-shadow: 0 12px 28px rgba(221, 107, 77, 0.22);
        }
        .nav-link:hover, .button:hover, button:hover { transform: translateY(-1px); }
        main { padding: 1rem 0 3rem; }
        .flash, .validation-errors {
            margin: 0 0 1.2rem;
            padding: 1rem 1.15rem;
            border-radius: 18px;
            border: 1px solid var(--line);
            background: white;
        }
        .flash.success { border-color: rgba(20, 116, 111, 0.28); background: #f2fcfa; }
        .flash.error, .validation-errors { border-color: rgba(221, 107, 77, 0.28); background: #fff3ef; }
        .hero-panel, .surface, .card, .filter-panel, .detail-grid > article, .detail-grid > aside {
            background: rgba(255, 253, 249, 0.88);
            border: 1px solid rgba(255, 255, 255, 0.72);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            backdrop-filter: blur(16px);
        }
        .hero-panel {
            display: grid;
            grid-template-columns: 1.25fr 0.95fr;
            gap: 1.5rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.42rem 0.8rem;
            border-radius: 999px;
            background: rgba(20, 116, 111, 0.1);
            color: var(--teal);
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        h1, h2, h3 { margin: 0; line-height: 1.05; font-family: Georgia, "Times New Roman", serif; }
        h1 { font-size: clamp(2.2rem, 5vw, 4rem); }
        h2 { font-size: clamp(1.55rem, 3vw, 2.3rem); }
        h3 { font-size: 1.15rem; }
        p { color: var(--muted); line-height: 1.7; }
        .hero-copy p { max-width: 56ch; margin: 1rem 0 0; font-size: 1.04rem; }
        .stats-grid, .card-grid { display: grid; gap: 1rem; }
        .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); align-content: start; }
        .stat-card {
            padding: 1.15rem;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(217,243,238,0.58));
            border: 1px solid rgba(20, 116, 111, 0.1);
        }
        .stat-label { color: var(--muted); font-size: 0.92rem; }
        .stat-value { margin-top: 0.3rem; font-size: 1.8rem; font-weight: 700; }
        .section-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .section-head p { margin: 0.4rem 0 0; }
        .card-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .card { padding: 1.25rem; }
        .meta-row, .card-actions { display: flex; flex-wrap: wrap; gap: 0.65rem; align-items: center; }
        .meta-row { margin: 1rem 0 0.75rem; color: var(--muted); font-size: 0.92rem; }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.42rem 0.75rem;
            border-radius: 999px;
            background: rgba(240, 178, 77, 0.16);
            color: #915b00;
            font-size: 0.85rem;
            font-weight: 700;
        }
        .badge.status { background: rgba(20, 116, 111, 0.11); color: var(--teal); }
        .filter-panel { padding: 1.25rem; margin-bottom: 1.25rem; }
        .form-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0.9rem; }
        .field { display: flex; flex-direction: column; gap: 0.45rem; }
        .field.span-2 { grid-column: span 2; }
        .field.span-4 { grid-column: 1 / -1; }
        label { font-weight: 700; font-size: 0.92rem; }
        input, select, textarea {
            width: 100%;
            padding: 0.9rem 1rem;
            color: var(--ink);
            font: inherit;
            background: rgba(255,255,255,0.92);
            border: 1px solid var(--line);
            border-radius: 18px;
            outline: none;
        }
        textarea { min-height: 160px; resize: vertical; }
        .detail-grid { display: grid; grid-template-columns: minmax(0, 1.7fr) minmax(280px, 0.95fr); gap: 1rem; }
        .detail-grid > article, .detail-grid > aside { padding: 1.5rem; }
        .stack { display: grid; gap: 0.85rem; }
        .meta { color: var(--muted); line-height: 1.7; }
        .pager {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-top: 1.25rem;
            padding: 1rem 1.15rem;
            border-radius: 20px;
            background: rgba(255, 253, 249, 0.9);
            border: 1px solid rgba(255,255,255,0.7);
            box-shadow: var(--shadow);
        }
        .pager-meta { color: var(--muted); font-weight: 700; }
        .pager-link { padding: 0.75rem 1rem; border-radius: 999px; background: white; border: 1px solid var(--line); }
        .pager-link.disabled { opacity: 0.45; pointer-events: none; }
        .site-footer { padding: 0 0 2.5rem; color: var(--muted); text-align: center; }
        @media (max-width: 960px) {
            .hero-panel, .detail-grid, .card-grid, .form-grid { grid-template-columns: 1fr; }
            .field.span-2, .field.span-4 { grid-column: auto; }
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 720px) {
            .nav-shell, .section-head, .pager { flex-direction: column; align-items: stretch; }
            .stats-grid { grid-template-columns: 1fr; }
            h1 { font-size: 2.35rem; }
            .hero-panel { padding: 1.5rem; }
            .card, .filter-panel, .detail-grid > article, .detail-grid > aside { padding: 1.1rem; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="nav-shell">
                <a href="{{ route('home') }}" class="brand">
                    <span class="brand-mark">UA</span>
                    <span>University Activities</span>
                </a>
                <nav class="nav-links">
                    <a href="{{ route('home') }}" class="nav-link">หน้าแรก</a>
                    <a href="{{ route('activities.index') }}" class="nav-link">กิจกรรม</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="button secondary">Admin Dashboard</a>
                    @else
                        <a href="{{ route('admin.login') }}" class="button secondary">Admin Login</a>
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
</body>
</html>
