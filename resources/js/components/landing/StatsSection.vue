<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Clock, Calendar, Infinity, PhoneCall, Activity } from 'lucide-vue-next';

// Helper functions
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

// Stats state
const stats = ref({
    lastHour: 0,
    today: 0,
    allTime: 0,
    uniqueNumbers: 0,
});
const isLoading = ref(true);
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
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    loadStats();
    statsInterval = setInterval(loadStats, 30000);
});

onUnmounted(() => {
    if (statsInterval) clearInterval(statsInterval);
});

const statItems = [
    { key: 'lastHour', icon: Clock, label: 'শেষ ঘন্টায়', color: 'text-cyan-400', glow: 'shadow-cyan-500/20' },
    { key: 'today', icon: Calendar, label: 'আজকে', color: 'text-green-400', glow: 'shadow-green-500/20' },
    { key: 'allTime', icon: Infinity, label: 'সর্বমোট', color: 'text-purple-400', glow: 'shadow-purple-500/20' },
    { key: 'uniqueNumbers', icon: PhoneCall, label: 'ইউনিক নাম্বার', color: 'text-orange-400', glow: 'shadow-orange-500/20' },
];
</script>

<template>
    <section class="relative py-12 bg-gradient-to-b from-slate-900 to-slate-950 overflow-hidden">
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0wIDBoNjB2NjBIMHoiLz48cGF0aCBkPSJNMzAgMzBtLTEgMGExIDEgMCAxIDAgMiAwYTEgMSAwIDEgMCAtMiAwIiBmaWxsPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIi8+PC9nPjwvc3ZnPg==')]"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Live Indicator -->
            <div class="flex items-center justify-center gap-2 mb-8">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/5 backdrop-blur-sm rounded-full border border-white/10">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                    </span>
                    <span class="text-sm text-white/70">লাইভ স্ট্যাটিস্টিক্স</span>
                    <Activity class="w-4 h-4 text-green-400" />
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-4xl mx-auto">
                <div
                    v-for="stat in statItems"
                    :key="stat.key"
                    class="group relative"
                >
                    <!-- Card -->
                    <div class="relative bg-white/5 backdrop-blur-sm rounded-2xl p-5 border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1 text-center">
                        <!-- Icon -->
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 mb-3">
                            <component :is="stat.icon" :class="['w-5 h-5', stat.color]" />
                        </div>

                        <!-- Value -->
                        <div class="mb-1">
                            <template v-if="isLoading">
                                <div class="h-8 w-16 mx-auto bg-white/10 rounded animate-pulse"></div>
                            </template>
                            <template v-else>
                                <span :class="['text-2xl md:text-3xl font-bold', stat.color]">
                                    {{ formatBengaliNumber(stats[stat.key as keyof typeof stats]) }}
                                </span>
                            </template>
                        </div>

                        <!-- Label -->
                        <p class="text-sm text-white/60">{{ stat.label }}</p>

                        <!-- Hover Glow Effect -->
                        <div :class="['absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10 blur-xl', stat.glow]" style="background: currentColor;"></div>
                    </div>
                </div>
            </div>

            <!-- Bottom Stats Bar -->
            <div class="mt-8 flex flex-wrap justify-center gap-6 md:gap-10">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <span class="text-sm text-white/60">99%+ এক্যুরেসি</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    <span class="text-sm text-white/60">99.99% আপটাইম</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                    <span class="text-sm text-white/60">রিয়েল-টাইম আপডেট</span>
                </div>
            </div>
        </div>
    </section>
</template>
