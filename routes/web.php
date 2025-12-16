<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicVehicleController;
use App\Http\Controllers\Auth\UnifiedLoginController;

// Public routes
Route::view('/', 'public.home')->name('home');
Route::get('/vehicles', [PublicVehicleController::class, 'catalog'])->name('vehicles.catalog');
Route::get('/vehicles/{car}', [PublicVehicleController::class, 'show'])->name('vehicles.show');
Route::post('/vehicles/search', [PublicVehicleController::class, 'search'])->name('vehicles.search');
Route::post('/vehicles/check-availability', [PublicVehicleController::class, 'checkAvailability'])->name('vehicles.check-availability');

// Unified Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [UnifiedLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UnifiedLoginController::class, 'login']);
});

Route::post('/logout', [UnifiedLoginController::class, 'logout'])->name('logout')->middleware('auth');

// Booking wizard routes
Route::get('/booking/wizard', [\App\Http\Controllers\BookingWizardController::class, 'start'])->name('booking.wizard');
Route::post('/booking/complete', [\App\Http\Controllers\BookingWizardController::class, 'complete'])->name('booking.complete');
Route::get('/booking/{booking}/confirmation', [\App\Http\Controllers\BookingWizardController::class, 'confirmation'])->name('booking.confirmation');

// Customer routes (now using unified auth)
Route::prefix('customer')->name('customer.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/register', [\App\Http\Controllers\Customer\AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [\App\Http\Controllers\Customer\AuthController::class, 'register']);
    });

    // Complete profile routes (auth required, no profile.complete middleware)
    Route::middleware('auth:customer')->group(function () {
        Route::get('/complete-profile', [\App\Http\Controllers\Customer\CompleteProfileController::class, 'show'])
            ->name('complete-profile');
        Route::post('/complete-profile', [\App\Http\Controllers\Customer\CompleteProfileController::class, 'update'])
            ->name('complete-profile.update');
        
        // Logout route (accessible to all authenticated customers)
        Route::post('/logout', [\App\Http\Controllers\Customer\AuthController::class, 'logout'])
            ->name('logout');
    });

    // Protected customer routes (require completed profile)
    Route::middleware(['auth:customer', 'profile.complete'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/bookings', [\App\Http\Controllers\Customer\DashboardController::class, 'bookings'])->name('bookings');
        Route::get('/bookings/{booking}', [\App\Http\Controllers\Customer\DashboardController::class, 'showBooking'])->name('bookings.show');
        Route::get('/bookings/{booking}/edit', [\App\Http\Controllers\Customer\DashboardController::class, 'editBooking'])->name('bookings.edit');
        Route::patch('/bookings/{booking}', [\App\Http\Controllers\Customer\DashboardController::class, 'updateBooking'])->name('bookings.update');
        Route::delete('/bookings/{booking}', [\App\Http\Controllers\Customer\DashboardController::class, 'cancelBooking'])->name('bookings.cancel');
        Route::get('/bookings/{booking}/ticket', [\App\Http\Controllers\Customer\DashboardController::class, 'downloadTicket'])->name('bookings.ticket');
        Route::get('/profile', [\App\Http\Controllers\Customer\DashboardController::class, 'profile'])->name('profile');
        Route::patch('/profile', [\App\Http\Controllers\Customer\DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::get('/support', [\App\Http\Controllers\Customer\DashboardController::class, 'support'])->name('support');
        Route::post('/support', [\App\Http\Controllers\Customer\DashboardController::class, 'submitSupportRequest'])->name('support.submit');
    });
});

Route::view('dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Vehicle Management Routes
    Route::resource('vehicles', \App\Http\Controllers\VehicleController::class);
    Route::patch('/vehicles/{car}/status', [\App\Http\Controllers\VehicleController::class, 'updateStatus'])->name('vehicles.update-status');
    Route::get('/vehicles/maintenance/due', [\App\Http\Controllers\VehicleController::class, 'maintenanceDue'])->name('vehicles.maintenance-due');
    
    // Customer Management Routes
    Route::get('/customers/members', [\App\Http\Controllers\CustomerController::class, 'members'])->name('customers.members');
    Route::get('/customers/blacklist', [\App\Http\Controllers\CustomerController::class, 'blacklist'])->name('customers.blacklist');
    Route::get('/customers/search', [\App\Http\Controllers\CustomerController::class, 'search'])->name('customers.search');
    Route::patch('/customers/{customer}/member-status', [\App\Http\Controllers\CustomerController::class, 'updateMemberStatus'])->name('customers.update-member-status');
    Route::patch('/customers/{customer}/blacklist-status', [\App\Http\Controllers\CustomerController::class, 'updateBlacklistStatus'])->name('customers.update-blacklist-status');
    Route::get('/customers/{customer}/validate-booking', [\App\Http\Controllers\CustomerController::class, 'validateForBooking'])->name('customers.validate-booking');
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    
    // Booking Management Routes
    Route::resource('bookings', \App\Http\Controllers\BookingController::class);
    Route::patch('/bookings/{booking}/confirm', [\App\Http\Controllers\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('/bookings/{booking}/activate', [\App\Http\Controllers\BookingController::class, 'activate'])->name('bookings.activate');
    Route::patch('/bookings/{booking}/complete', [\App\Http\Controllers\BookingController::class, 'complete'])->name('bookings.complete');
    Route::patch('/bookings/{booking}/cancel', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/calculate-price', [\App\Http\Controllers\BookingController::class, 'calculatePrice'])->name('bookings.calculate-price');
    Route::post('/bookings/check-availability', [\App\Http\Controllers\BookingController::class, 'checkAvailability'])->name('bookings.check-availability');
    Route::get('/bookings/search/api', [\App\Http\Controllers\BookingController::class, 'search'])->name('bookings.search');
    Route::get('/bookings/statistics/api', [\App\Http\Controllers\BookingController::class, 'statistics'])->name('bookings.statistics');
    Route::get('/bookings/drivers/available', [\App\Http\Controllers\BookingController::class, 'getAvailableDrivers'])->name('bookings.available-drivers');
    
    // Maintenance Management Routes
    Route::resource('maintenance', \App\Http\Controllers\MaintenanceController::class);
    Route::get('/maintenance/reminders/api', [\App\Http\Controllers\MaintenanceController::class, 'getReminders'])->name('maintenance.reminders');
    Route::post('/maintenance/schedule', [\App\Http\Controllers\MaintenanceController::class, 'schedule'])->name('maintenance.schedule');
    Route::get('/maintenance/analytics/api', [\App\Http\Controllers\MaintenanceController::class, 'analytics'])->name('maintenance.analytics');
    Route::get('/maintenance/export', [\App\Http\Controllers\MaintenanceController::class, 'export'])->name('maintenance.export');
    Route::get('/maintenance/car/{car}/history', [\App\Http\Controllers\MaintenanceController::class, 'carHistory'])->name('maintenance.car-history');
    Route::patch('/maintenance/{maintenance}/complete', [\App\Http\Controllers\MaintenanceController::class, 'markCompleted'])->name('maintenance.complete');
    Route::get('/availability/timeline', function () { return view('admin.availability.timeline'); })->name('availability.timeline');
    Route::get('/bookings/{booking}/checkout', [\App\Http\Controllers\BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::get('/bookings/{booking}/checkin', [\App\Http\Controllers\BookingController::class, 'checkin'])->name('bookings.checkin');
    // Expense Management Routes
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
    Route::get('/expenses/analytics/view', function () { return view('admin.expenses.analytics'); })->name('expenses.analytics-view');
    Route::get('/expenses/summary/monthly', [\App\Http\Controllers\ExpenseController::class, 'monthlySummary'])->name('expenses.monthly-summary');
    Route::get('/expenses/summary/yearly', [\App\Http\Controllers\ExpenseController::class, 'yearlySummary'])->name('expenses.yearly-summary');
    Route::get('/expenses/comparison/api', [\App\Http\Controllers\ExpenseController::class, 'comparison'])->name('expenses.comparison');
    Route::get('/expenses/analytics/api', [\App\Http\Controllers\ExpenseController::class, 'analytics'])->name('expenses.analytics');
    Route::get('/expenses/profitability/api', [\App\Http\Controllers\ExpenseController::class, 'profitability'])->name('expenses.profitability');
    Route::get('/expenses/search/api', [\App\Http\Controllers\ExpenseController::class, 'search'])->name('expenses.search');
    // Report Management Routes
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/customer', [\App\Http\Controllers\ReportController::class, 'customerReport'])->name('reports.customer');
    Route::get('/reports/financial', [\App\Http\Controllers\ReportController::class, 'financialReport'])->name('reports.financial');
    Route::get('/reports/vehicle', [\App\Http\Controllers\ReportController::class, 'vehicleReport'])->name('reports.vehicle');
    Route::get('/reports/analytics', [\App\Http\Controllers\ReportController::class, 'analyticsReport'])->name('reports.analytics');
    Route::get('/reports/profitability', [\App\Http\Controllers\ReportController::class, 'profitabilityReport'])->name('reports.profitability');
    Route::get('/reports/customer-ltv', [\App\Http\Controllers\ReportController::class, 'customerLTVReport'])->name('reports.customer-ltv');
    
    // Export Management Routes
    Route::post('/reports/batch-export', [\App\Http\Controllers\ReportController::class, 'batchExport'])->name('reports.batch-export');
    Route::post('/reports/schedule-export', [\App\Http\Controllers\ReportController::class, 'scheduleExport'])->name('reports.schedule-export');
    Route::get('/reports/export-history', [\App\Http\Controllers\ReportController::class, 'exportHistory'])->name('reports.export-history');
    // Settings Management Routes
    Route::get('/settings/company', [\App\Http\Controllers\SettingsController::class, 'company'])->name('settings.company');
    Route::get('/settings/users', [\App\Http\Controllers\SettingsController::class, 'users'])->name('settings.users');
    Route::get('/settings/pricing', [\App\Http\Controllers\SettingsController::class, 'pricing'])->name('settings.pricing');
    Route::get('/settings/system', [\App\Http\Controllers\SettingsController::class, 'system'])->name('settings.system');
    
    // Settings API Routes
    Route::post('/settings/company', [\App\Http\Controllers\SettingsController::class, 'updateCompany'])->name('settings.update-company');
    Route::post('/settings/pricing', [\App\Http\Controllers\SettingsController::class, 'updatePricing'])->name('settings.update-pricing');
    Route::get('/settings/users/list', [\App\Http\Controllers\SettingsController::class, 'getUsersList'])->name('settings.users-list');
    Route::post('/settings/users', [\App\Http\Controllers\SettingsController::class, 'createUser'])->name('settings.create-user');
    Route::patch('/settings/users/{user}', [\App\Http\Controllers\SettingsController::class, 'updateUser'])->name('settings.update-user');
    Route::delete('/settings/users/{user}', [\App\Http\Controllers\SettingsController::class, 'deleteUser'])->name('settings.delete-user');
    Route::patch('/settings/users/{user}/toggle-status', [\App\Http\Controllers\SettingsController::class, 'toggleUserStatus'])->name('settings.toggle-user-status');
    
    // Notification Management Routes
    Route::get('/notifications', function () { return view('admin.notifications.index'); })->name('notifications.index');
    Route::get('/notifications/preferences', function () { return view('admin.notifications.preferences'); })->name('notifications.preferences');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/generate', [\App\Http\Controllers\NotificationController::class, 'generate'])->name('notifications.generate');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
