<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Travel App') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="bg-zinc-50 text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col pt-16">
        
        <header class="fixed top-0 left-0 w-full z-10 bg-indigo-700 shadow-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if (Route::has('login'))
                    
                    <nav class="flex items-center justify-between h-16"> 
                        
                        <div class="font-black text-2xl text-amber-400 tracking-wider">
                            TRAVEL APP
                        </div>

                        <div class="flex items-center space-x-3">
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="inline-block px-5 py-1.5 text-white border border-white hover:bg-white hover:text-indigo-700 rounded-lg text-sm font-semibold transition duration-150"
                                >
                                    Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="inline-block px-5 py-1.5 text-white border border-white hover:bg-white hover:text-indigo-700 rounded-lg text-sm font-semibold transition duration-150"
                                >
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="inline-block px-5 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-semibold transition duration-150">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                        
                    </nav>
                @endif
            </div>
        </header>
        
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex flex-col items-center justify-center max-w-[335px] w-full lg:max-w-4xl lg:flex-row">
        
            <div class="flex flex-col items-center justify-center w-full p-8 lg:p-16 
            bg-stone-100 dark:bg-[#161615] dark:text-[#EDEDEC] 
            shadow-2xl rounded-xl lg:flex-row lg:space-x-12">
                
                <div class="flex-shrink-0 mb-8 lg:mb-0">
                    <img src="{{ asset('images/sleek-plane.png') }}" alt="Logo Travel" 
                        class="w-32 h-32 lg:w-48 lg:h-48 object-contain">
                </div>

                <div class="text-center lg:text-left">
                    <h1 class="text-3xl font-bold text-gray-900 mb-3">
                        Selamat Datang di Layanan Travel Online
                    </h1>
                    
                    <p class="mb-6 text-gray-600 dark:text-[#A1A09A] max-w-md">
                        Pesan tiket travel antar kota Anda dengan mudah, cepat, dan aman. 
                        Akses sekarang untuk melihat jadwal keberangkatan yang tersedia.
                    </p>

                    <a href="{{ route('login') }}" 
                    class="inline-block px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-base transition duration-150 shadow-md hover:shadow-lg">
                        Lihat Jadwal & Login
                    </a>
            </div>

    </div>
        </main>
</div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
