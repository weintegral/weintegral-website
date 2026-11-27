import { ArrowRight } from "lucide-react";

import { ClosingBand } from "@/components/about/closing-band";
import { PageIntro, SectionHeading } from "@/components/about/page-intro";
import { Placeholder } from "@/components/site/placeholder";
import { SiteLayout } from "@/components/site/site-layout";
import { careersHref } from "@/components/site/site-navigation";

/** One member of the leadership team, as supplied by the owner. */
export interface Leader {
    name: string;
    title: string;
    /** Two sentences at most. */
    bio: string;
    photoUrl: string;
    linkedInUrl: string | null;
}

/** Props from ManagementController::teamAction. */
export interface LeadershipPageProps {
    leaders: Leader[];
}

export default function Leadership({ leaders }: LeadershipPageProps) {
    return (
        <SiteLayout>
            <PageIntro
                trail={[
                    { label: "Home", href: "/" },
                    { label: "About", href: "/about" },
                ]}
                title="Leadership"
                lead="Meet the people who lead WeIntegral and answer for the work we deliver to every Client."
            />

            <section aria-labelledby="leaders-heading" className="py-(--section-space)">
                <div className="mx-auto max-w-(--container-max) px-(--gutter)">
                    <SectionHeading id="leaders-heading">Our leadership team</SectionHeading>
                    {leaders.length > 0 ? (
                        <ul className="grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                            {leaders.map((leader) => (
                                <LeaderCard key={leader.name} leader={leader} />
                            ))}
                        </ul>
                    ) : (
                        <div
                            data-leaders-placeholder=""
                            className="rounded-xl border-[1.5px] border-dashed border-emphasis bg-secondary p-8 text-muted-foreground"
                        >
                            <p className="font-semibold text-foreground">
                                <Placeholder>Leadership profiles, owner to supply</Placeholder>
                            </p>
                            <p className="mt-3 max-w-[60ch]">
                                For each leader: name, title, a photo, a two-sentence bio and a
                                LinkedIn profile. Profiles appear here as a grid once supplied.
                            </p>
                        </div>
                    )}
                </div>
            </section>

            <section aria-labelledby="join-heading" className="bg-muted py-(--section-space)">
                <div className="mx-auto grid max-w-(--container-max) items-end gap-8 px-(--gutter) lg:grid-cols-[minmax(0,1fr)_auto]">
                    <div>
                        <SectionHeading
                            id="join-heading"
                            intro="We look for people who keep learning and care about the businesses they serve."
                        >
                            Work with our team
                        </SectionHeading>
                    </div>
                    <a
                        href={careersHref}
                        className="mb-10 inline-flex items-center gap-1.5 font-semibold text-emphasis hover:underline lg:mb-14"
                    >
                        Explore careers at WeIntegral
                        <ArrowRight className="size-4" aria-hidden="true" />
                    </a>
                </div>
            </section>

            <ClosingBand />
        </SiteLayout>
    );
}

function LeaderCard({ leader }: { leader: Leader }) {
    return (
        <li>
            <img
                src={leader.photoUrl}
                alt=""
                width={480}
                height={600}
                loading="lazy"
                className="aspect-4/5 w-full rounded-xl bg-muted object-cover"
            />
            <h3 className="mt-5 text-(length:--text-h3) font-semibold">{leader.name}</h3>
            <p className="text-sm font-medium text-emphasis">{leader.title}</p>
            <p className="mt-3 text-muted-foreground">{leader.bio}</p>
            {leader.linkedInUrl ? (
                <a
                    href={leader.linkedInUrl}
                    className="mt-3 inline-block text-sm font-semibold hover:underline"
                >
                    LinkedIn<span className="sr-only"> profile of {leader.name}</span>
                </a>
            ) : null}
        </li>
    );
}
