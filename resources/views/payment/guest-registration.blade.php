@php
    use App\Models\Control;
    $harga = Control::where('jenis_tiket', 'general')->value('harga');
    $biaya_lain = Control::where('jenis_tiket', 'general')->value('biaya_lain');
    $grand_total = $harga + $biaya_lain;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Guest Registration - Prom Night TB25</title> 

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
</head>
<body class="bg-gray-50 text-gray-800 font-serif">
    <div id="container" class="flex items-center justify-center min-h-screen">
        <div class="max-w-3xl mx-auto p-8 bg-white shadow-lg rounded-lg border border-gray-200">
            <h1 class="text-3xl font-bold text-center text-gray-800 border-b pb-4 mb-8" style="font-family: 'Imperial Script', cursive; color: #b8860b;">
                Guest Registration
            </h1>

            <form id="guestForm" action="/tamu-beli" enctype="multipart/form-data" class="mt-6">
                @csrf
                <!-- Input Partner Search -->
                <label class="block font-semibold mb-2 text-gray-700">Cari Partner Kamu</label>
                <input type="text" id="partner" name="partner" placeholder="Masukkan nama partner kamu" class="w-full rounded-lg border border-gray-300 px-5 py-3 text-black outline-none transition-all focus:border-gold-500 focus:ring-2 focus:ring-gold-500" autocomplete="off" required />
                <p class="text-sm text-gray-500 mt-1">Pastikan dia sudah membeli tiket terlebih dahulu</p>
                <div id="searchResults" class="hidden border mt-2 bg-white rounded-md shadow-md overflow-hidden"></div>

                <div id="formutama" class="hidden">
                    <!-- Nama -->
                    <label class="block font-semibold mt-4 mb-2 text-gray-700">Nama</label>
                    <input type="text" name="nama" placeholder="Nama Kamu" class="w-full rounded-lg border border-gray-300 px-5 py-3 outline-none focus:border-gold-500 focus:ring-2 focus:ring-gold-500" required>

                    <!-- No Telepon -->
                    <label class="block font-semibold mt-4 mb-2 text-gray-700">No Telepon</label>
                    <input type="text" name="phone" placeholder="08123456xxx" class="w-full rounded-lg border border-gray-300 px-5 py-3 outline-none focus:border-gold-500 focus:ring-2 focus:ring-gold-500" required>

                    <!-- Email -->
                    <label class="block font-semibold mt-4 mb-2 text-gray-700">Email</label>
                    <input type="email" name="email" placeholder="example@example.com" class="w-full rounded-lg border border-gray-300 px-5 py-3 outline-none focus:border-gold-500 focus:ring-2 focus:ring-gold-500" required>

                    <!-- Metode Bayar -->
                    <input type="hidden" name="metodebayar" value="transfer">
                    <div class="mt-6 p-6 bg-gray-100 border rounded-lg flex justify-between items-center">
                        <div class="text-lg">
                            <p class="mb-2">Student Ticket:</p>
                            <p class="mb-2">Biaya Lain:</p>
                            <hr class="my-2 border-gold-500">
                            <p class="font-bold">Total Price:</p>
                        </div>
                        <div class="text-right text-lg font-medium">
                            <p class="mb-2">1 x Rp{{ number_format($harga, 0, ',', '.') }}</p>
                            <p class="mb-2">Rp{{ number_format($biaya_lain, 0, ',', '.') }}</p>
                            <hr class="my-2 border-gold-500">
                            <p class="text-lg font-bold text-gold-500">Rp{{ number_format($grand_total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <input type="hidden" name="harga" value="{{ $grand_total }}">

                    <!-- Nominal & Instruksi -->
                    <div class="mt-6 p-6 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                        <p class="font-semibold text-gray-800"><strong>Instruksi Pembayaran:</strong></p>
                        <p class="text-gray-700">Silakan transfer sebesar nominal di atas ke rekening berikut:</p>
                        <ul class="mt-2 text-sm text-gray-700">
                            <div class="rounded-lg border border-gray-600 bg-gray-600 w-fit p-4 my-5">
                                <h6 class="mb-2 font-medium">Transfer Bank BCA :</h6>
                                <p>Bank: BCA</p>
                                <p>Nomor Rekening: 4490327547</p>
                                <p class="mb-4">Atas Nama: RHEAN DARMA</p>
                            </div>
                        </ul>
                    </div>

                    <!-- Bukti Bayar -->
                    <label class="block font-semibold mt-6 mb-2 text-gray-700">Upload Bukti Pembayaran</label>
                    <div class="mb-4">
                        <div class="flex w-full items-center justify-center">
                            <label for="bukti" class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-400 bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                    <i class="fas fa-cloud-upload-alt mb-2 text-3xl text-gray-600"></i>
                                    <p class="text-sm text-gray-700">Click to upload</p>
                                    <p class="text-xs text-gray-500">JPG, JPEG, PNG (Max: 2MB)</p>
                                    <span id="filename" class="mt-2 text-sm text-gray-600"></span>
                                </div>
                                <input id="bukti" name="bukti" type="file" class="hidden" accept="image/*" required>
                            </label>
                        </div>
                    </div>

                    <div id="previewContainer" class="mb-4 hidden">
                        <img id="previewImage" class="mx-auto mb-2 h-40 object-contain rounded-lg shadow-md" />
                    </div>

                    <button type="submit" class="mt-6 w-full bg-gray-200 hover:bg-gray-300 text-black py-3 rounded-lg font-bold shadow-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <x-footer></x-footer>

    <script>
        const container = document.getElementById('container');
        const formUtama = document.getElementById('formutama');
        const partnerInput = document.getElementById('partner');

        partnerInput.addEventListener('input', () => {
            if (formUtama.classList.contains('hidden')) {
                container.classList.add('items-center', 'justify-center');
                container.classList.remove('items-start');
            }
        });

        

                // searchResults
                async function performSearch(query) {
            const results = document.getElementById('searchResults');
            const form = document.getElementById('formutama');
            if (query.length < 3) return results.classList.add('hidden');

            try {
            const res = await fetch(`/api/cari-buyer?query=${encodeURIComponent(query)}`);
            const data = await res.json();

            results.innerHTML = '';

            const filteredData = data.filter(siswa => siswa.status === 'completed' && siswa.kelas !== 'general');

            if (!filteredData.length) {
                results.innerHTML = `<div class="p-4 text-center text-gray-500">
                <i class="fas fa-search text-gray-400 mb-2 text-lg"></i>
                <p class="text-sm">Tidak ada hasil</p>
                </div>`;
            } else {
                filteredData.forEach(siswa => {
                const item = document.createElement('div');
                item.className = 'p-3 cursor-pointer hover:bg-gray-50 border-b border-gray-100';
                item.innerHTML = `
                    <div class="text-blue-500 text-sm">${siswa.order_id}</div>
                    <div class="text-gray-900 font-semibold">${siswa.nama}</div>
                    <div class="text-gray-500 text-sm">${siswa.kelas}</div>
                `;
                item.onclick = () => {
                    document.getElementById('partner').value = siswa.nama;
                    results.classList.add('hidden');
                    form.classList.remove('hidden');
                };
                results.appendChild(item);
                });
            }

            results.classList.remove('hidden');
            } catch (err) {
            console.error('Search error:', err);
            }
        }

        document.getElementById('partner').addEventListener('input', (e) => performSearch(e.target.value));

        // on change input partner
        document.getElementById('partner').addEventListener('change', (e) => {
            const form = document.getElementById('formutama');
            const results = document.getElementById('searchResults');
            if (!e.target.value.trim()) {
            form.classList.add('hidden');
            results.classList.add('hidden');
            }
        });

        // file preview and validation
        const fileInput = document.getElementById('bukti');
        const previewImage = document.getElementById('previewImage');
        const previewContainer = document.getElementById('previewContainer');
        const filenameDisplay = document.getElementById('filename');

        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0];
            if (file && file.size <= 2 * 1024 * 1024) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
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
                filenameDisplay.textContent = '';
            }
        });

        // send payment request
        const form = document.getElementById('guestForm');
        const confirmButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            confirmButton.disabled = true;
            confirmButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';

            fetch('/tamu-beli', {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": formData.get('_token')
            },
            body: formData
            })
            .then(response => {
                if (!response.headers.get('content-type')?.includes('application/json')) {
                    throw new Error('Invalid JSON response');
                }
                return response.json();
            })
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
            confirmButton.textContent = "Kirim";
            });
        });

        // Show warning on page load
        window.addEventListener('load', () => {
            Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: 'Pastikan partner kamu sudah membeli tiket dan terverifikasi sebelum melanjutkan.',
            confirmButtonText: 'Mengerti'
            });
        });
    </script>
</body>
</html>
