@extends('layouts.admin')

@section('title', 'จัดการกิจกรรม')

@section('content')
    <div class="page-head">
        <div>
            <h1>กิจกรรม</h1>
            <p>จัดการข้อมูลกิจกรรม สถานะการเผยแพร่ และเอกสารประกอบ</p>
        </div>

        <div class="button-group">
            <a href="{{ route('admin.categories.index') }}" class="button secondary">จัดการหมวดหมู่</a>
            <a href="{{ route('admin.activities.create') }}" class="button">สร้างกิจกรรม</a>
        </div>
    </div>

    <div id="activity-index-feedback" class="flash" hidden></div>

    <section class="form-card" style="margin-bottom: 1rem;">
        <div class="panel-head">
            <div>
                <h2>ตัวกรอง</h2>
                <p>ค้นหาตามคำสำคัญ หมวดหมู่ สถานะ หรือช่วงวันที่</p>
            </div>
        </div>

        <form action="{{ route('admin.activities.index') }}" method="GET" class="filter-grid">
            <div class="field span-2">
                <label for="search">ค้นหา</label>
                <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="ชื่อกิจกรรม รายละเอียด สถานที่ หรือผู้จัด">
            </div>

            <div class="field">
                <label for="category_id">หมวดหมู่</label>
                <select id="category_id" name="category_id">
                    <option value="">ทั้งหมด</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(($filters['category_id'] ?? null) == $category->id)>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="status">สถานะ</label>
                <select id="status" name="status">
                    <option value="">ทั้งหมด</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? null) === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="activity_date_from">วันที่เริ่มต้น</label>
                <input type="date" id="activity_date_from" name="activity_date_from" value="{{ $filters['activity_date_from'] ?? '' }}">
            </div>

            <div class="field">
                <label for="activity_date_to">วันที่สิ้นสุด</label>
                <input type="date" id="activity_date_to" name="activity_date_to" value="{{ $filters['activity_date_to'] ?? '' }}">
            </div>

            <div class="field span-4">
                <div class="button-group">
                    <button type="submit">กรองข้อมูล</button>
                    <a href="{{ route('admin.activities.index') }}" class="button secondary">ล้างตัวกรอง</a>
                </div>
            </div>
        </form>
    </section>

    <section class="table-wrap">
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ชื่อกิจกรรม</th>
                        <th>หมวดหมู่</th>
                        <th>วันที่จัด</th>
                        <th>สถานะ</th>
                        <th>เอกสาร</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $activity)
                        <tr id="activity-row-{{ $activity->id }}">
                            <td data-label="ชื่อกิจกรรม">
                                <strong>{{ $activity->title }}</strong>
                                <div class="muted">{{ \Illuminate\Support\Str::limit($activity->description, 90) }}</div>
                            </td>
                            <td data-label="หมวดหมู่">{{ $activity->category->category_name }}</td>
                            <td data-label="วันที่จัด">{{ $activity->activity_date->format('d M Y') }}</td>
                            <td data-label="สถานะ"><span class="badge neutral">{{ ucfirst($activity->status) }}</span></td>
                            <td data-label="เอกสาร">{{ $activity->document ? $activity->document->file_name : 'ไม่มีไฟล์' }}</td>
                            <td data-label="การจัดการ">
                                <div class="button-group">
                                    <a href="{{ route('admin.activities.show', $activity->id) }}" class="button secondary">ดู</a>
                                    <a href="{{ route('admin.activities.edit', $activity->id) }}" class="button">แก้ไข</a>
                                    <form
                                        action="{{ route('admin.activities.destroy', $activity->id) }}"
                                        method="POST"
                                        class="inline-form js-activity-delete-form"
                                        data-row="#activity-row-{{ $activity->id }}"
                                        data-title="{{ $activity->title }}"
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
                            <td colspan="6">ไม่พบกิจกรรมตามเงื่อนไขที่เลือก</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($activities->hasPages())
            <div class="button-group" style="margin-top: 1rem; justify-content: space-between;">
                <span class="muted">หน้า {{ $activities->currentPage() }} จาก {{ $activities->lastPage() }}</span>
                <div class="button-group">
                    @if ($activities->onFirstPage())
                        <span class="button secondary" style="pointer-events: none; opacity: 0.45;">ย้อนกลับ</span>
                    @else
                        <a href="{{ $activities->previousPageUrl() }}" class="button secondary">ย้อนกลับ</a>
                    @endif

                    @if ($activities->hasMorePages())
                        <a href="{{ $activities->nextPageUrl() }}" class="button secondary">ถัดไป</a>
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
            $(document).on('submit', '.js-activity-delete-form', function (event) {
                event.preventDefault();

                if (!window.confirm('ยืนยันการลบกิจกรรม "' + ($(this).data('title') || '') + '" หรือไม่?')) {
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
                    AppUi.showFeedback('#activity-index-feedback', 'success', payload.message);
                }).fail(function (xhr) {
                    const payload = xhr.responseJSON || {};
                    AppUi.showFeedback(
                        '#activity-index-feedback',
                        'error',
                        payload.message || 'ไม่สามารถลบกิจกรรมได้',
                        payload.error ? [payload.error] : []
                    );
                }).always(function () {
                    $button.prop('disabled', false).text('ลบ');
                });
            });
        });
    </script>
@endpush
