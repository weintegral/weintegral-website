import { ArrowRight } from "lucide-react";

import { Placeholder } from "@/components/site/placeholder";
import { PageIntro } from "@/components/site/page-intro";
import { SectionHeading } from "@/components/site/section-heading";
import { SiteLayout } from "@/components/site/site-layout";
import { careersLink, openPositionsLink } from "@/components/site/site-navigation";
import { Button } from "@/components/ui/button";
import { CareersSection, PillarList } from "@/features/careers/careers-section";

export default function Culture() {
    return (
        <SiteLayout>
            <PageIntro
                title="Culture"
                trail={[careersLink]}
                lead="People are our business. We build long-lasting relationships with our employees and consultants, and we give everyone room to learn, try new ideas and be heard."
            />

            <CareersSection labelledBy="values-heading">
                <SectionHeading id="values-heading">How we work</SectionHeading>
                <PillarList
                    pillars={[
                        {
                            title: "Keep learning",
                            body: "We invest in continuous learning and development, so you can sharpen your skills and stay current with the latest technologies and trends.",
                        },
                        {
                            title: "Experiment and adapt",
                            body: "We encourage new ideas and calculated risks. When challenges or opportunities change, we adapt quickly.",
                        },
                        {
                            title: "Everyone belongs",
                            body: "We're committed to a diverse, inclusive and respectful workplace that values the perspective and contribution of every person.",
                        },
                    ]}
                />
            </CareersSection>

            <CareersSection labelledBy="support-heading" muted>
                <div className="grid gap-10 lg:grid-cols-[5fr_7fr]">
                    <div>
                        <SectionHeading id="support-heading">
                            Support on every assignment
                        </SectionHeading>
                        <p className="mt-4 text-pretty text-muted-foreground">
                            We foster a creative, transparent and collaborative environment, whether
                            you work with our own team or on a Client assignment.
                        </p>
                    </div>
                    <dl className="divide-y border-y">
                        <SupportItem term="Your point of contact">
                            <Placeholder>
                                How consultants on assignment are supported (named contact, check-in
                                cadence), owner to confirm
                            </Placeholder>
                        </SupportItem>
                        <SupportItem term="Learning and certifications">
                            <Placeholder>
                                Training or certification support offered, owner to confirm
                            </Placeholder>
                        </SupportItem>
                        <SupportItem term="Where we work">
                            Our offices are in Lakeway, Texas and Ongole, Andhra Pradesh, India.
                        </SupportItem>
                    </dl>
                </div>
            </CareersSection>

            <CareersSection labelledBy="team-heading">
                <div className="grid items-center gap-10 lg:grid-cols-2">
                    <div
                        role="img"
                        aria-label="Team photo placeholder"
                        className="flex aspect-[4/3] items-center justify-center rounded-xl border border-dashed border-cta bg-muted p-8 text-center text-sm text-muted-foreground"
                    >
                        <Placeholder>
                            Team photo, WeIntegral's own or licensed stock with credit
                        </Placeholder>
                    </div>
                    <div>
                        <SectionHeading id="team-heading">Grow with us</SectionHeading>
                        <p className="mt-4 text-pretty text-muted-foreground">
                            We offer every employee and consultant opportunities to grow and further
                            their careers. See where you could start.
                        </p>
                        <Button asChild size="brand" className="mt-8">
                            <a href={openPositionsLink.href}>
                                Browse open positions
                                <ArrowRight aria-hidden="true" />
                            </a>
                        </Button>
                    </div>
                </div>
            </CareersSection>
        </SiteLayout>
    );
}

function SupportItem({ term, children }: { term: string; children: React.ReactNode }) {
    return (
        <div className="grid gap-2 py-5 sm:grid-cols-[14rem_1fr]">
            <dt className="font-semibold">{term}</dt>
            <dd className="text-muted-foreground">{children}</dd>
        </div>
    );
}
