<?php

namespace App\Livewire\DataDukungDetail;

use Livewire\Component;
use App\Models\DataDukung;
use Livewire\WithPagination;
use App\Models\DataDukungDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DataDukungDetailIndex extends Component
{
    use WithPagination;

    // Properti State
    public $dataDukungUuid;
    public $deleteUuid = null;
    public $search = '';
    
    // Properti Data
    public $category;
    public $dataDukung;

    public function mount($uuid)
    {
        $this->dataDukungUuid = $uuid;
        
        // Ambil DataDukung dengan relasi kategorinya
        $this->dataDukung = DataDukung::with('category')
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Set category dari relasi (untuk judul di header)
        $this->category = $this->dataDukung->category;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus()
    {
        $this->dataDukung->keterangan = ($this->dataDukung->keterangan === 'Selesai') 
            ? 'Belum Selesai' 
            : 'Selesai';
        $this->dataDukung->save();
        
        session()->flash('success', 'Status produk hukum berhasil diperbarui!');
    }

    public function confirmDelete($uuid)
    {
        $this->deleteUuid = $uuid;
    }

    public function delete()
    {
        if ($this->deleteUuid) {
            // Ambil detail beserta relasi filenya agar efisien
            $detail = DataDukungDetail::with('files')->where('uuid', $this->deleteUuid)->first();
            
            if ($detail) {
                DB::transaction(function () use ($detail) {
                    // 1. Loop semua file yang terkait di tabel DataDukungFile
                    foreach ($detail->files as $file) {
                        // Cek apakah file_path ada dan file fisiknya eksis di storage
                        if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
                            Storage::disk('public')->delete($file->file_path);
                        }
                        
                        // Hapus baris data di tabel data_dukung_files
                        $file->delete();
                    }

                    // 2. Hapus data utama di tabel data_dukung_details
                    $detail->delete();
                });

                session()->flash('success', 'Detail kegiatan dan semua lampiran berhasil dihapus!');
            }
            
            $this->deleteUuid = null;
        }
    }

    public function render()
    {
        // Tambahkan eager loading 'files'
        $query = DataDukungDetail::with('files')
            ->where('data_dukung_id', $this->dataDukung->id);

        if ($this->search) {
            $query->where('kegiatan', 'like', '%' . $this->search . '%');
        }

        return view('livewire.data-dukung-detail.data-dukung-detail-index', [
            'details' => $query->latest('tanggal')->paginate(10),
        ]);
    }
}