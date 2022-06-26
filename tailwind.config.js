const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    prefix: 'sqmsf-',
    content: [
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('tailwindcss-rtl')
    ],
};