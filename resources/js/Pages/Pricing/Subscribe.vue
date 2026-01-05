<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Card } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

interface Plan {
  id: number
  name: string
  description: string
  price: number
  formatted_price: string
  duration_text: string
  features: string[]
}

interface Props {
  plan: Plan
}

const props = defineProps<Props>()

const form = useForm({
  payment_method: 'bkash',
  transaction_id: '',
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
    showNotification('Number copied to clipboard!', 'success')
  }).catch(() => {
    const textArea = document.createElement('textarea')
    textArea.value = number
    document.body.appendChild(textArea)
    textArea.select()
    document.execCommand('copy')
    document.body.removeChild(textArea)
    showNotification('Number copied to clipboard!', 'success')
  })
}

function submit() {
  if (!form.terms) {
    showNotification('Please confirm the payment and agree to terms', 'error')
    return
  }
  form.post(`/pricing/subscribe/${props.plan.id}`)
}
</script>

<template>
  <Head>
    <title>Subscribe to {{ plan.name }} - Courier Fraud</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  </Head>

  <AppLayout>
    <!-- Notification Toast -->
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
            'fixed top-4 right-4 z-50 px-4 py-3 rounded-xl shadow-lg text-white',
            notification.type === 'success' ? 'bg-green-500' : 'bg-red-500'
          ]"
        >
          <i :class="notification.type === 'success' ? 'fas fa-check mr-2' : 'fas fa-exclamation-circle mr-2'"></i>
          {{ notification.message }}
        </div>
      </Transition>
    </Teleport>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8 sm:py-12">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
          <!-- Header -->
          <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl mb-4">
              <i class="fas fa-credit-card text-white text-lg"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
              Subscribe to <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">{{ plan.name }}</span>
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 max-w-xl mx-auto">
              Complete your subscription with secure manual payment verification
            </p>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Plan Summary Card -->
            <div class="lg:col-span-1">
              <Card class="overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4">
                  <div class="text-center">
                    <div class="inline-flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg mb-3">
                      <i class="fas fa-crown text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold mb-1">{{ plan.name }}</h2>
                    <p class="text-blue-100 text-xs">{{ plan.description }}</p>
                  </div>
                </div>
                
                <div class="p-4">
                  <div class="text-center mb-4">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ plan.formatted_price }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">for {{ plan.duration_text }}</div>
                  </div>
                  
                  <!-- Plan Features -->
                  <div>
                    <h3 class="font-medium text-gray-900 dark:text-white mb-3 flex items-center text-sm">
                      <i class="fas fa-check-circle text-green-500 mr-2"></i>
                      What's included:
                    </h3>
                    <ul class="space-y-2">
                      <li v-for="feature in plan.features" :key="feature" class="flex items-start text-gray-700 dark:text-gray-300">
                        <div class="flex-shrink-0 w-4 h-4 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-2 mt-0.5">
                          <i class="fas fa-check text-green-600 dark:text-green-400 text-[8px]"></i>
                        </div>
                        <span class="text-xs leading-relaxed">{{ feature }}</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </Card>
            </div>

            <!-- Payment & Form Section -->
            <div class="lg:col-span-2">
              <Card class="overflow-hidden">
                <!-- Payment Instructions -->
                <div class="bg-gradient-to-r from-pink-50 to-rose-50 dark:from-pink-900/20 dark:to-rose-900/20 p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700">
                  <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg flex items-center justify-center mr-2">
                      <i class="fas fa-mobile-alt text-pink-600 dark:text-pink-400 text-sm"></i>
                    </div>
                    Payment Instructions
                  </h3>
                  
                  <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white dark:bg-gray-800 border-2 border-pink-200 dark:border-pink-700 rounded-xl p-4 text-center">
                      <div class="inline-flex items-center justify-center w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg mb-2">
                        <i class="fas fa-money-bill-wave text-pink-600 dark:text-pink-400 text-sm"></i>
                      </div>
                      <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Send exactly</p>
                      <div class="text-xl font-bold text-pink-600 dark:text-pink-400">{{ plan.formatted_price }}</div>
                      <p class="text-xs text-gray-500 dark:text-gray-400">via Bkash</p>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 border-2 border-pink-200 dark:border-pink-700 rounded-xl p-4 text-center">
                      <div class="inline-flex items-center justify-center w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg mb-2">
                        <i class="fas fa-phone text-pink-600 dark:text-pink-400 text-sm"></i>
                      </div>
                      <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Send to</p>
                      <div class="text-lg font-bold text-pink-600 dark:text-pink-400">01309092748</div>
                      <button @click="copyNumber" class="text-xs text-pink-600 dark:text-pink-400 hover:text-pink-700 font-medium">
                        <i class="fas fa-copy mr-1"></i>Copy
                      </button>
                    </div>
                  </div>
                  
                  <div class="mt-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-3">
                    <div class="flex items-start">
                      <div class="flex-shrink-0 w-6 h-6 bg-yellow-100 dark:bg-yellow-800 rounded flex items-center justify-center mr-2">
                        <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 text-xs"></i>
                      </div>
                      <p class="text-xs text-yellow-700 dark:text-yellow-300">
                        After sending the payment, enter the transaction ID below to complete your subscription.
                      </p>
                    </div>
                  </div>
                </div>

                <!-- Subscription Form -->
                <form @submit.prevent="submit" class="p-4 sm:p-6">
                  <div class="space-y-4">
                    <div>
                      <Label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="fas fa-credit-card text-blue-500 mr-2 text-xs"></i>
                        Payment Method
                      </Label>
                      <select 
                        v-model="form.payment_method"
                        class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 dark:bg-gray-700 dark:text-white text-sm"
                      >
                        <option value="bkash">🏦 Bkash Mobile Banking</option>
                      </select>
                    </div>

                    <div>
                      <Label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="fas fa-receipt text-green-500 mr-2 text-xs"></i>
                        Transaction ID
                      </Label>
                      <Input 
                        v-model="form.transaction_id"
                        type="text" 
                        required 
                        placeholder="Enter your Bkash transaction ID"
                        :error="form.errors.transaction_id"
                      />
                      <p v-if="form.errors.transaction_id" class="mt-1 text-xs text-red-600 dark:text-red-400">
                        {{ form.errors.transaction_id }}
                      </p>
                      <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded p-2">
                        <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                        You'll receive this ID after completing the Bkash payment
                      </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3">
                      <div class="flex items-start">
                        <input 
                          id="terms" 
                          v-model="form.terms"
                          type="checkbox" 
                          class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-0.5 flex-shrink-0"
                        >
                        <label for="terms" class="ml-2 block text-xs text-gray-700 dark:text-gray-300 leading-relaxed">
                          <span class="font-medium">I confirm that:</span>
                          <ul class="mt-1 space-y-0.5 text-gray-600 dark:text-gray-400">
                            <li>• I have completed the payment of <strong class="text-gray-900 dark:text-white">{{ plan.formatted_price }}</strong></li>
                            <li>• I agree to the Terms of Service and Privacy Policy</li>
                          </ul>
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <Link 
                      href="/pricing" 
                      class="flex-1 bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 text-gray-700 dark:text-white py-2.5 px-4 rounded-lg text-center font-medium transition-all text-sm"
                    >
                      <i class="fas fa-arrow-left mr-2"></i>Back
                    </Link>
                    <button 
                      type="submit" 
                      :disabled="form.processing"
                      class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white py-2.5 px-4 rounded-lg font-medium transition-all text-sm shadow-md disabled:opacity-50"
                    >
                      <i v-if="form.processing" class="fas fa-spinner fa-spin mr-2"></i>
                      <i v-else class="fas fa-check-circle mr-2"></i>
                      Complete Subscription
                    </button>
                  </div>
                </form>
              </Card>
            </div>
          </div>

          <!-- Verification Timeline -->
          <Card class="p-4 sm:p-6">
            <div class="text-center mb-6">
              <div class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg mb-3">
                <i class="fas fa-clock text-white"></i>
              </div>
              <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">What happens next?</h3>
              <p class="text-sm text-gray-600 dark:text-gray-400">Your subscription journey</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div class="flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 sm:mr-0 sm:mb-2">
                  1
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white text-sm">Submit Form</h4>
                  <p class="text-xs text-gray-600 dark:text-gray-400">Submit with transaction ID</p>
                </div>
              </div>
              
              <div class="flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 sm:mr-0 sm:mb-2">
                  2
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white text-sm">Verification</h4>
                  <p class="text-xs text-gray-600 dark:text-gray-400">Verified within 2-24 hours</p>
                </div>
              </div>
              
              <div class="flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center mr-3 sm:mr-0 sm:mb-2">
                  <i class="fas fa-check text-sm"></i>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white text-sm">Active!</h4>
                  <p class="text-xs text-gray-600 dark:text-gray-400">Start using the API</p>
                </div>
              </div>
            </div>
            
            <div class="mt-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-3 text-center">
              <i class="fas fa-headset text-blue-600 dark:text-blue-400 mr-2"></i>
              <span class="text-xs text-blue-800 dark:text-blue-300">
                Need help? Contact <a href="mailto:support@fraudshield.com" class="underline">support@fraudshield.com</a>
              </span>
            </div>
          </Card>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
