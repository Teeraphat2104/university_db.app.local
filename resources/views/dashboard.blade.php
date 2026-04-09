@extends('layouts.app')

@section('title', 'แดชบอร์ด')
@section('header', 'แดชบอร์ด')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6">
        <div class="flex items-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);">
                <i class="fas fa-file-alt text-primary-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-slate-500">จำนวนเอกสาร</p>
                <p class="text-3xl font-bold text-slate-700" id="totalDocuments">-</p>
            </div>
        </div>
    </div>
    <div class="card p-6">
        <div class="flex items-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                <i class="fas fa-folder text-emerald-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-slate-500">จำนวนหมวดหมู่</p>
                <p class="text-3xl font-bold text-slate-700" id="totalCategories">-</p>
            </div>
        </div>
    </div>
    <div class="card p-6">
        <div class="flex items-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                <i class="fas fa-calendar text-amber-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-slate-500">เอกสารปีนี้</p>
                <p class="text-3xl font-bold text-slate-700" id="documentsThisYear">-</p>
            </div>
        </div>
    </div>
    <div class="card p-6">
        <div class="flex items-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #fae8ff 0%, #f5d0fe 100%);">
                <i class="fas fa-clock text-accent-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-slate-500">เอกสารล่าสุด</p>
                <p class="text-3xl font-bold text-slate-700" id="recentDocuments">-</p>
            </div>
        </div>
    </div>
</div>

<div class="card p-6">
    <h3 class="text-lg font-semibold mb-4 text-slate-700">
        <i class="fas fa-history text-primary-500 mr-2"></i>เอกสารล่าสุด
    </h3>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="table-header">
                    <th class="px-6 py-3 text-left">ชื่อเอกสาร</th>
                    <th class="px-6 py-3 text-left">หมวดหมู่</th>
                    <th class="px-6 py-3 text-left">ปี</th>
                    <th class="px-6 py-3 text-left">วันที่อัปโหลด</th>
                </tr>
            </thead>
            <tbody id="recentDocumentsTable">
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">กำลังโหลดข้อมูล...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    loadDashboardData();
});

function loadDashboardData() {
    $.get('/api/v1/documents', { per_page: 5 }, function(response) {
        if (response.status === 200) {
            $('#recentDocuments').text(response.pagination.total);
            
            let tableHtml = '';
            response.data.forEach(function(doc) {
                tableHtml += `
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-700">${doc.title}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><span class="badge badge-primary">${doc.category_name || '-'}</span></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">${doc.year}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">${doc.created_at}</td>
                    </tr>
                `;
            });
            $('#recentDocumentsTable').html(tableHtml || '<tr><td colspan="4" class="px-6 py-8 text-center text-slate-400">ไม่มีเอกสาร</td></tr>');
        }
    });

    $.get('/api/v1/categories', function(response) {
        if (response.status === 200) {
            $('#totalCategories').text(response.pagination.total);
        }
    });

    $.get('/api/v1/documents', { per_page: 100 }, function(response) {
        if (response.status === 200) {
            const currentYear = new Date().getFullYear();
            const thisYearDocs = response.data.filter(doc => doc.year == currentYear).length;
            $('#documentsThisYear').text(thisYearDocs);
            $('#totalDocuments').text(response.pagination.total);
        }
    });
}
</script>
@endpush
@endsection
