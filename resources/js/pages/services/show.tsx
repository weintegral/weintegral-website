import { ArrowRight } from "lucide-react";
import { useMemo } from "react";

import { ClosingBand } from "@/components/site/closing-band";
import { PageBreadcrumbs } from "@/components/site/page-breadcrumbs";
import { SiteLayout } from "@/components/site/site-layout";
import { contactHref, servicesHref } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import { CopyText, PlaceholderBlock } from "@/features/services/copy-text";
import { FaqList } from "@/features/services/faq-list";
import { ServiceAnchorNav } from "@/features/services/service-anchor-nav";
import { isPending, type Service } from "@/features/services/service";

/** Props from ServiceController::showAction. */
export interface ServicePageProps {
    service: Service;
}

const container = "mx-auto max-w-(--container-max) px-(--gutter)";
const section = "scroll-mt-16 py-(--section-space)";
const h2 = "text-(length:--text-h2) leading-tight font-semibold tracking-tight";
const h3 = "text-(length:--text-h3) leading-snug font-[620] tracking-[-0.015em]";

/** Sections listed in the in-page navigation, in page order. */
const anchors = [
    { id: "overview", label: "Overview" },
    { id: "what-you-get", label: "What you get" },
    { id: "how-we-deliver", label: "How we deliver" },
    { id: "engagement-options", label: "Engagement options" },
    { id: "technologies", label: "Technologies" },
    { id: "faq", label: "FAQ" },
];

/** One page for every Service (DESIGN.md comp B), driven by the Service's content. */
export default function ServicePage({ service }: ServicePageProps) {
    const technologiesHeading = service.technologies.heading;
    const pageAnchors = useMemo(
        () =>
            anchors.map((anchor) =>
                anchor.id === "technologies" ? { ...anchor, label: technologiesHeading } : anchor,
            ),
        [technologiesHeading],
    );

    return (
        <SiteLayout seo={service.seo}>
            <ServiceHero service={service} />
            <ServiceAnchorNav anchors={pageAnchors} />

            <section id="overview" aria-labelledby="overview-heading" className={section}>
                <div
                    className={`${container} grid gap-[clamp(2rem,1rem+4vw,5rem)] lg:grid-cols-[minmax(0,5fr)_minmax(0,7fr)]`}
                >
                    <h2 id="overview-heading" className={h2}>
                        {service.overview.heading}
                    </h2>
                    <div className="space-y-5">
                        {service.overview.paragraphs.map((paragraph, index) => (
                            <p
                                key={index}
                                className={`max-w-[60ch] text-(length:--text-lead) leading-relaxed ${index > 0 ? "text-muted-foreground" : ""}`}
                            >
                                <CopyText copy={paragraph} />
                            </p>
                        ))}
                    </div>
                </div>
            </section>

            <section
                id="what-you-get"
                aria-labelledby="what-you-get-heading"
                className={`${section} bg-muted`}
            >
                <div className={container}>
                    <h2
                        id="what-you-get-heading"
                        className={`${h2} mb-[clamp(2rem,1.5rem+2vw,3.5rem)]`}
                    >
                        What you get
                    </h2>
                    <div className="grid gap-10 md:grid-cols-3 md:gap-0">
                        {service.pillars.map((pillar) => (
                            <div
                                key={pillar.heading}
                                className="md:border-border md:pr-8 md:not-first:border-l md:not-first:pl-8"
                            >
                                <h3 className={`${h3} mb-5`}>{pillar.heading}</h3>
                                <ul>
                                    {pillar.capabilities.map((capability, index) => (
                                        <li
                                            key={index}
                                            className="relative border-t border-border py-3 pl-4 before:absolute before:top-[1.4rem] before:left-0 before:size-1.5 before:rounded-full before:bg-brand-coral"
                                        >
                                            <CopyText copy={capability} />
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            <section
                id="how-we-deliver"
                aria-labelledby="how-we-deliver-heading"
                className={section}
            >
                <div className={container}>
                    <div className="mb-[clamp(2rem,1.5rem+2vw,3.5rem)]">
                        <h2 id="how-we-deliver-heading" className={h2}>
                            How we deliver
                        </h2>
                        <p className="mt-4 max-w-[52ch] text-muted-foreground">
                            {service.delivery.intro}
                        </p>
                    </div>
                    <ol className="max-w-4xl">
                        {service.delivery.steps.map((step, index) => (
                            <li
                                key={step.title}
                                className="relative grid grid-cols-[3.5rem_1fr] gap-6 pb-9 last:pb-0 after:absolute after:top-12 after:bottom-1 after:left-[1.375rem] after:w-0.5 after:bg-border last:after:hidden"
                            >
                                <span
                                    aria-hidden="true"
                                    className="grid size-11 place-items-center rounded-full border-2 border-brand-coral font-[650] tabular-nums"
                                >
                                    {index + 1}
                                </span>
                                <div>
                                    <h3 className="mb-1.5 pt-2 text-(length:--text-h4) font-semibold">
                                        {step.title}
                                    </h3>
                                    <p className="max-w-[60ch] text-muted-foreground">
                                        {step.description}
                                    </p>
                                </div>
                            </li>
                        ))}
                    </ol>
                </div>
            </section>

            <div className={`${section} bg-muted`}>
                <div className={`${container} grid gap-6 md:grid-cols-2`}>
                    <PlaceholderBlock id="engagement-options" title="Engagement options">
                        {service.engagementOptions.placeholder}
                    </PlaceholderBlock>
                    <Technologies service={service} />
                    <PlaceholderBlock title="A case story" className="md:col-span-2">
                        {service.caseStory.placeholder}
                    </PlaceholderBlock>
                </div>
            </div>

            <section id="faq" aria-labelledby="faq-heading" className={section}>
                <div className={container}>
                    <h2 id="faq-heading" className={`${h2} mb-[clamp(2rem,1.5rem+2vw,3.5rem)]`}>
                        Questions Clients ask
                    </h2>
                    <FaqList faqs={service.faqs} />
                </div>
            </section>

            <section
                aria-labelledby="related-services-heading"
                className="bg-muted py-[clamp(3rem,2rem+3vw,5rem)]"
            >
                <div className={container}>
                    <h2 id="related-services-heading" className={`${h3} mb-6`}>
                        Related Services
                    </h2>
                    <ul className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        {service.relatedServices.map((related) => (
                            <li key={related.href}>
                                <a
                                    href={related.href}
                                    className="group flex h-full items-center justify-between gap-4 rounded-lg border border-border bg-card p-5 font-semibold transition-[border-color,box-shadow] duration-(--duration-base) ease-brand hover:border-input hover:shadow-token-md"
                                >
                                    {related.name}
                                    <ArrowRight
                                        className="size-5 shrink-0 text-emphasis transition-transform duration-(--duration-slow) ease-brand group-hover:translate-x-0.75"
                                        aria-hidden="true"
                                    />
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

function ServiceHero({ service }: ServicePageProps) {
    return (
        <section
            aria-labelledby="service-heading"
            className="border-b border-border pt-[clamp(2.5rem,2rem+3vw,5rem)] pb-[clamp(3rem,2rem+4vw,5.5rem)]"
        >
            <div className={container}>
                <PageBreadcrumbs
                    trail={[{ label: "Services", href: servicesHref }]}
                    current={service.name}
                />
                <div className="mt-8 grid items-start gap-[clamp(2rem,1rem+4vw,5rem)] lg:grid-cols-[minmax(0,1.35fr)_minmax(0,1fr)]">
                    <div>
                        <h1
                            id="service-heading"
                            className="max-w-[14ch] text-(length:--text-h1) leading-[1.1] font-semibold tracking-tight"
                        >
                            {service.name}
                        </h1>
                        <p className="mt-5 max-w-[50ch] text-(length:--text-lead) text-muted-foreground">
                            {service.summary}
                        </p>
                        <div className="mt-8 flex flex-wrap gap-3">
                            <Button asChild variant="cta" size="brand-lg">
                                <a href={contactHref}>
                                    Talk to an Expert
                                    <ArrowRight className="size-4" aria-hidden="true" />
                                </a>
                            </Button>
                            <Button asChild variant="outline" size="brand-lg">
                                <a href="#how-we-deliver">See how we deliver</a>
                            </Button>
                        </div>
                    </div>
                    <aside
                        aria-labelledby="at-a-glance-heading"
                        className="rounded-xl bg-muted p-7"
                    >
                        <h2
                            id="at-a-glance-heading"
                            className="mb-3 text-sm font-semibold text-muted-foreground"
                        >
                            At a glance
                        </h2>
                        <dl>
                            {service.atAGlance.map((item) => (
                                <div
                                    key={item.term}
                                    className="grid grid-cols-[7.5rem_1fr] gap-4 border-t border-border py-3.5 text-sm"
                                >
                                    <dt className="text-muted-foreground">{item.term}</dt>
                                    <dd className="font-medium">
                                        <CopyText copy={item.detail} />
                                    </dd>
                                </div>
                            ))}
                        </dl>
                    </aside>
                </div>
            </div>
        </section>
    );
}

function Technologies({ service }: ServicePageProps) {
    const { heading, items, note } = service.technologies;

    if (items.length === 0) {
        return (
            <PlaceholderBlock id="technologies" title={heading}>
                {isPending(note) ? note.placeholder : note}
            </PlaceholderBlock>
        );
    }

    return (
        <section
            id="technologies"
            aria-labelledby="technologies-heading"
            className="scroll-mt-20 rounded-lg border border-border bg-card px-6 py-5"
        >
            <h2 id="technologies-heading" className="mb-3 font-semibold">
                {heading}
            </h2>
            <ul className="flex flex-wrap gap-2">
                {items.map((item) => (
                    <li
                        key={item}
                        className="rounded-md bg-secondary px-2.5 py-1 text-sm font-medium text-secondary-foreground"
                    >
                        {item}
                    </li>
                ))}
            </ul>
            <p className="mt-4 text-sm">
                <CopyText copy={note} />
            </p>
        </section>
    );
}
