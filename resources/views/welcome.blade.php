<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'University Activities') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700&family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                            <input id="admin-email" name="email" type="email" required autocomplete="email" placeholder="admin@example.com">
                        </label>
                        <label class="field" for="admin-password">
                            <span>รหัสผ่าน</span>
                            <input id="admin-password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••">
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
                                <button id="category-submit" type="submit" class="btn btn-primary">เพิ่มหมวดหมู่</button>
                                <button id="category-cancel" type="button" class="btn btn-muted hidden">ยกเลิกแก้ไข</button>
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
                                <button id="admin-activity-search" type="button" class="btn btn-primary">ค้นหา</button>
                                <button id="admin-activity-reset" type="button" class="btn btn-muted">ล้างตัวกรอง</button>
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
                                <input id="activity-location" name="location" type="text" maxlength="500" placeholder="เช่น อาคารเรียนรวม">
                            </label>

                            <label class="field field-full" for="activity-description">
                                <span>รายละเอียด</span>
                                <textarea id="activity-description" name="description" rows="4" placeholder="รายละเอียดกิจกรรม..."></textarea>
                            </label>

                            <label class="field" for="activity-cover">
                                <span>รูปปก (JPG/PNG/WEBP ไม่เกิน 5MB)</span>
                                <input id="activity-cover" name="cover_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/*">
                            </label>

                            <label class="field" for="activity-pdf">
                                <span>ไฟล์ PDF (ไม่เกิน 20MB)</span>
                                <input id="activity-pdf" name="pdf_file" type="file" accept=".pdf,application/pdf">
                            </label>

                            <label class="check-field" for="activity-status">
                                <input id="activity-status" name="status" type="checkbox" checked>
                                <span>เปิดเผยกิจกรรม</span>
                            </label>

                            <div id="activity-existing-assets" class="asset-links field-full"></div>

                            <div class="inline-actions field-full">
                                <button id="activity-submit" type="submit" class="btn btn-primary">เพิ่มกิจกรรม</button>
                                <button id="activity-cancel" type="button" class="btn btn-muted hidden">ยกเลิกแก้ไข</button>
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
                <a id="dialog-download-pdf" class="btn btn-muted hidden" target="_blank" rel="noopener" download>ดาวน์โหลด PDF</a>
            </div>
        </article>
    </dialog>

    <div id="toast" class="toast hidden" role="status" aria-live="polite"></div>
</body>
</html>
