<?php

namespace App\Livewire\User;

use App\Models\Pesanan;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => 'Dashboard'])]
class Dashboard extends Component
{
    public function logout()
    {
        Auth::guard('customers')->logout();
        return $this->redirect('/');
    }

    public function render()
    {
        $customerId = Auth::guard('customers')->id();
        $orders = Pesanan::with('transaction')
            ->where('customer_id', $customerId)
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'selesai', 'ditolak'])
            ->latest()
            ->get();

        return view('livewire.user.dashboard', [
            'orders' => $orders
        ]);
    }
}
