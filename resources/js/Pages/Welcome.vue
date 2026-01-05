<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/components/ui/Button.vue';
import Card from '@/components/ui/Card.vue';
import Input from '@/components/ui/Input.vue';
import Modal from '@/components/ui/Modal.vue';
import StarRating from '@/components/ui/StarRating.vue';
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
        <section class="py-12 px-4">
            <div class="container mx-auto">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2 flex items-center justify-center gap-2">
                        <BarChart3 class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                        সার্চ পরিসংখ্যান
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">রিয়েল-টাইম সার্চ ডেটা এবং ব্যবহারকারীর কার্যক্রম</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Last Hour -->
                    <Card class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/50 dark:to-blue-800/50 border-blue-200 dark:border-blue-700 hover:scale-[1.02] transition-transform">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-500 text-white rounded-xl shadow-lg">
                                <Clock class="w-6 h-6" />
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-300">
                                    {{ formatBengaliNumber(stats.lastHour) }}
                                </div>
                                <div class="text-sm text-blue-500 dark:text-blue-300 font-medium">শেষ ১ ঘন্টায়</div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">সর্বশেষ ৬০ মিনিটের সার্চ</p>
                    </Card>
                    
                    <!-- Today -->
                    <Card class="p-6 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/50 dark:to-green-800/50 border-green-200 dark:border-green-700 hover:scale-[1.02] transition-transform">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-500 text-white rounded-xl shadow-lg">
                                <Calendar class="w-6 h-6" />
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-300">
                                    {{ formatBengaliNumber(stats.today) }}
                                </div>
                                <div class="text-sm text-green-500 dark:text-green-300 font-medium">আজকের সার্চ</div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">আজ রাত ১২টা থেকে এখন পর্যন্ত</p>
                    </Card>
                    
                    <!-- All Time -->
                    <Card class="p-6 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/50 dark:to-purple-800/50 border-purple-200 dark:border-purple-700 hover:scale-[1.02] transition-transform">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-purple-500 text-white rounded-xl shadow-lg">
                                <Infinity class="w-6 h-6" />
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-300">
                                    {{ formatBengaliNumber(stats.allTime) }}
                                </div>
                                <div class="text-sm text-purple-500 dark:text-purple-300 font-medium">সর্বমোট সার্চ</div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">সর্বকালের মোট সার্চ সংখ্যা</p>
                    </Card>
                    
                    <!-- Unique Numbers -->
                    <Card class="p-6 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/50 dark:to-orange-800/50 border-orange-200 dark:border-orange-700 hover:scale-[1.02] transition-transform">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-orange-500 text-white rounded-xl shadow-lg">
                                <PhoneCall class="w-6 h-6" />
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-orange-600 dark:text-orange-300">
                                    {{ formatBengaliNumber(stats.uniqueNumbers) }}
                                </div>
                                <div class="text-sm text-orange-500 dark:text-orange-300 font-medium">ইউনিক নাম্বার</div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">চেক করা মোট নাম্বার সংখ্যা</p>
                    </Card>
                </div>
                
                <!-- Last Updated -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center justify-center gap-1">
                        <RefreshCw class="w-4 h-4" />
                        সর্বশেষ আপডেট: <span class="font-medium text-gray-700 dark:text-gray-300">{{ lastUpdated }}</span>
                    </p>
                </div>
            </div>
        </section>
        
        <!-- Search Section -->
        <section class="container mx-auto px-4 py-8">
            <!-- Search Bar -->
            <Card class="p-6 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <Phone class="h-5 w-5 text-gray-400" />
                        </div>
                        <input
                            v-model="phoneInput"
                            type="text"
                            placeholder="Enter Mobile Number (e.g., 01600000000)"
                            class="w-full pl-12 p-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white transition duration-300"
                            @keypress.enter="performSearch"
                        />
                    </div>
                    <Button 
                        size="lg" 
                        :loading="isSearching"
                        @click="performSearch"
                        class="min-w-[180px]"
                    >
                        <Search class="w-5 h-5 mr-2" />
                        রিপোর্ট দেখুন
                    </Button>
                </div>
            </Card>
            
            <!-- Loading State -->
            <div v-if="isSearching" class="text-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-4 border-indigo-600 border-t-transparent mx-auto mb-4"></div>
                <p class="text-gray-600 dark:text-gray-400">Analyzing delivery history...</p>
            </div>
            
            <!-- Results Grid -->
            <div v-else-if="searchResults" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Panel - Delivery Success Ratio -->
                <Card class="p-6">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <PieChart class="w-5 h-5 text-indigo-600" />
                        Delivery Success Ratio
                    </h2>
                    
                    <!-- Progress Ring -->
                    <div class="flex justify-center mb-6">
                        <div class="relative w-40 h-40">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                <circle
                                    class="text-gray-200 dark:text-gray-700 stroke-current"
                                    stroke-width="8"
                                    fill="transparent"
                                    r="42"
                                    cx="50"
                                    cy="50"
                                />
                                <circle
                                    class="stroke-current transition-all duration-1000 ease-out"
                                    :style="{ color: getColorForRatio(successRatio) }"
                                    stroke-width="8"
                                    stroke-linecap="round"
                                    fill="transparent"
                                    r="42"
                                    cx="50"
                                    cy="50"
                                    :stroke-dasharray="264"
                                    :stroke-dashoffset="264 - (264 * successRatio / 100)"
                                />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center flex-col">
                                <span class="text-3xl font-bold">{{ successRatio.toFixed(1) }}%</span>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ ratingText }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Risk Indicator -->
                    <div 
                        class="text-center py-3 px-4 rounded-xl text-white flex items-center justify-center gap-2 font-medium"
                        :class="{
                            'bg-green-500': riskLevel.level === 'low',
                            'bg-yellow-500': riskLevel.level === 'medium',
                            'bg-red-500': riskLevel.level === 'high',
                            'bg-gray-500': riskLevel.level === 'unknown',
                        }"
                    >
                        <component :is="riskLevel.icon" class="w-5 h-5" />
                        {{ riskLevel.label }}
                    </div>
                    
                    <!-- Quote Box -->
                    <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 border-l-4 border-indigo-500 rounded-r-lg italic text-gray-600 dark:text-gray-300">
                        <template v-if="riskLevel.level === 'low'">
                            "Reliability is the foundation of trust. This customer's excellent record speaks volumes."
                        </template>
                        <template v-else-if="riskLevel.level === 'medium'">
                            "Trust but verify. While the history is mostly good, occasional issues suggest caution."
                        </template>
                        <template v-else-if="riskLevel.level === 'high'">
                            "Past behavior predicts future actions. The high cancellation rate signals significant risk."
                        </template>
                        <template v-else>
                            "Enter a phone number to analyze the delivery history."
                        </template>
                    </div>
                    
                    <!-- Fraud Risk Factors -->
                    <div class="mt-6">
                        <h3 class="font-semibold mb-3 flex items-center gap-2">
                            <Shield class="w-4 h-4 text-indigo-600" />
                            Fraud Risk Factors
                        </h3>
                        <ul class="space-y-2">
                            <li class="flex items-center text-sm gap-2">
                                <CheckCircle class="w-4 h-4 text-green-500" />
                                <span>High delivery success rate</span>
                            </li>
                            <li class="flex items-center text-sm gap-2">
                                <XCircle class="w-4 h-4 text-red-500" />
                                <span>Multiple cancelled orders</span>
                            </li>
                            <li class="flex items-center text-sm gap-2">
                                <AlertCircle class="w-4 h-4 text-yellow-500" />
                                <span>Inconsistent delivery patterns</span>
                            </li>
                        </ul>
                    </div>
                </Card>
                
                <!-- Right Panel - Results -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Message Box -->
                    <div 
                        class="p-4 rounded-xl flex items-center gap-4 border-l-4"
                        :class="{
                            'bg-green-50 dark:bg-green-900/30 border-green-500': riskLevel.level === 'low',
                            'bg-yellow-50 dark:bg-yellow-900/30 border-yellow-500': riskLevel.level === 'medium',
                            'bg-red-50 dark:bg-red-900/30 border-red-500': riskLevel.level === 'high',
                            'bg-gray-50 dark:bg-gray-900/30 border-gray-500': riskLevel.level === 'unknown',
                        }"
                    >
                        <component 
                            :is="riskLevel.icon" 
                            class="w-8 h-8"
                            :class="{
                                'text-green-500': riskLevel.level === 'low',
                                'text-yellow-500': riskLevel.level === 'medium',
                                'text-red-500': riskLevel.level === 'high',
                                'text-gray-500': riskLevel.level === 'unknown',
                            }"
                        />
                        <div>
                            <template v-if="riskLevel.level === 'low'">
                                <strong>Trusted Customer:</strong> This customer has an excellent delivery history with a {{ successRatio.toFixed(1) }}% success rate.
                            </template>
                            <template v-else-if="riskLevel.level === 'medium'">
                                <strong>Proceed with Caution:</strong> This customer has a generally good history, but with a {{ successRatio.toFixed(1) }}% success rate, some verification is advised.
                            </template>
                            <template v-else-if="riskLevel.level === 'high'">
                                <strong>High Risk Alert:</strong> This customer has a concerning history with only a {{ successRatio.toFixed(1) }}% success rate. Additional verification strongly recommended.
                            </template>
                            <template v-else>
                                <strong>New Customer:</strong> No delivery history available for this number.
                            </template>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-3 gap-4">
                        <Card class="p-4 text-center hover:scale-105 transition-transform">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">মোট অর্ডার</div>
                            <div class="text-3xl font-bold text-indigo-600">
                                {{ searchResults.courierData?.summary?.total_parcel || 0 }}
                            </div>
                            <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 mt-2">
                                Total
                            </span>
                        </Card>
                        
                        <Card class="p-4 text-center hover:scale-105 transition-transform">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">মোট ডেলিভারি</div>
                            <div class="text-3xl font-bold text-green-500">
                                {{ searchResults.courierData?.summary?.success_parcel || 0 }}
                            </div>
                            <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 mt-2">
                                Delivered
                            </span>
                        </Card>
                        
                        <Card class="p-4 text-center hover:scale-105 transition-transform">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">মোট বাতিল</div>
                            <div class="text-3xl font-bold text-red-500">
                                {{ searchResults.courierData?.summary?.cancelled_parcel || 0 }}
                            </div>
                            <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 mt-2">
                                Cancelled
                            </span>
                        </Card>
                    </div>
                    
                    <!-- Courier Table -->
                    <Card class="p-6">
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <BarChart3 class="w-5 h-5 text-indigo-600" />
                            কুরিয়ার ডিটেইলস
                        </h3>
                        
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
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    <tr 
                                        v-for="courier in courierList" 
                                        :key="courier.name"
                                        class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"
                                    >
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2">
                                                <img 
                                                    v-if="courier.logo" 
                                                    :src="courier.logo" 
                                                    :alt="courier.name"
                                                    class="w-6 h-6 object-contain rounded"
                                                />
                                                <span>{{ courier.name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">{{ courier.totalParcel }}</td>
                                        <td class="py-3 px-4">{{ courier.successParcel }}</td>
                                        <td class="py-3 px-4">{{ courier.cancelledParcel }}</td>
                                        <td class="py-3 px-4">
                                            <span 
                                                class="px-2 py-1 text-xs rounded-full text-white"
                                                :style="{ backgroundColor: getColorForRatio(courier.successRatio) }"
                                            >
                                                {{ courier.successRatio.toFixed(1) }}%
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                </div>
            </div>
            
            <!-- Empty State -->
            <div v-else-if="showEmptyState">
                <Card class="p-10 text-center">
                    <img 
                        src="https://img.freepik.com/free-vector/work-office-computer-man-woman-business-character-marketing-online-employee-technology-business-man-cartoon-co-working-flat-design-freelance_1150-41790.jpg?w=1060" 
                        alt="Search illustration" 
                        class="mx-auto mb-6 rounded-lg max-w-md"
                    />
                    <h3 class="text-xl font-bold mb-2">Check Courier Fraud</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-lg mx-auto">
                        Enter a mobile number and click "রিপোর্ট দেখুন" to check the courier delivery history and fraud risk assessment.
                    </p>
                    <div class="flex justify-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-sm">Low Risk</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <span class="text-sm">Medium Risk</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-sm">High Risk</span>
                        </div>
                    </div>
                </Card>
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
