/**
 * The site's information architecture, shared by the header, mobile menu and footer.
 *
 * Every href is a plain path: pages not yet migrated to Inertia are still Blade pages,
 * so the shell links with ordinary anchors (full page loads) rather than Inertia visits.
 */

export interface NavLink {
    label: string;
    href: string;
}

export interface ServiceLink extends NavLink {
    /** One-line outcome shown under the Service name in the menus. */
    outcome: string;
}

export const contactHref = "/contact";
export const servicesHref = "/services";
export const industriesHref = "/industries";
export const careersHref = "/career";
export const candidateResourcesHref = "/resources";

/** Insights is the external blog. */
export const insightsHref = "https://blog.weintegral.com";

export const services: ServiceLink[] = [
    {
        label: "Application Development",
        href: "/app-development",
        outcome: "Web and mobile applications built around your process",
    },
    {
        label: "Application Support",
        href: "/app-support",
        outcome: "Maintenance and production support for critical systems",
    },
    {
        label: "Quality Assurance & Testing",
        href: "/testing",
        outcome: "Testing focused on deployment readiness",
    },
    {
        label: "DevOps & Cloud",
        href: "/devops",
        outcome: "Pipelines and cloud deployment, commit to production",
    },
    {
        label: "IT Staffing",
        href: "/staffing",
        outcome: "Skilled IT professionals for the roles you need",
    },
];

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

/** Industries named in the footer. Awaiting owner confirmation (launch checklist). */
export const footerIndustries: NavLink[] = [
    { label: "Banking", href: industriesHref },
    { label: "Insurance", href: industriesHref },
    { label: "Ecommerce", href: industriesHref },
    { label: "All Industries", href: industriesHref },
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
