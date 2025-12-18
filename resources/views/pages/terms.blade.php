@php
    $settings = \App\Models\Setting::current();
@endphp

<x-public-layout>
    <x-slot name="title">Syarat dan Ketentuan - {{ $settings->company_name ?? 'Anugerah Rentcar' }}</x-slot>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-accent-600 to-accent-700 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Syarat dan Ketentuan
            </h1>
            <p class="text-xl text-accent-100 max-w-2xl mx-auto">
                Panduan lengkap untuk menyewa kendaraan di {{ $settings->company_name ?? 'Anugerah Rentcar' }}
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Isi</h3>
                    <nav class="space-y-2">
                        <a href="#cara-pesan" class="block text-gray-600 hover:text-accent-600 font-medium transition-colors">
                            📝 Cara Memesan
                        </a>
                        <a href="#persyaratan" class="block text-gray-600 hover:text-accent-600 font-medium transition-colors">
                            📋 Persyaratan Penyewaan
                        </a>
                        <a href="#dokumen" class="block text-gray-600 hover:text-accent-600 font-medium transition-colors">
                            🪪 Dokumen yang Diperlukan (KYC)
                        </a>
                        <a href="#pembayaran" class="block text-gray-600 hover:text-accent-600 font-medium transition-colors">
                            💰 Pembayaran
                        </a>
                        <a href="#penjemputan" class="block text-gray-600 hover:text-accent-600 font-medium transition-colors">
                            🚗 Penjemputan & Pengembalian
                        </a>
                        <a href="#kebijakan" class="block text-gray-600 hover:text-accent-600 font-medium transition-colors">
                            ⚠️ Kebijakan & Ketentuan
                        </a>
                        <a href="#faq" class="block text-gray-600 hover:text-accent-600 font-medium transition-colors">
                            ❓ FAQ
                        </a>
                    </nav>

                    <!-- CTA Button -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('vehicles.catalog') }}" 
                           class="block w-full bg-accent-600 text-white text-center py-3 px-4 rounded-lg hover:bg-accent-700 transition-colors font-medium">
                            Lihat Kendaraan Tersedia
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Cara Memesan -->
                <section id="cara-pesan" class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-accent-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">📝</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Cara Memesan Kendaraan</h2>
                    </div>

                    <div class="space-y-6">
                        <!-- Step 1 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-accent-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                                1
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Pilih Kendaraan & Tanggal</h4>
                                <p class="text-gray-600">
                                    Kunjungi halaman <a href="{{ route('vehicles.catalog') }}" class="text-accent-600 hover:underline">Katalog Kendaraan</a>, 
                                    pilih kendaraan yang Anda inginkan, lalu tentukan tanggal dan durasi sewa.
                                </p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-accent-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                                2
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Daftar atau Masuk</h4>
                                <p class="text-gray-600">
                                    Jika Anda pelanggan baru, silakan <a href="{{ route('customer.register') }}" class="text-accent-600 hover:underline">daftar akun</a> terlebih dahulu. 
                                    Jika sudah punya akun, langsung <a href="{{ route('login') }}" class="text-accent-600 hover:underline">masuk</a>.
                                </p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-accent-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                                3
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Lengkapi Data KYC</h4>
                                <p class="text-gray-600">
                                    Unggah dokumen verifikasi identitas (KTP, SIM, dan Kartu Keluarga) untuk proses verifikasi. 
                                    Ini hanya perlu dilakukan sekali untuk keamanan bersama.
                                </p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-accent-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                                4
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Konfirmasi & Pembayaran</h4>
                                <p class="text-gray-600">
                                    Review pesanan Anda, pilih metode pembayaran, dan selesaikan pembayaran deposit 
                                    untuk mengkonfirmasi pemesanan.
                                </p>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                                ✓
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Kendaraan Siap!</h4>
                                <p class="text-gray-600">
                                    Setelah pemesanan dikonfirmasi, kendaraan akan disiapkan sesuai jadwal. 
                                    Anda akan menerima email konfirmasi dan dapat mencetak tiket dari dashboard.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Persyaratan Penyewaan -->
                <section id="persyaratan" class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">📋</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Persyaratan Penyewaan</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">✅ Persyaratan Umum</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Usia minimal 21 tahun</li>
                                <li>• Memiliki SIM yang masih berlaku</li>
                                <li>• KTP yang masih berlaku</li>
                                <li>• Kartu Keluarga (KK) untuk verifikasi</li>
                                <li>• Tidak masuk dalam daftar hitam rental</li>
                            </ul>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">📄 Untuk Penyewa Perusahaan</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Surat kuasa perusahaan</li>
                                <li>• SIUP / NIB perusahaan</li>
                                <li>• KTP penanggung jawab</li>
                                <li>• Kontrak kerja sama (opsional)</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Dokumen KYC -->
                <section id="dokumen" class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">🪪</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Dokumen yang Diperlukan (KYC)</h2>
                    </div>

                    <p class="text-gray-600 mb-6">
                        Untuk keamanan dan kenyamanan bersama, kami menerapkan sistem Know Your Customer (KYC). 
                        Berikut dokumen yang perlu Anda unggah:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 text-center">
                            <div class="text-4xl mb-3">🪪</div>
                            <h4 class="font-bold text-gray-900 mb-2">KTP</h4>
                            <p class="text-sm text-gray-600">
                                Kartu Tanda Penduduk yang masih berlaku, foto jelas dan tidak terpotong.
                            </p>
                        </div>

                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 text-center">
                            <div class="text-4xl mb-3">🚗</div>
                            <h4 class="font-bold text-gray-900 mb-2">SIM</h4>
                            <p class="text-sm text-gray-600">
                                Surat Izin Mengemudi (SIM A/B) yang masih berlaku, 
                                sesuai dengan jenis kendaraan yang disewa.
                            </p>
                        </div>

                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-6 text-center">
                            <div class="text-4xl mb-3">👨‍👩‍👧‍👦</div>
                            <h4 class="font-bold text-gray-900 mb-2">Kartu Keluarga</h4>
                            <p class="text-sm text-gray-600">
                                Kartu Keluarga (KK) untuk verifikasi tambahan identitas dan alamat.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            <strong>💡 Tips:</strong> Pastikan foto dokumen jelas, tidak blur, 
                            tidak terpotong, dan semua informasi dapat terbaca dengan baik. 
                            Maksimal ukuran file 2MB dengan format JPG, JPEG, atau PNG.
                        </p>
                    </div>
                </section>

                <!-- Pembayaran -->
                <section id="pembayaran" class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">💰</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Pembayaran</h2>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Metode Pembayaran yang Diterima</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                    <span class="text-2xl mr-3">🏦</span>
                                    <div>
                                        <p class="font-medium text-gray-900">Transfer Bank</p>
                                        <p class="text-sm text-gray-600">BCA, Mandiri, BNI, BRI</p>
                                    </div>
                                </div>
                                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                    <span class="text-2xl mr-3">💵</span>
                                    <div>
                                        <p class="font-medium text-gray-900">Tunai</p>
                                        <p class="text-sm text-gray-600">Bayar di lokasi saat pickup</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Ketentuan Deposit</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Deposit minimal 30% dari total biaya sewa diperlukan untuk konfirmasi pemesanan</li>
                                <li>• Deposit keamanan kendaraan akan diminta saat pengambilan kendaraan</li>
                                <li>• Deposit dikembalikan setelah kendaraan dikembalikan dalam kondisi baik</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Penjemputan & Pengembalian -->
                <section id="penjemputan" class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">🚗</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Penjemputan & Pengembalian</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <span class="text-green-500 mr-2">📤</span> Penjemputan Kendaraan
                            </h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Ambil kendaraan di kantor kami atau antar ke lokasi Anda</li>
                                <li>• Bawa dokumen asli (KTP & SIM) saat pengambilan</li>
                                <li>• Cek kondisi kendaraan bersama petugas</li>
                                <li>• Tanda tangan berita acara serah terima</li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <span class="text-blue-500 mr-2">📥</span> Pengembalian Kendaraan
                            </h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Kembalikan tepat waktu sesuai jadwal</li>
                                <li>• Kondisi BBM sama seperti saat pengambilan</li>
                                <li>• Pemeriksaan kondisi kendaraan bersama</li>
                                <li>• Pelunasan biaya sewa dan pengembalian deposit</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-800">
                            <strong>⚠️ Keterlambatan:</strong> Keterlambatan pengembalian kendaraan akan dikenakan 
                            biaya tambahan sesuai dengan tarif harian atau per jam yang berlaku.
                        </p>
                    </div>
                </section>

                <!-- Kebijakan & Ketentuan -->
                <section id="kebijakan" class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">⚠️</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Kebijakan & Ketentuan</h2>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">❌ Larangan</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Dilarang menggunakan kendaraan untuk balap liar atau kegiatan ilegal</li>
                                <li>• Dilarang menyewakan ulang kepada pihak lain</li>
                                <li>• Dilarang membawa hewan peliharaan tanpa persetujuan</li>
                                <li>• Dilarang merokok di dalam kendaraan</li>
                                <li>• Dilarang memodifikasi kendaraan</li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">📝 Kebijakan Pembatalan</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Pembatalan H-3 atau lebih: Refund 100% deposit</li>
                                <li>• Pembatalan H-2: Refund 50% deposit</li>
                                <li>• Pembatalan H-1 atau kurang: Deposit tidak dikembalikan</li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">🛡️ Asuransi & Tanggung Jawab</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Semua kendaraan dilengkapi dengan asuransi dasar</li>
                                <li>• Kerusakan akibat kelalaian penyewa menjadi tanggung jawab penyewa</li>
                                <li>• Kehilangan kendaraan akibat kelalaian ditanggung penyewa</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- FAQ -->
                <section id="faq" class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">❓</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Pertanyaan yang Sering Diajukan (FAQ)</h2>
                    </div>

                    <div class="space-y-4" x-data="{ openFaq: null }">
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="openFaq = openFaq === 1 ? null : 1" 
                                    class="w-full flex justify-between items-center p-4 text-left font-medium text-gray-900 hover:bg-gray-50">
                                <span>Berapa lama proses verifikasi dokumen?</span>
                                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 1 }" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <div x-show="openFaq === 1" x-collapse class="px-4 pb-4 text-gray-600">
                                Proses verifikasi dokumen biasanya membutuhkan waktu 1-2 jam pada jam kerja. 
                                Setelah dokumen diverifikasi, Anda dapat langsung melakukan pemesanan.
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="openFaq = openFaq === 2 ? null : 2" 
                                    class="w-full flex justify-between items-center p-4 text-left font-medium text-gray-900 hover:bg-gray-50">
                                <span>Apakah bisa memperpanjang masa sewa?</span>
                                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 2 }" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <div x-show="openFaq === 2" x-collapse class="px-4 pb-4 text-gray-600">
                                Ya, Anda dapat memperpanjang masa sewa dengan menghubungi kami minimal H-1 sebelum 
                                jadwal pengembalian. Perpanjangan tergantung ketersediaan kendaraan.
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="openFaq = openFaq === 3 ? null : 3" 
                                    class="w-full flex justify-between items-center p-4 text-left font-medium text-gray-900 hover:bg-gray-50">
                                <span>Apakah tersedia layanan antar-jemput kendaraan?</span>
                                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 3 }" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <div x-show="openFaq === 3" x-collapse class="px-4 pb-4 text-gray-600">
                                Ya, kami menyediakan layanan antar-jemput kendaraan. 
                                Biaya tambahan mungkin berlaku tergantung lokasi. 
                                Hubungi kami untuk informasi lebih lanjut.
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="openFaq = openFaq === 4 ? null : 4" 
                                    class="w-full flex justify-between items-center p-4 text-left font-medium text-gray-900 hover:bg-gray-50">
                                <span>Bagaimana jika terjadi kecelakaan atau kerusakan?</span>
                                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 4 }" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <div x-show="openFaq === 4" x-collapse class="px-4 pb-4 text-gray-600">
                                Segera hubungi kami jika terjadi kecelakaan atau kerusakan. 
                                Dokumentasikan kejadian dengan foto dan laporan kronologi. 
                                Tanggung jawab kerusakan akan ditentukan berdasarkan penyebab kejadian.
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contact Section -->
                <section class="bg-gradient-to-r from-accent-600 to-accent-700 rounded-xl shadow-lg p-8 text-white">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold mb-4">Ada Pertanyaan Lain?</h2>
                        <p class="text-accent-100 mb-6">
                            Tim customer service kami siap membantu Anda. Hubungi kami melalui:
                        </p>
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="tel:{{ $settings->company_phone ?? '+6221123456' }}" 
                               class="inline-flex items-center bg-white text-accent-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                {{ $settings->company_phone ?? '+62 897-7777-451' }}
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp ?? '62897777451') }}" 
                               target="_blank"
                               class="inline-flex items-center bg-green-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-600 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-public-layout>
