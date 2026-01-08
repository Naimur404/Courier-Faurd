<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { 
    Tag, Check, Star, Zap, Crown, Rocket, 
    Sparkles, ArrowRight, HelpCircle
} from 'lucide-vue-next';

interface Plan {
    id: number;
    name: string;
    description: string;
    formatted_price: string;
    duration_text: string;
    features: string[];
    daily_limit?: number;
    monthly_price?: number;
    yearly_price?: number;
}

const props = defineProps<{
    plans?: Plan[];
}>();

const isYearly = ref(false);

// Default plans if not provided
const defaultPlans = [
    {
        id: 1,
        name: 'স্টার্ট',
        tagline: 'Daily 50',
        description: 'ছোট টিমের জন্য',
        monthlyPrice: 100,
        yearlyPrice: 1000,
        features: [
            'Premium Support',
            'Free API',
            'Bulk Search Enabled',
            'Google Sheet Integration',
            'Free WordPress Plugin',
            'Free Android Apps',
        ],
        icon: Rocket,
        color: 'from-emerald-500 to-green-600',
        popular: false,
    },
    {
        id: 2,
        name: 'গ্রোথ',
        tagline: 'Daily 100',
        description: 'স্কেলিং ব্যবসা',
        monthlyPrice: 199,
        yearlyPrice: 1999,
        features: [
            'Premium Support',
            'Free API',
            'Bulk Search Enabled',
            'Google Sheet Integration',
            'Free WordPress Plugin',
            'Free Android Apps',
        ],
        icon: Crown,
        color: 'from-indigo-500 to-purple-600',
        popular: true,
    },
    {
        id: 3,
        name: 'প্রো',
        tagline: 'Daily 500',
        description: 'অপারেশন-হেভি টিম',
        monthlyPrice: 349,
        yearlyPrice: 3499,
        features: [
            'Premium Support',
            'Free API',
            'Bulk Search Enabled',
            'Google Sheet Integration',
            'Free WordPress Plugin',
            'Free Android Apps',
        ],
        icon: Zap,
        color: 'from-purple-500 to-pink-600',
        popular: false,
    },
    {
        id: 4,
        name: 'ম্যাক্স',
        tagline: 'Daily 1000',
        description: 'হাই-ভলিউম টিম',
        monthlyPrice: 500,
        yearlyPrice: 5000,
        features: [
            'Premium Support',
            'Free API',
            'Bulk Search Enabled',
            'Google Sheet Integration',
            'Free WordPress Plugin',
            'Free Android Apps',
        ],
        icon: Sparkles,
        color: 'from-orange-500 to-red-600',
        popular: false,
    },
];

const getPrice = (plan: typeof defaultPlans[0]) => {
    return isYearly.value ? plan.yearlyPrice : plan.monthlyPrice;
};

const getPriceSuffix = () => {
    return isYearly.value ? '/বছর' : '/মাস';
};

const getDiscount = (plan: typeof defaultPlans[0]) => {
    const yearlyMonthly = plan.monthlyPrice * 12;
    const saved = yearlyMonthly - plan.yearlyPrice;
    const percent = Math.round((saved / yearlyMonthly) * 100);
    return percent;
};
</script>

<template>
    <section id="pricing" class="py-12 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 relative overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0">
            <div class="absolute top-40 left-20 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-40 right-20 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm mb-4">
                    <Tag class="w-4 h-4 text-yellow-400" />
                    <span class="text-sm text-white/90">প্রাইসিং</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    সহজ প্ল্যান — কোনো ইনস্টলেশন/হিডেন চার্জ নেই
                </h2>
                <p class="text-lg text-white/70 max-w-2xl mx-auto mb-8">
                    সব প্যাকেজেই ফিচারস আছে—আপনার দৈনিক সার্চ-লিমিট অনুযায়ী বেছে নিন।
                </p>

                <!-- Toggle -->
                <div class="inline-flex items-center gap-4 p-2 bg-white/10 backdrop-blur-sm rounded-full">
                    <button
                        @click="isYearly = false"
                        :class="[
                            'px-6 py-2 rounded-full font-medium transition-all duration-300',
                            !isYearly 
                                ? 'bg-white text-slate-900' 
                                : 'text-white/70 hover:text-white'
                        ]"
                    >
                        Monthly
                    </button>
                    <button
                        @click="isYearly = true"
                        :class="[
                            'px-6 py-2 rounded-full font-medium transition-all duration-300 flex items-center gap-2',
                            isYearly 
                                ? 'bg-white text-slate-900' 
                                : 'text-white/70 hover:text-white'
                        ]"
                    >
                        Yearly
                        <span class="text-xs bg-green-500 text-white px-2 py-0.5 rounded-full">Save 17%</span>
                    </button>
                </div>

                <!-- Stats Bar -->
                <div class="flex flex-wrap justify-center gap-6 mt-8">
                    <div class="flex items-center gap-2 text-white/80">
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        <span class="text-sm">Uptime 99.99%</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/80">
                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                        <span class="text-sm">Accuracy 99%+</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/80">
                        <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                        <span class="text-sm">Result Speed Fastest</span>
                    </div>
                </div>
            </div>

            <!-- Pricing Cards -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <div
                    v-for="(plan, index) in defaultPlans"
                    :key="plan.id"
                    :class="[
                        'relative bg-white/10 backdrop-blur-md rounded-3xl border transition-all duration-300 hover:-translate-y-2',
                        plan.popular 
                            ? 'border-indigo-400 hover:shadow-2xl hover:shadow-indigo-500/20' 
                            : 'border-white/20 hover:border-white/40 hover:shadow-xl'
                    ]"
                >
                    <!-- Popular Badge -->
                    <div 
                        v-if="plan.popular"
                        class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm font-medium rounded-full flex items-center gap-1"
                    >
                        <Star class="w-4 h-4" />
                        Most Popular
                    </div>

                    <div class="p-6">
                        <!-- Plan Icon & Name -->
                        <div class="flex items-center gap-3 mb-4">
                            <div 
                                class="w-12 h-12 rounded-xl flex items-center justify-center"
                                :class="`bg-gradient-to-br ${plan.color}`"
                            >
                                <component :is="plan.icon" class="w-6 h-6 text-white" />
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">{{ plan.name }}</h3>
                                <p class="text-sm text-white/60">{{ plan.tagline }}</p>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <span class="text-4xl font-bold text-white">৳{{ getPrice(plan) }}</span>
                            <span class="text-white/60">{{ getPriceSuffix() }}</span>
                            <p class="text-sm text-white/50 mt-1">{{ plan.description }}</p>
                        </div>

                        <!-- Yearly Discount Badge -->
                        <div 
                            v-if="isYearly"
                            class="inline-flex items-center gap-1 px-3 py-1 bg-green-500/20 text-green-400 text-sm rounded-full mb-4"
                        >
                            <Sparkles class="w-3 h-3" />
                            {{ getDiscount(plan) }}% সেভ করুন
                        </div>

                        <!-- CTA Button -->
                        <Link
                            href="/register"
                            :class="[
                                'flex items-center justify-center gap-2 w-full py-3 rounded-xl font-semibold transition-all duration-300 mb-6',
                                plan.popular
                                    ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white hover:shadow-lg hover:shadow-indigo-500/25'
                                    : 'bg-white/10 text-white hover:bg-white/20 border border-white/20'
                            ]"
                        >
                            Register to select plan
                            <ArrowRight class="w-4 h-4" />
                        </Link>

                        <!-- Features -->
                        <ul class="space-y-3">
                            <li
                                v-for="(feature, fIndex) in plan.features"
                                :key="fIndex"
                                class="flex items-center gap-2 text-white/80 text-sm"
                            >
                                <Check class="w-4 h-4 text-green-400 flex-shrink-0" />
                                {{ feature }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Enterprise CTA -->
            <div class="mt-12 text-center">
                <div class="inline-flex flex-col sm:flex-row items-center gap-4 p-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl">
                            <Crown class="w-6 h-6 text-white" />
                        </div>
                        <div class="text-left">
                            <h3 class="text-lg font-bold text-white">Enterprise?</h3>
                            <p class="text-sm text-white/60">কাস্টম লিমিট ও ডেডিকেটেড সাপোর্ট</p>
                        </div>
                    </div>
                    <a
                        href="https://api.whatsapp.com/send?phone=8801841414004&text=Hi%20FraudShield%2C%20I%20need%20enterprise%20plan"
                        target="_blank"
                        class="px-6 py-3 bg-white text-slate-900 font-semibold rounded-xl hover:bg-white/90 transition-all duration-300 flex items-center gap-2"
                    >
                        সেলস টিমের সাথে কথা বলুন
                        <ArrowRight class="w-4 h-4" />
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
