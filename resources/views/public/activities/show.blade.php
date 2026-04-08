@extends('layouts.public')

@section('title', $activity->title . ' | ระบบกิจกรรมนักศึกษา')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div class="hero-copy">
                <span class="eyebrow">{{ $activity->category->category_name }}</span>
                <h1>{{ $activity->title }}</h1>
                <p>{{ $activity->description }}</p>

                <div class="actions">
                    <a href="{{ route('home') }}" class="button secondary">กลับหน้าแรก</a>
                    @if ($activity->document)
                        <a href="{{ asset('storage/' . $activity->document->file_path) }}" class="button" target="_blank" rel="noopener">
                            ดาวน์โหลด PDF
                        </a>
                    @endif
                </div>
            </div>

            <div class="stats">
                <div class="stat">
                    <div class="stat-label">วันที่จัดกิจกรรม</div>
                    <div class="stat-value">{{ $activity->activity_date->format('d M Y') }}</div>
                </div>
                <div class="stat">
                    <div class="stat-label">สถานที่</div>
                    <div class="stat-value">{{ $activity->location }}</div>
                </div>
                <div class="stat">
                    <div class="stat-label">ผู้จัด</div>
                    <div class="stat-value">{{ $activity->organizer }}</div>
                </div>
                <div class="stat">
                    <div class="stat-label">สถานะ</div>
                    <div class="stat-value">{{ ucfirst($activity->status) }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section detail-grid">
        <article class="panel">
            <div class="section-head">
                <div>
                    <h2>รายละเอียดกิจกรรม</h2>
                    <p>ข้อมูลสำหรับผู้สนใจเข้าร่วมกิจกรรม</p>
                </div>
            </div>

            <div class="info-list">
                <div class="info-item">
                    <strong>คำอธิบาย</strong>
                    <p style="margin-top: 0.5rem;">{{ $activity->description }}</p>
                </div>
                <div class="info-item">
                    <strong>หมวดหมู่</strong>
                    <p style="margin-top: 0.5rem;">{{ $activity->category->category_name }}</p>
                </div>
                <div class="info-item">
                    <strong>ผู้บันทึกข้อมูล</strong>
                    <p style="margin-top: 0.5rem;">{{ $activity->creator->name }}</p>
                </div>
            </div>
        </article>

        <aside class="stack">
            <div class="panel">
                <h3>ข้อมูลสำคัญ</h3>
                <div class="info-list" style="margin-top: 1rem;">
                    <div class="info-item">
                        <strong>วันที่จัด</strong>
                        <p style="margin-top: 0.5rem;">{{ $activity->activity_date->format('d M Y') }}</p>
                    </div>
                    <div class="info-item">
                        <strong>สถานที่</strong>
                        <p style="margin-top: 0.5rem;">{{ $activity->location }}</p>
                    </div>
                    <div class="info-item">
                        <strong>ผู้จัด</strong>
                        <p style="margin-top: 0.5rem;">{{ $activity->organizer }}</p>
                    </div>
                    <div class="info-item">
                        <strong>สถานะ</strong>
                        <p style="margin-top: 0.5rem;">{{ ucfirst($activity->status) }}</p>
                    </div>
                </div>
            </div>

            <div class="panel">
                <h3>เอกสารประกอบ</h3>
                @if ($activity->document)
                    <div class="stack" style="margin-top: 1rem;">
                        <p>{{ $activity->document->file_name }}</p>
                        <p class="muted">{{ number_format($activity->document->file_size / 1024, 2) }} KB</p>
                        <a href="{{ asset('storage/' . $activity->document->file_path) }}" class="button" target="_blank" rel="noopener">
                            เปิดเอกสาร PDF
                        </a>
                    </div>
                @else
                    <p style="margin-top: 1rem;">ยังไม่มีเอกสารแนบสำหรับกิจกรรมนี้</p>
                @endif
            </div>
        </aside>
    </section>
@endsection
