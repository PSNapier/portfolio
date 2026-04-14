<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    post: {
        title: string;
        slug: string;
        excerpt: string | null;
        published_at: string | null;
    };
}>();
</script>

<template>
    <article class="rounded-lg border border-neutral-200 p-5 dark:border-neutral-800">
        <p class="font-mono mb-2 text-xs uppercase tracking-wide text-neutral-500">
            {{ post.published_at ?? 'Draft' }}
        </p>
        <h2 class="text-xl font-semibold">
            <Link
                :href="route('blog.show', post.slug)"
                class="underline-offset-4 transition-colors duration-[var(--motion-duration-color)] ease-[var(--motion-ease-standard)] hover:underline focus-visible:ring-2 focus-visible:ring-[var(--accent-color)] focus-visible:ring-offset-2 focus-visible:outline-none"
                :style="{ color: 'var(--accent-color)' }">
                {{ post.title }}
            </Link>
        </h2>
        <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-300">
            {{ post.excerpt ?? '' }}
        </p>
    </article>
</template>
