<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ __('Ringkasan Penjualan Merch') }}
        </h2>
    </x-slot>

    <div class="py-8">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('dashboard.merch.index', [], true) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Back
                </a>
            </div>
            <!-- Existing Code -->

            <!-- Dashboard Summary Section -->
            <div class="bg-white rounded-lg shadow-md mb-6 p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Produk</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Quantity</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                // Define product names mapping in PHP
                                $productNames = [
                                    'TB01' => 'Tote Bag - Design 1',
                                    'TB02' => 'Tote Bag - Design 2',
                                    'TM01' => 'Tumbler - Design 1',
                                    'TM02' => 'Tumbler - Design 2',
                                    'LN01' => 'Lanyard - Design 1',
                                    'LN02' => 'Lanyard - Design 2',
                                    'EP01' => 'Enamel Pin - Design 1',
                                    'EP02' => 'Enamel Pin - Design 2'
                                ];
                            @endphp
                            
                            @forelse($items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->product_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $productNames[$item->product_id] ?? 'Unknown Product' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">{{ $item->total_quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada data produk yang ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Existing Code -->
        </div>
    </div>
</x-app-layout>