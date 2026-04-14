<script setup lang="ts">
import { ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/outline';
import type { Component } from 'vue';
import type { Project } from '../../pages/landing/types';

defineProps<{
     project: Project;
     isDark: boolean;
     selectedColor: string;
     getTechIcon: (tech: string) => Component | null;
}>();
</script>

<template>
     <div class="flex flex-col items-start gap-8 md:flex-row">
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
                    :class="isDark ? 'text-neutral-300' : 'text-neutral-600'">
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
                              :stroke="
                                   tech.toLowerCase() === 'laravel'
                                        ? 1
                                        : undefined
                              "
                              class="h-3.5 w-3.5 shrink-0"
                              aria-hidden="true" />
                         {{ tech }}
                    </span>
               </div>
               <p
                    :class="isDark ? 'text-neutral-200' : 'text-neutral-800'"
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
                         :style="{ '--tw-ring-color': selectedColor }"
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
                         class="font-jetbrains-mono color-animate inline-flex items-center gap-1 text-sm font-semibold decoration-transparent decoration-1 underline-offset-4 transition-[color,text-decoration-color,transform] duration-200 hover:scale-105 hover:underline hover:decoration-current"
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
                    :class="isDark ? 'text-neutral-400' : 'text-neutral-500'">
                    {{ project.ctaText }}
               </p>
          </div>
     </div>
</template>
