@php
    $perPage = request('perPage', 10);
    $search = request('search');
    $sortField = request('sortField', 'created_at');
    $sortDirection = request('sortDirection', 'desc');
    $query = \App\Models\Tiket::query();

    if ($search) {
        $query->where('nama', 'like', "%$search%")
              ->orWhere('kelas', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('nis', 'like', "%$search%")
              ->orWhere('order_id', 'like', "%$search%");
    }

    if (in_array($sortField, ['order_id', 'email', 'nama', 'phone', 'kelas', 'metodebayar', 'status', 'entry', 'created_at'])) {
        $query->orderBy($sortField, $sortDirection);
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $data = $query->paginate($perPage)->appends([
        'search' => $search,
        'sortField' => $sortField,
        'sortDirection' => $sortDirection,
        'perPage' => $perPage,
    ]);
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-ticket"></i>
            {{ __('Data Pemesan Tiket') }}
            
        </h2>
    </x-slot>

    <div 
        class="py-6" 
        x-data="{
            showModal: false, 
            modalImg: '', 
            verifikasiUrl: '', 
            deleteUrl: '', 
            showDeleteModal: false,
            sortField: '{{ $sortField }}',
            sortDirection: '{{ $sortDirection }}',
            setSort(field) {
                if(this.sortField === field) {
                    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc'
                } else {
                    this.sortField = field;
                    this.sortDirection = 'asc';
                }
                let params = new URLSearchParams(window.location.search);
                params.set('sortField', this.sortField);
                params.set('sortDirection', this.sortDirection);
                params.set('search', '{{ $search }}');
                params.set('perPage', '{{ $perPage }}');
                window.location.search = params.toString();
            }
        }"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <form method="GET" class="flex w-full sm:w-auto">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari siswa..." 
                            value="{{ request('search') }}" 
                            class="border border-gray-300 rounded-l-lg px-4 py-2 w-64 focus:ring-2 focus:ring-blue-500"
                        >
                        <button 
                            type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center"
                        >
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </form>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Tampilkan per</span>
                        <select 
                            name="perPage" 
                            @change="
                                let params = new URLSearchParams(window.location.search);
                                params.set('perPage', $event.target.value);
                                params.set('search', '{{ $search }}');
                                params.set('sortField', '{{ $sortField }}');
                                params.set('sortDirection', '{{ $sortDirection }}');
                                window.location.search = params.toString();
                            " 
                            class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        >
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        
                        <button @click="window.location.href='{{ route('tiket.create', [], true) }}'"
                            class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-full flex items-center justify-center transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1">
                            <i class="fa-solid fa-plus text-white text-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                @php
                                    $columns = [
                                        'order_id' => 'Order ID',
                                        'email' => 'Email',
                                        'nama' => 'Nama',
                                        'phone' => 'Phone',
                                        'kelas' => 'Kelas',
                                        'metodebayar' => 'Metode',
                                        'status' => 'Status',
                                        'entry' => 'Entry',
                                        'created_at' => 'Tanggal Beli',
                                        'aksi' => 'Aksi',
                                    ];
                                @endphp
                                @foreach ($columns as $field => $label)
                                    @if($field !== 'aksi')
                                        <th 
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none"
                                            @click="setSort('{{ $field }}')"
                                        >
                                            {{ $label }}
                                            <template x-if="sortField === '{{ $field }}'">
                                                <i 
                                                    class="fa-solid ml-1" 
                                                    :class="sortDirection === 'asc' ? 'fa-arrow-up' : 'fa-arrow-down'"
                                                ></i>
                                            </template>
                                        </th>
                                    @else
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                            {{ $label }}
                                        </th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($data as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        <span class="font-mono">{{ $item->order_id }}</span>
                                        @if(Str::startsWith($item->order_id, 'MN-'))
                                            <span class="text-xs bg-blue-100 text-blue-800 px-1 rounded ml-1">Manual</span>
                                        @endif
                                        @if(Str::startsWith($item->order_id, 'LN-'))
                                            <span class="text-xs bg-blue-100 text-blue-800 px-1 rounded ml-1">Luar TB</span>
                                        @endif
                                        @if(Str::startsWith($item->order_id, 'CP-'))
                                            <span class="text-xs bg-purple-100 text-purple-800 px-1 rounded ml-1 flex items-center gap-1">
                                                <i class="fa-solid fa-heart text-purple-500"></i> Couple
                                            </span>
                                        @endif
                                        @if(Str::startsWith($item->order_id, 'GP-'))
                                            <span class="text-xs bg-green-100 text-green-800 px-1 rounded ml-1 flex items-center gap-1">
                                                <i class="fa-solid fa-users text-green-500"></i> Group
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->email }}</td>
                                    <td class="px-4 py-2">
                                        {{ $item->nama }}
                                    </td>
                                    <td class="px-4 py-2">{{ $item->phone }}</td>
                                    <td class="px-4 py-2">{{ $item->kelas }}</td>
                                    <td class="px-4 py-2">{{ $item->metodebayar }}</td>
                                    <td class="px-4 py-2">
                                        @if($item->status === 'completed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fa-solid fa-check-circle mr-1"></i>Success
                                            </span>
                                        @elseif($item->status === 'half')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                                <i class="fa-solid fa-circle-half-stroke mr-1"></i>DP
                                            </span>
                                        @elseif($item->bukti == '-')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fa-solid fa-clock mr-1"></i>Unpaid
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fa-solid fa-clock mr-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($item->entry === 1)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                {{ $item->checkin_time }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fa-solid fa-times mr-1"></i>Belum
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-3">
                                            @if($item->bukti == '-' && !Str::startsWith($item->order_id, 'MN'))
                                                <button class="p-1 text-gray-400 cursor-not-allowed" disabled title="Belum Upload">
                                                    <i class="fa-solid fa-times-circle"></i>
                                                </button>
                                            @else
                                            <button
                                                @click="modalImg = '{{ $item->bukti }}'; verifikasiUrl = '{{ route('tiket.verifikasi', $item->id, [], true) }}'; showModal = true"
                                                class="p-1 text-green-600 hover:text-green-800"
                                                title="Verifikasi"
                                            >
                                                <i class="fa-solid fa-check-circle"></i>
                                            </button>
                                            @endif
                                            <a href="{{ route('tiket.edit', $item->id, [], true) }}" class="p-1 text-blue-600 hover:text-blue-800" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            
                                            <button 
                                                @click="deleteUrl = '{{ route('tiket.destroy', $item->id, [], true) }}'; showDeleteModal = true"
                                                class="p-1 text-red-600 hover:text-red-800"
                                                title="Hapus"
                                            >
                                                <i class="fa-solid fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-4 text-center text-gray-500">
                                        <i class="fa-solid fa-database mr-2"></i>Tidak ada data ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

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

            </div>
        </div>

        <!-- Modal Verifikasi -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center" x-transition>
            <div class="absolute inset-0 bg-white/30 backdrop-blur-md" @click="showModal = false"></div>

            <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-xl w-full relative z-10" @click.stop>
                <button @click="showModal = false" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-xl font-bold">&times;</button>
                <div class="p-4 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fa-solid fa-check-circle text-green-500 mr-2"></i>Verifikasi Pembayaran
                    </h3>
                    <img :src="modalImg" alt="Bukti Pembayaran" class="w-full max-h-[70vh] object-contain rounded border">
                    <p class="text-sm text-gray-600">Pastikan bukti pembayaran sesuai dan jelas terlihat sebelum memverifikasi.</p>
                    
                    <div class="flex flex-col sm:flex-row gap-3">
                        <!-- Verifikasi Penuh Button -->
                        <form :action="verifikasiUrl" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded flex items-center justify-center">
                                <i class="fa-solid fa-check-circle mr-2"></i>Verifikasi Penuh
                            </button>
                        </form>
                        
                        <!-- Verifikasi DP Button -->
                        <form :action="verifikasiUrl.replace('verifikasi', 'verifikasi-half')" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded flex items-center justify-center">
                                <i class="fa-solid fa-circle-half-stroke mr-2"></i>Verifikasi DP
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center" x-transition>
            <div class="absolute inset-0 bg-white/30 backdrop-blur-md" @click="showDeleteModal = false"></div>
        
            <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-md w-full relative z-10" @click.stop>
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-red-100 rounded-full">
                            <i class="fa-solid fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Hapus Data</h3>
                    </div>
                    
                    <p class="text-gray-600">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
                    
                    <div class="flex justify-end gap-3 pt-4">
                        <button @click="showDeleteModal = false" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">
                                <i class="fa-solid fa-trash-alt mr-1"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <x-footer></x-footer>
    </div>
</x-app-layout>