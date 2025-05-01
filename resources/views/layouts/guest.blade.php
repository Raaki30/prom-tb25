<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #fdfcf9;
            background-image: 
                linear-gradient(to right, rgba(0, 0, 0, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .left-panel {
            background: radial-gradient(circle at center, #2b2a45 0%, #0a071c 90%);
            color: #ffe6f0;
            border-radius: 20px 0 0 20px;
            font-family: 'Georgia', serif;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }

        .left-panel h1 {
            font-family: 'Great Vibes', cursive;
            font-size: 3rem;
            margin: 0.25em 0;
            color: #ffccd5;
            text-shadow: 
                2px 2px 6px rgba(255, 182, 193, 0.7),
                0 0 10px #ff5c8d,
                0 0 20px #ff1e57;
        }

        .left-panel h2 {
            font-size: 1.5rem;
            margin: 0 0 1.5em 0;
            color: #ff5c8d;
            letter-spacing: 0.15em;
            font-weight: normal;
        }

        .left-panel svg {
            width: 100%;
            height: auto;
            max-height: 280px;
        }

        .right-panel {
            background: white;
            border-radius: 0 20px 20px 0;
        }

        .footer {
            text-align: center;
            font-size: 0.8rem;
            color: #999;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .left-panel {
                width: 100%;
                border-radius: 20px;
            }

            .right-panel {
                width: 100%;
                border-radius: 0;
            }

            .left-panel h1 {
                font-size: 2.5rem;
            }

            .left-panel h2 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center px-4">
    <div class="w-full max-w-4xl h-auto flex flex-col sm:flex-row shadow-lg overflow-hidden rounded-[20px] bg-white">
        <!-- Left side -->
        <div class="left-panel w-full sm:w-1/2 flex flex-col justify-center items-center p-8">
            <div class="container" role="main" aria-label="Casino de L'Amour prom night illustration">
                <svg viewBox="0 0 600 400" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet">
                    <!-- Background decorative glowing hearts -->
                    <defs>
                        <radialGradient id="heartGlow" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#ff5c8d" stop-opacity="0.7" />
                            <stop offset="100%" stop-color="#ff1e57" stop-opacity="0" />
                        </radialGradient>
                        <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
                            <feDropShadow dx="0" dy="0" stdDeviation="6" flood-color="#ff5c8d" flood-opacity="0.75" />
                        </filter>
                    </defs>

                    <!-- Casino sign background -->
                    <rect x="50" y="50" width="500" height="180" rx="25" ry="25" fill="#37003c" stroke="#ff5c8d" stroke-width="5" filter="url(#glow)" />
                    <text x="300" y="130" text-anchor="middle" font-family="'Great Vibes', cursive" font-size="46" fill="#ffe6f0" filter="url(#glow)">Casino de L’Amour</text>
                    <text x="300" y="175" text-anchor="middle" font-family="Georgia, serif" font-size="20" fill="#ff8fb1" font-weight="600" letter-spacing="0.2em">
                        TB 25 Prom Night
                    </text>

                    <!-- Champagne glasses -->
                    <g transform="translate(140 260)">
                        <rect x="-8" y="0" width="16" height="70" fill="#ffb3c6" stroke="#ff5c8d" stroke-width="2" rx="5" ry="5" />
                        <ellipse cx="0" cy="5" rx="12" ry="7" fill="url(#heartGlow)" />
                        <rect x="-12" y="70" width="24" height="5" fill="#ff5c8d" />
                    </g>
                    <g transform="translate(190 260) rotate(10)">
                        <rect x="-8" y="0" width="16" height="70" fill="#ffb3c6" stroke="#ff5c8d" stroke-width="2" rx="5" ry="5" />
                        <ellipse cx="0" cy="5" rx="12" ry="7" fill="url(#heartGlow)" />
                        <rect x="-12" y="70" width="24" height="5" fill="#ff5c8d" />
                    </g>

                    <!-- Casino chips stack -->
                    <g>
                        <circle cx="420" cy="280" r="30" fill="#ff1e57" stroke="#fff" stroke-width="8" />
                        <circle cx="420" cy="280" r="22" fill="#37003c" stroke="#ff5c8d" stroke-width="5" />
                        <text x="420" y="287" font-family="Georgia, serif" font-size="26" fill="#ff5c8d" font-weight="bold" text-anchor="middle" dominant-baseline="middle">♥</text>
                    </g>
                    <g transform="translate(0, -15)">
                        <circle cx="440" cy="260" r="24" fill="#ff5c8d" stroke="#fff" stroke-width="6" />
                        <circle cx="440" cy="260" r="16" fill="#2b2a45" stroke="#ff1e57" stroke-width="4" />
                        <text x="440" y="260" font-family="Georgia, serif" font-size="20" fill="#ff1e57" font-weight="bold" text-anchor="middle" dominant-baseline="middle">♣</text>
                    </g>

                    <!-- Playing card decorative -->
                    <g transform="translate(300 320) rotate(-15)">
                        <rect x="-20" y="-30" width="50" height="70" rx="8" ry="8" fill="#ffe6f0" stroke="#ff5c8d" stroke-width="3" />
                        <text x="5" y="5" font-family="Georgia, serif" font-size="30" fill="#ff1e57" font-weight="bold" text-anchor="middle" dominant-baseline="middle">A</text>
                        <text x="30" y="60" font-family="Georgia, serif" font-size="28" fill="#ff1e57" font-weight="bold" text-anchor="end" dominant-baseline="ideographic">♥</text>
                    </g>

                    <!-- Decorative sparkling stars and highlights -->
                    <g fill="#ffafd0" filter="url(#glow)" opacity="0.8">
                        <circle cx="120" cy="90" r="3" />
                        <circle cx="550" cy="70" r="2.5" />
                        <circle cx="540" cy="140" r="3" />
                        <circle cx="200" cy="110" r="2" />
                        <circle cx="480" cy="200" r="2.5" />
                        <circle cx="350" cy="140" r="3" />
                    </g>

                    <!-- Heart shape central large -->
                    <path fill="#ff1e57" filter="url(#glow)" opacity="0.9"
                        d="M300 230
                          c0 -27 -30 -40 -42 -18
                          -10 17 10 38 42 65
                          32 -27 52 -51 42 -68
                          -12 -21 -42 -6 -42 21z" />
                    <path fill="#ff7aa0" opacity="0.8"
                        d="M295 220
                          c0 -20 -22 -30 -32 -13
                          -7 13 7 28 32 48
                          25 -20 40 -37 32 -48
                          -9 -16 -32 -5 -32 13z" />
                </svg>
            </div>
        </div>

        <!-- Right side -->
        <div class="right-panel w-full sm:w-1/2 flex items-center justify-center p-8">
            <div class="w-full">
                {{ $slot }}
            </div>
        </div>
    </div>
    <div class="my-8"></div>
    <div class="footer mt-4">
        Made with <span class="text-red-500">♥</span> by Prom Night TB25 Committee
    </div>
</body>
</html>
