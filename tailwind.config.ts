import type { Config } from 'tailwindcss';

export default <Config>{
     content: [
          './components/**/*.{vue,js}',
          './layouts/**/*.vue',
          './pages/**/*.vue',
          './app.vue',
          './nuxt.config.ts',
     ],
     theme: {
          extend: {},
     },
     plugins: [],
};
