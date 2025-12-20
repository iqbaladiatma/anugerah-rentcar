# Super Admin Feature Documentation

## Overview
Fitur Super Admin telah berhasil ditambahkan ke sistem Anugerah Rentcar. Super Admin memiliki akses penuh ke semua fitur sistem, termasuk kemampuan khusus untuk:

1. **Melihat semua pengguna yang aktif** - Monitor siapa saja yang sedang mengunjungi browser secara real-time
2. **Mengelola semua pengguna** - Mengaktifkan/menonaktifkan akun pengguna
3. **Mengubah semua pengaturan sistem** - Akses penuh ke konfigurasi sistem

## Kredensial Super Admin Default

```
Email: superadmin@anugerah-rentcar.com
Password: SuperAdmin123!
```

**⚠️ PENTING: Segera ubah password setelah login pertama kali!**

## Fitur-Fitur Super Admin

### 1. Active Sessions Monitoring
- Melihat semua pengguna yang sedang online
- Informasi yang ditampilkan:
  - Nama dan email pengguna
  - Role pengguna (Super Admin, Admin, Staff, Driver)
  - Browser dan platform yang digunakan
  - IP Address
  - Halaman yang sedang diakses
  - Waktu aktivitas terakhir
- Kemampuan untuk "kick" session pengguna (memutus koneksi)

### 2. User Management
- Melihat semua pengguna terdaftar
- Informasi yang ditampilkan:
  - Data pengguna lengkap
  - Status aktif/non-aktif
  - Jumlah booking
  - Tanggal registrasi
- Mengaktifkan/menonaktifkan akun pengguna (kecuali Super Admin)

### 3. System Settings Management
- Melihat semua pengaturan sistem
- Mengedit nilai pengaturan secara langsung
- Pengaturan yang dapat dikelola:
  - Informasi perusahaan
  - Konfigurasi harga
  - Pengaturan sistem lainnya

## Struktur Database

### Tabel: `users`
Role baru ditambahkan: `super_admin`

```sql
ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'staff', 'driver') NOT NULL DEFAULT 'staff';
```

### Tabel: `active_sessions`
Tabel baru untuk tracking session aktif:

```sql
CREATE TABLE active_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    session_id VARCHAR(255) UNIQUE NOT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    browser VARCHAR(255) NULL,
    platform VARCHAR(255) NULL,
    device VARCHAR(255) NULL,
    current_page VARCHAR(255) NULL,
    last_activity TIMESTAMP NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX (user_id),
    INDEX (session_id),
    INDEX (last_activity)
);
```

## File-File yang Ditambahkan/Dimodifikasi

### Models
- `app/Models/User.php` - Ditambahkan role super_admin dan method `isSuperAdmin()`
- `app/Models/ActiveSession.php` - Model baru untuk tracking sessions

### Middleware
- `app/Http/Middleware/TrackActiveSession.php` - Middleware untuk tracking aktivitas pengguna
- `app/Http/Middleware/SuperAdminMiddleware.php` - Middleware untuk proteksi route super admin

### Livewire Components
- `app/Livewire/Admin/SuperAdminDashboard.php` - Component dashboard super admin
- `app/Livewire/Layout/AdminSidebar.php` - Updated dengan menu Super Admin

### Views
- `resources/views/livewire/admin/super-admin-dashboard.blade.php` - View dashboard super admin
- `resources/views/components/icons/shield-check.blade.php` - Icon untuk menu super admin

### Migrations
- `database/migrations/2025_12_20_082657_add_super_admin_role_to_users_table.php`
- `database/migrations/2025_12_20_083948_create_active_sessions_table.php`

### Seeders
- `database/seeders/SuperAdminSeeder.php` - Seeder untuk membuat akun super admin default

### Routes
- `routes/web.php` - Ditambahkan route untuk super admin dashboard

### Configuration
- `bootstrap/app.php` - Registrasi middleware baru

## Cara Menggunakan

### 1. Login sebagai Super Admin
1. Buka halaman login: `/masuk`
2. Masukkan kredensial super admin
3. Setelah login, Anda akan melihat menu "Super Admin" di sidebar

### 2. Mengakses Dashboard Super Admin
1. Klik menu "Super Admin" di sidebar
2. Atau akses langsung: `/admin/super-admin`

### 3. Monitoring Active Sessions
1. Di dashboard, tab "Active Sessions" menampilkan semua pengguna yang online
2. Klik tombol "Refresh" untuk memperbarui data
3. Klik "Kick" untuk memutus session pengguna tertentu

### 4. Mengelola Users
1. Klik tab "All Users"
2. Lihat daftar semua pengguna
3. Klik "Activate" atau "Deactivate" untuk mengubah status pengguna

### 5. Mengelola Settings
1. Klik tab "System Settings"
2. Klik icon edit pada setting yang ingin diubah
3. Ubah nilai dan klik "Save"

## Keamanan

### Proteksi Route
- Route super admin dilindungi dengan middleware `super.admin`
- Hanya user dengan role `super_admin` yang dapat mengakses
- User lain akan mendapat error 403 Forbidden

### Session Tracking
- Session tracking otomatis untuk semua authenticated users
- Data session dibersihkan otomatis setiap 1 jam
- Session dianggap aktif jika ada aktivitas dalam 5 menit terakhir

### Permissions
- Super Admin memiliki semua permission yang dimiliki Admin
- Super Admin tidak dapat di-deactivate oleh user lain
- Method `isAdmin()` mengembalikan `true` untuk Super Admin

## Dependencies Baru

### Composer Packages
- `jenssegers/agent` (^2.6) - Untuk mendeteksi browser, platform, dan device

## Troubleshooting

### Session tidak ter-track
- Pastikan middleware `TrackActiveSession` sudah terdaftar di `bootstrap/app.php`
- Pastikan middleware ditambahkan ke web middleware group
- Clear cache: `php artisan cache:clear`

### Error 403 saat akses Super Admin
- Pastikan user memiliki role `super_admin`
- Cek database: `SELECT * FROM users WHERE role = 'super_admin'`
- Pastikan middleware `super.admin` terdaftar

### Icon tidak muncul
- Pastikan file `shield-check.blade.php` ada di `resources/views/components/icons/`
- Clear view cache: `php artisan view:clear`

## Maintenance

### Membuat Super Admin Baru
```bash
php artisan db:seed --class=SuperAdminSeeder
```

Atau manual via tinker:
```php
php artisan tinker

User::create([
    'name' => 'Super Admin Name',
    'email' => 'email@example.com',
    'password' => bcrypt('password'),
    'phone' => '081234567890',
    'role' => 'super_admin',
    'is_active' => true,
    'email_verified_at' => now(),
]);
```

### Cleanup Old Sessions
Session lama dibersihkan otomatis, tapi bisa juga manual:
```php
php artisan tinker

\App\Models\ActiveSession::cleanupOldSessions();
```

### Monitoring Performance
- Session tracking menambah sedikit overhead pada setiap request
- Cleanup otomatis berjalan dengan probabilitas 1% per request
- Untuk aplikasi dengan traffic tinggi, pertimbangkan scheduled job untuk cleanup

## Future Enhancements

Beberapa fitur yang bisa ditambahkan di masa depan:
1. Real-time updates menggunakan WebSocket/Pusher
2. Session history dan analytics
3. Audit log untuk semua perubahan yang dilakukan Super Admin
4. Two-factor authentication untuk Super Admin
5. IP whitelist untuk akses Super Admin
6. Export data active sessions
7. Grafik dan statistik penggunaan sistem
