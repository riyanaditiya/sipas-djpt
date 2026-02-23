<?php

namespace App\Livewire\DataDukung;

use Livewire\Component;
use App\Models\Category;
use App\Models\DataDukung;
use Livewire\WithPagination;

class DataDukungIndex extends Component
{
    use WithPagination;

    public $deleteUuid = null;

    // Properti untuk filter pencarian
    public $filterStatus = '';
    public $search = '';
    public $selectedCategory = '';


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }
    
    public function updatingSelectedCategory() 
    { 
        $this->resetPage(); 
    }


    public function toggleStatus($uuid)
    {
        $sk = DataDukung::where('uuid', $uuid)->firstOrFail();
        
        // Logika switch status
        $sk->keterangan = ($sk->keterangan === 'Selesai') 
            ? 'Belum Selesai' 
            : 'Selesai';
            
        $sk->save();
    }

    public function confirmDelete($uuid)
    {
        $this->deleteUuid = $uuid;
    }

    public function delete()
    {
        if ($this->deleteUuid) {
            // Gunakan where('uuid', ...) karena yang disimpan adalah string UUID
            $dataDukung = DataDukung::where('uuid', $this->deleteUuid)->first();

            if ($dataDukung) {
                $dataDukung->delete();
                session()->flash('success', 'Produk Hukum berhasil dihapus!');
            }

            $this->deleteUuid = null; // Reset kembali
        }
    }

    public function render()
    {
        $arsips = DataDukung::with('category')
            ->where(function ($q) {
                $q->where('produk_hukum', 'like', "%{$this->search}%");
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('keterangan', $this->filterStatus);
            })
            ->when($this->selectedCategory, function ($q) {
                $q->where('category_id', $this->selectedCategory);
            })
            ->latest()
            ->paginate(10);

        $categories = Category::where('type', 'data-dukung')->get();

        return view('livewire.data-dukung.data-dukung-index', compact('arsips', 'categories'));
    }
}
