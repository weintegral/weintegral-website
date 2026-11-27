import { ArrowRight } from "lucide-react";

import { ClosingBand } from "@/components/about/closing-band";
import { PageIntro, SectionHeading } from "@/components/about/page-intro";
import { Placeholder } from "@/components/site/placeholder";
import { SiteLayout } from "@/components/site/site-layout";
import { contactHref, services } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";

/** An Industry WeIntegral serves. */
export interface Industry {
    name: string;
    /** One line on WeIntegral's work in this Industry; null until the owner supplies it. */
    summary: string | null;
}

/** Props from AboutController::industriesAction. */
export interface IndustriesPageProps {
    industries: Industry[];
}

export default function Industries({ industries }: IndustriesPageProps) {
    return (
        <SiteLayout
            seo={{
                title: "Industries",
                description:
                    "The industries WeIntegral serves with application development, support, testing, DevOps and IT staffing, and how sector knowledge speeds up every project.",
            }}
        >
            <PageIntro
                trail={[{ label: "Home", href: "/" }]}
                title="Industries"
                lead="Knowing a sector's rules, systems and customers shortens every project. These are the industries our teams work in."
            >
                <Button asChild variant="cta" size="brand-lg">
                    <a href={contactHref}>
                        Talk to an Expert
                        <ArrowRight aria-hidden="true" />
                    </a>
                </Button>
            </PageIntro>

            <section aria-labelledby="industries-heading" className="py-(--section-space)">
                <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                    <SectionHeading id="industries-heading">Industries we serve</SectionHeading>
                    <ul className="grid border-t border-foreground md:grid-cols-3">
                        {industries.map((industry) => (
                            <li
                                key={industry.name}
                                className="flex flex-col gap-3 border-b border-border py-7 md:border-r md:border-b-0 md:px-6 md:first:pl-0 md:last:border-r-0"
                            >
                                <h3 className="text-(length:--text-h2) leading-tight font-semibold tracking-tight">
                                    {industry.name}
                                </h3>
                                <p className="text-sm text-muted-foreground">
                                    {industry.summary ?? (
                                        <Placeholder>
                                            One line on our {industry.name.toLowerCase()} work, to
                                            confirm
                                        </Placeholder>
                                    )}
                                </p>
                            </li>
                        ))}
                    </ul>
                    <p className="mt-6 text-sm">
                        <Placeholder>
                            Industry list carried over from the previous Industries page, to confirm
                            or extend
                        </Placeholder>
                    </p>
                </div>
            </section>

            <section aria-labelledby="services-heading" className="bg-muted py-(--section-space)">
                <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                    <SectionHeading
                        id="services-heading"
                        intro="Whatever your sector, the same five Services carry your application from first build to steady operation."
                    >
                        What we bring to every industry
                    </SectionHeading>
                    <ul className="border-t border-border">
                        {services.map((service) => (
                            <li key={service.href}>
                                <a
                                    href={service.href}
                                    className="group grid items-center gap-2 border-b border-border px-1 py-6 transition-colors hover:bg-background md:grid-cols-[minmax(0,1fr)_minmax(0,1.25fr)_2.75rem] md:gap-8 md:px-3"
                                >
                                    <span className="text-(length:--text-h3) font-semibold group-hover:text-emphasis">
                                        {service.label}
                                    </span>
                                    <span className="text-muted-foreground">{service.outcome}</span>
                                    <span
                                        aria-hidden="true"
                                        className="hidden size-11 place-items-center rounded-full border border-border transition-colors group-hover:border-cta group-hover:bg-cta group-hover:text-cta-foreground md:grid"
                                    >
                                        <ArrowRight className="size-4" />
                                    </span>
                                </a>
                            </li>
                        ))}
                    </ul>
                </div>
            </section>

            <ClosingBand />
        </SiteLayout>
    );
}
