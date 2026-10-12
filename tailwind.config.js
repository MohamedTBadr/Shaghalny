import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/**
 * Shaghalny Design System — centralized tokens.
 *
 * All visual decisions (color, type, space, radius, elevation, motion) are
 * defined here so the entire product can be re-themed from a single source.
 * Semantic names are preferred over raw values in markup.
 */

/**
 * Semantic color tokens are backed by CSS custom properties (RGB channels),
 * so the entire palette can be re-themed at runtime by toggling the `dark`
 * class on the <html> element. Numeric brand shades remain static.
 */
const token = (name) => `rgb(var(--${name}) / <alpha-value>)`;

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        // ---------------------------------------------------------------- Breakpoints
        screens: {
            xs: '400px',
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
            '2xl': '1440px',
            '3xl': '1680px',
        },

        extend: {
            // ------------------------------------------------------------- Color
            colors: {
                brand: {
                    50: token('brand-50'),
                    100: token('brand-100'),
                    200: '#C7D2FE',
                    300: '#A5B4FC',
                    400: '#818CF8',
                    500: '#3157D5',
                    600: '#2546B5',
                    700: '#1E3A8A',
                    800: '#172554',
                    900: '#0F172A',
                    DEFAULT: token('brand'),
                    hover: token('brand-hover'),
                    subtle: token('brand-subtle'),
                },
                surface: {
                    DEFAULT: token('surface'),
                    card: token('surface-card'),
                    subtle: token('surface-subtle'),
                    muted: token('surface-muted'),
                    sunken: token('surface-sunken'),
                    dark: '#0F131D',
                    cardDark: '#161B26',
                },
                ink: {
                    primary: token('ink-primary'),
                    secondary: token('ink-secondary'),
                    muted: token('ink-muted'),
                    light: token('ink-light'),
                    inverse: token('ink-inverse'),
                },
                border: {
                    DEFAULT: token('border-default'),
                    subtle: token('border-subtle'),
                    strong: token('border-strong'),
                },
                accent: {
                    success: token('accent-success'),
                    'success-subtle': token('accent-success-subtle'),
                    'success-strong': token('accent-success-strong'),
                    warning: token('accent-warning'),
                    'warning-subtle': token('accent-warning-subtle'),
                    'warning-strong': token('accent-warning-strong'),
                    danger: token('accent-danger'),
                    'danger-subtle': token('accent-danger-subtle'),
                    'danger-strong': token('accent-danger-strong'),
                    info: token('accent-info'),
                    'info-subtle': token('accent-info-subtle'),
                    'info-strong': token('accent-info-strong'),
                    contrast: token('accent-contrast'),
                },
                sidebar: token('sidebar'),
                canvas: token('canvas'),
            },

            // --------------------------------------------------------- Typography
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                display: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },
            fontSize: {
                // [size, { lineHeight, letterSpacing }] — semantic type scale
                'display-lg': ['3.5rem', { lineHeight: '1.05', letterSpacing: '-0.03em' }],
                'display': ['2.75rem', { lineHeight: '1.08', letterSpacing: '-0.03em' }],
                'display-sm': ['2.25rem', { lineHeight: '1.12', letterSpacing: '-0.025em' }],
                'heading-page': ['1.75rem', { lineHeight: '1.2', letterSpacing: '-0.02em' }],
                'heading-section': ['1.375rem', { lineHeight: '1.25', letterSpacing: '-0.02em' }],
                'heading-card': ['1.0625rem', { lineHeight: '1.35', letterSpacing: '-0.01em' }],
                'body-lg': ['1.0625rem', { lineHeight: '1.6' }],
                'body': ['0.9375rem', { lineHeight: '1.6' }],
                'body-sm': ['0.875rem', { lineHeight: '1.55' }],
                'label': ['0.8125rem', { lineHeight: '1.4', letterSpacing: '0.01em' }],
                'caption': ['0.75rem', { lineHeight: '1.45' }],
                'meta': ['0.6875rem', { lineHeight: '1.4', letterSpacing: '0.02em' }],
                'overline': ['0.6875rem', { lineHeight: '1.2', letterSpacing: '0.08em' }],
            },
            fontWeight: {
                regular: '400',
                medium: '500',
                semibold: '600',
                bold: '700',
                extrabold: '800',
            },

            // --------------------------------------------------------- Dimensions
            maxWidth: {
                'content': '72rem',      // marketing / editorial
                'search': '80rem',       // search results
                'form': '42rem',         // forms
                'readable': '42rem',     // prose
                'dashboard': '84rem',    // dashboards
                'narrow': '32rem',       // auth / confirmation
            },
            spacing: {
                '4.5': '1.125rem',
                '13': '3.25rem',
                '15': '3.75rem',
                '18': '4.5rem',
                '22': '5.5rem',
                '30': '7.5rem',
                'header': '4rem',
                'sidebar': '16.5rem',
            },
            zIndex: {
                base: '0',
                raised: '10',
                sticky: '30',
                header: '40',
                drawer: '45',
                overlay: '50',
                modal: '60',
                dropdown: '70',
                toast: '80',
            },
            borderRadius: {
                none: '0',
                xs: '0.25rem',
                sm: '0.375rem',
                DEFAULT: '0.625rem',
                md: '0.625rem',
                lg: '0.75rem',
                xl: '0.875rem',
                '2xl': '1rem',
                '3xl': '1.25rem',
                full: '9999px',
            },
            borderWidth: {
                DEFAULT: '1px',
                '0': '0',
                '2': '2px',
            },

            // ----------------------------------------------------------- Elevation
            boxShadow: {
                none: 'none',
                subtle: '0 1px 2px 0 rgba(16, 24, 40, 0.04)',
                card: '0 1px 3px 0 rgba(16, 24, 40, 0.06), 0 1px 2px -1px rgba(16, 24, 40, 0.04)',
                'card-hover': '0 12px 24px -4px rgba(16, 24, 40, 0.10), 0 4px 8px -2px rgba(16, 24, 40, 0.04)',
                elevated: '0 4px 12px -2px rgba(16, 24, 40, 0.08), 0 2px 4px -2px rgba(16, 24, 40, 0.04)',
                dropdown: '0 10px 30px -4px rgba(16, 24, 40, 0.14), 0 4px 10px -2px rgba(16, 24, 40, 0.06)',
                modal: '0 24px 60px -12px rgba(16, 24, 40, 0.24)',
                focus: '0 0 0 3px rgba(49, 87, 213, 0.28)',
            },

            // -------------------------------------------------------------- Motion
            transitionDuration: {
                instant: '80ms',
                fast: '150ms',
                DEFAULT: '200ms',
                slow: '320ms',
                deliberate: '480ms',
            },
            transitionTimingFunction: {
                standard: 'cubic-bezier(0.2, 0, 0, 1)',
                entrance: 'cubic-bezier(0.16, 1, 0.3, 1)',
                exit: 'cubic-bezier(0.4, 0, 1, 1)',
            },
            keyframes: {
                'fade-in': {
                    from: { opacity: '0' },
                    to: { opacity: '1' },
                },
                'slide-up': {
                    from: { opacity: '0', transform: 'translateY(8px)' },
                    to: { opacity: '1', transform: 'translateY(0)' },
                },
                'toast-in': {
                    from: { opacity: '0', transform: 'translateY(12px) scale(0.98)' },
                    to: { opacity: '1', transform: 'translateY(0) scale(1)' },
                },
                shimmer: {
                    '100%': { transform: 'translateX(100%)' },
                },
                spin: {
                    to: { transform: 'rotate(360deg)' },
                },
            },
            animation: {
                'fade-in': 'fade-in 200ms cubic-bezier(0.2,0,0,1) both',
                'slide-up': 'slide-up 240ms cubic-bezier(0.16,1,0.3,1) both',
                'toast-in': 'toast-in 260ms cubic-bezier(0.16,1,0.3,1) both',
                shimmer: 'shimmer 1.6s infinite',
                spin: 'spin 0.7s linear infinite',
            },
        },
    },

    plugins: [forms],
};
