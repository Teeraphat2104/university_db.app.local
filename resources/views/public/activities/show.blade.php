@extends('layouts.public')

@section('title', $activity->title . ' | Student Activities')

@section('content')
    <section class="hero-panel">
        <div class="hero-copy">
            <span class="eyebrow">{{ $activity->category->category_name }}</span>
            <h1>{{ $activity->title }}</h1>
            <p>{{ $activity->description }}</p>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">วันที่จัดกิจกรรม</div>
                <div class="stat-value">{{ $activity->activity_date->format('d M Y') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">สถานที่</div>
                <div class="stat-value">{{ $activity->location }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">ผู้จัด</div>
                <div class="stat-value">{{ $activity->organizer }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">สถานะ</div>
                <div class="stat-value">{{ ucfirst($activity->status) }}</div>
            </div>
        </div>
    </section>

    <section class="detail-grid">
        <article>
            <div class="section-head">
                <div>
                    <h2>รายละเอียดกิจกรรม</h2>
                    <p>ข้อมูลสรุปสำหรับนักศึกษาที่สนใจเข้าร่วม</p>
                </div>
            </div>

            <div class="stack">
                <div>
                    <strong>คำอธิบาย</strong>
                    <p>{{ $activity->description }}</p>
                </div>
                <div>
                    <strong>หมวดหมู่</strong>
                    <p>{{ $activity->category->category_name }}</p>
                </div>
                <div>
                    <strong>ผู้บันทึกข้อมูล</strong>
                    <p>{{ $activity->creator->name }}</p>
                </div>
            </div>
        </article>

        <aside>
            <div class="stack">
                <div class="surface" style="padding:1.1rem;">
                    <strong>ข้อมูลสำคัญ</strong>
                    <p style="margin-bottom:0;">วันที่ {{ $activity->activity_date->format('d M Y') }}</p>
                    <p style="margin-bottom:0;">สถานที่ {{ $activity->location }}</p>
                    <p style="margin-bottom:0;">ผู้จัด {{ $activity->organizer }}</p>
                </div>

                <div class="surface" style="padding:1.1rem;">
                    <strong>เอกสารแนบ</strong>
                    @if ($activity->document)
                        <p>ไฟล์ {{ $activity->document->file_name }}</p>
                        <a href="{{ asset('storage/' . $activity->document->file_path) }}" class="button accent" target="_blank" rel="noopener">
                            เปิดเอกสาร PDF
                        </a>
                    @else
                        <p style="margin-bottom:0;">ยังไม่มีเอกสารแนบสำหรับกิจกรรมนี้</p>
                    @endif
                </div>

                <a href="{{ route('activities.index') }}" class="button secondary">กลับไปหน้ารายการกิจกรรม</a>
            </div>
        </aside>
    </section>
@endsection
