<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-ticket"></i>
            {{ __('Tambah Order Manual') }}
        </h2>
    </x-slot>

    <div x-data="{ showConfirmModal: false }" class="relative">
        <!-- Konten utama -->
        <div class="py-6" :class="{ 'blur-sm': showConfirmModal }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-6">
                        <form id="tiketForm" method="POST" action="{{ route('tiket.store', [], true) }}">
                            @csrf
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="nama" id="nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required autofocus>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                    <input type="text" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                </div>

                                <div>
                                    <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                                    <select name="kelas" id="kelas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        <option value="" disabled selected>Pilih Kelas</option>
                                        <option value="XII - 1">XII - 1</option>
                                        <option value="XII - 2">XII - 2</option>
                                        <option value="XII - 3">XII - 3</option>
                                        <option value="XII - 4">XII - 4</option>
                                        <option value="XII - 5">XII - 5</option>
                                        <option value="XII - 6">XII - 6</option>
                                        <option value="XII - 7">XII - 7</option>
                                        <option value="general">General</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
                                    <input type="text" name="nis" id="nis" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6 gap-4">
                                <a href="{{ url()->previous() }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-left"></i> Batal
                                </a>
                                <button type="button" @click="showConfirmModal = true" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm flex items-center gap-2 transition duration-200 ease-in-out">
                                    <i class="fa-solid fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <x-footer />
        </div>

        <!-- Modal Konfirmasi -->
        <div x-show="showConfirmModal" x-cloak
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div @click.away="showConfirmModal = false"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="bg-white rounded-xl shadow-xl w-full max-w-md transform transition-all">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Konfirmasi Simpan</h3>
                        <button @click="showConfirmModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    
                    <p class="text-gray-700 mb-6">Anda akan menambah tiket secara manual. Pastikan anda tahu apa yang anda lakukan.</p>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showConfirmModal = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Batal
                        </button>
                        <button type="button" @click="document.getElementById('tiketForm').submit()"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
