<script setup lang="ts">
import { onMounted, ref } from 'vue';
import NavBar from '@/components/landing/NavBar.vue';
import FooterSection from '@/components/landing/FooterSection.vue';
import Toast from '@/components/ui/Toast.vue';

// Props
const props = withDefaults(defineProps<{
    forceDarkNav?: boolean;
}>(), {
    forceDarkNav: true,
});

// Spacer for fixed navbar
const navHeight = ref(80);

onMounted(() => {
    // Check saved theme - default to dark mode
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
        document.documentElement.classList.remove('dark');
    } else {
        // Default to dark mode
        document.documentElement.classList.add('dark');
    }
});
</script>

<template>
    <div class="min-h-screen flex flex-col bg-slate-900">
        <!-- Navigation -->
        <NavBar :force-dark="props.forceDarkNav" />
        
        <!-- Spacer for fixed navbar -->
        <div :style="{ height: navHeight + 'px' }"></div>
        
        <!-- Main Content -->
        <main class="flex-grow">
            <slot />
        </main>
        
        <!-- Footer -->
        <FooterSection />
        
        <!-- Toast Notifications -->
        <Toast />
    </div>
</template>
