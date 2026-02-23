<x-layouts.auth>
    {{-- Kotak Container (Sesuai tema Login) --}}
    <div
        class="bg-white dark:bg-stone-900 border border-gray-200 dark:border-stone-800 shadow-xl rounded-2xl p-8 sm:p-10 transition-all">

        <div class="flex flex-col gap-6">
            {{-- Header --}}
            <x-auth-header :title="__('Reset Password')" :description="__('Silakan masukkan kata sandi baru Anda di bawah ini.')" />

            @if (session('status'))
                <div
                    class="flex items-center gap-3 p-4 text-sm rounded-xl bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800/50 text-yellow-800 dark:text-yellow-200 animate-in fade-in slide-in-from-top-2 duration-300">
                    {{-- Ikon Ceklis Gold --}}
                    <div class="flex-shrink-0 bg-yellow-600 text-white rounded-full p-1 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>

                    {{-- Pesan dari Session --}}
                    <p class="font-medium tracking-tight">
                        {{ session('status') }}
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
                @csrf

                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <flux:input name="email" :value="old('email', request('email'))" :label="__('Alamat Email')"
                    type="email" required autocomplete="email" icon="envelope" />

                <flux:input name="password" :label="__('Kata Sandi Baru')" type="password" required
                    autocomplete="new-password" :placeholder="__('Masukkan kata sandi baru')" icon="key" viewable />

                <flux:input name="password_confirmation" :label="__('Konfirmasi Kata Sandi')" type="password" required
                    autocomplete="new-password" :placeholder="__('Ulangi kata sandi baru')" icon="check-circle"
                    viewable />

                <div class="flex items-center justify-end">
                    <flux:button type="submit" variant="primary" class="w-full font-bold"
                        data-test="reset-password-button">
                        {{ __('Simpan Kata Sandi') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>
