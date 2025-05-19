@php
    $is_active = \App\Models\Control::value('is_active');
    $ismerch_active = \App\Models\Control::value('ismerchactive');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prom Night: Casino de L'Amour</title>

    {{-- TAILWIND --}}
    @vite('resources/css/app.css')

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ephesis&family=Imperial+Script&family=Lavishly+Yours&family=Tangerine&display=swap"
        rel="stylesheet">

    {{-- AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        html, body {
            width: 100vw;
            overflow-x: hidden
        }

    </style>
</head>

<body>
    {{-- Hero Section --}}
    <section class="hero-section relative flex items-center"
        style="background-image: url('{{ asset('images/prom-bg.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <!-- Overlay gelap di atas background image -->
        <div class="absolute inset-0 z-0 bg-black opacity-50"></div>
        <div class="relative z-10 min-h-screen w-full">


            <div class="relative isolate px-6 pt-14 lg:px-8">
                <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                    {{-- <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                        <div
                            class="relative rounded-full px-3 py-1 text-sm/6 text-white ring-1 ring-gray-100/20 hover:ring-gray-100/40 bg-black bg-opacity-40">
                            Announcing our next round of funding. <a href="#"
                                class="font-semibold text-red-200"><span class="absolute inset-0"
                                    aria-hidden="true"></span>Read more <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div> --}}
                    <div class="text-center">
                        <h1
                            class="text-gold-500 font-fancy-3 text-balance text-5xl font-semibold tracking-tight sm:text-8xl">
                            <span id="type-casino"></span><span id="type-de"></span><span id="type-lamour"></span>
                        </h1>
                        <p class="text-md mt-8 text-pretty font-medium text-gray-200 sm:text-xl/6" data-aos="fade-up"
                            data-aos-delay="200" data-aos-duration="1200">Casino de L’Amour” is
                            French and translates to “Casino of Love” — a mix of elegance and romance, perfect for a
                            Monte Carlo-themed prom night. It gives off that luxurious, flirty vibe while still sounding
                            fancy and classy.</p>
                        <div class="mt-10 flex items-center justify-center gap-x-6" data-aos="zoom-in"
                            data-aos-delay="400" data-aos-duration="1200">
                            @if ($is_active == true)
                                <a href="/pesan"
                                    class="shadow-xs rounded-md bg-red-500 px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500">Get
                                    Your Ticket</a>
                            @else
                                <a href="#"
                                    class="shadow-xs cursor-not-allowed rounded-md bg-gray-500 px-3.5 py-2.5 text-sm font-semibold text-white opacity-50">Coming
                                    Soon</a>
                            @endif
                        </div>
                        <div class="bouncing-arrow bouncing-icon" data-aos="fade-up" data-aos-delay="600"
                            data-aos-duration="1200">
                            <i class="fa-solid fa-angles-down relative top-20 text-xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End Hero Section --}}

    {{-- About Section --}}
    <section class="about-section">
        <div class="py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <p class="font-fancy-4 mt-2 text-pretty text-5xl font-semibold tracking-tight text-yellow-500 sm:text-6xl lg:text-balance"
                        data-aos="fade-down" data-aos-delay="50" data-aos-duration="1000">
                        About This Event</p>
                    <p class="mt-6 text-lg/8 text-gray-200" data-aos="fade-up" data-aos-delay="100"
                        data-aos-duration="1200">Casino De L’amour is a prom night wrapped in glamour and romance, inspired by the charm of a classic casino. Blending elegant décor, timeless music, and interactive games, it creates a luxurious atmosphere to celebrate friendship, love, and lasting memories. More than just a party, it’s an evening of style, emotion, and unforgettable moments.
                    </p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                        <div class="relative pl-16" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1200">
                            <dt class="text-base/7 font-semibold text-gray-100">
                                <div
                                    class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-red-600">
                                    <i class="fa fa-book scale-110 text-white" aria-hidden="true"></i>
                                </div>
                                Philosophy
                            </dt>
                            <dd class="mt-2 text-base/7 text-gray-300">Casino De L’amour is more than a theme—it’s a celebration of love, risk, and youthful elegance. A graceful farewell to high school, and a timeless memory in the making.
                            </dd>
                        </div>
                        <div class="relative pl-16" data-aos="fade-left" data-aos-delay="400" data-aos-duration="1200">
                            <dt class="text-base/7 font-semibold text-gray-100">
                                <div
                                    class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-red-600">
                                    <i class="fa fa-question scale-110 text-white" aria-hidden="true"></i>
                                </div>
                                Purpose
                            </dt>
                            <dd class="mt-2 text-base/7 text-gray-300">This night honors the journey shared—laughter, growth, and friendship. A final gathering to reflect, celebrate, and part ways with joy and gratitude.
                            </dd>
                        </div>
                        <div class="relative pl-16" data-aos="fade-right" data-aos-delay="600" data-aos-duration="1200">
                            <dt class="text-base/7 font-semibold text-gray-100">
                                <div
                                    class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-red-600">
                                    <i class="fa fa-key scale-110 text-white" aria-hidden="true"></i>
                                </div>
                                Highlights
                            </dt>
                            <dd class="mt-2 text-base/7 text-gray-300">Step into a night of Monte Carlo-inspired glamour—elegant décor, live entertainment, themed games, curated dining, photo spots, and a dance floor lit with love and luck.</dd>
                        </div>
                        <div class="relative pl-16" data-aos="fade-left" data-aos-delay="800" data-aos-duration="1200">
                            <dt class="text-base/7 font-semibold text-gray-100">
                                <div
                                    class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-red-600">
                                    <i class="fa fa-user scale-110 text-white" aria-hidden="true"></i>
                                </div>
                                Audience
                            </dt>
                            <dd class="mt-2 text-base/7 text-gray-300">We’re going to invite an audience that consists of students from Taruna Bakti High School and a limited number of external personnels besides Taruna Bakti students</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </section>
    {{-- End About Section --}}

    {{-- Merch Section --}}
    
    <section class="merch-section bg-gradient-to-b from-gray-900 via-gray-950 to-black py-24 sm:py-32">
        <div class="mx-auto max-w-2xl px-6 text-center lg:max-w-7xl lg:px-8">
            <p class="font-fancy-4 mt-2 text-pretty text-6xl font-semibold tracking-tight text-yellow-500 sm:text-6xl lg:text-balance"
                data-aos="fade-down" data-aos-delay="0" data-aos-duration="1200">
                Merchandise</p>
            <p class="mt-6 text-lg/8 text-gray-200" data-aos="fade-up" data-aos-delay="100"
                data-aos-duration="1200">Explore our exclusive merchandise for this event. Grab your favorite items and make this prom unforgettable!</p>
            <div class="mt-10 grid gap-8 sm:mt-16 lg:grid-cols-4">
                <!-- Card Template -->
                @foreach ([
                    ['title' => 'Tote Bag', 'description' => 'Stylish and eco-friendly tote bags with exclusive designs.', 'image' => 'Totebag1.png'],
                    ['title' => 'Tumblr', 'description' => 'Stay hydrated with our premium tumblers featuring unique designs.', 'image' => 'Tumblr1.png'],
                    ['title' => 'Lanyard', 'description' => 'Carry your essentials in style with our custom lanyards.', 'image' => 'Lanyard1.png'],
                    ['title' => 'Enamel Pin', 'description' => 'Collectible enamel pins to commemorate this special event.', 'image' => 'EnamelPin1.png']
                ] as $item)
                    <div class="relative flex flex-col items-center overflow-hidden rounded-lg bg-gradient-to-br from-[#2e0705] via-yellow-950 to-black shadow-lg p-6 transform transition duration-300 hover:-translate-y-2"
                        data-aos="fade-up" data-aos-delay="{{ $loop->index * 200 }}" data-aos-duration="1200">
                        <img class="mb-4 h-64 w-auto object-cover rounded-md" src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['title'] }}">
                        <h3 class="text-2xl font-semibold text-yellow-400">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-base text-gray-300 text-center">{{ $item['description'] }}</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-10 flex items-center justify-center gap-x-6" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1200">
                @if ($ismerch_active == true)
                    <a href="/merch"
                        class="mt-10 shadow-xs rounded-md bg-red-500 px-5 py-3 text-lg font-semibold text-white hover:bg-red-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500">
                        Explore More
                    </a>
                @else
                    <a href="#"
                        class="mt-10 shadow-xs cursor-not-allowed rounded-md bg-gray-500 px-5 py-3 text-lg font-semibold text-white opacity-50">
                        Coming Soon
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- End Merch Section --}}

    {{-- Theme Section --}}
    <section class="theme-section">
        <div class="py-24 sm:py-32">
            <div class="mx-auto max-w-2xl px-6 text-center lg:max-w-7xl lg:px-8">
                <p class="font-fancy-4 mt-2 text-pretty text-6xl font-semibold tracking-tight text-yellow-500 sm:text-6xl lg:text-balance"
                    data-aos="fade-down" data-aos-delay="0" data-aos-duration="1200">
                    Event Theme</p>
                <div class="mt-10 flex justify-center">
                    <div class="relative rounded-lg bg-gray-200 p-6 sm:p-10 lg:p-12 max-w-md"
                        data-aos="fade-up" data-aos-delay="200" data-aos-duration="1200">
                        <div class="text-center">
                            <p class="font-fancy-4 text-4xl font-medium tracking-tight text-gray-950">
                                Outfit Inspiration</p>
                            <p class="mt-4 text-sm text-gray-600">This is an outfit inspiration for the event. <br>Color palette: maroon red, navy, royal blue, black, gold, white, emerald green.</p>
                        </div>
                        <div class="mt-6 flex justify-center">
                            <img class="rounded-md object-cover object-top" src="{{ asset('images/outfit-inspo.png') }}" alt="Outfit Inspiration">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End Theme Section --}}


    
    {{-- Venue Section --}}
    <section class="venue-section">
        <div class="py-12 text-center sm:py-32">
            <p class="font-fancy-4 mt-2 text-pretty text-6xl font-semibold tracking-tight text-yellow-500 sm:text-6xl lg:text-balance"
                data-aos="fade-down" data-aos-delay="0" data-aos-duration="1200">
                The Venue</p>
            <div class="grid grid-cols-1 gap-10 p-5 sm:grid-cols-2 sm:p-20">
                {{-- CAROUSEL --}}
                <div class="relative mx-auto w-full max-w-3xl"data-aos="fade-up" data-aos-delay="200"
                    data-aos-duration="1200">
                    <!-- Slides container -->
                    <div id="carousel" class="relative h-64 overflow-hidden rounded-lg md:h-96">
                        <div class="carousel-slide absolute inset-0 opacity-100 transition-opacity duration-700">
                            <img src="https://thepapandayan.com/wp-content/uploads/2018/04/Suagi-Ballroom-1-scaled.jpg"
                                class="h-full w-full object-cover" />
                        </div>
                        <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-700">
                            <img
                                src="https://thepapandayan.com/wp-content/uploads/2018/03/SUAGI-GRAND-BALLROOM.jpg" />
                        </div>
                        <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-700">
                            <img src="https://ik.imagekit.io/tvlk/blog/2021/07/Grand-Ballroom-InterContinental-Bandung-Dago-Pakar.jpg"
                                class="h-full w-full object-cover" />
                        </div>
                        <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-700">
                            <img
                                src="https://thepapandayan.com/wp-content/uploads/2018/04/pic-suagi-ballroom.jpg" />
                        </div>
                    </div>

                    <!-- Controls -->
                    <button id="prev"
                        class="absolute left-4 top-1/2 z-10 -translate-y-1/2 transform rounded-full bg-white/50 p-2 shadow-md hover:bg-white">
                        &#8592;
                    </button>
                    <button id="next"
                        class="absolute right-4 top-1/2 z-10 -translate-y-1/2 transform rounded-full bg-white/50 p-2 shadow-md hover:bg-white">
                        &#8594;
                    </button>

                    <!-- Indicators -->
                    <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 transform space-x-2">
                        <button class="indicator h-3 w-3 rounded-full bg-white opacity-80 hover:opacity-100"
                            data-index="0"></button>
                        <button class="indicator h-3 w-3 rounded-full bg-white opacity-50 hover:opacity-100"
                            data-index="1"></button>
                        <button class="indicator h-3 w-3 rounded-full bg-white opacity-50 hover:opacity-100"
                            data-index="2"></button>
                        <button class="indicator h-3 w-3 rounded-full bg-white opacity-50 hover:opacity-100"
                            data-index="3"></button>
                    </div>
                </div>
                <div class="animate_animated animate_fadeIn mx-auto flex max-w-lg flex-col gap-4 rounded-2xl border border-yellow-600/30 bg-white/10 p-8 text-left font-medium text-white shadow-lg backdrop-blur-md"
                    style="box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.25);" data-aos="fade-left"
                    data-aos-delay="400" data-aos-duration="1200">
                    <p class="font-fancy-4 mb-1 flex items-center gap-3 text-5xl text-yellow-400">
                        The Papandayan Hotel
                    </p>

                    <ul class="my-5 space-y-2 pl-4">
                        <li class="flex items-center gap-2 text-base text-yellow-100">
                            <i class="fa fa-star text-yellow-400"></i> Exquisitely Decorated Venue
                        </li>
                        <li class="flex items-center gap-2 text-base text-yellow-100">
                            <i class="fa fa-star text-yellow-400"></i> Seamlessly Themed Ambience
                        </li>
                        <li class="flex items-center gap-2 text-base text-yellow-100">
                            <i class="fa fa-star text-yellow-400"></i> Sophisticated Lighting Design
                        </li>
                        <li class="flex items-center gap-2 text-base text-yellow-100">
                            <i class="fa fa-star text-yellow-400"></i> Spacious & Refined Interior
                        </li>
                        <li class="flex items-center gap-2 text-base text-yellow-100">
                            <i class="fa fa-star text-yellow-400"></i> Picture-Perfect Vibe
                        </li>
                    </ul>
                    <p class="text-base text-yellow-100"><i class="fa fa-location-dot text-yellow-400"></i> Jl. Gatot
                        Subroto No.83, Malabar, Kec. Lengkong, Kota Bandung, Jawa Barat 40262</p>
                </div>
            </div>

            <script>
                const slides = document.querySelectorAll(".carousel-slide");
                const indicators = document.querySelectorAll(".indicator");
                let current = 0;

                function showSlide(index) {
                    slides.forEach((slide, i) => {
                        slide.style.opacity = i === index ? "1" : "0";
                    });

                    indicators.forEach((dot, i) => {
                        dot.classList.toggle("opacity-80", i === index);
                        dot.classList.toggle("opacity-50", i !== index);
                    });

                    current = index;
                }

                document.getElementById("next").addEventListener("click", () => {
                    showSlide((current + 1) % slides.length);
                });

                document.getElementById("prev").addEventListener("click", () => {
                    showSlide((current - 1 + slides.length) % slides.length);
                });

                indicators.forEach((dot) => {
                    dot.addEventListener("click", () => {
                        const index = parseInt(dot.getAttribute("data-index"));
                        showSlide(index);
                    });
                });

                // Auto slide (optional)
                setInterval(() => {
                    showSlide((current + 1) % slides.length);
                }, 5000); // Change slide every 5s

                showSlide(0);
            </script>

        </div>
    </section>
    {{-- End Venue Section --}}


    {{-- Date & Time Section --}}
    <section class="date-time-section bg-gradient-to-b from-gray-900 via-gray-950 to-black py-20 text-white sm:py-32">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="font-fancy-4 mb-6 text-6xl font-bold tracking-tight text-yellow-400 sm:text-7xl"
                data-aos="fade-down" data-aos-duration="1400">
                Date & Time
            </h2>
            <p class="mb-12 text-2xl text-yellow-200 sm:text-2xl" data-aos="fade-up" data-aos-delay="200"
                data-aos-duration="1200">
                5 July 2025 | 18.30 - 23.00
            </p>
            <div class="stripes" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="1800">
                <div class="countdown-container">
                    <div class="countdown-unit" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1200">
                        <span id="days" class="countdown-number">00</span>
                        <span class="countdown-label">days</span>
                    </div>
                    <div class="countdown-unit" data-aos="fade-up" data-aos-delay="750" data-aos-duration="1300">
                        <span id="hours" class="countdown-number">00</span>
                        <span class="countdown-label">hours</span>
                    </div>
                    <div class="countdown-unit" data-aos="fade-up" data-aos-delay="900" data-aos-duration="1400">
                        <span id="minutes" class="countdown-number">00</span>
                        <span class="countdown-label">min</span>
                    </div>
                    <div class="countdown-unit" data-aos="fade-up" data-aos-delay="1050" data-aos-duration="1500">
                        <span id="seconds" class="countdown-number">00</span>
                        <span class="countdown-label">sec</span>
                    </div>
                </div>
            </div>
            <p class="font-fancy-4 mt-8 animate-pulse text-4xl text-yellow-300 sm:text-3xl" data-aos="fade-up"
                data-aos-delay="1200" data-aos-duration="1200">
                Until Prom Night Begins!
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6" data-aos="fade-up" data-aos-delay="1400" data-aos-duration="1200">
                @if ($is_active == true)
                    <a href="/pesan"
                        class="shadow-xs rounded-md bg-red-500 px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500">Get
                        Your Ticket</a>
                @else
                    <a href="#"
                        class="shadow-xs cursor-not-allowed rounded-md bg-gray-500 px-3.5 py-2.5 text-sm font-semibold text-white opacity-50">Coming
                        Soon</a>
                @endif
            </div>
        </div>
        <style>
            /* [unchanged CSS from your previous version] */
            .stripes {
                background-image: repeating-linear-gradient(45deg,
                        rgba(255, 255, 255, 0.03),
                        rgba(255, 255, 255, 0.03) 10px,
                        transparent 10px,
                        transparent 20px);
                background-color: #1a0a0a;
                min-height: 120px;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 1.5rem 1rem;
                border-radius: 1.5rem;
                margin: 0 auto;
                max-width: 700px;
            }

            .countdown-container {
                background: linear-gradient(135deg, #2a0d0d, #1a0606);
                border-radius: 1rem;
                box-shadow:
                    0 0 15px rgba(0, 0, 0, 0.6),
                    inset 0 0 15px rgba(0, 0, 0, 0.4);
                padding: 1.5rem 3rem;
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 3rem;
                max-width: 600px;
                width: 100%;
                user-select: none;
            }

            .countdown-unit {
                display: flex;
                flex-direction: column;
                align-items: center;
                color: #b33a3a;
                text-shadow: 0 0 2px #4f0000;
            }

            .countdown-number {
                font-size: 3.5rem;
                font-weight: 700;
                color: #bfa243;
                position: relative;
                perspective: 600px;
                width: 4.5rem;
                height: 4.5rem;
                line-height: 4.5rem;
                text-align: center;
                border-radius: 0.75rem;
                background: linear-gradient(145deg, #3b2a0a, #1f1603);
                box-shadow:
                    inset 2px 2px 8px rgba(191, 162, 67, 0.6),
                    inset -2px -2px 8px rgba(102, 85, 0, 0.8);
                text-shadow: 0 0 1px #a68f3a;
                font-feature-settings: "tnum";
                font-variant-numeric: tabular-nums;
                transition: color 0.3s ease;
                margin-bottom: 0.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .countdown-label {
                font-size: 0.875rem;
                color: #b33a3a;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                font-weight: 600;
                text-shadow: 0 0 1px #4f0000;
            }

            .flip {
                animation: flipAnim 1.37s ease forwards;
                transform-style: preserve-3d;
                backface-visibility: hidden;
            }

            @keyframes flipAnim {
                0% {
                    transform: rotateX(0deg);
                    opacity: 1;
                }

                50% {
                    transform: rotateX(90deg);
                    opacity: 0;
                }

                51% {
                    transform: rotateX(-90deg);
                    opacity: 0;
                }

                100% {
                    transform: rotateX(0deg);
                    opacity: 1;
                }
            }

            @media (max-width: 480px) {
                .countdown-container {
                    gap: 1.5rem;
                    padding: 1rem 1.5rem;
                }

                .countdown-number {
                    font-size: 2.5rem;
                    width: 3.5rem;
                    height: 3.5rem;
                    line-height: 3.5rem;
                }

                .countdown-label {
                    font-size: 0.75rem;
                }
            }
        </style>
        <script>
            // Countdown to 5 July 2025, 17:00 (5 PM) UTC+7 (Asia/Jakarta/Bangkok)
            const countdownTarget = new Date('2025-07-05T17:00:00+07:00');

            function animateFlip(element, newValue) {
                if (element.textContent == newValue) return;
                element.classList.remove('flip');
                void element.offsetWidth;
                element.classList.add('flip');
                element.textContent = newValue;
            }

            function updateCountdown() {
                const now = new Date();
                const diff = countdownTarget - now;
                if (diff <= 0) {
                    animateFlip(document.getElementById('days'), '0');
                    animateFlip(document.getElementById('hours'), '0');
                    animateFlip(document.getElementById('minutes'), '0');
                    animateFlip(document.getElementById('seconds'), '0');
                    clearInterval(timerInterval);
                    return;
                }
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                const minutes = Math.floor((diff / (1000 * 60)) % 60);
                const seconds = Math.floor((diff / 1000) % 60);
                animateFlip(document.getElementById('days'), days);
                animateFlip(document.getElementById('hours'), hours);
                animateFlip(document.getElementById('minutes'), minutes);
                animateFlip(document.getElementById('seconds'), seconds);
            }
            updateCountdown();
            const timerInterval = setInterval(updateCountdown, 1000);
        </script>
    </section>
    {{-- End Date & Time Section --}}

    <footer class="w-full bg-black px-4 py-6 shadow-inner backdrop-blur">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 sm:flex-row">
            <div class="text-sm tracking-wide text-yellow-200">
                © {{ date('Y') }} Prom Night TB25. All rights reserved.
            </div>
            <div class="flex space-x-5 text-xl text-white">
                <a href="https://wa.me/6282262293060" aria-label="whatsapp"
                    class="transition hover:text-yellow-400 focus:text-yellow-400">
                    <i class="fab fa fa-whatsapp"></i>
                </a>
                <a href="https://www.instagram.com/casinodelamour/" aria-label="Instagram"
                    class="transition hover:text-yellow-400 focus:text-yellow-400">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </footer>


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const words = [{
                    id: 'type-casino',
                    text: 'Casino',
                    after: ' '
                },
                {
                    id: 'type-de',
                    text: 'de',
                    after: ' '
                },
                {
                    id: 'type-lamour',
                    text: 'L\'Amour',
                    after: ''
                }
            ];
            let wordIdx = 0;
            let charIdx = 0;

            function typeNext() {
                if (wordIdx >= words.length) return;
                const {
                    id,
                    text,
                    after
                } = words[wordIdx];
                const el = document.getElementById(id);
                if (charIdx < text.length) {
                    el.textContent += text[charIdx];
                    charIdx++;
                    setTimeout(typeNext, 100); // typing speed
                } else {
                    el.textContent += after;
                    wordIdx++;
                    charIdx = 0;
                    setTimeout(typeNext, 500); // pause between words
                }
            }
            typeNext();
        });
    </script>
    {{-- <script async
    src="https://kac3opy67dsogirllmtqz3bn.agents.do-ai.run/static/chatbot/widget.js"
    data-agent-id="c646abf9-1fe5-11f0-bf8f-4e013e2ddde4"
    data-chatbot-id="NmTrlKnYY2GIKDE2rwZKe8786fy2Q0Wk"
    data-name="Casino de L’Amour Assistant"
    data-primary-color="#2D1E2F" 
    data-secondary-color="#F5EAEA" 
    data-button-background-color="#FFFFFF" 
    data-starting-message="Hai ✨ Siap untuk malam prom yang penuh cinta dan pesona? Bagaimana aku bisa membantumu?"
    data-logo="/static/chatbot/icons/default-agent.svg">
  </script> --}}
  
</body>

</html>