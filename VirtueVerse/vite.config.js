import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/customSelectize.css', 
                'resources/js/app.js', 
                'resources/js/**/*.js'
            ],
            refresh: true,
        }),
        tailwindcss('./tailwind.config.js'),
        vue({ 
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        outDir: './public/build',
    },
    resolve: { 
        alias: { 
            util: "util/",
            vue: 'vue/dist/vue.esm-bundler.js'
         } 
    },
});
