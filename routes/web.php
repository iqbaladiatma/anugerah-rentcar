<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

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
    Route::get('/reports', function () { return view('admin.dashboard'); })->name('reports.index');
    Route::get('/reports/profit', function () { return view('admin.dashboard'); })->name('reports.profit');
    Route::get('/settings/company', function () { return view('admin.dashboard'); })->name('settings.company');
    Route::get('/settings/users', function () { return view('admin.dashboard'); })->name('settings.users');
    Route::get('/settings/pricing', function () { return view('admin.dashboard'); })->name('settings.pricing');
    Route::get('/settings/system', function () { return view('admin.dashboard'); })->name('settings.system');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
