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

    protected $rules = [
        'email' => 'required|email',
    ];

    public function login()
    {
        $this->validate();

        $customer = Customer::where('email', $this->email)->first();

        if (!$customer) {
            // Create a new customer if not found
            $customer = Customer::create([
                'email' => $this->email,
                'nama' => 'Guest',
                'password' => bcrypt(str()->random(12)), // random password, not used for login
            ]);
        }

        Auth::guard('customer')->login($customer);
        return redirect('/');
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