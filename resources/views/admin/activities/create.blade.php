@extends('layouts.admin')

@section('title', 'Create Activity')

@section('content')
    <div class="topbar">
        <div class="headline">
            <h1>สร้างกิจกรรมใหม่</h1>
            <p>บันทึกข้อมูลกิจกรรมและอัปโหลดเอกสาร PDF ได้จากฟอร์มเดียว</p>
        </div>
        <a href="{{ route('admin.activities.index') }}" class="secondary">กลับไปหน้ารายการ</a>
    </div>

    <section class="form-shell">
        <form action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.activities._form')

            <div class="button-row" style="margin-top:1rem;justify-content:flex-end;">
                <a href="{{ route('admin.activities.index') }}" class="secondary">ยกเลิก</a>
                <button type="submit" class="primary">บันทึกกิจกรรม</button>
            </div>
        </form>
    </section>
@endsection
