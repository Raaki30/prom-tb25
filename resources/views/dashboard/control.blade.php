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
                    
                    <!-- Toggle Waiting Room Group (Minimized) -->
                    <div x-data="{ open: false }" class="border rounded-lg p-4 bg-gray-50">
                        <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-700">Waiting Room</span>
                                <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">New</span>
                                
                            </div>
                            <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div x-show="open" class="mt-4 space-y-4" x-cloak>
                            <!-- Toggle Waiting Room Status -->
                            <div>
                                <label for="iswaitingroomactive" class="block text-sm font-medium text-gray-700">Aktifkan Waiting Room</label>
                                <div class="flex items-center mt-2">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="iswaitingroomactive" id="iswaitingroomactive" 
                                            {{ $control->iswaitingroomactive ? 'checked' : '' }} 
                                            class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:bg-indigo-600 peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                        <span class="ml-3 text-sm text-gray-700">
                                            {{ $control->iswaitingroomactive ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <!-- Quantity When Waiting Room -->
                            <div>
                                <label for="quantity_waiting" class="block text-sm font-medium text-gray-700">Kuantitas Waiting Room</label>
                                <input type="number" name="quantity_waiting" id="quantity_waiting" 
                                    value="{{ $control->quantity_waiting }}" 
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out" 
                                    placeholder="Masukkan kuantitas waiting room">
                                <p class="mt-2 text-sm text-gray-500">Jumlah maksimum pengguna aktif di waiting room. Masukkan 0 jika tidak dibatasi</p>
                            </div>
                            <div>
                                <label for="sale_quantity" class="block text-sm font-medium text-gray-700">Kuantitas Penjualan Waiting Room</label>
                                <input type="number" name="sale_quantity" id="sale_quantity" 
                                    value="{{ $control->sale_quantity }}" 
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out" 
                                    placeholder="Masukkan kuantitas penjualan waiting room">
                                <p class="mt-2 text-sm text-gray-500">Jumlah tiket yang dapat dijual melalui waiting room. Masukkan 0 jika tidak dibatasi</p>
                            </div>
                            
                            <!-- Reset Waiting Room Button -->
                            <div class="border-t pt-4">
                                <button type="button"
                                    onclick="resetWaitingRoom()"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md shadow focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 ease-in-out">
                                    <i class="fas fa-trash-alt mr-2"></i> Reset Waiting Room
                                </button>
                                
                                <p class="mt-2 text-xs text-red-600">⚠️ Tindakan ini akan menghapus semua data antrian penggunu.'</p>
                            </div>
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

<script>
function resetWaitingRoom() {
    Swal.fire({
        title: 'Reset Waiting Room?',
        text: 'Apakah Anda yakin ingin menghapus semua data waiting room?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading indicator
            Swal.fire({
            title: 'Memproses...',
            text: 'Sedang mereset waiting room.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
            });

            fetch('{{ route("waiting.reset") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            credentials: 'same-origin'
            })
            .then(response => {
            if (response.ok) {
                Swal.fire({
                title: 'Berhasil',
                text: 'Waiting room telah direset.',
                icon: 'success',
                confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                title: 'Gagal',
                text: 'Terjadi kesalahan saat mereset waiting room.',
                icon: 'error',
                confirmButtonText: 'OK'
                });
            }
            })
            .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'An error occurred while resetting the waiting room database',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            });
        }
    });
}
</script>
