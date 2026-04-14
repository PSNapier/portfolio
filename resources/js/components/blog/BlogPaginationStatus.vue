<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    viewMode: 'paginated' | 'infinite';
    links: Array<{ url: string | null; label: string; active: boolean }>;
    currentPage: number;
    lastPage: number;
    isLoadingMore: boolean;
    hasMore: boolean;
}>();
</script>

<template>
    <div v-if="viewMode === 'paginated'" class="mt-8 flex flex-wrap gap-2">
        <template v-for="link in links" :key="link.label">
            <Link
                v-if="link.url"
                :href="link.url"
                class="rounded border px-3 py-1 text-sm transition-colors duration-[var(--motion-duration-color)] ease-[var(--motion-ease-standard)] focus-visible:ring-2 focus-visible:ring-[var(--accent-color)] focus-visible:ring-offset-2 focus-visible:outline-none"
                :class="link.active ? 'border-[var(--accent-color)]' : 'border-neutral-300 dark:border-neutral-700'"
                preserve-scroll>
                {{ link.label
                    .replaceAll('&laquo;', '«')
                    .replaceAll('&raquo;', '»')
                    .replaceAll('&amp;', '&')
                    .trim() }}
            </Link>
            <span
                v-else
                class="rounded border border-neutral-200 px-3 py-1 text-sm opacity-50 dark:border-neutral-800">
                {{ link.label
                    .replaceAll('&laquo;', '«')
                    .replaceAll('&raquo;', '»')
                    .replaceAll('&amp;', '&')
                    .trim() }}
            </span>
        </template>
    </div>

    <div v-else class="mt-8">
        <slot name="sentinel" />
        <p class="text-sm text-neutral-500">
            <span v-if="isLoadingMore">Loading more posts...</span>
            <span v-else-if="!hasMore">All posts loaded ({{ currentPage }}/{{ lastPage }} pages).</span>
        </p>
    </div>
</template>
