import { Fragment } from "react";

import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";

import type { NavLink } from "./site-navigation";

/**
 * The breadcrumb trail every inner page opens with: Home, then the page's ancestors,
 * then the current page (not a link).
 */
export function PageBreadcrumbs({
    trail = [],
    current,
}: {
    /** Ancestors between Home and the current page, outermost first. */
    trail?: NavLink[];
    current: string;
}) {
    return (
        <Breadcrumb aria-label="Breadcrumb">
            <BreadcrumbList className="gap-2">
                {[{ label: "Home", href: "/" }, ...trail].map((crumb) => (
                    <Fragment key={crumb.href}>
                        <BreadcrumbItem>
                            <BreadcrumbLink href={crumb.href} className="hover:underline">
                                {crumb.label}
                            </BreadcrumbLink>
                        </BreadcrumbItem>
                        <BreadcrumbSeparator>/</BreadcrumbSeparator>
                    </Fragment>
                ))}
                <BreadcrumbItem>
                    <BreadcrumbPage>{current}</BreadcrumbPage>
                </BreadcrumbItem>
            </BreadcrumbList>
        </Breadcrumb>
    );
}
