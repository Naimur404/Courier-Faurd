<script setup lang="ts">
import { 
    Building2, Users, 
    TrendingUp, Zap, Globe,
    CheckCircle, ArrowRight
} from 'lucide-vue-next';

const stats = [
    { value: '১০০+', label: 'সক্রিয় ব্যবহারকারী', icon: Users },
    { value: '৫০০+', label: 'দৈনিক সার্চ', icon: TrendingUp },
    { value: '৯৯.৯%', label: 'আপটাইম', icon: Zap },
    { value: '১০+', label: 'কুরিয়ার পার্টনার', icon: Globe },
];

const milestones = [
    { year: '২০২৩', title: 'যাত্রা শুরু', description: 'FraudShield এর আইডিয়া জন্ম নেয়' },
    { year: '২০২৪', title: 'বেটা লঞ্চ', description: 'প্রথম ১০০ ব্যবহারকারী যোগ' },
    { year: '২০২৫', title: 'API রিলিজ', description: 'ডেভেলপার API লঞ্চ' },
    { year: '২০২৬', title: 'সম্প্রসারণ', description: 'নতুন ফিচার ও পার্টনারশিপ' },
];
</script>

<template>
    <section id="about" class="py-16 bg-white dark:bg-slate-900">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/50 mb-4">
                    <Building2 class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">আমাদের সম্পর্কে</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    FraudShield কে আমরা?
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    বাংলাদেশের ই-কমার্স ব্যবসায়ীদের রিটার্ন সমস্যা থেকে মুক্তি দিতে আমরা কাজ করছি। 
                    আমাদের লক্ষ্য প্রতিটি অর্ডারে সঠিক সিদ্ধান্ত নিতে সাহায্য করা।
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
                <div
                    v-for="(stat, index) in stats"
                    :key="index"
                    class="text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-800/50 rounded-2xl border border-slate-200 dark:border-slate-700"
                >
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-xl mb-4">
                        <component :is="stat.icon" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        {{ stat.value }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        {{ stat.label }}
                    </div>
                </div>
            </div>

            <!-- Story Section -->
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">
                        আমাদের গল্প
                    </h3>
                    <div class="space-y-4 text-gray-600 dark:text-gray-400">
                        <p>
                            ই-কমার্স ব্যবসা করতে গিয়ে আমরা নিজেরাও রিটার্ন সমস্যায় পড়েছি। ফেক অর্ডার, 
                            ভুয়া নাম্বার, বার বার ক্যান্সেল — এসব সমস্যা প্রতিটি অনলাইন বিক্রেতার পরিচিত।
                        </p>
                        <p>
                            তখনই মাথায় এলো — যদি আগে থেকেই জানা যেত কোন গ্রাহক বিশ্বাসযোগ্য? এই চিন্তা 
                            থেকেই FraudShield এর জন্ম। আজ শত শত ব্যবসায়ী আমাদের প্ল্যাটফর্ম ব্যবহার করে 
                            রিটার্ন কমাচ্ছেন এবং লাভ বাড়াচ্ছেন।
                        </p>
                        <p>
                            আমরা বিশ্বাস করি সঠিক তথ্য দিয়ে সঠিক সিদ্ধান্ত নেওয়া সম্ভব। তাই প্রতিদিন 
                            আরও ভালো সার্ভিস দিতে কাজ করে যাচ্ছি।
                        </p>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-4">
                        <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                            <CheckCircle class="w-5 h-5" />
                            <span class="text-sm font-medium">১০০% বাংলাদেশী টিম</span>
                        </div>
                        <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                            <CheckCircle class="w-5 h-5" />
                            <span class="text-sm font-medium">লোকাল সাপোর্ট</span>
                        </div>
                        <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                            <CheckCircle class="w-5 h-5" />
                            <span class="text-sm font-medium">দ্রুত আপডেট</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-800/50 rounded-3xl p-8 border border-blue-100 dark:border-slate-700">
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6">আমাদের যাত্রা</h4>
                    <div class="space-y-6">
                        <div
                            v-for="(milestone, index) in milestones"
                            :key="index"
                            class="flex gap-4"
                        >
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {{ milestone.year.slice(-2) }}
                                </div>
                                <div v-if="index < milestones.length - 1" class="w-0.5 h-full bg-blue-200 dark:bg-blue-800 mt-2"></div>
                            </div>
                            <div class="pb-6">
                                <div class="text-sm text-blue-600 dark:text-blue-400 font-medium">{{ milestone.year }}</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ milestone.title }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ milestone.description }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-8 md:p-12">
                <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">
                    আমাদের সাথে যুক্ত হোন
                </h3>
                <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                    আজই FraudShield ব্যবহার শুরু করুন এবং আপনার ই-কমার্স ব্যবসায় রিটার্ন সমস্যা থেকে মুক্তি পান।
                </p>
                <a
                    href="#search"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold hover:bg-blue-50 transition-colors duration-300"
                >
                    বিনামূল্যে শুরু করুন
                    <ArrowRight class="w-5 h-5" />
                </a>
            </div>
        </div>
    </section>
</template>
