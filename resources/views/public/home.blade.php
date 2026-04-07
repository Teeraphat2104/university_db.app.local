@extends('layouts.public')

@section('title', 'หน้าหลัก | Student Activities')

@section('content')
    <section class="hero-panel">
        <div class="hero-copy">
            <span class="eyebrow">Student Activity Hub</span>
            <h1>ค้นหากิจกรรมที่ใช่ แล้วเข้าร่วมได้ทันที</h1>
            <p>
                พื้นที่รวมข่าวสารกิจกรรมสำหรับนักศึกษา ทั้งกิจกรรมเชิงวิชาการ อาสา กีฬา และเวิร์กช็อป
                โดยฝั่ง public เปิดให้ดูข้อมูลได้ทันที ส่วนฝั่ง admin จัดการข้อมูลแยกออกจากกันชัดเจน
            </p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">กิจกรรมที่เผยแพร่</div>
                <div class="stat-value">{{ $activityCount }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">หมวดหมู่กิจกรรม</div>
                <div class="stat-value">{{ $categories->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Public Access</div>
                <div class="stat-value">24/7</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Admin Workflow</div>
                <div class="stat-value">Secure</div>
            </div>
        </div>
    </section>

    <section class="filter-panel">
        <div class="section-head">
            <div>
                <h2>เริ่มค้นหากิจกรรม</h2>
                <p>กรองตามคำสำคัญ หมวดหมู่ หรือวันที่ที่ต้องการ</p>
            </div>
        </div>

        <form action="{{ route('activities.search') }}" method="GET" class="form-grid">
            <div class="field span-2">
                <label for="search">คำค้นหา</label>
                <input type="text" id="search" name="search" placeholder="เช่น hackathon, volunteer, orientation">
            </div>
            <div class="field">
                <label for="category_id">หมวดหมู่</label>
                <select id="category_id" name="category_id">
                    <option value="">ทั้งหมด</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="activity_date_from">วันที่เริ่มต้น</label>
                <input type="date" id="activity_date_from" name="activity_date_from">
            </div>
            <div class="field span-4" style="display:flex;justify-content:flex-end;">
                <button type="submit" class="accent">ค้นหากิจกรรม</button>
            </div>
        </form>
    </section>

    <section>
        <div class="section-head">
            <div>
                <h2>กิจกรรมล่าสุด</h2>
                <p>รายการที่เผยแพร่ล่าสุดสำหรับนักศึกษา</p>
            </div>
            <a href="{{ route('activities.index') }}" class="button secondary">ดูทั้งหมด</a>
        </div>

        <div class="card-grid">
            @forelse ($latestActivities as $activity)
                <article class="card">
                    <div class="meta-row">
                        <span class="badge">{{ $activity->category->category_name }}</span>
                        <span class="badge status">{{ ucfirst($activity->status) }}</span>
                    </div>
                    <h3>{{ $activity->title }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($activity->description, 140) }}</p>
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
                    <h3>ยังไม่มีกิจกรรมเผยแพร่</h3>
                    <p>เมื่อ admin เพิ่มกิจกรรมที่มีสถานะเผยแพร่ รายการจะแสดงที่หน้านี้ทันที</p>
                </article>
            @endforelse
        </div>
    </section>
@endsection
