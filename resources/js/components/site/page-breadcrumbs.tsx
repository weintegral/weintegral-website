import type { NavLink } from "./site-navigation";

/** A breadcrumb trail from Home; the last crumb is the current page and is not a link. */
export function PageBreadcrumbs({ trail, current }: { trail: NavLink[]; current: string }) {
    return (
        <nav aria-label="Breadcrumb" className="text-sm text-muted-foreground">
            <ol className="flex flex-wrap gap-2">
                {[{ label: "Home", href: "/" }, ...trail].map((crumb) => (
                    <li key={crumb.href} className="flex gap-2">
                        <a href={crumb.href} className="hover:text-foreground hover:underline">
                            {crumb.label}
                        </a>
                        <span aria-hidden="true">/</span>
                    </li>
                ))}
                <li aria-current="page">{current}</li>
            </ol>
        </nav>
    );
}
