@extends('layouts.admin')

@section('title', 'แก้ไขหมวดหมู่')

@section('content')
    <div class="page-head">
        <div>
            <h1>แก้ไขหมวดหมู่</h1>
            <p>อัปเดตชื่อหมวดหมู่สำหรับใช้งานในระบบกิจกรรม</p>
        </div>

        <div class="button-group">
            <a href="{{ route('admin.categories.index') }}" class="button secondary">กลับไปหน้ารายการ</a>
        </div>
    </div>

    <div id="category-edit-feedback" class="flash" hidden></div>

    <section class="form-card">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" id="category-edit-form" novalidate>
            @csrf
            @method('PUT')
            @include('admin.categories._form', ['category' => $category])

            <div class="button-group" style="margin-top: 1.25rem;">
                <button type="submit" id="category-edit-submit-button">บันทึกการเปลี่ยนแปลง</button>
                <a href="{{ route('admin.categories.index') }}" class="button secondary">ยกเลิก</a>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            const formSelector = '#category-edit-form';
            const $submitButton = $('#category-edit-submit-button');

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
                        AppUi.showFeedback('#category-edit-feedback', 'error', payload.message || 'ไม่สามารถบันทึกหมวดหมู่ได้', messages);
                        return;
                    }

                    AppUi.showFeedback(
                        '#category-edit-feedback',
                        'error',
                        payload.message || 'ไม่สามารถบันทึกหมวดหมู่ได้',
                        payload.error ? [payload.error] : []
                    );
                }).always(function () {
                    $submitButton.prop('disabled', false).text('บันทึกการเปลี่ยนแปลง');
                });
            });
        });
    </script>
@endpush
