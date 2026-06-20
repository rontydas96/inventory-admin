<section>
    <header>
        <h2 style="font-size: 18px; font-weight: 600; color: var(--text); display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-lock" style="color: var(--accent);"></i> {{ __('Update Password') }}
        </h2>

        <p style="margin-top: 6px; font-size: 14px; color: var(--text-muted);">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="margin-top: 24px;">
        @csrf
        @method('put')

        <div style="margin-bottom: 16px;">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div style="margin-bottom: 16px;">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div style="margin-bottom: 16px;">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div style="display: flex; align-items: center; gap: 16px;">
            <x-primary-button><i class="fas fa-save"></i> {{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="font-size: 14px; color: var(--success);"
                ><i class="fas fa-check-circle"></i> {{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
