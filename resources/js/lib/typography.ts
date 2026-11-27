/**
 * The heading type roles from DESIGN.md (Typography › Hierarchy) as Tailwind classes,
 * so every page sets each role the same way. Size comes from the token; weight,
 * line height and tracking from the role.
 */
export const typeRoles = {
    /** Homepage hero headline only. */
    display:
        "text-(length:--text-display) leading-[1.03] font-[680] tracking-[-0.035em] text-balance",
    /** Page H1 and the closing band. */
    headline: "text-(length:--text-h1) leading-[1.08] font-[650] tracking-[-0.03em] text-balance",
    /** Section headings and stat figures. */
    section: "text-(length:--text-h2) leading-[1.15] font-[650] tracking-[-0.025em] text-balance",
    /** Service rows, pillars, stages. */
    title: "text-(length:--text-h3) leading-[1.3] font-[620] tracking-[-0.015em]",
    /** Card titles, FAQ questions. */
    subtitle: "text-(length:--text-h4) leading-[1.4] font-[620] tracking-[-0.01em]",
    /** Intro paragraphs. */
    lead: "text-(length:--text-lead) leading-[1.55]",
} as const;
