import type { ReactNode } from "react";

import { typeRoles } from "@/lib/typography";

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
                    <h3 className={`mt-4 ${typeRoles.subtitle}`}>{pillar.title}</h3>
                    <p className="mt-2 text-pretty text-muted-foreground">{pillar.body}</p>
                </li>
            ))}
        </ul>
    );
}
