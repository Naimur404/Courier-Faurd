<script setup lang="ts">
import { computed, ref, onMounted, watch } from 'vue';
import { cn } from '@/lib/utils';

interface Props {
    modelValue: string;
    placeholder?: string;
    type?: string;
    class?: string;
    icon?: string;
    error?: string;
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    placeholder: '',
});

const emit = defineEmits<{
    'update:modelValue': [value: string];
    'enter': [];
}>();

const inputRef = ref<HTMLInputElement | null>(null);

const handleInput = (event: Event) => {
    const target = event.target as HTMLInputElement;
    emit('update:modelValue', target.value);
};

const handleKeypress = (event: KeyboardEvent) => {
    if (event.key === 'Enter') {
        emit('enter');
    }
};

const classes = computed(() =>
    cn(
        'w-full p-4 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white transition duration-300',
        props.icon && 'pl-10',
        props.error && 'border-red-500 focus:ring-red-500',
        props.class
    )
);
</script>

<template>
    <div class="relative">
        <div v-if="icon" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <component :is="icon" class="h-5 w-5 text-gray-400" />
        </div>
        <slot name="icon">
            <div v-if="$slots.icon" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <slot name="icon" />
            </div>
        </slot>
        <input
            ref="inputRef"
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            :class="classes"
            @input="handleInput"
            @keypress="handleKeypress"
        />
        <p v-if="error" class="mt-1 text-sm text-red-500">{{ error }}</p>
    </div>
</template>
