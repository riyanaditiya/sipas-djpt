<div>
    @include('partials.alert')

    <div class="relative w-full">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-start gap-5 mb-6">
                {{-- Ikon Statis dengan Shadow Halus --}}
                <div class="flex-shrink-0">
                    <div
                        class="flex items-center justify-center size-12 rounded-xl bg-gradient-to-tr from-blue-50 to-white dark:from-blue-500/10 dark:to-transparent border border-blue-100 dark:border-blue-500/20 shadow-sm">
                        <flux:icon.folder variant="outline" class="size-6 text-blue-600 dark:text-blue-400" />
                    </div>
                </div>

                {{-- Judul & Subheading --}}
                <div class="flex flex-col gap-1">
                    <flux:heading size="xl" level="1"
                        class="font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
                        {{ __('Data Dukung Penyusunan Produk Hukum') }}
                    </flux:heading>

                    <flux:subheading size="lg"
                        class="hidden sm:block text-slate-500 dark:text-slate-400 font-medium">
                        {{ __('Daftar data dukung yang tersimpan dalam sistem') }}
                    </flux:subheading>
                </div>
            </div>
            <flux:separator variant="subtle" />

        </div>

        <div class="mt-5">
            {{-- Toolbar: Pencarian & Filter --}}
            {{-- Toolbar: Pencarian & Filter --}}
            <div class="mb-6">
                {{-- Container Utama: Berubah jadi Column di mobile, Row di Desktop --}}
                <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">

                    {{-- Grup Input & Select: Grid yang menyesuaikan layar --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-12 gap-3 flex-grow">

                        {{-- Input Pencarian --}}
                        <div class="relative sm:col-span-2 lg:col-span-6 group">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-zinc-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg focus:ring-[#00A2E9] focus:border-[#00A2E9] block w-full pl-10 p-2.5 outline-none shadow-sm"
                                placeholder="Cari produk hukum...">
                        </div>

                        {{-- Filter Kategori --}}
                        <div class="sm:col-span-1 lg:col-span-3">
                            <select wire:model.live="selectedCategory"
                                class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg block w-full p-2.5 outline-none shadow-sm text-zinc-700 dark:text-zinc-300">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Status --}}
                        <div class="sm:col-span-1 lg:col-span-3">
                            <select wire:model.live="filterStatus"
                                class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg block w-full p-2.5 outline-none shadow-sm text-zinc-700 dark:text-zinc-300">
                                <option value="">Status</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Belum Selesai">Belum Selesai</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tombol Tambah --}}
                    <div class="w-full xl:w-auto">
                        <a wire:navigate href="{{ route('data-dukung.create') }}"
                            class="flex items-center justify-center gap-2 text-white bg-[#0576a6] hover:bg-[#0054A3] font-bold rounded-lg text-sm px-6 py-2.5 w-full xl:w-auto shadow-sm active:scale-95 transition-all">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="whitespace-nowrap">Tambah Data</span>
                        </a>
                    </div>

                </div>
            </div>

            {{-- Tabel --}}
            <div
                class="bg-white dark:bg-zinc-900 shadow-sm border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left table-fixed divide-y divide-zinc-200 dark:divide-zinc-800">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                            <tr>
                                <th
                                    class="px-4 py-4 w-[200px] sm:w-[30%] text-zinc-500 font-bold uppercase text-[10px] tracking-widest">
                                    Kategori
                                </th>
                                <th
                                    class="px-4 py-4 w-[200px] sm:w-[35%] text-zinc-500 font-bold uppercase text-[10px] tracking-widest">
                                    Produk Hukum
                                </th>
                                <th
                                    class="px-4 py-4 w-[120px] sm:w-[15%] text-center text-zinc-500 font-bold uppercase text-[10px] tracking-widest">
                                    Status
                                </th>
                                <th
                                    class="px-4 py-4 w-[150px] sm:w-[20%] text-center text-zinc-500 font-bold uppercase text-[10px] tracking-widest">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @forelse ($arsips as $dkg)
                                <tr class="hover:bg-zinc-50/80 dark:hover:bg-zinc-800/50 transition-colors">
                                    {{-- Kategori --}}
                                    <td class="px-4 py-4 text-zinc-700 dark:text-zinc-300">
                                        <span
                                            class="inline-flex items-center rounded-md bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300
                                                px-2.5 py-1 text-xs font-medium">
                                            {{ $dkg->category->name ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Produk Hukum --}}
                                    <td
                                        class="px-4 py-4 font-medium text-zinc-900 dark:text-zinc-100 break-words leading-relaxed">
                                        {{ $dkg->produk_hukum }}
                                    </td>
                                    {{-- Keterangan (Status) --}}
                                    <td class="px-4 py-3 text-center">
                                        <button wire:click="toggleStatus('{{ $dkg->uuid }}')"
                                            wire:loading.attr="disabled"
                                            class="group relative inline-flex items-center">
                                            <span
                                                class="px-2 py-1 rounded text-xs font-medium cursor-pointer transition-all duration-200 
                                            {{ $dkg->keterangan == 'Selesai' ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                                {{ $dkg->keterangan }}
                                            </span>
                                            <div wire:loading wire:target="toggleStatus('{{ $dkg->uuid }}')"
                                                class="absolute -right-6">
                                                <svg class="animate-spin h-4 w-4 text-yellow-600" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </button>
                                    </td>
                                    {{-- Aksi --}}
                                    <td class="px-4 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Detail --}}
                                            <a wire:navigate href="{{ route('details.index', $dkg->uuid) }}"
                                                class="px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 dark:bg-blue-500/10 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors border border-blue-200 dark:border-blue-500/20">
                                                Detail
                                            </a>
                                            {{-- Edit --}}
                                            <a wire:navigate href="{{ route('data-dukung.edit', $dkg->uuid) }}"
                                                title="Edit"
                                                class="p-2 text-yellow-600 bg-yellow-50 dark:bg-[#00A2E9]/10 rounded-lg hover:bg-yellow-100 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            {{-- Delete --}}
                                            <button wire:click="confirmDelete('{{ $dkg->uuid }}')" title="Hapus"
                                                class="p-2 text-red-600 bg-red-50 dark:bg-red-500/10 rounded-lg hover:bg-red-100 transition-colors">
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
                                    <td colspan="4" class="px-4 py-12 text-center">
                                        <svg class="mx-auto w-16 h-16 text-gray-400 dark:text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 9.75L14.25 14.25M14.25 9.75L9.75 14.25M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="mt-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Data
                                            tidak ditemukan</h3>
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            Coba masukkan kata kunci lain atau periksa kembali pencarian Anda.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $arsips->links() }}
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
