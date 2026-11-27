import { Head, usePage } from "@inertiajs/react";

import { pageTitle, siteName } from "@/lib/page-title";

export interface SeoProps {
    /** Page title without the site name; the app appends " | WeIntegral". */
    title: string;
    /** Meta description, unique per page, roughly 120 to 160 characters. */
    description: string;
}

/**
 * The page's search and sharing metadata: title, description, canonical URL,
 * Open Graph and Twitter tags. Rendered into <head> during SSR by Inertia.
 */
export function Seo({ title, description }: SeoProps) {
    const { canonicalUrl } = usePage().props.site;
    const fullTitle = pageTitle(title);

    return (
        <Head title={title}>
            <meta head-key="description" name="description" content={description} />
            <link head-key="canonical" rel="canonical" href={canonicalUrl} />

            <meta head-key="og:type" property="og:type" content="website" />
            <meta head-key="og:site_name" property="og:site_name" content={siteName} />
            <meta head-key="og:locale" property="og:locale" content="en_US" />
            <meta head-key="og:title" property="og:title" content={fullTitle} />
            <meta head-key="og:description" property="og:description" content={description} />
            <meta head-key="og:url" property="og:url" content={canonicalUrl} />

            <meta head-key="twitter:card" name="twitter:card" content="summary" />
            <meta head-key="twitter:title" name="twitter:title" content={fullTitle} />
            <meta head-key="twitter:description" name="twitter:description" content={description} />
        </Head>
    );
}
