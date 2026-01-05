<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    Shield, Home, Info, Tag, Infinity, Download, 
    Moon, Sun, Menu, X, LogIn, UserPlus, LogOut, 
    User, Settings, LayoutDashboard, ChevronDown,
    Search, Grid3X3
} from 'lucide-vue-next';
import Toast from '@/components/ui/Toast.vue';
import type { PageProps } from '@/types/inertia';

const page = usePage<PageProps>();
const isDark = ref(false);
const isMobileMenuOpen = ref(false);
const isUserDropdownOpen = ref(false);
const isMobile = ref(false);
const showMoreMenu = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth < 768;
};

const user = computed(() => page.props.auth?.user);
const isAdmin = computed(() => user.value?.role === 'admin');

// Helper function to get cookie value
const getCookie = (name: string): string | null => {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop()?.split(';').shift() || null;
    return null;
};

onMounted(() => {
    // Check for saved theme preference (localStorage takes priority, then cookie, then system)
    const savedTheme = localStorage.getItem('theme') || getCookie('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        isDark.value = true;
        document.documentElement.classList.add('dark');
    } else {
        isDark.value = false;
        document.documentElement.classList.remove('dark');
    }
    
    // Check if mobile
    checkMobile();
    window.addEventListener('resize', checkMobile);
});

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
});

// Helper function to set cookie
const setCookie = (name: string, value: string, days: number = 365) => {
    const expires = new Date();
    expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
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

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const toggleUserDropdown = () => {
    isUserDropdownOpen.value = !isUserDropdownOpen.value;
};

const navLinks = [
    { name: 'হোম', href: '/', icon: Home },
    { name: 'আমাদের সম্পর্কে', href: '/about', icon: Info },
    { name: 'প্রাইসিং', href: '/pricing', icon: Tag },
    { name: 'সীমাহীন সার্চ', href: '/website-subscriptions', icon: Infinity },
];

// Mobile bottom nav links
const mobileNavLinks = [
    { name: 'হোম', href: '/', icon: Home },
    { name: 'সার্চ', href: '/website-subscriptions', icon: Search },
    { name: 'প্রাইসিং', href: '/pricing', icon: Tag },
    { name: 'আরও', href: '#more', icon: Grid3X3, isMore: true },
];

// More menu items - App download first for better visibility
const moreMenuItems = [
    { name: 'অ্যাপ ডাউনলোড করুন', href: '/download', icon: Download, highlight: true },
    { name: 'আমাদের সম্পর্কে', href: '/about', icon: Info },
];

const currentPath = computed(() => {
    return typeof window !== 'undefined' ? window.location.pathname : '/';
});

const isActiveRoute = (href: string) => {
    if (href === '/') return currentPath.value === '/';
    return currentPath.value.startsWith(href);
};

const toggleMoreMenu = () => {
    showMoreMenu.value = !showMoreMenu.value;
};

const closeMoreMenu = () => {
    showMoreMenu.value = false;
};
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">
        <!-- Toast Component -->
        <Toast />
        
        <!-- Header -->
        <header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg shadow-lg py-4 sticky top-0 z-50 border-b border-gray-200 dark:border-gray-700">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <Link href="/" class="flex items-center group">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white w-10 h-10 rounded-xl flex items-center justify-center mr-3 shadow-lg group-hover:shadow-xl transition-shadow">
                            <Shield class="w-5 h-5" />
                        </div>
                        <div class="text-xl font-bold">
                            <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Fraud</span>
                            <span class="text-gray-800 dark:text-white">Shield</span>
                        </div>
                    </Link>
                    
                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex items-center gap-1">
                        <Link
                            v-for="link in navLinks"
                            :key="link.href"
                            :href="link.href"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                        >
                            <component :is="link.icon" class="w-4 h-4" />
                            {{ link.name }}
                        </Link>
                        
                        <!-- Auth Section -->
                        <template v-if="user">
                            <a
                                v-if="isAdmin"
                                href="/admin"
                                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                            >
                                <Settings class="w-4 h-4" />
                                Admin
                            </a>
                            <Link
                                v-else
                                href="/dashboard"
                                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                            >
                                <LayoutDashboard class="w-4 h-4" />
                                Dashboard
                            </Link>
                            
                            <!-- User Dropdown -->
                            <div class="relative">
                                <button
                                    @click="toggleUserDropdown"
                                    class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                                >
                                    <User class="w-4 h-4" />
                                    {{ user.name }}
                                    <ChevronDown class="w-3 h-3 transition-transform" :class="{ 'rotate-180': isUserDropdownOpen }" />
                                </button>
                                
                                <Transition
                                    enter-active-class="transition ease-out duration-100"
                                    enter-from-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95"
                                >
                                    <div
                                        v-if="isUserDropdownOpen"
                                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg py-2 z-50 border border-gray-200 dark:border-gray-700"
                                    >
                                        <a
                                            v-if="isAdmin"
                                            href="/admin"
                                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            <Settings class="w-4 h-4" />
                                            Admin Panel
                                        </a>
                                        <Link
                                            v-else
                                            href="/dashboard"
                                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            <LayoutDashboard class="w-4 h-4" />
                                            Dashboard
                                        </Link>
                                        <hr class="my-1 border-gray-200 dark:border-gray-700" />
                                        <Link
                                            href="/logout"
                                            method="post"
                                            as="button"
                                            class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            <LogOut class="w-4 h-4" />
                                            Logout
                                        </Link>
                                    </div>
                                </Transition>
                            </div>
                        </template>
                        
                        <template v-else>
                            <Link
                                href="/login"
                                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                            >
                                <LogIn class="w-4 h-4" />
                                Login
                            </Link>
                            <Link
                                href="/register"
                                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:opacity-90 transition-opacity"
                            >
                                <UserPlus class="w-4 h-4" />
                                Register
                            </Link>
                        </template>
                        
                        <!-- Theme Toggle -->
                        <button
                            @click="toggleTheme"
                            class="p-2.5 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-700 dark:text-gray-200"
                        >
                            <Moon v-if="!isDark" class="w-5 h-5" />
                            <Sun v-else class="w-5 h-5" />
                        </button>
                    </nav>
                    
                    <!-- Mobile Theme Toggle Only (menu removed - using bottom nav) -->
                    <div class="md:hidden flex items-center">
                        <button
                            @click="toggleTheme"
                            class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                        >
                            <Moon v-if="!isDark" class="w-5 h-5 text-gray-700" />
                            <Sun v-else class="w-5 h-5 text-gray-200" />
                        </button>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="flex-1" :class="{ 'pb-20': isMobile }">
            <slot />
        </main>
        
        <!-- Mobile Bottom Navigation -->
        <nav v-if="isMobile" class="fixed bottom-0 left-0 right-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg border-t border-gray-200 dark:border-gray-700 safe-area-bottom">
            <div class="flex items-center justify-around h-16 px-2">
                <template v-for="link in mobileNavLinks" :key="link.href">
                    <!-- More Button -->
                    <button
                        v-if="link.isMore"
                        @click="toggleMoreMenu"
                        class="flex flex-col items-center justify-center flex-1 h-full py-1 relative"
                        :class="showMoreMenu ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400'"
                    >
                        <div 
                            class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-200"
                            :class="showMoreMenu ? 'bg-indigo-100 dark:bg-indigo-900/50 scale-110' : 'hover:bg-gray-100 dark:hover:bg-gray-800'"
                        >
                            <component :is="link.icon" class="w-5 h-5" />
                        </div>
                        <span class="text-[10px] mt-0.5 font-medium">{{ link.name }}</span>
                    </button>
                    
                    <!-- Regular Nav Link -->
                    <Link
                        v-else
                        :href="link.href"
                        class="flex flex-col items-center justify-center flex-1 h-full py-1"
                        :class="isActiveRoute(link.href) ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400'"
                    >
                        <div 
                            class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-200"
                            :class="isActiveRoute(link.href) ? 'bg-indigo-100 dark:bg-indigo-900/50 scale-110' : 'hover:bg-gray-100 dark:hover:bg-gray-800'"
                        >
                            <component :is="link.icon" class="w-5 h-5" />
                        </div>
                        <span class="text-[10px] mt-0.5 font-medium">{{ link.name }}</span>
                    </Link>
                </template>
            </div>
            
            <!-- More Menu Popup -->
            <Transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 translate-y-4"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 translate-y-4"
            >
                <div v-if="showMoreMenu" class="absolute bottom-full left-0 right-0 mb-2 px-4">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <!-- More Menu Items -->
                        <div class="p-2 space-y-1">
                            <Link
                                v-for="item in moreMenuItems"
                                :key="item.href"
                                :href="item.href"
                                @click="closeMoreMenu"
                                :class="[
                                    'flex items-center gap-3 px-4 py-3 rounded-xl transition-colors',
                                    item.highlight 
                                        ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white' 
                                        : isActiveRoute(item.href) 
                                            ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' 
                                            : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                ]"
                            >
                                <div :class="[
                                    'w-10 h-10 rounded-xl flex items-center justify-center',
                                    item.highlight ? 'bg-white/20' : 'bg-gray-100 dark:bg-gray-700'
                                ]">
                                    <component :is="item.icon" class="w-5 h-5" />
                                </div>
                                <div class="flex-1">
                                    <span class="font-medium">{{ item.name }}</span>
                                    <span v-if="item.highlight" class="block text-xs text-white/80">Android অ্যাপ</span>
                                </div>
                            </Link>
                        </div>
                        
                        <!-- Auth Section in More Menu -->
                        <div class="border-t border-gray-200 dark:border-gray-700 p-2">
                            <template v-if="user">
                                <a
                                    v-if="isAdmin"
                                    href="/admin"
                                    @click="closeMoreMenu"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                >
                                    <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                                        <Settings class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                    </div>
                                    <div>
                                        <span class="font-medium block">{{ user.name }}</span>
                                        <span class="text-xs text-gray-500">Admin Panel</span>
                                    </div>
                                </a>
                                <Link
                                    v-else
                                    href="/dashboard"
                                    @click="closeMoreMenu"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                >
                                    <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                                        <LayoutDashboard class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                    </div>
                                    <div>
                                        <span class="font-medium block">{{ user.name }}</span>
                                        <span class="text-xs text-gray-500">Dashboard</span>
                                    </div>
                                </Link>
                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    @click="closeMoreMenu"
                                    class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                >
                                    <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                        <LogOut class="w-5 h-5" />
                                    </div>
                                    <span class="font-medium">লগআউট</span>
                                </Link>
                            </template>
                            <template v-else>
                                <Link
                                    href="/login"
                                    @click="closeMoreMenu"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                >
                                    <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        <LogIn class="w-5 h-5" />
                                    </div>
                                    <span class="font-medium">লগইন</span>
                                </Link>
                                <Link
                                    href="/register"
                                    @click="closeMoreMenu"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white transition-colors"
                                >
                                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                                        <UserPlus class="w-5 h-5" />
                                    </div>
                                    <span class="font-medium">রেজিস্টার</span>
                                </Link>
                            </template>
                        </div>
                        
                        <!-- Theme Toggle -->
                        <div class="border-t border-gray-200 dark:border-gray-700 p-2">
                            <button
                                @click="toggleTheme"
                                class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            >
                                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <Moon v-if="!isDark" class="w-5 h-5" />
                                    <Sun v-else class="w-5 h-5" />
                                </div>
                                <span class="font-medium">{{ isDark ? 'লাইট মোড' : 'ডার্ক মোড' }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
            
            <!-- Backdrop for More Menu -->
            <div 
                v-if="showMoreMenu" 
                @click="closeMoreMenu"
                class="fixed inset-0 -z-10"
            ></div>
        </nav>
        
        <!-- Desktop Footer -->
        <footer v-if="!isMobile" class="bg-gradient-to-r from-indigo-900 to-purple-900 text-white py-12 mt-auto">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Brand -->
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="bg-white text-indigo-600 w-10 h-10 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <Shield class="w-5 h-5" />
                            </div>
                            <div class="text-xl font-bold">
                                <span class="text-white">Fraud</span>
                                <span class="text-yellow-400">Shield</span>
                            </div>
                        </div>
                        <p class="text-sm text-indigo-200 mb-4">
                            উন্নত ফ্রড ডিটেকশন সিস্টেম কুরিয়ার সেবার জন্য। আপনার ব্যবসাকে সম্ভাব্য ফ্রড থেকে রক্ষা করুন।
                        </p>
                    </div>
                    
                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">দ্রুত লিংক</h3>
                        <ul class="space-y-2">
                            <li><Link href="/" class="text-indigo-200 hover:text-white transition">হোম</Link></li>
                            <li><Link href="/about" class="text-indigo-200 hover:text-white transition">আমাদের সম্পর্কে</Link></li>
                            <li><Link href="/download" class="text-indigo-200 hover:text-white transition">অ্যাপ ডাউনলোড</Link></li>
                            <li><Link href="/pricing" class="text-indigo-200 hover:text-white transition">প্রাইসিং</Link></li>
                        </ul>
                    </div>
                    
                    <!-- Resources -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">রিসোর্স</h3>
                        <ul class="space-y-2">
                            <li><Link href="/api/documentation" class="text-indigo-200 hover:text-white transition">API ডকুমেন্টেশন</Link></li>
                            <li><a href="#" class="text-indigo-200 hover:text-white transition">সাহায্য</a></li>
                            <li><a href="#" class="text-indigo-200 hover:text-white transition">ব্লগ</a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">যোগাযোগ</h3>
                        <ul class="space-y-2 text-indigo-200">
                            <li>ঢাকা, বাংলাদেশ</li>
                            <li>info@fraudshieldbd.site</li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-indigo-800 mt-8 pt-8 text-center text-sm text-indigo-300">
                    <p>© {{ new Date().getFullYear() }} FraudShield. All rights reserved.</p>
                    <p class="mt-1">Powered by <a href="https://tyrodevs.com" class="text-yellow-400 hover:text-yellow-300 transition">Tyrodevs</a></p>
                </div>
            </div>
        </footer>
        
        <!-- Mobile Footer (above bottom nav) -->
        <div v-if="isMobile" class="bg-gradient-to-r from-indigo-900 to-purple-900 text-white pb-20">
            <!-- App Download Banner - Compact -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-3 py-2">
                <Link href="/download" class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <Download class="w-4 h-4 text-white" />
                        </div>
                        <div>
                            <p class="font-semibold text-white text-xs leading-tight">অ্যাপ ডাউনলোড করুন</p>
                            <p class="text-[9px] text-white/70">Android অ্যাপ</p>
                        </div>
                    </div>
                    <div class="bg-white text-green-600 px-2.5 py-1 rounded-md font-bold text-[10px]">
                        ডাউনলোড
                    </div>
                </Link>
            </div>
            
            <!-- Mobile Footer Content - Compact -->
            <div class="px-4 py-4">
                <!-- Brand -->
                <div class="flex items-center justify-center mb-2">
                    <div class="bg-white text-indigo-600 w-8 h-8 rounded-lg flex items-center justify-center mr-2 shadow-lg">
                        <Shield class="w-4 h-4" />
                    </div>
                    <div class="text-lg font-bold">
                        <span class="text-white">Fraud</span>
                        <span class="text-yellow-400">Shield</span>
                    </div>
                </div>
                
                <p class="text-center text-xs text-indigo-200 mb-3">
                    উন্নত ফ্রড ডিটেকশন সিস্টেম কুরিয়ার সেবার জন্য
                </p>
                
                <!-- Quick Links (Horizontal) -->
                <div class="flex flex-wrap justify-center gap-2 mb-3">
                    <Link href="/" class="text-[10px] text-indigo-200 hover:text-white transition px-2 py-1 bg-white/10 rounded-full">হোম</Link>
                    <Link href="/about" class="text-[10px] text-indigo-200 hover:text-white transition px-2 py-1 bg-white/10 rounded-full">আমাদের সম্পর্কে</Link>
                    <Link href="/pricing" class="text-[10px] text-indigo-200 hover:text-white transition px-2 py-1 bg-white/10 rounded-full">প্রাইসিং</Link>
                    <Link href="/api/documentation" class="text-[10px] text-indigo-200 hover:text-white transition px-2 py-1 bg-white/10 rounded-full">API</Link>
                </div>
                
                <!-- Contact & Copyright Combined -->
                <div class="text-center text-[10px] text-indigo-400">
                    <p>info@fraudshieldbd.site</p>
                    <p class="mt-1">© {{ new Date().getFullYear() }} FraudShield | <a href="https://tyrodevs.com" class="text-yellow-400">Tyrodevs</a></p>
                </div>
            </div>
        </div>
    </div>
</template>
