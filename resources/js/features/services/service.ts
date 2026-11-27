/**
 * The content of a Service page, as App\Content\ServiceCatalog hands it to the page.
 * Laravel owns the copy; these types mirror its shape.
 */

/** Copy awaiting the owner: rendered in the visible placeholder style and listed in the launch checklist. */
export interface PendingCopy {
    placeholder: string;
}

/** A piece of copy that is either confirmed text or a placeholder. */
export type Copy = string | PendingCopy;

export interface ServiceLink {
    name: string;
    href: string;
}

export interface Service extends ServiceLink {
    slug: string;
    /** One-line outcome, as in the Services menu. */
    outcome: string;
    seo: { title: string; description: string };
    /** Hero lead: the problem the Service solves. */
    summary: string;
    atAGlance: { term: string; detail: Copy }[];
    overview: { heading: string; paragraphs: Copy[] };
    /** "What you get": three outcome-led pillars, each with its capabilities. */
    pillars: { heading: string; capabilities: Copy[] }[];
    delivery: { intro: string; steps: { title: string; description: string }[] };
    engagementOptions: PendingCopy;
    /** Technologies, tools or (IT Staffing) skills; an empty list shows only the note. */
    technologies: { heading: string; items: string[]; note: Copy };
    caseStory: PendingCopy;
    faqs: { question: string; answer: Copy }[];
    relatedServices: ServiceLink[];
}

/** A Service as listed on the Services overview. */
export interface ServiceSummary extends ServiceLink {
    outcome: string;
    /** The headings of the Service's pillars. */
    highlights: string[];
}

export function isPending(copy: Copy): copy is PendingCopy {
    return typeof copy !== "string";
}
