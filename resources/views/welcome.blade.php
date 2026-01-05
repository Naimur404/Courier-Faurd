@extends('layouts.app')

@section('title', 'FraudShield - বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Courier Fraud Detection')

@section('description', 'বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।')

@section('keywords', 'courier fraud bangladesh, fraud detection system, bangladeshi courier check, courier ফ্রড, কুরিয়ার ফ্রড চেক, কুরিয়ার নাম্বার চেক, courier check bangladesh')

@section('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebApplication",
  "name": "FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম",
  "url": "https://fraudshieldbd.site",
  "description": "বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "All",
  "offers": {
    "@@type": "Offer",
    "price": "0",
    "priceCurrency": "BDT"
  },
  "author": {
    "@@type": "Organization",
    "name": "Tyrodevs",
    "url": "https://tyrodevs.com"
  }
}
</script>
@endsection

@section('additional_styles')
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
        
        .dark .progress-ring circle.bg {
            stroke: #4b5563;
        }
        
        /* Search Statistics Dark Mode */
        .dark .stat-card {
            border-color: #4b5563;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        }
        
        .dark .stat-card:hover {
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        /* Search Statistics Animations */
        .stat-card {
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.6s ease-out forwards;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        @keyframes slideInUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .stat-number {
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-number {
            transform: scale(1.1);
        }

        .stat-icon {
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: rotate(10deg) scale(1.1);
        }

        /* Pulse animation for loading states */
        .pulse-slow {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Analytics Cards Dark Mode - Comprehensive Fix */
        .dark .stat-card .text-blue-600 {
            color: #60a5fa !important;
        }
        
        .dark .stat-card .text-green-600 {
            color: #34d399 !important;
        }
        
        .dark .stat-card .text-purple-600 {
            color: #a78bfa !important;
        }
        
        .dark .stat-card .text-orange-600 {
            color: #fb923c !important;
        }

        /* FAQ Styles */
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
          transition: transform 0.3s ease, box-shadow 0.3s ease;
          border-left: 5px solid #3498DB;
          animation: fadeIn 0.5s ease forwards;
          animation-delay: calc(var(--order) * 0.1s);
          opacity: 0;
          margin-bottom: 1rem;
        }
        
        .faq-item:hover {
          transform: translateY(-2px);
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
          transition: background-color 0.2s ease;
          min-height: 80px;
        }
        
        .faq-question:hover {
          background-color: rgba(52, 152, 219, 0.05);
        }
        
        .faq-answer {
          padding: 0 1.5rem;
          color: #5D6D7E;
          line-height: 1.6;
          max-height: 0;
          overflow: hidden;
          transition: max-height 0.3s ease, padding 0.3s ease, opacity 0.3s ease;
          opacity: 0;
        }
        
        .faq-answer.show {
          max-height: 500px;
          padding: 0 1.5rem 1.25rem 1.5rem;
          opacity: 1;
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
        
        /* Dark mode FAQ styles */
        .dark .faq-container {
          background-color: #1E293B;
          color: #E5E7EB;
        }
        
        .dark .faq-item {
          background-color: #374151;
          border-left: 5px solid #38B2AC;
          box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        
        .dark .faq-item:hover {
          box-shadow: 0 15px 30px rgba(0,0,0,0.4);
        }
        
        .dark .faq-title {
          color: #F3F4F6;
        }
        
        .dark .faq-description {
          color: #D1D5DB;
        }
        
        .dark .faq-question {
          color: #F3F4F6;
        }
        
        .dark .faq-answer {
          color: #D1D5DB;
        }
        
        .dark .faq-answer.show {
          color: #D1D5DB;
        }
        
        .dark .faq-icon {
          background: #4B5563;
          color: #60A5FA;
        }

        /* Rating and review system styles */
        .rating-star {
            transition: transform 0.1s ease-in-out;
        }

        .rating-star:hover {
            transform: scale(1.2);
        }

        /* Animation for the new review being added */
        @keyframes highlight {
            0% { background-color: rgba(99, 102, 241, 0.1); }
            100% { background-color: transparent; }
        }

        #reviewsList > div:first-child {
            animation: highlight 2s ease-out;
        }

        /* Modal animation */
        #ratingModal {
            transition: opacity 0.3s ease;
        }

        #ratingModal.hidden {
            opacity: 0;
            pointer-events: none;
        }

        #ratingModal:not(.hidden) {
            opacity: 1;
        }

        #ratingModal > div {
            transition: transform 0.3s ease;
            transform: scale(0.9);
        }

        #ratingModal:not(.hidden) > div {
            transform: scale(1);
        }

        /* Make reviews section responsive */
        @media (max-width: 640px) {
            #customerReviewsSection h2, 
            #customerReviewsSection button {
                font-size: 0.95rem;
            }
            
            #addReviewBtn {
                padding: 0.5rem 0.75rem;
            }
        }
@endsection

@section('content')
    <!-- Search Statistics Section -->
    <section class="py-12 px-4">
        <div class="container mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">
                    <i class="fas fa-chart-bar mr-2 text-indigo-600 dark:text-indigo-400"></i>
                    সার্চ পরিসংখ্যান
                </h2>
                <p class="text-gray-600 dark:text-gray-300">রিয়েল-টাইম সার্চ ডেটা এবং ব্যবহারকারীর কার্যক্রম</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Last Hour Searches -->
                <div class="stat-card bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-xl p-6 border border-blue-200 dark:border-blue-700 hover:shadow-lg transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="stat-icon p-3 bg-blue-500 text-white rounded-full">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="stat-number text-2xl font-bold text-blue-600 dark:text-blue-300" id="lastHourCount">
                                <span class="animate-pulse">...</span>
                            </div>
                            <div class="text-sm text-blue-500 dark:text-blue-300 font-medium">শেষ ১ ঘন্টায়</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-info-circle mr-1"></i>
                        সর্বশেষ ৬০ মিনিটের সার্চ
                    </div>
                </div>

                <!-- Today's Searches -->
                <div class="stat-card bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-xl p-6 border border-green-200 dark:border-green-700 hover:shadow-lg transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="stat-icon p-3 bg-green-500 text-white rounded-full">
                            <i class="fas fa-calendar-day text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="stat-number text-2xl font-bold text-green-600 dark:text-green-300" id="lastDayCount">
                                <span class="animate-pulse">...</span>
                            </div>
                            <div class="text-sm text-green-500 dark:text-green-200 font-medium">আজকের সার্চ</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-info-circle mr-1"></i>
                        আজ রাত ১২টা থেকে এখন পর্যন্ত (বাংলাদেশ সময়)
                    </div>
                </div>

                <!-- All Time Searches -->
                <div class="stat-card bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl p-6 border border-purple-200 dark:border-purple-700 hover:shadow-lg transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="stat-icon p-3 bg-purple-500 text-white rounded-full">
                            <i class="fas fa-infinity text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="stat-number text-2xl font-bold text-purple-600 dark:text-purple-300" id="allTimeCount">
                                <span class="animate-pulse">...</span>
                            </div>
                            <div class="text-sm text-purple-500 dark:text-purple-200 font-medium">সর্বমোট সার্চ</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-info-circle mr-1"></i>
                        সর্বকালের মোট সার্চ সংখ্যা
                    </div>
                </div>

                <!-- Unique Numbers Searched -->
                <div class="stat-card bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-xl p-6 border border-orange-200 dark:border-orange-700 hover:shadow-lg transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="stat-icon p-3 bg-orange-500 text-white rounded-full">
                            <i class="fas fa-phone-alt text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="stat-number text-2xl font-bold text-orange-600 dark:text-orange-300" id="uniqueNumbersCount">
                                <span class="animate-pulse">...</span>
                            </div>
                            <div class="text-sm text-orange-500 dark:text-orange-200 font-medium">ইউনিক নাম্বার</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-info-circle mr-1"></i>
                        চেক করা মোট নাম্বার সংখ্যা
                    </div>
                </div>
            </div>
            
            <!-- Last Updated Time -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-sync-alt mr-1"></i>
                    সর্বশেষ আপডেট: <span id="lastUpdated" class="font-medium text-gray-700 dark:text-gray-300">লোড হচ্ছে...</span>
                </p>
            </div>
        </div>
    </section>

    <!-- Main Search Section -->
    <main class="flex-1 container mx-auto px-4 py-8" id="search-section">
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

                    <!-- Rating and Comment Modal -->
<div id="ratingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-md w-full shadow-2xl">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold">Rate This Customer</h3>
        <button id="closeRatingModal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
          <i class="fas fa-times"></i>
        </button>
      </div>
      
      <p class="text-gray-600 dark:text-gray-300 mb-4">
        Share your experience with <span id="ratingPhoneNumber" class="font-medium"></span>
      </p>
      
      <form id="ratingForm">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="ownNumber">
              আপনার নম্বর
            </label>
            <input type="text" id="ownNumber" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="আপনার নম্বর লিখুন" required>
          </div>

        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="userName">
            আপনার নাম
          </label>
          <input type="text" id="userName" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="আপনার নাম লিখুন" required>
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
            রেটিং দিন
          </label>
          <div class="flex space-x-2 text-2xl">
            <i class="far fa-star cursor-pointer hover:text-yellow-500 rating-star" data-rating="1"></i>
            <i class="far fa-star cursor-pointer hover:text-yellow-500 rating-star" data-rating="2"></i>
            <i class="far fa-star cursor-pointer hover:text-yellow-500 rating-star" data-rating="3"></i>
            <i class="far fa-star cursor-pointer hover:text-yellow-500 rating-star" data-rating="4"></i>
            <i class="far fa-star cursor-pointer hover:text-yellow-500 rating-star" data-rating="5"></i>
          </div>
          <input type="hidden" id="ratingValue" value="0" required>
        </div>
        
        <div class="mb-6">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="userComment">
            আপনার মন্তব্য
          </label>
          <textarea id="userComment" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="আপনার অভিজ্ঞতা শেয়ার করুন" rows="3" required></textarea>
        </div>
        
        <div class="text-right">
          <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition duration-300">
            <i class="fas fa-paper-plane mr-2"></i> জমা দিন
          </button>
        </div>
      </form>
    </div>
  </div>
  
  <!-- Customer Reviews Section (To be added to the resultsContainer) -->
  <div id="customerReviewsSection" class="bg-white rounded-xl shadow-custom p-6 dark:bg-gray-800 mt-6 animate-in" style="animation-delay: 0.3s">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-bold flex items-center">
        <i class="fas fa-comments mr-2 text-indigo-600"></i>
        গ্রাহক রিভিউ
      </h2>
      <button id="addReviewBtn" class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg font-medium hover:bg-indigo-200 transition duration-300 dark:bg-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-800">
        <i class="fas fa-plus mr-2"></i> নতুন রিভিউ
      </button>
    </div>
    
    <div id="noReviewsMsg" class="text-center py-10 text-gray-500 dark:text-gray-400">
      <i class="fas fa-comment-slash text-4xl mb-4"></i>
      <p>এই নাম্বারের জন্য কোন রিভিউ নেই</p>
      <p class="text-sm mt-2">প্রথম রিভিউ দিয়ে অন্যদের সাহায্য করুন</p>
    </div>
    
    <div id="reviewsList" class="space-y-4 hidden">
      <!-- Reviews will be populated dynamically here -->
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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-custom p-6">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 dark:text-gray-100">কেন কুরিয়ার ফ্রড চেক করা প্রয়োজন?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="p-5 border border-gray-200 dark:border-gray-600 rounded-lg text-center bg-gray-50 dark:bg-gray-700">
                    <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-2xl text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">ব্যবসা সুরক্ষা</h3>
                    <p class="text-gray-600 dark:text-gray-300">আপনার ব্যবসাকে সম্ভাব্য কুরিয়ার ফ্রড থেকে রক্ষা করুন। প্রতি মাসে হাজার হাজার টাকা সাশ্রয় করুন।</p>
                </div>
                <div class="p-5 border border-gray-200 dark:border-gray-600 rounded-lg text-center bg-gray-50 dark:bg-gray-700">
                    <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-2xl text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">ডেলিভারি সাফল্য বাড়ান</h3>
                    <p class="text-gray-600 dark:text-gray-300">বিশ্বস্ত গ্রাহকদের চিহ্নিত করে আপনার ডেলিভারি সাফল্যের হার বাড়ান এবং ব্যবসার লাভ বৃদ্ধি করুন।</p>
                </div>
                <div class="p-5 border border-gray-200 dark:border-gray-600 rounded-lg text-center bg-gray-50 dark:bg-gray-700">
                    <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-history text-2xl text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">রিয়েল-টাইম ডাটা</h3>
                    <p class="text-gray-600 dark:text-gray-300">সর্বাধিক আপডেটেড ডাটা দিয়ে গ্রাহকের আচরণ বিশ্লেষণ করুন এবং সঠিক সিদ্ধান্ত নিন।</p>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">বাংলাদেশে কুরিয়ার ফ্রড সম্পর্কে জানুন</h3>
                <p class="mb-4 text-gray-700 dark:text-gray-300">বাংলাদেশে প্রতি বছর হাজার হাজার ব্যবসায়ী কুরিয়ার ফ্রডের শিকার হন। কুরিয়ার ফ্রড হল যখন একজন গ্রাহক ইচ্ছাকৃতভাবে পণ্য গ্রহণ করে না বা ডেলিভারি বাতিল করে। এর ফলে ব্যবসায়ীদের আর্থিক ক্ষতি হয় এবং সময় নষ্ট হয়।</p>
                <p class="mb-4 text-gray-700 dark:text-gray-300">FraudShield আপনাকে একটি গ্রাহকের পূর্ববর্তী ডেলিভারি ইতিহাস দেখার সুযোগ দেয়, যাতে আপনি সিদ্ধান্ত নিতে পারেন যে তাদের কাছে পণ্য পাঠানো নিরাপদ কিনা।</p>
                <p class="text-gray-700 dark:text-gray-300">আমাদের সিস্টেম বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিসের ডাটা ব্যবহার করে এবং একটি বিশ্বস্ত ফ্রড স্কোর প্রদান করে।</p>
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

    <div class="fixed bottom-8 right-8 z-50">
        <a href="{{ route('download.page') }}" class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-3 rounded-full font-semibold hover:shadow-lg hover:opacity-90 transition duration-300 shadow-xl animate-pulse">
          <i class="fas fa-download"></i>
          <span>অ্যাপ ডাউনলোড করুন</span>
        </a>
      </div>
@endsection

@section('scripts')
<script>
// Initialize Chart.js chart
let dataChart;

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
    if(successRatio == 0 && summary.total_parcel == 0) {
        rating.textContent = 'New';
        ratingMessage.textContent = 'This customer is new and has no delivery history.';
        riskIndicator.className = 'mt-6 text-center py-3 px-4 rounded-lg text-white bg-gray-500 flex items-center justify-center';
        riskIndicator.innerHTML = '<i class="fas fa-question-circle mr-2"></i> <span>No Data Available</span>';
        quoteBox.textContent = '"Reliability is the foundation of trust. This customer\'s no record to speaks volumes."';

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
        riskIndicator.innerHTML = '<i class="fas fa-check-circle mr-2"></i> <span>Low Risk</span>';
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
        riskIndicator.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i> <span>Medium Risk</span>';
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
        riskIndicator.innerHTML = '<i class="fas fa-times-circle mr-2"></i> <span>High Risk</span>';
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

        // Get courier name and logo
        const courierName = stats.name || courier.charAt(0).toUpperCase() + courier.slice(1);
        const courierLogo = stats.logo || '';
        
        // Build courier cell with logo if available
        let courierCell = '';
        if (courierLogo) {
            courierCell = `
                <div class="flex items-center gap-2">
                    <img src="${courierLogo}" alt="${courierName}" class="w-6 h-6 object-contain rounded" onerror="this.style.display='none'">
                    <span>${courierName}</span>
                </div>
            `;
        } else {
            courierCell = courierName;
        }

        row.innerHTML = `
            <td class="py-3 px-4">${courierCell}</td>
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
    }
}

function displayReviews(reviews) {
    const reviewsList = document.getElementById('reviewsList');
    const noReviewsMsg = document.getElementById('noReviewsMsg');
    
    if (!reviews || reviews.length === 0) {
        noReviewsMsg.classList.remove('hidden');
        reviewsList.classList.add('hidden');
        return;
    }
    
    // Hide no reviews message and show reviews list
    noReviewsMsg.classList.add('hidden');
    reviewsList.classList.remove('hidden');
    
    // Clear previous reviews
    reviewsList.innerHTML = '';
    
    // Add each review
    reviews.forEach(review => {
        const reviewElement = createReviewElement(review);
        reviewsList.appendChild(reviewElement);
    });
}

// Function to create a review element
function createReviewElement(review) {
    const reviewDiv = document.createElement('div');
    reviewDiv.className = 'bg-gray-50 dark:bg-gray-700 p-4 rounded-lg';
    
    // Format date
    const reviewDate = new Date(review.created_at);
    const formattedDate = reviewDate.toLocaleDateString('bn-BD', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    // Generate star rating HTML
    let starsHtml = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= review.rating) {
            starsHtml += '<i class="fas fa-star text-yellow-500"></i>';
        } else {
            starsHtml += '<i class="far fa-star text-gray-400"></i>';
        }
    }

    // Create a function to mask the phone number
    function maskPhoneNumber(phone) {
        if (!phone || phone.length < 4) return phone;
        
        // Keep the first 3 digits and last 2 digits visible
        const firstPart = phone.substring(0, 3);
        const lastPart = phone.substring(phone.length - 2);
        
        // Replace the middle with asterisks
        const maskedPart = '*'.repeat(phone.length - 5);
        
        return firstPart + maskedPart + lastPart;
    }

    // Then update your HTML template
    reviewDiv.innerHTML = `
        <div class="flex justify-between items-start mb-2">
            <div>
                <h4 class="font-semibold">${review.name} (${maskPhoneNumber(review.commenter_phone)})</h4>
                <div class="text-sm text-yellow-500 my-1">
                    ${starsHtml}
                </div>
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400">
                ${formattedDate}
            </div>
        </div>
        <p class="text-gray-700 dark:text-gray-300">${review.comment}</p>
    `;
    
    return reviewDiv;
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
        
        const response = await axios.post('/courier-check', { phone }, {
            headers: {
                'Authorization': 'Bearer YOUR_BEARER_TOKEN_HERE',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
       
        const data = response.data;
        
        document.getElementById('searchButton').disabled = false;
        
        // Hide loading and show results
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('resultsContainer').classList.remove('hidden');
        
        // Update UI with data
        updateUI(data);

        try {
            const response = await axios.get(`/customer-reviews/${phone}`, {
                headers: {
                    'Authorization': 'Bearer YOUR_BEARER_TOKEN_HERE',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const reviews = response.data.data;
           
            await new Promise(resolve => setTimeout(resolve, 2000));
            
            if (reviews.length > 0) {
                displayReviews(reviews);
            } else {
                document.getElementById('noReviewsMsg').classList.remove('hidden');
                document.getElementById('reviewsList').classList.add('hidden');
            }
            
        } catch (error) {
            console.error('Error fetching reviews:', error);
            document.getElementById('noReviewsMsg').classList.remove('hidden');
            document.getElementById('reviewsList').classList.add('hidden');
        }
        
        // Refresh search statistics after successful search
        if (typeof refreshStatsAfterSearch === 'function') {
            refreshStatsAfterSearch();
        }
        
    } catch (error) {
        document.getElementById('searchButton').disabled = false;
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('emptyState').classList.remove('hidden');
        
        // Check if it's a rate limit error (429 status)
        if (error.response && error.response.status === 429) {
            const rateLimitData = error.response.data;
            
            // Check if subscription plans are available in response
            const hasSubscriptionPlans = rateLimitData.subscription_available && rateLimitData.subscription_plans;
            
            // Show detailed modal with rate limit information and subscription options
            const rateLimitModal = `
                <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="rateLimitModal">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-lg w-full mx-4 shadow-2xl">
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">দৈনিক সার্চ সীমা অতিক্রম</h3>
                            <div class="text-left space-y-2 mb-6">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <strong>দৈনিক সীমা:</strong> ${rateLimitData.limit} টি সার্চ
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <strong>ব্যবহৃত:</strong> ${rateLimitData.used} টি সার্চ
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <strong>রিসেট হবে:</strong> ${new Date(rateLimitData.reset_time).toLocaleString('bn-BD')}
                                </p>
                            </div>
                            
                            ${hasSubscriptionPlans ? `
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-lg mb-6 border border-indigo-200">
                                <h4 class="font-bold text-indigo-800 mb-3">
                                    <i class="fas fa-infinity mr-2"></i>
                                    সীমাহীন সার্চের জন্য সাবস্ক্রাইব করুন
                                </h4>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="bg-white p-3 rounded-lg border border-indigo-100">
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-indigo-600">৳২০</div>
                                            <div class="text-sm text-gray-600">১ দিন</div>
                                            <div class="text-xs text-gray-500">সীমাহীন সার্চ</div>
                                        </div>
                                    </div>
                                    <div class="bg-white p-3 rounded-lg border border-indigo-100 ring-2 ring-indigo-500">
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-indigo-600">৳৫০</div>
                                            <div class="text-sm text-gray-600">১৫ দিন</div>
                                            <div class="text-xs text-green-600 font-medium">সাশ্রয়ী</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ` : `
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg mb-6">
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    আরও বেশি সার্চের জন্য আমাদের প্ল্যান দেখুন অথবা আগামীকাল আবার চেষ্টা করুন।
                                </p>
                            </div>
                            `}
                            
                            <div class="flex space-x-2">
                                <button onclick="document.getElementById('rateLimitModal').remove()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-3 rounded-lg font-medium transition duration-200 text-sm">
                                    বুঝেছি
                                </button>
                                ${hasSubscriptionPlans ? `
                                <a href="/website-subscriptions" class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-2 px-3 rounded-lg font-medium text-center transition duration-200 text-sm">
                                    <i class="fas fa-infinity mr-1"></i>
                                    সীমাহীন সার্চ
                                </a>
                                ` : `
                                <a href="/pricing" class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-2 px-3 rounded-lg font-medium text-center transition duration-200 text-sm">
                                    API প্ল্যান দেখুন
                                </a>
                                `}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', rateLimitModal);
            
        } else {
            // Regular error message for other types of errors
            Toastify({
                text: "ডাটা লোড করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।",
                className: "error",
                style: {
                    background: "linear-gradient(to right, red, red)",
                }
            }).showToast();
        }
        
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

// FAQ functionality
document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.faq-question');
      
    questions.forEach(question => {
        question.addEventListener('click', () => {
            const answer = question.nextElementSibling;
            const icon = question.querySelector('.faq-icon svg');
            const isCurrentlyOpen = answer.classList.contains('show');
            
            // Close all other answers first
            questions.forEach(otherQuestion => {
                const otherAnswer = otherQuestion.nextElementSibling;
                const otherIcon = otherQuestion.querySelector('.faq-icon svg');
                if (otherAnswer !== answer) {
                    otherAnswer.classList.remove('show');
                    otherIcon.innerHTML = '<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>';
                }
            });
            
            // Toggle current answer
            if (isCurrentlyOpen) {
                answer.classList.remove('show');
                icon.innerHTML = '<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>';
            } else {
                answer.classList.add('show');
                icon.innerHTML = '<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>';
            }
        });
    });

    // Rating and comment system functionality
    const ratingStars = document.querySelectorAll('.rating-star');
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            document.getElementById('ratingValue').value = rating;
            
            // Update star display
            ratingStars.forEach(s => {
                const starRating = parseInt(s.getAttribute('data-rating'));
                if (starRating <= rating) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                    s.classList.add('text-yellow-500');
                } else {
                    s.classList.remove('fas');
                    s.classList.remove('text-yellow-500');
                    s.classList.add('far');
                }
            });
        });
    });

    // Open rating modal
    const addReviewBtn = document.getElementById('addReviewBtn');
    const ratingModal = document.getElementById('ratingModal');
    
    if (addReviewBtn) {
        addReviewBtn.addEventListener('click', function() {
            // Set the current phone number in the modal
            const phoneNumber = document.getElementById('phoneInput').value;
            document.getElementById('ratingPhoneNumber').textContent = phoneNumber;
            
            // Show modal
            ratingModal.classList.remove('hidden');
            
            // Reset form
            document.getElementById('ratingForm').reset();
            ratingStars.forEach(s => {
                s.classList.remove('fas');
                s.classList.remove('text-yellow-500');
                s.classList.add('far');
            });
            document.getElementById('ratingValue').value = 0;
        });
    }

    // Close rating modal
    const closeRatingModal = document.getElementById('closeRatingModal');
    if (closeRatingModal) {
        closeRatingModal.addEventListener('click', function() {
            ratingModal.classList.add('hidden');
        });
    }

    // Click outside to close modal
    window.addEventListener('click', function(event) {
        if (event.target === ratingModal) {
            ratingModal.classList.add('hidden');
        }
    });

    // Handle form submission
    const ratingForm = document.getElementById('ratingForm');
    if (ratingForm) {
        ratingForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            
            const phoneNumber = document.getElementById('phoneInput').value;
            const ownNumber = document.getElementById('ownNumber').value;
            const userName = document.getElementById('userName').value;
            const rating = document.getElementById('ratingValue').value;
            const comment = document.getElementById('userComment').value;
            
            if (!phoneNumber || !userName || rating === '0' || !comment) {
                Toastify({
                    text: "সব তথ্য পূরণ করুন",
                    className: "error",
                    style: {
                        background: "linear-gradient(to right, red, red)",
                    }
                }).showToast();
                return;
            }
            
            try {
                // Show loading state
                const submitBtn = ratingForm.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> অপেক্ষা করুন...';
                submitBtn.disabled = true;
                
                const response = await axios.post('/customer-review', {
                    phone: phoneNumber,
                    ownNumber: ownNumber,
                    name: userName,
                    rating: rating,
                    comment: comment
                }, {
                    headers: {
                        'Authorization': 'Bearer YOUR_BEARER_TOKEN_HERE',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                const reviews = response.data.data;
                addReviewToUI(reviews);
                
                // Hide modal
                ratingModal.classList.add('hidden');
                
                // Show success message
                Toastify({
                    text: "আপনার রিভিউ সফলভাবে যোগ করা হয়েছে!",
                    className: "success",
                    style: {
                        background: "linear-gradient(to right, #10b981, #059669)",
                    }
                }).showToast();
                
                // Reset form and button
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
                ratingForm.reset();
                
            } catch (error) {
                console.error('Error submitting review:', error);
                
                Toastify({
                    text: error.response?.data?.message || "কিছু ভুল হয়েছে। আবার চেষ্টা করুন।",
                    className: "error",
                    style: {
                        background: "linear-gradient(to right, red, red)",
                    }
                }).showToast();
                
                // Reset button
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
                ratingForm.reset();
            }
        });
    }
    
    // Function to add a new review to the UI
    function addReviewToUI(review) {
        const reviewsList = document.getElementById('reviewsList');
        const noReviewsMsg = document.getElementById('noReviewsMsg');
        
        // Hide no reviews message and show reviews list
        noReviewsMsg.classList.add('hidden');
        reviewsList.classList.remove('hidden');
        
        // Create and add the new review to the top of the list
        const reviewElement = createReviewElement(review);
        reviewsList.insertBefore(reviewElement, reviewsList.firstChild);
    }
});

// Search Statistics functionality
let searchStatsInterval;

// Bengali number conversion function
function convertToBengaliNumbers(number) {
    const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    return number.toString().replace(/[0-9]/g, function(digit) {
        return bengaliDigits[parseInt(digit)];
    });
}

// Function to format number with commas and convert to Bengali
function formatBengaliNumber(number) {
    const formattedNumber = Math.round(number).toLocaleString('en-US');
    return convertToBengaliNumbers(formattedNumber);
}

// Function to load search statistics
async function loadSearchStatistics() {
    try {
        const response = await fetch('/api/search-stats');
        const result = await response.json();
        
        if (result.success) {
            const data = result.data;
            
            // Update the counters with animation
            animateCounter('lastHourCount', data.last_hour);
            animateCounter('lastDayCount', data.today);
            animateCounter('allTimeCount', data.all_time);
            animateCounter('uniqueNumbersCount', data.unique_numbers);
            
            // Update last updated time in Bengali using Bangladesh time from API
            if (data.bangladesh_time) {
                const bangladeshTime = new Date(data.bangladesh_time + '+06:00'); // Ensure timezone is applied
                const bengaliMonths = [
                    'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
                    'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'
                ];
                
                const day = convertToBengaliNumbers(bangladeshTime.getDate());
                const month = bengaliMonths[bangladeshTime.getMonth()];
                const year = convertToBengaliNumbers(bangladeshTime.getFullYear());
                const hours = convertToBengaliNumbers(bangladeshTime.getHours().toString().padStart(2, '0'));
                const minutes = convertToBengaliNumbers(bangladeshTime.getMinutes().toString().padStart(2, '0'));
                const seconds = convertToBengaliNumbers(bangladeshTime.getSeconds().toString().padStart(2, '0'));
                
                const timeString = `${day} ${month} ${year}, ${hours}:${minutes}:${seconds} (বাংলাদেশ সময়)`;
                document.getElementById('lastUpdated').textContent = timeString;
            } else {
                // Fallback to local time if Bangladesh time not available
                const now = new Date();
                const bengaliMonths = [
                    'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
                    'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'
                ];
                
                const day = convertToBengaliNumbers(now.getDate());
                const month = bengaliMonths[now.getMonth()];
                const year = convertToBengaliNumbers(now.getFullYear());
                const hours = convertToBengaliNumbers(now.getHours().toString().padStart(2, '0'));
                const minutes = convertToBengaliNumbers(now.getMinutes().toString().padStart(2, '0'));
                const seconds = convertToBengaliNumbers(now.getSeconds().toString().padStart(2, '0'));
                
                const timeString = `${day} ${month} ${year}, ${hours}:${minutes}:${seconds}`;
                document.getElementById('lastUpdated').textContent = timeString;
            }
        }
    } catch (error) {
        console.error('Error loading search statistics:', error);
        // Show error state in Bengali
        ['lastHourCount', 'lastDayCount', 'allTimeCount', 'uniqueNumbersCount'].forEach(id => {
            document.getElementById(id).textContent = 'ত্রুটি';
        });
    }
}

// Function to animate counter with Bengali number formatting
function animateCounter(elementId, targetValue) {
    const element = document.getElementById(elementId);
    const startValue = parseInt(element.textContent.replace(/[^\d]/g, '')) || 0;
    const duration = 1000; // 1 second
    const steps = 50;
    const stepValue = (targetValue - startValue) / steps;
    let currentValue = startValue;
    let step = 0;

    const timer = setInterval(() => {
        step++;
        currentValue += stepValue;
        
        if (step >= steps) {
            currentValue = targetValue;
            clearInterval(timer);
        }
        
        // Format number with commas and convert to Bengali
        const bengaliFormattedValue = formatBengaliNumber(currentValue);
        element.textContent = bengaliFormattedValue;
    }, duration / steps);
}

// Initialize search statistics when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Load initial data
    loadSearchStatistics();
    
    // Set up automatic refresh every 30 seconds
    searchStatsInterval = setInterval(loadSearchStatistics, 30000);
});

// Refresh statistics when a new search is performed
function refreshStatsAfterSearch() {
    // Add a small delay to ensure the backend has processed the search
    setTimeout(() => {
        loadSearchStatistics();
    }, 1000);
}

// Clean up interval when page is about to unload
window.addEventListener('beforeunload', function() {
    if (searchStatsInterval) {
        clearInterval(searchStatsInterval);
    }
});

// Add visibility change listener to pause/resume updates when tab is not active
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        // Page is hidden, clear interval
        if (searchStatsInterval) {
            clearInterval(searchStatsInterval);
        }
    } else {
        // Page is visible, restart interval
        loadSearchStatistics();
        searchStatsInterval = setInterval(loadSearchStatistics, 30000);
    }
});
</script>
@endsection