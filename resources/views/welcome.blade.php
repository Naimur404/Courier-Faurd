<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5TNKX5N9');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FraudShield - বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Courier Fraud Detection</title>
    <meta name="description" content="বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।">
    <meta name="keywords" content="courier fraud bangladesh, fraud detection system, bangladeshi courier check, courier ফ্রড, কুরিয়ার ফ্রড চেক, কুরিয়ার নাম্বার চেক, courier check bangladesh">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://courier-fraud.laravel.cloud">
    <meta property="og:title" content="FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Bangladesh Courier Fraud Detection">
    <meta property="og:description" content="মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন। বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম।">
    <meta property="og:image" content="{{asset('assets/banner.jpg')}}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="{{asset('assets/banner.jpg')}}">
    <meta property="twitter:url" content="https://courier-fraud.laravel.cloud">
    <meta property="twitter:title" content="FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Bangladesh Courier Fraud Detection">
    <meta property="twitter:description" content="মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন। বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম।">
    <meta property="twitter:image" content="{{asset('assets/banner.jpg')}}">
    
    <!-- Canonical URL -->
    <meta rel="canonical" href="https://courier-fraud.laravel.cloud">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('assets/favicon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('assets/favicon.png')}}">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম",
      "url": "https://courier-fraud.laravel.cloud",
      "description": "বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "All",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "BDT"
      },
      "author": {
        "@type": "Organization",
        "name": "Tyrodevs",
        "url": "https://tyrodevs.com"
      }
    }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
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
        
        .progress-ring {
            position: relative;
            width: 150px;
            height: 150px;
        }
        
        .progress-ring circle {
            fill: none;
            stroke-width: 10;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
            transition: stroke-dashoffset 1s ease;
        }
        
        .progress-ring circle.bg {
            stroke: #e5e7eb;
        }
        
        .progress-ring circle.progress {
            stroke-linecap: round;
        }
        
        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        
        .tab {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .tab.active {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 3px 3px 0 0;
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
        
        .spinner {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            border: 4px solid rgba(79, 70, 229, 0.1);
            border-top-color: var(--primary-color);
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Dark mode */
        .dark {
            color: #e2e8f0;
        }
        
        .dark .bg-white, .dark .bg-gray-50 {
            background-color: #1f2937;
        }
        
        .dark .border-gray-200 {
            border-color: #374151;
        }
        
        .dark .text-gray-600, .dark .text-gray-800 {
            color: #e2e8f0;
        }
        
        .dark .bg-gray-100 {
            background-color: #374151;
        }
        
        .dark .bg-green-100 {
            background-color: rgba(16, 185, 129, 0.2);
        }
        
        .dark .bg-yellow-100 {
            background-color: rgba(245, 158, 11, 0.2);
        }
        
        .dark .bg-red-100 {
            background-color: rgba(239, 68, 68, 0.2);
        }
        
        .dark .progress-ring circle.bg {
            stroke: #374151;
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

        @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .faq-container {
      max-width: auto;
      margin: 0 auto;
      padding: 2rem;
      font-family: 'Hind Siliguri', 'Bangla', sans-serif;
    }
    
    .faq-header {
      text-align: center;
      margin-bottom: 2.5rem;
      position: relative;
    }
    
    .faq-title {
      font-size: 2.25rem;
      font-weight: 700;
      color: #2C3E50;
      margin-bottom: 1rem;
      position: relative;
      display: inline-block;
    }
    
    .faq-title::after {
      content: "";
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 4px;
      background: linear-gradient(90deg, #3498DB, #2ECC71);
      border-radius: 2px;
    }
    
    .faq-description {
      color: #7F8C8D;
      max-width: 600px;
      margin: 0 auto;
    }
    
    .faq-items {
      display: grid;
      gap: 1.25rem;
    }
    
    .faq-item {
      border-radius: 12px;
      overflow: hidden;
      background: white;
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      border-left: 5px solid #3498DB;
      animation: fadeIn 0.5s ease forwards;
      animation-delay: calc(var(--order) * 0.1s);
      opacity: 0;
    }
    
    .faq-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .faq-question {
      padding: 1.25rem 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
      font-weight: 600;
      font-size: 1.125rem;
      color: #2C3E50;
    }
    
    .faq-answer {
      padding: 0 1.5rem 1.25rem 1.5rem;
      color: #5D6D7E;
      line-height: 1.6;
    }
    
    .faq-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: #EBF5FB;
      color: #3498DB;
      transition: all 0.3s ease;
    }
    
    /* Dark mode styles */
    @media (prefers-color-scheme: dark) {
      body {
        background-color: #1E293B;
        color: #E5E7EB;
      }
      
      .faq-item {
        background-color: #2D3748;
        border-left: 5px solid #38B2AC;
      }
      
      .faq-title {
        color: #E5E7EB;
      }
      
      .faq-question {
        color: #E5E7EB;
      }
      
      .faq-answer {
        color: #CBD5E0;
      }
      
      .faq-icon {
        background: #2C5282;
        color: #90CDF4;
      }
    }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen text-gray-800 dark:bg-gray-900 dark:text-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-lg py-4 sticky top-0 z-50 glass-effect dark:bg-gray-800">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white w-10 h-10 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="text-xl font-bold">
                    <span class="gradient-text">Fraud</span><span class="text-gray-800 dark:text-white">Shield</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button id="themeToggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300 focus:outline-none">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:inline"></i>
                </button>
            </div>
        </div>
    </header>
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম</h1>
            <p class="text-xl mb-6">মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।</p>
            <div class="flex justify-center">
                <a href="#search-section" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    <i class="fas fa-search mr-2"></i> অনুসন্ধান শুরু করুন
                </a>
            </div>
        </div>
    </section>
    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-4 py-8">
        {{-- <h1 class="text-2xl md:text-2xl font-bold mb-6 text-center animate-in">Courier Fraud Detection System</h1> --}}
        
        <!-- Search Bar - Full width on mobile -->
        <div class="bg-white rounded-xl shadow-custom p-6 mb-6 dark:bg-gray-800 animate-in" style="animation-delay: 0.1s">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone-alt text-gray-400"></i>
                    </div>
                    <input type="text" id="phoneInput" class="w-full pl-10 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-300"
                        placeholder="Enter Mobile Number (e.g., 0160000000)">
                </div>
                <button id="searchButton" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-4 rounded-lg font-semibold hover:opacity-90 transition duration-300 flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i> <span>রিপোর্ট দেখুন</span>
                </button>
            </div>
        </div>
        
        <!-- Loading State -->
        <div id="loading" class="hidden text-center py-5 animate-in">
            <div class="spinner mx-auto mb-2"></div>
            <p class="text-gray-600 dark:text-gray-400">Analyzing delivery history...</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-in" style="animation-delay: 0.2s">
            <!-- Left Panel -->
            <div class="bg-white rounded-xl shadow-custom p-6 dark:bg-gray-800">
                <h2 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-indigo-600"></i>
                    Delivery Success Ratio
                </h2>
                
                <div class="flex justify-center mb-4">
                    <div class="progress-ring">
                        <svg width="150" height="150" viewBox="0 0 150 150">
                            <circle class="bg" cx="75" cy="75" r="65" stroke-dasharray="408" stroke-dashoffset="0"></circle>
                            <circle id="progressRing" class="progress" cx="75" cy="75" r="65" stroke-dasharray="408" stroke-dashoffset="408"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center flex-col">
                            <span id="progressValue" class="text-3xl font-bold">0%</span>
                            <span id="rating" class="text-sm font-medium text-gray-500 dark:text-gray-400">N/A</span>
                        </div>
                    </div>
                </div>
                
                <div id="ratingMessage" class="text-center text-gray-600 mt-2 dark:text-gray-400">Enter a phone number to check delivery history.</div>
                
                <div id="riskIndicator" class="mt-6 text-center py-3 px-4 rounded-lg text-white bg-gray-500 flex items-center justify-center">
                    <i class="fas fa-question-circle mr-2"></i> <span>No Data Available</span>
                </div>
                
                <div id="quoteBox" class="mt-6 p-4 bg-gray-50 border-l-4 border-indigo-500 italic text-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-r-lg">
                    "Enter a phone number to analyze the delivery history."
                </div>
                
                <div class="mt-6">
                    <h3 class="font-semibold mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-indigo-600"></i>
                        Fraud Risk Factors
                    </h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>High delivery success rate</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                            <span>Multiple cancelled orders</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-exclamation-circle text-yellow-500 mr-2"></i>
                            <span>Inconsistent delivery patterns</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="lg:col-span-2">
                <!-- Results Container -->
                <div id="resultsContainer" class="hidden">
                    <!-- Message Box -->
                    <div id="messageBox" class="bg-green-100 border-l-4 border-green-500 p-4 rounded-xl mb-6 flex items-center gap-4 dark:bg-green-900 dark:border-green-700 animate-in">
                        <i class="fas fa-check-circle text-green-500 text-2xl dark:text-green-300"></i>
                        <div>
                            <strong>Trusted Customer:</strong> This customer has an excellent delivery history with a 100% success rate.
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-6 animate-in" style="animation-delay: 0.1s">
                        <div class="bg-white rounded-xl shadow-custom p-4 text-center dark:bg-gray-800 hover:transform hover:scale-105 transition duration-300">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">মোট অর্ডার</div>
                            <div id="totalValue" class="text-3xl font-bold text-indigo-600">0</div>
                            <div class="flex justify-center mt-2">
                                <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    <i class="fas fa-box mr-1"></i> Total
                                </span>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-custom p-4 text-center dark:bg-gray-800 hover:transform hover:scale-105 transition duration-300">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">মোট ডেলিভারি</div>
                            <div id="successValue" class="text-3xl font-bold text-green-500">0</div>
                            <div class="flex justify-center mt-2">
                                <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <i class="fas fa-check mr-1"></i> Delivered
                                </span>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-custom p-4 text-center dark:bg-gray-800 hover:transform hover:scale-105 transition duration-300">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">মোট বাতিল</div>
                            <div id="cancelledValue" class="text-3xl font-bold text-red-500">0</div>
                            <div class="flex justify-center mt-2">
                                <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    <i class="fas fa-times mr-1"></i> Cancelled
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Chart and Table Container -->
                    <div class="bg-white rounded-xl shadow-custom p-6 dark:bg-gray-800 animate-in" style="animation-delay: 0.2s">
                        <!-- Tabs -->
                        <div class="flex overflow-x-auto mb-6 border-b border-gray-200 dark:border-gray-600 pb-1">
                            <div class="tab px-4 py-2 cursor-pointer font-medium text-gray-600 hover:text-indigo-500 dark:text-gray-400 active" data-tab="courier">
                                <i class="fas fa-truck-loading mr-2"></i> কুরিয়ার
                            </div>
                            {{-- <div class="tab px-4 py-2 cursor-pointer font-medium text-gray-600 hover:text-indigo-500 dark:text-gray-400" data-tab="orders">
                                <i class="fas fa-shopping-bag mr-2"></i> অর্ডার
                            </div>
                            <div class="tab px-4 py-2 cursor-pointer font-medium text-gray-600 hover:text-indigo-500 dark:text-gray-400" data-tab="delivery">
                                <i class="fas fa-box-open mr-2"></i> ডেলিভারি
                            </div>
                            <div class="tab px-4 py-2 cursor-pointer font-medium text-gray-600 hover:text-indigo-500 dark:text-gray-400" data-tab="cancelled">
                                <i class="fas fa-ban mr-2"></i> বাতিল
                            </div>
                            <div class="tab px-4 py-2 cursor-pointer font-medium text-gray-600 hover:text-indigo-500 dark:text-gray-400" data-tab="delivery-rate">
                                <i class="fas fa-chart-line mr-2"></i> ডেলিভারি হার
                            </div> --}}
                        </div>

                        <!-- Chart Container -->
                        <div class="mb-6 h-64">
                            <canvas id="dataChart"></canvas>
                        </div>

                        <!-- Tab Content -->
                        <div id="courierTab" class="tab-content">
                            <div class="overflow-x-auto rounded-lg">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <th class="py-3 px-4 text-left font-semibold rounded-tl-lg">Courier</th>
                                            <th class="py-3 px-4 text-left font-semibold">Orders</th>
                                            <th class="py-3 px-4 text-left font-semibold">Delivered</th>
                                            <th class="py-3 px-4 text-left font-semibold">Cancelled</th>
                                            <th class="py-3 px-4 text-left font-semibold rounded-tr-lg">Success Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody id="courierTableBody" class="divide-y divide-gray-200 dark:divide-gray-600">
                                        <!-- Table rows will be populated dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Empty State -->
                <div id="emptyState" class="bg-white rounded-xl shadow-custom p-10 text-center dark:bg-gray-800">
                    <img src="https://img.freepik.com/free-vector/work-office-computer-man-woman-business-character-marketing-online-employee-technology-business-man-cartoon-co-working-flat-design-freelance_1150-41790.jpg?t=st=1740479906~exp=1740483506~hmac=f0e47a05873c1b7a4736f50a9a2c21bebb2c8a9e9f45269c1b6dd0d27e5176b7&w=1060" alt="Search illustration" class="mx-auto mb-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-2">Check Courier Fraud</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Enter a mobile number and click "রিপোর্ট দেখুন" to check the courier delivery history and fraud risk assessment.</p>
                    <div class="flex justify-center space-x-4">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                            <span class="text-sm">Low Risk</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                            <span class="text-sm">Medium Risk</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                            <span class="text-sm">High Risk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <section class="container mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow-custom p-6 dark:bg-gray-800">
            <h2 class="text-2xl font-bold mb-6 text-center">কেন কুরিয়ার ফ্রড চেক করা প্রয়োজন?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="p-5 border border-gray-200 rounded-lg text-center">
                    <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">ব্যবসা সুরক্ষা</h3>
                    <p class="text-gray-600 dark:text-gray-400">আপনার ব্যবসাকে সম্ভাব্য কুরিয়ার ফ্রড থেকে রক্ষা করুন। প্রতি মাসে হাজার হাজার টাকা সাশ্রয় করুন।</p>
                </div>
                <div class="p-5 border border-gray-200 rounded-lg text-center">
                    <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">ডেলিভারি সাফল্য বাড়ান</h3>
                    <p class="text-gray-600 dark:text-gray-400">বিশ্বস্ত গ্রাহকদের চিহ্নিত করে আপনার ডেলিভারি সাফল্যের হার বাড়ান এবং ব্যবসার লাভ বৃদ্ধি করুন।</p>
                </div>
                <div class="p-5 border border-gray-200 rounded-lg text-center">
                    <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-history text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">রিয়েল-টাইম ডাটা</h3>
                    <p class="text-gray-600 dark:text-gray-400">সর্বাধিক আপডেটেড ডাটা দিয়ে গ্রাহকের আচরণ বিশ্লেষণ করুন এবং সঠিক সিদ্ধান্ত নিন।</p>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                <h3 class="text-xl font-semibold mb-4">বাংলাদেশে কুরিয়ার ফ্রড সম্পর্কে জানুন</h3>
                <p class="mb-4">বাংলাদেশে প্রতি বছর হাজার হাজার ব্যবসায়ী কুরিয়ার ফ্রডের শিকার হন। কুরিয়ার ফ্রড হল যখন একজন গ্রাহক ইচ্ছাকৃতভাবে পণ্য গ্রহণ করে না বা ডেলিভারি বাতিল করে। এর ফলে ব্যবসায়ীদের আর্থিক ক্ষতি হয় এবং সময় নষ্ট হয়।</p>
                <p class="mb-4">FraudShield আপনাকে একটি গ্রাহকের পূর্ববর্তী ডেলিভারি ইতিহাস দেখার সুযোগ দেয়, যাতে আপনি সিদ্ধান্ত নিতে পারেন যে তাদের কাছে পণ্য পাঠানো নিরাপদ কিনা।</p>
                <p>আমাদের সিস্টেম বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিসের ডাটা ব্যবহার করে এবং একটি বিশ্বস্ত ফ্রড স্কোর প্রদান করে।</p>
            </div>
        </div>
    </section>
    
    <section class="faq-container">
        <div class="faq-header">
          <h2 class="faq-title">সাধারণ জিজ্ঞাসা (FAQ)</h2>
          <p class="faq-description">আপনার FraudShield সম্পর্কিত সব প্রশ্নের উত্তর এখানে পাবেন</p>
        </div>
        
        <div class="faq-items">
          <div class="faq-item" style="--order: 1">
            <div class="faq-question">
              <span>FraudShield কীভাবে কাজ করে?</span>
              <span class="faq-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
              </span>
            </div>
            <div class="faq-answer">
              FraudShield বাংলাদেশের বিভিন্ন কুরিয়ার সার্ভিস থেকে ডাটা সংগ্রহ করে এবং ডেলিভারি সাফল্য, বাতিল হার এবং অন্যান্য ফ্যাক্টর ব্যবহার করে ফ্রড স্কোর তৈরি করে। এই স্কোরিং সিস্টেম আপনাকে সঠিক সিদ্ধান্ত নিতে সাহায্য করে।
            </div>
          </div>
          
          <div class="faq-item" style="--order: 2">
            <div class="faq-question">
              <span>FraudShield ব্যবহার করার খরচ কত?</span>
              <span class="faq-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
              </span>
            </div>
            <div class="faq-answer">
              FraudShield বর্তমানে বিনামূল্যে ব্যবহার করা যায়। ভবিষ্যতে আমরা প্রিমিয়াম প্ল্যান চালু করব যেখানে আরও উন্নত ফিচার থাকবে। আমাদের লক্ষ্য হল সমস্ত ব্যবসার জন্য একটি সাশ্রয়ী মূল্যের সলিউশন প্রদান করা।
            </div>
          </div>
          
          <div class="faq-item" style="--order: 3">
            <div class="faq-question">
              <span>FraudShield এর ডাটা কতটা নির্ভরযোগ্য?</span>
              <span class="faq-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
              </span>
            </div>
            <div class="faq-answer">
              আমরা বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিস থেকে রিয়েল-টাইম ডাটা সংগ্রহ করি এবং আমাদের এলগরিদম 95% এরও বেশি সঠিকতার সাথে ফ্রড সনাক্ত করতে পারে। আমাদের সিস্টেম নিয়মিত আপডেট হয় নতুন ফ্রড প্যাটার্ন অনুসারে।
            </div>
          </div>
          
          <div class="faq-item" style="--order: 4">
            <div class="faq-question">
              <span>আমি কীভাবে আমার ব্যবসার জন্য FraudShield ইন্টিগ্রেট করতে পারি?</span>
              <span class="faq-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
              </span>
            </div>
            <div class="faq-answer">
              আমাদের API ব্যবহার করে আপনি আপনার ওয়েবসাইট বা অ্যাপে FraudShield ইন্টিগ্রেট করতে পারেন। বিস্তারিত জানতে আমাদের সাথে যোগাযোগ করুন। আমাদের টেকনিক্যাল টিম আপনাকে সম্পূর্ণ ইন্টিগ্রেশন গাইড প্রদান করবে।
            </div>
          </div>
        </div>
      </section>

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
                    <p class="text-sm text-indigo-200 mb-4">Advanced fraud detection system for courier services. Protect your business from potential fraud.</p>
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
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">Home</a></li>
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">About Us</a></li>
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">Features</a></li>
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">Documentation</a></li>
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">Help Center</a></li>
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">Privacy Policy</a></li>
                        <li><a href="#" class="text-indigo-200 hover:text-white transition duration-300">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2 text-yellow-400"></i>
                            <span class="text-indigo-200">Chittagong, Bangladesh</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-2 text-yellow-400"></i>
                            <span class="text-indigo-200">info@fraudshield.com</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-2 text-yellow-400"></i>
                            <span class="text-indigo-200">+8801309092748</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-indigo-700 mt-8 pt-6 text-center text-indigo-200">
                <p>© 2025 FraudShield - Courier Fraud Detection System. All rights reserved Tyrodevs.com</p>
            </div>
        </div>
    </footer>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5TNKX5N9"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
       // Theme Toggle Functionality
const themeToggle = document.getElementById('themeToggle');
themeToggle.addEventListener('click', () => {
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
});

// Set initial theme based on local storage or system preference
if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}

// Initialize Chart.js chart
let dataChart;

// Sample data for simulating API response
// const sampleData = {
//     phone: "01309092748",
//     status: "success",
//     courierData: {
//         "pathao": {
//             total_parcel: 45,
//             success_parcel: 38,
//             cancelled_parcel: 7,
//             success_ratio: 84.4
//         },
//         "redx": {
//             total_parcel: 32,
//             success_parcel: 28,
//             cancelled_parcel: 4,
//             success_ratio: 87.5
//         },
//         "steadfast": {
//             total_parcel: 27,
//             success_parcel: 24,
//             cancelled_parcel: 3,
//             success_ratio: 88.9
//         },
//         "e-courier": {
//             total_parcel: 18,
//             success_parcel: 16,
//             cancelled_parcel: 2,
//             success_ratio: 88.9
//         },
//         "summary": {
//             total_parcel: 122,
//             success_parcel: 106,
//             cancelled_parcel: 16,
//             success_ratio: 86.9
//         }
//     },
//     monthly_data: [
//         { month: "Jan", orders: 15, delivered: 13, cancelled: 2 },
//         { month: "Feb", orders: 18, delivered: 16, cancelled: 2 },
//         { month: "Mar", orders: 22, delivered: 19, cancelled: 3 },
//         { month: "Apr", orders: 20, delivered: 17, cancelled: 3 },
//         { month: "May", orders: 25, delivered: 22, cancelled: 3 },
//         { month: "Jun", orders: 22, delivered: 19, cancelled: 3 }
//     ]
// };

// Function to get color based on success ratio
function getColorForRatio(ratio) {
    if (ratio >= 90) return '#10b981'; // Green
    if (ratio >= 70) return '#f59e0b'; // Yellow/Orange
    return '#ef4444'; // Red
}

// Function to update the UI with the data
function updateUI(data) {
    const summary = data.courierData.summary;
    const successRatio = summary.success_ratio;

    // Update progress ring
    const progressRing = document.getElementById('progressRing');
    const progressValue = document.getElementById('progressValue');
    const circumference = 2 * Math.PI * 65;
    const offset = circumference - (successRatio / 100) * circumference;
    progressRing.style.strokeDashoffset = offset;
    progressRing.style.stroke = getColorForRatio(successRatio);
    progressValue.textContent = successRatio.toFixed(1) + '%';

    // Update rating and message
    const rating = document.getElementById('rating');
    const ratingMessage = document.getElementById('ratingMessage');
    const riskIndicator = document.getElementById('riskIndicator');
    const quoteBox = document.getElementById('quoteBox');
    const messageBox = document.getElementById('messageBox');

    // Set rating and UI elements based on success ratio

    if(successRatio == 0){
        rating.textContent = 'New';
        ratingMessage.textContent = 'This customer is new and has no delivery history.';
        riskIndicator.className = 'mt-6 text-center py-3 px-4 rounded-lg text-white bg-gray-500 flex items-center justify-center';
        riskIndicator.innerHTML = '<i class="fas fa-question-circle mr-2"></i> <span>No Data Available</span>';
        quoteBox.textContent = '"Reliability is the foundation of trust. This customer\'s no record to speaks volumes."';

        // ratingMessage.textContent = 'This customer has an excellent delivery history.';
        // riskIndicator.className = 'mt-6 text-center py-3 px-4 rounded-lg text-white bg-green-500 flex items-center justify-center';
        // riskIndicator.innerHTML = '<i class="fas fa-check-circle mr-2"></i> <span>Low Fraud Risk</span>';

        messageBox.className = 'bg-green-100 border-l-4 border-green-500 p-4 rounded-xl mb-6 flex items-center gap-4 dark:bg-green-900 dark:border-green-700 animate-in';
        messageBox.innerHTML = `
            <i class="fas fa-check-circle text-green-500 text-2xl dark:text-green-300"></i>
            <div>
                <strong>Your may trust this Customer:</strong> This customer has no delivery history with a ${successRatio.toFixed(1)}% success rate.
            </div>
        `;
    }
    else if (successRatio >= 90) {
        rating.textContent = 'Excellent';
        ratingMessage.textContent = 'This customer has an excellent delivery history.';
        riskIndicator.className = 'mt-6 text-center py-3 px-4 rounded-lg text-white bg-green-500 flex items-center justify-center';
        riskIndicator.innerHTML = '<i class="fas fa-check-circle mr-2"></i> <span>Low Fraud Risk</span>';
        quoteBox.textContent = '"Reliability is the foundation of trust. This customer\'s excellent record speaks volumes."';

        messageBox.className = 'bg-green-100 border-l-4 border-green-500 p-4 rounded-xl mb-6 flex items-center gap-4 dark:bg-green-900 dark:border-green-700 animate-in';
        messageBox.innerHTML = `
            <i class="fas fa-check-circle text-green-500 text-2xl dark:text-green-300"></i>
            <div>
                <strong>Trusted Customer:</strong> This customer has an excellent delivery history with a ${successRatio.toFixed(1)}% success rate.
            </div>
        `;
    } else if (successRatio >= 70) {
        rating.textContent = 'Good';
        ratingMessage.textContent = 'This customer has a good delivery history with a few cancellations.';
        riskIndicator.className = 'mt-6 text-center py-3 px-4 rounded-lg text-white bg-yellow-500 flex items-center justify-center';
        riskIndicator.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i> <span>Medium Fraud Risk</span>';
        quoteBox.textContent = '"Trust but verify. While the history is mostly good, occasional issues suggest caution."';

        messageBox.className = 'bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded-xl mb-6 flex items-center gap-4 dark:bg-yellow-900 dark:border-yellow-700 animate-in';
        messageBox.innerHTML = `
            <i class="fas fa-exclamation-circle text-yellow-500 text-2xl dark:text-yellow-300"></i>
            <div>
                <strong>Proceed with Caution:</strong> This customer has a generally good history, but with a ${successRatio.toFixed(1)}% success rate, some verification is advised.
            </div>
        `;
    } else {
        rating.textContent = 'Poor';
        ratingMessage.textContent = 'This customer has a concerning number of cancelled orders.';
        riskIndicator.className = 'mt-6 text-center py-3 px-4 rounded-lg text-white bg-red-500 flex items-center justify-center';
        riskIndicator.innerHTML = '<i class="fas fa-times-circle mr-2"></i> <span>High Fraud Risk</span>';
        quoteBox.textContent = '"Past behavior predicts future actions. The high cancellation rate signals significant risk."';

        messageBox.className = 'bg-red-100 border-l-4 border-red-500 p-4 rounded-xl mb-6 flex items-center gap-4 dark:bg-red-900 dark:border-red-700 animate-in';
        messageBox.innerHTML = `
            <i class="fas fa-times-circle text-red-500 text-2xl dark:text-red-300"></i>
            <div>
                <strong>High Risk Alert:</strong> This customer has a concerning history with only a ${successRatio.toFixed(1)}% success rate. Additional verification strongly recommended.
            </div>
        `;
    }

    // Update stats
    document.getElementById('totalValue').textContent = summary.total_parcel;
    document.getElementById('successValue').textContent = summary.success_parcel;
    document.getElementById('cancelledValue').textContent = summary.cancelled_parcel;

    // Update courier table
    const tableBody = document.getElementById('courierTableBody');
    tableBody.innerHTML = '';

    // Add rows for each courier
    for (const [courier, stats] of Object.entries(data.courierData)) {
        if (courier === 'summary') continue;

        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150';

        // Format success rate display
        let successRateDisplay = 'N/A';
        if (stats.total_parcel > 0) {
            const color = getColorForRatio(stats.success_ratio);
            successRateDisplay = `<span class="px-2 py-1 text-xs rounded-full text-white" style="background-color: ${color}">${stats.success_ratio.toFixed(1)}%</span>`;
        }

        row.innerHTML = `
            <td class="py-3 px-4">${courier.charAt(0).toUpperCase() + courier.slice(1)}</td>
            <td class="py-3 px-4">${stats.total_parcel}</td>
            <td class="py-3 px-4">${stats.success_parcel}</td>
            <td class="py-3 px-4">${stats.cancelled_parcel}</td>
            <td class="py-3 px-4">${successRateDisplay}</td>
        `;

        tableBody.appendChild(row);
    }

    // Update chart
    updateChart(data);
}

// Function to update the chart based on active tab
function updateChart(data) {
    const activeTab = document.querySelector('.tab.active').getAttribute('data-tab');
    const ctx = document.getElementById('dataChart').getContext('2d');
    
    // Destroy existing chart if it exists
    if (dataChart) {
        dataChart.destroy();
    }
    
    // Prepare chart data based on active tab
    let chartData = {
        labels: [],
        datasets: []
    };
    
    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#e2e8f0' : '#1f2937';
    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
    
    if (activeTab === 'courier') {
        // Courier-wise distribution
        const couriers = Object.keys(data.courierData).filter(key => key !== 'summary');
        chartData.labels = couriers.map(c => c.charAt(0).toUpperCase() + c.slice(1));
        
        chartData.datasets = [
            {
                label: 'Total Orders',
                data: couriers.map(c => data.courierData[c].total_parcel),
                backgroundColor: 'rgba(79, 70, 229, 0.7)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1
            },
            {
                label: 'Successful Deliveries',
                data: couriers.map(c => data.courierData[c].success_parcel),
                backgroundColor: 'rgba(16, 185, 129, 0.7)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 1
            },
            {
                label: 'Cancelled Orders',
                data: couriers.map(c => data.courierData[c].cancelled_parcel),
                backgroundColor: 'rgba(239, 68, 68, 0.7)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 1
            }
        ];
        
        // Create chart
        dataChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: textColor
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    }
                }
            }
        });
    } else if (activeTab === 'orders' || activeTab === 'delivery' || activeTab === 'cancelled') {
        // Monthly data
        chartData.labels = data.monthly_data.map(item => item.month);
        
        let dataKey = 'orders';
        let color = 'rgba(79, 70, 229, 1)';
        let bgColor = 'rgba(79, 70, 229, 0.2)';
        
        if (activeTab === 'delivery') {
            dataKey = 'delivered';
            color = 'rgba(16, 185, 129, 1)';
            bgColor = 'rgba(16, 185, 129, 0.2)';
        } else if (activeTab === 'cancelled') {
            dataKey = 'cancelled';
            color = 'rgba(239, 68, 68, 1)';
            bgColor = 'rgba(239, 68, 68, 0.2)';
        }
        
        chartData.datasets = [
            {
                label: dataKey.charAt(0).toUpperCase() + dataKey.slice(1),
                data: data.monthly_data.map(item => item[dataKey]),
                fill: true,
                backgroundColor: bgColor,
                borderColor: color,
                tension: 0.4
            }
        ];
        
        // Create chart
        dataChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: textColor
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    }
                }
            }
        });
    } else if (activeTab === 'delivery-rate') {
        // Delivery success rate trend
        chartData.labels = data.monthly_data.map(item => item.month);
        
        // Calculate monthly success rates
        const successRates = data.monthly_data.map(item => {
            return item.orders > 0 ? ((item.delivered / item.orders) * 100).toFixed(1) : 0;
        });
        
        chartData.datasets = [
            {
                label: 'Delivery Success Rate (%)',
                data: successRates,
                fill: true,
                backgroundColor: 'rgba(249, 115, 22, 0.2)',
                borderColor: 'rgba(249, 115, 22, 1)',
                tension: 0.4
            }
        ];
        
        // Create chart
        dataChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: textColor
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            color: textColor,
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            color: gridColor
                        }
                    }
                }
            }
        });
    }
}

// Tab switching functionality
const tabs = document.querySelectorAll('.tab');
tabs.forEach(tab => {
    tab.addEventListener('click', function() {
        const activeTabId = this.getAttribute('data-tab');
        
        // Update active tab styling
        tabs.forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        // Update chart if results are visible
        if (!document.getElementById('resultsContainer').classList.contains('hidden')) {
            updateChart(sampleData);
        }
    });
});

// Event listener for search button
document.getElementById('searchButton').addEventListener('click', async function() {
    const phone = document.getElementById('phoneInput').value;

    if (!phone) {
        // alert('Please enter a phone number');

        Toastify({
  text: "Please enter a phone number",
  className: "error",
  style: {
    background: "linear-gradient(to right, red, red)",
  }
}).showToast();
        return;
    }

    // Validate phone number format
    const phoneRegex = /^01[0-9]{9}$/;
    if (!phoneRegex.test(phone)) {
        Toastify({
  text: "Please enter a valid Bangladesh mobile number (e.g. 0160000000)",
  className: "error",
  style: {
    background: "linear-gradient(to right, red, red)",
  }
}).showToast();
        return;
    }

    document.getElementById('searchButton').disabled = true;

    // Show loading, hide results and empty state
    document.getElementById('loading').classList.remove('hidden');
    document.getElementById('resultsContainer').classList.add('hidden');
    document.getElementById('emptyState').classList.add('hidden');

    try {
        // Simulate API call delay
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        // In a real implementation, you would make an actual API call:
        
        const response = await axios.post('/courier-check', { phone }, {
            headers: {
                'Authorization': 'Bearer YOUR_BEARER_TOKEN_HERE',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        document.getElementById('searchButton').disabled = false;
        const data = response.data;
        
        
        // For demo purposes, use sample data
        // const data = sampleData;
        
        // Hide loading and show results
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('resultsContainer').classList.remove('hidden');
        
        // Update UI with data
        updateUI(data);
    } catch (error) {
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('emptyState').classList.remove('hidden');
        alert('Error fetching data. Please try again.');
        console.error('Error:', error);
    }
});

// Handle enter key on phone input
document.getElementById('phoneInput').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        document.getElementById('searchButton').click();
    }
});

// Initialize with empty state visible
document.getElementById('emptyState').classList.remove('hidden');
document.getElementById('resultsContainer').classList.add('hidden');
document.getElementById('loading').classList.add('hidden');

// Initialize progress ring stroke color
document.getElementById('progressRing').style.stroke = '#4f46e5';

// Listen for theme changes to update chart colors
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    if (!document.getElementById('resultsContainer').classList.contains('hidden')) {
        updateChart(sampleData);
    }
});

// Event listener for window resize to make chart responsive
window.addEventListener('resize', () => {
    if (dataChart) {
        dataChart.resize();
    }
});
    </script>
    <script>

document.addEventListener('DOMContentLoaded', function() {
    // Set page title based on search results
    const setDynamicPageTitle = (phoneNumber) => {
        if (phoneNumber) {
            document.title = `${phoneNumber} - কুরিয়ার ডেলিভারি হিস্টরি | FraudShield`;
            
            // Update meta description
            let metaDescription = document.querySelector('meta[name="description"]');
            if (metaDescription) {
                metaDescription.setAttribute('content', `${phoneNumber} নম্বরের কুরিয়ার ডেলিভারি হিস্টরি এবং ফ্রড রিস্ক রিপোর্ট। FraudShield - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম।`);
            }
        }
    };
    
    // Handle search button click
    const searchButton = document.getElementById('searchButton');
    const phoneInput = document.getElementById('phoneInput');
    
    if (searchButton && phoneInput) {
        searchButton.addEventListener('click', function() {
            const phoneNumber = phoneInput.value.trim();
            if (phoneNumber) {
                setDynamicPageTitle(phoneNumber);
                
                // Add phone number to URL for shareable links
                const url = new URL(window.location);
                url.searchParams.set('phone', phoneNumber);
                window.history.pushState({}, '', url);
            }
        });
        
        // Check URL parameters on page load
        const urlParams = new URLSearchParams(window.location.search);
        const phoneParam = urlParams.get('phone');
        if (phoneParam) {
            phoneInput.value = phoneParam;
            searchButton.click(); // Trigger search
        }
    }
    
    // Add structured breadcrumbs for search results
    const addBreadcrumbs = (phoneNumber) => {
        if (!phoneNumber) return;
        
        const breadcrumbsData = {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "হোম",
                    "item": "https://courier-fraud.laravel.cloud"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "কুরিয়ার চেক",
                    "item": "https://courier-fraud.laravel.cloud/check"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": `${phoneNumber} নম্বর চেক`,
                    "item": `https://courier-fraud.laravel.cloud/check?phone=${phoneNumber}`
                }
            ]
        };
        
        const script = document.createElement('script');
        script.type = 'application/ld+json';
        script.text = JSON.stringify(breadcrumbsData);
        document.head.appendChild(script);
    };
    
    // Implement smooth scrolling for better UX
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });
    const questions = document.querySelectorAll('.faq-question');
      
      questions.forEach(question => {
        question.addEventListener('click', () => {
          const answer = question.nextElementSibling;
          const icon = question.querySelector('.faq-icon svg');
          
          if (answer.style.display === 'none' || !answer.style.display) {
            answer.style.display = 'block';
            icon.innerHTML = '<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>';
          } else {
            answer.style.display = 'none';
            icon.innerHTML = '<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>';
          }
        });
      });
});
    </script>
</body>
</html>