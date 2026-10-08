import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Both faces are loaded in layouts/app.blade.php and layouts/guest.blade.php.
                // Before this mapping existed `font-serif` fell through to Georgia and
                // `font-sans` pointed at Figtree, which was never loaded at all.
                sans: ['Lato', ...defaultTheme.fontFamily.sans],
                serif: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                // Reverted to the site's original green (#1a2e2a) by request, after the
                // logo-matched green (#205B21) had been in place. brand-hover is derived
                // from THIS colour's own hue (168deg) rather than the logo's (121deg), so
                // hover still reads as "the same green, lit up" instead of a hue jump.
                'brand-green': '#1a2e2a',
                'brand-hover': '#2c4e47',  // lift for hover/press states, same hue as brand-green.
                'brand-orange': '#fe7f02',  // the logo's own orange. Fills, and text on dark grounds (5.6:1 on brand-green).
                'brand-ember': '#A25201',  // orange as text on light grounds (5.3:1). brand-orange there is 2.7:1.
                'brand-cream': '#F5F5DC',  // ink on dark surfaces. Matches the logo's light variant.
                'brand-light': '#FAF9F6',  // page and section grounds.
                'whatsapp': '#25D366',  // WhatsApp's own brand green -- not ours, but fixed by them.
                'whatsapp-dark': '#1DA851',
            },
        },
    },

    plugins: [forms],
};
