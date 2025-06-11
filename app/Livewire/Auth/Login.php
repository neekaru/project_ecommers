<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => 'Login'])]
class Login extends Component
{
    public string $email = '';
    public string $password = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        $customer = Customer::where('email', $this->email)->first();

     
        if (!$customer) {
            // Create a new customer if not found, hash the password with bcrypt
            $customer = Customer::create([
                'email' => $this->email,
                'nama' => 'Guest',
                'password' => bcrypt($this->password), // bcrypt hash for password
            ]);
        }

        if (auth()->guard('customers')->attempt(['email' => $this->email, 'password' => $this->password])) {
            // return 'oke berhasil login';
            return $this->redirect('/user');
        } else {
            // return 'gagal login';
            return $this->redirect('/login');
        }
     
    }

    public function redirectToGoogle()
    {
        return redirect()->route('auth.google', ['provider' => 'google']);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
} 