@extends('layouts.app')

@section('title', 'กิจกรรมทั้งหมด - Admin')

@section('content')
<header class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">กิจกรรมทั้งหมด</h1>
    </div>
    <div class="topbar-right">
        <button class="topbar-btn" onclick="location.reload()"><i class="fa-regular fa-rotate"></i></button>
    </div>
</header>

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
    <div class="card-body" style="display:flex;gap:1rem;align-items:center;flex-wrap:wrap">
        <div style="flex:1;min-width:200px">
            <input type="text" id="filter-keyword" placeholder="ค้นหากิจกรรม..." style="width:100%">
        </div>
        <select id="filter-category" style="padding:0.625rem 1rem;border:1px solid var(--border);border-radius:var(--radius);font-size:14px;background:var(--surface);min-width:150px">
            <option value="">ทุกหมวดหมู่</option>
        </select>
        <select id="filter-status" style="padding:0.625rem 1rem;border:1px solid var(--border);border-radius:var(--radius);font-size:14px;background:var(--surface);min-width:130px">
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

<dialog id="view-modal" class="modal-lg">
    <div class="dialog-header">
        <h3 id="view-modal-title">รายละเอียดกิจกรรม</h3>
        <button type="button" class="btn btn-sm btn-muted" onclick="closeViewModal()" style="padding:0.375rem 0.5rem">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="dialog-body" id="view-modal-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
            <div id="view-cover-wrap" style="display:none">
                <img id="view-cover" src="" alt="cover" style="width:100%;border-radius:var(--radius-lg);max-height:300px;object-fit:cover">
            </div>
            <div style="grid-column:1/-1">
                <h3 id="view-title" style="font-size:1.25rem;font-weight:700;margin:0 0 0.75rem"></h3>
                <p id="view-desc" style="color:var(--text-secondary);line-height:1.6;margin:0 0 1rem;font-size:14px"></p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;font-size:14px">
                    <div><span style="color:var(--text-muted)">หมวดหมู่:</span> <span id="view-category" style="font-weight:600"></span></div>
                    <div><span style="color:var(--text-muted)">วันที่:</span> <span id="view-date" style="font-weight:600"></span></div>
                    <div><span style="color:var(--text-muted)">สถานที่:</span> <span id="view-location" style="font-weight:600"></span></div>
                    <div><span style="color:var(--text-muted)">ผู้เข้าร่วม:</span> <span id="view-participants" style="font-weight:600"></span></div>
                    <div><span style="color:var(--text-muted)">สถานะ:</span> <span id="view-status" style="font-weight:600"></span></div>
                </div>
            </div>
        </div>
        <div id="view-pdf-wrap" style="margin-top:1.5rem;display:none">
            <hr style="border:none;border-top:1px solid var(--border);margin-bottom:1rem">
            <p style="font-weight:700;margin:0 0 0.5rem"><i class="fa-solid fa-file-pdf" style="color:#DC2626"></i> เอกสาร PDF</p>
            <iframe id="view-pdf" src="" style="width:100%;height:500px;border:1px solid var(--border);border-radius:var(--radius-lg)"></iframe>
        </div>
    </div>
</dialog>

<dialog id="edit-modal" class="modal-lg">
    <form id="edit-form">
        <div class="dialog-header">
            <h3 id="edit-modal-title">แก้ไขกิจกรรม</h3>
            <button type="button" class="btn btn-sm btn-muted" onclick="closeEditModal()" style="padding:0.375rem 0.5rem">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="dialog-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <input type="hidden" id="edit-id">
            <div style="grid-column:1/-1">
                <label class="field-label">ชื่อกิจกรรม</label>
                <input type="text" id="edit-title" name="title" required placeholder="กรุณากรอกชื่อกิจกรรม">
            </div>
            <div>
                <label class="field-label">หมวดหมู่</label>
                <select id="edit-category-id" name="category_id" required>
                    <option value="">เลือกหมวดหมู่</option>
                </select>
            </div>
            <div>
                <label class="field-label">วันที่จัดกิจกรรม</label>
                <input type="date" id="edit-activity-date" name="activity_date">
            </div>
            <div style="grid-column:1/-1">
                <label class="field-label">สถานที่</label>
                <input type="text" id="edit-location" name="location" placeholder="กรุณากรอกสถานที่">
            </div>
            <div style="grid-column:1/-1">
                <label class="field-label">รายละเอียด</label>
                <textarea id="edit-description" name="description" rows="4" placeholder="กรุณากรอกรายละเอียด"></textarea>
            </div>
            <div>
                <label class="field-label">สถานะ</label>
                <select id="edit-status" name="status">
                    <option value="1">เปิดใช้งาน</option>
                    <option value="0">ปิดใช้งาน</option>
                </select>
            </div>
        </div>
        <div class="dialog-footer">
            <button type="button" class="btn btn-muted" onclick="closeEditModal()">ยกเลิก</button>
            <button type="submit" class="btn btn-primary" id="edit-submit-btn">บันทึก</button>
        </div>
    </form>
</dialog>

<div id="empty-state" class="empty-state" style="display:none">
    <i class="fa-regular fa-calendar"></i>
    <p>ยังไม่มีกิจกรรม</p>
</div>
@endsection

@section('script')
<script>
var API = '/api/admin/activities';
var CAT_API = '/api/admin/categories';
var token = localStorage.getItem('admin_token');
var currentPage = 1;
var lastPage = 1;
var allCategories = [];

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
            allCategories = json.data || [];
            var sel = $('#filter-category');
            var editSel = $('#edit-category-id');
            $.each(allCategories, function (i, cat) {
                var name = $('<span>').text(cat.name).html();
                sel.append('<option value="' + cat.id + '">' + name + '</option>');
                editSel.append('<option value="' + cat.id + '">' + name + '</option>');
            });
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
                            '<button class="btn btn-sm btn-secondary" onclick="viewActivity(' + act.id + ')" style="padding:0.375rem" title="ดู"><i class="fa-regular fa-eye"></i></button>' +
                            '<button class="btn btn-sm btn-secondary" onclick="openEditModal(' + act.id + ')" style="padding:0.375rem" title="แก้ไข"><i class="fa-regular fa-pen-to-square"></i></button>' +
                            '<button class="btn btn-sm btn-secondary" onclick="confirmDelete(' + act.id + ')" style="padding:0.375rem;color:var(--danger)" title="ลบ"><i class="fa-regular fa-trash-can"></i></button>' +
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

    var startPage = Math.max(1, meta.current_page - 2);
    var endPage = Math.min(meta.last_page, startPage + 4);
    startPage = Math.max(1, endPage - 4);

    for (var p = startPage; p <= endPage; p++) {
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
    $.ajax({
        url: API + '/' + id,
        method: 'GET',
        headers: getHeaders(),
        success: function (json) {
            var act = json.data;
            if (!act) return;

            $('#view-title').text(act.title);
            $('#view-desc').text(act.description || 'ไม่มีรายละเอียด');
            $('#view-category').text(act.category ? act.category.name : '-');
            $('#view-date').text(act.activity_date || '-');
            $('#view-location').text(act.location || '-');
            $('#view-participants').text(act.participants_count || 0);
            $('#view-status').html(act.status
                ? '<span class="badge badge-success">เปิดใช้งาน</span>'
                : '<span class="badge badge-warning">ปิดใช้งาน</span>');

            if (act.cover_image_url) {
                $('#view-cover').attr('src', act.cover_image_url);
                $('#view-cover-wrap').show();
            } else {
                $('#view-cover-wrap').hide();
            }

            if (act.pdf_url) {
                $('#view-pdf').attr('src', act.pdf_url);
                $('#view-pdf-wrap').show();
            } else {
                $('#view-pdf-wrap').hide();
            }

            $('#view-modal')[0].showModal();
        },
        error: function () {
            showToast('ไม่สามารถโหลดข้อมูลกิจกรรม', 'error');
        }
    });
}

function closeViewModal() {
    $('#view-modal')[0].close();
}

function openEditModal(id) {
    $.ajax({
        url: API + '/' + id,
        method: 'GET',
        headers: getHeaders(),
        success: function (json) {
            var act = json.data;
            if (!act) return;

            $('#edit-id').val(act.id);
            $('#edit-title').val(act.title);
            $('#edit-category-id').val(act.category_id || '');
            $('#edit-activity-date').val(act.activity_date || '');
            $('#edit-location').val(act.location || '');
            $('#edit-description').val(act.description || '');
            $('#edit-status').val(act.status.toString());

            $('#edit-form').off('submit').on('submit', handleEditSubmit);
            $('#edit-modal')[0].showModal();
        },
        error: function () {
            showToast('ไม่สามารถโหลดข้อมูลกิจกรรม', 'error');
        }
    });
}

function closeEditModal() {
    $('#edit-modal')[0].close();
}

function handleEditSubmit(e) {
    e.preventDefault();
    var id = $('#edit-id').val();
    var btn = $('#edit-submit-btn');
    btn.prop('disabled', true).text('กำลังบันทึก...');

    $.ajax({
        url: API + '/' + id,
        method: 'PUT',
        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
        data: {
            title: $('#edit-title').val(),
            category_id: $('#edit-category-id').val(),
            activity_date: $('#edit-activity-date').val(),
            location: $('#edit-location').val(),
            description: $('#edit-description').val(),
            status: $('#edit-status').val()
        },
        success: function () {
            closeEditModal();
            loadActivities(currentPage);
            showToast('อัปเดตกิจกรรมสำเร็จ', 'success');
        },
        error: function (xhr) {
            var msg = 'เกิดข้อผิดพลาด';
            try { msg = JSON.parse(xhr.responseText).message || msg; } catch (e) {}
            showToast(msg, 'error');
            btn.prop('disabled', false).text('บันทึก');
        }
    });
}

function confirmDelete(id) {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: 'การลบกิจกรรมนี้จะไม่สามารถกู้คืนได้',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#64748B',
        confirmButtonText: 'ใช่, ลบเลย',
        cancelButtonText: 'ยกเลิก'
    }).then(function (result) {
        if (result.isConfirmed) {
            $.ajax({
                url: API + '/' + id,
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                success: function () {
                    loadActivities(currentPage);
                    Swal.fire('ลบแล้ว!', 'กิจกรรมถูกลบเรียบร้อย', 'success');
                },
                error: function (xhr) {
                    var msg = 'เกิดข้อผิดพลาด';
                    try { msg = JSON.parse(xhr.responseText).message || msg; } catch (e) {}
                    Swal.fire('ผิดพลาด!', msg, 'error');
                }
            });
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