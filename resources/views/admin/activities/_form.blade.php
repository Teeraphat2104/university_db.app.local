@php
    $activityModel = $activity ?? null;
@endphp

<div class="form-grid">
    <div class="field span-2">
        <label for="title">ชื่อกิจกรรม</label>
        <input type="text" id="title" name="title" value="{{ old('title', $activityModel?->title) }}" required>
    </div>

    <div class="field">
        <label for="category_id">หมวดหมู่</label>
        <select id="category_id" name="category_id" required>
            <option value="">เลือกหมวดหมู่</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $activityModel?->category_id) === (string) $category->id)>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label for="status">สถานะ</label>
        <select id="status" name="status" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $activityModel?->status ?? 'draft') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label for="activity_date">วันที่จัดกิจกรรม</label>
        <input type="date" id="activity_date" name="activity_date" value="{{ old('activity_date', optional($activityModel?->activity_date)->format('Y-m-d')) }}" required>
    </div>

    <div class="field span-2">
        <label for="location">สถานที่</label>
        <input type="text" id="location" name="location" value="{{ old('location', $activityModel?->location) }}" required>
    </div>

    <div class="field">
        <label for="organizer">ผู้จัดกิจกรรม</label>
        <input type="text" id="organizer" name="organizer" value="{{ old('organizer', $activityModel?->organizer) }}" required>
    </div>

    <div class="field">
        <label for="document">เอกสาร PDF</label>
        <input type="file" id="document" name="document" accept="application/pdf">
    </div>

    <div class="field span-4">
        <label for="description">รายละเอียดกิจกรรม</label>
        <textarea id="description" name="description" required>{{ old('description', $activityModel?->description) }}</textarea>
    </div>

    @if ($activityModel?->document)
        <div class="field span-4">
            <div class="panel">
                <strong>เอกสารปัจจุบัน</strong>
                <p class="meta">{{ $activityModel->document->file_name }}</p>
                <a href="{{ asset('storage/' . $activityModel->document->file_path) }}" class="secondary" target="_blank" rel="noopener">
                    เปิดไฟล์ PDF
                </a>
            </div>
        </div>
    @endif
</div>
