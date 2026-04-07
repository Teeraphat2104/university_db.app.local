@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="topbar">
        <div class="headline">
            <h1>Dashboard</h1>
            <p>ภาพรวมกิจกรรมที่เผยแพร่ กิจกรรมทั้งหมด และหมวดหมู่ภายในระบบ</p>
        </div>
        <div class="button-row">
            <a href="{{ route('admin.activities.create') }}" class="primary">สร้างกิจกรรมใหม่</a>
            <a href="{{ route('home') }}" class="secondary">ดูหน้า Public</a>
        </div>
    </div>

    <section class="metrics">
        <article class="metric-card">
            <span>กิจกรรมทั้งหมด</span>
            <strong>{{ $stats['total_activities'] }}</strong>
        </article>
        <article class="metric-card">
            <span>กิจกรรมที่เผยแพร่</span>
            <strong>{{ $stats['published_activities'] }}</strong>
        </article>
        <article class="metric-card">
            <span>กิจกรรมที่กำลังจะมาถึง</span>
            <strong>{{ $stats['upcoming_activities'] }}</strong>
        </article>
        <article class="metric-card">
            <span>หมวดหมู่</span>
            <strong>{{ $stats['categories'] }}</strong>
        </article>
    </section>

    <section class="table-shell">
        <div class="toolbar">
            <div>
                <h2 style="margin:0;">รายการล่าสุด</h2>
                <p class="meta">กิจกรรมที่ถูกสร้างหรือแก้ไขล่าสุด</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ชื่อกิจกรรม</th>
                    <th>หมวดหมู่</th>
                    <th>วันที่</th>
                    <th>สถานะ</th>
                    <th>ผู้สร้าง</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentActivities as $activity)
                    <tr>
                        <td data-label="ชื่อกิจกรรม">{{ $activity->title }}</td>
                        <td data-label="หมวดหมู่">{{ $activity->category->category_name }}</td>
                        <td data-label="วันที่">{{ $activity->activity_date->format('d M Y') }}</td>
                        <td data-label="สถานะ"><span class="badge status">{{ ucfirst($activity->status) }}</span></td>
                        <td data-label="ผู้สร้าง">{{ $activity->creator->name }}</td>
                        <td data-label="จัดการ">
                            <div class="button-row">
                                <a href="{{ route('admin.activities.show', $activity->id) }}" class="secondary">ดู</a>
                                <a href="{{ route('admin.activities.edit', $activity->id) }}" class="primary">แก้ไข</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">ยังไม่มีกิจกรรมในระบบ</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
