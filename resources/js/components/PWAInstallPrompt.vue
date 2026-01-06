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
            class="fixed bottom-4 left-4 right-4 md:left-auto md:right-4 md:w-96 z-50"
        >
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-2xl p-5 text-white">
                <!-- Close button -->
                <button 
                    @click="dismissPrompt"
                    class="absolute top-3 right-3 p-1 hover:bg-white/20 rounded-full transition-colors"
                >
                    <X class="w-5 h-5" />
                </button>
                
                <!-- Icon and Title -->
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <Smartphone class="w-8 h-8" />
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">অ্যাপ ইনস্টল করুন</h3>
                        <p class="text-sm text-white/80">FraudShield আপনার ফোনে ইনস্টল করুন</p>
                    </div>
                </div>
                
                <!-- Features -->
                <div class="space-y-2 mb-4 text-sm">
                    <div class="flex items-center gap-2">
                        <Zap class="w-4 h-4 text-yellow-300" />
                        <span>দ্রুত লোড হবে</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <WifiOff class="w-4 h-4 text-blue-300" />
                        <span>অফলাইনেও কাজ করবে</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Download class="w-4 h-4 text-green-300" />
                        <span>হোম স্ক্রিনে সেভ হবে</span>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-3">
                    <button
                        @click="installApp"
                        class="flex-1 bg-white text-indigo-600 font-semibold py-3 px-4 rounded-xl hover:bg-gray-100 transition-colors flex items-center justify-center gap-2"
                    >
                        <Download class="w-5 h-5" />
                        ইনস্টল করুন
                    </button>
                    <button
                        @click="dismissPermanently"
                        class="py-3 px-4 text-white/70 hover:text-white transition-colors text-sm"
                    >
                        পরে
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>
