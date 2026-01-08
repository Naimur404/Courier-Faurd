<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    Shield, Menu, X, Moon, Sun, 
    Home, Zap, Calculator, Puzzle, 
    Truck, Tag, Headphones, LogIn, 
    UserPlus, LayoutDashboard, LogOut, ChevronDown, CreditCard
} from 'lucide-vue-next';

// Props
const props = withDefaults(defineProps<{
    forceDark?: boolean;
}>(), {
    forceDark: false,
});

const page = usePage();
const user = computed(() => page.props.auth?.user);

const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);
const isDark = ref(false);
const activeSection = ref('#');

const navLinks = [
    { name: 'হোম', href: '#', icon: Home },
    { name: 'ফিচারস', href: '#features', icon: Zap },
    { name: 'লাভ/ক্ষতি', href: '#roi', icon: Calculator },
    { name: 'ইন্টিগ্রেশন', href: '#integrations', icon: Puzzle },
    { name: 'কুরিয়ার', href: '#couriers', icon: Truck },
    { name: 'API', href: '#pricing', icon: Tag },
    { name: 'সাবস্ক্রিপশন', href: '#website-subscription', icon: CreditCard },
    { name: 'কন্টাক্ট', href: '#contact', icon: Headphones },
];

const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
    
    // Update active section based on scroll position
    if (!props.forceDark) {
        updateActiveSection();
    }
};

const updateActiveSection = () => {
    const scrollPosition = window.scrollY + 100; // Offset for navbar height
    
    // Check if at top
    if (scrollPosition < 200) {
        activeSection.value = '#';
        return;
    }
    
    // Check each section
    for (let i = navLinks.length - 1; i >= 0; i--) {
        const link = navLinks[i];
        if (link.href === '#') continue;
        
        const element = document.querySelector(link.href);
        if (element) {
            const rect = element.getBoundingClientRect();
            const elementTop = rect.top + window.scrollY;
            
            if (scrollPosition >= elementTop) {
                activeSection.value = link.href;
                return;
            }
        }
    }
    
    activeSection.value = '#';
};

const toggleTheme = () => {
    isDark.value = !isDark.value;
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

const scrollToSection = (href: string) => {
    isMobileMenuOpen.value = false;
    activeSection.value = href;
    
    // If forceDark is true (non-home page), navigate to home page with anchor
    if (props.forceDark) {
        if (href === '#') {
            window.location.href = '/';
        } else {
            window.location.href = '/' + href;
        }
        return;
    }
    
    if (href === '#') {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }
    const element = document.querySelector(href);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    // Check saved theme
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        isDark.value = true;
        document.documentElement.classList.add('dark');
    }
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <nav 
        :class="[
            'fixed top-0 left-0 right-0 z-50 transition-all duration-300',
            props.forceDark
                ? 'bg-slate-900'
                : (isScrolled ? 'bg-white/90 dark:bg-slate-900/90 backdrop-blur-lg shadow-lg' : 'bg-transparent')
        ]"
    >
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16 md:h-20">
                <!-- Logo -->
                <Link href="/" class="flex items-center gap-2">
                    <div 
                        :class="[
                            'p-2 rounded-xl transition-all duration-300',
                            (props.forceDark || isScrolled)
                                ? 'bg-gradient-to-br from-indigo-500 to-purple-600' 
                                : 'bg-white/10 backdrop-blur-sm'
                        ]"
                    >
                        <Shield class="w-6 h-6 text-white" />
                    </div>
                    <span 
                        :class="[
                            'text-xl font-bold transition-colors duration-300',
                            props.forceDark
                                ? 'text-white'
                                : (isScrolled ? 'text-gray-900 dark:text-white' : 'text-white')
                        ]"
                    >
                        FraudShield
                    </span>
                </Link>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-1">
                    <button
                        v-for="link in navLinks"
                        :key="link.name"
                        @click="scrollToSection(link.href)"
                        :class="[
                            'px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300',
                            activeSection === link.href
                                ? 'bg-indigo-500/20 text-indigo-400'
                                : (props.forceDark
                                    ? 'text-white/70 hover:text-white hover:bg-white/10'
                                    : (isScrolled 
                                        ? 'text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-white/10' 
                                        : 'text-white/70 hover:text-white hover:bg-white/10'))
                        ]"
                    >
                        {{ link.name }}
                    </button>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-3">
                    <!-- Theme Toggle -->
                    <button
                        @click="toggleTheme"
                        :class="[
                            'p-2 rounded-lg transition-all duration-300',
                            props.forceDark
                                ? 'bg-white/10 text-white hover:bg-white/20'
                                : (isScrolled ? 'bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300' : 'bg-white/10 text-white hover:bg-white/20')
                        ]"
                    >
                        <Sun v-if="isDark" class="w-5 h-5" />
                        <Moon v-else class="w-5 h-5" />
                    </button>

                    <!-- Auth Buttons (Desktop) -->
                    <div class="hidden md:flex items-center gap-2">
                        <template v-if="user">
                            <Link
                                href="/dashboard"
                                :class="[
                                    'flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition-all duration-300',
                                    props.forceDark
                                        ? 'bg-white/10 text-white hover:bg-white/20'
                                        : (isScrolled ? 'bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-700' : 'bg-white/10 text-white hover:bg-white/20')
                                ]"
                            >
                                <LayoutDashboard class="w-4 h-4" />
                                ড্যাশবোর্ড
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                href="/login"
                                :class="[
                                    'flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition-all duration-300',
                                    props.forceDark
                                        ? 'text-white hover:bg-white/10'
                                        : (isScrolled ? 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800' : 'text-white hover:bg-white/10')
                                ]"
                            >
                                <LogIn class="w-4 h-4" />
                                লগইন
                            </Link>
                            <Link
                                href="/register"
                                class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-lg hover:shadow-lg hover:shadow-indigo-500/25 transition-all duration-300"
                            >
                                <UserPlus class="w-4 h-4" />
                                ফ্রি একাউন্ট
                            </Link>
                        </template>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button
                        @click="isMobileMenuOpen = !isMobileMenuOpen"
                        :class="[
                            'lg:hidden p-2 rounded-lg transition-all duration-300',
                            props.forceDark
                                ? 'bg-white/10 text-white'
                                : (isScrolled ? 'bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300' : 'bg-white/10 text-white')
                        ]"
                    >
                        <X v-if="isMobileMenuOpen" class="w-6 h-6" />
                        <Menu v-else class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 -translate-y-4"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-4"
        >
            <div 
                v-if="isMobileMenuOpen"
                class="lg:hidden absolute top-full left-0 right-0 bg-white dark:bg-slate-900 shadow-xl border-t border-gray-100 dark:border-slate-800"
            >
                <div class="container mx-auto px-4 py-4">
                    <!-- Nav Links -->
                    <div class="space-y-1 mb-4">
                        <button
                            v-for="link in navLinks"
                            :key="link.name"
                            @click="scrollToSection(link.href)"
                            :class="[
                                'flex items-center gap-3 w-full px-4 py-3 rounded-lg transition-colors',
                                activeSection === link.href
                                    ? 'bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800'
                            ]"
                        >
                            <component :is="link.icon" :class="[
                                'w-5 h-5',
                                activeSection === link.href
                                    ? 'text-indigo-600 dark:text-indigo-400'
                                    : 'text-gray-400 dark:text-gray-500'
                            ]" />
                            {{ link.name }}
                        </button>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="border-t border-gray-100 dark:border-slate-800 pt-4 space-y-2">
                        <template v-if="user">
                            <Link
                                href="/dashboard"
                                class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 font-medium rounded-lg"
                            >
                                <LayoutDashboard class="w-5 h-5" />
                                ড্যাশবোর্ড
                            </Link>
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                class="flex items-center justify-center gap-2 w-full px-4 py-3 text-red-600 dark:text-red-400 font-medium rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20"
                            >
                                <LogOut class="w-5 h-5" />
                                লগআউট
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                href="/login"
                                class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 font-medium rounded-lg"
                            >
                                <LogIn class="w-5 h-5" />
                                লগইন
                            </Link>
                            <Link
                                href="/register"
                                class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-lg"
                            >
                                <UserPlus class="w-5 h-5" />
                                ফ্রি একাউন্ট
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </Transition>
    </nav>
</template>
