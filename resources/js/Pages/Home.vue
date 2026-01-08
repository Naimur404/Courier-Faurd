<script setup lang="ts">
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import NavBar from '@/components/landing/NavBar.vue';
import HeroSection from '@/components/landing/HeroSection.vue';
import SearchSection from '@/components/landing/SearchSection.vue';
import FeaturesSection from '@/components/landing/FeaturesSection.vue';
import ROICalculator from '@/components/landing/ROICalculator.vue';
import IntegrationsSection from '@/components/landing/IntegrationsSection.vue';
import CouriersSection from '@/components/landing/CouriersSection.vue';
import PricingSection from '@/components/landing/PricingSection.vue';
import WebsiteSubscriptionSection from '@/components/landing/WebsiteSubscriptionSection.vue';
import SupportSection from '@/components/landing/SupportSection.vue';
import FooterSection from '@/components/landing/FooterSection.vue';

// Props from controller
const props = defineProps<{
    csrfToken?: string;
}>();

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
        <meta name="keywords" content="FraudShield, courier fraud, কুরিয়ার ফ্রড, fraud detection, ফ্রড ডিটেকশন, মোবাইল নাম্বার, bulk search, বাল্ক সার্চ, API, বাংলাদেশ কুরিয়ার, steadfast, pathao, redx, paperfly" />
        
        <!-- Canonical URL -->
        <link rel="canonical" href="https://fraudshieldbd.site/" />
        
        <!-- OpenGraph Meta Tags -->
        <meta property="og:title" content="FraudShield - রিটার্ন কমান, খরচ বাঁচান | কুরিয়ার ফ্রড ডিটেকশন" />
        <meta property="og:description" content="বাংলাদেশের প্রথম ও দ্রুততম কুরিয়ার ফ্রড ডিটেকশন প্ল্যাটফর্ম। বাল্ক সার্চ ≤৫০০, API ইন্টিগ্রেশন।" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://fraudshieldbd.site/" />
        <meta property="og:site_name" content="FraudShield" />
        <meta property="og:locale" content="bn_BD" />
        <meta property="og:image" content="https://fraudshieldbd.site/assets/og-image.png" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        
        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="FraudShield - রিটার্ন কমান, খরচ বাঁচান" />
        <meta name="twitter:description" content="বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন প্ল্যাটফর্ম।" />
        <meta name="twitter:image" content="https://fraudshieldbd.site/assets/og-image.png" />
        
        <!-- Additional SEO Meta Tags -->
        <meta name="robots" content="index, follow, max-image-preview:large" />
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
        
        <!-- Support Section -->
        <SupportSection />
        
        <!-- Footer -->
        <FooterSection />
    </div>
</template>
