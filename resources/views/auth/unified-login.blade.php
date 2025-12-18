<x-public-layout>
    <div class="min-h-screen flex items-center justify-center bg-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo and Header -->
            <div class="text-center mb-8 animate-fade-in">
                <div class="flex justify-center mb-6">
                    <img 
                        src="{{ asset('ini.jpg') }}" 
                        alt="Anugerah Rentcar Logo" 
                        class="w-32 h-32 lg:w-12 lg:h-12 min-w-[40px] min-h-[40px] lg:min-w-[48px] lg:min-h-[48px] object-contain rounded-xl group-hover:scale-105 transition-transform duration-200 flex-shrink-0"
                    >
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold mb-3">
                    Masuk ke Anugerah Rentcar
                </h2>
                <p class="text-gray-600 text-lg">
                    Masuk dengan akun Admin atau Customer Anda
                </p>
            </div>

            <!-- Login Form -->
            <div class="card p-8 lg:p-10 animate-slide-up">
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="form-label">
                            Alamat Email
                        </label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="form-input" 
                               placeholder="Masukkan email Anda" value="{{ old('email') }}">
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="form-label">
                            Password
                        </label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="form-input" 
                               placeholder="Masukkan password Anda">
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
                                        Terjadi kesalahan pada form Anda
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Remember Me and Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" 
                                   class="h-4 w-4 text-accent-600 focus:ring-accent-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-accent-600 hover:text-accent-500">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <div>
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-accent-500 to-accent-600 hover:from-accent-600 hover:to-accent-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:ring-offset-2">
                            <span class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                Masuk ke Sistem
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Links -->
                <div class="mt-6 text-center space-y-2">
                    <div class="text-sm text-gray-600">
                        Belum punya akun customer? 
                        <a href="{{ route('customer.register') }}" class="font-medium text-accent-600 hover:text-accent-500">
                            Daftar sekarang
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