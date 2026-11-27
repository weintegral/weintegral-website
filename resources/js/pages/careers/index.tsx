import { ArrowRight } from "lucide-react";

import { Placeholder } from "@/components/site/placeholder";
import { SiteLayout } from "@/components/site/site-layout";
import {
    candidateResourcesHref,
    careersLinks,
    openPositionsLink,
} from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import {
    CareersPageIntro,
    CareersSection,
    PillarList,
    SectionHeading,
} from "@/features/careers/careers-page-intro";

/** Props from CareerController::indexAction. */
export interface CareersIndexProps {
    openPositionCount: number;
    /** Where candidates send a résumé (ContactInfo::getHrEmailId). */
    careersEmail: string;
}

export default function CareersIndex({ openPositionCount, careersEmail }: CareersIndexProps) {
    const positions =
        openPositionCount === 1 ? "1 open position" : `${openPositionCount} open positions`;

    return (
        <SiteLayout
            seo={{
                title: "Careers",
                description:
                    "Build your IT career with WeIntegral. Browse open positions in development, testing and DevOps, and learn about our culture, benefits and candidate resources.",
            }}
        >
            <CareersPageIntro
                title="Careers"
                lead="Grow your career with WeIntegral. We offer our employees and consultants room to grow, real support and a voice in how we work."
            >
                <div className="mt-8 flex flex-wrap items-center gap-x-6 gap-y-4">
                    <Button asChild size="brand">
                        <a href={openPositionsLink.href}>
                            Browse open positions
                            <ArrowRight aria-hidden="true" />
                        </a>
                    </Button>
                    <span className="text-sm text-muted-foreground" data-open-position-count="">
                        {openPositionCount > 0
                            ? `${positions} right now`
                            : "No open positions right now"}
                    </span>
                </div>
            </CareersPageIntro>

            <CareersSection labelledBy="expect-heading">
                <SectionHeading id="expect-heading">What you can expect</SectionHeading>
                <PillarList
                    pillars={[
                        {
                            title: "People first",
                            body: "People are our business, and we invest in long-lasting relationships with every employee and consultant.",
                        },
                        {
                            title: "Room to grow",
                            body: "Continuous learning is part of the job, so you can build new skills and stay current with the latest technologies.",
                        },
                        {
                            title: "A voice in how we work",
                            body: "A transparent, collaborative workplace where ideas are welcome and everyone is heard.",
                        },
                    ]}
                />
            </CareersSection>

            <CareersSection labelledBy="explore-heading" muted>
                <SectionHeading id="explore-heading">Explore careers at WeIntegral</SectionHeading>
                <ul className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    {[
                        ...careersLinks.map((link) => ({
                            ...link,
                            blurb: careersLinkBlurbs[link.href] ?? "",
                        })),
                        {
                            label: "Candidate Resources",
                            href: candidateResourcesHref,
                            blurb: "Visa, H-1B and immigration tools we point candidates to.",
                        },
                    ].map((link) => (
                        <li key={link.href}>
                            <a
                                href={link.href}
                                className="group flex h-full flex-col rounded-lg border bg-background p-6 transition-shadow hover:border-input hover:shadow-md"
                            >
                                <span className="text-(length:--text-h4) font-semibold group-hover:underline">
                                    {link.label}
                                </span>
                                <span className="mt-2 text-sm text-muted-foreground">
                                    {link.blurb}
                                </span>
                                <ArrowRight
                                    className="mt-auto size-5 pt-4 transition-transform group-hover:translate-x-0.75"
                                    aria-hidden="true"
                                />
                            </a>
                        </li>
                    ))}
                </ul>
            </CareersSection>

            <CareersSection labelledBy="apply-heading">
                <div className="grid gap-10 lg:grid-cols-[5fr_7fr]">
                    <div>
                        <SectionHeading id="apply-heading">How to apply</SectionHeading>
                        <p className="mt-4 text-pretty text-muted-foreground">
                            Don't see a fit yet? Send us your résumé anyway and tell us the kind of
                            work you're looking for.
                        </p>
                    </div>
                    <ol className="space-y-6">
                        <HowToApplyStep number={1} title="Find a role">
                            Browse{" "}
                            <a href={openPositionsLink.href} className="underline">
                                open positions
                            </a>{" "}
                            and search by role or technology.
                        </HowToApplyStep>
                        <HowToApplyStep number={2} title="Send your résumé">
                            Email{" "}
                            <a href={`mailto:${careersEmail}`} className="underline">
                                {careersEmail}
                            </a>{" "}
                            with the role you're applying for.
                        </HowToApplyStep>
                        <HowToApplyStep number={3} title="Talk with our team">
                            If your experience fits, we'll be in touch to talk it through.{" "}
                            <Placeholder>
                                Hiring steps and response time, owner to confirm
                            </Placeholder>
                        </HowToApplyStep>
                    </ol>
                </div>
            </CareersSection>
        </SiteLayout>
    );
}

const careersLinkBlurbs: Record<string, string> = {
    "/career/openings": "Search current roles by title or technology.",
    "/career/work-culture": "How we work, learn and support each other.",
    "/career/benefits": "What we offer employees and consultants.",
};

function HowToApplyStep({
    number,
    title,
    children,
}: {
    number: number;
    title: string;
    children: React.ReactNode;
}) {
    return (
        <li className="grid grid-cols-[2.75rem_1fr] gap-4">
            <span
                aria-hidden="true"
                className="flex size-11 items-center justify-center rounded-full border-2 border-cta font-semibold tabular-nums"
            >
                {number}
            </span>
            <div>
                <h3 className="text-(length:--text-h4) font-semibold">{title}</h3>
                <p className="mt-1 text-muted-foreground">{children}</p>
            </div>
        </li>
    );
}
