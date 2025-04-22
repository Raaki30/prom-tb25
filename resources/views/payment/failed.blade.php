<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    {{-- TAILWIND --}}
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-800 bg-opacity-50">
    <div class="fixed inset-0 z-50 flex items-center justify-center" role="dialog" aria-labelledby="payment-failed-title">
        <div class="mx-4 w-full max-w-md rounded-lg bg-white shadow-xl">
            <div class="p-8 text-center">
                <div class="mb-6 text-6xl text-red-500">
                    <i class="fas fa-times-circle" aria-hidden="true"></i>
                </div>
                <h4 id="payment-failed-title" class="mb-4 text-2xl font-semibold text-gray-800">Pembayaran Gagal!</h4>
                <p class="mb-6 text-gray-600">
                    Maaf, pembayaran Anda tidak berhasil. Silakan coba lagi atau hubungi layanan pelanggan jika masalah
                    berlanjut.
                </p>
                <p class="mb-6 text-gray-600">
                    ID Pesanan Anda: <strong>{{ request()->query('order_id') }}</strong>
                </p>
                <div class="flex justify-center">
                    <div class="h-8 w-8 animate-spin rounded-full border-b-2 border-red-500"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = '/'; // Ganti ke halaman yang sesuai
        }, 5000);
    </script>
</body>

</html>
