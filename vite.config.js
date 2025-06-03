import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/apps/auth/login.js',
                'resources/js/apps/utils/helper.js',
                'resources/js/apps/auth/register.js',
                'resources/js/apps/user/user.js',
                'resources/js/apps/conversion/conversion.js',
                'resources/js/apps/mechanical/mechanical.js',
                'resources/js/apps/equipment/equipment.js',
                'resources/js/apps/certificate/certificate.js',
                'resources/js/apps/test-letter/test_letter.js',
                'resources/js/apps/test-letter/spu.js',
                'resources/js/apps/test-letter/certificate.js',
                'resources/js/apps/test-letter/permohonan-srut.js',
                'resources/js/apps/template-certificate/template.js',
            ],
            refresh: true,
        }),
    ],
});
