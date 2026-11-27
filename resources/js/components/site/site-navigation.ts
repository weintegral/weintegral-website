/**
 * The site's fixed information architecture, shared by the header, mobile menu and footer.
 * The Services and Industries lists come from Laravel as shared props (`site.services`,
 * `site.industries`); see resources/js/types/inertia.d.ts.
 */

export interface NavLink {
    label: string;
    href: string;
}

export const contactHref = "/contact";
export const servicesHref = "/services";
export const industriesHref = "/industries";
export const careersHref = "/career";
export const candidateResourcesHref = "/resources";

/** Insights is the external blog. */
export const insightsHref = "https://blog.weintegral.com";

export const aboutLinks: NavLink[] = [
    { label: "Who We Are", href: "/about" },
    { label: "Leadership", href: "/team" },
];

export const openPositionsLink: NavLink = { label: "Open Positions", href: "/career/openings" };

export const careersLinks: NavLink[] = [
    openPositionsLink,
    { label: "Culture", href: "/career/work-culture" },
    { label: "Benefits", href: "/career/benefits" },
];

export const companyLinks: NavLink[] = [
    ...aboutLinks,
    { label: "Careers", href: careersHref },
    { label: "Contact", href: contactHref },
];

export const legalLinks: NavLink[] = [
    { label: "Terms of Service", href: "/terms-of-service" },
    { label: "Privacy Policy", href: "/privacy-policy" },
];

/** Turns a display phone number into a dialable tel: href. */
export function telHref(phone: string): string {
    return `tel:${phone.replace(/[^+\d]/g, "")}`;
}
