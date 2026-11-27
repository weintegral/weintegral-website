import type { ReactNode } from "react";
import { cn } from "cn";

/**
 * Marks content awaiting the owner (DESIGN.md, Placeholders): a dashed coral outline.
 * Every use must be listed in the launch checklist and filled or removed before launch.
 */
export function Placeholder({ children, className }: { children: ReactNode; className?: string }) {
    return (
        <em
            data-placeholder=""
            className={cn(
                "rounded-sm border border-dashed border-cta bg-cta/16 px-[0.35em] py-[0.05em] not-italic [box-decoration-break:clone]",
                className,
            )}
        >
            {children}
        </em>
    );
}
