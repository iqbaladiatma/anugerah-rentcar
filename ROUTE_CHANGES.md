# 📋 Dokumentasi Perubahan Route ke Bahasa Indonesia

## 🎯 Ringkasan Perubahan

Semua route URL telah diubah dari bahasa Inggris ke bahasa Indonesia untuk meningkatkan user experience bagi pengguna Indonesia. Route names tetap menggunakan format yang sama untuk backward compatibility.

---

## 🌐 Public Routes

| Route Lama | Route Baru | Route Name | Keterangan |
|------------|------------|------------|------------|
| `/vehicles` | `/kendaraan` | `vehicles.catalog` | Katalog kendaraan |
| `/vehicles/{car}` | `/kendaraan/{car}` | `vehicles.show` | Detail kendaraan |
| `/vehicles/search` | `/kendaraan/cari` | `vehicles.search` | Pencarian kendaraan |
| `/vehicles/check-availability` | `/kendaraan/cek-ketersediaan` | `vehicles.check-availability` | Cek ketersediaan |
| `/login` | `/masuk` | `login` | Halaman login |
| `/logout` | `/keluar` | `logout` | Logout |
| `/booking/wizard` | `/pemesanan/wizard` | `booking.wizard` | Wizard pemesanan |
| `/booking/complete` | `/pemesanan/selesai` | `booking.complete` | Selesaikan pemesanan |
| `/booking/{booking}/confirmation` | `/pemesanan/{booking}/konfirmasi` | `booking.confirmation` | Konfirmasi pemesanan |

---

## 👤 Customer Routes

Prefix berubah dari `/customer` menjadi `/pelanggan`

| Route Lama | Route Baru | Route Name | Keterangan |
|------------|------------|------------|------------|
| `/customer/register` | `/pelanggan/daftar` | `customer.register` | Registrasi pelanggan |
| `/customer/complete-profile` | `/pelanggan/lengkapi-profil` | `customer.complete-profile` | Lengkapi profil |
| `/customer/dashboard` | `/pelanggan/dasbor` | `customer.dashboard` | Dashboard pelanggan |
| `/customer/bookings` | `/pelanggan/pemesanan` | `customer.bookings` | Daftar pemesanan |
| `/customer/bookings/{booking}` | `/pelanggan/pemesanan/{booking}` | `customer.bookings.show` | Detail pemesanan |
| `/customer/bookings/{booking}/edit` | `/pelanggan/pemesanan/{booking}/ubah` | `customer.bookings.edit` | Ubah pemesanan |
| `/customer/bookings/{booking}/ticket` | `/pelanggan/pemesanan/{booking}/tiket` | `customer.bookings.ticket` | Download tiket |
| `/customer/profile` | `/pelanggan/profil` | `customer.profile` | Profil pelanggan |
| `/customer/support` | `/pelanggan/dukungan` | `customer.support` | Dukungan pelanggan |
| `/customer/logout` | `/pelanggan/keluar` | `customer.logout` | Logout pelanggan |

---

## 🔐 Admin Routes

Prefix tetap `/admin`, tetapi sub-routes diubah ke bahasa Indonesia

### Kendaraan (Vehicles)
| Route Lama | Route Baru | Route Name |
|------------|------------|------------|
| `/admin/vehicles` | `/admin/kendaraan` | `admin.vehicles.index` |
| `/admin/vehicles/create` | `/admin/kendaraan/create` | `admin.vehicles.create` |
| `/admin/vehicles/{car}` | `/admin/kendaraan/{car}` | `admin.vehicles.show` |
| `/admin/vehicles/{car}/edit` | `/admin/kendaraan/{car}/edit` | `admin.vehicles.edit` |
| `/admin/vehicles/{car}/status` | `/admin/kendaraan/{car}/status` | `admin.vehicles.update-status` |
| `/admin/vehicles/maintenance/due` | `/admin/kendaraan/perawatan/jatuh-tempo` | `admin.vehicles.maintenance-due` |

### Pelanggan (Customers)
| Route Lama | Route Baru | Route Name |
|------------|------------|------------|
| `/admin/customers` | `/admin/pelanggan` | `admin.customers.index` |
| `/admin/customers/create` | `/admin/pelanggan/create` | `admin.customers.create` |
| `/admin/customers/{customer}` | `/admin/pelanggan/{customer}` | `admin.customers.show` |
| `/admin/customers/{customer}/edit` | `/admin/pelanggan/{customer}/edit` | `admin.customers.edit` |
| `/admin/customers/members` | `/admin/pelanggan/anggota` | `admin.customers.members` |
| `/admin/customers/blacklist` | `/admin/pelanggan/daftar-hitam` | `admin.customers.blacklist` |
| `/admin/customers/search` | `/admin/pelanggan/cari` | `admin.customers.search` |
| `/admin/customers/{customer}/member-status` | `/admin/pelanggan/{customer}/status-anggota` | `admin.customers.update-member-status` |
| `/admin/customers/{customer}/blacklist-status` | `/admin/pelanggan/{customer}/status-daftar-hitam` | `admin.customers.update-blacklist-status` |
| `/admin/customers/{customer}/validate-booking` | `/admin/pelanggan/{customer}/validasi-pemesanan` | `admin.customers.validate-booking` |

### Pemesanan (Bookings)
| Route Lama | Route Baru | Route Name |
|------------|------------|------------|
| `/admin/bookings` | `/admin/pemesanan` | `admin.bookings.index` |
| `/admin/bookings/create` | `/admin/pemesanan/create` | `admin.bookings.create` |
| `/admin/bookings/{booking}` | `/admin/pemesanan/{booking}` | `admin.bookings.show` |
| `/admin/bookings/{booking}/edit` | `/admin/pemesanan/{booking}/edit` | `admin.bookings.edit` |
| `/admin/bookings/{booking}/confirm` | `/admin/pemesanan/{booking}/konfirmasi` | `admin.bookings.confirm` |
| `/admin/bookings/{booking}/activate` | `/admin/pemesanan/{booking}/aktifkan` | `admin.bookings.activate` |
| `/admin/bookings/{booking}/complete` | `/admin/pemesanan/{booking}/selesai` | `admin.bookings.complete` |
| `/admin/bookings/{booking}/cancel` | `/admin/pemesanan/{booking}/batal` | `admin.bookings.cancel` |
| `/admin/bookings/{booking}/checkout` | `/admin/pemesanan/{booking}/checkout` | `admin.bookings.checkout` |
| `/admin/bookings/{booking}/checkin` | `/admin/pemesanan/{booking}/checkin` | `admin.bookings.checkin` |
| `/admin/bookings/calculate-price` | `/admin/pemesanan/hitung-harga` | `admin.bookings.calculate-price` |
| `/admin/bookings/check-availability` | `/admin/pemesanan/cek-ketersediaan` | `admin.bookings.check-availability` |
| `/admin/bookings/search/api` | `/admin/pemesanan/cari/api` | `admin.bookings.search` |
| `/admin/bookings/statistics/api` | `/admin/pemesanan/statistik/api` | `admin.bookings.statistics` |
| `/admin/bookings/drivers/available` | `/admin/pemesanan/sopir/tersedia` | `admin.bookings.available-drivers` |

### Perawatan (Maintenance)
| Route Lama | Route Baru | Route Name |
|------------|------------|------------|
| `/admin/maintenance` | `/admin/perawatan` | `admin.maintenance.index` |
| `/admin/maintenance/create` | `/admin/perawatan/create` | `admin.maintenance.create` |
| `/admin/maintenance/{maintenance}` | `/admin/perawatan/{maintenance}` | `admin.maintenance.show` |
| `/admin/maintenance/{maintenance}/edit` | `/admin/perawatan/{maintenance}/edit` | `admin.maintenance.edit` |
| `/admin/maintenance/{maintenance}/complete` | `/admin/perawatan/{maintenance}/selesai` | `admin.maintenance.complete` |
| `/admin/maintenance/reminders/api` | `/admin/perawatan/pengingat/api` | `admin.maintenance.reminders` |
| `/admin/maintenance/schedule` | `/admin/perawatan/jadwal` | `admin.maintenance.schedule` |
| `/admin/maintenance/analytics/api` | `/admin/perawatan/analitik/api` | `admin.maintenance.analytics` |
| `/admin/maintenance/export` | `/admin/perawatan/ekspor` | `admin.maintenance.export` |
| `/admin/maintenance/car/{car}/history` | `/admin/perawatan/kendaraan/{car}/riwayat` | `admin.maintenance.car-history` |

### Pengeluaran (Expenses)
| Route Lama | Route Baru | Route Name |
|------------|------------|------------|
| `/admin/expenses` | `/admin/pengeluaran` | `admin.expenses.index` |
| `/admin/expenses/create` | `/admin/pengeluaran/create` | `admin.expenses.create` |
| `/admin/expenses/{expense}` | `/admin/pengeluaran/{expense}` | `admin.expenses.show` |
| `/admin/expenses/{expense}/edit` | `/admin/pengeluaran/{expense}/edit` | `admin.expenses.edit` |
| `/admin/expenses/analytics/view` | `/admin/pengeluaran/analitik/tampilan` | `admin.expenses.analytics-view` |
| `/admin/expenses/summary/monthly` | `/admin/pengeluaran/ringkasan/bulanan` | `admin.expenses.monthly-summary` |
| `/admin/expenses/summary/yearly` | `/admin/pengeluaran/ringkasan/tahunan` | `admin.expenses.yearly-summary` |
| `/admin/expenses/comparison/api` | `/admin/pengeluaran/perbandingan/api` | `admin.expenses.comparison` |
| `/admin/expenses/analytics/api` | `/admin/pengeluaran/analitik/api` | `admin.expenses.analytics` |
| `/admin/expenses/profitability/api` | `/admin/pengeluaran/profitabilitas/api` | `admin.expenses.profitability` |
| `/admin/expenses/search/api` | `/admin/pengeluaran/cari/api` | `admin.expenses.search` |

### Laporan (Reports)
| Route Lama | Route Baru | Route Name |
|------------|------------|------------|
| `/admin/reports` | `/admin/laporan` | `admin.reports.index` |
| `/admin/reports/customer` | `/admin/laporan/pelanggan` | `admin.reports.customer` |
| `/admin/reports/financial` | `/admin/laporan/keuangan` | `admin.reports.financial` |
| `/admin/reports/vehicle` | `/admin/laporan/kendaraan` | `admin.reports.vehicle` |
| `/admin/reports/analytics` | `/admin/laporan/analitik` | `admin.reports.analytics` |
| `/admin/reports/profitability` | `/admin/laporan/profitabilitas` | `admin.reports.profitability` |
| `/admin/reports/customer-ltv` | `/admin/laporan/nilai-pelanggan` | `admin.reports.customer-ltv` |
| `/admin/reports/batch-export` | `/admin/laporan/ekspor-batch` | `admin.reports.batch-export` |
| `/admin/reports/schedule-export` | `/admin/laporan/jadwal-ekspor` | `admin.reports.schedule-export` |
| `/admin/reports/export-history` | `/admin/laporan/riwayat-ekspor` | `admin.reports.export-history` |

### Pengaturan (Settings)
| Route Lama | Route Baru | Route Name |
|------------|------------|------------|
| `/admin/settings/company` | `/admin/pengaturan/perusahaan` | `admin.settings.company` |
| `/admin/settings/users` | `/admin/pengaturan/pengguna` | `admin.settings.users` |
| `/admin/settings/pricing` | `/admin/pengaturan/harga` | `admin.settings.pricing` |
| `/admin/settings/system` | `/admin/pengaturan/sistem` | `admin.settings.system` |
| `/admin/settings/users/list` | `/admin/pengaturan/pengguna/daftar` | `admin.settings.users-list` |
| `/admin/settings/users/{user}/toggle-status` | `/admin/pengaturan/pengguna/{user}/ubah-status` | `admin.settings.toggle-user-status` |

### Notifikasi (Notifications)
| Route Lama | Route Baru | Route Name |
|------------|------------|------------|
| `/admin/notifications` | `/admin/notifikasi` | `admin.notifications.index` |
| `/admin/notifications/preferences` | `/admin/notifikasi/preferensi` | `admin.notifications.preferences` |
| `/admin/notifications/{notification}/read` | `/admin/notifikasi/{notification}/baca` | `admin.notifications.mark-read` |
| `/admin/notifications/mark-all-read` | `/admin/notifikasi/tandai-semua-dibaca` | `admin.notifications.mark-all-read` |
| `/admin/notifications/unread-count` | `/admin/notifikasi/jumlah-belum-dibaca` | `admin.notifications.unread-count` |
| `/admin/notifications/generate` | `/admin/notifikasi/buat` | `admin.notifications.generate` |

### Ketersediaan (Availability)
| Route Lama | Route Baru | Route Name |
|------------|------------|------------|
| `/admin/availability/timeline` | `/admin/ketersediaan/timeline` | `admin.availability.timeline` |

---

## 🔐 Auth Routes

| Route Lama | Route Baru | Route Name |
|------------|------------|------------|
| `/register` | `/daftar` | `register.admin` |
| `/forgot-password` | `/lupa-password` | `password.request` |
| `/verify-email` | `/verifikasi-email` | `verification.notice` |
| `/confirm-password` | `/konfirmasi-password` | `password.confirm` |

---

## ⚠️ Catatan Penting

1. **Route Names Tidak Berubah**: Semua route names tetap menggunakan format bahasa Inggris untuk backward compatibility dengan kode yang sudah ada.

2. **Perlu Update Link**: Semua link di view yang menggunakan hardcoded URL perlu diupdate. Gunakan helper `route()` untuk menghindari masalah ini.

3. **Cache Route**: Setelah perubahan, jalankan:
   ```bash
   php artisan route:clear
   php artisan route:cache
   ```

4. **Testing**: Pastikan untuk test semua fitur setelah perubahan route.

5. **SEO Impact**: Perubahan URL akan mempengaruhi SEO. Pertimbangkan untuk membuat redirect dari URL lama ke URL baru jika diperlukan.

---

## 📝 Contoh Penggunaan

### Sebelum:
```blade
<a href="/vehicles">Lihat Kendaraan</a>
<a href="/customer/dashboard">Dashboard</a>
<a href="/admin/bookings">Pemesanan</a>
```

### Sesudah (Recommended):
```blade
<a href="{{ route('vehicles.catalog') }}">Lihat Kendaraan</a>
<a href="{{ route('customer.dashboard') }}">Dashboard</a>
<a href="{{ route('admin.bookings.index') }}">Pemesanan</a>
```

---

## 🔄 Migration Guide

Jika ada hardcoded URL di aplikasi, gunakan find & replace dengan pattern berikut:

1. `/vehicles` → `/kendaraan`
2. `/customer` → `/pelanggan`
3. `/booking` → `/pemesanan`
4. `/admin/vehicles` → `/admin/kendaraan`
5. `/admin/customers` → `/admin/pelanggan`
6. `/admin/bookings` → `/admin/pemesanan`
7. `/admin/maintenance` → `/admin/perawatan`
8. `/admin/expenses` → `/admin/pengeluaran`
9. `/admin/reports` → `/admin/laporan`
10. `/admin/settings` → `/admin/pengaturan`
11. `/admin/notifications` → `/admin/notifikasi`

**Best Practice**: Selalu gunakan `route()` helper daripada hardcoded URL!

---

Dibuat pada: {{ date('Y-m-d H:i:s') }}
