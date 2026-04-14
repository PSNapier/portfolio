<script setup lang="ts">
import type { Component } from 'vue';
import type { Project } from '../../pages/landing/types';
import LandingProjectCard from './LandingProjectCard.vue';

defineProps<{
     projects: Project[];
     isDark: boolean;
     selectedColor: string;
     getTechIcon: (tech: string) => Component | null;
}>();
</script>

<template>
     <section
          id="projects"
          aria-label="Projects"
          class="mx-auto mt-10 w-full max-w-4xl scroll-mt-8 space-y-16 px-4">
          <LandingProjectCard
               v-for="(project, idx) in projects"
               :key="idx"
               :project="project"
               :is-dark="isDark"
               :selected-color="selectedColor"
               :get-tech-icon="getTechIcon" />
     </section>
</template>
