<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembayaran Group - Prom Night TB25</title>

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
            pointer-events: none;
            z-index: 0;
            opacity: 0.18;
            background-image: url('data:image/svg+xml;utf8,<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" fill="%23000000" fill-opacity="0"/><circle cx="20" cy="20" r="1.5" fill="%23fff" fill-opacity="0.12"/></svg>');
        }

        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 1;
        }

        .star {
            position: absolute;
            border-radius: 50%;
            background: white;
            opacity: 0.7;
            animation: twinkle 2s infinite ease-in-out;
        }

        @keyframes twinkle {
            0%,
            100% {
                opacity: 0.7;
            }

            50% {
                opacity: 0.2;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#2e0705] to-[#060604] min-h-screen">
    <!-- Animated Background Overlays -->
    <div class="bg-pattern fixed inset-0 w-[100vw] h-[100vh] pointer-events-none z-0"
        style="background-image: radial-gradient(rgba(255,255,255,0.07)_1px,transparent_1px), radial-gradient(rgba(255,255,255,0.04)_1px,transparent_1px); background-size: 40px 40px, 80px 80px; background-position: 0 0, 20px 20px;"></div>
    <div class="stars fixed inset-0 w-[100vw] h-[100vh] pointer-events-none z-10"></div>
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
                    <h1 class="font-fancy-3 mb-8 text-center text-6xl font-bold text-gray-50">Bundle Payment</h1>
                    
                    <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-heart text-red-400"></i>
                            <h3 class="text-red-400 text-lg font-medium">Group Ticket Bundle</h3>
                        </div>
                        <p class="text-white/80 mt-1">
                            {{ $ticketCount }} orang x Rp{{ number_format($harga, 0, ',', '.') }} = Rp{{ number_format($grand_total, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-5 sm:mb-0">
                        <!-- Info Siswa -->
                        <div class="box-payment-detail rounded-xl p-4 pb-6 pt-2 sm:bg-transparent lg:p-6">
                            <h2 class="mb-4 border-b-2 border-gray-200 text-2xl font-semibold text-white">
                                <i class="fa fa-users text-red-500"></i> Student Information
                            </h2>
                            <div class="grid grid-cols-1 gap-4 text-sm text-white">
                                <div class="text-left text-lg font-medium">
                                    @foreach($participants as $index => $participant)
                                        <p class="text-red-400 font-semibold">Peserta {{ $index + 1 }}:</p>
                                        <p class="text-red-500">{{ $participant['nis'] }}</p>
                                        <p>{{ $participant['nama_siswa'] }}</p>
                                        <p class="mb-4">{{ $participant['kelas'] }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Ringkasan Pesanan -->
                        <div class="box-payment-detail mb-6 rounded-xl p-4 sm:bg-transparent lg:p-6">
                            <h2 class="mb-4 border-b-2 border-gray-200 text-2xl font-semibold text-white">
                                <i class="fa fa-box-open text-red-500"></i> Order Summary
                            </h2>
                            <div class="flex justify-between items-center text-white mb-2">
                                <span>Harga per Tiket:</span>
                                <span>Rp{{ number_format($harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-white mb-4">
                                <span>Jumlah Tiket:</span>
                                <span>{{ $ticketCount }}</span>
                            </div>
                            <div class="flex justify-between items-center text-lg text-white pt-2 border-t border-gray-600">
                                <span class="font-bold">Grand Total:</span>
                                <span class="font-bold text-green-500">Rp{{ number_format($grand_total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Formulir Pembayaran -->
                    <form action="/payment/group/process" method="POST" class="space-y-4" autocomplete="off">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ 'GP-' . Str::upper(Str::random(4)) . mt_rand(10, 99) }}">
                        <input type="hidden" name="ticketCount" value="{{ $ticketCount }}">
                        <input type="hidden" name="harga" value="{{ $harga }}">
                        <input type="hidden" name="grandtotal" value="{{ $grand_total }}">
                        
                        @foreach($participants as $index => $participant)
                            <input type="hidden" name="nis{{ $index + 1 }}" value="{{ $participant['nis'] }}">
                            <input type="hidden" name="nama_siswa{{ $index + 1 }}" value="{{ $participant['nama_siswa'] }}">
                            <input type="hidden" name="kelas{{ $index + 1 }}" value="{{ $participant['kelas'] }}">
                        @endforeach
    
                        <div class="space-y-6">
                            @foreach($participants as $index => $participant)
                                <div class="bg-gray-800/50 rounded-lg p-4">
                                    <h3 class="text-white font-medium mb-3 flex items-center">
                                        <i class="fas fa-user-circle text-red-400 mr-2"></i>
                                        Kontak Peserta {{ $index + 1 }} ({{ $participant['nama_siswa'] }})
                                    </h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="email{{ $index + 1 }}" class="mb-2 block text-sm font-medium text-gray-200">
                                                Alamat Email
                                            </label>
                                            <input id="email{{ $index + 1 }}" name="email{{ $index + 1 }}" type="email"
                                                class="w-full border-0 border-b-2 bg-transparent px-1 py-2 text-white transition duration-300 focus:border-yellow-400 focus:outline-none @error('email'.($index+1)) border-red-500 @else border-gray-400 @enderror"
                                                placeholder="Email Peserta {{ $index + 1 }}" value="{{ old('email'.($index+1)) }}" required>
                                            @error('email'.($index+1))
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="phone{{ $index + 1 }}" class="mb-2 block text-sm font-medium text-gray-200">Nomor HP</label>
                                            <input id="phone{{ $index + 1 }}" name="phone{{ $index + 1 }}" type="text"
                                                class="w-full border-0 border-b-2 bg-transparent px-1 py-2 text-white transition duration-300 focus:border-yellow-400 focus:outline-none @error('phone'.($index+1)) border-red-500 @else border-gray-400 @enderror"
                                                placeholder="Nomor HP Peserta {{ $index + 1 }}" value="{{ old('phone'.($index+1)) }}" required>
                                            @error('phone'.($index+1))
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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

    <script>
        // Twinkling stars background
        function createStars() {
            const stars = document.querySelector('.stars');
            if (!stars) return;
            stars.innerHTML = '';
            const numStars = 60;
            for (let i = 0; i < numStars; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                const size = Math.random() * 2 + 1;
                star.style.width = `${size}px`;
                star.style.height = `${size}px`;
                star.style.position = 'absolute';
                star.style.top = `${Math.random() * 100}%`;
                star.style.left = `${Math.random() * 100}%`;
                star.style.background = 'white';
                star.style.opacity = Math.random() * 0.7 + 0.2;
                star.style.borderRadius = '50%';
                star.style.boxShadow = `0 0 6px 2px white`;
                star.style.animation = `twinkle 2s infinite ${Math.random() * 2}s`;
                stars.appendChild(star);
            }
        }
        document.addEventListener('DOMContentLoaded', createStars);
    </script>
    <style>
        @keyframes twinkle {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 0.2; }
        }
        .star {
            pointer-events: none;
            z-index: 11;
        }
        .bg-pattern {
            z-index: 0;
        }
        .stars {
            z-index: 10;
        }
    </style>
</body>

</html>