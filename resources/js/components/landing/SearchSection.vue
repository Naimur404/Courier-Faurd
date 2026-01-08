<script setup lang="ts">
import { ref, computed, watch, nextTick, onUnmounted } from 'vue';
import { 
    Search, Phone, Shield, PieChart, BarChart3, History,
    CheckCircle, XCircle, AlertCircle, HelpCircle,
    TrendingUp, RefreshCw, Truck, MessageSquare, Plus, Send
} from 'lucide-vue-next';
import { Chart, registerables } from 'chart.js';

// Register Chart.js
Chart.register(...registerables);

const props = defineProps<{
    csrfToken: string;
    searchPhone?: { phone: string; timestamp: number } | null;
}>();

// State
const phoneInput = ref('');
const isSearching = ref(false);
const searchResults = ref<any>(null);
const showEmptyState = ref(true);
const reviews = ref<any[]>([]);
const showRatingModal = ref(false);
const isSubmittingReview = ref(false);

// Toast notification
const toastMessage = ref('');
const toastType = ref<'error' | 'success' | 'warning'>('error');
const showToast = ref(false);
let toastTimeout: ReturnType<typeof setTimeout> | null = null;

const displayToast = (message: string, type: 'error' | 'success' | 'warning' = 'error') => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;
    if (toastTimeout) clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
        showToast.value = false;
    }, 5000);
};

// Review form
const reviewForm = ref({
    ownNumber: '',
    name: '',
    rating: 0,
    comment: '',
});

// Chart
const chartCanvas = ref<HTMLCanvasElement | null>(null);
let chartInstance: Chart | null = null;

// Computed
const successRatio = computed(() => {
    if (!searchResults.value?.courierData?.summary) return 0;
    return searchResults.value.courierData.summary.success_ratio || 0;
});

const riskLevel = computed(() => {
    const ratio = successRatio.value;
    const total = searchResults.value?.courierData?.summary?.total_parcel || 0;
    
    if (total === 0) return { level: 'unknown', color: 'gray', label: 'No Data', icon: HelpCircle };
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
const getColorForRatio = (ratio: number): string => {
    if (ratio >= 90) return '#10b981';
    if (ratio >= 70) return '#f59e0b';
    return '#ef4444';
};

const performSearch = async () => {
    if (!phoneInput.value) {
        displayToast('মোবাইল নাম্বার লিখুন', 'warning');
        return;
    }
    
    const phoneRegex = /^01[0-9]{9}$/;
    if (!phoneRegex.test(phoneInput.value)) {
        displayToast('সঠিক মোবাইল নাম্বার লিখুন (যেমন: 01600000000)', 'warning');
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
            displayToast(rateLimitData.message || `দৈনিক সার্চ সীমা (${rateLimitData.limit} টি) অতিক্রম করা হয়েছে।`, 'warning');
            showEmptyState.value = true;
            return;
        }
        
        const data = await response.json();
        
        if (!response.ok || data.success === false) {
            displayToast(data.message || 'সার্ভার থেকে ত্রুটির বার্তা পাওয়া গেছে', 'error');
            showEmptyState.value = true;
            return;
        }
        
        searchResults.value = data;
        await loadReviews();
        
        // Scroll to results section on success
        setTimeout(() => {
            const searchSection = document.getElementById('search');
            if (searchSection) {
                searchSection.scrollIntoView({ behavior: 'smooth' });
            }
        }, 100);
        
    } catch (error) {
        console.error('Search error:', error);
        displayToast('ডাটা লোড করতে সমস্যা হয়েছে', 'error');
        showEmptyState.value = true;
    } finally {
        isSearching.value = false;
    }
};

const loadReviews = async () => {
    try {
        const response = await fetch(`/customer-reviews/${phoneInput.value}`, {
            headers: { 'X-CSRF-TOKEN': props.csrfToken },
        });
        const data = await response.json();
        reviews.value = data.data || [];
    } catch (error) {
        reviews.value = [];
    }
};

const submitReview = async () => {
    if (!reviewForm.value.name || !reviewForm.value.comment || reviewForm.value.rating === 0) {
        alert('সব তথ্য পূরণ করুন');
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
    } catch (error) {
        alert('কিছু ভুল হয়েছে। আবার চেষ্টা করুন।');
    } finally {
        isSubmittingReview.value = false;
    }
};

const updateChart = () => {
    const canvas = chartCanvas.value;
    if (!canvas || courierList.value.length === 0) return;
    
    const ctx = canvas.getContext('2d');
    if (!ctx) return;
    
    if (chartInstance) {
        chartInstance.destroy();
        chartInstance = null;
    }
    
    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#e2e8f0' : '#1f2937';
    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
    
    chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: courierList.value.map(c => c.name),
            datasets: [
                {
                    label: 'Total Orders',
                    data: courierList.value.map(c => c.totalParcel),
                    backgroundColor: 'rgba(79, 70, 229, 0.8)',
                    borderRadius: 4
                },
                {
                    label: 'Successful',
                    data: courierList.value.map(c => c.successParcel),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderRadius: 4
                },
                {
                    label: 'Cancelled',
                    data: courierList.value.map(c => c.cancelledParcel),
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { color: textColor, usePointStyle: true }
                }
            },
            scales: {
                x: { ticks: { color: textColor }, grid: { display: false } },
                y: { beginAtZero: true, ticks: { color: textColor }, grid: { color: gridColor } }
            }
        }
    });
};

watch(courierList, (newVal) => {
    if (newVal.length > 0) {
        nextTick(() => setTimeout(updateChart, 200));
    }
}, { deep: true });

onUnmounted(() => {
    if (chartInstance) {
        chartInstance.destroy();
    }
});

// Watch for searchPhone prop changes
watch(() => props.searchPhone, (newData) => {
    if (newData && newData.phone) {
        phoneInput.value = newData.phone;
        performSearch();
    }
}, { deep: true });

// Expose performSearch for parent component
defineExpose({
    performSearch,
    setPhone: (phone: string) => {
        phoneInput.value = phone;
    }
});

const maskPhoneNumber = (phone: string): string => {
    if (!phone || phone.length < 6) return phone;
    return phone.slice(0, 3) + '****' + phone.slice(-4);
};
</script>

<template>
    <section id="search" class="py-8 bg-white dark:bg-slate-900">
        <div class="container mx-auto px-4">
            
            <!-- Toast Notification -->
            <Teleport to="body">
                <Transition
                    enter-active-class="transition-all duration-300 ease-out"
                    enter-from-class="-translate-y-full opacity-0"
                    enter-to-class="translate-y-0 opacity-100"
                    leave-active-class="transition-all duration-200 ease-in"
                    leave-from-class="translate-y-0 opacity-100"
                    leave-to-class="-translate-y-full opacity-0"
                >
                    <div v-if="showToast" class="fixed top-20 left-1/2 -translate-x-1/2 z-50 max-w-md w-full mx-4">
                        <div 
                            class="flex items-center gap-3 px-5 py-4 rounded-2xl shadow-2xl border backdrop-blur-sm"
                            :class="{
                                'bg-red-50 dark:bg-red-900/90 border-red-200 dark:border-red-700': toastType === 'error',
                                'bg-yellow-50 dark:bg-yellow-900/90 border-yellow-200 dark:border-yellow-700': toastType === 'warning',
                                'bg-green-50 dark:bg-green-900/90 border-green-200 dark:border-green-700': toastType === 'success',
                            }"
                        >
                            <div 
                                class="flex-shrink-0 p-2 rounded-xl"
                                :class="{
                                    'bg-red-100 dark:bg-red-800': toastType === 'error',
                                    'bg-yellow-100 dark:bg-yellow-800': toastType === 'warning',
                                    'bg-green-100 dark:bg-green-800': toastType === 'success',
                                }"
                            >
                                <XCircle v-if="toastType === 'error'" class="w-5 h-5 text-red-600 dark:text-red-300" />
                                <AlertCircle v-else-if="toastType === 'warning'" class="w-5 h-5 text-yellow-600 dark:text-yellow-300" />
                                <CheckCircle v-else class="w-5 h-5 text-green-600 dark:text-green-300" />
                            </div>
                            <p 
                                class="flex-1 text-sm font-medium"
                                :class="{
                                    'text-red-800 dark:text-red-200': toastType === 'error',
                                    'text-yellow-800 dark:text-yellow-200': toastType === 'warning',
                                    'text-green-800 dark:text-green-200': toastType === 'success',
                                }"
                            >{{ toastMessage }}</p>
                            <button 
                                @click="showToast = false"
                                class="flex-shrink-0 p-1 rounded-lg hover:bg-black/10 dark:hover:bg-white/10 transition-colors"
                            >
                                <XCircle class="w-4 h-4 text-gray-500" />
                            </button>
                        </div>
                    </div>
                </Transition>
            </Teleport>

            <!-- Loading State -->
            <div v-if="isSearching" class="text-center py-16">
                <div class="relative w-28 h-28 mx-auto mb-8">
                    <div class="absolute inset-0 rounded-full border-4 border-indigo-200 dark:border-indigo-900"></div>
                    <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-indigo-600 dark:border-t-indigo-400 animate-spin"></div>
                    <div class="absolute inset-0 rounded-full border-4 border-transparent border-b-purple-500 dark:border-b-purple-400 animate-spin" style="animation-duration: 1.5s"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/25">
                            <Shield class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 dark:text-gray-300 text-xl font-medium mb-2">বিশ্লেষণ করা হচ্ছে...</p>
                <p class="text-gray-500 dark:text-gray-500 text-sm">ডেলিভারি ইতিহাস যাচাই করা হচ্ছে</p>
            </div>

            <!-- Results -->
            <div v-else-if="searchResults" class="grid lg:grid-cols-3 gap-4 max-w-6xl mx-auto">
                <!-- Left: Success Ratio -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-800 dark:to-slate-800/50 rounded-3xl p-6 border border-gray-200 dark:border-slate-700 shadow-xl">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2 text-gray-900 dark:text-white">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl">
                            <PieChart class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        Delivery Success Ratio
                    </h3>
                    
                    <!-- Progress Ring -->
                    <div class="flex justify-center mb-6">
                        <div class="relative w-36 h-36">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                <circle class="text-gray-200 dark:text-slate-700 stroke-current" stroke-width="8" fill="transparent" r="42" cx="50" cy="50"/>
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
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ successRatio.toFixed(0) }}%</span>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full mt-1" :class="{
                                    'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400': ratingText === 'Excellent',
                                    'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-400': ratingText === 'Good',
                                    'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-400': ratingText === 'Poor',
                                    'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400': ratingText === 'New',
                                }">{{ ratingText }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Indicator -->
                    <div 
                        class="text-center py-3 px-4 rounded-2xl flex items-center justify-center gap-2 font-semibold text-white shadow-lg"
                        :class="{
                            'bg-gradient-to-r from-green-500 to-emerald-600 shadow-green-500/25': riskLevel.level === 'low',
                            'bg-gradient-to-r from-yellow-500 to-orange-500 shadow-yellow-500/25': riskLevel.level === 'medium',
                            'bg-gradient-to-r from-red-500 to-rose-600 shadow-red-500/25': riskLevel.level === 'high',
                            'bg-gradient-to-r from-gray-400 to-gray-500': riskLevel.level === 'unknown',
                        }"
                    >
                        <component :is="riskLevel.icon" class="w-5 h-5" />
                        {{ riskLevel.label }}
                    </div>

                    <!-- Quick Stats -->
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div class="text-center p-4 bg-white dark:bg-slate-700/50 rounded-xl border border-gray-100 dark:border-slate-600">
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ searchResults.courierData?.summary?.total_parcel || 0 }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">মোট অর্ডার</div>
                        </div>
                        <div class="text-center p-4 bg-white dark:bg-slate-700/50 rounded-xl border border-gray-100 dark:border-slate-600">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ searchResults.courierData?.summary?.success_parcel || 0 }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">সফল</div>
                        </div>
                        <div class="text-center p-4 bg-white dark:bg-slate-700/50 rounded-xl border border-gray-100 dark:border-slate-600">
                            <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ searchResults.courierData?.summary?.cancelled_parcel || 0 }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">বাতিল</div>
                        </div>
                        <div class="text-center p-4 bg-white dark:bg-slate-700/50 rounded-xl border border-gray-100 dark:border-slate-600">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ courierList.length }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">কুরিয়ার</div>
                        </div>
                    </div>

                    <!-- Recommendation -->
                    <div class="mt-6 p-4 rounded-2xl border" :class="{
                        'bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-800': riskLevel.level === 'low',
                        'bg-yellow-50 border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-800': riskLevel.level === 'medium',
                        'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800': riskLevel.level === 'high',
                        'bg-gray-50 border-gray-200 dark:bg-gray-800 dark:border-gray-700': riskLevel.level === 'unknown'
                    }">
                        <h4 class="font-semibold text-sm mb-2 flex items-center gap-2" :class="{
                            'text-green-800 dark:text-green-300': riskLevel.level === 'low',
                            'text-yellow-800 dark:text-yellow-300': riskLevel.level === 'medium',
                            'text-red-800 dark:text-red-300': riskLevel.level === 'high',
                            'text-gray-800 dark:text-gray-300': riskLevel.level === 'unknown'
                        }">
                            <TrendingUp class="w-4 h-4" />
                            সুপারিশ
                        </h4>
                        <p class="text-sm leading-relaxed" :class="{
                            'text-green-700 dark:text-green-400': riskLevel.level === 'low',
                            'text-yellow-700 dark:text-yellow-400': riskLevel.level === 'medium',
                            'text-red-700 dark:text-red-400': riskLevel.level === 'high',
                            'text-gray-600 dark:text-gray-400': riskLevel.level === 'unknown'
                        }">
                            <template v-if="riskLevel.level === 'low'">এই গ্রাহককে নিশ্চিন্তে ডেলিভারি দিতে পারেন। তাদের চমৎকার ট্র্যাক রেকর্ড রয়েছে।</template>
                            <template v-else-if="riskLevel.level === 'medium'">ফোনে যোগাযোগ করে ঠিকানা যাচাই করুন এবং অর্ডার কনফার্ম করুন।</template>
                            <template v-else-if="riskLevel.level === 'high'">⚠️ সতর্কতা! এডভান্স পেমেন্ট নিন অথবা ডেলিভারি এড়িয়ে যান। ঝুঁকি বেশি।</template>
                            <template v-else>নতুন গ্রাহক। প্রথম অর্ডারে সতর্কতা অবলম্বন করুন।</template>
                        </p>
                    </div>
                </div>

                <!-- Right: Chart & Table -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Chart -->
                    <div v-if="courierList.length > 0" class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-800 dark:to-slate-800/50 rounded-3xl p-6 border border-gray-200 dark:border-slate-700 shadow-xl">
                        <h3 class="text-lg font-bold mb-6 flex items-center gap-2 text-gray-900 dark:text-white">
                            <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl">
                                <Truck class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                            </div>
                            কুরিয়ার পারফরম্যান্স
                        </h3>
                        <div class="h-72">
                            <canvas ref="chartCanvas"></canvas>
                        </div>
                    </div>

                    <!-- Courier Table -->
                    <div v-if="courierList.length > 0" class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-800 dark:to-slate-800/50 rounded-3xl p-6 border border-gray-200 dark:border-slate-700 shadow-xl overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-sm font-semibold text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-slate-600">
                                    <th class="pb-4">Courier</th>
                                    <th class="pb-4">Orders</th>
                                    <th class="pb-4">Delivered</th>
                                    <th class="pb-4">Cancelled</th>
                                    <th class="pb-4 text-right">Success Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="courier in courierList" :key="courier.name" class="border-b border-gray-100 dark:border-slate-700/50 last:border-0 hover:bg-white/50 dark:hover:bg-slate-700/30 transition-colors">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-700 p-2 flex items-center justify-center border border-gray-100 dark:border-slate-600">
                                                <img v-if="courier.logo" :src="courier.logo" :alt="courier.name" class="max-w-full max-h-full object-contain" />
                                            </div>
                                            <span class="font-medium text-gray-900 dark:text-white">{{ courier.name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-gray-700 dark:text-gray-300 font-medium">{{ courier.totalParcel }}</td>
                                    <td class="py-4 text-green-600 dark:text-green-400 font-medium">{{ courier.successParcel }}</td>
                                    <td class="py-4 text-red-600 dark:text-red-400 font-medium">{{ courier.cancelledParcel }}</td>
                                    <td class="py-4 text-right">
                                        <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full" :class="{
                                            'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400': courier.successRatio >= 70,
                                            'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-400': courier.successRatio < 70,
                                        }">
                                            {{ courier.successRatio.toFixed(1) }}%
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Reviews -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-800 dark:to-slate-800/50 rounded-3xl p-6 border border-gray-200 dark:border-slate-700 shadow-xl">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold flex items-center gap-2 text-gray-900 dark:text-white">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl">
                                    <MessageSquare class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                গ্রাহক রিভিউ
                            </h3>
                            <button @click="showRatingModal = true" class="flex items-center gap-2 px-4 py-2 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-xl text-sm font-semibold hover:bg-indigo-200 dark:hover:bg-indigo-900 transition-colors">
                                <Plus class="w-4 h-4" />
                                নতুন রিভিউ
                            </button>
                        </div>
                        
                        <div v-if="reviews.length === 0" class="text-center py-10 text-gray-500">
                            <MessageSquare class="w-12 h-12 mx-auto mb-3 opacity-30" />
                            <p>এই নাম্বারের জন্য কোন রিভিউ নেই</p>
                            <p class="text-sm mt-1">প্রথম রিভিউ দিয়ে অন্যদের সাহায্য করুন</p>
                        </div>
                        
                        <div v-else class="space-y-4 max-h-72 overflow-y-auto">
                            <div v-for="review in reviews" :key="review.id" class="bg-white dark:bg-slate-700/50 p-4 rounded-2xl border border-gray-100 dark:border-slate-600">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ review.name }}</span>
                                        <span class="text-gray-400 text-sm ml-2">({{ maskPhoneNumber(review.commenter_phone) }})</span>
                                    </div>
                                    <div class="flex text-lg">
                                        <span v-for="i in 5" :key="i" :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-200 dark:text-gray-600'">★</span>
                                    </div>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300">{{ review.comment }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Modal -->
        <Teleport to="body">
            <div v-if="showRatingModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showRatingModal = false"></div>
                <div class="relative bg-white dark:bg-slate-800 rounded-3xl p-8 w-full max-w-md shadow-2xl border border-gray-200 dark:border-slate-700">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/25">
                            <MessageSquare class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">রিভিউ দিন</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ phoneInput }}</span> সম্পর্কে আপনার অভিজ্ঞতা শেয়ার করুন
                        </p>
                    </div>
                    
                    <form @submit.prevent="submitReview" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">আপনার নম্বর</label>
                            <input v-model="reviewForm.ownNumber" type="text" placeholder="01XXXXXXXXX" class="w-full p-4 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" required />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">আপনার নাম</label>
                            <input v-model="reviewForm.name" type="text" placeholder="আপনার নাম লিখুন" class="w-full p-4 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" required />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-3 text-gray-700 dark:text-gray-300">রেটিং</label>
                            <div class="flex justify-center gap-3">
                                <button 
                                    v-for="i in 5" 
                                    :key="i" 
                                    type="button" 
                                    @click="reviewForm.rating = i" 
                                    class="text-4xl transition-all duration-200 hover:scale-110"
                                    :class="i <= reviewForm.rating ? 'text-yellow-400 drop-shadow-lg' : 'text-gray-300 dark:text-gray-600 hover:text-yellow-300'"
                                >★</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">মন্তব্য</label>
                            <textarea v-model="reviewForm.comment" rows="3" placeholder="আপনার অভিজ্ঞতা লিখুন..." class="w-full p-4 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none" required></textarea>
                        </div>
                        <div class="flex gap-4 pt-2">
                            <button type="button" @click="showRatingModal = false" class="flex-1 py-4 border border-gray-300 dark:border-slate-600 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                বাতিল
                            </button>
                            <button 
                                type="submit" 
                                :disabled="isSubmittingReview" 
                                class="flex-1 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-500 hover:to-purple-500 disabled:opacity-50 flex items-center justify-center gap-2 shadow-lg shadow-indigo-500/25 transition-all"
                            >
                                <Send class="w-5 h-5" />
                                জমা দিন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
    </section>
</template>
