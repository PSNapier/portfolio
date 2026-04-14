import { computed, onMounted, onUnmounted, ref } from 'vue';

const SCROLL_FADE_DISTANCE = 200;

export function useScrollFade() {
     const scrollY = ref(0);

     const scrollFadeOpacity = computed(() => {
          const y = scrollY.value;
          return Math.max(0, Math.min(1, 1 - y / SCROLL_FADE_DISTANCE));
     });

     function updateScroll() {
          scrollY.value = window.scrollY;
     }

     onMounted(() => {
          updateScroll();
          window.addEventListener('scroll', updateScroll, { passive: true });
     });

     onUnmounted(() => {
          window.removeEventListener('scroll', updateScroll);
     });

     return {
          scrollY,
          scrollFadeOpacity,
     };
}
