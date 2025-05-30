<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Ditutup</title>
    {{-- TAILWIND --}}
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 20v-1.41l2.83-2.83 1.41 1.41L1.41 20H0zm20 0v-1.41l2.83-2.83 1.41 1.41L21.41 20H20zm0 18.59l2.83-2.83 1.41 1.41L21.41 40H20v-1.41zM12.41 20H18v5.59l-5.59-5.59zM40 12.41V18h-5.59l5.59-5.59zM20 12.41V18h-5.59l5.59-5.59zM0 12.41V18h5.59L0 12.41zM28.41 20H22v5.59l6.41-5.59zM0 28.41V34h5.59L0 28.41z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>

<body class="bg-[#18181b] min-h-screen flex items-center justify-center p-4">
    <div class="container mx-auto py-8">
        <div class="max-w-2xl mx-auto overflow-hidden bg-[#18181b]/80 rounded-lg border border-yellow-500/30 shadow-lg">
            <!-- Header -->
            <div class="relative bg-[#212026] px-8 py-10 text-center">
                <div class="absolute top-0 left-0 w-full h-full bg-pattern opacity-20"></div>
                <div class="relative">
                    <div class="inline-flex items-center justify-center w-20 h-20 mb-4 rounded-full bg-[#18181b]/60 border border-yellow-500/30">
                        <i class="fas fa-clock text-5xl text-yellow-400"></i>
                    </div>
                    <h2 class="text-3xl font-semibold text-yellow-100 font-fancy-4">Voting Telah Ditutup</h2>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-8 md:p-10">
                <div class="p-4 mb-6 rounded-lg bg-[#212026] border border-yellow-600/20 text-center">
                    <p class="text-yellow-100/80 font-medium">
                        Terima kasih telah berpartisipasi dalam voting Prom Awards tahun ini!
                    </p>
                </div>

                <!-- Divider -->
                <div class="relative py-3">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-yellow-600/30"></div>
                    </div>
                    
                    
                </div>
                
                <div class="mb-8 space-y-4 mt-6 text-center">
                    <p class="text-yellow-100/80">
                        Pengumuman pemenang akan dilakukan pada malam acara 
                        <span class="font-semibold text-yellow-400">Prom Night</span>.
                    </p>
                    
                    <p class="text-yellow-100/80">
                        See You at the Prom Night!
                    </p>
                </div>
                <div class="mt-8 text-center">
                    <a href="/" class="inline-flex items-center justify-center px-6 py-3 font-medium text-white bg-yellow-500 hover:bg-yellow-600 rounded-full transition-all duration-300">
                        <i class="fas fa-home mr-2"></i> Kembali ke Beranda
                    </a>
                </div>
                
                <!-- Social Media Links -->
                <div class="mt-8 pt-6 border-t border-yellow-600/20">
                    <div class="flex justify-center space-x-4">
                        <a href="https://instagram.com/casinodelamour" class="text-yellow-400 hover:text-yellow-300 transition-colors duration-200">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>