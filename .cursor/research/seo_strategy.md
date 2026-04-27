# SEO Strategy Notes

_Created: 2026-04-27_

## Starting Point

Current baseline: general site accessibility and performance best practices already in place. Goal is to expand into SEO as both a personal site differentiator and a managed hosting upsell for B2B/SMB clients.

---

## Top 3 Movers

| # | Move | Why It Matters | Effort |
|---|------|----------------|--------|
| 1 | **Structured data (JSON-LD Schema)** | Rich snippets boost CTR without changing rankings. `LocalBusiness`, `Service`, and `WebSite` schemas are perfect for SMB clients. | Low |
| 2 | **Google Search Console** | You can't improve what you can't see. GSC shows exactly which queries surface your site and what's broken. Free, 30-min setup. | Very Low |
| 3 | **Targeted landing pages per service/location** | One "Web Design for Small Businesses in [City]" page beats a generic homepage every time for B2B lead SEO. | Medium |

---

## Agentic Automation Potential

**High automation potential:**
- **Schema generation** — Claude agents can read a client's page and output production-ready JSON-LD. Scriptable as part of the build/onboarding flow.
- **Meta tag audits** — crawl a site, flag missing/duplicate titles and descriptions, generate replacements. One script, reusable across all clients.
- **Content briefs + blog drafts** — given a target keyword, an agent can pull competitor content structure, generate an outline, and draft a post.
- **GSC reporting** — GSC API + agent can pull weekly rankings/impressions and generate a client-facing summary. Good upsell touchpoint for care plan tier.

**Still manual (for now):** GMB/Google Business Profile optimization, link building outreach, and anything requiring genuine editorial judgment.

---

## Business Model Note

Schema generation + monthly GSC reporting as a differentiating add-on to managed hosting is worth testing. Erigo upsells SEO growth tiers starting at $299/month — useful ceiling signal.

---

## Technical Direction

### Transition Laravel + Vue Projects to SSR

All Laravel/Vue projects should move to SSR (server-side rendering) for two reasons:

1. **Search engine visibility** — client-side-only Vue means crawlers often see an empty shell. SSR delivers fully-rendered HTML on first request.
2. **AI agent visibility** — LLM-based agents and tools increasingly fetch and parse page content directly; SSR ensures they get real content rather than a JS bundle.

**Recommended approach:** Inertia.js with SSR enabled (already part of the stack). Laravel 12 + Inertia SSR is well-documented and avoids a full framework switch.

Key steps:
- Enable Inertia SSR via `php artisan inertia:start-ssr` and the Node SSR server
- Confirm `@inertiajs/vue3` SSR setup in `app.js` vs `ssr.js` entry points
- Test with `curl` or `view-source` to verify HTML is pre-rendered
- Audit for client-only code (`window`, `document`) that breaks SSR and wrap in `onMounted` guards
