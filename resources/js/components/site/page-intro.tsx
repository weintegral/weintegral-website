import type { ReactNode } from "react";

import { typeRoles } from "@/lib/typography";

import { PageBreadcrumbs } from "./page-breadcrumbs";
import type { NavLink } from "./site-navigation";

/**
 * The opening band of an inner page: breadcrumb trail, the page's single h1, a lead
 * paragraph and optional actions (comp B's page hero, without the aside).
 */
export function PageIntro({
    trail = [],
    title,
    lead,
    children,
}: {
    /** Ancestors between Home and this page, outermost first. */
    trail?: NavLink[];
    /** The page's h1, also its breadcrumb label. */
    title: string;
    lead: ReactNode;
    /** Actions (buttons, links) under the lead. */
    children?: ReactNode;
}) {
    return (
        <section aria-labelledby="page-title" className="border-b border-border bg-muted">
            <div className="mx-auto max-w-(--container-max) px-(--gutter) py-12 lg:py-20">
                <PageBreadcrumbs trail={trail} current={title} />
                <h1 id="page-title" className={`mt-6 ${typeRoles.headline}`}>
                    {title}
                </h1>
                <p
                    className={`mt-5 max-w-[52ch] text-pretty text-muted-foreground ${typeRoles.lead}`}
                >
                    {lead}
                </p>
                {children ? (
                    <div className="mt-8 flex flex-wrap items-center gap-3">{children}</div>
                ) : null}
            </div>
        </section>
    );
}
