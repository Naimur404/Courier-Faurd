<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { cn } from '@/lib/utils';
import { Star } from 'lucide-vue-next';

interface Props {
    modelValue: number;
    readonly?: boolean;
    size?: 'sm' | 'md' | 'lg';
}

const props = withDefaults(defineProps<Props>(), {
    readonly: false,
    size: 'md',
});

const emit = defineEmits<{
    'update:modelValue': [value: number];
}>();

const hoverRating = ref(0);

const sizeClasses = {
    sm: 'h-4 w-4',
    md: 'h-6 w-6',
    lg: 'h-8 w-8',
};

const handleClick = (rating: number) => {
    if (!props.readonly) {
        emit('update:modelValue', rating);
    }
};

const handleMouseEnter = (rating: number) => {
    if (!props.readonly) {
        hoverRating.value = rating;
    }
};

const handleMouseLeave = () => {
    hoverRating.value = 0;
};

const getStarClass = (index: number) => {
    const rating = hoverRating.value || props.modelValue;
    return index <= rating ? 'text-yellow-500 fill-yellow-500' : 'text-gray-300 dark:text-gray-600';
};
</script>

<template>
    <div class="flex space-x-1" @mouseleave="handleMouseLeave">
        <button
            v-for="i in 5"
            :key="i"
            type="button"
            :disabled="readonly"
            :class="cn(
                'transition-all duration-150',
                !readonly && 'cursor-pointer hover:scale-110',
                readonly && 'cursor-default'
            )"
            @click="handleClick(i)"
            @mouseenter="handleMouseEnter(i)"
        >
            <Star :class="cn(sizeClasses[size], getStarClass(i), 'transition-colors')" />
        </button>
    </div>
</template>
