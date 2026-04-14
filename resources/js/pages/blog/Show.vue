<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

type BlogPost = {
    title: string;
    slug: string;
    excerpt: string | null;
    tags: string[];
    published_at: string | null;
    rendered_body: string;
};

defineProps<{
    post: BlogPost;
}>();
</script>

<template>
    <Head :title="post.title" />

    <main class="mx-auto w-full max-w-3xl px-4 py-12 sm:px-6">
        <div class="mb-8 flex items-center justify-between gap-3">
            <Link :href="route('blog.index')" class="text-sm underline underline-offset-4">
                Back to blog
            </Link>
            <p class="text-xs uppercase tracking-wide text-neutral-500">
                {{ post.published_at ?? 'Draft' }}
            </p>
        </div>

        <article>
            <h1 class="mb-2 text-3xl font-bold">{{ post.title }}</h1>
            <p v-if="post.excerpt" class="mb-4 text-neutral-600 dark:text-neutral-300">
                {{ post.excerpt }}
            </p>

            <div class="mb-8 flex flex-wrap gap-2">
                <span
                    v-for="tag in post.tags"
                    :key="tag"
                    class="rounded-full border border-neutral-300 px-2 py-0.5 text-xs dark:border-neutral-700">
                    {{ tag }}
                </span>
            </div>

            <div
                class="prose prose-neutral max-w-none dark:prose-invert"
                v-html="post.rendered_body" />
        </article>
    </main>
</template>
