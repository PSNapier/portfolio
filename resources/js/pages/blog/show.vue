<script setup lang="ts">
import { ClockIcon } from '@heroicons/vue/24/outline';
import { Head } from '@inertiajs/vue3';
import BlogPageShell from '../../components/blog/BlogPageShell.vue';

interface BlogPost {
     title: string;
     slug: string;
     excerpt: string | null;
     rendered_excerpt: string | null;
     published_at: string | null;
     rendered_body: string;
}

interface BlogShowPageProps {
     post: BlogPost;
}

const props = defineProps<BlogShowPageProps>();

function formatDate(dateStr: string | null): string {
     if (!dateStr) return 'Draft';
     const d = new Date(dateStr);
     return d.toLocaleDateString('en-CA'); // YYYY-MM-DD
}
</script>

<template>
     <Head :title="post.title" />

     <BlogPageShell
          v-slot="{ isDark }"
          shell-class="content-shell-narrow">
          <article>
               <h1
                    class="font-jetbrains-mono color-animate mb-4 text-5xl leading-tight font-bold transition-colors md:text-7xl"
                    :style="{ color: 'var(--accent-color, #1ECFE6)' }">
                    <span class="underline-animate color-animate">
                         {{ post.title }}
                    </span>
               </h1>
               <p
                    class="font-jetbrains-mono color-animate mb-6 text-xl leading-snug font-semibold transition-colors md:text-2xl [&_a]:underline [&_a]:decoration-current [&_em]:italic [&_strong]:font-bold">
                    <ClockIcon
                         class="mr-1.5 inline size-5 md:size-6"
                         style="vertical-align: -0.1em"
                         aria-hidden="true" />{{
                         formatDate(props.post.published_at)
                    }}<template v-if="post.rendered_excerpt">
                         – <span v-html="post.rendered_excerpt" /></template
                    >
               </p>

               <div
                    :class="[
                         'markdown-content prose prose-lg prose-neutral max-w-none',
                         isDark && 'prose-invert',
                    ]"
                    v-html="post.rendered_body" />
          </article>
     </BlogPageShell>
</template>
