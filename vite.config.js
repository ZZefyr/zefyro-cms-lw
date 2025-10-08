import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'core/Resources/assets/css/tailwind.css',
                'core/Resources/assets/css/app.scss',
                'core/Resources/assets/js/app.js'
            ],
            refresh: true,
        }),
    ],
    // css: {
    //     preprocessorOptions: {
    //         scss: {
    //             additionalData: `@import "./core/Resources/assets/scss/_variables.scss";`
    //         }
    //     }
    // }
});
