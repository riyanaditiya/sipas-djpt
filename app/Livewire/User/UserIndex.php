<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public $deleteUuid = null; // ID user yang akan dihapus
    public $query = "";


    public function search()
    {
        $this->resetPage();
    }

    public function updatedQuery()
    {
        $this->resetPage();
    }

   
    // Set ID user yang ingin dihapus
    public function confirmDelete($uuid)
    {
        $this->deleteUuid = $uuid;
    }

    // Hapus user
    public function delete()
    {
        if ($this->deleteUuid) {
            // Gunakan where('uuid', ...) karena yang disimpan adalah string UUID
            $user = User::where('uuid', $this->deleteUuid)->first();

            if ($user) {
                $user->delete();
                session()->flash('success', 'User berhasil dihapus!');
            }

            $this->deleteUuid = null; // Reset kembali
        }
    }

    public function render()
    {
        $users = User::orderBy('created_at', 'desc')
                        ->where('name', 'like', "%{$this->query}%")
                        ->orWhere('email', 'like', "%{$this->query}%")
                        ->paginate(10);
        return view('livewire.user.user-index', compact('users'));
    }
}
