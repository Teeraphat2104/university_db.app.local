@extends('layouts.admin')

@section('title', 'Edit Activity')

@section('content')
    <div class="topbar">
        <div class="headline">
            <h1>แก้ไขกิจกรรม</h1>
            <p>อัปเดตข้อมูลกิจกรรม สถานะการเผยแพร่ และแทนที่เอกสาร PDF ได้</p>
        </div>
        <div class="button-row">
            <a href="{{ route('admin.activities.show', $activity->id) }}" class="secondary">ดูรายละเอียด</a>
            <a href="{{ route('admin.activities.index') }}" class="secondary">กลับไปหน้ารายการ</a>
        </div>
    </div>

    <section class="form-shell">
        <form action="{{ route('admin.activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.activities._form', ['activity' => $activity])

            <div class="button-row" style="margin-top:1rem;justify-content:flex-end;">
                <a href="{{ route('admin.activities.show', $activity->id) }}" class="secondary">ยกเลิก</a>
                <button type="submit" class="primary">บันทึกการเปลี่ยนแปลง</button>
            </div>
        </form>
    </section>
@endsection
