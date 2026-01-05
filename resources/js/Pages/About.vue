<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { 
    Shield, Phone, Mail, MapPin, CheckCircle, Search, 
    Database, Smartphone, Users, Lock, Clock, Activity,
    Zap, Eye, Download
} from 'lucide-vue-next';
import { ref, onMounted } from 'vue';

// Search stats
const totalVerifications = ref<number | null>(null);

onMounted(async () => {
    try {
        const response = await fetch('/api/search-stats');
        const data = await response.json();
        if (data.success && data.data?.all_time) {
            totalVerifications.value = data.data.all_time;
        }
    } catch (error) {
        console.error('Failed to fetch search stats:', error);
    }
});

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

// Hero badges
const heroBadges = [
    { icon: CheckCircle, text: 'নিরাপদ যাচাইকরণ' },
    { icon: Shield, text: 'গ্রাহক সুরক্ষা' },
    { icon: Clock, text: '২৪/৭ মনিটরিং' },
    { icon: Activity, text: 'রিয়েল-টাইম ডাটা' },
];

// Mission features
const missionFeatures = [
    { icon: Zap, title: 'রিয়েল-টাইম যাচাইকরণ', desc: 'কুরিয়ার সত্যতা এবং ডেলিভারি স্ট্যাটাসের তাৎক্ষণিক যাচাই' },
    { icon: Shield, title: 'ফ্রড প্রতিরোধ', desc: 'প্রতারণামূলক কার্যকলাপ সনাক্ত এবং প্রতিরোধের জন্য উন্নত অ্যালগোরিদম' },
    { icon: Lock, title: 'গ্রাহক নিরাপত্তা', desc: 'সমস্ত কুরিয়ার লেনদেনের জন্য ব্যাপক সুরক্ষা' },
];

// Why choose us features
const whyChooseUs = [
    { icon: Search, title: 'উন্নত অনুসন্ধান', desc: 'কুরিয়ার তথ্য তাৎক্ষণিকভাবে যাচাই করার শক্তিশালী অনুসন্ধান ক্ষমতা' },
    { icon: Database, title: 'বিস্তৃত ডাটাবেস', desc: 'যাচাইকৃত কুরিয়ার সেবা এবং ডেলিভারি কর্মীদের বিস্তৃত ডাটাবেস' },
    { icon: Smartphone, title: 'মোবাইল অ্যাপ', desc: 'চলাফেরার সময় কুরিয়ার যাচাইকরণের জন্য আমাদের মোবাইল অ্যাপ ডাউনলোড করুন' },
];

// Team members
const teamMembers = [
    { icon: Shield, title: 'নিরাপত্তা দল', desc: 'প্ল্যাটফর্মের নিরাপত্তা নিশ্চিত করতে দক্ষ সাইবার নিরাপত্তা পেশাদাররা' },
    { icon: Users, title: 'ডেভেলপমেন্ট দল', desc: 'উদ্ভাবনী যাচাইকরণ সমাধান তৈরিতে দক্ষ ডেভেলপাররা' },
    { icon: Phone, title: 'সাপোর্ট দল', desc: 'যেকোনো যাচাইকরণ প্রয়োজনে সহায়তার জন্য ২৪/৭ গ্রাহক সেবা' },
];
</script>

<template>
    <Head>
        <title>About Us - FraudShield</title>
        <meta name="description" content="FraudShield - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম" />
    </Head>
    
    <AppLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 py-16 md:py-24">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-1/4 w-72 h-72 bg-indigo-500 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
            </div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center max-w-4xl mx-auto">
                    <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight">
                        FraudShield <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">সম্পর্কে জানুন</span>
                    </h1>
                    <p class="text-lg md:text-xl text-slate-300 leading-relaxed mb-8">
                        বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম - আপনার ব্যবসাকে নিরাপদ রাখতে আমরা প্রতিশ্রুতিবদ্ধ
                    </p>
                    
                    <!-- Hero Badges -->
                    <div class="flex flex-wrap justify-center gap-3 md:gap-4">
                        <div 
                            v-for="badge in heroBadges" 
                            :key="badge.text"
                            class="flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-full"
                        >
                            <component :is="badge.icon" class="w-4 h-4 text-indigo-400" />
                            <span class="text-white text-sm font-medium">{{ badge.text }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="py-16 bg-white dark:bg-slate-900">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <span class="text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide">আমাদের লক্ষ্য</span>
                    <p class="text-slate-600 dark:text-slate-400 mt-4 leading-relaxed">
                        আমরা অনলাইন বাণিজ্যের জন্য একটি নিরাপদ পরিবেশ তৈরি করতে প্রতিশ্রুতিবদ্ধ যেখানে বিস্তৃত কুরিয়ার যাচাইকরণ সেবা প্রদান করা হয়। আমাদের লক্ষ্য হল ফ্রড নির্মূল করা এবং গ্রাহক ও কুরিয়ার সেবার মধ্যে বিশ্বাস তৈরি করা।
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div 
                        v-for="feature in missionFeatures" 
                        :key="feature.title"
                        class="group p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-all duration-300 text-center"
                    >
                        <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-500 group-hover:scale-110 transition-all duration-300">
                            <component :is="feature.icon" class="w-8 h-8 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" />
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2">{{ feature.title }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">{{ feature.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trust Stats Section -->
        <section class="py-16 bg-gradient-to-r from-indigo-600 to-purple-600">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-3xl mx-auto mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">হাজারো ব্যবহারকারীর বিশ্বাস</h2>
                    <p class="text-indigo-100">
                        নিরাপদ কুরিয়ার যাচাইকরণের জন্য আমাদের প্ল্যাটফর্মে বিশ্বাস রাখেন হাজার হাজার সন্তুষ্ট গ্রাহক
                    </p>
                </div>
                
                <div class="grid grid-cols-2 gap-6 max-w-2xl mx-auto">
                    <div class="text-center p-8 bg-white/10 backdrop-blur-sm rounded-2xl">
                        <div class="text-4xl md:text-5xl font-bold text-white mb-2">
                            {{ totalVerifications ? formatBengaliNumber(totalVerifications) : '...' }}
                        </div>
                        <p class="text-indigo-200">মোট যাচাইকরণ</p>
                    </div>
                    <div class="text-center p-8 bg-white/10 backdrop-blur-sm rounded-2xl">
                        <div class="text-4xl md:text-5xl font-bold text-white mb-2">৯৯.৯%</div>
                        <p class="text-indigo-200">নিরাপত্তার হার</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="py-16 bg-slate-50 dark:bg-slate-800/50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <span class="text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide">আমাদের সুবিধা</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mt-2 mb-3">
                        কেন আমাদের বেছে নিবেন?
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400">
                        কুরিয়ার ফ্রড থেকে আপনাকে রক্ষা করতে আমরা ব্যাপক নিরাপত্তা সমাধান প্রদান করি
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div 
                        v-for="item in whyChooseUs" 
                        :key="item.title"
                        class="group p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300"
                    >
                        <div class="w-14 h-14 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-500 transition-all duration-300">
                            <component :is="item.icon" class="w-7 h-7 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" />
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2">{{ item.title }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">{{ item.desc }}</p>
                        
                        <template v-if="item.title === 'মোবাইল অ্যাপ'">
                            <a 
                                href="#" 
                                class="inline-flex items-center gap-2 mt-4 text-indigo-600 dark:text-indigo-400 font-medium text-sm hover:underline"
                            >
                                <Download class="w-4 h-4" />
                                অ্যাপ ডাউনলোড করুন
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="py-16 bg-white dark:bg-slate-900">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <span class="text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide">আমাদের দল</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mt-2 mb-3">
                        নিবেদিতপ্রাণ পেশাদাররা
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400">
                        সবার জন্য কুরিয়ার সেবা নিরাপদ করতে কাজ করে যাওয়া নিবেদিতপ্রাণ পেশাদাররা
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div 
                        v-for="member in teamMembers" 
                        :key="member.title"
                        class="group text-center p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-all duration-300"
                    >
                        <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center mb-4 group-hover:bg-indigo-500 transition-all duration-300">
                            <component :is="member.icon" class="w-8 h-8 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" />
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2">{{ member.title }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">{{ member.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="py-16 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900">
            <div class="container mx-auto px-4">
                <div class="text-center mb-10">
                    <span class="text-indigo-400 font-semibold text-sm uppercase tracking-wide">যোগাযোগ করুন</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-white mt-2 mb-3">
                        আমাদের সাথে যোগাযোগ করুন
                    </h2>
                    <p class="text-slate-400">
                        আমাদের সেবা সম্পর্কে প্রশ্ন আছে? আপনাকে নিরাপদ রাখতে আমরা এখানে আছি
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div class="group text-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 transition-all duration-300">
                        <div class="w-14 h-14 mx-auto bg-green-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-500 transition-all">
                            <Mail class="w-6 h-6 text-green-400 group-hover:text-white transition-colors" />
                        </div>
                        <h3 class="font-bold text-white mb-1">ইমেইল সাপোর্ট</h3>
                        <p class="text-slate-500 text-sm mb-2">ইমেইলের মাধ্যমে সহায়তা পান</p>
                        <p class="text-indigo-400">info@fraudshield.com</p>
                    </div>
                    
                    <div class="group text-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 transition-all duration-300">
                        <div class="w-14 h-14 mx-auto bg-indigo-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-500 transition-all">
                            <Phone class="w-6 h-6 text-indigo-400 group-hover:text-white transition-colors" />
                        </div>
                        <h3 class="font-bold text-white mb-1">ফোন সাপোর্ট</h3>
                        <p class="text-slate-500 text-sm mb-2">যেকোনো সময় আমাদের কল করুন</p>
                        <p class="text-indigo-400">+৮৮০ ১৩০৯-০৯২৭৪৮</p>
                    </div>
                    
                    <div class="group text-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 transition-all duration-300">
                        <div class="w-14 h-14 mx-auto bg-purple-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-500 transition-all">
                            <MapPin class="w-6 h-6 text-purple-400 group-hover:text-white transition-colors" />
                        </div>
                        <h3 class="font-bold text-white mb-1">অফিসের ঠিকানা</h3>
                        <p class="text-slate-500 text-sm mb-2">আমাদের অফিসে আসুন</p>
                        <p class="text-indigo-400">চট্টগ্রাম, বাংলাদেশ</p>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
