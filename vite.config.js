import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/scss/app.scss'
            ],
            refresh: [
                'resources/views/**',
                'app/**',
                'routes/**',
                'lang/**',
            ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, './resources/js'),
            '~bootstrap': resolve(__dirname, 'node_modules/bootstrap'),
            'vue': 'vue/dist/vue.esm-bundler.js', // Adicionar para melhor compatibilidade
        },
    },
    server: {
        host: 'localhost',
        port: 3000,
        hmr: {
            host: 'localhost',
            protocol: 'ws'
        },
        watch: {
            usePolling: true,
        },
        cors: true,
        origin: 'http://localhost:3000'
    },
    build: {
        outDir: 'public/build',
        manifest: true,
        emptyOutDir: true,
        rollupOptions: {
            input: {
                app: resolve(__dirname, 'resources/js/app.js'),
                styles: resolve(__dirname, 'resources/scss/app.scss'),
            },
            output: {
                manualChunks: {
                    'vendor': ['vue', 'bootstrap']
                }
            }
        },
    },
    optimizeDeps: {
        include: ['bootstrap', 'vue'],
        exclude: ['laravel-vite-plugin']
    }
});