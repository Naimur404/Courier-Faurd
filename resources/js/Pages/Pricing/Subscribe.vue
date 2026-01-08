<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import NewLayout from '@/Layouts/NewLayout.vue'
import { 
    Crown, Check, ArrowLeft, ArrowRight, Copy, 
    CheckCircle, Clock, CreditCard, Phone, 
    AlertTriangle, Headphones, Loader2
} from 'lucide-vue-next'

interface Plan {
  id: number
  name: string
  description: string
  price: number
  formatted_price: string
  monthly_price: number
  yearly_price: number
  daily_limit: number
  duration_text: string
  features: string[]
}

interface Props {
  plan: Plan
  billing?: 'monthly' | 'yearly'
}

const props = defineProps<Props>()

// Get billing period from URL or default to monthly
const page = usePage()
const urlParams = new URLSearchParams(window.location.search)
const billingPeriod = ref<'monthly' | 'yearly'>(
  (urlParams.get('billing') as 'monthly' | 'yearly') || props.billing || 'monthly'
)

// Calculate the price based on billing period
const currentPrice = computed(() => {
  if (billingPeriod.value === 'yearly' && props.plan.yearly_price) {
    return props.plan.yearly_price
  }
  return props.plan.monthly_price || props.plan.price
})

const formattedCurrentPrice = computed(() => {
  return `৳${Number(currentPrice.value).toLocaleString()}`
})

const billingText = computed(() => {
  return billingPeriod.value === 'yearly' ? '১ বছর' : '১ মাস'
})

const copied = ref(false)

const form = useForm({
  payment_method: 'bkash',
  transaction_id: '',
  billing_period: billingPeriod.value,
  terms: false,
})

// Notification state
const notification = ref<{ show: boolean; message: string; type: 'success' | 'error' }>({
  show: false,
  message: '',
  type: 'success'
})

function showNotification(message: string, type: 'success' | 'error' = 'success') {
  notification.value = { show: true, message, type }
  setTimeout(() => {
    notification.value.show = false
  }, 3000)
}

function copyNumber() {
  const number = '01309092748'
  navigator.clipboard.writeText(number).then(() => {
    copied.value = true
    showNotification('নম্বর কপি হয়েছে!', 'success')
    setTimeout(() => { copied.value = false }, 2000)
  }).catch(() => {
    const textArea = document.createElement('textarea')
    textArea.value = number
    document.body.appendChild(textArea)
    textArea.select()
    document.execCommand('copy')
    document.body.removeChild(textArea)
    copied.value = true
    showNotification('নম্বর কপি হয়েছে!', 'success')
    setTimeout(() => { copied.value = false }, 2000)
  })
}

function submit() {
  if (!form.terms) {
    showNotification('পেমেন্ট নিশ্চিত করুন এবং শর্তাবলী মেনে নিন', 'error')
    return
  }
  form.post(`/pricing/subscribe/${props.plan.id}`)
}
</script>

<template>
  <Head>
    <title>{{ plan.name }} সাবস্ক্রাইব করুন - FraudShield</title>
  </Head>

  <NewLayout>
    <!-- Notification Toast -->
    <Teleport to="body">
      <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="translate-y-full opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-full opacity-0"
      >
        <div
          v-if="notification.show"
          :class="[
            'fixed top-24 left-1/2 -translate-x-1/2 z-50 px-6 py-3 rounded-xl shadow-2xl text-white flex items-center gap-2',
            notification.type === 'success' ? 'bg-green-500' : 'bg-red-500'
          ]"
        >
          <CheckCircle v-if="notification.type === 'success'" class="w-5 h-5" />
          <AlertTriangle v-else class="w-5 h-5" />
          {{ notification.message }}
        </div>
      </Transition>
    </Teleport>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-slate-900 py-16">
      <div class="absolute inset-0 bg-gradient-to-b from-transparent via-indigo-950/30 to-slate-900">
        <div class="absolute top-20 left-1/4 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-1/4 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl"></div>
      </div>
      
      <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
          <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-full mb-6">
            <CreditCard class="w-4 h-4 text-indigo-400" />
            <span class="text-white text-sm font-medium">সাবস্ক্রিপশন</span>
          </div>
          
          <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">{{ plan.name }}</span> প্ল্যানে সাবস্ক্রাইব করুন
          </h1>
          <p class="text-lg text-slate-300">
            নিরাপদ ম্যানুয়াল পেমেন্ট ভেরিফিকেশনের মাধ্যমে সাবস্ক্রিপশন সম্পন্ন করুন
          </p>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
      <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Plan Summary Card -->
            <div class="lg:col-span-1">
              <div class="bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 overflow-hidden sticky top-24">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-center">
                  <div class="inline-flex items-center justify-center w-14 h-14 bg-white/20 rounded-2xl mb-4">
                    <Crown class="w-7 h-7 text-white" />
                  </div>
                  <h2 class="text-2xl font-bold text-white mb-1">{{ plan.name }}</h2>
                  <p class="text-indigo-100 text-sm">{{ plan.description }}</p>
                </div>
                
                <div class="p-6">
                  <div class="text-center mb-6">
                    <div class="text-4xl font-bold text-white">{{ formattedCurrentPrice }}</div>
                    <div class="text-sm text-white/60">{{ billingText }} এর জন্য</div>
                    <div v-if="plan.daily_limit" class="inline-flex items-center gap-2 mt-3 px-3 py-1 bg-indigo-500/20 text-indigo-300 text-sm rounded-full">
                      Daily {{ plan.daily_limit }} সার্চ
                    </div>
                  </div>
                  
                  <!-- Plan Features -->
                  <div>
                    <h3 class="font-medium text-white mb-4 flex items-center text-sm">
                      <CheckCircle class="w-4 h-4 text-green-400 mr-2" />
                      যা অন্তর্ভুক্ত:
                    </h3>
                    <ul class="space-y-3">
                      <li v-for="feature in plan.features" :key="feature" class="flex items-start text-white/80">
                        <div class="flex-shrink-0 w-5 h-5 bg-green-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5">
                          <Check class="w-3 h-3 text-green-400" />
                        </div>
                        <span class="text-sm">{{ feature }}</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Payment & Form Section -->
            <div class="lg:col-span-2 space-y-6">
              
              <!-- Payment Instructions -->
              <div class="bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 overflow-hidden">
                <div class="bg-gradient-to-r from-pink-500/20 to-rose-500/20 p-6 border-b border-white/10">
                  <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                    <div class="w-10 h-10 bg-pink-500/20 rounded-xl flex items-center justify-center mr-3">
                      <Phone class="w-5 h-5 text-pink-400" />
                    </div>
                    পেমেন্ট নির্দেশনা
                  </h3>
                  
                  <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-2xl p-5 text-center">
                      <div class="inline-flex items-center justify-center w-10 h-10 bg-pink-500/20 rounded-xl mb-3">
                        <CreditCard class="w-5 h-5 text-pink-400" />
                      </div>
                      <p class="text-xs text-white/60 mb-2">পরিমাণ পাঠান</p>
                      <div class="text-2xl font-bold text-pink-400">{{ formattedCurrentPrice }}</div>
                      <p class="text-xs text-white/50 mt-1">বিকাশে</p>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-2xl p-5 text-center">
                      <div class="inline-flex items-center justify-center w-10 h-10 bg-pink-500/20 rounded-xl mb-3">
                        <Phone class="w-5 h-5 text-pink-400" />
                      </div>
                      <p class="text-xs text-white/60 mb-2">নম্বরে পাঠান</p>
                      <div class="text-xl font-bold text-pink-400">01309092748</div>
                      <button 
                        @click="copyNumber" 
                        class="inline-flex items-center gap-1 text-xs text-pink-400 hover:text-pink-300 font-medium mt-2 transition-colors"
                      >
                        <Copy v-if="!copied" class="w-3 h-3" />
                        <CheckCircle v-else class="w-3 h-3" />
                        {{ copied ? 'কপি হয়েছে!' : 'কপি করুন' }}
                      </button>
                    </div>
                  </div>
                  
                  <div class="mt-4 bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-4">
                    <div class="flex items-start">
                      <AlertTriangle class="w-5 h-5 text-yellow-400 flex-shrink-0 mr-3 mt-0.5" />
                      <p class="text-sm text-yellow-200">
                        পেমেন্ট পাঠানোর পর, নিচে ট্রানজেকশন আইডি দিন এবং সাবস্ক্রিপশন সম্পন্ন করুন।
                      </p>
                    </div>
                  </div>
                </div>

                <!-- Subscription Form -->
                <form @submit.prevent="submit" class="p-6">
                  <div class="space-y-5">
                    <div>
                      <label class="text-sm font-medium text-white mb-2 flex items-center">
                        <CreditCard class="w-4 h-4 text-indigo-400 mr-2" />
                        পেমেন্ট মেথড
                      </label>
                      <select 
                        v-model="form.payment_method"
                        class="w-full px-4 py-3 border border-white/20 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white/10 text-white text-sm mt-2"
                      >
                        <option value="bkash" class="bg-slate-800">🏦 বিকাশ মোবাইল ব্যাংকিং</option>
                      </select>
                    </div>

                    <div>
                      <label class="text-sm font-medium text-white mb-2 flex items-center">
                        <CheckCircle class="w-4 h-4 text-green-400 mr-2" />
                        ট্রানজেকশন আইডি
                      </label>
                      <input 
                        v-model="form.transaction_id"
                        type="text" 
                        required 
                        placeholder="আপনার বিকাশ ট্রানজেকশন আইডি দিন"
                        class="w-full px-4 py-3 border border-white/20 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white/10 text-white placeholder-white/40 text-sm mt-2"
                      />
                      <p v-if="form.errors.transaction_id" class="mt-2 text-xs text-red-400">
                        {{ form.errors.transaction_id }}
                      </p>
                      <p class="mt-2 text-xs text-white/50 bg-indigo-500/10 border border-indigo-500/20 rounded-lg p-3">
                        💡 বিকাশ পেমেন্ট সম্পন্ন করার পর আপনি এই আইডি পাবেন
                      </p>
                    </div>

                    <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                      <div class="flex items-start">
                        <input 
                          id="terms" 
                          v-model="form.terms"
                          type="checkbox" 
                          class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-white/30 rounded mt-0.5 flex-shrink-0 bg-white/10"
                        >
                        <label for="terms" class="ml-3 block text-sm text-white/80 leading-relaxed">
                          <span class="font-medium text-white">আমি নিশ্চিত করছি যে:</span>
                          <ul class="mt-2 space-y-1 text-white/60">
                            <li>• আমি <strong class="text-white">{{ formattedCurrentPrice }}</strong> পেমেন্ট সম্পন্ন করেছি</li>
                            <li>• আমি সেবার শর্তাবলী এবং গোপনীয়তা নীতি মেনে নিচ্ছি</li>
                          </ul>
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <Link 
                      href="/pricing" 
                      class="flex-1 bg-white/10 hover:bg-white/20 border border-white/20 text-white py-3 px-6 rounded-xl text-center font-medium transition-all flex items-center justify-center gap-2"
                    >
                      <ArrowLeft class="w-4 h-4" />
                      ফিরে যান
                    </Link>
                    <button 
                      type="submit" 
                      :disabled="form.processing"
                      class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-6 rounded-xl font-medium transition-all shadow-lg hover:shadow-indigo-500/25 disabled:opacity-50 flex items-center justify-center gap-2"
                    >
                      <Loader2 v-if="form.processing" class="w-4 h-4 animate-spin" />
                      <CheckCircle v-else class="w-4 h-4" />
                      সাবস্ক্রিপশন সম্পন্ন করুন
                    </button>
                  </div>
                </form>
              </div>

              <!-- Verification Timeline -->
              <div class="bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 p-6">
                <div class="text-center mb-8">
                  <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl mb-4">
                    <Clock class="w-6 h-6 text-white" />
                  </div>
                  <h3 class="text-xl font-bold text-white mb-2">এরপর কি হবে?</h3>
                  <p class="text-sm text-white/60">আপনার সাবস্ক্রিপশন যাত্রা</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                  <div class="flex items-center sm:flex-col sm:text-center p-4 bg-white/5 rounded-2xl border border-white/10">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full flex items-center justify-center text-lg font-bold mr-4 sm:mr-0 sm:mb-3">
                      ১
                    </div>
                    <div>
                      <h4 class="font-medium text-white">ফর্ম জমা দিন</h4>
                      <p class="text-xs text-white/50 mt-1">ট্রানজেকশন আইডি সহ</p>
                    </div>
                  </div>
                  
                  <div class="flex items-center sm:flex-col sm:text-center p-4 bg-white/5 rounded-2xl border border-white/10">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full flex items-center justify-center text-lg font-bold mr-4 sm:mr-0 sm:mb-3">
                      ২
                    </div>
                    <div>
                      <h4 class="font-medium text-white">যাচাইকরণ</h4>
                      <p class="text-xs text-white/50 mt-1">২-২৪ ঘন্টার মধ্যে</p>
                    </div>
                  </div>
                  
                  <div class="flex items-center sm:flex-col sm:text-center p-4 bg-white/5 rounded-2xl border border-white/10">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center mr-4 sm:mr-0 sm:mb-3">
                      <Check class="w-6 h-6" />
                    </div>
                    <div>
                      <h4 class="font-medium text-white">সক্রিয়!</h4>
                      <p class="text-xs text-white/50 mt-1">API ব্যবহার শুরু করুন</p>
                    </div>
                  </div>
                </div>
                
                <div class="mt-6 bg-indigo-500/10 border border-indigo-500/20 rounded-xl p-4 text-center">
                  <Headphones class="w-5 h-5 text-indigo-400 inline mr-2" />
                  <span class="text-sm text-indigo-200">
                    সাহায্য প্রয়োজন? যোগাযোগ করুন 
                    <a href="mailto:support@fraudshield.com" class="underline text-indigo-400 hover:text-indigo-300">support@fraudshield.com</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </NewLayout>
</template>
