<?php

namespace App\Livewire\DataDukung;

use Livewire\Component;
use App\Models\Category;
use App\Models\DataDukung;

class DataDukungEdit extends Component
{
    // Properti Form
    public $category_id;
    public $data_dkgId; 
    public $produk_hukum;
    public $keterangan;

    // Untuk dropdown kategori di view
    public $categories;

    protected function rules()
    {
        return [
            'category_id'  => 'required|exists:categories,id',
            'produk_hukum' => 'required|string',
            'keterangan'   => 'required|in:Selesai,Belum Selesai',
        ];
    }

    protected function messages()
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak valid.',

            'produk_hukum.required' => 'Produk hukum wajib diisi.',
            'produk_hukum.string'   => 'Produk hukum harus berupa teks.',

            'keterangan.required' => 'Keterangan wajib dipilih.',
            'keterangan.in'       => 'Keterangan harus bernilai Selesai atau Belum Selesai.',
        ];
    }

    public function mount($uuid)
    {
        // 1. Ambil data berdasarkan UUID
        $arsip = DataDukung::where('uuid', $uuid)->firstOrFail();

        // 2. Isi Properti Form
        $this->data_dkgId   = $arsip->id; // ID internal untuk update
        $this->category_id  = $arsip->category_id;
        $this->produk_hukum = $arsip->produk_hukum;
        $this->keterangan   = $arsip->keterangan;

        // 3. Ambil daftar kategori untuk dropdown di view
        $this->categories = Category::where('type', 'data-dukung') 
            ->orderBy('name')
            ->get();
    }

    public function update()
    {
        $this->validate();

        $arsip = DataDukung::findOrFail($this->data_dkgId);

        $arsip->update([
            'category_id'  => $this->category_id,
            'produk_hukum' => $this->produk_hukum,
            'keterangan'   => $this->keterangan,
        ]);

        session()->flash('success', 'Produk Hukum berhasil diperbarui!');
        
        // Pastikan nama route sesuai dengan data-dukung
        return $this->redirectRoute('data-dukung.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.data-dukung.data-dukung-edit');
    }
}