import { ArrowRight } from "lucide-react";

import { ClosingBand } from "@/components/site/closing-band";
import { PageIntro } from "@/components/site/page-intro";
import { ProcessBand } from "@/components/site/process-band";
import { SectionHeading, sectionHeadingGap } from "@/components/site/section-heading";
import { SiteLayout } from "@/components/site/site-layout";
import { contactHref } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { PlaceholderBlock } from "@/features/services/copy-text";
import { FaqList, type Faq } from "@/features/services/faq-list";
import type { ServiceSummary } from "@/features/services/service";
import { typeRoles } from "@/lib/typography";

/** Props from ServiceController::indexAction. */
export interface ServicesOverviewProps {
    services: ServiceSummary[];
    /** Sample engagement models and pricing (App\Content\SampleContent); null unless sample content is on. */
    sample: { engagementModels: EngagementModel[]; pricing: string } | null;
}

/** One row of the engagement-model comparison. */
export interface EngagementModel {
    name: string;
    whoManages: string;
    duration: string;
    bestFor: string;
}

const container = "mx-auto max-w-(--container-max) px-(--gutter)";

/** The overview FAQ; the pricing answer awaits the owner unless sample content supplies one. */
const faqs = (pricing: string | undefined): Faq[] => [
    {
        question: "Which Service do I need?",
        answer: "Start from what you're trying to achieve: new software, keeping existing software healthy, release confidence, faster deployments or more people on your team. If you're not sure, Talk to an Expert and we'll point you to the right team.",
    },
    {
        question: "Can one firm cover build, testing, deployment and support?",
        answer: "Yes. All five are WeIntegral Services, so you can start with one and add others as the work grows.",
    },
    {
        question: "How is pricing structured?",
        answer: pricing ?? {
            placeholder: "Answer to be supplied by owner (pricing approach per engagement model)",
        },
    },
];

export default function ServicesOverview({ services, sample }: ServicesOverviewProps) {
    return (
        <SiteLayout>
            <PageIntro
                title="Services"
                lead="Five Services, one accountable team. Start with the Service you need today. Because we cover build, testing, deployment and support, one firm can carry your application from first release to day-to-day support."
            >
                <Button asChild variant="cta" size="brand-lg">
                    <a href={contactHref}>
                        Talk to an Expert
                        <ArrowRight className="size-4" aria-hidden="true" />
                    </a>
                </Button>
            </PageIntro>

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
                                        <h3
                                            className={`${typeRoles.title} transition-colors group-hover:text-emphasis`}
                                        >
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

            <ProcessBand heading="From first conversation to running software" />

            {sample ? (
                <section aria-labelledby="engagement-heading" className="py-(--section-space)">
                    <div className={container}>
                        <SectionHeading
                            id="engagement-heading"
                            intro="Start small and grow: each model suits a different kind of work."
                            className={sectionHeadingGap}
                        >
                            How engagements are structured
                        </SectionHeading>
                        <Table data-engagement-models="">
                            <TableHeader>
                                <TableRow>
                                    <TableHead scope="col">Model</TableHead>
                                    <TableHead scope="col">Who manages the work</TableHead>
                                    <TableHead scope="col">Typical duration</TableHead>
                                    <TableHead scope="col">Best for</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {sample.engagementModels.map((model) => (
                                    <TableRow key={model.name}>
                                        <TableHead scope="row" className="font-semibold">
                                            {model.name}
                                        </TableHead>
                                        <TableCell>{model.whoManages}</TableCell>
                                        <TableCell>{model.duration}</TableCell>
                                        <TableCell>{model.bestFor}</TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </div>
                </section>
            ) : (
                <div className="py-(--section-space)">
                    <div className={container}>
                        <PlaceholderBlock title="How engagements are structured">
                            Placeholder. A comparison of the engagement models WeIntegral offers
                            (for example project-based delivery, managed support, contract staffing,
                            contract-to-hire and direct hire): who manages the work, typical
                            duration and best fit. Awaiting owner confirmation of which models
                            apply.
                        </PlaceholderBlock>
                    </div>
                </div>
            )}

            <section aria-labelledby="faq-heading" className="bg-muted py-(--section-space)">
                <div className={container}>
                    <SectionHeading id="faq-heading" className={sectionHeadingGap}>
                        Questions Clients ask
                    </SectionHeading>
                    <FaqList faqs={faqs(sample?.pricing)} />
                </div>
            </section>

            <ClosingBand />
        </SiteLayout>
    );
}
