<?php

namespace App\Livewire\Keputusan;

use Livewire\Component;
use App\Models\Category;
use App\Models\Keputusan;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class KeputusanEdit extends Component
{
    use WithFileUploads;

    public $skId; 
    public $category_id;
    public $nomor_surat;
    public $tentang;
    public $tanggal_penetapan;
    public $keterangan;
    public $passcode;
    public $hasExistingPasscode = false;

    // Properti File
    public $file_sk;            
    public $existing_file_sk;   
    public $file_name;          

    public $categories;

    protected function rules()
    {
        return [
            'category_id'       => 'required|exists:categories,id',
            'nomor_surat'       => 'required|max:100|unique:keputusans,nomor_surat,' . $this->skId,
            'tentang'           => 'required|string',
            'tanggal_penetapan' => 'required|date',
            'keterangan'        => 'required|in:Berlaku,Tidak Berlaku',
            'file_sk'           => 'nullable|file|mimes:pdf|max:2048', 
            'passcode'          => 'nullable|min:4',
        ];
    }

    protected $messages = [
        'category_id.required' => 'Kategori wajib dipilih.',
        'category_id.exists'   => 'Kategori yang dipilih tidak valid.',

        'nomor_surat.required' => 'Nomor surat wajib diisi.',
        'nomor_surat.max'      => 'Nomor surat maksimal 100 karakter.',
        'nomor_surat.unique'   => 'Nomor surat sudah terdaftar.',

        'tentang.required'     => 'Judul atau perihal surat wajib diisi.',
        'tentang.string'       => 'Judul atau perihal surat harus berupa teks.',

        'tanggal_penetapan.required' => 'Tanggal penetapan wajib diisi.',
        'tanggal_penetapan.date' => 'Format tanggal penetapan tidak valid.',

        'keterangan.required' => 'Keterangan status wajib dipilih.',
        'keterangan.in' => 'Keterangan harus bernilai Berlaku atau Tidak Berlaku.',

        'file_sk.required' => 'File dokumen wajib diunggah.',
        'file_sk.mimes'    => 'Format file harus PDF, DOC, atau DOCX.',
        'file_sk.max'      => 'Ukuran file maksimal adalah 2MB.',

        'passcode.min' => 'Passcode minimal 4 karakter.',
    ];

    public function mount($uuid)
    {
        $arsip = Keputusan::where('uuid', $uuid)->firstOrFail();

        $this->skId              = $arsip->id; 
        $this->category_id       = $arsip->category_id;
        $this->nomor_surat       = $arsip->nomor_surat;
        $this->tentang           = $arsip->tentang;
        $this->tanggal_penetapan = $arsip->tanggal_penetapan;
        $this->keterangan        = $arsip->keterangan;
        
        $this->existing_file_sk  = $arsip->file_path;
        $this->file_name         = $arsip->file_name; 
        $this->hasExistingPasscode = !empty($arsip->passcode);
        $this->passcode = '';

        $this->categories = Category::where('type', 'keputusan')->orderBy('name')->get();
    }

    public function update()
    {
        $this->validate();

        $arsip = Keputusan::findOrFail($this->skId);

        $data = [
            'category_id'       => $this->category_id,
            'nomor_surat'       => $this->nomor_surat,
            'tentang'           => $this->tentang,
            'tanggal_penetapan' => $this->tanggal_penetapan,
            'keterangan'        => $this->keterangan,
        ];

        // Logika Update File
        if ($this->file_sk) {
            // 1. Hapus file fisik lama dari storage
            if ($arsip->file_path && Storage::disk('public')->exists($arsip->file_path)) {
                Storage::disk('public')->delete($arsip->file_path);
            }
            
            // 2. Simpan file baru
            $data['file_path'] = $this->file_sk->store('keputusan', 'public');
            
            // 3. Update nama file dengan yang baru
            $data['file_name'] = $this->file_sk->getClientOriginalName();
        }

        if (!$this->hasExistingPasscode && !empty($this->passcode)) {
            $data['passcode'] = $this->passcode;
        }

        $arsip->update($data);

        session()->flash('success', 'Arsip Surat Keputusan berhasil diperbarui!');
        return $this->redirectRoute('keputusan.index', navigate: true);
    }
    
    public function render()
    {
        return view('livewire.keputusan.keputusan-edit');
    }
}