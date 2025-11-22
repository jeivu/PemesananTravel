<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal Travel Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.schedules.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="destination" class="block text-gray-700 text-sm font-bold mb-2">Tujuan Travel</label>
                        <input type="text" id="destination" name="destination" value="{{ old('destination') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('destination') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex space-x-4 mb-4">
                        <div class="w-1/2">
                            <label for="departure_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Keberangkatan</label>
                            <input type="date" id="departure_date" name="departure_date" value="{{ old('departure_date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('departure_date') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                        <div class="w-1/2">
                            <label for="departure_time" class="block text-gray-700 text-sm font-bold mb-2">Waktu Keberangkatan</label>
                            <input type="time" id="departure_time" name="departure_time" value="{{ old('departure_time') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('departure_time') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex space-x-4 mb-4">
                        <div class="w-1/2">
                            <label for="total_quota" class="block text-gray-700 text-sm font-bold mb-2">Kuota Penumpang</label>
                            <input type="number" id="total_quota" name="total_quota" value="{{ old('total_quota') }}" min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('total_quota') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                        <div class="w-1/2">
                            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Harga Tiket (Rp)</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="1000" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('price') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan Jadwal
                        </button>
                        <a href="{{ route('admin.schedules.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>