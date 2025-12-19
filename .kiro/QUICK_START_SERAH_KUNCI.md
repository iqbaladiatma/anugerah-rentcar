# 🚀 QUICK START GUIDE - FITUR SERAH TERIMA KUNCI

## ⚡ TL;DR - Cara Cepat Testing

### 1️⃣ **Setup Database** (Sudah Selesai ✅)
```bash
# Migration sudah jalan, tidak perlu run lagi
```

### 2️⃣ **Prepare Test Data**
```sql
-- Buat/update booking untuk testing
UPDATE bookings 
SET booking_status = 'confirmed', 
    payment_status = 'paid',
    kunci_diserahkan = 0,
    kunci_dikembalikan = 0
WHERE id = 1;
```

### 3️⃣ **Test Serah Kunci (Admin)**

**URL:** `http://localhost/admin/pemesanan/1/serah-kunci`

**Steps:**
1. Login sebagai admin
2. Buka booking detail
3. Klik button **"Serah Kunci"**
4. Upload minimal 4 foto kendaraan
5. Buat tanda tangan di canvas
6. Isi catatan (optional)
7. Klik **"Serahkan Kunci & Aktifkan Booking"**

**Expected Result:**
- ✅ Success message muncul
- ✅ Booking status → `active`
- ✅ Car status → `rented`
- ✅ Foto tersimpan di `storage/app/public/bookings/1/serah/`

### 4️⃣ **Test Customer Tracking**

**URL:** `http://localhost/pelanggan/dasbor`

**Steps:**
1. Login sebagai customer (pemilik booking)
2. Lihat dashboard
3. Cek badge **"Kunci Diserahkan"** (hijau)
4. Cek badge **"Sedang Digunakan"** (kuning, pulse)
5. Klik booking untuk detail
6. Scroll ke section **"Status Penyerahan Kunci"**

**Expected Result:**
- ✅ Timeline menampilkan penyerahan kunci
- ✅ Tanggal & waktu serah kunci
- ✅ Nama petugas
- ✅ Foto kondisi kendaraan (grid 4 kolom)
- ✅ Catatan petugas
- ✅ Status "Menunggu Pengembalian" dengan reminder

### 5️⃣ **Test Terima Kunci (Admin)**

**URL:** `http://localhost/admin/pemesanan/1/terima-kunci`

**Steps:**
1. Login sebagai admin
2. Buka booking detail
3. Klik button **"Terima Kunci"**
4. Upload minimal 4 foto kondisi return
5. Isi kilometer akhir (optional)
6. Isi level bahan bakar (optional)
7. Jika ada kerusakan:
   - Isi deskripsi kerusakan
   - Isi biaya kerusakan
8. Isi catatan (optional)
9. Centang semua checklist
10. Klik **"Terima Kunci & Selesaikan"**

**Expected Result:**
- ✅ Success message muncul
- ✅ Booking status → `completed`
- ✅ Car status → `available`
- ✅ Late penalty terhitung (jika terlambat)
- ✅ Foto tersimpan di `storage/app/public/bookings/1/terima/`

### 6️⃣ **Verify Customer View**

**URL:** `http://localhost/pelanggan/pemesanan/1`

**Expected Result:**
- ✅ Timeline lengkap (serah + terima)
- ✅ Badge "Kunci Dikembalikan" (biru)
- ✅ Semua foto dan catatan tampil

---

## 📋 CHECKLIST KOMPONEN

### ✅ **Yang Sudah Ada & Berfungsi:**

#### **Database**
- [x] Migration untuk kolom serah terima kunci
- [x] Relationships ke tabel users

#### **Model**
- [x] `Booking.php` dengan fillable columns
- [x] Helper methods: `bisaSerahKunci()`, `bisaTerimaKunci()`, `sudahSerahKunci()`, `sudahTerimaKunci()`
- [x] Relationships: `petugasSerahKunci()`, `petugasTerimaKunci()`

#### **Service**
- [x] `KeyHandoverService.php`
- [x] Method `serahKunci()` - Upload foto, update booking, update car
- [x] Method `terimaKunci()` - Upload foto, calculate fees, update booking
- [x] Method `uploadFotoKondisi()` - Handle file upload
- [x] Method `calculateAdditionalFees()` - Calculate late penalty & damage fee

#### **Controller**
- [x] `BookingController.php`
- [x] Method `serahKunci()` - Show form
- [x] Method `storeSerahKunci()` - Process submission
- [x] Method `terimaKunci()` - Show form
- [x] Method `storeTerimaKunci()` - Process submission

#### **Views - Admin**
- [x] `admin/bookings/serah-kunci.blade.php` - Form penyerahan kunci
- [x] `admin/bookings/terima-kunci.blade.php` - Form pengembalian kunci
- [x] Signature pad integration
- [x] Multiple file upload
- [x] Auto-calculate fees

#### **Views - Customer**
- [x] `customer/partials/kunci-status.blade.php` - Tracking component
- [x] Integration di `customer/dashboard.blade.php` - Status badges
- [x] Integration di `customer/booking-details.blade.php` - Full timeline
- [x] Responsive design
- [x] Photo galleries

#### **Routes**
- [x] `GET /admin/pemesanan/{booking}/serah-kunci`
- [x] `POST /admin/pemesanan/{booking}/serah-kunci`
- [x] `GET /admin/pemesanan/{booking}/terima-kunci`
- [x] `POST /admin/pemesanan/{booking}/terima-kunci`

---

## 🎯 STATUS TRANSITIONS

```
CONFIRMED → SERAH KUNCI → ACTIVE → TERIMA KUNCI → COMPLETED
   (paid)                (rented)                  (available)
```

### **Booking Status Flow:**
1. `pending` → Customer buat booking
2. `confirmed` → Admin konfirmasi & customer bayar
3. `active` → **Kunci diserahkan** ✅
4. `completed` → **Kunci dikembalikan** ✅

### **Car Status Flow:**
1. `available` → Mobil tersedia
2. `rented` → **Kunci diserahkan** ✅
3. `available` → **Kunci dikembalikan** ✅

---

## 🔑 HELPER METHODS PENTING

```php
// Cek apakah bisa serah kunci
$booking->bisaSerahKunci()
// Returns: booking_status === 'confirmed' 
//          && payment_status === 'paid' 
//          && !kunci_diserahkan

// Cek apakah bisa terima kunci
$booking->bisaTerimaKunci()
// Returns: booking_status === 'active' 
//          && kunci_diserahkan 
//          && !kunci_dikembalikan

// Cek apakah sudah serah kunci
$booking->sudahSerahKunci()
// Returns: (bool) kunci_diserahkan

// Cek apakah sudah terima kunci
$booking->sudahTerimaKunci()
// Returns: (bool) kunci_dikembalikan

// Cek apakah terlambat
$booking->isOverdue()
// Returns: booking_status === 'active' && now() > end_date
```

---

## 💰 PERHITUNGAN BIAYA

### **Late Penalty (Denda Keterlambatan)**

```php
if (now() > $booking->end_date) {
    $lateHours = $booking->end_date->diffInHours(now());
    
    if ($lateHours <= 24) {
        // Denda per jam untuk keterlambatan < 24 jam
        $penalty = $lateHours * 50000; // Rp 50.000/jam
    } else {
        // Denda per hari untuk keterlambatan > 24 jam
        $lateDays = ceil($lateHours / 24);
        $penalty = $lateDays * $car->daily_rate * 1.5; // 150% dari harga normal
    }
}
```

### **Deposit Return (Pengembalian Deposit)**

```php
$depositReturn = $booking->deposit_amount - ($latePenalty + $damageFee);

// Jika deposit tidak cukup untuk cover biaya tambahan
if ($depositReturn < 0) {
    // Customer harus bayar selisihnya
    $additionalPayment = abs($depositReturn);
}
```

---

## 📸 FOTO REQUIREMENTS

### **Penyerahan Kunci (Pickup)**
**Minimum 4 foto:**
1. Foto Depan
2. Foto Belakang
3. Foto Kiri/Kanan
4. Foto Interior/Dashboard

### **Pengembalian Kunci (Return)**
**Minimum 4 foto:**
1. Foto Depan
2. Foto Belakang
3. Foto Interior
4. Foto Dashboard

**Plus (Optional):**
- Foto Kerusakan (jika ada)

### **Specifications:**
- Format: JPG, JPEG, PNG
- Max size: 5MB per file
- Storage: `storage/app/public/bookings/{booking_id}/{type}/`
- Naming: `booking_{id}_{type}_{timestamp}_{index}.{ext}`

---

## 🐛 COMMON ISSUES & SOLUTIONS

### **Issue 1: Button "Serah Kunci" tidak muncul**

**Solusi:**
```sql
-- Pastikan booking sudah confirmed & paid
UPDATE bookings 
SET booking_status = 'confirmed', 
    payment_status = 'paid' 
WHERE id = 1;
```

### **Issue 2: Upload foto error**

**Solusi:**
```bash
# Buat symlink storage
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache

# Windows: pastikan folder storage writable
```

### **Issue 3: Signature pad tidak muncul**

**Solusi:**
- Cek browser console untuk errors
- Pastikan JavaScript loaded
- Clear browser cache

### **Issue 4: Customer tidak bisa lihat tracking**

**Solusi:**
```php
// Pastikan kunci sudah diserahkan
$booking->kunci_diserahkan; // harus true

// Pastikan customer login dengan account yang benar
auth('customer')->id() === $booking->customer_id
```

---

## 📱 RESPONSIVE TESTING

### **Desktop (1920x1080)**
- ✅ Full layout dengan sidebar
- ✅ 4-column photo grid
- ✅ Side-by-side timeline

### **Tablet (768x1024)**
- ✅ Stacked layout
- ✅ 3-column photo grid
- ✅ Adjusted spacing

### **Mobile (375x667)**
- ✅ Vertical layout
- ✅ 2-column photo grid
- ✅ Compact badges
- ✅ Touch-friendly buttons

---

## 🎨 UI COMPONENTS

### **Status Badges**

```blade
{{-- Kunci Diserahkan --}}
<span class="bg-green-100 text-green-800">
    ✅ Kunci Diserahkan
</span>

{{-- Sedang Digunakan --}}
<span class="bg-yellow-100 text-yellow-800 animate-pulse">
    ⏰ Sedang Digunakan
</span>

{{-- Kunci Dikembalikan --}}
<span class="bg-blue-100 text-blue-800">
    ✅ Kunci Dikembalikan
</span>
```

### **Timeline Icons**

```blade
{{-- Completed --}}
<div class="w-6 h-6 bg-green-500 rounded-full">
    <svg>✓</svg>
</div>

{{-- In Progress --}}
<div class="w-6 h-6 bg-yellow-400 rounded-full animate-pulse">
    <svg>⏰</svg>
</div>
```

---

## 🔗 USEFUL LINKS

### **Admin URLs**
- Booking List: `/admin/pemesanan`
- Booking Detail: `/admin/pemesanan/{id}`
- Serah Kunci: `/admin/pemesanan/{id}/serah-kunci`
- Terima Kunci: `/admin/pemesanan/{id}/terima-kunci`

### **Customer URLs**
- Dashboard: `/pelanggan/dasbor`
- Bookings: `/pelanggan/pemesanan`
- Booking Detail: `/pelanggan/pemesanan/{id}`

---

## 📞 SUPPORT

Jika ada masalah atau pertanyaan:

1. **Cek dokumentasi lengkap:** `WORKFLOW_SERAH_TERIMA_KUNCI.md`
2. **Cek component docs:** `CUSTOMER_TRACKING_COMPONENT.md`
3. **Cek implementation plan:** `IMPLEMENTASI_PENYERAHAN_KUNCI.md`

---

**Status:** ✅ **READY TO USE**  
**Last Updated:** 19 Desember 2025, 16:30 WIB  
**Version:** 1.0.0
