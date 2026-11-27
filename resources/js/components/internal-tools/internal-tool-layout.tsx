import { Head } from "@inertiajs/react";
import type { ReactNode } from "react";

import { SiteFooter } from "@/components/site/site-footer";
import { SiteHeader } from "@/components/site/site-header";
import { typeRoles } from "@/lib/typography";

/**
 * The shell for an Internal Tools page: the public header and footer around a plain
 * heading and content. No SEO metadata: the server marks these pages noindex
 * (robots meta and X-Robots-Tag), and nothing in the public navigation links here.
 */
export function InternalToolLayout({
    title,
    intro,
    children,
}: {
    title: string;
    intro?: ReactNode;
    children: ReactNode;
}) {
    return (
        <>
            <Head title={title} />
            <a
                href="#main-content"
                className="sr-only z-50 rounded-lg bg-background px-4 py-2 font-semibold focus:not-sr-only focus:fixed focus:top-2 focus:left-2"
            >
                Skip to content
            </a>
            <SiteHeader />
            <main id="main-content" tabIndex={-1} className="outline-none">
                <div className="mx-auto max-w-(--container-max) px-(--gutter) py-12 lg:py-16">
                    <p className="text-sm text-muted-foreground">Internal Tools</p>
                    <h1 className={`mt-2 ${typeRoles.section}`}>{title}</h1>
                    {intro ? <p className="mt-3 max-w-2xl text-muted-foreground">{intro}</p> : null}
                    <div className="mt-8">{children}</div>
                </div>
            </main>
            <SiteFooter />
        </>
    );
}
