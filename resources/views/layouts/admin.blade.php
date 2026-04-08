<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ผู้ดูแลระบบ')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --surface: #ffffff;
            --surface-soft: #f7f7f5;
            --bg: #f1f2ed;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --accent: #145a47;
            --accent-soft: #eef7f3;
            --danger: #b42318;
            --danger-soft: #fef3f2;
            --shadow: 0 18px 44px rgba(15, 23, 42, 0.06);
            --radius: 22px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: linear-gradient(180deg, #f7f7f3 0%, #eff0ea 100%);
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

        .admin-shell {
            width: min(1280px, calc(100% - 2rem));
            margin: 0 auto;
            padding: 1.25rem 0 2rem;
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            gap: 1.25rem;
        }

        .sidebar,
        .content-shell,
        .panel,
        .metric-card,
        .table-wrap,
        .form-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .sidebar {
            padding: 1.25rem;
            position: sticky;
            top: 1rem;
            align-self: start;
        }

        .brand {
            display: grid;
            gap: 0.4rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--line);
        }

        .brand small,
        .muted {
            color: var(--muted);
        }

        .brand strong {
            font-size: 1.2rem;
        }

        .nav-list {
            display: grid;
            gap: 0.65rem;
            margin-top: 1rem;
        }

        .nav-item,
        .action-button {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem 1rem;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--surface-soft);
            color: var(--muted);
            cursor: pointer;
            text-align: center;
        }

        .nav-item.active {
            color: #ffffff;
            background: var(--accent);
            border-color: var(--accent);
        }

        .content-shell {
            padding: 1.5rem;
        }

        .page-head,
        .panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .page-head {
            margin-bottom: 1.25rem;
        }

        .page-head h1,
        .panel-head h2,
        .panel-head h3 {
            margin: 0;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .page-head h1 {
            font-size: 2rem;
        }

        .page-head p,
        .panel-head p,
        .muted {
            margin: 0.45rem 0 0;
            line-height: 1.7;
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
        }

        .button,
        button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.82rem 1.15rem;
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

        .button.danger,
        button.danger {
            background: var(--danger);
        }

        .flash,
        .validation-errors {
            margin-bottom: 1rem;
            padding: 1rem 1.15rem;
            border-radius: 16px;
            border: 1px solid var(--line);
            background: var(--surface);
        }

        .flash.success {
            color: var(--accent);
            border-color: rgba(20, 90, 71, 0.16);
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

        .metrics {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .metric-card {
            padding: 1.2rem;
        }

        .metric-card span {
            display: block;
            color: var(--muted);
            font-size: 0.94rem;
        }

        .metric-card strong {
            display: block;
            margin-top: 0.35rem;
            font-size: 1.9rem;
        }

        .panel,
        .table-wrap,
        .form-card {
            padding: 1.35rem;
        }

        .filter-grid,
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

        textarea {
            min-height: 180px;
            resize: vertical;
        }

        .is-invalid {
            border-color: rgba(180, 35, 24, 0.4);
            background: #fff9f8;
        }

        .field-error {
            color: var(--danger);
            font-size: 0.9rem;
        }

        .help-text {
            font-size: 0.9rem;
            color: var(--muted);
        }

        .table-wrap {
            overflow: hidden;
        }

        .table-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: top;
        }

        th {
            color: var(--muted);
            font-size: 0.84rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        tbody tr:last-child td {
            border-bottom: none;
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

        .detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(280px, 0.9fr);
            gap: 1rem;
        }

        .stack,
        .info-list {
            display: grid;
            gap: 0.85rem;
        }

        .info-item {
            padding-bottom: 0.85rem;
            border-bottom: 1px solid var(--line);
        }

        .info-item:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .inline-form {
            display: inline;
        }

        .hidden {
            display: none;
        }

        @media (max-width: 1080px) {
            .admin-shell,
            .detail-grid,
            .metrics,
            .filter-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .field.span-2,
            .field.span-4 {
                grid-column: auto;
            }

            .sidebar {
                position: static;
            }
        }

        @media (max-width: 720px) {
            .page-head,
            .panel-head {
                flex-direction: column;
                align-items: stretch;
            }

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                padding: 0.75rem 0;
                border-bottom: 1px solid var(--line);
            }

            td {
                padding: 0.35rem 0;
                border: none;
            }

            td::before {
                content: attr(data-label);
                display: block;
                margin-bottom: 0.2rem;
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
                <strong>ระบบจัดการกิจกรรมนักศึกษา</strong>
                <span class="muted">{{ auth()->user()?->name }} · {{ auth()->user()?->email }}</span>
            </div>

            <div class="nav-list">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">แดชบอร์ด</a>
                <a href="{{ route('admin.activities.index') }}" class="nav-item {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">กิจกรรม</a>
                <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">หมวดหมู่</a>
                <a href="{{ route('home') }}" class="nav-item">หน้าเว็บไซต์</a>

                <form method="POST" action="{{ route('admin.logout') }}" id="admin-logout-form">
                    @csrf
                    <button type="submit" class="action-button">ออกจากระบบ</button>
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

        $(document).on('submit', '#admin-logout-form', function (event) {
            event.preventDefault();

            $.ajax({
                url: this.action,
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).done(function (payload) {
                window.location.href = payload.data.redirect_url;
            }).fail(function () {
                window.location.href = '{{ route('admin.login') }}';
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
