@extends('layouts.admin')

@section('title', 'สร้างกิจกรรม')

@section('content')
    <div class="page-head">
        <div>
            <h1>สร้างกิจกรรม</h1>
            <p>กรอกข้อมูลกิจกรรมและแนบเอกสาร PDF หากต้องการ</p>
        </div>

        <div class="button-group">
            <a href="{{ route('admin.categories.index') }}" class="button secondary">จัดการหมวดหมู่</a>
            <a href="{{ route('admin.activities.index') }}" class="button secondary">กลับไปหน้ารายการ</a>
        </div>
    </div>

    <div id="activity-create-feedback" class="flash" hidden></div>

    <section class="form-card">
        <form action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data" id="activity-create-form" novalidate>
            @csrf
            @include('admin.activities._form')

            <div class="button-group" style="margin-top: 1.25rem;">
                <button type="submit" id="activity-create-submit-button">บันทึกกิจกรรม</button>
                <a href="{{ route('admin.activities.index') }}" class="button secondary">ยกเลิก</a>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            const formSelector = '#activity-create-form';
            const $submitButton = $('#activity-create-submit-button');

            $(formSelector).on('submit', function (event) {
                event.preventDefault();

                AppUi.clearFormErrors(formSelector);
                $submitButton.prop('disabled', true).text('กำลังบันทึก...');

                $.ajax({
                    url: this.action,
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).done(function (payload) {
                    window.location.href = payload.data.redirect_url;
                }).fail(function (xhr) {
                    const payload = xhr.responseJSON || {};

                    if (xhr.status === 422) {
                        const messages = AppUi.applyFieldErrors(formSelector, payload.errors || {});
                        AppUi.showFeedback('#activity-create-feedback', 'error', payload.message || 'ไม่สามารถบันทึกกิจกรรมได้', messages);
                        return;
                    }

                    AppUi.showFeedback(
                        '#activity-create-feedback',
                        'error',
                        payload.message || 'ไม่สามารถบันทึกกิจกรรมได้',
                        payload.error ? [payload.error] : []
                    );
                }).always(function () {
                    $submitButton.prop('disabled', false).text('บันทึกกิจกรรม');
                });
            });
        });
    </script>
@endpush
