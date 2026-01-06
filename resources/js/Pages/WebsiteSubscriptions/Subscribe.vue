<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/components/ui/Button.vue';
import Card from '@/components/ui/Card.vue';
import { CreditCard, Check, Clock, Shield, Infinity, ArrowLeft } from 'lucide-vue-next';

interface Plan {
    name: string;
    price: number;
    duration: string;
    description: string;
    type: string;
}

const props = defineProps<{
    selectedPlan: Plan;
}>();

const form = useForm({
    payment_method: 'bkash',
    transaction_id: '',
});

const paymentMethods = [
    { id: 'bkash', name: 'bKash', logo: '/assets/bkash-logo.png' },
    { id: 'nagad', name: 'Nagad', logo: '/assets/nagad-logo.png' },
    { id: 'rocket', name: 'Rocket', logo: '/assets/rocket-logo.png' },
];

const submitPayment = () => {
    form.post(`/website-subscriptions/subscribe/${props.selectedPlan.type}`, {
        preserveScroll: true,
    });
};

// Format number to Bengali
const formatBengaliNumber = (num: number): string => {
    const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    return num.toLocaleString('en-IN').split('').map(char => {
        if (char >= '0' && char <= '9') {
            return bengaliDigits[parseInt(char)];
        }
        return char;
    }).join('');
};
</script>

<template>
    <Head>
        <title>Subscribe - {{ selectedPlan.name }} | FraudShield</title>
        <meta name="description" :content="`Subscribe to ${selectedPlan.name} plan for unlimited courier verification searches.`" />
        <link rel="canonical" :href="`https://fraudshieldbd.site/website-subscriptions/subscribe/${selectedPlan.type}`" />
        <meta property="og:title" :content="`Subscribe to ${selectedPlan.name} | FraudShield`" />
        <meta property="og:type" content="website" />
        <meta name="robots" content="noindex, nofollow" />
    </Head>
    
    <AppLayout>
        <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12 px-4">
            <div class="max-w-2xl mx-auto">
                <!-- Back Button -->
                <Link 
                    href="/website-subscriptions" 
                    class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 mb-6 transition-colors"
                >
                    <ArrowLeft class="w-4 h-4 mr-2" />
                    সাবস্ক্রিপশন প্ল্যানে ফিরে যান
                </Link>
                
                <!-- Plan Summary -->
                <Card class="mb-8 p-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold mb-2">{{ selectedPlan.name }}</h2>
                            <p class="text-indigo-100">{{ selectedPlan.description }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-4xl font-bold">৳{{ formatBengaliNumber(selectedPlan.price) }}</div>
                            <div class="text-indigo-200">{{ selectedPlan.duration }}</div>
                        </div>
                    </div>
                    
                    <!-- Features -->
                    <div class="mt-6 grid grid-cols-3 gap-4">
                        <div class="flex items-center">
                            <Infinity class="w-5 h-5 mr-2" />
                            <span class="text-sm">সীমাহীন সার্চ</span>
                        </div>
                        <div class="flex items-center">
                            <Shield class="w-5 h-5 mr-2" />
                            <span class="text-sm">ভেরিফাইড ডেটা</span>
                        </div>
                        <div class="flex items-center">
                            <Clock class="w-5 h-5 mr-2" />
                            <span class="text-sm">তাৎক্ষণিক ফলাফল</span>
                        </div>
                    </div>
                </Card>
                
                <!-- Payment Form -->
                <Card class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 flex items-center">
                        <CreditCard class="w-6 h-6 mr-2 text-indigo-600" />
                        পেমেন্ট মেথড নির্বাচন করুন
                    </h3>
                    
                    <form @submit.prevent="submitPayment">
                        <!-- Payment Methods -->
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <label 
                                v-for="method in paymentMethods" 
                                :key="method.id"
                                class="relative cursor-pointer"
                            >
                                <input 
                                    type="radio" 
                                    v-model="form.payment_method" 
                                    :value="method.id"
                                    class="sr-only peer"
                                />
                                <div class="p-4 border-2 rounded-xl text-center transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 hover:border-indigo-300">
                                    <img :src="method.logo" :alt="method.name" class="h-8 mx-auto mb-2" />
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ method.name }}</span>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Payment Instructions -->
                        <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4 mb-6">
                            <h4 class="font-bold text-yellow-800 dark:text-yellow-200 mb-2">পেমেন্ট নির্দেশনা:</h4>
                            <ol class="list-decimal list-inside text-yellow-700 dark:text-yellow-300 text-sm space-y-1">
                                <li>নিচের নম্বরে ৳{{ selectedPlan.price }} টাকা পাঠান</li>
                                <li>bKash/Nagad/Rocket: 01309092748</li>
                                <li>Transaction ID নিচে দিন</li>
                            </ol>
                        </div>
                        
                        <!-- Transaction ID -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Transaction ID
                            </label>
                            <input 
                                type="text" 
                                v-model="form.transaction_id"
                                placeholder="Enter your transaction ID"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                            />
                            <p v-if="form.errors.transaction_id" class="mt-1 text-sm text-red-500">{{ form.errors.transaction_id }}</p>
                        </div>
                        
                        <!-- Submit Button -->
                        <Button 
                            type="submit"
                            :disabled="form.processing"
                            class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl transition-all"
                        >
                            <span v-if="form.processing">প্রসেসিং...</span>
                            <span v-else class="flex items-center justify-center">
                                <Check class="w-5 h-5 mr-2" />
                                সাবস্ক্রিপশন কনফার্ম করুন
                            </span>
                        </Button>
                    </form>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
