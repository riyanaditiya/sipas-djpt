<div>
    {{-- Toast Notification --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-5 right-5 flex items-center gap-3
           bg-green-500 text-white px-5 py-3
           rounded-lg shadow-lg z-[9999]">
            <div class="flex h-9 w-9 items-center justify-center
                rounded-full bg-white/20">
                <svg class="w-5 h-5 animate-[pop_0.4s_ease-out]" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <span class="text-sm font-semibold tracking-wide">
                {{ session('success') }}
            </span>
        </div>

        <style>
            @keyframes pop {
                0% {
                    transform: scale(0.6);
                    opacity: 0;
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }
        </style>
    @endif

    <div class="relative w-full">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-start gap-5 mb-6">
                {{-- Ikon Statis dengan Shadow Halus --}}
                <div class="flex-shrink-0">
                    <div
                        class="flex items-center justify-center size-12 rounded-xl bg-gradient-to-tr from-blue-50 to-white dark:from-blue-500/10 dark:to-transparent border border-blue-100 dark:border-blue-500/20 shadow-sm">
                        <flux:icon.briefcase variant="outline" class="size-6 text-blue-600 dark:text-blue-400" />
                    </div>
                </div>

                {{-- Judul & Subheading --}}
                <div class="flex flex-col gap-1">
                    <flux:heading size="xl" level="1"
                        class="font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
                        {{ __('Daftar Pejabat Berwenang') }}
                    </flux:heading>

                    <flux:subheading size="lg"
                        class="hidden sm:block text-slate-500 dark:text-slate-400 font-medium">
                        {{ __('Manajemen data Dirjen, KPA, KPB, dan PPK yang terdaftar') }}
                    </flux:subheading>
                </div>
            </div>
            <flux:separator variant="subtle" />

        </div>

        <div class="mt-5">
            {{-- Toolbar: Pencarian & Filter --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-4">
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    {{-- Input Pencarian --}}
                    <div class="relative w-full sm:w-80 group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-zinc-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg focus:ring-[#00A2E9] focus:border-[#00A2E9] block w-full pl-10 p-2.5 outline-none shadow-sm"
                            placeholder="Cari nama pejabat...">
                    </div>

                    {{-- Filter Kategori --}}
                    <select wire:model.live="selectedCategory"
                        class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg block w-full sm:w-48 p-2.5 outline-none shadow-sm text-zinc-700 dark:text-zinc-300">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Tambah --}}
                <div class="w-full sm:w-auto">
                    <a wire:navigate href="{{ route('pejabat.create') }}"
                        class="flex items-center justify-center gap-2 text-white bg-[#0576a6] hover:bg-[#0054A3] font-bold rounded-lg text-sm px-5 py-2.5 w-full shadow-sm active:scale-95 transition-transform">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Data
                    </a>
                </div>
            </div>

            {{-- Tabel --}}
            <div
                class="bg-white dark:bg-zinc-900 shadow-sm border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left table-auto divide-y divide-zinc-200 dark:divide-zinc-800">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap">
                                    Kategori</th>
                                <th scope="col"
                                    class="px-6 py-4 text-zinc-500 font-bold uppercase text-[10px] tracking-widest min-w-[350px]">
                                    Nama Pejabat</th>
                                <th scope="col"
                                    class="px-6 py-4 text-zinc-500 font-bold uppercase text-[10px] tracking-widest min-w-[250px]">
                                    Jabatan</th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap">
                                    Tanggal</th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap">
                                    SK</th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @forelse ($pejabats as $pejabat)
                                @php
                                    $namas = is_array($pejabat->nama)
                                        ? $pejabat->nama
                                        : json_decode($pejabat->nama, true) ?? [];
                                    $jabatans = is_array($pejabat->jabatan)
                                        ? $pejabat->jabatan
                                        : json_decode($pejabat->jabatan, true) ?? [];
                                    $maxRows = max(count((array) $namas), count((array) $jabatans));
                                @endphp
                                <tr class="hover:bg-zinc-50/80 dark:hover:bg-zinc-800/50 transition-colors align-top">
                                    {{-- Kategori --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center rounded-md bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 px-2.5 py-1 text-[10px] font-medium uppercase">
                                            {{ $pejabat->category->name ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Nama Pejabat --}}
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-2">
                                            @for ($i = 0; $i < $maxRows; $i++)
                                                <div class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                                                    @if ($maxRows > 1)
                                                        <span
                                                            class="text-zinc-400 mr-1 text-xs">{{ $i + 1 }}.</span>
                                                    @endif
                                                    {{ $namas[$i] ?? '-' }}
                                                </div>
                                            @endfor
                                        </div>
                                    </td>

                                    {{-- Jabatan / Tentang --}}
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-2">
                                            @for ($i = 0; $i < $maxRows; $i++)
                                                <div
                                                    class="text-zinc-600 dark:text-zinc-400 leading-relaxed text-justify">
                                                    @if ($maxRows > 1)
                                                        <span
                                                            class="text-zinc-400 mr-1 text-xs">{{ $i + 1 }}.</span>
                                                    @endif
                                                    {{ $jabatans[$i] ?? '-' }}
                                                </div>
                                            @endfor
                                        </div>
                                    </td>

                                    {{-- Tanggal --}}
                                    <td
                                        class="px-6 py-4 text-center tabular-nums text-zinc-600 dark:text-zinc-400 whitespace-nowrap text-xs sm:text-sm">
                                        {{ \Carbon\Carbon::parse($pejabat->tgl_pengangkatan)->translatedFormat('d F Y') }}
                                    </td>

                                    {{-- Dokumen SK --}}
                                    <td class="px-6 py-4 text-center">
                                        @if ($pejabat->dokumen_sk)
                                            <a href="{{ asset('storage/' . $pejabat->dokumen_sk) }}" target="_blank"
                                                class="p-2 inline-flex text-red-600 bg-red-50 dark:bg-red-500/10 rounded-lg hover:bg-red-100 transition-colors border border-red-100 dark:border-red-500/20 shadow-sm"
                                                title="Lihat SK">
                                                <svg class="w-4 h-4" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                                                </svg>
                                            </a>
                                        @else
                                            <span class="text-zinc-400">-</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a wire:navigate href="{{ route('pejabat.edit', $pejabat->uuid) }}"
                                                title="Edit"
                                                class="p-2 text-yellow-600 bg-yellow-50 dark:bg-yellow-500/10 rounded-lg hover:bg-yellow-100 transition-colors border border-yellow-100 dark:border-yellow-500/20 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button wire:click="confirmDelete('{{ $pejabat->uuid }}')" title="Hapus"
                                                class="p-2 text-red-600 bg-red-50 dark:bg-red-500/10 rounded-lg hover:bg-red-100 transition-colors border border-red-100 dark:border-red-500/20 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-12 text-center">
                                        <svg class="mx-auto w-16 h-16 text-gray-400 dark:text-gray-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 9.75L14.25 14.25M14.25 9.75L9.75 14.25M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="mt-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Data
                                            tidak ditemukan</h3>
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Coba masukkan kata
                                            kunci lain atau periksa kembali pencarian Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $pejabats->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    @if ($deleteUuid)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Hapus</h2>
                <p class="mt-2 text-gray-600">Apakah Anda yakin ingin menghapus data ini?</p>
                <div class="mt-4 flex justify-end gap-3">
                    <button wire:click="$set('deleteUuid', null)"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button wire:click="delete"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>
