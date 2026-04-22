<script setup lang="ts">
defineProps<{
     isDark: boolean;
     selectedColor: string;
}>();
</script>

<template>
     <header
          class="flex flex-col gap-2 border-b pb-8"
          :class="isDark ? 'border-neutral-800' : 'border-neutral-200'">
          <div
               class="font-jetbrains-mono flex items-center gap-2 text-[10px] tracking-[0.16em] uppercase"
               :class="isDark ? 'text-neutral-500' : 'text-neutral-400'">
               <span
                    class="inline-block h-1.5 w-1.5 rounded-full"
                    :style="{ backgroundColor: selectedColor }"
                    aria-hidden="true" />
               Resume &middot; v2026.04
          </div>

          <h1
               class="font-jetbrains-mono m-0 text-5xl leading-none font-bold tracking-tight transition-colors duration-[var(--motion-duration-color)] ease-[var(--motion-ease-standard)] sm:text-6xl"
               :style="{ color: selectedColor }">
               A.R. Jones<span
                    class="ml-1 inline-block h-[0.9em] w-[0.55ch] animate-[resume-caret-blink_1.1s_steps(1)_infinite] align-[-2px]"
                    :style="{ backgroundColor: selectedColor }"
                    aria-hidden="true" />
          </h1>

          <div
               class="font-jetbrains-mono flex flex-wrap items-center gap-2 text-sm font-semibold tracking-wide"
               :class="isDark ? 'text-neutral-300' : 'text-neutral-700'">
               <span>Full Stack Developer</span>
               <span
                    :class="isDark ? 'text-neutral-600' : 'text-neutral-300'"
                    >/</span
               >
               <span>Agentic Engineer</span>
               <span
                    :class="isDark ? 'text-neutral-600' : 'text-neutral-300'"
                    >/</span
               >
               <span
                    class="font-medium"
                    :class="isDark ? 'text-neutral-500' : 'text-neutral-500'">
                    Laravel &middot; Vue &middot; Tailwind
               </span>
          </div>
     </header>
</template>

<style>
@keyframes resume-caret-blink {
     50% {
          opacity: 0;
     }
}
</style>
