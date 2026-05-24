@extends('layouts.app')

@section('title', 'กิจกรรมทั้งหมด - Admin')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-title">กิจกรรมทั้งหมด</h2>
        <p class="page-subtitle">จัดการกิจกรรมของมหาวิทยาลัย</p>
    </div>
    <button class="btn btn-primary" onclick="openCreateModal()">
        <i class="fa-solid fa-plus"></i> สร้างกิจกรรมใหม่
    </button>
</div>

<div class="card mb-6">
    <div class="card-body filter-bar">
        <div class="filter-input"><input type="text" id="filter-keyword" placeholder="ค้นหากิจกรรม..."></div>
        <select id="filter-category" style="padding:.625rem 1rem;border:1px solid var(--border);border-radius:var(--radius);font-size:14px;background:var(--surface);min-width:150px;">
            <option value="">ทุกหมวดหมู่</option>
        </select>
        <select id="filter-status" style="padding:.625rem 1rem;border:1px solid var(--border);border-radius:var(--radius);font-size:14px;background:var(--surface);min-width:130px;">
            <option value="">ทุกสถานะ</option>
            <option value="1">เปิดใช้งาน</option>
            <option value="0">ปิดใช้งาน</option>
        </select>
        <button class="btn btn-secondary" onclick="applyFilters()"><i class="fa-solid fa-filter"></i> กรอง</button>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="data-table" id="activities-table">
            <thead>
                <tr>
                    <th style="width:40px"><input type="checkbox" id="select-all" style="width:18px;height:18px;cursor:pointer;"></th>
                    <th>ชื่อกิจกรรม</th>
                    <th>หมวดหมู่</th>
                    <th>วันที่</th>
                    <th>สถานที่</th>
                    <th>ผู้เข้าร่วม</th>
                    <th>สถานะ</th>
                    <th style="width:120px">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody id="activities-tbody">
                <tr><td colspan="8" class="loading-cell"><i class="fa-solid fa-arrows-rotate fa-spin d-block" style="font-size:1.5rem;margin-bottom:.75rem"></i>กำลังโหลด...</td></tr>
            </tbody>
        </table>
    </div>
</div>

    <div class="pag-bar" style="margin-top:1rem">
    <p id="pagination-info" class="pag-info"></p>
    <div id="pagination-btns" class="pag-btns"></div>
</div>

<dialog id="view-modal" class="modal-lg">
    <div class="dialog-header">
        <h3>รายละเอียดกิจกรรม</h3>
        <button type="button" class="btn btn-sm btn-muted" style="padding:.375rem .5rem" onclick="closeViewModal()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="dialog-body">
        <div class="detail-grid">
            <div id="view-cover-wrap" class="d-none"><img id="view-cover" src="" alt="cover" class="detail-cover"></div>
            <div style="grid-column:1/-1">
                <h3 id="view-title" style="font-size:1.25rem;font-weight:700;margin:0 0 .75rem"></h3>
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
            <p style="font-weight:700;margin:0 0 .5rem"><i class="fa-solid fa-file-pdf" style="color:#DC2626"></i> เอกสาร PDF</p>
            <iframe id="view-pdf" src="" style="width:100%;height:500px;border:1px solid var(--border);border-radius:var(--radius-lg)"></iframe>
        </div>
    </div>
</dialog>

<dialog id="form-modal" class="modal-lg">
    <form id="activity-form">
        <div class="dialog-header">
            <h3 id="form-modal-title">สร้างกิจกรรมใหม่</h3>
            <button type="button" class="btn btn-sm btn-muted" style="padding:.375rem .5rem" onclick="closeFormModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="dialog-body form-grid">
            <input type="hidden" id="form-id">
            <div class="form-full">
                <label class="field-label">ชื่อกิจกรรม</label>
                <input type="text" id="form-title" name="title" required placeholder="กรุณากรอกชื่อกิจกรรม">
            </div>
            <div>
                <label class="field-label">หมวดหมู่</label>
                <select id="form-category-id" name="category_id" required><option value="">เลือกหมวดหมู่</option></select>
            </div>
            <div>
                <label class="field-label">วันที่จัดกิจกรรม</label>
                <input type="date" id="form-activity-date" name="activity_date">
            </div>
            <div class="form-full">
                <label class="field-label">สถานที่</label>
                <input type="text" id="form-location" name="location" placeholder="กรุณากรอกสถานที่">
            </div>
            <div class="form-full">
                <label class="field-label">รายละเอียด</label>
                <textarea id="form-description" name="description" rows="4" placeholder="กรุณากรอกรายละเอียด"></textarea>
            </div>
            <div class="form-full">
                <label class="field-label">รูปปก</label>
                <input type="file" id="form-cover" name="cover_image" accept="image/*">
                <div id="form-cover-existing" class="file-existing d-none mt-2">
                    <div class="fe-img-thumb" onclick="previewImage($(this).find('img').attr('src'))">
                        <img id="form-cover-preview" src="" alt="" style="width:64px;height:64px;object-fit:cover;display:block;">
                        <div class="fe-img-overlay"><i class="fa-solid fa-expand" style="font-size:.75rem"></i></div>
                    </div>
                    <span class="fe-label">รูปปกปัจจุบัน</span>
                </div>
            </div>
            <div class="form-full">
                <label class="field-label">ไฟล์ PDF</label>
                <input type="file" id="form-pdf" name="pdf_file" accept=".pdf">
                <div id="form-pdf-existing" class="file-existing d-none mt-2">
                    <div class="fe-pdf-chip" onclick="window.open($(this).data('url'), '_blank')">
                        <i class="fa-solid fa-file-pdf"></i>
                        <span>PDF ปัจจุบัน</span>
                    </div>
                    <span class="fe-label">ไฟล์ PDF ปัจจุบัน (อัปโหลดแทนที่หากต้องการเปลี่ยน)</span>
                </div>
            </div>
            <div>
                <label class="field-label">สถานะ</label>
                <select id="form-status" name="status">
                    <option value="1">เปิดใช้งาน</option>
                    <option value="0">ปิดใช้งาน</option>
                </select>
            </div>
        </div>
        <div class="dialog-footer">
            <button type="button" class="btn btn-muted" onclick="closeFormModal()">ยกเลิก</button>
            <button type="submit" class="btn btn-primary" id="form-submit-btn">บันทึก</button>
        </div>
    </form>
</dialog>

<div id="empty-state" class="empty-state d-none">
    <div class="empty-state-icon"><i class="fa-regular fa-calendar"></i></div>
    <h3>ยังไม่มีกิจกรรม</h3>
    <p>เริ่มสร้างกิจกรรมแรกของคุณ</p>
    <button class="btn btn-primary" onclick="openCreateModal()"><i class="fa-solid fa-plus"></i> สร้างกิจกรรมใหม่</button>
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
                $('#activities-tbody').html(
                    '<tr><td colspan="8" class="loading-cell">กรุณา <a href="/login" style="color:#4F46E5">เข้าสู่ระบบ</a> ก่อน</td></tr>'
                );
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
                        opts += '<option value="' + cat.id + '">' + $('<span>').text(cat.name).html() +
                            '</option>';
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
            var params = {
                page: page,
                per_page: 10
            };
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
                        tbody.html(
                            '<tr><td colspan="8" class="loading-cell">ไม่พบกิจกรรม</td></tr>'
                        );
                        return;
                    }
                    $.each(json.data, function(i, act) {
                        var catName = act.category ? act.category.name : '-';
                        var statusHtml = act.status ?
                            '<span class="badge badge-success">เปิดใช้งาน</span>' :
                            '<span class="badge badge-warning">ปิดใช้งาน</span>';
                        var initial = $('<span>').text(act.title).html().charAt(0).toUpperCase();
                        var titleSafe = $('<span>').text(act.title).html();
                        var catSafe = $('<span>').text(catName).html();
                        tbody.append('<tr>' +
                            '<td><input type="checkbox" class="row-check table-checkbox"></td>' +
                            '<td><div class="d-flex align-items-center" style="gap:1rem"><div class="activity-avatar">' +
                            initial + '</div><div><p class="fw-semibold" style="margin-bottom:2px">' +
                            titleSafe + '</p></div></div></td>' +
                            '<td><span class="badge badge-primary">' + catSafe + '</span></td>' +
                            '<td>' + (act.activity_date || '-') + '</td>' +
                            '<td>' + (act.location || '-') + '</td>' +
                            '<td><span class="fw-semibold">' + (act.participants_count || 0) +
                            '</span></td>' +
                            '<td>' + statusHtml + '</td>' +
                            '<td><div class="d-flex" style="gap:.5rem">' +
                            '<button class="btn btn-sm btn-secondary" style="padding:6px" onclick="viewActivity(' + act.id + ')" title="\u0e14\u0e39"><i class="fa-regular fa-eye"></i></button>' +
                            '<button class="btn btn-sm btn-secondary" style="padding:6px" onclick="openEditModal(' + act.id + ')" title="\u0e41\u0e01\u0e49\u0e44\u0e02"><i class="fa-solid fa-pen-to-square"></i></button>' +
                            '<button class="btn btn-sm btn-secondary" style="padding:6px;color:#EF4444" onclick="confirmDelete(' + act.id + ')" title="\u0e25\u0e1a"><i class="fa-solid fa-trash-can"></i></button>' +
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
                        $('#activities-tbody').html(
                            '<tr><td colspan="8" class="loading-cell">เซสชันหมดอายุ กรุณา <a href="/login" style="color:#4F46E5">เข้าสู่ระบบ</a> อีกครั้ง</td></tr>'
                        );
                    } else {
                        $('#activities-tbody').html(
                            '<tr><td colspan="8" style="text-align:center;padding:3rem;color:#EF4444">เกิดข้อผิดพลาดในการโหลดข้อมูล</td></tr>'
                        );
                    }
                }
            });
        }

        function updatePagination(meta) {
            $('#pagination-info').text('แสดง ' + ((meta.current_page - 1) * meta.per_page + 1) + '-' + Math.min(meta
                .current_page * meta.per_page, meta.total) + ' จาก ' + meta.total + ' รายการ');
            var btns = $('#pagination-btns').empty();
            var prevBtn = $('<button class="btn btn-sm btn-secondary">').text('ก่อนหน้า');
            if (meta.current_page <= 1) prevBtn.prop('disabled', true);
            prevBtn.on('click', function() {
                if (meta.current_page > 1) loadActivities(meta.current_page - 1);
            });
            btns.append(prevBtn);
            var sp = Math.max(1, meta.current_page - 2);
            var ep = Math.min(meta.last_page, sp + 4);
            sp = Math.max(1, ep - 4);
            for (var p = sp; p <= ep; p++)(function(page) {
                var btn = $('<button class="btn btn-sm ' + (page === meta.current_page ? 'btn-primary' :
                    'btn-secondary') + '">').text(page);
                btn.on('click', function() {
                    loadActivities(page);
                });
                btns.append(btn);
            })(p);
            var nextBtn = $('<button class="btn btn-sm btn-secondary">').text('ถัดไป');
            if (meta.current_page >= meta.last_page) nextBtn.prop('disabled', true);
            nextBtn.on('click', function() {
                if (meta.current_page < meta.last_page) loadActivities(meta.current_page + 1);
            });
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
                    $('#view-status').html(act.status ? '<span class="badge badge-success">เปิดใช้งาน</span>' :
                        '<span class="badge badge-warning">ปิดใช้งาน</span>');
                    if (act.cover_image_url) {
                        $('#view-cover').attr('src', act.cover_image_url);
                        $('#view-cover-wrap').removeClass('d-none');
                    } else {
                        $('#view-cover-wrap').addClass('d-none');
                    }
                    if (act.pdf_url) {
                        $('#view-pdf').attr('src', act.pdf_url);
                        $('#view-pdf-wrap').show();
                    } else {
                        $('#view-pdf-wrap').hide();
                    }
                    $('#view-modal')[0].showModal();
                },
                error: function() {
                    showToast('ไม่สามารถโหลดข้อมูลกิจกรรม', 'error');
                }
            });
        }

        function closeViewModal() {
            $('#view-modal')[0].close();
        }

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
                        $('#form-pdf-existing .fe-pdf-chip').data('url', act.pdf_url);
                        $('#form-pdf-existing').removeClass('d-none');
                    } else {
                        $('#form-pdf-existing').addClass('d-none');
                    }

                    $('#activity-form').off('submit').on('submit', handleEdit);
                    $('#form-modal')[0].showModal();
                },
                error: function() {
                    showToast('ไม่สามารถโหลดข้อมูลกิจกรรม', 'error');
                }
            });
        }

        function closeFormModal() {
            $('#form-modal')[0].close();
        }

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
            btn.prop('disabled', true).text('กำลังบันทึก...');

            $.ajax({
                url: API,
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },
                data: getFormData(),
                processData: false,
                contentType: false,
                success: function() {
                    closeFormModal();
                    loadActivities(1);
                    showToast('สร้างกิจกรรมสำเร็จ', 'success');
                },
                error: function(xhr) {
                    var msg = 'เกิดข้อผิดพลาด';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errs = xhr.responseJSON.errors;
                        if (typeof errs === 'object') {
                            var lines = [];
                            $.each(errs, function(k, v) {
                                lines.push(v);
                            });
                            msg = lines.join('\n');
                        } else if (typeof errs === 'string') {
                            msg = errs;
                        }
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    showToast(msg, 'error');
                    btn.prop('disabled', false).text('บันทึก');
                }
            });
        }

        function handleEdit(e) {
            e.preventDefault();
            var id = $('#form-id').val();
            var btn = $('#form-submit-btn');
            btn.prop('disabled', true).text('กำลังอัปเดต...');

            var fd = getFormData();
            fd.append('_method', 'PUT');

            $.ajax({
                url: API + '/' + id,
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },
                data: fd,
                processData: false,
                contentType: false,
                success: function() {
                    closeFormModal();
                    loadActivities(currentPage);
                    showToast('อัปเดตกิจกรรมสำเร็จ', 'success');
                },
                error: function(xhr) {
                    var msg = 'เกิดข้อผิดพลาด';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errs = xhr.responseJSON.errors;
                        if (typeof errs === 'object') {
                            var lines = [];
                            $.each(errs, function(k, v) {
                                lines.push(v);
                            });
                            msg = lines.join('\n');
                        } else if (typeof errs === 'string') {
                            msg = errs;
                        }
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    showToast(msg, 'error');
                    btn.prop('disabled', false).text('อัปเดต');
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
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: API + '/' + id,
                        method: 'DELETE',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        },
                        success: function() {
                            loadActivities(currentPage);
                            Swal.fire('ลบแล้ว!', 'กิจกรรมถูกลบเรียบร้อย', 'success');
                        },
                        error: function(xhr) {
                            var msg = 'เกิดข้อผิดพลาด';
                            try {
                                msg = JSON.parse(xhr.responseText).message || msg;
                            } catch (e) {}
                            Swal.fire('ผิดพลาด!', msg, 'error');
                        }
                    });
                }
            });
        }

        function showToast(msg, type) {
            $('.toast').remove();
            $('<div class="toast ' + (type || 'info') + '">').text(msg).appendTo('body');
            setTimeout(function() {
                $('.toast').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    </script>
@endsection
