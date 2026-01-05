<script setup lang="ts">
import { computed, ref } from 'vue';
import { cn } from '@/lib/utils';

interface Props {
    modelValue?: string;
    placeholder?: string;
    type?: string;
    class?: string;
    error?: string;
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    placeholder: '',
    modelValue: '',
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
        'flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm',
        props.error && 'border-destructive focus-visible:ring-destructive',
        props.class
    )
);
</script>

<template>
    <input
        ref="inputRef"
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :class="classes"
        @input="handleInput"
        @keypress="handleKeypress"
    />
</template>
