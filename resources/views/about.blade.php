@extends('layouts.app')

@section('title', 'About Us - FraudShield বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Courier Fraud Detection')

@section('description', 'FraudShield সম্পর্কে জানুন - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। আমাদের মিশন, দল এবং সেবা সম্পর্কে বিস্তারিত তথ্য।')

@section('keywords', 'about fraudshield, courier fraud bangladesh, fraud detection team, bangladeshi courier security, কুরিয়ার নিরাপত্তা, ফ্রডশিল্ড টিম')

@section('og_url', 'https://fraudshieldbd.site/about')
@section('og_title', 'About FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Bangladesh Courier Security')
@section('og_description', 'FraudShield সম্পর্কে জানুন - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। আমাদের মিশন হল আপনার ব্যবসাকে কুরিয়ার ফ্রড থেকে সুরক্ষিত রাখা।')

@section('twitter_url', 'https://fraudshieldbd.site/about')
@section('twitter_title', 'About FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Bangladesh Courier Security')
@section('twitter_description', 'FraudShield সম্পর্কে জানুন - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। আমাদের মিশন হল আপনার ব্যবসাকে কুরিয়ার ফ্রড থেকে সুরক্ষিত রাখা।')

@section('canonical', 'https://fraudshieldbd.site/about')

@section('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম",
  "url": "https://fraudshieldbd.site",
  "logo": "{{asset('assets/banner.jpg')}}",
  "description": "FraudShield বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। আমাদের মিশন হল ব্যবসায়িক প্রতিষ্ঠানগুলোকে কুরিয়ার ফ্রড থেকে সুরক্ষিত রাখা।",
  "sameAs": [
    "https://facebook.com/fraudshieldbd",
    "https://twitter.com/fraudshieldbd"
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+8801309092748",
    "contactType": "customer service",
    "availableLanguage": ["Bengali", "English"]
  },
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Chittagong",
    "addressCountry": "BD"
  }
}
</script>
@endsection

@section('content')

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-6 animate-in">
                FraudShield সম্পর্কে জানুন
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-4xl mx-auto opacity-90 animate-in" style="animation-delay: 0.1s">
                বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম - আপনার ব্যবসাকে নিরাপদ রাখতে আমরা প্রতিশ্রুতিবদ্ধ
            </p>
            <div class="flex justify-center flex-wrap gap-6 text-lg animate-in" style="animation-delay: 0.2s">
                <div class="flex items-center">
                    <i class="fas fa-shield-check text-2xl mr-2 text-yellow-400"></i>
                    <span>নিরাপদ যাচাইকরণ</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-users text-2xl mr-2 text-yellow-400"></i>
                    <span>গ্রাহক সুরক্ষা</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-clock text-2xl mr-2 text-yellow-400"></i>
                    <span>২৪/৭ মনিটরিং</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-chart-line text-2xl mr-2 text-yellow-400"></i>
                    <span>রিয়েল-টাইম ডাটা</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="animate-in">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-gray-100 mb-6">
                        আমাদের লক্ষ্য
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 text-lg mb-6 leading-relaxed">
                        আমরা অনলাইন বাণিজ্যের জন্য একটি নিরাপদ পরিবেশ তৈরি করতে প্রতিশ্রুতিবদ্ধ যেখানে বিস্তৃত 
                        কুরিয়ার যাচাইকরণ সেবা প্রদান করা হয়। আমাদের লক্ষ্য হল ফ্রড নির্মূল করা এবং গ্রাহক ও 
                        কুরিয়ার সেবার মধ্যে বিশ্বাস তৈরি করা।
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3 mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">রিয়েল-টাইম যাচাইকরণ</h3>
                                <p class="text-gray-600 dark:text-gray-300">কুরিয়ার সত্যতা এবং ডেলিভারি স্ট্যাটাসের তাৎক্ষণিক যাচাই</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3 mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">ফ্রড প্রতিরোধ</h3>
                                <p class="text-gray-600 dark:text-gray-300">প্রতারণামূলক কার্যকলাপ সনাক্ত এবং প্রতিরোধের জন্য উন্নত অ্যালগোরিদম</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3 mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">গ্রাহক নিরাপত্তা</h3>
                                <p class="text-gray-600 dark:text-gray-300">সমস্ত কুরিয়ার লেনদেনের জন্য ব্যাপক সুরক্ষা</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center animate-in" style="animation-delay: 0.1s">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-custom p-8 hover-scale">
                        <i class="fas fa-shield-alt text-indigo-600 dark:text-indigo-400 text-6xl mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">হাজারো ব্যবহারকারীর বিশ্বাস</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">নিরাপদ কুরিয়ার যাচাইকরণের জন্য আমাদের প্ল্যাটফর্মে বিশ্বাস রাখেন হাজার হাজার সন্তুষ্ট গ্রাহক</p>
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div>
                                <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400" id="total-searches-about">০</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">মোট যাচাইকরণ</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-green-600 dark:text-green-400">৯৯.৯%</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">নিরাপত্তার হার</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-gray-100 dark:bg-gray-800 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-in">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                    কেন আমাদের বেছে নিবেন?
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    কুরিয়ার ফ্রড থেকে আপনাকে রক্ষা করতে আমরা ব্যাপক নিরাপত্তা সমাধান প্রদান করি
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-custom p-8 hover-scale animate-in" style="animation-delay: 0.1s">
                    <div class="text-center mb-6">
                        <i class="fas fa-search text-indigo-600 dark:text-indigo-400 text-4xl mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">উন্নত অনুসন্ধান</h3>
                        <p class="text-gray-600 dark:text-gray-300">কুরিয়ার তথ্য তাৎক্ষণিকভাবে যাচাই করার শক্তিশালী অনুসন্ধান ক্ষমতা</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-custom p-8 hover-scale animate-in" style="animation-delay: 0.2s">
                    <div class="text-center mb-6">
                        <i class="fas fa-database text-green-600 dark:text-green-400 text-4xl mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">বিস্তৃত ডাটাবেস</h3>
                        <p class="text-gray-600 dark:text-gray-300">যাচাইকৃত কুরিয়ার সেবা এবং ডেলিভারি কর্মীদের বিস্তৃত ডাটাবেস</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-custom p-8 hover-scale animate-in" style="animation-delay: 0.3s">
                    <div class="text-center mb-6">
                        <i class="fas fa-mobile-alt text-purple-600 dark:text-purple-400 text-4xl mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">মোবাইল অ্যাপ</h3>
                        <p class="text-gray-600 dark:text-gray-300">চলাফেরার সময় কুরিয়ার যাচাইকরণের জন্য আমাদের মোবাইল অ্যাপ ডাউনলোড করুন</p>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('download.page') }}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-download mr-2"></i>অ্যাপ ডাউনলোড করুন
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-in">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                    আমাদের দল
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    সবার জন্য কুরিয়ার সেবা নিরাপদ করতে কাজ করে যাওয়া নিবেদিতপ্রাণ পেশাদাররা
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center animate-in" style="animation-delay: 0.1s">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-custom p-8 hover-scale">
                        <div class="w-24 h-24 bg-indigo-100 dark:bg-indigo-900 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-user-tie text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">নিরাপত্তা দল</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">প্ল্যাটফর্মের নিরাপত্তা নিশ্চিত করতে দক্ষ সাইবার নিরাপত্তা পেশাদাররা</p>
                        <div class="flex justify-center space-x-3">
                            <i class="fab fa-linkedin text-indigo-600 dark:text-indigo-400 text-lg"></i>
                            <i class="fab fa-twitter text-blue-400 text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="text-center animate-in" style="animation-delay: 0.2s">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-custom p-8 hover-scale">
                        <div class="w-24 h-24 bg-green-100 dark:bg-green-900 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-code text-green-600 dark:text-green-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">ডেভেলপমেন্ট দল</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">উদ্ভাবনী যাচাইকরণ সমাধান তৈরিতে দক্ষ ডেভেলপাররা</p>
                        <div class="flex justify-center space-x-3">
                            <i class="fab fa-github text-gray-800 dark:text-gray-300 text-lg"></i>
                            <i class="fab fa-gitlab text-orange-600 text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="text-center animate-in" style="animation-delay: 0.3s">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-custom p-8 hover-scale">
                        <div class="w-24 h-24 bg-purple-100 dark:bg-purple-900 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-headset text-purple-600 dark:text-purple-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">সাপোর্ট দল</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">যেকোনো যাচাইকরণ প্রয়োজনে সহায়তার জন্য ২৪/৭ গ্রাহক সেবা</p>
                        <div class="flex justify-center space-x-3">
                            <i class="fas fa-phone text-green-600 text-lg"></i>
                            <i class="fas fa-envelope text-indigo-600 dark:text-indigo-400 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="bg-gradient-to-r from-indigo-800 to-purple-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-in">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    যোগাযোগ করুন
                </h2>
                <p class="text-xl text-indigo-200 max-w-3xl mx-auto">
                    আমাদের সেবা সম্পর্কে প্রশ্ন আছে? আপনাকে নিরাপদ রাখতে আমরা এখানে আছি
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center animate-in" style="animation-delay: 0.1s">
                    <div class="bg-gray-700 bg-opacity-50 rounded-xl p-8 hover-scale">
                        <i class="fas fa-envelope text-blue-400 text-3xl mb-4"></i>
                        <h3 class="text-xl font-bold mb-2">ইমেইল সাপোর্ট</h3>
                        <p class="text-indigo-200 mb-4">ইমেইলের মাধ্যমে সহায়তা পান</p>
                        <a href="mailto:info@fraudshield.com" class="text-blue-400 hover:text-blue-300">
                            info@fraudshield.com
                        </a>
                    </div>
                </div>
                <div class="text-center animate-in" style="animation-delay: 0.2s">
                    <div class="bg-gray-700 bg-opacity-50 rounded-xl p-8 hover-scale">
                        <i class="fas fa-phone text-green-400 text-3xl mb-4"></i>
                        <h3 class="text-xl font-bold mb-2">ফোন সাপোর্ট</h3>
                        <p class="text-indigo-200 mb-4">যেকোনো সময় আমাদের কল করুন</p>
                        <a href="tel:+8801309092748" class="text-green-400 hover:text-green-300">
                            +৮৮০ ১৩০৯-০৯২৭৪৮
                        </a>
                    </div>
                </div>
                <div class="text-center animate-in" style="animation-delay: 0.3s">
                    <div class="bg-gray-700 bg-opacity-50 rounded-xl p-8 hover-scale">
                        <i class="fas fa-map-marker-alt text-red-400 text-3xl mb-4"></i>
                        <h3 class="text-xl font-bold mb-2">অফিসের ঠিকানা</h3>
                        <p class="text-indigo-200 mb-4">আমাদের অফিসে আসুন</p>
                        <p class="text-indigo-200">
                            চট্টগ্রাম, বাংলাদেশ
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    // Load search statistics for about page
    async function loadSearchStats() {
        try {
            const response = await fetch('/api/search-stats');
            const result = await response.json();
            
            if (result.success) {
                const data = result.data;
                const totalSearchesElement = document.getElementById('total-searches-about');
                if (totalSearchesElement && data.all_time) {
                    totalSearchesElement.textContent = formatBengaliNumber(data.all_time);
                }
            }
        } catch (error) {
            console.error('Failed to load search statistics:', error);
            const totalSearchesElement = document.getElementById('total-searches-about');
            if (totalSearchesElement) {
                totalSearchesElement.textContent = 'ত্রুটি';
            }
        }
    }

    // Load stats when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadSearchStats();
    });
</script>
@endsection