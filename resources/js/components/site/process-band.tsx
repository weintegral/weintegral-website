import { typeRoles } from "@/lib/typography";

import { SectionHeading, sectionHeadingGap } from "./section-heading";

/** The engagement stages, in order. The names are owner-confirmed (spec #54). */
export const engagementStages = ["Discover", "Build", "Run"] as const;

export type EngagementStage = (typeof engagementStages)[number];

const stageSummaries: Record<EngagementStage, string> = {
    Discover:
        "We learn your goals, systems and constraints, then agree on scope, team and timeline with you.",
    Build: "We design, develop and test the software your business needs.",
    Run: "We deploy what we built and keep it running with maintenance and support.",
};

/**
 * The navy Discover, Build, Run band (DESIGN.md, The Integral Line): the three stages
 * every engagement follows, on a line that runs horizontally, or vertically on mobile.
 */
export function ProcessBand({ heading }: { heading: string }) {
    return (
        <section
            aria-labelledby="process-heading"
            className="bg-inverse py-(--section-space) text-inverse-foreground"
        >
            <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                <SectionHeading
                    id="process-heading"
                    inverse
                    intro="Every engagement follows the same three stages, whether you need a full product team or one specialist."
                    className={sectionHeadingGap}
                >
                    {heading}
                </SectionHeading>
                <ol className="relative grid gap-9 pl-11 before:absolute before:top-2.5 before:bottom-0 before:left-[0.55rem] before:w-0.5 before:bg-linear-to-b before:from-cta before:from-75% before:to-transparent min-[52rem]:grid-cols-3 min-[52rem]:gap-10 min-[52rem]:pt-11 min-[52rem]:pl-0 min-[52rem]:before:top-2.5 min-[52rem]:before:right-0 min-[52rem]:before:bottom-auto min-[52rem]:before:left-2.5 min-[52rem]:before:h-0.5 min-[52rem]:before:w-auto min-[52rem]:before:bg-linear-to-r min-[52rem]:before:from-70%">
                    {engagementStages.map((stage) => (
                        <li
                            key={stage}
                            className="relative before:absolute before:top-0 before:-left-11 before:size-5 before:rounded-full before:border-3 before:border-cta before:bg-inverse min-[52rem]:before:-top-11 min-[52rem]:before:left-0"
                        >
                            <h3 className={`${typeRoles.title} mb-2.5`}>{stage}</h3>
                            <p className="max-w-[34ch] text-inverse-muted">
                                {stageSummaries[stage]}
                            </p>
                        </li>
                    ))}
                </ol>
            </div>
        </section>
    );
}
