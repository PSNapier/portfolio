# Lorekeeper site customization and hosting
_Exported on 4/13/2026 at 11:50:42 CDT from Cursor (3.0.16)_

---

**User**

Speaking with a new prospective client for a customized Lorekeeper site https://github.com/lk-arpg/lorekeeper 

-

Here's what I said:
Hello, Cas!

I saw your post on the Lorekeeper Discord and wanted to reach out and offer my services to you. 

For context I've been doing development for over a decade with a focus on ARPG rollers, custom sites and Lorekeeper builds for breeds like Nordanner (worth noting that I have experience working with groups of your scale). I've also helped update and customize LK installs so they work cleanly with newer versions. 

My rate is $35/hour, and I offer managed hosting on my servers for $25/month. I also offer a monthly cap system (you set a max number of hours per month), which keeps things affordable while still making steady progress.

You mentioned wanting the ability to manage events and possibly make minor edits yourself. I have previously implemented in-site admin systems that allow editing of the site itself, so I would likely be able to implement this sort of thing for you as well. With my managed hosting plan things like bug fixes on finalized work and minor edits (such as fixing typos, adding a gene to existing logic, etc.) are included with the monthly hosting. 

If you're interested let me know! I'll be curious to get more detail on what you're looking for. 

-

Their reply:
how much does your hosting have storage/bandwidth wise?

I also have this custom UI if youre able to quote me on how much it would cost to code in? (mobile version  sketch) 

is there a flatprice for setup or a rough amount of time that it would take to setip?

[images attached.]

-

I am going to utilize a Laravel Forge VPS with Cloudflare images if needed. How best to answer their storage/bandwidth question? 

I'm expecting probably two to four hours to implement the UI changes based on their mock-up, based on the images in the default Lorekeeper layout. What do you think? I've also included a screenshot of the default Lorekeeper UI for reference.

Feel free to ask me any questions.

---

**Cursor**


Here’s a direct way to frame your reply and a sanity check on the UI hours.

## Hosting: storage & bandwidth (Forge + Cloudflare)

**What to say**

- **Disk:** Tie it to the **VPS plan** (e.g. DigitalOcean droplet size). Quote the included SSD (e.g. 25 GB / 50 GB / 80 GB) and that app + DB + logs live there; large static assets can go to **object storage or Cloudflare** to keep the box lean.
- **Bandwidth:** Most Forge setups are on providers with a **monthly transfer allowance** (not truly “unlimited”). Say you monitor usage and right-size the plan; **Cloudflare in front** (and **Cloudflare Images** for user/character art) cuts **origin egress** and protects the server from image-heavy traffic.
- **Images specifically:** If they use **Cloudflare Images**, pricing is **CF’s image delivery/storage model**, not “bandwidth on the VPS” for those files—say that clearly so they don’t double-count.
- **Avoid:** Promising unlimited storage/bandwidth unless your contract and upstream plan actually support it.

**Optional clarity:** Separate “what the server includes” vs “what CF handles” so they know where limits apply.

---

## UI quote vs your 2–4 hour guess

**2–4 hours is only realistic** for a **light reskin** of the default layout: colors, typography, header/banner, maybe reordering a few blocks if the markup already matches.

From your mockups, the **desktop** design is **not** that:

- Non-rectangular UI (brush/blob shapes) → usually **SVG/masks**, extra assets, and a lot of **CSS** (and fighting Bootstrap).
- **Carousel** with real content → markup + JS + possibly admin-driven slides.
- **Star of the week** (random eligible character) + **selected character** → **queries, caching, edge cases** (no eligible character, user not logged in, performance).
- **Bank/currency in header** → wiring to existing LK balance/currency (depends what’s already there).
- **“NEW!” on nav** → needs a **rule** (what changed, how often it clears)—small feature, still spec + implementation.
- **Responsive mobile** layout that **doesn’t** match the desktop grid → often **as much work as desktop**, not “free.”

A **credible range** for “implement this mockup at reasonable fidelity on Lorekeeper” is more like **several days to a couple of weeks of focused work** (order-of-magnitude **~20–80+ hours**), highly dependent on:

- Pixel-perfect vs “in the spirit of”
- How many **templates** you override (`layouts`, home, nav partials)
- Whether **carousel / star / selected OC** are in scope for v1
- **Accessibility** and **maintainability** (custom shapes often hurt both if rushed)

If you quote **2–4 hours**, you risk **scope blow-up** or delivering something that still looks like default LK with a new background.

**Practical approach for the client:** Offer a **phased estimate**: Phase 1 = global theme + header/footer + home layout shell; Phase 2 = widgets (carousel, star, selected OC); Phase 3 = polish + mobile. Give a **range** per phase in hours × $35.

---

## Setup: flat fee vs time

Lorekeeper setup ([lk-arpg/lorekeeper](https://github.com/lk-arpg/lorekeeper)) for someone who’s done it before is often **~0.5–1.5 days** end-to-end if nothing weird: repo, `.env`, Composer, migrations, `add-site-settings` / `add-text-pages` / images, admin user, **OAuth/social** config, Forge server, SSL, queue/cron, basic hardening.

- **Flat setup:** Common; pad for **Discord/social app registration** and email deliverability snags.
- **Quote as a range** (e.g. 4–12 hours) unless they’ve confirmed host, domain, and auth providers.

---

## Questions worth asking them (reduces mis-estimating)

1. Is the quote for **desktop only**, **mobile only**, or **both** at launch?  
2. **Carousel / star / selected character / bank strip**—all v1 or later?  
3. **Content editing:** static Blade vs **CMS-style** blocks (much more time).  
4. **Browser support** and **accessibility** expectations.  
5. **Existing LK version** and whether they need **extensions** (many ARPGs stack extensions that also need styling).

**Security/complexity note:** “Edit the site in-site” is powerful; scope **roles, audit trail, and XSS** if they can inject HTML—call that out when pricing.

---

**Bottom line:** Answer hosting with **VPS disk + provider transfer + CF’s role**; push UI to a **scoped breakdown**; treat **2–4 hours** as a **theme-only** subset unless they explicitly accept a simplified interpretation of the mockup.

