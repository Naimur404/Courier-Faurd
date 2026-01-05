<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { 
  Infinity, Shield, Clock, Crown, CreditCard, 
  Check, Copy, X, AlertCircle, CheckCircle, Info,
  Sparkles, Zap, Star, ArrowRight
} from 'lucide-vue-next'

interface Plan {
  name: string
  price: number
  duration: string
  description: string
  days: number
}

interface ActiveSubscription {
  plan_type: string
  expires_at: string
  formatted_amount: string
  days_remaining: number
}

interface Props {
  plans: Record<string, Plan>
  activeSubscription: ActiveSubscription | null
}

const props = defineProps<Props>()
const page = usePage()

const showModal = ref(false)
const selectedPlan = ref<string | null>(null)
const selectedPlanDetails = ref<Plan | null>(null)
const transactionId = ref('')
const isSubmitting = ref(false)
const copied = ref(false)

// Notification state
const notification = ref<{ show: boolean; title: string; message: string; type: 'success' | 'error' | 'info' }>({
  show: false,
  title: '',
  message: '',
  type: 'info'
})

const isAuthenticated = computed(() => page.props.auth?.user !== null)

function showNotification(title: string, message: string, type: 'success' | 'error' | 'info' = 'info') {
  notification.value = { show: true, title, message, type }
  setTimeout(() => {
    notification.value.show = false
  }, 5000)
}

function closeNotification() {
  notification.value.show = false
}

function copyNumber() {
  const number = '01309092748'
  navigator.clipboard.writeText(number).then(() => {
    copied.value = true
    setTimeout(() => copied.value = false, 2000)
    showNotification('নম্বর কপি হয়েছে!', 'bKash নম্বর ক্লিপবোর্ডে কপি হয়েছে', 'success')
  }).catch(() => {
    const textArea = document.createElement('textarea')
    textArea.value = number
    document.body.appendChild(textArea)
    textArea.select()
    document.execCommand('copy')
    document.body.removeChild(textArea)
    copied.value = true
    setTimeout(() => copied.value = false, 2000)
    showNotification('নম্বর কপি হয়েছে!', 'bKash নম্বর ক্লিপবোর্ডে কপি হয়েছে', 'success')
  })
}

function subscribeToPlan(planType: string) {
  selectedPlan.value = planType
  selectedPlanDetails.value = props.plans[planType]
  showModal.value = true
}

function closeModal() {
  showModal.value = false
  selectedPlan.value = null
  selectedPlanDetails.value = null
  transactionId.value = ''
}

async function handleSubmit() {
  if (!transactionId.value.trim()) {
    showNotification('ট্রানজেকশন আইডি প্রয়োজন', 'অনুগ্রহ করে bKash ট্রানজেকশন আইডি প্রদান করুন', 'error')
    return
  }

  isSubmitting.value = true

  try {
    const response = await fetch(`/website-subscriptions/subscribe/${selectedPlan.value}`, {
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
    })

    const result = await response.json()

    if (result.success) {
      showNotification('সাবস্ক্রিপশন সফল!', 'আপনার সাবস্ক্রিপশন সফলভাবে সক্রিয় হয়েছে। অ্যাডমিনের অনুমোদনের অপেক্ষায় রয়েছে।', 'success')
      closeModal()
      setTimeout(() => {
        window.location.reload()
      }, 2000)
    } else {
      showNotification('সাবস্ক্রিপশন ব্যর্থ', result.message || 'সাবস্ক্রিপশন প্রক্রিয়ায় সমস্যা হয়েছে।', 'error')
    }
  } catch (error) {
    showNotification('নেটওয়ার্ক ত্রুটি', 'সাবস্ক্রিপশন প্রক্রিয়ায় সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error')
  } finally {
    isSubmitting.value = false
  }
}

function formatDate(dateStr: string): string {
  return new Date(dateStr).toLocaleDateString('bn-BD', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
    hour: 'numeric',
    minute: '2-digit'
  })
}

// Features for subscription
const features = [
  { icon: Infinity, title: 'সীমাহীন সার্চ', desc: 'দৈনিক সীমা ছাড়াই যতবার খুশি কুরিয়ার ভেরিফাই করুন', color: 'indigo' },
  { icon: Shield, title: 'নির্ভরযোগ্য ডেটা', desc: '১০০% সঠিক এবং আপডেটেড কুরিয়ার তথ্য', color: 'green' },
  { icon: Zap, title: 'তাৎক্ষণিক ফলাফল', desc: 'কোন অপেক্ষা ছাড়াই তুরন্ত ফলাফল পান', color: 'blue' },
]
</script>

<template>
  <Head>
    <title>ওয়েবসাইট সাবস্ক্রিপশন - সীমাহীন সার্চ | Courier Fraud</title>
    <meta name="description" content="আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন। দৈনিক ২০ টাকা বা ১৫ দিনের জন্য ৫০ টাকা।" />
  </Head>

  <AppLayout>
    <!-- Notification -->
    <Teleport to="body">
      <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="translate-x-full opacity-0"
        enter-to-class="translate-x-0 opacity-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="translate-x-0 opacity-100"
        leave-to-class="translate-x-full opacity-0"
      >
        <div
          v-if="notification.show"
          class="fixed top-5 right-5 z-[1000] min-w-[320px] max-w-[420px] rounded-2xl shadow-2xl overflow-hidden"
        >
          <div :class="[
            'p-4 flex items-start gap-3',
            notification.type === 'success' ? 'bg-gradient-to-r from-emerald-500 to-green-600' : '',
            notification.type === 'error' ? 'bg-gradient-to-r from-red-500 to-rose-600' : '',
            notification.type === 'info' ? 'bg-gradient-to-r from-blue-500 to-indigo-600' : ''
          ]">
            <div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
              <CheckCircle v-if="notification.type === 'success'" class="w-5 h-5 text-white" />
              <AlertCircle v-else-if="notification.type === 'error'" class="w-5 h-5 text-white" />
              <Info v-else class="w-5 h-5 text-white" />
            </div>
            <div class="flex-1 text-white">
              <h4 class="font-bold text-sm">{{ notification.title }}</h4>
              <p class="text-sm text-white/90 mt-0.5">{{ notification.message }}</p>
            </div>
            <button @click="closeNotification" class="text-white/70 hover:text-white transition">
              <X class="w-5 h-5" />
            </button>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 py-20 md:py-28">
      <!-- Background Effects -->
      <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-full blur-3xl"></div>
      </div>
      
      <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
          <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-full mb-6">
            <Sparkles class="w-4 h-4 text-yellow-400" />
            <span class="text-white/90 text-sm font-medium">প্রিমিয়াম ফিচার আনলক করুন</span>
          </div>
          
          <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
            সীমাহীন সার্চ
            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">
              প্ল্যান
            </span>
          </h1>
          
          <p class="text-lg md:text-xl text-slate-300 leading-relaxed max-w-2xl mx-auto">
            আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন এবং আপনার ব্যবসাকে নিরাপদ রাখুন
          </p>
        </div>
      </div>
    </section>

    <!-- Active Subscription Banner -->
    <div v-if="activeSubscription" class="relative -mt-8 z-20 container mx-auto px-4">
      <div class="max-w-4xl mx-auto">
        <div class="bg-gradient-to-r from-emerald-500 to-green-600 rounded-2xl p-6 shadow-xl shadow-green-500/20">
          <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
              <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                <CheckCircle class="w-7 h-7 text-white" />
              </div>
              <div class="text-white">
                <h3 class="text-xl font-bold">সক্রিয় সাবস্ক্রিপশন</h3>
                <p class="text-white/80">
                  {{ plans[activeSubscription.plan_type]?.name }} | মেয়াদ শেষ: {{ formatDate(activeSubscription.expires_at) }}
                </p>
              </div>
            </div>
            <div class="text-center md:text-right">
              <div class="flex items-center gap-2 text-white">
                <Infinity class="w-5 h-5" />
                <span class="text-sm">সীমাহীন সার্চ সুবিধা সক্রিয়</span>
              </div>
              <div class="text-2xl font-bold text-white mt-1">{{ activeSubscription.days_remaining }} দিন বাকি</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Subscription Plans -->
    <section class="py-20 bg-slate-50 dark:bg-slate-900">
      <div class="container mx-auto px-4">
        <div class="text-center mb-14">
          <span class="text-indigo-600 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide">মূল্য তালিকা</span>
          <h2 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mt-2 mb-4">
            আপনার প্রয়োজন অনুযায়ী প্ল্যান বেছে নিন
          </h2>
          <p class="text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
            সাশ্রয়ী মূল্যে সীমাহীন সার্চ সুবিধা নিন এবং আপনার ব্যবসাকে ফ্রড থেকে রক্ষা করুন
          </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
          <div 
            v-for="(plan, planType) in plans" 
            :key="planType"
            :class="[
              'group relative bg-white dark:bg-slate-800 rounded-3xl overflow-hidden transition-all duration-500 hover:shadow-2xl',
              planType === 'weekly' ? 'ring-2 ring-indigo-500 shadow-xl shadow-indigo-500/10' : 'shadow-lg hover:shadow-xl'
            ]"
          >
            <!-- Popular Badge -->
            <div v-if="planType === 'weekly'" class="absolute top-0 right-0">
              <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-xs font-bold px-4 py-2 rounded-bl-2xl flex items-center gap-1">
                <Star class="w-3 h-3 fill-current" />
                জনপ্রিয়
              </div>
            </div>
            
            <div class="p-8">
              <!-- Plan Header -->
              <div class="mb-8">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ plan.name }}</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm">{{ plan.description }}</p>
              </div>
              
              <!-- Price -->
              <div class="mb-8">
                <div class="flex items-baseline gap-1">
                  <span class="text-5xl font-bold text-slate-900 dark:text-white">৳{{ plan.price }}</span>
                  <span class="text-slate-500 dark:text-slate-400">/{{ plan.duration }}</span>
                </div>
              </div>

              <!-- Features -->
              <div class="space-y-4 mb-8">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                    <Infinity class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                  </div>
                  <span class="text-slate-700 dark:text-slate-300">সীমাহীন সার্চ</span>
                </div>
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                    <Shield class="w-4 h-4 text-green-600 dark:text-green-400" />
                  </div>
                  <span class="text-slate-700 dark:text-slate-300">ভেরিফাইড ডেটা</span>
                </div>
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                    <Clock class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                  </div>
                  <span class="text-slate-700 dark:text-slate-300">তাৎক্ষণিক ফলাফল</span>
                </div>
                <div v-if="planType === 'weekly'" class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/50 rounded-lg flex items-center justify-center">
                    <Crown class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                  </div>
                  <span class="text-slate-700 dark:text-slate-300">সাশ্রয়ী মূল্য</span>
                </div>
              </div>

              <!-- CTA Button -->
              <template v-if="isAuthenticated">
                <button 
                  v-if="activeSubscription"
                  disabled 
                  class="w-full py-4 px-6 rounded-xl font-bold bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 cursor-not-allowed flex items-center justify-center gap-2"
                >
                  <Check class="w-5 h-5" />
                  ইতিমধ্যে সাবস্ক্রাইব করা আছে
                </button>
                <button 
                  v-else
                  @click="subscribeToPlan(planType as string)"
                  :class="[
                    'w-full py-4 px-6 rounded-xl font-bold transition-all duration-300 flex items-center justify-center gap-2 group-hover:gap-3',
                    planType === 'weekly' 
                      ? 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white shadow-lg shadow-indigo-500/30' 
                      : 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-100'
                  ]"
                >
                  <CreditCard class="w-5 h-5" />
                  এখনই সাবস্ক্রাইব করুন
                  <ArrowRight class="w-4 h-4 transition-transform group-hover:translate-x-1" />
                </button>
              </template>
              <Link 
                v-else
                href="/login" 
                :class="[
                  'w-full py-4 px-6 rounded-xl font-bold transition-all duration-300 flex items-center justify-center gap-2',
                  planType === 'weekly' 
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white shadow-lg shadow-indigo-500/30' 
                    : 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-100'
                ]"
              >
                লগইন করে সাবস্ক্রাইব করুন
                <ArrowRight class="w-4 h-4" />
              </Link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white dark:bg-slate-800/50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-14">
          <span class="text-indigo-600 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide">সুবিধাসমূহ</span>
          <h2 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mt-2 mb-4">
            সাবস্ক্রিপশনের সুবিধা
          </h2>
          <p class="text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
            আমাদের সাবস্ক্রিপশন নিয়ে পান এই সব বিশেষ সুবিধা
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
          <div 
            v-for="feature in features" 
            :key="feature.title"
            class="group text-center p-8 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-gradient-to-br hover:from-indigo-50 hover:to-purple-50 dark:hover:from-indigo-950/30 dark:hover:to-purple-950/30 transition-all duration-300"
          >
            <div :class="[
              'w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-5 transition-all duration-300 group-hover:scale-110',
              feature.color === 'indigo' ? 'bg-indigo-100 dark:bg-indigo-900/50' : '',
              feature.color === 'green' ? 'bg-green-100 dark:bg-green-900/50' : '',
              feature.color === 'blue' ? 'bg-blue-100 dark:bg-blue-900/50' : ''
            ]">
              <component 
                :is="feature.icon" 
                :class="[
                  'w-8 h-8',
                  feature.color === 'indigo' ? 'text-indigo-600 dark:text-indigo-400' : '',
                  feature.color === 'green' ? 'text-green-600 dark:text-green-400' : '',
                  feature.color === 'blue' ? 'text-blue-600 dark:text-blue-400' : ''
                ]"
              />
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">{{ feature.title }}</h3>
            <p class="text-slate-600 dark:text-slate-400">{{ feature.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Subscription Modal -->
    <Teleport to="body">
      <Transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
          <!-- Backdrop -->
          <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeModal"></div>
          
          <!-- Modal Content -->
          <Transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 scale-95 translate-y-4"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
          >
            <div v-if="showModal" class="relative bg-white dark:bg-slate-800 rounded-3xl p-8 max-w-md w-full shadow-2xl">
              <!-- Close Button -->
              <button 
                @click="closeModal" 
                class="absolute top-4 right-4 w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition"
              >
                <X class="w-5 h-5" />
              </button>

              <!-- Modal Header -->
              <div class="text-center mb-6">
                <div class="w-16 h-16 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4">
                  <CreditCard class="w-8 h-8 text-white" />
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">
                  {{ selectedPlanDetails?.name }}
                </h3>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">
                  ৳{{ selectedPlanDetails?.price }}
                </p>
              </div>
              
              <form @submit.prevent="handleSubmit">
                <!-- Payment Method -->
                <div class="mb-6">
                  <Label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">পেমেন্ট মেথড</Label>
                  <div class="bg-gradient-to-br from-pink-50 to-rose-50 dark:from-pink-950/30 dark:to-rose-950/30 border border-pink-200 dark:border-pink-800/50 rounded-2xl p-5">
                    <div class="flex items-center gap-3 mb-4">
                      <div class="bg-pink-600 text-white font-bold px-3 py-1 rounded-lg text-sm">bKash</div>
                      <span class="text-slate-700 dark:text-slate-300 font-medium">পেমেন্ট করুন</span>
                    </div>
                    
                    <!-- bKash Number -->
                    <div class="bg-white dark:bg-slate-700 rounded-xl p-4 mb-4 flex items-center justify-between">
                      <span class="font-mono text-xl font-bold text-slate-900 dark:text-white">01309092748</span>
                      <button 
                        type="button" 
                        @click="copyNumber" 
                        :class="[
                          'flex items-center gap-2 px-4 py-2 rounded-lg font-medium text-sm transition-all',
                          copied 
                            ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' 
                            : 'bg-pink-100 hover:bg-pink-200 text-pink-700 dark:bg-pink-900/50 dark:hover:bg-pink-800 dark:text-pink-300'
                        ]"
                      >
                        <Check v-if="copied" class="w-4 h-4" />
                        <Copy v-else class="w-4 h-4" />
                        {{ copied ? 'কপি হয়েছে' : 'কপি' }}
                      </button>
                    </div>
                    
                    <!-- Instructions -->
                    <div class="text-sm text-slate-600 dark:text-slate-400">
                      <p class="font-semibold mb-2">পেমেন্ট প্রক্রিয়া:</p>
                      <ol class="space-y-1.5">
                        <li class="flex items-start gap-2">
                          <span class="w-5 h-5 bg-pink-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">১</span>
                          <span>উপরের নম্বরে bKash Send Money করুন</span>
                        </li>
                        <li class="flex items-start gap-2">
                          <span class="w-5 h-5 bg-pink-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">২</span>
                          <span>ট্রানজেকশন আইডি নিচে লিখুন</span>
                        </li>
                        <li class="flex items-start gap-2">
                          <span class="w-5 h-5 bg-pink-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">৩</span>
                          <span>সাবস্ক্রাইব বাটনে ক্লিক করুন</span>
                        </li>
                      </ol>
                    </div>
                  </div>
                </div>
                
                <!-- Transaction ID Input -->
                <div class="mb-6">
                  <Label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">ট্রানজেকশন আইডি *</Label>
                  <Input 
                    v-model="transactionId"
                    type="text" 
                    placeholder="bKash ট্রানজেকশন আইডি লিখুন" 
                    class="h-12 rounded-xl"
                    required
                  />
                  <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">পেমেন্ট সম্পন্ন হওয়ার পর যে আইডি পাবেন তা এখানে লিখুন</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-3">
                  <button 
                    type="button" 
                    @click="closeModal" 
                    class="flex-1 py-3 px-4 rounded-xl font-semibold bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 transition"
                  >
                    বাতিল
                  </button>
                  <button 
                    type="submit" 
                    :disabled="isSubmitting"
                    class="flex-1 py-3 px-4 rounded-xl font-semibold bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                  >
                    <svg v-if="isSubmitting" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    সাবস্ক্রাইব করুন
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>
      </Transition>
    </Teleport>
  </AppLayout>
</template>
