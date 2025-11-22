<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Penumpang & Jadwal Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-3xl font-bold mb-4 text-indigo-700">{{ $schedule->destination }}</h3>
                <p class="text-lg mb-6">Tanggal: {{ \Carbon\Carbon::parse($schedule->departure_date)->isoFormat('D MMMM YYYY') }} | Waktu: {{ $schedule->departure_time }}</p>

                <div class="bg-indigo-50 p-4 border-l-4 border-indigo-500 mb-8 shadow-md">
                    <h4 class="text-xl font-semibold text-indigo-700 mb-2">Total Penumpang Terkonfirmasi (Laporan)</h4>
                    <p class="text-4xl font-extrabold text-indigo-900">
                        {{ $totalConfirmedPassengers }}
                        <span class="text-base font-normal text-gray-600">dari Kuota Total {{ $schedule->total_quota }}</span>
                    </p>
                </div>

                <h4 class="text-2xl font-semibold mb-4">Riwayat Detail Penumpang</h4>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemesan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Booking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Tiket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($passengers as $key => $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $key + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->user->name }} ({{ $booking->user->email }})</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-mono">{{ $booking->booking_code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->number_of_tickets }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada pemesanan yang terkonfirmasi untuk jadwal ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    <a href="{{ route('admin.schedules.index') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali ke Daftar Jadwal
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>