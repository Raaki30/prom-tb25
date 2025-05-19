<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ __('Daftar Pembelian Merchandise') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
            <div class="mb-6">
                <a href="{{ route('dashboard.merch.manage', [], true) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Lihat Ringkasan
                </a>
            </div>
            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow-md mb-6 p-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Search Form -->
                    <form method="GET" class="flex flex-1">
                        <div class="relative w-full">
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Cari berdasarkan Order ID/Nama..." 
                                value="{{ request('search') }}"
                                class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >
                            <button 
                                type="submit" 
                                class="absolute right-0 top-0 h-full px-4 text-gray-500 hover:text-blue-600"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Items Per Page Selector -->
                    <div class="flex items-center space-x-2">
                        <label for="perPage" class="text-sm font-medium text-gray-700">Tampilkan:</label>
                        <select 
                            id="perPage" 
                            name="perPage"
                            onchange="window.location.href='?perPage='+this.value+'&search={{ request('search') }}'"
                            class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <span class="text-sm text-gray-500">entri</span>
                    </div>
                </div>
            </div>

            <!-- Purchases Table -->
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pembeli</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($merchs as $merch)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-blue-600 cursor-pointer hover:underline" 
                                              data-modal-toggle="merch-items-modal-{{ $merch->id }}">
                                            {{ $merch->order_id }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $merch->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $merch->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($merch->status_bayar == 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($merch->status_bayar == 'success')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Verified</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-3">
                                            @if($merch->status_bayar == 'success')
                                                <form action="{{ route('dashboard.merch.pickup', $merch->id, [], true) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-blue-600 hover:text-blue-900 flex items-center"
                                                            title="Pickup Merchandise">
                                                        <i class="fas fa-box"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($merch->status_bayar == 'pending')
                                                <form action="{{ route('dashboard.merch.verif', $merch->id, [], true) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-900 flex items-center"
                                                            title="Verifikasi Pembayaran">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('dashboard.merch.destroy', $merch->id, [], true) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 flex items-center"
                                                        title="Hapus Data">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada data pembelian yang ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($merchs->hasPages())
                <div class="px-6 py-3 border-t border-gray-200">
                    {{ $merchs->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Purchase Detail Modals -->
    @foreach($merchs as $merch)
    <div id="merch-items-modal-{{ $merch->id }}" 
         class="modal fixed inset-0 z-50 hidden overflow-y-auto" 
         aria-labelledby="modal-title" 
         aria-modal="true"
         role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:block">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"
                 data-modal-toggle="merch-items-modal-{{ $merch->id }}"></div>

            <!-- Modal panel - position absolute to ensure it shows above overlay -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full relative mx-auto">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <!-- Header -->
                            <div class="flex justify-between items-center border-b pb-4">
                                <h3 class="text-xl font-semibold text-gray-900" id="modal-title">
                                    Detail Pembelian #{{ $merch->order_id }}
                                </h3>
                                <button type="button" 
                                        class="text-gray-400 hover:text-gray-500"
                                        data-modal-toggle="merch-items-modal-{{ $merch->id }}">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Buyer Information -->
                            <div class="mt-6 grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-8">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Nama Lengkap</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $merch->nama }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Email</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $merch->email }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Nomor HP</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $merch->no_hp }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Tanggal Pembelian</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $merch->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Status Pembayaran</h4>
                                    <p class="mt-1">
                                        @if($merch->status_bayar == 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($merch->status_bayar == 'success')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Verified</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Status Pickup</h4>
                                    <p class="mt-1">
                                        @if($merch->status_pickup == 'not_picked')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Waiting</span>
                                        @elseif($merch->status_pickup == 'picked_up')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Picked Up</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Not Picked Up</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Purchased Items -->
                            <div class="mt-8">
                                <h4 class="text-lg font-medium text-gray-900 border-b pb-2">Item yang Dibeli</h4>
                                <div class="mt-4 overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Produk</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($merchItems->get($merch->id) as $item)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $item->product_id }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                    <span class="product-name" data-product-id="{{ $item->product_id }}">{{ $item->product_id }}</span>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr class="bg-gray-50">
                                                <td colspan="4" class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                                    Total Pembayaran
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    Rp {{ number_format($merchItems->get($merch->id)->sum(function($item) { return $item->quantity * $item->price; }), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Payment Proof -->
                            <div class="mt-8">
                                <h4 class="text-lg font-medium text-gray-900 border-b pb-2">Bukti Pembayaran</h4>
                                <div class="mt-4 flex justify-center">
                                    <div class="bg-gray-100 p-4 rounded-lg max-w-md">
                                        <img src="{{ $merch->bukti }}" 
                                             alt="Bukti Pembayaran untuk Order #{{ $merch->order_id }}"
                                             class="max-w-full h-auto rounded-lg border border-gray-300">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            data-modal-toggle="merch-items-modal-{{ $merch->id }}">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <script>
        // Product ID to Name mapping
        const productNames = {
            'TB01': 'Tote Bag - Design 1',
            'TB02': 'Tote Bag - Design 2',
            'TM01': 'Tumbler - Design 1',
            'TM02': 'Tumbler - Design 2',
            'LN01': 'Lanyard - Design 1',
            'LN02': 'Lanyard - Design 2',
            'EP01': 'Enamel Pin - Design 1',
            'EP02': 'Enamel Pin - Design 2'
        };

        // Modal toggle functionality
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default for links
                const modalId = this.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                
                if (modal) {
                    console.log('Toggling modal:', modalId); // Debug line
                    modal.classList.toggle('hidden');
                    document.body.classList.toggle('overflow-hidden', !modal.classList.contains('hidden'));
                }
            });
        });

        // Close modal when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this || e.target.getAttribute('data-modal-toggle') === this.id) {
                    this.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal:not(.hidden)').forEach(modal => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            }
        });

        // Populate product names
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.product-name').forEach(element => {
                const productId = element.getAttribute('data-product-id');
                if (productNames[productId]) {
                    element.textContent = productNames[productId];
                }
            });
        });
    </script>
</x-app-layout>