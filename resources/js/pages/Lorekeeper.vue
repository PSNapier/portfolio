<script setup lang="ts">
import {
     ArrowDownIcon,
     CheckIcon,
     CloudArrowUpIcon,
     PaintBrushIcon,
     PuzzlePieceIcon,
     WrenchScrewdriverIcon,
} from '@heroicons/vue/24/outline';
import { router } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, reactive, ref } from 'vue';
import LandingExamplesCta from '../components/landing/LandingExamplesCta.vue';
import LandingFooter from '../components/landing/LandingFooter.vue';
import LandingTopControls from '../components/landing/LandingTopControls.vue';
import { useLandingTheme } from '../composables/useLandingTheme';
import { useScrollFade } from '../composables/useScrollFade';

const { isDark, selectedColor, colors, toggleTheme } = useLandingTheme();
const { scrollFadeOpacity } = useScrollFade();

function setSelectedColor(color: string) {
     selectedColor.value = color;
}

/** Id on the “Start a conversation” h2 — matches /lorekeeper#contact and Inertia v.reset() hash scroll */
const contactAnchorId = 'contact';

function scrollToContact(options?: { behavior?: ScrollBehavior }) {
     document.getElementById(contactAnchorId)?.scrollIntoView({
          behavior: options?.behavior ?? 'smooth',
          block: 'start',
     });
}

let offInertiaFinish: (() => void) | undefined;

onMounted(() => {
     if (window.location.hash === `#${contactAnchorId}`) {
          requestAnimationFrame(() => scrollToContact({ behavior: 'auto' }));
     }

     offInertiaFinish = router.on('finish', () => {
          if (window.location.hash === `#${contactAnchorId}`) {
               requestAnimationFrame(() =>
                    scrollToContact({ behavior: 'auto' }),
               );
          }
     });
});

onBeforeUnmount(() => {
     offInertiaFinish?.();
});

const deliverables = [
     {
          icon: CloudArrowUpIcon,
          title: 'Fresh installs & migrations',
          body: 'Clean Lorekeeper setups on a production-ready VPS, plus migrations off shared hosts or abandoned servers without losing data.',
     },
     {
          icon: PaintBrushIcon,
          title: 'Custom layouts & reskins',
          body: 'Themed front pages, nav, character pages, and admin flows. Full reskins or targeted tweaks against your existing markup.',
     },
     {
          icon: PuzzlePieceIcon,
          title: 'Extensions & feature work',
          body: 'New features on top of Lorekeeper: carousels, featured characters, event systems, in-site content editing, custom extensions, and more.',
     },
     {
          icon: WrenchScrewdriverIcon,
          title: 'Ongoing maintenance',
          body: "Bug fixes on finalized work and small content edits handled as part of your hosting plan. And I'm always just an email away!",
     },
] as const;

const hostingIncludes = [
     'VPS hosting on managed infrastructure',
     'Cloudflare integration',
     'SSL, DNS help, and deploy pipeline',
     'Regular database backups',
     'Bug fixes on finalized work',
     'Minor edits (typos, small content tweaks, adding genes to existing logic, etc.)',
] as const;

/** Splits 6 line items into L/R columns without grid “row” sync (avoids huge gaps when one side wraps more). */
const hostingIncludesColumns = computed(() => ({
     left: hostingIncludes.filter((_, i) => i % 2 === 0),
     right: hostingIncludes.filter((_, i) => i % 2 === 1),
}));

const phases = [
     {
          title: 'Phase 1 — Shell',
          body: 'Global theme, header, footer, home layout scaffold. You see the site take shape early and can redirect before detail work starts.',
     },
     {
          title: 'Phase 2 — Widgets',
          body: 'The interactive bits: carousels, featured/random characters, currency strips, nav badges, any admin-driven content.',
     },
     {
          title: 'Phase 3 — Polish',
          body: 'Responsive pass, accessibility cleanup, edge cases (no eligible character, logged-out states), and performance tuning before launch.',
     },
] as const;

/** Set true to show the FAQ block again. */
const showFaq = false;

const faq = [
     {
          q: 'Do you work on older Lorekeeper installs?',
          a: 'Yes. I regularly update out-of-date installs to current LK versions, including reconciling customizations and extensions that drifted from upstream.',
     },
     {
          q: 'Can I edit the site myself?',
          a: 'For many content areas, yes. I have built in-site admin tooling for events, news, and page content on previous projects, and can scope a similar system for yours.',
     },
     {
          q: "What's included in the $25/month hosting?",
          a: 'Hosting itself, routine updates, backups, bug fixes on finalized work, and minor edits. Larger feature work or redesigns are quoted separately.',
     },
     {
          q: "What's not included?",
          a: 'New features, significant layout changes, new extensions, and anything requiring design work. Those run as scoped engagements on top of hosting.',
     },
     {
          q: 'How do setup timelines work?',
          a: 'A fresh install is typically a short, scoped engagement. Custom layouts and feature work are quoted in phases so you can stop, redirect, or extend between phases.',
     },
     {
          q: 'Do you work with groups of our scale?',
          a: 'I have experience with larger ARPG groups (Nordanner-scale), where performance, moderation, and admin ergonomics matter as much as visual polish.',
     },
] as const;

type ProjectType =
     | 'New setup'
     | 'Reskin'
     | 'Extension'
     | 'Managed hosting'
     | 'Other';

const projectTypes: ProjectType[] = [
     'New setup',
     'Reskin',
     'Extension',
     'Managed hosting',
     'Other',
];

const form = reactive({
     name: '',
     email: '',
     projectType: 'New setup' as ProjectType,
     budget: '',
     message: '',
});

const errors = reactive({
     name: '',
     email: '',
     message: '',
});

const submitted = ref(false);

const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function validate(): boolean {
     errors.name = form.name.trim() ? '' : 'Please enter your name.';
     errors.email = !form.email.trim()
          ? 'Please enter your email.'
          : emailPattern.test(form.email.trim())
            ? ''
            : 'Please enter a valid email.';
     errors.message = form.message.trim() ? '' : 'Please include a message.';
     return !errors.name && !errors.email && !errors.message;
}

const messageMax = 1600;
const messageRemaining = computed(() => messageMax - form.message.length);

function handleSubmit() {
     if (!validate()) return;

     const subject = `Lorekeeper inquiry — ${form.projectType}`;
     const bodyLines = [
          `Name: ${form.name}`,
          `Email: ${form.email}`,
          `Project type: ${form.projectType}`,
     ];
     if (form.budget.trim()) {
          bodyLines.push(`Budget / timeline: ${form.budget}`);
     }
     bodyLines.push('', form.message);

     const href = `mailto:AbatureStudio@gmail.com?subject=${encodeURIComponent(
          subject,
     )}&body=${encodeURIComponent(bodyLines.join('\n'))}`;

     window.location.href = href;
     submitted.value = true;
}
</script>

<template>
     <main
          :class="[
               'flex min-h-screen w-full cursor-default flex-col items-center overflow-x-hidden pb-24 transition-colors duration-300',
               isDark
                    ? 'bg-neutral-900 text-neutral-50'
                    : 'bg-neutral-50 text-neutral-900',
          ]"
          :style="{
               '--accent-color': selectedColor,
               '--selection-bg': selectedColor,
               '--selection-fg': '#171717',
          }">
          <LandingTopControls
               :is-dark="isDark"
               :selected-color="selectedColor"
               :colors="colors"
               :opacity="scrollFadeOpacity"
               @select-color="setSelectedColor"
               @toggle-theme="toggleTheme" />

          <LandingExamplesCta
               :selected-color="selectedColor"
               :is-dark="isDark"
               :opacity="scrollFadeOpacity"
               static-cta
               label="Get in touch"
               scroll-aria-label="Scroll to contact form"
               @navigate="scrollToContact">
               <template #trailing>
                    <ArrowDownIcon
                         class="h-4 w-4 shrink-0"
                         aria-hidden="true" />
               </template>
          </LandingExamplesCta>

          <!-- Hero -->
          <section
               class="content-shell-narrow relative flex min-h-0 flex-col pb-4">
               <div
                    class="font-jetbrains-mono color-animate relative z-10 mt-20 min-h-[90px] text-5xl leading-tight font-bold transition-colors sm:text-6xl md:text-7xl">
                    <span
                         class="underline-animate color-animate pb-2 transition-colors"
                         :style="{
                              '--accent-color': selectedColor,
                              color: selectedColor,
                         }">
                         Lorekeeper Work
                    </span>
               </div>
               <div
                    class="font-inter color-animate relative z-10 mt-2 max-w-none space-y-4 text-base leading-relaxed transition-colors md:text-lg"
                    :class="isDark ? 'text-neutral-200' : 'text-neutral-800'">
                    <p
                         class="font-jetbrains-mono color-animate text-xl leading-snug font-bold transition-colors md:text-2xl">
                         Setup, customization, extensions, and managed
                         hosting<br />
                         for Lorekeeper-based ARPG communities.
                    </p>
                    <p>
                         I build and maintain Lorekeeper installs for ARPG
                         groups, from clean, stable setups to heavily reskinned
                         custom front ends and feature extensions. My focus is
                         on sites that stay reliable as your community grows,
                         with admin ergonomics that can grow to meet your unique
                         group's unique needs.
                    </p>
                    <p>
                         If you already have a site that is drifting, broken, or
                         stuck on an old version, I can pick it up where the
                         last developer left off.
                    </p>
               </div>
          </section>

          <!-- What I do -->
          <section class="content-shell-narrow mt-6 w-full">
               <h2
                    class="font-jetbrains-mono color-animate mb-6 text-3xl font-bold transition-colors">
                    What I do
               </h2>
               <div class="grid gap-4 sm:grid-cols-2">
                    <div
                         v-for="item in deliverables"
                         :key="item.title"
                         class="color-animate rounded-xl border p-5 transition-colors"
                         :class="
                              isDark
                                   ? 'border-neutral-800 bg-neutral-900/60'
                                   : 'border-neutral-200 bg-white'
                         ">
                         <div class="flex items-center gap-2">
                              <component
                                   :is="item.icon"
                                   class="h-5 w-5 shrink-0"
                                   :style="{ color: selectedColor }"
                                   aria-hidden="true" />
                              <h3
                                   class="font-jetbrains-mono text-base font-semibold md:text-lg">
                                   {{ item.title }}
                              </h3>
                         </div>
                         <p
                              class="font-inter color-animate mt-2 text-base leading-relaxed transition-colors md:text-lg"
                              :class="
                                   isDark
                                        ? 'text-neutral-300'
                                        : 'text-neutral-700'
                              ">
                              {{ item.body }}
                         </p>
                    </div>
               </div>
          </section>

          <!-- Managed hosting price tile -->
          <section
               class="mt-16 flex w-full justify-center transition-colors"
               :style="{
                    backgroundColor: selectedColor,
                    color: isDark ? '#171717' : '#fafafa',
               }">
               <div class="content-shell-narrow py-16">
                    <div class="flex flex-col items-center gap-2 text-center">
                         <p
                              class="font-jetbrains-mono text-base tracking-[0.15em] uppercase opacity-80 md:text-lg">
                              Managed hosting
                         </p>
                         <p
                              class="font-jetbrains-mono text-5xl font-bold md:text-6xl">
                              $25<span class="text-2xl md:text-3xl"
                                   >/month</span
                              >
                         </p>
                         <p
                              class="font-inter mt-2 max-w-xl text-base leading-relaxed md:text-lg">
                              Your Lorekeeper site lives on my infrastructure,
                              with upkeep and small fixes rolled in. No hourly
                              invoicing for the little stuff.
                         </p>
                    </div>
                    <div
                         class="font-inter mx-auto mt-8 flex max-w-2xl flex-col gap-6 sm:flex-row sm:items-start sm:gap-8">
                         <ul
                              class="flex min-w-0 flex-1 list-none flex-col gap-2 p-0">
                              <li
                                   v-for="item in hostingIncludesColumns.left"
                                   :key="item"
                                   class="flex items-start gap-2 text-base leading-relaxed md:text-lg">
                                   <CheckIcon
                                        class="mt-1 h-5 w-5 shrink-0"
                                        aria-hidden="true" />
                                   <span>{{ item }}</span>
                              </li>
                         </ul>
                         <ul
                              class="flex min-w-0 flex-1 list-none flex-col gap-2 p-0">
                              <li
                                   v-for="item in hostingIncludesColumns.right"
                                   :key="item"
                                   class="flex items-start gap-2 text-base leading-relaxed md:text-lg">
                                   <CheckIcon
                                        class="mt-1 h-5 w-5 shrink-0"
                                        aria-hidden="true" />
                                   <span>{{ item }}</span>
                              </li>
                         </ul>
                    </div>
                    <div class="mt-8 flex justify-center">
                         <button
                              type="button"
                              class="font-jetbrains-mono inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-base font-semibold transition-none hover:scale-105 focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none md:text-lg"
                              :class="
                                   isDark
                                        ? 'bg-neutral-900 text-neutral-50 focus-visible:ring-neutral-900'
                                        : 'bg-neutral-50 text-neutral-900 focus-visible:ring-neutral-50'
                              "
                              @click="() => scrollToContact()">
                              Ask about hosting
                         </button>
                    </div>
               </div>
          </section>

          <!-- Approach / phases -->
          <section class="content-shell-narrow mt-16 w-full">
               <h2
                    class="font-jetbrains-mono color-animate mb-3 text-3xl font-bold transition-colors">
                    How engagements work
               </h2>
               <p
                    class="font-inter color-animate mb-6 max-w-2xl text-base leading-relaxed transition-colors"
                    :class="isDark ? 'text-neutral-300' : 'text-neutral-700'">
                    Larger builds run in phases. You see working pieces early,
                    get a chance to redirect between phases, and only pay for
                    the scope you actually want to ship.
               </p>
               <ol class="space-y-4">
                    <li
                         v-for="(phase, idx) in phases"
                         :key="phase.title"
                         class="color-animate flex gap-4 rounded-xl border p-5 transition-colors"
                         :class="
                              isDark
                                   ? 'border-neutral-800 bg-neutral-900/60'
                                   : 'border-neutral-200 bg-white'
                         ">
                         <div
                              class="font-jetbrains-mono flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-bold"
                              :style="{
                                   backgroundColor: selectedColor,
                                   color: isDark ? '#171717' : '#fafafa',
                              }">
                              {{ idx + 1 }}
                         </div>
                         <div>
                              <h3
                                   class="font-jetbrains-mono text-base font-semibold">
                                   {{ phase.title }}
                              </h3>
                              <p
                                   class="font-inter color-animate mt-1 text-sm leading-relaxed transition-colors"
                                   :class="
                                        isDark
                                             ? 'text-neutral-300'
                                             : 'text-neutral-700'
                                   ">
                                   {{ phase.body }}
                              </p>
                         </div>
                    </li>
               </ol>
          </section>

          <!-- FAQ (hidden via showFaq) -->
          <section
               v-if="showFaq"
               class="content-shell-narrow mt-16 w-full">
               <h2
                    class="font-jetbrains-mono color-animate mb-6 text-3xl font-bold transition-colors">
                    FAQ
               </h2>
               <dl class="space-y-5">
                    <div
                         v-for="item in faq"
                         :key="item.q"
                         class="color-animate border-b pb-5 transition-colors"
                         :class="
                              isDark
                                   ? 'border-neutral-800'
                                   : 'border-neutral-200'
                         ">
                         <dt
                              class="font-jetbrains-mono text-base font-semibold">
                              {{ item.q }}
                         </dt>
                         <dd
                              class="font-inter color-animate mt-2 text-sm leading-relaxed transition-colors"
                              :class="
                                   isDark
                                        ? 'text-neutral-300'
                                        : 'text-neutral-700'
                              ">
                              {{ item.a }}
                         </dd>
                    </div>
               </dl>
          </section>

          <!-- #contact: tight vertical gap (mt) after content above; minimal scroll-mt — chrome is small corner nav, not a full bar -->
          <section
               class="content-shell-narrow mt-8 w-full sm:mt-10"
               :aria-labelledby="contactAnchorId">
               <h2
                    :id="contactAnchorId"
                    class="font-jetbrains-mono color-animate mb-2 scroll-mt-2 text-3xl font-bold transition-colors sm:scroll-mt-3">
                    Start a conversation
               </h2>
               <p
                    class="font-inter color-animate mb-6 max-w-2xl text-base leading-relaxed transition-colors"
                    :class="isDark ? 'text-neutral-300' : 'text-neutral-700'">
                    Fill this out and it will open your email app with the
                    message pre-filled. No data is submitted anywhere until you
                    hit send in your mail client.
               </p>

               <form
                    class="color-animate space-y-4 rounded-xl border p-5 transition-colors sm:p-6"
                    :class="
                         isDark
                              ? 'border-neutral-800 bg-neutral-900/60'
                              : 'border-neutral-200 bg-white'
                    "
                    novalidate
                    @submit.prevent="handleSubmit">
                    <div class="grid gap-4 sm:grid-cols-2">
                         <label class="font-inter block text-sm">
                              <span class="font-medium">Name</span>
                              <input
                                   v-model="form.name"
                                   type="text"
                                   required
                                   autocomplete="name"
                                   class="color-animate mt-1 block w-full rounded-md border px-3 py-2 text-sm transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--accent-color)]"
                                   :class="
                                        isDark
                                             ? 'border-neutral-700 bg-neutral-950 text-neutral-50'
                                             : 'border-neutral-300 bg-white text-neutral-900'
                                   " />
                              <span
                                   v-if="errors.name"
                                   class="mt-1 block text-xs text-[#F73676]">
                                   {{ errors.name }}
                              </span>
                         </label>

                         <label class="font-inter block text-sm">
                              <span class="font-medium">Email</span>
                              <input
                                   v-model="form.email"
                                   type="email"
                                   required
                                   autocomplete="email"
                                   class="color-animate mt-1 block w-full rounded-md border px-3 py-2 text-sm transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--accent-color)]"
                                   :class="
                                        isDark
                                             ? 'border-neutral-700 bg-neutral-950 text-neutral-50'
                                             : 'border-neutral-300 bg-white text-neutral-900'
                                   " />
                              <span
                                   v-if="errors.email"
                                   class="mt-1 block text-xs text-[#F73676]">
                                   {{ errors.email }}
                              </span>
                         </label>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                         <label class="font-inter block text-sm">
                              <span class="font-medium">Project type</span>
                              <select
                                   v-model="form.projectType"
                                   class="color-animate mt-1 block w-full rounded-md border px-3 py-2 text-sm transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--accent-color)]"
                                   :class="
                                        isDark
                                             ? 'border-neutral-700 bg-neutral-950 text-neutral-50'
                                             : 'border-neutral-300 bg-white text-neutral-900'
                                   ">
                                   <option
                                        v-for="type in projectTypes"
                                        :key="type"
                                        :value="type">
                                        {{ type }}
                                   </option>
                              </select>
                         </label>

                         <label class="font-inter block text-sm">
                              <span class="font-medium">
                                   Budget / timeline
                                   <span class="font-normal opacity-60">
                                        (optional)
                                   </span>
                              </span>
                              <input
                                   v-model="form.budget"
                                   type="text"
                                   placeholder="e.g. launching in 2 months"
                                   class="color-animate mt-1 block w-full rounded-md border px-3 py-2 text-sm transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--accent-color)]"
                                   :class="
                                        isDark
                                             ? 'border-neutral-700 bg-neutral-950 text-neutral-50 placeholder:text-neutral-500'
                                             : 'border-neutral-300 bg-white text-neutral-900 placeholder:text-neutral-400'
                                   " />
                         </label>
                    </div>

                    <label class="font-inter block text-sm">
                         <span class="font-medium">Message</span>
                         <textarea
                              v-model="form.message"
                              required
                              rows="6"
                              :maxlength="messageMax"
                              class="color-animate mt-1 block w-full rounded-md border px-3 py-2 text-sm transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--accent-color)]"
                              :class="
                                   isDark
                                        ? 'border-neutral-700 bg-neutral-950 text-neutral-50'
                                        : 'border-neutral-300 bg-white text-neutral-900'
                              " />
                         <div class="mt-1 flex justify-between text-xs">
                              <span
                                   v-if="errors.message"
                                   class="text-[#F73676]">
                                   {{ errors.message }}
                              </span>
                              <span
                                   v-else
                                   class="opacity-60">
                                   Tell me about your group and what you want
                                   built.
                              </span>
                              <span class="opacity-60">
                                   {{ messageRemaining }} chars left
                              </span>
                         </div>
                    </label>

                    <div class="flex flex-col items-start gap-3 pt-2">
                         <button
                              type="submit"
                              class="font-jetbrains-mono inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition-none hover:scale-105 focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none"
                              :style="{
                                   backgroundColor: selectedColor,
                                   color: isDark ? '#171717' : '#fafafa',
                                   '--tw-ring-color': selectedColor,
                              }">
                              Open in my email app
                         </button>
                         <p
                              class="font-inter text-xs leading-relaxed"
                              :class="
                                   isDark
                                        ? 'text-neutral-400'
                                        : 'text-neutral-600'
                              ">
                              <template v-if="submitted">
                                   Your email app should have opened with the
                                   message pre-filled. If nothing happened,
                                   email
                                   <a
                                        href="mailto:AbatureStudio@gmail.com?subject=Lorekeeper%20inquiry"
                                        class="underline-animate"
                                        :style="{ color: selectedColor }">
                                        AbatureStudio@gmail.com
                                   </a>
                                   directly.
                              </template>
                              <template v-else>
                                   This opens your default email app with the
                                   message filled in. If nothing happens, email
                                   <a
                                        href="mailto:AbatureStudio@gmail.com?subject=Lorekeeper%20inquiry"
                                        class="underline-animate"
                                        :style="{ color: selectedColor }">
                                        AbatureStudio@gmail.com
                                   </a>
                                   directly.
                              </template>
                         </p>
                    </div>
               </form>
          </section>

          <LandingFooter />
     </main>
</template>
