<div class="max-w-4xl mx-auto px-4 sm:px-0 pb-10">
    <flux:heading size="xl" level="1">{{ __('Form Data Dukung Penyusunan Produk Hukum') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        {{ __('Tambahkan data untuk diarsipkan') }}
    </flux:subheading>

    <flux:separator variant="subtle" />

    <section class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mt-6">
        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Kategori --}}
            <flux:select label="Kategori" wire:model="category_id">
                <flux:select.option value="" selected>-- Pilih Keterangan --</flux:select.option>
                @foreach ($categories as $category)
                    <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                @endforeach
            </flux:select>

            {{-- Produk Hukum --}}
            <flux:input label="Produk Hukum" wire:model="produk_hukum" placeholder="Masukkan Nama Produk Hukum" />

            {{-- Keterangan --}}
            <flux:select label="Keterangan" wire:model="keterangan">
                <flux:select.option value="" selected>-- Pilih Keterangan --</flux:select.option>
                <flux:select.option value="Selesai">Selesai</flux:select.option>
                <flux:select.option value="Belum Selesai">Belum Selesai</flux:select.option>
            </flux:select>

            {{-- Action Buttons --}}
            <div class="flex justify-end gap-3 pt-4">
                <flux:button wire:navigate href="{{ route('data-dukung.index') }}" variant="filled">
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
