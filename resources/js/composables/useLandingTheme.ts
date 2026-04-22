import { ref, watch } from 'vue';
import { getResolvedIsDark, useAppearance } from './useAppearance';

// Canonical accent palette — see .cursor/rules/design-spec.mdc
// Order is intentional (cyan, green, gold, pink, purple) and index-aligned
// between vivid (light mode) and soft (dark mode) so toggling theme preserves selection.
const colorsVivid = [
     '#1ECFE6', // cyan
     '#32C36A', // green
     '#EBC166', // gold
     '#F73676', // pink
     '#A362A4', // purple
];

const colorsSoft = [
     '#4ED7EA', // cyan
     '#50CC80', // green
     '#EECA7A', // gold
     '#F85A8E', // pink
     '#B27AB2', // purple
];

export function useLandingTheme() {
     const { updateAppearance } = useAppearance();

     const isDark = ref(getResolvedIsDark());
     const selectedColor = ref(colorsVivid[0]);
     const colors = ref<string[]>(colorsVivid);

     function toggleTheme() {
          isDark.value = !isDark.value;
          updateAppearance(isDark.value ? 'dark' : 'light');
     }

     watch(
          isDark,
          (value) => {
               const prevColors = value ? colorsVivid : colorsSoft;
               const newColors = value ? colorsSoft : colorsVivid;
               const idx = prevColors.indexOf(selectedColor.value);
               colors.value = newColors;
               selectedColor.value = newColors[idx >= 0 ? idx : 0];
          },
          { immediate: true },
     );

     return {
          isDark,
          selectedColor,
          colors,
          toggleTheme,
     };
}
