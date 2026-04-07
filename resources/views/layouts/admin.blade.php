<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <style>
        :root {
            --ink: #1d2433;
            --muted: #677284;
            --surface-strong: #183449;
            --teal: #0f766e;
            --rose: #c2410c;
            --line: rgba(29, 36, 51, 0.12);
            --shadow: 0 20px 44px rgba(29, 36, 51, 0.12);
            --radius: 24px;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: var(--ink);
            font-family: "Space Grotesk", "Trebuchet MS", sans-serif;
            background:
                radial-gradient(circle at top right, rgba(217, 119, 6, 0.14), transparent 22%),
                linear-gradient(180deg, #f6efe3 0%, #f9f6f0 100%);
        }
        a { color: inherit; text-decoration: none; }
        button { font: inherit; }
        .admin-shell {
            width: min(1280px, calc(100% - 2rem));
            margin: 1rem auto;
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            gap: 1rem;
        }
        .sidebar, .content-shell, .panel, .metric-card, .table-shell, .form-shell {
            background: rgba(255, 253, 250, 0.92);
            border: 1px solid rgba(255,255,255,0.68);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            backdrop-filter: blur(14px);
        }
        .sidebar { padding: 1.3rem; position: sticky; top: 1rem; align-self: start; }
        .brand {
            display: grid;
            gap: 0.8rem;
            padding: 1rem;
            border-radius: 20px;
            color: white;
            background: linear-gradient(135deg, var(--surface-strong), #0f766e);
        }
        .brand small { color: rgba(255,255,255,0.74); letter-spacing: 0.06em; text-transform: uppercase; }
        .brand strong { font-size: 1.45rem; line-height: 1.15; font-family: Georgia, "Times New Roman", serif; }
        .nav-list { display: grid; gap: 0.65rem; margin-top: 1rem; }
        .nav-item, .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.9rem 1rem;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: white;
            cursor: pointer;
        }
        .nav-item.active {
            color: white;
            background: linear-gradient(135deg, var(--teal), #1f8b82);
            border-color: transparent;
            box-shadow: 0 14px 30px rgba(15, 118, 110, 0.22);
        }
        .content-shell { padding: 1.25rem; }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .headline h1, .headline h2 { margin: 0; font-family: Georgia, "Times New Roman", serif; }
        .headline p, .meta { margin: 0.45rem 0 0; color: var(--muted); line-height: 1.6; }
        .flash, .validation-errors {
            margin-bottom: 1rem;
            padding: 1rem 1.15rem;
            border-radius: 18px;
            background: white;
            border: 1px solid var(--line);
        }
        .flash.success { background: #f2fcfa; border-color: rgba(15, 118, 110, 0.28); }
        .flash.error, .validation-errors { background: #fff3ef; border-color: rgba(194, 65, 12, 0.28); }
        .metrics {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .metric-card { padding: 1.15rem; }
        .metric-card span { color: var(--muted); font-size: 0.92rem; }
        .metric-card strong { display: block; margin-top: 0.3rem; font-size: 2rem; }
        .table-shell, .form-shell, .panel { padding: 1.15rem; }
        .toolbar, .detail-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 0.9rem;
            margin-bottom: 1rem;
        }
        .button-row { display: flex; flex-wrap: wrap; gap: 0.7rem; }
        .primary, .secondary, .danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.82rem 1.15rem;
            border: none;
            border-radius: 999px;
            cursor: pointer;
        }
        .primary { background: linear-gradient(135deg, var(--teal), #1d8e86); color: white; }
        .secondary { background: white; color: var(--ink); border: 1px solid var(--line); }
        .danger { background: linear-gradient(135deg, var(--rose), #ea580c); color: white; }
        .filter-grid, .form-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0.9rem; }
        .field { display: flex; flex-direction: column; gap: 0.45rem; }
        .field.span-2 { grid-column: span 2; }
        .field.span-4 { grid-column: 1 / -1; }
        label { font-weight: 700; font-size: 0.92rem; }
        input, select, textarea {
            width: 100%;
            padding: 0.9rem 1rem;
            color: var(--ink);
            font: inherit;
            background: white;
            border: 1px solid var(--line);
            border-radius: 18px;
            outline: none;
        }
        textarea { min-height: 180px; resize: vertical; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            padding: 0.9rem 0.75rem;
            text-align: left;
            border-bottom: 1px solid rgba(29, 36, 51, 0.08);
            vertical-align: top;
        }
        th { color: var(--muted); font-size: 0.86rem; letter-spacing: 0.04em; text-transform: uppercase; }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.38rem 0.72rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
            background: rgba(217, 119, 6, 0.14);
            color: #8a5600;
        }
        .badge.status { background: rgba(15, 118, 110, 0.12); color: var(--teal); }
        .detail-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 1rem; }
        .stack { display: grid; gap: 0.8rem; }
        .pager { display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-top: 1rem; }
        .pager-link { padding: 0.75rem 1rem; border-radius: 999px; background: white; border: 1px solid var(--line); }
        .pager-meta { color: var(--muted); font-weight: 700; }
        .disabled { opacity: 0.45; pointer-events: none; }
        @media (max-width: 1080px) {
            .admin-shell, .detail-grid, .metrics, .filter-grid, .form-grid { grid-template-columns: 1fr; }
            .field.span-2, .field.span-4 { grid-column: auto; }
            .sidebar { position: static; }
        }
        @media (max-width: 720px) {
            .topbar, .toolbar, .detail-actions, .pager { flex-direction: column; align-items: stretch; }
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            tr { padding: 0.8rem 0; border-bottom: 1px solid rgba(29, 36, 51, 0.08); }
            td { padding: 0.35rem 0; border: none; }
            td::before {
                content: attr(data-label);
                display: block;
                color: var(--muted);
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
            }
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="sidebar">
            <div class="brand">
                <small>Admin Panel</small>
                <strong>Student Activity Manager</strong>
                <span>{{ auth()->user()?->name }} • {{ auth()->user()?->email }}</span>
            </div>
            <div class="nav-list">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.activities.index') }}" class="nav-item {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">Activities</a>
                <a href="{{ route('home') }}" class="nav-item">Public Site</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="action-button">Logout</button>
                </form>
            </div>
        </aside>
        <div class="content-shell">
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
    </div>
</body>
</html>
