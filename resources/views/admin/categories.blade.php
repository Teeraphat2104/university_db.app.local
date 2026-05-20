@extends('layouts.app')

@section('title', 'จัดการหมวดหมู่ - Admin')

@section('style')
    <style>
        .cat-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .cat-page-header h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .cat-page-header p {
            color: var(--text-muted);
        }

        .cat-id-cell {
            font-weight: 600;
            color: var(--text-muted);
        }

        .cat-name-cell {
            font-weight: 600;
        }

        .cat-empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FEF3C7, #FDE68A);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .cat-empty-icon i {
            font-size: 32px;
            color: #B45309;
        }

        .cat-empty h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .cat-empty p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .loading-cell {
            text-align: center;
            padding: 3rem;
            color: var(--text-muted);
        }
    </style>
@endsection

@section('content')
    <div class="cat-page-header">
        <div>
            <h2>หมวดหมู่กิจกรรม</h2>
            <p>จัดการหมวดหมู่สำหรับกิจกรรมของมหาวิทยาลัย</p>
        </div>
        <button class="btn btn-primary" onclick="openCreateModal()">
            <i class="fa-solid fa-plus"></i>
            เพิ่มหมวดหมู่
        </button>
    </div>

    <div class="card">
        <div class="card-body" style="padding:0">
            <table class="data-table" id="categories-table">
                <thead>
                    <tr>
                        <th style="width:60px">ID</th>
                        <th>ชื่อหมวดหมู่</th>
                        <th style="width:120px">สถานะ</th>
                        <th style="width:140px">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody id="categories-tbody">
                    <tr>
                        <td colspan="4" class="loading-cell">
                            <i class="fa-solid fa-spinner fa-spin"
                                style="font-size:1.5rem;display:block;margin-bottom:0.75rem"></i>
                            กำลังโหลด...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="empty-state" class="empty-state cat-empty" style="display:none">
        <div class="cat-empty-icon">
            <i class="fa-regular fa-folder-open"></i>
        </div>
        <h3>ยังไม่มีหมวดหมู่</h3>
        <p>สร้างหมวดหมู่แรกเพื่อจัดการกิจกรรม</p>
        <button class="btn btn-primary" onclick="openCreateModal()">
            <i class="fa-solid fa-plus"></i>
            สร้างหมวดหมู่
        </button>
    </div>

    <dialog id="category-modal" class="modal-sm">
        <form id="category-form">
            <div class="dialog-header">
                <h3 id="modal-title">เพิ่มหมวดหมู่</h3>
                <button type="button" class="btn btn-sm btn-muted" onclick="closeModal()" style="padding:0.375rem 0.5rem">
                    <i class="fa-solid fa-xmark"></i>
                </button>
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
                    '<tr><td colspan="4" class="loading-cell">กรุณา <a href="/login" style="color:var(--primary)">เข้าสู่ระบบ</a> ก่อน</td></tr>'
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
                        $('#empty-state').show();
                        return;
                    }
                    $('#empty-state').hide();

                    $.each(json.data, function(i, cat) {
                        var statusHtml = cat.status ?
                            '<span class="badge badge-success">เปิดใช้งาน</span>' :
                            '<span class="badge badge-warning">ปิดใช้งาน</span>';

                        var row = '<tr>' +
                            '<td class="cat-id-cell">' + cat.id + '</td>' +
                            '<td class="cat-name-cell">' + $('<span>').text(cat.name).html() + '</td>' +
                            '<td>' + statusHtml + '</td>' +
                            '<td>' +
                            '<div style="display:flex;gap:0.5rem">' +
                            '<button class="btn btn-sm btn-secondary" onclick="openEditModal(' + cat
                            .id + ',\'' + $('<span>').text(cat.name).html().replace(/'/g, "\\'") +
                            '\',' + cat.status +
                            ')" style="padding:0.375rem"><i class="fa-regular fa-pen-to-square"></i></button>' +
                            '<button class="btn btn-sm btn-secondary" onclick="deleteCategory(' + cat
                            .id +
                            ')" style="padding:0.375rem;color:var(--danger)"><i class="fa-regular fa-trash-can"></i></button>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';

                        tbody.append(row);
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        $('#categories-tbody').html(
                            '<tr><td colspan="4" class="loading-cell">เซสชันหมดอายุ กรุณา <a href="/login" style="color:var(--primary)">เข้าสู่ระบบ</a> อีกครั้ง</td></tr>'
                            );
                    } else {
                        $('#categories-tbody').html(
                            '<tr><td colspan="4" class="loading-cell" style="color:var(--danger)">เกิดข้อผิดพลาดในการโหลดข้อมูล</td></tr>'
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
