<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'University Activities') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700&family=Noto+Sans+Thai:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Remove Vite, add jQuery CDN and direct CSS/JS includes if needed -->
    <!-- <link rel="stylesheet" href="/css/app.css"> -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- <script src="/js/app.js"></script> -->

    <style>
        :root {
            --bg: #f4f2ee;
            --bg-accent: #ece7df;
            --card: #ffffff;
            --text: #1d2329;
            --muted: #5f6975;
            --line: #dfe3e8;
            --primary: #0f766e;
            --primary-strong: #0c5f58;
            --danger: #c83f4d;
            --radius-lg: 18px;
            --radius-md: 12px;
            --radius-sm: 9px;
            --shadow: 0 15px 35px rgba(19, 35, 56, 0.08);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            font-family: 'Noto Sans Thai', system-ui, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top right, rgba(15, 118, 110, 0.12), transparent 32%),
                linear-gradient(135deg, var(--bg) 0%, var(--bg-accent) 100%);
        }

        a {
            color: var(--primary);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .hidden {
            display: none !important;
        }

        .page-shell {
            width: min(1180px, 94%);
            margin: 26px auto 48px;
        }

        .card {
            background: color-mix(in oklab, var(--card) 92%, #f7fafc 8%);
            border: 1px solid color-mix(in oklab, var(--line) 76%, #ffffff 24%);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 20px 24px;
            margin-bottom: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-dot {
            width: 14px;
            height: 14px;
            border-radius: 999px;
            background: linear-gradient(180deg, var(--primary), #14998f);
            box-shadow: 0 0 0 8px rgba(15, 118, 110, 0.12);
        }

        .eyebrow {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            font-family: 'Manrope', sans-serif;
        }

        .topbar h1 {
            margin: 4px 0 0;
            font-size: clamp(1.05rem, 1.8vw, 1.35rem);
            font-weight: 700;
        }

        .mode-switch {
            display: inline-flex;
            gap: 8px;
            padding: 6px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: #f7f9fc;
        }

        .mode-btn {
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: var(--muted);
            padding: 8px 14px;
            font-family: 'Noto Sans Thai', sans-serif;
            font-size: 14px;
            cursor: pointer;
        }

        .mode-btn.is-active {
            background: var(--primary);
            color: #fff;
        }

        .view-stack {
            display: grid;
            gap: 16px;
        }

        .section-panel {
            padding: 24px;
        }

        .section-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .section-head h2,
        .section-head h3 {
            margin: 0 0 4px;
            font-family: 'Manrope', 'Noto Sans Thai', sans-serif;
            font-size: clamp(1.1rem, 1.9vw, 1.3rem);
        }

        .section-head p {
            margin: 0;
            color: var(--muted);
            font-size: 0.94rem;
        }

        .summary {
            margin: 4px 0 16px;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .filters,
        .form-grid {
            display: flex;
            flex-wrap: wrap;
            align-items: end;
            gap: 12px;
            margin-bottom: 16px;
        }

        .form-stack {
            display: grid;
            gap: 12px;
        }

        .field {
            display: grid;
            gap: 6px;
            min-width: 180px;
        }

        .field span {
            font-size: 13px;
            color: var(--muted);
        }

        .field.grow {
            flex: 1 1 280px;
        }

        .field-full {
            width: 100%;
        }

        input,
        select,
        textarea,
        button {
            font-family: inherit;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            background: #fff;
            color: var(--text);
            font-size: 0.95rem;
            padding: 10px 12px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid color-mix(in oklab, var(--primary) 35%, white 65%);
            outline-offset: 1px;
            border-color: var(--primary);
        }

        .check-field {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-size: 0.95rem;
            padding-bottom: 2px;
        }

        .check-field input {
            width: 18px;
            height: 18px;
            margin: 0;
        }

        .inline-actions {
            display: inline-flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }

        .btn {
            border: 0;
            border-radius: 10px;
            padding: 9px 13px;
            font-size: 0.9rem;
            line-height: 1;
            cursor: pointer;
            transition: transform 0.12s ease, opacity 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.55;
            transform: none;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-strong);
            text-decoration: none;
        }

        .btn-muted {
            background: #eef2f6;
            color: #314050;
        }

        .btn-danger {
            background: #fce8eb;
            color: #9b2030;
        }

        .btn-sm {
            padding: 7px 10px;
            font-size: 0.82rem;
        }

        .activity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(258px, 1fr));
            gap: 14px;
        }

        .activity-card {
            display: grid;
            grid-template-rows: 156px 1fr;
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
            background: #fff;
            overflow: hidden;
        }

        .activity-cover {
            background: linear-gradient(145deg, #d4ece9, #eaf4f2);
        }

        .activity-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cover-fallback {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            font-family: 'Manrope', sans-serif;
            font-size: 2rem;
            color: var(--primary);
        }

        .activity-body {
            padding: 14px;
            display: grid;
            gap: 8px;
        }

        .activity-body h3 {
            margin: 0;
            font-size: 1rem;
        }

        .activity-body p {
            margin: 0;
            color: #3d4752;
            font-size: 0.9rem;
        }

        .card-meta {
            font-size: 0.8rem !important;
            color: var(--muted) !important;
        }

        .empty-state {
            border: 1px dashed var(--line);
            border-radius: var(--radius-md);
            background: #fbfcfe;
            padding: 22px;
            text-align: center;
        }

        .empty-state h4 {
            margin: 0 0 4px;
        }

        .empty-state p {
            margin: 0;
            color: var(--muted);
        }

        .pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 9px;
            margin-top: 16px;
        }

        .page-text {
            font-size: 0.88rem;
            color: var(--muted);
        }

        .admin-auth {
            padding: 22px;
            max-width: 520px;
        }

        .hint {
            margin: 12px 0 0;
            color: var(--muted);
            font-size: 0.84rem;
        }

        .hint code {
            color: var(--text);
            font-size: 0.84rem;
        }

        .admin-header {
            padding: 18px 22px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .admin-header h2 {
            margin: 0 0 4px;
        }

        .admin-header p {
            margin: 0;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .admin-block {
            padding: 20px;
            margin-bottom: 14px;
        }

        .activity-form {
            margin-top: 6px;
            margin-bottom: 18px;
        }

        .asset-links {
            color: var(--muted);
            font-size: 0.88rem;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
            background: #fff;
        }

        th,
        td {
            border-bottom: 1px solid var(--line);
            text-align: left;
            padding: 12px 13px;
            vertical-align: top;
            font-size: 0.9rem;
        }

        th {
            color: var(--muted);
            font-weight: 600;
            font-size: 0.83rem;
            background: #f7f9fc;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .table-actions {
            white-space: nowrap;
        }

        .table-empty {
            text-align: center;
            color: var(--muted);
        }

        .cell-sub {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 0.8rem;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 4px 9px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .pill-on {
            background: #dbf4ef;
            color: #0c685f;
        }

        .pill-off {
            background: #f2f4f7;
            color: #5a6572;
        }

        .activity-dialog {
            width: min(640px, 92vw);
            border: 0;
            border-radius: var(--radius-lg);
            padding: 0;
            box-shadow: 0 40px 70px rgba(16, 27, 40, 0.3);
        }

        .activity-dialog::backdrop {
            background: rgba(23, 30, 39, 0.52);
        }

        .activity-dialog article {
            background: #fff;
            padding: 20px;
        }

        .dialog-close {
            margin-left: auto;
            display: block;
        }

        .dialog-image {
            width: 100%;
            border-radius: var(--radius-md);
            margin-top: 8px;
            margin-bottom: 14px;
            max-height: 290px;
            object-fit: cover;
        }

        .activity-dialog h3 {
            margin: 0;
            font-size: 1.16rem;
        }

        .activity-dialog .muted {
            color: var(--muted);
            margin-top: 5px;
            margin-bottom: 12px;
        }

        .activity-dialog p {
            margin: 0;
            line-height: 1.66;
        }

        .toast {
            position: fixed;
            right: 20px;
            bottom: 22px;
            border-radius: 11px;
            color: #fff;
            padding: 11px 14px;
            font-size: 0.9rem;
            z-index: 50;
            box-shadow: 0 12px 24px rgba(17, 30, 48, 0.24);
        }

        .toast.info {
            background: #3f5f7d;
        }

        .toast.success {
            background: #147d75;
        }

        .toast.error {
            background: #be3343;
        }

        @media (max-width: 980px) {
            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .pagination {
                justify-content: flex-start;
            }
        }

        @media (max-width: 760px) {
            .page-shell {
                width: min(96%, 100%);
                margin-top: 14px;
            }

            .section-panel,
            .admin-block,
            .admin-auth {
                padding: 16px;
            }

            .mode-switch {
                width: 100%;
                justify-content: space-between;
            }

            .mode-btn {
                flex: 1;
                text-align: center;
            }

            .filters,
            .form-grid {
                display: grid;
                gap: 10px;
            }

            .field,
            .field.grow {
                min-width: 100%;
            }

            .inline-actions {
                width: 100%;
            }

            .inline-actions .btn {
                flex: 1 1 120px;
                text-align: center;
            }

            .toast {
                left: 12px;
                right: 12px;
                bottom: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="page-shell">
        <header class="topbar card">
            <div class="brand">
                <span class="brand-dot" aria-hidden="true"></span>
                <div>
                    <p class="eyebrow">University Activities</p>
                    <h1>ระบบกิจกรรมและเอกสาร</h1>
                </div>
            </div>
            <nav class="mode-switch" aria-label="โหมดการใช้งาน">
                <button type="button" class="mode-btn is-active" data-mode="public">ผู้ใช้ทั่วไป</button>
                <button type="button" class="mode-btn" data-mode="admin">แอดมิน</button>
            </nav>
        </header>

        <main class="view-stack">
            <section id="public-view" class="card section-panel">
                <div class="section-head">
                    <div>
                        <h2>รายการกิจกรรม</h2>
                        <p>ค้นหาและกรองกิจกรรม พร้อมเปิดหรือดาวน์โหลดเอกสาร PDF ได้ทันที</p>
                    </div>
                </div>

                <div class="filters">
                    <label class="field grow" for="public-keyword">
                        <span>ค้นหาชื่อกิจกรรม</span>
                        <input id="public-keyword" type="text" placeholder="พิมพ์คำค้นหา...">
                    </label>
                    <label class="field" for="public-category">
                        <span>หมวดหมู่</span>
                        <select id="public-category">
                            <option value="">ทั้งหมด</option>
                        </select>
                    </label>
                    <div class="inline-actions">
                        <button id="public-search" type="button" class="btn btn-primary">ค้นหา</button>
                        <button id="public-reset" type="button" class="btn btn-muted">ล้างตัวกรอง</button>
                    </div>
                </div>

                <p id="public-summary" class="summary">กำลังโหลดรายการกิจกรรม...</p>

                <div id="public-activity-grid" class="activity-grid"></div>

                <div class="pagination">
                    <button id="public-prev" type="button" class="btn btn-muted">ก่อนหน้า</button>
                    <span id="public-page" class="page-text">หน้า 1 / 1</span>
                    <button id="public-next" type="button" class="btn btn-muted">ถัดไป</button>
                </div>
            </section>

            <section id="admin-view" class="section-panel hidden">
                <div id="admin-auth-card" class="card admin-auth">
                    <div class="section-head">
                        <div>
                            <h2>เข้าสู่ระบบแอดมิน</h2>
                            <p>จัดการหมวดหมู่และกิจกรรม พร้อมอัปโหลดรูปปกและไฟล์ PDF</p>
                        </div>
                    </div>
                    <form id="admin-login-form" class="form-stack">
                        <label class="field" for="admin-email">
                            <span>อีเมล</span>
                            <input id="admin-email" name="email" type="email" required autocomplete="email"
                                placeholder="admin@example.com">
                        </label>
                        <label class="field" for="admin-password">
                            <span>รหัสผ่าน</span>
                            <input id="admin-password" name="password" type="password" required
                                autocomplete="current-password" placeholder="••••••••">
                        </label>
                        <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
                    </form>
                    <p class="hint">บัญชีตัวอย่างจาก seeder: <code>admin@example.com / password</code></p>
                </div>

                <div id="admin-dashboard" class="hidden">
                    <section class="card admin-header">
                        <div>
                            <h2>Admin Dashboard</h2>
                            <p id="admin-profile-text">กำลังตรวจสอบ session...</p>
                        </div>
                        <button id="admin-logout" type="button" class="btn btn-muted">ออกจากระบบ</button>
                    </section>

                    <section class="card admin-block">
                        <div class="section-head">
                            <div>
                                <h3>จัดการหมวดหมู่</h3>
                                <p>เพิ่ม แก้ไข และลบหมวดหมู่กิจกรรม</p>
                            </div>
                        </div>

                        <form id="admin-category-form" class="form-grid">
                            <input type="hidden" id="category-id">
                            <label class="field grow" for="category-name">
                                <span>ชื่อหมวดหมู่</span>
                                <input id="category-name" type="text" required placeholder="เช่น กิจกรรมวิชาการ">
                            </label>
                            <label class="check-field" for="category-status">
                                <input id="category-status" type="checkbox" checked>
                                <span>เปิดใช้งาน</span>
                            </label>
                            <div class="inline-actions">
                                <button id="category-submit" type="submit"
                                    class="btn btn-primary">เพิ่มหมวดหมู่</button>
                                <button id="category-cancel" type="button"
                                    class="btn btn-muted hidden">ยกเลิกแก้ไข</button>
                            </div>
                        </form>

                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ชื่อหมวดหมู่</th>
                                        <th>สถานะ</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody id="admin-category-list"></tbody>
                            </table>
                        </div>
                    </section>

                    <section class="card admin-block">
                        <div class="section-head">
                            <div>
                                <h3>จัดการกิจกรรม</h3>
                                <p>เพิ่ม แก้ไข ลบกิจกรรม และอัปโหลดไฟล์แนบ</p>
                            </div>
                        </div>

                        <div class="filters">
                            <label class="field grow" for="admin-activity-keyword">
                                <span>ค้นหากิจกรรม</span>
                                <input id="admin-activity-keyword" type="text" placeholder="ค้นหาจากชื่อกิจกรรม">
                            </label>
                            <label class="field" for="admin-activity-filter-category">
                                <span>กรองหมวดหมู่</span>
                                <select id="admin-activity-filter-category">
                                    <option value="">ทั้งหมด</option>
                                </select>
                            </label>
                            <div class="inline-actions">
                                <button id="admin-activity-search" type="button"
                                    class="btn btn-primary">ค้นหา</button>
                                <button id="admin-activity-reset" type="button"
                                    class="btn btn-muted">ล้างตัวกรอง</button>
                            </div>
                        </div>

                        <form id="admin-activity-form" class="form-grid activity-form">
                            <input type="hidden" id="activity-id">

                            <label class="field grow" for="activity-title">
                                <span>ชื่อกิจกรรม</span>
                                <input id="activity-title" name="title" type="text" required maxlength="255">
                            </label>

                            <label class="field" for="activity-category">
                                <span>หมวดหมู่</span>
                                <select id="activity-category" name="category_id" required></select>
                            </label>

                            <label class="field" for="activity-date">
                                <span>วันที่กิจกรรม</span>
                                <input id="activity-date" name="activity_date" type="date">
                            </label>

                            <label class="field grow" for="activity-location">
                                <span>สถานที่</span>
                                <input id="activity-location" name="location" type="text" maxlength="500"
                                    placeholder="เช่น อาคารเรียนรวม">
                            </label>

                            <label class="field field-full" for="activity-description">
                                <span>รายละเอียด</span>
                                <textarea id="activity-description" name="description" rows="4" placeholder="รายละเอียดกิจกรรม..."></textarea>
                            </label>

                            <label class="field" for="activity-cover">
                                <span>รูปปก (JPG/PNG/WEBP ไม่เกิน 5MB)</span>
                                <input id="activity-cover" name="cover_image" type="file"
                                    accept=".jpg,.jpeg,.png,.webp,image/*">
                            </label>

                            <label class="field" for="activity-pdf">
                                <span>ไฟล์ PDF (ไม่เกิน 20MB)</span>
                                <input id="activity-pdf" name="pdf_file" type="file"
                                    accept=".pdf,application/pdf">
                            </label>

                            <label class="check-field" for="activity-status">
                                <input id="activity-status" name="status" type="checkbox" checked>
                                <span>เปิดเผยกิจกรรม</span>
                            </label>

                            <div id="activity-existing-assets" class="asset-links field-full"></div>

                            <div class="inline-actions field-full">
                                <button id="activity-submit" type="submit"
                                    class="btn btn-primary">เพิ่มกิจกรรม</button>
                                <button id="activity-cancel" type="button"
                                    class="btn btn-muted hidden">ยกเลิกแก้ไข</button>
                            </div>
                        </form>

                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>กิจกรรม</th>
                                        <th>หมวดหมู่</th>
                                        <th>วันที่</th>
                                        <th>สถานะ</th>
                                        <th>ไฟล์</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody id="admin-activity-list"></tbody>
                            </table>
                        </div>

                        <div class="pagination">
                            <button id="admin-activity-prev" type="button" class="btn btn-muted">ก่อนหน้า</button>
                            <span id="admin-activity-page" class="page-text">หน้า 1 / 1</span>
                            <button id="admin-activity-next" type="button" class="btn btn-muted">ถัดไป</button>
                        </div>
                    </section>
                </div>
            </section>
        </main>
    </div>

    <dialog id="activity-dialog" class="activity-dialog">
        <article>
            <button id="dialog-close" type="button" class="btn btn-muted dialog-close">ปิด</button>
            <img id="dialog-image" class="dialog-image hidden" alt="">
            <h3 id="dialog-title"></h3>
            <p id="dialog-meta" class="muted"></p>
            <p id="dialog-description"></p>
            <div class="inline-actions">
                <a id="dialog-open-pdf" class="btn btn-primary hidden" target="_blank" rel="noopener">เปิด PDF</a>
                <a id="dialog-download-pdf" class="btn btn-muted hidden" target="_blank" rel="noopener"
                    download>ดาวน์โหลด PDF</a>
            </div>
        </article>
    </dialog>

    <div id="toast" class="toast hidden" role="status" aria-live="polite"></div>

    <script>


        const API_PREFIX = '/api';
        const ADMIN_SESSION_KEY = 'university-admin-session-v1';

        const defaultMeta = {
            current_page: 1,
            last_page: 1,
            total: 0,
            per_page: 10,
        };

        const state = {
            mode: 'public',
            public: {
                filters: {
                    keyword: '',
                    category_id: '',
                    page: 1,
                    per_page: 9,
                },
                categories: [],
                activities: [],
                meta: {
                    ...defaultMeta,
                    per_page: 9
                },
            },
            admin: {
                session: loadAdminSession(),
                bootstrapped: false,
                filters: {
                    keyword: '',
                    category_id: '',
                    page: 1,
                    per_page: 8,
                },
                categories: [],
                activities: [],
                meta: {
                    ...defaultMeta,
                    per_page: 8
                },
            },
        };

        const el = {};

        document.addEventListener('DOMContentLoaded', async () => {
            cacheElements();
            bindEvents();

            const initialMode = window.location.pathname.startsWith('/admin') ? 'admin' : 'public';
            setMode(initialMode, false);

            try {
                await Promise.all([loadPublicCategories(), loadPublicActivities()]);
                await ensureAdminSession();
            } catch (error) {
                showToast(errorToMessage(error), 'error');
            }
        });

        function cacheElements() {
            el.modeButtons = document.querySelectorAll('.mode-btn');
            el.publicView = document.getElementById('public-view');
            el.adminView = document.getElementById('admin-view');

            el.publicKeyword = document.getElementById('public-keyword');
            el.publicCategory = document.getElementById('public-category');
            el.publicSearch = document.getElementById('public-search');
            el.publicReset = document.getElementById('public-reset');
            el.publicSummary = document.getElementById('public-summary');
            el.publicGrid = document.getElementById('public-activity-grid');
            el.publicPrev = document.getElementById('public-prev');
            el.publicNext = document.getElementById('public-next');
            el.publicPage = document.getElementById('public-page');

            el.dialog = document.getElementById('activity-dialog');
            el.dialogClose = document.getElementById('dialog-close');
            el.dialogImage = document.getElementById('dialog-image');
            el.dialogTitle = document.getElementById('dialog-title');
            el.dialogMeta = document.getElementById('dialog-meta');
            el.dialogDescription = document.getElementById('dialog-description');
            el.dialogOpenPdf = document.getElementById('dialog-open-pdf');
            el.dialogDownloadPdf = document.getElementById('dialog-download-pdf');

            el.adminAuthCard = document.getElementById('admin-auth-card');
            el.adminDashboard = document.getElementById('admin-dashboard');
            el.adminLoginForm = document.getElementById('admin-login-form');
            el.adminEmail = document.getElementById('admin-email');
            el.adminPassword = document.getElementById('admin-password');
            el.adminProfileText = document.getElementById('admin-profile-text');
            el.adminLogout = document.getElementById('admin-logout');

            el.adminCategoryForm = document.getElementById('admin-category-form');
            el.categoryId = document.getElementById('category-id');
            el.categoryName = document.getElementById('category-name');
            el.categoryStatus = document.getElementById('category-status');
            el.categorySubmit = document.getElementById('category-submit');
            el.categoryCancel = document.getElementById('category-cancel');
            el.categoryList = document.getElementById('admin-category-list');

            el.adminActivityKeyword = document.getElementById('admin-activity-keyword');
            el.adminActivityFilterCategory = document.getElementById('admin-activity-filter-category');
            el.adminActivitySearch = document.getElementById('admin-activity-search');
            el.adminActivityReset = document.getElementById('admin-activity-reset');
            el.adminActivityForm = document.getElementById('admin-activity-form');
            el.activityId = document.getElementById('activity-id');
            el.activityTitle = document.getElementById('activity-title');
            el.activityCategory = document.getElementById('activity-category');
            el.activityDate = document.getElementById('activity-date');
            el.activityLocation = document.getElementById('activity-location');
            el.activityDescription = document.getElementById('activity-description');
            el.activityCover = document.getElementById('activity-cover');
            el.activityPdf = document.getElementById('activity-pdf');
            el.activityStatus = document.getElementById('activity-status');
            el.activityExistingAssets = document.getElementById('activity-existing-assets');
            el.activitySubmit = document.getElementById('activity-submit');
            el.activityCancel = document.getElementById('activity-cancel');
            el.adminActivityList = document.getElementById('admin-activity-list');
            el.adminActivityPrev = document.getElementById('admin-activity-prev');
            el.adminActivityNext = document.getElementById('admin-activity-next');
            el.adminActivityPage = document.getElementById('admin-activity-page');

            el.toast = document.getElementById('toast');
        }

        function bindEvents() {
            el.modeButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    setMode(button.dataset.mode);
                });
            });

            el.publicSearch.addEventListener('click', () => {
                state.public.filters.keyword = el.publicKeyword.value.trim();
                state.public.filters.category_id = el.publicCategory.value;
                state.public.filters.page = 1;
                void loadPublicActivities();
            });

            el.publicReset.addEventListener('click', () => {
                el.publicKeyword.value = '';
                el.publicCategory.value = '';
                state.public.filters.keyword = '';
                state.public.filters.category_id = '';
                state.public.filters.page = 1;
                void loadPublicActivities();
            });

            el.publicCategory.addEventListener('change', () => {
                state.public.filters.category_id = el.publicCategory.value;
                state.public.filters.page = 1;
                void loadPublicActivities();
            });

            el.publicKeyword.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    el.publicSearch.click();
                }
            });

            el.publicPrev.addEventListener('click', () => {
                if (state.public.meta.current_page <= 1) {
                    return;
                }
                state.public.filters.page -= 1;
                void loadPublicActivities();
            });

            el.publicNext.addEventListener('click', () => {
                if (state.public.meta.current_page >= state.public.meta.last_page) {
                    return;
                }
                state.public.filters.page += 1;
                void loadPublicActivities();
            });

            el.publicGrid.addEventListener('click', (event) => {
                const detailButton = event.target.closest('[data-action="detail"]');
                if (!detailButton) {
                    return;
                }
                void openPublicDetail(detailButton.dataset.id);
            });

            el.dialogClose.addEventListener('click', () => closeDialog());
            el.dialog.addEventListener('click', (event) => {
                if (event.target === el.dialog) {
                    closeDialog();
                }
            });

            el.adminLoginForm.addEventListener('submit', (event) => {
                event.preventDefault();
                void loginAdmin();
            });

            el.adminLogout.addEventListener('click', () => {
                void logoutAdmin();
            });

            el.adminCategoryForm.addEventListener('submit', (event) => {
                event.preventDefault();
                void saveCategory();
            });

            el.categoryCancel.addEventListener('click', () => {
                resetCategoryForm();
            });

            el.categoryList.addEventListener('click', (event) => {
                const actionButton = event.target.closest('button[data-action]');
                if (!actionButton) {
                    return;
                }
                const {
                    action,
                    id
                } = actionButton.dataset;
                if (action === 'edit') {
                    editCategory(id);
                }
                if (action === 'delete') {
                    void deleteCategory(id);
                }
            });

            el.adminActivitySearch.addEventListener('click', () => {
                state.admin.filters.keyword = el.adminActivityKeyword.value.trim();
                state.admin.filters.category_id = el.adminActivityFilterCategory.value;
                state.admin.filters.page = 1;
                void loadAdminActivities();
            });

            el.adminActivityReset.addEventListener('click', () => {
                el.adminActivityKeyword.value = '';
                el.adminActivityFilterCategory.value = '';
                state.admin.filters.keyword = '';
                state.admin.filters.category_id = '';
                state.admin.filters.page = 1;
                void loadAdminActivities();
            });

            el.adminActivityFilterCategory.addEventListener('change', () => {
                state.admin.filters.category_id = el.adminActivityFilterCategory.value;
                state.admin.filters.page = 1;
                void loadAdminActivities();
            });

            el.adminActivityKeyword.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    el.adminActivitySearch.click();
                }
            });

            el.adminActivityPrev.addEventListener('click', () => {
                if (state.admin.meta.current_page <= 1) {
                    return;
                }
                state.admin.filters.page -= 1;
                void loadAdminActivities();
            });

            el.adminActivityNext.addEventListener('click', () => {
                if (state.admin.meta.current_page >= state.admin.meta.last_page) {
                    return;
                }
                state.admin.filters.page += 1;
                void loadAdminActivities();
            });

            el.adminActivityForm.addEventListener('submit', (event) => {
                event.preventDefault();
                void saveActivity();
            });

            el.activityCancel.addEventListener('click', () => {
                resetActivityForm();
            });

            el.adminActivityList.addEventListener('click', (event) => {
                const actionButton = event.target.closest('button[data-action]');
                if (!actionButton) {
                    return;
                }
                const {
                    action,
                    id
                } = actionButton.dataset;
                if (action === 'edit') {
                    void editActivity(id);
                }
                if (action === 'delete') {
                    void deleteActivity(id);
                }
            });
        }

        function setMode(mode, updateHistory = true) {
            state.mode = mode === 'admin' ? 'admin' : 'public';

            el.modeButtons.forEach((button) => {
                button.classList.toggle('is-active', button.dataset.mode === state.mode);
            });

            el.publicView.classList.toggle('hidden', state.mode !== 'public');
            el.adminView.classList.toggle('hidden', state.mode !== 'admin');

            if (updateHistory) {
                const target = state.mode === 'admin' ? '/admin' : '/';
                if (window.location.pathname !== target) {
                    window.history.replaceState({}, '', target);
                }
            }

            if (state.mode === 'admin') {
                void ensureAdminSession();
            }
        }

        async function loadPublicCategories() {
            const response = await api('/public/categories');
            state.public.categories = response.data || [];
            renderPublicCategoryOptions();
        }

        async function loadPublicActivities() {
            setPublicLoading(true);

            try {
                const query = buildQuery(state.public.filters);
                const response = await api(`/public/activities${query}`);
                state.public.activities = response.data || [];
                state.public.meta = response.meta || {
                    ...defaultMeta,
                    per_page: state.public.filters.per_page
                };
                renderPublicActivities();
            } catch (error) {
                el.publicSummary.textContent = 'ไม่สามารถโหลดข้อมูลกิจกรรมได้';
                showToast(errorToMessage(error), 'error');
            } finally {
                setPublicLoading(false);
            }
        }

        function renderPublicCategoryOptions() {
            const selected = state.public.filters.category_id || '';
            const options = state.public.categories
                .map((category) => `<option value="${category.id}">${escapeHtml(category.name)}</option>`)
                .join('');

            el.publicCategory.innerHTML = `<option value="">ทั้งหมด</option>${options}`;
            el.publicCategory.value = selected;
        }

        function renderPublicActivities() {
            const {
                activities,
                meta
            } = state.public;

            if (!activities.length) {
                el.publicGrid.innerHTML = `
            <article class="empty-state">
                <h4>ไม่พบกิจกรรม</h4>
                <p>ลองเปลี่ยนคำค้นหา หรือเลือกหมวดหมู่อื่น</p>
            </article>
        `;
            } else {
                el.publicGrid.innerHTML = activities.map((activity) => publicActivityCard(activity)).join('');
            }

            el.publicSummary.textContent = `แสดง ${activities.length} รายการ จากทั้งหมด ${meta.total ?? 0} รายการ`;
            el.publicPage.textContent = `หน้า ${meta.current_page ?? 1} / ${meta.last_page ?? 1}`;
            el.publicPrev.disabled = (meta.current_page ?? 1) <= 1;
            el.publicNext.disabled = (meta.current_page ?? 1) >= (meta.last_page ?? 1);
        }

        function publicActivityCard(activity) {
            const cover = activity.cover_image_url ?
                `<img src="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" alt="${escapeAttr(activity.title)}">` :
                `<div class="cover-fallback">${escapeHtml((activity.title || 'A').slice(0, 1).toUpperCase())}</div>`;

            const categoryName = activity.category?.name || 'ไม่ระบุหมวดหมู่';
            const shortDescription = truncate(activity.description || 'ไม่มีรายละเอียดเพิ่มเติม', 140);
            const openPdfButton = activity.pdf_url ?
                `<a class="btn btn-muted" href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener">เปิด PDF</a>` :
                '';
            const downloadPdfButton = activity.pdf_url ?
                `<a class="btn btn-muted" href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener" download>ดาวน์โหลด PDF</a>` :
                '';

            return `
        <article class="activity-card">
            <div class="activity-cover">${cover}</div>
            <div class="activity-body">
                <p class="card-meta">${escapeHtml(categoryName)}${activity.activity_date ? ` • ${formatDate(activity.activity_date)}` : ''}</p>
                <h3>${escapeHtml(activity.title || '-')}</h3>
                <p>${escapeHtml(shortDescription)}</p>
                <div class="inline-actions">
                    <button type="button" class="btn btn-primary" data-action="detail" data-id="${activity.id}">ดูรายละเอียด</button>
                    ${openPdfButton}
                    ${downloadPdfButton}
                </div>
            </div>
        </article>
    `;
        }

        async function openPublicDetail(id) {
            try {
                const response = await api(`/public/activities/${id}`);
                const activity = response.data;

                if (activity.cover_image_url) {
                    el.dialogImage.src = resolveAssetUrl(activity.cover_image_url);
                    el.dialogImage.alt = activity.title || '';
                    el.dialogImage.classList.remove('hidden');
                } else {
                    el.dialogImage.classList.add('hidden');
                    el.dialogImage.removeAttribute('src');
                    el.dialogImage.alt = '';
                }

                el.dialogTitle.textContent = activity.title || '-';
                el.dialogMeta.textContent = [activity.category?.name, activity.activity_date ? formatDate(activity
                        .activity_date) : null, activity.location]
                    .filter(Boolean)
                    .join(' • ');
                el.dialogDescription.textContent = activity.description || 'ไม่มีรายละเอียดเพิ่มเติม';

                if (activity.pdf_url) {
                    const pdfUrl = resolveAssetUrl(activity.pdf_url);
                    el.dialogOpenPdf.href = pdfUrl;
                    el.dialogOpenPdf.classList.remove('hidden');
                    el.dialogDownloadPdf.href = pdfUrl;
                    el.dialogDownloadPdf.classList.remove('hidden');
                } else {
                    el.dialogOpenPdf.classList.add('hidden');
                    el.dialogDownloadPdf.classList.add('hidden');
                }

                if (typeof el.dialog.showModal === 'function') {
                    el.dialog.showModal();
                } else {
                    el.dialog.setAttribute('open', 'open');
                }
            } catch (error) {
                showToast(errorToMessage(error), 'error');
            }
        }

        function closeDialog() {
            if (typeof el.dialog.close === 'function' && el.dialog.open) {
                el.dialog.close();
                return;
            }
            el.dialog.removeAttribute('open');
        }

        async function ensureAdminSession() {
            if (!state.admin.session?.token) {
                renderAdminLoggedOut();
                return;
            }

            try {
                const response = await api('/admin/profile', {
                    auth: true
                });
                state.admin.session.admin = response.data;
                saveAdminSession(state.admin.session);
                renderAdminLoggedIn();

                if (!state.admin.bootstrapped) {
                    await loadAdminData();
                    state.admin.bootstrapped = true;
                }
            } catch {
                clearAdminSession();
                renderAdminLoggedOut();
                showToast('Session หมดอายุ กรุณาเข้าสู่ระบบใหม่', 'error');
            }
        }

        function renderAdminLoggedOut() {
            el.adminAuthCard.classList.remove('hidden');
            el.adminDashboard.classList.add('hidden');
            el.adminLoginForm.reset();
        }

        function renderAdminLoggedIn() {
            const profile = state.admin.session?.admin;
            const profileText = profile ?
                `เข้าสู่ระบบเป็น ${profile.name} (${profile.email})` :
                'เข้าสู่ระบบสำเร็จ';

            el.adminProfileText.textContent = profileText;
            el.adminAuthCard.classList.add('hidden');
            el.adminDashboard.classList.remove('hidden');
        }

        async function loginAdmin() {
            const email = el.adminEmail.value.trim();
            const password = el.adminPassword.value;

            try {
                const response = await api('/admin/login', {
                    method: 'POST',
                    body: {
                        email,
                        password
                    },
                });

                state.admin.session = {
                    token: response.data.token,
                    admin: response.data.admin,
                };

                saveAdminSession(state.admin.session);
                state.admin.bootstrapped = false;

                renderAdminLoggedIn();
                await loadAdminData();
                state.admin.bootstrapped = true;

                el.adminLoginForm.reset();
                showToast('เข้าสู่ระบบสำเร็จ', 'success');
            } catch (error) {
                showToast(errorToMessage(error), 'error');
            }
        }

        async function logoutAdmin() {
            try {
                await api('/admin/logout', {
                    method: 'POST',
                    auth: true
                });
            } catch {
                // Ignore network/auth errors and clear local session anyway.
            }

            clearAdminSession();
            resetCategoryForm();
            resetActivityForm();
            renderAdminLoggedOut();
            showToast('ออกจากระบบแล้ว', 'info');
        }

        async function loadAdminData() {
            await loadAdminCategories();
            await loadAdminActivities();
        }

        async function loadAdminCategories() {
            try {
                const response = await api('/admin/categories', {
                    auth: true
                });
                state.admin.categories = response.data || [];
                renderAdminCategories();
                hydrateCategorySelects();
            } catch (error) {
                showToast(errorToMessage(error), 'error');
            }
        }

        function renderAdminCategories() {
            if (!state.admin.categories.length) {
                el.categoryList.innerHTML = `
            <tr>
                <td colspan="3" class="table-empty">ยังไม่มีหมวดหมู่</td>
            </tr>
        `;
                return;
            }

            el.categoryList.innerHTML = state.admin.categories
                .map((category) => {
                    const status = Number(category.status) === 1;

                    return `
                <tr>
                    <td>${escapeHtml(category.name)}</td>
                    <td><span class="pill ${status ? 'pill-on' : 'pill-off'}">${status ? 'เปิดใช้งาน' : 'ปิดใช้งาน'}</span></td>
                    <td class="table-actions">
                        <button type="button" class="btn btn-muted btn-sm" data-action="edit" data-id="${category.id}">แก้ไข</button>
                        <button type="button" class="btn btn-danger btn-sm" data-action="delete" data-id="${category.id}">ลบ</button>
                    </td>
                </tr>
            `;
                })
                .join('');
        }

        function hydrateCategorySelects() {
            const allCategories = state.admin.categories || [];
            const activitySelected = el.activityCategory.value;
            const filterSelected = state.admin.filters.category_id || '';

            const activityOptions = allCategories
                .map((category) => `<option value="${category.id}">${escapeHtml(category.name)}</option>`)
                .join('');
            el.activityCategory.innerHTML = `<option value="">เลือกหมวดหมู่</option>${activityOptions}`;
            el.activityCategory.value = activitySelected || '';

            const filterOptions = allCategories
                .map((category) => `<option value="${category.id}">${escapeHtml(category.name)}</option>`)
                .join('');
            el.adminActivityFilterCategory.innerHTML = `<option value="">ทั้งหมด</option>${filterOptions}`;
            el.adminActivityFilterCategory.value = filterSelected;
        }

        function editCategory(id) {
            const category = state.admin.categories.find((item) => String(item.id) === String(id));
            if (!category) {
                return;
            }

            el.categoryId.value = category.id;
            el.categoryName.value = category.name || '';
            el.categoryStatus.checked = Number(category.status) === 1;
            el.categorySubmit.textContent = 'บันทึกการแก้ไข';
            el.categoryCancel.classList.remove('hidden');
            el.categoryName.focus();
        }

        function resetCategoryForm() {
            el.adminCategoryForm.reset();
            el.categoryId.value = '';
            el.categoryStatus.checked = true;
            el.categorySubmit.textContent = 'เพิ่มหมวดหมู่';
            el.categoryCancel.classList.add('hidden');
        }

        async function saveCategory() {
            const id = el.categoryId.value;
            const payload = {
                name: el.categoryName.value.trim(),
                status: el.categoryStatus.checked ? 1 : 0,
            };

            if (!payload.name) {
                showToast('กรุณาระบุชื่อหมวดหมู่', 'error');
                return;
            }

            try {
                if (id) {
                    await api(`/admin/categories/${id}`, {
                        method: 'PUT',
                        auth: true,
                        body: payload,
                    });
                    showToast('อัปเดตหมวดหมู่แล้ว', 'success');
                } else {
                    await api('/admin/categories', {
                        method: 'POST',
                        auth: true,
                        body: payload,
                    });
                    showToast('เพิ่มหมวดหมู่แล้ว', 'success');
                }

                resetCategoryForm();
                await loadAdminCategories();
            } catch (error) {
                showToast(errorToMessage(error), 'error');
            }
        }

        async function deleteCategory(id) {
            const category = state.admin.categories.find((item) => String(item.id) === String(id));
            const categoryName = category?.name || 'หมวดหมู่นี้';

            const confirmed = window.confirm(`ยืนยันการลบ "${categoryName}" ?`);
            if (!confirmed) {
                return;
            }

            try {
                await api(`/admin/categories/${id}`, {
                    method: 'DELETE',
                    auth: true,
                });
                await loadAdminCategories();
                showToast('ลบหมวดหมู่แล้ว', 'success');
            } catch (error) {
                showToast(errorToMessage(error), 'error');
            }
        }

        async function loadAdminActivities() {
            try {
                const query = buildQuery(state.admin.filters);
                const response = await api(`/admin/activities${query}`, {
                    auth: true
                });
                state.admin.activities = response.data || [];
                state.admin.meta = response.meta || {
                    ...defaultMeta,
                    per_page: state.admin.filters.per_page
                };
                renderAdminActivities();
            } catch (error) {
                showToast(errorToMessage(error), 'error');
            }
        }

        function renderAdminActivities() {
            const list = state.admin.activities;

            if (!list.length) {
                el.adminActivityList.innerHTML = `
            <tr>
                <td colspan="6" class="table-empty">ยังไม่พบกิจกรรม</td>
            </tr>
        `;
            } else {
                el.adminActivityList.innerHTML = list
                    .map((activity) => {
                        const status = Number(activity.status) === 1;
                        const files = [
                                activity.cover_image_url ?
                                `<a href="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" target="_blank" rel="noopener">รูปปก</a>` :
                                null,
                                activity.pdf_url ?
                                `<a href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener">PDF</a>` :
                                null,
                            ]
                            .filter(Boolean)
                            .join(' • ');

                        return `
                    <tr>
                        <td>
                            <strong>${escapeHtml(activity.title || '-')}</strong>
                            <p class="cell-sub">${escapeHtml(activity.location || '')}</p>
                        </td>
                        <td>${escapeHtml(activity.category?.name || '-')}</td>
                        <td>${activity.activity_date ? formatDate(activity.activity_date) : '-'}</td>
                        <td><span class="pill ${status ? 'pill-on' : 'pill-off'}">${status ? 'แสดงผล' : 'ปิด'}</span></td>
                        <td>${files || '-'}</td>
                        <td class="table-actions">
                            <button type="button" class="btn btn-muted btn-sm" data-action="edit" data-id="${activity.id}">แก้ไข</button>
                            <button type="button" class="btn btn-danger btn-sm" data-action="delete" data-id="${activity.id}">ลบ</button>
                        </td>
                    </tr>
                `;
                    })
                    .join('');
            }

            el.adminActivityPage.textContent =
                `หน้า ${state.admin.meta.current_page ?? 1} / ${state.admin.meta.last_page ?? 1}`;
            el.adminActivityPrev.disabled = (state.admin.meta.current_page ?? 1) <= 1;
            el.adminActivityNext.disabled = (state.admin.meta.current_page ?? 1) >= (state.admin.meta.last_page ?? 1);
        }

        async function saveActivity() {
            const id = el.activityId.value;
            const formData = new FormData(el.adminActivityForm);
            formData.set('status', el.activityStatus.checked ? '1' : '0');

            if (!el.activityCover.files.length) {
                formData.delete('cover_image');
            }
            if (!el.activityPdf.files.length) {
                formData.delete('pdf_file');
            }

            try {
                if (id) {
                    formData.append('_method', 'PUT');
                    await api(`/admin/activities/${id}`, {
                        method: 'POST',
                        auth: true,
                        body: formData,
                    });
                    showToast('อัปเดตกิจกรรมแล้ว', 'success');
                } else {
                    await api('/admin/activities', {
                        method: 'POST',
                        auth: true,
                        body: formData,
                    });
                    showToast('เพิ่มกิจกรรมแล้ว', 'success');
                }

                resetActivityForm();
                await loadAdminActivities();
            } catch (error) {
                showToast(errorToMessage(error), 'error');
            }
        }

        async function editActivity(id) {
            try {
                const response = await api(`/admin/activities/${id}`, {
                    auth: true
                });
                const activity = response.data;

                el.activityId.value = activity.id;
                el.activityTitle.value = activity.title || '';
                el.activityCategory.value = activity.category_id || '';
                el.activityDate.value = activity.activity_date || '';
                el.activityLocation.value = activity.location || '';
                el.activityDescription.value = activity.description || '';
                el.activityStatus.checked = Number(activity.status) === 1;

                const links = [];
                if (activity.cover_image_url) {
                    links.push(
                        `<a href="${escapeAttr(resolveAssetUrl(activity.cover_image_url))}" target="_blank" rel="noopener">ดูรูปปกปัจจุบัน</a>`
                        );
                }
                if (activity.pdf_url) {
                    links.push(
                        `<a href="${escapeAttr(resolveAssetUrl(activity.pdf_url))}" target="_blank" rel="noopener">ดู PDF ปัจจุบัน</a>`
                        );
                }
                el.activityExistingAssets.innerHTML = links.join(' • ');

                el.activitySubmit.textContent = 'บันทึกการแก้ไข';
                el.activityCancel.classList.remove('hidden');

                el.adminActivityForm.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                });
            } catch (error) {
                showToast(errorToMessage(error), 'error');
            }
        }

        function resetActivityForm() {
            el.adminActivityForm.reset();
            el.activityId.value = '';
            el.activityStatus.checked = true;
            el.activityExistingAssets.innerHTML = '';
            el.activitySubmit.textContent = 'เพิ่มกิจกรรม';
            el.activityCancel.classList.add('hidden');
        }

        async function deleteActivity(id) {
            const target = state.admin.activities.find((item) => String(item.id) === String(id));
            const label = target?.title || 'กิจกรรมนี้';
            const confirmed = window.confirm(`ยืนยันการลบ "${label}" ?`);
            if (!confirmed) {
                return;
            }

            try {
                await api(`/admin/activities/${id}`, {
                    method: 'DELETE',
                    auth: true,
                });
                await loadAdminActivities();
                showToast('ลบกิจกรรมแล้ว', 'success');
            } catch (error) {
                showToast(errorToMessage(error), 'error');
            }
        }

        async function api(path, options = {}) {
            const {
                method = 'GET',
                    body = null,
                    auth = false,
            } = options;

            const headers = {
                Accept: 'application/json',
            };

            if (auth && state.admin.session?.token) {
                headers.Authorization = `Bearer ${state.admin.session.token}`;
            }

            let payload = body;

            if (body && !(body instanceof FormData)) {
                headers['Content-Type'] = 'application/json';
                payload = JSON.stringify(body);
            }

            const response = await fetch(`${API_PREFIX}${path}`, {
                method,
                headers,
                body: payload,
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || data.success === false) {
                const error = new Error(data.message || `Request failed (${response.status})`);
                error.status = response.status;
                error.errors = data.errors || null;
                throw error;
            }

            return data;
        }

        function buildQuery(params) {
            const search = new URLSearchParams();

            Object.entries(params).forEach(([key, value]) => {
                if (value === null || value === undefined || value === '') {
                    return;
                }
                search.set(key, String(value));
            });

            const query = search.toString();
            return query ? `?${query}` : '';
        }

        function setPublicLoading(isLoading) {
            if (isLoading) {
                el.publicSummary.textContent = 'กำลังโหลดข้อมูล...';
            }
        }

        function formatDate(value) {
            if (!value) {
                return '-';
            }

            const date = new Date(value);
            if (Number.isNaN(date.getTime())) {
                return value;
            }

            return new Intl.DateTimeFormat('th-TH', {
                dateStyle: 'medium',
            }).format(date);
        }

        function truncate(text, maxLength) {
            if (text.length <= maxLength) {
                return text;
            }

            return `${text.slice(0, maxLength).trim()}...`;
        }

        function escapeHtml(value) {
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function escapeAttr(value) {
            return escapeHtml(value);
        }

        function resolveAssetUrl(url) {
            return new URL(url, window.location.origin).toString();
        }

        function showToast(message, type = 'info') {
            if (!el.toast) {
                return;
            }

            el.toast.textContent = message;
            el.toast.className = `toast ${type}`;
            window.clearTimeout(showToast.timeout);
            showToast.timeout = window.setTimeout(() => {
                el.toast.className = 'toast hidden';
            }, 2800);
        }

        function errorToMessage(error) {
            if (error?.errors && typeof error.errors === 'object') {
                const firstField = Object.keys(error.errors)[0];
                if (firstField && Array.isArray(error.errors[firstField])) {
                    return error.errors[firstField][0];
                }
            }

            return error?.message || 'เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ';
        }

        function loadAdminSession() {
            try {
                const raw = localStorage.getItem(ADMIN_SESSION_KEY);
                return raw ? JSON.parse(raw) : null;
            } catch {
                return null;
            }
        }

        function saveAdminSession(session) {
            localStorage.setItem(ADMIN_SESSION_KEY, JSON.stringify(session));
        }

        function clearAdminSession() {
            state.admin.session = null;
            state.admin.bootstrapped = false;
            localStorage.removeItem(ADMIN_SESSION_KEY);
        }
    </script>
</body>

</html>
