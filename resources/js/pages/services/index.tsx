import { ArrowRight } from "lucide-react";

import { ClosingBand } from "@/components/site/closing-band";
import { PageBreadcrumbs } from "@/components/site/page-breadcrumbs";
import { SiteLayout } from "@/components/site/site-layout";
import { contactHref } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import { PlaceholderBlock } from "@/features/services/copy-text";
import { FaqList, type Faq } from "@/features/services/faq-list";
import type { ServiceSummary } from "@/features/services/service";

/** Props from ServiceController::indexAction. */
export interface ServicesOverviewProps {
    services: ServiceSummary[];
}

const container = "mx-auto max-w-(--container-max) px-(--gutter)";
const h2 = "text-(length:--text-h2) leading-tight font-semibold tracking-tight";

/** Discover, Build, Run: the engagement process confirmed by the owner. */
const stages = [
    {
        title: "Discover",
        description:
            "We learn your goals, systems and constraints, then agree on scope, team and timeline with you.",
    },
    {
        title: "Build",
        description:
            "We design, develop and test in short cycles, with working software you can review along the way.",
    },
    {
        title: "Run",
        description:
            "We deploy and support what we built, and adjust the team as your needs change.",
    },
];

const faqs: Faq[] = [
    {
        question: "Which Service do I need?",
        answer: "Start from what you're trying to achieve: new software, keeping existing software healthy, release confidence, faster deployments or more people on your team. If you're not sure, Talk to an Expert and we'll point you to the right team.",
    },
    {
        question: "Can one firm cover build, testing, deployment and support?",
        answer: "Yes. All five are WeIntegral Services, so you can start with one and add others as the work grows, without handing your application to another vendor.",
    },
    {
        question: "How is pricing structured?",
        answer: {
            placeholder: "Answer to be supplied by owner (pricing approach per engagement model)",
        },
    },
];

export default function ServicesOverview({ services }: ServicesOverviewProps) {
    return (
        <SiteLayout>
            <section
                aria-labelledby="services-heading"
                className="border-b border-border pt-[clamp(2.5rem,2rem+3vw,5rem)] pb-[clamp(3rem,2rem+4vw,5.5rem)]"
            >
                <div className={container}>
                    <PageBreadcrumbs trail={[]} current="Services" />
                    <h1
                        id="services-heading"
                        className="mt-8 text-(length:--text-h1) leading-[1.1] font-semibold tracking-tight"
                    >
                        Services
                    </h1>
                    <p className="mt-5 max-w-[56ch] text-(length:--text-lead) text-muted-foreground">
                        Five Services, one accountable team. Start with the Service you need today.
                        Because we cover build, testing, deployment and support, you never have to
                        hand your application to another vendor.
                    </p>
                    <Button asChild variant="cta" size="brand-lg" className="mt-8">
                        <a href={contactHref}>
                            Talk to an Expert
                            <ArrowRight className="size-4" aria-hidden="true" />
                        </a>
                    </Button>
                </div>
            </section>

            <section aria-labelledby="service-list-heading" className="py-(--section-space)">
                <div className={container}>
                    <h2 id="service-list-heading" className="sr-only">
                        Our Services
                    </h2>
                    <ul className="border-t border-border">
                        {services.map((service) => (
                            <li key={service.href}>
                                <a
                                    href={service.href}
                                    className="group grid items-start gap-x-8 gap-y-3 border-b border-border px-3 py-7 transition-colors duration-(--duration-base) ease-brand hover:bg-muted md:grid-cols-[minmax(0,1fr)_minmax(0,1.25fr)_2.75rem]"
                                >
                                    <div>
                                        <h3 className="text-(length:--text-h3) leading-snug font-[620] tracking-[-0.015em] transition-colors group-hover:text-emphasis">
                                            {service.name}
                                        </h3>
                                        <p className="mt-1 text-muted-foreground">
                                            {service.outcome}
                                        </p>
                                    </div>
                                    <ul className="space-y-1.5 text-sm">
                                        {service.highlights.map((highlight) => (
                                            <li
                                                key={highlight}
                                                className="relative pl-4 before:absolute before:top-2 before:left-0 before:size-1.5 before:rounded-full before:bg-brand-coral"
                                            >
                                                {highlight}
                                            </li>
                                        ))}
                                    </ul>
                                    <span
                                        aria-hidden="true"
                                        className="hidden size-11 place-items-center rounded-full border border-border transition-colors group-hover:border-cta group-hover:bg-cta group-hover:text-cta-foreground md:grid"
                                    >
                                        <ArrowRight className="size-5 transition-transform group-hover:translate-x-0.5" />
                                    </span>
                                </a>
                            </li>
                        ))}
                    </ul>
                </div>
            </section>

            <section
                aria-labelledby="process-heading"
                className="bg-inverse py-(--section-space) text-inverse-foreground"
            >
                <div className={container}>
                    <h2 id="process-heading" className={h2}>
                        From first conversation to running software
                    </h2>
                    <p className="mt-4 max-w-[52ch] text-inverse-muted">
                        Every engagement follows the same three stages, whether you need a full
                        product team or one specialist.
                    </p>
                    <ol className="mt-[clamp(2rem,1.5rem+2vw,3.5rem)] grid gap-8 md:grid-cols-3">
                        {stages.map((stage, index) => (
                            <li
                                key={stage.title}
                                className="border-t-[3px] border-brand-coral pt-6"
                            >
                                <span className="text-sm font-semibold text-inverse-muted">
                                    Stage {index + 1}
                                </span>
                                <h3 className="mt-1 text-(length:--text-h3) font-[620]">
                                    {stage.title}
                                </h3>
                                <p className="mt-2 text-inverse-muted">{stage.description}</p>
                            </li>
                        ))}
                    </ol>
                </div>
            </section>

            <div className="py-(--section-space)">
                <div className={container}>
                    <PlaceholderBlock title="How engagements are structured">
                        Placeholder. A comparison of the engagement models WeIntegral offers (for
                        example project-based delivery, managed support, contract staffing,
                        contract-to-hire and direct hire): who manages the work, typical duration
                        and best fit. Awaiting owner confirmation of which models apply.
                    </PlaceholderBlock>
                </div>
            </div>

            <section aria-labelledby="faq-heading" className="bg-muted py-(--section-space)">
                <div className={container}>
                    <h2 id="faq-heading" className={`${h2} mb-[clamp(2rem,1.5rem+2vw,3.5rem)]`}>
                        Questions Clients ask
                    </h2>
                    <FaqList faqs={faqs} />
                </div>
            </section>

            <ClosingBand />
        </SiteLayout>
    );
}
