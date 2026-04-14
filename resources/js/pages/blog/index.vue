<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
     IconBinaryTree2,
     IconBrackets,
     IconFilePencil,
     IconLayoutDashboard,
     IconMarkdown,
     IconMoonStars,
     IconPalette,
     IconPencil,
     IconRefresh,
     IconRocket,
     IconShieldLock,
     IconTargetArrow,
     IconFileText,
} from '@tabler/icons-vue';
import {
     computed,
     nextTick,
     onBeforeUnmount,
     onMounted,
     ref,
     watch,
} from 'vue';
import BlogFilters from '../../components/blog/BlogFilters.vue';
import BlogPageShell from '../../components/blog/BlogPageShell.vue';
import BlogPaginationStatus from '../../components/blog/BlogPaginationStatus.vue';

interface BlogPostPreview {
     title: string;
     slug: string;
     icon: string | null;
     excerpt: string | null;
     published_at: string | null;
}

interface PostPaginationLink {
     url: string | null;
     label: string;
     active: boolean;
}

interface PostsPayload {
     data: BlogPostPreview[];
     current_page: number;
     last_page: number;
     next_page_url: string | null;
     links: PostPaginationLink[];
}

interface BlogIndexFilters {
     search: string;
     tag: string;
     sort: string;
}

interface BlogIndexPageProps {
     posts: PostsPayload;
     filters: BlogIndexFilters;
     availableTags: string[];
}

const props = defineProps<BlogIndexPageProps>();

const modeKey = 'blog-view-mode';
const viewMode = ref<'paginated' | 'infinite'>('infinite');
const search = ref(props.filters.search ?? '');
const selectedTag = ref(props.filters.tag ?? '');
const sort = ref(props.filters.sort || 'newest');
const visiblePosts = ref<BlogPostPreview[]>(props.posts.data);
const currentPage = ref(props.posts.current_page);
const lastPage = ref(props.posts.last_page);
const nextPageUrl = ref<string | null>(props.posts.next_page_url);
const isLoadingMore = ref(false);
const sentinel = ref<HTMLElement | null>(null);
let observer: IntersectionObserver | null = null;

const hasMore = computed(
     () => viewMode.value === 'infinite' && nextPageUrl.value !== null,
);

const iconMap = {
     'binary-tree-2': IconBinaryTree2,
     brackets: IconBrackets,
     'file-pencil': IconFilePencil,
     'layout-dashboard': IconLayoutDashboard,
     markdown: IconMarkdown,
     'moon-stars': IconMoonStars,
     palette: IconPalette,
     pencil: IconPencil,
     refresh: IconRefresh,
     rocket: IconRocket,
     'shield-lock': IconShieldLock,
     'target-arrow': IconTargetArrow,
} as const;

function resolveIconComponent(icon: string | null) {
     if (!icon) {
          return IconFileText;
     }

     return iconMap[icon as keyof typeof iconMap] ?? IconFileText;
}

function applyFilters() {
     observer?.disconnect();

     const params: { search?: string; tag?: string; sort?: string } = {};
     const normalizedSearch = search.value.trim();
     const normalizedTag = selectedTag.value.trim();

     if (normalizedSearch !== '') {
          params.search = normalizedSearch;
     }

     if (normalizedTag !== '') {
          params.tag = normalizedTag;
     }

     if (sort.value !== 'newest') {
          params.sort = sort.value;
     }

     router.get(route('blog.index'), params, {
          preserveState: true,
          preserveScroll: true,
          replace: true,
     });
}

async function loadMore() {
     if (
          !nextPageUrl.value ||
          isLoadingMore.value ||
          viewMode.value !== 'infinite'
     ) {
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
     },
);

watch(
     () => props.filters,
     (filters) => {
          search.value = filters.search ?? '';
          selectedTag.value = filters.tag ?? '';
          sort.value = filters.sort || 'newest';
     },
);

watch(viewMode, async (mode) => {
     localStorage.setItem(modeKey, mode);

     if (mode !== 'infinite') {
          observer?.disconnect();
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

     <BlogPageShell shell-class="content-shell-narrow">
          <div
               class="grid min-h-[60vh] grid-cols-[0.5rem_minmax(0,1fr)] gap-4 sm:gap-6">
               <aside class="self-stretch">
                    <BlogFilters
                         :search="search"
                         :selected-tag="selectedTag"
                         :sort="sort"
                         :available-tags="availableTags"
                         :view-mode="viewMode"
                         @update:search="search = $event"
                         @update:selected-tag="selectedTag = $event"
                         @update:sort="sort = $event"
                         @update:view-mode="viewMode = $event"
                         @apply="applyFilters" />
               </aside>

               <div class="min-w-0">
                    <div class="w-full max-w-2xl space-y-4 text-left">
                         <Link
                              v-for="post in visiblePosts"
                              :key="post.slug"
                              :href="route('blog.show', post.slug)"
                              class="block text-xl font-normal tracking-tight text-current hover:text-[var(--accent-color)] focus-visible:ring-2 focus-visible:ring-[var(--accent-color)] focus-visible:ring-offset-2 focus-visible:outline-none sm:text-2xl">
                              <span class="flex flex-wrap items-center gap-2">
                                   <component
                                        :is="resolveIconComponent(post.icon)"
                                        :size="22"
                                        aria-hidden="true"
                                        class="shrink-0 opacity-80" />
                                   <span>{{ post.title }}</span>
                              </span>
                         </Link>
                    </div>

                    <div class="mt-10">
                         <BlogPaginationStatus
                              :view-mode="viewMode"
                              :links="posts.links"
                              :current-page="currentPage"
                              :last-page="lastPage"
                              :is-loading-more="isLoadingMore"
                              :has-more="hasMore">
                              <template #sentinel>
                                   <div
                                        ref="sentinel"
                                        class="h-8" />
                              </template>
                         </BlogPaginationStatus>
                    </div>
               </div>
          </div>
     </BlogPageShell>
</template>
