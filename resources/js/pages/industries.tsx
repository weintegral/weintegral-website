import { usePage } from "@inertiajs/react";
import { ArrowRight } from "lucide-react";

import { ClosingBand } from "@/components/site/closing-band";
import { PageIntro } from "@/components/site/page-intro";
import { SectionHeading, sectionHeadingGap } from "@/components/site/section-heading";
import { Placeholder } from "@/components/site/placeholder";
import { SiteLayout } from "@/components/site/site-layout";
import { contactHref } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import { typeRoles } from "@/lib/typography";

/** The Industries page lists the shared `site.industries` (App\Content\IndustryCatalog). */
export default function Industries() {
    const { industries, services, sample } = usePage().props.site;

    return (
        <SiteLayout>
            <PageIntro
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
                    <SectionHeading accent className={sectionHeadingGap} id="industries-heading">
                        Industries we serve
                    </SectionHeading>
                    <ul className="grid border-t border-foreground md:grid-cols-3">
                        {industries.map((industry) => (
                            <li
                                key={industry.name}
                                className="flex flex-col gap-3 border-b border-border py-7 md:border-r md:border-b-0 md:px-6 md:first:pl-0 md:last:border-r-0"
                            >
                                <h3 className={typeRoles.section}>{industry.name}</h3>
                                <p className="text-sm text-muted-foreground">{industry.summary}</p>
                            </li>
                        ))}
                    </ul>
                    {!sample && (
                        <p className="mt-6 text-sm">
                            <Placeholder>
                                Industry list carried over from the previous Industries page, to
                                confirm or extend
                            </Placeholder>
                        </p>
                    )}
                </div>
            </section>

            <section aria-labelledby="services-heading" className="bg-muted py-(--section-space)">
                <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                    <SectionHeading
                        accent
                        className={sectionHeadingGap}
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
                                    <span
                                        className={`${typeRoles.title} group-hover:text-emphasis`}
                                    >
                                        {service.name}
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
