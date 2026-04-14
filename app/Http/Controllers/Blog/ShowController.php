<?php

namespace App\Http\Controllers\Blog;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ShowController extends Controller
{
    public function __invoke(string $slug): Response
    {
        $post = Post::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return Inertia::render('blog/show', [
            'post' => [
                'title' => $post->title,
                'slug' => $post->slug,
                'icon' => $post->icon,
                'excerpt' => $post->excerpt,
                'rendered_excerpt' => $post->rendered_excerpt,
                'tags' => $post->tags ?? [],
                'published_at' => $post->published_at?->toDateString(),
                'rendered_body' => $post->rendered_body,
            ],
        ]);
    }
}
