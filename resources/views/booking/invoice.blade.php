<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pemesanan - {{ $booking->booking_code }}</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f4f9; font-family: sans-serif; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; line-height: 24px; color: #555; background: #fff; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
        
        /* Styling untuk cetak */
        @media print {
            body { background-color: #fff; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="text-center no-print mb-8" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px;">
            
            <button onclick="window.print()" 
                    style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                Cetak Invoice
            </button>
            
            <a href="{{ route('travels.index') }}" 
               style="padding: 10px 20px; background-color: #6c757d; color: white; border-radius: 5px; text-decoration: none !important; font-weight: bold; display: inline-block;">
                Kembali ke Jadwal
            </a>
            
            <a href="{{ route('booking.history') }}" 
               style="padding: 10px 20px; background-color: #28a745; color: white; border-radius: 5px; text-decoration: none !important; font-weight: bold; display: inline-block;">
                Lihat Riwayat Pemesanan
            </a>
            
        </div>

        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h1>Travel App</h1>
                            </td>
                            <td>
                                Invoice #: **{{ $booking->booking_code }}**<br>
                                Dipesan: **{{ $booking->created_at->isoFormat('D MMMM YYYY') }}**<br>
                                Status: **{{ $booking->payment_status == 'confirmed' ? 'LUNAS' : 'PENDING' }}**
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                **Penumpang:**<br>
                                {{ $booking->user->name }}<br>
                                {{ $booking->user->email }}
                            </td>
                            
                            <td>
                                **Detail Travel:**<br>
                                Tujuan: {{ $booking->schedule->destination }}<br>
                                Keberangkatan: {{ \Carbon\Carbon::parse($booking->schedule->departure_date)->isoFormat('D MMMM YYYY') }} ({{ $booking->schedule->departure_time }} WIB)
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>Deskripsi</td>
                <td style="text-align: right;">Harga</td>
            </tr>
            
            <tr class="item">
                <td>Tiket Travel ({{ $booking->number_of_tickets }}x)</td>
                <td style="text-align: right;">Rp {{ number_format($booking->schedule->price, 0, ',', '.') }}</td>
            </tr>
            
            <tr class="total">
                <td></td>
                <td style="text-align: right;">
                    Total Pembayaran: **Rp {{ number_format($booking->total_price, 0, ',', '.') }}**
                </td>
            </tr>
        </table>
    </div>
</body>
</html>