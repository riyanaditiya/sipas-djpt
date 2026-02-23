<?php

namespace App\Livewire\Pejabat;

use App\Models\Pejabat;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class PejabatIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $deleteUuid = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    { 
        $this->resetPage(); 
    }

    public function confirmDelete($uuid)
    {
        $this->deleteUuid = $uuid;
    }

    public function delete()
    {
        if ($this->deleteUuid) {
            $pejabat = Pejabat::where('uuid', $this->deleteUuid)->first();
            if ($pejabat) {
                if ($pejabat->dokumen_sk && Storage::disk('public')->exists($pejabat->dokumen_sk)) {
                    Storage::disk('public')->delete($pejabat->dokumen_sk);
                }
                $pejabat->delete();
                session()->flash('success', 'Data pejabat berhasil dihapus!');
            }
            $this->deleteUuid = null;
        }
    }

    public function render()
    {
        $pejabats = Pejabat::with('category')
            ->latest('tgl_pengangkatan')
            ->where(function($q) {
                $q->where('nama', 'like', "%{$this->search}%")
                ->orWhere('jabatan', 'like', "%{$this->search}%");
            })
            ->when($this->selectedCategory, function($q) {
                $q->where('category_id', $this->selectedCategory);
            })
            ->paginate(10);

        $categories = Category::where('type', 'pejabat')->get();

        return view('livewire.pejabat.pejabat-index', compact('pejabats', 'categories'));
    }
}