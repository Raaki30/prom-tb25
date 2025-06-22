<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pesan Tiket - Prom Night TB25</title>

    {{-- TAILWIND --}}
    @vite('resources/css/app.css')

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- FAVICON --}}

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
    <div id="progress-bar" class="progress-bar m-auto w-full">
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
            <li class="flex items-center text-white">
                <span
                    class="me-2 flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-gray-500 text-xs dark:border-gray-400">
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

   

    {{-- ISI IDENTITAS --}}
    <div class="w-full">
        <div
            class="identitas identitas mt-30 mx-auto bg-gelap-800 sm:scale-130 w-full scale-100 rounded-xl px-5 pb-10 pt-5 sm:w-1/3 md:w-2/3 lg:w-1/2 xl:w-1/3">
            <h1 class="font-fancy-3 mb-10 mt-5 text-center text-6xl text-white sm:text-5xl">Registration</h1>
            <form id="nisForm" class="space-y-6">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-200">Nomor Induk Siswa (NIS) / Nama</label>
                    <div class="relative">
                        <input type="text" id="nis" name="nis"
                            placeholder="Masukkan nama kamu atau NIS"
                            class="w-full rounded-xl border border-gray-300 px-5 py-3 text-white outline-none transition-all focus:border-red-500 focus:ring-2 focus:ring-red-500"
                            autocomplete="off" required />
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-200"></i>

                        <!-- Changed from absolute to relative positioning and improved width constraints -->
                        <div id="searchResults"
                            class="relative z-50 mt-2 hidden max-h-60 w-full overflow-y-auto rounded-xl border border-gray-200 bg-white shadow-lg">
                        </div>
                    </div>
                </div>

                <div id="siswaInfo"
                    class="flex hidden items-center gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4 transition-all">
                    <i class="fas fa-user text-xl text-red-500"></i>
                    <div>
                        <p class="text-base font-semibold text-gray-800" id="siswaNama"></p>
                        <p class="text-sm text-gray-600" id="siswaKelas"></p>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="/guest-registration" class="text-blue-400 hover:underline text-sm">
                        Dari Luar TB? Pesan disini
                    </a>
                </div>
                <button type="submit" id="submitButton"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-red-500 py-3 font-semibold text-white transition-all hover:bg-red-600 disabled:opacity-50"
                    disabled>
                    <span>Lanjutkan ke Pemesanan</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Couple Ticket Popup -->
    <div id="couplePopup" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="absolute inset-0 bg-black/30 backdrop-blur-md" id="popupOverlay"></div>
        <div class="relative mx-auto flex max-w-lg flex-col gap-4 rounded-2xl border border-red-600/30 bg-black p-8 text-left font-medium text-white shadow-lg transform transition-all duration-300 scale-95 opacity-0"
            style="box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.25);" id="popupContent">
            <button class="absolute right-4 top-4 text-white hover:text-red-400 transition-colors" id="closePopup">
            <i class="fas fa-times text-xl"></i>
            </button>
            <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                <i class="fa-solid fa-heart text-2xl text-red-600"></i>
            </div>
            <p class="font-fancy-3 text-4xl text-red-400">
                Couple Package
            </p>
            </div>
            
            <h3 class="text-2xl font-semibold text-gold-300 mt-2">Special Discount for Couples!</h3>
            <p class="text-base text-yellow-100">Bring your date and save on tickets when you register as a couple. Enjoy the perfect night together with special pricing!</p>
            
            <a href="/couple" class="mt-4 inline-block self-start rounded-xl bg-red-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-600">
            <i class="fas fa-ticket-alt mr-2"></i> Get Couple Tickets
            </a>
        </div>
    </div>

    <x-footer></x-footer>
    {{-- <x-whatsapp></x-whatsapp> --}}

    {{-- BACKEND STUFF --}}
    <form class="hidden" action="/payment/detail" method="POST" id="paymentForm">
        @csrf
        <input type="hidden" name="nis" id="nisInput">
        <input type="hidden" name="nama_siswa" id="namaSiswaInput">
        <input type="hidden" name="kelas" id="kelasInput">
        
    </form>
    <script>
        async function validateNis(nis) {
            try {
                const res = await fetch(`/api/validasi-nis/${nis}`);
                const data = await res.json();

                const info = document.getElementById('siswaInfo');
                const submit = document.getElementById('submitButton');

                if (data.valid) {
                    info.classList.remove('hidden');
                    document.getElementById('siswaNama').textContent = data.siswa.nama_siswa;
                    document.getElementById('siswaKelas').textContent = `Kelas: ${data.siswa.kelas}`;
                    submit.disabled = false;
                } else {
                    info.classList.add('hidden');
                    submit.disabled = true;
                    Swal.fire({
                        icon: 'error',
                        title: 'Anda Sudah Melakukan Pembelian',
                        text: 'Pembelian hanya bisa satu kali. Hubungi tim jika ini kesalahan.',
                        confirmButtonColor: '#3b82f6'
                    });
                }
            } catch {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                    confirmButtonColor: '#3b82f6'
                });
            }
        }

        async function performSearch(query) {
            const results = document.getElementById('searchResults');
            if (query.length < 3) return results.classList.add('hidden');

            try {
                const res = await fetch(`/api/cari-nama?query=${encodeURIComponent(query)}`);
                const data = await res.json();

                results.innerHTML = '';

                if (!data.length) {
                    results.innerHTML = `<div class="p-4 text-center text-gray-500">
                <i class="fas fa-search text-gray-400 mb-2 text-lg"></i>
                <p class="text-sm">Tidak ada hasil</p>
            </div>`;
                } else {
                    data.forEach(siswa => {
                        const item = document.createElement('div');
                        item.className = 'p-3 cursor-pointer hover:bg-gray-50 border-b border-gray-100';
                        item.innerHTML = `
                    <div class="text-blue-500 text-sm">${siswa.nis}</div>
                    <div class="text-gray-900 font-semibold">${siswa.nama_siswa}</div>
                    <div class="text-gray-500 text-sm">${siswa.kelas}</div>
                `;
                        item.onclick = () => {
                            document.getElementById('nis').value = siswa.nis;
                            results.classList.add('hidden');
                            validateNis(siswa.nis);
                        };
                        results.appendChild(item);
                    });
                }

                results.classList.remove('hidden');
            } catch (err) {
                console.error('Search error:', err);
            }
        }

        document.getElementById('nis').addEventListener('input', (e) => {
            const query = e.target.value;
            setTimeout(() => performSearch(query), 300);

            document.getElementById('submitButton').disabled = true;
            document.getElementById('siswaInfo').classList.add('hidden');
        });

        document.addEventListener('click', (e) => {
            const nis = document.getElementById('nis');
            const results = document.getElementById('searchResults');
            if (!nis.contains(e.target) && !results.contains(e.target)) {
                results.classList.add('hidden');
            }
        });

        document.getElementById('nisForm').addEventListener('submit', (e) => {
            e.preventDefault();

            const info = document.getElementById('siswaInfo');
            if (info.classList.contains('hidden')) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Data Belum Valid',
                    text: 'Silakan pilih siswa dari pencarian dulu.',
                    confirmButtonColor: '#3b82f6'
                });
            }

            document.getElementById('nisInput').value = document.getElementById('nis').value;
            document.getElementById('namaSiswaInput').value = document.getElementById('siswaNama').textContent;
            document.getElementById('kelasInput').value = document.getElementById('siswaKelas').textContent.replace(
                'Kelas: ', '');
            

            document.getElementById('paymentForm').submit();
        });

        // Popup functionality
        document.addEventListener('DOMContentLoaded', () => {
            const popup = document.getElementById('couplePopup');
            const popupContent = document.getElementById('popupContent');
            const closeBtn = document.getElementById('closePopup');
            const overlay = document.getElementById('popupOverlay');
            
            // Show popup with slight delay
            setTimeout(() => {
                popup.classList.remove('hidden');
                setTimeout(() => {
                    popupContent.classList.add('scale-100', 'opacity-100');
                    popupContent.classList.remove('scale-95', 'opacity-0');
                }, 10);
            }, 750);
            
            // Close popup function
            const closePopup = () => {
                popupContent.classList.remove('scale-100', 'opacity-100');
                popupContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    popup.classList.add('hidden');
                }, 300);
            };
            
            // Close events
            closeBtn.addEventListener('click', closePopup);
            overlay.addEventListener('click', closePopup);
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Add animated background pattern and stars
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
