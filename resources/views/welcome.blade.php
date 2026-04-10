{{--
    Entry point — assembles layout + components.
    Actual rendering is done by Blade components in:
      - components/topbar.blade.php
      - components/public/activity-section.blade.php
      - components/admin/*.blade.php
      - components/activity-dialog.blade.php
      - components/confirm-dialog.blade.php
      - components/toast.blade.php
--}}
<x-layouts.app>
    <div class="max-w-[1180px] w-[94%] mx-auto mt-6 mb-12 max-sm:w-[96%] max-sm:mt-3.5">
        <x-topbar />

        <main class="grid gap-4">
            {{-- Public view --}}
            <x-public.activity-section />

            {{-- Admin view --}}
            <section id="admin-view" class="hidden">
                <x-admin.login-card />

                <div id="admin-dashboard" class="hidden">
                    <x-admin.dashboard-header />
                    <x-admin.category-manager />
                    <x-admin.activity-manager />
                </div>
            </section>
        </main>
    </div>

    {{-- Dialogs (rendered outside the page shell) --}}
    <x-activity-dialog />
    <x-confirm-dialog />
    <x-admin.category-form-dialog />
    <x-admin.activity-form-dialog />
    <x-toast />
</x-layouts.app>
