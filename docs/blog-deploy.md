# Blog Deploy Notes

## Authoring workflow

1. Create markdown files in `content/posts/`.
2. Commit and push to GitHub.
3. Forge deploy runs `php artisan blog:sync`.

## Forge deploy hook

Add this line after `git pull` in your Forge deploy script:

```bash
php artisan blog:sync
```

## Frontmatter format

```yaml
---
title: My Post Title
slug: my-post-title
excerpt: One sentence summary.
tags: [laravel, vue]
published_at: 2026-04-14
---

Post body here...
```

- `published_at` omitted/empty means draft.
- `slug` omitted falls back to filename slug.
