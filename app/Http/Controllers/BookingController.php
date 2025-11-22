<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelSchedule;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    //Daftar jadwal travel tersedia
    public function index(Request $request)
    {
        $query = TravelSchedule::where('departure_date', '>=', now()->toDateString())
                               ->where('available_quota', '>', 0)
                               ->orderBy('departure_date', 'asc');
        
        // Filter berdasarkan Tujuan travel, tanggal keberangkatan, dan ketersediaan kouta
        if ($request->filled('destination')) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('departure_date', $request->date);
        }

        $schedules = $query->get();
        
        return view('booking.index', compact('schedules'));
    }

    // Proses pemesanan tiket
    public function book(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:travel_schedules,id',
            'number_of_tickets' => 'required|integer|min:1',
        ]);

        $schedule = TravelSchedule::findOrFail($validated['schedule_id']);
        $numTickets = $validated['number_of_tickets'];

        // Adanya validasi tiket yang dipesan tidak melebihi kuota / kuota habis [cite: 24]
        if ($schedule->available_quota < $numTickets) {
            return back()->withErrors('Jumlah tiket yang Anda pesan melebihi kuota yang tersedia (Sisa Kuota: ' . $schedule->available_quota . ').')
                         ->withInput();
        }

        // Mulai transaksi database untuk memastikan pengurangan kuota dan pemesanan bersifat atomik
        DB::beginTransaction();

        try {
            // Adanya validasi jika kuota ada 10 setelah ada pemesanan kuota berkurang menjadi 9 
            $schedule->available_quota -= $numTickets;
            $schedule->save();

            // Hitung total harga
            $totalPrice = $schedule->price * $numTickets;

            // Buat Pemesanan
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'schedule_id' => $schedule->id,
                'booking_code' => 'TRV-' . Str::upper(Str::random(8)),
                'number_of_tickets' => $numTickets,
                'total_price' => $totalPrice,
                'payment_status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('booking.payment.form', $booking)
                             ->with('success', 'Tiket berhasil dipesan. Harap segera lakukan konfirmasi pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            // Ini menangani error database, misalnya kegagalan update kuota
            return back()->withErrors('Terjadi kesalahan saat memproses pemesanan. Silakan coba lagi.')->withInput();
        }
    }
    // Tampilkan riwayat pemesanan pengguna
    public function history()
    {
        // Penumpang dapat melihat Riwayat pemesanan tiket yang pernah dilakukan. [cite: 29]
        $history = auth()->user()->bookings()
                         ->with('schedule')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('booking.history', compact('history'));
    }
    // Form konfirmasi pembayaran
    public function paymentForm(Booking $booking)
    {
        // Pastikan pengguna yang login adalah pemilik booking
        if (auth()->id() !== $booking->user_id) {
            abort(403, 'Akses ditolak.');
        }

        // Jika sudah dikonfirmasi, langsung arahkan ke invoice
        if ($booking->payment_status === 'confirmed') {
             return redirect()->route('booking.invoice', $booking);
        }

        return view('booking.payment', compact('booking'));
    }
    // Proses konfirmasi pembayaran
    public function confirmPayment(Request $request, Booking $booking)
    {
        // Validasi dan otorisasi
        if (auth()->id() !== $booking->user_id) {
            abort(403, 'Akses ditolak.');
        }

        if ($booking->payment_status !== 'pending') {
            return back()->withErrors('Pembayaran sudah dikonfirmasi atau dibatalkan.');
        }
        $booking->update([
            'payment_status' => 'confirmed',
        ]);

        return redirect()->route('booking.invoice', $booking)
                         ->with('success', 'Pembayaran Anda berhasil dikonfirmasi! Bukti pemesanan (Invoice) siap dicetak.');
    }
    // Tampilkan invoice pemesanan
    public function invoice(Booking $booking)
    {
        if (auth()->id() !== $booking->user_id) {
            abort(403, 'Akses ditolak.');
        }

        if ($booking->payment_status !== 'confirmed') {
            return redirect()->route('booking.history')->withErrors('Invoice hanya dapat dicetak setelah pembayaran dikonfirmasi.');
        }
        
        $booking->load('schedule');

        return view('booking.invoice', compact('booking'));
    }
}
