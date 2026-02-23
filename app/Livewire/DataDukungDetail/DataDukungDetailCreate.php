<?php

namespace App\Livewire\DataDukungDetail;

use Livewire\Component;
use App\Models\DataDukung;
use App\Models\DataDukungDetail;
use App\Models\DataDukungFile;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class DataDukungDetailCreate extends Component
{
    use WithFileUploads;

    public $uuid; 
    public $tanggal; 
    public $kegiatan;
    public $data_dkg;
    
    // Properti input dinamis
    public $jumlah_file = 1;
    public $file_inputs = []; 

    public function mount($uuid)
    {
        $this->uuid = $uuid;
                
        // Inisialisasi baris pertama
        $this->generateInputs();
    }

    /**
     * Computed Property untuk mengambil data produk hukum
     * Mempercepat render dan lebih bersih daripada memanggil di render()
     */
    #[Computed]
    public function dataDukung()
    {
        return DataDukung::where('uuid', $this->uuid)->firstOrFail();
    }

    /**
     * Mengatur jumlah baris input sesuai dengan $jumlah_file
     */
    public function updatedJumlahFile()
    {
        $this->resetValidation('file_inputs');
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

    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $mainData = $this->dataDukung();

                // 1. Simpan Data Detail Utama
                $detail = DataDukungDetail::create([
                    'data_dukung_id' => $mainData->id,
                    'tanggal'        => $this->tanggal,
                    'kegiatan'       => $this->kegiatan,
                    'data_dkg'       => $this->data_dkg,
                ]);

                // 2. Simpan File (Hanya jika file dipilih)
                foreach ($this->file_inputs as $item) {
                    if (isset($item['file']) && $item['file'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                        
                        $path = $item['file']->store('data_dukung', 'public');
                        
                        // Gunakan nama manual, jika kosong gunakan nama asli file
                        $finalName = !empty($item['name']) 
                                     ? $item['name'] 
                                     : $item['file']->getClientOriginalName();

                        DataDukungFile::create([
                            'data_dukung_detail_id' => $detail->id,
                            'file_name'             => $finalName,
                            'file_path'             => $path,
                        ]);
                    }
                }
            });

            session()->flash('success', 'Rincian kegiatan berhasil disimpan!');
            return $this->redirectRoute('details.index', ['uuid' => $this->uuid], navigate: true);

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function render()
    {
        return view('livewire.data-dukung-detail.data-dukung-detail-create');
    }
}