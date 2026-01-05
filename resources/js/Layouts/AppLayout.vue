<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    Shield, Home, Info, Tag, Infinity, Download, 
    Moon, Sun, Menu, X, LogIn, UserPlus, LogOut, 
    User, Settings, LayoutDashboard, ChevronDown 
} from 'lucide-vue-next';
import Toast from '@/components/ui/Toast.vue';

const page = usePage();
const isDark = ref(false);
const isMobileMenuOpen = ref(false);
const isUserDropdownOpen = ref(false);

const user = computed(() => page.props.auth?.user);
const isAdmin = computed(() => user.value?.role === 'admin');

onMounted(() => {
    // Check for saved theme preference or default to system preference
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        isDark.value = true;
        document.documentElement.classList.add('dark');
    }
});

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
                            <Link
                                v-if="isAdmin"
                                href="/admin"
                                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                            >
                                <Settings class="w-4 h-4" />
                                Admin
                            </Link>
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
                                        <Link
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
                    
                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center gap-2">
                        <button
                            @click="toggleTheme"
                            class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                        >
                            <Moon v-if="!isDark" class="w-5 h-5 text-gray-700" />
                            <Sun v-else class="w-5 h-5 text-gray-200" />
                        </button>
                        <button
                            @click="toggleMobileMenu"
                            class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                        >
                            <Menu v-if="!isMobileMenuOpen" class="w-6 h-6" />
                            <X v-else class="w-6 h-6" />
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Navigation Menu -->
                <Transition
                    enter-active-class="transition ease-out duration-200"
                    enter-from-class="opacity-0 -translate-y-2"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition ease-in duration-150"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-2"
                >
                    <nav v-if="isMobileMenuOpen" class="md:hidden mt-4 pb-4 border-t border-gray-200 dark:border-gray-700 pt-4 space-y-1">
                        <Link
                            v-for="link in navLinks"
                            :key="link.href"
                            :href="link.href"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                            @click="isMobileMenuOpen = false"
                        >
                            <component :is="link.icon" class="w-4 h-4" />
                            {{ link.name }}
                        </Link>
                        
                        <Link
                            href="/download"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                            @click="isMobileMenuOpen = false"
                        >
                            <Download class="w-4 h-4" />
                            অ্যাপ ডাউনলোড
                        </Link>
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2 space-y-1">
                            <template v-if="user">
                                <Link
                                    href="/dashboard"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                                    @click="isMobileMenuOpen = false"
                                >
                                    <LayoutDashboard class="w-4 h-4" />
                                    Dashboard
                                </Link>
                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                                >
                                    <LogOut class="w-4 h-4" />
                                    Logout
                                </Link>
                            </template>
                            <template v-else>
                                <Link
                                    href="/login"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                                    @click="isMobileMenuOpen = false"
                                >
                                    <LogIn class="w-4 h-4" />
                                    Login
                                </Link>
                                <Link
                                    href="/register"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
                                    @click="isMobileMenuOpen = false"
                                >
                                    <UserPlus class="w-4 h-4" />
                                    Register
                                </Link>
                            </template>
                        </div>
                    </nav>
                </Transition>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="flex-1">
            <slot />
        </main>
        
        <!-- Footer -->
        <footer class="bg-gradient-to-r from-indigo-900 to-purple-900 text-white py-12 mt-auto">
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
    </div>
</template>
