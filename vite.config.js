import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import fs from 'fs'

export default defineConfig({
    server:{
        host: 'pregao.test',
        port: 5173,
        https:{
            key:fs.readFileSync('C:/laragon/etc/ssl/laragon.key'),
            cert: fs.readFileSync('C:/laragon/etc/ssl/laragon.crt'),
        },
    },
    plugins: [
        laravel({
      //      input: 'resources/js/app.js',
            input: ['resources/js/main.js'],
            refresh: true,
        }),
        vue(),
    ],
})
