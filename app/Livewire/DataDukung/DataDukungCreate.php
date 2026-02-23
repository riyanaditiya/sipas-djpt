<?php

namespace App\Livewire\DataDukung;

use Livewire\Component;
use App\Models\Category;
use App\Models\DataDukung;

class DataDukungCreate extends Component
{
    public $category_id;
    public $produk_hukum;
    public $keterangan;

    protected $rules = [
        'category_id'       => 'required|exists:categories,id',
        'produk_hukum'       => 'required|string',
        'keterangan'        => 'required|in:Selesai,Belum Selesai',
    ];

    protected $messages = [
        'category_id.required' => 'Kategori wajib dipilih.',
        'category_id.exists'   => 'Kategori yang dipilih tidak valid.',

        'produk_hukum.required' => 'Produk hukum wajib diisi.',
        'produk_hukum.string'   => 'Produk hukum harus berupa teks.',

        'keterangan.required' => 'Keterangan wajib dipilih.',
        'keterangan.in'       => 'Keterangan harus bernilai Selesai atau Belum Selesai.',
    ];

    public function save()
    {
        $this->validate();

        DataDukung::create([
            'category_id' => $this->category_id,
            'produk_hukum' => $this->produk_hukum,
            'keterangan' => $this->keterangan,
          
        ]);

        
        $this->reset(['produk_hukum', 'keterangan']);

        session()->flash('success', 'Berhasil Menambahkan Produk Hukum!');

        // Redirect ke route index atau tetap di sini
        return $this->redirectRoute('data-dukung.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.data-dukung.data-dukung-create', [
            'categories' => Category::where('type', 'data-dukung')->get()
        ]);
    }
}
