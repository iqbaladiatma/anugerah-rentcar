# 🔑 IMPLEMENTASI FITUR PENYERAHAN KUNCI

## ✅ FASE 1: DATABASE (SELESAI)

### Kolom Baru di Tabel `bookings`:

**Penyerahan Kunci (Pickup):**
- ✅ `kunci_diserahkan` - Boolean, default false
- ✅ `tanggal_serah_kunci` - DateTime, nullable
- ✅ `petugas_serah_kunci_id` - FK ke users, nullable
- ✅ `foto_serah_kunci` - String (path), nullable
- ✅ `catatan_serah_kunci` - Text, nullable
- ✅ `tanda_tangan_customer` - Text (base64), nullable

**Pengembalian Kunci (Return):**
- ✅ `kunci_dikembalikan` - Boolean, default false
- ✅ `tanggal_terima_kunci` - DateTime, nullable
- ✅ `petugas_terima_kunci_id` - FK ke users, nullable
- ✅ `foto_terima_kunci` - String (path), nullable
- ✅ `catatan_terima_kunci` - Text, nullable

---

## 📝 FASE 2: UPDATE MODEL BOOKING

### File: `app/Models/Booking.php`

**Tambahkan ke $fillable:**
```php
'kunci_diserahkan',
'tanggal_serah_kunci',
'petugas_serah_kunci_id',
'foto_serah_kunci',
'catatan_serah_kunci',
'tanda_tangan_customer',
'kunci_dikembalikan',
'tanggal_terima_kunci',
'petugas_terima_kunci_id',
'foto_terima_kunci',
'catatan_terima_kunci',
```

**Tambahkan relationships:**
```php
public function petugasSerahKunci()
{
    return $this->belongsTo(User::class, 'petugas_serah_kunci_id');
}

public function petugasTerimaKunci()
{
    return $this->belongsTo(User::class, 'petugas_terima_kunci_id');
}
```

**Tambahkan helper methods:**
```php
public function bisaSerahKunci()
{
    return $this->booking_status === 'confirmed' 
        && $this->payment_status === 'paid'
        && !$this->kunci_diserahkan;
}

public function bisaTerimaKunci()
{
    return $this->booking_status === 'active'
        && $this->kunci_diserahkan
        && !$this->kunci_dikembalikan;
}

public function sudahSerahKunci()
{
    return $this->kunci_diserahkan;
}

public function sudahTerimaKunci()
{
    return $this->kunci_dikembalikan;
}
```

---

## 🎯 FASE 3: BUAT SERVICE

### File: `app/Services/KeyHandoverService.php`

**Methods:**
1. `serahKunci($booking, $data)` - Proses penyerahan kunci
2. `terimaKunci($booking, $data)` - Proses pengembalian kunci
3. `uploadFotoKondisi($files, $bookingId, $type)` - Upload foto
4. `generateBeritaAcara($booking, $type)` - Generate PDF
5. `sendNotification($booking, $type)` - Kirim notifikasi

---

## 🎨 FASE 4: BUAT UI COMPONENTS

### A. Form Serah Kunci
**File:** `resources/views/admin/bookings/serah-kunci.blade.php`

**Sections:**
1. Header - Info booking
2. Verifikasi Customer - Tampilkan dokumen
3. Upload Foto Kondisi - Multiple upload
4. Tanda Tangan Digital - Canvas signature pad
5. Catatan - Textarea
6. Submit Button

### B. Form Terima Kunci
**File:** `resources/views/admin/bookings/terima-kunci.blade.php`

**Sections:**
1. Header - Info booking
2. Kondisi Pickup - Display foto serah kunci
3. Upload Foto Return - Multiple upload
4. Perhitungan Biaya - Auto calculate
5. Catatan - Textarea
6. Submit Button

### C. Customer Tracking
**File:** `resources/views/customer/partials/kunci-status.blade.php`

**Tampilan:**
- Status penyerahan kunci
- Timeline tracking
- Download berita acara

---

## 🛣️ FASE 5: ROUTES

### File: `routes/web.php`

```php
// Admin - Penyerahan Kunci
Route::get('/admin/bookings/{booking}/serah-kunci', [BookingController::class, 'serahKunci'])
    ->name('admin.bookings.serah-kunci');
Route::post('/admin/bookings/{booking}/serah-kunci', [BookingController::class, 'storeSerahKunci'])
    ->name('admin.bookings.serah-kunci.store');

// Admin - Pengembalian Kunci
Route::get('/admin/bookings/{booking}/terima-kunci', [BookingController::class, 'terimaKunci'])
    ->name('admin.bookings.terima-kunci');
Route::post('/admin/bookings/{booking}/terima-kunci', [BookingController::class, 'storeTerimaKunci'])
    ->name('admin.bookings.terima-kunci.store');

// Download Berita Acara
Route::get('/admin/bookings/{booking}/berita-acara-serah', [BookingController::class, 'beritaAcaraSerah'])
    ->name('admin.bookings.berita-acara-serah');
Route::get('/admin/bookings/{booking}/berita-acara-terima', [BookingController::class, 'beritaAcaraTerima'])
    ->name('admin.bookings.berita-acara-terima');
```

---

## 🎬 FASE 6: CONTROLLER METHODS

### File: `app/Http/Controllers/BookingController.php`

**Methods baru:**

```php
public function serahKunci(Booking $booking)
{
    // Cek apakah bisa serah kunci
    if (!$booking->bisaSerahKunci()) {
        return back()->with('error', 'Booking belum bisa diserahkan kuncinya');
    }
    
    return view('admin.bookings.serah-kunci', compact('booking'));
}

public function storeSerahKunci(Request $request, Booking $booking)
{
    $validated = $request->validate([
        'foto_kondisi.*' => 'required|image|max:5120',
        'catatan' => 'nullable|string',
        'tanda_tangan' => 'required|string',
    ]);
    
    $keyHandoverService = app(KeyHandoverService::class);
    $keyHandoverService->serahKunci($booking, $validated);
    
    return redirect()->route('admin.bookings.show', $booking)
        ->with('success', 'Kunci berhasil diserahkan');
}

public function terimaKunci(Booking $booking)
{
    // Cek apakah bisa terima kunci
    if (!$booking->bisaTerimaKunci()) {
        return back()->with('error', 'Kunci belum bisa diterima');
    }
    
    return view('admin.bookings.terima-kunci', compact('booking'));
}

public function storeTerimaKunci(Request $request, Booking $booking)
{
    $validated = $request->validate([
        'foto_kondisi.*' => 'required|image|max:5120',
        'kilometer_akhir' => 'required|numeric',
        'bahan_bakar_akhir' => 'required|string',
        'kerusakan' => 'nullable|string',
        'biaya_kerusakan' => 'nullable|numeric',
        'catatan' => 'nullable|string',
    ]);
    
    $keyHandoverService = app(KeyHandoverService::class);
    $keyHandoverService->terimaKunci($booking, $validated);
    
    return redirect()->route('admin.bookings.show', $booking)
        ->with('success', 'Kunci berhasil diterima dan booking diselesaikan');
}
```

---

## 📊 FASE 7: TRACKING DI CUSTOMER DASHBOARD

### Update: `resources/views/customer/dashboard.blade.php`

Tambahkan section untuk tracking kunci pada active bookings.

**Tampilan:**
```
┌─────────────────────────────────────┐
│ 🔑 Status Penyerahan Kunci          │
├─────────────────────────────────────┤
│ ✅ Kunci Diserahkan                 │
│ 📅 19 Des 2025, 10:00 WIB           │
│ 👤 Petugas: Ahmad (Staff)           │
│ 📄 Download Berita Acara            │
└─────────────────────────────────────┘
```

---

## 🔔 FASE 8: NOTIFIKASI

### Event & Listener Baru:

**Events:**
- `KeyHandedOver` - Kunci diserahkan
- `KeyReturned` - Kunci dikembalikan

**Listeners:**
- `SendKeyHandoverNotification` - Notif ke customer
- `SendKeyReturnNotification` - Notif ke customer

**Notifikasi:**
- Email ke customer dengan berita acara
- SMS reminder (optional)
- Push notification (optional)

---

## 📱 FASE 9: SIGNATURE PAD

### Library: Signature Pad JS

**Installation:**
```bash
npm install signature_pad
```

**Usage:**
```javascript
const canvas = document.getElementById('signature-pad');
const signaturePad = new SignaturePad(canvas);

// Save
const dataURL = signaturePad.toDataURL();

// Clear
signaturePad.clear();
```

---

## 📄 FASE 10: PDF BERITA ACARA

### Template: `resources/views/pdf/berita-acara-serah.blade.php`

**Content:**
- Header perusahaan
- Nomor berita acara
- Tanggal & waktu
- Data customer
- Data kendaraan
- Kondisi kendaraan (foto)
- Tanda tangan customer
- Tanda tangan petugas

---

## ✅ CHECKLIST IMPLEMENTASI

### Week 1: Core Features
- [x] Database migration
- [x] Update Booking model
- [x] Buat KeyHandoverService
- [x] Buat form serah kunci
- [x] Buat form terima kunci
- [x] Implement signature pad
- [x] Upload foto kondisi
- [x] Customer tracking component
- [ ] Generate PDF berita acara

### Week 2: Testing & Polish
- [ ] Unit testing
- [ ] Integration testing
- [ ] UI/UX polish
- [ ] Bug fixing
- [ ] Documentation
- [ ] User training

---

## 🎯 NEXT STEPS

1. ✅ Update Model Booking
2. ✅ Buat KeyHandoverService
3. ✅ Buat UI Form Serah Kunci
4. ✅ Implement Signature Pad
5. ✅ Testing

---

**Status**: 🚀 Migration Done - Ready for Implementation  
**Updated**: 19 Desember 2025, 15:36 WIB
