<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserCreate extends Component
{
    public $name;
    public $email;
    public $role;
    public $password;
    public $confirm_password;

    protected $rules = [
        'name' => 'required|max:100',
        'email' => 'required|email:dns|unique:users,email',
        'password' => 'required|min:6',
        'confirm_password' => 'required|same:password',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'name.max' => 'Nama maksimal 100 karakter.',

        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',

        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',

        'confirm_password.required' => 'Konfirmasi password wajib diisi.',
        'confirm_password.same' => 'Konfirmasi password tidak sesuai dengan password.',
    ];

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => Hash::make($this->password)
        ]);

        $this->reset();

        session()->flash('success', 'Berhasil menambahkan user!');

        return $this->redirectRoute('user.index', navigate:true);
    }
    
    public function render()
    {
        return view('livewire.user.user-create');
    }
}
