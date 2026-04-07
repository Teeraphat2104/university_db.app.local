@extends('layouts.admin')

@section('title', 'Manage Activities')

@section('content')
    <div class="topbar">
        <div class="headline">
            <h1>Activities</h1>
            <p>จัดการรายการกิจกรรมนักศึกษา สถานะการเผยแพร่ และเอกสาร PDF</p>
        </div>
        <a href="{{ route('admin.activities.create') }}" class="primary">สร้างกิจกรรมใหม่</a>
    </div>

    <section class="form-shell" style="margin-bottom:1rem;">
        <form action="{{ route('admin.activities.index') }}" method="GET" class="filter-grid">
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
                <label for="status">สถานะ</label>
                <select id="status" name="status">
                    <option value="">ทั้งหมด</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? null) === $status)>{{ ucfirst($status) }}</option>
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
                <a href="{{ route('admin.activities.index') }}" class="secondary">ล้างตัวกรอง</a>
                <button type="submit" class="primary">ค้นหา</button>
            </div>
        </form>
    </section>

    <section class="table-shell">
        <table>
            <thead>
                <tr>
                    <th>ชื่อกิจกรรม</th>
                    <th>หมวดหมู่</th>
                    <th>วันที่จัด</th>
                    <th>สถานะ</th>
                    <th>เอกสาร</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($activities as $activity)
                    <tr>
                        <td data-label="ชื่อกิจกรรม">
                            <strong>{{ $activity->title }}</strong>
                            <div class="meta">{{ \Illuminate\Support\Str::limit($activity->description, 90) }}</div>
                        </td>
                        <td data-label="หมวดหมู่"><span class="badge">{{ $activity->category->category_name }}</span></td>
                        <td data-label="วันที่จัด">{{ $activity->activity_date->format('d M Y') }}</td>
                        <td data-label="สถานะ"><span class="badge status">{{ ucfirst($activity->status) }}</span></td>
                        <td data-label="เอกสาร">{{ $activity->document ? $activity->document->file_name : 'ไม่มีไฟล์' }}</td>
                        <td data-label="จัดการ">
                            <div class="button-row">
                                <a href="{{ route('admin.activities.show', $activity->id) }}" class="secondary">ดู</a>
                                <a href="{{ route('admin.activities.edit', $activity->id) }}" class="primary">แก้ไข</a>
                                <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Delete this activity?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="danger">ลบ</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">ยังไม่มีกิจกรรมที่ตรงเงื่อนไข</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

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
