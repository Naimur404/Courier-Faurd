<script setup lang="ts">
import { WifiOff } from 'lucide-vue-next';
import { useNetworkStatus } from '@/composables/usePWA';

const { isOnline } = useNetworkStatus();
</script>

<template>
    <Transition
        enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="translate-y-full opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition-all duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-full opacity-0"
    >
        <div 
            v-if="!isOnline" 
            class="fixed bottom-4 left-1/2 -translate-x-1/2 z-50 md:bottom-6"
        >
            <div class="flex items-center gap-3 px-4 py-3 bg-gray-900 dark:bg-gray-700 text-white rounded-xl shadow-lg">
                <div class="w-8 h-8 bg-red-500/20 rounded-full flex items-center justify-center">
                    <WifiOff class="w-4 h-4 text-red-400" />
                </div>
                <div>
                    <p class="text-sm font-medium">অফলাইন মোড</p>
                    <p class="text-xs text-gray-300">ইন্টারনেট সংযোগ নেই</p>
                </div>
            </div>
        </div>
    </Transition>
</template>
