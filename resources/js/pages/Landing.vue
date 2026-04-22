<script setup lang="ts">
import {
     BookOpenIcon,
     CodeBracketIcon,
     CommandLineIcon,
     SwatchIcon,
} from '@heroicons/vue/24/outline';
import { IconBrandLaravel, IconBrandVue } from '@tabler/icons-vue';
import { nextTick, onMounted } from 'vue';
import LandingContactSection from '../components/landing/LandingContactSection.vue';
import LandingExamplesCta from '../components/landing/LandingExamplesCta.vue';
import LandingFooter from '../components/landing/LandingFooter.vue';
import LandingHeroSection from '../components/landing/LandingHeroSection.vue';
import LandingProjectsSection from '../components/landing/LandingProjectsSection.vue';
import LandingTopControls from '../components/landing/LandingTopControls.vue';
import { useLandingTheme } from '../composables/useLandingTheme';
import { useScrollFade } from '../composables/useScrollFade';
import { projects } from './landing/projects';

const { isDark, selectedColor, colors } = useLandingTheme();
const { scrollFadeOpacity } = useScrollFade();

function setSelectedColor(color: string) {
     selectedColor.value = color;
}

function toggleTheme() {
     isDark.value = !isDark.value;
}

function scrollToProjects() {
     document.getElementById('projects')?.scrollIntoView({
          behavior: 'smooth',
          block: 'start',
     });
}

onMounted(() => {
     void nextTick(() => {
          if (window.location.hash === '#projects') {
               scrollToProjects();
          }
     });
});

const techIconMap = {
     javascript: CommandLineIcon,
     php: CodeBracketIcon,
     html: CodeBracketIcon,
     css: SwatchIcon,
     tailwind: SwatchIcon,
     canvas: SwatchIcon,
     vue: IconBrandVue,
     laravel: IconBrandLaravel,
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
               'flex w-full min-h-screen cursor-default flex-col items-center overflow-x-hidden pb-24 transition-colors duration-300',
               isDark
                    ? 'bg-neutral-900 text-neutral-50'
                    : 'bg-neutral-50 text-neutral-900',
          ]"
          :style="{
               '--accent-color': selectedColor,
               '--selection-bg': selectedColor,
               '--selection-fg': '#171717',
          }">
          <LandingTopControls
               :is-dark="isDark"
               :selected-color="selectedColor"
               :colors="colors"
               :opacity="scrollFadeOpacity"
               @select-color="setSelectedColor"
               @toggle-theme="toggleTheme" />

          <LandingExamplesCta
               :selected-color="selectedColor"
               :is-dark="isDark"
               :opacity="scrollFadeOpacity"
               @scroll-to-projects="scrollToProjects" />

          <LandingHeroSection
               :is-dark="isDark"
               :selected-color="selectedColor" />

          <LandingProjectsSection
               :projects="projects"
               :is-dark="isDark"
               :selected-color="selectedColor"
               :get-tech-icon="getTechIcon" />

          <LandingContactSection
               :selected-color="selectedColor"
               :is-dark="isDark" />

          <LandingFooter />
     </main>
</template>

<style>
@import '@fontsource/jetbrains-mono';
@import '@fontsource/inter/400.css';
@import '@fontsource/inter/700.css';

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
     background: var(--accent-color, #1ECFE6);
    border-radius: 4px;
     transition: background 0.3s;
     z-index: -1;
}

.color-animate {
     transition: color var(--motion-duration-color) var(--motion-ease-standard);
}

/* Use shared motion tokens for consistency across pages/components. */
.examples-cta {
     transition:
          background-color var(--motion-duration-color) var(--motion-ease-standard),
          color var(--motion-duration-color) var(--motion-ease-standard),
          opacity var(--motion-duration-micro) var(--motion-ease-micro),
          transform var(--motion-duration-micro) var(--motion-ease-micro);
}

::selection {
     background: var(--selection-bg, #1ECFE6);
     color: var(--selection-fg, #171717);
}

::-moz-selection {
     background: var(--selection-bg, #1ECFE6);
     color: var(--selection-fg, #171717);
}
</style>
