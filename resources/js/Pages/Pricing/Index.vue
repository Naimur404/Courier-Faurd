<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, computed } from 'vue'
import { 
    Crown, Rocket, Gem, Check, Clock, 
    ArrowRight, Copy, CheckCircle, HelpCircle, 
    Zap, Shield, Phone, Star, ArrowLeft
} from 'lucide-vue-next'

interface Plan {
  id: number
  name: string
  description: string
  formatted_price: string
  duration_text: string
  features: string[]
}

interface Props {
  plans: Plan[]
}

const props = defineProps<Props>()

const page = usePage()
const user = computed(() => page.props.auth?.user)
const hasActiveSubscription = computed(() => page.props.auth?.hasActiveSubscription ?? false)

const copied = ref(false)

const copyToClipboard = (text: string) => {
  navigator.clipboard.writeText(text).then(() => {
    copied.value = true
    setTimeout(() => {
      copied.value = false
    }, 2000)
  })
}

const planIcons = [Rocket, Crown, Gem]
const planColors = [
    { gradient: 'from-emerald-500 to-green-600', light: 'bg-emerald-100 dark:bg-emerald-900/50', text: 'text-emerald-600 dark:text-emerald-400' },
    { gradient: 'from-indigo-500 to-purple-600', light: 'bg-indigo-100 dark:bg-indigo-900/50', text: 'text-indigo-600 dark:text-indigo-400' },
    { gradient: 'from-purple-500 to-pink-600', light: 'bg-purple-100 dark:bg-purple-900/50', text: 'text-purple-600 dark:text-purple-400' },
]

const faqs = [
  {
    icon: Clock,
    title: 'যাচাইকরণে কত সময় লাগে?',
    answer: 'পেমেন্ট যাচাইকরণ সাধারণত ২-২৪ ঘন্টার মধ্যে সম্পন্ন হয়। সক্রিয় হলে আপনি ইমেইল নিশ্চিতকরণ পাবেন।'
  },
  {
    icon: Zap,
    title: 'আমি কি প্ল্যান আপগ্রেড করতে পারি?',
    answer: 'হ্যাঁ, আপনি যেকোনো সময় উচ্চতর প্ল্যানে আপগ্রেড করতে পারেন। সহায়তার জন্য সাপোর্ট টিমে যোগাযোগ করুন।'
  },
  {
    icon: Shield,
    title: 'ফ্রি ট্রায়াল আছে কি?',
    answer: 'নতুন ব্যবহারকারীদের জন্য সীমিত ফ্রি সার্চ অফার করা হয়। ট্রায়াল অ্যাক্সেসের জন্য সাপোর্ট টিমে যোগাযোগ করুন।'
  },
  {
    icon: HelpCircle,
    title: 'লিমিট শেষ হলে কি হবে?',
    answer: 'দৈনিক কোটা শেষ হলে API রিকোয়েস্ট সীমিত হবে। উচ্চতর লিমিটের জন্য আপগ্রেড করুন।'
  }
]
</script>

<template>
  <Head>
    <title>API প্ল্যান - FraudShield</title>
    <meta name="description" content="আপনার ব্যবসার জন্য সঠিক প্ল্যান বেছে নিন। সমস্ত প্ল্যানে রিয়েল-টাইম কুরিয়ার ট্র্যাকিং API এবং ২৪/৭ সাপোর্ট অন্তর্ভুক্ত।" />
  </Head>

  <AppLayout>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 py-16 md:py-20">
      <!-- Background Pattern -->
      <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-1/4 w-72 h-72 bg-indigo-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
      </div>
      
      <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
          <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-full mb-6">
            <Crown class="w-4 h-4 text-yellow-400" />
            <span class="text-white text-sm font-medium">API সাবস্ক্রিপশন প্ল্যান</span>
          </div>
          
          <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight">
            আপনার <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">প্ল্যান</span> বেছে নিন
          </h1>
          <p class="text-lg md:text-xl text-slate-300 leading-relaxed">
            আপনার ব্যবসার প্রয়োজনে সঠিক প্ল্যান নির্বাচন করুন। সমস্ত প্ল্যানে রিয়েল-টাইম আপডেট এবং ২৪/৭ সাপোর্ট অন্তর্ভুক্ত।
          </p>
        </div>
      </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="py-16 bg-white dark:bg-slate-900">
      <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-6 lg:gap-8 max-w-6xl mx-auto">
          <div 
            v-for="(plan, index) in plans" 
            :key="plan.id"
            :class="[
              'group relative p-6 lg:p-8 rounded-2xl transition-all duration-300',
              index === 1 
                ? 'bg-gradient-to-br from-indigo-600 to-purple-600 text-white ring-4 ring-indigo-500/30 scale-105 shadow-2xl' 
                : 'bg-slate-50 dark:bg-slate-800 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 hover:shadow-xl'
            ]"
          >
            <!-- Popular Badge -->
            <div 
              v-if="index === 1" 
              class="absolute -top-3 left-1/2 -translate-x-1/2 bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1 rounded-full flex items-center gap-1"
            >
              <Star class="w-3 h-3" />
              সবচেয়ে জনপ্রিয়
            </div>

            <!-- Icon -->
            <div 
              :class="[
                'w-14 h-14 rounded-2xl flex items-center justify-center mb-5',
                index === 1 ? 'bg-white/20' : planColors[index]?.light
              ]"
            >
              <component 
                :is="planIcons[index]" 
                :class="[
                  'w-7 h-7',
                  index === 1 ? 'text-white' : planColors[index]?.text
                ]" 
              />
            </div>

            <!-- Plan Name & Description -->
            <h3 :class="[
              'text-xl font-bold mb-2',
              index === 1 ? 'text-white' : 'text-slate-900 dark:text-white'
            ]">
              {{ plan.name }}
            </h3>
            <p :class="[
              'text-sm mb-6',
              index === 1 ? 'text-indigo-100' : 'text-slate-500 dark:text-slate-400'
            ]">
              {{ plan.description }}
            </p>

            <!-- Price -->
            <div class="mb-6">
              <span :class="[
                'text-4xl font-bold',
                index === 1 ? 'text-white' : 'text-slate-900 dark:text-white'
              ]">
                {{ plan.formatted_price }}
              </span>
              <span :class="[
                'text-sm',
                index === 1 ? 'text-indigo-200' : 'text-slate-500 dark:text-slate-400'
              ]">
                / {{ plan.duration_text }}
              </span>
            </div>

            <!-- Features -->
            <ul class="space-y-3 mb-8">
              <li 
                v-for="feature in plan.features" 
                :key="feature" 
                class="flex items-start gap-3"
              >
                <div :class="[
                  'w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5',
                  index === 1 ? 'bg-white/20' : 'bg-green-100 dark:bg-green-900/50'
                ]">
                  <Check :class="[
                    'w-3 h-3',
                    index === 1 ? 'text-white' : 'text-green-600 dark:text-green-400'
                  ]" />
                </div>
                <span :class="[
                  'text-sm leading-relaxed',
                  index === 1 ? 'text-indigo-100' : 'text-slate-600 dark:text-slate-300'
                ]">
                  {{ feature }}
                </span>
              </li>
            </ul>

            <!-- CTA Button -->
            <template v-if="user">
              <button 
                v-if="hasActiveSubscription"
                disabled 
                :class="[
                  'w-full py-3 px-6 rounded-xl font-semibold flex items-center justify-center gap-2 cursor-not-allowed',
                  index === 1 
                    ? 'bg-white/20 text-white/60' 
                    : 'bg-slate-200 dark:bg-slate-700 text-slate-400 dark:text-slate-500'
                ]"
              >
                <CheckCircle class="w-4 h-4" />
                ইতিমধ্যে সাবস্ক্রাইব করা
              </button>
              <Link 
                v-else
                :href="`/pricing/subscribe/${plan.id}`" 
                :class="[
                  'w-full py-3 px-6 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300',
                  index === 1 
                    ? 'bg-white text-indigo-600 hover:bg-indigo-50' 
                    : `bg-gradient-to-r ${planColors[index]?.gradient} text-white hover:shadow-lg hover:-translate-y-0.5`
                ]"
              >
                সাবস্ক্রাইব করুন
                <ArrowRight class="w-4 h-4" />
              </Link>
            </template>
            <Link 
              v-else
              href="/login" 
              :class="[
                'w-full py-3 px-6 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300',
                index === 1 
                  ? 'bg-white text-indigo-600 hover:bg-indigo-50' 
                  : `bg-gradient-to-r ${planColors[index]?.gradient} text-white hover:shadow-lg hover:-translate-y-0.5`
              ]"
            >
              শুরু করুন
              <Rocket class="w-4 h-4" />
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Payment Information Section -->
    <section class="py-16 bg-slate-50 dark:bg-slate-800/50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <span class="text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide">পেমেন্ট পদ্ধতি</span>
          <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mt-2 mb-3">
            পেমেন্ট তথ্য
          </h2>
          <p class="text-slate-600 dark:text-slate-400">
            সহজ এবং নিরাপদ পেমেন্ট প্রক্রিয়া
          </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
          <!-- Bkash Payment -->
          <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 lg:p-8 shadow-sm">
            <div class="flex items-center gap-4 mb-6">
              <div class="w-14 h-14 bg-pink-100 dark:bg-pink-900/50 rounded-xl flex items-center justify-center">
                <Phone class="w-7 h-7 text-pink-600 dark:text-pink-400" />
              </div>
              <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">বিকাশ পেমেন্ট</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">সেন্ড মানি করুন</p>
              </div>
            </div>

            <div class="bg-gradient-to-r from-pink-50 to-rose-50 dark:from-pink-900/20 dark:to-rose-900/20 border border-pink-200 dark:border-pink-800 rounded-xl p-6 text-center">
              <p class="text-slate-600 dark:text-slate-400 text-sm mb-3">নিচের নম্বরে টাকা পাঠান:</p>
              <div class="bg-white dark:bg-slate-900 rounded-lg p-4 mb-4 shadow-sm">
                <p class="text-2xl md:text-3xl font-bold text-pink-600 dark:text-pink-400 mb-2">01309092748</p>
                <button 
                  @click="copyToClipboard('01309092748')" 
                  class="inline-flex items-center gap-2 text-sm text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300 font-medium transition-colors"
                >
                  <Copy v-if="!copied" class="w-4 h-4" />
                  <CheckCircle v-else class="w-4 h-4" />
                  {{ copied ? 'কপি হয়েছে!' : 'নম্বর কপি করুন' }}
                </button>
              </div>
              <p class="text-sm text-pink-700 dark:text-pink-300 bg-pink-100 dark:bg-pink-900/30 rounded-lg p-3">
                টাকা পাঠিয়ে সাবস্ক্রিপশনের সময় ট্রানজেকশন আইডি দিন।
              </p>
            </div>
          </div>

          <!-- Process Timeline -->
          <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 lg:p-8 shadow-sm">
            <div class="flex items-center gap-4 mb-6">
              <div class="w-14 h-14 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center">
                <Clock class="w-7 h-7 text-indigo-600 dark:text-indigo-400" />
              </div>
              <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">প্রক্রিয়া টাইমলাইন</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">ধাপে ধাপে গাইড</p>
              </div>
            </div>

            <div class="space-y-4">
              <div class="flex items-start gap-4">
                <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">
                  ১
                </div>
                <div>
                  <p class="text-slate-900 dark:text-white font-medium">প্ল্যান নির্বাচন ও পেমেন্ট</p>
                  <p class="text-slate-500 dark:text-slate-400 text-sm">প্ল্যান বেছে নিন এবং বিকাশে পেমেন্ট করুন</p>
                </div>
              </div>
              <div class="flex items-start gap-4">
                <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">
                  ২
                </div>
                <div>
                  <p class="text-slate-900 dark:text-white font-medium">ট্রানজেকশন আইডি জমা দিন</p>
                  <p class="text-slate-500 dark:text-slate-400 text-sm">বিকাশ ট্রানজেকশন আইডি প্রদান করুন</p>
                </div>
              </div>
              <div class="flex items-start gap-4">
                <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">
                  ৩
                </div>
                <div>
                  <p class="text-slate-900 dark:text-white font-medium">পেমেন্ট যাচাইকরণ</p>
                  <p class="text-slate-500 dark:text-slate-400 text-sm">২-২৪ ঘন্টার মধ্যে যাচাই করা হয়</p>
                </div>
              </div>
              <div class="flex items-start gap-4">
                <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center flex-shrink-0">
                  <Check class="w-4 h-4" />
                </div>
                <div>
                  <p class="text-slate-900 dark:text-white font-medium">সাবস্ক্রিপশন সক্রিয়</p>
                  <p class="text-slate-500 dark:text-slate-400 text-sm">এখনই API ব্যবহার শুরু করুন</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white dark:bg-slate-900">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <span class="text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide">সাধারণ প্রশ্ন</span>
          <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mt-2 mb-3">
            সচরাচর জিজ্ঞাসা
          </h2>
          <p class="text-slate-600 dark:text-slate-400">
            আমাদের প্ল্যান এবং সেবা সম্পর্কে আপনার যা জানা দরকার
          </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 max-w-5xl mx-auto">
          <div 
            v-for="faq in faqs" 
            :key="faq.title"
            class="group p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-all duration-300"
          >
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-500 transition-all duration-300">
                <component :is="faq.icon" class="w-6 h-6 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" />
              </div>
              <div>
                <h3 class="font-bold text-slate-900 dark:text-white mb-2">{{ faq.title }}</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">{{ faq.answer }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Back to Home -->

  </AppLayout>
</template>
