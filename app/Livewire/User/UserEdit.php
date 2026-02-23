<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserEdit extends Component
{
    public $userId;
    public $name;
    public $email;
    public $role;
    public $password;
    public $confirm_password;

    protected function rules()
    {
        return [
            'name'  => 'required|string|min:3|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->userId), // email harus unik kecuali untuk user ini
            ],
            'password' => 'nullable|min:6',
            'confirm_password' => 'nullable|same:password',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'name.string' => 'Nama harus berupa teks.',
        'name.min' => 'Nama minimal 3 karakter.',
        'name.max' => 'Nama maksimal 100 karakter.',

        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan oleh pengguna lain.',

        'password.min' => 'Password minimal 6 karakter.',

        'confirm_password.same' => 'Konfirmasi password harus sama dengan password.',
    ];
    
    public function mount($uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        $this->userId = $user->id;   
        $this->name = $user->name;   
        $this->email = $user->email;   
        $this->password = '';
        $this->confirm_password = '';
    }

    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);

        $user->name = $this->name;
        $user->email = $this->email;

        if(!empty($this->password)){
            $user->password = Hash::make($this->password);
        }

        $user->save();

        session()->flash('success', 'User berhasil diperbarui!');
        return $this->redirectRoute('user.index', navigate:true);
    }
    
    public function render()
    {
        return view('livewire.user.user-edit');
    }
}
