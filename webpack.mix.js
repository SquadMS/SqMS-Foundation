const mix = require('laravel-mix');
const fs = require('fs');

/* Remove old build and restore required file structure */
if (fs.existsSync('public')) {
    fs.rmdirSync('public', { recursive: true });

    fs.mkdirSync('public');
    fs.mkdirSync('public/images');
}

/* Configure the public path */
mix.setPublicPath('public');

mix.setResourceRoot('/themes/sqms-foundation');

const postCssptions = [
    require('postcss-import'),
    require('tailwindcss')('./tailwind.config.js'),
    require('autoprefixer'),
]

/* Build SCSS/JS assets */
mix
/* Admin assets */
.sass('resources/scss/sqms.scss', 'public/css')
.options({
    postCss: postCssptions,
})

.js('resources/js/webp.js', 'public/js')

.version();

/* Copy static images */
mix.copyDirectory('resources/images/static', 'public/static-images');