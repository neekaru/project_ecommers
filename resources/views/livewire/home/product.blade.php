<div class="container mt-5">

    <section class="promo-section" style="color: ">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="promo-title">Waktunya manjain perut dengan <br>Paket Spesial <span class="highlight">Bebek Galak</span></h2>
                <p class="promo-description">
                    Nikmati bebek renyah + nasi + sambal galak cuma di satu paket hemat! 🔥
                </p>
                <a href="/menu#paket" class="btn btn-promo">Lihat paket spesial</a>
            </div>
            <div class="col-md-6 promo-image">
                <img src="{{ asset('icon/paket spesial.png') }}" alt="Paket Spesial Bebek Galak">
            </div>
        </div>
    </section>

    <section class="promo-section" style="background-color: #F1F0F0">
        <div class="row align-items-center">
            <div class="col-md-6 order-md-2"> <h2 class="promo-title">Acara Makin Berkesan <br>dengan <span class="highlight">Tumpeng Spesial</span></h2>
                <p class="promo-description">
                    Nasi Tumpeng ini sangat cocok untuk berbagai perayaan, acara Syukuran, Arisan, Peresmian, dan juga dapat dijadikan sebagai hadiah ulang tahun.
                </p>
                <a href="/menu#tumpeng" class="btn btn-promo">Lihat pilihan tumpeng</a>
            </div>
            <div class="col-md-6 order-md-1 promo-image"> <img src="{{ asset('icon/nasi kuning tumpeng.png') }}" alt="Tumpeng Spesial">
            </div>
        </div>
    </section>

    <section class="featured-products-section mt-5 mb-5">
        <div class="container">
            <h3 class="text-center mb-4 fw-bold">Produk Unggulan Kami</h3>
            <div class="row">
                @forelse ($products as $item)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if($item->gambar_produk)
                                <img src="{{ asset('storage/' . $item->gambar_produk) }}" class="card-img-top" alt="{{ $item->nama_produk }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="No image available" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $item->nama_produk }}</h5>
                                <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($item->deskripsi, 100) }}</p>
                                <p class="card-text fw-bold text-success">Rp. {{ number_format($item->harga_dasar, 0, ',', '.') }}</p>
                                <a href="/menu#products/{{ $item->slug }}" wire:navigate class="btn btn-danger mt-auto">Lihat Produk</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Saat ini belum ada produk unggulan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</div>