<script setup lang="ts">
import { computed } from 'vue';
import { cn } from '@/lib/utils';

interface Props {
    modelValue?: number;
    max?: number;
    class?: string;
    indicatorClass?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: 0,
    max: 100,
});

const percentage = computed(() => {
    return Math.min(100, Math.max(0, (props.modelValue / props.max) * 100));
});
</script>

<template>
    <div
        role="progressbar"
        :aria-valuenow="modelValue"
        :aria-valuemin="0"
        :aria-valuemax="max"
        :class="cn('relative h-4 w-full overflow-hidden rounded-full bg-secondary', props.class)"
    >
        <div
            :class="cn('h-full w-full flex-1 bg-primary transition-all', indicatorClass)"
            :style="{ transform: `translateX(-${100 - percentage}%)` }"
        />
    </div>
</template>
