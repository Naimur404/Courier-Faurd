<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Shield, Mail, Lock, Eye, EyeOff, ArrowRight, Loader2, User, Phone } from 'lucide-vue-next';

interface Props {
  errors?: Record<string, string>
}

defineProps<Props>();

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const form = useForm({
  name: '',
  phone: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false
});

const submit = () => {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation')
  });
};
</script>

<template>
  <Head>
    <title>রেজিস্টার - FraudShield</title>
    <meta name="description" content="FraudShield BD এ ফ্রি অ্যাকাউন্ট তৈরি করুন। কুরিয়ার ফ্রড ডিটেকশন সিস্টেমে যোগ দিন।" />
    <link rel="canonical" href="https://fraudshieldbd.site/register" />
    <meta name="robots" content="noindex, follow" />
  </Head>

  <div class="min-h-screen flex bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900">
    <!-- Left Side - Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
      <!-- Background Pattern -->
      <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0wIDBoNjB2NjBIMHoiLz48cGF0aCBkPSJNMzAgMzBtLTEgMGExIDEgMCAxIDAgMiAwYTEgMSAwIDEgMCAtMiAwIiBmaWxsPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIi8+PC9nPjwvc3ZnPg==')] opacity-40"></div>
      
      <!-- Animated Blobs -->
      <div class="absolute -top-40 -left-40 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
      
      <!-- Content -->
      <div class="relative z-10 flex flex-col justify-center items-center w-full p-12">
        <Link href="/" class="flex items-center gap-3 mb-8">
          <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg shadow-indigo-500/25">
            <Shield class="w-10 h-10 text-white" />
          </div>
          <span class="text-3xl font-bold text-white">FraudShield</span>
        </Link>
        
        <h1 class="text-4xl font-bold text-white text-center mb-4">
          আজই শুরু করুন<br/>ফ্রি!
        </h1>
        <p class="text-lg text-white/60 text-center max-w-md">
          বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। প্রতিদিন ৫টি ফ্রি সার্চ পান।
        </p>
        
        <!-- Features -->
        <div class="mt-12 space-y-4">
          <div class="flex items-center gap-3 text-white/80">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
              <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <span>প্রতিদিন ৫টি ফ্রি সার্চ</span>
          </div>
          <div class="flex items-center gap-3 text-white/80">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
              <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <span>সার্চ হিস্ট্রি সংরক্ষণ</span>
          </div>
          <div class="flex items-center gap-3 text-white/80">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
              <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <span>API অ্যাক্সেস</span>
          </div>
          <div class="flex items-center gap-3 text-white/80">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
              <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <span>২৪/৭ WhatsApp সাপোর্ট</span>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Right Side - Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8 bg-white dark:bg-slate-900 overflow-y-auto">
      <div class="w-full max-w-md py-4">
        <!-- Mobile Logo -->
        <div class="lg:hidden text-center mb-6">
          <Link href="/" class="inline-flex items-center gap-2">
            <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
              <Shield class="w-6 h-6 text-white" />
            </div>
            <span class="text-xl font-bold text-gray-900 dark:text-white">FraudShield</span>
          </Link>
        </div>
        
        <!-- Header -->
        <div class="text-center mb-6">
          <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
            অ্যাকাউন্ট তৈরি করুন 🚀
          </h2>
          <p class="text-gray-600 dark:text-gray-400">
            ফ্রি রেজিস্টার করে শুরু করুন
          </p>
        </div>
        
        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-4">
          <!-- Name Field -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
              পূর্ণ নাম
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <User class="h-5 w-5 text-gray-400" />
              </div>
              <input 
                id="name" 
                v-model="form.name"
                type="text" 
                autocomplete="name" 
                required 
                placeholder="আপনার নাম"
                class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                :class="{ 'border-red-500 focus:ring-red-500': form.errors.name }"
              />
            </div>
            <p v-if="form.errors.name" class="mt-1.5 text-sm text-red-500">
              {{ form.errors.name }}
            </p>
          </div>

          <!-- Phone Field -->
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
              মোবাইল নম্বর
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <Phone class="h-5 w-5 text-gray-400" />
              </div>
              <input 
                id="phone" 
                v-model="form.phone"
                type="tel" 
                autocomplete="tel" 
                required 
                placeholder="01XXXXXXXXX"
                class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                :class="{ 'border-red-500 focus:ring-red-500': form.errors.phone }"
              />
            </div>
            <p v-if="form.errors.phone" class="mt-1.5 text-sm text-red-500">
              {{ form.errors.phone }}
            </p>
          </div>
          
          <!-- Email Field -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
              ইমেইল ঠিকানা
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <Mail class="h-5 w-5 text-gray-400" />
              </div>
              <input 
                id="email" 
                v-model="form.email"
                type="email" 
                autocomplete="email" 
                required 
                placeholder="example@email.com"
                class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                :class="{ 'border-red-500 focus:ring-red-500': form.errors.email }"
              />
            </div>
            <p v-if="form.errors.email" class="mt-1.5 text-sm text-red-500">
              {{ form.errors.email }}
            </p>
          </div>
          
          <!-- Password Field -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
              পাসওয়ার্ড
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <Lock class="h-5 w-5 text-gray-400" />
              </div>
              <input 
                id="password" 
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'" 
                autocomplete="new-password" 
                required 
                placeholder="কমপক্ষে ৮ অক্ষর"
                class="w-full pl-12 pr-12 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                :class="{ 'border-red-500 focus:ring-red-500': form.errors.password }"
              />
              <button 
                type="button" 
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
              >
                <Eye v-if="!showPassword" class="h-5 w-5" />
                <EyeOff v-else class="h-5 w-5" />
              </button>
            </div>
            <p v-if="form.errors.password" class="mt-1.5 text-sm text-red-500">
              {{ form.errors.password }}
            </p>
          </div>
          
          <!-- Confirm Password Field -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
              পাসওয়ার্ড নিশ্চিত করুন
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <Lock class="h-5 w-5 text-gray-400" />
              </div>
              <input 
                id="password_confirmation" 
                v-model="form.password_confirmation"
                :type="showConfirmPassword ? 'text' : 'password'" 
                autocomplete="new-password" 
                required 
                placeholder="পাসওয়ার্ড আবার দিন"
                class="w-full pl-12 pr-12 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
              />
              <button 
                type="button" 
                @click="showConfirmPassword = !showConfirmPassword"
                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
              >
                <Eye v-if="!showConfirmPassword" class="h-5 w-5" />
                <EyeOff v-else class="h-5 w-5" />
              </button>
            </div>
          </div>

          <!-- Terms and Conditions -->
          <div class="flex items-start gap-2">
            <input 
              id="terms" 
              v-model="form.terms"
              type="checkbox" 
              required
              class="w-4 h-4 mt-0.5 rounded border-gray-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 bg-gray-50 dark:bg-slate-800"
            />
            <label for="terms" class="text-sm text-gray-600 dark:text-gray-400">
              আমি 
              <a href="#" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">সেবার শর্তাবলী</a> 
              এবং 
              <a href="#" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">গোপনীয়তা নীতি</a>তে 
              সম্মত আছি
            </label>
          </div>

          <!-- Submit Button -->
          <button 
            type="submit" 
            :disabled="form.processing"
            class="w-full flex items-center justify-center gap-2 py-3.5 px-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed"
          >
            <Loader2 v-if="form.processing" class="w-5 h-5 animate-spin" />
            <template v-else>
              অ্যাকাউন্ট তৈরি করুন
              <ArrowRight class="w-5 h-5" />
            </template>
          </button>
        </form>

        <!-- Divider -->
        <div class="my-6 flex items-center">
          <div class="flex-1 border-t border-gray-200 dark:border-slate-700"></div>
          <span class="px-4 text-sm text-gray-500 dark:text-gray-400">অথবা</span>
          <div class="flex-1 border-t border-gray-200 dark:border-slate-700"></div>
        </div>

        <!-- Login Link -->
        <p class="text-center text-gray-600 dark:text-gray-400">
          ইতিমধ্যে অ্যাকাউন্ট আছে? 
          <Link href="/login" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
            লগইন করুন
          </Link>
        </p>
        
        <!-- Back to Home -->
        <div class="mt-6 text-center">
          <Link href="/" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            হোমে ফিরে যান
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>
