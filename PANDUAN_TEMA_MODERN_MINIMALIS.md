# 🎨 Panduan Penggunaan Tema Modern Minimalis

## 📋 Daftar Isi
1. [Skema Warna](#skema-warna)
2. [Komponen Utama](#komponen-utama)
3. [Responsivitas](#responsivitas)
4. [Contoh Penggunaan](#contoh-penggunaan)
5. [Best Practices](#best-practices)

## 🎨 Skema Warna

### Warna Dominan (60% - Putih)
```css
/* Background dan suasana utama */
bg-primary-500    /* #ffffff - Putih murni */
bg-primary-600    /* #f8f8f8 - Putih sedikit abu */
bg-primary-700    /* #f5f5f5 - Background card */
```

### Warna Sekunder (30% - Hitam/Abu)
```css
/* Kontras dan pendukung */
text-secondary-900  /* #000000 - Hitam murni untuk heading */
text-secondary-800  /* #262626 - Hitam untuk text */
text-secondary-600  /* #525252 - Abu untuk subtitle */
text-secondary-400  /* #a3a3a3 - Abu muda untuk placeholder */
```

### Warna Aksen (10% - Orange)
```css
/* Titik fokus dan detail cerah */
bg-accent-500     /* #f97316 - Orange utama */
text-accent-600   /* #ea580c - Orange untuk link */
border-accent-200 /* #fed7aa - Orange muda untuk border */
```

## 🧩 Komponen Utama

### 1. Buttons
```html
<!-- Primary Button (Orange) -->
<button class="btn-primary">Aksi Utama</button>

<!-- Secondary Button (Hitam) -->
<button class="btn-secondary">Aksi Sekunder</button>

<!-- Outline Button -->
<button class="btn-outline">Aksi Outline</button>

<!-- Ghost Button -->
<button class="btn-ghost">Aksi Subtle</button>
```

### 2. Cards
```html
<!-- Card Dasar -->
<div class="card p-6">
    <h3 class="heading-sm mb-4">Judul Card</h3>
    <p class="text-secondary-600">Konten card...</p>
</div>

<!-- Card dengan Hover Effect -->
<div class="card-hover p-6">
    <h3 class="heading-sm mb-4">Card Interaktif</h3>
    <p class="text-secondary-600">Hover untuk efek...</p>
</div>

<!-- Card dengan Accent -->
<div class="card-accent p-6">
    <h3 class="heading-sm mb-4">Card Highlight</h3>
    <p class="text-accent-800">Konten penting...</p>
</div>
```

### 3. Forms
```html
<!-- Input Field -->
<div>
    <label class="form-label">Label Input</label>
    <input type="text" class="form-input" placeholder="Placeholder...">
</div>

<!-- Select Dropdown -->
<div>
    <label class="form-label">Pilihan</label>
    <select class="form-select">
        <option>Pilih opsi...</option>
    </select>
</div>

<!-- Textarea -->
<div>
    <label class="form-label">Pesan</label>
    <textarea class="form-textarea" rows="4"></textarea>
</div>
```

### 4. Navigation
```html
<!-- Desktop Navigation -->
<nav class="bg-primary-500 shadow-soft border-b border-secondary-100">
    <div class="container-custom">
        <div class="flex justify-between h-16 lg:h-20">
            <!-- Brand -->
            <a href="/" class="nav-brand">
                <div class="nav-logo">
                    <!-- Logo SVG -->
                </div>
                <span class="nav-title">Brand Name</span>
            </a>
            
            <!-- Navigation Links -->
            <div class="hidden lg:flex lg:space-x-8">
                <a href="/" class="nav-link-active">Beranda</a>
                <a href="/about" class="nav-link">Tentang</a>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Bottom Navigation -->
<nav class="mobile-nav">
    <div class="grid grid-cols-4 h-18">
        <a href="/" class="mobile-nav-item mobile-nav-active">
            <div class="mobile-nav-icon"><!-- Icon --></div>
            <span class="mobile-nav-label">Beranda</span>
        </a>
    </div>
</nav>
```

### 5. Typography
```html
<!-- Headings -->
<h1 class="heading-xl">Heading Extra Large</h1>
<h2 class="heading-lg">Heading Large</h2>
<h3 class="heading-md">Heading Medium</h3>
<h4 class="heading-sm">Heading Small</h4>

<!-- Body Text -->
<p class="text-body">Paragraph text yang responsif</p>

<!-- Gradient Text -->
<span class="text-gradient">Text dengan gradient orange</span>
```

### 6. Status Badges
```html
<!-- Success Badge -->
<span class="badge-success">Berhasil</span>

<!-- Warning Badge -->
<span class="badge-warning">Peringatan</span>

<!-- Info Badge -->
<span class="badge-info">Informasi</span>

<!-- Error Badge -->
<span class="badge-error">Error</span>
```

## 📱 Responsivitas

### Grid System
```html
<!-- Responsive Grid (1-2-3-4 kolom) -->
<div class="responsive-grid">
    <div class="card p-6">Item 1</div>
    <div class="card p-6">Item 2</div>
    <div class="card p-6">Item 3</div>
</div>

<!-- 2 Kolom Responsif -->
<div class="grid-2-col">
    <div class="card p-6">Kiri</div>
    <div class="card p-6">Kanan</div>
</div>
```

### Flexbox Responsif
```html
<!-- Flex yang berubah dari kolom ke baris -->
<div class="responsive-flex">
    <div class="card p-6">Item 1</div>
    <div class="card p-6">Item 2</div>
</div>
```

### Container dan Spacing
```html
<!-- Container Responsif -->
<div class="container-custom">
    <div class="section-padding">
        <!-- Konten dengan padding responsif -->
    </div>
</div>

<!-- Padding Kecil -->
<div class="section-padding-sm">
    <!-- Konten dengan padding lebih kecil -->
</div>
```

## 💡 Contoh Penggunaan

### Halaman Landing
```html
<div class="bg-primary-500 min-h-screen">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-accent-500 to-accent-600 text-white">
        <div class="container-custom section-padding">
            <div class="animate-fade-in text-center">
                <h1 class="heading-xl text-white mb-6">Judul Utama</h1>
                <p class="text-xl text-accent-100 mb-8">Subtitle yang menarik</p>
                <a href="#" class="btn-primary">Call to Action</a>
            </div>
        </div>
    </section>
    
    <!-- Content Section -->
    <section class="section-padding">
        <div class="container-custom">
            <div class="responsive-grid">
                <div class="card-hover p-8 text-center">
                    <h3 class="heading-sm mb-4">Fitur 1</h3>
                    <p class="text-secondary-600">Deskripsi fitur...</p>
                </div>
            </div>
        </div>
    </section>
</div>
```

### Dashboard Layout
```html
<div class="bg-primary-500 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-accent-500 to-accent-600 text-white">
        <div class="container-custom section-padding-sm">
            <h1 class="heading-lg text-white mb-4">Dashboard</h1>
            <p class="text-accent-100">Selamat datang kembali!</p>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="container-custom section-padding-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-accent-500 to-accent-600 rounded-xl flex items-center justify-center">
                        <!-- Icon -->
                    </div>
                    <div class="ml-4">
                        <p class="text-secondary-600">Label</p>
                        <p class="text-3xl font-bold text-secondary-900">123</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

## ✅ Best Practices

### 1. Konsistensi Warna
- Gunakan `primary-500` untuk background utama
- Gunakan `secondary-900` untuk heading utama
- Gunakan `accent-500` untuk aksi penting
- Jangan campurkan warna di luar skema

### 2. Responsivitas
- Selalu gunakan grid responsif untuk layout
- Test di mobile, tablet, dan desktop
- Gunakan `container-custom` untuk pembungkus
- Pastikan touch target minimal 44px di mobile

### 3. Typography
- Gunakan hierarchy yang jelas (xl > lg > md > sm)
- Gunakan `text-body` untuk paragraph
- Jangan gunakan font size custom, pakai class yang ada

### 4. Spacing
- Gunakan `section-padding` untuk section besar
- Gunakan `section-padding-sm` untuk section kecil
- Konsisten dengan gap (4, 6, 8, 12)

### 5. Animasi
- Gunakan `animate-fade-in` untuk entrance
- Gunakan `animate-slide-up` untuk card
- Jangan berlebihan dengan animasi

### 6. Cards dan Components
- Selalu gunakan `card` sebagai base
- Tambahkan `card-hover` untuk interaktif
- Gunakan padding konsisten (p-6, p-8)

### 7. Mobile Navigation
- Gunakan `mobile-nav` untuk bottom navigation
- Pastikan icon dan label jelas
- Gunakan state active/inactive yang tepat

## 🚀 Tips Pengembangan

1. **Gunakan Tailwind IntelliSense** untuk autocomplete class
2. **Test responsivitas** di berbagai ukuran layar
3. **Konsisten dengan spacing** menggunakan Tailwind scale
4. **Optimasi performa** dengan purging unused CSS
5. **Accessibility first** - gunakan semantic HTML
6. **Mobile first** - design dari mobile ke desktop

Dengan mengikuti panduan ini, Anda dapat membuat interface yang konsisten dengan tema modern minimalis yang telah diimplementasi! 🎨✨