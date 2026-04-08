@extends('layouts.admin')

@section('title', $activity->title . ' | ผู้ดูแล')

@section('content')
    <div class="page-head">
        <div>
            <h1>{{ $activity->title }}</h1>
            <p>รายละเอียดกิจกรรม เอกสารแนบ และข้อมูลผู้บันทึก</p>
        </div>

        <div class="button-group">
            <a href="{{ route('admin.activities.edit', $activity->id) }}" class="button">แก้ไขกิจกรรม</a>
            <a href="{{ route('admin.activities.index') }}" class="button secondary">กลับไปหน้ารายการ</a>
        </div>
    </div>

    <div id="activity-show-feedback" class="flash" hidden></div>

    <section class="detail-grid">
        <article class="panel">
            <div class="panel-head">
                <div>
                    <h2>ข้อมูลกิจกรรม</h2>
                    <p>รายละเอียดหลักที่แสดงบนหน้าเว็บไซต์สาธารณะ</p>
                </div>
            </div>

            <div class="info-list">
                <div class="info-item">
                    <div class="button-group" style="margin-bottom: 0.6rem;">
                        <span class="badge">{{ $activity->category->category_name }}</span>
                        <span class="badge neutral">{{ ucfirst($activity->status) }}</span>
                    </div>
                    <strong>รายละเอียด</strong>
                    <p class="muted" style="margin-top: 0.5rem;">{{ $activity->description }}</p>
                </div>
                <div class="info-item">
                    <strong>วันที่จัดกิจกรรม</strong>
                    <p class="muted" style="margin-top: 0.5rem;">{{ $activity->activity_date->format('d M Y') }}</p>
                </div>
                <div class="info-item">
                    <strong>สถานที่</strong>
                    <p class="muted" style="margin-top: 0.5rem;">{{ $activity->location }}</p>
                </div>
                <div class="info-item">
                    <strong>ผู้จัดกิจกรรม</strong>
                    <p class="muted" style="margin-top: 0.5rem;">{{ $activity->organizer }}</p>
                </div>
            </div>
        </article>

        <aside class="stack">
            <div class="panel">
                <h3>ข้อมูลระบบ</h3>
                <div class="info-list" style="margin-top: 1rem;">
                    <div class="info-item">
                        <strong>ผู้บันทึก</strong>
                        <p class="muted" style="margin-top: 0.5rem;">{{ $activity->creator->name }}</p>
                    </div>
                    <div class="info-item">
                        <strong>วันที่สร้าง</strong>
                        <p class="muted" style="margin-top: 0.5rem;">{{ $activity->created_at?->format('d M Y H:i') }}</p>
                    </div>
                    <div class="info-item">
                        <strong>วันที่แก้ไขล่าสุด</strong>
                        <p class="muted" style="margin-top: 0.5rem;">{{ $activity->updated_at?->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="panel">
                <h3>เอกสาร PDF</h3>
                @if ($activity->document)
                    <div class="stack" style="margin-top: 1rem;">
                        <p>{{ $activity->document->file_name }}</p>
                        <p class="muted">{{ number_format($activity->document->file_size / 1024, 2) }} KB</p>
                        <a href="{{ asset('storage/' . $activity->document->file_path) }}" class="button secondary" target="_blank" rel="noopener">
                            เปิดเอกสาร
                        </a>
                    </div>
                @else
                    <p class="muted" style="margin-top: 1rem;">ยังไม่มีเอกสารแนบ</p>
                @endif
            </div>

            <div class="panel">
                <h3>การจัดการ</h3>
                <div class="button-group" style="margin-top: 1rem;">
                    <a href="{{ route('activities.show', $activity->id) }}" class="button secondary" target="_blank" rel="noopener">ดูหน้า Public</a>
                    <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" id="activity-show-delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button danger" id="activity-show-delete-button">ลบกิจกรรม</button>
                    </form>
                </div>
            </div>
        </aside>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#activity-show-delete-form').on('submit', function (event) {
                event.preventDefault();

                if (!window.confirm('ยืนยันการลบกิจกรรมนี้หรือไม่?')) {
                    return;
                }

                const $button = $('#activity-show-delete-button');
                $button.prop('disabled', true).text('กำลังลบ...');

                $.ajax({
                    url: this.action,
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).done(function (payload) {
                    window.location.href = payload.data.redirect_url;
                }).fail(function (xhr) {
                    const payload = xhr.responseJSON || {};
                    AppUi.showFeedback(
                        '#activity-show-feedback',
                        'error',
                        payload.message || 'ไม่สามารถลบกิจกรรมได้',
                        payload.error ? [payload.error] : []
                    );
                }).always(function () {
                    $button.prop('disabled', false).text('ลบกิจกรรม');
                });
            });
        });
    </script>
@endpush
