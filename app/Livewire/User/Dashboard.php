<?php

namespace App\Livewire\User;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $orders = [
            [
                'status' => 'Pesanan Diproses',
                'message' => 'Pesanan #ORD-2025-001 sedang di proses oleh tim dapur kami',
                'waktu' => '15 menit yang lalu',
                'label' => 'Diproses'
            ],
            [
                'status' => 'Pesanan Siap Diambil',
                'message' => 'Pesanan #ORD-2025-001 sudah siap dan menunggu untuk diambil',
                'waktu' => '30 menit yang lalu',
                'label' => 'Siap Diambil'
            ],
            [
                'status' => 'Pesanan Selesai',
                'message' => 'Pesanan #ORD-2025-001 telah selesai. Terima kasih atas kepercayaan anda!',
                'waktu' => '1 jam yang lalu',
                'label' => 'Selesai'
            ]
        ];

        return view('livewire.user.dashboard', [
            'orders' => $orders
        ]);
    }
}
