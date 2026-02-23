<div>
    {{-- Toast Notification --}}
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
                <div class="flex-shrink-0">
                    <div
                        class="flex items-center justify-center size-12 rounded-xl bg-gradient-to-tr from-blue-50 to-white dark:from-blue-500/10 dark:to-transparent border border-blue-100 dark:border-blue-500/20 shadow-sm">
                        <flux:icon.document-text variant="outline" class="size-6 text-blue-600 dark:text-blue-400" />
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <flux:heading size="xl" level="1"
                        class="font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
                        {{ __('Keputusan / Peraturan Eselon I (DJPT)') }}
                    </flux:heading>
                    <flux:subheading size="lg"
                        class="hidden sm:block text-slate-500 dark:text-slate-400 font-medium">
                        {{ __('Daftar arsip resmi yang terkelola dalam sistem') }}
                    </flux:subheading>
                </div>
            </div>
            <flux:separator variant="subtle" />
        </div>

        <div class="mt-5">
            {{-- Toolbar: Pencarian & Filter --}}
            <div class="flex flex-col xl:flex-row items-center justify-between gap-4 mb-6 w-full">

                {{-- Sisi Kiri: Search & Dropdowns --}}
                {{-- Menggunakan grid-cols-12 untuk kontrol lebar yang lebih presisi --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 w-full xl:flex-1">

                    {{-- Input Pencarian: Diatur lebih panjang (span 5) --}}
                    <div class="relative w-full md:col-span-5">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-zinc-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg focus:ring-[#00A2E9] block w-full pl-10 p-2.5 outline-none shadow-sm"
                            placeholder="Cari nomor atau tentang...">
                    </div>

                    {{-- Filter Tahun: Diatur lebih pendek (span 2) --}}
                    <div class="md:col-span-2">
                        <select wire:model.live="filterYear"
                            class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg p-2.5 w-full outline-none shadow-sm text-zinc-700 dark:text-zinc-300 cursor-pointer">
                            <option value="">Tahun</option>
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Kategori: (span 3) --}}
                    <div class="md:col-span-3">
                        <select wire:model.live="selectedCategory"
                            class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg p-2.5 w-full outline-none shadow-sm text-zinc-700 dark:text-zinc-300 cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Status: (span 2) --}}
                    <div class="md:col-span-2">
                        <select wire:model.live="filterStatus"
                            class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg p-2.5 w-full outline-none shadow-sm text-zinc-700 dark:text-zinc-300 cursor-pointer">
                            <option value="">Status</option>
                            <option value="Berlaku">Berlaku</option>
                            <option value="Tidak Berlaku">Tidak Berlaku</option>
                        </select>
                    </div>
                </div>

                {{-- Sisi Kanan: Tombol Tambah --}}
                <div class="w-full xl:w-auto">
                    <a wire:navigate href="{{ route('keputusan.create') }}"
                        class="flex items-center justify-center gap-2 text-white bg-[#0576a6] hover:bg-[#0054A3] font-bold rounded-lg text-sm px-5 py-2.5 w-full xl:w-auto shadow-sm active:scale-95 transition-transform whitespace-nowrap">
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
                                <th
                                    class="px-6 py-4 text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap w-32">
                                    Nomor</th>
                                <th
                                    class="px-6 py-4 text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap w-32">
                                    Kategori</th>
                                <th class="px-6 py-4 text-zinc-500 font-bold uppercase text-[10px] tracking-widest">
                                    Tentang</th>
                                <th
                                    class="px-6 py-4 text-center text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap w-40">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-4 text-center text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap w-32">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-center text-zinc-500 font-bold uppercase text-[10px] tracking-widest whitespace-nowrap w-32">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @forelse ($arsips as $sk)
                                <tr class="hover:bg-zinc-50/80 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td
                                        class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100 whitespace-nowrap">
                                        {{ $sk->nomor_surat }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center rounded-md bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 px-2.5 py-1 text-xs font-medium whitespace-nowrap">
                                            {{ $sk->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-zinc-600 dark:text-zinc-400 min-w-[300px] leading-relaxed text-justify">
                                        {{ $sk->tentang }}</td>
                                    <td
                                        class="px-6 py-4 text-center tabular-nums text-zinc-600 dark:text-zinc-400 whitespace-nowrap text-sm">
                                        {{ \Carbon\Carbon::parse($sk->tanggal_penetapan)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button wire:click="toggleStatus('{{ $sk->uuid }}')"
                                            wire:loading.attr="disabled"
                                            class="group relative inline-flex items-center">
                                            <span
                                                class="px-2 py-1 rounded text-xs font-bold transition-all duration-200 whitespace-nowrap 
                                            {{ $sk->keterangan == 'Berlaku' ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                                {{ $sk->keterangan }}
                                            </span>
                                            <div wire:loading wire:target="toggleStatus('{{ $sk->uuid }}')"
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
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button wire:click="checkPasscode('{{ $sk->uuid }}')"
                                                class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors border border-red-100">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                                                </svg>
                                            </button>
                                            <a wire:navigate href="{{ route('keputusan.edit', $sk->uuid) }}"
                                                class="p-2 text-yellow-600 bg-yellow-50 rounded-lg hover:bg-yellow-100 border border-yellow-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button wire:click="confirmDelete('{{ $sk->uuid }}')"
                                                class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 border border-red-100">
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

            <div class="mt-4">
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

    {{-- Modal Passcode --}}
    @if ($passcodeUuid)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[60] p-4">
            <div
                class="bg-white dark:bg-zinc-900 rounded-xl shadow-2xl w-full max-w-md p-6 border border-zinc-200 dark:border-zinc-800">

                {{-- Modal Content Logic --}}
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="p-2 {{ $isResetting ? 'bg-blue-100 text-blue-600' : ($isForgotPasscode ? 'bg-purple-100 text-purple-600' : 'bg-yellow-100 text-yellow-600') }} rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-zinc-100">
                        @if ($isForgotPasscode)
                            Lupa Passcode
                        @elseif($isResetting)
                            Atur Passcode Baru
                        @else
                            Dokumen Terkunci
                        @endif
                    </h2>
                </div>

                @if (!$isResetting && !$isForgotPasscode)
                    <div class="space-y-4">
                        <input type="password" wire:model="inputPasscode" wire:keydown.enter="verifyAndOpen"
                            placeholder="Masukkan passcode"
                            class="w-full px-4 py-3 bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg outline-none focus:ring-yellow-500">
                        <div class="flex justify-between items-center">
                            <span class="text-red-500 text-[13px] font-medium">{{ session('error_passcode') }}</span>
                            <button wire:click="forgotPasscode" class="text-xs text-blue-600 hover:underline">Lupa
                                passcode?</button>
                        </div>
                        <div class="flex justify-end gap-3 pt-2">
                            <flux:button wire:click="$set('passcodeUuid', null)" variant="filled">
                                Batal
                            </flux:button>

                            <flux:button type="submit" wire:click="verifyAndOpen" wire:loading.attr="disabled"
                                variant="primary" class="bg-yellow-600 hover:bg-yellow-700 text-white">
                                Buka Dokumen
                            </flux:button>
                        </div>
                    </div>
                @elseif($isForgotPasscode)
                    <div class="space-y-4">
                        @if (session()->has('success_reset'))
                            <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg text-xs">
                                {{ session('success_reset') }}</div>
                        @endif
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Masukkan email terdaftar untuk menerima
                            link verifikasi.</p>
                        <input type="email" wire:model="emailForReset"
                            class="w-full px-4 py-3 bg-zinc-50 border border-zinc-300 rounded-lg outline-none focus:ring-purple-500"
                            placeholder="alamat@email.com">
                        <div class="flex justify-end gap-3 pt-2">

                            <flux:button wire:click="$set('isForgotPasscode', false)" variant="filled">
                                Batal
                            </flux:button>

                            {{-- Tombol Simpan dengan Spinner Saja --}}
                            <flux:button type="submit" wire:click="sendResetLink" wire:loading.attr="disabled"
                                variant="primary" class="bg-purple-600 hover:bg-purple-700 text-white">
                                Kirim Link
                            </flux:button>
                        </div>
                    </div>
                @elseif($isResetting)
                    <div class="space-y-4">
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Verifikasi berhasil! Silakan atur passcode
                            baru Anda.</p>

                        <input type="text" wire:model="newPasscode"
                            class="w-full px-4 py-3 bg-blue-50 dark:bg-zinc-800 border border-blue-300 dark:border-zinc-700 rounded-lg outline-none focus:ring-blue-500"
                            placeholder="Minimal 4 karakter">

                        {{-- Pembungkus untuk meratakan tombol ke kanan --}}
                        <div class="flex justify-end pt-2">
                            <flux:button type="submit" wire:click="saveNewPasscode" wire:loading.attr="disabled"
                                variant="primary" class="bg-blue-600 hover:bg-blue-700 text-white shadow-sm">
                                Simpan & Buka Dokumen
                            </flux:button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
