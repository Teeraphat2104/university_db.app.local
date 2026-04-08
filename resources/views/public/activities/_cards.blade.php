@forelse ($activities as $activity)
    <article class="card">
        <div class="button-group">
            <span class="badge">{{ $activity->category->category_name }}</span>
            <span class="badge neutral">{{ ucfirst($activity->status) }}</span>
        </div>

        <div class="stack">
            <h3>{{ $activity->title }}</h3>
            <p>{{ \Illuminate\Support\Str::limit($activity->description, 150) }}</p>
        </div>

        <div class="meta-list">
            <span>วันที่ {{ $activity->activity_date->format('d M Y') }}</span>
            <span>สถานที่ {{ $activity->location }}</span>
            <span>ผู้จัด {{ $activity->organizer }}</span>
        </div>

        <div class="button-group">
            <a href="{{ route('activities.show', $activity->id) }}" class="button secondary">ดูรายละเอียด</a>
            @if ($activity->document)
                <a href="{{ asset('storage/' . $activity->document->file_path) }}" class="button" target="_blank" rel="noopener">เอกสาร PDF</a>
            @endif
        </div>
    </article>
@empty
    <article class="card empty-state">
        <h3>ไม่พบกิจกรรมที่ตรงกับเงื่อนไข</h3>
        <p>ลองเปลี่ยนคำค้นหา หมวดหมู่ หรือช่วงวันที่ แล้วค้นหาอีกครั้ง</p>
    </article>
@endforelse
