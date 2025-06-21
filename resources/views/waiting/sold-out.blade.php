<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🎟️ Sold Out</title>
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
        
        /* Animation for sold out icon */
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }
        
        .shake-animation {
            animation: shake 0.8s ease-in-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#2e0705] to-[#060604] min-h-screen flex items-center justify-center" 
      x-data="{
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
        }
      }" 
      x-init="initStars()">
      
    <div class="bg-pattern"></div>
    <div class="stars"></div>

    <div class="w-full max-w-md mx-auto bg-[#18181b]/80 shadow-2xl rounded-3xl p-8 border border-yellow-500/30 relative overflow-hidden" 
         data-aos="fade-up" data-aos-duration="1200">
        <div class="absolute -top-8 -right-8 text-yellow-400 text-6xl opacity-10">
            🎟️
        </div>

        <div class="text-center space-y-6 animate-fade-in">
            <!-- Sold Out Message -->
            <div class="text-5xl font-extrabold text-yellow-400 font-fancy shake-animation" data-aos="fade-down" data-aos-duration="1500">Sold Out!</div>
            <h1 class="text-2xl font-bold text-yellow-100">Thank You for Your Enthusiasm</h1>
            
            <div class="flex justify-center my-6">
                <div class="w-24 h-24 bg-[#18181b]/60 rounded-full flex items-center justify-center border border-yellow-500/30">
                    <i class="fas fa-ticket-alt text-4xl text-yellow-400/80"></i>
                </div>
            </div>
            
            <p class="text-yellow-100/80 leading-relaxed">
                We're sorry, but all available tickets have been sold
            </p>
            
            <div class="p-3 bg-[#18181b]/60 rounded-lg border border-yellow-500/30 inline-block" data-aos="fade-up" data-aos-duration="700">
                <i class="fas fa-calendar-alt mr-2 text-yellow-200"></i>
                <span class="text-yellow-200">Check back next time!</span>
            </div>
            
            <a href="/" 
               class="hover-bouncing-dikit bg-yellow-400 hover:bg-yellow-600 transition-all duration-300 text-white font-semibold px-6 py-3 rounded-full shadow-lg inline-block mt-4">
                <i class="fas fa-home mr-2"></i> Back to Homepage
            </a>
            
            <div class="mt-8 pt-6 border-t border-yellow-600/20" data-aos="fade-up" data-aos-delay="500">
                <div class="flex justify-center space-x-4">
                    <a href="https://instagram.com/casinodelamour" class="text-yellow-400 hover:text-yellow-300">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
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
            });
        </script>
    </div>
</body>
</html>