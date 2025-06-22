<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Petunjuk Pembayaran - Prom Night TB25</title>

    {{-- TAILWIND --}}
    @vite('resources/css/app.css')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            <li class="flex items-center text-gold-500">
                <span
                    class="me-2 flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-gold-500 text-xs">
                    3
                </span>
                Pembayaran
            </li>
        </ol>
    </div>
    {{-- END NAVIGATION --}}

    {{-- CONTENT --}}
    <div class="container mx-auto flex-grow px-4 py-8">
        <div class="mx-auto max-w-3xl">
            <div class="rounded-lg bg-gelap-800 text-white shadow-lg">
                <div class="p-6">
                    <div class="mb-8 text-center">
                        <h1 class="font-fancy-3 text-4xl sm:text-5xl text-white mb-4">Pembayaran Tiket</h1>
                        <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-4 mb-4 inline-block">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-ticket-alt text-red-400"></i>
                                <span class="text-red-400 text-lg">Order ID: <span class="font-mono">{{ $tiket->order_id }}</span></span>
                            </div>
                        </div>
                        <p class="text-gray-300">Silakan lakukan pembayaran sebesar:</p>
                        <p class="text-3xl font-bold text-green-500 mt-2">Rp{{ number_format($tiket->harga, 0, ',', '.') }}</p>
                        <p class="text-gray-300 text-sm mt-1">Transfer ke rekening berikut:</p>
                        
                        <div class="flex flex-col gap-4 mt-4 max-w-md mx-auto">
                            @if ($tiket->metodebayar === 'bca')
                            <div class="bg-blue-900/20 border border-blue-500/30 rounded-lg p-4 text-left">
                                <p class="text-blue-300 font-medium">Bank BCA</p>
                                <p class="text-xl font-bold text-white mt-1">4490327547</p>
                                <p class="text-white">RHEAN DARMA</p>
                            </div>
                            @elseif ($tiket->metodebayar === 'mandiri')
                            <div class="bg-yellow-900/20 border border-yellow-500/30 rounded-lg p-4 text-left">
                                <p class="text-yellow-300 font-medium">Bank Mandiri</p>
                                <p class="text-xl font-bold text-white mt-1">0987654321</p>
                                <p class="text-white">Your Company Name</p>
                            </div>
                            @elseif ($tiket->metodebayar === 'qris')
                            <div class="bg-purple-900/20 border border-purple-500/30 rounded-lg p-4 text-left">
                                <p class="text-purple-300 font-medium">QRIS</p>
                                <div class="flex justify-center my-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" 
                                        alt="QRIS Code" class="h-40 w-40 bg-white p-2 rounded">
                                </div>
                                <p class="text-white">Your Company Name</p>
                            </div>
                            @else
                            <div class="bg-yellow-900/20 border border-yellow-500/30 rounded-lg p-4 text-left">
                                <p class="text-yellow-300 font-medium">Metode pembayaran tidak dikenali</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4">Informasi Ticket</h2>
                        <div class="bg-gray-800 p-4 rounded-lg">
                            <h3 class="font-medium text-red-400">Detail Peserta:</h3>
                            <p>NIS: {{ $tiket->nis }}</p>
                            <p>Nama: {{ $tiket->nama }}</p>
                            <p>Kelas: {{ $tiket->kelas }}</p>
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <form id="uploadForm" enctype="multipart/form-data" class="mb-8">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $tiket->order_id }}">
                        <h2 class="text-xl font-semibold mb-4">Upload Bukti Bayar</h2>
                        <p class="text-gray-300 text-sm mb-4">Setelah melakukan pembayaran, silakan upload bukti pembayaran di bawah ini.</p>
                        
                        <div class="mb-4">
                            <label for="bukti" 
                                class="flex w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-800 px-4 py-6 text-center hover:bg-gray-700">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <span class="text-gray-300">Klik untuk pilih file bukti bayar</span>
                                <span class="text-gray-400 text-xs mt-1">JPG, JPEG, PNG (Max 2MB)</span>
                                <input type="file" id="bukti" name="bukti" class="hidden" accept="image/*" required>
                            </label>
                        </div>
                        
                        <div id="previewContainer" class="hidden mb-4">
                            <p class="text-sm text-gray-300 mb-2">Preview:</p>
                            <div class="relative">
                                <img id="previewImage" class="w-full h-auto rounded-lg" src="" alt="Preview">
                                <span id="filename" class="block mt-2 text-sm text-gray-300"></span>
                            </div>
                        </div>
                        
                        <button type="submit" id="confirmButton"
                            class="w-full bg-gray-400 text-white rounded-lg py-3 px-4 font-semibold cursor-not-allowed">
                            Konfirmasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-footer></x-footer>

    <script>
        const fileInput = document.getElementById('bukti');
        const previewImage = document.getElementById('previewImage');
        const previewContainer = document.getElementById('previewContainer');
        const filenameDisplay = document.getElementById('filename');
        const confirmButton = document.getElementById('confirmButton');
        const form = document.getElementById('uploadForm');
      
        // Ensure the confirm button is disabled initially
        confirmButton.disabled = true;
        confirmButton.classList.add('bg-gray-400', 'cursor-not-allowed');
        confirmButton.classList.remove('bg-green-600', 'hover:bg-green-700');
      
        fileInput.addEventListener('change', function () {
          const file = fileInput.files[0];
          if (file && file.size <= 2 * 1024 * 1024) {
            const reader = new FileReader();
            reader.onload = function (e) {
              previewImage.src = e.target.result;
              previewContainer.classList.remove('hidden');
              confirmButton.disabled = false;
              confirmButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
              confirmButton.classList.add('bg-green-600', 'hover:bg-green-700');
              filenameDisplay.textContent = file.name;
            };
            reader.readAsDataURL(file);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'File terlalu besar',
              text: 'Ukuran maksimum 2MB',
            });
            fileInput.value = '';
            previewContainer.classList.add('hidden');
            confirmButton.disabled = true;
            confirmButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            confirmButton.classList.remove('bg-green-600', 'hover:bg-green-700');
            filenameDisplay.textContent = '';
          }
        });
      
        form.addEventListener('submit', function (e) {
          e.preventDefault();
      
          const formData = new FormData(form);
          confirmButton.disabled = true;
          confirmButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
      
          fetch("/payment/upload", {
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": formData.get('_token')
            },
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: 'Bukti pembayaran berhasil diupload.<br><b>Redirecting...</b>',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
              }).then(() => {
                window.location.href = "/payment/afterpay?order_id=" + data.order_id;
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal upload',
                text: data.message || 'Unknown error',
              });
            }
          })
          .catch(err => {
            console.error(err);
            Swal.fire({
              icon: 'error',
              title: 'Terjadi kesalahan',
              text: 'Gagal mengupload bukti bayar.',
            });
          })
          .finally(() => {
            confirmButton.disabled = false;
            confirmButton.textContent = "Konfirmasi";
          });
        });

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
