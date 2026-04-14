<?php

namespace App\Http\Controllers\Blog;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    public function __invoke(Request $request): Response|\Illuminate\Http\JsonResponse
    {
        $search = $request->string('search')->toString();
        $tag = $request->string('tag')->toString();
        $sort = $request->string('sort')->toString();

        $posts = Post::query()
            ->published()
            ->search($search)
            ->withTag($tag)
            ->sorted($sort)
            ->paginate(10)
            ->withQueryString()
            ->through(function (Post $post) {
                return [
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'icon' => $post->icon,
                    'excerpt' => $post->excerpt,
                    'tags' => $post->tags ?? [],
                    'published_at' => $post->published_at?->toDateString(),
                ];
            });

        if ($request->expectsJson()) {
            return response()->json($posts);
        }

        $tags = Post::query()
            ->published()
            ->get(['tags'])
            ->pluck('tags')
            ->flatten()
            ->filter(fn ($value) => is_string($value) && $value !== '')
            ->unique()
            ->sort()
            ->values();

        return Inertia::render('blog/index', [
            'posts' => $posts,
            'filters' => [
                'search' => $search,
                'tag' => $tag,
                'sort' => $sort,
            ],
            'availableTags' => $tags,
        ]);
    }
}
