import type { ReactNode } from "react";

import { SampleBanner } from "./sample-banner";
import { Seo } from "./seo";
import { SiteFooter } from "./site-footer";
import { SiteHeader } from "./site-header";

/**
 * The shared shell for every public Inertia page: SEO head (from the page's `seo`
 * prop), skip link, the sample-content banner (only while sample content is on), utility
 * bar and header, the page's own content as <main>, and the footer.
 */
export function SiteLayout({ children }: { children: ReactNode }) {
    return (
        <>
            <Seo />
            <a
                href="#main-content"
                className="sr-only z-50 rounded-lg bg-background px-4 py-2 font-semibold focus:not-sr-only focus:fixed focus:top-2 focus:left-2"
            >
                Skip to content
            </a>
            <SampleBanner />
            <SiteHeader />
            <main id="main-content" tabIndex={-1} className="outline-none">
                {children}
            </main>
            <SiteFooter />
        </>
    );
}
