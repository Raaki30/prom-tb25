@php
    $perPage = request('perPage', 10);
    $search = request('search');
    $query = \App\Models\Tiket::query();

    if ($search) {
        $query->where('nama', 'like', "%$search%")
              ->orWhere('kelas', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('nis', 'like', "%$search%")
              ->orWhere('order_id', 'like', "%$search%");
    }

    $data = $query->orderBy('created_at', 'desc')->paginate($perPage);
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-ticket"></i>
            {{ __('Data Pemesan Tiket') }}
        </h2>
        
    </x-slot>

    <div class="py-6" x-data="{ showModal: false, modalImg: '', verifikasiUrl: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <form method="GET" class="flex items-center gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari disini..." class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <button type="submit" class="text-sm px-3 py-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded">Cari</button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Entry</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Beli</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($data as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->order_id }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->email }}</td>
                                    <td class="px-4 py-2">
                                        {{ $item->nama }} 
                                        
                                        @if(Str::startsWith($item->order_id, 'LN-'))
                                        @php
                                            $partnerName = \App\Models\NIS::where('nis', $item->nis)->value('nama_siswa');
                                        @endphp
                                            ({{ __('Partner') }} {{ $partnerName }})
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ $item->phone }}</td>
                                    <td class="px-4 py-2">{{ $item->kelas }}</td>
                                    <td class="px-4 py-2">{{ $item->metodebayar }}</td>
                                    <td class="px-4 py-2">
                                        @if($item->status === 'completed')
                                            <span class="text-green-600 font-semibold">Success</span>
                                        @else
                                            <span class="text-yellow-500 font-semibold">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($item->entry === 1)
                                            <span class="text-green-600 font-semibold">{{ ($item->checkin_time) }}</span>
                                        @else
                                            <span class="text-red-500 font-semibold">Belum</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2">
                                        
                                            <button
                                                @click="modalImg = '{{ $item->bukti }}'; verifikasiUrl = '{{ route('tiket.verifikasi', $item->id, [], true) }}'; showModal = true"
                                                class="bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-1 rounded">
                                                Verifikasi
                                            </button>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-600">
                            Menampilkan <span class="font-semibold">{{ $data->firstItem() }}</span> sampai <span class="font-semibold">{{ $data->lastItem() }}</span> dari <span class="font-semibold">{{ $data->total() }}</span> entri
                        </div>
                        <div class="flex items-center justify-center space-x-1">
                            @if($data->onFirstPage())
                                <span class="px-3 py-1 text-gray-400 bg-gray-100 border border-gray-200 rounded-md cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $data->previousPageUrl() }}" class="px-3 py-1 text-gray-600 bg-white hover:bg-gray-100 border border-gray-200 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                            @endif

                            @for($i = 1; $i <= $data->lastPage(); $i++)
                                @if($i == $data->currentPage())
                                    <span class="px-3 py-1 text-blue-600 bg-blue-100 border border-blue-200 rounded-md font-medium">{{ $i }}</span>
                                @else
                                    <a href="{{ $data->url($i) }}" class="px-3 py-1 text-gray-600 bg-white hover:bg-gray-100 border border-gray-200 rounded-md">{{ $i }}</a>
                                @endif
                            @endfor

                            @if($data->hasMorePages())
                                <a href="{{ $data->nextPageUrl() }}" class="px-3 py-1 text-gray-600 bg-white hover:bg-gray-100 border border-gray-200 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span class="px-3 py-1 text-gray-400 bg-gray-100 border border-gray-200 rounded-md cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Verifikasi -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center" x-transition>
            <!-- BACKDROP BLUR -->
            <div class="absolute inset-0 bg-white/30 backdrop-blur-md" @click="showModal = false"></div>
        
            <!-- MODAL BOX -->
            <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-xl w-full relative z-10" @click.stop>
                <button @click="showModal = false" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-xl font-bold">&times;</button>
                <div class="p-4 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Bukti Pembayaran</h3>
                    <img :src="modalImg" alt="Bukti Pembayaran" class="w-full max-h-[70vh] object-contain rounded">
                    <p class="text-sm text-gray-600">Pastikan bukti pembayaran sesuai dan jelas terlihat sebelum memverifikasi.</p>
                    <form :action="verifikasiUrl" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">Verifikasi Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</x-app-layout>