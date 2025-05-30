<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Merch Casino de L'Amour</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 for beautiful alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- TAILWIND --}}
    @vite('resources/css/app.css')

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ephesis&family=Imperial+Script&family=Lavishly+Yours&family=Tangerine&display=swap"
        rel="stylesheet">
</head>

<body class="gradient-bg-dark">

    <h1
        class="font-fancy-4 text-pretty pt-20 text-center text-5xl font-bold tracking-tight text-yellow-500 sm:text-6xl lg:text-balance">
        Merchandise <br> Casino de L'Amour</h1>

    <!-- Bundle Information Section -->
    <div x-data="{ showBundle: true }" x-show="showBundle" class="mx-auto mt-6 w-full max-w-3xl p-4">
        <div class="relative rounded-xl bg-gradient-to-r from-yellow-50 to-yellow-100 p-5 shadow-md border border-yellow-200">
            <button @click="showBundle = false" type="button"
                class="absolute top-3 right-3 text-yellow-700 hover:text-yellow-900 rounded-full p-1 transition"
                aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 class="text-xl font-bold text-center text-yellow-800 mb-3">✨ Special Bundle Offers ✨</h2>
            <p class="text-gray-700 text-center mb-4">Dapatkan promo menarik dengan pembelian bundle</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="bg-white rounded-lg p-3 shadow-sm border border-yellow-200">
                    <p class="font-medium text-yellow-800">Tote Bag + Tumblr</p>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-gray-500 line-through">Rp115,000</span>
                        <span class="font-bold text-green-600">Rp95,000</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-3 shadow-sm border border-yellow-200">
                    <p class="font-medium text-yellow-800">Lanyard + Enamel Pin</p>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-gray-500 line-through">Rp65,000</span>
                        <span class="font-bold text-green-600">Rp45,000</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-3 shadow-sm border border-yellow-200">
                    <p class="font-medium text-yellow-800">Tote Bag + Enamel Pin</p>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-gray-500 line-through">Rp85,000</span>
                        <span class="font-bold text-green-600">Rp65,000</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-3 shadow-sm border border-yellow-200">
                    <p class="font-medium text-yellow-800">Complete Bundle (All Items)</p>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-gray-500 line-through">Rp180,000</span>
                        <span class="font-bold text-green-600">Rp165,000</span>
                    </div>
                </div>
            </div>

            <p class="text-sm text-center mt-3 text-gray-600">Promo otomatis terpasang saat pembayaran</p>
        </div>
    </div>
    <!-- End Bundle Information Section -->

    <section id="all-merch" class="mx-auto mt-5 w-full p-5 sm:w-3/4" x-data="{ activeTab: 'tab-1' }">
        <div class="container mx-auto w-full rounded-2xl bg-white pb-80 pt-8 sm:pb-56 shadow-2xl sm:px-14">
            <form id="merchForm" class="w-full p-0" method="POST" action="/beli-merch" enctype="multipart/form-data">
                @csrf
                
                <div id="tabs" class="tabs m-auto sm:w-full md:w-3/4 lg:w-1/2 mt-10">
                    <ul
                        class="flex flex-wrap justify-center border-b border-gray-200 text-center text-sm font-medium text-gray-500 dark:border-gray-700 dark:text-gray-400">
                        <li class="mr-2">
                            <a href="#" @click.prevent="activeTab = 'tab-1'"
                                :class="activeTab === 'tab-1' ?
                                    'text-blue-600 bg-gray-100 dark:bg-gray-800 dark:text-blue-500' :
                                    'hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300'"
                                class="inline-block rounded-t-lg p-2 sm:p-4">Tote Bag</a>
                        </li>
                        <li class="mr-2">
                            <a href="#" @click.prevent="activeTab = 'tab-2'"
                                :class="activeTab === 'tab-2' ?
                                    'text-blue-600 bg-gray-100 dark:bg-gray-800 dark:text-blue-500' :
                                    'hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300'"
                                class="inline-block rounded-t-lg p-2 sm:p-4">Tumblr</a>
                        </li>
                        <li class="mr-2">
                            <a href="#" @click.prevent="activeTab = 'tab-3'"
                                :class="activeTab === 'tab-3' ?
                                    'text-blue-600 bg-gray-100 dark:bg-gray-800 dark:text-blue-500' :
                                    'hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300'"
                                class="inline-block rounded-t-lg p-2 sm:p-4">Lanyard</a>
                        </li>
                        <li class="mr-2">
                            <a href="#" @click.prevent="activeTab = 'tab-4'"
                                :class="activeTab === 'tab-4' ?
                                    'text-blue-600 bg-gray-100 dark:bg-gray-800 dark:text-blue-500' :
                                    'hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300'"
                                class="inline-block rounded-t-lg p-2 sm:p-4">Enamel Pin</a>
                        </li>
                    </ul>
                    <div class="mt-4 px-5">
                        <!-- Tab 1: Tote Bag -->
                        <div x-show="activeTab === 'tab-1'" class="tab-content grid grid-cols-1 gap-8 md:grid-cols-2">
                            <div id="TB01"
                                class="produk-1 flex flex-col items-center rounded-lg border-2 border-gray-300 p-4">
                                <img src="{{ asset('images/Totebag1.png') }}" alt="Tote Bag"
                                    class="mb-4 h-48 w-48 object-contain">
                                <h2 class="text-lg font-semibold">Design 1</h2>
                                <p class="text-gray-700">Price: Rp50,000</p>
                                <div class="mt-2 flex items-center">
                                    <button type="button"
                                        class="btn-decrease flex h-10 w-10 items-center justify-center rounded bg-red-500 text-white">-</button>
                                    <span class="quantity mx-4 text-lg">0</span>
                                    <button type="button"
                                        class="btn-increase flex h-10 w-10 items-center justify-center rounded bg-green-500 text-white">+</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="products[TB01][id]" value="TB01">
                                <input type="hidden" name="products[TB01][quantity]" class="hidden-quantity"
                                    value="0">
                                <input type="hidden" name="products[TB01][price]" value="20000">
                                <input type="hidden" name="products[TB01][name]" value="Tote Bag Design 1">
                            </div>
                            <div id="TB02"
                                class="produk-2 flex flex-col items-center rounded-lg border-2 border-gray-300 p-4">
                                <img src="{{ asset('images/Totebag2.png') }}" alt="Tote Bag"
                                    class="mb-4 h-48 w-48 object-contain">
                                <h2 class="text-lg font-semibold">Design 2</h2>
                                <p class="text-gray-700">Price: Rp50,000</p>
                                <div class="mt-2 flex items-center">
                                    <button type="button"
                                        class="btn-decrease flex h-10 w-10 items-center justify-center rounded bg-red-500 text-white">-</button>
                                    <span class="quantity mx-4 text-lg">0</span>
                                    <button type="button"
                                        class="btn-increase flex h-10 w-10 items-center justify-center rounded bg-green-500 text-white">+</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="products[TB02][id]" value="TB02">
                                <input type="hidden" name="products[TB02][quantity]" class="hidden-quantity"
                                    value="0">
                                <input type="hidden" name="products[TB02][price]" value="15000">
                                <input type="hidden" name="products[TB02][name]" value="Tote Bag Design 2">
                            </div>
                        </div>

                        <!-- Tab 2: Tumblr -->
                        <div x-show="activeTab === 'tab-2'" class="tab-content grid grid-cols-1 gap-8 md:grid-cols-2">
                            <div id="TM01"
                                class="produk-1 flex flex-col items-center rounded-lg border-2 border-gray-300 p-4">
                                <img src="{{ asset('images/Tumblr1.png') }}" alt="Tumblr"
                                    class="mb-4 h-48 w-48 object-contain">
                                <h2 class="text-lg font-semibold">Design 1</h2>
                                <p class="text-gray-700">Price: Rp65,000</p>
                                <div class="mt-2 flex items-center">
                                    <button type="button"
                                        class="btn-decrease flex h-10 w-10 items-center justify-center rounded bg-red-500 text-white">-</button>
                                    <span class="quantity mx-4 text-lg">0</span>
                                    <button type="button"
                                        class="btn-increase flex h-10 w-10 items-center justify-center rounded bg-green-500 text-white">+</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="products[TM01][id]" value="TM01">
                                <input type="hidden" name="products[TM01][quantity]" class="hidden-quantity"
                                    value="0">
                                <input type="hidden" name="products[TM01][price]" value="25000">
                                <input type="hidden" name="products[TM01][name]" value="Tumblr Design 1">
                            </div>
                            <div id="TM02"
                                class="produk-2 flex flex-col items-center rounded-lg border-2 border-gray-300 p-4">
                                <img src="{{ asset('images/Tumblr2.png') }}" alt="Tumblr"
                                    class="mb-4 h-48 w-48 object-contain">
                                <h2 class="text-lg font-semibold">Design 2</h2>
                                <p class="text-gray-700">Price: Rp65,000</p>
                                <div class="mt-2 flex items-center">
                                    <button type="button"
                                        class="btn-decrease flex h-10 w-10 items-center justify-center rounded bg-red-500 text-white">-</button>
                                    <span class="quantity mx-4 text-lg">0</span>
                                    <button type="button"
                                        class="btn-increase flex h-10 w-10 items-center justify-center rounded bg-green-500 text-white">+</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="products[TM02][id]" value="TM02">
                                <input type="hidden" name="products[TM02][quantity]" class="hidden-quantity"
                                    value="0">
                                <input type="hidden" name="products[TM02][price]" value="22000">
                                <input type="hidden" name="products[TM02][name]" value="Tumblr Design 2">
                            </div>
                        </div>

                        <!-- Tab 3: Lanyard -->
                        <div x-show="activeTab === 'tab-3'" class="tab-content grid grid-cols-1 gap-8 md:grid-cols-2">
                            <div id="LN01"
                                class="produk-1 flex flex-col items-center rounded-lg border-2 border-gray-300 p-4">
                                <img src="{{ asset('images/Lanyard1.png') }}" alt="Lanyard"
                                    class="mb-4 h-48 w-48 object-contain">
                                <h2 class="text-lg font-semibold">Design 1</h2>
                                <p class="text-gray-700">Price: Rp30,000</p>
                                <div class="mt-2 flex items-center">
                                    <button type="button"
                                        class="btn-decrease flex h-10 w-10 items-center justify-center rounded bg-red-500 text-white">-</button>
                                    <span class="quantity mx-4 text-lg">0</span>
                                    <button type="button"
                                        class="btn-increase flex h-10 w-10 items-center justify-center rounded bg-green-500 text-white">+</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="products[LN01][id]" value="LN01">
                                <input type="hidden" name="products[LN01][quantity]" class="hidden-quantity"
                                    value="0">
                                <input type="hidden" name="products[LN01][price]" value="10000">
                                <input type="hidden" name="products[LN01][name]" value="Lanyard Design 1">
                            </div>
                            <div id="LN02"
                                class="produk-2 flex flex-col items-center rounded-lg border-2 border-gray-300 p-4">
                                <img src="{{ asset('images/Lanyard2.png') }}" alt="Lanyard"
                                    class="mb-4 h-48 w-48 object-contain">
                                <h2 class="text-lg font-semibold">Design 2</h2>
                                <p class="text-gray-700">Price: Rp30,000</p>
                                <div class="mt-2 flex items-center">
                                    <button type="button"
                                        class="btn-decrease flex h-10 w-10 items-center justify-center rounded bg-red-500 text-white">-</button>
                                    <span class="quantity mx-4 text-lg">0</span>
                                    <button type="button"
                                        class="btn-increase flex h-10 w-10 items-center justify-center rounded bg-green-500 text-white">+</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="products[LN02][id]" value="LN02">
                                <input type="hidden" name="products[LN02][quantity]" class="hidden-quantity"
                                    value="0">
                                <input type="hidden" name="products[LN02][price]" value="12000">
                                <input type="hidden" name="products[LN02][name]" value="Lanyard Design 2">
                            </div>
                        </div>

                        <!-- Tab 4: Enamel Pin -->
                        <div x-show="activeTab === 'tab-4'" class="tab-content grid grid-cols-1 gap-8 md:grid-cols-2">
                            <div id="EP01"
                                class="produk-1 flex flex-col items-center rounded-lg border-2 border-gray-300 p-4">
                                <img src="{{ asset('images/EnamelPin1.png') }}" alt="Enamel Pin"
                                    class="mb-4 h-48 w-48 object-contain">
                                <h2 class="text-lg font-semibold">Design 1</h2>
                                <p class="text-gray-700">Price: Rp35,000</p>
                                <div class="mt-2 flex items-center">
                                    <button type="button"
                                        class="btn-decrease flex h-10 w-10 items-center justify-center rounded bg-red-500 text-white">-</button>
                                    <span class="quantity mx-4 text-lg">0</span>
                                    <button type="button"
                                        class="btn-increase flex h-10 w-10 items-center justify-center rounded bg-green-500 text-white">+</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="products[EP01][id]" value="EP01">
                                <input type="hidden" name="products[EP01][quantity]" class="hidden-quantity"
                                    value="0">
                                <input type="hidden" name="products[EP01][price]" value="8000">
                                <input type="hidden" name="products[EP01][name]" value="Enamel Pin Design 1">
                            </div>
                            <div id="EP02"
                                class="produk-2 flex flex-col items-center rounded-lg border-2 border-gray-300 p-4">
                                <img src="{{ asset('images/EnamelPin2.png') }}" alt="Enamel Pin"
                                    class="mb-4 h-48 w-48 object-contain">
                                <h2 class="text-lg font-semibold">Design 2</h2>
                                <p class="text-gray-700">Price: Rp35,000</p>
                                <div class="mt-2 flex items-center">
                                    <button type="button"
                                        class="btn-decrease flex h-10 w-10 items-center justify-center rounded bg-red-500 text-white">-</button>
                                    <span class="quantity mx-4 text-lg">0</span>
                                    <button type="button"
                                        class="btn-increase flex h-10 w-10 items-center justify-center rounded bg-green-500 text-white">+</button>
                                </div>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="products[EP02][id]" value="EP02">
                                <input type="hidden" name="products[EP02][quantity]" class="hidden-quantity"
                                    value="0">
                                <input type="hidden" name="products[EP02][price]" value="9000">
                                <input type="hidden" name="products[EP02][name]" value="Enamel Pin Design 2">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Data Pribadi -->
                <div class="m-auto mt-8 w-full rounded-lg bg-gray-50 p-5 shadow-md sm:w-1/2">
                    <h2 class="mb-4 text-lg font-semibold">Data Pribadi</h2>
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama"
                            class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Masukkan email" required>
                    </div>
                    <div class="mb-4">
                        <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="tel" id="no_hp" name="no_hp"
                            class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Masukkan nomor telepon" required>
                    </div>
                    <div class="mb-4">
                        <label for="metode_bayar" class="block text-sm font-medium text-gray-700">Metode Bayar</label>
                        <select id="metode_bayar" name="metode_bayar"
                            class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            required>
                            <option value="Transfer Bank">Transfer Bank</option>
                            {{-- <option value="QRIS">QRIS</option> --}}
                        </select>
                    </div>
                    <div class="mt-6 p-6 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                        <p class="font-semibold text-gray-800"><strong>Instruksi Pembayaran:</strong></p>
                        <p class="text-gray-700">Silakan transfer sebesar nominal di atas ke rekening berikut:</p>
                        <ul class="mt-2 text-sm text-gray-700">
                            <div class="rounded-lg border border-yellow-300 bg-yellow-100 w-fit p-4 my-5">
                                <h6 class="mb-2 font-medium">Transfer Bank BCA :</h6>
                                <p>Bank: BCA</p>
                                <p>Nomor Rekening: 4490327547</p>
                                <p class="mb-4">Atas Nama: RHEAN DARMA</p>
                            </div>
                        </ul>
                    </div>
                    
                    <div class="my-6"></div>
                    <div class="mb-4">
                        <label for="bukti_bayar" class="block text-sm font-medium text-gray-700">Bukti Bayar</label>
                        <input type="file" id="bukti_bayar" name="bukti_bayar" accept="image/*,.pdf"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border file:border-gray-300 file:bg-gray-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-100"
                            required>
                    </div>
                </div>
            </form>

            <div class="fixed bottom-0 left-0 right-0 mt-8 rounded-lg bg-white p-4 shadow-lg sm:static">
                <!-- Total Harga -->
                <div class="total-harga flex items-center justify-between rounded-lg bg-gray-100 p-4 shadow-md">
                    <h2 class="text-lg font-semibold">Total Harga:</h2>
                    <span id="totalPrice" class="text-xl font-bold text-green-600">Rp0</span>
                </div>

                <!-- Tombol Checkout -->
                <div class="mt-4 text-center">
                    <button type="button" id="checkoutButton"
                        class="rounded-lg bg-blue-500 px-6 py-3 font-semibold text-white transition hover:bg-blue-600">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const decreaseButtons = document.querySelectorAll('.btn-decrease');
            const increaseButtons = document.querySelectorAll('.btn-increase');
            const totalPriceElement = document.getElementById('totalPrice');
            const checkoutButton = document.getElementById('checkoutButton');
            const merchForm = document.getElementById('merchForm');
            const buktiBayarInput = document.getElementById('bukti_bayar');

            // Set form attributes
            merchForm.action = "/beli-merch";
            merchForm.method = "POST";
            merchForm.enctype = "multipart/form-data";

            // Product prices and variants
            const prices = {
                'TB01': 50000,
                'TB02': 50000,
                'TM01': 65000,
                'TM02': 65000,
                'LN01': 30000,
                'LN02': 30000,
                'EP01': 35000,
                'EP02': 35000
            };

            const variants = {
                'TB01': 'TB01-V1',
                'TB02': 'TB02-V1',
                'TM01': 'TM01-V1',
                'TM02': 'TM02-V1',
                'LN01': 'LN01-V1',
                'LN02': 'LN02-V1',
                'EP01': 'EP01-V1',
                'EP02': 'EP02-V1'
            };
            
            // Define product categories for bundling
            const productCategories = {
                'TB01': 'TB',
                'TB02': 'TB',
                'TM01': 'TM',
                'TM02': 'TM',
                'LN01': 'LN',
                'LN02': 'LN',
                'EP01': 'EP',
                'EP02': 'EP'
            };
            
            // Define bundles and their discounted prices
            const bundles = [
                {
                    categories: ['TB', 'TM'],
                    price: 95000,
                    description: 'Bundle: Tote Bag + Tumblr = Rp95.000'
                },
                {
                    categories: ['LN', 'EP'],
                    price: 45000,
                    description: 'Bundle: Lanyard + Enamel Pin = Rp45.000'
                },
                {
                    categories: ['TB', 'EP'],
                    price: 65000,
                    description: 'Bundle: Tote Bag + Enamel Pin = Rp65.000'
                },
                {
                    categories: ['TB', 'TM', 'LN', 'EP'],
                    price: 165000,
                    description: 'Bundle: All Items = Rp165.000'
                }
            ];
            
            // Create bundle info container if it doesn't exist
            let bundleInfoContainer = document.getElementById('bundleInfo');
            if (!bundleInfoContainer) {
                bundleInfoContainer = document.createElement('div');
                bundleInfoContainer.id = 'bundleInfo';
                bundleInfoContainer.className = 'mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200';
                bundleInfoContainer.style.display = 'none'; // Hide by default
                document.querySelector('.total-harga').insertAdjacentElement('afterend', bundleInfoContainer);
            }

            // Update total price with bundle calculations
            const updateTotalPrice = () => {
                // Get quantities by product
                const quantities = {};
                document.querySelectorAll('.hidden-quantity').forEach((quantityInput) => {
                    const quantity = parseInt(quantityInput.value);
                    const productId = quantityInput.name.match(/\[(.*?)\]/)[1];
                    quantities[productId] = quantity;
                });
                
                // Get quantities by category
                const categoryQuantities = {};
                let regularTotal = 0;
                
                Object.keys(quantities).forEach(productId => {
                    const category = productCategories[productId];
                    const quantity = quantities[productId];
                    
                    if (!categoryQuantities[category]) {
                        categoryQuantities[category] = 0;
                    }
                    
                    categoryQuantities[category] += quantity;
                    regularTotal += quantity * prices[productId];
                });
                
                // Calculate bundle pricing
                let finalTotal = regularTotal;
                let appliedBundles = [];
                let bundleDiscount = 0;
                
                // Check which bundles apply (starting from largest/most valuable bundle)
                bundles.sort((a, b) => b.categories.length - a.categories.length).forEach(bundle => {
                    // Check if all required categories for this bundle are present
                    const hasAllCategories = bundle.categories.every(category => 
                        categoryQuantities[category] && categoryQuantities[category] > 0
                    );
                    
                    if (hasAllCategories) {
                        // Calculate how many complete bundles can be made
                        let bundleCount = Math.min(...bundle.categories.map(category => categoryQuantities[category]));
                        
                        if (bundleCount > 0) {
                            // Calculate the regular price for these items
                            let regularBundlePrice = 0;
                            bundle.categories.forEach(category => {
                                // Find a product in this category
                                const productId = Object.keys(productCategories).find(id => productCategories[id] === category);
                                regularBundlePrice += prices[productId];
                            });
                            
                            const bundleSavings = (regularBundlePrice - bundle.price) * bundleCount;
                            bundleDiscount += bundleSavings;
                            finalTotal = regularTotal - bundleDiscount;
                            
                            appliedBundles.push({
                                description: bundle.description,
                                count: bundleCount,
                                savings: bundleSavings
                            });
                            
                            // Remove these items from consideration for other bundles
                            bundle.categories.forEach(category => {
                                categoryQuantities[category] -= bundleCount;
                            });
                        }
                    }
                });
                
                // Update UI with the total
                totalPriceElement.textContent = `Rp${finalTotal.toLocaleString('id-ID')}`;
                
                // Update hidden input for the total
                let grandTotalInput = document.getElementById('grand_total');
                if (!grandTotalInput) {
                    grandTotalInput = document.createElement('input');
                    grandTotalInput.type = 'hidden';
                    grandTotalInput.id = 'grand_total';
                    grandTotalInput.name = 'grand_total';
                    merchForm.appendChild(grandTotalInput);
                }
                grandTotalInput.value = finalTotal;
                
                // Add discount info to hidden input
                let bundleDiscountInput = document.getElementById('bundle_discount');
                if (!bundleDiscountInput) {
                    bundleDiscountInput = document.createElement('input');
                    bundleDiscountInput.type = 'hidden';
                    bundleDiscountInput.id = 'bundle_discount';
                    bundleDiscountInput.name = 'bundle_discount';
                    merchForm.appendChild(bundleDiscountInput);
                }
                bundleDiscountInput.value = bundleDiscount;
                
                // Show bundle information
                if (appliedBundles.length > 0) {
                    let bundleHTML = `
                        <h3 class="text-md font-semibold text-green-800 mb-2">Bundling Applied!</h3>
                        <ul class="text-sm text-gray-700 space-y-1">
                    `;
                    
                    appliedBundles.forEach(bundle => {
                        bundleHTML += `
                            <li class="flex justify-between">
                                <span>${bundle.count}x ${bundle.description}</span>
                                <span class="text-green-600 font-medium">-Rp${bundle.savings.toLocaleString('id-ID')}</span>
                            </li>
                        `;
                    });
                    
                    bundleHTML += `
                        </ul>
                        <div class="mt-2 pt-2 border-t border-yellow-200">
                            <div class="flex justify-between">
                                <span class="font-medium">Regular Price:</span>
                                <span>Rp${regularTotal.toLocaleString('id-ID')}</span>
                            </div>
                            <div class="flex justify-between text-green-600 font-medium">
                                <span>Bundle Discount:</span>
                                <span>-Rp${bundleDiscount.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                    `;
                    
                    bundleInfoContainer.innerHTML = bundleHTML;
                    bundleInfoContainer.style.display = 'block';
                } else {
                    bundleInfoContainer.style.display = 'none';
                }
            };

            // Quantity button handlers
            decreaseButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const quantitySpan = btn.parentElement.querySelector('.quantity');
                    const hiddenQuantityInput = btn.parentElement.parentElement.querySelector('.hidden-quantity');
                    let currentValue = parseInt(quantitySpan.textContent);
                    if (currentValue > 0) {
                        quantitySpan.textContent = currentValue - 1;
                        hiddenQuantityInput.value = currentValue - 1;
                        updateTotalPrice();
                    }
                });
            });

            increaseButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const quantitySpan = btn.parentElement.querySelector('.quantity');
                    const hiddenQuantityInput = btn.parentElement.parentElement.querySelector('.hidden-quantity');
                    let currentValue = parseInt(quantitySpan.textContent);
                    quantitySpan.textContent = currentValue + 1;
                    hiddenQuantityInput.value = currentValue + 1;
                    updateTotalPrice();
                });
            });

            // File validation
            buktiBayarInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    // Check file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File terlalu besar',
                            text: 'Ukuran file maksimal 2MB!',
                        });
                        e.target.value = ''; // Clear the input
                        return;
                    }
    
                    // Check file type (image)
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!validTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format tidak didukung',
                            text: 'Hanya menerima file gambar (JPEG, JPG, PNG)!',
                        });
                        e.target.value = ''; // Clear the input
                        return;
                    }
                }
            });
    
            // Checkout handler
            checkoutButton.addEventListener('click', async () => {
                // Personal data validation
                const nama = document.getElementById('nama').value.trim();
                const email = document.getElementById('email').value.trim();
                const noHp = document.getElementById('no_hp').value.trim();
                const metodeBayar = document.getElementById('metode_bayar').value;
                const buktiFile = document.getElementById('bukti_bayar').files[0];
    
                if (!nama || !email || !noHp || !metodeBayar) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data tidak lengkap',
                        text: 'Harap lengkapi semua data pribadi sebelum melanjutkan!',
                    });
                    return;
                }
    
                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Email tidak valid',
                        text: 'Harap masukkan alamat email yang valid!',
                    });
                    return;
                }
    
                // Phone number validation
                if (noHp.length < 10 || !/^\d+$/.test(noHp)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Nomor telepon tidak valid',
                        text: 'Harap masukkan nomor telepon yang valid (minimal 10 digit)!',
                    });
                    return;
                }
    
                // File validation
                if (!buktiFile) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Bukti pembayaran diperlukan',
                        text: 'Harap unggah bukti pembayaran sebelum melanjutkan!',
                    });
                    return;
                }
    
                // Product selection validation
                let hasProducts = false;
                let items = [];
    
                document.querySelectorAll('.hidden-quantity').forEach((input) => {
                    const productId = input.name.match(/\[(.*?)\]/)[1];
                    const quantity = parseInt(input.value);
    
                    if (quantity > 0) {
                        hasProducts = true;
                        items.push({
                            product_id: productId,
                            variant_id: variants[productId],
                            quantity: quantity,
                            price: prices[productId]
                        });
                    }
                });
    
                if (!hasProducts) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak ada produk',
                        text: 'Harap pilih setidaknya satu produk sebelum melanjutkan!',
                    });
                    return;
                }
    
                // Confirmation dialog
                const { isConfirmed } = await Swal.fire({
                    title: 'Konfirmasi Pesanan',
                    html: `
                        <div class="text-left">
                            <p class="mb-2"><strong>Nama:</strong> ${nama}</p>
                            <p class="mb-2"><strong>Email:</strong> ${email}</p>
                            <p class="mb-2"><strong>No HP:</strong> ${noHp}</p>
                            <p class="mb-2"><strong>Metode Bayar:</strong> ${metodeBayar}</p>
                            <p class="mb-2"><strong>Total Pembayaran:</strong> Rp${document.getElementById('grand_total').value.toLocaleString('id-ID')}</p>
                        </div>
                        <p class="mt-4">Apakah Anda yakin dengan pesanan ini?</p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, lanjutkan!',
                    cancelButtonText: 'Batal'
                });
    
                if (isConfirmed) {
                    // Show loading indicator
                    Swal.fire({
                        title: 'Memproses pesanan...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
    
                    try {
                        // Create FormData
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                        formData.append('nama', nama);
                        formData.append('email', email);
                        formData.append('no_hp', noHp);
                        formData.append('metodebayar', metodeBayar);
                        formData.append('bukti', buktiFile);
                        formData.append('grand_total', document.getElementById('grand_total').value);
    
                        // Add items
                        items.forEach((item, index) => {
                            formData.append(`items[${index}][product_id]`, item.product_id);
                            formData.append(`items[${index}][variant_id]`, item.variant_id);
                            formData.append(`items[${index}][quantity]`, item.quantity);
                            formData.append(`items[${index}][price]`, item.price);
                        });
    
                        // Submit form
                        const response = await fetch('/beli-merch', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
    
                        const data = await response.json();
    
                        if (!response.ok) {
                            throw new Error(data.message || 'Terjadi kesalahan pada server');
                        }
    
                        // Success
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Pembelian merchandise berhasil dilakukan.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '/';
                        });
    
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: error.message || 'Terjadi kesalahan saat mengirim data',
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>
