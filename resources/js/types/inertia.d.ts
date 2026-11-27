import "@inertiajs/core";

/** An office and its postal address as display lines, from App\Services\ContactInfo::offices(). */
export interface Office {
    name: string;
    addressLines: string[];
}

/** A Service as the site lists it, from App\Content\ServiceCatalog::listings(). */
export interface ServiceListing {
    name: string;
    href: string;
    /** One-line outcome shown under the Service name in the menus. */
    outcome: string;
}

/** An Industry WeIntegral serves, from App\Content\IndustryCatalog. */
export interface Industry {
    name: string;
    /** One line on what WeIntegral offers this Industry. */
    summary: string;
}

/** A link to one of the firm's social profiles. */
export interface SocialLink {
    label: string;
    href: string;
}

/**
 * Sample content for the site shell, from App\Content\SampleContent::shell(). Present
 * only when SITE_SAMPLE_CONTENT is on (never in production): every page then shows
 * the `notice` banner, and the values here stand in for facts the owner has not supplied.
 */
export interface SampleShell {
    /** "Sample content — not for publication". */
    notice: string;
    /** The closing band's reply-time promise. */
    replyTime: string;
    socialLinks: SocialLink[];
}

/** The default Open Graph and Twitter image. */
export interface ShareImage {
    url: string;
    width: number;
    height: number;
    alt: string;
}

/** Props HandleInertiaRequests::share() gives every page, for the site shell. */
export interface SiteProps {
    contact: { email: string; phone: string };
    offices: Office[];
    services: ServiceListing[];
    industries: Industry[];
    /** Absolute URL of the current page without its query string. */
    canonicalUrl: string;
    shareImage: ShareImage;
    /** Null unless sample content is on. */
    sample: SampleShell | null;
}

declare module "@inertiajs/core" {
    export interface InertiaConfig {
        sharedPageProps: {
            site: SiteProps;
        };
    }
}
