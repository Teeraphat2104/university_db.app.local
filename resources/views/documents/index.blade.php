@extends('layouts.app')

@section('title', 'จัดการเอกสาร')
@section('header', 'จัดการเอกสาร')

@section('content')
<div class="card mb-6 p-6">
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="flex-1">
            <input type="text" id="searchKeyword" placeholder="ค้นหาชื่อเอกสาร..." 
                   class="input-field w-full px-4 py-3 rounded-xl">
        </div>
        <div class="w-full md:w-48">
            <select id="filterYear" class="input-field w-full px-4 py-3 rounded-xl">
                <option value="">ทุกปี</option>
            </select>
        </div>
        <div class="w-full md:w-48">
            <select id="filterCategory" class="input-field w-full px-4 py-3 rounded-xl">
                <option value="">ทุกหมวดหมู่</option>
            </select>
        </div>
        <button onclick="loadDocuments()" class="btn-primary px-6 py-3 rounded-xl text-white font-medium">
            <i class="fas fa-search mr-2"></i>ค้นหา
        </button>
    </div>
    
    <div class="flex justify-end">
        <button onclick="openModal('create')" class="btn-success px-6 py-3 rounded-xl text-white font-medium">
            <i class="fas fa-plus mr-2"></i>เพิ่มเอกสาร
        </button>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="table-header">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">ชื่อเอกสาร</th>
                    <th class="px-6 py-3 text-left">หมวดหมู่</th>
                    <th class="px-6 py-3 text-left">ปี</th>
                    <th class="px-6 py-3 text-left">วันที่อัปโหลด</th>
                    <th class="px-6 py-3 text-left">จัดการ</th>
                </tr>
            </thead>
            <tbody id="documentsTable">
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-400">กำลังโหลด...</td>
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
<div id="documentModal" class="fixed inset-0 modal-overlay hidden z-50 flex items-center justify-center">
    <div class="modal-content w-full max-w-md mx-4">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-slate-700" id="modalTitle">เพิ่มเอกสาร</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="documentForm" class="p-6">
            @csrf
            <input type="hidden" id="documentId">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-600 mb-2">ชื่อเอกสาร *</label>
                <input type="text" id="documentTitle" required
                       class="input-field w-full px-4 py-3 rounded-xl">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-600 mb-2">หมวดหมู่ *</label>
                <select id="documentCategory" required
                        class="input-field w-full px-4 py-3 rounded-xl">
                    <option value="">เลือกหมวดหมู่</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-600 mb-2">ปี *</label>
                <input type="number" id="documentYear" required
                       class="input-field w-full px-4 py-3 rounded-xl">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-600 mb-2">ไฟล์ <span id="fileRequired" class="text-amber-600">(PDF, Excel, Word)</span> *</label>
                <input type="file" id="documentFile" accept=".pdf,.xlsx,.docx"
                       class="input-field w-full px-4 py-3 rounded-xl">
                <p class="text-xs text-slate-400 mt-1">ขนาดไฟล์ไม่เกิน 10MB</p>
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
    loadCategoriesForFilters();
    loadDocuments();
    populateYearFilter();
});

function populateYearFilter() {
    const currentYear = new Date().getFullYear();
    let options = '<option value="">ทุกปี</option>';
    for (let year = currentYear; year >= currentYear - 10; year--) {
        options += `<option value="${year}">${year}</option>`;
    }
    $('#filterYear').html(options);
}

function loadCategoriesForFilters() {
    $.get('/api/v1/categories', function(response) {
        if (response.status === 200) {
            let options = '<option value="">ทุกหมวดหมู่</option>';
            response.data.forEach(function(cat) {
                options += `<option value="${cat.id}">${cat.name}</option>`;
            });
            $('#filterCategory').html(options);
            $('#documentCategory').html(options);
        }
    });
}

function loadDocuments(page = 1) {
    currentPage = page;
    const params = {
        page: page,
        per_page: 10,
        keyword: $('#searchKeyword').val(),
        year: $('#filterYear').val(),
        category_id: $('#filterCategory').val()
    };

    $.get('/api/v1/documents', params, function(response) {
        if (response.status === 200) {
            let tableHtml = '';
            response.data.forEach(function(doc, index) {
                tableHtml += `
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">${(page - 1) * 10 + index + 1}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-700">${doc.title}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><span class="badge badge-primary">${doc.category_name || '-'}</span></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-600 font-medium">${doc.year}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">${doc.created_at}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="${doc.file_url}" target="_blank" class="text-primary-500 hover:text-primary-700 mr-3">
                                <i class="fas fa-download"></i>
                            </a>
                            <button onclick="openModal('edit', ${doc.id})" class="text-amber-500 hover:text-amber-700 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteDocument(${doc.id})" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#documentsTable').html(tableHtml || '<tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">ไม่มีเอกสาร</td></tr>');
            
            $('#paginationInfo').text(`แสดง ${(page - 1) * 10 + 1} - ${Math.min(page * 10, response.pagination.total)} จาก ${response.pagination.total} รายการ`);
            
            let paginationHtml = '';
            for (let i = 1; i <= response.pagination.last_page; i++) {
                paginationHtml += `<button onclick="loadDocuments(${i})" class="pagination-btn px-3 py-1 rounded-lg ${i === page ? 'active' : ''}">${i}</button>`;
            }
            $('#paginationButtons').html(paginationHtml);
        }
    });
}

function openModal(mode, id = null) {
    if (mode === 'edit' && id) {
        $('#modalTitle').text('แก้ไขเอกสาร');
        $('#documentId').val(id);
        $('#fileRequired').text('(เปลี่ยนไฟล์ใหม่)');
        $('#documentFile').removeAttr('required');
        
        $.get('/api/v1/documents', { per_page: 100 }, function(response) {
            const doc = response.data.find(d => d.id === id);
            if (doc) {
                $('#documentTitle').val(doc.title);
                $('#documentCategory').val(doc.category_id);
                $('#documentYear').val(doc.year);
            }
        });
    } else {
        $('#modalTitle').text('เพิ่มเอกสาร');
        $('#documentId').val('');
        $('#documentTitle').val('');
        $('#documentCategory').val('');
        $('#documentYear').val(new Date().getFullYear());
        $('#fileRequired').text('(PDF, Excel, Word)');
        $('#documentFile').attr('required', 'required');
    }
    $('#documentModal').removeClass('hidden');
}

function closeModal() {
    $('#documentModal').addClass('hidden');
    $('#documentForm')[0].reset();
}

$('#documentForm').on('submit', function(e) {
    e.preventDefault();
    const id = $('#documentId').val();
    const formData = new FormData();
    formData.append('title', $('#documentTitle').val());
    formData.append('category_id', $('#documentCategory').val());
    formData.append('year', $('#documentYear').val());
    
    const fileInput = $('#documentFile')[0];
    if (fileInput.files.length > 0) {
        formData.append('file', fileInput.files[0]);
    }

    const url = id ? `/api/v1/documents/${id}` : '/api/v1/documents';
    const method = id ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        method: method,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.status === 200) {
                closeModal();
                loadDocuments();
                showAlert('สำเร็จ', response.message);
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            showAlert('เกิดข้อผิดพลาด', response.message || 'เกิดข้อผิดพลาด', 'error');
        }
    });
});

function deleteDocument(id) {
    showConfirm('ยืนยันการลบ', 'คุณต้องการลบเอกสารนี้หรือไม่?').then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/v1/documents/${id}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.status === 200) {
                        loadDocuments();
                        showAlert('สำเร็จ', response.message);
                    }
                },
                error: function(xhr) {
                    showAlert('เกิดข้อผิดพลาด', 'เกิดข้อผิดพลาด', 'error');
                }
            });
        }
    });
}
</script>
@endpush
@endsection
