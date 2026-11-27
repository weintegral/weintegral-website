import { cn } from "cn";
import type { ReactNode } from "react";

import { Placeholder } from "@/components/site/placeholder";

import { isPending, type Copy } from "./service";

/** Renders confirmed copy as text and pending copy in the placeholder style. */
export function CopyText({ copy }: { copy: Copy }) {
    return isPending(copy) ? <Placeholder>{copy.placeholder}</Placeholder> : copy;
}

/**
 * A whole section or block awaiting the owner (DESIGN.md, Placeholders): a dashed
 * coral outline around a title and what will go there.
 */
export function PlaceholderBlock({
    id,
    title,
    children,
    className,
}: {
    id?: string;
    title: string;
    children: ReactNode;
    className?: string;
}) {
    return (
        <div
            id={id}
            data-placeholder=""
            className={cn(
                "scroll-mt-20 rounded-lg border-[1.5px] border-dashed border-emphasis bg-[rgb(233_107_86/0.08)] px-6 py-5",
                className,
            )}
        >
            <h2 className="mb-1 font-semibold">{title}</h2>
            <p>{children}</p>
        </div>
    );
}
