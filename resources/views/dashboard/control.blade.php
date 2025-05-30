<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-gear"></i>
            Pengaturan
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
                    <!-- Harga Tamu -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga Tiket Tamu</label>
                        <input type="number" name="harga_tamu" id="harga_tamu" value="{{ $control->harga_tamu }}" 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out" 
                            placeholder="Masukkan harga tiket tamu">
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
                    <!-- Toggle Guest Access -->
                    <div>
                        <label for="isguestactive" class="block text-sm font-medium text-gray-700">Izinkan Akses Tamu</label>
                        <div class="flex items-center mt-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="isguestactive" id="isguestactive" 
                                    {{ $control->isguestactive ? 'checked' : '' }} 
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:bg-indigo-600 peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                <span class="ml-3 text-sm text-gray-700">
                                    {{ $control->isguestactive ? 'Diizinkan' : 'Tidak Diizinkan' }}
                                </span>
                            </label>
                        </div>
                    </div>
                    <!-- Toggle Merch Activation -->
                    <div>
                        <label for="ismerchactive" class="block text-sm font-medium text-gray-700">Aktivasi Merch</label>
                        <div class="flex items-center mt-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="ismerchactive" id="ismerchactive" 
                                    {{ $control->ismerchactive ? 'checked' : '' }} 
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:bg-indigo-600 peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                <span class="ml-3 text-sm text-gray-700">
                                    {{ $control->ismerchactive ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Toggle Voting Activation -->
                    <div>
                        <label for="isvoteactive" class="block text-sm font-medium text-gray-700">Aktivasi Voting</label>
                        <div class="flex items-center mt-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="isvoteactive" id="isvoteactive" 
                                    {{ $control->isvoteactive ? 'checked' : '' }} 
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:bg-indigo-600 peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                <span class="ml-3 text-sm text-gray-700">
                                    {{ $control->isvoteactive ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </label>
                        </div>
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
