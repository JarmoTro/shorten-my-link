import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/scss/global.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
