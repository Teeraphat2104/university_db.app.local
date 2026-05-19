<x-admin.layouts.app>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon primary">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <span class="stat-trend up">
                    <i class="fa-solid fa-arrow-up"></i>
                    12%
                </span>
            </div>
            <p class="stat-value">24</p>
            <p class="stat-label">กิจกรรมทั้งหมด</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon success">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="stat-trend up">
                    <i class="fa-solid fa-arrow-up"></i>
                    8%
                </span>
            </div>
            <p class="stat-value">1,234</p>
            <p class="stat-label">นักศึกษาทั้งหมด</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon warning">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
            </div>
            <p class="stat-value">856</p>
            <p class="stat-label">ผู้เข้าร่วม</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon danger">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <span class="stat-trend down">
                    <i class="fa-solid fa-arrow-down"></i>
                    2%
                </span>
            </div>
            <p class="stat-value">3</p>
            <p class="stat-label">กิจกรรมวันนี้</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">กิจกรรมล่าสุด</h3>
                <a href="/admin/activities" class="btn btn-sm btn-secondary">ดูทั้งหมด</a>
            </div>
            <div class="card-body" style="padding: 0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ชื่อกิจกรรม</th>
                            <th>วันที่</th>
                            <th>ผู้เข้าร่วม</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p style="font-weight: 600;">อบรมเทคโนโลยีสารสนเทศ</p>
                                <p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: การศึกษา</p>
                            </td>
                            <td>13 พ.ค. 2569</td>
                            <td>45 คน</td>
                            <td><span class="badge badge-success">เสร็จสิ้น</span></td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-weight: 600;">กีฬาสีภาคต้น</p>
                                <p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: กีฬา</p>
                            </td>
                            <td>14 พ.ค. 2569</td>
                            <td>120 คน</td>
                            <td><span class="badge badge-primary">กำลังดำเนิน</span></td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-weight: 600;">อาสาสมัครบริการชุมชน</p>
                                <p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: อาสา</p>
                            </td>
                            <td>15 พ.ค. 2569</td>
                            <td>30 คน</td>
                            <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-weight: 600;">สัมมนาพัฒนาทักษะ</p>
                                <p style="font-size: 12px; color: var(--text-muted);">หมวดหมู่: พัฒนาทักษะ</p>
                            </td>
                            <td>20 พ.ค. 2569</td>
                            <td>0 คน</td>
                            <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">หมวดหมู่</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #EEF2FF; border-radius: var(--radius);">
                        <span style="font-weight: 600; color: var(--primary);">การศึกษา</span>
                        <span style="font-weight: 700; color: var(--primary);">8</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #DCFCE7; border-radius: var(--radius);">
                        <span style="font-weight: 600; color: var(--success);">กีฬา</span>
                        <span style="font-weight: 700; color: var(--success);">5</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #FEF3C7; border-radius: var(--radius);">
                        <span style="font-weight: 600; color: #B45309;">อาสา</span>
                        <span style="font-weight: 700; color: #B45309;">4</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #FEE2E2; border-radius: var(--radius);">
                        <span style="font-weight: 600; color: var(--danger);">พัฒนาทักษะ</span>
                        <span style="font-weight: 700; color: var(--danger);">3</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ผู้เข้าร่วมมากที่สุด (Top 5)</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">1</div>
                        <div style="flex: 1;">
                            <p style="font-weight: 600;">สมชาย ใจดี</p>
                            <p style="font-size: 12px; color: var(--text-muted);">ภาควิชาวิทยาศาสตร์</p>
                        </div>
                        <span class="badge badge-success">12 กิจกรรม</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">2</div>
                        <div style="flex: 1;">
                            <p style="font-weight: 600;">สมศักดิ์ รักเรียน</p>
                            <p style="font-size: 12px; color: var(--text-muted);">ภาควิชาวิศวกรรม</p>
                        </div>
                        <span class="badge badge-success">10 กิจกรรม</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">3</div>
                        <div style="flex: 1;">
                            <p style="font-weight: 600;">สมหญิง สุขใส</p>
                            <p style="font-size: 12px; color: var(--text-muted);">ภาควิชาบริหาร</p>
                        </div>
                        <span class="badge badge-success">8 กิจกรรม</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">การดำเนินการ</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="/admin/activities/create" class="btn btn-primary" style="justify-content: flex-start;">
                        <i class="fa-solid fa-plus"></i>
                        สร้างกิจกรรมใหม่
                    </a>
                    <a href="/admin/participants/import" class="btn btn-secondary" style="justify-content: flex-start;">
                        <i class="fa-solid fa-upload"></i>
                        นำเข้าข้อมูลผู้เข้าร่วม
                    </a>
                    <a href="/admin/reports/export" class="btn btn-secondary" style="justify-content: flex-start;">
                        <i class="fa-solid fa-file-export"></i>
                        ส่งออกรายงาน
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin.layouts.app>
