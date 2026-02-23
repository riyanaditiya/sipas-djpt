<?php

namespace App\Livewire\Keputusan;

use Livewire\Component;
use App\Models\Category;
use App\Models\Keputusan;
use App\Mail\ResetPasscodeMail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class KeputusanIndex extends Component
{
    use WithPagination;

    // Properti Dasar
    public $deleteUuid = null;
    public $search = '';
    public $filterStatus = '';
    public $selectedCategory = ''; 
    public $filterYear = '';

    // Properti Passcode & Modal
    public $passcodeUuid = null; 
    public $inputPasscode = '';
    public $selectedLink = '';
    
    // Properti Reset Passcode (Email Workflow)
    public $isForgotPasscode = false;
    public $emailForReset = '';
    public $isResetting = false; 
    public $newPasscode = '';

    /**
     * Menangani request dari Signed URL (Email)
     */
    public function mount()
    {
        if (request()->query('reset_verified') && request()->query('uuid')) {
            $this->passcodeUuid = request()->query('uuid');
            $this->isResetting = true;
            $this->isForgotPasscode = false;
        }
    }

    // Reset halaman saat filter berubah
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
        $sk = Keputusan::where('uuid', $uuid)->firstOrFail();
        $sk->keterangan = ($sk->keterangan === 'Berlaku') ? 'Tidak Berlaku' : 'Berlaku';
        $sk->save();
    }

    /**
     * Workflow Lupa Passcode (Email)
     */
    public function forgotPasscode()
    {
        $this->isForgotPasscode = true;
        $this->isResetting = false;
        $this->resetErrorBag();
    }

    public function sendResetLink()
    {
        $this->validate(['emailForReset' => 'required|email']);

        $arsip = Keputusan::where('uuid', $this->passcodeUuid)->first();

        if ($arsip) {
            // Generate Signed URL (Berlaku 60 menit)
            $url = URL::temporarySignedRoute(
                'passcode.reset.verify', 
                now()->addMinutes(60), 
                ['uuid' => $arsip->uuid]
            );

            // Kirim Email Asli
            Mail::to($this->emailForReset)->send(new ResetPasscodeMail($url, $arsip->nomor_surat));

            session()->flash('success_reset', 'Link verifikasi telah dikirim ke ' . $this->emailForReset);
        }
    }

    /**
     * Workflow Verifikasi & Akses Dokumen
     */
    public function checkPasscode($uuid)
    {
        $keputusan = Keputusan::where('uuid', $uuid)->firstOrFail();
        $this->resetErrorBag();
        session()->forget('error_passcode');

        $fileUrl = Storage::url($keputusan->file_path);

        if (empty($keputusan->passcode)) {
            $this->dispatch('open-new-tab', url: $fileUrl);
            return;
        }

        $this->passcodeUuid = $uuid;
        $this->inputPasscode = '';
        $this->isForgotPasscode = false;
        $this->isResetting = false;
    }

    public function verifyAndOpen()
    {
        $keputusan = Keputusan::where('uuid', $this->passcodeUuid)->first();

        if (!$keputusan) return;

        if (trim($this->inputPasscode) === trim($keputusan->passcode)) {
            $url = Storage::url($keputusan->file_path);
            $this->dispatch('open-new-tab', url: $url);
            $this->closeModal();
        } else {
            session()->flash('error_passcode', 'Passcode salah!');
        }
    }

    public function saveNewPasscode()
    {
        $this->validate(['newPasscode' => 'required|min:4']);

        $arsip = Keputusan::where('uuid', $this->passcodeUuid)->first();

        if ($arsip) {
            $arsip->update(['passcode' => $this->newPasscode]);
            $url = Storage::url($arsip->file_path);
            
            $this->dispatch('open-new-tab', url: $url);
            $this->closeModal();
            session()->flash('success', 'Passcode berhasil diperbarui!');
        }
    }

    private function closeModal()
    {
        $this->passcodeUuid = null;
        $this->inputPasscode = '';
        $this->isResetting = false;
        $this->isForgotPasscode = false;
        $this->emailForReset = '';
        $this->newPasscode = '';
    }

    public function confirmDelete($uuid)
    {
        $this->deleteUuid = $uuid;
    }

    public function delete()
    {
        if ($this->deleteUuid) {
            $keputusan = Keputusan::where('uuid', $this->deleteUuid)->first();
            if ($keputusan) {
                if ($keputusan->file_path && Storage::disk('public')->exists($keputusan->file_path)) {
                    Storage::disk('public')->delete($keputusan->file_path);
                }
                $keputusan->delete();
                session()->flash('success', 'Arsip berhasil dihapus!');
            }
            $this->deleteUuid = null;
        }
    }

    public function render()
    {
        $arsips = Keputusan::with('category')
            ->where(function ($q) {
                // Pencarian UTAMA tetap ada (Nomor & Tentang)
                $q->where('nomor_surat', 'like', "%{$this->search}%")
                ->orWhere('tentang', 'like', "%{$this->search}%");
            })
            ->when($this->filterYear, function ($q) {
                // Filter tahun sekarang terpisah (Hanya mengambil dari kolom tanggal)
                $q->whereYear('tanggal_penetapan', $this->filterYear);
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('keterangan', $this->filterStatus);
            })
            ->when($this->selectedCategory, function ($q) {
                $q->where('category_id', $this->selectedCategory);
            })
            ->latest('tanggal_penetapan')
            ->paginate(10);

        // Ambil daftar tahun unik untuk isi dropdown filter
        $availableYears = Keputusan::selectRaw('YEAR(tanggal_penetapan) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $categories = Category::where('type', 'keputusan')->get();

        return view('livewire.keputusan.keputusan-index', compact('arsips', 'categories', 'availableYears'));
    }
}