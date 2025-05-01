<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-users"></i> {{ __('Data Siswa') }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto" x-data="formModal()">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 shadow-sm">
                <div class="flex items-center">
                    <i class="fa-solid fa-circle-check mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <form method="GET" class="flex w-full sm:w-auto">
                <input type="text" name="search" placeholder="Cari siswa..." value="{{ request('search') }}" 
                    class="border border-gray-300 rounded-l-lg px-4 py-2 w-64 focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Cari
                </button>
            </form>
            <button @click="openAdd()"
                class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-full flex items-center justify-center transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1">
                <i class="fa-solid fa-plus text-white text-lg"></i>
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-sm font-medium text-gray-700">
                            <th class="px-6 py-3">NIS</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Kelas</th>
                            <th class="px-6 py-3">Sudah Beli</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-gray-800">
                        @foreach($data as $siswa)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 font-medium">{{ $siswa->nis }}</td>
                            <td class="px-6 py-4">{{ $siswa->nama_siswa }}</td>
                            <td class="px-6 py-4">{{ $siswa->kelas }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $siswa->sudah_beli ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $siswa->sudah_beli ? 'Sudah' : 'Belum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <button @click='openEdit({!! json_encode($siswa) !!})'
                                        class="text-amber-600 hover:text-amber-900 transition duration-200 focus:outline-none rounded-md p-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button @click='openDelete({{ $siswa->id }})'
                                        class="text-rose-600 hover:text-rose-900 transition duration-200 focus:outline-none rounded-md p-1">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
            @if($data->isEmpty())
                <div class="p-8 text-center text-gray-500">
                    <i class="fa-solid fa-database mb-2 text-2xl text-gray-300"></i>
                    <p>Tidak ada data siswa yang ditemukan</p>
                </div>
            @endif
        
            <!-- Pagination -->
@if ($data->hasPages())
<div class="px-6 py-4 border-t border-gray-100 bg-white">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-600">
            Menampilkan <span class="font-semibold">{{ $data->firstItem() }}</span> sampai <span class="font-semibold">{{ $data->lastItem() }}</span> dari <span class="font-semibold">{{ $data->total() }}</span> entri
        </div>
        <div class="flex items-center justify-center space-x-1">
            <!-- Tombol ke Halaman Pertama -->
            @if($data->onFirstPage())
                <span class="px-3 py-1 text-gray-400 bg-gray-100 border border-gray-200 rounded-md">
                    <i class="fa-solid fa-angles-left"></i>
                </span>
            @else
                <a href="{{ $data->url(1) }}" class="px-3 py-1 text-gray-600 bg-white hover:bg-gray-100 border border-gray-200 rounded-md">
                    <i class="fa-solid fa-angles-left"></i>
                </a>
            @endif

            <!-- Tombol Previous -->
            @if($data->onFirstPage())
                <span class="px-3 py-1 text-gray-400 bg-gray-100 border border-gray-200 rounded-md">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $data->previousPageUrl() }}" class="px-3 py-1 text-gray-600 bg-white hover:bg-gray-100 border border-gray-200 rounded-md">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            <!-- Nomor Halaman -->
            @php
                $currentPage = $data->currentPage();
                $lastPage = $data->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $start + 4);
                if ($end - $start < 4) {
                    $start = max(1, $end - 4);
                }
            @endphp
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $currentPage)
                    <span class="px-3 py-1 text-blue-600 bg-blue-100 border border-blue-200 rounded-md font-medium">{{ $i }}</span>
                @else
                    <a href="{{ $data->url($i) }}" class="px-3 py-1 text-gray-600 bg-white hover:bg-gray-100 border border-gray-200 rounded-md">{{ $i }}</a>
                @endif
            @endfor

            <!-- Tombol Next -->
            @if($data->hasMorePages())
                <a href="{{ $data->nextPageUrl() }}" class="px-3 py-1 text-gray-600 bg-white hover:bg-gray-100 border border-gray-200 rounded-md">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="px-3 py-1 text-gray-400 bg-gray-100 border border-gray-200 rounded-md">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif

            <!-- Tombol ke Halaman Terakhir -->
            @if($data->currentPage() == $data->lastPage())
                <span class="px-3 py-1 text-gray-400 bg-gray-100 border border-gray-200 rounded-md">
                    <i class="fa-solid fa-angles-right"></i>
                </span>
            @else
                <a href="{{ $data->url($data->lastPage()) }}" class="px-3 py-1 text-gray-600 bg-white hover:bg-gray-100 border border-gray-200 rounded-md">
                    <i class="fa-solid fa-angles-right"></i>
                </a>
            @endif
        </div>
    </div>
</div>
@endif

        

        <!-- Add/Edit Modal -->
        <div x-show="showModal" x-cloak 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div @click.away="closeModal()"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="bg-white rounded-xl shadow-xl w-full max-w-md transform transition-all">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900" x-text="modalTitle"></h3>
                        <button @click="closeModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    
                    <form :action="formAction" method="POST">
                        @csrf
                        <template x-if="isEdit">
                            @method('POST')
                        </template>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                                <input type="text" name="nis" x-model="formData.nis"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                <input type="text" name="nama_siswa" x-model="formData.nama_siswa"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                                <input type="text" name="kelas" x-model="formData.kelas"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembelian</label>
                                <select name="sudah_beli" x-model="formData.sudah_beli"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    required>
                                    <option value="0">Belum</option>
                                    <option value="1">Sudah</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 gap-3">
                            <button type="button" @click="closeModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" x-cloak
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div @click.away="closeDeleteModal()"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="bg-white rounded-xl shadow-xl w-full max-w-md transform transition-all">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h3>
                        <button @click="closeDeleteModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    
                    <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus data siswa ini?</p>

                    <form :action="deleteAction" method="POST" class="flex justify-end gap-3">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="closeDeleteModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function formModal() {
            return {
                showModal: false,
                showDeleteModal: false,
                modalTitle: '',
                formAction: '',
                deleteAction: '',
                isEdit: false,
                formData: {
                    nis: '',
                    nama_siswa: '',
                    kelas: '',
                    sudah_beli: 0,
                },
                openAdd() {
                    this.showModal = true;
                    this.modalTitle = 'Tambah Siswa';
                    this.formAction = '{{ route("dashboard.siswa.store") }}';
                    this.isEdit = false;
                    this.formData = {
                        nis: '',
                        nama_siswa: '',
                        kelas: '',
                        sudah_beli: 0,
                    };
                    document.body.classList.add('modal-open'); // Tambahkan kelas ke body
                },
                openEdit(siswa) {
                    this.showModal = true;
                    this.modalTitle = 'Edit Siswa';
                    this.formAction = `/dashboard/siswa/${siswa.id}/update`;
                    this.isEdit = true;
                    this.formData = {
                        nis: siswa.nis,
                        nama_siswa: siswa.nama_siswa,
                        kelas: siswa.kelas,
                        sudah_beli: siswa.sudah_beli,
                    };
                    document.body.classList.add('modal-open'); // Tambahkan kelas ke body
                },
                openDelete(id) {
                    this.showDeleteModal = true;
                    this.deleteAction = `/dashboard/siswa/${id}/delete`;
                    document.body.classList.add('modal-open'); // Tambahkan kelas ke body
                },
                closeModal() {
                    this.showModal = false;
                    document.body.classList.remove('modal-open'); // Hapus kelas dari body
                },
                closeDeleteModal() {
                    this.showDeleteModal = false;
                    document.body.classList.remove('modal-open'); // Hapus kelas dari body
                },
            };
        }
    </script>
    <style>
        .modal-open {
            overflow: hidden;
        }

        .modal-open::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            z-index: 40; /* Pastikan ini berada di bawah modal */
        }
    </style>
</x-app-layout>