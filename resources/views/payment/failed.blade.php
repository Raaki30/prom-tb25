<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Ditutup</title>
    {{-- TAILWIND --}}
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-800 bg-opacity-50">
    <div class="fixed inset-0 z-50 flex items-center justify-center" role="dialog" aria-labelledby="purchase-closed-title">
        <div class="mx-4 w-full max-w-md rounded-lg bg-white shadow-xl">
            <div class="p-8 text-center">
                <div class="mb-6 text-6xl text-yellow-500">
                    <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                </div>
                <h4 id="purchase-closed-title" class="mb-4 text-2xl font-bold text-gray-800">Oops! Terlambat Sedikit 😢</h4>
                <p class="mb-4 text-gray-600">
                    Sayangnya, sesi pembelian sudah resmi ditutup. Tapi jangan khawatir...
                </p>
                <p class="mb-6 text-gray-600">
                    Terima kasih sudah antusias! Kalau ada yang ingin ditanyakan, tim kami siap bantu kamu.
                </p>
                <div class="flex justify-center">
                    <a href="/" class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700 transition">
                        Balik ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
