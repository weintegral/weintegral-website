import { Head, usePage } from "@inertiajs/react";

import { pageTitle, siteName } from "@/lib/page-title";

/** A public page's `seo` prop, from Controller::seo() in Laravel. */
export interface SeoProps {
    /** Page title without the site name; the app appends " | WeIntegral". */
    title: string;
    /** Meta description, unique per page, roughly 120 to 160 characters. */
    description: string;
}

/**
 * The page's search and sharing metadata, from its `seo` prop: title, description,
 * canonical URL, Open Graph and Twitter tags (with the default share image). Rendered into <head> during SSR by
 * Inertia; resources/views/app.blade.php renders the same tags when SSR is down.
 */
export function Seo() {
    const { props } = usePage<{ seo: SeoProps }>();
    const { title, description } = props.seo;
    const { canonicalUrl, shareImage } = props.site;
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
            <meta head-key="og:image" property="og:image" content={shareImage.url} />
            <meta
                head-key="og:image:width"
                property="og:image:width"
                content={String(shareImage.width)}
            />
            <meta
                head-key="og:image:height"
                property="og:image:height"
                content={String(shareImage.height)}
            />
            <meta head-key="og:image:alt" property="og:image:alt" content={shareImage.alt} />

            <meta head-key="twitter:card" name="twitter:card" content="summary_large_image" />
            <meta head-key="twitter:title" name="twitter:title" content={fullTitle} />
            <meta head-key="twitter:description" name="twitter:description" content={description} />
        </Head>
    );
}
