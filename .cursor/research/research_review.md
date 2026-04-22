# Research Folder Review — Findings & Next Actions

_Created: 2026-04-22_
_Purpose: summary of an audit pass over `.cursor/research/` docs, issues found, and recommended next moves._

## Framing correction

These files are **exploratory reference material**, not a commitment to four active funnels. They exist to support multiple possible moves:

- Comps/pricing reference as Napier continues establishing as a freelancer.
- Foundation for an ARPG-specific landing page and sales funnel.
- Reference for a future expansion into B2B/SMB work.
- Meaningful agency possibilities for job-hunt or subcontract.

Earlier critique about "scope drift" assumed these were all active prospecting fronts — that was wrong. A library of context for future decisions is legitimate and especially valuable given agentic workflows that can consume it.

## What's working

- `napier_context.md` is an honest, calibrated self-assessment. "Strong mid, not senior" is realistic and will prevent wasted senior applications.
- Cohort split (ARPG / B2B / Laravel / Agencies) maps cleanly to four distinct audiences.
- `agencies.md` "start-here 8" + agentic callouts (Kirschbaum, Standard Beagle) is the most actionable artifact in the folder.

## Issues identified

1. **Reference vs. pipeline boundary needs to be explicit.** These files are currently fine as reference. The risk is treating them as pipelines without converting them. When a specific move activates (e.g. "I'm building the ARPG landing page this month"), the relevant file should get promoted to a tracker (CSV/frontmatter) with contact path, status, last-touched, and pitch angle. Keep raw reference and active pipeline as separate artifacts.

3. **Women-led filter is strategic, not incidental.** Intentional filter because Napier is female and the male-dominated default funnel is part of what's broken. Add an explicit purpose header to `b2b_cohort.md` and `laravel_cohort.md` so the rationale is legible:
   > _Purpose: prioritize women-led shops and women Laravel devs for outreach, collab, and referral — explicit filter, not incidental._

4. **`agencies.md` local section is mostly non-Laravel.** Shores Media, Reanimation, Olympic, Tenderling are WordPress/branding shops that won't hire a Laravel mid. Either recategorize as "possible subcontract/overflow partners" or remove from the job-hunt list.

5. **Top-of-funnel problem, not target-selection problem.** ~1% response rate across hundreds of applications means the resume/pipeline is broken. Better cohort data feeds the same broken funnel. Needs its own investigation: ATS keywords, resume format, referrals, portfolio landing page.

6. **`cohort_refs.md` is referenced but missing from the folder.**

7. **ARPG cohort mixes competitors with collaborators.** `itinerare`, `Min`, `Preimpression` are paid-commission competitors. `ScuffedNewt`, `JuniJwi` are ecosystem contributors. Different purposes — tag them (`competitor` / `collaborator` / `referral network`).

8. **Historical/mismatched entries in women-led lists.** E.g. Pixel Me Pink (now male-owned) no longer matches the filter — move to a "historical / context only" subsection.

## Strategic implications of the women-led filter

- If bias is part of the funnel issue, generic mass applications are especially poor ROI. Warm intros via women-led Laravel networks (Larabelles, Laracon meetups) will convert far better than cold ATS submissions.
- `laravel_cohort.md` is more valuable as a **referral/warm-intro network** than as a client list.
- **Larabelles is underused** — listed as a source but not as a community to participate in. Visible contribution there (answering questions, sharing roll-geno progress) is likely higher-leverage than any single application.
- Agency targeting can layer the filter in: audit top-8 agencies for women in eng leadership (public team pages on Kirschbaum, Tighten, Vehikl) as direct warm-intro targets.

## Use-cases these files support

Each file has more than one plausible activation path. Worth noting them so the reference is easy to mobilize later:

- **`arpg_cohort.md`** — pricing intel for ARPG rate-setting; competitor landscape for an ARPG landing page on abature.studio; referral/collab network for overflow work; content inspiration (what offerings do competitors list?).
- **`b2b_cohort.md`** — comps for positioning and pricing if/when expanding into SMB; design/offering reference for a B2B service page; potential subcontract partners (especially WordPress shops who might refer custom Laravel work out).
- **`laravel_cohort.md`** — warm-intro/referral network (highest value); comps for freelance rate-setting; community entry points (Larabelles).
- **`agencies.md`** — job-hunt targets; subcontract/overflow partners; local-network leverage in Austin/Georgetown.

## Recommended next moves (optional, pick when activating)

- **When job-hunting becomes active:** audit the ~1% response rate first (resume, ATS, portfolio, referrals) before expanding the agency list. Top-of-funnel fix > more targets.
- **When building the ARPG landing page:** mine `arpg_cohort.md` for offering/pricing structure; decide which entries are competitors-to-differentiate-from vs. collaborators-to-partner-with.
- **Always-on, low-cost:** Larabelles community presence. It feeds both the referral network and the warm-intro channel regardless of which funnel activates next.

## Quick cleanup backlog

- [ ] Add purpose header to `b2b_cohort.md` and `laravel_cohort.md`.
- [ ] Create or remove missing `cohort_refs.md` reference.
- [ ] Tag ARPG entries: `competitor` / `collaborator` / `referral`.
- [ ] Split `agencies.md` local section: Laravel-fit vs. subcontract/overflow.
- [ ] Move historical/mismatched entries out of primary women-led lists.
- [ ] Add columns to cohort files: contact path, status, last-touched, pitch angle.
