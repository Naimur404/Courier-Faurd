<script setup lang="ts">
import { computed } from 'vue';
import { cn } from '@/lib/utils';

interface Props {
    class?: string;
    gradient?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    gradient: false,
});

const classes = computed(() => 
    cn(
        'rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden transition-all duration-300 hover:shadow-xl',
        props.gradient && 'bg-gradient-to-br',
        props.class
    )
);
</script>

<template>
    <div :class="classes">
        <slot />
    </div>
</template>
