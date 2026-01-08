<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Search, Phone, ArrowRight, Sparkles, CheckCircle2, Zap, Shield, Clock, Calendar, Activity, Users } from 'lucide-vue-next';

const phoneInput = ref('');
const isSearching = ref(false);

const emit = defineEmits<{
    (e: 'search', phone: string): void;
}>();

const performSearch = () => {
    if (!phoneInput.value) return;
    emit('search', phoneInput.value);
};

// Stats
const convertToBengaliNumbers = (num: number | string): string => {
    const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    return num.toString().replace(/[0-9]/g, (digit) => bengaliDigits[parseInt(digit)]);
};

const formatBengaliNumber = (num: number): string => {
    if (num >= 10000000) {
        return convertToBengaliNumbers((num / 10000000).toFixed(1)) + ' কোটি';
    } else if (num >= 100000) {
        return convertToBengaliNumbers((num / 100000).toFixed(1)) + ' লক্ষ';
    } else if (num >= 1000) {
        return convertToBengaliNumbers((num / 1000).toFixed(1)) + 'K+';
    }
    return convertToBengaliNumbers(num);
};

const stats = ref({
    lastHour: 0,
    today: 0,
    allTime: 0,
    uniqueNumbers: 0,
});
let statsInterval: ReturnType<typeof setInterval> | null = null;

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
        }
    } catch (error) {
        console.error('Error loading stats:', error);
    }
};

onMounted(() => {
    loadStats();
    statsInterval = setInterval(loadStats, 30000);
});

onUnmounted(() => {
    if (statsInterval) clearInterval(statsInterval);
});

const highlights = [
    { icon: Zap, text: 'বাল্ক সার্চ ≤৫০০' },
    { icon: Shield, text: '৯৯% নির্ভুলতা' },
    { icon: CheckCircle2, text: '৯৯.৯৯% আপটাইম' },
];
</script>

<template>
    <section class="relative min-h-[90vh] flex items-center overflow-hidden bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 pt-20 md:pt-24">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
            
            <!-- Grid Pattern -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0wIDBoNjB2NjBIMHoiLz48cGF0aCBkPSJNMzAgMzBtLTEgMGExIDEgMCAxIDAgMiAwYTEgMSAwIDEgMCAtMiAwIiBmaWxsPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIi8+PC9nPjwvc3ZnPg==')] opacity-40"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Live Stats -->
                <div class="mb-6">
                    <div class="flex flex-wrap justify-center gap-3 md:gap-4">
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/5 backdrop-blur-sm rounded-full border border-white/10">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            <Clock class="w-3.5 h-3.5 text-cyan-400" />
                            <span class="text-white font-medium text-sm">{{ formatBengaliNumber(stats.lastHour) }}</span>
                            <span class="text-white/40 text-xs">ঘন্টায়</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/5 backdrop-blur-sm rounded-full border border-white/10">
                            <Calendar class="w-3.5 h-3.5 text-green-400" />
                            <span class="text-white font-medium text-sm">{{ formatBengaliNumber(stats.today) }}</span>
                            <span class="text-white/40 text-xs">আজকে</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/5 backdrop-blur-sm rounded-full border border-white/10">
                            <Activity class="w-3.5 h-3.5 text-purple-400" />
                            <span class="text-white font-medium text-sm">{{ formatBengaliNumber(stats.allTime) }}</span>
                            <span class="text-white/40 text-xs">মোট</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/5 backdrop-blur-sm rounded-full border border-white/10">
                            <Users class="w-3.5 h-3.5 text-orange-400" />
                            <span class="text-white font-medium text-sm">{{ formatBengaliNumber(stats.uniqueNumbers) }}</span>
                            <span class="text-white/40 text-xs">ইউনিক</span>
                        </div>
                    </div>
                </div>

                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-8 animate-fade-in">
                    <Sparkles class="w-4 h-4 text-yellow-400" />
                    <span class="text-sm text-white/90">বাংলাদেশে প্রথম — Bulk Search (≤ ৫০০)</span>
                </div>

                <!-- Main Headline -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    রিটার্ন কমান, খরচ বাঁচান —
                    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                        FraudShield
                    </span>
                    দিয়ে স্মার্ট কুরিয়ার সার্চ
                </h1>

                <!-- Subheadline -->
                <p class="text-lg md:text-xl text-white/70 mb-8 max-w-2xl mx-auto leading-relaxed">
                    নম্বরভিত্তিক (সিঙ্গেল + বাল্ক≤৫০০) সার্চ, শক্তিশালী ফিল্টার, বাল্ক এক্সপোর্ট ও REST API।
                    রিয়েল-টাইম ইনসাইটে দ্রুত সিদ্ধান্ত—কম সময়ে বেশি ডেলিভারি।
                </p>

                <!-- Search Box -->
                <div class="max-w-xl mx-auto mb-8">
                    <div class="relative flex flex-col sm:flex-row gap-3 p-2 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20">
                        <div class="relative flex-1">
                            <Phone class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/50" />
                            <input
                                v-model="phoneInput"
                                type="text"
                                placeholder="মোবাইল নাম্বার লিখুন (01XXXXXXXXX)"
                                class="w-full pl-12 pr-4 py-4 bg-white/10 text-white placeholder-white/40 rounded-xl border border-white/10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                @keypress.enter="performSearch"
                            />
                        </div>
                        <button
                            @click="performSearch"
                            :disabled="isSearching"
                            class="flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/25 disabled:opacity-50"
                        >
                            <Search class="w-5 h-5" />
                            <span>সার্চ করুন</span>
                        </button>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <Link
                        href="/register"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white text-slate-900 font-semibold rounded-xl hover:bg-white/90 transition-all duration-300 hover:shadow-lg"
                    >
                        ফ্রি রেজিস্টার করুন
                        <ArrowRight class="w-4 h-4" />
                    </Link>
                    <a
                        href="#features"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 text-white font-semibold rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300"
                    >
                        ফিচারস দেখুন
                    </a>
                    <a
                        href="#pricing"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 text-white font-semibold rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300"
                    >
                        প্ল্যান দেখুন
                    </a>
                </div>

                <!-- Highlights -->
                <div class="flex flex-wrap justify-center gap-6 pb-8">
                    <div
                        v-for="(item, index) in highlights"
                        :key="index"
                        class="flex items-center gap-2 text-white/80"
                    >
                        <div class="p-1.5 rounded-lg bg-white/10">
                            <component :is="item.icon" class="w-4 h-4 text-indigo-400" />
                        </div>
                        <span class="text-sm">{{ item.text }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator - Hidden on mobile, visible on desktop -->
        <div class="hidden md:block absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce z-20">
            <div class="w-6 h-10 rounded-full border-2 border-white/30 flex items-start justify-center p-2">
                <div class="w-1 h-2 bg-white/50 rounded-full animate-scroll"></div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes scroll {
    0%, 100% { transform: translateY(0); opacity: 1; }
    50% { transform: translateY(4px); opacity: 0.5; }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-scroll {
    animation: scroll 1.5s ease-in-out infinite;
}
</style>
