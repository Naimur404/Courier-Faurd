<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Card } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

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
    showNotification('নম্বর কপি হয়েছে!', 'bKash নম্বর ক্লিপবোর্ডে কপি হয়েছে', 'success')
  }).catch(() => {
    // Fallback
    const textArea = document.createElement('textarea')
    textArea.value = number
    document.body.appendChild(textArea)
    textArea.select()
    document.execCommand('copy')
    document.body.removeChild(textArea)
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
</script>

<template>
  <Head>
    <title>ওয়েবসাইট সাবস্ক্রিপশন - সীমাহীন সার্চ | Courier Fraud</title>
    <meta name="description" content="আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন। দৈনিক ২০ টাকা বা ১৫ দিনের জন্য ৫০ টাকা।" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
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
          :class="[
            'fixed top-5 right-5 z-[1000] min-w-[300px] max-w-[500px] rounded-xl p-4 shadow-lg backdrop-blur-sm',
            notification.type === 'success' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white border-l-4 border-green-700' : '',
            notification.type === 'error' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white border-l-4 border-red-700' : '',
            notification.type === 'info' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white border-l-4 border-blue-700' : ''
          ]"
        >
          <div class="flex items-center">
            <i :class="[
              'mr-3 text-xl',
              notification.type === 'success' ? 'fas fa-check-circle' : '',
              notification.type === 'error' ? 'fas fa-exclamation-circle' : '',
              notification.type === 'info' ? 'fas fa-info-circle' : ''
            ]"></i>
            <div class="flex-1">
              <div class="font-semibold mb-1">{{ notification.title }}</div>
              <div class="text-sm opacity-90">{{ notification.message }}</div>
            </div>
            <button @click="closeNotification" class="ml-3 opacity-70 hover:opacity-100 transition">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">
          <i class="fas fa-infinity mr-3"></i>
          সীমাহীন সার্চ প্ল্যান
        </h1>
        <p class="text-xl md:text-2xl text-indigo-100 max-w-3xl mx-auto">
          আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন
        </p>
      </div>
    </div>

    <!-- Current Subscription Status -->
    <div v-if="activeSubscription" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
          <div class="flex items-center">
            <div class="bg-green-100 dark:bg-green-800 rounded-full p-3 mr-4">
              <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
            </div>
            <div>
              <h3 class="text-lg font-bold text-green-800 dark:text-green-400">সক্রিয় সাবস্ক্রিপশন</h3>
              <p class="text-green-600 dark:text-green-500">
                প্ল্যান: {{ plans[activeSubscription.plan_type]?.name }} | 
                মেয়াদ শেষ: {{ formatDate(activeSubscription.expires_at) }}
              </p>
              <p class="text-sm text-green-500 dark:text-green-600 mt-1">
                <i class="fas fa-infinity mr-1"></i>
                আপনার বর্তমানে সীমাহীন সার্চ সুবিধা আছে
              </p>
            </div>
          </div>
          <div class="text-right">
            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ activeSubscription.formatted_amount }}</div>
            <div class="text-sm text-green-500">{{ activeSubscription.days_remaining }} দিন বাকি</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Subscription Plans -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
          সাবস্ক্রিপশন প্ল্যান
        </h2>
        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
          আপনার প্রয়োজন অনুযায়ী উপযুক্ত প্ল্যান বেছে নিন এবং সীমাহীন সার্চ করুন
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <div 
          v-for="(plan, planType) in plans" 
          :key="planType"
          :class="[
            'bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition duration-300',
            planType === 'weekly' ? 'ring-4 ring-indigo-500 ring-opacity-50' : ''
          ]"
        >
          <div v-if="planType === 'weekly'" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-center py-3">
            <span class="font-bold text-sm uppercase tracking-wide">
              <i class="fas fa-star mr-1"></i> সবচেয়ে জনপ্রিয়
            </span>
          </div>
          
          <div class="p-8">
            <div class="text-center">
              <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ plan.name }}</h3>
              <div class="text-5xl font-bold text-indigo-600 mb-2">
                ৳{{ plan.price.toLocaleString() }}
              </div>
              <p class="text-gray-500 dark:text-gray-400 mb-6">{{ plan.duration }}</p>
              
              <div class="text-gray-600 dark:text-gray-300 mb-8">
                <p class="text-lg">{{ plan.description }}</p>
              </div>

              <!-- Features -->
              <div class="space-y-4 mb-8">
                <div class="flex items-center justify-center">
                  <i class="fas fa-infinity text-indigo-500 mr-2"></i>
                  <span class="dark:text-gray-300">সীমাহীন সার্চ</span>
                </div>
                <div class="flex items-center justify-center">
                  <i class="fas fa-shield-check text-green-500 mr-2"></i>
                  <span class="dark:text-gray-300">ভেরিফাইড ডেটা</span>
                </div>
                <div class="flex items-center justify-center">
                  <i class="fas fa-clock text-blue-500 mr-2"></i>
                  <span class="dark:text-gray-300">তাৎক্ষণিক ফলাফল</span>
                </div>
                <div v-if="planType === 'weekly'" class="flex items-center justify-center">
                  <i class="fas fa-crown text-yellow-500 mr-2"></i>
                  <span class="dark:text-gray-300">সাশ্রয়ী মূল্য</span>
                </div>
              </div>

              <!-- Subscribe Button -->
              <template v-if="isAuthenticated">
                <button 
                  v-if="activeSubscription"
                  disabled 
                  class="w-full bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 py-3 px-6 rounded-xl font-bold cursor-not-allowed"
                >
                  <i class="fas fa-check mr-2"></i>
                  ইতিমধ্যে সাবস্ক্রাইব করা আছে
                </button>
                <button 
                  v-else
                  @click="subscribeToPlan(planType as string)"
                  class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-6 rounded-xl font-bold transform hover:scale-105 transition duration-200 shadow-lg"
                >
                  <i class="fas fa-credit-card mr-2"></i>
                  এখনই সাবস্ক্রাইব করুন
                </button>
              </template>
              <Link 
                v-else
                href="/login" 
                class="block w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-6 rounded-xl font-bold text-center transform hover:scale-105 transition duration-200 shadow-lg"
              >
                <i class="fas fa-sign-in-alt mr-2"></i>
                লগইন করে সাবস্ক্রাইব করুন
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white dark:bg-gray-800 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">সাবস্ক্রিপশনের সুবিধা</h2>
          <p class="text-xl text-gray-600 dark:text-gray-400">আমাদের সাবস্ক্রিপশন নিয়ে পান এই সব বিশেষ সুবিধা</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="bg-indigo-100 dark:bg-indigo-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-infinity text-indigo-600 dark:text-indigo-300 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">সীমাহীন সার্চ</h3>
            <p class="text-gray-600 dark:text-gray-400">দৈনিক সীমা ছাড়াই যতবার খুশি কুরিয়ার ভেরিফাই করুন</p>
          </div>

          <div class="text-center">
            <div class="bg-green-100 dark:bg-green-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-shield-check text-green-600 dark:text-green-300 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">নির্ভরযোগ্য ডেটা</h3>
            <p class="text-gray-600 dark:text-gray-400">১০০% সঠিক এবং আপডেটেড কুরিয়ার তথ্য</p>
          </div>

          <div class="text-center">
            <div class="bg-blue-100 dark:bg-blue-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-clock text-blue-600 dark:text-blue-300 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">তাৎক্ষণিক ফলাফল</h3>
            <p class="text-gray-600 dark:text-gray-400">কোন অপেক্ষা ছাড়াই তুরন্ত ফলাফল পান</p>
          </div>
        </div>
      </div>
    </div>

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
          <div class="absolute inset-0 bg-black/50" @click="closeModal"></div>
          
          <!-- Modal Content -->
          <div class="relative bg-white dark:bg-gray-800 rounded-xl p-6 max-w-md w-full shadow-2xl">
            <div class="text-center">
              <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-800 mb-4">
                <i class="fas fa-credit-card text-indigo-600 dark:text-indigo-300 text-xl"></i>
              </div>
              <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                {{ selectedPlanDetails?.name }} - ৳{{ selectedPlanDetails?.price }}
              </h3>
              
              <form @submit.prevent="handleSubmit">
                <div class="mb-6">
                  <Label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">পেমেন্ট মেথড</Label>
                  <div class="bg-pink-50 dark:bg-pink-900/20 border border-pink-200 dark:border-pink-800 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                      <div class="bg-pink-600 text-white rounded-lg px-3 py-1 text-sm font-bold mr-3">bKash</div>
                      <span class="text-gray-700 dark:text-gray-300 font-medium">পেমেন্ট নম্বর</span>
                    </div>
                    <div class="bg-white dark:bg-gray-700 border rounded-lg p-3 mb-3">
                      <div class="flex items-center justify-between">
                        <span class="font-mono text-lg font-bold text-gray-900 dark:text-white">01309092748</span>
                        <button 
                          type="button" 
                          @click="copyNumber" 
                          class="bg-pink-100 hover:bg-pink-200 dark:bg-pink-800 dark:hover:bg-pink-700 text-pink-700 dark:text-pink-200 px-3 py-1 rounded text-sm font-medium transition-colors"
                        >
                          <i class="fas fa-copy mr-1"></i> কপি
                        </button>
                      </div>
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 text-left">
                      <p class="mb-2"><strong>পেমেন্ট প্রক্রিয়া:</strong></p>
                      <ol class="list-decimal list-inside space-y-1 text-xs">
                        <li>উপরের নম্বরে bKash Send Money করুন</li>
                        <li>ট্রানজেকশন সম্পন্ন হলে ট্রানজেকশন আইডি নিচে লিখুন</li>
                        <li>সাবস্ক্রাইব বাটনে ক্লিক করুন</li>
                      </ol>
                    </div>
                  </div>
                </div>
                
                <div class="mb-6 text-left">
                  <Label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ট্রানজেকশন আইডি *</Label>
                  <Input 
                    v-model="transactionId"
                    type="text" 
                    placeholder="bKash ট্রানজেকশন আইডি লিখুন" 
                    required
                  />
                  <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">পেমেন্ট সম্পন্ন হওয়ার পর যে আইডি পাবেন তা এখানে লিখুন</p>
                </div>
                
                <div class="flex space-x-3">
                  <button 
                    type="button" 
                    @click="closeModal" 
                    class="flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white py-2 px-4 rounded-lg font-medium transition duration-200"
                  >
                    বাতিল
                  </button>
                  <button 
                    type="submit" 
                    :disabled="isSubmitting"
                    class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200 disabled:opacity-50"
                  >
                    <i v-if="isSubmitting" class="fas fa-spinner fa-spin mr-2"></i>
                    সাবস্ক্রাইব করুন
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </AppLayout>
</template>
