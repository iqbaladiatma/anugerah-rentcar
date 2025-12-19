# 🚗 ALUR LENGKAP SISTEM RENTAL MOBIL ANUGERAH RENT CAR

## 📋 DAFTAR ISI
1. [Overview Sistem](#overview-sistem)
2. [Alur Customer Journey](#alur-customer-journey)
3. [Alur Admin Management](#alur-admin-management)
4. [Database Schema](#database-schema)
5. [Fitur-Fitur Utama](#fitur-fitur-utama)

---

## 🎯 OVERVIEW SISTEM

### Arsitektur Aplikasi
- **Framework**: Laravel 12.x
- **Frontend**: Livewire + Alpine.js + Tailwind CSS
- **Database**: MySQL
- **Authentication**: Multi-guard (Admin & Customer)
- **File Storage**: Laravel Storage (public disk)

### Role & Akses
1. **Admin** - Full access ke semua fitur
2. **Staff** - Akses terbatas untuk operasional
3. **Driver** - Akses untuk melihat jadwal
4. **Customer** - Portal untuk booking dan tracking

---

## 🛣️ ALUR CUSTOMER JOURNEY (End-to-End)

### **FASE 1: REGISTRASI & PROFILE** 📝

#### 1.1 Customer Baru Registrasi
```
URL: /pelanggan/register
Controller: App\Http\Controllers\Customer\AuthController@register
```

**Flow:**
1. Customer mengisi form registrasi:
   - Nama lengkap
   - Email
   - Password
   
2. System membuat customer dengan `profile_completed = false`
   
3. Event `CustomerCreated` di-dispatch
   
4. Listener `SendCustomerNotifications` membuat notifikasi untuk semua admin/staff:
   ```
   Notifikasi: "Pelanggan Baru - [Nama Customer]"
   Priority: Low
   Icon: user-plus
   ```

5. Customer di-redirect ke halaman lengkapi profil

#### 1.2 Lengkapi Profil (KYC)
```
URL: /pelanggan/lengkapi-profil
Livewire: App\Livewire\Customer\CompleteProfile
```

**Data yang Harus Dilengkapi:**
- NIK (16 digit)
- Nomor Telepon
- Alamat Lengkap
- Upload KTP (foto)
- Upload SIM (foto)
- Upload Kartu Keluarga (foto)

**Validasi:**
- File max 10MB
- Format: JPG, JPEG, PNG
- Dokumen harus jelas dan valid

**Setelah Lengkap:**
- `profile_completed = true`
- Customer bisa mulai booking

---

### **FASE 2: PENCARIAN & PEMILIHAN KENDARAAN** 🔍

#### 2.1 Browse Katalog Kendaraan
```
URL: /kendaraan
View: resources/views/vehicles/catalog.blade.php
```

**Fitur Pencarian:**
- Filter by Brand
- Filter by Type (Sedan, SUV, MPV, dll)
- Filter by Price Range
- Filter by Transmission
- Filter by Fuel Type
- Search by Name/Model

**Informasi Kendaraan:**
- Foto kendaraan (depan, belakang, interior, dashboard)
- Brand & Model
- Tahun
- Warna
- Plat Nomor
- Harga sewa per hari
- Status ketersediaan
- Spesifikasi (transmisi, bahan bakar, kapasitas)

#### 2.2 Detail Kendaraan
```
URL: /kendaraan/{id}
Controller: App\Http\Controllers\VehicleController@show
```

**Informasi Lengkap:**
- Galeri foto
- Spesifikasi detail
- Harga sewa
- Syarat & ketentuan
- Tombol "Pesan Sekarang"

---

### **FASE 3: PROSES BOOKING** 📅

#### 3.1 Booking Wizard (5 Steps)
```
URL: /pemesanan/wizard?car_id={id}&start_date={date}&end_date={date}
Livewire: App\Livewire\Public\BookingWizard
```

**STEP 1: Pilih Kendaraan & Tanggal**
- Pilih tanggal ambil
- Pilih tanggal kembali
- Lokasi pengambilan
- Lokasi pengembalian
- Opsi: Dengan Sopir (checkbox)
- Opsi: Perjalanan Luar Kota (checkbox + biaya tambahan)
- Pilih kendaraan dari yang tersedia

**Validasi:**
- Tanggal tidak boleh di masa lalu
- Tanggal kembali harus setelah tanggal ambil
- Cek ketersediaan kendaraan

**STEP 2: Detail Harga**
```
Service: App\Services\BookingCalculatorService
```

**Perhitungan Otomatis:**
```php
Base Amount = Daily Rate × Duration Days
Driver Fee = Driver Rate × Duration Days (jika dengan sopir)
Out of Town Fee = Input manual (jika luar kota)
Member Discount = Base Amount × Member Discount % (jika member)
Total Amount = Base Amount + Driver Fee + Out of Town Fee - Member Discount
Deposit Amount = Total Amount × 30% (default)
```

**Tampilan:**
- Info kendaraan terpilih
- Breakdown harga detail
- Total yang harus dibayar
- Deposit yang diperlukan

**STEP 3: Informasi Pelanggan**

**Jika Sudah Login:**
- Tampilkan info customer
- Cek apakah member (auto apply discount)
- Lanjut ke step 4

**Jika Belum Login:**
- Toggle: "Pelanggan Baru" / "Sudah Punya Akun"

**Pelanggan Baru:**
- Nama lengkap
- Nomor telepon
- Email
- NIK (16 digit)
- Alamat
- Password
- Konfirmasi password

**Sudah Punya Akun:**
- Email
- Password
- Tombol "Login & Continue"

**Proses:**
1. Validasi data
2. Create customer atau authenticate
3. Dispatch `CustomerCreated` event (jika baru)
4. Auto login
5. Lanjut ke step 4

**STEP 4: Upload Dokumen**

**Dokumen yang Diperlukan:**
1. **KTP** (Kartu Tanda Penduduk)
2. **SIM** (Surat Izin Mengemudi)
3. **KK** (Kartu Keluarga)

**Jika Customer Sudah Upload Sebelumnya:**
- Tampilkan status "Already uploaded"
- Bisa skip atau upload ulang

**Upload Baru:**
- Drag & drop atau click to upload
- Preview sebelum upload
- Validasi file (size, format)
- Store di `storage/app/public/customers/{nik}_{type}_{timestamp}.{ext}`

**STEP 5: Konfirmasi & Pembayaran**

**Ringkasan Booking:**
- Info kendaraan
- Tanggal rental
- Lokasi pickup & return
- Info customer
- Breakdown harga

**Metode Pembayaran:**
- Bank Transfer
- Cash (bayar di lokasi)

**Catatan Tambahan:**
- Text area untuk request khusus

**Tombol "Complete Booking"**

#### 3.2 Proses Create Booking
```php
Livewire: App\Livewire\Public\BookingWizard@createBooking()
```

**Langkah-langkah:**

1. **Generate Booking Number**
   ```php
   Format: BK{YYYYMMDD}{XXX}
   Contoh: BK20251219001
   ```

2. **Create Booking Record**
   ```php
   Booking::create([
       'booking_number' => 'BK20251219001',
       'customer_id' => $customer->id,
       'car_id' => $selectedCarId,
       'start_date' => $startDate,
       'end_date' => $endDate,
       'pickup_location' => $pickupLocation,
       'return_location' => $returnLocation,
       'with_driver' => $withDriver,
       'is_out_of_town' => $isOutOfTown,
       'out_of_town_fee' => $outOfTownFee,
       'base_amount' => $pricingData['base_amount'],
       'driver_fee' => $pricingData['driver_fee'],
       'member_discount' => $pricingData['member_discount'],
       'total_amount' => $pricingData['total_amount'],
       'deposit_amount' => $pricingData['deposit_amount'],
       'payment_status' => 'pending',
       'booking_status' => 'pending',
       'notes' => $notes,
   ]);
   ```

3. **Dispatch Event `BookingCreated`**

4. **Listener `SendBookingNotifications` Berjalan:**
   - Buat notifikasi "Orderan Baru" untuk semua admin/staff
   - Kirim email konfirmasi ke customer

5. **Redirect ke Dashboard Customer**
   ```
   URL: /pelanggan/dasbor
   Message: "Booking created successfully! Booking number: BK20251219001"
   ```

---

### **FASE 4: KONFIRMASI & PEMBAYARAN** 💳

#### 4.1 Admin Menerima Notifikasi
```
Notifikasi di Navbar Admin:
- Badge merah dengan jumlah notifikasi
- Dropdown menampilkan "Orderan Baru"
- Priority: High (Urgent)
- Icon: Shopping Cart
```

#### 4.2 Admin Review Booking
```
URL: /admin/bookings/{id}
Controller: App\Http\Controllers\BookingController@show
```

**Informasi yang Ditampilkan:**
- Detail booking lengkap
- Info customer + dokumen
- Info kendaraan
- Breakdown harga
- Status pembayaran
- Status booking

**Aksi yang Bisa Dilakukan:**
1. **Konfirmasi Booking** (ubah status ke 'confirmed')
2. **Reject Booking** (ubah status ke 'cancelled')
3. **Assign Driver** (jika dengan sopir)
4. **Update Payment Status**
5. **Print Invoice**

#### 4.3 Update Payment Status
```
Admin mengubah payment_status:
- pending → paid (setelah terima pembayaran)
- paid → completed (setelah rental selesai)
```

#### 4.4 Konfirmasi Booking
```
Admin mengubah booking_status:
- pending → confirmed
```

**Trigger:**
- Email konfirmasi ke customer
- Update car status (jika perlu)
- Assign driver (jika ada)

---

### **FASE 5: PENGAMBILAN KENDARAAN** 🚗

#### 5.1 Persiapan Admin
```
Checklist sebelum pickup:
□ Verifikasi pembayaran deposit
□ Verifikasi dokumen customer (KTP, SIM, KK)
□ Cek kondisi kendaraan
□ Foto kondisi kendaraan (depan, belakang, interior)
□ Catat kilometer awal
□ Isi bahan bakar penuh
□ Siapkan kunci & dokumen kendaraan
```

#### 5.2 Proses Pickup
```
Admin update booking:
- booking_status: confirmed → active
- actual_pickup_date: [tanggal actual]
- pickup_km: [kilometer awal]
- pickup_fuel_level: [level bahan bakar]
- pickup_condition_notes: [catatan kondisi]
```

**Upload Foto Kondisi:**
```
Storage: storage/app/public/bookings/{booking_id}/pickup/
Files:
- front.jpg
- back.jpg
- interior.jpg
- dashboard.jpg
```

#### 5.3 Serah Terima
```
Dokumen yang Diserahkan:
□ Kunci kendaraan
□ STNK (fotocopy)
□ Buku manual (jika ada)
□ Kartu tol (jika ada)

Customer Menandatangani:
□ Form serah terima
□ Checklist kondisi kendaraan
```

---

### **FASE 6: MASA RENTAL** ⏱️

#### 6.1 Tracking Booking
```
Customer Dashboard:
URL: /pelanggan/dasbor
```

**Customer Bisa Melihat:**
- Status booking (Active)
- Tanggal pickup & return
- Kendaraan yang disewa
- Total pembayaran
- Sisa hari rental
- Kontak darurat

#### 6.2 Extend Rental (Opsional)
```
Jika customer ingin perpanjang:
1. Hubungi admin
2. Admin cek ketersediaan
3. Admin update end_date
4. Recalculate pricing
5. Customer bayar selisih
```

#### 6.3 Monitoring Admin
```
Admin Dashboard:
- List active bookings
- Upcoming returns (reminder)
- Overdue bookings (alert)
```

**Notifikasi Otomatis:**
- H-1 sebelum return: Reminder ke customer
- H+1 setelah return: Alert overdue ke admin

---

### **FASE 7: PENGEMBALIAN KENDARAAN** 🔄

#### 7.1 Persiapan Return
```
Customer:
□ Isi bahan bakar penuh
□ Bersihkan interior
□ Kembalikan semua aksesoris
□ Datang tepat waktu
```

#### 7.2 Proses Return
```
Admin Checklist:
□ Cek kondisi eksterior (body, cat, kaca)
□ Cek kondisi interior (jok, dashboard, karpet)
□ Cek kelengkapan (kunci, STNK, aksesoris)
□ Catat kilometer akhir
□ Cek level bahan bakar
□ Foto kondisi kendaraan
```

#### 7.3 Update Booking
```
Admin update:
- booking_status: active → completed
- actual_return_date: [tanggal actual]
- return_km: [kilometer akhir]
- return_fuel_level: [level bahan bakar]
- return_condition_notes: [catatan kondisi]
- late_return_days: [jika terlambat]
- late_return_fee: [biaya keterlambatan]
- damage_fee: [biaya kerusakan jika ada]
```

**Upload Foto Return:**
```
Storage: storage/app/public/bookings/{booking_id}/return/
Files:
- front.jpg
- back.jpg
- interior.jpg
- dashboard.jpg
```

#### 7.4 Perhitungan Biaya Tambahan
```php
// Jika terlambat
if ($actualReturnDate > $scheduledReturnDate) {
    $lateDays = $actualReturnDate->diffInDays($scheduledReturnDate);
    $lateReturnFee = $lateDays × $dailyRate × 1.5; // 150% dari harga normal
}

// Jika ada kerusakan
if ($hasDamage) {
    $damageFee = [input manual berdasarkan estimasi perbaikan];
}

// Total biaya tambahan
$additionalFees = $lateReturnFee + $damageFee;
```

#### 7.5 Pengembalian Deposit
```
Deposit Calculation:
- Deposit Awal: Rp 1.000.000
- Biaya Keterlambatan: Rp 0
- Biaya Kerusakan: Rp 0
- Deposit Dikembalikan: Rp 1.000.000

Jika ada biaya tambahan:
- Deposit Dikembalikan = Deposit - Additional Fees
```

**Update Payment:**
```
- payment_status: paid → completed
- deposit_returned: true
- deposit_return_amount: [jumlah dikembalikan]
- deposit_return_date: [tanggal]
```

#### 7.6 Serah Terima Return
```
Customer Menerima:
□ Deposit (dikurangi biaya tambahan jika ada)
□ Kwitansi pengembalian
□ Fotocopy dokumen return

Customer Menandatangani:
□ Form serah terima return
□ Checklist kondisi kendaraan
□ Persetujuan biaya tambahan (jika ada)
```

---

### **FASE 8: POST-RENTAL** ⭐

#### 8.1 Update Car Status
```
Admin update kendaraan:
- status: rented → available
- last_service_km: [jika perlu service]
- next_service_due: [tanggal service berikutnya]
```

#### 8.2 Customer Loyalty
```
System otomatis:
- Hitung total bookings customer
- Update member status jika eligible
- Apply member discount untuk booking berikutnya
```

**Kriteria Member:**
```php
if ($customer->bookings()->completed()->count() >= 3) {
    $customer->update([
        'is_member' => true,
        'member_discount' => 10, // 10% discount
    ]);
}
```

#### 8.3 Reporting
```
Admin bisa generate laporan:
- Revenue per booking
- Customer lifetime value
- Vehicle utilization
- Profitability analysis
```

---

## 🎛️ ALUR ADMIN MANAGEMENT

### 1. Dashboard Admin
```
URL: /admin/dashboard
Livewire: App\Livewire\Admin\DashboardStats
```

**Metrics yang Ditampilkan:**
- Total Revenue (bulan ini)
- Active Bookings
- Available Vehicles
- Total Customers
- Grafik revenue trend
- Top performing vehicles
- Recent bookings

### 2. Manajemen Kendaraan
```
URL: /admin/kendaraan
Controller: App\Http\Controllers\CarController
```

**CRUD Operations:**
- Create: Tambah kendaraan baru
- Read: List & detail kendaraan
- Update: Edit info kendaraan
- Delete: Hapus kendaraan (soft delete)

**Fitur Tambahan:**
- Upload multiple photos
- Set pricing (daily rate, driver fee)
- Track maintenance schedule
- View booking history per vehicle

### 3. Manajemen Customer
```
URL: /admin/pelanggan
Controller: App\Http\Controllers\CustomerController
```

**Fitur:**
- List semua customer
- View customer detail + dokumen
- Member management
- Blacklist management
- Customer statistics
- Booking history per customer

### 4. Manajemen Booking
```
URL: /admin/bookings
Controller: App\Http\Controllers\BookingController
```

**Workflow:**
1. List semua booking (filter by status)
2. View detail booking
3. Confirm/Reject booking
4. Assign driver
5. Update payment status
6. Process pickup
7. Process return
8. Generate invoice

### 5. Manajemen Driver
```
URL: /admin/drivers
```

**Fitur:**
- CRUD drivers
- Assign ke booking
- Track availability
- View schedule
- Calculate salary

### 6. Financial Management
```
URL: /admin/keuangan
```

**Fitur:**
- Income tracking
- Expense management
- Profit calculation
- Tax calculation
- Generate financial reports

### 7. Reports & Analytics
```
URL: /admin/laporan
```

**Jenis Laporan:**
- Revenue Report
- Booking Report
- Vehicle Utilization
- Customer Analytics
- Profitability Analysis
- Tax Report

---

## 💾 DATABASE SCHEMA

### Tabel Utama

#### `customers`
```sql
- id
- name
- email
- phone
- nik (16 digit)
- address
- ktp_photo
- sim_photo
- kk_photo
- password
- is_member (boolean)
- member_discount (%)
- is_blacklisted (boolean)
- blacklist_reason
- profile_completed (boolean)
- created_at
- updated_at
```

#### `cars`
```sql
- id
- brand
- model
- year
- color
- license_plate
- type (sedan, suv, mpv, etc)
- transmission (manual, automatic)
- fuel_type (bensin, diesel, hybrid)
- capacity (passengers)
- daily_rate (harga sewa per hari)
- driver_fee (biaya sopir per hari)
- status (available, rented, maintenance)
- photo_front
- photo_back
- photo_interior
- photo_dashboard
- features (JSON)
- created_at
- updated_at
```

#### `bookings`
```sql
- id
- booking_number (BK20251219001)
- customer_id
- car_id
- driver_id (nullable)
- start_date
- end_date
- pickup_location
- return_location
- with_driver (boolean)
- is_out_of_town (boolean)
- out_of_town_fee
- base_amount
- driver_fee
- member_discount
- total_amount
- deposit_amount
- payment_status (pending, paid, completed)
- booking_status (pending, confirmed, active, completed, cancelled)
- actual_pickup_date
- actual_return_date
- pickup_km
- return_km
- pickup_fuel_level
- return_fuel_level
- late_return_days
- late_return_fee
- damage_fee
- deposit_returned (boolean)
- notes
- created_at
- updated_at
```

#### `notifications`
```sql
- id
- type (new_customer, new_booking, payment_overdue, etc)
- title
- message
- details
- priority (low, medium, high)
- icon
- user_id (admin/staff yang menerima)
- notifiable_type (Customer, Booking, etc)
- notifiable_id
- recipient_type (user, all_staff, etc)
- action_url
- read_at
- is_active
- expires_at
- created_at
- updated_at
```

#### `users` (Admin/Staff/Driver)
```sql
- id
- name
- email
- phone
- role (admin, staff, driver)
- password
- is_active
- created_at
- updated_at
```

---

## 🎯 FITUR-FITUR UTAMA

### 1. Multi-Guard Authentication
```php
Guards:
- web (Admin/Staff/Driver)
- customer (Customer)

Middleware:
- auth:web (untuk admin routes)
- auth:customer (untuk customer routes)
```

### 2. Real-time Notifications
```php
Events & Listeners:
- CustomerCreated → SendCustomerNotifications
- BookingCreated → SendBookingNotifications

Notification Widget:
- Auto-refresh setiap 30 detik
- Badge count unread
- Dropdown recent notifications
- Mark as read functionality
```

### 3. Dynamic Pricing Calculator
```php
Service: BookingCalculatorService

Factors:
- Duration (days)
- Daily rate
- Driver fee (if with driver)
- Out of town fee (if applicable)
- Member discount (if member)
- Deposit (30% of total)
```

### 4. Availability Checker
```php
Service: AvailabilityService

Logic:
- Check overlapping bookings
- Exclude cancelled bookings
- Consider maintenance schedule
- Real-time availability status
```

### 5. Document Management
```php
Secure File Upload:
- Validation (size, type, content)
- Sanitized filename
- Organized storage structure
- Access control
```

### 6. Member System
```php
Auto Member Upgrade:
- After 3 completed bookings
- 10% discount on future bookings
- Priority customer service
```

### 7. Reporting & Analytics
```php
Reports:
- Revenue analysis
- Vehicle utilization
- Customer lifetime value
- Profitability per vehicle
- Tax calculations
```

---

## 🔐 SECURITY FEATURES

### 1. Authentication & Authorization
- Password hashing (bcrypt)
- CSRF protection
- Session management
- Role-based access control

### 2. File Upload Security
- File type validation
- File size limits
- Content verification
- Sanitized filenames
- Secure storage paths

### 3. Data Validation
- Server-side validation
- Client-side validation (Livewire)
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade escaping)

### 4. Privacy & GDPR
- Customer data encryption
- Document access control
- Data retention policies
- Right to be forgotten

---

## 📱 RESPONSIVE DESIGN

### Public Pages
- Mobile-first approach
- Tailwind CSS responsive utilities
- Touch-friendly interfaces
- Optimized images

### Admin Panel
- Desktop-optimized
- Sidebar navigation
- Data tables with pagination
- Modal dialogs

---

## 🚀 PERFORMANCE OPTIMIZATION

### 1. Database
- Indexed columns (booking_number, customer_id, car_id)
- Eager loading relationships
- Query optimization
- Database caching

### 2. File Storage
- Lazy loading images
- Optimized file sizes
- CDN ready structure

### 3. Frontend
- Livewire for reactive components
- Alpine.js for lightweight interactions
- Vite for asset bundling
- CSS purging (Tailwind)

---

## 📊 BUSINESS METRICS

### KPIs yang Bisa Ditrack:
1. **Revenue Metrics**
   - Total revenue
   - Average booking value
   - Revenue per vehicle
   - Monthly recurring revenue

2. **Operational Metrics**
   - Vehicle utilization rate
   - Average rental duration
   - Booking conversion rate
   - Customer acquisition cost

3. **Customer Metrics**
   - Customer lifetime value
   - Repeat booking rate
   - Member conversion rate
   - Customer satisfaction score

4. **Fleet Metrics**
   - Maintenance cost per vehicle
   - Downtime percentage
   - ROI per vehicle
   - Depreciation tracking

---

## 🎓 KESIMPULAN

Sistem Anugerah Rent Car adalah aplikasi rental mobil yang komprehensif dengan:

✅ **User Experience yang Smooth**
- Booking wizard 5 langkah yang intuitif
- Real-time availability checking
- Automatic pricing calculation
- Member rewards system

✅ **Admin Management yang Powerful**
- Comprehensive dashboard
- Complete booking lifecycle management
- Financial tracking & reporting
- Notification system

✅ **Security & Compliance**
- Secure authentication
- Document verification
- Data protection
- Audit trail

✅ **Scalability**
- Modular architecture
- Service-oriented design
- Queue-ready (untuk future scaling)
- API-ready structure

---

**Dibuat**: 19 Desember 2025  
**Versi**: 1.0  
**Status**: ✅ Production Ready
