<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pesan Tiket Bundle - Prom Night TB25</title>

    {{-- TAILWIND --}}
    @vite('resources/css/app.css')

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            width: 100%;
            height: 100%;
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
            width: 100%;
            height: 100%;
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

<body class="bg-gradient-to-br from-[#2e0705] to-[#060604] min-h-full">

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
            class="identitas mt-30 mx-auto bg-gelap-800 sm:scale-120 w-full scale-100 rounded-xl px-5 pb-10 pt-5 sm:w-1/3 md:w-2/3 lg:w-3/5 xl:w-2/5">
            <h1 class="font-fancy-3 mb-10 mt-5 text-center text-6xl text-white sm:text-5xl">Couple Registration</h1>
            
            <div class="bg-gray-900 mb-5 p-4 rounded-lg border border-gray-700">
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-400"></i>
                    <p class="text-blue-400 font-medium">Couple Ticket Info</p>
                </div>
                <p class="text-gray-300 text-sm mt-2">Beli tiket untuk 2 orang dan dapatkan harga spesial</p>
            </div>

            <div class="step-indicator flex justify-between px-2 mb-6">
                <div id="step-1-indicator" class="step-dot flex flex-col items-center">
                    <div class="h-6 w-6 rounded-full bg-red-500 flex items-center justify-center text-white">1</div>
                    <span class="text-xs text-white mt-1">Peserta 1</span>
                </div>
                <div class="flex-grow border-t-2 border-gray-500 self-start mt-3 mx-2"></div>
                <div id="step-2-indicator" class="step-dot flex flex-col items-center opacity-50">
                    <div class="h-6 w-6 rounded-full bg-gray-500 flex items-center justify-center text-white">2</div>
                    <span class="text-xs text-white mt-1">Peserta 2</span>
                </div>
            </div>

            <form id="coupleForm" class="space-y-6">
                @csrf

                <!-- Step 1: First Person -->
                <div id="step1" class="transition-all duration-300">
                    <h3 class="text-white text-xl font-medium mb-4">Informasi Peserta 1</h3>
                    
                    <div class="mb-4">
                        <label class="mb-2 block text-sm font-medium text-gray-200">Nomor Induk Siswa (NIS) / Nama</label>
                        <div class="relative">
                            <input type="text" id="nis1" name="nis1"
                                placeholder="Masukkan nama kamu atau NIS"
                                class="w-full rounded-xl border border-gray-300 px-5 py-3 text-white outline-none transition-all focus:border-red-500 focus:ring-2 focus:ring-red-500"
                                autocomplete="off" required />
                            <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-200"></i>
                            <div id="searchResults1"
                                class="relative z-50 mt-2 hidden max-h-60 w-full overflow-y-auto rounded-xl border border-gray-200 bg-white shadow-lg">
                            </div>
                        </div>
                    </div>

                    <div id="siswaInfo1"
                        class="flex hidden items-center gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4 transition-all">
                        <i class="fas fa-user text-xl text-red-500"></i>
                        <div>
                            <p class="text-base font-semibold text-gray-800" id="siswaNama1"></p>
                            <p class="text-sm text-gray-600" id="siswaKelas1"></p>
                        </div>
                    </div>

                    <div class="text-center mt-8">
                        <button type="button" id="nextToStep2"
                            class="w-full items-center justify-center gap-2 rounded-xl bg-red-500 py-3 font-semibold text-white transition-all hover:bg-red-600 disabled:opacity-50 disabled:bg-gray-500"
                            disabled>
                            <span>Lanjutkan ke Peserta 2</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Second Person -->
                <div id="step2" class="hidden transition-all duration-300">
                    <h3 class="text-white text-xl font-medium mb-4">Informasi Peserta 2</h3>
                    
                    <div class="mb-4">
                        <label class="mb-2 block text-sm font-medium text-gray-200">Nomor Induk Siswa (NIS) / Nama</label>
                        <div class="relative">
                            <input type="text" id="nis2" name="nis2"
                                placeholder="Masukkan nama atau NIS peserta kedua"
                                class="w-full rounded-xl border border-gray-300 px-5 py-3 text-white outline-none transition-all focus:border-red-500 focus:ring-2 focus:ring-red-500"
                                autocomplete="off" required />
                            <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-200"></i>
                            <div id="searchResults2"
                                class="relative z-50 mt-2 hidden max-h-60 w-full overflow-y-auto rounded-xl border border-gray-200 bg-white shadow-lg">
                            </div>
                        </div>
                    </div>

                    <div id="siswaInfo2"
                        class="flex hidden items-center gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4 transition-all">
                        <i class="fas fa-user text-xl text-red-500"></i>
                        <div>
                            <p class="text-base font-semibold text-gray-800" id="siswaNama2"></p>
                            <p class="text-sm text-gray-600" id="siswaKelas2"></p>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-8">
                        <button type="button" id="backToStep1"
                            class="w-1/2 flex items-center justify-center gap-2 rounded-xl bg-gray-600 py-3 font-semibold text-white transition-all hover:bg-gray-700">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </button>
                        <button type="submit" id="submitButton"
                            class="w-1/2 flex items-center justify-center gap-2 rounded-xl bg-red-500 py-3 font-semibold text-white transition-all hover:bg-red-600 disabled:opacity-50 disabled:bg-gray-500"
                            disabled>
                            <span>Lanjutkan</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </form>

            </div>
            <div class="mb-10"></div>
            <x-footer></x-footer>

    {{-- BACKEND STUFF --}}
    <form class="hidden" action="/payment/couple" method="POST" id="paymentForm">
        @csrf
        <input type="hidden" name="nis1" id="nisInput1">
        <input type="hidden" name="nama_siswa1" id="namaSiswaInput1">
        <input type="hidden" name="kelas1" id="kelasInput1">
        <input type="hidden" name="nis2" id="nisInput2">
        <input type="hidden" name="nama_siswa2" id="namaSiswaInput2">
        <input type="hidden" name="kelas2" id="kelasInput2">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starsContainer = document.createElement('div');
            starsContainer.className = 'stars';
            document.body.appendChild(starsContainer);
            // Create background pattern
            const pattern = document.createElement('div');
            pattern.className = 'bg-pattern';
            document.body.appendChild(pattern);
            // Create stars
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

        // Step control
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step1Indicator = document.getElementById('step-1-indicator');
        const step2Indicator = document.getElementById('step-2-indicator');
        const nextToStep2 = document.getElementById('nextToStep2');
        const backToStep1 = document.getElementById('backToStep1');
        
        nextToStep2.addEventListener('click', () => {
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
            step1Indicator.classList.add('opacity-50');
            step1Indicator.querySelector('div').classList.remove('bg-red-500');
            step1Indicator.querySelector('div').classList.add('bg-gray-500');
            step2Indicator.classList.remove('opacity-50');
            step2Indicator.querySelector('div').classList.remove('bg-gray-500');
            step2Indicator.querySelector('div').classList.add('bg-red-500');
        });
        
        backToStep1.addEventListener('click', () => {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
            step2Indicator.classList.add('opacity-50');
            step2Indicator.querySelector('div').classList.remove('bg-red-500');
            step2Indicator.querySelector('div').classList.add('bg-gray-500');
            step1Indicator.classList.remove('opacity-50');
            step1Indicator.querySelector('div').classList.remove('bg-gray-500');
            step1Indicator.querySelector('div').classList.add('bg-red-500');
        });

        // Validation functions
        async function validateNis(nis, personNumber) {
            try {
                const res = await fetch(`/api/validasi-nis/${nis}`);
                const data = await res.json();

                const info = document.getElementById(`siswaInfo${personNumber}`);
                const nextButton = personNumber === '1' ? 
                    document.getElementById('nextToStep2') : 
                    document.getElementById('submitButton');

                if (data.valid) {
                    info.classList.remove('hidden');
                    document.getElementById(`siswaNama${personNumber}`).textContent = data.siswa.nama_siswa;
                    document.getElementById(`siswaKelas${personNumber}`).textContent = `Kelas: ${data.siswa.kelas}`;
                    nextButton.disabled = false;
                } else {
                    info.classList.add('hidden');
                    nextButton.disabled = true;
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

        async function performSearch(query, personNumber) {
            const results = document.getElementById(`searchResults${personNumber}`);
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
                            document.getElementById(`nis${personNumber}`).value = siswa.nis;
                            results.classList.add('hidden');
                            validateNis(siswa.nis, personNumber);
                        };
                        results.appendChild(item);
                    });
                }

                results.classList.remove('hidden');
            } catch (err) {
                console.error('Search error:', err);
            }
        }

        // Event listeners for search
        ['1', '2'].forEach(personNumber => {
            document.getElementById(`nis${personNumber}`).addEventListener('input', (e) => {
                const query = e.target.value;
                setTimeout(() => performSearch(query, personNumber), 300);

                const nextButton = personNumber === '1' ? 
                    document.getElementById('nextToStep2') : 
                    document.getElementById('submitButton');
                
                nextButton.disabled = true;
                document.getElementById(`siswaInfo${personNumber}`).classList.add('hidden');
            });
        });

        // Hide search results when clicking outside
        document.addEventListener('click', (e) => {
            ['1', '2'].forEach(personNumber => {
                const nis = document.getElementById(`nis${personNumber}`);
                const results = document.getElementById(`searchResults${personNumber}`);
                
                if (nis && results && !nis.contains(e.target) && !results.contains(e.target)) {
                    results.classList.add('hidden');
                }
            });
        });

        // Form submission
        document.getElementById('coupleForm').addEventListener('submit', (e) => {
            e.preventDefault();

            const info1 = document.getElementById('siswaInfo1');
            const info2 = document.getElementById('siswaInfo2');
            
            if (info1.classList.contains('hidden') || info2.classList.contains('hidden')) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Data Belum Lengkap',
                    text: 'Silakan pilih kedua siswa dari pencarian terlebih dahulu.',
                    confirmButtonColor: '#3b82f6'
                });
            }

            // Check if same person is selected
            if (document.getElementById('nis1').value === document.getElementById('nis2').value) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Peserta Duplikat',
                    text: 'Anda tidak dapat memilih orang yang sama untuk kedua tiket.',
                    confirmButtonColor: '#3b82f6'
                });
            }

            // Transfer values to the hidden form
            document.getElementById('nisInput1').value = document.getElementById('nis1').value;
            document.getElementById('namaSiswaInput1').value = document.getElementById('siswaNama1').textContent;
            document.getElementById('kelasInput1').value = document.getElementById('siswaKelas1').textContent.replace('Kelas: ', '');
            
            document.getElementById('nisInput2').value = document.getElementById('nis2').value;
            document.getElementById('namaSiswaInput2').value = document.getElementById('siswaNama2').textContent;
            document.getElementById('kelasInput2').value = document.getElementById('siswaKelas2').textContent.replace('Kelas: ', '');

            document.getElementById('paymentForm').submit();
        });
    </script>
</body>

</html>