@extends('layouts.app')

@section('title', 'จัดการเอกสาร')
@section('header', 'ระบบจัดการเอกสาร')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Search & Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">ค้นหาเอกสาร</label>
                <div class="relative">
                    <input type="text" id="searchKeyword" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="พิมพ์ชื่อเอกสารที่ต้องการค้นหา...">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="w-full md:w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">ปี</label>
                <select id="filterYear" class="w-full py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">ทั้งหมด</option>
                    @foreach(range(date('Y'), date('Y')-10) as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">หมวดหมู่</label>
                <select id="filterCategory" class="w-full py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">ทั้งหมด</option>
                </select>
            </div>
            <button id="btnSearch" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center justify-center">
                <i class="fas fa-search mr-2"></i> ค้นหา
            </button>
            <button id="btnAddDocument" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> เพิ่มเอกสาร
            </button>
        </div>
    </div>

    <!-- Results Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm font-medium">
                <tr>
                    <th class="px-6 py-4">#</th>
                    <th class="px-6 py-4">ชื่อเอกสาร</th>
                    <th class="px-6 py-4">หมวดหมู่</th>
                    <th class="px-6 py-4 text-center">ปี</th>
                    <th class="px-6 py-4">วันที่อัปโหลด</th>
                    <th class="px-6 py-4 text-right">จัดการ</th>
                </tr>
            </thead>
            <tbody id="documentList" class="divide-y divide-gray-100 text-sm">
                <!-- Data will be loaded via AJAX -->
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>กำลังโหลดข้อมูล...</p>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div id="pagination" class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <!-- Pagination will be loaded via AJAX -->
        </div>
    </div>
</div>

<!-- Modal for Create/Edit -->
<div id="docModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 id="modalTitle" class="text-lg font-bold text-gray-800">เพิ่มเอกสารใหม่</h3>
            <button class="closeModal text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="docForm" enctype="multipart/form-data">
            <input type="hidden" id="docId" name="id">
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อเอกสาร <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="docTitle" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">หมวดหมู่ <span class="text-red-500">*</span></label>
                        <select name="category_id" id="docCategory" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <!-- Categories loaded via AJAX -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ปี <span class="text-red-500">*</span></label>
                        <select name="year" id="docYear" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach(range(date('Y'), date('Y')-20) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ไฟล์เอกสาร (PDF, Word, Excel) <span id="fileRequired" class="text-red-500">*</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition cursor-pointer relative" id="dropArea">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                            <div class="flex text-sm text-gray-600">
                                <span class="text-blue-600 font-medium">คลิกเพื่ออัปโหลด</span>
                                <p class="pl-1">หรือลากไฟล์มาวางที่นี่</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF, XLSX, DOCX ไม่เกิน 10MB</p>
                        </div>
                        <input id="docFile" name="file" type="file" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <p id="fileNameDisplay" class="mt-2 text-sm text-blue-600 font-medium hidden"></p>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end space-x-3">
                <button type="button" class="closeModal px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">ยกเลิก</button>
                <button type="submit" id="btnSave" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition shadow-sm">
                    <i class="fas fa-save mr-2"></i> บันทึกข้อมูล
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const API_URL = '/api/v1';
        let categories = [];
        let currentPage = 1;

        // Load Initial Data
        loadCategories();
        loadDocuments();

        // Search Handlers
        $('#btnSearch').click(() => {
            currentPage = 1;
            loadDocuments();
        });

        $('#searchKeyword').on('keypress', (e) => {
            if(e.which == 13) loadDocuments();
        });

        // Modal Handlers
        $('#btnAddDocument').click(() => {
            resetForm();
            $('#modalTitle').text('เพิ่มเอกสารใหม่');
            $('#fileRequired').show();
            $('#docModal').removeClass('hidden');
        });

        $('.closeModal').click(() => {
            $('#docModal').addClass('hidden');
        });

        // File Input Handler
        $('#docFile').change(function() {
            const fileName = $(this).val().split('\\').pop();
            if(fileName) {
                $('#fileNameDisplay').text('ไฟล์ที่เลือก: ' + fileName).removeClass('hidden');
            } else {
                $('#fileNameDisplay').addClass('hidden');
            }
        });

        // Form Submit
        $('#docForm').submit(function(e) {
            e.preventDefault();
            const id = $('#docId').val();
            const formData = new FormData(this);
            const isEdit = id !== '';

            let url = API_URL + '/documents';
            let method = 'POST';

            if (isEdit) {
                url = API_URL + '/documents/' + id;
                // Laravel Spoofing for PUT
                formData.append('_method', 'PUT');
            }

            $('#btnSave').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> กำลังบันทึก...');

            $.ajax({
                url: url,
                method: 'POST', // Always POST when sending FormData
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (res) => {
                    alert(res.message);
                    $('#docModal').addClass('hidden');
                    loadDocuments();
                },
                error: (err) => {
                    console.error(err);
                    alert('เกิดข้อผิดพลาด: ' + (err.responseJSON?.message || 'โปรดตรวจสอบความถูกต้องของข้อมูล'));
                },
                complete: () => {
                    $('#btnSave').prop('disabled', false).html('<i class="fas fa-save mr-2"></i> บันทึกข้อมูล');
                }
            });
        });

        // Functions
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
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
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
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-folder-open text-4xl mb-3"></i>
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
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-500 font-medium">${(currentPage - 1) * 10 + index + 1}</td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">${doc.title}</div>
                            <div class="text-xs text-gray-400">ID: ${doc.id}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold">
                                ${doc.category_name || 'ทั่วไป'}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-medium text-gray-600">${doc.year}</td>
                        <td class="px-6 py-4 text-gray-500">${doc.created_at}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="${doc.file_url}" target="_blank" class="text-blue-600 hover:text-blue-800 p-2" title="ดูเอกสาร">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button onclick="editDoc(${doc.id})" class="text-amber-600 hover:text-amber-800 p-2" title="แก้ไข">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteDoc(${doc.id})" class="text-red-600 hover:text-red-800 p-2" title="ลบ">
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
            let html = `<div class="text-sm text-gray-500">แสดงผลหน้าที่ ${meta.current_page} จาก ${meta.last_page} (ทั้งหมด ${meta.total} รายการ)</div>`;
            html += '<div class="flex space-x-1">';
            
            if (meta.current_page > 1) {
                html += `<button onclick="goToPage(${meta.current_page - 1})" class="px-3 py-1 border border-gray-300 rounded hover:bg-white transition text-gray-600">&laquo;</button>`;
            }

            for (let i = 1; i <= meta.last_page; i++) {
                const activeClass = i === meta.current_page ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50';
                html += `<button onclick="goToPage(${i})" class="px-3 py-1 border rounded transition ${activeClass}">${i}</button>`;
            }

            if (meta.current_page < meta.last_page) {
                html += `<button onclick="goToPage(${meta.current_page + 1})" class="px-3 py-1 border border-gray-300 rounded hover:bg-white transition text-gray-600">&raquo;</button>`;
            }

            html += '</div>';
            $('#pagination').html(html);
        }

        window.goToPage = (page) => {
            loadDocuments(page);
        };

        window.editDoc = (id) => {
            // Find document in current list or fetch from API
            // For simplicity, we'll fetch or just look at what we have
            // Let's fetch the list again or use the cached data
            $.get(API_URL + '/documents', (res) => {
                const doc = res.data.find(d => d.id == id);
                if (doc) {
                    $('#docId').val(doc.id);
                    $('#docTitle').val(doc.title);
                    $('#docCategory').val(doc.category_id);
                    $('#docYear').val(doc.year);
                    $('#modalTitle').text('แก้ไขข้อมูลเอกสาร');
                    $('#fileRequired').hide(); // File is optional on edit
                    $('#fileNameDisplay').addClass('hidden');
                    $('#docModal').removeClass('hidden');
                }
            });
        };

        window.deleteDoc = (id) => {
            if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบเอกสารนี้?')) {
                $.ajax({
                    url: API_URL + '/documents/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (res) => {
                        alert(res.message);
                        loadDocuments();
                    },
                    error: (err) => {
                        alert('เกิดข้อผิดพลาดในการลบ');
                    }
                });
            }
        };

        function resetForm() {
            $('#docId').val('');
            $('#docForm')[0].reset();
            $('#fileNameDisplay').addClass('hidden');
        }
    });
</script>
@endpush
