<div class="max-w-4xl mx-auto px-4 sm:px-0 pb-10">
    @push('style')
        <style>
            .ql-toolbar.ql-snow {
                border-top-left-radius: 0.5rem;
                border-top-right-radius: 0.5rem;
                border-color: #e4e4e7;
                background: #f9fafb;
            }

            .ql-container.ql-snow {
                border-bottom-left-radius: 0.5rem;
                border-bottom-right-radius: 0.5rem;
                border-color: #e4e4e7;
                min-height: 150px;
            }

            .dark .ql-toolbar.ql-snow {
                background: rgba(255, 255, 255, 0.05);
                border-color: rgba(255, 255, 255, 0.1);
            }

            .dark .ql-container.ql-snow {
                border-color: rgba(255, 255, 255, 0.1);
                color: white;
            }
        </style>
    @endpush

    {{-- Header Section --}}
    <header class="mb-6">
        <flux:heading size="xl" level="1">{{ __('Edit Rincian Kegiatan') }}</flux:heading>
        <flux:subheading size="lg" class="mb-4">
            {{ __('Perbarui data progres dan dokumen pendukung') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </header>

    <section
        class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm p-4 md:p-6 mt-6 border border-zinc-200 dark:border-white/10">
        <form wire:submit.prevent="update" class="space-y-6">

            {{-- Info Produk (Read Only) --}}
            <div class="p-4 rounded-xl bg-zinc-50 dark:bg-white/5 border border-zinc-200 dark:border-white/10">
                <flux:label class="uppercase tracking-wider text-[10px] font-bold text-zinc-500">Produk Hukum
                </flux:label>
                <div class="mt-1 text-sm font-bold text-zinc-800 dark:text-zinc-200 italic">
                    {{ $this->dataDukung->produk_hukum }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <flux:input label="Tanggal Kegiatan" type="date" wire:model="tanggal" />
                <flux:input label="Nama Kegiatan" wire:model="kegiatan" />
            </div>

            {{-- Rich Text Editor --}}
            <flux:field>
                <flux:label>Data Dukung (Detail)</flux:label>
                <div wire:ignore class="mt-2">
                    <div x-data="{
                        content: @entangle('data_dkg'),
                        initQuill() {
                            const quill = new Quill($refs.editor, { theme: 'snow' });
                            if (this.content) quill.root.innerHTML = this.content;
                            quill.on('text-change', () => { this.content = quill.root.innerHTML; });
                            this.$watch('content', (value) => { if (value !== quill.root.innerHTML) quill.root.innerHTML = value || ''; });
                        }
                    }" x-init="initQuill()">
                        <div x-ref="editor" class="h-40 md:h-48"></div>
                    </div>
                </div>
            </flux:field>

            {{-- BAGIAN 1: FILE TERSEDIA --}}
            @if (count($existingFiles) > 0)
                <div
                    class="p-4 md:p-6 bg-zinc-50 dark:bg-white/5 rounded-2xl border border-zinc-200 dark:border-white/10 space-y-6">
                    <header>
                        <flux:heading size="sm">File Tersimpan</flux:heading>
                        <flux:subheading size="xs italic">Ubah nama atau ganti file PDF yang sudah ada</flux:subheading>
                    </header>

                    <div class="space-y-4">
                        @foreach ($existingFiles as $index => $file)
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl shadow-sm relative overflow-hidden transition-all">

                                {{-- Input Nama Dokumen --}}
                                <flux:input label="Nama Dokumen {{ $index + 1 }}"
                                    wire:model="existingFiles.{{ $index }}.file_name" />

                                <flux:field>
                                    {{-- Baris Label: Ganti File + Badge & Tombol Hapus --}}
                                    <div class="flex items-center justify-between mb-1">
                                        <flux:label>
                                            <span class="flex items-center gap-2">
                                                Ganti File
                                                <flux:badge color="red" size="sm" inset="top bottom">*PDF | Max:
                                                    2MB
                                                </flux:badge>
                                            </span>
                                        </flux:label>

                                        <button type="button" wire:click="confirmFileDeletion({{ $file['id'] }})"
                                            class="group flex items-center gap-1 text-zinc-400 hover:text-red-500 transition-colors">
                                            <span
                                                class="text-[9px] font-bold uppercase opacity-0 group-hover:opacity-100 transition-opacity">Hapus</span>
                                            <flux:icon name="trash" variant="mini" class="w-4 h-4" />
                                        </button>
                                    </div>

                                    {{-- Input File dengan Proteksi Teks Panjang --}}
                                    <flux:input type="file" wire:model="existingFiles.{{ $index }}.new_file"
                                        accept="application/pdf"
                                        class="overflow-hidden whitespace-nowrap text-ellipsis max-w-full text-xs md:text-sm" />

                                    {{-- Status Bar & Spinner (Dibawah Input) --}}
                                    <div class="mt-2 flex items-center gap-2 min-w-0 h-4">
                                        {{-- Spinner Loading --}}
                                        <div wire:loading wire:target="existingFiles.{{ $index }}.new_file">
                                            <svg class="animate-spin h-3.5 w-3.5 text-yellow-600" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </div>

                                        {{-- Teks Status --}}
                                        <div wire:loading.remove
                                            wire:target="existingFiles.{{ $index }}.new_file" class="min-w-0">
                                            @if (isset($existingFiles[$index]['new_file']) && !is_string($existingFiles[$index]['new_file']))
                                                <div class="flex items-center gap-1.5 text-blue-600 dark:text-blue-400">
                                                    <flux:icon name="check-circle" variant="mini"
                                                        class="w-3.5 h-3.5 flex-shrink-0" />
                                                    <span class="text-[10px] font-medium truncate italic"
                                                        title="{{ $existingFiles[$index]['new_file']->getClientOriginalName() }}">
                                                        Baru:
                                                        {{ $existingFiles[$index]['new_file']->getClientOriginalName() }}
                                                    </span>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-1 text-zinc-400/60">
                                                    <flux:icon name="document-text" variant="mini"
                                                        class="w-3.5 h-3.5 flex-shrink-0" />
                                                    <span class="text-[10px] font-medium italic">Status:
                                                        Tersimpan</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <flux:error name="existingFiles.{{ $index }}.new_file" />
                                </flux:field>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- BAGIAN 2: TAMBAH FILE BARU --}}
            <div
                class="p-4 md:p-6 bg-zinc-50 dark:bg-white/5 rounded-2xl border border-zinc-200 dark:border-white/10 space-y-6">
                {{-- Header & Input Jumlah Tetap Dipertahankan --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex-1">
                        <flux:heading size="sm">Tambah Lampiran Baru
                            <flux:badge color="gray" size="sm" inset="top bottom">Optional
                            </flux:badge>
                        </flux:heading>
                        <flux:subheading size="xs italic">Tentukan jumlah baris file tambahan</flux:subheading>
                    </div>
                    <div class="flex items-center gap-2">
                        <flux:label class="text-xs">Jumlah:</flux:label>
                        <flux:input type="number" wire:model.live="jumlah_file" min="1" size="sm"
                            class="!w-16" />
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach ($file_inputs as $index => $input)
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl shadow-sm relative overflow-hidden">

                            {{-- Input Nama Dokumen --}}
                            <flux:input label="Nama Dokumen {{ $index + 1 }}"
                                wire:model="file_inputs.{{ $index }}.name" placeholder="Contoh: Nota Dinas" />

                            <flux:field>
                                <div class="flex items-center justify-between mb-1">
                                    <flux:label>
                                        <span class="flex items-center gap-2">
                                            Upload File
                                            <flux:badge color="red" size="sm" inset="top bottom">*PDF | Max: 2MB
                                            </flux:badge>
                                        </span>
                                    </flux:label>

                                    {{-- Spinner Loading di Samping Label --}}
                                    <div wire:loading wire:target="file_inputs.{{ $index }}.file"
                                        class="flex items-center">
                                        <svg class="animate-spin h-4 w-4 text-yellow-600"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Input File dengan CSS Truncate --}}
                                <flux:input type="file" wire:model="file_inputs.{{ $index }}.file"
                                    accept="application/pdf"
                                    class="overflow-hidden whitespace-nowrap text-ellipsis max-w-full text-xs md:text-sm" />

                                <flux:error name="file_inputs.{{ $index }}.file" />
                                <flux:error name="file_inputs.{{ $index }}.name" />
                            </flux:field>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="flex justify-end gap-3 pt-4">
                <flux:button wire:navigate href="{{ route('details.index', $dataDukungUuid) }}" variant="filled">
                    Batal
                </flux:button>

                {{-- Tombol Simpan dengan Spinner Saja --}}
                <flux:button type="submit" wire:loading.attr="disabled" wire:target="update" variant="primary"
                    class="!bg-[#0576a6] hover:!bg-[#0054A3] text-white">
                    Simpan
                </flux:button>
            </div>
        </form>
    </section>

    {{-- MODAL KONFIRMASI HAPUS VERSI SEBELUMNYA --}}
    @if ($confirmingFileDeletion)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
            <div
                class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 border border-zinc-200 dark:border-zinc-800">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Konfirmasi Hapus</h2>
                <p class="mt-2 text-gray-600 dark:text-zinc-400 text-sm">
                    Apakah Anda yakin ingin menghapus dokumen ini secara permanen?
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('confirmingFileDeletion', false)"
                        class="px-4 py-2 bg-gray-200 dark:bg-zinc-800 text-gray-700 dark:text-zinc-300 rounded-lg hover:bg-gray-300 dark:hover:bg-zinc-700 transition-all text-sm font-medium">
                        Batal
                    </button>
                    <button wire:click="deleteExistingFile"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all text-sm font-medium">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
