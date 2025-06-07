// https://nuxt.com/docs/api/configuration/nuxt-config

import tailwindcss from '@tailwindcss/vite';

export default defineNuxtConfig({
     compatibilityDate: '2025-05-15',
     devtools: { enabled: false },
     modules: ['@nuxt/eslint'],
     css: ['~/assets/css/tailwind.css'],
     vite: {
          plugins: [
               tailwindcss(),
          ],
     },
});
