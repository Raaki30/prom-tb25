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
        <div class="identitas mt-30 mx-auto bg-gelap-800 sm:scale-120 w-full scale-100 rounded-xl px-5 pb-10 pt-5 sm:w-1/3 md:w-2/3 lg:w-3/5 xl:w-2/5">
            <h1 class="font-fancy-3 mb-10 mt-5 text-center text-6xl text-white sm:text-5xl">Bundle Registration</h1>
            <div class="bg-gray-900 mb-5 p-4 rounded-lg border border-gray-700">
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-400"></i>
                    <p class="text-blue-400 font-medium">Bundle Ticket Info</p>
                </div>
                <p class="text-gray-300 text-sm mt-2">Beli tiket untuk beberapa orang sekaligus dan dapatkan harga spesial</p>
            </div>

            {{-- Step 1: Ticket Count Selector --}}
            <div id="ticketCountStep" class="mb-6 text-center">
                <label for="ticketCount" class="block text-lg text-white font-semibold mb-2">Berapa tiket bundle yang ingin dibeli?</label>
                <select id="ticketCount" class="rounded-lg px-4 py-2 text-lg text-white border-2 border-red-700 hover:bg-gelap-700" style="min-width: 120px;">
                    <option class="text-white bg-nogelap-700ne" value="2" selected>2 Tiket</option>
                    <option class="text-white bg-gelap-700" value="3">3 Tiket</option>
                    <option class="text-white bg-gelap-700" value="4">4 Tiket</option>
                    <option class="text-white bg-gelap-700" value="5">5 Tiket</option>
                </select>
                <button id="startRegistration" class="ml-4 mt-4 rounded-lg bg-red-500 px-6 py-2 text-white font-semibold hover:bg-red-600 transition">Lanjutkan</button>
            </div>

            {{-- Step 2: Dynamic Steps Form --}}
            <form id="coupleForm" class="space-y-6 hidden">
                @csrf
                <div id="stepsContainer"></div>
                <div class="flex gap-3 mt-8" id="navigationButtons"></div>
            </form>
        </div>
        <div class="mb-10"></div>
        <x-footer></x-footer>

    {{-- BACKEND STUFF --}}
    <form class="hidden" action="/payment/group" method="POST" id="paymentForm">
        @csrf
        @for ($i = 1; $i <= 5; $i++)
            <input type="hidden" name="nis{{ $i }}" id="nisInput{{ $i }}">
            <input type="hidden" name="nama_siswa{{ $i }}" id="namaSiswaInput{{ $i }}">
            <input type="hidden" name="kelas{{ $i }}" id="kelasInput{{ $i }}">
        @endfor
        <input type="hidden" name="ticket_count" id="ticketCountInput">
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

            // Dynamic Step System
            const stepsContainer = document.getElementById('stepsContainer');
            const navigationButtons = document.getElementById('navigationButtons');
            const ticketCountSelect = document.getElementById('ticketCount');
            const ticketCountStep = document.getElementById('ticketCountStep');
            const coupleForm = document.getElementById('coupleForm');
            const startRegistration = document.getElementById('startRegistration');
            let ticketCount = 2;
            let currentStep = 0;
            let validatedNIS = [];

            // Only show ticket count selector at first
            coupleForm.classList.add('hidden');
            ticketCountStep.classList.remove('hidden');

            startRegistration.addEventListener('click', function(e) {
                e.preventDefault();
                ticketCount = parseInt(ticketCountSelect.value);
                validatedNIS = Array(ticketCount).fill(null);
                currentStep = 0;
                ticketCountSelect.disabled = true;
                startRegistration.disabled = true;
                ticketCountStep.classList.add('hidden');
                coupleForm.classList.remove('hidden');
                renderSteps();
            });

            function createStep(index) {
                return `
                    <div class="step" data-step="${index}" style="${index !== 0 ? 'display:none;' : ''}">
                        <h3 class="text-white text-xl font-medium mb-4">Informasi Peserta ${index + 1}</h3>
                        <div class="mb-4">
                            <label class="mb-2 block text-sm font-medium text-gray-200">Nomor Induk Siswa (NIS) / Nama</label>
                            <div class="relative">
                                <input type="text" id="nis${index+1}" name="nis${index+1}"
                                    placeholder="Masukkan nama atau NIS peserta"
                                    class="w-full rounded-xl border border-gray-300 px-5 py-3 text-white outline-none transition-all focus:border-red-500 focus:ring-2 focus:ring-red-500"
                                    autocomplete="off" required />
                                <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-200"></i>
                                <div id="searchResults${index+1}"
                                    class="relative z-50 mt-2 hidden max-h-60 w-full overflow-y-auto rounded-xl border border-gray-200 bg-white shadow-lg">
                                </div>
                            </div>
                        </div>
                        <div id="siswaInfo${index+1}"
                            class="flex hidden items-center gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4 transition-all">
                            <i class="fas fa-user text-xl text-red-500"></i>
                            <div>
                                <p class="text-base font-semibold text-gray-800" id="siswaNama${index+1}"></p>
                                <p class="text-sm text-gray-600" id="siswaKelas${index+1}"></p>
                            </div>
                        </div>
                    </div>
                `;
            }

            function renderSteps() {
                stepsContainer.innerHTML = '';
                for (let i = 0; i < ticketCount; i++) {
                    stepsContainer.innerHTML += createStep(i);
                }
                renderNavigation();
                attachStepEvents();
            }

            function renderNavigation() {
                navigationButtons.innerHTML = '';
                if (currentStep > 0) {
                    navigationButtons.innerHTML += `<button type="button" id="backBtn" class="w-1/2 flex items-center justify-center gap-2 rounded-xl bg-gray-600 py-3 font-semibold text-white transition-all hover:bg-gray-700"><i class='fas fa-arrow-left'></i><span>Kembali</span></button>`;
                } else {
                    // Back to ticket count selection from peserta 1
                    navigationButtons.innerHTML += `<button type="button" id="backToTicketCount" class="w-1/2 flex items-center justify-center gap-2 rounded-xl bg-gray-600 py-3 font-semibold text-white transition-all hover:bg-gray-700"><i class='fas fa-arrow-left'></i><span>Kembali</span></button>`;
                }
                if (currentStep < ticketCount - 1) {
                    navigationButtons.innerHTML += `<button type="button" id="nextBtn" class="w-full sm:w-1/2 flex items-center justify-center gap-2 rounded-xl bg-red-500 py-3 font-semibold text-white transition-all hover:bg-red-600 disabled:opacity-50 disabled:bg-gray-500" disabled><span>Lanjutkan ke Peserta ${currentStep+2}</span><i class='fas fa-arrow-right'></i></button>`;
                } else {
                    navigationButtons.innerHTML += `<button type="submit" id="submitButton" class="w-1/2 flex items-center justify-center gap-2 rounded-xl bg-red-500 py-3 font-semibold text-white transition-all hover:bg-red-600 disabled:opacity-50 disabled:bg-gray-500" disabled><span>Lanjutkan</span><i class='fas fa-arrow-right'></i></button>`;
                }
                // Attach navigation events
                if (document.getElementById('backBtn')) {
                    document.getElementById('backBtn').onclick = () => showStep(currentStep - 1);
                }
                if (document.getElementById('backToTicketCount')) {
                    document.getElementById('backToTicketCount').onclick = () => {
                        coupleForm.classList.add('hidden');
                        ticketCountStep.classList.remove('hidden');
                        ticketCountSelect.disabled = false;
                        startRegistration.disabled = false;
                    };
                }
                if (document.getElementById('nextBtn')) {
                    document.getElementById('nextBtn').onclick = () => showStep(currentStep + 1);
                }
            }

            function showStep(step) {
                document.querySelectorAll('.step').forEach((el, idx) => {
                    el.style.display = idx === step ? '' : 'none';
                });
                currentStep = step;
                renderNavigation();
                updateNavButtonState();
            }

            function attachStepEvents() {
                for (let i = 1; i <= ticketCount; i++) {
                    const nisInput = document.getElementById(`nis${i}`);
                    nisInput.addEventListener('input', (e) => {
                        const query = e.target.value;
                        setTimeout(() => performSearch(query, i), 300);
                        validatedNIS[i-1] = null;
                        document.getElementById(`siswaInfo${i}`).classList.add('hidden');
                        updateNavButtonState();
                    });
                }
            }

            // Validation and Search
            async function validateNis(nis, personNumber) {
                // Check for duplicate NIS
                for (let i = 1; i <= ticketCount; i++) {
                    if (i !== personNumber && document.getElementById(`nis${i}`) && document.getElementById(`nis${i}`).value === nis) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Peserta Duplikat',
                            text: 'Anda tidak dapat memilih orang yang sama untuk dua tiket.',
                            confirmButtonColor: '#3b82f6'
                        });
                        return;
                    }
                }
                try {
                    const res = await fetch(`/api/validasi-nis/${nis}`);
                    const data = await res.json();
                    const info = document.getElementById(`siswaInfo${personNumber}`);
                    if (data.valid) {
                        info.classList.remove('hidden');
                        document.getElementById(`siswaNama${personNumber}`).textContent = data.siswa.nama_siswa;
                        document.getElementById(`siswaKelas${personNumber}`).textContent = `Kelas: ${data.siswa.kelas}`;
                        validatedNIS[personNumber-1] = {
                            nis: nis,
                            nama: data.siswa.nama_siswa,
                            kelas: data.siswa.kelas
                        };
                    } else {
                        info.classList.add('hidden');
                        validatedNIS[personNumber-1] = null;
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
                updateNavButtonState();
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

            // Hide search results when clicking outside
            document.addEventListener('click', (e) => {
                for (let i = 1; i <= ticketCount; i++) {
                    const nis = document.getElementById(`nis${i}`);
                    const results = document.getElementById(`searchResults${i}`);
                    if (nis && results && !nis.contains(e.target) && !results.contains(e.target)) {
                        results.classList.add('hidden');
                    }
                }
            });

            function updateNavButtonState() {
                // Enable next/submit only if current step is validated
                const nextBtn = document.getElementById('nextBtn');
                const submitBtn = document.getElementById('submitButton');
                if (validatedNIS[currentStep]) {
                    if (nextBtn) nextBtn.disabled = false;
                    if (submitBtn) submitBtn.disabled = false;
                } else {
                    if (nextBtn) nextBtn.disabled = true;
                    if (submitBtn) submitBtn.disabled = true;
                }
            }

            // Form submission
            document.getElementById('coupleForm').addEventListener('submit', (e) => {
                e.preventDefault();
                // Validate all steps
                for (let i = 0; i < ticketCount; i++) {
                    if (!validatedNIS[i]) {
                        return Swal.fire({
                            icon: 'error',
                            title: 'Data Belum Lengkap',
                            text: 'Silakan pilih semua siswa dari pencarian terlebih dahulu.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                }
                // Check for duplicate NIS
                const nisSet = new Set(validatedNIS.map(x => x.nis));
                if (nisSet.size !== ticketCount) {
                    return Swal.fire({
                        icon: 'error',
                        title: 'Peserta Duplikat',
                        text: 'Tidak boleh ada NIS yang sama.',
                        confirmButtonColor: '#3b82f6'
                    });
                }
                // Transfer values to the hidden form
                for (let i = 0; i < ticketCount; i++) {
                    document.getElementById(`nisInput${i+1}`).value = validatedNIS[i].nis;
                    document.getElementById(`namaSiswaInput${i+1}`).value = validatedNIS[i].nama;
                    document.getElementById(`kelasInput${i+1}`).value = validatedNIS[i].kelas;
                }
                document.getElementById('ticketCountInput').value = ticketCount;
                document.getElementById('paymentForm').submit();
            });

            // Initial render
            renderSteps();
        });
    </script>
</body>

</html>