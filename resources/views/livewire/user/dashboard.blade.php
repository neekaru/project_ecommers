@php use Illuminate\Support\Str; @endphp
<div class="container mt-5">
    {{-- Profil User --}}
    <div class="card shadow-sm p-4 mb-4">
        <div class="d-flex align-items-center">
            <div class="position-relative">
                <img src="{{ auth('customers')->user()->avatar ? asset('storage/' . auth('customers')->user()->avatar) : asset('storage/avatar.jpg') }}" alt="Profile Picture" class="rounded-circle" width="80" height="80">
                <a href="{{ route('user.edit-profile') }}" class="position-absolute bottom-0 end-0 bg-light rounded-circle p-1" style="transform: translate(25%, 25%);" title="Edit Profile">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </div>
            <div class="ms-3">
                <h4 class="mb-0">{{ auth('customers')->user()->nama }}</h4>
                <small>{{ auth('customers')->user()->email }}</small><br>
                <small>{{ auth('customers')->user()->telepon ?? 'Nomor telepon belum diatur' }}</small><br>
                <small>{{ auth('customers')->user()->alamat ?? 'Alamat belum diatur' }}</small>
            </div>
            <button wire:click="logout" class="btn btn-sm btn-outline-danger ms-auto">Logout</button>
        </div>
    </div>

    {{-- Notifikasi Pesanan --}}
    <div class="card shadow-sm p-4 mb-4" wire:poll.5s>
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

    {{-- Histori Pesanan --}}
    <div class="card shadow-sm p-4 mb-4">
        <h5><i class="fa fa-history text-primary me-2"></i> Histori Pesanan</h5>
        <p class="text-muted">Riwayat pesanan anda yang telah selesai atau dibatalkan.</p>

        @forelse ($orders->whereIn('status', ['selesai', 'ditolak']) as $order)
            <a href="{{ route('user.order.detail', ['order' => $order->id]) }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm rounded-4 mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5>Order#:{{ $order->id }}</h5>
                                <p class="text-muted small">{{ $order->created_at->format('d-F-Y, H:i') }} wib</p>
                                @php
                                    $catatanMap = [
                                        'dine_in' => 'Dine In',
                                        'take_away' => 'Take Away',
                                        'drive_thru' => 'Drive Thru',
                                        'catering' => 'Catering'
                                    ];
                                    $catatanLabel = $order->transaction?->catatan ?? null;
                                @endphp
                                <p class="mt-3">
                                    Metode pemesanan anda:
                                    {{ $catatanLabel && isset($catatanMap[$catatanLabel]) ? $catatanMap[$catatanLabel] : ($catatanLabel ?? '-') }}
                                </p>
                            </div>
                            @if ($order->transaction && $detail = $order->transaction->details->first())
                                @php
                                    $product = $detail->product;
                                @endphp
                                <div class="text-end">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3 text-start">
                                            <h5 class="mb-0">{{ $product->nama_product }}</h5>
                                            <small class="text-muted">{{ 'Rp ' . number_format($detail->total_harga, 0, ',', '.') }}</small>

                                            @if ($order->status == 'selesai' && ($order->komentar || ($detail && \App\Models\Rating::where('product_id', $detail->product_id)->where('customer_id', auth('customers')->id())->exists())))
                                                <div class="mt-2">
                                                    @php
                                                        // Fallback: check if pesanan_id column exists before using it
                                                        $pesananIdColumn = false;
                                                        try {
                                                            $pesananIdColumn = \Schema::hasColumn('komentars', 'pesanan_id');
                                                        } catch (\Throwable $e) {}
                                                        if ($detail && $pesananIdColumn) {
                                                            $komentar = \App\Models\Komentar::where('product_id', $detail->product_id)
                                                                ->where('customer_id', auth('customers')->id())
                                                                ->where('pesanan_id', $order->id)
                                                                ->first();
                                                        } else {
                                                            $komentar = $detail ? \App\Models\Komentar::where('product_id', $detail->product_id)
                                                                ->where('customer_id', auth('customers')->id())
                                                                ->first() : null;
                                                        }
                                                    @endphp
                                                    @if ($komentar)
                                                        <p class="mb-1 fst-italic"><strong>Ulasan:</strong> "{{ Str::limit($komentar->isi, 30) }}"</p>
                                                    @endif
                                                    @php
                                                        $pesananIdColumnRating = false;
                                                        try {
                                                            $pesananIdColumnRating = \Schema::hasColumn('ratings', 'pesanan_id');
                                                        } catch (\Throwable $e) {}
                                                        if ($detail && $pesananIdColumnRating) {
                                                            $rating = \App\Models\Rating::where('product_id', $detail->product_id)
                                                                ->where('customer_id', auth('customers')->id())
                                                                ->where('pesanan_id', $order->id)
                                                                ->first();
                                                        } else {
                                                            $rating = $detail ? \App\Models\Rating::where('product_id', $detail->product_id)
                                                                ->where('customer_id', auth('customers')->id())
                                                                ->first() : null;
                                                        }
                                                    @endphp
                                                    @if ($rating)
                                                        <div class="d-flex align-items-center">
                                                            <strong class="me-2">Rating:</strong>
                                                            <div class="d-flex">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star @if($i <= $rating->rating) text-warning @else text-secondary @endif"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif($order->status == 'selesai')
                                                <p class="mt-2 mb-1 text-muted">Belum ada ulasan</p>
                                            @endif
                                            <span class="badge bg-{{ $order->status == 'selesai' ? 'success' : 'danger' }} mt-2">{{ Str::title($order->status) }}</span>
                                        </div>
                                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_product }}" class="rounded"
                                            width="80" height="80">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center text-muted">
                <p>Tidak ada riwayat pesanan.</p>
            </div>
        @endforelse
    </div>
</div>
