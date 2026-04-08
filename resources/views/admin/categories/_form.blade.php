@php
    $categoryModel = $category ?? null;
@endphp

<div class="form-grid">
    <div class="field span-4">
        <label for="category_name">ชื่อหมวดหมู่</label>
        <input type="text" id="category_name" name="category_name" value="{{ old('category_name', $categoryModel?->category_name) }}" required>
        <span class="help-text">ใช้ชื่อที่สื่อความหมาย เช่น Academic, Volunteer, Workshop</span>
    </div>
</div>
