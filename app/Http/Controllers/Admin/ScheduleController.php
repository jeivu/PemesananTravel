<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TravelSchedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = TravelSchedule::orderBy('departure_date', 'asc')->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required',
            'total_quota' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Buat Jadwal 
        TravelSchedule::create([
            'destination' => $validated['destination'],
            'departure_date' => $validated['departure_date'],
            'departure_time' => $validated['departure_time'],
            'total_quota' => $validated['total_quota'],
            'available_quota' => $validated['total_quota'], 
            'price' => $validated['price'],
        ]);

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Jadwal travel berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TravelSchedule $schedule)
    {
        // Muat data pemesanan yang statusnya sudah 'confirmed'
        $schedule->load(['bookings' => function ($query) {
            $query->where('payment_status', 'confirmed')->with('user');
        }]);

        // Laporan Jumlah Penumpang Per Travel 
        $totalConfirmedPassengers = $schedule->bookings->sum('number_of_tickets');

        // Riwayat Penumpang (data dari 10 penumpang)
        $passengers = $schedule->bookings;

        return view('admin.schedules.show', compact('schedule', 'totalConfirmedPassengers', 'passengers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TravelSchedule $schedule)
    {
        return view('admin.schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TravelSchedule $schedule)
    {
        // Validasi Input
        $validated = $request->validate([
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required',
            'total_quota' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);
        // Update Kuota 
        $currentBooked = $schedule->total_quota - $schedule->available_quota;

        if ($validated['total_quota'] < $currentBooked) {
             // Kuota baru tidak boleh lebih kecil dari jumlah tiket yang sudah dipesan
            return back()->withErrors('Kuota total tidak boleh lebih kecil dari jumlah tiket yang sudah dipesan ('.$currentBooked.' tiket).');
        }
        
        $newAvailableQuota = $validated['total_quota'] - $currentBooked;

        // Update Jadwal
        $schedule->update([
            'destination' => $validated['destination'],
            'departure_date' => $validated['departure_date'],
            'departure_time' => $validated['departure_time'],
            'total_quota' => $validated['total_quota'],
            'available_quota' => $newAvailableQuota, 
            'price' => $validated['price'],
        ]);

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Jadwal travel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TravelSchedule $schedule)
    {
        // Cek apakah ada pemesanan terkait
        if ($schedule->bookings()->exists()) {
            return back()->withErrors('Tidak dapat menghapus jadwal karena sudah ada pemesanan tiket terkait.');
        }

        $schedule->delete();

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Jadwal travel berhasil dihapus!');
    }
}
