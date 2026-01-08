<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    Tag, Check, Star, Zap, Crown, Rocket, 
    Sparkles, ArrowRight, HelpCircle, Loader2, CheckCircle
} from 'lucide-vue-next';
import axios from 'axios';

// Auth status
const page = usePage();
const user = computed(() => page.props.auth?.user);
const hasActiveSubscription = computed(() => page.props.auth?.hasActiveSubscription ?? false);
const userSubscription = ref<{ plan_id: number; plan_name: string; status: string } | null>(null);

interface ApiPlan {
    id: number;
    name: string;
    slug: string;
    description: string;
    price: number;
    formatted_price: string;
    monthly_price: number;
    yearly_price: number;
    daily_limit: number;
    duration_months: number;
    duration_text: string;
    features: string[];
    is_popular: boolean;
}

interface DisplayPlan {
    id: number;
    name: string;
    tagline: string;
    description: string;
    monthlyPrice: number;
    yearlyPrice: number;
    features: string[];
    icon: typeof Rocket;
    color: string;
    popular: boolean;
}

const isYearly = ref(false);
const loading = ref(true);
const error = ref<string | null>(null);
const apiPlans = ref<ApiPlan[]>([]);

// Icon and color mapping based on plan name/slug
const planStyles: Record<string, { icon: typeof Rocket; color: string }> = {
    'স্টার্ট': { icon: Rocket, color: 'from-emerald-500 to-green-600' },
    'গ্রোথ': { icon: Crown, color: 'from-indigo-500 to-purple-600' },
    'প্রো': { icon: Zap, color: 'from-purple-500 to-pink-600' },
    'ম্যাক্স': { icon: Sparkles, color: 'from-orange-500 to-red-600' },
};

// Fallback plans if API fails
const fallbackPlans: DisplayPlan[] = [
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

// Convert API plans to display format
const displayPlans = computed<DisplayPlan[]>(() => {
    if (apiPlans.value.length === 0) {
        return fallbackPlans;
    }

    return apiPlans.value.map((plan) => {
        const style = planStyles[plan.name] || { icon: Rocket, color: 'from-slate-500 to-gray-600' };
        return {
            id: plan.id,
            name: plan.name,
            tagline: `Daily ${plan.daily_limit}`,
            description: plan.description,
            monthlyPrice: Number(plan.monthly_price),
            yearlyPrice: Number(plan.yearly_price),
            features: plan.features || [
                'Premium Support',
                'Free API',
                'Bulk Search Enabled',
                'Google Sheet Integration',
                'Free WordPress Plugin',
                'Free Android Apps',
            ],
            icon: style.icon,
            color: style.color,
            popular: plan.is_popular,
        };
    });
});

// Fetch plans from API
const fetchPlans = async () => {
    try {
        loading.value = true;
        error.value = null;
        const response = await axios.get('/api/public/plans');
        if (response.data.success) {
            apiPlans.value = response.data.data;
        }
    } catch (err) {
        console.error('Failed to fetch plans:', err);
        error.value = 'প্ল্যান লোড করতে সমস্যা হয়েছে';
        // Will use fallback plans
    } finally {
        loading.value = false;
    }
};

// Fetch user's active subscription
const fetchUserSubscription = async () => {
    if (!user.value) return;
    
    try {
        const response = await axios.get('/api/api-subscriptions/status');
        if (response.data.subscribed && response.data.subscription) {
            userSubscription.value = {
                plan_id: response.data.subscription.plan_id,
                plan_name: response.data.subscription.plan_name,
                status: response.data.subscription.status,
            };
        }
    } catch (err) {
        console.error('Failed to fetch subscription:', err);
    }
};

// Check if a plan is the user's current plan
const isCurrentPlan = (planId: number) => {
    return userSubscription.value?.plan_id === planId && userSubscription.value?.status === 'active';
};

onMounted(() => {
    fetchPlans();
    fetchUserSubscription();
});

const getPrice = (plan: DisplayPlan) => {
    return isYearly.value ? plan.yearlyPrice : plan.monthlyPrice;
};

const getPriceSuffix = () => {
    return isYearly.value ? '/বছর' : '/মাস';
};

const getDiscount = (plan: DisplayPlan) => {
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
                    <span class="text-sm text-white/90">API প্রাইসিং</span>
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
            <div v-if="loading" class="flex justify-center py-12">
                <div class="flex items-center gap-3 text-white/70">
                    <Loader2 class="w-6 h-6 animate-spin" />
                    <span>প্ল্যান লোড হচ্ছে...</span>
                </div>
            </div>

            <div v-else class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <div
                    v-for="(plan, index) in displayPlans"
                    :key="plan.id"
                    :class="[
                        'relative bg-white/10 backdrop-blur-md rounded-3xl border transition-all duration-300 hover:-translate-y-2',
                        plan.popular 
                            ? 'border-indigo-400 hover:shadow-2xl hover:shadow-indigo-500/20 mt-4 lg:mt-0' 
                            : 'border-white/20 hover:border-white/40 hover:shadow-xl'
                    ]"
                >
                    <!-- Current Plan Badge -->
                    <div 
                        v-if="isCurrentPlan(plan.id)"
                        class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs font-medium rounded-full flex items-center gap-1 whitespace-nowrap shadow-lg"
                    >
                        <Check class="w-3 h-3" />
                        <span>সাবস্ক্রাইবড</span>
                    </div>
                    <!-- Popular Badge -->
                    <div 
                        v-else-if="plan.popular"
                        class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-medium rounded-full flex items-center gap-1 whitespace-nowrap shadow-lg"
                    >
                        <Star class="w-3 h-3" />
                        <span class="hidden sm:inline">Most Popular</span>
                        <span class="sm:hidden">Popular</span>
                    </div>

                    <div class="p-5 sm:p-6">
                        <!-- Plan Icon & Name -->
                        <div class="flex items-center gap-3 mb-4">
                            <div 
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                                :class="`bg-gradient-to-br ${plan.color}`"
                            >
                                <component :is="plan.icon" class="w-5 h-5 sm:w-6 sm:h-6 text-white" />
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base sm:text-lg font-bold text-white truncate">{{ plan.name }}</h3>
                                <p class="text-xs sm:text-sm text-white/60">{{ plan.tagline }}</p>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <span class="text-3xl sm:text-4xl font-bold text-white">৳{{ getPrice(plan) }}</span>
                            <span class="text-white/60 text-sm">{{ getPriceSuffix() }}</span>
                            <p class="text-xs sm:text-sm text-white/50 mt-1 line-clamp-2">{{ plan.description }}</p>
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
                        <template v-if="user">
                            <button
                                v-if="isCurrentPlan(plan.id)"
                                disabled
                                class="flex items-center justify-center gap-2 w-full py-3 rounded-xl font-semibold bg-green-500/20 text-green-400 cursor-not-allowed mb-6 border-2 border-green-500/50"
                            >
                                <CheckCircle class="w-5 h-5" />
                                বর্তমান প্ল্যান
                            </button>
                            <button
                                v-else-if="hasActiveSubscription"
                                disabled
                                class="flex items-center justify-center gap-2 w-full py-3 rounded-xl font-semibold bg-white/10 text-white/50 cursor-not-allowed mb-6 border border-white/20"
                            >
                                <Check class="w-4 h-4" />
                                ইতিমধ্যে সাবস্ক্রাইব করা
                            </button>
                            <Link
                                v-else
                                :href="`/pricing/subscribe/${plan.id}?billing=${isYearly ? 'yearly' : 'monthly'}`"
                                :class="[
                                    'flex items-center justify-center gap-2 w-full py-3 rounded-xl font-semibold transition-all duration-300 mb-6',
                                    plan.popular
                                        ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white hover:shadow-lg hover:shadow-indigo-500/25'
                                        : 'bg-white/10 text-white hover:bg-white/20 border border-white/20'
                                ]"
                            >
                                সাবস্ক্রাইব করুন
                                <ArrowRight class="w-4 h-4" />
                            </Link>
                        </template>
                        <Link
                            v-else
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
