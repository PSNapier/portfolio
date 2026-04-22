<script setup lang="ts">
import LandingFooter from '../landing/LandingFooter.vue';
import LandingTopControls from '../landing/LandingTopControls.vue';
import { useLandingTheme } from '../../composables/useLandingTheme';
import { useScrollFade } from '../../composables/useScrollFade';

withDefaults(
    defineProps<{
        shellClass?: string;
    }>(),
    {
        shellClass: 'content-shell-wide',
    }
);

const { isDark, selectedColor, colors, toggleTheme } = useLandingTheme();
const { scrollFadeOpacity } = useScrollFade();

function setSelectedColor(color: string) {
    selectedColor.value = color;
}
</script>

<template>
    <main
        :class="[
            'min-h-screen transition-colors',
            isDark ? 'bg-neutral-900 text-neutral-50' : 'bg-neutral-50 text-neutral-900',
        ]"
        :style="{
            '--accent-color': selectedColor,
            '--selection-bg': selectedColor,
            '--selection-fg': '#171717',
            transitionDuration: 'var(--motion-duration-color)',
            transitionTimingFunction: 'var(--motion-ease-standard)',
        }">
        <LandingTopControls
            :is-dark="isDark"
            :selected-color="selectedColor"
            :colors="colors"
            :opacity="scrollFadeOpacity"
            @select-color="setSelectedColor"
            @toggle-theme="toggleTheme" />

        <section :class="[shellClass, 'pt-20 pb-12 sm:pt-24']">
            <slot :selected-color="selectedColor" :is-dark="isDark" />
        </section>

        <LandingFooter />
    </main>
</template>
