<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prom Voting</title>

    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap" rel="stylesheet">

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
<body class="bg-gradient-to-br from-[#2e0705] to-[#060604] min-h-screen text-white" style="background-image: url('{{ asset('images/bg-vote.png') }}'); background-size: cover; background-repeat: no-repeat;">

<div class="max-w-4xl mx-auto px-4 py-10" x-data="votingApp()" x-init="init()">
    <div class="bg-[#18181b] border border-gray-700 rounded-2xl shadow-2xl p-6 sm:p-10">
        <h1 class="text-center text-yellow-400 font-fancy-4 text-5xl sm:text-6xl mb-10" data-aos="fade-down">
            Prom Voting Form
        </h1>

        <!-- Step 0: Phone Input -->
        <div x-show="step === 0" class="flex justify-center items-center min-h-[400px]" data-aos="fade-up">
            <div class="w-full max-w-md bg-[#18181b] border border-gray-700 rounded-xl shadow-lg p-8 text-center">
                <div class="mb-6">
                    <i class="fas fa-user-lock text-yellow-400 text-4xl mb-2"></i>
                    <h2 class="text-2xl font-bold text-yellow-100 mb-1">Mulai Voting</h2>
                    <p class="text-gray-400 text-sm">Masukkan nomor telepon untuk mulai voting</p>
                </div>
                <label class="block mb-2 text-lg font-semibold text-yellow-100">Nomor Telepon</label>
                <input type="tel" x-model="searchQuery" placeholder="08xxxxxxxxxx" required
                    class="w-full text-center px-4 py-2 rounded bg-gray-800 border border-gray-600 placeholder-gray-400 mb-4 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition" />

                <template x-if="selectedUser">
                    <div>
                        <p class="text-yellow-100 text-sm"><strong x-text="selectedUser.nama"></strong> - <span x-text="selectedUser.kelas"></span></p>
                        <p class="text-red-500 text-sm" x-show="selectedUser.status !== 'completed'">❌ Belum terverifikasi</p>
                        <p class="text-green-500 text-sm" x-show="selectedUser.status === 'completed'">✅ Tiket valid</p>
                    </div>
                </template>

                <template x-if="notFound">
                    <p class="text-red-500 font-medium text-sm">❌ Nomor tidak ditemukan atau sudah vote</p>
                </template>

                <button @click="verifyPhone" :disabled="loading"
                    class="mt-4 bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-6 rounded transition w-full flex items-center justify-center"
                    :class="{ 'opacity-60 cursor-not-allowed': loading }">
                    <svg x-show="loading" class="w-5 h-5 animate-spin inline-block mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>
                    <span x-text="loading ? 'Memeriksa...' : 'Verifikasi'"></span>
                </button>
            </div>
        </div>

        <!-- Voting Steps -->
        <div x-show="step > 0" x-transition>
            <template x-if="currentCategory">
                <div class="mt-10" data-aos="fade-up">
                    <h2 class="text-xl font-semibold mb-6 text-center text-yellow-100" x-text="currentCategory.name"></h2>
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <template x-for="candidate in currentCategory.candidates" :key="candidate.id">
                            <div @click="vote(candidate.id)"
                                class="hover-bouncing-dikit cursor-pointer border border-gray-600 rounded-lg p-2 bg-[#18181b] hover:bg-[#23232a] hover:shadow"
                                :class="{ 'selected ring-2 ring-yellow-500': isSelected(candidate.id) }">
                                <div class="aspect-square w-full overflow-hidden rounded mb-2">
                                    <img :src="candidate.photo_url" :alt="candidate.name" class="w-full h-full object-cover" />
                                </div>
                                <p class="text-center font-medium" x-text="candidate.name"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Progress Bar -->
            <div class="mt-8">
                <div class="w-full bg-gray-700 rounded-full h-3">
                    <div class="bg-yellow-400 h-3 rounded-full transition-all duration-500"
                         :style="`width: ${(step / categories.length) * 100}%`"></div>
                </div>
                <div class="text-center mt-2 text-sm text-yellow-100">
                    <span x-text="step"></span> / <span x-text="categories.length"></span>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-6 flex justify-center space-x-4">
                <button x-show="step > 1" @click="prevStep"
                    class="bg-gray-700 hover:bg-gray-600 w-12 h-12 rounded-full flex items-center justify-center text-xl">
                    <i class="fas fa-arrow-left"></i>
                </button>

                <template x-if="step < categories.length">
                    <button @click="nextStep" :disabled="!isSelected(currentCategory?.candidates.find(c => votes[currentCategory.id] === c.id)?.id)"
                        class="bg-yellow-400 hover:bg-yellow-500 w-12 h-12 rounded-full flex items-center justify-center text-xl text-white">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </template>

                <template x-if="step === categories.length">
                    <button @click="submitVotes" :disabled="submitting"
                        class="bg-green-500 hover:bg-green-600 w-12 h-12 rounded-full flex items-center justify-center text-xl text-white">
                        <svg x-show="submitting" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                        </svg>
                        <i x-show="!submitting" class="fas fa-check"></i>
                    </button>
                </template>
            </div>

            <!-- Messages -->
            <div class="mt-4 text-center">
                <template x-if="successMessage">
                    <p class="text-green-500" x-text="successMessage"></p>
                </template>
                <template x-if="errorMessage">
                    <p class="text-red-500" x-text="errorMessage"></p>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
    AOS.init();

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
                    AOS.refresh();
                } catch {
                    this.errorMessage = 'Gagal mengambil data kandidat.';
                }
            },

            get currentCategory() {
                if (this.step === 0 || this.step > this.categories.length) return null;
                return this.categories[this.step - 1];
            },

            vote(candidateId) {
                if (!this.currentCategory) return;
                this.votes[this.currentCategory.id] = candidateId;
                if (this.step < this.categories.length) {
                    setTimeout(() => this.nextStep(), 200);
                }
            },

            isSelected(candidateId) {
                return this.votes[this.currentCategory?.id] === candidateId;
            },

            nextStep() {
                if (!this.currentCategory || !this.votes[this.currentCategory.id]) return;
                this.step++;
                AOS.refresh();
            },

            prevStep() {
                if (this.step > 1) {
                    this.step--;
                    AOS.refresh();
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
                        if (data.status === 'completed') this.step = 1;
                        AOS.refresh();
                    } else {
                        this.notFound = true;
                    }
                } catch {
                    this.errorMessage = 'Terjadi kesalahan saat verifikasi.';
                } finally {
                    this.loading = false;
                }
            },

            async submitVotes() {
                if (Object.keys(this.votes).length !== this.categories.length) return;

                this.submitting = true;
                const payload = {
                    nis: this.nis,
                    vote: Object.entries(this.votes).map(([category_id, nominee_id]) => ({ category_id, nominee_id }))
                };

                try {
                    const res = await fetch('/submit-vote', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    });
                    const result = await res.json();
                    if (result.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Berhasil!',
                                                html: 'Vote berhasil dikirim.<br><b>Redirecting...</b>',
                                                timer: 2000,
                                                timerProgressBar: true,
                                                showConfirmButton: false,
                                            }).then(() => {
                                                window.location.href = '/';
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Gagal submit vote',
                                                text: result.message || 'Gagal submit vote.'
                                            });
                                        }
                } catch {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Terjadi kesalahan saat mengirim vote.'
                    });
                } finally {
                    this.submitting = false;
                }
            }
        }
    }
</script>

</body>
</html>