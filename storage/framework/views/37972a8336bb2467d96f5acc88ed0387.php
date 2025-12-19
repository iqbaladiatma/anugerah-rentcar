<?php if (isset($component)) { $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06 = $attributes; } ?>
<?php $component = App\View\Components\PublicLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PublicLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="bg-white min-h-screen">
        <!-- Breadcrumb -->
        <div class="bg-secondary-50 border-b border-secondary-100">
            <div class="container-custom py-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <a href="<?php echo e(route('home')); ?>" class="text-secondary-500 hover:text-accent-500 transition-colors p-2 rounded-lg hover:bg-accent-50">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <a href="<?php echo e(route('vehicles.catalog')); ?>" class="ml-4 text-sm font-medium text-secondary-600 hover:text-accent-500 transition-colors px-2 py-1 rounded-lg hover:bg-accent-50">
                                    Kendaraan
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-4 text-sm font-semibold text-secondary-900 px-2 py-1 bg-accent-100 rounded-lg"><?php echo e($car->brand); ?> <?php echo e($car->model); ?></span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-custom section-padding-sm">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Vehicle Images and Details -->
                <div class="lg:col-span-2">
                    <!-- Image Gallery -->
                    <div class="mb-8 animate-fade-in">
                        <div class="grid grid-cols-1 gap-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car->photo_front): ?>
                                <div class="relative overflow-hidden rounded-2xl shadow-medium hover:shadow-large transition-all duration-300">
                                    <img src="<?php echo e(asset('storage/' . $car->photo_front)); ?>" 
                                         alt="<?php echo e($car->brand); ?> <?php echo e($car->model); ?> - Front"
                                         class="w-full h-96 lg:h-[500px] object-cover hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-secondary-900/20 to-transparent"></div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car->photo_side || $car->photo_back): ?>
                                <div class="grid grid-cols-2 gap-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car->photo_side): ?>
                                        <img src="<?php echo e(asset('storage/' . $car->photo_side)); ?>" 
                                             alt="<?php echo e($car->brand); ?> <?php echo e($car->model); ?> - Side"
                                             class="w-full h-48 object-cover rounded-lg shadow-md">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car->photo_back): ?>
                                        <img src="<?php echo e(asset('storage/' . $car->photo_back)); ?>" 
                                             alt="<?php echo e($car->brand); ?> <?php echo e($car->model); ?> - Back"
                                             class="w-full h-48 object-cover rounded-lg shadow-md">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <!-- Vehicle Information -->
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
                        <div class="mb-6">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo e($car->brand); ?> <?php echo e($car->model); ?></h1>
                            <p class="text-lg text-gray-600"><?php echo e($car->year); ?> • <?php echo e($car->color); ?> • <?php echo e($car->license_plate); ?></p>
                        </div>

                        <!-- Vehicle Features -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Fitur Kendaraan</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Kondisi Udara
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Transmisi Manual
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    5 Kursi
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Steer
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Sistem Audio
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car->driver_fee_per_day > 0): ?>
                                    <div class="flex items-center text-sm text-accent-600">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        Driver Tersedia
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <!-- Pricing Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Harga</h3>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <div class="text-2xl font-bold text-accent-600 mb-1">
                                            Rp <?php echo e(number_format($car->daily_rate, 0, ',', '.')); ?>

                                        </div>
                                        <p class="text-sm text-gray-600">Per Hari</p>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car->weekly_rate && $car->weekly_rate < ($car->daily_rate * 7)): ?>
                                        <div>
                                            <div class="text-xl font-bold text-green-600 mb-1">
                                                Rp <?php echo e(number_format($car->weekly_rate, 0, ',', '.')); ?>

                                            </div>
                                            <p class="text-sm text-gray-600">Per Pekan (Save <?php echo e(number_format(($car->daily_rate * 7) - $car->weekly_rate, 0, ',', '.')); ?>)</p>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car->driver_fee_per_day > 0): ?>
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <p class="text-sm text-gray-600">
                                            Driver fee: <span class="font-medium">Rp <?php echo e(number_format($car->driver_fee_per_day, 0, ',', '.')); ?>/day</span>
                                        </p>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Syarat & Ketentuan</h3>
                            <div class="text-sm text-gray-600 space-y-2">
                                <p>• SIM yang valid</p>
                                <p>• Minimum umur 21 tahun</p>
                                <p>• Deposit diperlukan untuk konfirmasi pemesanan</p>
                                <p>• Bensin harus dikembalikan pada level yang sama</p>
                                <p>• Denda dikenakan setelah periode grace</p>
                                <p>• Pemeriksaan kendaraan diperlukan saat pengambilan dan pengembalian</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Panel -->
                <div class="lg:col-span-1 mt-8 lg:mt-0">
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 sticky top-4">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Booking Kendaraan</h3>
                        
                        <form action="<?php echo e(route('booking.wizard')); ?>" method="GET" class="space-y-6">
                            <input type="hidden" name="car_id" value="<?php echo e($car->id); ?>">
                            
                            <!-- Date Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengambilan</label>
                                <input type="date" name="start_date" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                                       min="<?php echo e(date('Y-m-d')); ?>" 
                                       value="<?php echo e(request('start_date', date('Y-m-d'))); ?>"
                                       required id="startDate">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengembalian</label>
                                <input type="date" name="end_date" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                                       min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" 
                                       value="<?php echo e(request('end_date', date('Y-m-d', strtotime('+1 day')))); ?>"
                                       required id="endDate">
                            </div>

                            <!-- Availability Status -->
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium text-green-800">Tersedia untuk Booking</span>
                                </div>
                            </div>

                            <!-- Pricing Preview -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-medium text-gray-900 mb-3">Biaya yang Diperkirakan</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Harga Harian</span>
                                        <span class="font-medium">Rp <?php echo e(number_format($car->daily_rate, 0, ',', '.')); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Durasi</span>
                                        <span class="font-medium" id="durationDisplay">1 hari</span>
                                    </div>
                                    <div class="border-t pt-2">
                                        <div class="flex justify-between font-semibold">
                                            <span>Total yang Diperkirakan</span>
                                            <span class="text-accent-600" id="totalDisplay">Rp <?php echo e(number_format($car->daily_rate, 0, ',', '.')); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    *Biaya akhir mungkin berubah berdasarkan layanan tambahan dan diskon
                                </p>
                            </div>

                            <!-- Book Now Button -->
                            <button type="submit" 
                                    class="w-full bg-accent-500 text-white py-4 px-6 rounded-lg hover:bg-accent-600 transition-colors font-semibold text-lg shadow-md hover:shadow-lg">
                                Booking Sekarang
                            </button>

                            <!-- Contact Info -->
                            <div class="text-center pt-4 border-t border-gray-200">
                                <p class="text-sm text-gray-600 mb-2">Butuh bantuan? Hubungi kami:</p>
                                <div class="space-y-1">
                                    <a href="tel:+6281234567890" class="flex items-center justify-center text-sm text-accent-600 hover:text-accent-700">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                        </svg>
                                        +62 897-7777-451
                                    </a>
                                    <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center justify-center text-sm text-green-600 hover:text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                        </svg>
                                        WhatsApp
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Calculate duration and pricing
        function updatePricing() {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);
            
            if (startDate && endDate && endDate > startDate) {
                const duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                const dailyRate = <?php echo e($car->daily_rate); ?>;
                const weeklyRate = <?php echo e($car->weekly_rate ?? 0); ?>;
                
                let totalPrice = dailyRate * duration;
                
                // Apply weekly rate if applicable
                if (duration >= 7 && weeklyRate > 0) {
                    const weeks = Math.floor(duration / 7);
                    const remainingDays = duration % 7;
                    totalPrice = (weeklyRate * weeks) + (dailyRate * remainingDays);
                }
                
                document.getElementById('durationDisplay').textContent = duration + (duration === 1 ? ' day' : ' days');
                document.getElementById('totalDisplay').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
            }
        }

        // Auto-update end date when start date changes
        document.getElementById('startDate').addEventListener('change', function() {
            const startDate = new Date(this.value);
            const endDateInput = document.getElementById('endDate');
            const currentEndDate = new Date(endDateInput.value);
            
            // If end date is before or same as start date, set it to start date + 1 day
            if (!endDateInput.value || currentEndDate <= startDate) {
                const nextDay = new Date(startDate);
                nextDay.setDate(nextDay.getDate() + 1);
                endDateInput.value = nextDay.toISOString().split('T')[0];
            }
            
            // Update minimum date for end date
            endDateInput.min = this.value;
            updatePricing();
        });

        document.getElementById('endDate').addEventListener('change', updatePricing);

        // Initial pricing calculation
        updatePricing();
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $attributes = $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $component = $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/public/vehicles/show.blade.php ENDPATH**/ ?>