import "@inertiajs/core";

/** An office address as plain lines, from App\Services\ContactInfo. */
export interface Office {
    name: string;
    addressLines: string[];
}

/** Props HandleInertiaRequests::share() gives every page, for the site shell. */
export interface SiteProps {
    contact: { email: string; phone: string };
    offices: Office[];
    /** Absolute URL of the current page without its query string. */
    canonicalUrl: string;
}

declare module "@inertiajs/core" {
    export interface InertiaConfig {
        sharedPageProps: {
            site: SiteProps;
        };
    }
}
