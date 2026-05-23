@extends('layouts.app')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-title">Dashboard</h2>
        <p class="page-subtitle">ภาพรวมของระบบ</p>
    </div>
    <span class="text-sm text-gray-400"><i class="fa-regular fa-calendar mr-1"></i><span id="current-date"></span></span>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon primary"><i class="fa-regular fa-calendar-check"></i></div>
        </div>
        <p class="stat-value">24</p>
        <p class="stat-label">กิจกรรมทั้งหมด</p>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon success"><i class="fa-solid fa-users"></i></div>
        </div>
        <p class="stat-value">1,234</p>
        <p class="stat-label">นักศึกษาทั้งหมด</p>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon warning"><i class="fa-solid fa-user-plus"></i></div>
        </div>
        <p class="stat-value">856</p>
        <p class="stat-label">ผู้เข้าร่วม</p>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon danger"><i class="fa-regular fa-calendar"></i></div>
        </div>
        <p class="stat-value">3</p>
        <p class="stat-label">กิจกรรมวันนี้</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-5 mb-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">กิจกรรมล่าสุด</h3>
            <a href="/admin/activities" class="btn btn-sm btn-secondary">ดูทั้งหมด</a>
        </div>
        <div class="card-body p-0">
            <table class="data-table">
                <thead>
                    <tr><th>ชื่อกิจกรรม</th><th>วันที่</th><th>ผู้เข้าร่วม</th><th>สถานะ</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td><p class="font-semibold">อบรมเทคโนโลยีสารสนเทศ</p><p class="text-xs text-gray-400">หมวดหมู่: การศึกษา</p></td>
                        <td>13 พ.ค. 2569</td><td>45 คน</td>
                        <td><span class="badge badge-success">เสร็จสิ้น</span></td>
                    </tr>
                    <tr>
                        <td><p class="font-semibold">กีฬาสีภาคต้น</p><p class="text-xs text-gray-400">หมวดหมู่: กีฬา</p></td>
                        <td>14 พ.ค. 2569</td><td>120 คน</td>
                        <td><span class="badge badge-primary">กำลังดำเนิน</span></td>
                    </tr>
                    <tr>
                        <td><p class="font-semibold">อาสาสมัครบริการชุมชน</p><p class="text-xs text-gray-400">หมวดหมู่: อาสา</p></td>
                        <td>15 พ.ค. 2569</td><td>30 คน</td>
                        <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                    </tr>
                    <tr>
                        <td><p class="font-semibold">สัมมนาพัฒนาทักษะ</p><p class="text-xs text-gray-400">หมวดหมู่: พัฒนาทักษะ</p></td>
                        <td>20 พ.ค. 2569</td><td>0 คน</td>
                        <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><h3 class="card-title">หมวดหมู่</h3></div>
        <div class="card-body flex flex-col gap-3">
            <div class="flex items-center justify-between px-3 py-2 rounded-lg bg-indigo-50"><span class="font-semibold text-indigo-600">การศึกษา</span><span class="font-bold text-indigo-600">8</span></div>
            <div class="flex items-center justify-between px-3 py-2 rounded-lg bg-emerald-50"><span class="font-semibold text-emerald-600">กีฬา</span><span class="font-bold text-emerald-600">5</span></div>
            <div class="flex items-center justify-between px-3 py-2 rounded-lg bg-amber-50"><span class="font-semibold text-amber-600">อาสา</span><span class="font-bold text-amber-600">4</span></div>
            <div class="flex items-center justify-between px-3 py-2 rounded-lg bg-red-50"><span class="font-semibold text-red-600">พัฒนาทักษะ</span><span class="font-bold text-red-600">3</span></div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    <div class="card">
        <div class="card-header"><h3 class="card-title">ผู้เข้าร่วมมากที่สุด (Top 5)</h3></div>
        <div class="card-body flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                <div class="flex-1"><p class="font-semibold">สมชาย ใจดี</p><p class="text-xs text-gray-400">ภาควิชาวิทยาศาสตร์</p></div>
                <span class="badge badge-success">12 กิจกรรม</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                <div class="flex-1"><p class="font-semibold">สมศักดิ์ รักเรียน</p><p class="text-xs text-gray-400">ภาควิชาวิศวกรรม</p></div>
                <span class="badge badge-success">10 กิจกรรม</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                <div class="flex-1"><p class="font-semibold">สมหญิง สุขใส</p><p class="text-xs text-gray-400">ภาควิชาบริหาร</p></div>
                <span class="badge badge-success">8 กิจกรรม</span>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><h3 class="card-title">การดำเนินการ</h3></div>
        <div class="card-body flex flex-col gap-3">
            <a href="/admin/activities/create" class="btn btn-primary justify-start"><i class="fa-solid fa-plus"></i> สร้างกิจกรรมใหม่</a>
            <a href="/admin/participants/import" class="btn btn-secondary justify-start"><i class="fa-solid fa-upload"></i> นำเข้าข้อมูลผู้เข้าร่วม</a>
            <a href="/admin/reports/export" class="btn btn-secondary justify-start"><i class="fa-solid fa-file-export"></i> ส่งออกรายงาน</a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(function() {
    var d = new Date();
    var months = ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
    var days = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
    $('#current-date').text(days[d.getDay()] + 'ที่ ' + d.getDate() + ' ' + months[d.getMonth()] + ' ' + (d.getFullYear()+543));
});
</script>
@endsection
