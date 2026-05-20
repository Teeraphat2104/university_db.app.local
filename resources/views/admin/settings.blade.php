@extends('layouts.app')

@section('title', 'ตั้งค่าระบบ - Admin')

@section('style')
    <style>
        .settings-page {
            max-width: 800px;
        }

        .settings-group {
            margin-bottom: 1.5rem;
        }

        .settings-group:last-child {
            margin-bottom: 0;
        }

        .field-hint {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        .color-preview {
            width: 36px;
            height: 36px;
            border-radius: var(--radius);
            border: 2px solid var(--border);
            flex-shrink: 0;
        }

        .color-input-wrap {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .color-input-wrap input[type="color"] {
            width: 48px;
            height: 36px;
            padding: 2px;
            border-radius: var(--radius);
            cursor: pointer;
        }

        .color-input-wrap input[type="text"] {
            flex: 1;
        }

        .image-preview {
            width: 80px;
            height: 80px;
            border-radius: var(--radius);
            object-fit: cover;
            border: 1px solid var(--border);
        }

        .image-preview-sm {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            object-fit: cover;
        }

        .logo-preview-wrap {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .favicon-preview {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid var(--border);
        }

        .save-bar {
            position: sticky;
            bottom: 0;
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 1rem 0;
            margin-top: 1.5rem;
            display: flex;
            justify-content: flex-end;
        }

        .saving-spinner {
            display: none;
        }

        .saving .saving-text {
            display: none;
        }

        .saving .saving-spinner {
            display: inline-flex;
        }

        .group-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .group-icon.general {
            background: #DBEAFE;
            color: var(--primary);
        }

        .group-icon.appearance {
            background: #F3E8FF;
            color: #9333EA;
        }

        .group-icon.contact {
            background: #DCFCE7;
            color: var(--success);
        }

        .group-icon.footer {
            background: #FEF3C7;
            color: #B45309;
        }

        .group-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .group-header h3 {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        .group-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        .field-row {
            margin-bottom: 1rem;
        }

        .field-row:last-child {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="settings-page">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
            <div>
                <h2 style="font-size:24px;font-weight:700;margin-bottom:0.25rem">ตั้งค่าระบบ</h2>
                <p style="color:var(--text-muted)">จัดการค่าต่างๆ ของเว็บไซต์</p>
            </div>
        </div>

        <div id="settings-loading" style="text-align:center;padding:3rem;color:var(--text-muted)">
            <i class="bi bi-arrow-repeat bi-spin" style="font-size:1.5rem;display:block;margin-bottom:0.75rem"></i>
            กำลังโหลด...
        </div>

        <form id="settings-form" style="display:none">
            <div id="settings-groups"></div>
            <div class="save-bar">
                <button type="submit" class="btn btn-primary" id="save-btn">
                    <span class="saving-text"><i class="bi bi-check-lg"></i> บันทึกการตั้งค่า</span>
                    <span class="saving-spinner"><i class="bi bi-arrow-repeat bi-spin"></i> กำลังบันทึก...</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        var API = '/api/admin/settings';
        var token = localStorage.getItem('admin_token');
        var groupMeta = {
            general: {
                label: 'ทั่วไป',
                icon: 'bi bi-gear',
                css: 'general'
            },
            appearance: {
                label: 'ลักษณะเว็บ',
                icon: 'bi bi-palette',
                css: 'appearance'
            },
            contact: {
                label: 'ช่องทางติดต่อ',
                icon: 'bi bi-envelope',
                css: 'contact'
            },
            footer: {
                label: 'ท้ายเว็บ',
                icon: 'bi bi-layout-text-window',
                css: 'footer'
            },
        };

        function getHeaders() {
            return {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            };
        }

        $(function() {
            if (!token) {
                $('#settings-loading').html(
                    'กรุณา <a href="/login" style="color:var(--primary)">เข้าสู่ระบบ</a> ก่อน');
                return;
            }
            loadSettings();
        });

        function loadSettings() {
            $.ajax({
                url: API,
                method: 'GET',
                headers: getHeaders(),
                success: function(json) {
                    if (!json.data) return;
                    renderSettings(json.data);
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        $('#settings-loading').html(
                            'เซสชันหมดอายุ กรุณา <a href="/login" style="color:var(--primary)">เข้าสู่ระบบ</a> อีกครั้ง'
                            );
                    } else {
                        $('#settings-loading').html('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                    }
                }
            });
        }

        function renderSettings(groups) {
            var $container = $('#settings-groups').empty();
            var order = ['general', 'appearance', 'contact', 'footer'];

            $.each(order, function(_, groupKey) {
                var items = groups[groupKey];
                if (!items || !items.length) return;

                var meta = groupMeta[groupKey] || {
                    label: groupKey,
                    icon: 'bi bi-circle',
                    css: ''
                };
                var html = '<div class="card settings-group">' +
                    '<div class="card-header">' +
                    '<div class="group-header">' +
                    '<div class="group-icon ' + meta.css + '"><i class="' + meta.icon + '"></i></div>' +
                    '<div><h3>' + meta.label + '</h3></div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="card-body">';

                $.each(items, function(_, setting) {
                    html += renderField(setting);
                });

                html += '</div></div>';
                $container.append(html);
            });

            $('#settings-loading').hide();
            $('#settings-form').show();
            bindColorPreview();
        }

        function renderField(setting) {
            var key = setting.key;
            var val = setting.value || '';
            var type = setting.type;
            var labels = {
                site_name: 'ชื่อระบบ',
                site_description: 'คำอธิบายระบบ',
                academic_year: 'ปีการศึกษา',
                primary_color: 'สีหลัก',
                logo: 'โลโก้',
                favicon: 'Favicon',
                hero_title: 'หัวข้อหน้าแรก',
                hero_subtitle: 'คำอธิบายหน้าแรก',
                contact_email: 'อีเมลติดต่อ',
                contact_phone: 'เบอร์โทรศัพท์',
                facebook_url: 'Facebook',
                line_url: 'Line',
                youtube_url: 'YouTube',
                footer_text: 'ข้อความท้ายเว็บ',
            };
            var label = labels[key] || key;
            var required = ['site_name', 'contact_email'].includes(key);

            var field = '<div class="field-row">';
            field += '<label class="field-label">' + label + (required ? ' <span style="color:var(--danger)">*</span>' :
                '') + '</label>';

            switch (type) {
                case 'textarea':
                    field += '<textarea id="setting-' + key + '" name="settings[' + key + ']" rows="3">' + $('<span>').text(
                        val).html() + '</textarea>';
                    break;
                case 'color':
                    field += '<div class="color-input-wrap">';
                    field += '<input type="color" id="setting-color-' + key + '" value="' + (val || '#6366F1') + '">';
                    field += '<input type="text" id="setting-' + key + '" name="settings[' + key + ']" value="' + $(
                        '<span>').text(val).html() + '" placeholder="#6366F1">';
                    field += '<div class="color-preview" id="preview-' + key + '" style="background:' + (val || '#6366F1') +
                        '"></div>';
                    field += '</div>';
                    break;
                case 'image':
                    var hasFile = setting.url ? true : false;
                    field += '<input type="file" id="setting-' + key + '" name="settings[' + key +
                        ']" accept="image/*" style="padding:0;border:none">';
                    if (hasFile) {
                        field += '<div class="logo-preview-wrap">';
                        if (key === 'favicon') {
                            field += '<img src="' + setting.url + '" class="favicon-preview">';
                        } else {
                            field += '<img src="' + setting.url + '" class="image-preview">';
                        }
                        field += '<span style="font-size:12px;color:var(--text-muted)">อัปโหลดใหม่เพื่อเปลี่ยน</span>';
                        field += '</div>';
                    }
                    break;
                case 'email':
                    field += '<input type="email" id="setting-' + key + '" name="settings[' + key + ']" value="' + $(
                        '<span>').text(val).html() + '" placeholder="email@example.com">';
                    break;
                default:
                    field += '<input type="text" id="setting-' + key + '" name="settings[' + key + ']" value="' + $(
                        '<span>').text(val).html() + '" placeholder="' + label + '">';
            }

            field += '</div>';
            return field;
        }

        function bindColorPreview() {
            $('input[type="color"]').each(function() {
                var key = this.id.replace('setting-color-', '');
                var textInput = $('#setting-' + key);
                var preview = $('#preview-' + key);

                $(this).on('input', function() {
                    var c = $(this).val();
                    textInput.val(c);
                    preview.css('background', c);
                });

                textInput.on('input', function() {
                    var c = $(this).val();
                    $('#setting-color-' + key).val(c);
                    preview.css('background', c);
                });
            });
        }

        $('#settings-form').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#save-btn');
            btn.addClass('saving').prop('disabled', true);

            var fd = new FormData();
            fd.append('_method', 'PUT');

            $('.field-row').each(function() {
                var input = $(this).find('input, textarea, select');
                if (input.length === 0) return;
                var name = input.attr('name');
                if (!name) return;

                if (input.attr('type') === 'file') {
                    var file = input[0].files[0];
                    if (file) fd.append(name, file);
                } else if (input.attr('type') === 'color') {
                    // skip color picker input, use text input
                } else {
                    fd.append(name, input.val());
                }
            });

            $.ajax({
                url: API,
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },
                data: fd,
                processData: false,
                contentType: false,
                success: function() {
                    showToast('บันทึกการตั้งค่าสำเร็จ', 'success');
                    btn.removeClass('saving').prop('disabled', false);
                },
                error: function(xhr) {
                    var msg = 'เกิดข้อผิดพลาด';
                    try {
                        msg = JSON.parse(xhr.responseText).message || msg;
                    } catch (e) {}
                    showToast(msg, 'error');
                    btn.removeClass('saving').prop('disabled', false);
                }
            });
        });

        function showToast(msg, type) {
            $('.toast').remove();
            $('<div class="toast ' + (type || 'info') + '">').text(msg).appendTo('body');
            setTimeout(function() {
                $('.toast').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    </script>
@endsection
