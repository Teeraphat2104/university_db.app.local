@extends('layouts.app')

@section('title', 'ตั้งค่าระบบ - Admin')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold py-3 mb-0">ตั้งค่าระบบ</h4>
        <p class="text-muted mb-0">จัดการค่าต่างๆ ของเว็บไซต์</p>
    </div>
</div>

<div id="settings-loading" class="text-center py-5 text-muted">
    <div class="spinner-border spinner-border-sm mb-2" role="status"></div><br>
    กำลังโหลด...
</div>

<form id="settings-form" class="d-none">
    <div id="settings-groups" class="d-flex flex-column gap-4"></div>
    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
        <button type="submit" class="btn btn-primary" id="save-btn">
            <span class="saving-text"><i class="bx bx-check me-1"></i> บันทึกการตั้งค่า</span>
            <span class="saving-spinner d-none"><span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...</span>
        </button>
    </div>
</form>

<style>
    .saving .saving-text { display: none; }
    .saving .saving-spinner { display: inline-flex !important; }
    .settings-icon { width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:.5rem; font-size:1rem; }
</style>
@endsection

@section('script')
    <script>
        var LIST_API = '/api/admin/settings';
        var UPDATE_API = '/api/admin/settings/update';
        var token = localStorage.getItem('admin_token');
        var groupMeta = {
            general: { label: 'ทั่วไป', icon: 'bx bx-cog', bg: 'bg-label-primary' },
            appearance: { label: 'ลักษณะเว็บ', icon: 'bx bx-palette', bg: 'bg-label-info' },
            contact: { label: 'ช่องทางติดต่อ', icon: 'bx bx-envelope', bg: 'bg-label-success' },
            footer: { label: 'ท้ายเว็บ', icon: 'bx bx-receipt', bg: 'bg-label-warning' },
        };

        function getHeaders() { return { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }; }

        $(function() {
            if (!token) {
                $('#settings-loading').html('กรุณา <a href="/login" class="text-primary">เข้าสู่ระบบ</a> ก่อน');
                return;
            }
            loadSettings();
        });

        function loadSettings() {
            $.ajax({
                url: LIST_API, method: 'POST', headers: getHeaders(),
                success: function(json) { if (json.data) renderSettings(json.data); },
                error: function(xhr) {
                    if (xhr.status === 401) $('#settings-loading').html('เซสชันหมดอายุ กรุณา <a href="/login" class="text-primary">เข้าสู่ระบบ</a> อีกครั้ง');
                    else $('#settings-loading').html('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                }
            });
        }

        function renderSettings(groups) {
            var $container = $('#settings-groups').empty();
            var order = ['general', 'appearance', 'contact', 'footer'];
            $.each(order, function(_, groupKey) {
                var items = groups[groupKey];
                if (!items || !items.length) return;
                var meta = groupMeta[groupKey] || { label: groupKey, icon: 'bx bx-circle', bg: '' };
                var html = '<div class="card"><div class="card-header d-flex align-items-center gap-3"><div class="settings-icon ' + meta.bg + '"><i class="' + meta.icon + '"></i></div><h5 class="mb-0">' + meta.label + '</h5></div><div class="card-body">';
                $.each(items, function(_, setting) { html += renderField(setting); });
                html += '</div></div>';
                $container.append(html);
            });
            $('#settings-loading').addClass('d-none');
            $('#settings-form').removeClass('d-none');
            bindColorPreview();
        }

        function renderField(setting) {
            var key = setting.key;
            var val = setting.value || '';
            var type = setting.type;
            var labels = {
                site_name: 'ชื่อระบบ', site_description: 'คำอธิบายระบบ', academic_year: 'ปีการศึกษา',
                primary_color: 'สีหลัก', logo: 'โลโก้', favicon: 'Favicon',
                hero_title: 'หัวข้อหน้าแรก', hero_subtitle: 'คำอธิบายหน้าแรก',
                contact_email: 'อีเมลติดต่อ', contact_phone: 'เบอร์โทรศัพท์',
                facebook_url: 'Facebook', line_url: 'Line', youtube_url: 'YouTube',
                footer_text: 'ข้อความท้ายเว็บ',
            };
            var label = labels[key] || key;
            var required = ['site_name', 'contact_email'].includes(key);
            var field = '<div class="mb-3">';
            field += '<label class="form-label">' + label + (required ? ' <span class="text-danger">*</span>' : '') + '</label>';
            switch (type) {
                case 'textarea':
                    field += '<textarea id="setting-' + key + '" name="settings[' + key + ']" class="form-control" rows="3">' + $('<span>').text(val).html() + '</textarea>';
                    break;
                case 'color':
                    field += '<div class="d-flex align-items-center gap-2">';
                    field += '<input type="color" id="setting-color-' + key + '" class="form-control-color" value="' + (val || '#696cff') + '" style="width:48px;height:36px;padding:2px">';
                    field += '<input type="text" id="setting-' + key + '" name="settings[' + key + ']" class="form-control" value="' + $('<span>').text(val).html() + '" placeholder="#696cff">';
                    field += '<div class="rounded border flex-shrink-0" style="width:36px;height:36px;background:' + (val || '#696cff') + '"></div>';
                    field += '</div>';
                    break;
                case 'image':
                    var hasFile = setting.url ? true : false;
                    field += '<input type="file" id="setting-' + key + '" name="settings[' + key + ']" class="form-control" accept="image/*">';
                    if (hasFile) {
                        var previewClass = key === 'favicon' ? 'rounded" style="width:32px;height:32px;object-fit:cover' : 'rounded" style="width:80px;height:80px;object-fit:cover';
                        field += '<div class="d-flex align-items-center gap-2 mt-2"><img src="' + setting.url + '" class="' + previewClass + '"><small class="text-muted">อัปโหลดใหม่เพื่อเปลี่ยน</small></div>';
                    }
                    break;
                case 'email':
                    field += '<input type="email" id="setting-' + key + '" name="settings[' + key + ']" class="form-control" value="' + $('<span>').text(val).html() + '" placeholder="email@example.com">';
                    break;
                default:
                    field += '<input type="text" id="setting-' + key + '" name="settings[' + key + ']" class="form-control" value="' + $('<span>').text(val).html() + '" placeholder="' + label + '">';
            }
            field += '</div>';
            return field;
        }

        function bindColorPreview() {
            $('input[type="color"]').each(function() {
                var key = this.id.replace('setting-color-', '');
                var textInput = $('#setting-' + key);
                var preview = $(this).siblings('div.rounded');
                $(this).on('input', function() { var c = $(this).val(); textInput.val(c); preview.css('background', c); });
                textInput.on('input', function() { var c = $(this).val(); $('#setting-color-' + key).val(c); preview.css('background', c); });
            });
        }

        $('#settings-form').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#save-btn');
            btn.addClass('saving').prop('disabled', true);
            var fd = new FormData();
            $('.mb-3').each(function() {
                var input = $(this).find('input, textarea, select');
                if (input.length === 0) return;
                var name = input.attr('name');
                if (!name) return;
                if (input.attr('type') === 'file') { var file = input[0].files[0]; if (file) fd.append(name, file); }
                else if (input.attr('type') !== 'color') { fd.append(name, input.val()); }
            });
            $.ajax({
                url: UPDATE_API, method: 'POST',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                data: fd, processData: false, contentType: false,
                success: function() { showToast('บันทึกการตั้งค่าสำเร็จ', 'success'); btn.removeClass('saving').prop('disabled', false); },
                error: function(xhr) { var msg = 'เกิดข้อผิดพลาด'; try { msg = JSON.parse(xhr.responseText).message || msg; } catch(e) {} showToast(msg, 'error'); btn.removeClass('saving').prop('disabled', false); }
            });
        });

        function showToast(msg, type) {
            $('.toast').remove();
            $('<div class="toast ' + (type || 'info') + '">').text(msg).appendTo('body');
            setTimeout(function() { $('.toast').fadeOut(300, function() { $(this).remove(); }); }, 3000);
        }
    </script>
@endsection
