# Easy Lot Cayman — WordPress theme

Editorial WordPress theme for [easylot.ky](https://easylot.ky/). It is built to *teach*
rather than to advertise: the homepage and the guide page walk a visitor through how
buying land in the Cayman Islands with Direct Owner Financing actually works, with a
published video pinned to each step.

Created by [Toc Toc Marketing](https://toctoc.ky/).

---

## What is different from the previous theme

| | Old theme | This theme |
|---|---|---|
| CSS | Tailwind CDN + an anti-FOUC script that hid the page for up to 1.5s | One hand-written `style.css`, no framework, no FOUC hack |
| Icons | Material Symbols icon font | Inline SVG (`easylot_icon()`) |
| Structured data | Several separate `<script>` blocks | One `@graph`, extended by templates through the `easylot_schema_graph` filter |
| Video | Cards on two pages | Cards everywhere + a floating muted player, all sharing one lightbox |
| Content | Feature-led | Step-led: comparison table, 5-step walkthrough, 4-document checklist, calculator, 12-answer FAQ |

## Install

The theme lives at the **repository root**, so the repo *is* the theme folder.

```bash
git clone https://github.com/<you>/easylot-cayman.git
```

Then either upload the folder to `wp-content/themes/easylot-cayman/`, or zip the repo
(excluding `.git`) and install it through **Appearance → Themes → Add New → Upload**.

## Pages to create and their templates

| Page slug | Page template to assign |
|---|---|
| *(front page)* | — (uses `front-page.php` automatically) |
| `how-to-buy-land-in-cayman` | **How to Buy Land (Guide)** |
| `all-our-developments` | **All Developments** |
| `video-guides` | **Video Guides** |
| `frequently-asked-questions` | **FAQ** |
| `contact-us` | **Contact / Pre-Approval** |
| `about-us` | **About Us** |
| `team-members` | **Meet the Team** |
| `directions` | **Directions** |

`easylot_url()` in `functions.php` resolves each of these by slug and falls back to a
sensible path, so a renamed page does not produce a dead link across the theme.

### Development pages keep their map

The three development pages (`/project/…`) carry an **interactive lot map supplied by a
third party**. `single-project.php` and `page.php` print `the_content()` verbatim and add
nothing around the embed, so the map keeps working exactly as it does today. Do not wrap
that content in a max-width container — `.entry-content--full` exists for this.

## Where to edit content

Everything editable is grouped under **"SITE DATA"** near the top of `functions.php`:

- `easylot_contact()` — phone, WhatsApp, email, address, logo, social links
- `easylot_developments()` — the three developments, their images, blurbs and starting prices
- `easylot_videos()` — every video guide (URL, question, answer, category, `featured`, `step`)
- `easylot_intro_video()` — the clip in the floating bottom-left player
- `easylot_faqs()` — the FAQ, which is also what becomes `FAQPage` schema
- `easylot_testimonials()`

## The floating video player

Bottom-left, muted, looping, with a play button in the middle. Pressing it opens the same
lightbox the video cards use, full size and with sound.

It loads **two files** on purpose:

- a small silent teaser (~850 KB) that loops in the corner
- the full clip (~10 MB) that only downloads when somebody presses play

Upload both to the media library and point `easylot_intro_video()` at them. It appears
after 320px of scroll (or 4 seconds), and dismissing it is remembered for the session.

## Structured data

`easylot_schema_graph()` emits one JSON-LD `@graph` in `<head>` containing:

- `RealEstateAgent` / `LocalBusiness` for Easy Lot
- `WebSite`, whose `creator` points at the Toc Toc entity
- `WebPage` for the current URL
- the **Toc Toc entity block** — `Organization`/`ProfessionalService`, plus `Person` nodes
  for Daniel Garrido and Andre Gutierrez

Those Toc Toc `@id` values are **stable across every site Toc Toc builds** and must never
be rewritten per-site — that is what consolidates the agency as one entity:

```
https://toctoc.ky/#organization
https://toctoc.ky/#daniel-garrido
https://www.linkedin.com/in/andre-g-9b373a97/#person
```

Templates add `FAQPage`, `HowTo`, `ItemList`, `VideoObject` and `BreadcrumbList` nodes via
the `easylot_schema_graph` filter rather than printing a second script block.

`llms.txt` is served from the theme root at `/llms.txt` and ends with the same credit line.

## SEO targeting

Head copy and headings are aimed at the queries that actually earn impressions for this
domain in Search Console:

- land for sale in the cayman islands
- cayman islands land for sale by owner / for sale by owner cayman islands
- cheap land for sale in cayman islands
- land for sale in cayman / land for sale grand cayman
- cayman real estate finance / lease to own homes cayman

If a plugin (Rank Math, Yoast, AIOSEO) is active it keeps control of titles and meta tags;
the theme only steps in when none is.

## Browser behaviour

`main.js` is plain ES5-compatible JavaScript with no dependencies: sticky nav and read
progress, mobile drawer, scroll reveal, FAQ accordion, video lightbox, category filter,
floating player and the payment calculator. Everything degrades — with JS off the page
still reads and the FAQ answers are still in the HTML and in the schema.

`prefers-reduced-motion` disables every decorative animation.

## Licence

GPL v2 or later.
