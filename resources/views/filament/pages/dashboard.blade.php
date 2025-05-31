<x-filament::page>
    <div class="space-y-6">

        {{-- Statistik Atas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Total Pesanan --}}
            <x-filament::card class="bg-white shadow border rounded-lg flex items-center gap-4 p-4">
                <x-heroicon-o-clipboard class="w-8 h-8 text-gray-700" />
                <div>
                    <div class="font-semibold text-sm text-gray-800">Total Pesanan</div>
                </div>
            </x-filament::card>

            {{-- Pendapatan Hari Ini --}}
            <x-filament::card class="bg-white shadow border rounded-lg flex items-center gap-4 p-4">
                <x-heroicon-o-currency-dollar class="w-8 h-8 text-gray-700" />
                <div>
                    <div class="font-semibold text-sm text-gray-800">Pendapatan Hari Ini</div>
                </div>
            </x-filament::card>

            {{-- Stok Hari Ini --}}
            <x-filament::card class="bg-white shadow border rounded-lg flex items-center gap-4 p-4">
                <x-heroicon-o-truck class="w-8 h-8 text-gray-700" />
                <div>
                    <div class="font-semibold text-sm text-gray-800">Stok Hari Ini</div>
                </div>
            </x-filament::card>
        </div>

        {{-- Pemasukan Total --}}
        <x-filament::card class="bg-white shadow border rounded-lg flex items-center gap-4 p-6">
            <x-heroicon-o-currency-dollar class="w-10 h-10 text-green-700" />
            <div>
                <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($this->totalPendapatan ?? 2500000, 0, ',', '.') }}</div>
                <div class="text-sm text-gray-600">Pemasukan</div>
            </div>
        </x-filament::card>

        {{-- Notifikasi --}}
        <x-filament::card class="bg-white shadow border rounded-lg p-4">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Notifikasi</h3>
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-center gap-2">
                    <x-heroicon-o-clock class="w-5 h-5 text-yellow-600" />
                    Pesanan Baru Telah Masuk
                </li>
                <li class="flex items-center gap-2">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-red-600" />
                    Stok Makanan Hampir Habis
                </li>
            </ul>
        </x-filament::card>

        {{-- Chart Penjualan --}}
        <x-filament::card class="bg-gradient-to-r from-sky-100 to-sky-200 shadow-lg hover:shadow-2xl transition duration-300">
            <h3 class="text-lg font-bold text-sky-800 mb-2 flex items-center gap-2">
                <x-heroicon-o-chart-bar class="w-5 h-5 text-sky-700" />
                Penjualan
            </h3>
            <canvas id="salesChart" height="100"></canvas>

            {{-- Chart.js Script --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Figma', 'Sketch', 'XD', 'Corel', 'InDesign', 'Canva', 'Webflow', 'Affinity', 'Marker'],
                        datasets: [
                            {
                                label: '2020',
                                data: [20, 40, 35, 55, 25, 35, 70, 60, 30],
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                                tension: 0.4
                            },
                            {
                                label: '2021',
                                data: [30, 50, 60, 40, 65, 45, 75, 85, 70],
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                                tension: 0.4
                            },
                            {
                                label: '2022',
                                data: [60, 70, 65, 80, 55, 60, 90, 95, 85],
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
                });
            </script>
        </x-filament::card>

    </div>
</x-filament::page>
