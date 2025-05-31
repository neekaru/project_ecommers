<!-- Section Menu -->
  <div class="container py-5">
    <!-- Ayam -->
    <section id="ayam">
      <h4 class="fw-bold">Menu Ayam</h4>
      <div class="row">
        @php
          $ayam = $products->filter(function($item) {
            return optional($item->category)->name === 'Ayam';
          });
        @endphp
        @forelse ($ayam as $item)
          <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
              @if($item->gambar_produk)
                <img src="{{ asset('storage/' . $item->gambar_produk) }}" class="card-img-top" alt="{{ $item->nama_produk }}" style="height: 200px; object-fit: cover;">
              @else
                <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="No image available" style="height: 200px; object-fit: cover;">
              @endif
              <div class="card-body">
                <h6 class="card-title mb-1">{{ $item->nama_produk }}</h6>
                <p class="card-text text-secondary mb-1">Kategori: {{ $item->category ? $item->category->name : '-' }}</p>
                <p class="card-text text-danger fw-bold">Rp. {{ number_format($item->harga_dasar, 0, ',', '.') }}</p>
                <a href="#" class="btn btn-outline-dark btn-sm float-end">➕</a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-center">Saat ini belum ada menu ayam.</p>
          </div>
        @endforelse
      </div>
    </section>

    <!-- Bebek -->
    <section id="bebek" class="mt-5">
      <h4 class="fw-bold">Menu Bebek</h4>
      <div class="row">
        @php
          $bebek = $products->filter(function($item) {
            return optional($item->category)->name === 'Bebek';
          });
        @endphp
        @forelse ($bebek as $item)
          <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
              @if($item->gambar_produk)
                <img src="{{ asset('storage/' . $item->gambar_produk) }}" class="card-img-top" alt="{{ $item->nama_produk }}" style="height: 200px; object-fit: cover;">
              @else
                <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="No image available" style="height: 200px; object-fit: cover;">
              @endif
              <div class="card-body">
                <h6 class="card-title mb-1">{{ $item->nama_produk }}</h6>
                <p class="card-text text-secondary mb-1">Kategori: {{ $item->category ? $item->category->name : '-' }}</p>
                <p class="card-text text-danger fw-bold">Rp. {{ number_format($item->harga_dasar, 0, ',', '.') }}</p>
                <a href="#" class="btn btn-outline-dark btn-sm float-end">➕</a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-center">Saat ini belum ada menu bebek.</p>
          </div>
        @endforelse
      </div>
    </section>

    <!-- Paket Spesial -->
    <section id="paket" class="mt-5">
      <h4 class="fw-bold">Paket Spesial</h4>
      <div class="row">
        @php
          $paket = $products->filter(function($item) {
            return optional($item->category)->name === 'Paket Spesial';
          });
        @endphp
        @forelse ($paket as $item)
          <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
              @if($item->gambar_produk)
                <img src="{{ asset('storage/' . $item->gambar_produk) }}" class="card-img-top" alt="{{ $item->nama_produk }}" style="height: 200px; object-fit: cover;">
              @else
                <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="No image available" style="height: 200px; object-fit: cover;">
              @endif
              <div class="card-body">
                <h6 class="card-title mb-1">{{ $item->nama_produk }}</h6>
                <p class="card-text text-secondary mb-1">Kategori: {{ $item->category ? $item->category->name : '-' }}</p>
                <p class="card-text text-danger fw-bold">Rp. {{ number_format($item->harga_dasar, 0, ',', '.') }}</p>
                <a href="#" class="btn btn-outline-dark btn-sm float-end">➕</a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-center">Saat ini belum ada paket spesial.</p>
          </div>
        @endforelse
      </div>
    </section>

    <!-- Tumpeng -->
    <section id="tumpeng" class="mt-5">
      <h4 class="fw-bold">Tumpeng</h4>
      <div class="row">
        @php
          $tumpeng = $products->filter(function($item) {
            return optional($item->category)->name === 'Tumpeng';
          });
        @endphp
        @forelse ($tumpeng as $item)
          <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
              @if($item->gambar_produk)
                <img src="{{ asset('storage/' . $item->gambar_produk) }}" class="card-img-top" alt="{{ $item->nama_produk }}" style="height: 200px; object-fit: cover;">
              @else
                <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="No image available" style="height: 200px; object-fit: cover;">
              @endif
              <div class="card-body">
                <h6 class="card-title mb-1">{{ $item->nama_produk }}</h6>
                <p class="card-text text-secondary mb-1">Kategori: {{ $item->category ? $item->category->name : '-' }}</p>
                <p class="card-text text-danger fw-bold">Rp. {{ number_format($item->harga_dasar, 0, ',', '.') }}</p>
                <a href="#" class="btn btn-outline-dark btn-sm float-end">➕</a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-center">Saat ini belum ada tumpeng.</p>
          </div>
        @endforelse
      </div>
    </section>

    <!-- Minuman -->
    <section id="minuman" class="mt-5">
      <h4 class="fw-bold">Minuman</h4>
      <div class="row">
        @php
          $minuman = $products->filter(function($item) {
            return optional($item->category)->name === 'Minuman';
          });
        @endphp
        @forelse ($minuman as $item)
          <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
              @if($item->gambar_produk)
                <img src="{{ asset('storage/' . $item->gambar_produk) }}" class="card-img-top" alt="{{ $item->nama_produk }}" style="height: 200px; object-fit: cover;">
              @else
                <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="No image available" style="height: 200px; object-fit: cover;">
              @endif
              <div class="card-body">
                <h6 class="card-title mb-1">{{ $item->nama_produk }}</h6>
                <p class="card-text text-secondary mb-1">Kategori: {{ $item->category ? $item->category->name : '-' }}</p>
                <p class="card-text text-danger fw-bold">Rp. {{ number_format($item->harga_dasar, 0, ',', '.') }}</p>
                <a href="#" class="btn btn-outline-dark btn-sm float-end">➕</a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-center">Saat ini belum ada minuman.</p>
          </div>
        @endforelse
      </div>
    </section>
  </div>