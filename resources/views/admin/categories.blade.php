@extends('layouts.app')

@section('title', 'จัดการหมวดหมู่ - Admin')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-title">หมวดหมู่กิจกรรม</h2>
        <p class="page-subtitle">จัดการหมวดหมู่สำหรับกิจกรรมของมหาวิทยาลัย</p>
    </div>
    <button class="btn btn-primary" onclick="openCreateModal()">
        <i class="fa-solid fa-plus"></i> เพิ่มหมวดหมู่
    </button>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="data-table" id="categories-table">
            <thead>
                <tr>
                    <th class="w-14">ID</th>
                    <th>ชื่อหมวดหมู่</th>
                    <th class="w-28">สถานะ</th>
                    <th class="w-36">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody id="categories-tbody">
                <tr><td colspan="4" class="loading-cell"><i class="fa-solid fa-spinner fa-spin text-2xl block mb-3"></i>กำลังโหลด...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div id="empty-state" class="empty-state hidden">
    <div class="empty-state-icon"><i class="fa-regular fa-folder-open"></i></div>
    <h3>ยังไม่มีหมวดหมู่</h3>
    <p>สร้างหมวดหมู่แรกเพื่อจัดการกิจกรรม</p>
    <button class="btn btn-primary" onclick="openCreateModal()"><i class="fa-solid fa-plus"></i> สร้างหมวดหมู่</button>
</div>

<dialog id="category-modal" class="modal-sm">
    <form id="category-form">
        <div class="dialog-header">
            <h3 id="modal-title">เพิ่มหมวดหมู่</h3>
            <button type="button" class="btn btn-sm btn-muted py-1.5 px-2" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="dialog-body">
            <input type="hidden" id="category-id">
            <div>
                <label class="field-label">ชื่อหมวดหมู่</label>
                <input type="text" id="category-name" name="name" required placeholder="กรุณากรอกชื่อหมวดหมู่">
            </div>
        </div>
        <div class="dialog-footer">
            <button type="button" class="btn btn-muted" onclick="closeModal()">ยกเลิก</button>
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
            return {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            };
        }

        $(function() {
            if (!token) {
                $('#categories-tbody').html(
                    '<tr><td colspan="4" class="loading-cell">กรุณา <a href="/login" class="text-indigo-600">เข้าสู่ระบบ</a> ก่อน</td></tr>'
                    );
                return;
            }
            loadCategories();
        });

        function loadCategories() {
            $.ajax({
                url: API,
                method: 'GET',
                headers: getHeaders(),
                success: function(json) {
                    var tbody = $('#categories-tbody');
                    tbody.empty();

                    if (!json.data || json.data.length === 0) {
                        $('#empty-state').removeClass('hidden');
                        return;
                    }
                    $('#empty-state').addClass('hidden');

                    $.each(json.data, function(i, cat) {
                        var statusHtml = cat.status ?
                            '<span class="badge badge-success">เปิดใช้งาน</span>' :
                            '<span class="badge badge-warning">ปิดใช้งาน</span>';

                        var row = '<tr>' +
                            '<td class="cat-id-cell">' + cat.id + '</td>' +
                            '<td class="cat-name-cell">' + $('<span>').text(cat.name).html() + '</td>' +
                            '<td>' + statusHtml + '</td>' +
                            '<td>' +
                            '<div class="flex gap-2">' +
                            '<button class="btn btn-sm btn-secondary p-1.5" onclick="openEditModal(' + cat
                            .id + ',\'' + $('<span>').text(cat.name).html().replace(/'/g, "\\'") +
                            '\',' + cat.status +
                            ')"><i class="fa-solid fa-pen-to-square"></i></button>' +
                            '<button class="btn btn-sm btn-secondary p-1.5 text-red-500" onclick="deleteCategory(' + cat
                            .id +
                            ')"><i class="fa-solid fa-trash-can"></i></button>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';

                        tbody.append(row);
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        $('#categories-tbody').html(
                            '<tr><td colspan="4" class="loading-cell">เซสชันหมดอายุ กรุณา <a href="/login" class="text-indigo-600">เข้าสู่ระบบ</a> อีกครั้ง</td></tr>'
                            );
                    } else {
                        $('#categories-tbody').html(
                            '<tr><td colspan="4" class="loading-cell text-red-500">เกิดข้อผิดพลาดในการโหลดข้อมูล</td></tr>'
                            );
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

        function closeModal() {
            $('#category-modal')[0].close();
        }

        function handleCreate(e) {
            e.preventDefault();
            var btn = $('#modal-submit-btn');
            btn.prop('disabled', true).text('กำลังบันทึก...');

            $.ajax({
                url: API,
                method: 'POST',
                headers: getHeaders(),
                data: {
                    name: $('#category-name').val()
                },
                success: function() {
                    closeModal();
                    loadCategories();
                    showToast('เพิ่มหมวดหมู่สำเร็จ', 'success');
                },
                error: function(xhr) {
                    var msg = 'เกิดข้อผิดพลาด';
                    try {
                        msg = JSON.parse(xhr.responseText).message || msg;
                    } catch (e) {}
                    showToast(msg, 'error');
                    btn.prop('disabled', false).text('บันทึก');
                }
            });
        }

        function handleEdit(e) {
            e.preventDefault();
            var id = $('#category-id').val();
            var btn = $('#modal-submit-btn');
            btn.prop('disabled', true).text('กำลังอัปเดต...');

            $.ajax({
                url: API + '/' + id,
                method: 'PUT',
                headers: getHeaders(),
                data: {
                    name: $('#category-name').val()
                },
                success: function() {
                    closeModal();
                    loadCategories();
                    showToast('อัปเดตหมวดหมู่สำเร็จ', 'success');
                },
                error: function(xhr) {
                    var msg = 'เกิดข้อผิดพลาด';
                    try {
                        msg = JSON.parse(xhr.responseText).message || msg;
                    } catch (e) {}
                    showToast(msg, 'error');
                    btn.prop('disabled', false).text('อัปเดต');
                }
            });
        }

        function deleteCategory(id) {
            if (!confirm('คุณแน่ใจหรือไม่ที่จะลบหมวดหมู่นี้?')) return;

            $.ajax({
                url: API + '/' + id,
                method: 'DELETE',
                headers: getHeaders(),
                success: function() {
                    loadCategories();
                    showToast('ลบหมวดหมู่สำเร็จ', 'success');
                },
                error: function(xhr) {
                    var msg = 'เกิดข้อผิดพลาด';
                    try {
                        msg = JSON.parse(xhr.responseText).message || msg;
                    } catch (e) {}
                    showToast(msg, 'error');
                }
            });
        }

        function showToast(msg, type) {
            $('.toast').remove();
            var toast = $('<div class="toast ' + (type || 'info') + '">').text(msg);
            $('body').append(toast);
            setTimeout(function() {
                toast.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    </script>
@endsection
