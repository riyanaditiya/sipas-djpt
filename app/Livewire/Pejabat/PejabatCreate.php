<?php

namespace App\Livewire\Pejabat;

use App\Models\Pejabat;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class PejabatCreate extends Component
{
    use WithFileUploads;

    public $category_id;
    public $tgl_pengangkatan;
    public $dokumen_sk;
    public $inputs = [];

    protected function rules()
    {
        return [
            'category_id'      => 'required|exists:categories,id',
            'tgl_pengangkatan' => 'required|date',
            'dokumen_sk'       => 'required|mimes:pdf|max:2048',
            'inputs.*.nama'    => 'required|min:3',
            'inputs.*.jabatan' => 'required',
        ];
    }

    protected $messages = [
        'category_id.required'      => 'Kategori wajib dipilih.',
        'category_id.exists'        => 'Kategori tidak valid.',
        'tgl_pengangkatan.required' => 'Tanggal pengangkatan wajib diisi.',
        'tgl_pengangkatan.date'     => 'Format tanggal tidak valid.',
        'dokumen_sk.required'       => 'File SK wajib diunggah.',
        'dokumen_sk.mimes'          => 'Format file harus PDF.',
        'dokumen_sk.max'            => 'Ukuran file maksimal 2MB.',
        'inputs.*.nama.required'    => 'Nama pejabat wajib diisi.',
        'inputs.*.nama.min'         => 'Nama pejabat minimal 3 karakter.',
        'inputs.*.jabatan.required' => 'Jabatan wajib diisi.',
    ];

    public function mount()
    {
        $this->inputs = [['nama' => '', 'jabatan' => '']];
    }

    public function updatedCategoryId($value)
    {
        // Reset inputs menjadi hanya 1 baris kosong setiap kali kategori berubah
        $this->inputs = [['nama' => '', 'jabatan' => '']];
    }

    public function addInput() 
    { 
        $this->inputs[] = ['nama' => '', 'jabatan' => '']; 
    }

    public function removeInput($index) 
    { 
        if (count($this->inputs) > 1) {
            unset($this->inputs[$index]); 
            $this->inputs = array_values($this->inputs); 
        }
    }

    public function save()
    {
        $this->validate();

        $path = $this->dokumen_sk->store('sk-pejabat', 'public');

        Pejabat::create([
            'category_id'      => $this->category_id,
            'nama'             => array_column($this->inputs, 'nama'), 
            'jabatan'          => array_column($this->inputs, 'jabatan'),
            'tgl_pengangkatan' => $this->tgl_pengangkatan,
            'dokumen_sk'       => $path,
        ]);

        $this->reset(['category_id', 'tgl_pengangkatan', 'dokumen_sk', 'inputs']);
        $this->inputs = [['nama' => '', 'jabatan' => '']];

        session()->flash('success', 'Data Pejabat Berhasil Ditambahkan!');

        return $this->redirectRoute('pejabat.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.pejabat.pejabat-create', [
            'categories' => Category::where('type', 'pejabat')->get()
        ]);
    }
}