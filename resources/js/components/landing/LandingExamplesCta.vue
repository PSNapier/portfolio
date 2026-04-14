<script setup lang="ts">
defineProps<{
     selectedColor: string;
     isDark: boolean;
     opacity: number;
}>();

const emit = defineEmits<{
     scrollToProjects: [];
}>();
</script>

<template>
     <button
          type="button"
          class="examples-cta fixed bottom-5 left-1/2 z-40 max-w-[min(100vw-2rem,28rem)] -translate-x-1/2 rounded-full px-3.5 py-2 text-center text-xs leading-snug font-medium shadow-md hover:scale-105 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 sm:text-sm"
          :style="{
               backgroundColor: selectedColor,
               color: isDark ? '#171717' : '#fafafa',
               '--tw-ring-color': selectedColor,
               opacity,
               pointerEvents: opacity < 0.02 ? 'none' : 'auto',
          }"
          :aria-hidden="opacity < 0.02"
          :tabindex="opacity < 0.02 ? -1 : 0"
          aria-label="Scroll to projects"
          @click="emit('scrollToProjects')">
          Show me examples...
     </button>
</template>
