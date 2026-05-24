@extends('layouts.app')

@section('title', 'กิจกรรมทั้งหมด - Admin')

@section('style')
<style>
dialog::backdrop { background: rgba(0,0,0,.45); }
</style>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold py-3 mb-0">กิจกรรมทั้งหมด</h4>
        <p class="text-muted mb-0">จัดการกิจกรรมของมหาวิทยาลัย</p>
    </div>
    <button class="btn btn-primary" onclick="openCreateModal()">
        <i class="bx bx-plus me-1"></i> สร้างกิจกรรมใหม่
    </button>
</div>

<div class="card mb-4">
    <div class="card-body d-flex flex-wrap align-items-center gap-2">
        <div style="min-width:200px">
            <input type="text" id="filter-keyword" class="form-control form-control-sm" placeholder="ค้นหากิจกรรม...">
        </div>
        <select id="filter-category" class="form-select form-select-sm" style="min-width:150px">
            <option value="">ทุกหมวดหมู่</option>
        </select>
        <select id="filter-status" class="form-select form-select-sm" style="min-width:130px">
            <option value="">ทุกสถานะ</option>
            <option value="1">เปิดใช้งาน</option>
            <option value="0">ปิดใช้งาน</option>
        </select>
        <button class="btn btn-outline-secondary btn-sm" onclick="applyFilters()"><i class="bx bx-filter me-1"></i> กรอง</button>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width:40px"><input type="checkbox" id="select-all" class="form-check-input" style="cursor:pointer;"></th>
                    <th>ชื่อกิจกรรม</th>
                    <th>หมวดหมู่</th>
                    <th>วันที่</th>
                    <th>สถานที่</th>
                    <th>ผู้เข้าร่วม</th>
                    <th>สถานะ</th>
                    <th class="text-center" style="width:120px">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody id="activities-tbody">
                <tr><td colspan="8" class="text-center py-5 text-muted"><div class="spinner-border spinner-border-sm mb-2" role="status"></div><br>กำลังโหลด...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between mt-3">
    <p id="pagination-info" class="mb-0 text-muted small"></p>
    <div id="pagination-btns" class="d-flex gap-1"></div>
</div>

<dialog id="view-modal" class="modal-lg" style="border:none;border-radius:.75rem;padding:0;max-width:700px;width:90vw">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h5 class="mb-0">รายละเอียดกิจกรรม</h5>
        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" onclick="closeViewModal()"><i class="bx bx-x"></i></button>
    </div>
    <div class="p-4">
        <div id="view-cover-wrap" class="d-none mb-3">
            <img id="view-cover" src="" alt="cover" class="w-100 rounded" style="max-height:300px;object-fit:cover">
        </div>
        <h4 id="view-title" class="mb-2 fw-bold"></h4>
        <p id="view-desc" class="text-muted mb-3" style="line-height:1.6"></p>
        <div class="row g-3 mb-3">
            <div class="col-6"><small class="text-muted d-block">หมวดหมู่:</small><span id="view-category" class="fw-semibold"></span></div>
            <div class="col-6"><small class="text-muted d-block">วันที่:</small><span id="view-date" class="fw-semibold"></span></div>
            <div class="col-6"><small class="text-muted d-block">สถานที่:</small><span id="view-location" class="fw-semibold"></span></div>
            <div class="col-6"><small class="text-muted d-block">ผู้เข้าร่วม:</small><span id="view-participants" class="fw-semibold"></span></div>
            <div class="col-6"><small class="text-muted d-block">สถานะ:</small><span id="view-status" class="fw-semibold"></span></div>
        </div>
        <div id="view-pdf-wrap" class="d-none">
            <hr>
            <p class="fw-semibold mb-2"><i class="bx bxs-file-pdf text-danger me-1"></i> เอกสาร PDF</p>
            <iframe id="view-pdf" src="" class="w-100 rounded border" style="height:500px"></iframe>
        </div>
    </div>
</dialog>

<dialog id="form-modal" class="modal-lg" style="border:none;border-radius:.75rem;padding:0;max-width:700px;width:90vw">
    <form id="activity-form">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
            <h5 id="form-modal-title" class="mb-0">สร้างกิจกรรมใหม่</h5>
            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" onclick="closeFormModal()"><i class="bx bx-x"></i></button>
        </div>
        <div class="p-4">
            <input type="hidden" id="form-id">
            <div class="mb-3">
                <label class="form-label">ชื่อกิจกรรม <span class="text-danger">*</span></label>
                <input type="text" id="form-title" name="title" class="form-control" required placeholder="กรุณากรอกชื่อกิจกรรม">
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label">หมวดหมู่ <span class="text-danger">*</span></label>
                    <select id="form-category-id" name="category_id" class="form-select" required><option value="">เลือกหมวดหมู่</option></select>
                </div>
                <div class="col-6">
                    <label class="form-label">วันที่จัดกิจกรรม</label>
                    <input type="date" id="form-activity-date" name="activity_date" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">สถานที่</label>
                <input type="text" id="form-location" name="location" class="form-control" placeholder="กรุณากรอกสถานที่">
            </div>
            <div class="mb-3">
                <label class="form-label">รายละเอียด</label>
                <textarea id="form-description" name="description" class="form-control" rows="4" placeholder="กรุณากรอกรายละเอียด"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">รูปปก</label>
                <input type="file" id="form-cover" name="cover_image" class="form-control" accept="image/*">
                <div id="form-cover-existing" class="d-none mt-2 d-flex align-items-center gap-2">
                    <div class="position-relative" style="width:64px;height:64px;cursor:pointer" onclick="previewImage($(this).find('img').attr('src'))">
                        <img id="form-cover-preview" src="" alt="" style="width:64px;height:64px;object-fit:cover;border-radius:.375rem">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background:rgba(0,0,0,.3);border-radius:.375rem;opacity:0;transition:opacity .15s" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0"><i class="bx bx-expand text-white" style="font-size:.75rem"></i></div>
                    </div>
                    <small class="text-muted">รูปปกปัจจุบัน</small>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">ไฟล์ PDF</label>
                <input type="file" id="form-pdf" name="pdf_file" class="form-control" accept=".pdf">
                <div id="form-pdf-existing" class="d-none mt-2 d-flex align-items-center gap-2">
                    <div class="d-inline-flex align-items-center gap-1 px-3 py-1 rounded-pill border text-danger" style="cursor:pointer" onclick="window.open($(this).data('url'), '_blank')">
                        <i class="bx bxs-file-pdf"></i>
                        <span class="small fw-semibold">PDF ปัจจุบัน</span>
                    </div>
                    <small class="text-muted">(อัปโหลดแทนที่หากต้องการเปลี่ยน)</small>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">สถานะ</label>
                <select id="form-status" name="status" class="form-select">
                    <option value="1">เปิดใช้งาน</option>
                    <option value="0">ปิดใช้งาน</option>
                </select>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-end gap-2 px-4 py-3 border-top">
            <button type="button" class="btn btn-outline-secondary" onclick="closeFormModal()">ยกเลิก</button>
            <button type="submit" class="btn btn-primary" id="form-submit-btn">บันทึก</button>
        </div>
    </form>
</dialog>

<div id="empty-state" class="text-center py-5 d-none">
    <div class="mb-3 text-muted" style="font-size:3rem"><i class="bx bx-calendar"></i></div>
    <h5>ยังไม่มีกิจกรรม</h5>
    <p class="text-muted mb-3">เริ่มสร้างกิจกรรมแรกของคุณ</p>
    <button class="btn btn-primary" onclick="openCreateModal()"><i class="bx bx-plus me-1"></i> สร้างกิจกรรมใหม่</button>
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

        $(function() {
            if (!token) {
                $('#activities-tbody').html('<tr><td colspan="8" class="text-center py-5 text-muted">กรุณา <a href="/login" class="text-primary">เข้าสู่ระบบ</a> ก่อน</td></tr>');
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
                success: function(json) {
                    allCategories = json.data || [];
                    var opts = '';
                    $.each(allCategories, function(i, cat) {
                        opts += '<option value="' + cat.id + '">' + $('<span>').text(cat.name).html() + '</option>';
                    });
                    $('#filter-category').append(opts);
                    $('#form-category-id').append(opts);
                },
                error: function() {
                    showToast('ไม่สามารถโหลดหมวดหมู่ได้', 'error');
                }
            });
        }

        function applyFilters() {
            currentPage = 1;
            loadActivities(1);
        }

        function loadActivities(page) {
            var params = { page: page, per_page: 10 };
            var keyword = $('#filter-keyword').val();
            var categoryId = $('#filter-category').val();
            var status = $('#filter-status').val();
            if (keyword) params.keyword = keyword;
            if (categoryId) params.category_id = categoryId;
            if (status !== '') params.status = status;

            $.ajax({
                url: API,
                method: 'GET',
                headers: getHeaders(),
                data: params,
                success: function(json) {
                    var tbody = $('#activities-tbody');
                    tbody.empty();
                    if (!json.data || json.data.length === 0) {
                        tbody.html('<tr><td colspan="8" class="text-center py-5 text-muted">ไม่พบกิจกรรม</td></tr>');
                        return;
                    }
                    $.each(json.data, function(i, act) {
                        var catName = act.category ? act.category.name : '-';
                        var statusHtml = act.status ? '<span class="badge bg-label-success">เปิดใช้งาน</span>' : '<span class="badge bg-label-warning">ปิดใช้งาน</span>';
                        var initial = $('<span>').text(act.title).html().charAt(0).toUpperCase();
                        var titleSafe = $('<span>').text(act.title).html();
                        var catSafe = $('<span>').text(catName).html();
                        tbody.append('<tr>' +
                            '<td><input type="checkbox" class="row-check form-check-input"></td>' +
                            '<td><div class="d-flex align-items-center gap-3"><div class="avatar avatar-sm"><span class="avatar-initial rounded bg-label-primary">' + initial + '</span></div><div><div class="fw-semibold">' + titleSafe + '</div></div></div></td>' +
                            '<td><span class="badge bg-label-info">' + catSafe + '</span></td>' +
                            '<td>' + (act.activity_date || '-') + '</td>' +
                            '<td>' + (act.location || '-') + '</td>' +
                            '<td><span class="fw-semibold">' + (act.participants_count || 0) + '</span></td>' +
                            '<td>' + statusHtml + '</td>' +
                            '<td><div class="d-flex justify-content-center gap-1">' +
                            '<button class="btn btn-sm btn-icon btn-outline-secondary" onclick="viewActivity(' + act.id + ')" title="ดู"><i class="bx bx-show"></i></button>' +
                            '<button class="btn btn-sm btn-icon btn-outline-secondary" onclick="openEditModal(' + act.id + ')" title="แก้ไข"><i class="bx bx-pencil"></i></button>' +
                            '<button class="btn btn-sm btn-icon btn-outline-danger" onclick="confirmDelete(' + act.id + ')" title="ลบ"><i class="bx bx-trash"></i></button>' +
                            '</div></td></tr>');
                    });
                    if (json.meta) {
                        currentPage = json.meta.current_page;
                        lastPage = json.meta.last_page;
                        updatePagination(json.meta);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        $('#activities-tbody').html('<tr><td colspan="8" class="text-center py-5 text-muted">เซสชันหมดอายุ กรุณา <a href="/login" class="text-primary">เข้าสู่ระบบ</a> อีกครั้ง</td></tr>');
                    } else {
                        $('#activities-tbody').html('<tr><td colspan="8" class="text-center py-5 text-danger">เกิดข้อผิดพลาดในการโหลดข้อมูล</td></tr>');
                    }
                }
            });
        }

        function updatePagination(meta) {
            $('#pagination-info').text('แสดง ' + ((meta.current_page - 1) * meta.per_page + 1) + '-' + Math.min(meta.current_page * meta.per_page, meta.total) + ' จาก ' + meta.total + ' รายการ');
            var btns = $('#pagination-btns').empty();
            var prevBtn = $('<button class="btn btn-sm btn-outline-secondary">').html('<i class="bx bx-chevron-left"></i>');
            if (meta.current_page <= 1) prevBtn.prop('disabled', true);
            prevBtn.on('click', function() { if (meta.current_page > 1) loadActivities(meta.current_page - 1); });
            btns.append(prevBtn);
            var sp = Math.max(1, meta.current_page - 2);
            var ep = Math.min(meta.last_page, sp + 4);
            sp = Math.max(1, ep - 4);
            for (var p = sp; p <= ep; p++)(function(page) {
                var btn = $('<button class="btn btn-sm ' + (page === meta.current_page ? 'btn-primary' : 'btn-outline-secondary') + '">').text(page);
                btn.on('click', function() { loadActivities(page); });
                btns.append(btn);
            })(p);
            var nextBtn = $('<button class="btn btn-sm btn-outline-secondary">').html('<i class="bx bx-chevron-right"></i>');
            if (meta.current_page >= meta.last_page) nextBtn.prop('disabled', true);
            nextBtn.on('click', function() { if (meta.current_page < meta.last_page) loadActivities(meta.current_page + 1); });
            btns.append(nextBtn);
        }

        function viewActivity(id) {
            $.ajax({
                url: API + '/' + id,
                method: 'GET',
                headers: getHeaders(),
                success: function(json) {
                    var act = json.data;
                    if (!act) return;
                    $('#view-title').text(act.title);
                    $('#view-desc').text(act.description || 'ไม่มีรายละเอียด');
                    $('#view-category').text(act.category ? act.category.name : '-');
                    $('#view-date').text(act.activity_date || '-');
                    $('#view-location').text(act.location || '-');
                    $('#view-participants').text(act.participants_count || 0);
                    $('#view-status').html(act.status ? '<span class="badge bg-label-success">เปิดใช้งาน</span>' : '<span class="badge bg-label-warning">ปิดใช้งาน</span>');
                    if (act.cover_image_url) {
                        $('#view-cover').attr('src', act.cover_image_url);
                        $('#view-cover-wrap').removeClass('d-none');
                    } else {
                        $('#view-cover-wrap').addClass('d-none');
                    }
                    if (act.pdf_url) {
                        $('#view-pdf').attr('src', act.pdf_url);
                        $('#view-pdf-wrap').removeClass('d-none');
                    } else {
                        $('#view-pdf-wrap').addClass('d-none');
                    }
                    $('#view-modal')[0].showModal();
                },
                error: function() { showToast('ไม่สามารถโหลดข้อมูลกิจกรรม', 'error'); }
            });
        }

        function closeViewModal() { $('#view-modal')[0].close(); }

        function openCreateModal() {
            $('#form-modal-title').text('สร้างกิจกรรมใหม่');
            $('#form-submit-btn').text('บันทึก');
            $('#form-id').val('');
            $('#activity-form')[0].reset();
            $('#form-cover-existing, #form-pdf-existing').addClass('d-none');
            $('#form-cover, #form-pdf').val('');
            $('#activity-form').off('submit').on('submit', handleCreate);
            $('#form-modal')[0].showModal();
        }

        function openEditModal(id) {
            $.ajax({
                url: API + '/' + id,
                method: 'GET',
                headers: getHeaders(),
                success: function(json) {
                    var act = json.data;
                    if (!act) return;
                    $('#form-modal-title').text('แก้ไขกิจกรรม');
                    $('#form-submit-btn').text('อัปเดต');
                    $('#form-id').val(act.id);
                    $('#form-title').val(act.title);
                    $('#form-category-id').val(act.category_id || '');
                    $('#form-activity-date').val(act.activity_date || '');
                    $('#form-location').val(act.location || '');
                    $('#form-description').val(act.description || '');
                    $('#form-status').val(act.status.toString());
                    $('#form-cover, #form-pdf').val('');
                    if (act.cover_image_url) {
                        $('#form-cover-preview').attr('src', act.cover_image_url);
                        $('#form-cover-existing').removeClass('d-none');
                    } else {
                        $('#form-cover-existing').addClass('d-none');
                    }
                    if (act.pdf_url) {
                        $('#form-pdf-existing .d-inline-flex').data('url', act.pdf_url);
                        $('#form-pdf-existing').removeClass('d-none');
                    } else {
                        $('#form-pdf-existing').addClass('d-none');
                    }
                    $('#activity-form').off('submit').on('submit', handleEdit);
                    $('#form-modal')[0].showModal();
                },
                error: function() { showToast('ไม่สามารถโหลดข้อมูลกิจกรรม', 'error'); }
            });
        }

        function closeFormModal() { $('#form-modal')[0].close(); }

        function getFormData() {
            var fd = new FormData();
            fd.append('title', $('#form-title').val());
            fd.append('category_id', $('#form-category-id').val());
            fd.append('activity_date', $('#form-activity-date').val());
            fd.append('location', $('#form-location').val());
            fd.append('description', $('#form-description').val());
            fd.append('status', $('#form-status').val());
            var cover = $('#form-cover')[0].files[0];
            if (cover) fd.append('cover_image', cover);
            var pdf = $('#form-pdf')[0].files[0];
            if (pdf) fd.append('pdf_file', pdf);
            return fd;
        }

        function handleCreate(e) {
            e.preventDefault();
            var btn = $('#form-submit-btn');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>กำลังบันทึก...');
            $.ajax({
                url: API, method: 'POST',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                data: getFormData(), processData: false, contentType: false,
                success: function() { closeFormModal(); loadActivities(1); showToast('สร้างกิจกรรมสำเร็จ', 'success'); },
                error: function(xhr) {
                    var msg = 'เกิดข้อผิดพลาด';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errs = xhr.responseJSON.errors;
                        if (typeof errs === 'object') { var lines = []; $.each(errs, function(k, v) { lines.push(v); }); msg = lines.join('\n'); }
                        else if (typeof errs === 'string') msg = errs;
                    } else if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    showToast(msg, 'error');
                    btn.prop('disabled', false).text('บันทึก');
                }
            });
        }

        function handleEdit(e) {
            e.preventDefault();
            var id = $('#form-id').val();
            var btn = $('#form-submit-btn');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>กำลังอัปเดต...');
            var fd = getFormData();
            fd.append('_method', 'PUT');
            $.ajax({
                url: API + '/' + id, method: 'POST',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                data: fd, processData: false, contentType: false,
                success: function() { closeFormModal(); loadActivities(currentPage); showToast('อัปเดตกิจกรรมสำเร็จ', 'success'); },
                error: function(xhr) {
                    var msg = 'เกิดข้อผิดพลาด';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errs = xhr.responseJSON.errors;
                        if (typeof errs === 'object') { var lines = []; $.each(errs, function(k, v) { lines.push(v); }); msg = lines.join('\n'); }
                        else if (typeof errs === 'string') msg = errs;
                    } else if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    showToast(msg, 'error');
                    btn.prop('disabled', false).text('อัปเดต');
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?', text: 'การลบกิจกรรมนี้จะไม่สามารถกู้คืนได้', icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#DC2626', cancelButtonColor: '#64748B',
                confirmButtonText: 'ใช่, ลบเลย', cancelButtonText: 'ยกเลิก'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: API + '/' + id, method: 'DELETE',
                        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                        success: function() { loadActivities(currentPage); Swal.fire('ลบแล้ว!', 'กิจกรรมถูกลบเรียบร้อย', 'success'); },
                        error: function(xhr) { var msg = 'เกิดข้อผิดพลาด'; try { msg = JSON.parse(xhr.responseText).message || msg; } catch(e) {} Swal.fire('ผิดพลาด!', msg, 'error'); }
                    });
                }
            });
        }

        function showToast(msg, type) {
            $('.toast').remove();
            $('<div class="toast ' + (type || 'info') + '">').text(msg).appendTo('body');
            setTimeout(function() { $('.toast').fadeOut(300, function() { $(this).remove(); }); }, 3000);
        }
    </script>
@endsection
