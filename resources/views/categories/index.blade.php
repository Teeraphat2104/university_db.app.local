@extends('layouts.app')

@section('title', 'จัดการหมวดหมู่')
@section('header', 'จัดการหมวดหมู่')

@section('content')
<div class="card mb-6 p-6">
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="flex-1">
            <input type="text" id="searchCategory" placeholder="ค้นหาหมวดหมู่..." 
                   class="input-field w-full px-4 py-3 rounded-xl">
        </div>
        <button onclick="loadCategories()" class="btn-primary px-6 py-3 rounded-xl text-white font-medium">
            <i class="fas fa-search mr-2"></i>ค้นหา
        </button>
    </div>
    
    <div class="flex justify-end">
        <button onclick="openModal('create')" class="btn-success px-6 py-3 rounded-xl text-white font-medium">
            <i class="fas fa-plus mr-2"></i>เพิ่มหมวดหมู่
        </button>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="table-header">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">ชื่อหมวดหมู่</th>
                    <th class="px-6 py-3 text-left">จำนวนเอกสาร</th>
                    <th class="px-6 py-3 text-left">วันที่สร้าง</th>
                    <th class="px-6 py-3 text-left">จัดการ</th>
                </tr>
            </thead>
            <tbody id="categoriesTable">
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">กำลังโหลด...</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-100">
        <nav class="flex justify-between items-center">
            <span class="text-sm text-slate-500" id="paginationInfo">แสดง 0 - 0 จาก 0 รายการ</span>
            <div class="flex gap-2" id="paginationButtons"></div>
        </nav>
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="categoryModal" class="fixed inset-0 modal-overlay hidden z-50 flex items-center justify-center">
    <div class="modal-content w-full max-w-md mx-4">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-slate-700" id="modalTitle">เพิ่มหมวดหมู่</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="categoryForm" class="p-6">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-600 mb-2">ชื่อหมวดหมู่ *</label>
                <input type="text" id="categoryName" required
                       class="input-field w-full px-4 py-3 rounded-xl"
                       placeholder="กรอกชื่อหมวดหมู่">
            </div>
            
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-xl border-2 border-slate-200 text-slate-600 hover:bg-slate-50">ยกเลิก</button>
                <button type="submit" class="btn-primary px-4 py-2 rounded-xl text-white">บันทึก</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let currentPage = 1;

function showAlert(title, text, icon = 'success') {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: 'ตกลง',
        confirmButtonColor: '#0ea5e9',
        background: '#ffffff',
        color: '#334155'
    });
}

function showConfirm(title, text) {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'ลบ',
        cancelButtonText: 'ยกเลิก',
        background: '#ffffff',
        color: '#334155'
    });
}

$(document).ready(function() {
    loadCategories();
});

function loadCategories(page = 1) {
    currentPage = page;
    const params = {
        page: page,
        per_page: 10,
        search: $('#searchCategory').val()
    };

    $.get('/api/v1/categories', params, function(response) {
        if (response.status === 200) {
            let tableHtml = '';
            response.data.forEach(function(cat, index) {
                tableHtml += `
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">${(page - 1) * 10 + index + 1}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-700">${cat.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><span class="badge badge-success">${cat.documents_count || 0}</span></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">${cat.created_at}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button onclick="openModal('edit', ${cat.id})" class="text-amber-500 hover:text-amber-700 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteCategory(${cat.id})" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#categoriesTable').html(tableHtml || '<tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">ไม่มีหมวดหมู่</td></tr>');
            
            $('#paginationInfo').text(`แสดง ${(page - 1) * 10 + 1} - ${Math.min(page * 10, response.pagination.total)} จาก ${response.pagination.total} รายการ`);
            
            let paginationHtml = '';
            for (let i = 1; i <= response.pagination.last_page; i++) {
                paginationHtml += `<button onclick="loadCategories(${i})" class="pagination-btn px-3 py-1 rounded-lg ${i === page ? 'active' : ''}">${i}</button>`;
            }
            $('#paginationButtons').html(paginationHtml);
        }
    });
}

function openModal(mode, id = null) {
    if (mode === 'edit' && id) {
        $('#modalTitle').text('แก้ไขหมวดหมู่');
        
        $.get('/api/v1/categories', { per_page: 100 }, function(response) {
            const cat = response.data.find(c => c.id === id);
            if (cat) {
                $('#categoryName').val(cat.name);
            }
        });
        
        $('#categoryForm').data('id', id);
    } else {
        $('#modalTitle').text('เพิ่มหมวดหมู่');
        $('#categoryName').val('');
        $('#categoryForm').removeData('id');
    }
    $('#categoryModal').removeClass('hidden');
}

function closeModal() {
    $('#categoryModal').addClass('hidden');
    $('#categoryForm')[0].reset();
    $('#categoryForm').removeData('id');
}

$('#categoryForm').on('submit', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    const url = id ? `/api/v1/categories/${id}` : '/api/v1/categories';
    const method = id ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        method: method,
        data: {
            name: $('#categoryName').val()
        },
        success: function(response) {
            if (response.status === 200) {
                closeModal();
                loadCategories();
                showAlert('สำเร็จ', response.message);
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            showAlert('เกิดข้อผิดพลาด', response.message || 'เกิดข้อผิดพลาด', 'error');
        }
    });
});

function deleteCategory(id) {
    showConfirm('ยืนยันการลบ', 'คุณต้องการลบหมวดหมู่นี้หรือไม่?').then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/v1/categories/${id}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.status === 200) {
                        loadCategories();
                        showAlert('สำเร็จ', response.message);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    showAlert('เกิดข้อผิดพลาด', response.message || 'เกิดข้อผิดพลาด', 'error');
                }
            });
        }
    });
}
</script>
@endpush
@endsection
