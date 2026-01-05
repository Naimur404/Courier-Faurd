<script setup lang="ts">
import { computed } from 'vue';
import { cn } from '@/lib/utils';
import { cva, type VariantProps } from 'class-variance-authority';

const buttonVariants = cva(
    'inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-semibold ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50',
    {
        variants: {
            variant: {
                default: 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:opacity-90 shadow-lg hover:shadow-xl',
                destructive: 'bg-red-500 text-white hover:bg-red-600',
                outline: 'border border-gray-300 dark:border-gray-600 bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800',
                secondary: 'bg-gray-100 text-gray-900 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700',
                ghost: 'hover:bg-gray-100 dark:hover:bg-gray-800',
                link: 'text-indigo-600 underline-offset-4 hover:underline',
                success: 'bg-green-500 text-white hover:bg-green-600',
                warning: 'bg-yellow-500 text-white hover:bg-yellow-600',
            },
            size: {
                default: 'h-10 px-4 py-2',
                sm: 'h-9 rounded-md px-3',
                lg: 'h-12 rounded-lg px-8 text-base',
                xl: 'h-14 rounded-xl px-10 text-lg',
                icon: 'h-10 w-10',
            },
        },
        defaultVariants: {
            variant: 'default',
            size: 'default',
        },
    }
);

type ButtonVariants = VariantProps<typeof buttonVariants>;

interface Props {
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
    class?: string;
    disabled?: boolean;
    loading?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    variant: 'default',
    size: 'default',
    disabled: false,
    loading: false,
});

const classes = computed(() => cn(buttonVariants({ variant: props.variant, size: props.size }), props.class));
</script>

<template>
    <button :class="classes" :disabled="disabled || loading">
        <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <slot />
    </button>
</template>
