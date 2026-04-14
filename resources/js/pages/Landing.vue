<script setup lang="ts">
import {
     ArrowDownIcon,
     ArrowTopRightOnSquareIcon,
     BookOpenIcon,
     CodeBracketIcon,
     CommandLineIcon,
     CubeTransparentIcon,
     MoonIcon,
     NewspaperIcon,
     ServerStackIcon,
     SunIcon,
     SwatchIcon,
} from '@heroicons/vue/24/outline';
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';

interface ProjectExtraImage {
     src: string;
     alt: string;
}

interface Project {
     title: string;
     subtitle: string;
     image: string;
     link: string;
     stack: string[];
     description: string;
     ctaText?: string;
     extraImages?: ProjectExtraImage[];
}

// R Y G B V (left→right); soft/vivid same index for theme toggle mapping
const colorsSoft = ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#a78bfa'];
const colorsVivid = [
     '#ef4444', // red-500
     '#eab308', // yellow-500
     '#10b981', // green-500
     '#3b82f6', // blue-500
     '#8b5cf6', // purple-500
];
const isDark = ref(false);
let colors = isDark.value ? colorsSoft : colorsVivid;
const selectedColor = ref(colorsVivid[3]); // default accent: blue

watch(isDark, (val) => {
     const prevColors = val ? colorsVivid : colorsSoft;
     const newColors = val ? colorsSoft : colorsVivid;
     const idx = prevColors.indexOf(selectedColor.value);
     colors = newColors;
     selectedColor.value = newColors[idx >= 0 ? idx : 0];
});

/** Pixels of scroll over which fixed controls fade out (examples CTA + theme bar) */
const SCROLL_FADE_DISTANCE = 200;

const scrollY = ref(0);

/** Scroll target for the projects list (button + optional URL #projects) */
const projectsSectionRef = ref<HTMLElement | null>(null);

/** Shared scroll fade (examples CTA + accent / theme controls) */
const scrollFadeOpacity = computed(() => {
     const y = scrollY.value;
     return Math.max(0, Math.min(1, 1 - y / SCROLL_FADE_DISTANCE));
});

function updateScroll() {
     scrollY.value = window.scrollY;
}

function scrollToProjects() {
     projectsSectionRef.value?.scrollIntoView({
          behavior: 'smooth',
          block: 'start',
     });
}

onMounted(() => {
     updateScroll();
     window.addEventListener('scroll', updateScroll, { passive: true });
     void nextTick(() => {
          if (window.location.hash === '#projects') {
               projectsSectionRef.value?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
               });
          }
     });
});

onUnmounted(() => {
     window.removeEventListener('scroll', updateScroll);
});

const projects: Project[] = [
     {
          title: 'ARPG Roller Demos',
          subtitle: 'Interactive tools for equine genetics enthusiasts',
          image: '/imgs/example-breedingroller.png',
          link: 'https://arpg.abature.studio/breeding-roller',
          stack: ['JavaScript', 'CSS'],
          description:
               'Demo project providing examples of automated rollers for ARPG groups and admin, built with JavaScript and CSS for seamless interaction.',
     },
     {
          title: 'Nordanner',
          subtitle:
               'Lorekeeper site with custom  masterlist, crafting, and staff rollers',
          image: '/imgs/example-nordanner.png',
          link: '#',
          ctaText: 'Public site not live yet (in development)',
          stack: ['Laravel', 'PHP', 'Blade', 'Lorekeeper'],
          description:
               'Adds integrated admin Rollers (arena, breeding, cartography) with Lorekeeper-native styling, automated logbook import for over 19,000 characters, advanced search support for custom info fields, lineage/info tab updates on character and MYO pages, and more.',
     },
     {
          title: 'Critterverse',
          subtitle: 'Rollers for the Critterverse ARPG',
          image: '/imgs/example-critterverse.png',
          link: 'https://critterverse.abature.studio/',
          stack: ['JavaScript', 'Tailwind', 'HTML'],
          description:
               'Tabbed interface for breeding rolls (sire/dam, mutations, items) and a separate randomizer, with results rendered in-page. JavaScript with Tailwind CSS.',
     },
     {
          title: 'Rattlesnake Mountain',
          subtitle: 'Custom ARPG site',
          image: '/imgs/example-rattlesnakemountain.png',
          link: '#',
          ctaText: 'Public site not live yet (in development)',
          extraImages: [
               {
                    src: '/imgs/example-rattlesnakemountain-1.png',
                    alt: 'Rattlesnake Mountain admin panel — CMS menu and pages',
               },
               {
                    src: '/imgs/example-rattlesnakemountain-2.png',
                    alt: 'Rattlesnake Mountain shop — item grid after data import',
               },
          ],
          stack: ['Vue', 'Tailwind', 'Laravel'],
          description:
               'Custom HARPG site. Laravel, Vue 3 with Inertia, Tailwind, and MySQL. Full user account system with character creation, image upload, interactive rollers, and much more! Standout work includes a deep, fully tailored admin panel and a pipeline that automatically imports the prior site’s shop data so inventory and history carry over cleanly.',
     },
     {
          title: 'Sigil Maker',
          subtitle: 'Automated sigil crafting',
          image: '/imgs/example-sigilmaker.png',
          link: 'https://sigilmaker.abature.studio/',
          stack: ['JavaScript', 'HTML', 'Canvas'],
          description:
               'Tool that turns typed text into a digit string using a fixed letter-to-digit table, with an optional step that strips duplicate digits. The canvas places digits 0–9 on a circle and draws line segments in order so the path reads like a classic sigil construction.',
     },
];

const techIconMap = {
     javascript: CommandLineIcon,
     php: CodeBracketIcon,
     html: CodeBracketIcon,
     css: SwatchIcon,
     tailwind: SwatchIcon,
     canvas: SwatchIcon,
     vue: CubeTransparentIcon,
     laravel: ServerStackIcon,
     blade: CodeBracketIcon,
     lorekeeper: BookOpenIcon,
} as const;

function getTechIcon(tech: string) {
     return techIconMap[tech.toLowerCase() as keyof typeof techIconMap] ?? null;
}
</script>

<template class="bg-neutral-50">
     <main
          :class="[
               'f-full flex min-h-screen cursor-default flex-col items-center transition-colors duration-300',
               isDark
                    ? 'bg-neutral-900 text-neutral-50'
                    : 'bg-neutral-50 text-neutral-900',
          ]"
          :style="{
               '--selection-bg': selectedColor,
               '--selection-fg': '#171717',
          }">
          <div
               class="fixed top-3 left-3 z-30 transition-[opacity,transform] duration-200 sm:top-6 sm:left-8"
               :inert="scrollFadeOpacity < 0.02"
               :style="{
                    opacity: scrollFadeOpacity,
                    pointerEvents: scrollFadeOpacity < 0.02 ? 'none' : 'auto',
               }"
               :aria-hidden="scrollFadeOpacity < 0.02">
               <a
                    href="#"
                    class="font-jetbrains-mono color-animate inline-flex items-center gap-1 text-sm font-semibold decoration-1 underline-offset-4 decoration-transparent transition-[color,text-decoration-color,transform] duration-200 hover:scale-105 hover:underline hover:decoration-current"
                    :style="{ color: selectedColor }">
                    <NewspaperIcon
                         class="h-4 w-4"
                         aria-hidden="true" />
                    Blog (coming soon!)
               </a>
          </div>

          <div
               class="fixed top-3 right-3 z-30 flex items-center gap-2 transition-[opacity,transform] duration-200 sm:top-6 sm:right-8 sm:gap-3"
               :inert="scrollFadeOpacity < 0.02"
               :style="{
                    opacity: scrollFadeOpacity,
                    pointerEvents: scrollFadeOpacity < 0.02 ? 'none' : 'auto',
               }"
               :aria-hidden="scrollFadeOpacity < 0.02">
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

          <button
               type="button"
               class="examples-cta fixed bottom-5 left-1/2 z-40 max-w-[min(100vw-2rem,28rem)] -translate-x-1/2 rounded-full px-3.5 py-2 text-center text-xs leading-snug font-medium shadow-md hover:scale-105 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 sm:text-sm"
               :style="{
                    backgroundColor: selectedColor,
                    color: isDark ? '#171717' : '#fafafa',
                    '--tw-ring-color': selectedColor,
                    opacity: scrollFadeOpacity,
                    pointerEvents: scrollFadeOpacity < 0.02 ? 'none' : 'auto',
               }"
               :aria-hidden="scrollFadeOpacity < 0.02"
               :tabindex="scrollFadeOpacity < 0.02 ? -1 : 0"
               aria-label="Scroll to projects"
               @click="scrollToProjects">
               Show me examples...
          </button>

          <section
               class="relative flex min-h-0 max-w-[820px] flex-col px-4 pb-8">
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
                    class="font-inter color-animate relative z-10 mt-4 max-w-none space-y-4 text-base leading-relaxed transition-colors md:text-lg"
                    :class="isDark ? 'text-neutral-200' : 'text-neutral-800'">
                    <p
                         class="font-jetbrains-mono color-animate text-xl leading-snug font-bold transition-colors md:text-2xl">
                         I build strange little machines for the internet.<br />
                         Mostly for ARPGs. Mostly involving genetics. Always
                         involving a lot of logic.
                    </p>
                    <p>
                         I’ve spent the last decade deep in niche systems,
                         translating complex rule sets into reliable,
                         client-facing tools that streamline both administration
                         and user experience.
                    </p>
                    <p>
                         I don’t just build what you describe, I understand how
                         these systems evolve, break, and scale over time. My
                         work prioritizes usability, performance, and making
                         things make sense.
                    </p>
                    <div>
                         <p class="font-semibold">Specializing in:</p>
                         <ul
                              class="mt-2 list-disc space-y-1 pl-6 marker:text-neutral-500 dark:marker:text-neutral-400">
                              <li>ARPG rollers and full-site ecosystems</li>
                              <li>
                                   Refactoring and stabilizing abandoned or
                                   failing projects
                              </li>
                              <li>
                                   Automating large datasets and legacy systems
                                   (10k+ records)
                              </li>
                         </ul>
                    </div>
                    <p>
                         <span class="font-semibold">Also: I fix things.</span>
                         Clients often come to me when projects stall, break
                         down, or disappear into silence. I focus on clear
                         communication, stable architecture, and keeping things
                         maintainable long-term.
                    </p>
                    <p>My workflow is structured but flexible.</p>
                    <p
                         class="font-jetbrains-mono color-animate my-6 flex flex-col items-center text-center text-xl font-bold tracking-[0.04em] transition-colors md:my-8 md:text-2xl"
                         :class="
                              isDark ? 'text-neutral-200' : 'text-neutral-800'
                         ">
                         <span>Define the system</span>
                         <ArrowDownIcon
                              class="my-1 h-4 w-4 stroke-[2.5] md:my-2" />
                         <span>Build in iterative sessions</span>
                         <ArrowDownIcon
                              class="my-1 h-4 w-4 stroke-[2.5] md:my-2" />
                         <span>Refine as we go.</span>
                    </p>
                    <p>
                         You’ll always know what’s happening, what’s done, and
                         what’s next with working implementations delivered
                         early.
                    </p>
               </div>
          </section>

          <section
               id="projects"
               ref="projectsSectionRef"
               aria-label="Projects"
               class="mx-auto mt-10 w-full max-w-4xl scroll-mt-8 space-y-16 px-4">
               <div
                    v-for="(project, idx) in projects"
                    :key="idx"
                    class="flex flex-col items-start gap-8 md:flex-row">
                    <!-- Image -->
                    <a
                         v-if="project.link !== '#'"
                         :href="project.link"
                         target="_blank"
                         rel="noopener"
                         class="block w-full overflow-hidden rounded-lg shadow-lg transition-transform hover:scale-105 md:w-1/2">
                         <img
                              :src="project.image"
                              :alt="project.title"
                              class="h-auto w-full max-w-full rounded bg-neutral-100 object-contain" />
                    </a>
                    <div
                         v-else
                         class="block w-full overflow-hidden rounded-lg shadow-lg transition-transform hover:scale-105 md:w-1/2">
                         <img
                              :src="project.image"
                              :alt="project.title"
                              class="h-auto w-full max-w-full rounded bg-neutral-100 object-contain" />
                    </div>
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
                                   class="color-animate inline-flex items-center gap-1 rounded bg-neutral-200 px-2 py-1 font-mono text-xs text-neutral-700 transition-colors transition-transform hover:scale-105">
                                   <component
                                        :is="getTechIcon(tech)"
                                        v-if="getTechIcon(tech)"
                                        class="h-3.5 w-3.5 shrink-0"
                                        aria-hidden="true" />
                                   {{ tech }}
                              </span>
                         </div>
                         <p
                              :class="
                                   isDark
                                        ? 'text-neutral-200'
                                        : 'text-neutral-800'
                              "
                              class="color-animate mt-2 text-base transition-colors">
                              {{ project.description }}
                         </p>
                         <div
                              v-if="project.extraImages?.length"
                              class="mt-3 grid grid-cols-2 gap-2 sm:max-w-md sm:grid-cols-2">
                              <a
                                   v-for="(img, gIdx) in project.extraImages"
                                   :key="gIdx"
                                   :href="img.src"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="group relative block aspect-video w-full overflow-hidden rounded-md border shadow-sm transition-transform hover:scale-105 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2"
                                   :class="
                                        isDark
                                             ? 'border-neutral-600 bg-neutral-800 focus-visible:ring-offset-neutral-900'
                                             : 'border-neutral-200 bg-neutral-100 focus-visible:ring-offset-neutral-50'
                                   "
                                   :style="{
                                        '--tw-ring-color': selectedColor,
                                   }"
                                   :aria-label="`Open image in new tab: ${img.alt}`">
                                   <img
                                        :src="img.src"
                                        :alt="img.alt"
                                        class="h-full w-full object-cover object-top" />
                                   <div
                                        class="pointer-events-none absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-visible:opacity-100">
                                        <span
                                             class="px-3 text-center text-sm font-semibold text-white drop-shadow-md">
                                             Open in new tab
                                        </span>
                                   </div>
                              </a>
                         </div>
                         <div
                              v-if="project.link && project.link !== '#'"
                              class="mt-2">
                              <a
                                   :href="project.link"
                                   target="_blank"
                                   rel="noopener"
                                   class="font-jetbrains-mono color-animate inline-flex items-center gap-1 text-sm font-semibold decoration-1 underline-offset-4 decoration-transparent transition-[color,text-decoration-color,transform] duration-200 hover:scale-105 hover:underline hover:decoration-current"
                                   :style="{ color: selectedColor }">
                                   <span>View Project</span>
                                   <ArrowTopRightOnSquareIcon
                                        class="h-4 w-4"
                                        aria-hidden="true" />
                              </a>
                         </div>
                         <p
                              v-else-if="project.link === '#'"
                              class="font-jetbrains-mono color-animate mt-2 text-sm font-semibold"
                              :class="
                                   isDark
                                        ? 'text-neutral-400'
                                        : 'text-neutral-500'
                              ">
                              {{ project.ctaText }}
                         </p>
                    </div>
               </div>
          </section>

          <section
               class="mt-16 flex w-full justify-center transition-colors"
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
                         me your questions and inquiries at
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
     background: var(--accent-color, #3b82f6);
     border-radius: 999px;
     transition: background 0.3s;
     z-index: -1;
}

.color-animate {
     transition: color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Same duration + easing as .color-animate; keep scroll fade / hover scale at 200ms */
.examples-cta {
     transition:
          background-color 0.3s cubic-bezier(0.4, 0, 0.2, 1),
          color 0.3s cubic-bezier(0.4, 0, 0.2, 1),
          opacity 0.2s ease,
          transform 0.2s ease;
}

::selection {
     background: var(--selection-bg, #3b82f6);
     color: var(--selection-fg, #171717);
}

::-moz-selection {
     background: var(--selection-bg, #3b82f6);
     color: var(--selection-fg, #171717);
}
</style>
