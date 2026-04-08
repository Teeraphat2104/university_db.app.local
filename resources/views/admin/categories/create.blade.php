@extends('layouts.admin')

@section('title', 'สร้างหมวดหมู่')

@section('content')
    <div class="page-head">
        <div>
            <h1>สร้างหมวดหมู่</h1>
            <p>เพิ่มหมวดหมู่สำหรับใช้อ้างอิงตอนสร้างกิจกรรม</p>
        </div>

        <div class="button-group">
            <a href="{{ route('admin.categories.index') }}" class="button secondary">กลับไปหน้ารายการ</a>
        </div>
    </div>

    <div id="category-create-feedback" class="flash" hidden></div>

    <section class="form-card">
        <form action="{{ route('admin.categories.store') }}" method="POST" id="category-create-form" novalidate>
            @csrf
            @include('admin.categories._form')

            <div class="button-group" style="margin-top: 1.25rem;">
                <button type="submit" id="category-create-submit-button">บันทึกหมวดหมู่</button>
                <a href="{{ route('admin.categories.index') }}" class="button secondary">ยกเลิก</a>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            const formSelector = '#category-create-form';
            const $submitButton = $('#category-create-submit-button');

            $(formSelector).on('submit', function (event) {
                event.preventDefault();

                AppUi.clearFormErrors(formSelector);
                $submitButton.prop('disabled', true).text('กำลังบันทึก...');

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

                    if (xhr.status === 422) {
                        const messages = AppUi.applyFieldErrors(formSelector, payload.errors || {});
                        AppUi.showFeedback('#category-create-feedback', 'error', payload.message || 'ไม่สามารถบันทึกหมวดหมู่ได้', messages);
                        return;
                    }

                    AppUi.showFeedback(
                        '#category-create-feedback',
                        'error',
                        payload.message || 'ไม่สามารถบันทึกหมวดหมู่ได้',
                        payload.error ? [payload.error] : []
                    );
                }).always(function () {
                    $submitButton.prop('disabled', false).text('บันทึกหมวดหมู่');
                });
            });
        });
    </script>
@endpush
