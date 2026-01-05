<script setup lang="ts">
import { computed } from 'vue';
import { cn } from '@/lib/utils';
import { cva, type VariantProps } from 'class-variance-authority';

const alertVariants = cva(
    'relative w-full rounded-lg border p-4 [&>svg~*]:pl-7 [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-foreground',
    {
        variants: {
            variant: {
                default: 'bg-background text-foreground',
                destructive: 'border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive',
                success: 'border-green-500/50 text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/20 [&>svg]:text-green-600',
                warning: 'border-yellow-500/50 text-yellow-700 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 [&>svg]:text-yellow-600',
            },
        },
        defaultVariants: {
            variant: 'default',
        },
    }
);

type AlertVariants = VariantProps<typeof alertVariants>;

interface Props {
    variant?: AlertVariants['variant'];
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    variant: 'default',
});

const classes = computed(() => cn(alertVariants({ variant: props.variant }), props.class));
</script>

<template>
    <div role="alert" :class="classes">
        <slot />
    </div>
</template>
