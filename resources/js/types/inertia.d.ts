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
}

declare module "@inertiajs/core" {
    export interface InertiaConfig {
        sharedPageProps: {
            site: SiteProps;
        };
    }
}
