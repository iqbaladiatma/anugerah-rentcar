# Auto-Expand Sidebar Dropdown

## Fitur

Sidebar admin sekarang akan **otomatis membuka (expand) dropdown** ketika Anda sedang berada di salah satu halaman dalam dropdown tersebut.

### Contoh Penggunaan

**✅ Sebelum:**
- User di halaman `/admin/reports/profitability`
- Dropdown "Financial Management" tertutup (collapsed)
- User harus klik dropdown untuk melihat menu aktif

**🎉 Sekarang:**
- User di halaman `/admin/reports/profitability`
- Dropdown "Financial Management" **otomatis terbuka (expanded)**
- User langsung bisa lihat menu aktif dengan highlight

## Cara Kerja

### 1. Active Route Detection

Di file `admin-sidebar.blade.php`, kita menggunakan `@php` block untuk check apakah ada child route yang sedang active:

```php
@php
    // Check if any child route is currently active
    $isActive = false;
    foreach($item['children'] as $child) {
        if(request()->routeIs($child['route'] . '*')) {
            $isActive = true;
            break;
        }
    }
@endphp
```

### 2. Alpine.js State Initialization

Hasil dari check di atas digunakan untuk menginisialisasi state Alpine.js:

```html
<li x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">
```

- Jika `$isActive = true` → dropdown akan open secara default
- Jika `$isActive = false` → dropdown akan closed secara default

### 3. User Dapat Toggle

Meskipun dropdown auto-expand, user tetap bisa:
- **Klik button** untuk collapse dropdown
- **Klik lagi** untuk expand kembali
- State akan **persist** sampai user navigate ke halaman lain

## Dropdown yang Terpengaruh

Semua dropdown menu akan auto-expand ketika berada di halaman yang relevan:

### 1. **Fleet Management**
- `/admin/vehicles/*` → Fleet dropdown terbuka
- `/admin/maintenance/*` → Fleet dropdown terbuka
- `/admin/availability/timeline` → Fleet dropdown terbuka

### 2. **Customer Management**
- `/admin/customers/*` → Customer dropdown terbuka
- `/admin/customers/members` → Customer dropdown terbuka
- `/admin/customers/blacklist` → Customer dropdown terbuka

### 3. **Booking Management**
- `/admin/bookings/*` → Booking dropdown terbuka

### 4. **Financial Management** 
- `/admin/expenses/*` → Financial dropdown terbuka
- `/admin/reports/*` → Financial dropdown terbuka
- `/admin/reports/profitability` → Financial dropdown terbuka ✅

### 5. **System Settings**
- `/admin/settings/*` → Settings dropdown terbuka

## Visual Indicators

Ketika dropdown terbuka karena halaman aktif:

1. **Button dropdown** akan ter-highlight dengan:
   - Background: `bg-gray-50`
   - Text color: `text-blue-600`

2. **Arrow icon** akan rotate 90°:
   ```html
   :class="{ 'rotate-90': open }"
   ```

3. **Menu item aktif** akan ter-highlight dengan:
   - Background: `bg-gray-50`
   - Text color: `text-blue-600`
   - Font weight: `font-medium`

## Kode yang Diubah

### File: `resources/views/livewire/layout/admin-sidebar.blade.php`

**Sebelum:**
```html
<li x-data="{ open: {{ request()->routeIs(...complex logic...) ? 'true' : 'false' }} }">
```

**Sesudah:**
```html
@php
    $isActive = false;
    foreach($item['children'] as $child) {
        if(request()->routeIs($child['route'] . '*')) {
            $isActive = true;
            break;
        }
    }
@endphp
<li x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">
```

## Benefits

✅ **UX Lebih Baik** - User langsung tahu dimana mereka berada  
✅ **Navigation Lebih Cepat** - Tidak perlu klik dropdown lagi  
✅ **Visual Context** - Dropdown yang terbuka menunjukkan konteks halaman saat ini  
✅ **Tetap Flexible** - User masih bisa collapse jika mau  

## Troubleshooting

### Dropdown tidak auto-expand?

**Cek:**
1. Clear view cache: `php artisan view:clear`
2. Pastikan route name match dengan yang di `AdminSidebar.php`
3. Cek browser console untuk Alpine.js errors

### Dropdown terbuka di halaman yang salah?

**Periksa:**
1. Pattern route harus menggunakan wildcard `*`
2. Route name harus sesuai dengan convention
3. Example: `admin.reports.profitability` → check dengan `admin.reports.profitability*`

## Testing Checklist

- [ ] Buka `/admin/vehicles` → Fleet dropdown terbuka
- [ ] Buka `/admin/customers` → Customer dropdown terbuka
- [ ] Buka `/admin/bookings` → Booking dropdown terbuka
- [ ] Buka `/admin/reports/profitability` → Financial dropdown terbuka ✅
- [ ] Buka `/admin/settings/company` → Settings dropdown terbuka
- [ ] Klik dropdown untuk collapse → berhasil
- [ ] Klik lagi untuk expand → berhasil
- [ ] Navigate ke halaman lain → dropdown state reset sesuai halaman baru
