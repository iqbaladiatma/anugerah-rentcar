<x-admin-layout>
        <!-- Vehicle Status -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            {{ ucfirst($car->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Vehicle Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Kendaraan</h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Plat Nomor</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $car->license_plate }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Merek & Model</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $car->brand }} {{ $car->model }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tahun</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $car->year }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Warna</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $car->color }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Pricing Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Harga</h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tarif Harian</dt>
                                <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($car->daily_rate, 0, ',', '.') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tarif Mingguan</dt>
                                <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($car->weekly_rate, 0, ',', '.') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Biaya Sopir/Hari</dt>
                                <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($car->driver_fee_per_day, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Recent Bookings -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Pemesanan Terbaru</h3>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-sm text-gray-500">Tidak ada pemesanan terbaru</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>