<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    @fluxAppearance
</head>

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-950 antialiased font-sans">

    <div class="flex min-h-screen">

        {{-- ================= SIDEBAR ================= --}}
        {{-- Border disesuaikan agar sedikit lebih terang dari bg #2f3182 untuk aksen yang halus --}}
        <flux:sidebar sticky collapsible
            class="bg-[#24256c] dark:bg-zinc-900 border-r border-white/10 dark:border-zinc-800">

            {{-- HEADER SIDEBAR --}}
            <flux:sidebar.header class="flex items-center !h-auto py-4">
                <div class="flex items-center w-full">
                    <a href="{{ route('dashboard') }}" class="group flex items-center no-underline outline-none">

                        {{-- LOGO CONTAINER --}}
                        <div
                            class="flex items-center justify-center overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-white/20 group-hover:ring-blue-400 transition-all duration-300
                                    h-12 w-12 in-data-flux-sidebar-collapsed-desktop:h-9 in-data-flux-sidebar-collapsed-desktop:w-9 
                                    shrink-0">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo"
                                class="h-full w-full object-contain p-1.5">
                        </div>

                        {{-- TEKS (Warna diubah ke Putih agar kontras dengan bg biru) --}}
                        <div
                            class="ml-3 transition-opacity duration-300 in-data-flux-sidebar-collapsed-desktop:hidden whitespace-nowrap">
                            <div class="flex items-center gap-1.5 text-xl font-bold tracking-tight">
                                <span class="font-[Montserrat] text-white leading-none">SIPAS</span>
                                <span
                                    class="bg-gradient-to-r from-blue-300 to-blue-500 bg-clip-text text-transparent font-[Montserrat] leading-none">DJPT</span>
                            </div>
                        </div>
                    </a>

                    {{-- Spacer --}}
                    <div class="flex-1 in-data-flux-sidebar-collapsed-desktop:hidden"></div>

                    {{-- Tombol Collapse (Warna ikon disesuaikan ke putih transparan) --}}
                    <flux:sidebar.collapse
                        class="text-white/70 hover:text-white hover:bg-white/10 in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
                </div>
            </flux:sidebar.header>

            {{-- NAVIGATION --}}
            <flux:sidebar.nav class="space-y-1">

                <div
                    class="mt-6 mb-2 px-3 text-[10px] font-bold text-white/40 dark:text-zinc-500 uppercase tracking-[0.15em] in-data-flux-sidebar-collapsed-desktop:hidden">
                    Menu Utama
                </div>
                @php
                    $itemClasses = "font-medium transition-colors duration-200 !text-white/80
                        hover:!bg-white/10 hover:!text-white
                        data-[current]:!bg-white/20 data-[current]:!text-white
                        dark:hover:!bg-blue-500/10 dark:data-[current]:!bg-blue-600/20 dark:data-[current]:!text-blue-300";
                @endphp

                <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate class="{{ $itemClasses }}">
                    Dashboard
                </flux:sidebar.item>

                @can('manage-users')
                    <flux:sidebar.item icon="users" :href="route('user.index')"
                        :current="request()->routeIs('user.index')" wire:navigate class="{{ $itemClasses }}">
                        Data Pengguna
                    </flux:sidebar.item>
                @endcan

                <div
                    class="mt-8 mb-2 px-3 text-[10px] font-bold text-white/40 dark:text-zinc-500 uppercase tracking-[0.15em] in-data-flux-sidebar-collapsed-desktop:hidden">
                    Data Arsip
                </div>

                <flux:sidebar.item icon="document-text" :href="route('keputusan.index')"
                    :current="request()->routeIs('keputusan.index')" wire:navigate class="{{ $itemClasses }}">
                    Produk Hukum
                </flux:sidebar.item>

                <flux:sidebar.item icon="folder" :href="route('data-dukung.index')"
                    :current="request()->routeIs('data-dukung.index')" wire:navigate class="{{ $itemClasses }}">
                    Penyusunan Produk Hkm
                </flux:sidebar.item>

                <flux:sidebar.item icon="briefcase" :href="route('pejabat.index')"
                    :current="request()->routeIs('pejabat.index')" wire:navigate class="{{ $itemClasses }}">
                    Pejabat Berwenang
                </flux:sidebar.item>

            </flux:sidebar.nav>

            <flux:sidebar.spacer />

            {{-- PROFILE DESKTOP --}}
            <flux:dropdown position="top" align="start" class="max-lg:hidden w-full">
                {{-- Tombol Pemicu Profile --}}
                <button type="button"
                    class="w-full group flex items-center rounded-lg transition-colors duration-200 hover:bg-white/10 outline-none
               p-2 in-data-flux-sidebar-collapsed-desktop:justify-center">

                    {{-- KOTAK AVATAR --}}
                    <div class="flex items-center justify-center h-8 w-8 shrink-0 rounded-md bg-zinc-300 shadow-sm">
                        <span class="text-sm font-bold text-zinc-800">
                            {{ auth()->user()->initials() }}
                        </span>
                    </div>

                    {{-- TEKS NAMA (Sembunyikan saat collapsed) --}}
                    <div
                        class="ml-3 flex flex-col items-start min-w-0 overflow-hidden text-left transition-opacity duration-300 in-data-flux-sidebar-collapsed-desktop:hidden">
                        <span class="block truncate text-sm font-medium text-white">
                            {{ auth()->user()->name }}
                        </span>
                    </div>

                    {{-- ICON CHEVRON (Sembunyikan saat collapsed) --}}
                    <svg class="ml-auto h-4 w-4 shrink-0 text-white/60 group-hover:text-white in-data-flux-sidebar-collapsed-desktop:hidden"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                {{-- MENU DROPDOWN --}}
                <flux:menu class="w-[220px]">
                    <div class="px-3 py-2">
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-zinc-500 truncate">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                    <flux:menu.separator />
                    <flux:menu.item icon="cog-6-tooth" :href="route('profile.edit')" wire:navigate>
                        Pengaturan
                    </flux:menu.item>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            class="text-red-600 dark:text-red-400">
                            Keluar
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>

        </flux:sidebar>

        {{-- ================= CONTENT AREA ================= --}}
        <div class="flex flex-col flex-1 min-w-0 bg-zinc-50 dark:bg-zinc-950">

            {{-- HEADER MOBILE --}}
            <flux:header
                class="lg:hidden sticky top-0 z-10 border-b border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md px-4 py-2">
                <flux:sidebar.toggle class="-ml-2 text-zinc-500" icon="bars-2" variant="ghost" />
                <flux:spacer />
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/logo.jpg') }}" class="h-6 w-6 object-contain">
                    <span class="font-bold text-sm tracking-tight dark:text-white">SIPAS DJPT</span>
                </div>
                <flux:spacer />
                <flux:dropdown position="top" align="end">
                    <flux:profile :initials="auth()->user()->initials()" class="scale-90 cursor-pointer shadow-sm" />
                    <flux:menu class="w-52 rounded-xl">
                        <flux:menu.item icon="cog-6-tooth" :href="route('profile.edit')" wire:navigate>Pengaturan
                        </flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="text-rose-500">Keluar</flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </flux:header>

            {{-- MAIN --}}
            <main class="flex flex-col flex-1">
                <div class="flex-1 px-6 py-6 lg:px-8 lg:py-8">
                    {{ $slot }}
                </div>

                {{-- FOOTER --}}
                <footer class="border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 mt-auto">
                    <div
                        class="px-8 py-4 flex flex-col md:flex-row items-center justify-between text-[11px] text-zinc-500 dark:text-zinc-400 font-medium uppercase tracking-widest">
                        <div class="flex items-center gap-2">
                            <span class="text-zinc-900 dark:text-zinc-200 font-bold">SIPAS DJPT</span>
                            <span class="h-1 w-1 rounded-full bg-zinc-500 dark:bg-zinc-600"></span>
                            <span>© {{ date('Y') }}</span>
                        </div>
                        <span class="mt-2 md:mt-0">Direktorat Jenderal Perikanan Tangkap</span>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @fluxScripts
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-new-tab', (event) => {
                const url = event.url || event[0].url;
                if (url) {
                    window.open(url, '_blank');
                }
            });
        });
    </script>
</body>

</html>
