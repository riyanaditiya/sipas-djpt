<?php

namespace App\Livewire\DataDukungDetail;

use Livewire\Component;
use App\Models\DataDukung;
use App\Models\DataDukungDetail;
use App\Models\DataDukungFile;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;

class DataDukungDetailEdit extends Component
{
    use WithFileUploads;

    public $detailUuid; 
    public $dataDukungUuid; 
    
    // Properti Form
    public $tanggal; 
    public $kegiatan;
    public $data_dkg;
    
    // Untuk File Eksisting & Baru
    public $existingFiles = [];
    public $jumlah_file = 1;
    public $file_inputs = [];
    
    public $confirmingFileDeletion = false;
    public $fileIdBeingDeleted;

    protected function rules()
    {
        return [
            'tanggal'            => 'required|date',
            'kegiatan'           => 'required|string|min:3|max:255',
            'data_dkg'           => 'nullable|string',
            'file_inputs.*.name' => 'nullable|string|max:255',
            'file_inputs.*.file' => 'nullable|file|mimes:pdf|max:2048',
        ];
    }

    protected $messages = [
        'file_inputs.*.file.mimes' => 'File harus berformat PDF.',
        'file_inputs.*.file.max'   => 'Ukuran file maksimal adalah 2MB.',
    ];

    public function mount($uuid)
    {
        $detail = DataDukungDetail::with('files', 'dataDukung')
            ->where('uuid', $uuid)
            ->firstOrFail();

        $this->detailUuid = $detail->uuid;
        $this->dataDukungUuid = $detail->dataDukung->uuid;
        $this->tanggal = $detail->tanggal;
        $this->kegiatan = $detail->kegiatan;
        $this->data_dkg = $detail->data_dkg;
        
        // Modifikasi array agar bisa menampung file baru per item
        $this->existingFiles = $detail->files->map(function ($file) {
            return [
                'id' => $file->id,
                'file_name' => $file->file_name,
                'file_path' => $file->file_path,
                'new_file' => null, // Tempat menyimpan file pengganti
            ];
        })->toArray();
        
        $this->generateInputs();
    }


    #[Computed]
    public function dataDukung()
    {
        return DataDukung::where('uuid', $this->dataDukungUuid)->firstOrFail();
    }

    public function updatedJumlahFile()
    {
        $this->generateInputs();
    }

    private function generateInputs()
    {
        $targetCount = max(1, (int)$this->jumlah_file);
        $currentCount = count($this->file_inputs);

        if ($targetCount > $currentCount) {
            for ($i = $currentCount; $i < $targetCount; $i++) {
                $this->file_inputs[] = ['name' => '', 'file' => null];
            }
        } elseif ($targetCount < $currentCount) {
            array_splice($this->file_inputs, $targetCount);
        }
    }

    public function confirmFileDeletion($id)
    {
        $this->fileIdBeingDeleted = $id;
        $this->confirmingFileDeletion = true;
    }

    public function deleteExistingFile()
    {
        $file = DataDukungFile::find($this->fileIdBeingDeleted);
        
        if ($file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
            
            // Refresh array existingFiles
            $this->existingFiles = array_filter($this->existingFiles, function($f) {
                return $f['id'] !== $this->fileIdBeingDeleted;
            });
        }

        $this->confirmingFileDeletion = false;
        $this->fileIdBeingDeleted = null;
        
        session()->flash('success', 'File berhasil dihapus.');
    }

    public function update()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $detail = DataDukungDetail::where('uuid', $this->detailUuid)->firstOrFail();

                $detail->update([
                    'tanggal'  => $this->tanggal,
                    'kegiatan' => $this->kegiatan,
                    'data_dkg' => $this->data_dkg,
                ]);

                // 1. UPDATE FILE LAMA (Nama atau Dokumennya)
                foreach ($this->existingFiles as $index => $item) {
                    $fileRecord = DataDukungFile::find($item['id']);
                    
                    $dataToUpdate = [
                        'file_name' => $item['file_name']
                    ];

                    // Jika user mengunggah file baru untuk mengganti file ini
                    if (isset($item['new_file']) && $item['new_file'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                        // Hapus file lama dari storage
                        Storage::disk('public')->delete($fileRecord->file_path);
                        
                        // Simpan file baru
                        $path = $item['new_file']->store('data_dukung', 'public');
                        $dataToUpdate['file_path'] = $path;
                    }

                    $fileRecord->update($dataToUpdate);
                }

                // 2. Simpan File Tambahan Baru (logika tetap sama)
                foreach ($this->file_inputs as $item) {
                    if (isset($item['file']) && $item['file'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                        $path = $item['file']->store('data_dukung', 'public');
                        $finalName = !empty($item['name']) ? $item['name'] : $item['file']->getClientOriginalName();

                        DataDukungFile::create([
                            'data_dukung_detail_id' => $detail->id,
                            'file_name'             => $finalName,
                            'file_path'             => $path,
                        ]);
                    }
                }
            });

            session()->flash('success', 'Data dan dokumen berhasil diperbarui!');
            return $this->redirectRoute('details.index', ['uuid' => $this->dataDukungUuid], navigate: true);

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.data-dukung-detail.data-dukung-detail-edit');
    }
}