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

const { isDark, selectedColor, colors } = useLandingTheme();
const { scrollFadeOpacity } = useScrollFade();

function setSelectedColor(color: string) {
    selectedColor.value = color;
}

function toggleTheme() {
    isDark.value = !isDark.value;
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

        <section :class="[shellClass, 'pt-24 pb-12 sm:pt-28']">
            <slot :selected-color="selectedColor" :is-dark="isDark" />
        </section>

        <LandingFooter />
    </main>
</template>

<style>
::selection {
    background: var(--selection-bg, #3b82f6);
    color: var(--selection-fg, #171717);
}

::-moz-selection {
    background: var(--selection-bg, #3b82f6);
    color: var(--selection-fg, #171717);
}
</style>
