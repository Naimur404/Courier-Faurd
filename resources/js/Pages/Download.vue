<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import Button from '@/components/ui/Button.vue'
import Card from '@/components/ui/Card.vue'

interface Props {
  downloadCount: number
  lastDownloadTime: string | null
  downloadUrl: string
  qrCodeUrl: string
}

const props = defineProps<Props>()

const isDownloading = ref(false)
const currentDeviceIndex = ref(0)
let deviceRotationInterval: ReturnType<typeof setInterval> | null = null

const screenshots = [
  '/assets/Sc1.png',
  '/assets/Sc2.png',
  '/assets/Sc3.png'
]

const features = [
  {
    icon: 'shield-alt',
    title: 'Courier Fraud Detection',
    description: 'Identify and prevent courier fraud with our advanced detection system'
  },
  {
    icon: 'history',
    title: 'Delivery History Check',
    description: 'View complete delivery history and track courier reliability'
  },
  {
    icon: 'chart-line',
    title: 'Success Rate Analysis',
    description: 'Check courier success rates and make informed decisions'
  },
  {
    icon: 'star',
    title: 'Customer Feedback System',
    description: 'Read and share feedback on courier services'
  }
]

const benefits = [
  {
    icon: 'bolt',
    title: 'Fast & Reliable',
    description: 'Quick and accurate detection of potential courier fraud'
  },
  {
    icon: 'lock',
    title: 'Secure',
    description: 'Your data is protected with enterprise-grade security'
  },
  {
    icon: 'sync',
    title: 'Regular Updates',
    description: 'Constantly improving with frequent updates and new features'
  }
]

const getDeviceStyle = (index: number) => {
  const positions = [
    { left: '25%', scale: 0.8, zIndex: 1 },
    { left: '50%', scale: 1, zIndex: 10 },
    { left: '75%', scale: 0.8, zIndex: 1 }
  ]
  const position = (index - currentDeviceIndex.value + 3) % 3
  return {
    left: positions[position].left,
    transform: `translateX(-50%) scale(${positions[position].scale})`,
    zIndex: positions[position].zIndex
  }
}

const handleDownload = async () => {
  isDownloading.value = true
  
  try {
    const response = await fetch('/api/track-download-intent', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      }
    })
    
    const data = await response.json()
    
    if (data.success) {
      window.location.href = `${props.downloadUrl}?track_id=${data.track_id}`
    } else {
      window.location.href = props.downloadUrl
    }
  } catch (error) {
    console.error('Error:', error)
    window.location.href = props.downloadUrl
  } finally {
    setTimeout(() => {
      isDownloading.value = false
    }, 2000)
  }
}

onMounted(() => {
  deviceRotationInterval = setInterval(() => {
    currentDeviceIndex.value = (currentDeviceIndex.value + 1) % 3
  }, 3000)
})

onUnmounted(() => {
  if (deviceRotationInterval) {
    clearInterval(deviceRotationInterval)
  }
})
</script>

<template>
  <Head>
    <title>Download FraudShield App - কুরিয়ার ফ্রড ডিটেকশন অ্যাপ</title>
    <meta name="description" content="FraudShield Android অ্যাপ ডাউনলোড করুন - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল থেকে ডেলিভারি ইতিহাস দেখুন। Download courier fraud detection app for Android." />
    <meta name="keywords" content="FraudShield app, Android app, কুরিয়ার অ্যাপ, courier fraud app, download, ডাউনলোড, APK" />
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://fraudshieldbd.site/download" />
    
    <!-- OpenGraph Meta Tags -->
    <meta property="og:title" content="Download FraudShield App" />
    <meta property="og:description" content="FraudShield Android অ্যাপ ডাউনলোড করুন - কুরিয়ার ফ্রড ডিটেকশন।" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://fraudshieldbd.site/download" />
    <meta property="og:site_name" content="FraudShield" />
    <meta property="og:image" content="https://fraudshieldbd.site/assets/og-image.png" />
    
    <meta name="robots" content="index, follow" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  </Head>

  <div class="min-h-screen bg-[#121212] text-gray-100">
    <!-- Hero Section -->
    <section class="relative overflow-hidden">
      <!-- Background gradients -->
      <div class="absolute inset-0 bg-gradient-to-b from-purple-900/20 to-transparent pointer-events-none"></div>
      <div class="absolute top-20 left-10 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute top-40 right-10 w-72 h-72 bg-purple-800/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
      
      <!-- Home button -->
      <div class="bg-[#121212] py-3 px-4 flex justify-center">
        <Link href="/" class="flex items-center gap-2 px-5 py-1.5 text-sm font-medium text-white bg-white/10 rounded-full transition-all duration-300 hover:bg-white/20">
          <i class="fas fa-home"></i>
          <span>Home</span>
        </Link>
      </div>

      <!-- Hero content -->
      <div class="relative container mx-auto px-4 pt-24 pb-64 text-center">
        <div class="flex flex-col items-center">
          <!-- App logo -->
          <div class="relative mb-6 animate-bounce" style="animation-duration: 3s;">
            <div class="absolute inset-0 bg-purple-600/30 rounded-3xl blur-xl"></div>
            <img src="/assets/banner.jpg" alt="FraudShield Logo" class="relative w-24 h-24 object-cover rounded-2xl border-2 border-white/20 shadow-lg">
          </div>
          
          <h1 class="text-4xl md:text-5xl font-bold mb-3 text-white">FraudShield</h1>
          <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10">
            কুরিয়ার ফ্রড ডিটেকশন সিস্টেম - ডেলিভারি ইতিহাস দেখুন এবং বিশ্বসযোগ্যতা যাচাই করুন
          </p>
        </div>
      </div>
    </section>

    <!-- Device Showcase Section -->
    <section class="relative -mt-52 mb-24">
      <div class="container mx-auto px-4">
        <div class="relative h-[500px] md:h-[580px] overflow-visible">
          <div
            v-for="(screenshot, index) in screenshots"
            :key="index"
            class="device absolute w-[250px] md:w-[270px] rounded-[36px] overflow-hidden shadow-2xl bg-[#121212] border-[10px] border-[#383838] transition-all duration-500"
            :style="getDeviceStyle(index)"
          >
            <div class="device-screen w-full h-full rounded-[28px] overflow-hidden">
              <img :src="screenshot" :alt="`FraudShield Screenshot ${index + 1}`" class="w-full h-full object-cover">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Download Action Area -->
    <section class="mb-20">
      <div class="container mx-auto px-4">
        <Card class="p-10 text-center relative overflow-hidden max-w-3xl mx-auto bg-[#282828]/80 backdrop-blur-md border border-white/5">
          <!-- Background glow effect -->
          <div class="absolute -inset-x-10 -bottom-10 h-40 bg-purple-600/10 blur-3xl"></div>
          
          <h2 class="text-2xl font-bold mb-4 text-white relative z-10">Download Our Mobile App Now</h2>
          <p class="text-gray-300 mb-8 max-w-lg mx-auto relative z-10">
            Experience the best courier fraud detection system with our FraudShield mobile application
          </p>
          
          <div class="flex flex-col md:flex-row items-center justify-center gap-8 relative z-10">
            <div class="flex-1">
              <Button
                @click="handleDownload"
                :disabled="isDownloading"
                class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-white bg-purple-600 rounded-full overflow-hidden transition-all duration-300 hover:bg-purple-700 hover:shadow-[0_0_15px_rgba(130,87,230,0.5)] active:scale-95 disabled:opacity-70"
              >
                <svg v-if="isDownloading" class="w-5 h-5 mr-3 -ml-1 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <i class="fas fa-download mr-2"></i>
                Download APK
              </Button>
            </div>
            
            <div class="flex-1 flex flex-col items-center">
              <div class="p-2 bg-white rounded-xl mb-3 transform transition hover:rotate-3 hover:scale-105 duration-300">
                <img :src="qrCodeUrl" alt="QR Code for Download" class="w-32 h-32">
              </div>
              <p class="text-gray-400 text-sm">Or scan this QR code with your device</p>
            </div>
          </div>
        </Card>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="mb-20">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <Card class="p-8 bg-[#282828]/80 backdrop-blur-md border border-white/5 transition-all duration-300 hover:shadow-[0_0_15px_rgba(130,87,230,0.5)] hover:-translate-y-1">
            <div class="flex flex-col items-center justify-center h-full">
              <span class="text-4xl md:text-5xl font-bold text-purple-500 mb-2">{{ downloadCount.toLocaleString() }}</span>
              <span class="text-lg text-gray-300">Total Downloads</span>
            </div>
          </Card>
          
          <Card class="p-8 bg-[#282828]/80 backdrop-blur-md border border-white/5 transition-all duration-300 hover:shadow-[0_0_15px_rgba(130,87,230,0.5)] hover:-translate-y-1">
            <div class="flex flex-col items-center justify-center h-full">
              <span class="text-lg text-gray-300 mb-2">Last Download</span>
              <span class="text-2xl md:text-3xl font-bold text-purple-500">{{ lastDownloadTime ?? 'No downloads yet' }}</span>
            </div>
          </Card>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="mb-20">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-white">
          <span class="inline-block relative">
            Key Features
            <span class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-purple-600 to-purple-400"></span>
          </span>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <Card
            v-for="feature in features"
            :key="feature.title"
            class="p-6 flex items-center gap-4 bg-[#282828]/80 backdrop-blur-md border border-white/5 transition-all duration-300 hover:shadow-[0_0_15px_rgba(130,87,230,0.5)] hover:-translate-y-1"
          >
            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-purple-600/20 flex items-center justify-center">
              <i :class="`fas fa-${feature.icon} text-xl text-purple-500`"></i>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-white mb-1">{{ feature.title }}</h3>
              <p class="text-gray-400 text-sm">{{ feature.description }}</p>
            </div>
          </Card>
        </div>
      </div>
    </section>

    <!-- Benefits Section -->
    <section class="mb-20">
      <div class="container mx-auto px-4">
        <Card class="p-8 md:p-12 relative overflow-hidden bg-[#282828]/80 backdrop-blur-md border border-white/5">
          <!-- Background effect -->
          <div class="absolute top-0 right-0 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl"></div>
          
          <div class="relative z-10">
            <h2 class="text-2xl md:text-3xl font-bold mb-8 text-center text-white">Why Choose FraudShield?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              <div
                v-for="benefit in benefits"
                :key="benefit.title"
                class="flex flex-col items-center text-center"
              >
                <div class="w-16 h-16 rounded-full bg-purple-600/20 flex items-center justify-center mb-4">
                  <i :class="`fas fa-${benefit.icon} text-2xl text-purple-500`"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">{{ benefit.title }}</h3>
                <p class="text-gray-400">{{ benefit.description }}</p>
              </div>
            </div>
          </div>
        </Card>
      </div>
    </section>

    <!-- Version info -->
    <div class="text-center text-gray-500 text-sm mb-12">
      <p>FraudShield v1.0.0 | Last updated: {{ new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) }}</p>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-purple-800 to-purple-600 py-8 rounded-t-3xl">
      <div class="container mx-auto px-4 text-center">
        <p class="text-white/90">© 2025 FraudShield. All rights reserved.</p>
        <p class="text-white/70 text-sm mt-2">Powered by Tyrodevs.com</p>
      </div>
    </footer>
  </div>
</template>

<style scoped>
@keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

.device {
  top: 0;
}
</style>
