<?php

use App\Models\Customer;
use App\Models\User;
use App\Models\Notification;
use App\Events\CustomerCreated;

// Test 1: Cek jumlah admin
$adminCount = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
    ->where('is_active', true)
    ->count();
echo "Jumlah admin/staff aktif: $adminCount\n";

// Test 2: Ambil customer terakhir
$customer = Customer::latest()->first();
if ($customer) {
    echo "Customer terakhir: {$customer->name} (ID: {$customer->id})\n";
    
    // Test 3: Dispatch event
    echo "Dispatching CustomerCreated event...\n";
    CustomerCreated::dispatch($customer);
    
    // Test 4: Cek notifikasi yang dibuat
    sleep(2); // Tunggu sebentar untuk listener
    $notifications = Notification::where('type', 'new_customer')
        ->where('notifiable_id', $customer->id)
        ->get();
    
    echo "Notifikasi dibuat: " . $notifications->count() . "\n";
    
    if ($notifications->count() > 0) {
        foreach ($notifications as $notif) {
            echo "  - User ID: {$notif->user_id}, Title: {$notif->title}\n";
        }
    } else {
        echo "MASALAH: Tidak ada notifikasi yang dibuat!\n";
        echo "Cek apakah listener berjalan dengan benar.\n";
    }
} else {
    echo "Tidak ada customer di database\n";
}
