<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Shield, Mail, Lock, Eye, EyeOff, ArrowRight, Loader2 } from 'lucide-vue-next';

interface Props {
  errors?: Record<string, string>
}

defineProps<Props>();

const showPassword = ref(false);

const form = useForm({
  email: '',
  password: '',
  remember: false
});

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password')
  });
};
</script>

<template>
  <Head>
    <title>লগইন - FraudShield</title>
    <meta name="description" content="FraudShield BD এ লগইন করুন। কুরিয়ার ফ্রড ডিটেকশন সিস্টেমে অ্যাক্সেস পান।" />
    <link rel="canonical" href="https://fraudshieldbd.site/login" />
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
      
      <!-- Content -->
      <div class="relative z-10 flex flex-col justify-center items-center w-full p-12">
        <Link href="/" class="flex items-center gap-3 mb-8">
          <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg shadow-indigo-500/25">
            <Shield class="w-10 h-10 text-white" />
          </div>
          <span class="text-3xl font-bold text-white">FraudShield</span>
        </Link>
        
        <h1 class="text-4xl font-bold text-white text-center mb-4">
          রিটার্ন কমান,<br/>খরচ বাঁচান
        </h1>
        <p class="text-lg text-white/60 text-center max-w-md">
          বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস যাচাই করুন।
        </p>
        
        <!-- Features -->
        <div class="mt-12 space-y-4">
          <div class="flex items-center gap-3 text-white/80">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
              <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <span>বাল্ক সার্চ (≤৫০০ নাম্বার)</span>
          </div>
          <div class="flex items-center gap-3 text-white/80">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
              <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <span>REST API ইন্টিগ্রেশন</span>
          </div>
          <div class="flex items-center gap-3 text-white/80">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
              <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <span>রিয়েল-টাইম রিস্ক স্কোর</span>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Right Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-white dark:bg-slate-900">
      <div class="w-full max-w-md">
        <!-- Mobile Logo -->
        <div class="lg:hidden text-center mb-8">
          <Link href="/" class="inline-flex items-center gap-2">
            <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
              <Shield class="w-6 h-6 text-white" />
            </div>
            <span class="text-xl font-bold text-gray-900 dark:text-white">FraudShield</span>
          </Link>
        </div>
        
        <!-- Header -->
        <div class="text-center mb-8">
          <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
            স্বাগতম! 👋
          </h2>
          <p class="text-gray-600 dark:text-gray-400">
            আপনার অ্যাকাউন্টে লগইন করুন
          </p>
        </div>
        
        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-5">
          <!-- Email Field -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
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
                class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                :class="{ 'border-red-500 focus:ring-red-500': form.errors.email }"
              />
            </div>
            <p v-if="form.errors.email" class="mt-2 text-sm text-red-500">
              {{ form.errors.email }}
            </p>
          </div>
          
          <!-- Password Field -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
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
                autocomplete="current-password" 
                required 
                placeholder="••••••••"
                class="w-full pl-12 pr-12 py-3.5 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
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
            <p v-if="form.errors.password" class="mt-2 text-sm text-red-500">
              {{ form.errors.password }}
            </p>
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
              <input 
                id="remember" 
                v-model="form.remember"
                type="checkbox" 
                class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 bg-gray-50 dark:bg-slate-800"
              />
              <span class="text-sm text-gray-600 dark:text-gray-400">মনে রাখুন</span>
            </label>
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
              পাসওয়ার্ড ভুলে গেছেন?
            </a>
          </div>

          <!-- Submit Button -->
          <button 
            type="submit" 
            :disabled="form.processing"
            class="w-full flex items-center justify-center gap-2 py-3.5 px-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed"
          >
            <Loader2 v-if="form.processing" class="w-5 h-5 animate-spin" />
            <template v-else>
              লগইন করুন
              <ArrowRight class="w-5 h-5" />
            </template>
          </button>
        </form>

        <!-- Divider -->
        <div class="my-8 flex items-center">
          <div class="flex-1 border-t border-gray-200 dark:border-slate-700"></div>
          <span class="px-4 text-sm text-gray-500 dark:text-gray-400">অথবা</span>
          <div class="flex-1 border-t border-gray-200 dark:border-slate-700"></div>
        </div>

        <!-- Register Link -->
        <p class="text-center text-gray-600 dark:text-gray-400">
          অ্যাকাউন্ট নেই? 
          <Link href="/register" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
            ফ্রি রেজিস্টার করুন
          </Link>
        </p>
        
        <!-- Back to Home -->
        <div class="mt-8 text-center">
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
