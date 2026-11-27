import { cn } from "cn";
import type { ReactNode } from "react";

import { typeRoles } from "@/lib/typography";

/**
 * A section's h2 in the Section type role (DESIGN.md), with an optional intro below it
 * and an optional action (such as an "All Services" link) to its right.
 */
export function SectionHeading({
    id,
    children,
    intro,
    action,
    accent = false,
    inverse = false,
    className,
}: {
    id: string;
    children: ReactNode;
    intro?: ReactNode;
    action?: ReactNode;
    /** Adds the brand's short coral rule above the heading (DESIGN.md, Shapes). */
    accent?: boolean;
    /** Set on a navy band, where the intro uses the inverse muted colour. */
    inverse?: boolean;
    className?: string;
}) {
    return (
        <div className={cn("flex flex-wrap items-end justify-between gap-8", className)}>
            <div>
                <h2
                    id={id}
                    className={cn(
                        typeRoles.section,
                        accent &&
                            "relative pt-4 before:absolute before:top-0 before:left-0 before:h-0.5 before:w-6 before:bg-brand-coral",
                    )}
                >
                    {children}
                </h2>
                {intro ? (
                    <p
                        className={cn(
                            "mt-4 max-w-[52ch] text-pretty",
                            inverse ? "text-inverse-muted" : "text-muted-foreground",
                        )}
                    >
                        {intro}
                    </p>
                ) : null}
            </div>
            {action}
        </div>
    );
}

/** The space below a SectionHeading that introduces a list or grid. */
export const sectionHeadingGap = "mb-[clamp(2rem,1.5rem+2vw,3.5rem)]";
