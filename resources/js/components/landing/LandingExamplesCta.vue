<script setup lang="ts">
withDefaults(
     defineProps<{
          selectedColor: string;
          isDark: boolean;
          opacity: number;
          label?: string;
          scrollAriaLabel?: string;
          /** When true: same hover scale as default CTA, but no transition (instant snap). */
          staticCta?: boolean;
     }>(),
     {
          label: 'Show me examples...',
          scrollAriaLabel: 'Scroll to projects',
          staticCta: false,
     },
);

const emit = defineEmits<{
     navigate: [];
}>();
</script>

<template>
     <button
          type="button"
          :class="[
               'fixed bottom-5 left-1/2 z-40 flex max-w-[min(100vw-2rem,28rem)] -translate-x-1/2 items-center justify-center gap-2 rounded-full px-3.5 py-2 text-center text-xs leading-snug font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 sm:text-sm',
               !staticCta && 'examples-cta hover:scale-105',
               staticCta && 'hover:scale-105 transition-none',
          ]"
          :style="{
               backgroundColor: selectedColor,
               color: isDark ? '#171717' : '#fafafa',
               '--tw-ring-color': selectedColor,
               opacity,
               pointerEvents: opacity < 0.02 ? 'none' : 'auto',
          }"
          :aria-hidden="opacity < 0.02"
          :tabindex="opacity < 0.02 ? -1 : 0"
          :aria-label="scrollAriaLabel"
          @click="emit('navigate')">
          <span>{{ label }}</span>
          <slot name="trailing" />
     </button>
</template>
