@extends('layouts.public')

@section('title', $pageTitle . ' | ระบบกิจกรรมนักศึกษา')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div class="hero-copy">
                <span class="eyebrow">Activities</span>
                <h1>{{ $pageTitle }}</h1>
                <p>{{ $pageSubtitle }}</p>
            </div>

            <div class="stats">
                <div class="stat">
                    <div class="stat-label">รายการในหน้านี้</div>
                    <div class="stat-value">{{ $activities->count() }}</div>
                </div>
                <div class="stat">
                    <div class="stat-label">รายการทั้งหมด</div>
                    <div class="stat-value">{{ $activities->total() }}</div>
                </div>
                <div class="stat">
                    <div class="stat-label">หน้าปัจจุบัน</div>
                    <div class="stat-value">{{ $activities->currentPage() }}</div>
                </div>
                <div class="stat">
                    <div class="stat-label">สถานะที่แสดง</div>
                    <div class="stat-value">Published</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section panel">
        <div class="section-head">
            <div>
                <h2>ตัวกรอง</h2>
                <p>ค้นหาตามคำสำคัญ หมวดหมู่ หรือช่วงวันที่</p>
            </div>
        </div>

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

            <div class="field span-4">
                <div class="actions" style="margin-top: 0;">
                    <button type="submit">ค้นหา</button>
                    <a href="{{ route('activities.index') }}" class="button secondary">ล้างตัวกรอง</a>
                </div>
            </div>
        </form>
    </section>

    <section class="section">
        <div class="card-grid">
            @include('public.activities._cards', ['activities' => $activities])
        </div>

        @include('public.activities._pager', ['activities' => $activities])
    </section>
@endsection
