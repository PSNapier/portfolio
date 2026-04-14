<script setup lang="ts">
import { MoonIcon, NewspaperIcon, SunIcon } from '@heroicons/vue/24/outline';
import { IconBrandGithub } from '@tabler/icons-vue';

defineProps<{
     isDark: boolean;
     selectedColor: string;
     colors: string[];
     opacity: number;
}>();

const emit = defineEmits<{
     toggleTheme: [];
     selectColor: [color: string];
}>();
</script>

<template>
     <div
          class="fixed top-3 left-3 z-30 transition-[opacity,transform] duration-200 sm:top-6 sm:left-8"
          :inert="opacity < 0.02"
          :style="{
               opacity,
               pointerEvents: opacity < 0.02 ? 'none' : 'auto',
          }"
          :aria-hidden="opacity < 0.02">
          <div class="flex items-center gap-4">
               <a
                    href="https://github.com/PSNapier"
                    target="_blank"
                    rel="noreferrer noopener"
                    class="font-jetbrains-mono color-animate inline-flex items-center gap-1 text-sm font-semibold decoration-transparent decoration-1 underline-offset-4 transition-[color,text-decoration-color,transform] duration-200 hover:scale-105 hover:underline hover:decoration-current"
                    :style="{ color: selectedColor }">
                    <IconBrandGithub
                         class="h-4 w-4"
                         aria-hidden="true" />
                    GitHub
               </a>
               <a
                    :href="route('blog.index')"
                    class="font-jetbrains-mono color-animate inline-flex items-center gap-1 text-sm font-semibold decoration-transparent decoration-1 underline-offset-4 transition-[color,text-decoration-color,transform] duration-200 hover:scale-105 hover:underline hover:decoration-current"
                    :style="{ color: selectedColor }">
                    <NewspaperIcon
                         class="h-4 w-4"
                         aria-hidden="true" />
                    Blog
               </a>
          </div>
     </div>

     <div
          class="fixed top-3 right-3 z-30 flex items-center gap-2 transition-[opacity,transform] duration-200 sm:top-6 sm:right-8 sm:gap-3"
          :inert="opacity < 0.02"
          :style="{
               opacity,
               pointerEvents: opacity < 0.02 ? 'none' : 'auto',
          }"
          :aria-hidden="opacity < 0.02">
          <div
               v-for="(color, idx) in colors"
               :key="idx"
               :style="{ backgroundColor: color }"
               class="h-4 w-4 cursor-pointer rounded-full transition-transform duration-200 hover:scale-125"
               @click="emit('selectColor', color)" />
          <button
               class="ml-2 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full transition-colors transition-transform duration-200 hover:scale-125 sm:ml-4 dark:border-neutral-700"
               :class="
                    isDark ? 'bg-neutral-50' : 'bg-white dark:bg-neutral-800'
               "
               :aria-label="
                    isDark ? 'Switch to light mode' : 'Switch to dark mode'
               "
               @click="emit('toggleTheme')">
               <component
                    :is="isDark ? SunIcon : MoonIcon"
                    :class="'h-5 w-5'"
                    :style="{ color: selectedColor }" />
          </button>
     </div>
</template>
