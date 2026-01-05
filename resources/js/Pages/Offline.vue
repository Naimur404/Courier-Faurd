<script setup lang="ts">
import { WifiOff, RefreshCw } from 'lucide-vue-next';
import AppLayout from '@/Layouts/AppLayout.vue';

const refreshPage = () => {
    window.location.reload();
};
</script>

<template>
    <AppLayout>
        <div class="min-h-[60vh] flex items-center justify-center px-4">
            <div class="text-center">
                <!-- Offline Icon -->
                <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6">
                    <WifiOff class="w-12 h-12 text-gray-400 dark:text-gray-500" />
                </div>
                
                <!-- Title -->
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3">
                    আপনি অফলাইনে আছেন
                </h1>
                
                <!-- Description -->
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    দুঃখিত, বর্তমানে ইন্টারনেট সংযোগ পাওয়া যাচ্ছে না। অনুগ্রহ করে আপনার ইন্টারনেট সংযোগ পরীক্ষা করুন এবং আবার চেষ্টা করুন।
                </p>
                
                <!-- Retry Button -->
                <button 
                    @click="refreshPage"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors"
                >
                    <RefreshCw class="w-5 h-5" />
                    আবার চেষ্টা করুন
                </button>
            </div>
        </div>
    </AppLayout>
</template>
