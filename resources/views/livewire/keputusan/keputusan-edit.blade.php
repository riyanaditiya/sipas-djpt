<div class="max-w-4xl mx-auto px-4 sm:px-0 pb-10">
    <flux:heading size="xl" level="1">{{ __('Edit Keputusan / Peraturan Eselon I DJPT') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        {{ __('Edit data untuk diarsipkan') }}
    </flux:subheading>

    <flux:separator variant="subtle" />

    <section class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mt-6">
        <form wire:submit.prevent="update" class="space-y-6">
            {{-- Category --}}
            <flux:select label="Kategori" wire:model="category_id">
                <flux:select.option value="">-- Pilih Kategori --</flux:select.option>
                @foreach ($categories as $category)
                    <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                @endforeach
            </flux:select>

            {{-- Nomor Surat --}}
            <flux:input label="Nomor" wire:model="nomor_surat" placeholder="Masukkan nomor surat" />

            {{-- Tentang --}}
            <flux:textarea label="Tentang" wire:model="tentang" rows="4"
                placeholder="Masukan judul atau perihal surat" />

            {{-- Tanggal Penetapan dan Keterangan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input type="date" label="Tanggal Penetapan" wire:model="tanggal_penetapan" />

                <flux:select label="Status" wire:model="keterangan">
                    <flux:select.option value="">-- Pilih Status --</flux:select.option>
                    <flux:select.option value="Berlaku">Berlaku</flux:select.option>
                    <flux:select.option value="Tidak Berlaku">Tidak Berlaku</flux:select.option>
                </flux:select>
            </div>

            {{-- File Upload Section (Modern Style) --}}
            <flux:field>
                <flux:label>
                    <span class="flex items-center gap-2">
                        File Dokumen
                        <flux:badge color="red" size="sm" inset="top bottom">*PDF | Max: 2MB</flux:badge>
                    </span>
                </flux:label>

                <div class="space-y-3 overflow-hidden">
                    {{-- Area Informasi File yang Sudah Ada --}}
                    @if ($existing_file_sk)
                        <div
                            class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-white/5 border border-zinc-200 dark:border-white/10 rounded-lg">
                            <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg">
                                <svg class="w-5 h-5 text-red-500 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">File saat ini:</p>
                                <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200 truncate">
                                    {{ $file_name }}
                                </p>
                            </div>
                            <flux:button variant="ghost" size="sm"
                                href="{{ asset('storage/' . $existing_file_sk) }}" target="_blank">
                                Lihat
                            </flux:button>
                        </div>
                    @endif

                    {{-- Input File Utama Flux --}}
                    <div class="relative">
                        <flux:input type="file" wire:model="file_sk" accept="application/pdf" />
                    </div>
                </div>

                <flux:description>
                    *Kosongkan jika tidak ingin mengganti.
                </flux:description>

                <flux:error name="file_sk" />
            </flux:field>

            {{-- Passcode Section --}}
            <div
                class="p-4 rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900/50">
                @if (!($hasExistingPasscode ?? false))
                    <flux:input label="Tambah Keamanan Dokumen (Opsional)" wire:model="passcode"
                        placeholder="Masukkan passcode baru jika ingin mengunci...">
                        <x-slot name="icon">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </x-slot>
                    </flux:input>
                @else
                    <div class="flex items-center gap-3 text-green-600 dark:text-green-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">Dokumen ini sudah dilindungi passcode.</span>
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end gap-3 pt-4">
                <flux:button wire:navigate href="{{ route('keputusan.index') }}" variant="filled">
                    Batal
                </flux:button>

                {{-- Tombol Simpan dengan Spinner Saja --}}
                <flux:button type="submit" wire:loading.attr="disabled" wire:target="update, file_sk" variant="primary"
                    class="!bg-[#0576a6] hover:!bg-[#0054A3] text-white">
                    Simpan
                </flux:button>
            </div>
        </form>
    </section>
</div>
