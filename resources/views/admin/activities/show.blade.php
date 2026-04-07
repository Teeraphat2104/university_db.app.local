@extends('layouts.admin')

@section('title', $activity->title . ' | Admin')

@section('content')
    <div class="topbar">
        <div class="headline">
            <h1>{{ $activity->title }}</h1>
            <p>รายละเอียดกิจกรรม เอกสารแนบ และข้อมูลผู้สร้าง</p>
        </div>
        <div class="button-row">
            <a href="{{ route('admin.activities.edit', $activity->id) }}" class="primary">แก้ไขกิจกรรม</a>
            <a href="{{ route('admin.activities.index') }}" class="secondary">กลับไปหน้ารายการ</a>
        </div>
    </div>

    <section class="detail-grid">
        <article class="panel">
            <div class="stack">
                <div>
                    <span class="badge">{{ $activity->category->category_name }}</span>
                    <span class="badge status">{{ ucfirst($activity->status) }}</span>
                </div>
                <div>
                    <strong>รายละเอียด</strong>
                    <p class="meta">{{ $activity->description }}</p>
                </div>
                <div>
                    <strong>วันที่จัดกิจกรรม</strong>
                    <p class="meta">{{ $activity->activity_date->format('d M Y') }}</p>
                </div>
                <div>
                    <strong>สถานที่</strong>
                    <p class="meta">{{ $activity->location }}</p>
                </div>
                <div>
                    <strong>ผู้จัดกิจกรรม</strong>
                    <p class="meta">{{ $activity->organizer }}</p>
                </div>
            </div>
        </article>

        <aside class="stack">
            <div class="panel">
                <strong>ข้อมูลระบบ</strong>
                <p class="meta">Created by {{ $activity->creator->name }}</p>
                <p class="meta">Created at {{ $activity->created_at?->format('d M Y H:i') }}</p>
                <p class="meta">Updated at {{ $activity->updated_at?->format('d M Y H:i') }}</p>
            </div>

            <div class="panel">
                <strong>เอกสาร PDF</strong>
                @if ($activity->document)
                    <p class="meta">{{ $activity->document->file_name }}</p>
                    <p class="meta">{{ number_format($activity->document->file_size / 1024, 2) }} KB</p>
                    <a href="{{ asset('storage/' . $activity->document->file_path) }}" class="primary" target="_blank" rel="noopener">
                        เปิดเอกสาร
                    </a>
                @else
                    <p class="meta">ยังไม่มีเอกสารแนบ</p>
                @endif
            </div>

            <div class="panel">
                <strong>การจัดการ</strong>
                <div class="button-row" style="margin-top:0.8rem;">
                    <a href="{{ route('activities.show', $activity->id) }}" class="secondary" target="_blank" rel="noopener">ดูหน้า Public</a>
                    <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Delete this activity?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="danger">ลบกิจกรรม</button>
                    </form>
                </div>
            </div>
        </aside>
    </section>
@endsection
