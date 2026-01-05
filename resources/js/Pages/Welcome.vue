<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/components/ui/Button.vue';
import Card from '@/components/ui/Card.vue';
import Input from '@/components/ui/Input.vue';
import Modal from '@/components/ui/Modal.vue';
import StarRating from '@/components/ui/StarRating.vue';
import Badge from '@/components/ui/Badge.vue';
import Progress from '@/components/ui/Progress.vue';
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';
import { Alert, AlertTitle, AlertDescription } from '@/components/ui/alert';
import { 
    Search, Phone, Clock, Calendar, Infinity, PhoneCall,
    Shield, TrendingUp, History, ChevronDown, ChevronUp,
    CheckCircle, XCircle, AlertCircle, HelpCircle,
    MessageSquare, Plus, Download, BarChart3, PieChart,
    Send, RefreshCw
} from 'lucide-vue-next';
import { 
    formatBengaliNumber, 
    convertToBengaliNumbers, 
    getColorForRatio,
    maskPhoneNumber,
    formatBengaliDate
} from '@/lib/utils';

// Props from controller
const props = defineProps<{
    csrfToken: string;
}>();

// Reactive state
const phoneInput = ref('');
const isSearching = ref(false);
const searchResults = ref<any>(null);
const reviews = ref<any[]>([]);
const showRatingModal = ref(false);
const showEmptyState = ref(true);

// Stats state
const stats = ref({
    lastHour: 0,
    today: 0,
    allTime: 0,
    uniqueNumbers: 0,
});
const lastUpdated = ref('লোড হচ্ছে...');
let statsInterval: number | null = null;

// Review form state
const reviewForm = ref({
    ownNumber: '',
    name: '',
    rating: 0,
    comment: '',
});
const isSubmittingReview = ref(false);

// FAQ state
const activeFaq = ref<number | null>(null);

// Computed properties
const successRatio = computed(() => {
    if (!searchResults.value?.courierData?.summary) return 0;
    return searchResults.value.courierData.summary.success_ratio || 0;
});

const riskLevel = computed(() => {
    const ratio = successRatio.value;
    const total = searchResults.value?.courierData?.summary?.total_parcel || 0;
    
    if (total === 0) return { level: 'unknown', color: 'gray', label: 'No Data Available', icon: HelpCircle };
    if (ratio >= 90) return { level: 'low', color: 'green', label: 'Low Risk', icon: CheckCircle };
    if (ratio >= 70) return { level: 'medium', color: 'yellow', label: 'Medium Risk', icon: AlertCircle };
    return { level: 'high', color: 'red', label: 'High Risk', icon: XCircle };
});

const ratingText = computed(() => {
    const ratio = successRatio.value;
    const total = searchResults.value?.courierData?.summary?.total_parcel || 0;
    
    if (total === 0) return 'New';
    if (ratio >= 90) return 'Excellent';
    if (ratio >= 70) return 'Good';
    return 'Poor';
});

const courierList = computed(() => {
    if (!searchResults.value?.courierData) return [];
    return Object.entries(searchResults.value.courierData)
        .filter(([key]) => key !== 'summary')
        .map(([courier, data]: [string, any]) => ({
            name: data.name || courier.charAt(0).toUpperCase() + courier.slice(1),
            logo: data.logo || '',
            totalParcel: data.total_parcel,
            successParcel: data.success_parcel,
            cancelledParcel: data.cancelled_parcel,
            successRatio: data.success_ratio,
        }));
});

// Methods
const loadStats = async () => {
    try {
        const response = await fetch('/api/search-stats');
        const result = await response.json();
        
        if (result.success) {
            stats.value = {
                lastHour: result.data.last_hour,
                today: result.data.today,
                allTime: result.data.all_time,
                uniqueNumbers: result.data.unique_numbers,
            };
            
            // Format last updated time in Bengali
            if (result.data.bangladesh_time) {
                const bengaliMonths = [
                    'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
                    'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'
                ];
                const date = new Date(result.data.bangladesh_time);
                const day = convertToBengaliNumbers(date.getDate());
                const month = bengaliMonths[date.getMonth()];
                const year = convertToBengaliNumbers(date.getFullYear());
                const hours = convertToBengaliNumbers(date.getHours().toString().padStart(2, '0'));
                const minutes = convertToBengaliNumbers(date.getMinutes().toString().padStart(2, '0'));
                
                lastUpdated.value = `${day} ${month} ${year}, ${hours}:${minutes} (বাংলাদেশ সময়)`;
            }
        }
    } catch (error) {
        console.error('Error loading stats:', error);
    }
};

const performSearch = async () => {
    if (!phoneInput.value) {
        (window as any).$toast?.({ message: 'Please enter a phone number', type: 'error' });
        return;
    }
    
    // Validate phone number
    const phoneRegex = /^01[0-9]{9}$/;
    if (!phoneRegex.test(phoneInput.value)) {
        (window as any).$toast?.({ message: 'Please enter a valid Bangladesh mobile number (e.g. 01600000000)', type: 'error' });
        return;
    }
    
    isSearching.value = true;
    showEmptyState.value = false;
    searchResults.value = null;
    
    try {
        const response = await fetch('/courier-check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': props.csrfToken,
            },
            body: JSON.stringify({ phone: phoneInput.value }),
        });
        
        if (response.status === 429) {
            const rateLimitData = await response.json();
            (window as any).$toast?.({ 
                message: `দৈনিক সার্চ সীমা (${rateLimitData.limit} টি) অতিক্রম করা হয়েছে।`, 
                type: 'warning' 
            });
            showEmptyState.value = true;
            return;
        }
        
        const data = await response.json();
        searchResults.value = data;
        
        // Load reviews
        await loadReviews();
        
        // Refresh stats
        await loadStats();
        
    } catch (error) {
        console.error('Search error:', error);
        (window as any).$toast?.({ message: 'ডাটা লোড করতে সমস্যা হয়েছে', type: 'error' });
        showEmptyState.value = true;
    } finally {
        isSearching.value = false;
    }
};

const loadReviews = async () => {
    try {
        const response = await fetch(`/customer-reviews/${phoneInput.value}`, {
            headers: {
                'X-CSRF-TOKEN': props.csrfToken,
            },
        });
        const data = await response.json();
        reviews.value = data.data || [];
    } catch (error) {
        console.error('Error loading reviews:', error);
        reviews.value = [];
    }
};

const submitReview = async () => {
    if (!reviewForm.value.name || !reviewForm.value.comment || reviewForm.value.rating === 0) {
        (window as any).$toast?.({ message: 'সব তথ্য পূরণ করুন', type: 'error' });
        return;
    }
    
    isSubmittingReview.value = true;
    
    try {
        const response = await fetch('/customer-review', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': props.csrfToken,
            },
            body: JSON.stringify({
                phone: phoneInput.value,
                ownNumber: reviewForm.value.ownNumber,
                name: reviewForm.value.name,
                rating: reviewForm.value.rating,
                comment: reviewForm.value.comment,
            }),
        });
        
        const data = await response.json();
        
        if (data.data) {
            reviews.value.unshift(data.data);
        }
        
        showRatingModal.value = false;
        reviewForm.value = { ownNumber: '', name: '', rating: 0, comment: '' };
        
        (window as any).$toast?.({ message: 'আপনার রিভিউ সফলভাবে যোগ করা হয়েছে!', type: 'success' });
    } catch (error) {
        console.error('Error submitting review:', error);
        (window as any).$toast?.({ message: 'কিছু ভুল হয়েছে। আবার চেষ্টা করুন।', type: 'error' });
    } finally {
        isSubmittingReview.value = false;
    }
};

const toggleFaq = (index: number) => {
    activeFaq.value = activeFaq.value === index ? null : index;
};

// FAQ data
const faqs = [
    {
        question: 'FraudShield কীভাবে কাজ করে?',
        answer: 'FraudShield বাংলাদেশের বিভিন্ন কুরিয়ার সার্ভিস থেকে ডাটা সংগ্রহ করে এবং ডেলিভারি সাফল্য, বাতিল হার এবং অন্যান্য ফ্যাক্টর ব্যবহার করে ফ্রড স্কোর তৈরি করে।',
    },
    {
        question: 'FraudShield ব্যবহার করার খরচ কত?',
        answer: 'FraudShield বর্তমানে বিনামূল্যে ব্যবহার করা যায়। ভবিষ্যতে আমরা প্রিমিয়াম প্ল্যান চালু করব যেখানে আরও উন্নত ফিচার থাকবে।',
    },
    {
        question: 'FraudShield এর ডাটা কতটা নির্ভরযোগ্য?',
        answer: 'আমরা বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিস থেকে রিয়েল-টাইম ডাটা সংগ্রহ করি এবং আমাদের এলগরিদম 95% এরও বেশি সঠিকতার সাথে ফ্রড সনাক্ত করতে পারে।',
    },
    {
        question: 'আমি কীভাবে আমার ব্যবসার জন্য FraudShield ইন্টিগ্রেট করতে পারি?',
        answer: 'আমাদের API ব্যবহার করে আপনি আপনার ওয়েবসাইট বা অ্যাপে FraudShield ইন্টিগ্রেট করতে পারেন। বিস্তারিত জানতে আমাদের সাথে যোগাযোগ করুন।',
    },
];

// Lifecycle
onMounted(() => {
    loadStats();
    statsInterval = setInterval(loadStats, 30000) as unknown as number;
    
    // Visibility change handler
    document.addEventListener('visibilitychange', () => {
        if (document.hidden && statsInterval) {
            clearInterval(statsInterval);
        } else {
            loadStats();
            statsInterval = setInterval(loadStats, 30000) as unknown as number;
        }
    });
});

onUnmounted(() => {
    if (statsInterval) {
        clearInterval(statsInterval);
    }
});
</script>

<template>
    <Head>
        <title>FraudShield - বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Courier Fraud Detection</title>
        <meta name="description" content="বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।" />
        <meta name="keywords" content="courier fraud bangladesh, fraud detection system, bangladeshi courier check, courier ফ্রড, কুরিয়ার ফ্রড চেক" />
        <meta property="og:title" content="FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম" />
        <meta property="og:description" content="মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://fraudshieldbd.site" />
    </Head>
    
    <AppLayout>
        <!-- Stats Section -->
        <section class="py-12 px-4 overflow-visible">
            <div class="container mx-auto overflow-visible">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2 flex items-center justify-center gap-2">
                        <BarChart3 class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                        সার্চ পরিসংখ্যান
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">রিয়েল-টাইম সার্চ ডেটা এবং ব্যবহারকারীর কার্যক্রম</p>
                </div>
                
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Last Hour -->
                    <Card class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/50 dark:to-blue-800/50 border-blue-200 dark:border-blue-700 hover:scale-[1.02] transition-transform text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-xl shadow-lg mb-3">
                            <Clock class="w-5 h-5" />
                        </div>
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-300 mb-1">
                            {{ formatBengaliNumber(stats.lastHour) }}
                        </div>
                        <div class="text-sm text-blue-500 dark:text-blue-300 font-semibold mb-1">শেষ ১ ঘন্টায়</div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">সর্বশেষ ৬০ মিনিটের সার্চ</p>
                    </Card>
                    
                    <!-- Today -->
                    <Card class="p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/50 dark:to-green-800/50 border-green-200 dark:border-green-700 hover:scale-[1.02] transition-transform text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-xl shadow-lg mb-3">
                            <Calendar class="w-5 h-5" />
                        </div>
                        <div class="text-2xl font-bold text-green-600 dark:text-green-300 mb-1">
                            {{ formatBengaliNumber(stats.today) }}
                        </div>
                        <div class="text-sm text-green-500 dark:text-green-300 font-semibold mb-1">আজকের সার্চ</div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">আজ রাত ১২টা থেকে এখন পর্যন্ত</p>
                    </Card>
                    
                    <!-- All Time -->
                    <Card class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/50 dark:to-purple-800/50 border-purple-200 dark:border-purple-700 hover:scale-[1.02] transition-transform text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-purple-500 text-white rounded-xl shadow-lg mb-3">
                            <Infinity class="w-5 h-5" />
                        </div>
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-300 mb-1">
                            {{ formatBengaliNumber(stats.allTime) }}
                        </div>
                        <div class="text-sm text-purple-500 dark:text-purple-300 font-semibold mb-1">সর্বমোট সার্চ</div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">সর্বকালের মোট সার্চ সংখ্যা</p>
                    </Card>
                    
                    <!-- Unique Numbers -->
                    <Card class="p-4 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/50 dark:to-orange-800/50 border-orange-200 dark:border-orange-700 hover:scale-[1.02] transition-transform text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-orange-500 text-white rounded-xl shadow-lg mb-3">
                            <PhoneCall class="w-5 h-5" />
                        </div>
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-300 mb-1">
                            {{ formatBengaliNumber(stats.uniqueNumbers) }}
                        </div>
                        <div class="text-sm text-orange-500 dark:text-orange-300 font-semibold mb-1">ইউনিক নাম্বার</div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">চেক করা মোট নাম্বার সংখ্যা</p>
                    </Card>
                </div>
                
                <!-- Last Updated -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <RefreshCw class="w-4 h-4 inline-block align-middle mr-1" />
                        <span class="align-middle">সর্বশেষ আপডেট: <span class="font-medium text-gray-700 dark:text-gray-300">{{ lastUpdated }}</span></span>
                    </p>
                </div>
            </div>
        </section>
        
        <!-- Search Section -->
        <section class="container mx-auto px-4 py-4">
            <!-- Search Bar -->
            <Card class="p-4 mb-4 bg-gradient-to-r from-indigo-500/5 to-purple-500/5 dark:from-indigo-500/10 dark:to-purple-500/10 border-indigo-200 dark:border-indigo-800">
                <div class="text-center mb-3">
                    <h1 class="text-lg md:text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-1">
                        কুরিয়ার ফ্রড চেক করুন
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস যাচাই করুন</p>
                </div>
                <div class="flex flex-col md:flex-row gap-3 max-w-xl mx-auto">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <Phone class="h-4 w-4 text-indigo-500" />
                        </div>
                        <input
                            v-model="phoneInput"
                            type="text"
                            placeholder="মোবাইল নাম্বার লিখুন (যেমন: 01600000000)"
                            class="w-full pl-10 p-3 border border-indigo-200 dark:border-indigo-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition duration-300 text-sm"
                            @keypress.enter="performSearch"
                        />
                    </div>
                    <Button 
                        size="default" 
                        :loading="isSearching"
                        @click="performSearch"
                        class="min-w-[140px] shadow-md"
                    >
                        <Search class="w-4 h-4 mr-1" />
                        রিপোর্ট দেখুন
                    </Button>
                </div>
            </Card>
            
            <!-- Loading State -->
            <div v-if="isSearching" class="text-center py-16">
                <div class="relative w-20 h-20 mx-auto mb-6">
                    <div class="absolute inset-0 rounded-full border-4 border-indigo-200 dark:border-indigo-800"></div>
                    <div class="absolute inset-0 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin"></div>
                    <Shield class="absolute inset-0 m-auto w-8 h-8 text-indigo-600" />
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-lg">ডেলিভারি ইতিহাস বিশ্লেষণ করা হচ্ছে...</p>
            </div>
            
            <!-- Main Content Grid - Always Show -->
            <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Left Panel - Delivery Success Ratio (Always Visible) -->
                <Card class="p-4 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 border border-gray-100 dark:border-gray-700">
                    <h2 class="text-base font-bold mb-3 flex items-center gap-2 text-gray-800 dark:text-gray-100">
                        <div class="p-1.5 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                            <PieChart class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        Delivery Success Ratio
                    </h2>
                    
                    <!-- Progress Ring -->
                    <div class="flex justify-center mb-3">
                        <div class="relative w-28 h-28">
                            <!-- Decorative rings -->
                            <div class="absolute inset-0 rounded-full border-2 border-dashed border-gray-200 dark:border-gray-700 animate-spin" style="animation-duration: 20s;"></div>
                            <div class="absolute inset-1 rounded-full bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 shadow-inner"></div>
                            
                            <svg class="absolute inset-1 w-[calc(100%-8px)] h-[calc(100%-8px)] transform -rotate-90" viewBox="0 0 100 100">
                                <circle
                                    class="text-gray-200 dark:text-gray-700 stroke-current"
                                    stroke-width="10"
                                    fill="transparent"
                                    r="40"
                                    cx="50"
                                    cy="50"
                                />
                                <circle
                                    class="stroke-current transition-all duration-1000 ease-out"
                                    :style="{ color: searchResults ? getColorForRatio(successRatio) : '#6366f1' }"
                                    stroke-width="10"
                                    stroke-linecap="round"
                                    fill="transparent"
                                    r="40"
                                    cx="50"
                                    cy="50"
                                    :stroke-dasharray="251"
                                    :stroke-dashoffset="searchResults ? 251 - (251 * successRatio / 100) : 251"
                                />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center flex-col">
                                <span class="text-xl font-bold" :class="searchResults ? '' : 'text-gray-400 dark:text-gray-500'">
                                    {{ searchResults ? successRatio.toFixed(0) : '0' }}%
                                </span>
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full" :class="{
                                    'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300': searchResults && ratingText === 'Excellent',
                                    'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300': searchResults && ratingText === 'Good',
                                    'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300': searchResults && ratingText === 'Poor',
                                    'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400': !searchResults || ratingText === 'New',
                                }">
                                    {{ searchResults ? ratingText : 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Message -->
                    <div class="text-center mb-3 p-2 rounded-lg text-sm" :class="{
                        'bg-gray-100 dark:bg-gray-800': !searchResults,
                        'bg-green-50 dark:bg-green-900/30': searchResults && riskLevel.level === 'low',
                        'bg-yellow-50 dark:bg-yellow-900/30': searchResults && riskLevel.level === 'medium',
                        'bg-red-50 dark:bg-red-900/30': searchResults && riskLevel.level === 'high',
                    }">
                        <p class="text-gray-600 dark:text-gray-400 text-xs" v-if="!searchResults">
                            <Phone class="w-3 h-3 inline-block mr-1 -mt-0.5" />
                            মোবাইল নাম্বার দিয়ে সার্চ করুন
                        </p>
                        <p v-else class="font-medium text-xs" :class="{
                            'text-green-700 dark:text-green-300': riskLevel.level === 'low',
                            'text-yellow-700 dark:text-yellow-300': riskLevel.level === 'medium',
                            'text-red-700 dark:text-red-300': riskLevel.level === 'high',
                            'text-gray-600 dark:text-gray-400': riskLevel.level === 'unknown',
                        }">
                            {{ riskLevel.level === 'low' ? 'এই গ্রাহক বিশ্বস্ত!' : 
                               riskLevel.level === 'medium' ? 'সতর্কতার সাথে এগিয়ে যান' :
                               riskLevel.level === 'high' ? 'উচ্চ ঝুঁকিপূর্ণ গ্রাহক!' : 'ডেলিভারি ইতিহাস নেই' }}
                        </p>
                    </div>
                    
                    <!-- Risk Indicator -->
                    <div 
                        class="text-center py-2 px-3 rounded-lg flex items-center justify-center gap-2 font-medium text-sm transition-all duration-300"
                        :class="{
                            'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-md': searchResults && riskLevel.level === 'low',
                            'bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-md': searchResults && riskLevel.level === 'medium',
                            'bg-gradient-to-r from-red-500 to-rose-500 text-white shadow-md': searchResults && riskLevel.level === 'high',
                            'bg-gradient-to-r from-gray-400 to-gray-500 text-white': !searchResults || riskLevel.level === 'unknown',
                        }"
                    >
                        <component :is="searchResults ? riskLevel.icon : HelpCircle" class="w-4 h-4" />
                        {{ searchResults ? riskLevel.label : 'Waiting' }}
                    </div>
                    
                    <!-- Fraud Risk Factors -->
                    <div class="mt-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <h3 class="font-medium text-xs mb-2 flex items-center gap-1.5 text-gray-800 dark:text-gray-100">
                            <Shield class="w-3 h-3 text-indigo-600 dark:text-indigo-400" />
                            Risk Factors
                        </h3>
                        <ul class="space-y-1.5">
                            <li class="flex items-center text-xs gap-2 p-1.5 rounded" :class="searchResults && successRatio >= 90 ? 'bg-green-50 dark:bg-green-900/20' : 'bg-gray-50 dark:bg-gray-700/50'">
                                <div class="p-1 rounded-full" :class="searchResults && successRatio >= 90 ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'">
                                    <CheckCircle class="w-2.5 h-2.5 text-white" />
                                </div>
                                <span :class="searchResults && successRatio >= 90 ? 'text-green-700 dark:text-green-300' : 'text-gray-500 dark:text-gray-400'">
                                    High success rate
                                </span>
                            </li>
                            <li class="flex items-center text-xs gap-2 p-1.5 rounded" :class="searchResults && searchResults.courierData?.summary?.cancelled_parcel > 3 ? 'bg-red-50 dark:bg-red-900/20' : 'bg-gray-50 dark:bg-gray-700/50'">
                                <div class="p-1 rounded-full" :class="searchResults && searchResults.courierData?.summary?.cancelled_parcel > 3 ? 'bg-red-500' : 'bg-gray-300 dark:bg-gray-600'">
                                    <XCircle class="w-2.5 h-2.5 text-white" />
                                </div>
                                <span :class="searchResults && searchResults.courierData?.summary?.cancelled_parcel > 3 ? 'text-red-700 dark:text-red-300' : 'text-gray-500 dark:text-gray-400'">
                                    Multiple cancellations
                                </span>
                            </li>
                            <li class="flex items-center text-xs gap-2 p-1.5 rounded bg-gray-50 dark:bg-gray-700/50">
                                <div class="p-1 rounded-full bg-gray-300 dark:bg-gray-600">
                                    <AlertCircle class="w-2.5 h-2.5 text-white" />
                                </div>
                                <span class="text-gray-500 dark:text-gray-400">Inconsistent patterns</span>
                            </li>
                        </ul>
                    </div>
                </Card>
                
                <!-- Right Panel -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Show Results if Available -->
                    <template v-if="searchResults">
                        <!-- Alert Message Box -->
                        <Alert 
                            :variant="riskLevel.level === 'low' ? 'success' : riskLevel.level === 'medium' ? 'warning' : riskLevel.level === 'high' ? 'destructive' : 'default'"
                            class="border-l-4"
                        >
                            <component :is="riskLevel.icon" class="h-5 w-5" />
                            <AlertTitle class="text-lg">
                                {{ riskLevel.level === 'low' ? 'বিশ্বস্ত গ্রাহক' : 
                                   riskLevel.level === 'medium' ? 'সতর্কতার সাথে এগিয়ে যান' :
                                   riskLevel.level === 'high' ? 'উচ্চ ঝুঁকি সতর্কতা' : 'নতুন গ্রাহক' }}
                            </AlertTitle>
                            <AlertDescription>
                                <template v-if="riskLevel.level === 'low'">
                                    এই গ্রাহকের {{ successRatio.toFixed(1) }}% সাফল্যের হার সহ চমৎকার ডেলিভারি ইতিহাস রয়েছে।
                                </template>
                                <template v-else-if="riskLevel.level === 'medium'">
                                    {{ successRatio.toFixed(1) }}% সাফল্যের হার সহ সাধারণত ভালো ইতিহাস, তবে কিছু যাচাই করা উচিত।
                                </template>
                                <template v-else-if="riskLevel.level === 'high'">
                                    মাত্র {{ successRatio.toFixed(1) }}% সাফল্যের হার। অতিরিক্ত যাচাই দৃঢ়ভাবে সুপারিশ করা হয়।
                                </template>
                                <template v-else>
                                    এই নম্বরের জন্য কোন ডেলিভারি ইতিহাস পাওয়া যায়নি।
                                </template>
                            </AlertDescription>
                        </Alert>
                        
                        <!-- Stats Cards with Progress -->
                        <div class="grid grid-cols-3 gap-4">
                            <Card class="p-5 text-center hover:shadow-lg transition-all">
                                <div class="text-sm text-muted-foreground mb-2 font-medium">মোট অর্ডার</div>
                                <div class="text-4xl font-bold text-primary mb-2">
                                    {{ searchResults.courierData?.summary?.total_parcel || 0 }}
                                </div>
                                <Badge variant="outline" class="text-xs">Total Orders</Badge>
                            </Card>
                            
                            <Card class="p-5 text-center hover:shadow-lg transition-all">
                                <div class="text-sm text-muted-foreground mb-2 font-medium">মোট ডেলিভারি</div>
                                <div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">
                                    {{ searchResults.courierData?.summary?.success_parcel || 0 }}
                                </div>
                                <Badge variant="success" class="text-xs">Delivered</Badge>
                            </Card>
                            
                            <Card class="p-5 text-center hover:shadow-lg transition-all">
                                <div class="text-sm text-muted-foreground mb-2 font-medium">মোট বাতিল</div>
                                <div class="text-4xl font-bold text-red-600 dark:text-red-400 mb-2">
                                    {{ searchResults.courierData?.summary?.cancelled_parcel || 0 }}
                                </div>
                                <Badge variant="destructive" class="text-xs">Cancelled</Badge>
                            </Card>
                        </div>
                        
                        <!-- Success Rate Progress Bar -->
                        <Card class="p-5">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-medium text-muted-foreground">সাফল্যের হার</span>
                                <Badge :variant="successRatio >= 90 ? 'success' : successRatio >= 70 ? 'warning' : 'destructive'">
                                    {{ successRatio.toFixed(1) }}%
                                </Badge>
                            </div>
                            <Progress 
                                :model-value="successRatio" 
                                class="h-3"
                                :indicator-class="successRatio >= 90 ? 'bg-green-500' : successRatio >= 70 ? 'bg-yellow-500' : 'bg-red-500'"
                            />
                        </Card>
                    
                    <!-- Courier Table -->
                    <Card class="p-6">
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <BarChart3 class="w-5 h-5 text-primary" />
                            কুরিয়ার ডিটেইলস
                        </h3>
                        
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead class="w-[180px]">Courier</TableHead>
                                    <TableHead>Orders</TableHead>
                                    <TableHead>Delivered</TableHead>
                                    <TableHead>Cancelled</TableHead>
                                    <TableHead class="text-right">Success Rate</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow 
                                    v-for="courier in courierList" 
                                    :key="courier.name"
                                >
                                    <TableCell class="font-medium">
                                        <div class="flex items-center gap-2">
                                            <img 
                                                v-if="courier.logo" 
                                                :src="courier.logo" 
                                                :alt="courier.name"
                                                class="w-6 h-6 object-contain rounded"
                                            />
                                            <span>{{ courier.name }}</span>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <Badge variant="outline">{{ courier.totalParcel }}</Badge>
                                    </TableCell>
                                    <TableCell>
                                        <Badge variant="success">{{ courier.successParcel }}</Badge>
                                    </TableCell>
                                    <TableCell>
                                        <Badge variant="destructive">{{ courier.cancelledParcel }}</Badge>
                                    </TableCell>
                                    <TableCell class="text-right">
                                        <Badge 
                                            :class="courier.successRatio >= 90 ? 'bg-green-500 hover:bg-green-600' : courier.successRatio >= 70 ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-red-500 hover:bg-red-600'"
                                            class="text-white"
                                        >
                                            {{ courier.successRatio.toFixed(1) }}%
                                        </Badge>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </Card>
                    
                    <!-- Customer Reviews Section -->
                    <Card class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold flex items-center gap-2">
                                <MessageSquare class="w-5 h-5 text-indigo-600" />
                                গ্রাহক রিভিউ
                            </h2>
                            <Button 
                                variant="secondary"
                                @click="showRatingModal = true"
                            >
                                <Plus class="w-4 h-4 mr-1" />
                                নতুন রিভিউ
                            </Button>
                        </div>
                        
                        <!-- No Reviews -->
                        <div v-if="reviews.length === 0" class="text-center py-10 text-gray-500 dark:text-gray-400">
                            <MessageSquare class="w-12 h-12 mx-auto mb-4 opacity-50" />
                            <p>এই নাম্বারের জন্য কোন রিভিউ নেই</p>
                            <p class="text-sm mt-2">প্রথম রিভিউ দিয়ে অন্যদের সাহায্য করুন</p>
                        </div>
                        
                        <!-- Reviews List -->
                        <div v-else class="space-y-4">
                            <div 
                                v-for="review in reviews" 
                                :key="review.id"
                                class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg"
                            >
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-semibold">{{ review.name }} ({{ maskPhoneNumber(review.commenter_phone) }})</h4>
                                        <StarRating :model-value="review.rating" readonly size="sm" class="my-1" />
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ formatBengaliDate(review.created_at) }}
                                    </div>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300">{{ review.comment }}</p>
                            </div>
                        </div>
                    </Card>
                    </template>
                    
                    <!-- Empty State when no search results -->
                    <template v-else>
                        <Card class="h-full p-6 text-center bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 flex flex-col items-center justify-center">
                            <img 
                                src="https://img.freepik.com/free-vector/work-office-computer-man-woman-business-character-marketing-online-employee-technology-business-man-cartoon-co-working-flat-design-freelance_1150-41790.jpg?w=1060" 
                                alt="Search illustration" 
                                class="mx-auto mb-4 rounded-lg shadow-md w-48 sm:w-56 md:w-64"
                            />
                            <h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-100">কুরিয়ার ফ্রড চেক করুন</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 max-w-sm mx-auto text-sm">
                                মোবাইল নাম্বার দিয়ে সার্চ করুন এবং গ্রাহকের ডেলিভারি ইতিহাস দেখুন।
                            </p>
                            <div class="flex flex-wrap justify-center gap-2">
                                <div class="flex items-center gap-1.5 bg-green-50 dark:bg-green-900/30 px-3 py-1.5 rounded-full">
                                    <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                                    <span class="text-xs text-green-700 dark:text-green-300 font-medium">Low Risk</span>
                                </div>
                                <div class="flex items-center gap-1.5 bg-yellow-50 dark:bg-yellow-900/30 px-3 py-1.5 rounded-full">
                                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                                    <span class="text-xs text-yellow-700 dark:text-yellow-300 font-medium">Medium Risk</span>
                                </div>
                                <div class="flex items-center gap-1.5 bg-red-50 dark:bg-red-900/30 px-3 py-1.5 rounded-full">
                                    <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                                    <span class="text-xs text-red-700 dark:text-red-300 font-medium">High Risk</span>
                                </div>
                            </div>
                        </Card>
                    </template>
                </div>
            </div>
        </section>
        
        <!-- Why Section -->
        <section class="container mx-auto px-4 py-12">
            <Card class="p-6">
                <h2 class="text-2xl font-bold mb-8 text-center">কেন কুরিয়ার ফ্রড চেক করা প্রয়োজন?</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                            <Shield class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">ব্যবসা সুরক্ষা</h3>
                        <p class="text-gray-600 dark:text-gray-300">আপনার ব্যবসাকে সম্ভাব্য কুরিয়ার ফ্রড থেকে রক্ষা করুন। প্রতি মাসে হাজার হাজার টাকা সাশ্রয় করুন।</p>
                    </div>
                    
                    <div class="p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                            <TrendingUp class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">ডেলিভারি সাফল্য বাড়ান</h3>
                        <p class="text-gray-600 dark:text-gray-300">বিশ্বস্ত গ্রাহকদের চিহ্নিত করে আপনার ডেলিভারি সাফল্যের হার বাড়ান এবং ব্যবসার লাভ বৃদ্ধি করুন।</p>
                    </div>
                    
                    <div class="p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                            <History class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-semibold mb-2">রিয়েল-টাইম ডাটা</h3>
                        <p class="text-gray-600 dark:text-gray-300">সর্বাধিক আপডেটেড ডাটা দিয়ে গ্রাহকের আচরণ বিশ্লেষণ করুন এবং সঠিক সিদ্ধান্ত নিন।</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl">
                    <h3 class="text-xl font-semibold mb-4">বাংলাদেশে কুরিয়ার ফ্রড সম্পর্কে জানুন</h3>
                    <p class="mb-4 text-gray-700 dark:text-gray-300">
                        বাংলাদেশে প্রতি বছর হাজার হাজার ব্যবসায়ী কুরিয়ার ফ্রডের শিকার হন। কুরিয়ার ফ্রড হল যখন একজন গ্রাহক ইচ্ছাকৃতভাবে পণ্য গ্রহণ করে না বা ডেলিভারি বাতিল করে।
                    </p>
                    <p class="mb-4 text-gray-700 dark:text-gray-300">
                        FraudShield আপনাকে একটি গ্রাহকের পূর্ববর্তী ডেলিভারি ইতিহাস দেখার সুযোগ দেয়, যাতে আপনি সিদ্ধান্ত নিতে পারেন যে তাদের কাছে পণ্য পাঠানো নিরাপদ কিনা।
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        আমাদের সিস্টেম বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিসের ডাটা ব্যবহার করে এবং একটি বিশ্বস্ত ফ্রড স্কোর প্রদান করে।
                    </p>
                </div>
            </Card>
        </section>
        
        <!-- FAQ Section -->
        <section class="container mx-auto px-4 py-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold mb-2">সাধারণ জিজ্ঞাসা (FAQ)</h2>
                <p class="text-gray-600 dark:text-gray-400">আপনার FraudShield সম্পর্কিত সব প্রশ্নের উত্তর এখানে পাবেন</p>
            </div>
            
            <div class="max-w-3xl mx-auto space-y-4">
                <Card 
                    v-for="(faq, index) in faqs" 
                    :key="index"
                    class="overflow-hidden border-l-4 border-indigo-500 hover:shadow-lg transition-shadow"
                >
                    <button
                        @click="toggleFaq(index)"
                        class="w-full p-5 flex justify-between items-center text-left font-semibold text-gray-800 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"
                    >
                        <span>{{ faq.question }}</span>
                        <div class="p-1 bg-indigo-100 dark:bg-indigo-900 rounded-full text-indigo-600 dark:text-indigo-400">
                            <ChevronUp v-if="activeFaq === index" class="w-5 h-5" />
                            <ChevronDown v-else class="w-5 h-5" />
                        </div>
                    </button>
                    <Transition
                        enter-active-class="transition-all duration-200 ease-out"
                        enter-from-class="opacity-0 max-h-0"
                        enter-to-class="opacity-100 max-h-96"
                        leave-active-class="transition-all duration-150 ease-in"
                        leave-from-class="opacity-100 max-h-96"
                        leave-to-class="opacity-0 max-h-0"
                    >
                        <div v-if="activeFaq === index" class="px-5 pb-5 text-gray-600 dark:text-gray-300 overflow-hidden">
                            {{ faq.answer }}
                        </div>
                    </Transition>
                </Card>
            </div>
        </section>
        
        <!-- Floating Download Button -->
        <div class="fixed bottom-8 right-8 z-40">
            <a
                href="/download"
                class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-full font-semibold hover:shadow-2xl hover:scale-105 transition-all duration-300 shadow-xl animate-pulse"
            >
                <Download class="w-5 h-5" />
                <span>অ্যাপ ডাউনলোড করুন</span>
            </a>
        </div>
        
        <!-- Rating Modal -->
        <Modal v-model:open="showRatingModal">
            <h3 class="text-xl font-bold mb-4">Rate This Customer</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Share your experience with <span class="font-medium">{{ phoneInput }}</span>
            </p>
            
            <form @submit.prevent="submitReview" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">আপনার নম্বর</label>
                    <input
                        v-model="reviewForm.ownNumber"
                        type="text"
                        placeholder="আপনার নম্বর লিখুন"
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                        required
                    />
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">আপনার নাম</label>
                    <input
                        v-model="reviewForm.name"
                        type="text"
                        placeholder="আপনার নাম লিখুন"
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                        required
                    />
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">রেটিং দিন</label>
                    <StarRating v-model="reviewForm.rating" size="lg" />
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">আপনার মন্তব্য</label>
                    <textarea
                        v-model="reviewForm.comment"
                        placeholder="আপনার অভিজ্ঞতা শেয়ার করুন"
                        rows="3"
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                        required
                    ></textarea>
                </div>
                
                <div class="flex justify-end">
                    <Button type="submit" :loading="isSubmittingReview">
                        <Send class="w-4 h-4 mr-2" />
                        জমা দিন
                    </Button>
                </div>
            </form>
        </Modal>
    </AppLayout>
</template>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
