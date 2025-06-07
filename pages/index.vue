<!-- eslint-disable vue/multi-word-component-names -->
<script setup lang="ts">
import { MoonIcon, SunIcon } from '@heroicons/vue/24/outline';
import { onMounted, ref } from 'vue';

useHead({
     title: 'Abature Studio',
     link: [
          {
               rel: 'icon',
               type: 'image/svg+xml',
               href: 'data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌈</text></svg>',
          },
     ],
});

const colors = [
     '#f87171',
     '#fbbf24',
     '#34d399',
     '#60a5fa',
     '#a78bfa',
];
const selectedColor = ref(colors[0]);
const isDark = ref(false);

onMounted(() => {
     if (
          window.matchMedia &&
          window.matchMedia('(prefers-color-scheme: dark)').matches
     ) {
          isDark.value = true;
     }
});

const projects = [
     {
          title: 'ARPG Roller Demos',
          subtitle: 'Demos for equine genetics enthusiasts',
          image: 'imgs/example-breedingroller.png',
          link: 'https://arpg.abature.studio/breeding-roller',
          stack: ['JavaScript', 'CSS', 'Node.js'],
          description:
               'A set of userful, interactive demos showcasing my automated rollers for ARPG players and admin, built with JavaScript and CSS.',
     },
     {
          title: 'Rattlesnake Mountain',
          subtitle: 'Interactive ARPG world',
          image: 'imgs/example-rattlesnakemountain.png',
          link: 'https://rattlesnakemountain.abature.studio',
          stack: ['Vue', 'Tailwind', 'Laravel'],
          description:
               'One of my latest projects which is still in development, a client project transferring an ARPG world to a new platform with Vue 3 and TailwindCSS, which will feature a custom CMS, rollers and admin tools.',
     },

     {
          title: 'Merakis Activity Roller',
          subtitle: 'A automated roller inspired by Pokémon encounters',
          image: 'imgs/example-merakisactivityroller.png',
          link: 'https://github.com/PSNapier/merakis-activity-roller',
          stack: ['JavaScript', 'CSS'],
          description:
               'A client project implementing an automated solution for rolling their Pokémon-style encounters, built with JavaScript and CSS.',
     },
     {
          title: 'Sigil Maker',
          subtitle: 'A tool that automatically designs sigils',
          image: 'imgs/example-sigilmaker.png',
          link: 'https://sigilmaker.abature.studio/',
          stack: ['JavaScript', 'ChatGPT'],
          description:
               'A fun little side project I created with the help of ChatGPT, which generates sigils based on user input.',
     },
     {
          title: 'Portfolio Website',
          subtitle: 'Personal branding & project showcase',
          image: 'imgs/example-youarehere.jpg',
          link: '',
          stack: ['Vue', 'TailwindCSS', 'ChatGPT'],
          description:
               'You are here! 😄 Built with Vue 3, TailwindCSS and ChatGPT, featuring a customizable theme for the extra pizazz.',
     },
];
</script>

<template class="bg-neutral-50">
     <main
          :class="[
               'f-full flex min-h-screen cursor-default flex-col items-center transition-colors duration-300',
               isDark
                    ? 'bg-neutral-900 text-neutral-50'
                    : 'bg-neutral-50 text-neutral-900',
          ]">
          <div
               class="fixed top-3 right-3 z-30 flex items-center gap-2 sm:top-6 sm:right-8 sm:gap-3">
               <div
                    v-for="(color, idx) in colors"
                    :key="idx"
                    :style="{ backgroundColor: color }"
                    class="h-4 w-4 cursor-pointer rounded-full transition-transform duration-200 hover:scale-125"
                    @click="selectedColor = color" />
               <!-- Theme toggle button -->
               <button
                    class="ml-2 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full transition-colors transition-transform duration-200 hover:scale-125 sm:ml-4 dark:border-neutral-700"
                    :class="
                         isDark
                              ? 'bg-neutral-50'
                              : 'bg-white dark:bg-neutral-800'
                    "
                    :aria-label="
                         isDark ? 'Switch to light mode' : 'Switch to dark mode'
                    "
                    @click="isDark = !isDark">
                    <component
                         :is="isDark ? SunIcon : MoonIcon"
                         :class="'h-5 w-5'"
                         :style="{ color: selectedColor }" />
               </button>
          </div>
          <section
               class="relative flex min-h-[300px] max-w-[820px] flex-col overflow-hidden px-4">
               <div
                    class="font-jetbrains-mono relative z-10 mt-20 text-7xl font-bold">
                    <span
                         class="underline-animate pb-4"
                         :style="{ '--underline-color': selectedColor }">
                         Abature Studio
                    </span>
               </div>
               <div class="font-inter relative z-10 mt-4 text-2xl">
                    I craft clean, functional websites for artists, small
                    businesses, and odd little corners of the internet. Built
                    with Tailwind, Laravel, and JavaScript—always fast,
                    responsive, and a little bit off the beaten path.
               </div>
          </section>

          <section class="mx-auto mt-10 w-full max-w-4xl space-y-16 px-4">
               <div
                    v-for="(project, idx) in projects"
                    :key="idx"
                    class="flex flex-col items-start gap-8 md:flex-row">
                    <!-- Image -->
                    <a
                         :href="project.link"
                         target="_blank"
                         rel="noopener"
                         class="block w-full overflow-hidden rounded-lg shadow-lg transition-transform hover:scale-105 md:w-1/2">
                         <img
                              :src="project.image"
                              :alt="project.title"
                              class="h-auto w-full max-w-full rounded bg-neutral-100 object-contain" />
                    </a>
                    <!-- Text -->
                    <div class="flex w-full flex-col gap-1 md:w-1/2">
                         <h2
                              class="font-jetbrains-mono group color-animate text-3xl font-bold"
                              :style="{ color: selectedColor }">
                              <span
                                   class="underline-animate"
                                   :style="{
                                        '--underline-color': selectedColor,
                                   }">
                                   {{ project.title }}
                              </span>
                         </h2>
                         <h3
                              class="text-lg font-semibold"
                              :class="
                                   isDark
                                        ? 'text-neutral-300'
                                        : 'text-neutral-600'
                              ">
                              {{ project.subtitle }}
                         </h3>
                         <div class="my-2 flex flex-wrap gap-2">
                              <span
                                   v-for="(tech, tIdx) in project.stack"
                                   :key="tIdx"
                                   class="rounded bg-neutral-200 px-2 py-1 font-mono text-xs text-neutral-700">
                                   {{ tech }}
                              </span>
                         </div>
                         <p
                              :class="
                                   isDark
                                        ? 'text-neutral-200'
                                        : 'text-neutral-800'
                              "
                              class="text-base">
                              {{ project.description }}
                         </p>
                         <div class="mt-2">
                              <a
                                   :href="project.link"
                                   target="_blank"
                                   rel="noopener"
                                   class="inline-block text-sm font-semibold underline underline-offset-4 transition hover:scale-105"
                                   :style="{ color: selectedColor }">
                                   View Project &rarr;
                              </a>
                         </div>
                    </div>
               </div>
          </section>

          <section
               class="mt-16 flex w-full justify-center"
               :style="{
                    backgroundColor: selectedColor,
                    color: isDark ? '#18181b' : '#fff',
               }">
               <div class="mx-auto w-full max-w-[820px] px-4 py-16 text-center">
                    <h2 class="font-jetbrains-mono mb-2 text-3xl font-bold">
                         Contact Me
                    </h2>
                    <p class="font-inter text-lg">
                         Interested in comissioning a project or hiring me?<br />Email
                         me your qeuestions and inquiries at
                         <a
                              href="mailto:AbatureStudio@gmail.com?subject=Web%20Dev%20Inquiry"
                              class="underline underline-offset-2 transition hover:opacity-50">
                              AbatureStudio@gmail.com
                         </a>
                    </p>
               </div>
          </section>

          <footer
               class="mt-16 mb-4 flex w-full justify-center text-center text-sm text-neutral-500">
               &copy; Abature Studio {{ new Date().getFullYear() }}
          </footer>
     </main>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');

.font-jetbrains-mono {
     font-family: 'JetBrains Mono', monospace;
}
.font-inter {
     font-family: 'Inter', sans-serif;
}

.underline-animate {
     position: relative;
     display: inline-block;
}
.underline-animate::after {
     content: '';
     position: absolute;
     left: 0;
     bottom: 0.1em;
     width: 100%;
     height: 0.07em;
     background: var(--underline-color, #f87171);
     border-radius: 999px;
     transition: background 0.3s;
     z-index: -1;
}

.color-animate {
     transition: color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
