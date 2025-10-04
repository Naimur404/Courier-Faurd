<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5TNKX5N9');
    </script>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MW75LTD9PG"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-MW75LTD9PG');
</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FraudShield - বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Courier Fraud Detection')</title>
    <meta name="description" content="@yield('description', 'বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।')">
    <meta name="keywords" content="@yield('keywords', 'courier fraud bangladesh, fraud detection system, bangladeshi courier check, courier ফ্রড, কুরিয়ার ফ্রড চেক, কুরিয়ার নাম্বার চেক, courier check bangladesh')">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="@yield('og_url', 'https://fraudshieldbd.site')">
    <meta property="og:title" content="@yield('og_title', 'FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Bangladesh Courier Fraud Detection')">
    <meta property="og:description" content="@yield('og_description', 'মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন। বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম।')">
    <meta property="og:image" content="{{asset('assets/banner.jpg')}}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="{{asset('assets/banner.jpg')}}">
    <meta property="twitter:url" content="@yield('twitter_url', 'https://fraudshieldbd.site')">
    <meta property="twitter:title" content="@yield('twitter_title', 'FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Bangladesh Courier Fraud Detection')">
    <meta property="twitter:description" content="@yield('twitter_description', 'মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন। বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম।')">
    <meta property="twitter:image" content="{{asset('assets/banner.jpg')}}">
    
    <!-- Canonical URL -->
    <meta rel="canonical" href="@yield('canonical', 'https://fraudshieldbd.site')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('assets/favicon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('assets/favicon.png')}}">
    
    <!-- Structured Data -->
    @yield('structured_data')
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    @yield('additional_head_scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #f97316;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-color: #f9fafb;
            --dark-color: #111827;
        }
        
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }
        
        /* Comprehensive Dark Mode Styles */
        .dark {
            color: #f3f4f6;
        }
        
        .dark .bg-white, .dark .bg-gray-50 {
            background-color: #1f2937;
            color: #f3f4f6;
        }
        
        .dark .border-gray-200 {
            border-color: #4b5563;
        }
        
        .dark .text-gray-600, .dark .text-gray-800 {
            color: #d1d5db !important;
        }
        
        .dark .text-gray-500 {
            color: #9ca3af !important;
        }
        
        .dark .text-gray-400 {
            color: #9ca3af !important;
        }
        
        .dark .bg-gray-100 {
            background-color: #374151;
        }
        
        .dark .bg-green-100 {
            background-color: rgba(16, 185, 129, 0.15);
        }
        
        .dark .bg-yellow-100 {
            background-color: rgba(245, 158, 11, 0.15);
        }
        
        .dark .bg-red-100 {
            background-color: rgba(239, 68, 68, 0.15);
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.7);
        }
        
        .dark .glass-effect {
            background-color: rgba(31, 41, 55, 0.7);
        }

        .shadow-custom {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .gradient-text {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hover-scale {
            transition: transform 0.3s ease-in-out;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }

        .animate-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Additional Dark Mode Text Fixes */
        .dark h1, .dark h2, .dark h3, .dark h4, .dark h5, .dark h6 {
            color: #f3f4f6;
        }
        
        .dark p {
            color: #d1d5db;
        }
        
        .dark .text-indigo-200 {
            color: #c7d2fe !important;
        }
        
        .dark .text-indigo-600 {
            color: #818cf8 !important;
        }
        
        .dark .text-purple-600 {
            color: #a78bfa !important;
        }
        
        .dark .text-blue-600 {
            color: #60a5fa !important;
        }
        
        .dark .text-green-600 {
            color: #34d399 !important;
        }
        
        .dark .text-orange-600 {
            color: #fb923c !important;
        }
        
        .dark .text-red-600 {
            color: #f87171 !important;
        }

        /* Why section dark mode */
        .dark .bg-white.rounded-xl.shadow-custom {
            background-color: #1f2937;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        }
        
        .dark .border.border-gray-200 {
            border-color: #4b5563;
            background-color: #374151;
        }
        
        .dark .bg-indigo-100 {
            background-color: rgba(99, 102, 241, 0.15);
        }
        
        .dark .text-indigo-600 {
            color: #818cf8 !important;
        }
        
        .dark .bg-gray-50.dark\:bg-gray-700 {
            background-color: #374151;
        }
        
        /* Footer dark mode improvements */
        .dark .text-white\/70 {
            color: rgba(243, 244, 246, 0.7) !important;
        }
        
        /* Link colors in dark mode */
        .dark a {
            color: #60a5fa;
        }
        
        .dark a:hover {
            color: #93c5fd;
        }
        
        /* Form elements additional fixes */
        .dark .rounded-lg {
            border-color: #4b5563;
        }
        
        /* Ensure all text elements are visible */
        .dark .text-yellow-400 {
            color: #fbbf24 !important;
        }
        
        .dark .text-yellow-500 {
            color: #f59e0b !important;
        }

        @yield('additional_styles')
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen text-gray-800 dark:bg-gray-900 dark:text-gray-100">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5TNKX5N9"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    
    <!-- Header -->
    <header class="bg-white shadow-lg py-4 sticky top-0 z-50 glass-effect dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white w-10 h-10 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="text-xl font-bold">
                        <a href="{{ url('/') }}">
                            <span class="gradient-text">Fraud</span>
                            <span class="text-gray-800 dark:text-white">Shield</span>
                        </a>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('/') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                        <i class="fas fa-home mr-1"></i>হোম
                    </a>
                    <a href="{{ url('/about') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('about') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                        <i class="fas fa-info-circle mr-1"></i>আমাদের সম্পর্কে
                    </a>
                    <a href="{{ route('pricing') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('pricing') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                        <i class="fas fa-tags mr-1"></i>প্রাইসিং
                    </a>
                    <a href="{{ route('download.page') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('download') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                        <i class="fas fa-download mr-1"></i>অ্যাপ ডাউনলোড
                    </a>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-cog mr-1"></i>Admin
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('dashboard*') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                            </a>
                        @endif
                        
                        <!-- User Dropdown -->
                        <div class="relative group">
                            <button class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center focus:outline-none focus:ring-2 focus:ring-indigo-500" onclick="toggleDropdown(event)">
                                <i class="fas fa-user mr-1"></i>{{ auth()->user()->name }}
                                <i class="fas fa-chevron-down ml-1 text-xs transition-transform" id="dropdown-arrow"></i>
                            </button>
                            <div id="user-dropdown" class="absolute right-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 hidden border border-gray-200 dark:border-gray-600">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2 text-red-500"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Direct Logout Button (Alternative) -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 px-3 py-2 rounded-md text-sm font-medium transition-colors" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-sign-in-alt mr-1"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-user-plus mr-1"></i>Register
                        </a>
                    @endauth
                    
                    <button id="themeToggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300 focus:outline-none text-gray-800 dark:text-gray-200">
                        <i class="fas fa-moon dark:hidden text-gray-800"></i>
                        <i class="fas fa-sun hidden dark:inline text-gray-200"></i>
                    </button>
                </div>

                <!-- Mobile Navigation Button -->
                <div class="md:hidden flex items-center gap-2">
                    <button id="themeToggleMobile" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300 focus:outline-none text-gray-800 dark:text-gray-200">
                        <i class="fas fa-moon dark:hidden text-gray-800"></i>
                        <i class="fas fa-sun hidden dark:inline text-gray-200"></i>
                    </button>
                    <button id="mobileMenuToggle" class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobileMenu" class="md:hidden hidden mt-4 pb-4 border-t border-gray-200 dark:border-gray-600">
                <div class="flex flex-col space-y-2 pt-4">
                    <a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('/') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900' : '' }}">
                        <i class="fas fa-home mr-2"></i>হোম
                    </a>
                    <a href="{{ url('/about') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('about') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900' : '' }}">
                        <i class="fas fa-info-circle mr-2"></i>আমাদের সম্পর্কে
                    </a>
                    <a href="{{ route('pricing') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('pricing') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900' : '' }}">
                        <i class="fas fa-tags mr-2"></i>প্রাইসিং
                    </a>
                    <a href="{{ route('download.page') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('download') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900' : '' }}">
                        <i class="fas fa-download mr-2"></i>অ্যাপ ডাউনলোড
                    </a>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-cog mr-2"></i>Admin Panel
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('dashboard*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900' : '' }}">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        @endif
                        
                        <div class="border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                            <p class="px-3 py-1 text-xs text-gray-500 dark:text-gray-400">Logged in as: {{ auth()->user()->name }}</p>
                            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="w-full text-left text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900 px-3 py-2 rounded-md text-sm font-medium transition-colors border border-red-200 dark:border-red-700 mx-3">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                            <a href="{{ route('register') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-user-plus mr-2"></i>Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-indigo-800 to-purple-800 text-white py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="bg-white text-indigo-600 w-10 h-10 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="text-xl font-bold">
                            <span class="text-white">Fraud</span><span class="text-yellow-400">Shield</span>
                        </div>
                    </div>
                    <p class="text-sm text-indigo-200 mb-4">উন্নত ফ্রড ডিটেকশন সিস্টেম কুরিয়ার সেবার জন্য। আপনার ব্যবসাকে সম্ভাব্য ফ্রড থেকে রক্ষা করুন।</p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-white hover:text-yellow-400 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-white hover:text-yellow-400 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-white hover:text-yellow-400 transition duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">দ্রুত লিংক</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-indigo-200 hover:text-white transition duration-300">হোম</a></li>
                        <li><a href="{{ url('/about') }}" class="text-indigo-200 hover:text-white transition duration-300">আমাদের সম্পর্কে</a></li>
                        <li><a href="{{ route('download.page') }}" class="text-indigo-200 hover:text-white transition duration-300">অ্যাপ ডাউনলোড</a></li>
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">প্রাইসিং</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">রিসোর্স</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">ডকুমেন্টেশন</a></li>
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">সাহায্য কেন্দ্র</a></li>
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">গোপনীয়তা নীতি</a></li>
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">সেবার শর্তাবলী</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">যোগাযোগ</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2 text-yellow-400"></i>
                            <span class="text-indigo-200">চট্টগ্রাম, বাংলাদেশ</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-2 text-yellow-400"></i>
                            <span class="text-indigo-200">info@fraudshield.com</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-2 text-yellow-400"></i>
                            <span class="text-indigo-200">+৮৮০১৩০৯০৯২৭৪৮</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-indigo-700 mt-8 pt-6 text-center text-indigo-200">
                <p>© ২০২৫ FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। সকল অধিকার সংরক্ষিত Tyrodevs.com</p>
            </div>
        </div>
    </footer>

    <!-- Floating Download Button -->
    <div class="fixed bottom-8 right-8 z-50">
        <a href="{{ route('download.page') }}" class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-3 rounded-full font-semibold hover:shadow-lg hover:opacity-90 transition duration-300 shadow-xl animate-pulse">
          <i class="fas fa-download"></i>
          <span>অ্যাপ ডাউনলোড করুন</span>
        </a>
    </div>

    <!-- Google Tag Manager (noscript) -->
    <!-- End Google Tag Manager (noscript) -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Theme Toggle Functionality
        const themeToggle = document.getElementById('themeToggle');
        const themeToggleMobile = document.getElementById('themeToggleMobile');
        
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', toggleTheme);
        }
        if (themeToggleMobile) {
            themeToggleMobile.addEventListener('click', toggleTheme);
        }

        // Set initial theme based on local storage or system preference
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Mobile Menu Toggle Functionality
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                
                // Update hamburger icon
                const icon = mobileMenuToggle.querySelector('svg');
                if (mobileMenu.classList.contains('hidden')) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                } else {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                }
            });

            // Close mobile menu when clicking on a link
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    const icon = mobileMenuToggle.querySelector('svg');
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                });
            });
        }

        // User Dropdown Toggle Functionality
        function toggleDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('user-dropdown');
            const arrow = document.getElementById('dropdown-arrow');
            
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                dropdown.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('user-dropdown');
            const arrow = document.getElementById('dropdown-arrow');
            
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        });

        // Bengali number conversion
        function convertToBengaliNumbers(number) {
            const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
            return number.toString().replace(/\d/g, digit => bengaliDigits[parseInt(digit)]);
        }

        // Function to format number with commas and convert to Bengali
        function formatBengaliNumber(number) {
            const formattedNumber = Math.round(number).toLocaleString('en-US');
            return convertToBengaliNumbers(formattedNumber);
        }

        // Add smooth scrolling for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>