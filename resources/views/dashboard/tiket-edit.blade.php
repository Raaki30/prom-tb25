<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-ticket"></i>
            {{ __('Edit Order') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <form method="POST" action="{{ route('tiket.update', $tiket->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama" id="nama" value="{{ $tiket->nama }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required autofocus>
                            </div>
    
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ $tiket->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
    
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                <input type="text" name="phone" id="phone" value="{{ $tiket->phone }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
    
                            <div>
                                <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                                <select name="kelas" id="kelas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="" disabled {{ $tiket->kelas == '' ? 'selected' : '' }}>Pilih Kelas</option>
                                    <option value="XII - 1" {{ $tiket->kelas == 'XII - 1' ? 'selected' : '' }}>XII - 1</option>
                                    <option value="XII - 2" {{ $tiket->kelas == 'XII - 2' ? 'selected' : '' }}>XII - 2</option>
                                    <option value="XII - 3" {{ $tiket->kelas == 'XII - 3' ? 'selected' : '' }}>XII - 3</option>
                                    <option value="XII - 4" {{ $tiket->kelas == 'XII - 4' ? 'selected' : '' }}>XII - 4</option>
                                    <option value="XII - 5" {{ $tiket->kelas == 'XII - 5' ? 'selected' : '' }}>XII - 5</option>
                                    <option value="XII - 6" {{ $tiket->kelas == 'XII - 6' ? 'selected' : '' }}>XII - 6</option>
                                    <option value="XII - 7" {{ $tiket->kelas == 'XII - 7' ? 'selected' : '' }}>XII - 7</option>
                                    <option value="XII - 8" {{ $tiket->kelas == 'XII - 8' ? 'selected' : '' }}>XII - 8</option>
                                    <option value="XII - 9" {{ $tiket->kelas == 'XII - 9' ? 'selected' : '' }}>XII - 9</option>
                                    <option value="general" {{ $tiket->kelas == 'general' ? 'selected' : '' }}>General</option>
                                </select>
                            </div>
    
                            <div>
                                <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
                                <input type="text" name="nis" id="nis" value="{{ $tiket->nis }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                        </div>
    
                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('dashboard.tiket') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-1">
                                <i class="fa-solid fa-arrow-left"></i> Batal
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