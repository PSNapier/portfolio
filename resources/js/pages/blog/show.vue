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

     <BlogPageShell shell-class="content-shell-narrow">
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
                    class="prose prose-neutral dark:prose-invert prose-lg max-w-none md-preview"
                    v-html="post.rendered_body" />
          </article>
     </BlogPageShell>
</template>

<style scoped>
.underline-animate {
     text-decoration: underline;
     text-decoration-color: currentColor;
     text-decoration-thickness: max(2px, 0.08em);
     text-underline-offset: 0.14em;
     text-decoration-skip-ink: auto;
     transition:
          color var(--motion-duration-color) var(--motion-ease-standard),
          text-decoration-color var(--motion-duration-color)
               var(--motion-ease-standard);
}

/* ── Body rhythm ────────────────────────────────────────── */
:deep(.md-preview p) {
     font-size: 1.25rem;
     line-height: 1.7;
     margin-bottom: 0.75em;
}

/* ── Markdown-preview decorators ───────────────────────── */

:deep(.md-preview h1),
:deep(.md-preview h2),
:deep(.md-preview h3),
:deep(.md-preview h4) {
     font-family: 'JetBrains Mono', monospace;
     font-weight: 700;
     letter-spacing: -0.03em;
}

:deep(.md-preview h1) { font-size: 2.75rem; line-height: 1.15; margin-top: 2.5rem; margin-bottom: 1rem; }
:deep(.md-preview h2) { font-size: 2.1rem;  line-height: 1.2;  margin-top: 2.25rem; margin-bottom: 0.875rem; }
:deep(.md-preview h3) { font-size: 1.5rem;  line-height: 1.3;  margin-top: 2rem; margin-bottom: 0.75rem; }
:deep(.md-preview h4) { font-size: 1.2rem;  line-height: 1.35; margin-top: 1.75rem; margin-bottom: 0.5rem; }

:deep(.md-preview h1::before),
:deep(.md-preview h2::before),
:deep(.md-preview h3::before),
:deep(.md-preview h4::before) {
     font-family: 'JetBrains Mono', monospace;
     color: var(--accent-color, #1ECFE6);
     font-weight: 400;
     font-size: 0.75em;
     margin-right: 0.45em;
     transition: color var(--motion-duration-color) var(--motion-ease-standard);
}

:deep(.md-preview h1::before) { content: '#'; }
:deep(.md-preview h2::before) { content: '##'; }
:deep(.md-preview h3::before) { content: '###'; }
:deep(.md-preview h4::before) { content: '####'; }

/* Links */
:deep(.md-preview a) {
     font-family: 'JetBrains Mono', monospace;
     color: var(--accent-color, #1ECFE6);
     text-decoration: underline;
     text-decoration-color: transparent;
     text-decoration-thickness: 1px;
     text-underline-offset: 0.18em;
     transition: color var(--motion-duration-color) var(--motion-ease-standard);
}
:deep(.md-preview a:hover) {
     text-decoration-color: currentColor;
}

/* Unordered list — dash markers */
:deep(.md-preview ul) { list-style: none; padding-left: 1.6em; margin-top: 0.25em; margin-bottom: 1.25em; }
:deep(.md-preview ul > li) { position: relative; font-size: 1.25rem; line-height: 1.7; }
:deep(.md-preview ul > li::before) {
     content: '-';
     position: absolute;
     left: -1.4em;
     font-family: 'JetBrains Mono', monospace;
     color: var(--accent-color, #1ECFE6);
     font-weight: 400;
     font-size: 1em;
     opacity: 0.7;
     transition: color var(--motion-duration-color) var(--motion-ease-standard);
}

/* Horizontal rule — rendered as --- */
:deep(.md-preview hr) {
     border: none;
     margin: 2rem 0;
     height: auto;
     overflow: visible;
}
:deep(.md-preview hr::before) {
     content: '---';
     font-family: 'JetBrains Mono', monospace;
     color: var(--accent-color, #1ECFE6);
     font-size: 0.9rem;
     font-weight: 400;
     letter-spacing: 0.25em;
     transition: color var(--motion-duration-color) var(--motion-ease-standard);
     display: block;
     text-align: center;
}

/* Blockquote — > marker */
:deep(.md-preview blockquote) {
     border-left: 2px solid var(--accent-color, #1ECFE6);
     padding-left: 1.2em;
     font-style: normal;
     opacity: 0.8;
}
:deep(.md-preview blockquote p:first-child::before) {
     content: '> ';
     font-family: 'JetBrains Mono', monospace;
     color: var(--accent-color, #1ECFE6);
     font-size: 0.85em;
     opacity: 0.65;
}
:deep(.md-preview blockquote p:first-child::after) { content: ''; }

/* Inline code */
:deep(.md-preview :not(pre) > code) {
     font-family: 'JetBrains Mono', monospace;
     font-size: 0.85em;
     padding: 0.15em 0.4em;
    border-radius: 2px;
     background: color-mix(in srgb, var(--accent-color, #1ECFE6) 12%, transparent);
     color: var(--accent-color, #1ECFE6);
     font-weight: 500;
}

/* Code blocks */
:deep(.md-preview pre) {
     border: 1px solid color-mix(in srgb, var(--accent-color, #1ECFE6) 20%, transparent);
    border-radius: 4px;
     font-family: 'JetBrains Mono', monospace;
     font-size: 0.875em;
}
:deep(.md-preview pre code) {
     font-family: 'JetBrains Mono', monospace;
     background: transparent;
     color: inherit;
     padding: 0;
}
</style>
