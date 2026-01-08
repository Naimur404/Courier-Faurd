<script setup lang="ts">
import { ref, computed } from 'vue';
import { Calculator, TrendingDown, TrendingUp, AlertTriangle, Sparkles } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

const dailyParcels = ref(100);
const returnRate = ref(30);
const deliveryCharge = ref(100);

const dailyLoss = computed(() => {
    const returnedParcels = (dailyParcels.value * returnRate.value) / 100;
    return Math.round(returnedParcels * deliveryCharge.value);
});

const monthlyLoss = computed(() => dailyLoss.value * 30);

const potentialSaving = computed(() => {
    // Assuming FraudShield can reduce return rate by 10%
    const reducedReturnRate = Math.max(0, returnRate.value - 10);
    const reducedReturns = (dailyParcels.value * reducedReturnRate) / 100;
    const newLoss = reducedReturns * deliveryCharge.value * 30;
    return monthlyLoss.value - newLoss;
});

const formatNumber = (num: number) => {
    return new Intl.NumberFormat('bn-BD').format(num);
};
</script>

<template>
    <section id="roi" class="py-12 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 relative overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0">
            <div class="absolute top-20 right-20 w-72 h-72 bg-red-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 left-20 w-72 h-72 bg-green-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm mb-4">
                    <Calculator class="w-4 h-4 text-yellow-400" />
                    <span class="text-sm text-white/90">ROI ক্যালকুলেটর</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    সৃজনশীল কৌশল দিয়ে সম্ভাবনা উন্মোচন
                </h2>
                <p class="text-lg text-white/70 max-w-2xl mx-auto">
                    দেখুন কতটা রিটার্ন কমিয়ে খরচ বাঁচাতে পারেন FraudShield ব্যবহার করে।
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 items-center max-w-5xl mx-auto">
                <!-- Calculator Input -->
                <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <Calculator class="w-5 h-5 text-indigo-400" />
                        দ্রুত হিসাব — কেন জরুরি?
                    </h3>

                    <div class="space-y-6">
                        <!-- Daily Parcels -->
                        <div>
                            <label class="flex justify-between text-white/80 mb-2 text-sm">
                                <span>দৈনিক পার্সেল সংখ্যা</span>
                                <span class="font-bold text-white">{{ dailyParcels }}</span>
                            </label>
                            <input
                                v-model="dailyParcels"
                                type="range"
                                min="10"
                                max="500"
                                step="10"
                                class="w-full h-2 bg-white/20 rounded-lg appearance-none cursor-pointer accent-indigo-500"
                            />
                            <div class="flex justify-between text-xs text-white/50 mt-1">
                                <span>১০</span>
                                <span>৫০০</span>
                            </div>
                        </div>

                        <!-- Return Rate -->
                        <div>
                            <label class="flex justify-between text-white/80 mb-2 text-sm">
                                <span>বর্তমান রিটার্ন রেট</span>
                                <span class="font-bold text-white">{{ returnRate }}%</span>
                            </label>
                            <input
                                v-model="returnRate"
                                type="range"
                                min="5"
                                max="50"
                                step="5"
                                class="w-full h-2 bg-white/20 rounded-lg appearance-none cursor-pointer accent-red-500"
                            />
                            <div class="flex justify-between text-xs text-white/50 mt-1">
                                <span>৫%</span>
                                <span>৫০%</span>
                            </div>
                        </div>

                        <!-- Delivery Charge -->
                        <div>
                            <label class="flex justify-between text-white/80 mb-2 text-sm">
                                <span>ডেলিভারি চার্জ (৳)</span>
                                <span class="font-bold text-white">৳{{ deliveryCharge }}</span>
                            </label>
                            <input
                                v-model="deliveryCharge"
                                type="range"
                                min="50"
                                max="200"
                                step="10"
                                class="w-full h-2 bg-white/20 rounded-lg appearance-none cursor-pointer accent-purple-500"
                            />
                            <div class="flex justify-between text-xs text-white/50 mt-1">
                                <span>৳৫০</span>
                                <span>৳২০০</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-white/60 text-xs mt-6">
                        *সংখ্যাগুলো ইন্ডাস্ট্রি-রেফারেন্স; কুরিয়ার/ব্যবসা অনুযায়ী ভিন্ন হতে পারে।
                    </p>
                </div>

                <!-- Results -->
                <div class="space-y-4">
                    <!-- Daily Loss -->
                    <div class="bg-gradient-to-r from-red-500/20 to-red-600/20 backdrop-blur-md rounded-2xl p-6 border border-red-500/30">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-red-500/30 rounded-lg">
                                <TrendingDown class="w-5 h-5 text-red-400" />
                            </div>
                            <span class="text-white/80">দৈনিক ক্ষতি (আনুমানিক)</span>
                        </div>
                        <div class="text-3xl font-bold text-red-400">
                            ≈ ৳{{ formatNumber(dailyLoss) }}
                        </div>
                    </div>

                    <!-- Monthly Loss -->
                    <div class="bg-gradient-to-r from-orange-500/20 to-orange-600/20 backdrop-blur-md rounded-2xl p-6 border border-orange-500/30">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-orange-500/30 rounded-lg">
                                <AlertTriangle class="w-5 h-5 text-orange-400" />
                            </div>
                            <span class="text-white/80">মাসিক সম্ভাব্য ক্ষতি</span>
                        </div>
                        <div class="text-3xl font-bold text-orange-400">
                            ≈ ৳{{ formatNumber(monthlyLoss) }}
                        </div>
                    </div>

                    <!-- Potential Saving -->
                    <div class="bg-gradient-to-r from-green-500/20 to-emerald-600/20 backdrop-blur-md rounded-2xl p-6 border border-green-500/30">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-green-500/30 rounded-lg">
                                <TrendingUp class="w-5 h-5 text-green-400" />
                            </div>
                            <span class="text-white/80">রিটার্ন ১০% কমলে মাসিক সেভ</span>
                        </div>
                        <div class="text-3xl font-bold text-green-400">
                            ≈ ৳{{ formatNumber(potentialSaving) }}
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="pt-4">
                        <Link
                            href="/register"
                            class="flex items-center justify-center gap-2 w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/25"
                        >
                            <Sparkles class="w-5 h-5" />
                            ফ্রি ট্রাই করুন
                        </Link>
                        <p class="text-center text-white/50 text-sm mt-3">
                            FraudShield ব্যবহার করে আগে থেকেই রিস্ক শনাক্ত করুন
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
