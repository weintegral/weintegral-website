import type { ReactNode } from "react";

import { careersHref } from "@/components/site/site-navigation";

interface CareersPageIntroProps {
    /** The page's H1, also its breadcrumb label. */
    title: string;
    /** Intro paragraph under the heading. */
    lead: ReactNode;
    /** Whether the breadcrumb passes through Careers (true for the Careers sub-pages). */
    withinCareers?: boolean;
    /** Actions or extra content under the lead. */
    children?: ReactNode;
}

/** Breadcrumb, H1 and lead that open every Careers and Candidate Resources page. */
export function CareersPageIntro({
    title,
    lead,
    withinCareers = false,
    children,
}: CareersPageIntroProps) {
    return (
        <div className="border-b bg-muted">
            <div className="mx-auto max-w-(--container-max) px-(--gutter) py-12 lg:py-16">
                <nav aria-label="Breadcrumb" className="text-sm text-muted-foreground">
                    <ol className="flex flex-wrap gap-2">
                        <li>
                            <a href="/" className="hover:text-foreground hover:underline">
                                Home
                            </a>
                        </li>
                        <li aria-hidden="true">/</li>
                        {withinCareers && (
                            <>
                                <li>
                                    <a
                                        href={careersHref}
                                        className="hover:text-foreground hover:underline"
                                    >
                                        Careers
                                    </a>
                                </li>
                                <li aria-hidden="true">/</li>
                            </>
                        )}
                        <li aria-current="page">{title}</li>
                    </ol>
                </nav>
                <h1 className="mt-4 text-(length:--text-h1) leading-tight font-semibold tracking-tight text-balance">
                    {title}
                </h1>
                <p className="mt-4 max-w-2xl text-(length:--text-lead) text-pretty text-muted-foreground">
                    {lead}
                </p>
                {children}
            </div>
        </div>
    );
}

/** A page section with the standard container and vertical rhythm. */
export function CareersSection({
    labelledBy,
    muted = false,
    children,
}: {
    labelledBy: string;
    muted?: boolean;
    children: ReactNode;
}) {
    return (
        <section aria-labelledby={labelledBy} className={muted ? "border-y bg-muted" : undefined}>
            <div className="mx-auto max-w-(--container-max) px-(--gutter) py-14 lg:py-20">
                {children}
            </div>
        </section>
    );
}

/** Section heading at the Section (h2) size. */
export function SectionHeading({ id, children }: { id: string; children: ReactNode }) {
    return (
        <h2
            id={id}
            className="text-(length:--text-h2) leading-tight font-semibold tracking-tight text-balance"
        >
            {children}
        </h2>
    );
}

/**
 * Three to five headed points in hairline-divided columns (DESIGN.md: lists of three run as
 * columns with dividers, a short coral rule above each heading).
 */
export function PillarList({ pillars }: { pillars: { title: string; body: ReactNode }[] }) {
    return (
        <ul className="mt-10 grid gap-x-10 gap-y-8 md:grid-cols-3">
            {pillars.map((pillar) => (
                <li key={pillar.title} className="border-t pt-6">
                    <span aria-hidden="true" className="block h-0.5 w-6 bg-brand-coral" />
                    <h3 className="mt-4 text-(length:--text-h4) font-semibold">{pillar.title}</h3>
                    <p className="mt-2 text-pretty text-muted-foreground">{pillar.body}</p>
                </li>
            ))}
        </ul>
    );
}
