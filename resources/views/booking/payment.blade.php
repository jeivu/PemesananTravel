<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfirmasi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="text-2xl font-bold mb-4">Pembayaran Tiket - {{ $booking->booking_code }}</h3>
                <p class="mb-4">Harap transfer total pembayaran ke rekening berikut:</p>
                
                <div class="p-4 border border-gray-200 rounded-lg mb-6 bg-gray-50">
                    <p>Bank Tujuan: **BCA**</p>
                    <p>Nomor Rekening: **1234567890**</p>
                    <p>Atas Nama: **Travel Service PT**</p>
                    <hr class="my-2">
                    <p class="text-xl font-extrabold text-red-600">
                        Total Bayar: Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </p>
                    <p class="text-sm mt-1 text-gray-500">Batas waktu pembayaran: 24 Jam sejak pemesanan.</p>
                </div>

                <form action="{{ route('booking.payment.confirm', $booking) }}" method="POST">
                    @csrf
                    <p class="mb-4">Setelah Anda mentransfer, silakan klik tombol di bawah untuk mengonfirmasi pembayaran Anda.</p>
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline">
                        Saya Sudah Bayar (Konfirmasi Pembayaran)
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>