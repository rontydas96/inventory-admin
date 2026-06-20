<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-user-circle" style="color: var(--accent);"></i> {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8" style="background: var(--card); box-shadow: var(--shadow); border-radius: var(--radius); border: 1px solid var(--border);">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8" style="background: var(--card); box-shadow: var(--shadow); border-radius: var(--radius); border: 1px solid var(--border);">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8" style="background: var(--card); box-shadow: var(--shadow); border-radius: var(--radius); border: 1px solid var(--border);">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
