import { ref, onMounted, onUnmounted, computed } from 'vue';

// Reactive refs for PWA state
const isOnline = ref(true);
const isInstalled = ref(false);
const isInstallable = ref(false);
const deferredPrompt = ref<any>(null);
const swRegistration = ref<ServiceWorkerRegistration | null>(null);
const swUpdateAvailable = ref(false);

export function usePWA() {
    // Check if app is installed as PWA
    const checkIfInstalled = () => {
        return window.matchMedia('(display-mode: standalone)').matches ||
               (window.navigator as any).standalone === true ||
               document.referrer.includes('android-app://');
    };

    // Update online status
    const updateOnlineStatus = () => {
        isOnline.value = navigator.onLine;
    };

    // Handle install prompt
    const handleBeforeInstallPrompt = (e: Event) => {
        e.preventDefault();
        deferredPrompt.value = e;
        isInstallable.value = true;
    };

    // Handle app installed
    const handleAppInstalled = () => {
        isInstalled.value = true;
        isInstallable.value = false;
        deferredPrompt.value = null;
    };

    // Prompt user to install
    const promptInstall = async (): Promise<boolean> => {
        if (!deferredPrompt.value) {
            console.log('No install prompt available');
            return false;
        }

        try {
            deferredPrompt.value.prompt();
            const { outcome } = await deferredPrompt.value.userChoice;
            
            if (outcome === 'accepted') {
                console.log('User accepted the install prompt');
                return true;
            } else {
                console.log('User dismissed the install prompt');
                return false;
            }
        } finally {
            deferredPrompt.value = null;
            isInstallable.value = false;
        }
    };

    // Check for service worker updates
    const checkForUpdates = async () => {
        if (swRegistration.value) {
            await swRegistration.value.update();
        }
    };

    // Skip waiting and activate new service worker
    const activateUpdate = () => {
        if (swRegistration.value?.waiting) {
            swRegistration.value.waiting.postMessage({ type: 'SKIP_WAITING' });
        }
    };

    // Request notification permission
    const requestNotificationPermission = async (): Promise<NotificationPermission> => {
        if (!('Notification' in window)) {
            console.log('This browser does not support notifications');
            return 'denied';
        }

        if (Notification.permission === 'granted') {
            return 'granted';
        }

        if (Notification.permission !== 'denied') {
            const permission = await Notification.requestPermission();
            return permission;
        }

        return Notification.permission;
    };

    // Subscribe to push notifications
    const subscribeToPush = async (): Promise<PushSubscription | null> => {
        if (!swRegistration.value) {
            console.log('No service worker registration');
            return null;
        }

        try {
            const subscription = await swRegistration.value.pushManager.subscribe({
                userVisibleOnly: true,
                // Add your VAPID public key here
                // applicationServerKey: urlBase64ToUint8Array(VAPID_PUBLIC_KEY)
            });
            console.log('Push subscription:', subscription);
            return subscription;
        } catch (error) {
            console.error('Failed to subscribe to push:', error);
            return null;
        }
    };

    // Setup event listeners
    const setupListeners = () => {
        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
        window.addEventListener('beforeinstallprompt', handleBeforeInstallPrompt);
        window.addEventListener('appinstalled', handleAppInstalled);
    };

    // Cleanup event listeners
    const cleanupListeners = () => {
        window.removeEventListener('online', updateOnlineStatus);
        window.removeEventListener('offline', updateOnlineStatus);
        window.removeEventListener('beforeinstallprompt', handleBeforeInstallPrompt);
        window.removeEventListener('appinstalled', handleAppInstalled);
    };

    // Initialize PWA features
    const init = () => {
        isInstalled.value = checkIfInstalled();
        isOnline.value = navigator.onLine;
        setupListeners();

        // Get service worker registration
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.ready.then((registration) => {
                swRegistration.value = registration;

                // Check for updates
                registration.addEventListener('updatefound', () => {
                    const newWorker = registration.installing;
                    if (newWorker) {
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                swUpdateAvailable.value = true;
                            }
                        });
                    }
                });
            });
        }
    };

    // Computed properties
    const canInstall = computed(() => isInstallable.value && !isInstalled.value);
    const hasUpdate = computed(() => swUpdateAvailable.value);

    return {
        // State
        isOnline,
        isInstalled,
        isInstallable,
        swUpdateAvailable,
        
        // Computed
        canInstall,
        hasUpdate,
        
        // Methods
        init,
        cleanup: cleanupListeners,
        promptInstall,
        checkForUpdates,
        activateUpdate,
        requestNotificationPermission,
        subscribeToPush,
    };
}

// Network status composable for components
export function useNetworkStatus() {
    const online = ref(navigator.onLine);

    const updateStatus = () => {
        online.value = navigator.onLine;
    };

    onMounted(() => {
        window.addEventListener('online', updateStatus);
        window.addEventListener('offline', updateStatus);
    });

    onUnmounted(() => {
        window.removeEventListener('online', updateStatus);
        window.removeEventListener('offline', updateStatus);
    });

    return {
        isOnline: online,
    };
}
