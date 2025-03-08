<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('assets/favicon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('assets/favicon.png')}}">
    <title>Download FraudShield App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f3effb',
                            100: '#e9e0f8',
                            200: '#d4c2f1',
                            300: '#bfa4e9',
                            400: '#a986e1',
                            500: '#9469d9',
                            600: '#8257e6', // Main primary
                            700: '#6e43c0',
                            800: '#5b42b5',
                            900: '#473790',
                        },
                        dark: {
                            50: '#f7f7f7',
                            100: '#e3e3e3',
                            200: '#c8c8c8',
                            300: '#a4a4a4',
                            400: '#818181',
                            500: '#666666',
                            600: '#515151',
                            700: '#434343',
                            800: '#383838',
                            850: '#282828',
                            900: '#1e1e1e',
                            950: '#121212',
                        },
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    },
                    boxShadow: {
                        'glow': '0 0 15px rgba(130, 87, 230, 0.5), 0 0 30px rgba(130, 87, 230, 0.2)',
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.15)',
                    },
                    backdropBlur: {
                        xs: '2px',
                    },
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-gradient-primary {
                @apply bg-gradient-to-r from-primary-800 to-primary-600;
            }
            .border-gradient {
                border-image: linear-gradient(to right, theme('colors.primary.600'), theme('colors.primary.400')) 1;
            }
            .glass-effect {
                @apply bg-dark-900/80 backdrop-blur-md border border-white/10 shadow-glass;
            }
            .glass-card {
                @apply bg-dark-850/80 backdrop-blur-md border border-white/5 shadow-glass rounded-2xl;
            }
            .card-hover {
                @apply transition-all duration-300 hover:shadow-glow hover:-translate-y-1;
            }
        }
    </style>
</head>
<body class="bg-dark-950 text-gray-100 min-h-screen">
    <!-- Home button -->
  
    
    <!-- Hero Section with gradient background -->
    <section class="relative overflow-hidden">
        
        <!-- Top gradient background -->
        <div class="absolute inset-0 bg-gradient-to-b from-primary-800/20 to-transparent pointer-events-none"></div>
    
        <!-- Animated background elements -->
        <div class="absolute top-20 left-10 w-64 h-64 bg-primary-600/10 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-primary-800/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1s;"></div>
        <div class="bg-dark-950 py-3 px-4 flex justify-center">
            <a href="https://courier-fraud.laravel.cloud" class="flex items-center gap-2 px-5 py-1.5 text-sm font-medium text-white bg-white/10 rounded-full transition-all duration-300 hover:bg-white/20">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
        </div>
        <!-- Hero content -->
        <div class="relative container mx-auto px-4 pt-24 pb-64 text-center">
          
            <div class="flex flex-col items-center">
                <!-- App logo -->
                <div class="relative mb-6 animate-float">
                    <div class="absolute inset-0 bg-primary-600/30 rounded-3xl blur-xl"></div>
                    <img src="{{asset('assets/banner.jpg')}}" alt="FraudShield Logo" class="relative w-24 h-24 object-cover rounded-2xl border-2 border-white/20 shadow-lg">
                </div>
                
                <h1 class="text-4xl md:text-5xl font-bold mb-3 text-white">FraudShield</h1>
                <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10">
                    কুরিয়ার ফ্রড ডিটেকশন সিস্টেম - ডেলিভারি ইতিহাস দেখুন এবং বিশ্বসযোগ্যতা যাচাই করুন
                </p>
            </div>
        </div>
    </section>
    
    <!-- Device Showcase Section -->
    <section class="relative -mt-52 mb-24">
        <div class="container mx-auto px-4">
            <div class="relative h-[500px] md:h-[580px] overflow-visible">
                <!-- Devices will be positioned with JavaScript -->
                <div id="device-1" class="device absolute w-[250px] md:w-[270px] rounded-[36px] overflow-hidden shadow-2xl bg-dark-950 border-[10px] border-dark-800 transition-all duration-500" style="left: 25%; transform: translateX(-50%) scale(0.8); top: 0;">
                    <div class="device-screen w-full h-full rounded-[28px] overflow-hidden">
                        <img src="{{asset('assets/Sc1.png')}}" alt="FraudShield Screenshot 1" class="w-full h-full object-cover">
                    </div>
                </div>
                
                <div id="device-2" class="device absolute w-[250px] md:w-[270px] rounded-[36px] overflow-hidden shadow-2xl bg-dark-950 border-[10px] border-dark-800 transition-all duration-500 z-10" style="left: 50%; transform: translateX(-50%) scale(1); top: 0;">
                    <div class="device-screen w-full h-full rounded-[28px] overflow-hidden">
                        <img src="{{asset('assets/Sc2.png')}}" alt="FraudShield Screenshot 2" class="w-full h-full object-cover">
                    </div>
                </div>
                
                <div id="device-3" class="device absolute w-[250px] md:w-[270px] rounded-[36px] overflow-hidden shadow-2xl bg-dark-950 border-[10px] border-dark-800 transition-all duration-500" style="left: 75%; transform: translateX(-50%) scale(0.8); top: 0;">
                    <div class="device-screen w-full h-full rounded-[28px] overflow-hidden">
                        <img src="{{asset('assets/Sc3.png')}}" alt="FraudShield Screenshot 3" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Clear Download Action Area -->
    <section class="mb-20">
        <div class="container mx-auto px-4">
            <div class="glass-card p-10 text-center relative overflow-hidden max-w-3xl mx-auto">
                <!-- Background glow effect -->
                <div class="absolute -inset-x-10 -bottom-10 h-40 bg-primary-600/10 blur-3xl"></div>
                
                <h2 class="text-2xl font-bold mb-4 text-white">Download Our Mobile App Now</h2>
                <p class="text-gray-300 mb-8 max-w-lg mx-auto">
                    Experience the best courier fraud detection system with our FraudShield mobile application
                </p>
                
                <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                    <div class="flex-1">
                        <button id="downloadBtn" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-white bg-primary-600 rounded-full overflow-hidden transition-all duration-300 hover:bg-primary-700 hover:shadow-glow active:scale-95">
                            <span class="relative z-10 flex items-center">
                                <svg id="spinner" class="hidden w-5 h-5 mr-3 -ml-1 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <i class="fas fa-download mr-2"></i>
                                Download APK
                            </span>
                            
                            <!-- Button hover effect -->
                            <span class="absolute inset-0 overflow-hidden rounded-full">
                                <span class="absolute inset-0 rounded-full bg-gradient-to-r from-primary-400/40 to-primary-600/40 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>
                            </span>
                        </button>
                    </div>
                    
                    <div class="flex-1 flex flex-col items-center">
                        <div class="p-2 bg-white rounded-xl mb-3 transform transition hover:rotate-3 hover:scale-105 duration-300">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode(route('download.apk2')) }}" 
                                 alt="QR Code for Download" class="w-32 h-32">
                        </div>
                        <p class="text-gray-400 text-sm">Or scan this QR code with your device</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="mb-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass-card p-8 card-hover">
                    <div class="flex flex-col items-center justify-center h-full">
                        <span class="text-4xl md:text-5xl font-bold text-primary-500 mb-2">{{ number_format($downloadCount) }}</span>
                        <span class="text-lg text-gray-300">Total Downloads</span>
                    </div>
                </div>
                
                <div class="glass-card p-8 card-hover">
                    <div class="flex flex-col items-center justify-center h-full">
                        <span class="text-lg text-gray-300 mb-2">Last Download</span>
                        <span class="text-2xl md:text-3xl font-bold text-primary-500">{{ $lastDownloadTime ?? 'No downloads yet' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="mb-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-white">
                <span class="inline-block relative">
                    Key Features
                    <span class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-primary-600 to-primary-400"></span>
                </span>
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass-card p-6 card-hover flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-600/20 flex items-center justify-center">
                        <i class="fas fa-shield-alt text-xl text-primary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-1">Courier Fraud Detection</h3>
                        <p class="text-gray-400 text-sm">Identify and prevent courier fraud with our advanced detection system</p>
                    </div>
                </div>
                
                <div class="glass-card p-6 card-hover flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-600/20 flex items-center justify-center">
                        <i class="fas fa-history text-xl text-primary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-1">Delivery History Check</h3>
                        <p class="text-gray-400 text-sm">View complete delivery history and track courier reliability</p>
                    </div>
                </div>
                
                <div class="glass-card p-6 card-hover flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-600/20 flex items-center justify-center">
                        <i class="fas fa-chart-line text-xl text-primary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-1">Success Rate Analysis</h3>
                        <p class="text-gray-400 text-sm">Check courier success rates and make informed decisions</p>
                    </div>
                </div>
                
                <div class="glass-card p-6 card-hover flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-600/20 flex items-center justify-center">
                        <i class="fas fa-star text-xl text-primary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-1">Customer Feedback System</h3>
                        <p class="text-gray-400 text-sm">Read and share feedback on courier services</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- App benefits -->
    <section class="mb-20">
        <div class="container mx-auto px-4">
            <div class="glass-card p-8 md:p-12 relative overflow-hidden">
                <!-- Background effect -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary-600/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <h2 class="text-2xl md:text-3xl font-bold mb-8 text-center text-white">Why Choose FraudShield?</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 rounded-full bg-primary-600/20 flex items-center justify-center mb-4">
                                <i class="fas fa-bolt text-2xl text-primary-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Fast & Reliable</h3>
                            <p class="text-gray-400">Quick and accurate detection of potential courier fraud</p>
                        </div>
                        
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 rounded-full bg-primary-600/20 flex items-center justify-center mb-4">
                                <i class="fas fa-lock text-2xl text-primary-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Secure</h3>
                            <p class="text-gray-400">Your data is protected with enterprise-grade security</p>
                        </div>
                        
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 rounded-full bg-primary-600/20 flex items-center justify-center mb-4">
                                <i class="fas fa-sync text-2xl text-primary-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Regular Updates</h3>
                            <p class="text-gray-400">Constantly improving with frequent updates and new features</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Version info -->
    <div class="text-center text-gray-500 text-sm mb-12">
        <p>FraudShield v1.0.0 | Last updated: {{ date('F j, Y') }}</p>
    </div>
    
    <!-- Footer -->
    <footer class="bg-gradient-primary py-8 rounded-t-3xl">
        <div class="container mx-auto px-4 text-center">
            <p class="text-white/90">© 2025 FraudShield. All rights reserved.</p>
            <p class="text-white/70 text-sm mt-2">Powered by Tyrodevs.com</p>
        </div>
    </footer>
    
    <script>
        document.getElementById('downloadBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Show loading spinner
            const spinner = document.getElementById('spinner');
            spinner.classList.remove('hidden');
            this.disabled = true;
            
            // First, track the intent
            fetch('{{ route("track.download.intent") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Then initiate the actual download with the tracking ID
                    window.location.href = '{{ route("download.apk") }}?track_id=' + data.track_id;
                    
                    // Reset button after a short delay
                    setTimeout(() => {
                        spinner.classList.add('hidden');
                        this.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Reset button on error
                spinner.classList.add('hidden');
                this.disabled = false;
            });
        });
        
        // Device showcase rotation
        const devices = document.querySelectorAll('.device');
        let currentIndex = 0;
        
        function rotateDevices() {
            currentIndex = (currentIndex + 1) % 3;
            
            const positions = [
                { left: '25%', scale: 0.8, zIndex: 1 },
                { left: '50%', scale: 1, zIndex: 10 },
                { left: '75%', scale: 0.8, zIndex: 1 }
            ];
            
            devices.forEach((device, index) => {
                const position = (index - currentIndex + 3) % 3;
                device.style.transform = `translateX(-50%) scale(${positions[position].scale})`;
                device.style.left = positions[position].left;
                device.style.zIndex = positions[position].zIndex;
            });
        }
        
        setInterval(rotateDevices, 3000);
    </script>
</body>
</html>