<section>
    <header>
        <h2 style="font-size: 18px; font-weight: 600; color: var(--danger); display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-trash-alt" style="color: var(--danger);"></i> {{ __('Delete Account') }}
        </h2>

        <p style="margin-top: 6px; font-size: 14px; color: var(--text-muted);">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <div style="margin-top: 16px;">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        ><i class="fas fa-trash-alt"></i> {{ __('Delete Account') }}</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding: 24px;">
            @csrf
            @method('delete')

            <h2 style="font-size: 18px; font-weight: 600; color: var(--text); display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-exclamation-triangle" style="color: var(--danger);"></i> {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p style="margin-top: 6px; font-size: 14px; color: var(--text-muted);">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div style="margin-top: 24px;">
                <x-input-label for="password" value="{{ __('Password') }}" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" />
            </div>

            <div style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 8px;">
                <x-secondary-button x-on:click="$dispatch('close')">
                    <i class="fas fa-times"></i> {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button>
                    <i class="fas fa-trash-alt"></i> {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
