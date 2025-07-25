<div class="card product-card">

    <div class="card shadow rounded-4 p-4 mx-auto my-5" style="max-width: 720px;">
        {{-- Tombol Kembali --}}
        <div class="position-relative">
            <button class="btn btn-light back-button" onclick="history.back()">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
        </div>

        {{-- Gambar Produk --}}
       <div class="row g-4">
        {{-- Kolom Gambar --}}
        <div class="col-auto">
            <div style="width: 240px; height: 240px;" class="overflow-hidden rounded">
                <img src="{{ asset('storage/' . $product['gambar_produk']) }}"
                    alt="{{ $product['nama_produk'] }}"
                    class="img-fluid h-100 object-fit-cover w-100 rounded">
            </div>
        </div>

        {{-- Informasi Produk --}}
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <h2 class="h5 fw-bold text-dark mb-0">{{ $product['nama_produk'] }}</h2>
                <div class="fw-semibold text-dark fs-5">Rp. {{ number_format($variantPrice, 0, ',', '.') }}</div>
            </div>
            <p class="text-muted small mb-2">{{ $product['deskripsi'] }}</p>
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-secondary small">per porsi</div>
                {{-- Selector Jumlah --}}
                <div class="quantity-selector d-flex align-items-center" wire:key="qty-selector">
                    <button type="button" wire:click="decrementQuantity" class="btn btn-outline-secondary px-3">−</button>
                    <span class="mx-3 fw-semibold">{{ $quantity }}</span>
                    <button type="button" wire:click="incrementQuantity" class="btn btn-outline-secondary px-3">+</button>
                </div>
            </div>
        </div>

        {{-- Varian --}}
        <div class="mb-4">
            <h3 class="section-title">Varian :</h3>
            <div class="vstack gap-2">
                @foreach($variants as $key => $variantData)
                    <div class="variant-option {{ $variant === $key ? 'active' : '' }} d-flex justify-content-between align-items-center">
                        <div class="form-check m-0 d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="variant" id="variant_{{ $key }}"
                                   wire:model.live="variant" value="{{ $key }}">
                            <label class="form-check-label ms-2 mb-0" for="variant_{{ $key }}">
                                {{ $variantData['name'] }}
                            </label>
                        </div>
                        <span class="price ms-3">Rp. {{ number_format($variantData['price'], 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tambahan --}}
        <div class="mb-4">
            <h3 class="section-title">Tambahan :</h3>
            <div class="vstack gap-2">
                @foreach($addOns as $key => $addOn)
                    <div class="addon-option {{ in_array($key, $selectedAddOns) ? 'active' : '' }}">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div class="form-check m-0 d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" name="addon" id="addon_{{ $key }}"
                                       wire:click="toggleAddOn('{{ $key }}')"
                                       @if(in_array($key, $selectedAddOns)) checked @endif>
                                <label class="form-check-label ms-2 mb-0" for="addon_{{ $key }}">
                                    {{ $addOn['name'] }}
                                </label>
                            </div>
                            <div class="d-flex align-items-center">
                                @if(in_array($key, $selectedAddOns))
                                <div class="quantity-selector d-flex align-items-center me-3">
                                    <button type="button" wire:click="decrementAddonQuantity('{{ $key }}')" class="btn btn-outline-secondary px-2 py-1">−</button>
                                    <span class="mx-2 fw-semibold">{{ $addonQuantities[$key] ?? 1 }}</span>
                                    <button type="button" wire:click="incrementAddonQuantity('{{ $key }}')" class="btn btn-outline-secondary px-2 py-1">+</button>
                                </div>
                                @endif
                                <div class="badge-price ms-4">
                                    Rp. {{ number_format($addOn['price'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tombol Keranjang --}}
        <div class="mb-4">
            <button type="button" wire:click="addToCart" class="btn btn-success w-100 fw-semibold text-uppercase py-2">
                MASUK KERANJANG
            </button>
        </div>

        {{-- Ulasan Produk --}}
        <div class="bg-light rounded p-4">
            <div class="d-flex align-items-center mb-3">
                <svg width="16" height="16" fill="none" stroke="currentColor" class="me-2 text-secondary"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z"/>
                </svg>
                <span class="small fw-medium text-secondary">Ulasan Produk</span>
            </div>
            <div class="vstack gap-3">
                @forelse($komentars as $ulasan)
                    <div class="d-flex gap-2">
                        <div class="avatar-circle">
                            <span class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                                {{ strtoupper(substr($ulasan['name'] ?? 'A', 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="small fw-medium text-dark">{{ $ulasan['name'] }}</span>
                                @if($ulasan['rating'])
                                    <div class="d-flex align-items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg width="12" height="12"
                                                 class="me-1 {{ $i <= $ulasan['rating'] ? 'text-warning' : 'text-secondary' }}"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                @endif
                            </div>
                            <p class="text-muted small mb-0">{{ $ulasan['isi'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small">Belum ada ulasan untuk produk ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

