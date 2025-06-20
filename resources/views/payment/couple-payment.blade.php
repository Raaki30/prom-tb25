<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembayaran Couple - Prom Night TB25</title>

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
</head>

<body class="gradient-bg-dark">

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
                    <h1 class="font-fancy-3 mb-8 text-center text-6xl font-bold text-gray-50">Couple Payment</h1>
                    
                    <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-heart text-red-400"></i>
                            <h3 class="text-red-400 text-lg font-medium">Couple Ticket Bundle</h3>
                        </div>
                        <p class="text-white/80 mt-1">Nikmati diskon dengan pembelian tiket bundle</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-5 sm:mb-0">
                        <!-- Info Siswa -->
                        <div class="box-payment-detail rounded-xl p-4 pb-6 pt-2 sm:bg-transparent lg:p-6">
                            <h2 class="mb-4 border-b-2 border-gray-200 text-2xl font-semibold text-white">
                                <i class="fa fa-users text-red-500"></i> Student Information
                            </h2>
                            <div class="grid grid-cols-1 gap-4 text-sm text-white">
                                <div class="text-left text-lg font-medium">
                                    <p class="text-red-400 font-semibold">Peserta 1:</p>
                                    <p class="text-red-500">{{ $nis1 }}</p>
                                    <p>{{ $nama_siswa1 }}</p>
                                    <p class="mb-4">{{ $kelas1 }}</p>

                                    <p class="text-red-400 font-semibold">Peserta 2:</p>
                                    <p class="text-red-500">{{ $nis2 }}</p>
                                    <p>{{ $nama_siswa2 }}</p>
                                    <p>{{ $kelas2 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ringkasan Pesanan -->
                        <div class="box-payment-detail mb-6 rounded-xl p-4 sm:bg-transparent lg:p-6">
                            <h2 class="mb-4 border-b-2 border-gray-200 text-2xl font-semibold text-white">
                                <i class="fa fa-box-open text-red-500"></i> Order Summary
                            </h2>
                            <div class="flex justify-between items-center text-lg text-white">
                                <span class="font-bold">Grand Total:</span>
                                <span class="font-bold text-green-500">Rp{{ number_format($grand_total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Formulir Pembayaran -->
                    <form action="/payment/couple/process" method="POST" class="space-y-4" autocomplete="off">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ 'CP-' . Str::upper(Str::random(4)) . mt_rand(10, 99) }}">
                        <input type="hidden" name="nis1" value="{{ $nis1 }}">
                        <input type="hidden" name="nama_siswa1" value="{{ $nama_siswa1 }}">
                        <input type="hidden" name="kelas1" value="{{ $kelas1 }}">
                        <input type="hidden" name="nis2" value="{{ $nis2 }}">
                        <input type="hidden" name="nama_siswa2" value="{{ $nama_siswa2 }}">
                        <input type="hidden" name="kelas2" value="{{ $kelas2 }}">
                        <input type="hidden" name="harga" value="{{ $total_per_tiket }}">
                        <input type="hidden" name="grandtotal" value="{{ $grand_total }}">
                        
                        <div class="space-y-6">
                            <!-- Peserta 1 contact info -->
                            <div class="bg-gray-800/50 rounded-lg p-4">
                                <h3 class="text-white font-medium mb-3 flex items-center">
                                    <i class="fas fa-user-circle text-red-400 mr-2"></i>
                                    Kontak Peserta 1 ({{ $nama_siswa1 }})
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="email1" class="mb-2 block text-sm font-medium text-gray-200">Alamat
                                            Email</label>
                                        <input type="email" name="email1" id="email1" placeholder="email.peserta1@example.com"
                                            class="@error('email1') border-red-500 @enderror w-full border-0 border-b-2 border-gray-400 bg-transparent px-1 py-2 text-white transition duration-300 focus:border-red-500 focus:outline-none"
                                            value="{{ old('email1') }}" required>
                                        @error('email1')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="phone1" class="mb-2 block text-sm font-medium text-gray-200">Nomor HP</label>
                                        <input type="tel" name="phone1" id="phone1" placeholder="08xxxxxxx"
                                            class="@error('phone1') border-red-500 @enderror w-full border-0 border-b-2 border-gray-400 bg-transparent px-1 py-2 text-white transition duration-300 focus:border-red-500 focus:outline-none"
                                            value="{{ old('phone1') }}" required>
                                        @error('phone1')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Peserta 2 contact info -->
                            <div class="bg-gray-800/50 rounded-lg p-4">
                                <h3 class="text-white font-medium mb-3 flex items-center">
                                    <i class="fas fa-user-circle text-red-400 mr-2"></i>
                                    Kontak Peserta 2 ({{ $nama_siswa2 }})
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="email2" class="mb-2 block text-sm font-medium text-gray-200">Alamat
                                            Email</label>
                                        <input type="email" name="email2" id="email2" placeholder="email.peserta2@example.com"
                                            class="@error('email2') border-red-500 @enderror w-full border-0 border-b-2 border-gray-400 bg-transparent px-1 py-2 text-white transition duration-300 focus:border-red-500 focus:outline-none"
                                            value="{{ old('email2') }}" required>
                                        @error('email2')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="phone2" class="mb-2 block text-sm font-medium text-gray-200">Nomor HP</label>
                                        <input type="tel" name="phone2" id="phone2" placeholder="08xxxxxxx"
                                            class="@error('phone2') border-red-500 @enderror w-full border-0 border-b-2 border-gray-400 bg-transparent px-1 py-2 text-white transition duration-300 focus:border-red-500 focus:outline-none"
                                            value="{{ old('phone2') }}" required>
                                        @error('phone2')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-200">Metode Pembayaran</label>
                                
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" name="metodebayar" value="bca" class="peer sr-only" checked>
                                <div
                                    class="h-5 w-5 rounded-full border-2 border-red-500 transition duration-200 peer-checked:bg-red-500">
                                </div>
                                <span class="text-gray-200">Bank Transfer</span>
                            </label>
                            {{-- <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" name="metodebayar" value="mandiri" class="peer sr-only">
                                <div
                                    class="h-5 w-5 rounded-full border-2 border-red-500 transition duration-200 peer-checked:bg-red-500">
                                </div>
                                <span class="text-gray-200">Mandiri Virtual Account</span>
                            </label> --}}
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
</body>

</html>