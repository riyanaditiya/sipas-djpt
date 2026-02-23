<x-layouts.auth>
    <div
        class="bg-white dark:bg-stone-900 border border-gray-200 dark:border-stone-800 shadow-xl rounded-2xl p-8 sm:p-10 transition-all">

        <div class="flex flex-col gap-8">
            {{-- Header: Logo & Title --}}
            <div class="flex flex-col items-center gap-2 text-center">

                {{-- Logo dan Tulisan Berdampingan --}}
                <div class="flex items-center justify-center gap-4 mb-2">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo KKP" class="h-14 w-auto object-contain">

                    <div class="flex flex-col items-start leading-tight">
                        <div class="flex items-center gap-1.5 text-2xl font-bold tracking-wide select-none">
                            <span class="font-[Montserrat] text-zinc-900 dark:text-white">
                                SIPAS
                            </span>
                            <span
                                class="bg-gradient-to-r from-[#00A2E9] to-[#0054A3] bg-clip-text text-transparent font-[Montserrat]">
                                DJPT
                            </span>
                        </div>
                        {{-- Subtitle Instansi di bawah Nama Aplikasi --}}
                        <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                            Kementerian Kelautan dan Perikanan
                        </p>
                    </div>
                </div>

                <p class="text-md text-gray-500 dark:text-gray-400 leading-relaxed">
                    {{ __('Silakan masuk untuk mengakses akun Anda.') }}
                </p>
            </div>

            {{-- Status Alert --}}
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

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.store') }}" class="grid gap-6">
                @csrf

                {{-- Email Field --}}
                <flux:input name="email" type="email" icon="envelope" :label="__('Email')" :value="old('email')"
                    placeholder="nama@djpt.go.id" required autofocus />

                {{-- Password Field --}}
                <div class="space-y-3">
                    <div class="flex items-end justify-between">
                        <flux:label>{{ __('Kata Sandi') }}</flux:label>

                        @if (Route::has('password.request'))
                            <flux:link :href="route('password.request')" variant="subtle" class="text-xs font-semibold"
                                wire:navigate>
                                {{ __('Lupa kata sandi?') }}
                            </flux:link>
                        @endif
                    </div>

                    <flux:input name="password" type="password" icon="key" :placeholder="__('Masukkan kata sandi')"
                        required autocomplete="current-password" viewable />
                </div>

                {{-- Remember Me --}}
                <flux:checkbox name="remember" :label="__('Ingat saya')" :checked="old('remember')" />

                {{-- Action Button --}}
                <flux:button type="submit" variant="primary" class="w-full font-bold py-2.5">
                    {{ __('Masuk') }}
                </flux:button>
            </form>

            {{-- Footer --}}
            <footer class="text-center">
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-medium">
                    &copy; {{ date('Y') }} DJPT — Sistem Informasi Pengelolaan Arsip
                </p>
            </footer>
        </div>
    </div>
</x-layouts.auth>
