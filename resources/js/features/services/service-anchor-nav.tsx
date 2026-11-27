import { useEffect, useState } from "react";

export interface Anchor {
    id: string;
    label: string;
}

/**
 * The sticky "On this page" navigation. Plain in-page links work without
 * JavaScript; once hydrated, the link for the section in view is marked current.
 */
export function ServiceAnchorNav({ anchors }: { anchors: Anchor[] }) {
    const [current, setCurrent] = useState(anchors[0]?.id);

    useEffect(() => {
        const sections = anchors
            .map((anchor) => document.getElementById(anchor.id))
            .filter((element): element is HTMLElement => element !== null);

        // A section counts as "in view" once it crosses the upper third of the viewport.
        const observer = new IntersectionObserver(
            (entries) => {
                const visible = entries.filter((entry) => entry.isIntersecting);
                const last = visible[visible.length - 1];
                if (last) {
                    setCurrent(last.target.id);
                }
            },
            { rootMargin: "-20% 0px -66% 0px" },
        );

        sections.forEach((section) => observer.observe(section));

        return () => observer.disconnect();
    }, [anchors]);

    return (
        <nav
            aria-label="On this page"
            className="sticky top-0 z-20 border-b border-border bg-background/92 backdrop-blur-md backdrop-saturate-150"
        >
            <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                <ul className="flex gap-7 overflow-x-auto [scrollbar-width:none]">
                    {anchors.map((anchor) => (
                        <li key={anchor.id}>
                            <a
                                href={`#${anchor.id}`}
                                aria-current={current === anchor.id ? "true" : undefined}
                                onClick={() => setCurrent(anchor.id)}
                                className="block py-4 text-sm font-[550] whitespace-nowrap text-muted-foreground shadow-[inset_0_-2px_0_transparent] transition-[color,box-shadow] duration-(--duration-base) ease-brand hover:text-foreground aria-[current=true]:text-foreground aria-[current=true]:shadow-[inset_0_-2px_0_var(--brand-coral)]"
                            >
                                {anchor.label}
                            </a>
                        </li>
                    ))}
                </ul>
            </div>
        </nav>
    );
}
