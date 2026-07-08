<script setup lang="ts">
import {
     ArrowDownIcon,
     ArrowsRightLeftIcon,
     ArrowTrendingUpIcon,
     ChatBubbleLeftRightIcon,
     CheckIcon,
     CloudArrowUpIcon,
     CurrencyDollarIcon,
     DocumentTextIcon,
     EnvelopeIcon,
     GlobeAltIcon,
     HandRaisedIcon,
     PaintBrushIcon,
     PuzzlePieceIcon,
     QuestionMarkCircleIcon,
     Squares2X2Icon,
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

/** Id on the “Start a conversation” h2, matches /lorekeeper#contact and Inertia v.reset() hash scroll */
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
     'Default Lorekeeper install & setup',
     'VPS hosting on managed infrastructure',
     'Cloudflare integration',
     'SSL, DNS help, and deploy pipeline',
     'Regular database backups',
     'Bug fixes on finalized work',
     'Minor edits (typos, small content tweaks, adding genes to existing logic, etc.)',
] as const;

/** Headline stats for the DeviantArt → Lorekeeper migration case study. */
const migrationStats = [
     { value: '20,000+', label: 'characters migrated' },
     { value: '~20 hrs', label: 'start to finish' },
     { value: '2,000+', label: 'member group' },
] as const;

/** Splits 6 line items into L/R columns without grid “row” sync (avoids huge gaps when one side wraps more). */
const hostingIncludesColumns = computed(() => ({
     left: hostingIncludes.filter((_, i) => i % 2 === 0),
     right: hostingIncludes.filter((_, i) => i % 2 === 1),
}));

const phases = [
     {
          icon: HandRaisedIcon,
          title: 'First contact',
          body: "We start with a get-to-know-you email. Share any questions, concerns, or must-haves and I'll address them up front.",
     },
     {
          icon: DocumentTextIcon,
          title: 'A shared plan',
          body: 'For deeper customization, I set up a reference document in Google Docs. We populate it with your requests, and I cross items off as they ship. A running session log lives there too, so you can always see exactly where my time went.',
     },
     {
          icon: ArrowTrendingUpIcon,
          title: 'Steady, visible progress',
          body: 'Sessions typically run 1–3 hours, usually with changes to show by the end. I touch base after each one so we stay on the same page and my time goes where you want it.',
     },
     {
          icon: CurrencyDollarIcon,
          title: 'Predictable cost',
          body: 'Monthly caps on dev work are available, keeping the price consistent and manageable while we make steady, ongoing progress.',
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
          q: "What's included in the $45/month hosting?",
          a: 'A default Lorekeeper setup, hosting itself, routine updates, backups, bug fixes on finalized work, and minor edits. Larger feature work or redesigns are quoted at an hourly rate.',
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

const form = reactive({
     name: '',
     email: '',
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

     const subject = 'Lorekeeper inquiry';
     const bodyLines = [`Name: ${form.name}`, `Email: ${form.email}`];
     bodyLines.push('', form.message);

     const href = `mailto:AbatureStudio@gmail.com?subject=${encodeURIComponent(
          subject,
     )}&body=${encodeURIComponent(bodyLines.join('\n'))}`;

     // Trigger via a real anchor click. Assigning window.location.href to a
     // mailto: URI is dropped silently by some browsers, leaving the button
     // looking dead. A synthesized <a> click matches a normal mailto link.
     const link = document.createElement('a');
     link.href = href;
     link.rel = 'noopener';
     document.body.appendChild(link);
     link.click();
     link.remove();

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
                         Lorekeeper
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
                    class="font-jetbrains-mono color-animate mb-6 flex items-center gap-2.5 text-3xl font-bold transition-colors">
                    <Squares2X2Icon
                         class="h-7 w-7 shrink-0"
                         :style="{ color: selectedColor }"
                         aria-hidden="true" />
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

          <!-- Recent work -->
          <section class="content-shell-narrow mt-16 w-full">
               <h2
                    class="font-jetbrains-mono color-animate mb-6 flex items-center gap-2.5 text-3xl font-bold transition-colors">
                    <GlobeAltIcon
                         class="h-7 w-7 shrink-0"
                         :style="{ color: selectedColor }"
                         aria-hidden="true" />
                    Recent work
               </h2>
               <a
                    href="https://arcticsons.online/"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="color-animate group block rounded-xl border p-5 transition-colors hover:scale-[1.01]"
                    :class="
                         isDark
                              ? 'border-neutral-800 bg-neutral-900/60'
                              : 'border-neutral-200 bg-white'
                    ">
                    <div
                         class="arcticsons-frame color-animate mb-4 h-64 w-full overflow-hidden rounded-lg border transition-colors sm:h-72"
                         :class="
                              isDark
                                   ? 'border-neutral-800'
                                   : 'border-neutral-200'
                         ">
                         <img
                              src="/imgs/example-arcticsons.png"
                              alt="Arcticsons Lorekeeper front page"
                              loading="lazy"
                              class="arcticsons-pan block w-full" />
                    </div>
                    <div
                         class="flex flex-wrap items-center justify-between gap-2">
                         <h3 class="font-jetbrains-mono text-lg font-semibold">
                              Arcticsons
                         </h3>
                         <span
                              class="font-jetbrains-mono inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold"
                              :style="{
                                   backgroundColor: selectedColor,
                                   color: isDark ? '#171717' : '#fafafa',
                              }">
                              Live site
                         </span>
                    </div>
                    <p
                         class="font-inter color-animate mt-2 text-base leading-relaxed transition-colors md:text-lg"
                         :class="
                              isDark ? 'text-neutral-300' : 'text-neutral-700'
                         ">
                         A finished Lorekeeper front end with a custom winter
                         theme, with themed nav and panels, a new-character
                         showcase, and the full activity and guide flows,
                         running stable in production.
                    </p>
                    <div class="mt-3 flex justify-end">
                         <span
                              class="underline-animate underline-on-hover font-jetbrains-mono text-sm font-semibold"
                              :style="{ color: selectedColor }">
                              Visit arcticsons.online →
                         </span>
                    </div>
               </a>
          </section>

          <!-- Case study: DeviantArt → Lorekeeper migration -->
          <section class="content-shell-narrow mt-16 w-full">
               <h2
                    class="font-jetbrains-mono color-animate mb-3 flex items-center gap-2.5 text-3xl font-bold transition-colors">
                    <ArrowsRightLeftIcon
                         class="h-7 w-7 shrink-0"
                         :style="{ color: selectedColor }"
                         aria-hidden="true" />
                    Case study, migrating 20,000+ characters
               </h2>
               <div
                    class="font-inter color-animate space-y-4 text-base leading-relaxed transition-colors md:text-lg"
                    :class="isDark ? 'text-neutral-300' : 'text-neutral-700'">
                    <p>
                         A well-established ARPG group with over 2,000 members
                         was moving to Lorekeeper. They handed me a single
                         Google spreadsheet: character records, each linking to
                         art hosted on DeviantArt, plus a little info. Their
                         plan was to recruit members and volunteers to copy it
                         all over by hand, likely hundreds, if not thousands, of
                         man-hours.
                    </p>
                    <p>
                         The catch: DeviantArt's API won't return a deviation
                         from its URL alone. It needs the internal deviation ID.
                         So I pulled the full galleries of several DeviantArt
                         accounts and a group, extracted the character IDs from
                         each deviation, and matched them back to the
                         spreadsheet, debugging mismatches along the way. With
                         IDs linked, I fetched every image and description,
                         converted the art into performant formats, adapted
                         Lorekeeper to accept the group's custom ID scheme, and
                         parsed genetic data straight out of the descriptions to
                         populate the database.
                    </p>
                    <p>
                         What was quoted as hundreds-to-thousands of volunteer
                         hours ran in about twenty. I also built a low-friction
                         admin tool inside the site itself, so staff can fill
                         any gaps by hand in seconds.
                    </p>
               </div>

               <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div
                         v-for="stat in migrationStats"
                         :key="stat.label"
                         class="color-animate rounded-xl border p-5 text-center transition-colors"
                         :class="
                              isDark
                                   ? 'border-neutral-800 bg-neutral-900/60'
                                   : 'border-neutral-200 bg-white'
                         ">
                         <p
                              class="font-jetbrains-mono text-3xl font-bold md:text-4xl"
                              :style="{ color: selectedColor }">
                              {{ stat.value }}
                         </p>
                         <p
                              class="font-inter color-animate mt-1 text-sm transition-colors"
                              :class="
                                   isDark
                                        ? 'text-neutral-400'
                                        : 'text-neutral-600'
                              ">
                              {{ stat.label }}
                         </p>
                    </div>
               </div>

               <p
                    class="font-inter color-animate mt-6 text-base leading-relaxed transition-colors"
                    :class="isDark ? 'text-neutral-300' : 'text-neutral-700'">
                    The pipeline is reusable. If your characters live in
                    spreadsheets or on DeviantArt, this is a solved problem, and
                    it goes faster every time.
               </p>
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
                              $45<span class="text-2xl md:text-3xl"
                                   >/month</span
                              >
                         </p>
                         <p
                              class="font-inter mt-2 max-w-xl text-base leading-relaxed md:text-lg">
                              A default Lorekeeper setup on my managed
                              infrastructure, with upkeep and small fixes rolled
                              in. No hourly invoicing for the little stuff.
                              Custom layouts and feature work are available at
                              an hourly rate. Contact for details.
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
                    <p
                         class="font-inter mx-auto mt-6 max-w-xl text-center text-sm leading-relaxed opacity-80">
                         Dev work is billed transparently. A shared session log
                         and optional monthly caps keep costs predictable, so
                         your bill never runs away from you.
                    </p>
               </div>
          </section>

          <!-- Approach / phases -->
          <section class="content-shell-narrow mt-16 w-full">
               <h2
                    class="font-jetbrains-mono color-animate mb-3 flex items-center gap-2.5 text-3xl font-bold transition-colors">
                    <ChatBubbleLeftRightIcon
                         class="h-7 w-7 shrink-0"
                         :style="{ color: selectedColor }"
                         aria-hidden="true" />
                    How we'll work together
               </h2>
               <p
                    class="font-inter color-animate mb-6 max-w-2xl text-base leading-relaxed transition-colors"
                    :class="isDark ? 'text-neutral-300' : 'text-neutral-700'">
                    Every project starts with a conversation, not a contract.
                    Here's how we work together, from the first email to
                    finished features.
               </p>
               <ol class="space-y-4">
                    <li
                         v-for="phase in phases"
                         :key="phase.title"
                         class="color-animate flex gap-4 rounded-xl border p-5 transition-colors"
                         :class="
                              isDark
                                   ? 'border-neutral-800 bg-neutral-900/60'
                                   : 'border-neutral-200 bg-white'
                         ">
                         <div
                              class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full"
                              :style="{
                                   backgroundColor: selectedColor,
                                   color: isDark ? '#171717' : '#fafafa',
                              }">
                              <component
                                   :is="phase.icon"
                                   class="h-6 w-6"
                                   aria-hidden="true" />
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
                    class="font-jetbrains-mono color-animate mb-6 flex items-center gap-2.5 text-3xl font-bold transition-colors">
                    <QuestionMarkCircleIcon
                         class="h-7 w-7 shrink-0"
                         :style="{ color: selectedColor }"
                         aria-hidden="true" />
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

          <!-- #contact: tight vertical gap (mt) after content above, minimal scroll-mt. Chrome is small corner nav, not a full bar -->
          <section
               class="content-shell-narrow mt-8 w-full sm:mt-10"
               :aria-labelledby="contactAnchorId">
               <h2
                    :id="contactAnchorId"
                    class="font-jetbrains-mono color-animate mb-2 flex scroll-mt-2 items-center gap-2.5 text-3xl font-bold transition-colors sm:scroll-mt-3">
                    <EnvelopeIcon
                         class="h-7 w-7 shrink-0"
                         :style="{ color: selectedColor }"
                         aria-hidden="true" />
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

                    <div class="flex flex-col items-end gap-3 pt-2">
                         <button
                              type="submit"
                              class="font-jetbrains-mono inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition-none hover:scale-105 focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none"
                              :style="{
                                   backgroundColor: selectedColor,
                                   color: isDark ? '#171717' : '#fafafa',
                                   '--tw-ring-color': selectedColor,
                              }">
                              Open In Email App
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

<style scoped>
/* Scrolls the full-page Arcticsons screenshot down inside its fixed frame, then
   fades back to the top. --frame-h is the visible window height, so the scroll
   stops exactly at the image's bottom regardless of its height. No layout shift. */
.arcticsons-frame {
     --frame-h: 16rem;
}

@media (min-width: 640px) {
     .arcticsons-frame {
          --frame-h: 18rem;
     }
}

.arcticsons-pan {
     animation: arcticsons-scroll 18s ease-in-out infinite;
}

@keyframes arcticsons-scroll {
     0%,
     6% {
          transform: translateY(0);
          opacity: 1;
     }
     78% {
          transform: translateY(calc(-100% + var(--frame-h)));
          opacity: 1;
     }
     88% {
          transform: translateY(calc(-100% + var(--frame-h)));
          opacity: 0;
     }
     89% {
          transform: translateY(0);
          opacity: 0;
     }
     100% {
          transform: translateY(0);
          opacity: 1;
     }
}

/* TEMP: reduced-motion guard disabled for testing — re-enable before shipping.
@media (prefers-reduced-motion: reduce) {
     .arcticsons-pan {
          animation: none;
     }
}
*/
</style>
