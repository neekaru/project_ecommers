<x-filament::page>
    <div class="space-y-6">

        <div class="container mt-5">
            <h1 class="text-3xl font-extrabold text-gray-900 drop-shadow-md">Selamat Datang di RM Bebek Galak Rara 57</h1>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Total Produk --}}
            <x-filament::card class="bg-gradient-to-r from-amber-100 to-amber-200 border-l-8 border-amber-600 shadow-lg hover:shadow-2xl transition duration-300">
                <div class="flex items-center gap-4">
                    <x-heroicon-o-cube class="w-10 h-10 text-amber-700" />
                    <div>
                        <div class="text-2xl font-bold text-amber-900">{{ $this->totalProduk }}</div>
                        <div class="text-sm text-amber-800">Total Produk</div>
                    </div>
                </div>
            </x-filament::card>

            {{-- Total Pelanggan --}}
            <x-filament::card class="bg-gradient-to-r from-emerald-100 to-emerald-200 border-l-8 border-emerald-600 shadow-lg hover:shadow-2xl transition duration-300">
                <div class="flex items-center gap-4">
                    <x-heroicon-o-users class="w-10 h-10 text-emerald-700" />
                    <div>
                        <div class="text-2xl font-bold text-emerald-900">{{ $this->totalPelanggan }}</div>
                        <div class="text-sm text-emerald-800">Total Pelanggan</div>
                    </div>
                </div>
            </x-filament::card>

            {{-- Total Transaksi --}}
            <x-filament::card class="bg-gradient-to-r from-indigo-100 to-indigo-200 border-l-8 border-indigo-600 shadow-lg hover:shadow-2xl transition duration-300">
                <div class="flex items-center gap-4">
                    <x-heroicon-o-shopping-cart class="w-10 h-10 text-indigo-700" />
                    <div>
                        <div class="text-2xl font-bold text-indigo-900">{{ $this->totalTransaksi }}</div>
                        <div class="text-sm text-indigo-800">Total Transaksi</div>
                    </div>
                </div>
            </x-filament::card>

        </div>

        {{-- Total Pendapatan --}}
        <x-filament::card class="bg-gradient-to-r from-green-100 to-green-200 shadow-lg hover:shadow-2xl transition duration-300">
            <div class="text-center">
                <div class="text-lg font-semibold text-green-800 mb-1">Total Pendapatan</div>
                <div class="text-3xl font-extrabold text-green-900">
                    Rp {{ number_format($this->totalPendapatan ?? 0, 0, ',', '.') }}
                </div>
            </div>
        </x-filament::card>

        {{-- Notifikasi --}}
        <x-filament::card class="bg-gradient-to-r from-yellow-100 to-yellow-200 shadow-lg hover:shadow-2xl transition duration-300">
            <h3 class="text-lg font-bold text-yellow-900 flex items-center gap-2">
                <x-heroicon-o-bell class="w-5 h-5 text-yellow-700" />
                Notifikasi
            </h3>
            <ul class="list-disc list-inside mt-2 text-sm text-yellow-800">
                <li>Pesanan Baru Telah Masuk</li>
                <li>Stok Makanan Hampir Habis</li>
            </ul>
        </x-filament::card>

        {{-- Chart Dummy --}}
        <x-filament::card class="bg-gradient-to-r from-sky-100 to-sky-200 shadow-lg hover:shadow-2xl transition duration-300">
            <h3 class="text-lg font-bold text-sky-800 mb-2 flex items-center gap-2">
                <x-heroicon-o-chart-bar class="w-5 h-5 text-sky-700" />
                Penjualan
            </h3>
            <p class="text-gray-600 text-sm">📊 Chart dummy - bisa kamu ganti pakai Livewire Chart / ChartJS</p>
        </x-filament::card>

    </div>
</x-filament::page>
