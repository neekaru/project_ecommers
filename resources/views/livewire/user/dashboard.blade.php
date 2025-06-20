<div class="container mt-5">
    {{-- Profil User --}}
    <div class="card shadow-sm p-4 mb-4">
        <div class="d-flex align-items-center">
            <img src="{{ asset('storage/avatar.jpg') }}" alt="Profile Picture" class="rounded-circle" width="80">
            <div class="ms-3">
                <h4 class="mb-0">{{ auth('customers')->user()->nama }}</h4>
                <small>{{ auth('customers')->user()->email }}</small><br>
                <small>{{ auth('customers')->user()->telepon ?? '0852-xxxx' }}</small><br>
                <small>{{ auth('customers')->user()->alamat ?? 'Alamat belum diatur' }}</small>
            </div>
            <button wire:click="logout" class="btn btn-sm btn-outline-danger ms-auto">Logout</button>
        </div>
    </div>

    {{-- Notifikasi Pesanan --}}
    <div class="card shadow-sm p-4" wire:poll.5s>
        <h5><i class="fa fa-bell text-danger me-2"></i> Notifikasi Pesanan</h5>
        <p class="text-muted">Update terbaru tentang pesanan anda</p>

        @forelse ($orders as $order)
            <div class="card mb-3 p-3 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    @php
                        $statusInfo = match($order->status) {
                            'menunggu' => [
                                'title' => 'Pesanan di Proses',
                                'message' => 'Pesanan #' . $order->id . ' sedang di proses oleh tim dapur kami',
                                'class' => 'bg-warning text-dark',
                                'label' => 'Diproses'
                            ],
                            'dikonfirmasi' => [
                                'title' => 'Pesanan Siap Diambil',
                                'message' => 'Pesanan #' . $order->id . ' sudah siap dan menunggu untuk di ambil',
                                'class' => 'bg-info text-dark',
                                'label' => 'Siap Diambil'
                            ],
                            'ditolak' => [
                                'title' => 'Pesanan Dibatalkan',
                                'message' => 'Pesanan #' . $order->id . ' ditolak.',
                                'class' => 'bg-danger',
                                'label' => 'Ditolak'
                            ],
                            'selesai' => [
                                'title' => 'Pesanan Selesai',
                                'message' => 'Pesanan #' . $order->id . ' telah selesai. Terima kasih atas kepercayaan anda!',
                                'class' => 'bg-success',
                                'label' => 'Selesai'
                            ],
                            default => [
                                'title' => 'Status Tidak Diketahui',
                                'message' => 'Terjadi kesalahan pada pesanan #' . $order->id,
                                'class' => 'bg-secondary',
                                'label' => 'Error'
                            ]
                        };
                    @endphp
                    <div>
                        <strong>{{ $statusInfo['title'] }}</strong><br>
                        <small class="text-muted">{{ $statusInfo['message'] }}</small><br>
                        <small class="text-muted">{{ $order->updated_at->diffForHumans() }}</small>
                    </div>
                    <span class="badge {{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</span>
                </div>
            </div>
        @empty
            <div class="text-center text-muted">
                <p>Tidak ada notifikasi pesanan saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
