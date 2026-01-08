<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    Shield, Menu, X, Moon, Sun, 
    Home, Zap, Calculator, Puzzle, 
    Truck, Tag, Headphones, LogIn, 
    UserPlus, LayoutDashboard, LogOut, ChevronDown, CreditCard,
    Building2, HelpCircle, Search, Grid3X3, User
} from 'lucide-vue-next';

// Props
const props = withDefaults(defineProps<{
    forceDark?: boolean;
}>(), {
    forceDark: false,
});

const page = usePage();
const user = computed(() => page.props.auth?.user);
const isAdmin = computed(() => user.value?.role === 'admin');

const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);
const isDark = ref(true);
const activeSection = ref('#');
const isMobile = ref(false);
const showMoreMenu = ref(false);

// Check if mobile
const checkMobile = () => {
    isMobile.value = window.innerWidth < 768;
};

const navLinks = [
    { name: 'হোম', href: '#', icon: Home },
    { name: 'ফিচারস', href: '#features', icon: Zap },
    { name: 'লাভ/ক্ষতি', href: '#roi', icon: Calculator },
    { name: 'ইন্টিগ্রেশন', href: '#integrations', icon: Puzzle },
    { name: 'কুরিয়ার', href: '#couriers', icon: Truck },
    { name: 'API', href: '#pricing', icon: Tag },
    { name: 'সাবস্ক্রিপশন', href: '#website-subscription', icon: CreditCard },
    { name: 'আমাদের সম্পর্কে', href: '#about', icon: Building2 },
    { name: 'FAQ', href: '#faq', icon: HelpCircle },
    { name: 'কন্টাক্ট', href: '#contact', icon: Headphones },
];

// Mobile bottom nav links
const mobileNavLinks = [
    { name: 'হোম', href: '#', icon: Home },
    { name: 'প্রাইসিং', href: '#pricing', icon: Tag },
    { name: 'সাবস্ক্রিপশন', href: '#website-subscription', icon: CreditCard },
    { name: 'আরও', href: '#more', icon: Grid3X3, isMore: true },
];

// More menu items
const moreMenuItems = [
    { name: 'ফিচারস', href: '#features', icon: Zap },
    { name: 'লাভ/ক্ষতি', href: '#roi', icon: Calculator },
    { name: 'কুরিয়ার', href: '#couriers', icon: Truck },
    { name: 'আমাদের সম্পর্কে', href: '#about', icon: Building2 },
    { name: 'FAQ', href: '#faq', icon: HelpCircle },
    { name: 'কন্টাক্ট', href: '#contact', icon: Headphones },
];

const toggleMoreMenu = () => {
    showMoreMenu.value = !showMoreMenu.value;
};

const closeMoreMenu = () => {
    showMoreMenu.value = false;
};

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

// Helper to set cookie
const setCookie = (name: string, value: string, days: number = 365) => {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = `${name}=${value}; expires=${expires}; path=/; SameSite=Lax`;
};

const toggleTheme = () => {
    isDark.value = !isDark.value;
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        setCookie('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        setCookie('theme', 'light');
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
    window.addEventListener('resize', checkMobile);
    checkMobile();
    
    // Check saved theme - default to dark mode
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
        isDark.value = false;
        document.documentElement.classList.remove('dark');
        setCookie('theme', 'light');
    } else {
        // Default to dark mode
        isDark.value = true;
        document.documentElement.classList.add('dark');
        // Set cookie for SSR on next request
        if (!savedTheme) {
            localStorage.setItem('theme', 'dark');
        }
        setCookie('theme', 'dark');
    }
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    window.removeEventListener('resize', checkMobile);
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
                            <a
                                v-if="isAdmin"
                                href="/admin"
                                :class="[
                                    'flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition-all duration-300',
                                    props.forceDark
                                        ? 'bg-white/10 text-white hover:bg-white/20'
                                        : (isScrolled ? 'bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-700' : 'bg-white/10 text-white hover:bg-white/20')
                                ]"
                            >
                                <LayoutDashboard class="w-4 h-4" />
                                ড্যাশবোর্ড
                            </a>
                            <Link
                                v-else
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
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                :class="[
                                    'flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition-all duration-300',
                                    props.forceDark
                                        ? 'text-red-400 hover:bg-red-500/20'
                                        : (isScrolled ? 'text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20' : 'text-red-400 hover:bg-red-500/20')
                                ]"
                            >
                                <LogOut class="w-4 h-4" />
                                লগআউট
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

                    <!-- Mobile Auth Button (small, minimal) -->
                    <div class="flex md:hidden items-center gap-2">
                        <template v-if="user">
                            <a
                                v-if="isAdmin"
                                href="/admin"
                                :class="[
                                    'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-300',
                                    props.forceDark
                                        ? 'bg-white/10 text-white hover:bg-white/20'
                                        : (isScrolled ? 'bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300' : 'bg-white/10 text-white')
                                ]"
                            >
                                <LayoutDashboard class="w-4 h-4" />
                            </a>
                            <Link
                                v-else
                                href="/dashboard"
                                :class="[
                                    'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-300',
                                    props.forceDark
                                        ? 'bg-white/10 text-white hover:bg-white/20'
                                        : (isScrolled ? 'bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300' : 'bg-white/10 text-white')
                                ]"
                            >
                                <User class="w-4 h-4" />
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                href="/login"
                                :class="[
                                    'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-300',
                                    props.forceDark
                                        ? 'text-white hover:bg-white/10'
                                        : (isScrolled ? 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800' : 'text-white hover:bg-white/10')
                                ]"
                            >
                                <LogIn class="w-4 h-4" />
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <nav 
        v-if="isMobile"
        class="fixed bottom-0 left-0 right-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-lg border-t border-gray-200 dark:border-slate-700 shadow-lg"
    >
        <div class="flex items-center justify-around h-16">
            <template v-for="link in mobileNavLinks" :key="link.name">
                <!-- More Button with Popup -->
                <div v-if="link.isMore" class="relative">
                    <button
                        @click="toggleMoreMenu"
                        class="flex flex-col items-center justify-center px-4 py-2 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
                    >
                        <component :is="link.icon" class="w-5 h-5 mb-0.5" />
                        <span class="text-xs">{{ link.name }}</span>
                    </button>

                    <!-- More Menu Popup -->
                    <Transition
                        enter-active-class="transition-all duration-200 ease-out"
                        enter-from-class="opacity-0 translate-y-4 scale-95"
                        enter-to-class="opacity-100 translate-y-0 scale-100"
                        leave-active-class="transition-all duration-150 ease-in"
                        leave-from-class="opacity-100 translate-y-0 scale-100"
                        leave-to-class="opacity-0 translate-y-4 scale-95"
                    >
                        <div 
                            v-if="showMoreMenu"
                            class="absolute bottom-full right-0 mb-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden"
                        >
                            <button
                                v-for="item in moreMenuItems"
                                :key="item.name"
                                @click="scrollToSection(item.href); closeMoreMenu();"
                                class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors"
                            >
                                <component :is="item.icon" class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                                {{ item.name }}
                            </button>
                            
                            <!-- Auth in More menu for logged in users -->
                            <template v-if="user">
                                <div class="border-t border-gray-200 dark:border-slate-700">
                                    <Link
                                        href="/logout"
                                        method="post"
                                        as="button"
                                        class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                    >
                                        <LogOut class="w-4 h-4" />
                                        লগআউট
                                    </Link>
                                </div>
                            </template>
                            <!-- Auth in More menu for guests -->
                            <template v-else>
                                <div class="border-t border-gray-200 dark:border-slate-700">
                                    <Link
                                        href="/register"
                                        class="flex items-center gap-3 w-full px-4 py-3 text-sm text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors"
                                    >
                                        <UserPlus class="w-4 h-4" />
                                        ফ্রি একাউন্ট
                                    </Link>
                                </div>
                            </template>
                        </div>
                    </Transition>
                </div>

                <!-- Regular Nav Links -->
                <button
                    v-else
                    @click="scrollToSection(link.href)"
                    :class="[
                        'flex flex-col items-center justify-center px-4 py-2 transition-colors',
                        activeSection === link.href
                            ? 'text-indigo-600 dark:text-indigo-400'
                            : 'text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400'
                    ]"
                >
                    <component :is="link.icon" class="w-5 h-5 mb-0.5" />
                    <span class="text-xs">{{ link.name }}</span>
                </button>
            </template>
        </div>
    </nav>

    <!-- Backdrop for More Menu -->
    <div 
        v-if="showMoreMenu && isMobile" 
        @click="closeMoreMenu"
        class="fixed inset-0 z-40 bg-black/20"
    />
</template>
