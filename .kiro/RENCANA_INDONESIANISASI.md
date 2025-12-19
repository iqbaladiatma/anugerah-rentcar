# 🇮🇩 RENCANA INDONESIANISASI SISTEM & FITUR PENYERAHAN KUNCI

## 📋 DAFTAR PERUBAHAN

### FASE 1: PERUBAHAN DATABASE & MIGRASI

#### A. Tabel `bookings` - Kolom Baru
```sql
-- Status pembayaran (ubah enum)
payment_status: 
  - 'pending' → 'menunggu'
  - 'partial' → 'sebagian'
  - 'paid' → 'lunas'
  - 'verifying' → 'verifikasi'
  - 'refunded' → 'dikembalikan'

-- Status booking (ubah enum)
booking_status:
  - 'pending' → 'menunggu'
  - 'confirmed' → 'dikonfirmasi'
  - 'active' → 'aktif'
  - 'completed' → 'selesai'
  - 'cancelled' → 'dibatalkan'

-- Kolom baru untuk penyerahan kunci
ALTER TABLE bookings ADD COLUMN:
- kunci_diserahkan BOOLEAN DEFAULT FALSE
- tanggal_serah_kunci DATETIME NULL
- petugas_serah_kunci_id INT NULL (FK ke users)
- foto_serah_kunci VARCHAR(255) NULL
- catatan_serah_kunci TEXT NULL
- tanda_tangan_customer TEXT NULL (base64 signature)

- kunci_dikembalikan BOOLEAN DEFAULT FALSE
- tanggal_terima_kunci DATETIME NULL
- petugas_terima_kunci_id INT NULL (FK ke users)
- foto_terima_kunci VARCHAR(255) NULL
- catatan_terima_kunci TEXT NULL
```

#### B. Tabel `cars` - Kolom Baru
```sql
-- Status kendaraan (ubah enum)
status:
  - 'available' → 'tersedia'
  - 'rented' → 'disewa'
  - 'maintenance' → 'perawatan'
  - 'reserved' → 'dipesan'

-- Tipe kendaraan (ubah enum)
type:
  - 'sedan' → 'sedan'
  - 'suv' → 'suv'
  - 'mpv' → 'mpv'
  - 'hatchback' → 'hatchback'
  - 'pickup' → 'pickup'
  - 'van' → 'van'

-- Transmisi (ubah enum)
transmission:
  - 'manual' → 'manual'
  - 'automatic' → 'otomatis'
  - 'cvt' → 'cvt'

-- Bahan bakar (ubah enum)
fuel_type:
  - 'petrol' → 'bensin'
  - 'diesel' → 'diesel'
  - 'electric' → 'listrik'
  - 'hybrid' → 'hybrid'
```

#### C. Tabel `users` - Kolom Baru
```sql
-- Role (ubah enum)
role:
  - 'admin' → 'admin'
  - 'staff' → 'staf'
  - 'driver' → 'sopir'
```

#### D. Tabel `customers`
```sql
-- Status member
is_member → adalah_member
member_discount → diskon_member
is_blacklisted → dalam_blacklist
blacklist_reason → alasan_blacklist
profile_completed → profil_lengkap
```

---

### FASE 2: PERUBAHAN MODEL CONSTANTS

#### A. Model Booking
```php
// Payment Status
const PAYMENT_MENUNGGU = 'menunggu';
const PAYMENT_SEBAGIAN = 'sebagian';
const PAYMENT_LUNAS = 'lunas';
const PAYMENT_VERIFIKASI = 'verifikasi';
const PAYMENT_DIKEMBALIKAN = 'dikembalikan';

// Booking Status
const STATUS_MENUNGGU = 'menunggu';
const STATUS_DIKONFIRMASI = 'dikonfirmasi';
const STATUS_AKTIF = 'aktif';
const STATUS_SELESAI = 'selesai';
const STATUS_DIBATALKAN = 'dibatalkan';
```

#### B. Model Car
```php
// Car Status
const STATUS_TERSEDIA = 'tersedia';
const STATUS_DISEWA = 'disewa';
const STATUS_PERAWATAN = 'perawatan';
const STATUS_DIPESAN = 'dipesan';

// Transmission
const TRANS_MANUAL = 'manual';
const TRANS_OTOMATIS = 'otomatis';
const TRANS_CVT = 'cvt';

// Fuel Type
const FUEL_BENSIN = 'bensin';
const FUEL_DIESEL = 'diesel';
const FUEL_LISTRIK = 'listrik';
const FUEL_HYBRID = 'hybrid';
```

#### C. Model User
```php
// Roles
const ROLE_ADMIN = 'admin';
const ROLE_STAF = 'staf';
const ROLE_SOPIR = 'sopir';
```

---

### FASE 3: FITUR PENYERAHAN KUNCI

#### A. Alur Penyerahan Kunci (Pickup)

**Step 1: Admin/Staff Proses Penyerahan**
```
URL: /admin/bookings/{id}/serah-kunci
Method: POST
```

**Data yang Dibutuhkan:**
- Verifikasi identitas customer
- Cek kondisi kendaraan
- Foto kendaraan (depan, belakang, interior, dashboard)
- Foto odometer (kilometer awal)
- Foto bahan bakar (level awal)
- Foto kondisi khusus (jika ada)
- Tanda tangan digital customer
- Catatan tambahan

**Proses:**
1. Admin scan/input NIK customer
2. System verifikasi customer dan booking
3. Admin cek kondisi kendaraan
4. Upload foto kondisi
5. Customer tanda tangan digital
6. System update:
   - kunci_diserahkan = TRUE
   - tanggal_serah_kunci = NOW()
   - petugas_serah_kunci_id = admin_id
   - booking_status = 'aktif'
   - car_status = 'disewa'
7. Generate Berita Acara Serah Terima (PDF)
8. Kirim email/notif ke customer

#### B. Alur Pengembalian Kunci (Return)

**Step 1: Admin/Staff Proses Pengembalian**
```
URL: /admin/bookings/{id}/terima-kunci
Method: POST
```

**Data yang Dibutuhkan:**
- Cek kondisi kendaraan return
- Foto kendaraan (depan, belakang, interior, dashboard)
- Foto odometer (kilometer akhir)
- Foto bahan bakar (level akhir)
- Foto kerusakan (jika ada)
- Hitung biaya tambahan (keterlambatan, kerusakan)
- Catatan pengembalian

**Proses:**
1. Customer datang return kendaraan
2. Admin cek kondisi kendaraan
3. Upload foto kondisi return
4. Bandingkan dengan kondisi pickup
5. Hitung biaya tambahan (jika ada)
6. Customer konfirmasi biaya
7. System update:
   - kunci_dikembalikan = TRUE
   - tanggal_terima_kunci = NOW()
   - petugas_terima_kunci_id = admin_id
   - booking_status = 'selesai'
   - car_status = 'tersedia'
   - payment_status = 'lunas' (jika sudah bayar semua)
8. Proses pengembalian deposit
9. Generate Berita Acara Pengembalian (PDF)
10. Kirim email/notif ke customer

---

### FASE 4: KOMPONEN UI BARU

#### A. Form Serah Kunci (Admin)
```
Komponen: resources/views/admin/bookings/serah-kunci.blade.php

Sections:
1. Informasi Booking
   - Nomor booking
   - Customer
   - Kendaraan
   - Tanggal rental

2. Verifikasi Customer
   - Input NIK
   - Tampilkan foto KTP
   - Tampilkan foto SIM
   - Verifikasi identitas

3. Kondisi Kendaraan
   - Upload foto depan
   - Upload foto belakang
   - Upload foto interior
   - Upload foto dashboard
   - Input kilometer awal
   - Input level bahan bakar
   - Catatan kondisi

4. Tanda Tangan Digital
   - Canvas untuk tanda tangan
   - Tombol clear
   - Preview signature

5. Konfirmasi
   - Review semua data
   - Tombol "Serahkan Kunci"
```

#### B. Form Terima Kunci (Admin)
```
Komponen: resources/views/admin/bookings/terima-kunci.blade.php

Sections:
1. Informasi Booking
   - Nomor booking
   - Customer
   - Kendaraan
   - Tanggal rental

2. Kondisi Pickup (Read-only)
   - Foto kondisi awal
   - Kilometer awal
   - Bahan bakar awal

3. Kondisi Return
   - Upload foto depan
   - Upload foto belakang
   - Upload foto interior
   - Upload foto dashboard
   - Input kilometer akhir
   - Input level bahan bakar
   - Upload foto kerusakan (jika ada)
   - Catatan kondisi

4. Perhitungan Biaya
   - Kilometer tempuh
   - Keterlambatan (jika ada)
   - Biaya keterlambatan
   - Kerusakan (jika ada)
   - Biaya kerusakan
   - Total biaya tambahan
   - Deposit dikembalikan

5. Konfirmasi Customer
   - Customer review biaya
   - Customer konfirmasi
   - Tanda tangan digital

6. Finalisasi
   - Tombol "Terima Kunci & Selesaikan"
```

#### C. Tracking Kunci (Customer Dashboard)
```
Komponen: resources/views/customer/partials/kunci-tracking.blade.php

Tampilan:
- Status penyerahan kunci
- Tanggal serah kunci
- Petugas yang menyerahkan
- Foto kondisi pickup
- Download Berita Acara Serah Terima

Jika sudah return:
- Status pengembalian kunci
- Tanggal terima kunci
- Petugas yang menerima
- Foto kondisi return
- Biaya tambahan (jika ada)
- Download Berita Acara Pengembalian
```

---

### FASE 5: MIGRASI DATA

#### A. Migration File Baru
```
database/migrations/2025_12_19_indonesianisasi_database.php

Langkah:
1. Backup data existing
2. Update enum values
3. Rename columns
4. Add new columns
5. Migrate existing data
6. Update indexes
```

#### B. Seeder untuk Data Bahasa Indonesia
```
database/seeders/IndonesianDataSeeder.php

Isi:
- Update car types
- Update transmission types
- Update fuel types
- Update status values
```

---

### FASE 6: UPDATE CONTROLLER & SERVICE

#### A. BookingController
```php
Tambah methods:
- serahKunci(Request $request, Booking $booking)
- storeSerahKunci(Request $request, Booking $booking)
- terimaKunci(Request $request, Booking $booking)
- storeTerimaKunci(Request $request, Booking $booking)
- downloadBeritaAcaraSerah(Booking $booking)
- downloadBeritaAcaraTerima(Booking $booking)
```

#### B. KeyHandoverService (Baru)
```php
app/Services/KeyHandoverService.php

Methods:
- processSerahKunci($booking, $data)
- processTerimaKunci($booking, $data)
- uploadFotoKondisi($booking, $files, $type)
- generateBeritaAcara($booking, $type)
- calculateAdditionalFees($booking, $returnData)
- sendNotificationSerahKunci($booking)
- sendNotificationTerimaKunci($booking)
```

---

### FASE 7: ROUTES BARU

```php
Route::group(['prefix' => 'admin', 'middleware' => 'auth:web'], function() {
    // Penyerahan Kunci
    Route::get('/bookings/{booking}/serah-kunci', [BookingController::class, 'serahKunci'])
        ->name('admin.bookings.serah-kunci');
    Route::post('/bookings/{booking}/serah-kunci', [BookingController::class, 'storeSerahKunci'])
        ->name('admin.bookings.serah-kunci.store');
    
    // Pengembalian Kunci
    Route::get('/bookings/{booking}/terima-kunci', [BookingController::class, 'terimaKunci'])
        ->name('admin.bookings.terima-kunci');
    Route::post('/bookings/{booking}/terima-kunci', [BookingController::class, 'storeTerimaKunci'])
        ->name('admin.bookings.terima-kunci.store');
    
    // Download Berita Acara
    Route::get('/bookings/{booking}/berita-acara-serah', [BookingController::class, 'downloadBeritaAcaraSerah'])
        ->name('admin.bookings.berita-acara-serah');
    Route::get('/bookings/{booking}/berita-acara-terima', [BookingController::class, 'downloadBeritaAcaraTerima'])
        ->name('admin.bookings.berita-acara-terima');
});
```

---

## 🎯 PRIORITAS IMPLEMENTASI

### URGENT (Hari 1-2):
1. ✅ Buat migration untuk kolom baru
2. ✅ Update Model constants
3. ✅ Buat KeyHandoverService
4. ✅ Buat form serah kunci
5. ✅ Buat form terima kunci

### PENTING (Hari 3-4):
6. ✅ Update semua enum di database
7. ✅ Update semua view untuk bahasa Indonesia
8. ✅ Generate PDF Berita Acara
9. ✅ Testing end-to-end

### NICE TO HAVE (Hari 5+):
10. ✅ Signature pad digital
11. ✅ Auto-detect kerusakan dari foto (AI)
12. ✅ SMS notification
13. ✅ Mobile app integration

---

## ⚠️ CATATAN PENTING

1. **Backward Compatibility**: 
   - Buat alias untuk enum lama
   - Gradual migration, tidak langsung hapus

2. **Data Migration**:
   - Backup database sebelum migrate
   - Test di staging dulu
   - Rollback plan jika gagal

3. **User Training**:
   - Dokumentasi untuk admin
   - Video tutorial penyerahan kunci
   - FAQ untuk customer

4. **Performance**:
   - Index untuk kolom baru
   - Optimize query
   - Cache status kunci

---

**Dibuat**: 19 Desember 2025  
**Status**: 📝 Planning Phase  
**Estimasi**: 5-7 hari kerja
