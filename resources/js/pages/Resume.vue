<script setup lang="ts">
import LandingFooter from '../components/landing/LandingFooter.vue';
import LandingTopControls from '../components/landing/LandingTopControls.vue';
import ResumeHeader from '../components/resume/ResumeHeader.vue';
import ResumeMain from '../components/resume/ResumeMain.vue';
import ResumeSidebar from '../components/resume/ResumeSidebar.vue';
import { useLandingTheme } from '../composables/useLandingTheme';
import { useScrollFade } from '../composables/useScrollFade';

const { isDark, selectedColor, colors, toggleTheme } = useLandingTheme();
const { scrollFadeOpacity } = useScrollFade();

function setSelectedColor(color: string) {
     selectedColor.value = color;
}

function printResume() {
     window.print();
}
</script>

<template>
     <main
          :class="[
               'flex min-h-screen w-full cursor-default flex-col items-center overflow-x-hidden pb-24 transition-colors duration-300',
               isDark
                    ? 'bg-neutral-900 text-neutral-50'
                    : 'bg-neutral-50 text-neutral-900',
          ]"
          :style="{
               '--accent-color': selectedColor,
               '--selection-bg': selectedColor,
               '--selection-fg': '#171717',
          }">
          <div data-print-hide>
               <LandingTopControls
                    :is-dark="isDark"
                    :selected-color="selectedColor"
                    :colors="colors"
                    :opacity="scrollFadeOpacity"
                    @select-color="setSelectedColor"
                    @toggle-theme="toggleTheme" />
          </div>

          <div class="content-shell-wide pt-20 sm:pt-28">
               <ResumeHeader
                    :is-dark="isDark"
                    :selected-color="selectedColor" />

               <div
                    class="mt-10 grid grid-cols-1 gap-10 md:grid-cols-[220px_1fr] md:gap-12">
                    <ResumeSidebar
                         :is-dark="isDark"
                         :selected-color="selectedColor" />
                    <ResumeMain
                         :is-dark="isDark"
                         :selected-color="selectedColor" />
               </div>

               <div
                    data-print-hide
                    class="mt-12 flex justify-end">
                    <button
                         type="button"
                         class="font-jetbrains-mono inline-flex cursor-pointer items-center gap-2 rounded-lg border px-3.5 py-2 text-xs font-semibold transition-[color,border-color,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:-translate-y-px focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none"
                         :class="
                              isDark
                                   ? 'border-neutral-700 text-neutral-100 focus-visible:ring-[var(--accent-color)]'
                                   : 'border-neutral-300 text-neutral-900 focus-visible:ring-[var(--accent-color)]'
                         "
                         @mouseenter="
                              ($event.currentTarget as HTMLElement).style.borderColor = selectedColor;
                              ($event.currentTarget as HTMLElement).style.color = selectedColor;
                         "
                         @mouseleave="
                              ($event.currentTarget as HTMLElement).style.borderColor = '';
                              ($event.currentTarget as HTMLElement).style.color = '';
                         "
                         @click="printResume">
                         <svg
                              viewBox="0 0 24 24"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              class="h-3.5 w-3.5"
                              aria-hidden="true">
                              <path d="M12 3v12" />
                              <path d="m7 10 5 5 5-5" />
                              <path d="M5 21h14" />
                         </svg>
                         Download PDF
                    </button>
               </div>
          </div>

          <div
               data-print-hide
               class="mt-12 w-full">
               <LandingFooter />
          </div>
     </main>
</template>
