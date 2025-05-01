<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-gear"></i>
            Pengaturan Tiket
        </h2>
        
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-xl p-6 space-y-6">

                <form action="{{ route('dashboard.control.update', $control->id, [], true) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                
                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga Tiket</label>
                        <input type="number" name="harga" id="harga" value="{{ $control->harga }}" 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out" 
                            placeholder="Masukkan harga tiket">
                        <p class="mt-2 text-sm text-red-600">⚠️ Hati-hati saat mengubah harga tiket, terutama jika sistem sedang live.</p>
                    </div>
                    <!-- Biaya Lain -->
                    <div>
                        <label for="biaya_lain" class="block text-sm font-medium text-gray-700">Biaya Lain</label>
                        <input type="number" name="biaya_lain" id="biaya_lain" value="{{ $control->biaya_lain ?? '' }}" 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out" 
                            placeholder="Masukkan biaya lain">
                        <p class="mt-2 text-sm text-gray-500">Opsional: Tambahkan biaya tambahan jika diperlukan. Masukkan 0 jika tidak ada</p>
                    </div>
                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai Penjualan</label>
                        <input type="datetime-local" name="tanggal_mulai" id="tanggal_mulai" 
                            value="{{ \Carbon\Carbon::parse($control->tanggal_mulai)->format('Y-m-d\TH:i') }}" 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out">
                    </div>
                
                    <!-- Tanggal Berakhir -->
                    <div>
                        <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700">Tanggal Berakhir Penjualan</label>
                        <input type="datetime-local" name="tanggal_berakhir" id="tanggal_berakhir" 
                            value="{{ \Carbon\Carbon::parse($control->tanggal_berakhir)->format('Y-m-d\TH:i') }}" 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out">
                    </div>
                
                    <!-- Aktif / Nonaktif -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full shadow-sm"
                        style="background-color: {{ $control->is_active ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $control->is_active ? '#047857' : '#B91C1C' }};">
                        <span class="text-xl">
                            {{ $control->is_active ? '🌟' : '😴' }}
                        </span>
                        <span class="text-sm font-semibold">
                            {{ $control->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                
                    <!-- Simpan Perubahan Button -->
                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 ease-in-out">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
                

            </div>
        </div>
        <x-footer></x-footer>
    </div>
</x-app-layout>
