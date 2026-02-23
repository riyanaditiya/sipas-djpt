{{-- Wrapper Utama dengan overflow-hidden untuk mematikan scroll horizontal global --}}
<div class="relative flex-1 min-w-0 overflow-x-hidden">

    {{-- Flash Message / Toast Notification --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-5 right-5 flex items-center gap-3
           bg-green-500 text-white px-5 py-3
           rounded-lg shadow-lg z-[9999]">
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white/20">
                <svg class="w-5 h-5 animate-[pop_0.4s_ease-out]" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <span class="text-sm font-semibold tracking-wide">{{ session('success') }}</span>
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

    <div class="w-full">
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
                        {{ __('Detail Data Dukung') }}
                    </flux:heading>

                    <flux:subheading size="lg"
                        class="hidden sm:block text-slate-500 dark:text-slate-400 font-medium">
                        {{ __('Manajemen rincian kegiatan untuk produk hukum ini') }}
                    </flux:subheading>
                </div>
            </div>
            <flux:separator variant="subtle" />

        </div>

        {{-- Info Card Induk --}}
        <div
            class="mb-6 bg-zinc-50 dark:bg-white/5 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">

                <div class="md:col-span-4 min-w-0">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-1">Produk Hukum</p>
                    <p class="text-base font-bold text-zinc-900 dark:text-zinc-100 italic leading-tight break-words">
                        {{ $dataDukung->produk_hukum }}
                    </p>
                </div>

                <div class="md:col-span-2 flex flex-col md:items-end shrink-0">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-2">Keterangan</p>
                    <button wire:click="toggleStatus"
                        class="group flex items-center gap-2 transition-all active:scale-95">
                        <span
                            class="px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider shadow-sm 
                    {{ $dataDukung->keterangan == 'Selesai' ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400' }}">
                            {{ $dataDukung->keterangan }}
                        </span>
                        <div
                            class="p-1.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded shadow-sm group-hover:rotate-180 transition-transform duration-500">
                            <flux:icon.arrow-path class="w-3.5 h-3.5 text-zinc-500" />
                        </div>
                    </button>
                </div>

            </div>
        </div>

        {{-- Toolbar: Pencarian & Tombol Tambah --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <flux:button wire:navigate href="{{ route('data-dukung.index') }}" variant="filled" icon="chevron-left"
                    class="shrink-0" />

                <div class="relative w-full sm:w-80 group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-zinc-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg focus:ring-[#00A2E9] focus:border-[#00A2E9] block w-full pl-10 p-2.5 outline-none shadow-sm transition-all"
                        placeholder="Cari rincian kegiatan...">
                </div>
            </div>

            <div class="w-full sm:w-auto">
                <a wire:navigate href="{{ route('details.create', $dataDukung->uuid) }}"
                    class="flex items-center justify-center gap-2 text-white bg-[#0576a6] hover:bg-[#0054A3] font-bold rounded-lg text-sm px-6 py-2.5 w-full transition-all active:scale-95 shadow-md whitespace-nowrap">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Rincian
                </a>
            </div>
        </div>

        {{-- Table Rincian dengan Container yang Benar --}}
        <div
            class="bg-white dark:bg-zinc-900 shadow-sm border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden min-w-0">
            <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700">
                <table class="w-full text-sm text-left table-auto divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                        <tr>
                            <th
                                class="px-6 py-4 w-12 text-zinc-500 font-bold uppercase text-[10px] tracking-widest text-center">
                                No</th>
                            <th
                                class="px-6 py-4 text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap">
                                Tanggal</th>
                            <th
                                class="px-6 py-4 text-zinc-500 font-bold uppercase text-[10px] tracking-widest min-w-[200px]">
                                Kegiatan</th>
                            <th
                                class="px-6 py-4 text-zinc-500 font-bold uppercase text-[10px] tracking-widest min-w-[300px]">
                                Data Dukung</th>
                            <th
                                class="px-6 py-4 text-center text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap">
                                File</th>
                            <th
                                class="px-6 py-4 text-center text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($details as $index => $detail)
                            <tr class="hover:bg-zinc-50/80 dark:hover:bg-zinc-800/50 transition-colors align-top">
                                <td class="px-6 py-4 text-center font-medium text-zinc-400 tabular-nums">
                                    {{ $details->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="text-sm font-medium text-zinc-500 dark:text-zinc-100 tabular-nums tracking-tight">
                                        {{ \Carbon\Carbon::parse($detail->tanggal)->translatedFormat('d F Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-zinc-500 dark:text-zinc-100 leading-tight">
                                        {{ $detail->kegiatan }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="text-[11px] text-zinc-600 dark:text-zinc-400 leading-relaxed text-justify break-words 
                                        [&_ol]:list-decimal [&_ul]:list-disc [&_ol]:ml-4 [&_ul]:ml-4">
                                        {!! $detail->data_dkg ?? '-' !!}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($detail->files->count() > 0)
                                        <div class="flex flex-col gap-1.5 min-w-[150px]">
                                            @foreach ($detail->files as $file)
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                    class="flex items-center gap-2 bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md px-2 py-1 hover:border-red-400 transition-colors group">
                                                    <span
                                                        class="flex-shrink-0 flex items-center justify-center w-4 h-4 bg-zinc-200 dark:bg-zinc-700 rounded text-[9px] font-bold group-hover:bg-red-100 group-hover:text-red-600">
                                                        {{ $loop->iteration }}
                                                    </span>
                                                    <svg class="w-4 h-4 text-red-400" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                                                    </svg>
                                                    <span
                                                        class="text-[10px] text-zinc-600 dark:text-zinc-400 truncate w-24">
                                                        {{ $file->file_name }}
                                                    </span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-zinc-400 text-[10px] block text-center italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a wire:navigate href="{{ route('details.edit', $detail->uuid) }}"
                                            class="p-2 text-yellow-600 bg-yellow-50 dark:bg-yellow-500/10 rounded-lg border border-yellow-100 dark:border-yellow-500/20 shadow-sm hover:bg-yellow-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button wire:click="confirmDelete('{{ $detail->uuid }}')"
                                            class="p-2 text-red-600 bg-red-50 dark:bg-red-500/10 rounded-lg border border-red-100 dark:border-red-500/20 shadow-sm hover:bg-red-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center">
                                    <svg class="mx-auto w-16 h-16 text-gray-400 dark:text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
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
            {{ $details->links() }}
        </div>
    </div>

    {{-- Modal Delete --}}
    @if ($deleteUuid)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-[10000] p-4">
            <div
                class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 border border-zinc-200 dark:border-zinc-800">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Konfirmasi Hapus</h2>
                <p class="mt-2 text-gray-600 dark:text-zinc-400">Apakah Anda yakin ingin menghapus data ini?</p>
                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('deleteUuid', null)"
                        class="px-4 py-2 text-sm font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">Batal</button>
                    <button wire:click="delete"
                        class="px-4 py-2 text-sm font-semibold bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all shadow-md active:scale-95">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>
