@extends('layouts.admin')

@section('title', 'จัดการหมวดหมู่')

@section('content')
    <div class="page-head">
        <div>
            <h1>หมวดหมู่</h1>
            <p>เพิ่มและจัดการหมวดหมู่ที่ใช้ตอนสร้างกิจกรรม</p>
        </div>

        <div class="button-group">
            <a href="{{ route('admin.categories.create') }}" class="button">สร้างหมวดหมู่</a>
        </div>
    </div>

    <div id="category-index-feedback" class="flash" hidden></div>

    <section class="form-card" style="margin-bottom: 1rem;">
        <div class="panel-head">
            <div>
                <h2>ค้นหาหมวดหมู่</h2>
                <p>ค้นหาจากชื่อหมวดหมู่ที่ต้องการจัดการ</p>
            </div>
        </div>

        <form action="{{ route('admin.categories.index') }}" method="GET" class="filter-grid">
            <div class="field span-2">
                <label for="search">ค้นหา</label>
                <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="เช่น Academic, Volunteer, Workshop">
            </div>

            <div class="field">
                <label for="per_page">จำนวนต่อหน้า</label>
                <select id="per_page" name="per_page">
                    @foreach ([10, 20, 30, 50] as $size)
                        <option value="{{ $size }}" @selected((int) ($filters['per_page'] ?? 10) === $size)>{{ $size }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field span-4">
                <div class="button-group">
                    <button type="submit">กรองข้อมูล</button>
                    <a href="{{ route('admin.categories.index') }}" class="button secondary">ล้างตัวกรอง</a>
                </div>
            </div>
        </form>
    </section>

    <section class="table-wrap">
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ชื่อหมวดหมู่</th>
                        <th>จำนวนกิจกรรม</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr id="category-row-{{ $category->id }}">
                            <td data-label="ชื่อหมวดหมู่">
                                <strong>{{ $category->category_name }}</strong>
                            </td>
                            <td data-label="จำนวนกิจกรรม">{{ $category->activities_count }}</td>
                            <td data-label="การจัดการ">
                                <div class="button-group">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="button secondary">แก้ไข</a>
                                    <form
                                        action="{{ route('admin.categories.destroy', $category->id) }}"
                                        method="POST"
                                        class="inline-form js-category-delete-form"
                                        data-row="#category-row-{{ $category->id }}"
                                        data-title="{{ $category->category_name }}"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button danger">ลบ</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">ไม่พบหมวดหมู่ตามเงื่อนไขที่เลือก</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="button-group" style="margin-top: 1rem; justify-content: space-between;">
                <span class="muted">หน้า {{ $categories->currentPage() }} จาก {{ $categories->lastPage() }}</span>
                <div class="button-group">
                    @if ($categories->onFirstPage())
                        <span class="button secondary" style="pointer-events: none; opacity: 0.45;">ย้อนกลับ</span>
                    @else
                        <a href="{{ $categories->previousPageUrl() }}" class="button secondary">ย้อนกลับ</a>
                    @endif

                    @if ($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}" class="button secondary">ถัดไป</a>
                    @else
                        <span class="button secondary" style="pointer-events: none; opacity: 0.45;">ถัดไป</span>
                    @endif
                </div>
            </div>
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            $(document).on('submit', '.js-category-delete-form', function (event) {
                event.preventDefault();

                if (!window.confirm('ยืนยันการลบหมวดหมู่ "' + ($(this).data('title') || '') + '" หรือไม่?')) {
                    return;
                }

                const $form = $(this);
                const $button = $form.find('button');

                $button.prop('disabled', true).text('กำลังลบ...');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).done(function (payload) {
                    $($form.data('row')).remove();
                    AppUi.showFeedback('#category-index-feedback', 'success', payload.message);
                }).fail(function (xhr) {
                    const payload = xhr.responseJSON || {};
                    AppUi.showFeedback(
                        '#category-index-feedback',
                        'error',
                        payload.message || 'ไม่สามารถลบหมวดหมู่ได้',
                        payload.error ? [payload.error] : []
                    );
                }).always(function () {
                    $button.prop('disabled', false).text('ลบ');
                });
            });
        });
    </script>
@endpush
