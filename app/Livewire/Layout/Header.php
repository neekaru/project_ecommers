<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    public function logout()
    {
        Auth::guard('customers')->logout();
        return $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.layout.header');
    }
}
