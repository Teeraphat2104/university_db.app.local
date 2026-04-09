@extends('layouts.app')

@section('title', 'จัดการเอกสาร')
@section('header', 'ระบบจัดการเอกสาร')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Search & Actions -->
    <div class="card p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-600 mb-2">ค้นหาเอกสาร</label>
                <div class="relative">
                    <input type="text" id="searchKeyword" class="input-field w-full pl-12 pr-4 py-3 rounded-xl" placeholder="พิมพ์ชื่อเอกสารที่ต้องการค้นหา...">
                    <i class="fas fa-search absolute left-4 top-3.5 text-slate-400"></i>
                </div>
            </div>
            <div class="w-full md:w-40">
                <label class="block text-sm font-medium text-slate-600 mb-2">ปี</label>
                <select id="filterYear" class="input-field w-full py-3 rounded-xl">
                    <option value="">ทั้งหมด</option>
                    @foreach(range(date('Y'), date('Y')-10) as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-slate-600 mb-2">หมวดหมู่</label>
                <select id="filterCategory" class="input-field w-full py-3 rounded-xl">
                    <option value="">ทั้งหมด</option>
                </select>
            </div>
            <button id="btnSearch" class="btn-primary px-6 py-3 rounded-xl text-white font-medium">
                <i class="fas fa-search mr-2"></i> ค้นหา
            </button>
            <button id="btnAddDocument" class="btn-success px-6 py-3 rounded-xl text-white font-medium">
                <i class="fas fa-plus mr-2"></i> เพิ่มเอกสาร
            </button>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="table-header">
                    <th class="px-6 py-4 text-left">#</th>
                    <th class="px-6 py-4 text-left">ชื่อเอกสาร</th>
                    <th class="px-6 py-4 text-left">หมวดหมู่</th>
                    <th class="px-6 py-4 text-center">ปี</th>
                    <th class="px-6 py-4 text-left">วันที่อัปโหลด</th>
                    <th class="px-6 py-4 text-right">จัดการ</th>
                </tr>
            </thead>
            <tbody id="documentList">
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="fas fa-spinner fa-spin text-2xl text-primary-500 mb-2"></i>
                        <p>กำลังโหลดข้อมูล...</p>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div id="pagination" class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
        </div>
    </div>
</div>

<!-- Modal for Create/Edit -->
<div id="docModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center hidden">
    <div class="modal-content w-full max-w-lg mx-4">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 id="modalTitle" class="text-lg font-bold text-slate-700">เพิ่มเอกสารใหม่</h3>
            <button class="closeModal text-slate-400 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="docForm" enctype="multipart/form-data">
            <input type="hidden" id="docId" name="id">
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">ชื่อเอกสาร <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="docTitle" required class="input-field w-full px-4 py-3 rounded-xl">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">หมวดหมู่ <span class="text-red-500">*</span></label>
                        <select name="category_id" id="docCategory" required class="input-field w-full px-4 py-3 rounded-xl">
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">ปี <span class="text-red-500">*</span></label>
                        <select name="year" id="docYear" required class="input-field w-full px-4 py-3 rounded-xl">
                            @foreach(range(date('Y'), date('Y')-20) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">ไฟล์เอกสาร (PDF, Word, Excel) <span id="fileRequired" class="text-amber-600">*</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 rounded-xl border-2 border-dashed border-slate-300" style="background: #f8fafc;" id="dropArea">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-slate-400 text-3xl mb-2"></i>
                            <div class="flex text-sm text-slate-500 justify-center">
                                <span class="text-primary-600 font-medium">คลิกเพื่ออัปโหลด</span>
                                <p class="pl-1">หรือลากไฟล์มาวางที่นี่</p>
                            </div>
                            <p class="text-xs text-slate-400">PDF, XLSX, DOCX ไม่เกิน 10MB</p>
                        </div>
                        <input id="docFile" name="file" type="file" class="absolute inset-0 opacity-0 cursor-pointer" accept=".pdf,.xlsx,.docx">
                    </div>
                    <p id="fileNameDisplay" class="mt-2 text-sm text-primary-600 font-medium hidden"></p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end space-x-3">
                <button type="button" class="closeModal px-4 py-2 rounded-xl border-2 border-slate-200 text-slate-600 hover:bg-slate-50">ยกเลิก</button>
                <button type="submit" class="btn-primary px-6 py-2 rounded-xl text-white">
                    <i class="fas fa-save mr-2"></i> บันทึกข้อมูล
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
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
        const API_URL = '/api/v1';
        let categories = [];
        let currentPage = 1;

        loadCategories();
        loadDocuments();

        $('#btnSearch').click(() => {
            currentPage = 1;
            loadDocuments();
        });

        $('#searchKeyword').on('keypress', (e) => {
            if(e.which == 13) loadDocuments();
        });

        $('#btnAddDocument').click(() => {
            resetForm();
            $('#modalTitle').text('เพิ่มเอกสารใหม่');
            $('#fileRequired').show();
            $('#docModal').removeClass('hidden');
        });

        $('.closeModal').click(() => {
            $('#docModal').addClass('hidden');
        });

        $('#docFile').change(function() {
            const fileName = $(this).val().split('\\').pop();
            if(fileName) {
                $('#fileNameDisplay').text('ไฟล์ที่เลือก: ' + fileName).removeClass('hidden');
            } else {
                $('#fileNameDisplay').addClass('hidden');
            }
        });

        $('#docForm').submit(function(e) {
            e.preventDefault();
            const id = $('#docId').val();
            const formData = new FormData(this);
            const isEdit = id !== '';

            let url = API_URL + '/documents';
            let method = 'POST';

            if (isEdit) {
                url = API_URL + '/documents/' + id;
                formData.append('_method', 'PUT');
            }

            $('#btnSave').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> กำลังบันทึก...');

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (res) => {
                    showAlert('สำเร็จ', res.message);
                    $('#docModal').addClass('hidden');
                    loadDocuments();
                },
                error: (err) => {
                    showAlert('เกิดข้อผิดพลาด', err.responseJSON?.message || 'โปรดตรวจสอบความถูกต้องของข้อมูล', 'error');
                },
                complete: () => {
                    $('#btnSave').prop('disabled', false).html('<i class="fas fa-save mr-2"></i> บันทึกข้อมูล');
                }
            });
        });

        function loadCategories() {
            $.get(API_URL + '/categories', (res) => {
                categories = res.data;
                const options = categories.map(cat => `<option value="${cat.id}">${cat.name}</option>`).join('');
                $('#filterCategory').append(options);
                $('#docCategory').html('<option value="">เลือกหมวดหมู่</option>' + options);
            });
        }

        function loadDocuments(page = 1) {
            currentPage = page;
            const params = {
                page: page,
                keyword: $('#searchKeyword').val(),
                year: $('#filterYear').val(),
                category_id: $('#filterCategory').val()
            };

            $('#documentList').html(`
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="fas fa-spinner fa-spin text-2xl text-primary-500 mb-2"></i>
                        <p>กำลังโหลดข้อมูล...</p>
                    </td>
                </tr>
            `);

            $.get(API_URL + '/documents', params, (res) => {
                renderTable(res.data);
                renderPagination(res.pagination);
            });
        }

        function renderTable(data) {
            if (data.length === 0) {
                $('#documentList').html(`
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                            <i class="fas fa-folder-open text-4xl mb-3 text-slate-300"></i>
                            <p class="text-lg">ไม่พบข้อมูลเอกสาร</p>
                            <p class="text-sm">ลองเปลี่ยนเงื่อนไขการค้นหาใหม่</p>
                        </td>
                    </tr>
                `);
                return;
            }

            let html = '';
            data.forEach((doc, index) => {
                html += `
                    <tr class="table-row">
                        <td class="px-6 py-4 text-slate-400 font-medium">${(currentPage - 1) * 10 + index + 1}</td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-700">${doc.title}</div>
                            <div class="text-xs text-slate-400">ID: ${doc.id}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="badge badge-primary">${doc.category_name || 'ทั่วไป'}</span>
                        </td>
                        <td class="px-6 py-4 text-center font-medium text-amber-600">${doc.year}</td>
                        <td class="px-6 py-4 text-slate-400">${doc.created_at}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="${doc.file_url}" target="_blank" class="text-primary-500 hover:text-primary-700 p-2" title="ดูเอกสาร">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button onclick="editDoc(${doc.id})" class="text-amber-500 hover:text-amber-700 p-2" title="แก้ไข">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteDoc(${doc.id})" class="text-red-500 hover:text-red-700 p-2" title="ลบ">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#documentList').html(html);
        }

        function renderPagination(meta) {
            if (!meta || meta.last_page <= 1) {
                $('#pagination').addClass('hidden');
                return;
            }

            $('#pagination').removeClass('hidden');
            let html = `<div class="text-sm text-slate-500">แสดงหน้าที่ ${meta.current_page} จาก ${meta.last_page} (ทั้งหมด ${meta.total} รายการ)</div>`;
            html += '<div class="flex space-x-1">';
            
            for (let i = 1; i <= meta.last_page; i++) {
                const activeClass = i === meta.current_page ? 'active' : '';
                html += `<button onclick="goToPage(${i})" class="pagination-btn px-3 py-1 rounded-lg ${activeClass}">${i}</button>`;
            }

            html += '</div>';
            $('#pagination').html(html);
        }

        window.goToPage = (page) => {
            loadDocuments(page);
        };

        window.editDoc = (id) => {
            $.get(API_URL + '/documents', (res) => {
                const doc = res.data.find(d => d.id == id);
                if (doc) {
                    $('#docId').val(doc.id);
                    $('#docTitle').val(doc.title);
                    $('#docCategory').val(doc.category_id);
                    $('#docYear').val(doc.year);
                    $('#modalTitle').text('แก้ไขข้อมูลเอกสาร');
                    $('#fileRequired').hide();
                    $('#fileNameDisplay').addClass('hidden');
                    $('#docModal').removeClass('hidden');
                }
            });
        };

        window.deleteDoc = (id) => {
            showConfirm('ยืนยันการลบ', 'คุณแน่ใจหรือไม่ว่าต้องการลบเอกสารนี้?').then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: API_URL + '/documents/' + id,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: (res) => {
                            showAlert('สำเร็จ', res.message);
                            loadDocuments();
                        },
                        error: (err) => {
                            showAlert('เกิดข้อผิดพลาด', 'เกิดข้อผิดพลาดในการลบ', 'error');
                        }
                    });
                }
            });
        };

        function resetForm() {
            $('#docId').val('');
            $('#docForm')[0].reset();
            $('#fileNameDisplay').addClass('hidden');
        }
    });
</script>
@endpush
