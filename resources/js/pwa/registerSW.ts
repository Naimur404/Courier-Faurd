// PWA Service Worker Registration
export function registerServiceWorker(): void {
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', async () => {
            try {
                const registration = await navigator.serviceWorker.register('/sw.js', {
                    scope: '/'
                });
                
                console.log('✅ Service Worker registered successfully:', registration.scope);

                // Check for updates
                registration.addEventListener('updatefound', () => {
                    const newWorker = registration.installing;
                    if (newWorker) {
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                // New content is available, show update prompt
                                showUpdatePrompt();
                            }
                        });
                    }
                });

                // Check for updates periodically (every hour)
                setInterval(() => {
                    registration.update();
                }, 60 * 60 * 1000);

            } catch (error) {
                console.error('❌ Service Worker registration failed:', error);
            }
        });

        // Handle controller change (when new SW takes over)
        navigator.serviceWorker.addEventListener('controllerchange', () => {
            console.log('🔄 New Service Worker activated');
        });
    }
}

// Show update prompt to user
function showUpdatePrompt(): void {
    const updateBanner = document.createElement('div');
    updateBanner.id = 'sw-update-banner';
    updateBanner.innerHTML = `
        <div style="
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 16px;
            font-family: 'Noto Sans Bengali', sans-serif;
            max-width: 90%;
            width: 400px;
        ">
            <div style="flex: 1;">
                <strong style="display: block; margin-bottom: 4px;">🆕 নতুন আপডেট!</strong>
                <span style="font-size: 14px; opacity: 0.9;">নতুন ভার্সন পাওয়া গেছে</span>
            </div>
            <button id="sw-update-btn" style="
                background: white;
                color: #4f46e5;
                border: none;
                padding: 10px 20px;
                border-radius: 8px;
                cursor: pointer;
                font-weight: 600;
                font-size: 14px;
                transition: transform 0.2s;
            ">রিফ্রেশ করুন</button>
        </div>
    `;
    document.body.appendChild(updateBanner);

    document.getElementById('sw-update-btn')?.addEventListener('click', () => {
        window.location.reload();
    });
}

// Check if app is installed
export function isAppInstalled(): boolean {
    return window.matchMedia('(display-mode: standalone)').matches ||
           (window.navigator as any).standalone === true;
}

// PWA Install prompt handling
let deferredPrompt: any = null;

export function initInstallPrompt(callback?: (prompt: any) => void): void {
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        console.log('📱 Install prompt ready');
        
        if (callback) {
            callback(deferredPrompt);
        }
    });

    window.addEventListener('appinstalled', () => {
        console.log('✅ App installed successfully');
        deferredPrompt = null;
    });
}

export function showInstallPrompt(): Promise<boolean> {
    return new Promise((resolve) => {
        if (!deferredPrompt) {
            console.log('No install prompt available');
            resolve(false);
            return;
        }

        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult: any) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
                resolve(true);
            } else {
                console.log('User dismissed the install prompt');
                resolve(false);
            }
            deferredPrompt = null;
        });
    });
}

export function getDeferredPrompt(): any {
    return deferredPrompt;
}
