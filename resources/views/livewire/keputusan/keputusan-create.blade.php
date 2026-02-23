<div class="max-w-4xl mx-auto px-4 sm:px-0 pb-10">
    <flux:heading size="xl" level="1">{{ __('Form Keputusan / Peraturan Eselon I DJPT') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        {{ __('Tambahkan data untuk diarsipkan') }}
    </flux:subheading>

    <flux:separator variant="subtle" />

    <section class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mt-6">
        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Category --}}
            <flux:select label="Kategori" wire:model="category_id">
                <flux:select.option value="" selected>-- Pilih Keterangan --</flux:select.option>
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
                    <flux:select.option value="" selected>-- Pilih Status --</flux:select.option>
                    <flux:select.option value="Berlaku">Berlaku</flux:select.option>
                    <flux:select.option value="Tidak Berlaku">Tidak Berlaku</flux:select.option>
                </flux:select>
            </div>

            {{-- Upload File --}}
            <flux:field>
                <flux:label>
                    <span class="flex items-center gap-2">
                        File Dokumen
                        <flux:badge color="red" size="sm" inset="top bottom">*PDF | Max: 2MB</flux:badge>
                    </span>
                </flux:label>
                <div class="max-w-full overflow-hidden">
                    <flux:input type="file" wire:model="file_sk" accept="application/pdf" class="truncate" />
                </div>
                <flux:error name="file_sk" />
            </flux:field>

            {{-- Passcode --}}
            <div
                class="p-4 rounded-xl border border-dashed border-zinc-300 dark:border-white/20 bg-zinc-50 dark:bg-white/5">
                <div class="space-y-3">
                    <flux:input label="Keamanan Dokumen" badge="Optional" wire:model="passcode"
                        placeholder="Masukkan passcode jika dokumen ini rahasia">
                        <x-slot name="icon">
                            <svg class="w-4 h-4 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </x-slot>
                    </flux:input>
                    <flux:description>
                        *Kosongkan jika dokumen boleh dibuka oleh siapa saja tanpa kode.
                    </flux:description>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end gap-3 pt-4">
                <flux:button wire:navigate href="{{ route('keputusan.index') }}" variant="filled">
                    Batal
                </flux:button>

                {{-- Tombol Simpan dengan Spinner Saja --}}
                <flux:button type="submit" wire:loading.attr="disabled" wire:target="save, file_sk" variant="primary"
                    class="!bg-[#0576a6] hover:!bg-[#0054A3] text-white">
                    Simpan
                </flux:button>
            </div>
        </form>
    </section>
</div>
