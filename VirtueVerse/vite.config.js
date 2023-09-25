import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/authors/author.js', 'resources/js/shared/regexHelper.js'],
            refresh: true,
        }),
        tailwindcss('./tailwind.config.js'),
    ],
    build: {
        outDir: './public/build',
    },
});
