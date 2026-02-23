<?php

namespace App\Livewire\Pejabat;

use App\Models\Pejabat;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PejabatEdit extends Component
{
    use WithFileUploads;

    public $pejabatId; 
    public $category_id;
    public $tgl_pengangkatan;
    public $dokumen_sk;
    public $existing_dokumen_sk;
    public $inputs = [];

    protected function rules()
    {
        return [
            'category_id'      => 'required|exists:categories,id',
            'tgl_pengangkatan' => 'required|date',
            'dokumen_sk'       => 'nullable|mimes:pdf|max:2048',
            'inputs.*.nama'    => 'required|min:3',
            'inputs.*.jabatan' => 'required',
        ];
    }

    protected $messages = [
        'category_id.required'      => 'Kategori wajib dipilih.',
        'tgl_pengangkatan.required' => 'Tanggal pengangkatan wajib diisi.',
        'dokumen_sk.mimes'          => 'Format file harus PDF.',
        'dokumen_sk.max'            => 'Ukuran file maksimal 2MB.',
        'inputs.*.nama.required'    => 'Nama pejabat wajib diisi.',
        'inputs.*.jabatan.required' => 'Jabatan wajib diisi.',
    ];

    public function mount($uuid)
    {
        $pejabat = Pejabat::where('uuid', $uuid)->firstOrFail();

        $this->pejabatId = $pejabat->id;
        $this->category_id = $pejabat->category_id;
        $this->tgl_pengangkatan = $pejabat->tgl_pengangkatan;
        $this->existing_dokumen_sk = $pejabat->dokumen_sk;

        // Load data nama & jabatan ke dalam array inputs
        $namas = is_array($pejabat->nama) ? $pejabat->nama : json_decode($pejabat->nama, true) ?? [];
        $jabatans = is_array($pejabat->jabatan) ? $pejabat->jabatan : json_decode($pejabat->jabatan, true) ?? [];

        foreach ($namas as $index => $nama) {
            $this->inputs[] = [
                'nama' => $nama,
                'jabatan' => $jabatans[$index] ?? ''
            ];
        }

        if (empty($this->inputs)) {
            $this->inputs = [['nama' => '', 'jabatan' => '']];
        }
    }

    public function updatedCategoryId($value)
    {
        $category = Category::find($value);
        $categoryName = $category?->name ?? '';

        // Jika bukan PPK, paksa input menjadi hanya 1 baris
        if (!Str::contains($categoryName, 'PPK')) {
            if (count($this->inputs) > 1) {
                $this->inputs = [array_shift($this->inputs)];
            }
        }
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

    public function update()
    {
        $this->validate();

        $pejabat = Pejabat::findOrFail($this->pejabatId);

        $data = [
            'category_id'      => $this->category_id,
            'nama'             => array_column($this->inputs, 'nama'), 
            'jabatan'          => array_column($this->inputs, 'jabatan'),
            'tgl_pengangkatan' => $this->tgl_pengangkatan,
        ];

        if ($this->dokumen_sk) {
            if ($pejabat->dokumen_sk && Storage::disk('public')->exists($pejabat->dokumen_sk)) {
                Storage::disk('public')->delete($pejabat->dokumen_sk);
            }
            $data['dokumen_sk'] = $this->dokumen_sk->store('sk-pejabat', 'public');
        }

        $pejabat->update($data);

        session()->flash('success', 'Data Pejabat Berhasil Diperbarui!');
        return $this->redirectRoute('pejabat.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.pejabat.pejabat-edit', [
            'categories' => Category::where('type', 'pejabat')->orderBy('name')->get()
        ]);
    }
}