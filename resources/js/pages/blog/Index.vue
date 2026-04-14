<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';

type BlogPostPreview = {
    title: string;
    slug: string;
    excerpt: string | null;
    tags: string[];
    published_at: string | null;
};

type PostsPayload = {
    data: BlogPostPreview[];
    current_page: number;
    last_page: number;
    next_page_url: string | null;
    links: Array<{ url: string | null; label: string; active: boolean }>;
};

type Filters = {
    search: string;
    tag: string;
    sort: string;
};

const props = defineProps<{
    posts: PostsPayload;
    filters: Filters;
    availableTags: string[];
}>();

const search = ref(props.filters.search ?? '');
const selectedTag = ref(props.filters.tag ?? '');
const sort = ref(props.filters.sort ?? 'newest');

const modeKey = 'blog-view-mode';
const viewMode = ref<'paginated' | 'infinite'>('paginated');
const visiblePosts = ref<BlogPostPreview[]>(props.posts.data);
const currentPage = ref(props.posts.current_page);
const lastPage = ref(props.posts.last_page);
const nextPageUrl = ref<string | null>(props.posts.next_page_url);
const isLoadingMore = ref(false);
const sentinel = ref<HTMLElement | null>(null);
let observer: IntersectionObserver | null = null;

const hasMore = computed(() => {
    return viewMode.value === 'infinite' && nextPageUrl.value !== null;
});

function formatPageLabel(label: string) {
    return label
        .replaceAll('&laquo;', '«')
        .replaceAll('&raquo;', '»')
        .replaceAll('&amp;', '&')
        .trim();
}

function applyFilters() {
    router.get(
        route('blog.index'),
        {
            search: search.value || undefined,
            tag: selectedTag.value || undefined,
            sort: sort.value === 'newest' ? undefined : sort.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}

function setViewMode(mode: 'paginated' | 'infinite') {
    viewMode.value = mode;
    localStorage.setItem(modeKey, mode);
}

async function loadMore() {
    if (!nextPageUrl.value || isLoadingMore.value || viewMode.value !== 'infinite') {
        return;
    }

    isLoadingMore.value = true;

    try {
        const response = await fetch(nextPageUrl.value, {
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        const payload = (await response.json()) as PostsPayload;

        visiblePosts.value = [...visiblePosts.value, ...payload.data];
        currentPage.value = payload.current_page;
        lastPage.value = payload.last_page;
        nextPageUrl.value = payload.next_page_url;
    } finally {
        isLoadingMore.value = false;
    }
}

function setupObserver() {
    observer?.disconnect();

    if (!sentinel.value) {
        return;
    }

    observer = new IntersectionObserver((entries) => {
        for (const entry of entries) {
            if (entry.isIntersecting) {
                void loadMore();
            }
        }
    });

    observer.observe(sentinel.value);
}

watch(
    () => props.posts,
    (payload) => {
        visiblePosts.value = payload.data;
        currentPage.value = payload.current_page;
        lastPage.value = payload.last_page;
        nextPageUrl.value = payload.next_page_url;
    }
);

watch(viewMode, async (mode) => {
    if (mode !== 'infinite') {
        return;
    }

    await nextTick();
    setupObserver();
});

onMounted(async () => {
    const saved = localStorage.getItem(modeKey);
    if (saved === 'infinite' || saved === 'paginated') {
        viewMode.value = saved;
    }

    if (viewMode.value === 'infinite') {
        await nextTick();
        setupObserver();
    }
});

onBeforeUnmount(() => {
    observer?.disconnect();
});
</script>

<template>
    <Head title="Blog" />

    <main class="mx-auto w-full max-w-4xl px-4 py-12 sm:px-6">
        <div class="mb-8 flex flex-col gap-4">
            <div class="flex items-center justify-between gap-3">
                <h1 class="text-3xl font-bold">Blog</h1>
                <Link :href="route('landing')" class="text-sm underline underline-offset-4">
                    Back to landing
                </Link>
            </div>

            <div class="grid gap-3 sm:grid-cols-4">
                <input
                    v-model="search"
                    type="search"
                    placeholder="Search posts"
                    class="rounded-md border border-neutral-300 px-3 py-2 sm:col-span-2 dark:border-neutral-700 dark:bg-neutral-900"
                    @keyup.enter="applyFilters" />

                <select
                    v-model="sort"
                    class="rounded-md border border-neutral-300 px-3 py-2 dark:border-neutral-700 dark:bg-neutral-900"
                    @change="applyFilters">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                    <option value="title">Title</option>
                </select>

                <button
                    type="button"
                    class="rounded-md border border-neutral-300 px-3 py-2 text-sm font-medium dark:border-neutral-700"
                    @click="applyFilters">
                    Apply
                </button>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button
                    type="button"
                    class="rounded-full border px-3 py-1 text-xs"
                    :class="selectedTag === '' ? 'border-neutral-900 dark:border-neutral-100' : 'border-neutral-300 dark:border-neutral-700'"
                    @click="selectedTag = ''; applyFilters()">
                    All tags
                </button>
                <button
                    v-for="tagName in availableTags"
                    :key="tagName"
                    type="button"
                    class="rounded-full border px-3 py-1 text-xs"
                    :class="selectedTag === tagName ? 'border-neutral-900 dark:border-neutral-100' : 'border-neutral-300 dark:border-neutral-700'"
                    @click="selectedTag = tagName; applyFilters()">
                    {{ tagName }}
                </button>
            </div>

            <div class="flex items-center gap-2 text-sm">
                <span>View:</span>
                <button
                    type="button"
                    class="rounded border px-2 py-1"
                    :class="viewMode === 'paginated' ? 'border-neutral-900 dark:border-neutral-100' : 'border-neutral-300 dark:border-neutral-700'"
                    @click="setViewMode('paginated')">
                    Paginated
                </button>
                <button
                    type="button"
                    class="rounded border px-2 py-1"
                    :class="viewMode === 'infinite' ? 'border-neutral-900 dark:border-neutral-100' : 'border-neutral-300 dark:border-neutral-700'"
                    @click="setViewMode('infinite')">
                    Infinite
                </button>
            </div>
        </div>

        <div class="space-y-6">
            <article
                v-for="post in visiblePosts"
                :key="post.slug"
                class="rounded-lg border border-neutral-200 p-5 dark:border-neutral-800">
                <p class="mb-2 text-xs uppercase tracking-wide text-neutral-500">
                    {{ post.published_at ?? 'Draft' }}
                </p>
                <h2 class="text-xl font-semibold">
                    <Link :href="route('blog.show', post.slug)" class="underline-offset-4 hover:underline">
                        {{ post.title }}
                    </Link>
                </h2>
                <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-300">
                    {{ post.excerpt ?? '' }}
                </p>
                <div class="mt-3 flex flex-wrap gap-2">
                    <span
                        v-for="tag in post.tags"
                        :key="`${post.slug}-${tag}`"
                        class="rounded-full border border-neutral-300 px-2 py-0.5 text-xs dark:border-neutral-700">
                        {{ tag }}
                    </span>
                </div>
            </article>
        </div>

        <div v-if="viewMode === 'paginated'" class="mt-8 flex flex-wrap gap-2">
            <template v-for="link in posts.links" :key="link.label">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    class="rounded border px-3 py-1 text-sm"
                    :class="link.active ? 'border-neutral-900 dark:border-neutral-100' : 'border-neutral-300 dark:border-neutral-700'"
                    preserve-scroll>
                    {{ formatPageLabel(link.label) }}
                </Link>
                <span
                    v-else
                    class="rounded border border-neutral-200 px-3 py-1 text-sm opacity-50 dark:border-neutral-800">
                    {{ formatPageLabel(link.label) }}
                </span>
            </template>
        </div>

        <div v-else class="mt-8">
            <div ref="sentinel" class="h-8" />
            <p class="text-sm text-neutral-500">
                <span v-if="isLoadingMore">Loading more posts...</span>
                <span v-else-if="!hasMore">All posts loaded ({{ currentPage }}/{{ lastPage }} pages).</span>
            </p>
        </div>
    </main>
</template>
