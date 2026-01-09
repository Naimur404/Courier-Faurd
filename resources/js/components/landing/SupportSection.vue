<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { 
    MessageCircle, Phone, Headphones, ArrowRight,
    Shield, Clock, Lock, CheckCircle
} from 'lucide-vue-next';

const page = usePage();

const isLoggedIn = computed(() => !!page.props.auth?.user);

const settings = computed(() => page.props.settings as {
    phone?: string;
    whatsapp?: string;
});

const whatsappLink = computed(() => {
    const number = settings.value.whatsapp || '8801841414004';
    return `https://api.whatsapp.com/send?phone=${number}&text=Hi%20FraudShield%2C%20I%20need%20live%20support`;
});

const phoneNumber = computed(() => settings.value.phone || '01841414004');

const benefits = [
    { icon: Clock, text: 'দ্রুত ফল — স্মার্ট ক্যাশ ও অপ্টিমাইজড কুরিয়ার রাউটিং।' },
    { icon: Shield, text: 'বিশ্বাসযোগ্যতা — 99.99% আপটাইম, অবিরাম মনিটরিং।' },
    { icon: Lock, text: 'সুরক্ষিত সংযোগ — এন্ড-টু-এন্ড সিকিউর লিঙ্ক ও অডিট লগ।' },
];
</script>

<template>
    <section id="contact" class="py-12 bg-white dark:bg-slate-900">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-900/50 mb-4">
                    <Headphones class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                    <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">সাপোর্ট</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    লাইভ সাপোর্ট দরকার?
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    ইন্টিগ্রেশন সেটআপ, API অ্যাক্সেস বা প্রাইসিং নিয়ে প্রশ্ন থাকলে আমাদের টিম প্রস্তুত।
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Contact Cards -->
                    <div class="space-y-4">
                        <!-- WhatsApp -->
                        <a
                            :href="whatsappLink"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex items-center gap-4 p-6 bg-gradient-to-r from-green-500/10 to-emerald-500/10 dark:from-green-500/20 dark:to-emerald-500/20 rounded-2xl border border-green-200 dark:border-green-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                        >
                            <div class="p-4 bg-green-500 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                                <MessageCircle class="w-8 h-8 text-white" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                                    WhatsApp
                                </h3>
                                <p class="text-green-600 dark:text-green-400 font-medium">
                                    {{ phoneNumber }}
                                </p>
                            </div>
                            <ArrowRight class="w-6 h-6 text-green-500 group-hover:translate-x-2 transition-transform duration-300" />
                        </a>

                        <!-- Phone Call -->
                        <a
                            :href="`tel:${phoneNumber}`"
                            class="group flex items-center gap-4 p-6 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 dark:from-blue-500/20 dark:to-cyan-500/20 rounded-2xl border border-blue-200 dark:border-blue-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                        >
                            <div class="p-4 bg-blue-500 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                                <Phone class="w-8 h-8 text-white" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                                    কল করুন
                                </h3>
                                <p class="text-blue-600 dark:text-blue-400 font-medium">
                                    {{ phoneNumber }}
                                </p>
                            </div>
                            <ArrowRight class="w-6 h-6 text-blue-500 group-hover:translate-x-2 transition-transform duration-300" />
                        </a>

                        <!-- Quick Actions -->
                        <div class="flex gap-4 pt-4">
                            <!-- Show Dashboard & API Docs for logged in users -->
                            <template v-if="isLoggedIn">
                                <Link
                                    href="/dashboard"
                                    class="flex-1 flex items-center justify-center gap-2 py-4 bg-gray-100 dark:bg-slate-800 text-gray-900 dark:text-white font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-slate-700 transition-all duration-300"
                                >
                                    ড্যাশবোর্ড
                                </Link>
                                <Link
                                    href="/api/documentation"
                                    class="flex-1 flex items-center justify-center gap-2 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/25 transition-all duration-300"
                                >
                                    API ডকুমেন্টেশন
                                </Link>
                            </template>
                            <!-- Show Login & Register for guests -->
                            <template v-else>
                                <Link
                                    href="/login"
                                    class="flex-1 flex items-center justify-center gap-2 py-4 bg-gray-100 dark:bg-slate-800 text-gray-900 dark:text-white font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-slate-700 transition-all duration-300"
                                >
                                    লগইন
                                </Link>
                                <Link
                                    href="/register"
                                    class="flex-1 flex items-center justify-center gap-2 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/25 transition-all duration-300"
                                >
                                    রেজিস্টার
                                </Link>
                            </template>
                        </div>
                    </div>

                    <!-- Benefits Card -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-3xl p-8 border border-indigo-100 dark:border-indigo-800">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <CheckCircle class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                            কেন FraudShield?
                        </h3>

                        <div class="space-y-4">
                            <div
                                v-for="(benefit, index) in benefits"
                                :key="index"
                                class="flex items-start gap-4 p-4 bg-white dark:bg-slate-800 rounded-xl"
                            >
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex-shrink-0">
                                    <component 
                                        :is="benefit.icon" 
                                        class="w-5 h-5 text-indigo-600 dark:text-indigo-400" 
                                    />
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ benefit.text }}
                                </p>
                            </div>
                        </div>

                        <p class="text-center text-gray-600 dark:text-gray-400 mt-6 text-sm">
                            কুরিয়ার ইন্টেলিজেন্সের দ্রুততম প্ল্যাটফর্ম—<br/>
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">আপনার ডাটা, আপনার নিয়ন্ত্রণ।</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
