<x-layouts.auth>
    {{-- Kotak Container (Sama dengan tema Login) --}}
    <div
        class="bg-white dark:bg-stone-900 border border-gray-200 dark:border-stone-800 shadow-xl rounded-2xl p-8 sm:p-10 transition-all">

        <div class="flex flex-col gap-6">
            {{-- Header --}}
            <x-auth-header :title="__('Lupa Password')" :description="__('Kami akan mengirimkan tautan pemulihan ke email Anda.')" />

            {{-- Status Sesi (Pesan Sukses/Error) --}}
            @if (session('status'))
                <div
                    class="flex items-center gap-3 p-4 text-sm rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 text-green-800 dark:text-green-200 animate-in fade-in slide-in-from-top-2 duration-300">
                    {{-- Ikon Ceklis Gold --}}
                    <div class="flex-shrink-0 bg-green-600 text-white rounded-full p-1 shadow-sm">
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

            {{-- Form --}}
            <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
                @csrf

                <flux:input name="email" :label="__('Alamat Email')" type="email" required autofocus icon="envelope"
                    placeholder="nama@djpt.go.id" />

                {{-- Tombol Aksi --}}
                <flux:button variant="primary" type="submit" class="w-full font-bold"
                    data-test="email-password-reset-link-button">
                    {{ __('Kirim Tautan Reset Password') }}
                </flux:button>
            </form>

            {{-- Link Kembali ke Login --}}
            <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
                <span>{{ __('Atau, kembali ke halaman') }}</span>
                <flux:link :href="route('login')" variant="subtle" class="font-semibold" wire:navigate>
                    {{ __('Masuk') }}
                </flux:link>
            </div>
        </div>
    </div>
</x-layouts.auth>
