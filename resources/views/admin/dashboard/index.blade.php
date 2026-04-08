@extends('layouts.admin')

@section('title', 'แดชบอร์ดผู้ดูแล')

@section('content')
    <div class="page-head">
        <div>
            <h1>แดชบอร์ด</h1>
            <p>ภาพรวมของกิจกรรม หมวดหมู่ และรายการล่าสุดภายในระบบ</p>
        </div>

        <div class="button-group">
            <a href="{{ route('admin.activities.create') }}" class="button">สร้างกิจกรรมใหม่</a>
            <a href="{{ route('admin.categories.create') }}" class="button secondary">สร้างหมวดหมู่</a>
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

    <section class="table-wrap">
        <div class="panel-head">
            <div>
                <h2>กิจกรรมล่าสุด</h2>
                <p>รายการที่เพิ่งถูกสร้างหรือแก้ไขล่าสุด</p>
            </div>
        </div>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ชื่อกิจกรรม</th>
                        <th>หมวดหมู่</th>
                        <th>วันที่จัด</th>
                        <th>สถานะ</th>
                        <th>ผู้สร้าง</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentActivities as $activity)
                        <tr>
                            <td data-label="ชื่อกิจกรรม">{{ $activity->title }}</td>
                            <td data-label="หมวดหมู่">{{ $activity->category->category_name }}</td>
                            <td data-label="วันที่จัด">{{ $activity->activity_date->format('d M Y') }}</td>
                            <td data-label="สถานะ"><span class="badge neutral">{{ ucfirst($activity->status) }}</span></td>
                            <td data-label="ผู้สร้าง">{{ $activity->creator->name }}</td>
                            <td data-label="การจัดการ">
                                <div class="button-group">
                                    <a href="{{ route('admin.activities.show', $activity->id) }}" class="button secondary">ดู</a>
                                    <a href="{{ route('admin.activities.edit', $activity->id) }}" class="button button-sm">แก้ไข</a>
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
        </div>
    </section>
@endsection
