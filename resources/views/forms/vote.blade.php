<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Prom Awards Voting</title>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>


<body class="bg-gradient-to-br from-pink-100 to-blue-100 min-h-screen flex items-center justify-center px-4 py-8">

  <div x-data="votingForm()" class="w-full max-w-2xl bg-white shadow-xl rounded-3xl p-6 overflow-hidden relative transition-all duration-500">
    
    <!-- Heading -->
    <div class="mb-6 text-center animate-fade-in">
      <h1 class="text-3xl font-bold text-gray-800 tracking-tight">🎓 PROM AWARDS VOTING</h1>
      <p class="text-sm text-gray-500 mt-1">Pilih satu kandidat untuk setiap kategori</p>
    </div>

    <!-- Step indicator -->
    <div class="text-center mb-4 text-gray-600 animate-fade-in">
      <span>Step <span x-text="step + 1"></span> of <span x-text="categories.length"></span></span>
    </div>

    <!-- Voting Category Section -->
    <div x-transition:enter="transition ease-out duration-500" 
         x-transition:enter-start="opacity-0 scale-95" 
         x-transition:enter-end="opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-300" 
         x-transition:leave-start="opacity-100 scale-100" 
         x-transition:leave-end="opacity-0 scale-95" 
         x-show="currentCategory" class="animate-fade-in">
      
      <h2 class="text-xl font-semibold text-center mb-4 text-blue-700" x-text="currentCategory.name"></h2>
      
      <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <template x-for="candidate in currentCategory.candidates" :key="candidate.id">
          <button @click="vote(candidate.id)"
            class="group rounded-xl border hover:border-blue-500 p-2 transition-all transform hover:scale-105 hover:shadow-lg"
            :class="{'ring-2 ring-blue-500': isSelected(candidate.id)}">
            <div class="overflow-hidden rounded-lg">
              <img :src="candidate.photo_url" alt=""
                class="w-full h-36 object-cover rounded-lg transition-all duration-300 group-hover:scale-110">
            </div>
            <p class="text-sm font-medium text-center text-gray-700 mt-2" x-text="candidate.name"></p>
          </button>
        </template>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="mt-8 text-center">
      <button x-show="isFinished"
        @click="submitVotes"
        class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white py-2 px-6 rounded-full text-sm font-semibold shadow-lg transition-all transform hover:scale-105 animate-bounce">
        Submit Vote 🚀
      </button>
    </div>
  </div>

  <script>
    function votingForm() {
      return {
        step: 0,
        categories: [
          {
            id: 1,
            name: 'Best Dressed',
            candidates: [
              { id: 101, name: 'Alya Rahma', photo_url: 'https://via.placeholder.com/200x200?text=Alya' },
              { id: 102, name: 'Dimas Prasetyo', photo_url: 'https://via.placeholder.com/200x200?text=Dimas' },
              { id: 103, name: 'Nina M.', photo_url: 'https://via.placeholder.com/200x200?text=Nina' },
            ]
          },
          {
            id: 2,
            name: 'Most Charming',
            candidates: [
              { id: 201, name: 'Faris Ramadhan', photo_url: 'https://via.placeholder.com/200x200?text=Faris' },
              { id: 202, name: 'Putri Ayu', photo_url: 'https://via.placeholder.com/200x200?text=Putri' },
              { id: 203, name: 'Raka Syahputra', photo_url: 'https://via.placeholder.com/200x200?text=Raka' },
            ]
          },
          {
            id: 3,
            name: 'Prom King',
            candidates: [
              { id: 301, name: 'Adit S.', photo_url: 'https://via.placeholder.com/200x200?text=Adit' },
              { id: 302, name: 'Kevin L.', photo_url: 'https://via.placeholder.com/200x200?text=Kevin' },
              { id: 303, name: 'Dito H.', photo_url: 'https://via.placeholder.com/200x200?text=Dito' },
            ]
          }
        ],
        votes: {},
        get currentCategory() {
          return this.categories[this.step];
        },
        vote(candidateId) {
          this.votes[this.currentCategory.id] = candidateId;
          setTimeout(() => {
            if (this.step < this.categories.length - 1) {
              this.step++;
            }
          }, 300);
        },
        isSelected(candidateId) {
          return this.votes[this.currentCategory.id] === candidateId;
        },
        get isFinished() {
          return Object.keys(this.votes).length === this.categories.length;
        },
        submitVotes() {
          alert('🎉 Terima kasih! Voting kamu berhasil dikirim.');
          window.location.href = "/";
        }
      }
    }

    const popupNisInput = document.getElementById('popupNis');
    const popupSubmitBtn = document.getElementById('popupSubmitBtn');
    const popupResults = document.getElementById('popupSearchResults');
    const popupModal = document.getElementById('verifikasiModal');

    popupNisInput.addEventListener('input', (e) => {
        const query = e.target.value;
        popupSubmitBtn.disabled = true;
        document.getElementById('popupSiswaInfo').classList.add('hidden');
        setTimeout(() => searchPopup(query), 300);
    });

    async function searchPopup(query) {
        if (query.length < 3) return popupResults.classList.add('hidden');

        try {
            const res = await fetch(`/api/cari-nama?query=${encodeURIComponent(query)}`);
            const data = await res.json();

            popupResults.innerHTML = '';

            if (!data.length) {
                popupResults.innerHTML = `<div class="p-4 text-center text-gray-500">
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
                        <div class="text-gray-500 text-sm">${siswa.kelas}</div>`;
                    item.onclick = () => {
                        popupNisInput.value = siswa.nis;
                        popupResults.classList.add('hidden');
                        validatePopupNis(siswa.nis);
                    };
                    popupResults.appendChild(item);
                });
            }

            popupResults.classList.remove('hidden');
        } catch (err) {
            console.error('Search error:', err);
        }
    }

    async function validatePopupNis(nis) {
        try {
            const res = await fetch(`/api/validasi-nis/${nis}`);
            const data = await res.json();

            if (data.valid) {
                document.getElementById('popupSiswaNama').textContent = data.siswa.nama_siswa;
                document.getElementById('popupSiswaKelas').textContent = `Kelas: ${data.siswa.kelas}`;
                document.getElementById('popupSiswaInfo').classList.remove('hidden');
                popupSubmitBtn.disabled = false;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Anda Sudah Membeli',
                    text: 'Tiket hanya bisa dibeli sekali.',
                    confirmButtonColor: '#3b82f6'
                });
                popupSubmitBtn.disabled = true;
                document.getElementById('popupSiswaInfo').classList.add('hidden');
            }
        } catch {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan.',
                confirmButtonColor: '#3b82f6'
            });
        }
    }

    document.getElementById('popupNisForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const nis = popupNisInput.value;
        const nama = document.getElementById('popupSiswaNama').textContent;
        const kelas = document.getElementById('popupSiswaKelas').textContent.replace('Kelas: ', '');

        // Set form utama
        document.getElementById('nis').value = nis;
        document.getElementById('nisInput').value = nis;
        document.getElementById('namaSiswaInput').value = nama;
        document.getElementById('kelasInput').value = kelas;
        document.getElementById('siswaNama').textContent = nama;
        document.getElementById('siswaKelas').textContent = `Kelas: ${kelas}`;
        document.getElementById('siswaInfo').classList.remove('hidden');
        document.getElementById('submitButton').disabled = false;

        // Close popup modal
        popupModal.classList.add('hidden');
    });

    // Disable close by outside click
    window.addEventListener('click', function (e) {
        if (e.target === popupModal) {
            e.stopPropagation(); // Blok klik di luar modal
        }
    });
  </script>

  <style>
    .animate-fade-in {
      animation: fadeIn 0.6s ease-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</body>

<!-- MODAL VERIFIKASI NIS -->
<div id="verifikasiModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
    <div class="bg-gelap-800 w-full max-w-md rounded-xl p-6 shadow-lg">
        <h2 class="font-fancy-3 text-center text-4xl text-white mb-6">Verifikasi Tiket</h2>
        <form id="popupNisForm" class="space-y-4">
            <label class="block text-white text-sm">Masukkan NIS atau Nama:</label>
            <div class="relative">
                <input type="text" id="popupNis" placeholder="NIS atau nama kamu"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-white bg-gray-700 focus:border-red-500 focus:ring-2 focus:ring-red-500" />
                <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-white"></i>
                <div id="popupSearchResults"
                    class="absolute z-50 mt-2 hidden max-h-60 w-full overflow-y-auto rounded-xl border border-gray-200 bg-white shadow-lg">
                </div>
            </div>
            <div id="popupSiswaInfo"
                class="hidden mt-3 flex items-center gap-4 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <i class="fas fa-user text-xl text-red-500"></i>
                <div>
                    <p class="text-base font-semibold text-gray-800" id="popupSiswaNama"></p>
                    <p class="text-sm text-gray-600" id="popupSiswaKelas"></p>
                </div>
            </div>
            <button type="submit"
                class="w-full rounded-lg bg-red-500 py-2 text-white font-semibold hover:bg-red-600 transition"
                id="popupSubmitBtn" disabled>Masuk</button>
        </form>
    </div>
</div>


</html>
