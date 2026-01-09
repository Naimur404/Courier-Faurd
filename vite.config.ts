import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, './resources/js'),
        },
    },
    ssr: {
        noExternal: ['@inertiajs/vue3'],
    },
    build: {
        // Enable minification for production builds
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
            mangle: true,
            format: {
                comments: false,
            },
        },
        // Split chunks for better caching and lazy loading
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        // Core Vue framework - keep small
                        if (id.includes('vue') || id.includes('@inertiajs')) {
                            return 'vendor';
                        }
                        // Chart.js - lazy loaded only when needed
                        if (id.includes('chart.js')) {
                            return 'chart';
                        }
                        // Lucide icons - used across app
                        if (id.includes('lucide-vue-next')) {
                            return 'icons';
                        }
                    }
                },
            },
        },
    },
});
