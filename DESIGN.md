---
name: WeIntegral
description: The public website of WeIntegral, an IT services firm. Navy and coral, set in Inter, light first.
colors:
    ink: "#0b1730"
    navy: "#13294b"
    navy-band: "#0f2140"
    coral: "#e96b56"
    coral-hover: "#f08068"
    coral-text: "#b5412e"
    coral-ring: "#c4503b"
    paper: "#ffffff"
    mist: "#f3f5f8"
    wash: "#eef2f7"
    hairline: "#dde3eb"
    field-stroke: "#7d8aa0"
    slate: "#4f5d73"
    band-slate: "#b4c2d9"
    band-hairline: "#2a4069"
    crimson: "#c62f3a"
    pine: "#1f7a4d"
    night: "#0a1322"
    night-raised: "#101c30"
    night-muted: "#152238"
    night-wash: "#1a2840"
    night-hairline: "#24344d"
    night-field-stroke: "#5b6d8a"
    frost: "#e6ecf4"
    frost-muted: "#9aa9bf"
    pale-navy: "#d5e0f0"
    coral-light: "#f08a78"
    coral-light-text: "#f29482"
    rose: "#f0727c"
    mint: "#5cc48f"
typography:
    display:
        fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
        fontSize: "clamp(2.5rem, 1.6rem + 3.6vw, 4.5rem)"
        fontWeight: 680
        lineHeight: 1.03
        letterSpacing: "-0.035em"
    headline:
        fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
        fontSize: "clamp(2.25rem, 1.75rem + 2vw, 3.5rem)"
        fontWeight: 650
        lineHeight: 1.08
        letterSpacing: "-0.03em"
    section:
        fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
        fontSize: "clamp(1.75rem, 1.45rem + 1.2vw, 2.5rem)"
        fontWeight: 650
        lineHeight: 1.15
        letterSpacing: "-0.025em"
    title:
        fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
        fontSize: "clamp(1.25rem, 1.15rem + 0.4vw, 1.5rem)"
        fontWeight: 620
        lineHeight: 1.3
        letterSpacing: "-0.015em"
    subtitle:
        fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
        fontSize: "1.125rem"
        fontWeight: 620
        lineHeight: 1.4
        letterSpacing: "-0.01em"
    lead:
        fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
        fontSize: "clamp(1.125rem, 1.08rem + 0.2vw, 1.25rem)"
        fontWeight: 400
        lineHeight: 1.55
    body:
        fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
        fontSize: "1rem"
        fontWeight: 400
        lineHeight: 1.6
    small:
        fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
        fontSize: "0.875rem"
        fontWeight: 400
        lineHeight: 1.5
    label:
        fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
        fontSize: "0.8125rem"
        fontWeight: 600
        lineHeight: 1.4
    logo:
        fontFamily: "Poppins, Inter, sans-serif"
        fontSize: "1.25rem"
        fontWeight: 700
        lineHeight: 1
        letterSpacing: "0.04em"
rounded:
    sm: "4px"
    md: "6px"
    lg: "8px"
    xl: "12px"
    full: "9999px"
spacing:
    "1": "4px"
    "2": "8px"
    "3": "12px"
    "4": "16px"
    "6": "24px"
    "8": "32px"
    "12": "48px"
    "16": "64px"
    gutter: "clamp(1rem, 4vw, 2rem)"
    section: "clamp(4rem, 3rem + 5vw, 7.5rem)"
components:
    button-cta:
        backgroundColor: "{colors.coral}"
        textColor: "{colors.ink}"
        rounded: "{rounded.lg}"
        padding: "10px 20px"
        height: "44px"
    button-cta-hover:
        backgroundColor: "{colors.coral-hover}"
    button-primary:
        backgroundColor: "{colors.navy}"
        textColor: "{colors.paper}"
        rounded: "{rounded.lg}"
        padding: "10px 20px"
        height: "44px"
    button-outline:
        backgroundColor: "{colors.paper}"
        textColor: "{colors.ink}"
        rounded: "{rounded.lg}"
        padding: "10px 20px"
        height: "44px"
    nav-trigger:
        textColor: "{colors.ink}"
        rounded: "{rounded.md}"
        padding: "8px 12px"
        height: "40px"
    nav-trigger-open:
        backgroundColor: "{colors.wash}"
        textColor: "{colors.navy}"
    mega-menu:
        backgroundColor: "{colors.paper}"
        textColor: "{colors.ink}"
    band:
        backgroundColor: "{colors.navy-band}"
        textColor: "{colors.paper}"
    closing-band:
        backgroundColor: "{colors.coral}"
        textColor: "{colors.ink}"
    input:
        backgroundColor: "{colors.paper}"
        textColor: "{colors.ink}"
        rounded: "{rounded.lg}"
        height: "44px"
---

# Design System: WeIntegral

Status: comps approved (spec #54). Tokens live in `resources/css/tokens.css`; `resources/css/app.css` imports them and maps them onto the Tailwind/shadcn theme (#57), so utilities such as `bg-primary`, `bg-inverse` and `text-cta-foreground` resolve to them. Fonts are self-hosted with `@fontsource`.

## Overview

**Creative north star: "The Integral Line."** WeIntegral's pitch is that one firm carries software from build to run. The system draws that literally: a single continuous coral line on a navy field, with the five Services as stations along it. Everything else stays quiet, precise and readable so that line, the headline and the "Talk to an Expert" action carry the page.

- **Mood:** confident, plain-spoken, engineered. Closer to a well-run engineering team than to a glossy agency.
- **Colour strategy:** committed. Navy owns whole regions (utility bar, hero, process band, footer). Coral is the action colour and owns exactly one region per page, the closing call-to-action band. Neutrals are cool greys tinted towards navy.
- **Light first.** The light palette is the default. A dark palette follows `prefers-color-scheme: dark`; there is no toggle.
- **Structure** follows the large IT services firm pattern (utility bar, mega-menu, hero with one primary action, Service and Industry sections, four-column footer). The reference sites inform structure only: no copy, colours, logos or imagery are borrowed.
- **Anti-references:** the old Bootstrap template look (grey `#545454` text, icon-in-circle service cards), generic stock "handshake" imagery, gradient text, glassmorphism, neon on black.

## Colors

All tokens use shadcn/ui's theme variable names (`--background`, `--primary` and so on), so the foundation can map them with `@theme inline`. Brand extras (`--cta`, `--emphasis`, `--success`, `--inverse*`) cover what shadcn has no slot for.

### Primary

- **WeIntegral Navy** (`--primary`, #13294b): primary buttons, links and the nav "open" text. In dark mode `--primary` becomes **Pale Navy** (#d5e0f0) with ink text, so primary buttons stay visible.
- **Navy Band** (`--inverse`, #0f2140; dark #13294b): full-width regions such as the utility bar, hero, process band and footer. Text on it uses `--inverse-foreground` (#ffffff) and `--inverse-muted` (#b4c2d9).

### Secondary (brand accent)

- **WeIntegral Coral** (`--cta`, #e96b56): the "Talk to an Expert" button, the Integral Line, station rings and the closing band. Text on coral is always **Ink** (#0b1730, 5.68:1). White on coral fails AA (3.13:1), so never use it.
- **Coral Text** (`--emphasis`, #b5412e; dark #f29482): coral-family text on light surfaces, such as hover states on headings and "All Services" links. Plain coral (#e96b56) is never used for text on white.
- **Coral Ring** (`--ring`, #c4503b; dark #f08a78): focus outlines. It clears 3:1 on white, mist, wash and the navy band.

shadcn's `--accent` is **not** the brand accent. It is the subtle hover and selected wash (#eef2f7; dark #1a2840) that shadcn components use for menu items, ghost buttons and selected rows.

### Neutral

- **Ink** (`--foreground`, #0b1730): body text and headings.
- **Slate** (`--muted-foreground`, #4f5d73): secondary text and descriptions.
- **Paper** (`--background`, `--card`, `--popover`, #ffffff): page and raised surfaces.
- **Mist** (`--muted`, #f3f5f8): alternating section background.
- **Wash** (`--secondary`, `--accent`, #eef2f7): hover and selected fills and secondary buttons.
- **Hairline** (`--border`, #dde3eb): dividers and card borders. Decorative only, never the sole boundary of a control.
- **Field Stroke** (`--input`, #7d8aa0): form-field borders. They clear the 3:1 non-text contrast that WCAG 1.4.11 requires.

### Status

- **Crimson** (`--destructive`, #c62f3a; dark #f0727c): errors. It is deliberately redder and darker than coral so an error never reads as a brand accent.
- **Pine** (`--success`, #1f7a4d; dark #5cc48f): the Visitor Request success message.

### Dark palette

| Token                  | Light   | Dark    |
| ---------------------- | ------- | ------- |
| `--background`         | #ffffff | #0a1322 |
| `--foreground`         | #0b1730 | #e6ecf4 |
| `--card`, `--popover`  | #ffffff | #101c30 |
| `--primary`            | #13294b | #d5e0f0 |
| `--primary-foreground` | #ffffff | #0b1730 |
| `--secondary`          | #eef2f7 | #1a2840 |
| `--muted`              | #f3f5f8 | #152238 |
| `--muted-foreground`   | #4f5d73 | #9aa9bf |
| `--accent`             | #eef2f7 | #1a2840 |
| `--destructive`        | #c62f3a | #f0727c |
| `--border`             | #dde3eb | #24344d |
| `--input`              | #7d8aa0 | #5b6d8a |
| `--ring`               | #c4503b | #f08a78 |
| `--cta`                | #e96b56 | #e96b56 |
| `--cta-hover`          | #f08068 | #f08a78 |
| `--emphasis`           | #b5412e | #f29482 |
| `--success`            | #1f7a4d | #5cc48f |
| `--inverse`            | #0f2140 | #13294b |

In dark mode the navy band (#13294b) sits lighter than the page (#0a1322), so it still reads as a distinct region.

### Contrast (WCAG 2.2 AA)

Every text and background pair the tokens allow was computed with the WCAG relative-luminance formula. Text needs 4.5:1. Non-text needs 3:1: field borders, focus rings and the CTA shape. All 66 pairs pass. The large-text allowance (3:1) is never relied on.

#### Light

| Foreground                       | Background            | Ratio   | Needs                               | Result |
| -------------------------------- | --------------------- | ------- | ----------------------------------- | ------ |
| `foreground` #0b1730             | `background` #ffffff  | 17.80:1 | 4.5:1 text                          | Pass   |
| `muted-foreground` #4f5d73       | `background` #ffffff  | 6.68:1  | 4.5:1 text                          | Pass   |
| `emphasis` #b5412e               | `background` #ffffff  | 5.58:1  | 4.5:1 text                          | Pass   |
| `primary` #13294b                | `background` #ffffff  | 14.52:1 | 4.5:1 text (links)                  | Pass   |
| `card-foreground` #0b1730        | `card` #ffffff        | 17.80:1 | 4.5:1 text                          | Pass   |
| `muted-foreground` #4f5d73       | `card` #ffffff        | 6.68:1  | 4.5:1 text                          | Pass   |
| `emphasis` #b5412e               | `card` #ffffff        | 5.58:1  | 4.5:1 text                          | Pass   |
| `popover-foreground` #0b1730     | `popover` #ffffff     | 17.80:1 | 4.5:1 text                          | Pass   |
| `muted-foreground` #4f5d73       | `popover` #ffffff     | 6.68:1  | 4.5:1 text                          | Pass   |
| `primary-foreground` #ffffff     | `primary` #13294b     | 14.52:1 | 4.5:1 text                          | Pass   |
| `secondary-foreground` #13294b   | `secondary` #eef2f7   | 12.91:1 | 4.5:1 text                          | Pass   |
| `muted-foreground` #4f5d73       | `secondary` #eef2f7   | 5.94:1  | 4.5:1 text                          | Pass   |
| `foreground` #0b1730             | `muted` #f3f5f8       | 16.30:1 | 4.5:1 text                          | Pass   |
| `muted-foreground` #4f5d73       | `muted` #f3f5f8       | 6.11:1  | 4.5:1 text                          | Pass   |
| `emphasis` #b5412e               | `muted` #f3f5f8       | 5.11:1  | 4.5:1 text                          | Pass   |
| `accent-foreground` #13294b      | `accent` #eef2f7      | 12.91:1 | 4.5:1 text                          | Pass   |
| `destructive-foreground` #ffffff | `destructive` #c62f3a | 5.43:1  | 4.5:1 text                          | Pass   |
| `destructive` #c62f3a            | `background` #ffffff  | 5.43:1  | 4.5:1 text (field errors)           | Pass   |
| `success-foreground` #ffffff     | `success` #1f7a4d     | 5.32:1  | 4.5:1 text                          | Pass   |
| `success` #1f7a4d                | `background` #ffffff  | 5.32:1  | 4.5:1 text (form success)           | Pass   |
| `cta-foreground` #0b1730         | `cta` #e96b56         | 5.68:1  | 4.5:1 text                          | Pass   |
| `cta-foreground` #0b1730         | `cta-hover` #f08068   | 6.78:1  | 4.5:1 text                          | Pass   |
| `inverse-foreground` #ffffff     | `inverse` #0f2140     | 16.01:1 | 4.5:1 text                          | Pass   |
| `inverse-muted` #b4c2d9          | `inverse` #0f2140     | 8.89:1  | 4.5:1 text                          | Pass   |
| `cta` #e96b56                    | `inverse` #0f2140     | 5.11:1  | 4.5:1 text (coral on navy band)     | Pass   |
| `input` #7d8aa0                  | `background` #ffffff  | 3.49:1  | 3.0:1 non-text (field border)       | Pass   |
| `ring` #c4503b                   | `background` #ffffff  | 4.61:1  | 3.0:1 non-text (focus ring)         | Pass   |
| `input` #7d8aa0                  | `muted` #f3f5f8       | 3.20:1  | 3.0:1 non-text (field border)       | Pass   |
| `input` #7d8aa0                  | `card` #ffffff        | 3.49:1  | 3.0:1 non-text (field border)       | Pass   |
| `ring` #c4503b                   | `muted` #f3f5f8       | 4.22:1  | 3.0:1 non-text (focus ring)         | Pass   |
| `ring` #c4503b                   | `secondary` #eef2f7   | 4.10:1  | 3.0:1 non-text (focus ring)         | Pass   |
| `ring` #c4503b                   | `inverse` #0f2140     | 3.47:1  | 3.0:1 non-text (focus ring on band) | Pass   |
| `cta` #e96b56                    | `background` #ffffff  | 3.13:1  | 3.0:1 non-text (CTA shape)          | Pass   |

#### Dark

| Foreground                       | Background            | Ratio   | Needs                               | Result |
| -------------------------------- | --------------------- | ------- | ----------------------------------- | ------ |
| `foreground` #e6ecf4             | `background` #0a1322  | 15.65:1 | 4.5:1 text                          | Pass   |
| `muted-foreground` #9aa9bf       | `background` #0a1322  | 7.79:1  | 4.5:1 text                          | Pass   |
| `emphasis` #f29482               | `background` #0a1322  | 8.27:1  | 4.5:1 text                          | Pass   |
| `primary` #d5e0f0                | `background` #0a1322  | 13.95:1 | 4.5:1 text (links)                  | Pass   |
| `card-foreground` #e6ecf4        | `card` #101c30        | 14.36:1 | 4.5:1 text                          | Pass   |
| `muted-foreground` #9aa9bf       | `card` #101c30        | 7.15:1  | 4.5:1 text                          | Pass   |
| `emphasis` #f29482               | `card` #101c30        | 7.58:1  | 4.5:1 text                          | Pass   |
| `popover-foreground` #e6ecf4     | `popover` #101c30     | 14.36:1 | 4.5:1 text                          | Pass   |
| `muted-foreground` #9aa9bf       | `popover` #101c30     | 7.15:1  | 4.5:1 text                          | Pass   |
| `primary-foreground` #0b1730     | `primary` #d5e0f0     | 13.35:1 | 4.5:1 text                          | Pass   |
| `secondary-foreground` #e6ecf4   | `secondary` #1a2840   | 12.43:1 | 4.5:1 text                          | Pass   |
| `muted-foreground` #9aa9bf       | `secondary` #1a2840   | 6.19:1  | 4.5:1 text                          | Pass   |
| `foreground` #e6ecf4             | `muted` #152238       | 13.41:1 | 4.5:1 text                          | Pass   |
| `muted-foreground` #9aa9bf       | `muted` #152238       | 6.68:1  | 4.5:1 text                          | Pass   |
| `emphasis` #f29482               | `muted` #152238       | 7.08:1  | 4.5:1 text                          | Pass   |
| `accent-foreground` #e6ecf4      | `accent` #1a2840      | 12.43:1 | 4.5:1 text                          | Pass   |
| `destructive-foreground` #0b1730 | `destructive` #f0727c | 6.28:1  | 4.5:1 text                          | Pass   |
| `destructive` #f0727c            | `background` #0a1322  | 6.56:1  | 4.5:1 text (field errors)           | Pass   |
| `success-foreground` #0b1730     | `success` #5cc48f     | 8.26:1  | 4.5:1 text                          | Pass   |
| `success` #5cc48f                | `background` #0a1322  | 8.63:1  | 4.5:1 text (form success)           | Pass   |
| `cta-foreground` #0b1730         | `cta` #e96b56         | 5.68:1  | 4.5:1 text                          | Pass   |
| `cta-foreground` #0b1730         | `cta-hover` #f08a78   | 7.30:1  | 4.5:1 text                          | Pass   |
| `inverse-foreground` #ffffff     | `inverse` #13294b     | 14.52:1 | 4.5:1 text                          | Pass   |
| `inverse-muted` #b4c2d9          | `inverse` #13294b     | 8.06:1  | 4.5:1 text                          | Pass   |
| `cta` #e96b56                    | `inverse` #13294b     | 4.63:1  | 4.5:1 text (coral on navy band)     | Pass   |
| `input` #5b6d8a                  | `background` #0a1322  | 3.54:1  | 3.0:1 non-text (field border)       | Pass   |
| `ring` #f08a78                   | `background` #0a1322  | 7.63:1  | 3.0:1 non-text (focus ring)         | Pass   |
| `input` #5b6d8a                  | `muted` #152238       | 3.03:1  | 3.0:1 non-text (field border)       | Pass   |
| `input` #5b6d8a                  | `card` #101c30        | 3.25:1  | 3.0:1 non-text (field border)       | Pass   |
| `ring` #f08a78                   | `muted` #152238       | 6.53:1  | 3.0:1 non-text (focus ring)         | Pass   |
| `ring` #f08a78                   | `secondary` #1a2840   | 6.06:1  | 3.0:1 non-text (focus ring)         | Pass   |
| `ring` #f08a78                   | `inverse` #13294b     | 5.95:1  | 3.0:1 non-text (focus ring on band) | Pass   |
| `cta` #e96b56                    | `background` #0a1322  | 5.94:1  | 3.0:1 non-text (CTA shape)          | Pass   |

Pairs that are **not** allowed: white or ink-muted text on coral, coral (#e96b56) as text on white or mist (3.13:1), and `--border` as a control's only boundary.

### Named rules

**The One Coral Field Rule.** Coral fills at most one region per page, the closing band. Elsewhere it appears only as the CTA button, the Integral Line, station rings, small rules and focus rings.

**The Ink-on-Coral Rule.** Anything set on coral uses `--cta-foreground` (#0b1730). There are no exceptions.

### Wiring into Tailwind v4

The site shell imports `tokens.css` and exposes the variables to Tailwind with `@theme inline`, which gives utilities such as `bg-primary`, `text-muted-foreground` and `bg-cta`:

```css
@theme inline {
    --color-background: var(--background);
    --color-foreground: var(--foreground);
    --color-primary: var(--primary);
    --color-primary-foreground: var(--primary-foreground);
    /* ...one line per shadcn variable... */
    --color-cta: var(--cta);
    --color-cta-foreground: var(--cta-foreground);
    --color-emphasis: var(--emphasis);
    --color-inverse: var(--inverse);
    --color-inverse-foreground: var(--inverse-foreground);
    --color-inverse-muted: var(--inverse-muted);
    --radius-sm: calc(var(--radius) - 4px);
    --radius-md: calc(var(--radius) - 2px);
    --radius-lg: var(--radius);
    --radius-xl: calc(var(--radius) + 4px);
}
```

`tokens.css` names the font stack `--font-sans`, which is also Tailwind's own theme key. Do not alias it to itself inside `@theme inline`. Either load `tokens.css` after Tailwind's theme, or set the same stack in `@theme`.

Tailwind's default `dark:` variant already follows `prefers-color-scheme`, which matches the token file. The `.dark` class exists only to force the palette in previews and tests.

## Typography

**Inter** (variable, optical sizes 14 to 32, weights 400 to 700) is used for everything. Display sizes use Inter's display optical size, tight tracking and a 650 to 680 weight, which gives headlines their own voice without a second family. **Poppins 700** is kept only for the "WEINTEGRAL" wordmark. Both are self-hosted through `@fontsource` packages.

Fallback stack: `Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif`.

### Hierarchy

| Role     | Token            | Size                                      | Weight | Line height | Tracking | Use                               |
| -------- | ---------------- | ----------------------------------------- | ------ | ----------- | -------- | --------------------------------- |
| Display  | `--text-display` | clamp(2.5rem, 1.6rem + 3.6vw, 4.5rem)     | 680    | 1.03        | -0.035em | Homepage hero headline only       |
| Headline | `--text-h1`      | clamp(2.25rem, 1.75rem + 2vw, 3.5rem)     | 650    | 1.08        | -0.03em  | Page H1 and the closing band      |
| Section  | `--text-h2`      | clamp(1.75rem, 1.45rem + 1.2vw, 2.5rem)   | 650    | 1.15        | -0.025em | Section headings, stat figures    |
| Title    | `--text-h3`      | clamp(1.25rem, 1.15rem + 0.4vw, 1.5rem)   | 620    | 1.3         | -0.015em | Service rows, pillars, stages     |
| Subtitle | `--text-h4`      | 1.125rem                                  | 620    | 1.4         | -0.01em  | Card titles, FAQ questions        |
| Lead     | `--text-lead`    | clamp(1.125rem, 1.08rem + 0.2vw, 1.25rem) | 400    | 1.55        | 0        | Intro paragraphs                  |
| Body     | `--text-body`    | 1rem                                      | 400    | 1.6         | 0        | Running text, max 65 to 75ch      |
| Small    | `--text-small`   | 0.875rem                                  | 400    | 1.5         | 0        | Descriptions, footer, breadcrumbs |
| Label    | `--text-caption` | 0.8125rem                                 | 600    | 1.4         | 0        | Utility bar, meta, captions       |

The scale steps by roughly 1.25 at desktop and compresses on small screens through `clamp()`. Headings use `text-wrap: balance` and paragraphs use `text-wrap: pretty`. Figures in stats and tables use `font-variant-numeric: tabular-nums`.

### Named rules

**The No-Eyebrow Rule.** No small uppercase kicker sits above a heading. The heading carries its own weight.

**The Sentence-Case Rule.** Headings, buttons and navigation use sentence case. Uppercase is reserved for the wordmark.

## Layout

- **Container:** `--container-max` 77.5rem (1240px) with a side gutter of `--gutter`, which is clamp(1rem, 4vw, 2rem).
- **Spacing:** 4px base, using the Tailwind scale (1, 2, 3, 4, 6, 8, 12, 16). Sections are separated by `--section-space`, clamp(4rem, 3rem + 5vw, 7.5rem). Headings get more space above than below.
- **Rhythm:** alternate Paper and Mist sections, with navy bands for the hero, process and footer and one coral closing band. Never stack two navy or two coral regions.
- **Grids:** two-column splits run 5:7 (intro and content) or 1:1 (careers teaser). Lists of three run as columns with hairline dividers rather than boxed cards.
- **Breakpoints:** 64rem (the desktop nav collapses to the menu button), 52rem (splits stack and the process line turns vertical) and 36rem (the utility bar hides, hero buttons go full width and the hero line hides).
- **Header:** a 36px utility bar, then a 72px header (64px on mobile). The primary nav sits left after the logo and "Talk to an Expert" sits on the right.

## Elevation & Depth

The system is mostly flat with tonal layering: Paper, then Mist, then the navy bands. Shadows only appear on things that float above the page. Every shadow is navy-tinted, offset and blurred, never a zero-offset glow.

- **sm** (`0 1px 2px rgb(11 23 48 / .06)`): subtle lift on small controls.
- **md** (`0 4px 12px -2px rgb(11 23 48 / .1), 0 2px 4px -2px rgb(11 23 48 / .06)`): hover state of related-Service links and cards.
- **lg** (`0 24px 48px -16px rgb(11 23 48 / .24), 0 4px 12px -4px rgb(11 23 48 / .08)`): the mega-menu, dropdowns and sheets.

Dark mode swaps the tint for black at higher alpha (see `tokens.css`).

## Shapes

- `--radius` is 0.5rem (8px). Following shadcn's convention, sm, md, lg and xl are 4, 6, 8 and 12px. Buttons, inputs and tiles use 8px, nav triggers use 6px, and panels (the mega-menu feature, "At a glance", the photo frame) use 12px.
- Circles appear only as Integral Line stations, process stage markers, numbered steps and the round arrow button on Service rows.
- Borders are 1px hairlines. Placeholders use a 1.5px dashed coral-text border, in comps only.
- There are no coloured side borders on cards or callouts. Accents are short 24px by 2px coral rules above a heading.

## Components

Map these onto shadcn/ui components where one exists: Button, NavigationMenu (mega-menu), DropdownMenu, Sheet (mobile menu), Accordion (FAQ and mobile submenus), Breadcrumb, Input, Textarea, Label, Form and Table.

### Buttons

- **Shape:** 8px radius, minimum height 44px (52px for `lg`), 600 weight, 15px text (16px for `lg`).
- **CTA** (`--cta`, `--cta-foreground`): "Talk to an Expert" only, used once per viewport region. Hover uses `--cta-hover`.
- **Primary** (navy): secondary conversions such as "Browse open positions".
- **Outline:** a `--input` border on light surfaces, or an `--inverse-border` border on navy bands ("Find a role").
- **Ink:** ink fill with white text, used only on the coral closing band.
- **Arrow behaviour:** a trailing arrow nudges 3px right on hover (320ms ease-out).
- **Focus:** a 2px `--ring` outline with a 3px offset.

### Navigation

- **Utility bar:** email and phone on the left; Candidate Resources and Careers on the right.
- **Primary nav:** Services (mega-menu), Industries, Insights (external, with an arrow icon and an "opens the blog" screen-reader label), About (dropdown: Who We Are, Leadership) and Careers (dropdown: Open Positions, Culture, Benefits).
- **Trigger states:** hover and open use the `--accent` wash, and the chevron rotates 180°. The current section gets a 2px coral underline.
- **Mega-menu:** full width under the header, `--popover` background, shadow lg. On the left is "View all Services" plus the five Services in two columns (name plus a one-line outcome). On the right is a navy feature panel, "Not sure which Service fits?", with the CTA. It opens on click or Enter, and Escape, an outside click or opening another menu closes it. Focus returns to the trigger.
- **Mobile (below 64rem):** a menu button opens a full-height sheet. Sections are accordions (Services is expanded in the comp), rows are 56px, and the CTA plus email and phone are pinned to the bottom.

### Service index rows

The homepage Services list is a ruled index, not a card grid. Each row holds the name (Title), a one-line outcome (muted) and a round arrow button. On hover the row tints to Mist, the name turns coral-text and the arrow fills coral.

### The Integral Line (signature)

An SVG ∫-shaped line in the homepage hero. A 14px `--inverse-border` track sits under a 3px coral line, with the five Services as linked stations (9px ring, label and one-word role). It draws once on load (1200ms ease-out, `pathLength` 1) and is static under `prefers-reduced-motion`. Hovering a station fills it coral and dims the other stations to 55%. It is hidden below 36rem, where the Services list follows directly. The same line grammar runs horizontally (vertically on mobile) through the Discover, Build, Run process band.

### Cards and containers

- **Logo tiles:** always a white tile with a hairline border (logos are supplied on white). Logos are greyscale at 80% and show full colour on hover.
- **Panels:** "At a glance" and the mega feature use a 12px radius, Mist or navy fill, 28px padding and no shadow.
- **Related links:** a hairline-bordered card that gains shadow md and an `--input` border on hover.

### Inputs and fields

These are not in the comps yet; they are built with the contact form (#60). Inputs are 44px high with an 8px radius, a 1px `--input` border on `--background` and a `--ring` focus outline. Errors use a `--destructive` border and text below the field. The success message uses `--success`.

### Placeholders (comps only)

Unconfirmed facts are wrapped in a dashed coral-text outline on a pale coral wash (`.ph`). Production must never ship this style: each placeholder is either filled or removed, and tracked in the launch checklist.

## Motion

- **Easing:** `--ease-out` is cubic-bezier(0.16, 1, 0.3, 1), an exponential ease-out.
- **Durations:** fast 120ms (hover fills), base 200ms (colour and chevrons), slow 320ms (arrow nudges and logo colour) and draw 1200ms (the Integral Line).
- **Authored moment:** the Integral Line drawing in is the page's one authored animation. Sections do not fade or slide in on scroll.
- **Reduced motion:** all transitions and animations collapse to 1ms, and content is visible by default.

## Do's and Don'ts

- **Do** use ink (#0b1730) text on coral, and coral-text (#b5412e) for coral-coloured text on light surfaces.
- **Do** keep "Talk to an Expert" as the only coral button in a region.
- **Do** theme browser surfaces: `::selection` is coral with ink text, focus rings use `--ring`, and `scrollbar-color` uses `--input`.
- **Do** mark every unconfirmed fact as a placeholder and add it to the launch checklist.
- **Don't** put white text on coral, or coral text on white.
- **Don't** use shadcn `--accent` for brand emphasis. It is a hover wash.
- **Don't** add gradient text, glass blur as decoration, zero-offset glows or coloured side borders.
- **Don't** add eyebrow labels above headings, or decorative section numbers. The numbered "How we deliver" steps are allowed because their order matters.
- **Don't** publish the current site's template testimonials.
- **Don't** reuse copy, colours, logos or imagery from reference sites.
