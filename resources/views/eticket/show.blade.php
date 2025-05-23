<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>You're Invited - Prom Night 2025</title>

    {{-- TAILWIND --}}
    @vite('resources/css/app.css')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(0deg, #2e0705, #060604);
        }

        .font-gv {
            font-family: 'Great Vibes', cursive;
        }
    </style>
</head>

<body class="flex min-h-screen items-center justify-center p-6 text-red-900">
    <main class="w-full max-w-4xl select-none rounded-2xl bg-white p-8 text-center shadow-xl sm:p-14">
        <!-- Greeting -->
        <p class="mb-2 text-base text-red-700">Dear, <span class="font-semibold">{{ $tiket->nama }}</span></p>

        <!-- Main Header -->
        <h1 class="font-gv mb-4 text-5xl leading-tight text-red-800 sm:text-6xl">You're Invited</h1>

        <!-- Event Title -->
        <h2 class="mb-3 text-3xl font-medium text-red-900 sm:text-4xl">Prom Night: Casino de L'Amour</h2>

        <!-- Subtext -->
        <p class="mb-12 text-base text-red-600 sm:text-lg">
            A magical <span class="font-medium text-red-800">night</span> to remember, under the stars ✨
        </p>

        <!-- QR Ticket Section -->
        <section aria-label="Entry Ticket" class="mx-auto mb-10 max-w-md rounded-lg bg-red-100 px-8 py-10">
            <h3 class="mb-6 text-lg font-semibold text-red-800">Your Entry Ticket</h3>
            <div class="mx-auto mb-6 w-fit">
                {!! $qrCode !!}
            </div>
            <p class="text-sm text-red-800">Show this QR code at the entrance</p>
        </section>

        <!-- Guest Info Section -->
        <section aria-label="Guest Information" class="mx-auto max-w-3xl rounded-lg bg-red-100 px-10 py-10 text-left">
            <h3 class="mb-6 text-center text-lg font-semibold text-red-800">Your Info</h3>
            <div class="flex flex-col gap-8 text-lg sm:flex-row sm:justify-between">
                <div class="space-y-3">
                    <p><span class="font-bold">Name: </span>{{ $tiket->nama }}</p>
                    <p><span class="font-bold">Class: </span>{{ $tiket->kelas }}</p>
                </div>
                <div class="space-y-3">
                    <p><span class="font-bold">ID: </span>{{ $tiket->nis }}</p>
                    <p><span class="font-bold">Ticket ID: </span>{{ $tiket->order_id }}</p>
                </div>
            </div>
        </section>

        <!-- Closing Message -->
        <p class="mx-auto mt-12 max-w-md text-base text-red-700">
            ✨ Let’s make this night <span class="font-medium text-red-800">magical</span> together ✨
        </p>
        <p class="mx-auto mt-2 max-w-md text-base text-red-700">
            Questions? WhatsApp us at
            <a class="font-medium text-red-800 underline" href="https://wa.me/6285222928594" target="_blank"
                rel="noopener">+6285222928594</a>
        </p>
    </main>
</body>

</html>
