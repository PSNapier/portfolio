<script setup lang="ts">
import {
     EnvelopeIcon,
     GlobeAltIcon,
} from '@heroicons/vue/24/outline';
import { IconBrandGithub, IconBrandLinkedin } from '@tabler/icons-vue';

defineProps<{
     isDark: boolean;
     selectedColor: string;
}>();

type PillStyle = 'solid' | 'outline';

const skillGroups: { heading: string; items: string[]; style: PillStyle }[] = [
     {
          heading: 'Frontend',
          items: [
               'Vue.js',
               'TypeScript',
               'JavaScript',
               'Tailwind',
               'Inertia',
               'HTML · CSS',
          ],
          style: 'solid',
     },
     {
          heading: 'Backend',
          items: ['Laravel', 'PHP', 'Livewire', 'Node.js', 'MySQL', 'Pest'],
          style: 'solid',
     },
     {
          heading: 'Tools',
          items: ['Herd', 'Sail', 'Vite', 'Docker', 'Git', 'Cursor'],
          style: 'outline',
     },
     {
          heading: 'Hosting',
          items: ['DigitalOcean', 'Forge', 'LAMP/LEMP', 'DNS'],
          style: 'outline',
     },
];

const contacts = [
     {
          icon: GlobeAltIcon,
          href: 'https://abature.studio',
          label: 'abature.studio',
          external: true,
     },
     {
          icon: IconBrandGithub,
          href: 'https://github.com/PSNapier',
          label: 'github.com/PSNapier',
          external: true,
     },
     {
          icon: IconBrandLinkedin,
          href: 'https://linkedin.com/in/arjones',
          label: 'linkedin.com/in/arjones',
          external: true,
     },
     {
          icon: EnvelopeIcon,
          href: 'mailto:hello@abature.studio',
          label: 'hello@abature.studio',
          external: false,
     },
];

const softSkills = [
     'Direct client communication',
     'Translating needs into technical plans',
     'Team leadership (10–20)',
     'Photoshop · Figma · Blender 3D',
];
</script>

<template>
     <aside class="flex flex-col gap-10">
          <section>
               <h2
                    class="font-jetbrains-mono m-0 mb-3 flex items-center gap-2.5 text-[10px] font-bold tracking-[0.16em] uppercase"
                    :class="isDark ? 'text-neutral-400' : 'text-neutral-500'">
                    <span
                         class="inline-block h-px w-3.5"
                         :style="{ backgroundColor: selectedColor }"
                         aria-hidden="true" />
                    Contact
               </h2>
               <ul class="m-0 flex list-none flex-col gap-2 p-0 text-sm">
                    <li
                         v-for="(c, i) in contacts"
                         :key="i"
                         class="flex items-start gap-2"
                         :class="isDark ? 'text-neutral-300' : 'text-neutral-700'">
                         <component
                              :is="c.icon"
                              class="mt-0.5 h-3.5 w-3.5 flex-shrink-0"
                              :class="isDark ? 'text-neutral-500' : 'text-neutral-400'"
                              aria-hidden="true" />
                         <a
                              :href="c.href"
                              :target="c.external ? '_blank' : undefined"
                              :rel="c.external ? 'noreferrer noopener' : undefined"
                              class="font-jetbrains-mono color-animate break-all text-xs decoration-transparent decoration-1 underline-offset-4 transition-[color,text-decoration-color] duration-[var(--motion-duration-color)] ease-[var(--motion-ease-standard)] hover:underline hover:decoration-current focus-visible:outline-2 focus-visible:outline-offset-2"
                              :style="{
                                   outlineColor: selectedColor,
                              }"
                              @mouseenter="
                                   ($event.currentTarget as HTMLElement).style.color = selectedColor
                              "
                              @mouseleave="
                                   ($event.currentTarget as HTMLElement).style.color = ''
                              ">
                              {{ c.label }}
                         </a>
                    </li>
               </ul>
          </section>

          <section>
               <h2
                    class="font-jetbrains-mono m-0 mb-3 flex items-center gap-2.5 text-[10px] font-bold tracking-[0.16em] uppercase"
                    :class="isDark ? 'text-neutral-400' : 'text-neutral-500'">
                    <span
                         class="inline-block h-px w-3.5"
                         :style="{ backgroundColor: selectedColor }"
                         aria-hidden="true" />
                    Tech Stack
               </h2>
               <div class="flex flex-col gap-4">
                    <div
                         v-for="group in skillGroups"
                         :key="group.heading"
                         class="flex flex-col gap-2">
                         <p
                              class="font-jetbrains-mono m-0 flex items-baseline gap-1.5 text-xs font-semibold"
                              :class="isDark ? 'text-neutral-100' : 'text-neutral-800'">
                              <span
                                   class="font-bold"
                                   :style="{ color: selectedColor }"
                                   >//</span
                              >
                              {{ group.heading }}
                         </p>
                         <div class="flex flex-wrap gap-1.5">
                              <span
                                   v-for="item in group.items"
                                   :key="item"
                                   class="font-jetbrains-mono inline-flex items-center rounded px-1.5 py-0.5 text-[10.5px] leading-6"
                                   :class="
                                        group.style === 'solid'
                                             ? isDark
                                                  ? 'bg-neutral-800 text-neutral-100'
                                                  : 'bg-neutral-200 text-neutral-800'
                                             : isDark
                                               ? 'border border-neutral-700 text-neutral-300'
                                               : 'border border-neutral-300 text-neutral-700'
                                   ">
                                   {{ item }}
                              </span>
                         </div>
                    </div>
               </div>
          </section>

          <section>
               <h2
                    class="font-jetbrains-mono m-0 mb-3 flex items-center gap-2.5 text-[10px] font-bold tracking-[0.16em] uppercase"
                    :class="isDark ? 'text-neutral-400' : 'text-neutral-500'">
                    <span
                         class="inline-block h-px w-3.5"
                         :style="{ backgroundColor: selectedColor }"
                         aria-hidden="true" />
                    Also
               </h2>
               <ul
                    class="m-0 flex list-none flex-col gap-1.5 p-0 text-[13px] leading-relaxed"
                    :class="isDark ? 'text-neutral-300' : 'text-neutral-700'">
                    <li
                         v-for="(s, i) in softSkills"
                         :key="i"
                         class="relative pl-3 before:absolute before:top-[0.7em] before:left-0 before:h-px before:w-1"
                         :class="
                              isDark
                                   ? 'before:bg-neutral-600'
                                   : 'before:bg-neutral-400'
                         ">
                         {{ s }}
                    </li>
               </ul>
          </section>
     </aside>
</template>
