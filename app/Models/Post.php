<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'icon',
        'excerpt',
        'body',
        'tags',
        'published_at',
        'file_path',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        $search = trim((string) $search);

        if ($search === '') {
            return $query;
        }

        return $query->where(function (Builder $inner) use ($search) {
            $inner
                ->where('title', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%");
        });
    }

    public function scopeWithTag(Builder $query, ?string $tag): Builder
    {
        $tag = trim((string) $tag);

        if ($tag === '') {
            return $query;
        }

        return $query->whereJsonContains('tags', $tag);
    }

    public function scopeSorted(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'oldest' => $query->orderBy('published_at'),
            'title' => $query->orderBy('title'),
            default => $query->orderByDesc('published_at'),
        };
    }

    public function getRenderedBodyAttribute(): string
    {
        return (string) self::markdownConverter()->convert((string) $this->body);
    }

    public function getRenderedExcerptAttribute(): ?string
    {
        $raw = $this->excerpt;

        if ($raw === null || trim((string) $raw) === '') {
            return null;
        }

        $html = (string) self::markdownConverter()->convert((string) $raw);

        if (preg_match('/\A<p>(.*)<\/p>\s*\z/s', $html, $matches)) {
            return $matches[1];
        }

        return $html;
    }

    private static function markdownConverter(): CommonMarkConverter
    {
        static $converter;

        $converter ??= new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return $converter;
    }
}
