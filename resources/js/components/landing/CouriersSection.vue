<script setup lang="ts">
import { Truck } from 'lucide-vue-next';

const couriers = [
    { name: 'Steadfast', logo: '/c-logo/steadfast-logo.png' },
    { name: 'Pathao', logo: '/c-logo/pathao-logo.png' },
    { name: 'REDX', logo: '/c-logo/redx-logo.png' },
    { name: 'Paperfly', logo: '/c-logo/paperfly-logo.png' },
    { name: 'Parceldex', logo: '/c-logo/parceldex-logo.png' },
    { name: 'CarryBee', logo: '/c-logo/carrybee-logo.webp' },
];
</script>

<template>
    <section id="couriers" class="py-12 bg-white dark:bg-slate-900">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-900/50 mb-4">
                    <Truck class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                    <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">সাপোর্টেড কুরিয়ার</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Supported Couriers
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    FraudShield একমাত্র প্ল্যাটফর্ম, যা বাংলাদেশের মধ্যে সবচেয়ে বেশি কুরিয়ার রিপোর্ট প্রদান করছে — দ্রুত ও নির্ভুল।
                </p>
            </div>

            <!-- Courier Logos - Infinite Scroll Animation -->
            <div class="relative overflow-hidden">
                <!-- Gradient Masks -->
                <div class="absolute left-0 top-0 bottom-0 w-20 bg-gradient-to-r from-white dark:from-slate-900 to-transparent z-10"></div>
                <div class="absolute right-0 top-0 bottom-0 w-20 bg-gradient-to-l from-white dark:from-slate-900 to-transparent z-10"></div>

                <!-- Scrolling Container -->
                <div class="flex animate-scroll-x">
                    <!-- First Set -->
                    <div class="flex gap-6 items-center px-3">
                        <div
                            v-for="(courier, index) in couriers"
                            :key="`first-${index}`"
                            class="flex items-center justify-center px-8 py-5 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 min-w-[140px] h-[70px]"
                        >
                            <img
                                :src="courier.logo"
                                :alt="courier.name"
                                class="max-h-10 w-auto object-contain"
                            />
                        </div>
                    </div>

                    <!-- Duplicate Set for Seamless Loop -->
                    <div class="flex gap-6 items-center px-3">
                        <div
                            v-for="(courier, index) in couriers"
                            :key="`second-${index}`"
                            class="flex items-center justify-center px-8 py-5 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 min-w-[140px] h-[70px]"
                        >
                            <img
                                :src="courier.logo"
                                :alt="courier.name"
                                class="max-h-10 w-auto object-contain"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="text-center p-6 bg-gray-50 dark:bg-slate-800 rounded-2xl">
                    <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-1">৬+</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">কুরিয়ার পার্টনার</div>
                </div>
                <div class="text-center p-6 bg-gray-50 dark:bg-slate-800 rounded-2xl">
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-1">৯৯%</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">এক্যুরেসি</div>
                </div>
                <div class="text-center p-6 bg-gray-50 dark:bg-slate-800 rounded-2xl">
                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">৯৯.৯৯%</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">আপটাইম</div>
                </div>
                <div class="text-center p-6 bg-gray-50 dark:bg-slate-800 rounded-2xl">
                    <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-1">Fastest</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">রেসপন্স স্পিড</div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@keyframes scroll-x {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.animate-scroll-x {
    animation: scroll-x 30s linear infinite;
}

.animate-scroll-x:hover {
    animation-play-state: paused;
}
</style>
