<div class="max-w-4xl mx-auto px-4 sm:px-0 pb-10">
    @push('style')
        <style>
            /* Style khusus untuk Quill Editor agar serasi dengan Flux */
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
        <flux:heading size="xl" level="1" class="text-xl md:text-2xl">{{ __('Tambah Rincian Kegiatan') }}
        </flux:heading>
        <flux:subheading size="lg" class="mb-4 text-sm md:text-base">
            {{ __('Input detail data dukung untuk produk hukum ini') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </header>

    <section
        class="bg-white dark:bg-gray-900 rounded-lg shadow-sm p-4 md:p-6 mt-6 border border-zinc-200 dark:border-white/10">
        <form wire:submit.prevent="save" class="space-y-6">

            {{-- Info Produk (Read Only) --}}
            <div class="p-4 rounded-xl bg-zinc-50 dark:bg-white/5 border border-zinc-200 dark:border-white/10">
                <flux:label class="uppercase tracking-wider text-[10px] font-bold text-zinc-500">Produk Hukum
                </flux:label>
                <div class="mt-1 text-sm font-bold text-zinc-800 dark:text-zinc-200 italic leading-relaxed">
                    {{ $this->dataDukung->produk_hukum ?? 'Data tidak ditemukan' }}
                </div>
            </div>

            {{-- Grid Responsif: 1 kolom di HP, 2 kolom di Desktop --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <flux:input label="Tanggal Kegiatan" type="date" wire:model="tanggal" class="w-full" />

                <flux:input label="Nama Kegiatan" wire:model="kegiatan" placeholder="Masukkan nama kegiatan"
                    class="w-full" />
            </div>

            {{-- Data Dukung --}}
            <flux:field>
                <flux:label badge="Optional">Data Dukung</flux:label>
                <div wire:ignore class="mt-2">
                    <div x-data="{
                        content: @entangle('data_dkg'),
                        initQuill() {
                            const quill = new Quill($refs.editor, { theme: 'snow', placeholder: 'Masukkan narasi data dukung...' });
                            if (this.content) quill.root.innerHTML = this.content;
                            quill.on('text-change', () => { this.content = quill.root.innerHTML; });
                            this.$watch('content', (value) => { if (value !== quill.root.innerHTML) quill.root.innerHTML = value || ''; });
                        }
                    }" x-init="initQuill()">
                        <div x-ref="editor" class="h-40 md:h-48"></div>
                    </div>
                </div>
                <flux:error name="data_dkg" />
            </flux:field>

            {{-- Upload File Section --}}
            <div
                class="p-4 md:p-6 bg-zinc-50 dark:bg-white/5 rounded-2xl border border-zinc-200 dark:border-white/10 space-y-6">
                {{-- Header Lampiran Responsif --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex-1">
                        <flux:heading size="sm">Lampiran Dokumen</flux:heading>
                        <flux:subheading size="xs">Tambahkan file data dukung</flux:subheading>
                    </div>
                    <div
                        class="flex items-center gap-3 bg-white dark:bg-zinc-800 p-2 rounded-lg border border-zinc-200 dark:border-white/10 sm:border-none sm:bg-transparent">
                        <flux:label class="whitespace-nowrap text-xs font-medium">Jumlah Dokumen:</flux:label>
                        <flux:input type="number" wire:model.live="jumlah_file" min="1" size="sm"
                            class="!w-16" />
                    </div>
                </div>

                <flux:separator variant="subtle" />

                <div class="space-y-4">
                    @foreach ($file_inputs as $index => $input)
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl shadow-sm relative overflow-hidden">
                            <flux:input label="Nama Dokumen {{ $index + 1 }}"
                                wire:model="file_inputs.{{ $index }}.name" placeholder="Contoh: Nota Dinas" />

                            <flux:field>
                                <div class="flex items-center justify-between">
                                    <flux:label>
                                        <span class="flex items-center gap-2">
                                            Upload File
                                            <flux:badge color="red" size="sm" inset="top bottom">*PDF | Max: 2MB
                                            </flux:badge>
                                        </span>
                                    </flux:label>
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

            {{-- Action Buttons Responsif: Stack di HP, Row di Desktop --}}
            <div class="flex justify-end gap-3 pt-4">
                <flux:button wire:navigate href="{{ route('details.index', $uuid) }}" variant="filled">
                    Batal
                </flux:button>

                {{-- Tombol Simpan dengan Spinner Saja --}}
                <flux:button type="submit" wire:loading.attr="disabled" wire:target="save" variant="primary"
                    class="!bg-[#0576a6] hover:!bg-[#0054A3] text-white">
                    Simpan
                </flux:button>
            </div>
        </form>
    </section>
</div>
