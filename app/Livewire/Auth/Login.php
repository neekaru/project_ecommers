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

        // Attempt to authenticate first
        if (auth()->guard('customers')->attempt(['email' => $this->email, 'password' => $this->password])) {
            return $this->redirect('/user');
        }

        // If user does not exist, create and login
        $customer = Customer::where('email', $this->email)->first();
        if (!$customer) {
            $customer = Customer::create([
                'email' => $this->email,
                'nama' => 'Guest',
                'password' => bcrypt($this->password),
            ]);
            auth()->guard('customers')->login($customer);
            return $this->redirect('/user');
        }

        // If user exists but password is wrong, do not create a new user
        return $this->redirect('/login');
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