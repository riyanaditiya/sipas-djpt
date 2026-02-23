<div class="max-w-4xl mx-auto px-4 sm:px-0 pb-10">
    <flux:heading size="xl" level="1">{{ __('Form Pejabat Berwenang') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        {{ __('Tambahkan data untuk diarsipkan') }}
    </flux:subheading>

    <flux:separator variant="subtle" />

    @php
        $currentCategory = $category_id ? $categories->find($category_id) : null;
        $categoryName = $currentCategory?->name ?? '';

        $isDirjen = Str::contains($categoryName, 'Dirjen');
        $isPPK = Str::contains($categoryName, 'PPK');
        // KPA dan KPB tidak masuk ke $isPPK, jadi tombol tambah tidak muncul
    @endphp

    <section class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mt-6">
        <form wire:submit="save" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:field>
                    <flux:label>Kategori</flux:label>
                    <flux:select wire:model.live="category_id">
                        <flux:select.option value="" selected>-- Pilih Kategori --</flux:select.option>
                        @foreach ($categories as $cat)
                            <flux:select.option value="{{ $cat->id }}">{{ $cat->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="category_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Tanggal Pengangkatan</flux:label>
                    <flux:input type="date" wire:model="tgl_pengangkatan" />
                    <flux:error name="tgl_pengangkatan" />
                </flux:field>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <flux:label>Data Pejabat</flux:label>
                    {{-- Tombol tambah HANYA muncul jika kategori adalah PPK --}}
                    @if ($isPPK)
                        <flux:button size="sm" variant="filled" icon="plus" wire:click="addInput">
                            Tambah Pejabat
                        </flux:button>
                    @endif
                </div>

                @foreach ($inputs as $index => $input)
                    <div class="flex flex-col md:flex-row gap-4 p-4 bg-zinc-50 dark:bg-white/5 rounded-lg border border-zinc-100 dark:border-zinc-800"
                        wire:key="input-field-{{ $index }}">

                        {{-- Input Nama --}}
                        <div class="flex-1">
                            <flux:input wire:model="inputs.{{ $index }}.nama" placeholder="Nama Lengkap" />
                            <flux:error name="inputs.{{ $index }}.nama" />
                        </div>

                        {{-- Input Jabatan --}}
                        <div class="flex-1">
                            @if ($isDirjen)
                                {{-- Dropdown untuk Dirjen --}}
                                <flux:select wire:model="inputs.{{ $index }}.jabatan">
                                    <flux:select.option value="" selected>-- Pilih Jabatan --</flux:select.option>
                                    <flux:select.option value="Definitif">Definitif</flux:select.option>
                                    <flux:select.option value="PLT">PLT</flux:select.option>
                                </flux:select>
                            @else
                                {{-- Input Manual untuk KPA, KPB, PPK --}}
                                <flux:input wire:model="inputs.{{ $index }}.jabatan"
                                    placeholder="Masukan Jabatan" />
                            @endif
                            <flux:error name="inputs.{{ $index }}.jabatan" />
                        </div>

                        {{-- Tombol Hapus Baris (Hanya muncul jika di PPK dan baris > 1) --}}
                        @if ($isPPK && count($inputs) > 1)
                            <div class="flex items-start pt-1">
                                <flux:button variant="ghost" color="red" icon="trash"
                                    wire:click="removeInput({{ $index }})" />
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <hr class="border-zinc-200 dark:border-zinc-800">

            <flux:field>
                <flux:label>
                    <span class="flex items-center gap-2">
                        File Dokumen SK
                        <flux:badge color="red" size="sm" inset="top bottom">*PDF | Max: 2MB</flux:badge>
                    </span>
                </flux:label>
                <div class="max-w-full overflow-hidden">
                    <flux:input type="file" wire:model="dokumen_sk" accept="application/pdf" class="truncate" />
                </div>
                <flux:error name="dokumen_sk" />
            </flux:field>


            <div class="flex justify-end gap-3 pt-4">
                <flux:button href="{{ route('pejabat.index') }}" variant="filled">
                    Kembali
                </flux:button>

                {{-- Tombol Simpan dengan Spinner Saja --}}
                <flux:button type="submit" wire:loading.attr="disabled" wire:target="save, dokumen_sk"
                    variant="primary" class="!bg-[#0576a6] hover:!bg-[#0054A3] text-white">
                    Simpan
                </flux:button>
            </div>
        </form>
    </section>
</div>
