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
</head>

<body class="gradient-bg-dark">

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
                        <h3 class="mb-4 text-5xl font-semibold font-fancy-3">Petunjuk Pembayaran</h3>
                        <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                            {{-- BACKEND STUFF --}}
                            <h5 class="text-lg font-medium text-blue-800">Order ID: {{ $tiket->order_id }}</h5>
                            <p class="text-blue-700">Total Harga: Rp {{ number_format($tiket->harga, 0, ',', '.') }}</p>
                            
                        </div>
                    </div>

                    <div class="mb-8">
                        <h5 class="mb-4 text-lg font-medium">Silakan ikuti langkah-langkah berikut:</h5>
                        <ol class="list-decimal space-y-4 pl-5">
                            <li>Transfer ke nomor rekening di bawah ini:</li>
                            
                               
                            <li>
                                @if ($tiket->metodebayar === 'bca') 
                                <div class="rounded-lg border border-gray-600 bg-gray-600 w-fit p-4 my-5">
                                    <h6 class="mb-2 font-medium">Bank BCA Virtual Account:</h6>
                                    <p>Bank: BCA</p>
                                    <p>Nomor Rekening: 1234567890</p>
                                    <p class="mb-4">Atas Nama: Your Company Name</p>
                                </div>
                                @elseif($tiket->metodebayar === 'mandiri')
                                <div class="rounded-lg border border-gray-600 bg-gray-600 w-fit p-4 my-5">
                                    <h6 class="mb-2 font-medium">Bank Mandiri Virtual Account:</h6>
                                    <p>Bank: Mandiri</p>
                                    <p>Nomor Rekening: 0987654321</p>
                                    <p class="mb-4">Atas Nama: Your Company Name</p>
                                </div>
                                @elseif($tiket->metodebayar === 'qris')
                                <div class="rounded-lg border border-gray-600 bg-gray-600 w-fit p-4 my-5">
                                    <h6 class="mb-2 font-medium">QRIS:</h6>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="">
                                    <p class="mb-4">Atas Nama: Your Company Name</p>
                                </div>
                                @else
                                <div class="font-semibold text-yellow-600">
                                    Metode pembayaran tidak dikenali.
                                </div>
                                @endif
                            </li>
                            <li>Simpan bukti pembayaran Anda.</li>
                            <li>Upload bukti pembayaran di bawah ini.</li>
                        </ol>
                    </div>

                    <!-- Upload Form -->
                    <form id="uploadForm" enctype="multipart/form-data" class="mb-8">
                        {{-- BACKEND STUFF --}}
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $tiket->order_id }}">
                        <div class="mb-4 ">
                            <label class="mb-2 block text-sm font-medium text-white">Upload Bukti Bayar</label>
                            <div class="flex w-full items-center justify-center">
                                <label for="bukti"
                                    class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-500 bg-gelap-800 hover:bg-gelap-800">
                                    <div class="flex flex-col items-center justify-center pb-6 pt-5 ">
                                        <i class="fas fa-cloud-upload-alt mb-2 text-3xl text-gray-200"></i>
                                        <p class="text-sm text-gray-50">Click to upload</p>
                                        <p class="text-xs text-gray-50">JPG, JPEG, PNG (Max: 2MB)</p>
                                        <span id="filename" class="mt-2 text-sm text-gray-600"></span>
                                    </div>
                                    <input id="bukti" name="bukti" type="file" class="hidden" accept="image/*"
                                        required>
                                </label>
                            </div>
                        </div>

                        <div id="previewContainer" class="mb-4 hidden">
                            <img id="previewImage" class="mx-auto mb-2 h-40 object-contain" />
                        </div>

                        <div class="text-center">
                            <button id="confirmButton" type="submit"
                            class="w-full sm:w-1/4 rounded-md bg-green-600 px-4 py-2 text-white transition hover:bg-green-700">
                            Konfirmasi
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>


    <x-whatsapp></x-whatsapp>
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
      </script>
</body>

</html>
