@php
    $iswaiting_active = \App\Models\Control::value('iswaitingroomactive');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembayaran - Prom Night TB25</title>

    {{-- TAILWIND --}}
    @vite('resources/css/app.css')

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ephesis&family=Imperial+Script&family=Lavishly+Yours&display=swap"
        rel="stylesheet">
    <style>
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(234,179,8,0.03) 1px, transparent 1px),
                radial-gradient(circle at 75% 75%, rgba(234,179,8,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -2;
            pointer-events: none;
        }
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            pointer-events: none;
        }
        .star {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: twinkle 4s infinite ease-in-out;
        }
        @keyframes twinkle {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.8; }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#2e0705] to-[#060604] min-h-screen">

    {{-- NAVIGATION - PROSES BAYAR --}}
    <div id="progress-bar" class="progress-bar m-auto w-full ">
        <ol
            class="shadow-xs bg-progress rounded-b-4xl mx-auto flex w-fit items-center space-x-2 rounded-t-sm p-5 text-center text-sm font-medium text-gray-500 sm:space-x-4 sm:p-4 sm:text-2xl">
            <li class="text-gold-500 flex items-center">
                <span
                    class="border-gold-500 me-2 flex h-5 w-5 shrink-0 items-center justify-center rounded-full border text-xs">
                    1
                </span>
                Identitas</span>
                <svg class="ms-2 h-3 w-3 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="text-gold-500 flex items-center">
                <span
                    class="border-gold-500 me-2 flex h-5 w-5 shrink-0 items-center justify-center rounded-full border text-xs">
                    2
                </span>
                Konfirmasi</span>
                <svg class="ms-2 h-3 w-3 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center text-white">
                <span
                    class="me-2 flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-gray-500 text-xs dark:border-gray-400">
                    3
                </span>
                Pembayaran
            </li>
        </ol>
    </div>


    {{-- END NAVIGATION --}}

    {{-- CONTENT --}}
    <div class="mt-15 flex flex-grow items-center justify-center lg:p-6 scale-100 sm:scale-110">
        <div class="w-full max-w-3xl">
            <div id="order-details" class="bg-gelap-800 gradient-bg-payment rounded-2xl shadow-2xl mx-5">
                <div class="px-4 pt-10 pb-5 sm:px-8">
                    <h1 class="font-fancy-3 mb-8 text-center text-6xl font-bold text-gray-50">Payment Detail</h1>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-5 sm:mb-0">
                        <!-- Info Siswa -->
                        <div class="box-payment-detail  rounded-xl p-4 pb-6 pt-2 sm:bg-transparent lg:p-6">
                            <h2 class="mb-4 border-b-2 border-gray-200 text-2xl font-semibold text-white"><i
                                    class="fa fa-user text-red-500"></i> Student Information</h2>
                            <div class="grid grid-cols-1 gap-4 text-sm text-white">
                                <div class="text-left text-lg font-medium">
                                    <p class="text-red-500">{{ $nis }}</p>
                                    <p class="">{{ $nama_siswa }}</p>
                                    <p class="">{{ $kelas }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ringkasan Pesanan -->
                        <div class="box-payment-detail mb-6 rounded-xl p-4 sm:bg-transparent lg:p-6">
                            <h2 class="mb-4 border-b-2 border-gray-200 text-2xl font-semibold text-white"><i
                                    class="fa fa-box-open text-red-500"></i> Order Summary</h2>
                            <div class="grid grid-cols-2 gap-4 text-sm text-white">
                                <div class="text-lg">
                                    <p class="mb-2">Student Ticket:</p>
                                    <p class="mb-2">Biaya Lain:</p>
                                    <hr class="my-2">
                                    <p class="font-bold">Total Price:</p>
                                </div>
                                <div class="text-right text-lg font-medium">
                                    <p class="mb-2">1 x Rp{{ number_format($harga, 0, ',', '.') }}</p>
                                    <p class="mb-2">Rp{{ number_format($biaya_lain, 0, ',', '.') }}</p>
                                    <hr class="my-2">
                                    <p class="text-lg font-bold text-green-500 flex flex-col items-end" id="totalPriceWrapper">
                                        <span id="originalPrice" class="line-through text-xs text-gray-400 hidden">Rp{{ number_format($grand_total, 0, ',', '.') }}</span>
                                        <span id="totalPrice">Rp{{ number_format($grand_total, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulir Pembayaran -->
                    <form action="/payment/process" method="POST" class="space-y-4" autocomplete="off">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ 'TB-' . Str::upper(Str::random(4)) . mt_rand(10, 99); }}">
                        <input type="hidden" name="nis" value="{{ $nis }}">
                        <input type="hidden" name="nama_siswa" value="{{ $nama_siswa }}">
                        <input type="hidden" name="kelas" value="{{ $kelas }}">
                        <input type="hidden" name="harga" value="{{ $harga }}">
                        <input type="hidden" name="grandtotal" id="grandTotalInput" value="{{ $grand_total * 1.0 }}">
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-gray-200">Alamat
                                Email</label>
                            <input type="email" name="email" id="email" placeholder="john.doe@example.com"
                                class="@error('email') border-red-500 @enderror w-full border-0 border-b-2 border-gray-400 bg-transparent px-1 py-2 text-white transition duration-300 focus:border-red-500 focus:outline-none"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="mb-2 block text-sm font-medium text-gray-200">Nomor HP</label>
                            <input type="tel" name="phone" id="phone" placeholder="08xxxxxxx"
                                class="@error('phone') border-red-500 @enderror w-full border-0 border-b-2 border-gray-400 bg-transparent px-1 py-2 text-white transition duration-300 focus:border-red-500 focus:outline-none"
                                value="{{ old('phone') }}" required>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- JENIS BAYAR, FULL / DP --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-200">Jumlah Bayar</label>
                                
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" name="jumlahbayar" value="bca" class="peer sr-only">
                                <div
                                    class="h-5 w-5 rounded-full border-2 border-red-500 transition duration-200 peer-checked:bg-red-500">
                                </div>
                                <span class="text-gray-200">Bayar Full</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" name="jumlahbayar" value="mandiri" class="peer sr-only" @if($iswaiting_active) disabled @endif>
                                <div
                                    class="h-5 w-5 rounded-full border-2 border-red-500 transition duration-200 peer-checked:bg-red-500 @if($iswaiting_active) opacity-50 @endif">
                                </div>
                                <span class="text-gray-200 @if($iswaiting_active) opacity-50 @endif">Bayar 50% di awal, dan sisanya saat hari H</span>
                                @if($iswaiting_active)
                                    <span class="ml-2 text-xs text-yellow-400">(Tidak tersedia saat ini)</span>
                                @endif
                            </label>
                        </div>
                        {{-- PAYMENT METHOD --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-200">Metode Pembayaran</label>
                                
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" name="metodebayar" value="bca" class="peer sr-only" checked>
                                <div
                                    class="h-5 w-5 rounded-full border-2 border-red-500 transition duration-200 peer-checked:bg-red-500">
                                </div>
                                <span class="text-gray-200">Bank Transfer</span>
                            </label>
                        </div>


                        <div class="flex flex-col gap-4 p-5 sm:flex-row">
                            <a href="{{ url()->previous() }}"
                                class="w-full rounded-lg bg-white py-3 text-center text-gray-800 transition-colors hover:bg-gray-300">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                            <button type="submit"
                                class="w-full rounded-lg bg-red-500 py-3 font-semibold text-white transition-colors hover:bg-red-700">
                                <i class="fas fa-credit-card mr-2"></i>Lanjut ke Pembayaran
                            </button>
                        </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <x-footer></x-footer>
    {{-- <x-whatsapp></x-whatsapp> --}}
    @stack('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const fullRadio = document.querySelector('input[name="jumlahbayar"][value="bca"]');
        const halfRadio = document.querySelector('input[name="jumlahbayar"][value="mandiri"]');
        const totalPriceEl = document.getElementById('totalPrice');
        const grandTotalInput = document.getElementById('grandTotalInput');
        const originalPriceEl = document.getElementById('originalPrice');
        const originalTotal = {{ $grand_total }};

        function formatRupiah(angka) {
            return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateTotal(isHalf) {
            if (isHalf) {
                let newTotal = Math.round(originalTotal / 2);
                totalPriceEl.textContent = formatRupiah(newTotal);
                grandTotalInput.value = newTotal;
                originalPriceEl.classList.remove('hidden');
            } else {
                totalPriceEl.textContent = formatRupiah(originalTotal);
                grandTotalInput.value = originalTotal;
                originalPriceEl.classList.add('hidden');
            }
        }

        if (fullRadio && halfRadio) {
            fullRadio.addEventListener('change', function() {
                if (this.checked) updateTotal(false);
            });
            halfRadio.addEventListener('change', function() {
                if (this.checked) updateTotal(true);
            });
        }

        const form = document.querySelector('form[action="/payment/process"]');
        const submitBtn = form.querySelector('button[type="submit"]');
        const confirmPopup = document.getElementById('confirmPopup');
        const confirmPopupOverlay = document.getElementById('confirmPopupOverlay');
        const closeConfirmPopup = document.getElementById('closeConfirmPopup');
        const confirmSubmit = document.getElementById('confirmSubmit');
        const cancelSubmit = document.getElementById('cancelSubmit');
        const recapText = document.getElementById('recapText');

        function getRecapText() {
            let isHalf = halfRadio && halfRadio.checked;
            let recap = `<b>Nama:</b> ${form['nama_siswa'].value}<br>` +
                        `<b>Kelas:</b> ${form['kelas'].value}<br>` +
                        `<b>Total Bayar:</b> ${totalPriceEl.textContent}<br>`;
            if (isHalf) {
                recap += `<div class='mt-2 p-2 rounded bg-yellow-100 text-yellow-900 text-sm'><b>Catatan:</b> Anda memilih bayar 50%. Sisa pembayaran dilakukan saat masuk acara.</div>`;
            }
            return recap;
        }

        function showConfirmPopup() {
            recapText.innerHTML = getRecapText();
            confirmPopup.classList.remove('hidden');
        }
        function hideConfirmPopup() {
            confirmPopup.classList.add('hidden');
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            showConfirmPopup();
        });
        confirmSubmit.addEventListener('click', function() {
            hideConfirmPopup();
            form.submit();
        });
        cancelSubmit.addEventListener('click', hideConfirmPopup);
        closeConfirmPopup.addEventListener('click', hideConfirmPopup);
        confirmPopupOverlay.addEventListener('click', hideConfirmPopup);
    });
    </script>

    <!-- Confirmation Popup -->
    <div id="confirmPopup" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" id="confirmPopupOverlay"></div>
        <div class="relative mx-auto flex max-w-md flex-col gap-4 rounded-2xl border border-yellow-400/30 bg-gray-900 p-8 text-left font-medium text-white shadow-lg">
            <button class="absolute right-4 top-4 text-white hover:text-red-400 transition-colors" id="closeConfirmPopup">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-2xl font-semibold text-yellow-300">Konfirmasi Pembayaran</h3>
            <div id="recapText" class="text-base text-gray-100"></div>
            <div class="mt-4 flex gap-2">
                <button id="confirmSubmit" class="flex-1 rounded-lg bg-green-500 py-2 font-semibold text-white hover:bg-green-600">Ya, Lanjutkan</button>
                <button id="cancelSubmit" class="flex-1 rounded-lg bg-gray-500 py-2 font-semibold text-white hover:bg-gray-600">Batal</button>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const starsContainer = document.createElement('div');
    starsContainer.className = 'stars';
    document.body.appendChild(starsContainer);
    const pattern = document.createElement('div');
    pattern.className = 'bg-pattern';
    document.body.appendChild(pattern);
    for(let i = 0; i < 100; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        const size = Math.random() * 3 + 1;
        star.style.width = `${size}px`;
        star.style.height = `${size}px`;
        star.style.top = `${Math.random() * 100}%`;
        star.style.left = `${Math.random() * 100}%`;
        star.style.animationDelay = `${Math.random() * 4}s`;
        starsContainer.appendChild(star);
    }
});
</script>
</body>
</html>
