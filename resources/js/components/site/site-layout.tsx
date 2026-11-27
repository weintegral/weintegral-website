import type { ReactNode } from "react";

import { Seo, type SeoProps } from "./seo";
import { SiteFooter } from "./site-footer";
import { SiteHeader } from "./site-header";

/**
 * The shared shell for every public Inertia page: SEO head, skip link, utility bar
 * and header, the page's own content as <main>, and the footer.
 */
export function SiteLayout({ seo, children }: { seo: SeoProps; children: ReactNode }) {
    return (
        <>
            <Seo {...seo} />
            <a
                href="#main-content"
                className="sr-only z-50 rounded-lg bg-background px-4 py-2 font-semibold focus:not-sr-only focus:fixed focus:top-2 focus:left-2"
            >
                Skip to content
            </a>
            <SiteHeader />
            <main id="main-content" tabIndex={-1} className="outline-none">
                {children}
            </main>
            <SiteFooter />
        </>
    );
}
