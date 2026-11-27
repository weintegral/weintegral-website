import type { ReactNode } from "react";

import type { NavLink } from "@/components/site/site-navigation";

/**
 * The opening band of an About-section page: breadcrumb trail, the page's single h1,
 * a lead paragraph and optional actions (comp B's page hero, without the aside).
 */
export function PageIntro({
    trail,
    title,
    lead,
    children,
}: {
    /** Ancestors of this page, from Home down; the current page is appended. */
    trail: NavLink[];
    title: string;
    lead: ReactNode;
    children?: ReactNode;
}) {
    return (
        <section aria-labelledby="page-title" className="border-b border-border bg-muted">
            <div className="mx-auto max-w-(--container-max) px-(--gutter) py-12 lg:py-20">
                <nav aria-label="Breadcrumb" className="text-sm text-muted-foreground">
                    <ol className="flex flex-wrap gap-2">
                        {trail.map((link) => (
                            <li key={link.href} className="flex gap-2">
                                <a
                                    href={link.href}
                                    className="hover:text-foreground hover:underline"
                                >
                                    {link.label}
                                </a>
                                <span aria-hidden="true">/</span>
                            </li>
                        ))}
                        <li aria-current="page">{title}</li>
                    </ol>
                </nav>
                <h1
                    id="page-title"
                    className="mt-6 text-(length:--text-h1) leading-[1.08] font-semibold tracking-tight"
                >
                    {title}
                </h1>
                <p className="mt-5 max-w-[52ch] text-(length:--text-lead) text-muted-foreground">
                    {lead}
                </p>
                {children ? <div className="mt-8 flex flex-wrap gap-3">{children}</div> : null}
            </div>
        </section>
    );
}

/** A section heading with the brand's short coral rule above it (DESIGN.md, Borders). */
export function SectionHeading({
    id,
    children,
    intro,
}: {
    id: string;
    children: ReactNode;
    intro?: ReactNode;
}) {
    return (
        <div className="mb-10 lg:mb-14">
            <h2
                id={id}
                className="relative pt-4 text-(length:--text-h2) leading-tight font-semibold tracking-tight before:absolute before:top-0 before:left-0 before:h-0.5 before:w-6 before:bg-brand-coral"
            >
                {children}
            </h2>
            {intro ? <p className="mt-4 max-w-[52ch] text-muted-foreground">{intro}</p> : null}
        </div>
    );
}
