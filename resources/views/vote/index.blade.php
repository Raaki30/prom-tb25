<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Prom Awards Voting</title>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .animate-fade-in {
      animation: fadeIn 0.6s ease-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="bg-gradient-to-br from-pink-100 to-blue-100 min-h-screen flex items-center justify-center px-4 py-8 font-sans">
  <div x-data="votingForm()" x-init="init()" class="w-full max-w-3xl bg-white shadow-2xl rounded-3xl p-8 transition-all duration-500 relative">
    
    <!-- Welcome Screen -->
    <template x-if="!started">
      <div class="text-center animate-fade-in">
        <h1 class="text-4xl font-extrabold text-pink-600 tracking-tight mb-4">🎀 Welcome to Prom Awards Voting 🎀</h1>
        <p class="text-gray-700 text-base mb-6">Please verify your phone number first👇</p>

        <div class="mb-4 flex gap-2 justify-center">
          <input type="tel" x-model="searchQuery"
                 placeholder="Masukkan Nomor Telepon Anda"
                 pattern="[0-9]*" inputmode="numeric"
                 class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400"/>
          <button @click="verifyPhone"
                  :disabled="loading"
                  :class="{ 'opacity-60 cursor-not-allowed': loading }"
                  class="bg-pink-500 text-white px-4 py-2 rounded-xl hover:bg-pink-600 transition flex items-center gap-2">
            <svg x-show="loading" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span x-text="loading ? 'Memeriksa...' : 'Verifikasi'"></span>
          </button>
        </div>

        <template x-if="selectedUser">
          <div class="mb-4">
            <p class="text-gray-600 text-sm"><strong x-text="selectedUser.nama"></strong> - <span x-text="selectedUser.kelas"></span></p>
            <p class="text-red-500 text-sm" x-show="selectedUser.status !== 'completed'">❌ Anda belum membeli tiket.</p>
            <p class="text-green-600 text-sm" x-show="selectedUser.status === 'completed'">✅ Tiket sudah dibeli.</p>
          </div>
        </template>

        <template x-if="notFound">
          <p class="text-red-500 font-medium text-sm">❌ Nomor tidak ditemukan atau kamu sudah melakukan vote</p>
        </template>

        <button 
          :disabled="!selectedUser || selectedUser.status !== 'completed'"
          @click="startVoting"
          :class="[ 'px-6 py-3 rounded-full font-semibold shadow-md transition-all transform',
            (!selectedUser || selectedUser.status !== 'completed') 
              ? 'bg-gray-300 text-gray-400 cursor-not-allowed opacity-60' 
              : 'bg-pink-500 hover:bg-pink-600 text-white hover:scale-105'
          ]">
          Start Voting 💖
        </button>
      </div>
    </template>

    <!-- Voting UI -->
    <div x-show="started" x-transition x-cloak>
      <div class="mb-6 text-center animate-fade-in">
        <h1 class="text-3xl font-extrabold text-pink-600 tracking-tight">🌟 PROM AWARDS VOTING 🌟</h1>
        <p class="text-sm text-gray-600 mt-1">Step <span x-text="step + 1"></span> of <span x-text="categories.length"></span></p>
      </div>

      <div x-transition x-show="currentCategory" class="animate-fade-in">
        <h2 class="text-2xl font-bold text-center mb-6 text-pink-500" x-text="currentCategory.name"></h2>
        <div class="flex flex-wrap justify-center gap-6">
          <template x-for="candidate in currentCategory.candidates" :key="candidate.id">
            <button
              @click="vote(candidate.id)"
              :class="{ 'ring-4 ring-pink-400': isSelected(candidate.id) }"
              class="group w-48 flex flex-col items-center bg-gradient-to-br from-pink-50 to-blue-50 border-2 border-white hover:border-pink-400 rounded-2xl p-4 shadow-lg transition-transform transform hover:scale-105">
              <div class="overflow-hidden rounded-xl border border-pink-200 shadow-sm w-full h-48">
                <img :src="candidate.photo_url" alt="candidate photo"
                  class="w-full h-full object-cover rounded-xl transition-all duration-500 group-hover:scale-110" />
              </div>
              <p class="mt-4 text-lg font-bold text-center text-purple-700" x-text="candidate.name"></p>
            </button>
          </template>
        </div>
      </div>

      <div class="mt-10 text-center">
        <div class="flex justify-center">
          <button x-show="isFinished"
            @click="submitVotes"
            :disabled="submitting"
            :class="{ 'opacity-60 cursor-not-allowed': submitting }"
            class="bg-gradient-to-r from-pink-500 to-indigo-500 hover:from-pink-600 hover:to-indigo-600 text-white py-3 px-8 rounded-full text-lg font-semibold shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-2">
            <svg x-show="submitting" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span x-text="submitting ? 'Mengirim...' : '🎉 Submit Your Votes 🎉'"></span>
          </button>
        </div>

        <div class="mt-4 text-center">
          <template x-if="successMessage">
            <p class="text-green-600 font-medium text-sm" x-text="successMessage"></p>
          </template>
          <template x-if="errorMessage">
            <p class="text-red-500 font-medium text-sm" x-text="errorMessage"></p>
          </template>
        </div>
      </div>
    </div>
  </div>

  <script>
    function votingForm() {
      return {
        started: false,
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
          } catch (error) {
            this.errorMessage = "❌ Gagal mengambil data kandidat.";
          }
        },

        get currentCategory() {
          return this.categories[this.step];
        },

        vote(candidateId) {
          this.votes[this.currentCategory.id] = candidateId;
          if (this.step < this.categories.length - 1) {
            this.step++;
          }
        },

        isSelected(candidateId) {
          return this.votes[this.currentCategory.id] === candidateId;
        },

        get isFinished() {
          return Object.keys(this.votes).length === this.categories.length;
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
            } else {
              this.notFound = true;
            }
          } catch (err) {
            this.errorMessage = "❌ Terjadi kesalahan saat verifikasi.";
          } finally {
            this.loading = false;
          }
        },

        startVoting() {
          if (this.selectedUser && this.selectedUser.status === 'completed') {
            this.started = true;
          }
        },

        submitVotes() {
          if (!this.isFinished) return;

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
              setTimeout(() => window.location.href = '/vote', 2000);
            } else {
              this.errorMessage = data.message || "❌ Gagal mengirim vote.";
            }
          })
          .catch(() => {
            this.submitting = false;
            this.errorMessage = "❌ Terjadi kesalahan saat mengirim vote.";
          });
        }
      }
    }
  </script>
</body>
</html>
