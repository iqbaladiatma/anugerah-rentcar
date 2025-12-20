<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicVehicleController;
use App\Http\Controllers\Auth\UnifiedLoginController;
use App\Http\Controllers\HomeController;

// Public routes - Homepage with auto-redirect for authenticated users
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kendaraan', [PublicVehicleController::class, 'catalog'])->name('vehicles.catalog');
Route::get('/kendaraan/{car}', [PublicVehicleController::class, 'show'])->name('vehicles.show');
Route::post('/kendaraan/cari', [PublicVehicleController::class, 'search'])->name('vehicles.search');
Route::post('/kendaraan/cek-ketersediaan', [PublicVehicleController::class, 'checkAvailability'])->name('vehicles.check-availability');

// Static pages
Route::view('/syarat-ketentuan', 'pages.terms')->name('terms');
Route::view('/dukungan', 'pages.support')->name('public.support');

// Unified Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [UnifiedLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/masuk', [UnifiedLoginController::class, 'login']);
});

Route::post('/keluar', [UnifiedLoginController::class, 'logout'])->name('logout')->middleware('auth');

// Booking wizard routes - Requires authentication and completed profile (KYC)
Route::middleware(['auth:customer', 'profile.complete'])->group(function () {
    Route::get('/pemesanan/wizard', [\App\Http\Controllers\BookingWizardController::class, 'start'])->name('booking.wizard');
    Route::post('/pemesanan/selesai', [\App\Http\Controllers\BookingWizardController::class, 'complete'])->name('booking.complete');
    Route::get('/pemesanan/{booking}/konfirmasi', [\App\Http\Controllers\BookingWizardController::class, 'confirmation'])->name('booking.confirmation');
});

// Customer routes (now using unified auth)
Route::prefix('pelanggan')->name('customer.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/daftar', [\App\Http\Controllers\Customer\AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/daftar', [\App\Http\Controllers\Customer\AuthController::class, 'register']);
    });

    // Complete profile routes (auth required, no profile.complete middleware)
    Route::middleware('auth:customer')->group(function () {
        Route::get('/lengkapi-profil', [\App\Http\Controllers\Customer\CompleteProfileController::class, 'show'])
            ->name('complete-profile');
        Route::post('/lengkapi-profil', [\App\Http\Controllers\Customer\CompleteProfileController::class, 'update'])
            ->name('complete-profile.update');
        
        // Logout route (accessible to all authenticated customers)
        Route::post('/keluar', [\App\Http\Controllers\Customer\AuthController::class, 'logout'])
            ->name('logout');
    });

    // Protected customer routes (require completed profile)
    Route::middleware(['auth:customer', 'profile.complete'])->group(function () {
        Route::get('/dasbor', [\App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/pemesanan', [\App\Http\Controllers\Customer\DashboardController::class, 'bookings'])->name('bookings');
        Route::get('/pemesanan/{booking}', [\App\Http\Controllers\Customer\DashboardController::class, 'showBooking'])->name('bookings.show');
        Route::get('/pemesanan/{booking}/ubah', [\App\Http\Controllers\Customer\DashboardController::class, 'editBooking'])->name('bookings.edit');
        Route::patch('/pemesanan/{booking}', [\App\Http\Controllers\Customer\DashboardController::class, 'updateBooking'])->name('bookings.update');
        Route::delete('/pemesanan/{booking}', [\App\Http\Controllers\Customer\DashboardController::class, 'cancelBooking'])->name('bookings.cancel');
        Route::get('/pemesanan/{booking}/tiket', [\App\Http\Controllers\Customer\DashboardController::class, 'downloadTicket'])->name('bookings.ticket');
        Route::get('/pemesanan/{booking}/pembayaran', [\App\Http\Controllers\Customer\DashboardController::class, 'showPayment'])->name('bookings.payment');
        Route::post('/pemesanan/{booking}/pembayaran', [\App\Http\Controllers\Customer\DashboardController::class, 'submitPayment'])->name('bookings.payment.submit');
        Route::get('/profil', [\App\Http\Controllers\Customer\DashboardController::class, 'profile'])->name('profile');
        Route::patch('/profil', [\App\Http\Controllers\Customer\DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::get('/dukungan', [\App\Http\Controllers\Customer\DashboardController::class, 'support'])->name('support');
        Route::post('/dukungan', [\App\Http\Controllers\Customer\DashboardController::class, 'submitSupportRequest'])->name('support.submit');
    });
});

Route::view('dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Vehicle Management Routes
    Route::resource('kendaraan', \App\Http\Controllers\VehicleController::class, [
        'names' => [
            'index' => 'vehicles.index',
            'create' => 'vehicles.create',
            'store' => 'vehicles.store',
            'show' => 'vehicles.show',
            'edit' => 'vehicles.edit',
            'update' => 'vehicles.update',
            'destroy' => 'vehicles.destroy',
        ],
        'parameters' => [
            'kendaraan' => 'vehicle'
        ]
    ]);
    Route::patch('/kendaraan/{car}/status', [\App\Http\Controllers\VehicleController::class, 'updateStatus'])->name('vehicles.update-status');
    Route::get('/kendaraan/perawatan/jatuh-tempo', [\App\Http\Controllers\VehicleController::class, 'maintenanceDue'])->name('vehicles.maintenance-due');
    
    // Customer Management Routes
    Route::get('/pelanggan/anggota', [\App\Http\Controllers\CustomerController::class, 'members'])->name('customers.members');
    Route::get('/pelanggan/daftar-hitam', [\App\Http\Controllers\CustomerController::class, 'blacklist'])->name('customers.blacklist');
    Route::get('/pelanggan/cari', [\App\Http\Controllers\CustomerController::class, 'search'])->name('customers.search');
    Route::patch('/pelanggan/{customer}/status-anggota', [\App\Http\Controllers\CustomerController::class, 'updateMemberStatus'])->name('customers.update-member-status');
    Route::patch('/pelanggan/{customer}/status-daftar-hitam', [\App\Http\Controllers\CustomerController::class, 'updateBlacklistStatus'])->name('customers.update-blacklist-status');
    Route::get('/pelanggan/{customer}/validasi-pemesanan', [\App\Http\Controllers\CustomerController::class, 'validateForBooking'])->name('customers.validate-booking');
    Route::resource('pelanggan', \App\Http\Controllers\CustomerController::class, [
        'names' => [
            'index' => 'customers.index',
            'create' => 'customers.create',
            'store' => 'customers.store',
            'show' => 'customers.show',
            'edit' => 'customers.edit',
            'update' => 'customers.update',
            'destroy' => 'customers.destroy',
        ],
        'parameters' => [
            'pelanggan' => 'customer'
        ]
    ]);
    
    // Booking Management Routes
    Route::resource('pemesanan', \App\Http\Controllers\BookingController::class, ['names' => [
        'index' => 'bookings.index',
        'create' => 'bookings.create',
        'store' => 'bookings.store',
        'show' => 'bookings.show',
        'edit' => 'bookings.edit',
        'update' => 'bookings.update',
        'destroy' => 'bookings.destroy',
    ]]);
    Route::patch('/pemesanan/{booking}/konfirmasi', [\App\Http\Controllers\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('/pemesanan/{booking}/aktifkan', [\App\Http\Controllers\BookingController::class, 'activate'])->name('bookings.activate');
    Route::patch('/pemesanan/{booking}/selesai', [\App\Http\Controllers\BookingController::class, 'complete'])->name('bookings.complete');
    Route::patch('/pemesanan/{booking}/batal', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::patch('/pemesanan/{booking}/setujui-pembayaran', [\App\Http\Controllers\BookingController::class, 'approvePayment'])->name('bookings.approve-payment');
    Route::patch('/pemesanan/{booking}/tolak-pembayaran', [\App\Http\Controllers\BookingController::class, 'rejectPayment'])->name('bookings.reject-payment');
    Route::post('/pemesanan/hitung-harga', [\App\Http\Controllers\BookingController::class, 'calculatePrice'])->name('bookings.calculate-price');
    Route::post('/pemesanan/cek-ketersediaan', [\App\Http\Controllers\BookingController::class, 'checkAvailability'])->name('bookings.check-availability');
    Route::get('/pemesanan/cari/api', [\App\Http\Controllers\BookingController::class, 'search'])->name('bookings.search');
    Route::get('/pemesanan/statistik/api', [\App\Http\Controllers\BookingController::class, 'statistics'])->name('bookings.statistics');
    Route::get('/pemesanan/sopir/tersedia', [\App\Http\Controllers\BookingController::class, 'getAvailableDrivers'])->name('bookings.available-drivers');
    
    // Key Handover Routes
    Route::get('/pemesanan/{booking}/serah-kunci', [\App\Http\Controllers\BookingController::class, 'serahKunci'])->name('bookings.serah-kunci');
    Route::post('/pemesanan/{booking}/serah-kunci', [\App\Http\Controllers\BookingController::class, 'storeSerahKunci'])->name('bookings.serah-kunci.store');
    Route::get('/pemesanan/{booking}/terima-kunci', [\App\Http\Controllers\BookingController::class, 'terimaKunci'])->name('bookings.terima-kunci');
    Route::post('/pemesanan/{booking}/terima-kunci', [\App\Http\Controllers\BookingController::class, 'storeTerimaKunci'])->name('bookings.terima-kunci.store');
    
    // Maintenance Management Routes
    Route::resource('perawatan', \App\Http\Controllers\MaintenanceController::class, ['names' => [
        'index' => 'maintenance.index',
        'create' => 'maintenance.create',
        'store' => 'maintenance.store',
        'show' => 'maintenance.show',
        'edit' => 'maintenance.edit',
        'update' => 'maintenance.update',
        'destroy' => 'maintenance.destroy',
    ]]);
    Route::get('/perawatan/pengingat/api', [\App\Http\Controllers\MaintenanceController::class, 'getReminders'])->name('maintenance.reminders');
    Route::post('/perawatan/jadwal', [\App\Http\Controllers\MaintenanceController::class, 'schedule'])->name('maintenance.schedule');
    Route::get('/perawatan/analitik/api', [\App\Http\Controllers\MaintenanceController::class, 'analytics'])->name('maintenance.analytics');
    Route::get('/perawatan/ekspor', [\App\Http\Controllers\MaintenanceController::class, 'export'])->name('maintenance.export');
    Route::get('/perawatan/kendaraan/{car}/riwayat', [\App\Http\Controllers\MaintenanceController::class, 'carHistory'])->name('maintenance.car-history');
    Route::patch('/perawatan/{maintenance}/selesai', [\App\Http\Controllers\MaintenanceController::class, 'markCompleted'])->name('maintenance.complete');
    Route::get('/ketersediaan/timeline', function () { return view('admin.availability.timeline'); })->name('availability.timeline');
    Route::get('/pemesanan/{booking}/checkout', [\App\Http\Controllers\BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::get('/pemesanan/{booking}/checkin', [\App\Http\Controllers\BookingController::class, 'checkin'])->name('bookings.checkin');
    
    // Expense Management Routes
    Route::get('/pengeluaran/analitik/tampilan', function () { return view('admin.expenses.analytics'); })->name('expenses.analytics-view');
    Route::get('/pengeluaran/ringkasan/bulanan', [\App\Http\Controllers\ExpenseController::class, 'monthlySummary'])->name('expenses.monthly-summary');
    Route::get('/pengeluaran/ringkasan/tahunan', [\App\Http\Controllers\ExpenseController::class, 'yearlySummary'])->name('expenses.yearly-summary');
    Route::get('/pengeluaran/perbandingan/api', [\App\Http\Controllers\ExpenseController::class, 'comparison'])->name('expenses.comparison');
    Route::get('/pengeluaran/analitik/api', [\App\Http\Controllers\ExpenseController::class, 'analytics'])->name('expenses.analytics');
    Route::get('/pengeluaran/profitabilitas/api', [\App\Http\Controllers\ExpenseController::class, 'profitability'])->name('expenses.profitability');
    Route::get('/pengeluaran/cari/api', [\App\Http\Controllers\ExpenseController::class, 'search'])->name('expenses.search');

    Route::resource('pengeluaran', \App\Http\Controllers\ExpenseController::class, ['names' => [
        'index' => 'expenses.index',
        'create' => 'expenses.create',
        'store' => 'expenses.store',
        'show' => 'expenses.show',
        'edit' => 'expenses.edit',
        'update' => 'expenses.update',
        'destroy' => 'expenses.destroy',
    ]]);
    
    // Report Management Routes
    Route::get('/laporan', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/laporan/pelanggan', [\App\Http\Controllers\ReportController::class, 'customerReport'])->name('reports.customer');
    Route::get('/laporan/keuangan', [\App\Http\Controllers\ReportController::class, 'financialReport'])->name('reports.financial');
    Route::get('/laporan/kendaraan', [\App\Http\Controllers\ReportController::class, 'vehicleReport'])->name('reports.vehicle');
    Route::get('/laporan/analitik', [\App\Http\Controllers\ReportController::class, 'analyticsReport'])->name('reports.analytics');
    Route::get('/laporan/profitabilitas', [\App\Http\Controllers\ReportController::class, 'profitabilityReport'])->name('reports.profitability');
    Route::get('/laporan/nilai-pelanggan', [\App\Http\Controllers\ReportController::class, 'customerLTVReport'])->name('reports.customer-ltv');
    
    // Export Management Routes
    Route::post('/laporan/ekspor-batch', [\App\Http\Controllers\ReportController::class, 'batchExport'])->name('reports.batch-export');
    Route::post('/laporan/jadwal-ekspor', [\App\Http\Controllers\ReportController::class, 'scheduleExport'])->name('reports.schedule-export');
    Route::get('/laporan/riwayat-ekspor', [\App\Http\Controllers\ReportController::class, 'exportHistory'])->name('reports.export-history');
    
    // Settings Management Routes
    Route::get('/pengaturan/perusahaan', [\App\Http\Controllers\SettingsController::class, 'company'])->name('settings.company');
    Route::get('/pengaturan/pengguna', [\App\Http\Controllers\SettingsController::class, 'users'])->name('settings.users');
    Route::get('/pengaturan/harga', [\App\Http\Controllers\SettingsController::class, 'pricing'])->name('settings.pricing');
    
    // Super Admin Only Routes
    Route::middleware('super.admin')->group(function () {
        Route::get('/pengaturan/sistem', [\App\Http\Controllers\SettingsController::class, 'system'])->name('settings.system');
    });
    
    // Settings API Routes
    Route::post('/pengaturan/perusahaan', [\App\Http\Controllers\SettingsController::class, 'updateCompany'])->name('settings.update-company');
    Route::post('/pengaturan/harga', [\App\Http\Controllers\SettingsController::class, 'updatePricing'])->name('settings.update-pricing');
    Route::get('/pengaturan/pengguna/daftar', [\App\Http\Controllers\SettingsController::class, 'getUsersList'])->name('settings.users-list');
    Route::post('/pengaturan/pengguna', [\App\Http\Controllers\SettingsController::class, 'createUser'])->name('settings.create-user');
    Route::patch('/pengaturan/pengguna/{user}', [\App\Http\Controllers\SettingsController::class, 'updateUser'])->name('settings.update-user');
    Route::delete('/pengaturan/pengguna/{user}', [\App\Http\Controllers\SettingsController::class, 'deleteUser'])->name('settings.delete-user');
    Route::patch('/pengaturan/pengguna/{user}/ubah-status', [\App\Http\Controllers\SettingsController::class, 'toggleUserStatus'])->name('settings.toggle-user-status');
    
    // Notification Management Routes
    Route::get('/notifikasi', function () { return view('admin.notifications.index'); })->name('notifications.index');
    Route::get('/notifikasi/preferensi', function () { return view('admin.notifications.preferences'); })->name('notifications.preferences');
    Route::post('/notifikasi/{notification}/baca', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifikasi/tandai-semua-dibaca', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifikasi/jumlah-belum-dibaca', [\App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::post('/notifikasi/buat', [\App\Http\Controllers\NotificationController::class, 'generate'])->name('notifications.generate');
    
    // Super Admin Routes
    Route::middleware('super.admin')->group(function () {
        Route::get('/super-admin', \App\Livewire\Admin\SuperAdminDashboard::class)->name('super-admin.dashboard');
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
