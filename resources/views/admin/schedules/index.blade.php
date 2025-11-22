<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Jadwal Travel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('admin.schedules.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                    + Tambah Jadwal
                </a>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-indigo-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Tujuan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Tgl/Waktu Keberangkatan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Kuota (Sisa/Total)</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($schedules as $schedule)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->destination }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($schedule->departure_date)->isoFormat('D MMMM YYYY') }} Pukul {{ $schedule->departure_time }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-bold text-lg {{ $schedule->available_quota <= 0 ? 'text-red-500' : 'text-green-600' }}">
                                            {{ $schedule->available_quota }}
                                        </span>
                                        / {{ $schedule->total_quota }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($schedule->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                        <a href="{{ route('admin.schedules.show', $schedule) }}" class="text-green-600 hover:text-green-900 mr-2">Laporan</a>
                                        
                                        <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus jadwal ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada jadwal travel yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>