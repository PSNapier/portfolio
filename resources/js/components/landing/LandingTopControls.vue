<script setup lang="ts">
import {
     Bars3Icon,
     BookOpenIcon,
     DocumentTextIcon,
     MoonIcon,
     NewspaperIcon,
     SunIcon,
     XMarkIcon,
} from '@heroicons/vue/24/outline';
import { Link, usePage } from '@inertiajs/vue3';
import { IconBrandGithub, IconLayoutGrid } from '@tabler/icons-vue';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

const page = usePage();
const showLorekeeper = computed(() => page.props.showLorekeeper);
const showResume = computed(() => page.props.showResume);

defineProps<{
     isDark: boolean;
     selectedColor: string;
     colors: string[];
     opacity: number;
}>();

const emit = defineEmits<{
     toggleTheme: [];
     selectColor: [color: string];
}>();

const isLandingRoute = route().current('landing');
const isLorekeeperRoute = route().current('lorekeeper');
const isBlogIndexRoute = route().current('blog.index');
const isResumeRoute = route().current('resume');
const isMobileMenuOpen = ref(false);
const mobileMenuRoot = ref<HTMLElement | null>(null);

function closeMobileMenu() {
     isMobileMenuOpen.value = false;
}

function toggleMobileMenu() {
     isMobileMenuOpen.value = !isMobileMenuOpen.value;
}

function handlePointerDown(event: PointerEvent) {
     if (!isMobileMenuOpen.value || !mobileMenuRoot.value) {
          return;
     }

     const target = event.target;
     if (!(target instanceof Node)) {
          return;
     }

     if (!mobileMenuRoot.value.contains(target)) {
          closeMobileMenu();
     }
}

function handleKeyDown(event: KeyboardEvent) {
     if (event.key === 'Escape') {
          closeMobileMenu();
     }
}

onMounted(() => {
     window.addEventListener('pointerdown', handlePointerDown);
     window.addEventListener('keydown', handleKeyDown);
});

onBeforeUnmount(() => {
     window.removeEventListener('pointerdown', handlePointerDown);
     window.removeEventListener('keydown', handleKeyDown);
});
</script>

<template>
     <div
          ref="mobileMenuRoot"
          class="fixed inset-x-0 top-0 z-30 sm:hidden"
          :inert="opacity < 0.02"
          :style="{
               opacity,
               pointerEvents: opacity < 0.02 ? 'none' : 'auto',
          }"
          :aria-hidden="opacity < 0.02">
          <div
               class="w-full px-3 pt-3 pb-2 shadow-lg transition-[background-color,border-radius] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)]"
               :style="{ backgroundColor: selectedColor }">
               <button
                    type="button"
                    class="ml-auto flex h-9 w-9 items-center justify-center rounded-lg transition-transform duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none"
                    :class="
                         isDark
                              ? 'text-neutral-900 focus-visible:ring-neutral-900'
                              : 'text-neutral-50 focus-visible:ring-neutral-50'
                    "
                    :aria-expanded="isMobileMenuOpen"
                    aria-controls="mobile-top-controls-menu"
                    aria-label="Toggle navigation menu"
                    @click="toggleMobileMenu">
                    <component
                         :is="isMobileMenuOpen ? XMarkIcon : Bars3Icon"
                         class="h-6 w-6" />
               </button>

               <div
                    v-if="isMobileMenuOpen"
                    id="mobile-top-controls-menu"
                    class="mt-3 flex min-w-[12rem] flex-col items-end gap-3 pb-2 text-right">
                    <Link
                         :href="route('landing')"
                         class="font-jetbrains-mono inline-flex items-center gap-2 text-lg font-medium decoration-transparent decoration-1 underline-offset-4 transition-[text-decoration-color,transform,opacity] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 hover:underline hover:decoration-current focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none"
                         :class="[
                              isDark
                                   ? 'text-neutral-900 focus-visible:ring-neutral-900'
                                   : 'text-neutral-50 focus-visible:ring-neutral-50',
                              isLandingRoute
                                   ? 'opacity-60 hover:scale-100 hover:no-underline'
                                   : '',
                         ]"
                         @click="closeMobileMenu">
                         <IconLayoutGrid
                              class="h-4 w-4"
                              aria-hidden="true" />
                         Portfolio
                    </Link>
                    <Link
                         v-if="showLorekeeper"
                         :href="route('lorekeeper')"
                         class="font-jetbrains-mono inline-flex items-center gap-2 text-lg font-medium decoration-transparent decoration-1 underline-offset-4 transition-[text-decoration-color,transform,opacity] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 hover:underline hover:decoration-current focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none"
                         :class="[
                              isDark
                                   ? 'text-neutral-900 focus-visible:ring-neutral-900'
                                   : 'text-neutral-50 focus-visible:ring-neutral-50',
                              isLorekeeperRoute
                                   ? 'opacity-60 hover:scale-100 hover:no-underline'
                                   : '',
                         ]"
                         @click="closeMobileMenu">
                         <BookOpenIcon
                              class="h-4 w-4"
                              aria-hidden="true" />
                         Lorekeeper
                    </Link>
                    <Link
                         :href="route('blog.index')"
                         class="font-jetbrains-mono inline-flex items-center gap-2 text-lg font-medium decoration-transparent decoration-1 underline-offset-4 transition-[text-decoration-color,transform,opacity] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 hover:underline hover:decoration-current focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none"
                         :class="[
                              isDark
                                   ? 'text-neutral-900 focus-visible:ring-neutral-900'
                                   : 'text-neutral-50 focus-visible:ring-neutral-50',
                              isBlogIndexRoute
                                   ? 'opacity-60 hover:scale-100 hover:no-underline'
                                   : '',
                         ]"
                         @click="closeMobileMenu">
                         <NewspaperIcon
                              class="h-4 w-4"
                              aria-hidden="true" />
                         Blog
                    </Link>
                    <a
                         href="https://github.com/PSNapier"
                         target="_blank"
                         rel="noreferrer noopener"
                         class="font-jetbrains-mono inline-flex items-center gap-2 text-lg font-medium decoration-transparent decoration-1 underline-offset-4 transition-[text-decoration-color,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 hover:underline hover:decoration-current focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none"
                         :class="
                              isDark
                                   ? 'text-neutral-900 focus-visible:ring-neutral-900'
                                   : 'text-neutral-50 focus-visible:ring-neutral-50'
                         "
                         @click="closeMobileMenu">
                         <IconBrandGithub
                              class="h-4 w-4"
                              aria-hidden="true" />
                         GitHub
                    </a>
                    <Link
                         v-if="showResume"
                         :href="route('resume')"
                         class="font-jetbrains-mono inline-flex items-center gap-2 text-lg font-medium decoration-transparent decoration-1 underline-offset-4 transition-[text-decoration-color,transform,opacity] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 hover:underline hover:decoration-current focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none"
                         :class="[
                              isDark
                                   ? 'text-neutral-900 focus-visible:ring-neutral-900'
                                   : 'text-neutral-50 focus-visible:ring-neutral-50',
                              isResumeRoute
                                   ? 'opacity-60 hover:scale-100 hover:no-underline'
                                   : '',
                         ]"
                         @click="closeMobileMenu">
                         <DocumentTextIcon
                              class="h-4 w-4"
                              aria-hidden="true" />
                         Resume
                    </Link>

                    <div
                         class="mt-1 flex items-center gap-2 rounded-full px-2 py-1 transition-colors duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)]"
                         :class="isDark ? 'bg-neutral-900/85' : 'bg-white/90'">
                         <button
                              v-for="(color, idx) in colors"
                              :key="idx"
                              type="button"
                              :style="{ backgroundColor: color }"
                              class="h-4 w-4 cursor-pointer rounded-full transition-transform duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-125 focus-visible:ring-2 focus-visible:ring-neutral-900 focus-visible:ring-offset-1 focus-visible:outline-none"
                              :aria-label="`Select accent color ${idx + 1}`"
                              @click="emit('selectColor', color)" />
                         <button
                              type="button"
                              class="ml-1 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-transparent transition-transform duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-110 focus-visible:ring-2 focus-visible:ring-[var(--accent-color)] focus-visible:ring-offset-2 focus-visible:outline-none"
                              :aria-label="
                                   isDark
                                        ? 'Switch to light mode'
                                        : 'Switch to dark mode'
                              "
                              @click="emit('toggleTheme')">
                              <component
                                   :is="isDark ? SunIcon : MoonIcon"
                                   class="h-5 w-5"
                                   :style="{ color: selectedColor }" />
                         </button>
                    </div>
               </div>
          </div>
     </div>

     <div
          class="fixed top-3 left-3 z-30 hidden transition-[opacity,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] sm:top-6 sm:left-8 sm:block"
          :inert="opacity < 0.02"
          :style="{
               opacity,
               pointerEvents: opacity < 0.02 ? 'none' : 'auto',
          }"
          :aria-hidden="opacity < 0.02">
          <nav class="flex h-8 items-end gap-4 pb-2">
               <Link
                    :href="route('landing')"
                    class="font-jetbrains-mono color-animate inline-flex items-center gap-1 text-sm font-semibold decoration-transparent decoration-1 underline-offset-4 transition-[color,text-decoration-color,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 hover:underline hover:decoration-current focus-visible:ring-2 focus-visible:ring-[var(--accent-color)] focus-visible:ring-offset-2 focus-visible:outline-none"
                    :class="
                         isLandingRoute
                              ? 'text-neutral-500 hover:scale-100 hover:no-underline dark:text-neutral-400'
                              : ''
                    "
                    :style="
                         isLandingRoute ? undefined : { color: selectedColor }
                    ">
                    <IconLayoutGrid
                         class="h-4 w-4"
                         aria-hidden="true" />
                    Portfolio
               </Link>
               <Link
                    v-if="showLorekeeper"
                    :href="route('lorekeeper')"
                    class="font-jetbrains-mono color-animate inline-flex items-center gap-1 text-sm font-semibold decoration-transparent decoration-1 underline-offset-4 transition-[color,text-decoration-color,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 hover:underline hover:decoration-current focus-visible:ring-2 focus-visible:ring-[var(--accent-color)] focus-visible:ring-offset-2 focus-visible:outline-none"
                    :class="
                         isLorekeeperRoute
                              ? 'text-neutral-500 hover:scale-100 hover:no-underline dark:text-neutral-400'
                              : ''
                    "
                    :style="
                         isLorekeeperRoute
                              ? undefined
                              : { color: selectedColor }
                    ">
                    <BookOpenIcon
                         class="h-4 w-4"
                         aria-hidden="true" />
                    Lorekeeper
               </Link>
               <Link
                    :href="route('blog.index')"
                    class="font-jetbrains-mono color-animate inline-flex items-center gap-1 text-sm font-semibold decoration-transparent decoration-1 underline-offset-4 transition-[color,text-decoration-color,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 hover:underline hover:decoration-current focus-visible:ring-2 focus-visible:ring-[var(--accent-color)] focus-visible:ring-offset-2 focus-visible:outline-none"
                    :class="
                         isBlogIndexRoute
                              ? 'text-neutral-500 hover:scale-100 hover:no-underline dark:text-neutral-400'
                              : ''
                    "
                    :style="
                         isBlogIndexRoute ? undefined : { color: selectedColor }
                    ">
                    <NewspaperIcon
                         class="h-4 w-4"
                         aria-hidden="true" />
                    Blog
               </Link>
               <a
                    href="https://github.com/PSNapier"
                    target="_blank"
                    rel="noreferrer noopener"
                    class="font-jetbrains-mono color-animate inline-flex items-center gap-1 text-sm font-semibold decoration-transparent decoration-1 underline-offset-4 transition-[color,text-decoration-color,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 hover:underline hover:decoration-current focus-visible:ring-2 focus-visible:ring-[var(--accent-color)] focus-visible:ring-offset-2 focus-visible:outline-none"
                    :style="{ color: selectedColor }">
                    <IconBrandGithub
                         class="h-4 w-4"
                         aria-hidden="true" />
                    GitHub
               </a>
               <Link
                    v-if="showResume"
                    :href="route('resume')"
                    class="font-jetbrains-mono color-animate inline-flex items-center gap-1 text-sm font-semibold decoration-transparent decoration-1 underline-offset-4 transition-[color,text-decoration-color,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-105 hover:underline hover:decoration-current focus-visible:ring-2 focus-visible:ring-[var(--accent-color)] focus-visible:ring-offset-2 focus-visible:outline-none"
                    :class="
                         isResumeRoute
                              ? 'text-neutral-500 hover:scale-100 hover:no-underline dark:text-neutral-400'
                              : ''
                    "
                    :style="
                         isResumeRoute ? undefined : { color: selectedColor }
                    ">
                    <DocumentTextIcon
                         class="h-4 w-4"
                         aria-hidden="true" />
                    Resume
               </Link>
          </nav>
     </div>

     <div
          class="fixed top-3 right-3 z-30 hidden items-center gap-2 transition-[opacity,transform] duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] sm:top-6 sm:right-8 sm:flex sm:gap-3"
          :inert="opacity < 0.02"
          :style="{
               opacity,
               pointerEvents: opacity < 0.02 ? 'none' : 'auto',
          }"
          :aria-hidden="opacity < 0.02">
          <div
               v-for="(color, idx) in colors"
               :key="idx"
               :style="{ backgroundColor: color }"
               class="h-4 w-4 cursor-pointer rounded-full transition-transform duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-125"
               @click="emit('selectColor', color)" />
          <button
               class="ml-2 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full border transition-colors transition-transform duration-[var(--motion-duration-micro)] ease-[var(--motion-ease-micro)] hover:scale-125 focus-visible:ring-2 focus-visible:ring-[var(--accent-color)] focus-visible:ring-offset-2 focus-visible:outline-none sm:ml-4"
               :class="
                    isDark
                         ? 'border-neutral-200 bg-neutral-50'
                         : 'border-neutral-600 bg-neutral-800'
               "
               :aria-label="
                    isDark ? 'Switch to light mode' : 'Switch to dark mode'
               "
               @click="emit('toggleTheme')">
               <component
                    :is="isDark ? SunIcon : MoonIcon"
                    :class="'h-5 w-5'"
                    :style="{ color: selectedColor }" />
          </button>
     </div>
</template>
