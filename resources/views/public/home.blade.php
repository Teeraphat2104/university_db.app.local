@extends('layouts.public')

@section('title', 'หน้าแรก | ระบบกิจกรรมนักศึกษา')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div class="hero-copy">
                <span class="eyebrow">Student Activity Hub</span>
                <h1>ค้นหากิจกรรมนักศึกษาได้ในหน้าเดียว</h1>
                <p>
                    ค้นหากิจกรรมตามคำสำคัญ หมวดหมู่ และช่วงวันที่
                    พร้อมดูรายละเอียดและดาวน์โหลดเอกสารประกอบได้ทันทีโดยไม่ต้องเข้าสู่ระบบ
                </p>

                <div class="actions">
                    <a href="#search-panel" class="button">เริ่มค้นหา</a>
                    <a href="{{ route('activities.index') }}" class="button secondary">ดูกิจกรรมทั้งหมด</a>
                </div>
            </div>

            <div class="stats">
                <div class="stat">
                    <div class="stat-label">กิจกรรมที่เผยแพร่</div>
                    <div class="stat-value">{{ $activityCount }}</div>
                </div>
                <div class="stat">
                    <div class="stat-label">หมวดหมู่ทั้งหมด</div>
                    <div class="stat-value">{{ $categories->count() }}</div>
                </div>
                <div class="stat">
                    <div class="stat-label">การเข้าถึง</div>
                    <div class="stat-value">Public</div>
                </div>
                <div class="stat">
                    <div class="stat-label">เอกสารแนบ</div>
                    <div class="stat-value">PDF</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section panel" id="search-panel">
        <div class="section-head">
            <div>
                <h2>ค้นหากิจกรรม</h2>
                <p>กรอกเงื่อนไขที่ต้องการ แล้วผลลัพธ์จะแสดงด้านล่างในหน้าเดียวกัน</p>
            </div>
        </div>

        <div id="home-search-feedback" class="flash" hidden></div>

        <form action="{{ route('home') }}" method="GET" class="form-grid" id="home-search-form">
            <div class="field span-2">
                <label for="search">คำค้นหา</label>
                <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="เช่น workshop, volunteer, orientation">
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
                    <button type="submit" id="home-search-submit-button">ค้นหากิจกรรม</button>
                    <a href="{{ route('home') }}" class="button secondary">ล้างตัวกรอง</a>
                </div>
            </div>
        </form>
    </section>

    <section class="section">
        <div class="section-head">
            <div>
                <h2>ผลการค้นหา</h2>
                <p id="home-search-result-meta">
                    @if ($hasActiveFilters && $activities)
                        พบ {{ $activities->total() }} รายการ
                    @else
                        เริ่มจากกรอกเงื่อนไขด้านบนเพื่อค้นหากิจกรรม
                    @endif
                </p>
            </div>
        </div>

        <div id="home-search-results" class="card-grid">
            @if ($hasActiveFilters && $activities)
                @include('public.activities._cards', ['activities' => $activities])
            @else
                <article class="card empty-state">
                    <h3>ยังไม่มีผลการค้นหา</h3>
                    <p>เลือกหมวดหมู่หรือใส่คำค้นหา แล้วกดค้นหากิจกรรมเพื่อดูรายการที่ต้องการ</p>
                </article>
            @endif
        </div>

        <div id="home-search-pagination">
            @if ($hasActiveFilters && $activities)
                @include('public.activities._pager', ['activities' => $activities])
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            const formSelector = '#home-search-form';
            const $submitButton = $('#home-search-submit-button');
            const baseShowUrl = '{{ url('/activities') }}';

            const escapeHtml = (value) => $('<div>').text(value ?? '').html();
            const formatDate = (value) => {
                if (!value) {
                    return '-';
                }

                const date = new Date(value);

                if (Number.isNaN(date.getTime())) {
                    return value;
                }

                return date.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            };

            const buildCards = (items) => {
                if (!items.length) {
                    return '<article class="card empty-state"><h3>ไม่พบกิจกรรมที่ตรงกับเงื่อนไข</h3><p>ลองเปลี่ยนคำค้นหา หมวดหมู่ หรือช่วงวันที่ แล้วค้นหาอีกครั้ง</p></article>';
                }

                return items.map((item) => {
                    const documentLink = item.document && item.document.file_url
                        ? '<a href="' + item.document.file_url + '" class="button" target="_blank" rel="noopener">เอกสาร PDF</a>'
                        : '';

                    return `
                        <article class="card">
                            <div class="button-group">
                                <span class="badge">${escapeHtml(item.category?.category_name)}</span>
                                <span class="badge neutral">${escapeHtml((item.status || '').charAt(0).toUpperCase() + (item.status || '').slice(1))}</span>
                            </div>
                            <div class="stack">
                                <h3>${escapeHtml(item.title)}</h3>
                                <p>${escapeHtml(item.description)}</p>
                            </div>
                            <div class="meta-list">
                                <span>วันที่ ${escapeHtml(formatDate(item.activity_date))}</span>
                                <span>สถานที่ ${escapeHtml(item.location)}</span>
                                <span>ผู้จัด ${escapeHtml(item.organizer)}</span>
                            </div>
                            <div class="button-group">
                                <a href="${baseShowUrl}/${item.id}" class="button secondary">ดูรายละเอียด</a>
                                ${documentLink}
                            </div>
                        </article>
                    `;
                }).join('');
            };

            const buildPagination = (pagination) => {
                if (!pagination || pagination.last_page <= 1) {
                    return '';
                }

                const previous = pagination.previous_page_url
                    ? `<a href="${pagination.previous_page_url}" class="pager-link js-home-search-page">ย้อนกลับ</a>`
                    : '<span class="pager-link disabled">ย้อนกลับ</span>';

                const next = pagination.next_page_url
                    ? `<a href="${pagination.next_page_url}" class="pager-link js-home-search-page">ถัดไป</a>`
                    : '<span class="pager-link disabled">ถัดไป</span>';

                return `
                    <div class="pager">
                        ${previous}
                        <span class="muted">หน้า ${pagination.current_page} จาก ${pagination.last_page}</span>
                        ${next}
                    </div>
                `;
            };

            const updateUrl = (url, data) => {
                const requestUrl = new URL(url, window.location.origin);
                const queryString = typeof data === 'string'
                    ? data
                    : (data && Object.keys(data).length ? new URLSearchParams(data).toString() : requestUrl.search.replace(/^\?/, ''));

                window.history.replaceState(null, '', queryString ? ('{{ route('home') }}' + '?' + queryString) : '{{ route('home') }}');
            };

            const runSearch = (url, data) => {
                $submitButton.prop('disabled', true).text('กำลังค้นหา...');

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: data,
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).done(function (payload) {
                    const dataSet = payload.data || {};

                    $('#home-search-results').html(buildCards(dataSet.items || []));
                    $('#home-search-pagination').html(buildPagination(dataSet.pagination || {}));
                    $('#home-search-result-meta').text(
                        dataSet.has_active_filters
                            ? 'พบ ' + ((dataSet.pagination && dataSet.pagination.total) || 0) + ' รายการ'
                            : 'เริ่มจากกรอกเงื่อนไขด้านบนเพื่อค้นหากิจกรรม'
                    );

                    updateUrl(url, data);
                }).fail(function (xhr) {
                    const payload = xhr.responseJSON || {};
                    AppUi.showFeedback(
                        '#home-search-feedback',
                        'error',
                        payload.message || 'ไม่สามารถค้นหากิจกรรมได้',
                        payload.error ? [payload.error] : []
                    );
                }).always(function () {
                    $submitButton.prop('disabled', false).text('ค้นหากิจกรรม');
                });
            };

            $(formSelector).on('submit', function (event) {
                event.preventDefault();
                runSearch(this.action, $(this).serialize());
            });

            $(document).on('click', '.js-home-search-page', function (event) {
                event.preventDefault();
                runSearch(this.href, null);
            });
        });
    </script>
@endpush
