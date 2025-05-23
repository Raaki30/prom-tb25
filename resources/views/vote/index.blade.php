<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prom Voting</title>

    {{-- TAILWIND --}}
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ephesis&family=Imperial+Script&family=Lavishly+Yours&family=Tangerine&display=swap"
        rel="stylesheet">

    {{-- AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        .font-fancy-4 {
            font-family: 'Tangerine', cursive;
        }
        .hover-bouncing-dikit:hover {
            animation: bounce 0.5s;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .selected {
            border-color: rgb(234 179 8);
            background-color: rgba(234, 179, 8, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#2e0705] to-[#060604] min-h-full">
    <div class="mx-auto max-w-4xl px-6 py-10 min-h-screen flex flex-col justify-center" x-data="votingApp()" x-init="init()">
        <h1 class="font-fancy-4 my-5 text-pretty text-6xl font-semibold tracking-tight text-yellow-400 sm:text-6xl lg:text-balance text-center" data-aos="fade-down" data-aos-duration="1500">
            Prom Voting Form
        </h1>

        <div>
            <!-- Phone verification step -->
            <div x-show="step === 0" data-aos="fade-up" data-aos-duration="900" class="text-center">
                <label for="phone" class="block mb-4 text-lg font-semibold text-yellow-100 text-center">Masukkan Nomor Telepon Anda</label>
                <input type="tel" x-model="searchQuery" placeholder="08xxxxxxxxxx" required
                    class="mb-4 w-1/2 rounded border-b border-gray-600 bg-[#18181b] px-4 py-2 text-white placeholder-gray-400 text-center" />
                
                <template x-if="selectedUser">
                    <div class="mb-4">
                        <p class="text-yellow-100 text-sm"><strong x-text="selectedUser.nama"></strong> - <span x-text="selectedUser.kelas"></span></p>
                        <p class="text-red-500 text-sm" x-show="selectedUser.status !== 'completed'">❌ Pembayaran anda belum terverifikasi. Mohon menunggu</p>
                        <p class="text-green-600 text-sm" x-show="selectedUser.status === 'completed'">✅ Tiket sudah dibeli.</p>
                    </div>
                </template>

                <template x-if="notFound">
                    <p class="text-red-500 font-medium text-sm">❌ Nomor tidak ditemukan atau kamu sudah melakukan vote</p>
                </template>
                
                <button @click="verifyPhone"
                    :disabled="loading"
                    :class="{ 'opacity-60 cursor-not-allowed': loading }"
                    class="flex items-center justify-center rounded bg-yellow-400 px-8 py-3 text-lg font-bold text-white hover:bg-yellow-600 transition-all duration-200 mx-auto">
                    <svg x-show="loading" class="w-5 h-5 animate-spin text-white mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span x-text="loading ? 'Memeriksa...' : 'Verify'"></span>
                </button>
            </div>

            <!-- Voting steps -->
            <template x-if="step > 0">
                <div>
                    

                    <!-- Current category -->
                    <template x-if="currentCategory">
                        <div data-aos="fade-up" data-aos-duration="900">
                            <h2 class="text-xl font-semibold mb-4 text-center text-yellow-100" x-text="currentCategory.name"></h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <template x-for="(candidate, idx) in currentCategory.candidates" :key="candidate.id">
                                    <div @click="vote(candidate.id)" 
                                        class="hover-bouncing-dikit border border-gray-600 bg-[#18181b] rounded p-2 text-center cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:bg-[#23232a] hover:shadow-md"
                                        :class="{ 'selected ring ring-yellow-500 border-yellow-500': isSelected(candidate.id) }">
                                        <div class="w-full aspect-square mb-2">
                                            <img :src="candidate.photo_url" :alt="candidate.name" class="w-full h-full object-cover rounded" />
                                        </div>
                                        <p class="font-medium text-white" x-text="candidate.name"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                    <!-- Progress Bar -->
                    <div class="w-full mt-8 mb-6">
                        <div class="w-full bg-gray-700 rounded-full h-3">
                            <div class="bg-yellow-400 h-3 rounded-full transition-all duration-500"
                                 :style="`width: ${(step / categories.length) * 100}%`"></div>
                        </div>
                        <div class="text-center text-yellow-100 text-xs mt-1">
                            <span x-text="step"></span> / <span x-text="categories.length"></span>
                        </div>
                    </div>
                    <!-- Navigation buttons -->
                    <div class="mt-8 flex justify-center gap-6">
                        <button type="button" @click="prevStep"
                            class="flex items-center justify-center rounded-full bg-gray-700 w-12 h-12 text-2xl text-gray-100 hover:bg-gray-600 transition-all duration-200 mx-2"
                            x-show="step > 1">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <template x-if="step < categories.length">
                            <button type="button" @click="nextStep"
                                class="flex items-center justify-center rounded-full bg-yellow-400 w-12 h-12 text-2xl text-white hover:bg-yellow-600 transition-all duration-200 mx-2" 
                                :disabled="!isSelected(currentCategory && currentCategory.candidates.find(c => votes[currentCategory.id] === c.id)?.id)">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </template>
                        <template x-if="step === categories.length">
                            <button type="button" @click="submitVotes"
                                :disabled="submitting"
                                class="flex items-center justify-center rounded-full bg-yellow-400 w-12 h-12 text-2xl text-white hover:bg-yellow-600 transition-all duration-200 mx-2">
                                <svg x-show="submitting" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <i x-show="!submitting" class="fas fa-check"></i>
                            </button>
                        </template>
                    </div>
                    
                    <!-- Success/Error Messages -->
                    <div class="mt-4 text-center">
                        <template x-if="successMessage">
                            <p class="text-green-600 font-medium text-sm" x-text="successMessage"></p>
                        </template>
                        <template x-if="errorMessage">
                            <p class="text-red-500 font-medium text-sm" x-text="errorMessage"></p>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        function votingApp() {
            return {
                step: 0,
                categories: [],
                votes: {},
                searchQuery: '',
                selectedUser: null,
                nis: '',
                notFound: false,
                loading: false,
                submitting: false,
                successMessage: '',
                errorMessage: '',

                async init() {
                    try {
                        const res = await fetch('/api/get-candidates');
                        this.categories = await res.json();
                        
                        // Initialize AOS
                        if (window.AOS) {
                            AOS.init({
                                once: true,
                                duration: 900,
                                easing: 'ease-in-out',
                            });
                        }
                    } catch (error) {
                        this.errorMessage = "❌ Gagal mengambil data kandidat.";
                    }
                },

                get currentCategory() {
                    if (this.step === 0 || this.step > this.categories.length) return null;
                    return this.categories[this.step - 1];
                },

                vote(candidateId) {
                    if (!this.currentCategory) return;
                    this.votes[this.currentCategory.id] = candidateId;
                    // Auto-advance to next step if not last category
                    if (this.step < this.categories.length) {
                        setTimeout(() => { this.nextStep(); }, 200);
                    }
                },

                isSelected(candidateId) {
                    if (!this.currentCategory) return false;
                    return this.votes[this.currentCategory.id] === candidateId;
                },

                nextStep() {
                    if (!this.currentCategory || !this.votes[this.currentCategory.id]) return;
                    this.step++;
                    if (window.AOS) AOS.refresh();
                },

                prevStep() {
                    if (this.step > 1) {
                        this.step--;
                        if (window.AOS) AOS.refresh();
                    }
                },

                async verifyPhone() {
                    if (!this.searchQuery.trim()) return;
                    
                    this.loading = true;
                    this.notFound = false;
                    this.selectedUser = null;

                    try {
                        const res = await fetch(`/api/verif-beli?query=${encodeURIComponent(this.searchQuery)}`);
                        const data = await res.json();
                        if (data && data.nis) {
                            this.selectedUser = data;
                            this.nis = data.nis;
                            
                            if (data.status === 'completed') {
                                this.step = 1; // Move to first category
                                if (window.AOS) AOS.refresh();
                            }
                        } else {
                            this.notFound = true;
                        }
                    } catch (err) {
                        this.errorMessage = "❌ Terjadi kesalahan saat verifikasi.";
                    } finally {
                        this.loading = false;
                    }
                },

                submitVotes() {
                    if (Object.keys(this.votes).length !== this.categories.length) return;
                    
                    this.submitting = true;
                    this.successMessage = '';
                    this.errorMessage = '';

                    const response = {
                        nis: this.nis,
                        vote: Object.entries(this.votes).map(([category_id, nominee_id]) => ({
                            category_id,
                            nominee_id
                        }))
                    };

                    fetch('/submit-vote', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        },
                        body: JSON.stringify(response)
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.submitting = false;
                        if (data.success) {
                            this.successMessage = "✅ Vote berhasil dikirim. Terima kasih! Redirecting you back...";
                            this.submitting = true;
                            setTimeout(() => window.location.href = '/', 2000);
                        } else {
                            this.errorMessage = data.message || "❌ Gagal mengirim vote.";
                        }
                    })
                    .catch(() => {
                        this.submitting = false;
                        this.errorMessage = "❌ Terjadi kesalahan saat mengirim vote.";
                    });
                }
            };
        }
    </script>
</body>
</html>
