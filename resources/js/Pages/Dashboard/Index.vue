<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3'
import Card from '@/components/ui/Card.vue'
import Button from '@/components/ui/Button.vue'
import Badge from '@/components/ui/Badge.vue'
import Progress from '@/components/ui/Progress.vue'
import Alert from '@/components/ui/alert/Alert.vue'
import AlertTitle from '@/components/ui/alert/AlertTitle.vue'
import AlertDescription from '@/components/ui/alert/AlertDescription.vue'
import { ref, computed } from 'vue'
import type { PageProps } from '@/types/inertia'

interface ApiKey {
  id: number
  name: string
  key: string
  masked_key: string
  is_active: boolean
  created_at: string
  last_used_at: string | null
  usage_count: number
}

interface Plan {
  id: number
  name: string
  description: string
  request_limit: number
}

interface Subscription {
  id: number
  plan: Plan
  expires_at: string | null
  days_remaining: number
}

interface WebsiteSubscription {
  id: number
  plan_type: string
  formatted_amount: string
  verification_status: string
  expires_at: string | null
  days_remaining: number
  admin_notes: string | null
}

interface CourierBreakdownItem {
  name: string
  total_parcel: number
  success_parcel: number
  cancelled_parcel: number
  success_ratio: number
  logo: string | null
}

interface SearchHistoryItem {
  id: number
  phone: string
  customer_id: number | null
  courier_summary: {
    total_parcel: number
    success_ratio: number
    cancel_count: number
    partial_count: number
  } | null
  total_parcels: number
  success_ratio: number
  courier_breakdown: CourierBreakdownItem[]
  searched_at: string | null
  search_by: string
}

interface Props {
  apiKeys: ApiKey[]
  todayUsage: number
  monthlyUsage: number
  activeSubscription: Subscription | null
  activeWebsiteSubscription: WebsiteSubscription | null
  searchHistory: SearchHistoryItem[]
  csrfToken: string
  flash?: {
    success?: string
    error?: string
    new_api_key?: string
    new_api_secret?: string
  }
}

const props = defineProps<Props>()
const page = usePage<PageProps>()
const user = computed(() => page.props.auth?.user)

// Search functionality
const phoneInput = ref('')
const isSearching = ref(false)
const searchResults = ref<any>(null)
const searchError = ref<string | null>(null)

const displayToast = (message: string, type: 'success' | 'error' | 'warning' = 'success') => {
  const toast = document.createElement('div')
  const colors = {
    success: 'bg-green-500',
    error: 'bg-red-500',
    warning: 'bg-yellow-500'
  }
  toast.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`
  toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'exclamation'} mr-2"></i>${message}`
  document.body.appendChild(toast)
  
  setTimeout(() => toast.classList.remove('translate-x-full'), 100)
  setTimeout(() => {
    toast.classList.add('translate-x-full')
    setTimeout(() => document.body.removeChild(toast), 300)
  }, 3000)
}

const performSearch = async () => {
  if (!phoneInput.value) {
    displayToast('মোবাইল নাম্বার লিখুন', 'warning')
    return
  }
  
  const phoneRegex = /^01[0-9]{9}$/
  if (!phoneRegex.test(phoneInput.value)) {
    displayToast('সঠিক মোবাইল নাম্বার লিখুন (যেমন: 01600000000)', 'warning')
    return
  }
  
  isSearching.value = true
  searchError.value = null
  searchResults.value = null
  
  try {
    const response = await fetch('/courier-check', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': props.csrfToken,
      },
      body: JSON.stringify({ phone: phoneInput.value }),
    })
    
    if (response.status === 429) {
      const rateLimitData = await response.json()
      displayToast(rateLimitData.message || `দৈনিক সার্চ সীমা অতিক্রম করা হয়েছে।`, 'warning')
      searchError.value = 'Rate limit exceeded'
      return
    }
    
    const data = await response.json()
    
    if (!response.ok || data.success === false) {
      displayToast(data.message || 'সার্ভার থেকে ত্রুটির বার্তা পাওয়া গেছে', 'error')
      searchError.value = data.message || 'Server error'
      return
    }
    
    searchResults.value = data
    displayToast('সার্চ সফল হয়েছে', 'success')
    
  } catch (error) {
    console.error('Search error:', error)
    displayToast('ডাটা লোড করতে সমস্যা হয়েছে', 'error')
    searchError.value = 'Network error'
  } finally {
    isSearching.value = false
  }
}

const searchFromHistory = (phone: string) => {
  phoneInput.value = phone
  performSearch()
}

const getRiskLevel = (successRatio: number) => {
  if (successRatio >= 80) return { label: 'নিম্ন ঝুঁকি', color: 'bg-green-500', textColor: 'text-green-700' }
  if (successRatio >= 50) return { label: 'মাঝারি ঝুঁকি', color: 'bg-yellow-500', textColor: 'text-yellow-700' }
  return { label: 'উচ্চ ঝুঁকি', color: 'bg-red-500', textColor: 'text-red-700' }
}

const getCourierBreakdown = (results: any) => {
  if (!results?.courierData) return []
  
  const couriers = []
  for (const [key, value] of Object.entries(results.courierData)) {
    if (key !== 'summary' && typeof value === 'object' && value !== null) {
      const courierData = value as any
      if (courierData.total_parcel !== undefined) {
        couriers.push({
          name: key,
          total_parcel: courierData.total_parcel || 0,
          success_parcel: courierData.success_parcel || 0,
          cancelled_parcel: courierData.cancelled_parcel || 0,
          success_ratio: courierData.success_ratio || 0,
          logo: courierData.logo || null
        })
      }
    }
  }
  
  // Sort by total_parcel descending
  return couriers.sort((a, b) => b.total_parcel - a.total_parcel)
}

const copyToClipboard = (text: string) => {
  navigator.clipboard.writeText(text).then(() => {
    displayToast('Copied to clipboard!', 'success')
  })
}

const usagePercentage = computed(() => {
  if (!props.activeSubscription) return 0
  return Math.min(100, (props.todayUsage / props.activeSubscription.plan.request_limit) * 100)
})

const usageColor = computed(() => {
  if (usagePercentage.value > 90) return 'destructive'
  if (usagePercentage.value > 70) return 'warning'
  return 'success'
})

const stats = computed(() => [
  {
    icon: 'key',
    gradient: 'from-blue-500 to-indigo-600',
    label: 'API Keys',
    value: props.apiKeys.length,
    subtext: `${props.apiKeys.filter(k => k.is_active).length} active`
  },
  {
    icon: 'chart-line',
    gradient: 'from-green-500 to-emerald-600',
    label: "Today's Usage",
    value: props.todayUsage.toLocaleString(),
    subtext: 'requests made'
  },
  {
    icon: 'calendar',
    gradient: 'from-purple-500 to-pink-600',
    label: 'Monthly Usage',
    value: props.monthlyUsage.toLocaleString(),
    subtext: 'this month'
  },
  {
    icon: 'crown',
    gradient: 'from-orange-500 to-yellow-500',
    label: 'API Plan',
    value: props.activeSubscription?.plan.name || 'No Plan',
    subtext: props.activeSubscription ? `${props.activeSubscription.days_remaining} days left` : 'Inactive'
  },
  {
    icon: 'infinity',
    gradient: 'from-indigo-500 to-purple-600',
    label: 'Website Plan',
    value: props.activeWebsiteSubscription ? `${props.activeWebsiteSubscription.plan_type.charAt(0).toUpperCase()}${props.activeWebsiteSubscription.plan_type.slice(1)}` : 'No Plan',
    subtext: props.activeWebsiteSubscription?.verification_status === 'verified' 
      ? `${props.activeWebsiteSubscription.days_remaining} days left`
      : props.activeWebsiteSubscription?.verification_status === 'pending'
        ? 'Pending approval'
        : 'Limited'
  }
])
</script>

<template>
  <Head>
    <title>Dashboard - FraudShield API</title>
    <meta name="description" content="Manage your FraudShield API keys and subscriptions" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  </Head>

  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="container mx-auto px-4">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
          <div>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-1">Welcome back, {{ user?.name }}!</p>
          </div>
          <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3">
            <Link href="/api/documentation" target="_blank">
              <Button class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors w-full sm:w-auto">
                <i class="fas fa-book mr-2"></i>API Documentation
              </Button>
            </Link>
            <Link href="/pricing">
              <Button variant="outline" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors w-full sm:w-auto">
                <i class="fas fa-crown mr-2"></i>Upgrade Plan
              </Button>
            </Link>
          </div>
        </div>
      </div>

      <!-- Alert Messages -->
      <Alert v-if="flash?.success" class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700">
        <i class="fas fa-check-circle mr-3 text-green-500"></i>
        <AlertDescription>{{ flash.success }}</AlertDescription>
      </Alert>

      <Alert v-if="flash?.error" class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700">
        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
        <AlertDescription>{{ flash.error }}</AlertDescription>
      </Alert>

      <!-- New API Key Alert -->
      <Alert v-if="flash?.new_api_key" class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 p-6">
        <div class="flex items-start">
          <i class="fas fa-key text-blue-500 mr-3 mt-1"></i>
          <div class="flex-1">
            <AlertTitle class="font-bold text-lg mb-2">Your new API credentials</AlertTitle>
            <AlertDescription class="text-sm mb-4 text-blue-700">Save these credentials securely. They won't be shown again!</AlertDescription>
            
            <div class="space-y-3">
              <div>
                <label class="block text-sm font-medium text-blue-800 mb-1">API Key:</label>
                <div class="flex items-center space-x-2">
                  <code class="bg-blue-100 px-3 py-2 rounded flex-1 font-mono text-sm">{{ flash.new_api_key }}</code>
                  <Button @click="copyToClipboard(flash.new_api_key!)" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm transition-colors">
                    <i class="fas fa-copy"></i>
                  </Button>
                </div>
              </div>
              
              <div v-if="flash.new_api_secret">
                <label class="block text-sm font-medium text-blue-800 mb-1">API Secret:</label>
                <div class="flex items-center space-x-2">
                  <code class="bg-blue-100 px-3 py-2 rounded flex-1 font-mono text-sm">{{ flash.new_api_secret }}</code>
                  <Button @click="copyToClipboard(flash.new_api_secret!)" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm transition-colors">
                    <i class="fas fa-copy"></i>
                  </Button>
                </div>
              </div>
            </div>
            
            <div class="mt-4 p-3 bg-blue-100 rounded">
              <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Important:</strong> Store these credentials securely. Use the API key for authentication and refer to our documentation for implementation details.
              </p>
            </div>
          </div>
        </div>
      </Alert>

      <!-- Quick Stats -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6 mb-8">
        <Card 
          v-for="stat in stats" 
          :key="stat.label"
          class="p-6 border border-gray-100 dark:border-gray-700"
        >
          <div class="flex items-center">
            <div :class="['p-3 rounded-full bg-gradient-to-r', stat.gradient]">
              <i :class="['fas text-white text-xl', `fa-${stat.icon}`]"></i>
            </div>
            <div class="ml-4 min-w-0 flex-1">
              <p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate">{{ stat.label }}</p>
              <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ stat.value }}</p>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ stat.subtext }}</p>
            </div>
          </div>
        </Card>
      </div>

      <!-- Search Section -->
      <Card class="border border-gray-100 dark:border-gray-700 mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white">ফোন নম্বর সার্চ</h2>
              <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">কুরিয়ার ফ্রড চেক করুন</p>
            </div>
            <div class="p-3 rounded-full bg-gradient-to-r from-primary to-primary/80">
              <i class="fas fa-search text-white text-xl"></i>
            </div>
          </div>
        </div>
        
        <div class="p-6">
          <!-- Search Input -->
          <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex-1 relative">
              <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                <i class="fas fa-phone"></i>
              </span>
              <input
                v-model="phoneInput"
                type="tel"
                placeholder="মোবাইল নম্বর লিখুন (যেমন: 01600000000)"
                class="w-full pl-12 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white transition-all"
                maxlength="11"
                @keyup.enter="performSearch"
              />
            </div>
            <Button 
              @click="performSearch"
              :disabled="isSearching"
              class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-lg font-medium transition-all flex items-center justify-center gap-2"
            >
              <i :class="['fas', isSearching ? 'fa-spinner fa-spin' : 'fa-search']"></i>
              {{ isSearching ? 'সার্চ করা হচ্ছে...' : 'সার্চ করুন' }}
            </Button>
          </div>

          <!-- Search Results -->
          <div v-if="searchResults" class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-750 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                <i class="fas fa-chart-pie text-primary mr-2"></i>
                সার্চ রেজাল্ট: {{ phoneInput }}
              </h3>
              <Badge 
                :variant="getRiskLevel(searchResults.courierData?.summary?.success_ratio || 0).textColor.includes('green') ? 'success' : getRiskLevel(searchResults.courierData?.summary?.success_ratio || 0).textColor.includes('yellow') ? 'warning' : 'destructive'"
              >
                {{ getRiskLevel(searchResults.courierData?.summary?.success_ratio || 0).label }}
              </Badge>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
              <div class="bg-white dark:bg-gray-700 rounded-lg p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-primary">{{ searchResults.courierData?.summary?.total_parcel || 0 }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">মোট পার্সেল</p>
              </div>
              <div class="bg-white dark:bg-gray-700 rounded-lg p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-green-600">{{ searchResults.courierData?.summary?.success_ratio || 0 }}%</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">সাফল্যের হার</p>
              </div>
              <div class="bg-white dark:bg-gray-700 rounded-lg p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-red-600">{{ searchResults.courierData?.summary?.cancel_count || 0 }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">ক্যান্সেল</p>
              </div>
              <div class="bg-white dark:bg-gray-700 rounded-lg p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-yellow-600">{{ searchResults.courierData?.summary?.partial_count || 0 }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">পার্শিয়াল</p>
              </div>
            </div>

            <!-- Risk Indicator Bar -->
            <div class="bg-white dark:bg-gray-700 rounded-lg p-4 shadow-sm">
              <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">ঝুঁকির মাত্রা</span>
                <span class="text-sm text-gray-500">{{ searchResults.courierData?.summary?.success_ratio || 0 }}% সফল</span>
              </div>
              <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-3">
                <div 
                  :class="[getRiskLevel(searchResults.courierData?.summary?.success_ratio || 0).color, 'h-3 rounded-full transition-all duration-500']"
                  :style="{ width: `${searchResults.courierData?.summary?.success_ratio || 0}%` }"
                ></div>
              </div>
            </div>

            <!-- Courier Breakdown -->
            <div v-if="getCourierBreakdown(searchResults).length > 0" class="mt-4">
              <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">
                <i class="fas fa-truck text-primary mr-2"></i>কুরিয়ার অনুযায়ী পার্সেল
              </h4>
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <div 
                  v-for="courier in getCourierBreakdown(searchResults)" 
                  :key="courier.name"
                  class="bg-white dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-100 dark:border-gray-600"
                >
                  <div class="flex items-center gap-3 mb-2">
                    <img 
                      v-if="courier.logo" 
                      :src="courier.logo" 
                      :alt="courier.name"
                      class="w-8 h-8 object-contain rounded"
                    />
                    <div v-else class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                      <i class="fas fa-truck text-gray-400 text-sm"></i>
                    </div>
                    <span class="font-medium text-gray-900 dark:text-white capitalize">{{ courier.name }}</span>
                  </div>
                  <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-800 rounded px-2 py-1">
                      <span class="text-gray-500">মোট:</span>
                      <span class="font-semibold text-gray-900 dark:text-white">{{ courier.total_parcel }}</span>
                    </div>
                    <div class="flex items-center justify-between bg-green-50 dark:bg-green-900/20 rounded px-2 py-1">
                      <span class="text-green-600">সফল:</span>
                      <span class="font-semibold text-green-700">{{ courier.success_parcel }}</span>
                    </div>
                    <div class="flex items-center justify-between bg-red-50 dark:bg-red-900/20 rounded px-2 py-1">
                      <span class="text-red-600">ক্যান্সেল:</span>
                      <span class="font-semibold text-red-700">{{ courier.cancelled_parcel }}</span>
                    </div>
                    <div class="flex items-center justify-between bg-blue-50 dark:bg-blue-900/20 rounded px-2 py-1">
                      <span class="text-blue-600">সফলতা:</span>
                      <span class="font-semibold text-blue-700">{{ courier.success_ratio }}%</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div v-else-if="!isSearching && !searchError" class="text-center py-8 text-gray-500 dark:text-gray-400">
            <i class="fas fa-search text-4xl mb-3 opacity-30"></i>
            <p>ফোন নম্বর লিখে সার্চ করুন</p>
          </div>
        </div>
      </Card>

      <!-- Search History Section -->
      <Card v-if="props.searchHistory && props.searchHistory.length > 0" class="border border-gray-100 dark:border-gray-700 mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white">সার্চ ইতিহাস</h2>
              <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">আপনার সাম্প্রতিক সার্চসমূহ</p>
            </div>
            <Badge variant="outline">{{ props.searchHistory.length }} টি সার্চ</Badge>
          </div>
        </div>
        
        <div class="p-6">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <div 
              v-for="item in props.searchHistory" 
              :key="item.id"
              class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all cursor-pointer group"
              @click="searchFromHistory(item.phone)"
            >
              <div class="flex items-start justify-between mb-2">
                <div class="flex items-center gap-2">
                  <div class="p-2 rounded-full bg-primary/10 text-primary">
                    <i class="fas fa-phone text-sm"></i>
                  </div>
                  <span class="font-mono font-medium text-gray-900 dark:text-white">{{ item.phone }}</span>
                </div>
                <Badge 
                  v-if="item.success_ratio !== null"
                  :variant="item.success_ratio >= 80 ? 'success' : item.success_ratio >= 50 ? 'warning' : 'destructive'"
                  class="text-xs"
                >
                  {{ item.success_ratio }}%
                </Badge>
              </div>
              
              <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-3">
                  <span v-if="item.total_parcels" class="flex items-center gap-1">
                    <i class="fas fa-box"></i> {{ item.total_parcels }} পার্সেল
                  </span>
                </div>
                <span v-if="item.searched_at" class="flex items-center gap-1">
                  <i class="fas fa-clock"></i>
                  {{ new Date(item.searched_at).toLocaleDateString('bn-BD') }}
                </span>
              </div>

              <div class="mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <Button size="sm" variant="outline" class="w-full text-xs">
                  <i class="fas fa-search mr-1"></i> আবার সার্চ করুন
                </Button>
              </div>
            </div>
          </div>
        </div>
      </Card>

      <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 lg:gap-8">
        <!-- API Keys Section -->
        <Card class="border border-gray-100 dark:border-gray-700">
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">API Keys</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Your API authentication keys</p>
              </div>
            </div>
          </div>
          
          <div class="p-6">
            <div v-if="apiKeys.length > 0" class="space-y-4">
              <div 
                v-for="apiKey in apiKeys" 
                :key="apiKey.id"
                class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors"
              >
                <div class="flex flex-col space-y-3 sm:flex-row sm:justify-between sm:items-start sm:space-y-0">
                  <div class="flex-1 min-w-0">
                    <div class="flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-3 mb-2">
                      <h3 class="font-medium text-gray-900 dark:text-white truncate">{{ apiKey.name }}</h3>
                      <Badge :variant="apiKey.is_active ? 'success' : 'destructive'" class="w-fit">
                        {{ apiKey.is_active ? 'Active' : 'Inactive' }}
                      </Badge>
                    </div>
                    
                    <div class="flex items-center space-x-2 mb-2">
                      <code class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded text-sm font-mono flex-1 min-w-0 truncate">{{ apiKey.masked_key }}</code>
                      <Button @click="copyToClipboard(apiKey.key)" class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs transition-colors flex-shrink-0">
                        <i class="fas fa-copy"></i>
                      </Button>
                    </div>
                    
                    <div class="flex flex-col space-y-1 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4 text-xs text-gray-500 dark:text-gray-400">
                      <span class="flex items-center"><i class="fas fa-calendar mr-1"></i>Created: {{ new Date(apiKey.created_at).toLocaleDateString() }}</span>
                      <span v-if="apiKey.last_used_at" class="flex items-center"><i class="fas fa-clock mr-1"></i>Last used: {{ new Date(apiKey.last_used_at).toLocaleDateString() }}</span>
                      <span v-else class="flex items-center"><i class="fas fa-clock mr-1"></i>Never used</span>
                      <span class="flex items-center"><i class="fas fa-chart-bar mr-1"></i>{{ apiKey.usage_count.toLocaleString() }} uses</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div v-else class="text-center py-8">
              <div class="mb-4">
                <i class="fas fa-key text-gray-400 dark:text-gray-500 text-4xl"></i>
              </div>
              <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No API keys available</h3>
              <p class="text-gray-500 dark:text-gray-400 mb-4">Contact administrator to get your API keys.</p>
            </div>
            
            <!-- Quick Links -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
              <div class="flex flex-wrap gap-3">
                <span class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400">
                  <i class="fas fa-info-circle mr-2"></i>Use these API keys to authenticate your requests
                </span>
              </div>
            </div>
          </div>
        </Card>

        <!-- Subscriptions Section -->
        <Card class="border border-gray-100 dark:border-gray-700">
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Subscription Status</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Your API and website subscription plans</p>
              </div>
              <Badge v-if="activeSubscription || activeWebsiteSubscription" variant="success">
                {{ (activeSubscription && activeWebsiteSubscription) ? 'Both Active' : 'Active' }}
              </Badge>
            </div>
          </div>
          
          <div class="p-6 space-y-6">
            <!-- API Subscription -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                <i class="fas fa-crown text-orange-500 mr-2"></i>
                API Subscription
              </h3>
              <div v-if="activeSubscription" class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                  <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ activeSubscription.plan.name }}</h4>
                  <Badge variant="warning">Active</Badge>
                </div>
                <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">{{ activeSubscription.plan.description }}</p>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 text-sm mb-4">
                  <div class="flex items-center">
                    <i class="fas fa-tachometer-alt text-orange-500 mr-2 flex-shrink-0"></i>
                    <span class="text-gray-600 dark:text-gray-400 mr-1">Daily Limit:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ activeSubscription.plan.request_limit.toLocaleString() }} requests</span>
                  </div>
                  <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-orange-500 mr-2 flex-shrink-0"></i>
                    <span class="text-gray-600 dark:text-gray-400 mr-1">Expires:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ activeSubscription.expires_at ? new Date(activeSubscription.expires_at).toLocaleDateString() : 'Never' }}</span>
                  </div>
                  <div class="flex items-center">
                    <i class="fas fa-clock text-orange-500 mr-2 flex-shrink-0"></i>
                    <span class="text-gray-600 dark:text-gray-400 mr-1">Days Remaining:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ activeSubscription.days_remaining }}</span>
                  </div>
                  <div class="flex items-center">
                    <i class="fas fa-chart-pie text-orange-500 mr-2 flex-shrink-0"></i>
                    <span class="text-gray-600 dark:text-gray-400 mr-1">Usage Today:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ todayUsage.toLocaleString() }} / {{ activeSubscription.plan.request_limit.toLocaleString() }}</span>
                  </div>
                </div>
                
                <Alert v-if="activeSubscription.days_remaining < 7 && activeSubscription.days_remaining > 0" class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200 px-3 py-2 rounded-lg mb-3">
                  <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i>
                  <AlertDescription class="text-sm">API subscription expires in {{ activeSubscription.days_remaining }} days</AlertDescription>
                </Alert>

                <!-- Usage Progress Bar -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 mb-3">
                  <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Today's API Usage</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ todayUsage.toLocaleString() }} / {{ activeSubscription.plan.request_limit.toLocaleString() }}</span>
                  </div>
                  <Progress :value="usagePercentage" :max="100" :variant="usageColor as any" />
                </div>
              </div>
              <div v-else class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <div class="text-center">
                  <i class="fas fa-exclamation-circle text-orange-400 dark:text-orange-500 text-2xl mb-2"></i>
                  <h4 class="font-medium text-gray-900 dark:text-white mb-1">No API Subscription</h4>
                  <p class="text-gray-600 dark:text-gray-400 text-sm">Subscribe to access API services</p>
                  <Link href="/pricing" class="mt-3 inline-block">
                    <Button class="bg-orange-500 hover:bg-orange-600 text-white">
                      <i class="fas fa-crown mr-2"></i>View Plans
                    </Button>
                  </Link>
                </div>
              </div>
            </div>

            <!-- Website Subscription -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                <i class="fas fa-infinity text-indigo-500 mr-2"></i>
                Website Unlimited Search
              </h3>
              <div v-if="activeWebsiteSubscription" class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                  <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ activeWebsiteSubscription.plan_type.charAt(0).toUpperCase() + activeWebsiteSubscription.plan_type.slice(1) }} Plan
                    <span class="text-sm font-normal text-gray-600 dark:text-gray-400">({{ activeWebsiteSubscription.formatted_amount }})</span>
                  </h4>
                  <Badge :variant="activeWebsiteSubscription.verification_status === 'verified' ? 'success' : activeWebsiteSubscription.verification_status === 'pending' ? 'warning' : 'destructive'">
                    {{ activeWebsiteSubscription.verification_status === 'verified' ? 'Verified' : activeWebsiteSubscription.verification_status === 'pending' ? 'Pending' : 'Rejected' }}
                  </Badge>
                </div>
                
                <Alert v-if="activeWebsiteSubscription.verification_status === 'pending'" class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200 px-3 py-2 rounded-lg mb-3">
                  <i class="fas fa-clock mr-2 text-yellow-500"></i>
                  <div>
                    <AlertTitle class="text-sm font-medium">অ্যাডমিনের অনুমোদনের অপেক্ষায়</AlertTitle>
                    <AlertDescription class="text-xs">আপনার সাবস্ক্রিপশন যাচাইকরণের পর আনলিমিটেড সার্চ সুবিধা পাবেন।</AlertDescription>
                  </div>
                </Alert>
                
                <Alert v-if="activeWebsiteSubscription.verification_status === 'rejected'" class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-3 py-2 rounded-lg mb-3">
                  <i class="fas fa-times-circle mr-2 text-red-500"></i>
                  <div>
                    <AlertTitle class="text-sm font-medium">সাবস্ক্রিপশন প্রত্যাখ্যাত</AlertTitle>
                    <AlertDescription v-if="activeWebsiteSubscription.admin_notes" class="text-xs">কারণ: {{ activeWebsiteSubscription.admin_notes }}</AlertDescription>
                  </div>
                </Alert>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 text-sm">
                  <div class="flex items-center">
                    <i class="fas fa-infinity text-indigo-500 mr-2 flex-shrink-0"></i>
                    <span class="text-gray-600 dark:text-gray-400 mr-1">Website Searches:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">
                      {{ activeWebsiteSubscription.verification_status === 'verified' ? 'Unlimited' : 'Pending Approval' }}
                    </span>
                  </div>
                  <div v-if="activeWebsiteSubscription.verification_status === 'verified'" class="flex items-center">
                    <i class="fas fa-calendar-alt text-indigo-500 mr-2 flex-shrink-0"></i>
                    <span class="text-gray-600 dark:text-gray-400 mr-1">Expires:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ activeWebsiteSubscription.expires_at ? new Date(activeWebsiteSubscription.expires_at).toLocaleDateString() : 'Never' }}</span>
                  </div>
                </div>
              </div>
              <div v-else class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <div class="text-center">
                  <i class="fas fa-infinity text-indigo-400 dark:text-indigo-500 text-2xl mb-2"></i>
                  <h4 class="font-medium text-gray-900 dark:text-white mb-1">Limited Website Access</h4>
                  <p class="text-gray-600 dark:text-gray-400 text-sm">Subscribe for unlimited website searches</p>
                </div>
              </div>
            </div>
          </div>
        </Card>
      </div>

      <!-- Back to Home -->
      <div class="text-center mt-12">
        <Link href="/">
          <Button variant="outline" class="px-6 py-3">
            <i class="fas fa-arrow-left mr-2"></i>Back to Home
          </Button>
        </Link>
      </div>
    </div>
  </div>
</template>
