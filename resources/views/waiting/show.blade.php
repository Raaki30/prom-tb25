@php
    use Illuminate\Support\Facades\Session;
    use App\Models\WaitingRoom;
    $session_id = Session::getId();
    $hasAction = WaitingRoom::where('session_id', $session_id)->exists();
    $originPosition = Session::get('origin_position', 0);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🎟️ Virtual Waiting Room</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&family=Pacifico&family=Tangerine:wght@400;700&family=Ephesis&family=Imperial+Script&family=Lavishly+Yours&display=swap" rel="stylesheet">
    
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
        }
        .font-fancy {
            font-family: 'Tangerine', cursive;
        }
        .cute-icon {
            animation: bounce 1.5s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .hover-bouncing-dikit:hover {
            animation: bounce 0.5s;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        /* Background pattern */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(234,179,8,0.03) 1px, transparent 1px),
                radial-gradient(circle at 75% 75%, rgba(234,179,8,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -2;
            pointer-events: none;
        }
        
        /* Sparkling stars */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
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
        
        /* Progress bar animations */
        @keyframes pulse {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }

        /* Success animations */
        @keyframes celebrate {
            0% { transform: scale(0.8); opacity: 0; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .celebrate {
            animation: celebrate 0.8s ease-out forwards;
        }
        
        @keyframes fadeInUp {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .spin {
            animation: spin 1.5s linear infinite;
        }
        
        .countdown-circle {
            transform: rotate(-90deg);
            transform-origin: center;
            transition: stroke-dashoffset 1s linear;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#2e0705] to-[#060604] min-h-screen flex items-center justify-center" 
      x-data="waitingRoom({{ $hasAction ? 'true' : 'false' }})" 
      x-init="initStars()">
      
    <div class="bg-pattern"></div>
    <div class="stars"></div>

    <div class="w-full max-w-md mx-auto bg-[#18181b]/80 shadow-2xl rounded-3xl p-8 border border-yellow-500/30 relative overflow-hidden" 
         data-aos="fade-up" data-aos-duration="1200">
        <div class="absolute -top-8 -right-8 text-yellow-400 text-6xl opacity-10">
            🎟️
        </div>

        <div x-show="!isActive && !hasAction" class="text-center space-y-6 animate-fade-in">
            <!-- Join Waiting Room -->
            <div class="text-5xl font-extrabold text-yellow-400 font-fancy cute-icon" data-aos="fade-down" data-aos-duration="1500">Welcome!</div>
            <h1 class="text-2xl font-bold text-yellow-100">Virtual Waiting Room</h1>
            <p class="text-yellow-100/80 leading-relaxed">
                Karena jumlah tiket terbatas, kami menggunakan sistem antrian untuk memberikan anda pengalaman yang lebih baik. Klik untuk cek ketersediaan sebelum masuk ke ruang tunggu ✨
            </p>
            <button 
                id="join-queue-btn" 
                class="hover-bouncing-dikit bg-yellow-400 hover:bg-yellow-600 transition-all duration-300 text-white font-semibold px-6 py-3 rounded-full shadow-lg"
            >
                <i class="fas fa-door-open mr-2"></i> Cek Ketersediaan
            </button>
        </div>

        <div x-show="!isActive && hasAction" class="text-center space-y-6 animate-fade-in">
            <!-- In Queue -->
            <div class="text-5xl font-extrabold text-yellow-400 font-fancy cute-icon" data-aos="fade-down" data-aos-duration="1500">Hang Tight!</div>
            <h1 class="text-2xl font-bold text-yellow-100">You're in the Queue</h1>
            
            <div class="p-3 bg-[#18181b]/60 rounded-lg border border-yellow-500/30 inline-block" data-aos="fade-up" data-aos-duration="700">
                <i class="fas fa-ticket-alt mr-2 text-yellow-200"></i>
                <span class="text-yellow-200">Your place is secured</span>
            </div>
            
            <div class="space-y-4 mt-4">
                <div class="space-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-sm text-yellow-100/70">⏳ Estimated Wait Time</div>
                    <div class="text-xl font-semibold text-yellow-400" id="wait-time">Calculating...</div>
                </div>
                <div class="space-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-sm text-yellow-100/70">📍 Your Position</div>
                    <div class="text-xl font-semibold text-yellow-400" id="queue-position">Calculating...</div>
                </div>
                <div class="space-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-sm text-yellow-100/70">🎟️ Remaining Tickets</div>
                    <div class="text-xl font-semibold text-yellow-400" id="remaining-tickets">Calculating...</div>
                </div>
            </div>
            
            <div class="mt-4" data-aos="fade-up" data-aos-delay="300">
                <div class="w-full h-5 bg-[#212026] rounded-full overflow-hidden shadow-inner">
                    <div id="progress-bar" class="h-5 bg-gradient-to-r from-yellow-400 to-yellow-600 transition-all duration-700 ease-in-out text-xs text-white text-center leading-5 animate-pulse" style="width: 0%;">
                        ✨
                    </div>
                </div>
            </div>
            
            <p class="text-yellow-100/80 text-sm mt-6" data-aos="fade-up" data-aos-delay="400">Please stay on this page. You'll be automatically redirected when it's your turn ✨</p>
            <div class="mt-4 text-yellow-100/60 text-xs">
                <span class="font-semibold">Session ID:</span>
                <span class="select-all bg-yellow-900/30 px-2 py-1 rounded">{{ $originPosition }}</span>
            </div>
            
            <div class="mt-8 pt-6 border-t border-yellow-600/20" data-aos="fade-up" data-aos-delay="500">
                <div class="flex justify-center space-x-4">
                    <a href="https://instagram.com/casinodelamour" class="text-yellow-400 hover:text-yellow-300">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- You're in! Success state -->
        <div x-show="isActive" class="text-center space-y-8">
            <div class="text-6xl font-extrabold text-yellow-400 font-fancy celebrate" data-aos="fade-down" data-aos-duration="1500">
                You're In! 🎉
            </div>
            
            <div class="p-4 bg-yellow-500/20 rounded-lg border border-yellow-500/50 inline-block fade-in-up" style="animation-delay: 0.3s">
                <i class="fas fa-check-circle text-2xl text-yellow-400 mr-2"></i>
                <span class="text-yellow-200 text-lg">Your turn has arrived!</span>
            </div>
            
            <div class="space-y-6 mt-4 fade-in-up" style="animation-delay: 0.6s">
                <p class="text-yellow-100 text-lg">Preparing your experience...</p>
                
                <!-- Countdown timer circle -->
                <div class="flex justify-center items-center my-6">
                    <div class="relative w-24 h-24">
                        <svg class="w-full h-full" viewBox="0 0 100 100">
                            <!-- Background circle -->
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#2d2d33" stroke-width="8"/>
                            
                            <!-- Progress circle -->
                            <circle id="countdown-circle" class="countdown-circle" 
                                    cx="50" cy="50" r="45" 
                                    fill="none" 
                                    stroke="#eab308" 
                                    stroke-width="8"
                                    stroke-dasharray="283"
                                    stroke-dashoffset="0"/>
                        </svg>
                        <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                            <span id="countdown-number" class="text-2xl font-bold text-yellow-400">5</span>
                        </div>
                    </div>
                </div>
                
                <p class="text-yellow-100/70 text-sm">You'll be automatically redirected in a few seconds.</p>
            </div>
            
            <div class="mt-6 flex justify-center space-x-2 fade-in-up" style="animation-delay: 0.9s">
                <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse" style="animation-delay: 0s;"></span>
                <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse" style="animation-delay: 0.2s;"></span>
                <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse" style="animation-delay: 0.4s;"></span>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize AOS
                AOS.init({
                    once: true,
                    duration: 900,
                    easing: 'ease-in-out',
                });
                
                // Join queue button
                const joinBtn = document.getElementById('join-queue-btn');
                if (joinBtn) {
                    joinBtn.addEventListener('click', function() {
                        fetch('/waiting/join', {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(async response => {
                            const contentType = response.headers.get('content-type');
                            let data = null;
                            if (contentType && contentType.includes('application/json')) {
                                data = await response.json();
                            }
                            if (data && data.status === 'valid') {
                                window.location.reload();
                            } else if (data && data.status == 'sold') {
                                window.location.href = '/waiting/sold';
                            } else {
                                window.location.reload();
                            }
                        });
                    });
                }
            });
            
            function waitingRoom(hasUserAction) {
                return {
                    isActive: false,
                    hasAction: hasUserAction,
                    countdown: 5,
                    countdownCircle: null,
                    countdownNumber: null,
                    
                    initStars() {
                        // Create stars
                        const starsContainer = document.createElement('div');
                        starsContainer.className = 'stars';
                        document.body.appendChild(starsContainer);
                        
                        // Create background pattern
                        const pattern = document.createElement('div');
                        pattern.className = 'bg-pattern';
                        document.body.appendChild(pattern);
                        
                        // Create stars
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

                        // Initialize countdown timer elements
                        this.countdownCircle = document.getElementById('countdown-circle');
                        this.countdownNumber = document.getElementById('countdown-number');
                        
                        // Start fetching queue status
                        if (this.hasAction) {
                            this.fetchQueueStatus();
                            setInterval(() => this.fetchQueueStatus(), 7000);
                        }

                        this.handlePageExit();
                    },

                    handlePageExit() {
                        window.addEventListener('beforeunload', (event) => {
                            // Only send the abandonment request if user is in queue
                            if (this.hasAction && !this.isActive) {
                                // Use sendBeacon for more reliable delivery when page is unloading
                                navigator.sendBeacon('/waiting/abandon', JSON.stringify({
                                    session_id: '{{ $session_id }}'
                                }));
                            }
                        });
                    },

                    fetchQueueStatus() {
                        fetch('/waiting/status')
                            .then(response => response.json())
                            .then(data => {
                                // Redirect if tickets are sold out
                                if (data && data.status === 'sold') {
                                    window.location.href = '/waiting/sold';
                                    return;
                                }
                                // Only update queue info if we're not in the active state
                                if (!this.isActive) {
                                    const waitTimeEl = document.getElementById('wait-time');
                                    const positionEl = document.getElementById('queue-position');
                                    const progressBarEl = document.getElementById('progress-bar');
                                    const remainingTicketsEl = document.getElementById('remaining-tickets');

                                    if (remainingTicketsEl) {
                                        remainingTicketsEl.textContent = data.remainingTickets !== undefined 
                                            ? data.remainingTickets 
                                            : 'N/A';
                                    }
                                    
                                    if (waitTimeEl && positionEl && progressBarEl) {
                                        const position = parseInt(data.position) || 0;
                                        const total = parseInt(data.total) || 100;

                                        // Use originPosition as minimum, 1 as maximum
                                        const originPosition = {{ $originPosition }};
                                        const min = originPosition;
                                        const max = 1;

                                        // Clamp position between min and max for progress calculation
                                        const clampedPosition = Math.max(max, Math.min(position, min));
                                        // Progress: 100% if position == max (1), 0% if position == min (originPosition)
                                        const progress = ((min - clampedPosition) / (min - max)) * 100;

                                        if (data.estimatedTime !== undefined && data.estimatedTime < 10) {
                                            waitTimeEl.textContent = '< 10 Minutes';
                                        } else {
                                            waitTimeEl.textContent = (data.estimatedTime !== undefined && data.estimatedTime !== null)
                                                ? data.estimatedTime + ' Minutes'
                                                : 'N/A';
                                        }
                                        positionEl.textContent = position ?? 'N/A';
                                        progressBarEl.style.width = `${progress}%`;
                                        progressBarEl.textContent = progress > 90 ? 'Almost there!' : '✨';
                                    }

                                    // Instead of immediate redirect, set active state
                                    if (data && data.status === 'active') {
                                        console.log("Activating transition screen!");
                                        this.isActive = true;
                                        this.startCountdown();
                                    }
                                }
                            })
                            .catch(err => {
                                console.error("Error fetching queue status:", err);
                                if (!this.isActive) {
                                    const waitTimeEl = document.getElementById('wait-time');
                                    const positionEl = document.getElementById('queue-position');
                                    if (waitTimeEl) waitTimeEl.textContent = 'Error';
                                    if (positionEl) positionEl.textContent = 'Error';
                                }
                            });
                    },

                    startCountdown() {
                        console.log("Starting countdown");
                        // Set initial countdown values
                        this.countdown = 5;
                        
                        if (this.countdownNumber) {
                            this.countdownNumber.textContent = this.countdown;
                        }
                        
                        if (this.countdownCircle) {
                            // The circumference of the circle (2πr)
                            const circumference = 2 * Math.PI * 45;
                            this.countdownCircle.style.strokeDasharray = circumference;
                            this.countdownCircle.style.strokeDashoffset = '0';
                        }
                        
                        // Start countdown timer
                        const intervalId = setInterval(() => {
                            this.countdown--;
                            
                            if (this.countdownNumber) {
                                this.countdownNumber.textContent = this.countdown;
                            }
                            
                            if (this.countdownCircle) {
                                // Calculate dashoffset based on remaining time
                                const circumference = 2 * Math.PI * 45;
                                const offset = circumference * (1 - this.countdown / 5);
                                this.countdownCircle.style.strokeDashoffset = offset;
                            }
                            
                            if (this.countdown <= 0) {
                                clearInterval(intervalId);
                                // Redirect after countdown
                                window.location.href = '{{ route('pesan') }}';
                            }
                        }, 1000);
                    }
                }
            }
        </script>
    </div>
</body>
</html>
