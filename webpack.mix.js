const mix = require('laravel-mix');
const fs = require('fs');

/* Remove old build and restore required file structure */
if (fs.existsSync('resources/dist')) {
    fs.rmdirSync('resources/dist', { recursive: true });

    fs.mkdirSync('resources/dist');
    fs.mkdirSync('resources/dist/images');
}

/* Configure the public path */
mix.setPublicPath('resources/dist');

mix.setResourceRoot('/themes/sqms-foundation');

const postCssptions = [
    require('postcss-import'),
    require('tailwindcss')('./tailwind.config.js'),
    require('autoprefixer'),
]

/* Build SCSS/JS assets */
mix
/* Admin assets */
.sass('resources/scss/sqms.scss', 'resources/dist/css')
.options({
    postCss: postCssptions,
})
.sass('resources/scss/flag-icons.scss', 'resources/dist/css')

.js('resources/js/webp.js', 'resources/dist/js')

.version();

/* Copy static images */
mix.copyDirectory('resources/images/static', 'resources/dist/static-images');