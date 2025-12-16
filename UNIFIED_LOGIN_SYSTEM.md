# Unified Login System

## Overview
Sistem login yang terintegrasi untuk semua role (Admin, Staff, Driver, dan Customer) melalui satu endpoint `/login`.

## Cara Kerja

Sistem unified login bekerja dengan mencoba autentikasi pada dua guard secara berurutan:

1. **Guard `web`** - untuk User (Admin/Staff/Driver)
2. **Guard `customer`** - untuk Customer

### Flow Autentikasi

```
User masuk email & password
        ↓
Coba login dengan guard 'web'
        ↓
    Berhasil? → Redirect ke /admin/dashboard
        ↓ Tidak
Coba login dengan guard 'customer'
        ↓
    Berhasil? → Redirect ke /customer/dashboard
        ↓ Tidak
Tampilkan error "Email atau password salah"
```

## File-file Terkait

### 1. Routes
- `routes/web.php` (baris 14-20)
  - `/login` [GET] → Menampilkan form login
  - `/login` [POST] → Memproses login
  - `/logout` [POST] → Logout dari sistem

### 2. Controller
- `app/Http/Controllers/Auth/UnifiedLoginController.php`
  - `showLoginForm()` → Menampilkan view login
  - `login()` → Memproses autentikasi multi-guard
  - `logout()` → Logout dari guard yang aktif

### 3. View
- `resources/views/auth/unified-login.blade.php`
  - Form login yang unified untuk semua role

### 4. Models
- `app/Models/User.php` → Model untuk Admin/Staff/Driver
- `app/Models/Customer.php` → Model untuk Customer

### 5. Configuration
- `config/auth.php`
  - Guard `web` → menggunakan provider `users` (tabel: users)
  - Guard `customer` → menggunakan provider `customers` (tabel: customers)

## Keuntungan Unified Login

1. **User Experience** - Customer dan Admin tidak perlu bingung mencari halaman login yang benar
2. **Maintainability** - Hanya satu halaman login yang perlu dikelola
3. **Security** - Satu titik entry yang lebih mudah di-monitor dan di-secure
4. **Simplicity** - Kode lebih sederhana dan mudah dipahami

## Middleware yang Digunakan

### Untuk Customer
```php
Route::middleware('auth:customer')->group(function () {
    // Customer routes
});
```

### Untuk Admin/Staff/Driver
```php
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    // Admin routes
});
```

## Contoh Penggunaan

### Di Blade Template
```blade
{{-- Link ke halaman login --}}
<a href="{{ route('login') }}">Login</a>

{{-- Logout form --}}
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
```

### Di Controller
```php
// Cek apakah user sudah login (Admin/Staff/Driver)
if (Auth::guard('web')->check()) {
    // User is admin
}

// Cek apakah customer sudah login
if (Auth::guard('customer')->check()) {
    // User is customer
}

// Logout
Auth::guard('web')->logout();
// atau
Auth::guard('customer')->logout();
```

## Database Tables

### Table `users`
- `id`
- `name`
- `email`
- `password`
- `phone`
- `role` (admin/staff/driver)
- `is_active`
- `email_verified_at`
- `created_at`
- `updated_at`

### Table `customers`
- `id`
- `name`
- `email`
- `password`
- `phone`
- `nik`
- `ktp_photo`
- `sim_photo`
- `address`
- `is_member`
- `member_discount`
- `is_blacklisted`
- `blacklist_reason`
- `email_verified_at`
- `created_at`
- `updated_at`

## Testing

### Test Login Admin
1. Buka `/login`
2. Masukkan email admin (dari tabel `users`)
3. Masukkan password
4. Sistem akan redirect ke `/admin/dashboard`

### Test Login Customer
1. Buka `/login`
2. Masukkan email customer (dari tabel `customers`)
3. Masukkan password
4. Sistem akan redirect ke `/customer/dashboard`

## Notes

- Route `/customer/login` **sudah tidak digunakan lagi**
- Semua link login harus mengarah ke `route('login')`
- Jangan ada duplicate route dengan nama `login`
- Logout akan otomatis mendeteksi guard mana yang aktif
