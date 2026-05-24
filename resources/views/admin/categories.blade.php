@extends('layouts.app')

@section('title', 'จัดการหมวดหมู่ - Admin')

@section('style')
<style>
dialog::backdrop { background: rgba(0,0,0,.45); }
</style>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold py-3 mb-0">หมวดหมู่กิจกรรม</h4>
        <p class="text-muted mb-0">จัดการหมวดหมู่สำหรับกิจกรรมของมหาวิทยาลัย</p>
    </div>
    <button class="btn btn-primary" onclick="openCreateModal()">
        <i class="bx bx-plus me-1"></i> เพิ่มหมวดหมู่
    </button>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width:3.5rem">ID</th>
                    <th>ชื่อหมวดหมู่</th>
                    <th style="width:7rem">สถานะ</th>
                    <th class="text-center" style="width:9rem">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody id="categories-tbody">
                <tr><td colspan="4" class="text-center py-5 text-muted"><div class="spinner-border spinner-border-sm mb-2" role="status"></div><br>กำลังโหลด...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div id="empty-state" class="text-center py-5 d-none">
    <div class="mb-3 text-muted" style="font-size:3rem"><i class="bx bx-folder-open"></i></div>
    <h5>ยังไม่มีหมวดหมู่</h5>
    <p class="text-muted mb-3">สร้างหมวดหมู่แรกเพื่อจัดการกิจกรรม</p>
    <button class="btn btn-primary" onclick="openCreateModal()"><i class="bx bx-plus me-1"></i> สร้างหมวดหมู่</button>
</div>

<dialog id="category-modal" class="modal-sm" style="border:none;border-radius:.75rem;padding:0;max-width:450px;width:90vw">
    <form id="category-form">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
            <h5 id="modal-title" class="mb-0">เพิ่มหมวดหมู่</h5>
            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" onclick="closeModal()"><i class="bx bx-x"></i></button>
        </div>
        <div class="p-4">
            <input type="hidden" id="category-id">
            <div>
                <label class="form-label">ชื่อหมวดหมู่ <span class="text-danger">*</span></label>
                <input type="text" id="category-name" name="name" class="form-control" required placeholder="กรุณากรอกชื่อหมวดหมู่">
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-end gap-2 px-4 py-3 border-top">
            <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">ยกเลิก</button>
            <button type="submit" class="btn btn-primary" id="modal-submit-btn">บันทึก</button>
        </div>
    </form>
</dialog>
@endsection

@section('script')
    <script>
        var API = '/api/admin/categories';
        var token = localStorage.getItem('admin_token');

        function getHeaders() {
            return { 'Authorization': 'Bearer ' + token, 'Content-Type': 'application/json', 'Accept': 'application/json' };
        }

        $(function() {
            if (!token) {
                $('#categories-tbody').html('<tr><td colspan="4" class="text-center py-5 text-muted">กรุณา <a href="/login" class="text-primary">เข้าสู่ระบบ</a> ก่อน</td></tr>');
                return;
            }
            loadCategories();
        });

        function loadCategories() {
            $.ajax({
                url: API, method: 'GET', headers: getHeaders(),
                success: function(json) {
                    var tbody = $('#categories-tbody');
                    tbody.empty();
                    if (!json.data || json.data.length === 0) {
                        $('#empty-state').removeClass('d-none');
                        return;
                    }
                    $('#empty-state').addClass('d-none');
                    $.each(json.data, function(i, cat) {
                        var statusHtml = cat.status ? '<span class="badge bg-label-success">เปิดใช้งาน</span>' : '<span class="badge bg-label-warning">ปิดใช้งาน</span>';
                        tbody.append('<tr>' +
                            '<td class="text-muted small">' + cat.id + '</td>' +
                            '<td class="fw-semibold">' + $('<span>').text(cat.name).html() + '</td>' +
                            '<td>' + statusHtml + '</td>' +
                            '<td class="text-center"><div class="d-flex justify-content-center gap-1">' +
                            '<button class="btn btn-sm btn-icon btn-outline-secondary" onclick="openEditModal(' + cat.id + ',\'' + $('<span>').text(cat.name).html().replace(/'/g, "\\'") + '\',' + cat.status + ')"><i class="bx bx-pencil"></i></button>' +
                            '<button class="btn btn-sm btn-icon btn-outline-danger" onclick="deleteCategory(' + cat.id + ')"><i class="bx bx-trash"></i></button>' +
                            '</div></td></tr>');
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        $('#categories-tbody').html('<tr><td colspan="4" class="text-center py-5 text-muted">เซสชันหมดอายุ กรุณา <a href="/login" class="text-primary">เข้าสู่ระบบ</a> อีกครั้ง</td></tr>');
                    } else {
                        $('#categories-tbody').html('<tr><td colspan="4" class="text-center py-5 text-danger">เกิดข้อผิดพลาดในการโหลดข้อมูล</td></tr>');
                    }
                }
            });
        }

        function openCreateModal() {
            $('#modal-title').text('เพิ่มหมวดหมู่');
            $('#modal-submit-btn').text('บันทึก');
            $('#category-id').val('');
            $('#category-name').val('');
            $('#category-form').off('submit').on('submit', handleCreate);
            $('#category-modal')[0].showModal();
        }

        function openEditModal(id, name, status) {
            $('#modal-title').text('แก้ไขหมวดหมู่');
            $('#modal-submit-btn').text('อัปเดต');
            $('#category-id').val(id);
            $('#category-name').val(name);
            $('#category-form').off('submit').on('submit', handleEdit);
            $('#category-modal')[0].showModal();
        }

        function closeModal() { $('#category-modal')[0].close(); }

        function handleCreate(e) {
            e.preventDefault();
            var btn = $('#modal-submit-btn');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>กำลังบันทึก...');
            $.ajax({
                url: API, method: 'POST', headers: getHeaders(), data: { name: $('#category-name').val() },
                success: function() { closeModal(); loadCategories(); showToast('เพิ่มหมวดหมู่สำเร็จ', 'success'); },
                error: function(xhr) { var msg = 'เกิดข้อผิดพลาด'; try { msg = JSON.parse(xhr.responseText).message || msg; } catch(e) {} showToast(msg, 'error'); btn.prop('disabled', false).text('บันทึก'); }
            });
        }

        function handleEdit(e) {
            e.preventDefault();
            var id = $('#category-id').val();
            var btn = $('#modal-submit-btn');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>กำลังอัปเดต...');
            $.ajax({
                url: API + '/' + id, method: 'PUT', headers: getHeaders(), data: { name: $('#category-name').val() },
                success: function() { closeModal(); loadCategories(); showToast('อัปเดตหมวดหมู่สำเร็จ', 'success'); },
                error: function(xhr) { var msg = 'เกิดข้อผิดพลาด'; try { msg = JSON.parse(xhr.responseText).message || msg; } catch(e) {} showToast(msg, 'error'); btn.prop('disabled', false).text('อัปเดต'); }
            });
        }

        function deleteCategory(id) {
            if (!confirm('คุณแน่ใจหรือไม่ที่จะลบหมวดหมู่นี้?')) return;
            $.ajax({
                url: API + '/' + id, method: 'DELETE', headers: getHeaders(),
                success: function() { loadCategories(); showToast('ลบหมวดหมู่สำเร็จ', 'success'); },
                error: function(xhr) { var msg = 'เกิดข้อผิดพลาด'; try { msg = JSON.parse(xhr.responseText).message || msg; } catch(e) {} showToast(msg, 'error'); }
            });
        }

        function showToast(msg, type) {
            $('.toast').remove();
            $('<div class="toast ' + (type || 'info') + '">').text(msg).appendTo('body');
            setTimeout(function() { $('.toast').fadeOut(300, function() { $(this).remove(); }); }, 3000);
        }
    </script>
@endsection
