<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import NavBar from '@/components/landing/NavBar.vue';
import HeroSection from '@/components/landing/HeroSection.vue';
import SearchSection from '@/components/landing/SearchSection.vue';
import FeaturesSection from '@/components/landing/FeaturesSection.vue';
import ROICalculator from '@/components/landing/ROICalculator.vue';
import IntegrationsSection from '@/components/landing/IntegrationsSection.vue';
import CouriersSection from '@/components/landing/CouriersSection.vue';
import PricingSection from '@/components/landing/PricingSection.vue';
import WebsiteSubscriptionSection from '@/components/landing/WebsiteSubscriptionSection.vue';
import FAQSection from '@/components/landing/FAQSection.vue';
import AboutSection from '@/components/landing/AboutSection.vue';
import SupportSection from '@/components/landing/SupportSection.vue';
import FooterSection from '@/components/landing/FooterSection.vue';

// Props from controller
const props = defineProps<{
    csrfToken?: string;
}>();

const page = usePage();

// Toast notification function
const displayToast = (message: string, type: 'success' | 'error' | 'warning' = 'success') => {
  const toast = document.createElement('div')
  const colors = {
    success: 'bg-green-500',
    error: 'bg-red-500',
    warning: 'bg-yellow-500'
  }
  const icons = {
    success: 'check-circle',
    error: 'times-circle',
    warning: 'exclamation-circle'
  }
  toast.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300 flex items-center`
  toast.innerHTML = `<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="${type === 'success' ? 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' : type === 'error' ? 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z' : 'M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z'}" clip-rule="evenodd"/></svg>${message}`
  document.body.appendChild(toast)
  
  setTimeout(() => toast.classList.remove('translate-x-full'), 100)
  setTimeout(() => {
    toast.classList.add('translate-x-full')
    setTimeout(() => document.body.removeChild(toast), 300)
  }, 3000)
}

// Show flash messages on mount
onMounted(() => {
  const flash = page.props.flash as { success?: string; error?: string; message?: string } | undefined
  if (flash?.success) {
    displayToast(flash.success, 'success')
  }
  if (flash?.error) {
    displayToast(flash.error, 'error')
  }
  if (flash?.message) {
    displayToast(flash.message, 'success')
  }
})

// Search phone state
const searchPhone = ref<{ phone: string; timestamp: number } | null>(null);

const handleSearch = (phone: string) => {
    // Set the phone number with timestamp to always trigger watch
    searchPhone.value = { phone, timestamp: Date.now() };
};
</script>

<template>
    <Head>
        <title>FraudShield - রিটার্ন কমান, খরচ বাঁচান | বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন</title>
        <meta name="description" content="FraudShield - বাংলাদেশের প্রথম ও দ্রুততম কুরিয়ার ফ্রড ডিটেকশন প্ল্যাটফর্ম। বাল্ক সার্চ, API ইন্টিগ্রেশন, রিয়েল-টাইম রিপোর্ট। রিটার্ন কমান, খরচ বাঁচান।" />
        <meta name="keywords" content="FraudShield, courier fraud, কুরিয়ার ফ্রড, fraud detection, ফ্রড ডিটেকশন, মোবাইল নাম্বার, mobile number check, ডেলিভারি ইতিহাস, delivery history, গ্রাহক যাচাই, customer verification, রিস্ক স্কোর, risk score, বাংলাদেশ কুরিয়ার, bangladesh courier, courier check bd, courier checker, sundarban courier tracking, কুরিয়ার চেকার, সুন্দরবন কুরিয়ার ট্র্যাকিং, bulk search, বাল্ক সার্চ, API, steadfast, pathao, redx, paperfly" />
        
        <!-- Canonical URL -->
        <link rel="canonical" href="https://fraudshieldbd.site/" />
        
        <!-- OpenGraph Meta Tags -->
        <meta property="og:title" content="FraudShield - কুরিয়ার ফ্রড চেক | বাংলাদেশী ফ্রড ডিটেকশন" />
        <meta property="og:description" content="মোবাইল নাম্বার দিয়ে কুরিয়ার ফ্রড চেক করুন। গ্রাহকের ডেলিভারি ইতিহাস দেখুন। বাল্ক সার্চ ≤৫০০, API ইন্টিগ্রেশন।" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://fraudshieldbd.site/" />
        <meta property="og:site_name" content="FraudShield" />
        <meta property="og:locale" content="bn_BD" />
        <meta property="og:image" content="https://fraudshieldbd.site/assets/og-image.png" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:image:alt" content="FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম" />
        
        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="FraudShield - কুরিয়ার ফ্রড চেক | বাংলাদেশী ফ্রড ডিটেকশন" />
        <meta name="twitter:description" content="মোবাইল নাম্বার দিয়ে কুরিয়ার ফ্রড চেক করুন। গ্রাহকের ডেলিভারি ইতিহাস দেখুন।" />
        <meta name="twitter:image" content="https://fraudshieldbd.site/assets/og-image.png" />
        
        <!-- Additional SEO Meta Tags -->
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
        <meta name="author" content="Tyrodevs" />
        <meta name="geo.region" content="BD" />
        <meta name="geo.placename" content="Bangladesh" />
    </Head>

    <div class="min-h-screen bg-white dark:bg-slate-900">
        <!-- Navigation Bar -->
        <NavBar />
        
        <!-- Hero Section -->
        <HeroSection @search="handleSearch" />
        
        <!-- Search Section (with integrated stats) -->
        <SearchSection :csrf-token="props.csrfToken || ''" :search-phone="searchPhone" />
        
        <!-- Features Section -->
        <FeaturesSection />
        
        <!-- ROI Calculator -->
        <ROICalculator />
        
        <!-- Integrations Section -->
        <IntegrationsSection />
        
        <!-- Couriers Section -->
        <CouriersSection />
        
        <!-- Pricing Section -->
        <PricingSection />

        <!-- Website Subscription Section -->
        <WebsiteSubscriptionSection />

        <!-- About Us Section -->
        <AboutSection />

        <!-- FAQ Section -->
        <FAQSection />
        
        <!-- Support Section -->
        <SupportSection />
        
        <!-- Footer -->
        <FooterSection />
        
        <!-- Bottom spacer for mobile navigation -->
        <div class="h-16 md:hidden" />
    </div>
</template>
