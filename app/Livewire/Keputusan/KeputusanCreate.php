<?php

namespace App\Livewire\Keputusan;

use Livewire\Component;
use App\Models\Category;
use App\Models\Keputusan;
use Livewire\WithFileUploads;

class KeputusanCreate extends Component
{
    use WithFileUploads;
    
    public $category_id;

    public $nomor_surat;
    public $tentang;
    public $tanggal_penetapan;
    public $keterangan;
    public $file_sk;
    public $file_name;
    public $passcode;

    protected $rules = [
        'category_id'       => 'required|exists:categories,id',
        'nomor_surat'       => 'required|max:100|unique:keputusans,nomor_surat',
        'tentang'           => 'required|string',
        'tanggal_penetapan' => 'required|date',
        'keterangan'        => 'required|in:Berlaku,Tidak Berlaku',
        'file_sk'           => 'required|file|mimes:pdf,docx,doc|max:2048',
        'file_name'         => 'required',
        'passcode'          => 'nullable|min:4',
    ];

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

    public function save()
    {
        if ($this->file_sk) {
            $this->file_name = $this->file_sk->getClientOriginalName();
        }

        $this->validate();

        $path = $this->file_sk->store('keputusan', 'public');

        Keputusan::create([
            'category_id'       => $this->category_id,
            'nomor_surat'       => $this->nomor_surat,
            'tentang'           => $this->tentang,
            'tanggal_penetapan' => $this->tanggal_penetapan,
            'keterangan'        => $this->keterangan,
            'file_path'         => $path,
            'file_name'         => $this->file_name,
            'passcode'          => $this->passcode,
        ]);

        // Reset hanya field input
        $this->reset(['nomor_surat', 'tentang', 'tanggal_penetapan', 'keterangan', 'file_sk', 'file_name', 'passcode']);
        
        session()->flash('success', 'Berhasil Menambahkan Arsip Surat Keputusan!');

        return $this->redirectRoute('keputusan.index', navigate: true);    
    }

    public function render()
    {
        return view('livewire.keputusan.keputusan-create', [
            'categories' => Category::where('type', 'keputusan')->get()
        ]);
    }
}
