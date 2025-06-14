<div class="container mt-5">
    {{-- Profil User --}}
    <div class="card shadow-sm p-4 mb-4">
        <div class="d-flex align-items-center">
            <img src="{{ asset('storage/avatar.jpg') }}" alt="Profile Picture" class="rounded-circle" width="80">
            <div class="ms-3">
                <h4 class="mb-0">{{ Auth::user()->name }}</h4>
                <small>{{ Auth::user()->email }}</small><br>
                <small>{{ Auth::user()->phone ?? '0852-xxxx' }}</small><br>
                <small>{{ Auth::user()->alamat ?? 'Alamat belum diatur' }}</small>
            </div>
            <a href="#" class="btn btn-sm btn-outline-danger ms-auto">Logout</a>
        </div>
    </div>

    {{-- Notifikasi Pesanan --}}
    <div class="card shadow-sm p-4">
        <h5><i class="fa fa-bell text-danger me-2"></i> Notifikasi Pesanan</h5>
        <p class="text-muted">Update terbaru tentang pesanan anda</p>

        @foreach ($orders as $order)
            <div class="card mb-3 p-3 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $order['status'] }}</strong><br>
                        <small class="text-muted">{{ $order['message'] }}</small><br>
                        <small class="text-muted">{{ $order['waktu'] }}</small>
                    </div>
                    <span class="badge bg-success">{{ $order['label'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
