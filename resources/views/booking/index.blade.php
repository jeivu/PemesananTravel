<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Travel Tersedia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('travels.index') }}" class="bg-white p-6 shadow-sm sm:rounded-lg mb-6 flex space-x-4">
                <input type="text" name="destination" placeholder="Cari Tujuan Travel" value="{{ request('destination') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <input type="date" name="date" value="{{ request('date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </form>
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($schedules as $schedule)
                
                {{-- KARTU JADWAL DENGAN TATA LETAK DAN EFEK BARU --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6 border-l-4 
                            {{-- Ganti warna border sesuai ketersediaan kuota --}}
                            {{ $schedule->available_quota <= 3 ? 'border-red-500' : 'border-indigo-500' }}
                            
                            {{-- Efek Hover untuk interaksi --}}
                            transition duration-300 ease-in-out transform hover:scale-[1.02] hover:shadow-2xl">
                    
                    <div class="flex justify-between items-start mb-4">
                        {{-- JUDUL TUJUAN --}}
                        <h3 class="text-2xl font-extrabold text-gray-900">
                            {{ $schedule->destination }}
                        </h3>
                        
                        {{-- IKON (Gantilah dengan ikon yang sesuai, misalnya dari Font Awesome atau SVG) --}}
                        <svg class="w-8 h-8 text-indigo-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path></svg>
                    </div>

                    {{-- DETAIL KEBERANGKATAN --}}
                    <p class="text-sm text-gray-600 mb-4 border-b pb-3">
                        <span class="font-semibold text-gray-700">Tanggal:</span> {{ \Carbon\Carbon::parse($schedule->departure_date)->isoFormat('D MMMM YYYY') }}<br>
                        <span class="font-semibold text-gray-700">Waktu:</span> {{ $schedule->departure_time }} WIB
                    </p>
                    
                    {{-- HARGA --}}
                    <div class="mb-4">
                        <p class="text-xl font-bold text-red-600">
                            Rp {{ number_format($schedule->price, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500">Harga per tiket</p>
                    </div>
                    
                    {{-- KUOTA TERSEDIA (Highlight Warna) --}}
                    <div class="mb-6">
                        <p class="text-lg font-semibold">
                            Sisa Kursi: 
                            <span class="text-xl font-extrabold 
                                {{ $schedule->available_quota <= 3 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $schedule->available_quota }}
                            </span>
                            / {{ $schedule->total_quota }}
                        </p>
                        @if ($schedule->available_quota <= 3 && $schedule->available_quota > 0)
                            <span class="text-xs text-red-500 font-medium">Hampir Habis! Segera pesan.</span>
                        @elseif ($schedule->available_quota <= 0)
                            <span class="text-xs text-red-700 font-bold">Tiket Habis</span>
                        @endif
                    </div>

                    {{-- Form Pemesanan --}}
                    <form action="{{ route('travels.book') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        
                        <label for="tickets-{{ $schedule->id }}" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tiket:</label>
                        <div class="flex space-x-2 items-center">
                            <input type="number" id="tickets-{{ $schedule->id }}" name="number_of_tickets" min="1" max="{{ $schedule->available_quota }}" 
                                value="1" required class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-2/3
                                                    disabled:bg-gray-400 transition duration-150" 
                                    @if($schedule->available_quota == 0) disabled @endif>
                                @if($schedule->available_quota == 0)
                                    Habis
                                @else
                                    Pesan Sekarang
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            @empty
                {{-- Pesan Kosong --}}
                <div class="md:col-span-3 bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-center text-gray-500">Tidak ada jadwal travel yang tersedia saat ini sesuai kriteria pencarian.</p>
                </div>
            @endforelse
        </div>
            </div>
        </div>
    </div>
</x-app-layout>