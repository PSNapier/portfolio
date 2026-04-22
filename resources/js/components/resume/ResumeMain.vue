<script setup lang="ts">
defineProps<{
     isDark: boolean;
     selectedColor: string;
}>();

type Job = {
     role: string;
     period: string;
     org: string;
     scale?: string;
     bullets: string[];
};

const jobs: Job[] = [
     {
          role: 'Laravel / Vue / Full Stack Developer',
          period: '2024 — PRESENT',
          org: 'Rattlesnake Mountain ARPG',
          scale: '100+ members · pre-launch',
          bullets: [
               'Rebuilding an online ARPG as a custom <strong>Laravel/Vue</strong> application — migrating off Wix with full mobile responsiveness.',
               'Improved Lighthouse <strong>Speed Index from 3.9s → 0.7s</strong> and First Contentful Paint <strong>1.1s → 0.6s</strong>.',
               'Built auth, character pages, leaderboards, automated dice rollers, and an admin CMS from scratch.',
               'Managing full DevOps: Laravel Forge on DigitalOcean, GitHub-driven deploys, planned Cloudflare integration.',
               'Wrote Pest coverage and held the line on modern Laravel/Vue best practices for maintainability.',
          ],
     },
     {
          role: 'Full Stack Developer · Web Consultant',
          period: '2022 — 2024',
          org: 'Nordanner ARPG',
          scale: '2,000+ members',
          bullets: [
               'Migrated a legacy internal tool (<strong>5,000+ lines of vanilla JS</strong>) to Dockerized hosting on DigitalOcean — full deployment, DNS, and container setup without source files.',
               'Identified and removed <strong>cryptojacking scripts</strong> during reverse engineering, likely tied to wallet sniffing.',
               'Refactored a deeply recursive, object-based codebase to stabilize the platform without a full rewrite.',
               'Client stated they would have been forced to abandon the platform without my intervention.',
          ],
     },
     {
          role: 'Front End Developer',
          period: '2021 — 2022',
          org: 'Peafowl Friesian ARPG',
          scale: '800+ members',
          bullets: [
               'Designed and built a custom <strong>genetics roller</strong> in vanilla JS for a fictional fantasy species.',
               'Punnett-square logic with layered gene rules and admin-selectable modifiers (e.g. user-held items).',
               '<strong>Reduced manual admin workload by 90%+</strong> — turning a tedious gene-by-gene process into a repeatable one.',
          ],
     },
];

type Project = {
     title: string;
     badge: string;
     body: string;
     stack: string[];
     linkLabel: string;
     href: string;
     external: boolean;
};

const projects: Project[] = [
     {
          title: 'Rattlesnake Mountain',
          badge: 'ARPG · In progress',
          body: 'Full-site ARPG ecosystem: auth, character pages, leaderboard, dice rollers, admin CMS. Laravel + Vue, shipped responsive.',
          stack: ['Laravel', 'Vue', 'Tailwind', 'Pest'],
          linkLabel: 'View project',
          href: '#',
          external: false,
     },
     {
          title: 'Genetics Roller',
          badge: 'Automation',
          body: 'Punnett-square engine for fictional species genetics. Layered gene rules, admin modifiers, random output — replaced a manual workflow.',
          stack: ['JavaScript', 'HTML', 'CSS'],
          linkLabel: 'View project',
          href: '#',
          external: false,
     },
     {
          title: 'Nordanner Rescue',
          badge: 'Recovery',
          body: 'Reverse-engineered a 5k-line legacy tool with no source files, Dockerized it, removed cryptojacking scripts, and stabilized the platform.',
          stack: ['Docker', 'JavaScript', 'DigitalOcean'],
          linkLabel: 'Case study',
          href: '#',
          external: false,
     },
     {
          title: 'Abature Studio',
          badge: 'Portfolio',
          body: 'This site. Laravel + Vue + Inertia portfolio with a design system, theme switcher, and animated accent-color interactions.',
          stack: ['Laravel', 'Vue', 'Inertia', 'Tailwind'],
          linkLabel: 'abature.studio',
          href: 'https://abature.studio',
          external: true,
     },
];

const education = [
     {
          what: 'Self-directed study · Full Stack Web Development',
          who: 'Laravel · Vue · PHP · TypeScript — ongoing',
          year: '2019 —',
     },
     {
          what: 'Supervisor / Assistant Manager',
          who: 'Pet Paradise — led teams of 10–20, MOD for 210+ dogs',
          year: 'PRIOR',
     },
];
</script>

<template>
     <div class="flex flex-col gap-10">
          <section>
               <h2
                    class="font-jetbrains-mono m-0 mb-3 flex items-center gap-2.5 text-[10px] font-bold tracking-[0.16em] uppercase"
                    :class="isDark ? 'text-neutral-400' : 'text-neutral-500'">
                    <span
                         class="inline-block h-px w-3.5"
                         :style="{ backgroundColor: selectedColor }"
                         aria-hidden="true" />
                    Summary
               </h2>
               <p
                    class="m-0 text-[15px] leading-relaxed"
                    :class="isDark ? 'text-neutral-300' : 'text-neutral-700'">
                    <span
                         class="font-semibold"
                         :class="isDark ? 'text-neutral-50' : 'text-neutral-900'">
                         Resourceful full stack developer </span
                    >currently deep in the Laravel / Vue / Tailwind ecosystem. A
                    decade spent translating complex rule sets into reliable,
                    client-facing tools — ARPG rollers, full-site ecosystems,
                    and the occasional rescue of a stalled project. I prioritize
                    usability, performance, and making things make sense.
               </p>
          </section>

          <section>
               <h2
                    class="font-jetbrains-mono m-0 mb-4 flex items-center gap-2.5 text-[10px] font-bold tracking-[0.16em] uppercase"
                    :class="isDark ? 'text-neutral-400' : 'text-neutral-500'">
                    <span
                         class="inline-block h-px w-3.5"
                         :style="{ backgroundColor: selectedColor }"
                         aria-hidden="true" />
                    Selected Experience
               </h2>

               <div class="flex flex-col gap-6">
                    <article
                         v-for="(job, i) in jobs"
                         :key="i"
                         class="flex flex-col gap-1">
                         <div
                              class="flex flex-wrap items-baseline justify-between gap-2.5">
                              <h3
                                   class="font-inter m-0 text-base font-bold tracking-tight"
                                   :class="
                                        isDark
                                             ? 'text-neutral-50'
                                             : 'text-neutral-900'
                                   ">
                                   {{ job.role }}
                              </h3>
                              <span
                                   class="font-jetbrains-mono text-[10px] tracking-wider whitespace-nowrap"
                                   :class="
                                        isDark
                                             ? 'text-neutral-500'
                                             : 'text-neutral-500'
                                   ">
                                   {{ job.period }}
                              </span>
                         </div>
                         <p
                              class="font-jetbrains-mono m-0 flex flex-wrap items-baseline gap-2 text-sm font-semibold"
                              :style="{ color: selectedColor }">
                              {{ job.org }}
                              <span
                                   v-if="job.scale"
                                   class="text-[11px] font-normal"
                                   :class="
                                        isDark
                                             ? 'text-neutral-500'
                                             : 'text-neutral-500'
                                   ">
                                   {{ job.scale }}
                              </span>
                         </p>
                         <ul class="m-0 mt-1 flex list-none flex-col gap-1 p-0">
                              <li
                                   v-for="(bullet, bi) in job.bullets"
                                   :key="bi"
                                   class="relative pl-4 text-[13px] leading-relaxed"
                                   :class="
                                        isDark
                                             ? 'text-neutral-300'
                                             : 'text-neutral-700'
                                   ">
                                   <span
                                        class="absolute top-0 left-0 text-xs leading-6"
                                        :style="{ color: selectedColor }"
                                        aria-hidden="true"
                                        >▸</span
                                   >
                                   <span
                                        class="[&_strong]:font-semibold"
                                        :class="
                                             isDark
                                                  ? '[&_strong]:text-neutral-50'
                                                  : '[&_strong]:text-neutral-900'
                                        "
                                        v-html="bullet" />
                              </li>
                         </ul>
                    </article>
               </div>
          </section>

          <section>
               <h2
                    class="font-jetbrains-mono m-0 mb-4 flex items-center gap-2.5 text-[10px] font-bold tracking-[0.16em] uppercase"
                    :class="isDark ? 'text-neutral-400' : 'text-neutral-500'">
                    <span
                         class="inline-block h-px w-3.5"
                         :style="{ backgroundColor: selectedColor }"
                         aria-hidden="true" />
                    Featured Projects
               </h2>
               <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <article
                         v-for="project in projects"
                         :key="project.title"
                         class="flex flex-col gap-2 rounded-md border p-3 transition-[border-color,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:-translate-y-px"
                         :class="isDark ? 'border-neutral-800' : 'border-neutral-200'"
                         @mouseenter="
                              ($event.currentTarget as HTMLElement).style.borderColor = selectedColor
                         "
                         @mouseleave="
                              ($event.currentTarget as HTMLElement).style.borderColor = ''
                         ">
                         <div class="flex items-baseline justify-between gap-2">
                              <h3
                                   class="font-jetbrains-mono m-0 text-xs font-bold"
                                   :class="
                                        isDark
                                             ? 'text-neutral-50'
                                             : 'text-neutral-900'
                                   ">
                                   {{ project.title }}
                              </h3>
                              <span
                                   class="font-jetbrains-mono text-[9px] tracking-[0.1em] uppercase"
                                   :class="
                                        isDark
                                             ? 'text-neutral-500'
                                             : 'text-neutral-500'
                                   ">
                                   {{ project.badge }}
                              </span>
                         </div>
                         <p
                              class="m-0 text-[11px] leading-relaxed"
                              :class="
                                   isDark ? 'text-neutral-400' : 'text-neutral-700'
                              ">
                              {{ project.body }}
                         </p>
                         <div class="mt-auto flex flex-wrap gap-1">
                              <span
                                   v-for="tech in project.stack"
                                   :key="tech"
                                   class="font-jetbrains-mono inline-flex items-center rounded px-1.5 py-0.5 text-[10px]"
                                   :class="
                                        isDark
                                             ? 'bg-neutral-800 text-neutral-100'
                                             : 'bg-neutral-200 text-neutral-800'
                                   ">
                                   {{ tech }}
                              </span>
                         </div>
                         <a
                              :href="project.href"
                              :target="project.external ? '_blank' : undefined"
                              :rel="
                                   project.external
                                        ? 'noreferrer noopener'
                                        : undefined
                              "
                              class="font-jetbrains-mono mt-0.5 inline-flex items-center gap-1 text-[10px] font-semibold decoration-transparent decoration-1 underline-offset-4 transition-[text-decoration-color,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:underline hover:decoration-current"
                              :style="{ color: selectedColor }">
                              {{ project.linkLabel }}
                              <span aria-hidden="true">↗</span>
                         </a>
                    </article>
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
                    Education &middot; Prior
               </h2>
               <div class="flex flex-col">
                    <div
                         v-for="(row, i) in education"
                         :key="i"
                         class="flex items-baseline justify-between gap-2.5 py-2 last:border-b-0"
                         :class="[
                              isDark
                                   ? 'border-b border-dashed border-neutral-800'
                                   : 'border-b border-dashed border-neutral-200',
                         ]">
                         <div>
                              <div
                                   class="text-[13px] font-semibold"
                                   :class="
                                        isDark
                                             ? 'text-neutral-50'
                                             : 'text-neutral-900'
                                   ">
                                   {{ row.what }}
                              </div>
                              <div
                                   class="font-jetbrains-mono text-[11px]"
                                   :class="
                                        isDark
                                             ? 'text-neutral-500'
                                             : 'text-neutral-500'
                                   ">
                                   {{ row.who }}
                              </div>
                         </div>
                         <div
                              class="font-jetbrains-mono text-[11px] whitespace-nowrap"
                              :class="
                                   isDark ? 'text-neutral-500' : 'text-neutral-500'
                              ">
                              {{ row.year }}
                         </div>
                    </div>
               </div>
          </section>
     </div>
</template>
