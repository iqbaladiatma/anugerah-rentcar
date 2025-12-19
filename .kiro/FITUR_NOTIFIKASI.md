# 🔔 Fitur Notifikasi - Anugerah Rent Car

## Ringkasan
Sistem notifikasi otomatis yang mengirimkan pemberitahuan real-time ke semua admin/staff ketika ada:
- **Pelanggan Baru** - Setiap kali ada customer baru terdaftar
- **Orderan Baru** - Setiap kali ada booking baru dibuat

---

## ✨ Fitur Utama

### 1. Notifikasi Pelanggan Baru
- **Trigger**: Customer baru dibuat (via admin, registrasi, atau booking wizard)
- **Penerima**: Semua admin dan staff yang aktif
- **Prioritas**: Low
- **Icon**: User Plus (👤+)
- **Informasi**: Nama, telepon, dan email pelanggan
- **Action**: Link ke halaman detail customer

### 2. Notifikasi Orderan Baru
- **Trigger**: Booking baru dibuat
- **Penerima**: Semua admin dan staff yang aktif
- **Prioritas**: High (Urgent)
- **Icon**: Shopping Cart (🛒)
- **Informasi**: Nomor booking, nama customer, kendaraan, dan total harga
- **Action**: Link ke halaman detail booking

---

## 📍 Lokasi Notifikasi

### 1. Notification Widget (Navbar)
- **Lokasi**: Header admin (icon lonceng)
- **Fitur**:
  - Badge merah menampilkan jumlah notifikasi belum dibaca
  - Dropdown menampilkan 5 notifikasi terbaru
  - Auto-refresh setiap 30 detik
  - Tombol "Tandai Semua Sudah Dibaca"
  - Link ke Notification Center

### 2. Notification Center
- **Route**: `/admin/notifikasi`
- **Fitur**:
  - Daftar lengkap semua notifikasi
  - Filter berdasarkan:
    - Status (belum dibaca/sudah dibaca)
    - Tipe notifikasi
    - Prioritas
  - Pagination
  - Mark as read individual atau semua
  - Auto-refresh

---

## 🔧 Implementasi Teknis

### File yang Dibuat

#### Events
- `app/Events/CustomerCreated.php` - Event pelanggan baru
- `app/Events/BookingCreated.php` - Event booking baru (sudah ada)

#### Listeners
- `app/Listeners/SendCustomerNotifications.php` - Handler notifikasi pelanggan baru
- `app/Listeners/SendBookingNotifications.php` - Handler notifikasi orderan baru

#### Icons
- `resources/views/components/icons/user-plus.blade.php`
- `resources/views/components/icons/shopping-cart.blade.php`

### File yang Dimodifikasi

#### Models
- `app/Models/Notification.php`
  - Tambah konstanta: `TYPE_NEW_CUSTOMER`, `TYPE_NEW_BOOKING`
  - Tambah icon mapping
  - Tambah methods: `createNewCustomerNotification()`, `createNewBookingNotification()`

#### Service Providers
- `app/Providers/AppServiceProvider.php`
  - Register event listeners

#### Controllers
- `app/Http/Controllers/CustomerController.php` - Dispatch CustomerCreated
- `app/Http/Controllers/BookingController.php` - Dispatch BookingCreated
- `app/Http/Controllers/Customer/AuthController.php` - Dispatch CustomerCreated

#### Livewire Components
- `app/Livewire/Admin/CustomerForm.php` - Dispatch CustomerCreated
- `app/Livewire/Admin/NotificationCenter.php` - Tambah filter tipe baru
- `app/Livewire/BookingWizard.php` - Dispatch events
- `app/Livewire/Public/BookingWizard.php` - Dispatch events

#### Views
- `resources/views/livewire/layout/admin-header.blade.php` - Integrasi NotificationWidget

---

## 🎯 Cara Kerja

### Flow Pelanggan Baru
```
Customer Dibuat → CustomerCreated Event Dispatched
                ↓
SendCustomerNotifications Listener
                ↓
Query Semua Admin/Staff Aktif
                ↓
Buat Notifikasi untuk Setiap Admin
                ↓
Notifikasi Muncul di Widget & Center
```

### Flow Orderan Baru
```
Booking Dibuat → BookingCreated Event Dispatched
               ↓
SendBookingNotifications Listener
               ↓
Query Semua Admin/Staff Aktif
               ↓
Buat Notifikasi untuk Setiap Admin
               ↓
Notifikasi Muncul di Widget & Center
               ↓
Email Konfirmasi ke Customer (jika ada email)
```

---

## 🧪 Testing

### Manual Testing

1. **Test Pelanggan Baru**:
   ```
   - Buat customer baru via admin panel
   - Atau registrasi customer baru via public
   - Cek notification widget (badge harus bertambah)
   - Klik bell icon, lihat notifikasi "Pelanggan Baru"
   ```

2. **Test Orderan Baru**:
   ```
   - Buat booking baru via admin atau public
   - Cek notification widget (badge harus bertambah)
   - Klik bell icon, lihat notifikasi "Orderan Baru" dengan prioritas tinggi
   ```

3. **Test Multi-Admin**:
   ```
   - Login sebagai admin 1
   - Buat customer/booking baru
   - Login sebagai admin 2
   - Kedua admin harus menerima notifikasi yang sama
   ```

### Tinker Testing
```php
// Test event dispatch
php artisan tinker

use App\Models\Customer;
use App\Events\CustomerCreated;

$customer = Customer::first();
CustomerCreated::dispatch($customer);

// Cek notifikasi
use App\Models\Notification;
Notification::where('type', 'new_customer')->latest()->first();
```

---

## 📊 Database

### Tabel: notifications
```sql
- type: 'new_customer' atau 'new_booking'
- title: Judul notifikasi
- message: Pesan utama
- details: Detail tambahan
- priority: 'low', 'medium', 'high'
- user_id: ID admin/staff penerima
- notifiable_type: 'App\Models\Customer' atau 'App\Models\Booking'
- notifiable_id: ID customer atau booking
- action_url: Link ke detail
- read_at: Timestamp dibaca (null = belum dibaca)
- is_active: Status aktif
```

---

## 🎨 UI/UX

### Notification Widget
- **Badge**: Lingkaran merah dengan angka (max 9+)
- **Dropdown**: Max-height 96 (scrollable)
- **Unread**: Background biru muda
- **Icons**: Dinamis berdasarkan tipe
- **Priority Colors**:
  - High: Merah
  - Medium: Kuning
  - Low: Biru

### Notification Center
- **Layout**: Full page dengan filters
- **Filters**: Checkbox, select dropdowns
- **Pagination**: 10 per halaman
- **Actions**: Mark read, view detail

---

## 🔄 Auto-Refresh

- **Widget**: Refresh setiap 30 detik
- **Center**: Refresh setiap 30 detik
- **Method**: Livewire polling

---

## 🚀 Future Enhancements

1. **Push Notifications** - Browser push notifications
2. **Email Notifications** - Email ke admin untuk notifikasi urgent
3. **SMS Notifications** - SMS untuk notifikasi critical
4. **Sound Alerts** - Suara notifikasi di browser
5. **Notification Preferences** - Admin bisa atur preferensi notifikasi
6. **Notification History** - Archive notifikasi lama
7. **Notification Templates** - Template customizable

---

## 📝 Catatan

- Notifikasi hanya dikirim ke admin/staff yang `is_active = true`
- Notifikasi pelanggan baru memiliki prioritas rendah
- Notifikasi orderan baru memiliki prioritas tinggi (urgent)
- Auto-refresh dapat dimatikan jika perlu untuk performa
- Notifikasi lama (>30 hari dan sudah dibaca) dapat dihapus otomatis

---

## 👨‍💻 Maintenance

### Clear Old Notifications
```php
php artisan tinker

use App\Services\NotificationService;
$service = app(NotificationService::class);
$deleted = $service->cleanupOldNotifications(30); // Hapus notifikasi >30 hari
echo "Deleted: $deleted notifications";
```

### Generate Test Notifications
```php
php artisan tinker

use App\Models\Notification;
use App\Models\User;

// Generate untuk semua admin
$admins = User::where('role', 'admin')->where('is_active', true)->get();
foreach ($admins as $admin) {
    Notification::create([
        'type' => 'system_alert',
        'title' => 'Test Notification',
        'message' => 'This is a test',
        'priority' => 'medium',
        'user_id' => $admin->id,
        'is_active' => true,
    ]);
}
```

---

**Dibuat**: 19 Desember 2025  
**Versi**: 1.0  
**Status**: ✅ Production Ready
