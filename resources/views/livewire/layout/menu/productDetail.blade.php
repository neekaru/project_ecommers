{{-- Ensure Bootstrap CSS is loaded for this component --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="card mx-auto my-4 shadow border-0" style="max-width: 36rem;">
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success rounded-0 mb-0" role="alert">
            <span class="d-inline-block">{{ session('message') }}</span>
        </div>
    @endif

    {{-- Product Header Section --}}
    <div class="d-flex p-4 border-bottom align-items-center">
        {{-- Back Button --}}
        <div class="flex-shrink-0 me-3">
            <button class="btn btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center">
                <svg class="" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
        </div>
        {{-- Product Image --}}
        <div class="flex-shrink-0 me-4" style="width: 96px; height: 96px;">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="img-fluid rounded product-image w-100 h-100 object-fit-cover">
        </div>
        {{-- Product Info --}}
        <div class="flex-grow-1">
            <h2 class="h5 fw-bold text-dark mb-1">{{ $product['name'] }}</h2>
            <p class="text-muted small mb-2">{{ $product['description'] }}</p>
            <div class="fw-semibold text-dark">Rp. {{ number_format($this->variantPrice, 0, ',', '.') }}</div>
            <div class="text-secondary small">per porsi</div>
        </div>
        {{-- Quantity Selector --}}
        <div class="flex-shrink-0 ms-4">
            <div class="input-group input-group-sm">
                <button wire:click="decrementQuantity" class="btn btn-outline-success" type="button">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </button>
                <span class="input-group-text bg-white">{{ $quantity }}</span>
                <button wire:click="incrementQuantity" class="btn btn-outline-success" type="button">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Variant Selection --}}
    <div class="p-4 border-bottom">
        <h3 class="fw-semibold text-dark mb-3">Varian :</h3>
        <div class="vstack gap-2">
            @foreach($variants as $key => $variantData)
                <div class="d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="variant" id="variant_{{ $key }}" wire:model.live="variant" value="{{ $key }}">
                        <label class="form-check-label" for="variant_{{ $key }}">
                            {{ $variantData['name'] }}
                        </label>
                    </div>
                    <span class="fw-medium text-danger small">
                        Rp. {{ number_format($variantData['price'], 0, ',', '.') }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Add-ons Selection --}}
    <div class="p-4 border-bottom">
        <h3 class="fw-semibold text-dark mb-3">Tambahan :</h3>
        <div class="vstack gap-2">
            @foreach($addOns as $key => $addOn)
                <div class="d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="addon_{{ $key }}" wire:click="toggleAddOn('{{ $key }}')" @if(in_array($key, $selectedAddOns)) checked @endif>
                        <label class="form-check-label" for="addon_{{ $key }}">
                            {{ $addOn['name'] }}
                        </label>
                    </div>
                    <span class="badge rounded-pill {{ in_array($key, $selectedAddOns) ? 'bg-success-subtle text-success-emphasis border border-success-subtle' : 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle' }}">
                        Rp. {{ number_format($addOn['price'], 0, ',', '.') }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Add to Cart Button --}}
    <div class="p-4">
        <button wire:click="addToCart" class="btn btn-success w-100 fw-semibold text-uppercase py-2">
            MASUK KERANJANG
        </button>
    </div>

    {{-- Reviews Section --}}
    <div class="px-4 pb-4">
        <div class="bg-light rounded p-4">
            <div class="d-flex align-items-center mb-3">
                <svg width="16" height="16" fill="none" stroke="currentColor" class="me-2 text-secondary" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z"/>
                </svg>
                <span class="small fw-medium text-secondary">Ulasan Produk</span>
            </div>
            <div class="vstack gap-3">
                @foreach($reviews as $review)
                    <div class="d-flex gap-2">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <span class="small fw-medium">{{ $review['avatar'] }}</span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="small fw-medium text-dark">{{ $review['name'] }}</span>
                                <div class="d-flex align-items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg width="12" height="12" class="me-1 {{ $i <= $review['rating'] ? 'text-warning' : 'text-secondary' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-muted small mb-0">{{ $review['comment'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
