import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/apps/auth/login.js',
                'resources/js/apps/user/user.js',
                'resources/js/apps/candidate/candidate.js',
            ],
            refresh: true,
        }),
    ],
});
