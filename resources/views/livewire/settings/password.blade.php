<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Perbarui kata sandi')" :subheading="__('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman')">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input wire:model="current_password" :label="__('Kata sandi saat ini')" type="password" required
                autocomplete="current-password" />
            <flux:input wire:model="password" :label="__('Kata sandi baru')" type="password" required
                autocomplete="new-password" />
            <flux:input wire:model="password_confirmation" :label="__('Konfirmasi kata sandi')" type="password" required
                autocomplete="new-password" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Simpan') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Berhasil disimpan.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
