<script setup lang="ts">
import { ref } from 'vue';
import { MessageCircle, Plus, Minus } from 'lucide-vue-next';

interface FAQ {
    question: string;
    answer: string;
}

const faqs: FAQ[] = [
    {
        question: 'FraudShield কিভাবে কাজ করে?',
        answer: 'FraudShield বাংলাদেশের প্রধান কুরিয়ার সার্ভিস (Steadfast, Pathao, RedX, Paperfly ইত্যাদি) থেকে গ্রাহকের ডেলিভারি ইতিহাস সংগ্রহ করে। মোবাইল নাম্বার দিয়ে সার্চ করলে আপনি দেখতে পাবেন গ্রাহক কতবার পার্সেল নিয়েছেন, কতবার ক্যান্সেল করেছেন এবং তাদের সাকসেস রেট কত।'
    },
    {
        question: 'API ইন্টিগ্রেশন কিভাবে করব?',
        answer: 'রেজিস্ট্রেশন করার পর ড্যাশবোর্ড থেকে API Key জেনারেট করুন। আমাদের API ডকুমেন্টেশন অনুসরণ করে আপনার ই-কমার্স সাইট বা অ্যাপে সহজেই ইন্টিগ্রেট করতে পারবেন। WooCommerce, Shopify এবং কাস্টম প্ল্যাটফর্মের জন্য রেডিমেড সলিউশন আছে।'
    },
    {
        question: 'প্রাইসিং প্ল্যান কিভাবে কাজ করে?',
        answer: 'আমাদের ফ্রি প্ল্যানে দৈনিক ১০টি সার্চ পাবেন। প্রিমিয়াম প্ল্যানে আনলিমিটেড সার্চ এবং API অ্যাক্সেস পাবেন। ব্যবসায়িক প্রয়োজনে এন্টারপ্রাইজ প্ল্যানও আছে যেখানে ডেডিকেটেড সাপোর্ট এবং কাস্টম ফিচার পাবেন।'
    },
    {
        question: 'ডেটা কতটুকু আপডেটেড থাকে?',
        answer: 'আমাদের সিস্টেম প্রতিদিন কুরিয়ার পার্টনারদের সাথে ডেটা সিঙ্ক করে। ফলে আপনি সবসময় সর্বশেষ ডেলিভারি তথ্য পাবেন। রিয়েল-টাইম আপডেটের জন্য API ব্যবহার করুন।'
    },
    {
        question: 'আমার ডেটা কি সুরক্ষিত?',
        answer: 'হ্যাঁ, সম্পূর্ণ সুরক্ষিত। আমরা SSL এনক্রিপশন, সিকিউর সার্ভার এবং ডেটা প্রাইভেসি পলিসি মেনে চলি। আপনার সার্চ ডেটা শুধুমাত্র আপনার অ্যাকাউন্টে দৃশ্যমান এবং তৃতীয় পক্ষের সাথে শেয়ার করা হয় না।'
    },
    {
        question: 'সাপোর্ট কিভাবে পাব?',
        answer: 'WhatsApp, ফোন কল বা ইমেইলে আমাদের সাপোর্ট টিম ২৪/৭ প্রস্তুত। ইন্টিগ্রেশন সেটআপ, টেকনিক্যাল সমস্যা বা বিলিং সংক্রান্ত যেকোনো প্রশ্নে সাহায্য পাবেন।'
    },
    {
        question: 'রিফান্ড পলিসি কি?',
        answer: 'যদি আমাদের সার্ভিসে সন্তুষ্ট না হন, প্রথম ৭ দিনের মধ্যে ফুল রিফান্ড পাবেন। শুধু সাপোর্ট টিমে যোগাযোগ করুন এবং রিফান্ডের কারণ জানান।'
    }
];

const openIndex = ref<number | null>(0);

const toggleFAQ = (index: number) => {
    openIndex.value = openIndex.value === index ? null : index;
};
</script>

<template>
    <section id="faq" class="py-20 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 relative overflow-hidden">
        <!-- Background decorations -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/20 border border-indigo-400/30 mb-6">
                    <MessageCircle class="w-4 h-4 text-indigo-400" />
                    <span class="text-sm font-medium text-indigo-300">প্রশ্নোত্তর</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">
                    যা জানতে চান
                </h2>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                    FraudShield সম্পর্কে সবচেয়ে জনপ্রিয় প্রশ্নগুলোর উত্তর
                </p>
            </div>

            <!-- FAQ Grid -->
            <div class="max-w-4xl mx-auto">
                <div class="grid gap-4">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="index"
                        class="group"
                    >
                        <div 
                            :class="[
                                'rounded-2xl border transition-all duration-300',
                                openIndex === index 
                                    ? 'bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border-indigo-400/50 shadow-lg shadow-indigo-500/10' 
                                    : 'bg-slate-800/50 border-slate-700/50 hover:border-slate-600/50 hover:bg-slate-800/80'
                            ]"
                        >
                            <button
                                @click="toggleFAQ(index)"
                                class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none"
                            >
                                <span 
                                    :class="[
                                        'text-lg font-semibold pr-4 transition-colors duration-300',
                                        openIndex === index ? 'text-white' : 'text-slate-300 group-hover:text-white'
                                    ]"
                                >
                                    {{ faq.question }}
                                </span>
                                <div 
                                    :class="[
                                        'flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-300',
                                        openIndex === index 
                                            ? 'bg-indigo-500 text-white rotate-0' 
                                            : 'bg-slate-700 text-slate-400 group-hover:bg-slate-600'
                                    ]"
                                >
                                    <Minus v-if="openIndex === index" class="w-4 h-4" />
                                    <Plus v-else class="w-4 h-4" />
                                </div>
                            </button>
                            
                            <div 
                                :class="[
                                    'overflow-hidden transition-all duration-300',
                                    openIndex === index ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'
                                ]"
                            >
                                <div class="px-6 pb-5 text-slate-400 leading-relaxed">
                                    {{ faq.answer }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom CTA -->
            <div class="text-center mt-16">
                <div class="inline-flex flex-col sm:flex-row items-center gap-4 p-6 rounded-2xl bg-gradient-to-r from-indigo-500/10 to-purple-500/10 border border-indigo-400/20">
                    <div class="text-center sm:text-left">
                        <p class="text-white font-semibold mb-1">আরও প্রশ্ন আছে?</p>
                        <p class="text-slate-400 text-sm">আমাদের সাপোর্ট টিম সবসময় প্রস্তুত</p>
                    </div>
                    <a
                        href="#contact"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-xl font-medium transition-all duration-300 shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40"
                    >
                        <MessageCircle class="w-5 h-5" />
                        যোগাযোগ করুন
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
