import { usePage } from "@inertiajs/react";
import { ArrowUpRight } from "lucide-react";

import { Placeholder } from "./placeholder";
import {
    candidateResourcesHref,
    companyLinks,
    industriesHref,
    insightsHref,
    legalLinks,
    openPositionsLink,
    telHref,
    type NavLink,
} from "./site-navigation";
import { Wordmark } from "./wordmark";

const legalEntity = "West East Integral Inc.";

const linkClass = "hover:text-inverse-foreground hover:underline";

/** The four-column footer: Services, Industries, Company, Resources, then offices, contact, social and legal. */
export function SiteFooter() {
    const { contact, offices, services, industries, sample } = usePage().props.site;
    const serviceLinks = services.map((service) => ({ label: service.name, href: service.href }));
    // Every Industry links to the Industries page until each has its own page.
    const industryLinks = [
        ...industries.map((industry) => ({ label: industry.name, href: industriesHref })),
        { label: "All Industries", href: industriesHref },
    ];

    return (
        <footer className="bg-inverse text-sm text-inverse-muted">
            <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                <div className="grid grid-cols-1 gap-8 pt-16 pb-12 sm:grid-cols-2 lg:grid-cols-[minmax(0,1.3fr)_repeat(4,minmax(0,1fr))]">
                    <div className="sm:col-span-2 lg:col-span-1">
                        <Wordmark className="text-inverse-foreground lg:text-xl" />
                        <p className="mt-4 max-w-[30ch]">
                            Application development, support, testing, DevOps and IT staffing for
                            businesses of all sizes.
                        </p>
                    </div>
                    <FooterColumn title="Services" links={serviceLinks} />
                    <FooterColumn title="Industries" links={industryLinks} />
                    <FooterColumn title="Company" links={companyLinks} />
                    <nav aria-labelledby="footer-resources">
                        <h2
                            id="footer-resources"
                            className="mb-4 font-semibold text-inverse-foreground"
                        >
                            Resources
                        </h2>
                        <ul className="space-y-2.5">
                            <li>
                                <a
                                    href={insightsHref}
                                    target="_blank"
                                    rel="noopener"
                                    className={`inline-flex items-center gap-1.5 ${linkClass}`}
                                >
                                    Insights
                                    <ArrowUpRight className="size-3.5" aria-hidden="true" />
                                    <span className="sr-only">(opens the blog in a new tab)</span>
                                </a>
                            </li>
                            <li>
                                <a href={openPositionsLink.href} className={linkClass}>
                                    {openPositionsLink.label}
                                </a>
                            </li>
                            <li>
                                <a href={candidateResourcesHref} className={linkClass}>
                                    Candidate Resources
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div className="grid grid-cols-1 gap-8 border-t border-inverse-border py-8 sm:grid-cols-2 lg:grid-cols-4">
                    {offices.map((office) => (
                        <div key={office.name}>
                            <h2 className="mb-2 font-semibold text-inverse-foreground">
                                {office.name}
                            </h2>
                            <address className="not-italic">
                                {office.addressLines.map((line) => (
                                    <span key={line} className="block">
                                        {line}
                                    </span>
                                ))}
                            </address>
                        </div>
                    ))}
                    <div>
                        <h2 className="mb-2 font-semibold text-inverse-foreground">Talk to us</h2>
                        <ul className="space-y-1">
                            <li>
                                <a
                                    href={telHref(contact.phone)}
                                    className={`inline-block py-0.5 ${linkClass}`}
                                >
                                    {contact.phone}
                                </a>
                            </li>
                            <li>
                                <a
                                    href={`mailto:${contact.email}`}
                                    className={`inline-block py-0.5 ${linkClass}`}
                                >
                                    {contact.email}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 className="mb-2 font-semibold text-inverse-foreground">Follow</h2>
                        {sample ? (
                            <ul className="space-y-1">
                                {sample.socialLinks.map((link) => (
                                    <li key={link.href}>
                                        <a
                                            href={link.href}
                                            rel="noopener"
                                            className={`inline-block py-0.5 ${linkClass}`}
                                        >
                                            {link.label}
                                        </a>
                                    </li>
                                ))}
                            </ul>
                        ) : (
                            <p className="text-inverse-foreground">
                                <Placeholder>Social profiles, owner to supply</Placeholder>
                            </p>
                        )}
                    </div>
                </div>

                <div className="flex flex-wrap justify-between gap-4 border-t border-inverse-border pt-6 pb-8 text-caption">
                    <p>
                        &copy; {new Date().getFullYear()} {legalEntity} All rights reserved.
                    </p>
                    <ul className="flex flex-wrap gap-6">
                        {legalLinks.map((link) => (
                            <li key={link.href}>
                                <a href={link.href} className={linkClass}>
                                    {link.label}
                                </a>
                            </li>
                        ))}
                    </ul>
                </div>
            </div>
        </footer>
    );
}

function FooterColumn({ title, links }: { title: string; links: NavLink[] }) {
    const id = `footer-${title.toLowerCase()}`;

    return (
        <nav aria-labelledby={id}>
            <h2 id={id} className="mb-4 font-semibold text-inverse-foreground">
                {title}
            </h2>
            <ul className="space-y-2.5">
                {links.map((link) => (
                    <li key={link.label}>
                        <a href={link.href} className={linkClass}>
                            {link.label}
                        </a>
                    </li>
                ))}
            </ul>
        </nav>
    );
}
