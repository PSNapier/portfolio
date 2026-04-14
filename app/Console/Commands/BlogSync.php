<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\YamlFrontMatter\YamlFrontMatter;

#[Signature('blog:sync')]
#[Description('Sync markdown blog posts into database index')]
class BlogSync extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $paths = File::glob(base_path('content/posts/*.md')) ?: [];
        $seenFilePaths = [];
        $upserted = 0;

        foreach ($paths as $path) {
            $relativePath = Str::of($path)
                ->after(base_path().DIRECTORY_SEPARATOR)
                ->replace('\\', '/')
                ->toString();

            $contents = File::get($path);
            $document = YamlFrontMatter::parse($this->stripUtf8Bom($contents));
            $matter = $document->matter();
            $filename = pathinfo($path, PATHINFO_FILENAME);

            $slug = Str::of((string) ($matter['slug'] ?? $filename))
                ->slug()
                ->toString();

            if ($slug === '') {
                $this->warn("Skipping {$relativePath}: invalid slug.");

                continue;
            }

            $tags = $this->normalizeTags($matter['tags'] ?? []);
            $publishedAt = $this->parsePublishedAt($matter['published_at'] ?? null, $relativePath);

            Post::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => (string) ($matter['title'] ?? Str::headline($filename)),
                    'icon' => $this->normalizeIcon($matter['icon'] ?? null),
                    'excerpt' => $this->normalizeExcerpt($matter['excerpt'] ?? null),
                    'body' => trim($document->body()),
                    'tags' => $tags === [] ? null : $tags,
                    'published_at' => $publishedAt,
                    'file_path' => $relativePath,
                ]
            );

            $seenFilePaths[] = $relativePath;
            $upserted++;
        }

        if ($seenFilePaths === []) {
            $deleted = Post::query()->delete();
        } else {
            $deleted = Post::query()
                ->whereNotIn('file_path', $seenFilePaths)
                ->delete();
        }

        $this->info("Blog sync complete. Upserted {$upserted}, deleted {$deleted} stale rows.");

        return self::SUCCESS;
    }

    /**
     * @param  mixed  $rawTags
     * @return array<int, string>
     */
    private function normalizeTags(mixed $rawTags): array
    {
        if (is_string($rawTags)) {
            $rawTags = explode(',', $rawTags);
        }

        if (! is_array($rawTags)) {
            return [];
        }

        return collect($rawTags)
            ->filter(fn ($tag) => is_string($tag))
            ->map(fn (string $tag) => Str::lower(trim($tag)))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function normalizeExcerpt(mixed $excerpt): ?string
    {
        if (! is_string($excerpt)) {
            return null;
        }

        $value = trim($excerpt);

        return $value === '' ? null : $value;
    }

    private function normalizeIcon(mixed $icon): ?string
    {
        if (! is_string($icon)) {
            return null;
        }

        $value = Str::of($icon)->trim()->slug('-')->toString();

        return $value === '' ? null : $value;
    }

    private function stripUtf8Bom(string $contents): string
    {
        return str_starts_with($contents, "\xEF\xBB\xBF")
            ? substr($contents, 3)
            : $contents;
    }

    private function parsePublishedAt(mixed $publishedAt, string $relativePath): ?Carbon
    {
        if ($publishedAt === null || $publishedAt === '') {
            return null;
        }

        if ($publishedAt instanceof DateTimeInterface) {
            return Carbon::instance($publishedAt);
        }

        if (is_int($publishedAt) || is_float($publishedAt)) {
            return Carbon::createFromTimestamp((int) $publishedAt);
        }

        if (! is_string($publishedAt)) {
            $this->warn("Invalid published_at in {$relativePath}; treating as draft.");

            return null;
        }

        try {
            return Carbon::parse($publishedAt);
        } catch (\Throwable) {
            $this->warn("Could not parse published_at in {$relativePath}; treating as draft.");

            return null;
        }
    }
}
