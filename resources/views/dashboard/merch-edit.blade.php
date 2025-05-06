<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-shirt"></i>
            {{ __('Edit Pembelian Merch') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <form method="POST" action="{{ route('dashboard.merch.update', $merch->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Nama -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $merch->nama) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required autofocus>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $merch->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>

                            <!-- No HP -->
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $merch->no_hp) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>

                            <!-- Grand Total -->
                            <div>
                                <label for="grand_total" class="block text-sm font-medium text-gray-700">Grand Total</label>
                                <input type="number" name="grand_total" id="grand_total" value="{{ old('grand_total', $merch->grand_total) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>

                            <!-- Metode Pembayaran -->
                            <div>
                                <label for="metodebayar" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                                <input type="text" name="metodebayar" id="metodebayar" value="{{ old('metodebayar', $merch->metodebayar) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>

                            <!-- Status Bayar -->
                            <div>
                                <label for="status_bayar" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                                <select name="status_bayar" id="status_bayar" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="pending" {{ $merch->status_bayar == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $merch->status_bayar == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </div>

                            <!-- Status Pickup -->
                            <div>
                                <label for="status_pickup" class="block text-sm font-medium text-gray-700">Status Pengambilan</label>
                                <select name="status_pickup" id="status_pickup" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="not_picked" {{ $merch->status_pickup == 'not_picked' ? 'selected' : '' }}>Belum Diambil</option>
                                    <option value="picked" {{ $merch->status_pickup == 'picked' ? 'selected' : '' }}>Sudah Diambil</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('dashboard.merch.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-1">
                                <i class="fa-solid fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm flex items-center gap-2 transition duration-200 ease-in-out">
                                <i class="fa-solid fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-footer></x-footer>
    </div>
</x-app-layout>
