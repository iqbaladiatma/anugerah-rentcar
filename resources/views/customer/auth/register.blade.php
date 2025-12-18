<x-public-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-accent-50 to-accent-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo and Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img 
                        src="{{ asset('ini.jpg') }}" 
                        alt="Anugerah Rentcar Logo" 
                        class="w-32 h-32 lg:w-12 lg:h-12 min-w-[40px] min-h-[40px] lg:min-w-[48px] lg:min-h-[48px] object-contain rounded-xl group-hover:scale-105 transition-transform duration-200 flex-shrink-0"
                    >
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Buat Akun Baru
                </h2>
                <p class="text-gray-600">
                    Atau 
                    <a href="{{ route('login') }}" class="font-medium text-accent-600 hover:text-accent-500">
                        masuk ke akun yang sudah ada
                    </a>
                </p>
            </div>

            <!-- Register Form -->
            <div class="bg-white rounded-xl shadow-xl p-8">
                <form class="space-y-6" action="{{ route('customer.register') }}" method="POST">
                    @csrf
                    
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input id="name" name="name" type="text" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-colors" 
                               placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Email
                        </label>
                        <input id="email" name="email" type="email" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-colors" 
                               placeholder="Masukkan alamat email Anda" value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <input id="password" name="password" type="password" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-colors" 
                               placeholder="Buat password yang kuat (min. 8 karakter)">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-colors" 
                               placeholder="Konfirmasi password Anda">
                    </div>

                    <!-- Info Message -->
                    <div class="rounded-lg bg-accent-50 p-4 border border-accent-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-accent-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-accent-700">
                                    Setelah mendaftar, Anda akan diminta melengkapi biodata lengkap untuk dapat menggunakan semua fitur.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="rounded-lg bg-red-50 p-4 border border-red-200">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Mohon perbaiki kesalahan berikut:
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Register Button -->
                    <div>
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-accent-500 to-accent-600 hover:from-accent-600 hover:to-accent-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:ring-offset-2">
                            <span class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                Buat Akun Sekarang
                            </span>
                        </button>
                    </div>

                    <!-- Terms -->
                    <div class="text-xs text-gray-500 text-center">
                        Dengan membuat akun, Anda menyetujui Syarat & Ketentuan dan Kebijakan Privasi kami.
                    </div>
                </form>

                <!-- Links -->
                <div class="mt-6 text-center space-y-2">
                    <div class="text-sm text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-medium text-accent-600 hover:text-accent-500">
                            Masuk di sini
                        </a>
                    </div>
                    <div class="text-sm">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">
                            ← Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>