<script setup lang="ts">
import { MoonIcon, SunIcon } from '@heroicons/vue/24/outline';
import { onMounted, ref } from 'vue';

// const colors = ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#a78bfa'];
const colors = [
     '#ef4444', // red-500
     '#eab308', // yellow-500
     '#10b981', // green-500
     '#3b82f6', // blue-500
     '#8b5cf6', // purple-500
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
          subtitle: 'Interactive tools for equine genetics enthusiasts',
          image: '/imgs/example-breedingroller.png',
          link: 'https://arpg.abature.studio/breeding-roller',
          stack: ['JavaScript', 'CSS', 'Node.js'],
          description:
               'Client project delivering automated rollers for ARPG players and admins, built with JavaScript and CSS for seamless interaction.',
     },
     {
          title: 'Rattlesnake Mountain',
          subtitle: 'Interactive ARPG world',
          image: '/imgs/example-rattlesnakemountain.png',
          link: 'https://rattlesnakemountain.abature.studio',
          stack: ['Vue', 'Tailwind', 'Laravel'],
          description:
               'Current client project migrating an ARPG world to a new platform using Vue 3 and TailwindCSS, featuring a custom CMS, rollers, and admin tools.',
     },
     {
          title: 'Merakis Activity Roller',
          subtitle: 'Automated roller inspired by Pokémon encounters',
          image: '/imgs/example-merakisactivityroller.png',
          link: 'https://github.com/PSNapier/merakis-activity-roller',
          stack: ['JavaScript', 'CSS'],
          description:
               'Client project implementing an automated system for Pokémon-style encounters, crafted with JavaScript and CSS.',
     },
     {
          title: 'Sigil Maker',
          subtitle: 'A tool that automatically designs sigils',
          image: '/imgs/example-sigilmaker.png',
          link: 'https://sigilmaker.abature.studio/',
          stack: ['JavaScript', 'ChatGPT'],
          description:
               'A fun side project created with ChatGPT that generates custom sigils from user input.',
     },
     {
          title: 'Portfolio Website',
          subtitle: 'Personal branding & project showcase',
          image: '/imgs/example-youarehere.jpg',
          link: '',
          stack: ['Vue', 'TailwindCSS', 'ChatGPT'],
          description:
               'You are here! 😄 Built with Vue 3, TailwindCSS, and ChatGPT, featuring a customizable theme for extra flair.',
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
               class="relative flex min-h-[340px] max-w-[820px] flex-col overflow-hidden px-4">
               <div
                    class="font-jetbrains-mono color-animate relative z-10 mt-20 min-h-[90px] text-7xl leading-tight font-bold transition-colors">
                    <span
                         class="underline-animate color-animate pb-4 transition-colors"
                         :style="{
                              '--accent-color': selectedColor,
                              color: selectedColor,
                         }">
                         Abature Studio
                    </span>
               </div>
               <div
                    class="font-inter color-animate relative z-10 mt-4 min-h-[60px] text-2xl leading-snug transition-colors">
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
                              class="font-jetbrains-mono group color-animate text-3xl font-bold transition-colors"
                              :style="{ color: selectedColor }">
                              <span
                                   class="underline-animate color-animate transition-colors"
                                   :style="{
                                        '--accent-color': selectedColor,
                                        color: selectedColor,
                                   }">
                                   {{ project.title }}
                              </span>
                         </h2>
                         <h3
                              class="color-animate text-lg font-semibold transition-colors"
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
                                   class="color-animate rounded bg-neutral-200 px-2 py-1 font-mono text-xs text-neutral-700 transition-colors transition-transform hover:scale-105">
                                   {{ tech }}
                              </span>
                         </div>
                         <p
                              :class="
                                   isDark
                                        ? 'text-neutral-200'
                                        : 'text-neutral-800'
                              "
                              class="color-animate text-base transition-colors">
                              {{ project.description }}
                         </p>
                         <div
                              v-if="project.link"
                              class="mt-2">
                              <a
                                   :href="project.link"
                                   target="_blank"
                                   rel="noopener"
                                   class="color-animate inline-block text-sm font-semibold underline underline-offset-4 transition transition-colors hover:scale-105"
                                   :style="{ color: selectedColor }">
                                   View Project &rarr;
                              </a>
                         </div>
                    </div>
               </div>
          </section>

          <section
               class="color-animate mt-16 flex w-full justify-center transition-colors"
               :style="{
                    backgroundColor: selectedColor,
                    color: isDark ? '#171717' : '#fafafa',
               }">
               <div class="mx-auto w-full max-w-[820px] px-4 py-16 text-center">
                    <h2
                         class="font-jetbrains-mono color-animate mb-2 text-3xl font-bold transition-colors">
                         Contact Me
                    </h2>
                    <p
                         class="font-inter color-animate text-lg transition-colors">
                         Interested in comissioning a project or hiring me?<br />Email
                         me your qeuestions and inquiries at
                         <a
                              href="mailto:AbatureStudio@gmail.com?subject=Web%20Dev%20Inquiry"
                              class="color-animate underline underline-offset-2 transition transition-colors hover:opacity-50"
                              :style="{
                                   color: isDark ? '#171717' : '#fafafa',
                              }">
                              AbatureStudio@gmail.com
                         </a>
                    </p>
               </div>
          </section>

          <footer
               class="color-animate mt-10 mb-4 flex w-full justify-center text-center text-sm text-neutral-500 transition-colors">
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
     background: var(--accent-color, #f87171);
     border-radius: 999px;
     transition: background 0.3s;
     z-index: -1;
}

.color-animate {
     transition: color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
