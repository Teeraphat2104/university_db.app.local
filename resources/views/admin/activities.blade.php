@extends('layouts.app')

@section('title', 'กิจกรรมทั้งหมด - Admin')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
    <div>
        <h2 style="font-size:24px;font-weight:700;margin-bottom:0.25rem">กิจกรรมทั้งหมด</h2>
        <p style="color:var(--text-muted)">จัดการกิจกรรมของมหาวิทยาลัย</p>
    </div>
    <button class="btn btn-primary">
        <i class="fa-solid fa-plus"></i>
        สร้างกิจกรรมใหม่
    </button>
</div>

<div class="card" style="margin-bottom:1.5rem">
    <div class="card-body" style="display:flex;gap:1rem;align-items:center;">
        <div style="flex:1;min-width:200px">
            <input type="text" id="filter-keyword" placeholder="ค้นหากิจกรรม..." style="width:100%">
        </div>
        <select id="filter-category" style="padding:0.625rem 1rem;border:1px solid var(--border);border-radius:var(--radius);font-size:14px;background:var(--surface);width:20%">
            <option value="">ทุกหมวดหมู่</option>
        </select>
        <select id="filter-status" style="padding:0.625rem 1rem;border:1px solid var(--border);border-radius:var(--radius);font-size:14px;background:var(--surface);width:20%">
            <option value="">ทุกสถานะ</option>
            <option value="1">เปิดใช้งาน</option>
            <option value="0">ปิดใช้งาน</option>
        </select>
        <button class="btn btn-secondary" onclick="applyFilters()">
            <i class="fa-solid fa-filter"></i>
            กรอง
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        <table class="data-table" id="activities-table">
            <thead>
                <tr>
                    <th style="width:40px"><input type="checkbox" id="select-all" style="width:18px;height:18px;cursor:pointer"></th>
                    <th>ชื่อกิจกรรม</th>
                    <th>หมวดหมู่</th>
                    <th>วันที่</th>
                    <th>สถานที่</th>
                    <th>ผู้เข้าร่วม</th>
                    <th>สถานะ</th>
                    <th style="width:100px">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody id="activities-tbody">
                <tr>
                    <td colspan="8" style="text-align:center;padding:3rem;color:var(--text-muted)">
                        <i class="fa-solid fa-spinner fa-spin" style="font-size:1.5rem;display:block;margin-bottom:0.75rem"></i>
                        กำลังโหลด...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="pagination-wrap" style="display:flex;justify-content:space-between;align-items:center;margin-top:1.5rem">
    <p id="pagination-info" style="color:var(--text-muted);font-size:14px"></p>
    <div id="pagination-btns" style="display:flex;gap:0.5rem"></div>
</div>
@endsection

@section('script')
<script>
var API = '/api/admin/activities';
var CAT_API = '/api/admin/categories';
var token = localStorage.getItem('admin_token');
var currentPage = 1;
var lastPage = 1;

function getHeaders() {
    return {
        'Authorization': 'Bearer ' + token,
        'Accept': 'application/json'
    };
}

$(function () {
    if (!token) {
        $('#activities-tbody').html('<tr><td colspan="8" style="text-align:center;padding:3rem;color:var(--text-muted)">กรุณา <a href="/login" style="color:var(--primary)">เข้าสู่ระบบ</a> ก่อน</td></tr>');
        return;
    }
    loadCategories();
    loadActivities(1);
});

function loadCategories() {
    $.ajax({
        url: CAT_API,
        method: 'GET',
        headers: getHeaders(),
        success: function (json) {
            var sel = $('#filter-category');
            if (json.data) {
                $.each(json.data, function (i, cat) {
                    sel.append('<option value="' + cat.id + '">' + $('<span>').text(cat.name).html() + '</option>');
                });
            }
        }
    });
}

function applyFilters() {
    currentPage = 1;
    loadActivities(1);
}

function loadActivities(page) {
    var keyword = $('#filter-keyword').val();
    var categoryId = $('#filter-category').val();
    var status = $('#filter-status').val();
    var params = { page: page, per_page: 10 };

    if (keyword) params.keyword = keyword;
    if (categoryId) params.category_id = categoryId;
    if (status !== '') params.status = status;

    $.ajax({
        url: API,
        method: 'GET',
        headers: getHeaders(),
        data: params,
        success: function (json) {
            var tbody = $('#activities-tbody');
            tbody.empty();

            if (!json.data || json.data.length === 0) {
                tbody.html('<tr><td colspan="8" style="text-align:center;padding:3rem;color:var(--text-muted)">ไม่พบกิจกรรม</td></tr>');
                return;
            }

            $.each(json.data, function (i, act) {
                var dateStr = act.activity_date || '-';
                var catName = act.category ? act.category.name : '-';
                var statusHtml = act.status
                    ? '<span class="badge badge-success">เปิดใช้งาน</span>'
                    : '<span class="badge badge-warning">ปิดใช้งาน</span>';

                var initial = $('<span>').text(act.title).html().charAt(0).toUpperCase();
                var titleSafe = $('<span>').text(act.title).html();
                var catSafe = $('<span>').text(catName).html();

                var row = '<tr>' +
                    '<td><input type="checkbox" class="row-check" style="width:18px;height:18px;cursor:pointer"></td>' +
                    '<td>' +
                        '<div style="display:flex;align-items:center;gap:1rem">' +
                            '<div style="width:48px;height:48px;border-radius:var(--radius);background:linear-gradient(135deg,#667eea,#764ba2);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;flex-shrink:0">' + initial + '</div>' +
                            '<div><p style="font-weight:600;margin-bottom:2px">' + titleSafe + '</p></div>' +
                        '</div>' +
                    '</td>' +
                    '<td><span class="badge badge-primary">' + catSafe + '</span></td>' +
                    '<td>' + dateStr + '</td>' +
                    '<td>' + (act.location || '-') + '</td>' +
                    '<td><span style="font-weight:600">' + (act.participants_count || 0) + '</span></td>' +
                    '<td>' + statusHtml + '</td>' +
                    '<td>' +
                        '<div style="display:flex;gap:0.5rem">' +
                            '<button class="btn btn-sm btn-secondary" onclick="viewActivity(' + act.id + ')" style="padding:0.375rem"><i class="fa-regular fa-eye"></i></button>' +
                            '<button class="btn btn-sm btn-secondary" style="padding:0.375rem"><i class="fa-regular fa-pen-to-square"></i></button>' +
                            '<button class="btn btn-sm btn-secondary" onclick="deleteActivity(' + act.id + ')" style="padding:0.375rem;color:var(--danger)"><i class="fa-regular fa-trash-can"></i></button>' +
                        '</div>' +
                    '</td>' +
                '</tr>';

                tbody.append(row);
            });

            if (json.meta) {
                currentPage = json.meta.current_page;
                lastPage = json.meta.last_page;
                updatePagination(json.meta);
            }
        },
        error: function (xhr) {
            if (xhr.status === 401) {
                $('#activities-tbody').html('<tr><td colspan="8" style="text-align:center;padding:3rem;color:var(--text-muted)">เซสชันหมดอายุ กรุณา <a href="/login" style="color:var(--primary)">เข้าสู่ระบบ</a> อีกครั้ง</td></tr>');
            } else {
                $('#activities-tbody').html('<tr><td colspan="8" style="text-align:center;padding:3rem;color:var(--danger)">เกิดข้อผิดพลาดในการโหลดข้อมูล</td></tr>');
            }
        }
    });
}

function updatePagination(meta) {
    var info = 'แสดง ' + ((meta.current_page - 1) * meta.per_page + 1) + '-' + Math.min(meta.current_page * meta.per_page, meta.total) + ' จาก ' + meta.total + ' รายการ';
    $('#pagination-info').text(info);

    var btns = $('#pagination-btns');
    btns.empty();

    var prevBtn = $('<button class="btn btn-sm btn-secondary">').text('ก่อนหน้า');
    if (meta.current_page <= 1) prevBtn.prop('disabled', true);
    prevBtn.on('click', function () { if (meta.current_page > 1) loadActivities(meta.current_page - 1); });
    btns.append(prevBtn);

    for (var p = 1; p <= meta.last_page; p++) {
        (function (page) {
            var btn = $('<button class="btn btn-sm ' + (page === meta.current_page ? 'btn-primary' : 'btn-secondary') + '">').text(page);
            btn.on('click', function () { loadActivities(page); });
            btns.append(btn);
        })(p);
    }

    var nextBtn = $('<button class="btn btn-sm btn-secondary">').text('ถัดไป');
    if (meta.current_page >= meta.last_page) nextBtn.prop('disabled', true);
    nextBtn.on('click', function () { if (meta.current_page < meta.last_page) loadActivities(meta.current_page + 1); });
    btns.append(nextBtn);
}

function viewActivity(id) {
    window.location.href = '/admin/activities/' + id;
}

function deleteActivity(id) {
    if (!confirm('คุณแน่ใจหรือไม่ที่จะลบกิจกรรมนี้?')) return;

    $.ajax({
        url: API + '/' + id,
        method: 'DELETE',
        headers: getHeaders(),
        success: function () {
            loadActivities(currentPage);
            showToast('ลบกิจกรรมสำเร็จ', 'success');
        },
        error: function (xhr) {
            var msg = 'เกิดข้อผิดพลาด';
            try { msg = JSON.parse(xhr.responseText).message || msg; } catch (e) {}
            showToast(msg, 'error');
        }
    });
}

function showToast(msg, type) {
    $('.toast').remove();
    var toast = $('<div class="toast ' + (type || 'info') + '">').text(msg);
    $('body').append(toast);
    setTimeout(function () { toast.fadeOut(300, function () { $(this).remove(); }); }, 3000);
}
</script>
@endsection