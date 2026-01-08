<script setup lang="ts">
import { 
    Users, Search, Filter, Download, BarChart3, 
    Shield, Clock, Layers, FileSpreadsheet, Zap
} from 'lucide-vue-next';

const features = [
    {
        icon: Users,
        title: 'রোল-ভিত্তিক লগইন',
        description: 'টিমভিত্তিক পারমিশন—অ্যাডমিন/অপস/ভিউ-অনলি।',
        color: 'from-blue-500 to-cyan-500',
        bgColor: 'bg-blue-500/10',
    },
    {
        icon: Search,
        title: 'সার্চ বাই নাম্বার',
        description: 'একক থেকে ৫০০ নম্বর—দ্রুত ও নির্ভুল রেজাল্ট।',
        color: 'from-purple-500 to-pink-500',
        bgColor: 'bg-purple-500/10',
    },
    {
        icon: Filter,
        title: 'স্মার্ট ফিল্টার',
        description: 'কুরিয়ার, স্ট্যাটাস, তারিখ অনুযায়ী ফিল্টার করুন।',
        color: 'from-green-500 to-emerald-500',
        bgColor: 'bg-green-500/10',
    },
    {
        icon: Download,
        title: 'বাল্ক এক্সপোর্ট',
        description: 'CSV/Excel ফরম্যাটে রেজাল্ট ডাউনলোড করুন।',
        color: 'from-orange-500 to-amber-500',
        bgColor: 'bg-orange-500/10',
    },
    {
        icon: BarChart3,
        title: 'ড্যাশবোর্ড অ্যানালিটিক্স',
        description: 'রিয়েল-টাইম স্ট্যাটস ও চার্ট ভিউ।',
        color: 'from-indigo-500 to-violet-500',
        bgColor: 'bg-indigo-500/10',
    },
    {
        icon: Shield,
        title: 'রিস্ক স্কোরিং',
        description: 'AI-পাওয়ার্ড ফ্রড রিস্ক অ্যাসেসমেন্ট।',
        color: 'from-red-500 to-rose-500',
        bgColor: 'bg-red-500/10',
    },
    {
        icon: Clock,
        title: 'রিয়েল-টাইম আপডেট',
        description: 'সব কুরিয়ার থেকে লাইভ ডাটা সিঙ্ক।',
        color: 'from-teal-500 to-cyan-500',
        bgColor: 'bg-teal-500/10',
    },
    {
        icon: Layers,
        title: 'মাল্টি-কুরিয়ার সাপোর্ট',
        description: 'বাংলাদেশের সব প্রধান কুরিয়ার সার্ভিস।',
        color: 'from-fuchsia-500 to-pink-500',
        bgColor: 'bg-fuchsia-500/10',
    },
];
</script>

<template>
    <section id="features" class="py-12 bg-white dark:bg-slate-900">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-900/50 mb-4">
                    <Zap class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                    <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">ফিচারস</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    যা পাবেন FraudShield-এ
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    ফাস্ট ওয়ার্কফ্লো, সহজ নিয়ন্ত্রণ, স্কেলেবল অবকাঠামো—সব এক জায়গায়।
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    v-for="(feature, index) in features"
                    :key="index"
                    class="group relative p-6 bg-gray-50 dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 hover:border-indigo-200 dark:hover:border-indigo-800 transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
                >
                    <!-- Icon -->
                    <div 
                        class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 transition-transform duration-300 group-hover:scale-110"
                        :class="feature.bgColor"
                    >
                        <component 
                            :is="feature.icon" 
                            class="w-7 h-7 bg-gradient-to-r bg-clip-text"
                            :class="`text-${feature.color.split(' ')[0].replace('from-', '')}`"
                        />
                    </div>

                    <!-- Content -->
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                        {{ feature.title }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ feature.description }}
                    </p>

                    <!-- Hover Effect -->
                    <div 
                        class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                        :class="`bg-gradient-to-br ${feature.color} opacity-5`"
                    ></div>
                </div>
            </div>
        </div>
    </section>
</template>
