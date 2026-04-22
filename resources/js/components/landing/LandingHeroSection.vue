<script setup lang="ts">
import {
     ArrowDownIcon,
     ArrowPathIcon,
     CircleStackIcon,
     WrenchScrewdriverIcon,
} from '@heroicons/vue/24/outline';

defineProps<{
     isDark: boolean;
     selectedColor: string;
}>();
</script>

<template>
     <section class="content-shell-narrow relative flex min-h-0 flex-col pb-8">
          <div
               class="font-jetbrains-mono color-animate relative z-10 mt-20 min-h-[90px] text-5xl leading-tight font-bold transition-colors sm:text-6xl md:text-7xl">
               <span
                    class="underline-animate color-animate pb-2 transition-colors"
                    :style="{
                         '--accent-color': selectedColor,
                         color: selectedColor,
                    }">
                    Abature Studio
               </span>
          </div>
          <div
               class="font-inter color-animate relative z-10 mt-2 max-w-none space-y-4 text-base leading-relaxed transition-colors md:text-lg"
               :class="isDark ? 'text-neutral-200' : 'text-neutral-800'">
               <p
                    class="font-jetbrains-mono color-animate text-xl leading-snug font-bold transition-colors md:text-2xl">
                    I build strange little machines for the internet.<br />
                    Mostly for ARPGs. Mostly involving genetics. Always
                    involving a lot of logic.
               </p>
               <p>
                    I’ve spent the last decade deep in niche systems,
                    translating complex rule sets into reliable, client-facing
                    tools that streamline both administration and user
                    experience.
               </p>
               <p>
                    I don’t just build what you describe, I understand how these
                    systems evolve, break, and scale over time. My work
                    prioritizes usability, performance, and making things make
                    sense.
               </p>
               <div>
                    <p class="font-semibold">Specializing in:</p>
                    <ul class="mt-2 space-y-2">
                         <li class="flex items-start gap-2">
                              <CircleStackIcon
                                   class="mt-[7px] h-4 w-4 shrink-0"
                                   aria-hidden="true" />
                              <span>ARPG rollers and full-site ecosystems</span>
                         </li>
                         <li class="flex items-start gap-2">
                              <WrenchScrewdriverIcon
                                   class="mt-[7px] h-4 w-4 shrink-0"
                                   aria-hidden="true" />
                              <span>
                                   Refactoring and stabilizing abandoned or
                                   failing projects
                              </span>
                         </li>
                         <li class="flex items-start gap-2">
                              <ArrowPathIcon
                                   class="mt-[7px] h-4 w-4 shrink-0"
                                   aria-hidden="true" />
                              <span>
                                   Automating large datasets and legacy systems
                                   (10k+ records)
                              </span>
                         </li>
                    </ul>
               </div>
               <p>
                    <span class="font-semibold">Also: I fix things.</span>
                    Clients often come to me when projects stall, break down, or
                    disappear into silence. I focus on clear communication,
                    stable architecture, and keeping things maintainable
                    long-term.
               </p>
               <p>My workflow is structured but flexible.</p>
               <p
                    class="font-jetbrains-mono color-animate my-6 flex flex-col items-center text-center text-xl font-bold tracking-[0.04em] transition-colors md:my-8 md:text-2xl"
                    :class="isDark ? 'text-neutral-200' : 'text-neutral-800'">
                    <span>Define the system</span>
                    <ArrowDownIcon class="my-1 h-4 w-4 stroke-[2.5] md:my-2" />
                    <span>Build in iterative sessions</span>
                    <ArrowDownIcon class="my-1 h-4 w-4 stroke-[2.5] md:my-2" />
                    <span>Refine as we go.</span>
               </p>
               <p>
                    You’ll always know what’s happening, what’s done, and what’s
                    next with working implementations delivered early.
               </p>
          </div>
     </section>
</template>
