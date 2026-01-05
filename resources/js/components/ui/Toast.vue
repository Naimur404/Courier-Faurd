<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

interface ToastOptions {
    message: string;
    type?: 'success' | 'error' | 'warning' | 'info';
    duration?: number;
}

interface Toast extends ToastOptions {
    id: number;
}

const toasts = ref<Toast[]>([]);
let toastId = 0;

const addToast = (options: ToastOptions) => {
    const id = ++toastId;
    const toast: Toast = {
        id,
        message: options.message,
        type: options.type || 'info',
        duration: options.duration || 3000,
    };
    
    toasts.value.push(toast);
    
    setTimeout(() => {
        removeToast(id);
    }, toast.duration);
};

const removeToast = (id: number) => {
    const index = toasts.value.findIndex(t => t.id === id);
    if (index > -1) {
        toasts.value.splice(index, 1);
    }
};

const getToastClasses = (type: string) => {
    const baseClasses = 'p-4 rounded-lg shadow-lg flex items-center space-x-3 transition-all duration-300';
    const typeClasses = {
        success: 'bg-gradient-to-r from-green-500 to-green-600 text-white',
        error: 'bg-gradient-to-r from-red-500 to-red-600 text-white',
        warning: 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white',
        info: 'bg-gradient-to-r from-blue-500 to-blue-600 text-white',
    };
    return `${baseClasses} ${typeClasses[type as keyof typeof typeClasses] || typeClasses.info}`;
};

// Expose the addToast method for global use
defineExpose({ addToast });

// Make it globally accessible
onMounted(() => {
    (window as any).$toast = addToast;
});
</script>

<template>
    <Teleport to="body">
        <div class="fixed top-4 right-4 z-50 space-y-2">
            <TransitionGroup
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 translate-x-full"
                enter-to-class="opacity-100 translate-x-0"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="opacity-100 translate-x-0"
                leave-to-class="opacity-0 translate-x-full"
            >
                <div
                    v-for="toast in toasts"
                    :key="toast.id"
                    :class="getToastClasses(toast.type || 'info')"
                >
                    <span>{{ toast.message }}</span>
                    <button @click="removeToast(toast.id)" class="ml-2 hover:opacity-70">
                        ✕
                    </button>
                </div>
            </TransitionGroup>
        </div>
    </Teleport>
</template>
