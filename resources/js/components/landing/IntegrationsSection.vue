<script setup lang="ts">
import { FileSpreadsheet, Globe, Code2, ArrowRight, Puzzle } from 'lucide-vue-next';

const integrations = [
    {
        icon: FileSpreadsheet,
        name: 'Google Sheets',
        description: 'শিট-এ লাইভ আপডেট—ম্যানুয়াল সার্চের ঝামেলা শেষ।',
        color: 'from-green-500 to-emerald-600',
        iconBg: 'bg-green-500/20',
        iconColor: 'text-green-500',
    },
    {
        icon: Globe,
        name: 'WordPress',
        description: 'ফর্ম/অর্ডারে রিয়েল-টাইম ভেরিফিকেশন।',
        color: 'from-blue-500 to-cyan-600',
        iconBg: 'bg-blue-500/20',
        iconColor: 'text-blue-500',
    },
    {
        icon: Code2,
        name: 'REST API',
        description: 'ERP/CRM/Shop-এ ইন্টিগ্রেট করুন।',
        color: 'from-purple-500 to-pink-600',
        iconBg: 'bg-purple-500/20',
        iconColor: 'text-purple-500',
    },
];
</script>

<template>
    <section id="integrations" class="py-12 bg-gray-50 dark:bg-slate-800/50">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-900/50 mb-4">
                    <Puzzle class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                    <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">ইন্টিগ্রেশন</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    ইন্টিগ্রেশন ও অটোমেশন
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    ডাটা যেখানে—কাজ সেখানেই। আপনার পছন্দের টুলসে সহজে ইন্টিগ্রেট করুন।
                </p>
            </div>

            <!-- Integrations Grid -->
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div
                    v-for="(integration, index) in integrations"
                    :key="index"
                    class="group relative bg-white dark:bg-slate-900 rounded-3xl p-8 border border-gray-100 dark:border-slate-700 hover:border-indigo-200 dark:hover:border-indigo-800 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2"
                >
                    <!-- Gradient Border Effect on Hover -->
                    <div 
                        class="absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500 -z-10 blur-xl"
                        :class="`bg-gradient-to-r ${integration.color}`"
                    ></div>

                    <!-- Icon -->
                    <div 
                        class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 transition-transform duration-300 group-hover:scale-110"
                        :class="integration.iconBg"
                    >
                        <component 
                            :is="integration.icon" 
                            class="w-8 h-8"
                            :class="integration.iconColor"
                        />
                    </div>

                    <!-- Content -->
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ integration.name }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                        {{ integration.description }}
                    </p>

                    <!-- Link -->
                    <a 
                        href="#"
                        class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-medium hover:gap-3 transition-all duration-300"
                    >
                        বিস্তারিত দেখুন
                        <ArrowRight class="w-4 h-4" />
                    </a>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-16 text-center">
                <div class="inline-flex flex-wrap justify-center gap-4 p-4 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center gap-2 px-4 py-2">
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">সব প্ল্যানে API অ্যাক্সেস</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2">
                        <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">ফ্রি ওয়ার্ডপ্রেস প্লাগইন</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2">
                        <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">ডকুমেন্টেশন ও সাপোর্ট</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
