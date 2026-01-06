<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Download, X, Smartphone, Zap, WifiOff } from 'lucide-vue-next';

const showPrompt = ref(false);
const deferredPrompt = ref<any>(null);
const isInstalled = ref(false);

const checkIfInstalled = () => {
    return window.matchMedia('(display-mode: standalone)').matches ||
           (window.navigator as any).standalone === true;
};

const handleBeforeInstallPrompt = (e: Event) => {
    e.preventDefault();
    deferredPrompt.value = e;
    
    // Don't show immediately, wait a bit for user engagement
    setTimeout(() => {
        if (!isInstalled.value && !localStorage.getItem('pwa-prompt-dismissed')) {
            showPrompt.value = true;
        }
    }, 3000);
};

const handleAppInstalled = () => {
    isInstalled.value = true;
    showPrompt.value = false;
    deferredPrompt.value = null;
};

const installApp = async () => {
    if (!deferredPrompt.value) return;
    
    deferredPrompt.value.prompt();
    const { outcome } = await deferredPrompt.value.userChoice;
    
    if (outcome === 'accepted') {
        showPrompt.value = false;
    }
    deferredPrompt.value = null;
};

const dismissPrompt = () => {
    showPrompt.value = false;
    localStorage.setItem('pwa-prompt-dismissed', Date.now().toString());
};

const dismissPermanently = () => {
    showPrompt.value = false;
    localStorage.setItem('pwa-prompt-dismissed-permanent', 'true');
};

onMounted(() => {
    isInstalled.value = checkIfInstalled();
    
    if (isInstalled.value || localStorage.getItem('pwa-prompt-dismissed-permanent')) {
        return;
    }
    
    window.addEventListener('beforeinstallprompt', handleBeforeInstallPrompt);
    window.addEventListener('appinstalled', handleAppInstalled);
});

onUnmounted(() => {
    window.removeEventListener('beforeinstallprompt', handleBeforeInstallPrompt);
    window.removeEventListener('appinstalled', handleAppInstalled);
});
</script>

<template>
    <!-- PWA Install Banner -->
    <Transition
        enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="translate-y-full opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition-all duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-full opacity-0"
    >
        <div 
            v-if="showPrompt" 
            class="fixed bottom-20 md:bottom-4 left-2 right-2 md:left-auto md:right-4 md:w-96 z-50"
        >
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-2xl p-4 md:p-5 text-white">
                <!-- Close button -->
                <button 
                    @click="dismissPrompt"
                    class="absolute top-2 right-2 md:top-3 md:right-3 p-1.5 hover:bg-white/20 rounded-full transition-colors"
                >
                    <X class="w-4 h-4 md:w-5 md:h-5" />
                </button>
                
                <!-- Icon and Title -->
                <div class="flex items-start gap-3 md:gap-4 mb-3 md:mb-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <Smartphone class="w-6 h-6 md:w-8 md:h-8" />
                    </div>
                    <div class="pr-6">
                        <h3 class="font-bold text-base md:text-lg">অ্যাপ ইনস্টল করুন</h3>
                        <p class="text-xs md:text-sm text-white/80">FraudShield আপনার ফোনে ইনস্টল করুন</p>
                    </div>
                </div>
                
                <!-- Features - Hidden on very small screens -->
                <div class="hidden xs:flex flex-wrap gap-x-4 gap-y-1 mb-3 md:mb-4 text-xs md:text-sm">
                    <div class="flex items-center gap-1.5">
                        <Zap class="w-3.5 h-3.5 md:w-4 md:h-4 text-yellow-300" />
                        <span>দ্রুত লোড</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <WifiOff class="w-3.5 h-3.5 md:w-4 md:h-4 text-blue-300" />
                        <span>অফলাইনে কাজ</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <Download class="w-3.5 h-3.5 md:w-4 md:h-4 text-green-300" />
                        <span>হোম স্ক্রিনে সেভ</span>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-2 md:gap-3">
                    <button
                        @click="installApp"
                        class="flex-1 bg-white text-indigo-600 font-semibold py-2.5 md:py-3 px-3 md:px-4 rounded-xl hover:bg-gray-100 transition-colors flex items-center justify-center gap-2 text-sm md:text-base"
                    >
                        <Download class="w-4 h-4 md:w-5 md:h-5" />
                        ইনস্টল করুন
                    </button>
                    <button
                        @click="dismissPermanently"
                        class="py-2.5 md:py-3 px-3 md:px-4 text-white/70 hover:text-white transition-colors text-xs md:text-sm"
                    >
                        পরে
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>
