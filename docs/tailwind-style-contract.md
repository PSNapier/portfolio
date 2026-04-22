# Site design and Tailwind style contract

Applies to landing, blog, and future marketing pages. Product rules and stack rules live together here; implementation details for CSS vs templates are in the last sections.

## Layout

- Default to a clean single-column reading flow. Use multi-column layout only when content density needs it (e.g. blog index cards + sidebar).
- Keep consistent vertical cadence between sections and blocks. Prefer shared layout tokens in `resources/css/app.css` (`--layout-content-padding-x`, `--layout-content-max-narrow`, `--layout-content-max-wide`, `.content-shell-narrow`, `.content-shell-wide`) over ad hoc page-level wrapper padding or max-width.

## Theme and color

- Neutral base palette anchored by charcoal `#2F3030`, with light/dark support on all pages. Drive smooth background/text and theme changes through shared motion tokens (e.g. `--motion-duration-color`), not one-off transition values.
- **Accent system:** canonical accents are cyan `#1ECFE6`, green `#32C36A`, gold `#EBC166`, pink `#F73676`, purple `#A362A4`. One active palette color per context drives links, highlights, controls, and text selection (`--selection-bg`, `--accent-color`).
- **Theme bar:** keep palette picker behavior and visual parity across pages. New UI must use these theme-bar values—do not introduce ad-hoc accent colors elsewhere.

## Global chrome

- **Top controls:** `resources/js/components/landing/LandingTopControls.vue` is the global cross-page control surface—keep it present and consistent on landing, blog index, and blog post pages.
- **Footer:** `resources/js/components/landing/LandingFooter.vue` should match on landing and blog so page framing stays aligned.

## Typography

- **Inter** for body, UI, and most headings.
- **JetBrains Mono** for code, metadata, and technical labels, plus intentional brand-forward hero headlines or short subheads on marketing pages.

## Motion

- Use `resources/css/app.css` motion tokens: `--motion-duration-color`, `--motion-duration-micro`, `--motion-ease-standard`, `--motion-ease-micro` instead of hardcoded transition duration or easing on new work.

## Accessibility

- Strong contrast, visible focus states, sensible heading order, keyboard-usable controls and navigation.

## Content UX and component boundaries

- **Landing:** scanability, clear CTA hierarchy, section-level storytelling.
- **Blog:** comfortable measure and line height, clear metadata, predictable navigation between index and post.
- **Structure:** page files own structure and data; reusable sections/components own visuals. Do not duplicate style logic across pages.

When editing UI, keep the above unless a redesign is explicitly requested.

---

## Keep in `resources/css/app.css`

- Design tokens: `--layout-content-*`, `--motion-*`, `--accent-color`, `--selection-*`.
- Semantic layout shells: `.content-shell-narrow`, `.content-shell-wide`.
- Cross-page utility helpers:
  - `.font-jetbrains-mono`
  - `.font-inter`
  - `.color-animate`
  - `.underline-animate`
  - `.examples-cta`
- Shared markdown class target: `.markdown-content` with element-level overrides.

## Keep in templates (Tailwind utilities)

- Layout composition (`flex`, `grid`, spacing, sizing, breakpoints).
- State, focus, and hover classes.
- Theme toggles and accent-based arbitrary values (for dynamic runtime colors).

## Avoid

- New page-scoped `<style>` blocks for reusable visual patterns.
- Duplicate font imports outside `resources/css/app.css`.
- Hardcoded transition durations or easing that bypass motion tokens.
