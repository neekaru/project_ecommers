<div class="container my-4">
    <div class="bg-white p-4 rounded shadow-sm mx-auto" style="max-width: 600px;">
        <h2 class="h4 fw-bold mb-4">DAFTAR PESANAN</h2>

        @foreach($items as $item)
            <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                <div class="d-flex gap-3 align-items-start">
                    <img src="{{ $item['image'] }}" alt="{{ $item['nama_produk'] }}" class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                    <div>
                        <div class="fw-semibold">{{ $item['name'] }}</div>
                        <div class="text-muted small">{{ $item['desc'] }}</div>
                        <a href="#" class="text-primary small">Edit</a>
                    </div>
                </div>
                <div class="text-end">
                    <div class="text-danger fw-semibold">Rp. {{ number_format($item['price'], 0, ',', '.') }}</div>
                    <div class="text-success small">× {{ $item['qty'] }}</div>
                </div>
            </div>
        @endforeach

        <div class="mt-4 text-end h5 fw-bold">
            Sub total: <span class="text-danger">Rp. {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="mt-4 text-center">
            <button class="btn btn-success px-4 py-2">
                pesan sekarang
            </button>
        </div>
    </div>
</div>