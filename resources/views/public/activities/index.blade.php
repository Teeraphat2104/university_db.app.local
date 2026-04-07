@extends('layouts.public')

@section('title', $pageTitle . ' | Student Activities')

@section('content')
    <section class="hero-panel">
        <div class="hero-copy">
            <span class="eyebrow">Public Activities</span>
            <h1>{{ $pageTitle }}</h1>
            <p>{{ $pageSubtitle }}</p>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">ผลลัพธ์ในหน้านี้</div>
                <div class="stat-value">{{ $activities->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">ผลลัพธ์ทั้งหมด</div>
                <div class="stat-value">{{ $activities->total() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">หน้าปัจจุบัน</div>
                <div class="stat-value">{{ $activities->currentPage() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">สถานะที่เปิดแสดง</div>
                <div class="stat-value">Published</div>
            </div>
        </div>
    </section>

    <section class="filter-panel">
        <form action="{{ request()->routeIs('activities.search') ? route('activities.search') : route('activities.index') }}" method="GET" class="form-grid">
            <div class="field span-2">
                <label for="search">คำค้นหา</label>
                <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="ค้นหาจากชื่อ รายละเอียด สถานที่ หรือผู้จัด">
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
                <label for="activity_date_from">วันที่เริ่มต้น</label>
                <input type="date" id="activity_date_from" name="activity_date_from" value="{{ $filters['activity_date_from'] ?? '' }}">
            </div>
            <div class="field">
                <label for="activity_date_to">วันที่สิ้นสุด</label>
                <input type="date" id="activity_date_to" name="activity_date_to" value="{{ $filters['activity_date_to'] ?? '' }}">
            </div>
            <div class="field span-4" style="display:flex;justify-content:flex-end;gap:0.75rem;">
                <a href="{{ route('activities.index') }}" class="button secondary">ล้างตัวกรอง</a>
                <button type="submit">ค้นหา</button>
            </div>
        </form>
    </section>

    <section>
        <div class="card-grid">
            @forelse ($activities as $activity)
                <article class="card">
                    <div class="meta-row">
                        <span class="badge">{{ $activity->category->category_name }}</span>
                        <span class="badge status">{{ ucfirst($activity->status) }}</span>
                    </div>
                    <h3>{{ $activity->title }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($activity->description, 150) }}</p>
                    <div class="stack meta">
                        <span>วันที่ {{ $activity->activity_date->format('d M Y') }}</span>
                        <span>สถานที่ {{ $activity->location }}</span>
                        <span>ผู้จัด {{ $activity->organizer }}</span>
                    </div>
                    <div class="card-actions" style="margin-top:1rem;">
                        <a href="{{ route('activities.show', $activity->id) }}" class="button">ดูรายละเอียด</a>
                    </div>
                </article>
            @empty
                <article class="card">
                    <h3>ไม่พบกิจกรรมที่ตรงเงื่อนไข</h3>
                    <p>ลองเปลี่ยนคำค้นหา หมวดหมู่ หรือช่วงวันที่ แล้วค้นหาอีกครั้ง</p>
                </article>
            @endforelse
        </div>

        @if ($activities->hasPages())
            <div class="pager">
                <span class="pager-link {{ $activities->onFirstPage() ? 'disabled' : '' }}">
                    @if ($activities->onFirstPage())
                        ย้อนกลับ
                    @else
                        <a href="{{ $activities->previousPageUrl() }}">ย้อนกลับ</a>
                    @endif
                </span>
                <span class="pager-meta">หน้า {{ $activities->currentPage() }} / {{ $activities->lastPage() }}</span>
                <span class="pager-link {{ $activities->hasMorePages() ? '' : 'disabled' }}">
                    @if ($activities->hasMorePages())
                        <a href="{{ $activities->nextPageUrl() }}">ถัดไป</a>
                    @else
                        ถัดไป
                    @endif
                </span>
            </div>
        @endif
    </section>
@endsection
