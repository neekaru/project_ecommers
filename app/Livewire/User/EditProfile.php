<?php

namespace App\Livewire\User;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class EditProfile extends Component
{
    use WithFileUploads;

    public $nama;
    public $email;
    public $telepon;
    public $alamat;
    public $avatar;
    public $existingAvatar;

    public function mount()
    {
        $customer = Customer::find(auth('customers')->user()->id);

        if ($customer) {
            $this->nama = $customer->nama;
            $this->email = $customer->email;
            $this->telepon = $customer->telepon;
            $this->alamat = $customer->alamat;
            $this->existingAvatar = $customer->avatar;
        }
    }

    public function updateProfile()
    {
        $customer = Customer::find(auth('customers')->user()->id);

        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $customer->id,
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'avatar' => 'nullable|image|max:16384', // 16MB Max
        ]);

        $data = [
            'nama' => $this->nama,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'alamat' => $this->alamat,
        ];

        if ($this->avatar) {
            // Hapus avatar lama jika ada
            if ($this->existingAvatar) {
                Storage::disk('public')->delete($this->existingAvatar);
            }
            $data['avatar'] = $this->avatar->store('avatars', 'public');
            $this->existingAvatar = $data['avatar'];
        }

        $customer->update($data);

        session()->flash('message', 'Profil berhasil diperbarui.');
        return redirect()->route('user.dashboard');
    }

    public function render()
    {
        return view('livewire.user.edit-profile');
    }
}