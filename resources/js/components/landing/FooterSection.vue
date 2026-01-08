<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Shield, CheckCircle, Clock, Lock } from 'lucide-vue-next';

const page = usePage();

const settings = computed(() => page.props.settings as {
    phone?: string;
    whatsapp?: string;
    address?: string;
    footer_text?: string;
});

const phoneNumber = computed(() => settings.value.phone || '01841414004');
const whatsappNumber = computed(() => settings.value.whatsapp || '8801841414004');
const footerText = computed(() => settings.value.footer_text || '© 2026 FraudShield — All rights reserved.');

const footerLinks = {
    product: [
        { name: 'প্রাইসিং', href: '#pricing', isSection: true },
        { name: 'ফিচারস', href: '#features', isSection: true },
        { name: 'ওয়ার্ডপ্রেস প্লাগইন', href: '#integrations', isSection: true },
    ],
    account: [
        { name: 'লগইন', href: '/login', isSection: false },
        { name: 'রেজিস্টার', href: '/register', isSection: false },
        { name: 'কন্টাক্ট', href: '#contact', isSection: true },
    ],
    legal: [
        { name: 'শর্তাবলী', href: '/terms', isSection: false },
        { name: 'গোপনীয়তা নীতি', href: '/privacy', isSection: false },
    ],
};

const handleLinkClick = (link: { href: string; isSection: boolean }, event: Event) => {
    if (!link.isSection) return; // Let default navigation happen for non-section links
    
    event.preventDefault();
    const sectionId = link.href;
    
    // Check if we're on the home page
    if (window.location.pathname === '/') {
        // Scroll to section on same page
        const element = document.querySelector(sectionId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    } else {
        // Navigate to home page with hash
        router.visit('/' + sectionId);
    }
};
</script>

<template>
    <footer class="bg-slate-950 text-white">
        <!-- Main Footer -->
        <div class="container mx-auto px-4 py-10">
            <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-12">
                <!-- Brand Column -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
                            <Shield class="w-8 h-8 text-white" />
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            FraudShield
                        </span>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed max-w-sm">
                        কুরিয়ার ইন্টেলিজেন্সের দ্রুততম প্ল্যাটফর্ম—আপনার ডাটা, আপনার নিয়ন্ত্রণ।
                    </p>
                    
                    <!-- Stats Badges -->
                    <div class="flex flex-wrap gap-3">
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/5 rounded-full border border-white/10">
                            <CheckCircle class="w-4 h-4 text-green-400" />
                            <span class="text-sm text-gray-300">99%+ এক্যুরেসি</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/5 rounded-full border border-white/10">
                            <Clock class="w-4 h-4 text-blue-400" />
                            <span class="text-sm text-gray-300">99.99% আপটাইম</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/5 rounded-full border border-white/10">
                            <Lock class="w-4 h-4 text-purple-400" />
                            <span class="text-sm text-gray-300">সুরক্ষিত সংযোগ</span>
                        </div>
                    </div>
                </div>

                <!-- Product Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">প্রোডাক্ট</h4>
                    <ul class="space-y-3">
                        <li v-for="link in footerLinks.product" :key="link.name">
                            <a 
                                :href="link.href"
                                @click="(e) => handleLinkClick(link, e)"
                                class="text-gray-400 hover:text-white transition-colors duration-300 cursor-pointer"
                            >
                                {{ link.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Account Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">অ্যাকাউন্ট</h4>
                    <ul class="space-y-3">
                        <li v-for="link in footerLinks.account" :key="link.name">
                            <a 
                                :href="link.href"
                                @click="(e) => handleLinkClick(link, e)"
                                class="text-gray-400 hover:text-white transition-colors duration-300 cursor-pointer"
                            >
                                {{ link.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Legal Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">আইনী তথ্য</h4>
                    <ul class="space-y-3">
                        <li v-for="link in footerLinks.legal" :key="link.name">
                            <a 
                                :href="link.href"
                                class="text-gray-400 hover:text-white transition-colors duration-300"
                            >
                                {{ link.name }}
                            </a>
                        </li>
                        <li>
                            <a 
                                :href="`tel:${phoneNumber}`"
                                class="text-gray-400 hover:text-white transition-colors duration-300"
                            >
                                হেল্পলাইন: {{ phoneNumber }}
                            </a>
                        </li>
                        <li v-if="settings.address">
                            <span class="text-gray-400">
                                {{ settings.address }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-white/10">
            <div class="container mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 text-sm text-center md:text-left">
                        {{ footerText }}
                    </p>
                    
                    <div class="flex items-center gap-6 text-sm text-gray-500">
                        <span>Developed by Tyrodevs</span>
                        <a 
                            :href="`https://api.whatsapp.com/send?phone=${whatsappNumber}`"
                            target="_blank"
                            class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-full hover:bg-green-500 transition-colors duration-300"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            WhatsApp Live Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
