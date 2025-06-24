<div class="container mt-5" style="max-width: 800px;">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card shadow-lg rounded-4 p-4">
        <h3 class="fw-bold mb-4 text-center">Detail Order</h3>

        {{-- Order Information --}}
        <div class="card shadow-sm rounded-4 mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    {{-- Left Side: Order Details --}}
                    <div class="col-md-6">
                        <h5 class="fw-bold">Order #{{ $order->id }}</h5>
                        <p class="text-muted small mb-3">{{ $order->created_at->translatedFormat('l, d F Y, H:i') }} WIB</p>
                        <p class="mt-3">
                            <strong class="d-block">Metode Pemesanan:</strong>
                            <span class="badge bg-primary-soft">{{ $order->transaction?->catatan ?? '-' }}</span>
                        </p>
                        @if (Str::lower($order->transaction?->catatan ?? '') == 'dine_in')
                            <p class="text-muted small">Silahkan ambil pesanan Anda di kasir.</p>
                        @else
                            <p class="text-muted small">Pesanan Anda sedang dalam perjalanan.</p>
                        @endif
                    </div>

                    {{-- Right Side: Product Details --}}
                    @if ($order->transaction && ($detail = $order->transaction->details->first()))
                        @php
                            $product = $detail->product ?? null;
                            $varian = $detail->varian ?? null;
                        @endphp
                        <div class="col-md-6 text-md-end">
                            <div class="d-flex align-items-center justify-content-md-end">
                                <div class="me-3 text-start">
                                    <h5 class="mb-1 fw-bold">{{ $product?->nama_product ?? '-' }}</h5>
                                    @if($varian)
                                    <p class="mb-1 text-muted small">Varian: {{ $varian?->nama_varian ?? '-' }}</p>
                                    @endif
                                    <p class="mb-1 fw-bold text-success">{{ 'Rp ' . number_format($detail->total_harga ?? 0, 0, ',', '.') }}</p>

                                    @if ($ratingModel)
                                        <div class="mt-2">
                                            <div class="d-flex align-items-center">
                                                <strong class="me-2">Rating:</strong>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star @if($i <= $ratingModel->rating) text-warning @else text-secondary @endif"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <img src="{{ asset('storage/' . ($product?->gambar ?? 'default.png')) }}" alt="{{ $product?->nama_product ?? 'Produk' }}" class="rounded-3" width="90" height="90" style="object-fit: cover;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Review Form --}}
        @if ($order->status == 'selesai')
            <div class="card shadow-sm rounded-4">
                <div class="card-body text-center">
                    <h5 class="mb-3 fw-bold">Berikan Ulasan Anda</h5>
                    <form wire:submit.prevent="saveReview">
                        @csrf
                        {{-- Star Rating --}}
                        <div class="d-flex justify-content-center mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star fa-2x @if($i <= $rating) text-warning @else text-secondary @endif"
                                   wire:click="setRating({{ $i }})"
                                   style="cursor: pointer;"></i>
                            @endfor
                        </div>
                        @error('rating') <small class="text-danger d-block mb-2">{{ $message }}</small> @enderror

                        {{-- Comment Box --}}
                        <div class="form-floating mb-3">
                            <textarea wire:model.defer="komentar" class="form-control" placeholder="Tulis ulasan Anda di sini..." id="komentar" style="height: 120px;"></textarea>
                            <label for="komentar">Tulis ulasan Anda di sini...</label>
                        </div>
                        @error('komentar') <small class="text-danger d-block mb-2">{{ $message }}</small> @enderror

                        {{-- Submit Button --}}
                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            <span wire:loading.remove wire:target="saveReview">Kirim Ulasan</span>
                            <span wire:loading wire:target="saveReview">Menyimpan...</span>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                Anda dapat memberikan ulasan setelah pesanan selesai.
            </div>
        @endif
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary mt-3">Kembali ke Dashboard</a>
    </div>
</div>

@push('styles')
<style>
    .bg-primary-soft {
        background-color: rgba(0, 123, 255, 0.1);
        color: #007bff;
    }
    .fa-star.text-secondary {
        opacity: 0.5;
    }
</style>
@endpush 