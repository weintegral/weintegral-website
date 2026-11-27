import { ArrowUpRight } from "lucide-react";

import { SiteLayout } from "@/components/site/site-layout";
import { openPositionsLink } from "@/components/site/site-navigation";
import { CareersPageIntro, CareersSection } from "@/features/careers/careers-page-intro";

/** One link from App\Services\Resource::getResources(). */
export interface CandidateResource {
    title: string;
    brief: string;
    url: string;
}

/** Props from ResourceController::indexAction. */
export interface CandidateResourcesProps {
    candidateResources: CandidateResource[];
}

function hostOf(url: string): string {
    return new URL(url).hostname.replace(/^www\./, "");
}

export default function CandidateResources({ candidateResources }: CandidateResourcesProps) {
    return (
        <SiteLayout>
            <CareersPageIntro
                title="Candidate resources"
                lead="Working through a visa, H-1B or green card process? These official and third-party tools can help you check a case, research wages and plan appointments."
            />

            <CareersSection labelledBy="resources-heading">
                <h2 id="resources-heading" className="sr-only">
                    Links
                </h2>
                <ul
                    className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3"
                    data-candidate-resources=""
                >
                    {candidateResources.map((resource) => (
                        <li key={resource.url}>
                            <a
                                href={resource.url}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="group flex h-full flex-col rounded-lg border bg-background p-6 transition-shadow hover:border-input hover:shadow-md"
                            >
                                <span className="flex items-start justify-between gap-3 text-(length:--text-h4) font-semibold group-hover:underline">
                                    {resource.title}
                                    <ArrowUpRight
                                        className="mt-1 size-4 shrink-0 text-muted-foreground"
                                        aria-hidden="true"
                                    />
                                </span>
                                <span className="mt-2 text-sm text-pretty text-muted-foreground">
                                    {resource.brief}
                                </span>
                                <span className="mt-auto pt-4 text-xs text-muted-foreground">
                                    {hostOf(resource.url)}
                                    <span className="sr-only"> (opens in a new tab)</span>
                                </span>
                            </a>
                        </li>
                    ))}
                </ul>
                <p className="mt-10 max-w-3xl text-sm text-pretty text-muted-foreground">
                    These links lead to government and third-party websites. WeIntegral doesn't
                    control their content, and nothing here is legal advice. For questions about
                    your case, talk to an immigration attorney.
                </p>
            </CareersSection>

            <CareersSection labelledBy="roles-heading" muted>
                <h2 id="roles-heading" className="text-(length:--text-h3) font-semibold">
                    Looking for your next role?
                </h2>
                <p className="mt-2 text-muted-foreground">
                    <a href={openPositionsLink.href} className="underline">
                        Browse open positions
                    </a>{" "}
                    and search by role, technology or skill.
                </p>
            </CareersSection>
        </SiteLayout>
    );
}
