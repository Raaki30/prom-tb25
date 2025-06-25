@php
    use Illuminate\Support\Facades\Session;
    use App\Models\WaitingRoom;
    $session_id = Session::getId();
    $hasAction = WaitingRoom::where('session_id', $session_id)->exists();
    $originPosition = Session::get('origin_position', 0);
    $stats = Session::get('action');
    
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beli Tiket - Prom Casino De Lamour</title>
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
        
        /* Animation for position changes */
        @keyframes highlight-change {
            0% { transform: scale(1); color: #eab308; }
            50% { transform: scale(1.2); color: #ffc107; }
            100% { transform: scale(1); color: #eab308; }
        }

        .highlight-change {
            animation: highlight-change 1s ease;
        }
        
        /* Low ticket warning */
        .tickets-low {
            animation: pulse-red 1.5s infinite;
        }
        
        @keyframes pulse-red {
            0%, 100% { color: #eab308; }
            50% { color: #ef4444; }
        }
        
        /* Progress bar animations */
        .progress-bar-animated {
            background-size: 30px 30px;
            background-image: linear-gradient(
                45deg,
                rgba(255, 255, 255, 0.15) 25%,
                transparent 25%,
                transparent 50%,
                rgba(255, 255, 255, 0.15) 50%,
                rgba(255, 255, 255, 0.15) 75%,
                transparent 75%,
                transparent
            );
            animation: progress-bar-stripes 1s linear infinite;
        }
        
        @keyframes progress-bar-stripes {
            0% { background-position: 0 0; }
            100% { background-position: 30px 0; }
        }
        
        /* Connection error indicator */
        .connection-error {
            border: 2px solid #ef4444;
            animation: pulse-border 1.5s infinite;
        }
        
        @keyframes pulse-border {
            0%, 100% { border-color: #ef4444; }
            50% { border-color: #fee2e2; }
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
        
         <!-- MODAL TANDA MASUK WAITING ROOM -->
        <div id="couplePopup" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-md" id="popupOverlay"></div>
            <div class="relative mx-auto flex max-w-md flex-col gap-4 rounded-2xl border border-yellow-600/30 bg-[#18181b] p-8 text-left font-medium text-white shadow-lg transform transition-all duration-300 scale-95 opacity-0"
                style="box-shadow: 0 8px 32px 0 rgba(234, 179, 8, 0.15);" id="popupContent">
                <button class="absolute right-4 top-4 text-white hover:text-yellow-400 transition-colors" id="closePopup" aria-label="Tutup">
                    <i class="fas fa-times text-xl"></i>
                </button>
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100">
                        <i class="fa-solid fa-hourglass-half text-2xl text-yellow-600"></i>
                    </div>
                    <p class="font-fancy text-3xl text-yellow-400">
                        Mohon Tunggu
                    </p>
                </div>
                <h3 class="text-xl font-semibold text-yellow-300 mt-2">Sistem Sedang Ramai</h3>
                <p class="text-base text-yellow-100">
                    Karena banyaknya pengunjung, Anda kami alihkan ke <span class="font-bold text-yellow-400">waiting room</span> agar proses pembelian tiket tetap adil dan lancar.<br>
                    Silakan tunggu sebentar, Anda akan segera masuk ke antrian.
                </p>
                <button id="confirmPopupClose" class="mt-4 inline-block self-start rounded-xl bg-yellow-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-yellow-600">
                    Mengerti
                </button>
            </div>
        </div>
        

        <div x-show="!isActive && !hasAction" class="text-center space-y-6 animate-fade-in">
            <!-- Join Waiting Room -->
            <div class="text-5xl font-extrabold text-yellow-400 font-fancy cute-icon" data-aos="fade-down" data-aos-duration="1500">Welcome!</div>
            <h1 class="text-2xl font-bold text-yellow-100">Udah Siap Belum Beli Tiketnya?</h1>
            <p class="text-yellow-100/80 leading-relaxed">
                Sebelum lanjut beli tiket, yuk kita cek dulu ketersediaannya di sistem ✨
            </p>
            <button 
                id="join-queue-btn" 
                class="hover-bouncing-dikit bg-yellow-400 hover:bg-yellow-600 transition-all duration-300 text-white font-semibold px-6 py-3 rounded-full shadow-lg"
            >
                <i class="fas fa-door-open mr-2"></i> Cek Ketersediaan
            </button>
        </div>

        <div x-show="!isActive && hasAction" class="text-center space-y-6 animate-fade-in" id="waiting-room">
            <!-- In Queue -->
            <div class="text-5xl font-extrabold text-yellow-400 font-fancy cute-icon" data-aos="fade-down" data-aos-duration="1500">Hold Tight!</div>
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
                <span class="select-all bg-yellow-900/30 px-2 py-1 rounded">{{ $session_id }}</span>
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
            <p class="text-yellow-200 text-xs mt-2">
                <i class="fas fa-clock mr-1"></i>
                Setelah masuk, Anda harus menyelesaikan pesanan dalam waktu <span class="font-semibold text-yellow-400">10 menit</span> sebelum tiket Anda dilepas kembali.
            </p>
            </div>
            
            <div class="mt-6 flex justify-center space-x-2 fade-in-up" style="animation-delay: 0.9s">
            <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse" style="animation-delay: 0s;"></span>
            <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse" style="animation-delay: 0.2s;"></span>
            <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse" style="animation-delay: 0.4s;"></span>
            </div>
        </div>

        <script>
                        // Example JS to show/hide modal (call showModal() when needed)
            function showModal() {
                const popup = document.getElementById('couplePopup');
                const content = document.getElementById('popupContent');
                popup.classList.remove('hidden');
                setTimeout(() => content.classList.remove('scale-95', 'opacity-0'), 10);
            }
            function hideModal() {
                const popup = document.getElementById('couplePopup');
                const content = document.getElementById('popupContent');
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => popup.classList.add('hidden'), 200);
            }
            document.getElementById('closePopup')?.addEventListener('click', hideModal);
            document.getElementById('confirmPopupClose')?.addEventListener('click', hideModal);
            document.getElementById('popupOverlay')?.addEventListener('click', hideModal);
            
            document.addEventListener('DOMContentLoaded', function() {
                // Show the modal if the user is in the waiting room
                
                    // Only show modal if #waiting-room is visible for more than 2 seconds
                    if (@json($stats) === 'hold') {
                        setTimeout(() => {
                            const waitingRoomDiv = document.getElementById('waiting-room');
                            if (waitingRoomDiv && waitingRoomDiv.offsetParent !== null) {
                                showModal();
                            }
                        }, 2000);
                    }
                
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
        lastPosition: null,
        retryCount: 0,
        maxRetries: 5,
        pollingInterval: 7000, // 7 seconds default polling
        
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
                
                // Set up polling with exponential backoff
                this.setupPolling();
            }

            this.handlePageExit();
        },
        
        setupPolling() {
            // Clear any existing interval
            if (this.pollingIntervalId) {
                clearInterval(this.pollingIntervalId);
            }
            
            // Set up new polling interval
            this.pollingIntervalId = setInterval(() => {
                this.fetchQueueStatus();
            }, this.pollingInterval);
        },

        handlePageExit() {
            // Use both beforeunload and visibilitychange for better coverage
            window.addEventListener('beforeunload', this.handleAbandon.bind(this));
            
            // Also handle tab switching/minimizing
            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState === 'hidden' && this.hasAction && !this.isActive) {
                    // Store timestamp when user left
                    localStorage.setItem('waiting_room_left_at', Date.now());
                }
                
                if (document.visibilityState === 'visible') {
                    // Check if user was away for too long
                    const leftAt = parseInt(localStorage.getItem('waiting_room_left_at') || '0');
                    if (leftAt > 0 && Date.now() - leftAt > 5 * 60 * 1000) { // 5 minutes
                        // Force refresh if away too long
                        window.location.reload();
                    } else {
                        // Just update status immediately
                        this.fetchQueueStatus();
                    }
                }
            });
        },
        
        handleAbandon(event) {
            // Only send the abandonment request if user is in queue
            if (this.hasAction && !this.isActive) {
                // Use sendBeacon for more reliable delivery when page is unloading
                navigator.sendBeacon('/waiting/abandon', JSON.stringify({
                    session_id: '{{ $session_id }}'
                }));
            }
        },

        fetchQueueStatus() {
            fetch('/waiting/status')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Reset retry count on successful fetch
                    this.retryCount = 0;
                
                    // Redirect if tickets are sold out
                    if (data && data.status === 'sold') {
                        window.location.href = '/waiting/sold';
                        return;
                    }
                    
                    // Handle active status
                    if (data && data.status === 'active' && !this.isActive) {
                        console.log("Activating transition screen!");
                        this.isActive = true;
                        
                        // Stop polling when active
                        if (this.pollingIntervalId) {
                            clearInterval(this.pollingIntervalId);
                        }
                        
                        this.startCountdown();
                        return;
                    }
                    
                    // Only update queue info if we're not in the active state
                    if (!this.isActive) {
                        const waitTimeEl = document.getElementById('wait-time');
                        const positionEl = document.getElementById('queue-position');
                        const progressBarEl = document.getElementById('progress-bar');
                        const remainingEl = document.getElementById('remaining-tickets');
                        const statsEl = document.getElementById('queue-stats');

                        if (statsEl) {
                            // Add detailed stats if in debug mode
                            statsEl.innerHTML = `
                                <span class="text-xs">Active: ${data.active}/${data.waitingLimit}</span>
                                <span class="text-xs ml-2">Completed: ${data.completed}/${data.saleLimit}</span>
                            `;
                        }

                        // Update remaining tickets indicator
                        if (remainingEl) {
                            remainingEl.textContent = data.remainingTickets !== undefined 
                                ? data.remainingTickets 
                                : 'N/A';
                                
                            // Add visual indication if tickets are running low
                            if (data.remainingTickets < 10) {
                                remainingEl.classList.add('text-red-400', 'animate-pulse');
                            } else {
                                remainingEl.classList.remove('text-red-400', 'animate-pulse');
                            }
                        }
                        
                        // Update wait time and position
                        if (waitTimeEl && positionEl && progressBarEl) {
                            const position = parseInt(data.position) || 0;
                            const total = parseInt(data.total) || 100;
                            
                            // Animate position change
                            if (this.lastPosition !== null && this.lastPosition !== position) {
                                positionEl.classList.add('highlight-change');
                                setTimeout(() => {
                                    positionEl.classList.remove('highlight-change');
                                }, 1000);
                            }
                            this.lastPosition = position;

                            // Use originPosition as minimum, 1 as maximum
                            const originPosition = {{ $originPosition ?? 0 }};
                            const min = originPosition || 100;
                            const max = 1;

                            // Clamp position between min and max for progress calculation
                            const clampedPosition = Math.max(max, Math.min(position, min));
                            
                            // Progress: 100% if position == max (1), 0% if position == min (originPosition)
                            const progress = ((min - clampedPosition) / (min - max)) * 100;

                            // Format estimated wait time with better wording
                            if (data.estimatedTime !== undefined) {
                                if (data.estimatedTime === 0) {
                                    waitTimeEl.textContent = 'You\'re next!';
                                    waitTimeEl.classList.add('text-green-400');
                                } else if (data.estimatedTime < 1) {
                                    waitTimeEl.textContent = 'Less than a minute';
                                    waitTimeEl.classList.remove('text-green-400');
                                } else {
                                    waitTimeEl.textContent = `~${data.estimatedTime} ${data.estimatedTime === 1 ? 'minute' : 'minutes'}`;
                                    waitTimeEl.classList.remove('text-green-400');
                                }
                            } else {
                                waitTimeEl.textContent = 'Calculating...';
                            }
                            
                            // Position indicator
                            positionEl.textContent = position ?? 'N/A';
                            
                            // Progress bar with adaptive messaging
                            progressBarEl.style.width = `${Math.max(5, progress)}%`; // Minimum 5% width for visibility
                            
                            if (progress > 90) {
                                progressBarEl.textContent = 'Almost there!';
                                progressBarEl.classList.add('font-bold');
                            } else if (progress > 70) {
                                progressBarEl.textContent = 'Getting closer!';
                                progressBarEl.classList.remove('font-bold');
                            } else if (progress > 40) {
                                progressBarEl.textContent = 'Making progress...';
                                progressBarEl.classList.remove('font-bold');
                            } else {
                                progressBarEl.textContent = '✨';
                                progressBarEl.classList.remove('font-bold');
                            }
                            
                            // Adapt polling frequency based on position
                            if (position <= 10) {
                                this.pollingInterval = 3000; // Poll faster when close to front
                                this.setupPolling();
                            } else if (position <= 50) {
                                this.pollingInterval = 5000; // Medium frequency
                                this.setupPolling();
                            } else {
                                this.pollingInterval = 7000; // Default frequency
                            }
                        }
                    }
                })
                .catch(err => {
                    console.error("Error fetching queue status:", err);
                    
                    // Increment retry count
                    this.retryCount++;
                    
                    if (this.retryCount <= this.maxRetries) {
                        // Exponential backoff for retries (3s, 6s, 12s, etc.)
                        const backoffTime = Math.min(15000, 3000 * Math.pow(2, this.retryCount - 1));
                        
                        console.log(`Retrying in ${backoffTime/1000} seconds... (Attempt ${this.retryCount} of ${this.maxRetries})`);
                        
                        // Try again after backoff period
                        setTimeout(() => this.fetchQueueStatus(), backoffTime);
                    } else {
                        // Show error message after max retries
                        const waitTimeEl = document.getElementById('wait-time');
                        const positionEl = document.getElementById('queue-position');
                        if (waitTimeEl) waitTimeEl.textContent = 'Connection error';
                        if (positionEl) positionEl.textContent = 'Please refresh';
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