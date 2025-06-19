<div class="container py-5">
    <div class="row">
        <!-- Daftar Pesanan -->
        <div class="col-md-6">
            <div class="card p-4">
                <h5 class="fw-bold mb-4">DAFTAR PESANAN</h5>

                @foreach($items as $item)
                    <div class="d-flex justify-content-between align-items-start border-bottom py-3">
                        <div class="d-flex gap-3">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                            <div>
                                <strong>{{ $item['name'] }}</strong><br>
                                <small class="text-muted">{{ $item['desc'] }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div>Rp. {{ number_format($item['price'], 0, ',', '.') }}</div>
                            <small class="text-success">× {{ $item['qty'] }}</small>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4 text-end fw-bold h5">
                    Sub total: Rp. {{ number_format($subtotal, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- Form Checkout -->
        <div class="col-md-6">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">INFORMASI PELANGGAN</h5>

                <input type="text" wire:model.defer="nama" class="form-control mb-3" placeholder="Nama *">
                <input type="text" wire:model.defer="telepon" class="form-control mb-3" placeholder="Nomor Telepon *">
                <textarea wire:model.defer="alamat" class="form-control mb-4" placeholder="Alamat *"></textarea>

                <h5 class="fw-bold mb-2">PILIH METODE PEMESANAN</h5>
                <div class="mb-3">
                    @foreach(['Dine-in', 'Take Away', 'Driver Thru', 'Catering'] as $method)
                        <div class="form-check form-check-inline">
                            <input type="radio" wire:model="metodePemesanan" class="form-check-input" value="{{ $method }}" id="pesan_{{ $method }}">
                            <label class="form-check-label" for="pesan_{{ $method }}">{{ $method }}</label>
                        </div>
                    @endforeach
                </div>

                <h5 class="fw-bold mb-2">METODE PEMBAYARAN</h5>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="radio" wire:model="metodePembayaran" class="form-check-input" value="Qris" id="bayar_qris">
                        <label class="form-check-label" for="bayar_qris">Qris</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" wire:model="metodePembayaran" class="form-check-input" value="Cod/cash" id="bayar_cod">
                        <label class="form-check-label" for="bayar_cod">Cod/cash</label>
                    </div>
                </div>

                <div class="form-check form-switch mb-3">
                <input type="checkbox" wire:model="jadwalAktif" class="form-check-input" id="jadwalSwitch">
                <label class="form-check-label" for="jadwalSwitch">Jadwalin Pengambilan/Pengantaran</label>
                </div>

                <button wire:click="submit" class="btn btn-success w-100">pesan sekarang</button>
               
                @if (session()->has('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                @if($jadwalAktif)
            
                <div class="d-flex gap-3 mb-4">
                <input type="date" wire:model.defer="tanggal" class="form-control" placeholder="Tanggal">
                <input type="time" wire:model.defer="waktu" class="form-control" placeholder="Waktu">
                </div>
                @endif
            </div>
        </div>
    </div>
</div>