<section>
    <header>
        <h2 style="font-size: 18px; font-weight: 600; color: var(--text); display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-id-card" style="color: var(--accent);"></i> {{ __('Profile Information') }}
        </h2>

        <p style="margin-top: 6px; font-size: 14px; color: var(--text-muted);">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="margin-top: 24px;">
        @csrf
        @method('patch')

        <div style="margin-bottom: 16px;">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div style="margin-bottom: 16px;">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p style="font-size: 14px; margin-top: 8px; color: var(--text);">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" style="text-decoration: underline; font-size: 14px; color: var(--accent); background: none; border: none; cursor: pointer;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='var(--accent)'">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 8px; font-weight: 500; font-size: 14px; color: var(--success);">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 16px;">
            <x-primary-button><i class="fas fa-save"></i> {{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
