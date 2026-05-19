<x-admin.layouts.app>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 0.25rem;">กิจกรรมทั้งหมด</h2>
            <p style="color: var(--text-muted);">จัดการกิจกรรมของมหาวิทยาลัย</p>
        </div>
        <button class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            สร้างกิจกรรมใหม่
        </button>
    </div>

    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <input type="text" placeholder="ค้นหากิจกรรม..." style="width: 100%; padding: 0.625rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 14px;">
            </div>
            <select style="padding: 0.625rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 14px; background: var(--surface);">
                <option>ทุกหมวดหมู่</option>
                <option>การศึกษา</option>
                <option>กีฬา</option>
                <option>อาสา</option>
                <option>พัฒนาทักษะ</option>
            </select>
            <select style="padding: 0.625rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 14px; background: var(--surface);">
                <option>ทุกสถานะ</option>
                <option>รอดำเนินการ</option>
                <option>กำลังดำเนิน</option>
                <option>เสร็จสิ้น</option>
            </select>
            <button class="btn btn-secondary">
                <i class="fa-solid fa-filter"></i>
                กรอง
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="padding: 0;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;">
                        </th>
                        <th>ชื่อกิจกรรม</th>
                        <th>หมวดหมู่</th>
                        <th>วันที่</th>
                        <th>สถานที่</th>
                        <th>ผู้เข้าร่วม</th>
                        <th>สถานะ</th>
                        <th style="width: 100px;">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">อ</div>
                                <div>
                                    <p style="font-weight: 600; margin-bottom: 2px;">อบรมเทคโนโลยีสารสนเทศ</p>
                                    <p style="font-size: 12px; color: var(--text-muted);">สร้างเมื่อ 10 พ.ค. 2569</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-primary">การศึกษา</span></td>
                        <td>13 พ.ค. 2569</td>
                        <td>ห้องปฏิบัติการคอมพิวเตอร์</td>
                        <td><span style="font-weight: 600;">45</span> / 50</td>
                        <td><span class="badge badge-success">เสร็จสิ้น</span></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem; color: var(--danger);">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, #f093fb, #f5576c); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">ก</div>
                                <div>
                                    <p style="font-weight: 600; margin-bottom: 2px;">กีฬาสีภาคต้น</p>
                                    <p style="font-size: 12px; color: var(--text-muted);">สร้างเมื่อ 8 พ.ค. 2569</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-success">กีฬา</span></td>
                        <td>14 พ.ค. 2569</td>
                        <td>สนามกีฬากลาง</td>
                        <td><span style="font-weight: 600;">120</span> / 200</td>
                        <td><span class="badge badge-primary">กำลังดำเนิน</span></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem; color: var(--danger);">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, #4facfe, #00f2fe); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">อ</div>
                                <div>
                                    <p style="font-weight: 600; margin-bottom: 2px;">อาสาสมัครบริการชุมชน</p>
                                    <p style="font-size: 12px; color: var(--text-muted);">สร้างเมื่อ 5 พ.ค. 2569</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-warning">อาสา</span></td>
                        <td>15 พ.ค. 2569</td>
                        <td>ชุมชนวัดสว่าง</td>
                        <td><span style="font-weight: 600;">30</span> / 40</td>
                        <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem; color: var(--danger);">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, #fa709a, #fee140); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">ส</div>
                                <div>
                                    <p style="font-weight: 600; margin-bottom: 2px;">สัมมนาพัฒนาทักษะ</p>
                                    <p style="font-size: 12px; color: var(--text-muted);">สร้างเมื่อ 1 พ.ค. 2569</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-danger">พัฒนาทักษะ</span></td>
                        <td>20 พ.ค. 2569</td>
                        <td>ห้องประชุมใหญ่</td>
                        <td><span style="font-weight: 600;">0</span> / 100</td>
                        <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem; color: var(--danger);">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;"></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, #a8edea, #fed6e3); display: flex; align-items: center; justify-content: color: white; font-weight: 700; color: #333;">ว</div>
                                <div>
                                    <p style="font-weight: 600; margin-bottom: 2px;">วิทยาศาสตร์สำหรับเด็ก</p>
                                    <p style="font-size: 12px; color: var(--text-muted);">สร้างเมื่อ 28 เม.ย. 2569</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-primary">การศึกษา</span></td>
                        <td>25 เม.ย. 2569</td>
                        <td>พิพิธภัณฑ์วิทยา</td>
                        <td><span style="font-weight: 600;">60</span> / 60</td>
                        <td><span class="badge badge-success">เสร็จสิ้น</span></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem;">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" style="padding: 0.375rem; color: var(--danger);">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
        <p style="color: var(--text-muted); font-size: 14px;">แสดง 1-5 จาก 24 รายการ</p>
        <div style="display: flex; gap: 0.5rem;">
            <button class="btn btn-sm btn-secondary" disabled>ก่อนหน้า</button>
            <button class="btn btn-sm btn-primary">1</button>
            <button class="btn btn-sm btn-secondary">2</button>
            <button class="btn btn-sm btn-secondary">3</button>
            <button class="btn btn-sm btn-secondary">4</button>
            <button class="btn btn-sm btn-secondary">5</button>
            <button class="btn btn-sm btn-secondary">ถัดไป</button>
        </div>
    </div>
</x-admin.layouts.app>