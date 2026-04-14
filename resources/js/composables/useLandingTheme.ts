import { ref, watch } from 'vue';

const colorsSoft = ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#a78bfa'];
const colorsVivid = ['#ef4444', '#eab308', '#10b981', '#3b82f6', '#8b5cf6'];

export function useLandingTheme() {
     const isDark = ref(false);
     const selectedColor = ref(colorsVivid[3]);
     const colors = ref<string[]>(colorsVivid);

     watch(isDark, (value) => {
          const prevColors = value ? colorsVivid : colorsSoft;
          const newColors = value ? colorsSoft : colorsVivid;
          const idx = prevColors.indexOf(selectedColor.value);
          colors.value = newColors;
          selectedColor.value = newColors[idx >= 0 ? idx : 0];
     });

     return {
          isDark,
          selectedColor,
          colors,
     };
}
