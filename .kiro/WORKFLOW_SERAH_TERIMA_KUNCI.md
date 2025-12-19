# 🔑 WORKFLOW FITUR SERAH TERIMA KUNCI

## 📋 Overview

Dokumentasi lengkap workflow fitur serah terima kunci dari awal hingga akhir, termasuk semua komponen yang terlibat dan cara kerjanya.

---

## 🎯 Komponen Utama

### 1. **Database** ✅
- Kolom di tabel `bookings` untuk tracking serah terima kunci
- Relationships ke tabel `users` untuk petugas

### 2. **Model** ✅
- `Booking.php` dengan helper methods
- Relationships dan validations

### 3. **Service** ✅
- `KeyHandoverService.php` untuk business logic
- Upload foto, calculate fees, notifications

### 4. **Controller** ✅
- `BookingController.php` dengan methods serah/terima kunci
- Validation dan redirect logic

### 5. **Views** ✅
- Form serah kunci (admin)
- Form terima kunci (admin)
- Customer tracking component

### 6. **Routes** ✅
- Admin routes untuk serah/terima kunci
- Proper naming dan middleware

---

## 🔄 COMPLETE WORKFLOW

### **FASE 1: BOOKING CONFIRMED & PAID**

```
Status Booking: confirmed
Payment Status: paid
Kunci Diserahkan: false
Kunci Dikembalikan: false
```

**Yang Bisa Dilakukan:**
- ✅ Admin bisa akses form serah kunci
- ❌ Belum bisa terima kunci (kunci belum diserahkan)
- ❌ Customer belum bisa lihat tracking

**Validasi:**
```php
$booking->bisaSerahKunci()
// Returns: true jika booking_status === 'confirmed' 
//          && payment_status === 'paid' 
//          && !kunci_diserahkan
```

---

### **FASE 2: PENYERAHAN KUNCI (PICKUP)**

#### **Step 1: Admin Akses Form Serah Kunci**

**URL:** `/admin/pemesanan/{booking}/serah-kunci`

**Controller Method:**
```php
public function serahKunci(Booking $booking)
{
    // Cek validasi
    if (!$booking->bisaSerahKunci()) {
        return back()->with('error', 'Booking belum bisa diserahkan kuncinya');
    }
    
    // Load relationships
    $booking->load(['customer', 'car', 'driver']);
    
    // Tampilkan form
    return view('admin.bookings.serah-kunci', compact('booking'));
}
```

**View:** `resources/views/admin/bookings/serah-kunci.blade.php`

**Form Fields:**
1. **Foto Kondisi** (required, multiple files)
   - Foto Depan
   - Foto Belakang
   - Foto Kiri
   - Foto Kanan
   - Foto Interior
   - Foto Dashboard

2. **Tanda Tangan Customer** (required)
   - Canvas signature pad
   - Saved as base64 string

3. **Catatan** (optional)
   - Textarea untuk catatan kondisi kendaraan

#### **Step 2: Submit Form Serah Kunci**

**POST:** `/admin/pemesanan/{booking}/serah-kunci`

**Validation:**
```php
$validated = $request->validate([
    'foto_kondisi.*' => 'required|image|max:5120',  // Max 5MB per foto
    'catatan' => 'nullable|string|max:1000',
    'tanda_tangan' => 'required|string',
]);
```

**Service Process:**
```php
KeyHandoverService::serahKunci($booking, $validated)
```

**Yang Terjadi:**
1. ✅ Upload foto ke `storage/bookings/{booking_id}/serah/`
2. ✅ Simpan path foto sebagai JSON array
3. ✅ Update booking:
   ```php
   [
       'kunci_diserahkan' => true,
       'tanggal_serah_kunci' => now(),
       'petugas_serah_kunci_id' => auth()->id(),
       'foto_serah_kunci' => json_encode($fotoPaths),
       'catatan_serah_kunci' => $catatan,
       'tanda_tangan_customer' => $tandaTangan,
       'booking_status' => 'active',  // ← Status berubah ke ACTIVE
   ]
   ```
4. ✅ Update car status:
   ```php
   $booking->car->update(['status' => 'rented']);
   ```
5. ✅ Send notification (optional)

**Result:**
```
Status Booking: active
Kunci Diserahkan: true
Kunci Dikembalikan: false
Car Status: rented
```

---

### **FASE 3: CUSTOMER TRACKING**

#### **Customer Dashboard**

**URL:** `/pelanggan/dasbor`

**Yang Ditampilkan:**
- Badge "Kunci Diserahkan" (hijau) di recent bookings
- Badge "Sedang Digunakan" (kuning, animasi pulse)

```blade
@if($booking->sudahSerahKunci())
    <span class="bg-green-100 text-green-800">
        ✅ Kunci Diserahkan
    </span>
    
    @if(!$booking->sudahTerimaKunci())
        <span class="bg-yellow-100 text-yellow-800 animate-pulse">
            ⏰ Sedang Digunakan
        </span>
    @endif
@endif
```

#### **Booking Details Page**

**URL:** `/pelanggan/pemesanan/{booking}`

**Component:** `@include('customer.partials.kunci-status')`

**Yang Ditampilkan:**
1. **Timeline Penyerahan Kunci:**
   - ✅ Icon hijau (completed)
   - Tanggal & waktu: 19 Des 2025, 10:00 WIB
   - Petugas: Ahmad (Staff)
   - Foto kondisi (grid 4 kolom, max 4 preview)
   - Catatan petugas

2. **Status Menunggu Pengembalian:**
   - ⏰ Icon kuning (in progress, pulse animation)
   - Tanggal pengembalian: 25 Des 2025, 10:00 WIB
   - Warning jika < 24 jam atau terlambat
   - Info box dengan reminder

---

### **FASE 4: PENGEMBALIAN KUNCI (RETURN)**

#### **Step 1: Admin Akses Form Terima Kunci**

**URL:** `/admin/pemesanan/{booking}/terima-kunci`

**Validasi:**
```php
$booking->bisaTerimaKunci()
// Returns: true jika booking_status === 'active' 
//          && kunci_diserahkan === true
//          && !kunci_dikembalikan
```

**View:** `resources/views/admin/bookings/terima-kunci.blade.php`

**Form Sections:**

1. **Informasi Booking** (read-only)
   - Customer, kendaraan, periode rental
   - Tanggal serah kunci

2. **Kondisi Saat Pickup** (read-only)
   - Foto kondisi saat diserahkan
   - Catatan pickup

3. **Foto Kondisi Return** (required)
   - Foto Depan
   - Foto Belakang
   - Foto Interior
   - Foto Dashboard
   - Foto Kerusakan (optional, multiple)

4. **Detail Pengembalian**
   - Kilometer Akhir (optional)
   - Level Bahan Bakar (optional)
   - Deskripsi Kerusakan (optional)
   - Biaya Kerusakan (optional, muncul jika ada kerusakan)

5. **Perhitungan Biaya** (auto-calculate)
   - Total Rental
   - Deposit
   - Keterlambatan (jika ada)
   - Biaya Kerusakan (jika ada)
   - **Deposit Dikembalikan** = Deposit - (Keterlambatan + Kerusakan)

6. **Catatan** (optional)
   - Textarea untuk catatan pengembalian

7. **Checklist** (required)
   - ☑ Kondisi kendaraan sudah dicek
   - ☑ Kelengkapan kendaraan sudah diperiksa
   - ☑ Foto kondisi sudah diupload
   - ☑ Biaya tambahan sudah dikonfirmasi

#### **Step 2: Submit Form Terima Kunci**

**POST:** `/admin/pemesanan/{booking}/terima-kunci`

**Validation:**
```php
$validated = $request->validate([
    'foto_kondisi.*' => 'required|image|max:5120',
    'kilometer_akhir' => 'nullable|numeric',
    'bahan_bakar_akhir' => 'nullable|string',
    'kerusakan' => 'nullable|string|max:1000',
    'biaya_kerusakan' => 'nullable|numeric|min:0',
    'catatan' => 'nullable|string|max:1000',
]);
```

**Service Process:**
```php
KeyHandoverService::terimaKunci($booking, $validated)
```

**Yang Terjadi:**

1. ✅ Upload foto ke `storage/bookings/{booking_id}/terima/`

2. ✅ Calculate additional fees:
   ```php
   // Late Penalty
   if (now() > $booking->end_date) {
       $lateHours = $booking->end_date->diffInHours(now());
       
       if ($lateHours <= 24) {
           $latePenalty = $lateHours * 50000; // Rp 50k/jam
       } else {
           $lateDays = ceil($lateHours / 24);
           $latePenalty = $lateDays * $car->daily_rate * 1.5; // 150%
       }
   }
   
   // Damage Fee
   $damageFee = $validated['biaya_kerusakan'] ?? 0;
   
   $totalFees = $latePenalty + $damageFee;
   ```

3. ✅ Update booking:
   ```php
   [
       'kunci_dikembalikan' => true,
       'tanggal_terima_kunci' => now(),
       'petugas_terima_kunci_id' => auth()->id(),
       'foto_terima_kunci' => json_encode($fotoPaths),
       'catatan_terima_kunci' => $catatan,
       'actual_return_date' => now(),
       'booking_status' => 'completed',  // ← Status berubah ke COMPLETED
       'late_penalty' => $latePenalty,
   ]
   ```

4. ✅ Update car status:
   ```php
   $booking->car->update(['status' => 'available']);
   ```

5. ✅ Send notification (optional)

**Result:**
```
Status Booking: completed
Kunci Diserahkan: true
Kunci Dikembalikan: true
Car Status: available
```

---

### **FASE 5: COMPLETED - CUSTOMER VIEW**

#### **Customer Dashboard**

**Badges:**
- ✅ "Kunci Diserahkan" (hijau)
- ✅ "Kunci Dikembalikan" (biru)

#### **Booking Details**

**Timeline Lengkap:**

```
┌─────────────────────────────────────┐
│ 🔑 Status Penyerahan Kunci          │
├─────────────────────────────────────┤
│ ✅ Kunci Diserahkan        [Selesai]│
│ 📅 19 Des 2025, 10:00 WIB           │
│ 👤 Petugas: Ahmad                   │
│ 📷 [4 foto kondisi]                 │
│ 📝 Catatan: Kondisi baik...         │
│                                     │
│ ✅ Kunci Dikembalikan      [Selesai]│
│ 📅 25 Des 2025, 09:30 WIB           │
│ 👤 Petugas: Budi                    │
│ 📷 [4 foto kondisi]                 │
│ 📝 Catatan: Kendaraan dalam...      │
└─────────────────────────────────────┘
```

---

## 🔍 VALIDASI & BUSINESS RULES

### **Penyerahan Kunci (Pickup)**

**Syarat:**
1. ✅ Booking status = `confirmed`
2. ✅ Payment status = `paid`
3. ✅ Kunci belum diserahkan (`kunci_diserahkan = false`)

**Setelah Serah Kunci:**
- Booking status → `active`
- Car status → `rented`
- Customer bisa lihat tracking

### **Pengembalian Kunci (Return)**

**Syarat:**
1. ✅ Booking status = `active`
2. ✅ Kunci sudah diserahkan (`kunci_diserahkan = true`)
3. ✅ Kunci belum dikembalikan (`kunci_dikembalikan = false`)

**Setelah Terima Kunci:**
- Booking status → `completed`
- Car status → `available`
- Calculate late penalty (jika ada)
- Calculate damage fee (jika ada)

---

## 💾 DATA STRUCTURE

### **Booking Table Columns**

```sql
-- Penyerahan Kunci
kunci_diserahkan BOOLEAN DEFAULT false
tanggal_serah_kunci DATETIME NULL
petugas_serah_kunci_id BIGINT NULL (FK to users)
foto_serah_kunci TEXT NULL (JSON array of paths)
catatan_serah_kunci TEXT NULL
tanda_tangan_customer TEXT NULL (base64)

-- Pengembalian Kunci
kunci_dikembalikan BOOLEAN DEFAULT false
tanggal_terima_kunci DATETIME NULL
petugas_terima_kunci_id BIGINT NULL (FK to users)
foto_terima_kunci TEXT NULL (JSON array of paths)
catatan_terima_kunci TEXT NULL
```

### **Foto Storage Structure**

```
storage/app/public/bookings/
├── {booking_id}/
│   ├── serah/
│   │   ├── booking_123_serah_1734598800_0.jpg
│   │   ├── booking_123_serah_1734598800_1.jpg
│   │   ├── booking_123_serah_1734598800_2.jpg
│   │   └── ...
│   └── terima/
│       ├── booking_123_terima_1735030800_0.jpg
│       ├── booking_123_terima_1735030800_1.jpg
│       └── ...
```

### **JSON Format for Photos**

```json
[
    "bookings/123/serah/booking_123_serah_1734598800_0.jpg",
    "bookings/123/serah/booking_123_serah_1734598800_1.jpg",
    "bookings/123/serah/booking_123_serah_1734598800_2.jpg"
]
```

---

## 🎨 UI/UX FLOW

### **Admin Side**

1. **Booking List** → Klik booking
2. **Booking Detail** → Button "Serah Kunci" (jika bisa)
3. **Form Serah Kunci** → Upload foto, signature, catatan
4. **Submit** → Redirect ke booking detail dengan success message
5. **Booking Detail** → Button "Terima Kunci" (jika bisa)
6. **Form Terima Kunci** → Upload foto, input data, catatan
7. **Submit** → Redirect ke booking detail dengan success message

### **Customer Side**

1. **Dashboard** → Lihat recent bookings dengan badges
2. **Klik Booking** → Booking details
3. **Scroll ke "Status Penyerahan Kunci"** → Lihat timeline
4. **View Photos** → Klik foto untuk fullscreen
5. **Read Notes** → Lihat catatan petugas

---

## 🔐 SECURITY & PERMISSIONS

### **Admin Routes**
- Middleware: `auth`, `verified`
- Only authenticated admin users
- Access control di controller level

### **Customer Routes**
- Middleware: `auth:customer`, `profile.complete`
- Only authenticated customers
- Can only view their own bookings

### **File Upload Security**
- Validation: `image|max:5120` (5MB)
- Stored in: `storage/app/public/bookings/`
- Access via: `asset('storage/...')`

---

## 📊 TESTING CHECKLIST

### **Penyerahan Kunci**
- [ ] Form validation works
- [ ] File upload works (single & multiple)
- [ ] Signature pad works
- [ ] Data saved correctly
- [ ] Booking status updated to 'active'
- [ ] Car status updated to 'rented'
- [ ] Customer can see tracking

### **Pengembalian Kunci**
- [ ] Form validation works
- [ ] File upload works
- [ ] Late penalty calculated correctly
- [ ] Damage fee calculated correctly
- [ ] Data saved correctly
- [ ] Booking status updated to 'completed'
- [ ] Car status updated to 'available'
- [ ] Customer can see complete timeline

### **Customer Tracking**
- [ ] Badges show correctly on dashboard
- [ ] Timeline displays correctly
- [ ] Photos load correctly
- [ ] Notes display correctly
- [ ] Responsive on mobile
- [ ] Overdue warning shows when late

---

## 🚀 CARA TESTING

### **1. Setup Data**

```sql
-- Buat booking dengan status confirmed & paid
UPDATE bookings 
SET booking_status = 'confirmed', 
    payment_status = 'paid' 
WHERE id = 1;
```

### **2. Test Serah Kunci**

1. Login sebagai admin
2. Buka `/admin/pemesanan/1`
3. Klik button "Serah Kunci"
4. Upload 4-6 foto
5. Buat tanda tangan di canvas
6. Isi catatan (optional)
7. Submit
8. Cek database: `kunci_diserahkan = 1`, `booking_status = 'active'`
9. Cek storage: foto tersimpan di `storage/app/public/bookings/1/serah/`

### **3. Test Customer Tracking**

1. Login sebagai customer (pemilik booking)
2. Buka `/pelanggan/dasbor`
3. Lihat badge "Kunci Diserahkan" dan "Sedang Digunakan"
4. Klik booking
5. Scroll ke "Status Penyerahan Kunci"
6. Lihat timeline, foto, catatan

### **4. Test Terima Kunci**

1. Login sebagai admin
2. Buka `/admin/pemesanan/1`
3. Klik button "Terima Kunci"
4. Upload 4+ foto
5. Isi kilometer, bahan bakar (optional)
6. Jika ada kerusakan: isi deskripsi & biaya
7. Isi catatan (optional)
8. Centang semua checklist
9. Submit
10. Cek database: `kunci_dikembalikan = 1`, `booking_status = 'completed'`
11. Cek storage: foto tersimpan di `storage/app/public/bookings/1/terima/`

### **5. Test Customer View Completed**

1. Login sebagai customer
2. Buka `/pelanggan/dasbor`
3. Lihat badge "Kunci Dikembalikan"
4. Klik booking
5. Lihat timeline lengkap (serah + terima)

---

## 🐛 TROUBLESHOOTING

### **Problem: Button "Serah Kunci" tidak muncul**

**Cek:**
1. Booking status = `confirmed`?
2. Payment status = `paid`?
3. `kunci_diserahkan = false`?

### **Problem: Upload foto gagal**

**Cek:**
1. Storage link: `php artisan storage:link`
2. Permissions: `chmod -R 775 storage`
3. File size < 5MB?
4. Format: jpg, jpeg, png?

### **Problem: Customer tidak bisa lihat tracking**

**Cek:**
1. `kunci_diserahkan = true`?
2. Customer login dengan account yang benar?
3. Booking belongs to customer?

### **Problem: Late penalty tidak terhitung**

**Cek:**
1. `end_date` sudah lewat?
2. `actual_return_date` > `end_date`?
3. Logic di `KeyHandoverService::calculateAdditionalFees()`

---

**Status:** ✅ **FULLY FUNCTIONAL**  
**Last Updated:** 19 Desember 2025, 16:25 WIB  
**Version:** 1.0.0
