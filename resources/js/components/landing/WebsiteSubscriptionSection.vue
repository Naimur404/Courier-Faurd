<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { 
    Infinity, Shield, Clock, Crown, CreditCard, 
    Check, Copy, X, AlertCircle, CheckCircle,
    Sparkles, Zap, Star, ArrowRight, Loader2
} from 'lucide-vue-next';

interface WebsitePlan {
    id: number;
    name: string;
    slug: string;
    description: string;
    price: number;
    formatted_price: string;
    duration_days: number;
    duration_text: string;
    icon: string;
    color: string;
    features: string[];
    is_popular: boolean;
}

const page = usePage();
const isLoggedIn = computed(() => !!page.props.auth?.user);

const plans = ref<WebsitePlan[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);
const userSubscription = ref<{ plan_type: string; status: string } | null>(null);

const showModal = ref(false);
const selectedPlan = ref<WebsitePlan | null>(null);
const transactionId = ref('');
const isSubmitting = ref(false);
const copied = ref(false);

// Icon mapping
const iconMap: Record<string, any> = {
    Zap,
    Crown,
    Star,
    Shield,
    Sparkles,
    Infinity,
};

const getIcon = (iconName: string) => {
    return iconMap[iconName] || Zap;
};

const getColorClasses = (color: string) => {
    const colors: Record<string, { bg: string; text: string; border: string; gradient: string }> = {
        indigo: { 
            bg: 'bg-indigo-500/20', 
            text: 'text-indigo-400', 
            border: 'border-indigo-500/50',
            gradient: 'from-indigo-600 to-purple-600'
        },
        purple: { 
            bg: 'bg-purple-500/20', 
            text: 'text-purple-400', 
            border: 'border-purple-500/50',
            gradient: 'from-purple-600 to-pink-600'
        },
        blue: { 
            bg: 'bg-blue-500/20', 
            text: 'text-blue-400', 
            border: 'border-blue-500/50',
            gradient: 'from-blue-600 to-cyan-600'
        },
        green: { 
            bg: 'bg-green-500/20', 
            text: 'text-green-400', 
            border: 'border-green-500/50',
            gradient: 'from-green-600 to-emerald-600'
        },
    };
    return colors[color] || colors.indigo;
};

const fetchPlans = async () => {
    try {
        loading.value = true;
        const response = await fetch('/api/public/website-plans');
        const data = await response.json();
        if (data.success) {
            plans.value = data.data;
        }
    } catch (err) {
        error.value = 'Failed to load plans';
    } finally {
        loading.value = false;
    }
};

const fetchUserSubscription = async () => {
    if (!isLoggedIn.value) return;
    
    try {
        const response = await fetch('/api/website-subscriptions/status', {
            headers: {
                'Accept': 'application/json',
            },
        });
        const data = await response.json();
        if (data.subscribed && data.subscription) {
            userSubscription.value = {
                plan_type: data.subscription.plan,
                status: 'active',
            };
        }
    } catch (err) {
        console.error('Failed to fetch subscription:', err);
    }
};

const isCurrentPlan = (planSlug: string) => {
    return userSubscription.value?.plan_type === planSlug && userSubscription.value?.status === 'active';
};

const openSubscribeModal = (plan: WebsitePlan) => {
    if (!isLoggedIn.value) {
        router.visit('/register');
        return;
    }
    selectedPlan.value = plan;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedPlan.value = null;
    transactionId.value = '';
};

const copyNumber = () => {
    const number = '01309092748';
    navigator.clipboard.writeText(number).then(() => {
        copied.value = true;
        setTimeout(() => copied.value = false, 2000);
    });
};

const handleSubmit = async () => {
    if (!transactionId.value.trim() || !selectedPlan.value) return;
    
    isSubmitting.value = true;
    try {
        const response = await fetch(`/website-subscriptions/subscribe/${selectedPlan.value.slug}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || '',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                payment_method: 'bkash',
                transaction_id: transactionId.value,
            })
        });
        
        const result = await response.json();
        if (result.success) {
            closeModal();
            window.location.reload();
        }
    } catch (err) {
        console.error(err);
    } finally {
        isSubmitting.value = false;
    }
};

onMounted(() => {
    fetchPlans();
    fetchUserSubscription();
});
</script>

<template>
    <section id="website-subscription" class="py-20 bg-gray-50 dark:bg-slate-800/50">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-500/20 border border-indigo-200 dark:border-indigo-500/30 mb-4">
                    <CreditCard class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                    <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">ওয়েবসাইট সাবস্ক্রিপশন</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    সীমাহীন সার্চ অ্যাক্সেস
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    দৈনিক সীমা ছাড়াই যতবার খুশি কুরিয়ার ভেরিফাই করুন। সাশ্রয়ী মূল্যে সম্পূর্ণ অ্যাক্সেস।
                </p>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center py-12">
                <Loader2 class="w-8 h-8 text-indigo-400 animate-spin" />
            </div>

            <!-- Plans Grid -->
            <div v-else class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div
                    v-for="plan in plans"
                    :key="plan.id"
                    class="relative group"
                >
                    <!-- Current Plan Badge -->
                    <div 
                        v-if="isCurrentPlan(plan.slug)"
                        class="absolute -top-3 left-1/2 -translate-x-1/2 z-10"
                    >
                        <span class="px-4 py-1 text-xs font-semibold text-white bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center gap-1">
                            <Check class="w-3 h-3" />
                            সাবস্ক্রাইবড
                        </span>
                    </div>
                    <!-- Popular Badge -->
                    <div 
                        v-else-if="plan.is_popular"
                        class="absolute -top-3 left-1/2 -translate-x-1/2 z-10"
                    >
                        <span class="px-4 py-1 text-xs font-semibold text-white bg-gradient-to-r from-purple-600 to-pink-600 rounded-full">
                            জনপ্রিয়
                        </span>
                    </div>

                    <div 
                        class="relative h-full p-8 rounded-3xl border transition-all duration-300 hover:-translate-y-2"
                        :class="[
                            plan.is_popular 
                                ? 'bg-gradient-to-b from-indigo-50 to-purple-50 dark:from-slate-800 dark:to-slate-900 border-purple-300 dark:border-purple-500/50 hover:border-purple-400' 
                                : 'bg-gray-50 dark:bg-slate-800/50 border-gray-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-500/50'
                        ]"
                    >
                        <!-- Icon -->
                        <div 
                            class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6"
                            :class="getColorClasses(plan.color).bg"
                        >
                            <component 
                                :is="getIcon(plan.icon)" 
                                class="w-7 h-7"
                                :class="getColorClasses(plan.color).text"
                            />
                        </div>

                        <!-- Plan Name -->
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ plan.name }}</h3>
                        
                        <!-- Price -->
                        <div class="flex items-baseline gap-1 mb-4">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">{{ plan.formatted_price }}</span>
                            <span class="text-gray-500 dark:text-gray-400">/{{ plan.duration_text }}</span>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 dark:text-gray-400 mb-6">{{ plan.description }}</p>

                        <!-- Features -->
                        <ul class="space-y-3 mb-8">
                            <li 
                                v-for="(feature, index) in plan.features"
                                :key="index"
                                class="flex items-center gap-3 text-gray-700 dark:text-gray-300"
                            >
                                <div class="w-5 h-5 rounded-full bg-green-100 dark:bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                    <Check class="w-3 h-3 text-green-600 dark:text-green-400" />
                                </div>
                                <span class="text-sm">{{ feature }}</span>
                            </li>
                        </ul>

                        <!-- CTA Button -->
                        <button
                            v-if="isCurrentPlan(plan.slug)"
                            disabled
                            class="w-full py-4 rounded-xl font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 border-2 border-green-500 dark:border-green-500/50 cursor-not-allowed flex items-center justify-center gap-2"
                        >
                            <CheckCircle class="w-5 h-5" />
                            বর্তমান প্ল্যান
                        </button>
                        <button
                            v-else
                            @click="openSubscribeModal(plan)"
                            class="w-full py-4 rounded-xl font-semibold transition-all duration-300"
                            :class="[
                                plan.is_popular
                                    ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white hover:shadow-lg hover:shadow-purple-500/25'
                                    : 'bg-indigo-600 dark:bg-white/10 text-white hover:bg-indigo-700 dark:hover:bg-white/20'
                            ]"
                        >
                            {{ isLoggedIn ? 'সাবস্ক্রাইব করুন' : 'রেজিস্টার করুন' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Features Bar -->
            <div class="mt-16 flex flex-wrap justify-center gap-6">
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <Infinity class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                    <span>সীমাহীন সার্চ</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <Shield class="w-5 h-5 text-green-600 dark:text-green-400" />
                    <span>নির্ভরযোগ্য ডেটা</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <Zap class="w-5 h-5 text-yellow-600 dark:text-yellow-400" />
                    <span>তাৎক্ষণিক ফলাফল</span>
                </div>
            </div>
        </div>

        <!-- Payment Modal -->
        <Teleport to="body">
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
            >
                <!-- Backdrop -->
                <div 
                    class="absolute inset-0 bg-black/70 backdrop-blur-sm"
                    @click="closeModal"
                ></div>

                <!-- Modal -->
                <div class="relative w-full max-w-md bg-slate-800 rounded-3xl border border-slate-700 p-8 animate-fade-in">
                    <!-- Close Button -->
                    <button
                        @click="closeModal"
                        class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white transition-colors"
                    >
                        <X class="w-5 h-5" />
                    </button>

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-pink-500/20 flex items-center justify-center">
                            <CreditCard class="w-8 h-8 text-pink-400" />
                        </div>
                        <h3 class="text-xl font-bold text-white">bKash পেমেন্ট</h3>
                        <p class="text-gray-400 mt-1">{{ selectedPlan?.name }} - {{ selectedPlan?.formatted_price }}</p>
                    </div>

                    <!-- bKash Number -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            নিচের নম্বরে Send Money করুন:
                        </label>
                        <div class="flex items-center gap-2 p-4 bg-slate-900 rounded-xl border border-slate-700">
                            <span class="text-xl font-bold text-pink-400 flex-1">01309092748</span>
                            <button
                                @click="copyNumber"
                                class="p-2 text-gray-400 hover:text-white transition-colors"
                            >
                                <Copy v-if="!copied" class="w-5 h-5" />
                                <CheckCircle v-else class="w-5 h-5 text-green-400" />
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Personal (Send Money) এ টাকা পাঠান</p>
                    </div>

                    <!-- Transaction ID Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            ট্রানজেকশন আইডি:
                        </label>
                        <input
                            v-model="transactionId"
                            type="text"
                            placeholder="যেমন: TRX123456789"
                            class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        />
                    </div>

                    <!-- Submit Button -->
                    <button
                        @click="handleSubmit"
                        :disabled="isSubmitting || !transactionId.trim()"
                        class="w-full py-4 bg-gradient-to-r from-pink-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-pink-500/25 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <Loader2 v-if="isSubmitting" class="w-5 h-5 animate-spin" />
                        <span>{{ isSubmitting ? 'প্রসেসিং...' : 'কনফার্ম করুন' }}</span>
                    </button>

                    <!-- Note -->
                    <p class="text-xs text-center text-gray-500 mt-4">
                        <AlertCircle class="w-4 h-4 inline mr-1" />
                        অ্যাডমিন ভেরিফিকেশনের পর সাবস্ক্রিপশন অ্যাক্টিভ হবে
                    </p>
                </div>
            </div>
        </Teleport>
    </section>
</template>

<style scoped>
@keyframes fade-in {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.animate-fade-in {
    animation: fade-in 0.2s ease-out;
}
</style>
